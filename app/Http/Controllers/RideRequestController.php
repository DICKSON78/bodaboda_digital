<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\Rider;
use App\Models\User;
use App\Services\MqttService;
use App\Services\GeoService;
use App\Services\RedisLock;
use App\Events\RideRequested;
use App\Events\RideAccepted;
use App\Events\DriverLocationUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RideRequestController extends Controller
{
    protected MqttService $mqtt;
    protected GeoService $geo;

    public function __construct(MqttService $mqtt, GeoService $geo)
    {
        $this->mqtt = $mqtt;
        $this->geo = $geo;
    }

    // Calculate distance using Haversine formula (kept for fallback)
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $R = 6371;
        $dLat = ($lat2 - $lat1) * M_PI / 180;
        $dLng = ($lng2 - $lng1) * M_PI / 180;
        $a = sin($dLat/2) * sin($dLat/2) +
              cos($lat1 * M_PI / 180) * cos($lat2 * M_PI / 180) *
              sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }

    // Find nearby drivers using Redis GEORADIUS (O(log n))
    private function findNearbyDrivers($pickupLat, $pickupLng, $radiusKm = 5)
    {
        $riders = $this->geo->findNearby($pickupLat, $pickupLng, $radiusKm, 20);

        return collect($riders)->values();
    }

    // Get all pending ride requests for driver dashboard
    public function pendingRequests(Request $request)
    {
        try {
            $rides = Ride::where('status', 'requested')
                ->with('passenger')
                ->latest()
                ->get()
                ->map(function($ride) {
                    return [
                        'id' => $ride->id,
                        'user' => [
                            'name' => $ride->passenger?->name ?? 'Unknown',
                            'phone' => $ride->passenger?->phone_number ?? '',
                            'avatar' => $ride->passenger?->avatar ?? '',
                        ],
                        'pickup_address' => $ride->pickup_address,
                        'dest_address' => $ride->destination_address,
                        'fare' => (float) $ride->fare,
                        'distance' => (float) $ride->distance,
                        'created_at' => $ride->created_at->diffForHumans(),
                    ];
                });

            return response()->json([
                'success' => true,
                'requests' => $rides,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch pending requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'requests' => [],
                'message' => 'Failed to fetch ride requests.'
            ], 500);
        }
    }

    // Request a ride
    public function requestRide(Request $request)
    {
        try {
            $validated = $request->validate([
                'pickup_lat' => 'required|numeric',
                'pickup_lng' => 'required|numeric',
                'dest_lat' => 'required|numeric',
                'dest_lng' => 'required|numeric',
                'pickup_address' => 'required|string',
                'destination_address' => 'required|string',
                'fare' => 'required|numeric|min:0',
                'distance' => 'required|numeric|min:0',
                'user_id' => 'required|exists:users,id'
            ]);

            // Create ride with REQUESTED status
            $ride = Ride::create([
                'passenger_id' => $validated['user_id'],
                'pickup_lat' => $validated['pickup_lat'],
                'pickup_lng' => $validated['pickup_lng'],
                'dest_lat' => $validated['dest_lat'],
                'dest_lng' => $validated['dest_lng'],
                'pickup_address' => $validated['pickup_address'],
                'destination_address' => $validated['destination_address'],
                'fare' => $validated['fare'],
                'distance' => $validated['distance'],
                'status' => 'requested'
            ]);

            // Find nearby drivers
            $nearbyDrivers = $this->findNearbyDrivers(
                $validated['pickup_lat'], 
                $validated['pickup_lng']
            );

            Log::info("Ride {$ride->id} requested, found {$nearbyDrivers->count()} nearby drivers");

            $passenger = User::find($validated['user_id']);

            // Publish ride request to MQTT topic for nearby drivers
            $this->mqtt->publish(config('mqtt.topics.ride_request'), [
                'ride_id' => $ride->id,
                'passenger' => [
                    'id' => (int) $validated['user_id'],
                    'name' => $passenger?->name ?? 'Unknown',
                    'phone' => $passenger?->phone_number ?? '',
                    'avatar' => $passenger?->avatar ?? '',
                ],
                'pickup' => [
                    'lat' => (float) $validated['pickup_lat'],
                    'lng' => (float) $validated['pickup_lng'],
                    'address' => $validated['pickup_address'],
                ],
                'destination' => [
                    'lat' => (float) $validated['dest_lat'],
                    'lng' => (float) $validated['dest_lng'],
                    'address' => $validated['destination_address'],
                ],
                'fare' => (float) $validated['fare'],
                'distance' => (float) $validated['distance'],
                'nearby_drivers_count' => $nearbyDrivers->count(),
                'timestamp' => now()->toIso8601String(),
            ]);

            // Dispatch Laravel event for WebSocket/Pusher broadcasting
            RideRequested::dispatch(
                $ride,
                ['id' => $passenger?->id, 'name' => $passenger?->name],
                ['lat' => (float) $validated['pickup_lat'], 'lng' => (float) $validated['pickup_lng']],
                ['lat' => (float) $validated['dest_lat'], 'lng' => (float) $validated['dest_lng']],
                (float) $validated['fare'],
                (float) $validated['distance']
            );

            if ($nearbyDrivers->isNotEmpty()) {
                $driverData = $nearbyDrivers->map(function($rider) use ($validated) {
                    $distance = $this->calculateDistance(
                        $validated['pickup_lat'], $validated['pickup_lng'],
                        $rider->current_lat, $rider->current_lng
                    );
                    
                    return [
                        'id' => $rider->id,
                        'name' => $rider->user->name,
                        'phone' => $rider->user->phone_number,
                        'avatar' => $rider->user->avatar,
                        'bike_plate' => $rider->bike_plate,
                        'current_lat' => $rider->current_lat,
                        'current_lng' => $rider->current_lng,
                        'distance_km' => round($distance, 2),
                        'eta_minutes' => max(1, round($distance * 3)) // Rough ETA: 3 minutes per km
                    ];
                });

                return response()->json([
                    'success' => true,
                    'ride' => $ride,
                    'nearby_drivers' => $driverData,
                    'message' => 'Ride requested successfully. Waiting for driver acceptance.'
                ]);
            }

            return response()->json([
                'success' => true,
                'ride' => $ride,
                'nearby_drivers' => [],
                'message' => 'Ride requested. No drivers available nearby at the moment.'
            ]);

        } catch (\Exception $e) {
            Log::error('Ride request failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to request ride: ' . $e->getMessage()
            ], 500);
        }
    }

    // Accept a ride
    public function acceptRide(Request $request, Ride $ride)
    {
        try {
            $validated = $request->validate([
                'rider_id' => 'required|exists:riders,id'
            ]);

            $rider = Rider::findOrFail($validated['rider_id']);
            if ($rider->status !== 'online') {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be online to accept rides.'
                ], 400);
            }

            RedisLock::withLock('ride:accept:' . $ride->id, function() use ($ride, $rider) {
                DB::transaction(function() use ($ride, $rider) {
                    $fresh = Ride::where('id', $ride->id)
                        ->where('status', 'requested')
                        ->lockForUpdate()
                        ->first();

                    if (!$fresh) {
                        throw new \RuntimeException('This ride is no longer available.');
                    }

                    $fresh->update([
                        'rider_id' => $rider->id,
                        'status' => 'accepted',
                        'accepted_at' => now()
                    ]);
                });
            });

            $ride->refresh();

            Log::info("Ride {$ride->id} accepted by rider {$rider->id}");

            $this->mqtt->publish(
                $this->mqtt->rideStatusTopic($ride),
                [
                    'ride_id' => $ride->id,
                    'status' => 'accepted',
                    'driver' => [
                        'id' => $rider->id,
                        'name' => $rider->user->name ?? null,
                        'phone' => $rider->user->phone_number ?? null,
                        'avatar' => $rider->user->avatar ?? null,
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

            // Dispatch Laravel event for WebSocket/Pusher broadcasting
            RideAccepted::dispatch(
                $ride,
                [
                    'id' => $rider->id,
                    'name' => $rider->user->name ?? null,
                    'phone' => $rider->user->phone_number ?? null,
                    'bike_plate' => $rider->bike_plate,
                ]
            );

            return response()->json([
                'success' => true,
                'ride' => $ride->fresh(['rider.user']),
                'message' => 'Ride accepted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Ride acceptance failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to accept ride: ' . $e->getMessage()
            ], 500);
        }
    }

    // Decline a ride
    public function declineRide(Request $request, Ride $ride)
    {
        try {
            $validated = $request->validate([
                'rider_id' => 'required|exists:riders,id'
            ]);

            // Just log the decline for now
            Log::info("Ride {$ride->id} declined by rider {$validated['rider_id']}");

            return response()->json([
                'success' => true,
                'message' => 'Ride declined.'
            ]);

        } catch (\Exception $e) {
            Log::error('Ride decline failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to decline ride: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update ride status
    public function updateStatus(Request $request, Ride $ride)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:driver_arriving,driver_arrived,ongoing,completed,cancelled',
                'rider_id' => 'required|exists:riders,id'
            ]);

            // Verify this rider is assigned to this ride
            if ($ride->rider_id !== (int) $validated['rider_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not assigned to this ride.'
                ], 403);
            }

            // Update status and timestamp
            $updateData = ['status' => $validated['status']];
            
            switch ($validated['status']) {
                case 'driver_arriving':
                    // Still accepted, driver en route
                    $updateData['status'] = 'accepted';
                    break;
                case 'driver_arrived':
                    $updateData['driver_arrived_at'] = now();
                    break;
                case 'ongoing':
                    $updateData['trip_started_at'] = now();
                    break;
                case 'completed':
                    $updateData['trip_completed_at'] = now();
                    break;
                case 'cancelled':
                    // No additional timestamp needed
                    break;
            }

            $ride->update($updateData);

            Log::info("Ride {$ride->id} status updated to {$validated['status']}");

            // Publish ride status update to MQTT
            $this->mqtt->publish(
                $this->mqtt->rideStatusTopic($ride),
                [
                    'ride_id' => $ride->id,
                    'ride_token' => $ride->ride_token,
                    'status' => $validated['status'],
                    'driver' => [
                        'id' => (int) $validated['rider_id'],
                    ],
                ]
            );

            return response()->json([
                'success' => true,
                'ride' => $ride->fresh(),
                'message' => 'Ride status updated successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Ride status update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ride status: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update driver location
    public function updateDriverLocation(Request $request)
    {
        try {
            $validated = $request->validate([
                'rider_id' => 'required|exists:riders,id',
                'lat' => 'required|numeric',
                'lng' => 'required|numeric'
            ]);

            $rider = Rider::findOrFail($validated['rider_id']);
            $rider->update([
                'current_lat' => $validated['lat'],
                'current_lng' => $validated['lng']
            ]);

            // Publish driver location to MQTT (raw topic, no ride token)
            $this->mqtt->publish(
                $this->mqtt->driverLocationRawTopic($rider->id),
                [
                    'rider_id' => $rider->id,
                    'lat' => (float) $validated['lat'],
                    'lng' => (float) $validated['lng'],
                ]
            );

            // Dispatch Laravel event for WebSocket/Pusher broadcasting
            DriverLocationUpdated::dispatch(
                (int) $rider->id,
                (float) $validated['lat'],
                (float) $validated['lng']
            );

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Driver location update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location: ' . $e->getMessage()
            ], 500);
        }
    }
}
