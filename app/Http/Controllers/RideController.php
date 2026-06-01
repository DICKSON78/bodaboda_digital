<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Rider;
use App\Services\FareService;
use App\Services\MqttService;
use App\Services\RedisLock;
use App\Events\RideRequested;
use App\Events\RideAccepted;
use App\Events\DriverLocationUpdated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RideController extends Controller
{
    protected $fareService;
    protected MqttService $mqtt;

    public function __construct(FareService $fareService, MqttService $mqtt)
    {
        $this->fareService = $fareService;
        $this->mqtt = $mqtt;
    }

    public function create()
    {
        return view('rides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_lat' => 'required|numeric',
            'pickup_lng' => 'required|numeric',
            'dest_lat' => 'required|numeric',
            'dest_lng' => 'required|numeric',
            'distance' => 'required|numeric',
        ]);

        $fare = $this->fareService->calculate($request->distance, $request->pickup_lat, $request->pickup_lng);

        $ride = Ride::create([
            'passenger_id' => Auth::check() ? Auth::id() : null,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lng' => $request->pickup_lng,
            'dest_lat' => $request->dest_lat,
            'dest_lng' => $request->dest_lng,
            'fare' => $fare,
            'status' => 'requested',
            'ride_token' => \Illuminate\Support\Str::uuid(),
        ]);

        $mqttPayload = [
            'ride_id' => $ride->id,
            'passenger_id' => Auth::id(),
            'pickup' => [
                'lat' => (float) $request->pickup_lat,
                'lng' => (float) $request->pickup_lng,
            ],
            'destination' => [
                'lat' => (float) $request->dest_lat,
                'lng' => (float) $request->dest_lng,
            ],
            'fare' => (float) $fare,
            'distance' => (float) $request->distance,
        ];

        $this->mqtt->publish(config('mqtt.topics.ride_request'), $mqttPayload);

        // Dispatch Laravel event for WebSocket/Pusher broadcasting
        RideRequested::dispatch(
            $ride,
            ['id' => Auth::id(), 'name' => Auth::user()?->name],
            ['lat' => (float) $request->pickup_lat, 'lng' => (float) $request->pickup_lng],
            ['lat' => (float) $request->dest_lat, 'lng' => (float) $request->dest_lng],
            (float) $fare,
            (float) $request->distance
        );

        return $request->expectsJson()
            ? response()->json([
                'success' => true,
                'ride' => $ride,
                'mqtt' => ['topic' => 'ride/request', 'payload' => $mqttPayload],
                'message' => 'Ride requested! Looking for riders...'
            ])
            : redirect()->route('rides.show', $ride)->with('success', 'Ride requested! Looking for riders...');
    }

    public function calculateFare(Request $request)
    {
        $request->validate([
            'distance' => 'required|numeric',
            'pickup_lat' => 'nullable|numeric',
            'pickup_lng' => 'nullable|numeric',
        ]);
        $fare = $this->fareService->calculate($request->distance, $request->pickup_lat, $request->pickup_lng);
        $surge = $this->fareService->getCurrentSurge();
        return response()->json([
            'fare' => $fare,
            'formatted_fare' => number_format($fare),
            'surge' => $surge,
        ]);
    }

    public function show(Ride $ride)
    {
        return view('rides.show', compact('ride'));
    }

    public function accept(Ride $ride)
    {
        $rider = Auth::user()->rider;
        
        if (!$rider || !$rider->is_approved) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved riders can accept rides.'
            ], 403);
        }

        try {
            RedisLock::withLock('ride:accept:' . $ride->id, function() use ($ride, $rider) {
                $updated = DB::transaction(function() use ($ride, $rider) {
                    $fresh = Ride::where('id', $ride->id)
                        ->where('status', 'requested')
                        ->lockForUpdate()
                        ->first();

                    if (!$fresh) {
                        return false;
                    }

                    $fresh->update([
                        'rider_id' => $rider->id,
                        'status' => 'accepted',
                        'accepted_at' => now(),
                    ]);

                    return true;
                });

                if (!$updated) {
                    throw new \RuntimeException('Ride is no longer available.');
                }
            });
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to accept ride. Please try again.'
            ], 500);
        }

        $ride->refresh();

        $this->mqtt->publish(
            $this->mqtt->rideStatusTopic($ride),
            [
                'ride_id' => $ride->id,
                'ride_token' => $ride->ride_token,
                'status' => 'accepted',
                'driver' => [
                    'id' => $rider->id,
                    'name' => Auth::user()->name,
                    'phone' => Auth::user()->phone_number,
                    'avatar' => Auth::user()->avatar,
                    'bike_plate' => $rider->bike_plate,
                    'license_number' => $rider->license_number,
                    'first_name' => $rider->first_name,
                    'last_name' => $rider->last_name,
                ],
                'pickup' => [
                    'lat' => (float) $ride->pickup_lat,
                    'lng' => (float) $ride->pickup_lng,
                    'address' => $ride->pickup_address,
                ],
                'destination' => [
                    'lat' => (float) $ride->dest_lat,
                    'lng' => (float) $ride->dest_lng,
                    'address' => $ride->destination_address,
                ],
                'fare' => (float) $ride->fare,
                'distance' => (float) $ride->distance,
            ]
        );

        return response()->json([
            'success' => true,
            'ride' => $ride->fresh(['rider.user']),
            'message' => 'Ride accepted!'
        ]);
    }

    public function decline(Ride $ride)
    {
        $rider = Auth::user()->rider;

        if (!$rider) {
            return response()->json([
                'success' => false,
                'message' => 'Only riders can decline rides.'
            ], 403);
        }

        if ($ride->status !== 'requested') {
            return response()->json([
                'success' => false,
                'message' => 'This ride is no longer available.'
            ], 400);
        }

        Log::info("Ride {$ride->id} declined by rider {$rider->id}");

        return response()->json([
            'success' => true,
            'message' => 'Ride declined.'
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ride::query();

        if ($user->role === 'passenger') {
            $query->where('passenger_id', $user->id);
        } elseif ($user->role === 'rider' && $user->rider) {
            $query->where('rider_id', $user->rider->id);
        }

        $rides = $query->latest()->paginate(15);

        return view('rides.index', compact('rides'));
    }

    public function start(Ride $ride)
    {
        if ($ride->status !== 'accepted') {
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Ride must be accepted to start.'], 422)
                : back()->with('error', 'Ride must be accepted to start.');
        }

        $ride->update(['status' => 'ongoing']);

        $topic = $this->mqtt->rideStatusTopic($ride);
        $payload = [
            'ride_id' => $ride->id,
            'ride_token' => $ride->ride_token,
            'status' => 'ongoing',
        ];

        $this->mqtt->publish($topic, $payload);

        return request()->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Ride started!', 'mqtt' => ['topic' => $topic, 'payload' => $payload]])
            : back()->with('success', 'Ride started! Have a safe trip.');
    }

    public function complete(Ride $ride)
    {
        if ($ride->status !== 'ongoing') {
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Ride must be ongoing to complete.'], 422)
                : back()->with('error', 'Ride must be ongoing to complete.');
        }

        $ride->update(['status' => 'completed']);

        $topic = $this->mqtt->rideStatusTopic($ride);
        $payload = [
            'ride_id' => $ride->id,
            'ride_token' => $ride->ride_token,
            'status' => 'completed',
            'fare' => (float) $ride->fare,
            'distance' => (float) $ride->distance,
        ];

        $this->mqtt->publish($topic, $payload);

        return request()->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Ride completed!', 'mqtt' => ['topic' => $topic, 'payload' => $payload]])
            : redirect()->route('rides.show', $ride)->with('success', 'Ride completed! Please rate your experience.');
    }

    public function cancel(Ride $ride)
    {
        if (!in_array($ride->status, ['requested', 'accepted'])) {
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Cannot cancel this ride anymore.'], 422)
                : back()->with('error', 'Cannot cancel this ride anymore.');
        }

        $ride->update(['status' => 'cancelled']);

        $topic = $this->mqtt->rideStatusTopic($ride);
        $payload = [
            'ride_id' => $ride->id,
            'ride_token' => $ride->ride_token,
            'status' => 'cancelled',
        ];

        $this->mqtt->publish($topic, $payload);

        return request()->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Ride cancelled.', 'mqtt' => ['topic' => $topic, 'payload' => $payload]])
            : redirect()->route('dashboard')->with('success', 'Ride cancelled.');
    }
}
