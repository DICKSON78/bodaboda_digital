<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Rider;
use App\Services\FareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    protected $fareService;

    public function __construct(FareService $fareService)
    {
        $this->fareService = $fareService;
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

        $fare = $this->fareService->calculate($request->distance);

        $ride = Ride::create([
            'passenger_id' => Auth::check() ? Auth::id() : null,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lng' => $request->pickup_lng,
            'dest_lat' => $request->dest_lat,
            'dest_lng' => $request->dest_lng,
            'fare' => $fare,
            'status' => 'requested',
        ]);

        return redirect()->route('rides.show', $ride)->with('success', 'Ride requested! Looking for riders...');
    }

    public function calculateFare(Request $request)
    {
        $request->validate(['distance' => 'required|numeric']);
        $fare = $this->fareService->calculate($request->distance);
        return response()->json(['fare' => $fare, 'formatted_fare' => number_format($fare)]);
    }

    public function show(Ride $ride)
    {
        return view('rides.show', compact('ride'));
    }

    public function accept(Ride $ride)
    {
        $rider = Auth::user()->rider;
        
        if (!$rider || !$rider->is_approved) {
            return back()->with('error', 'Only approved riders can accept rides.');
        }

        if ($ride->status !== 'requested') {
            return back()->with('error', 'Ride is no longer available.');
        }

        $ride->update([
            'rider_id' => $rider->id,
            'status' => 'accepted',
        ]);

        return back()->with('success', 'Ride accepted!');
    }

    public function start(Ride $ride)
    {
        if ($ride->status !== 'accepted') {
            return back()->with('error', 'Ride must be accepted to start.');
        }

        $ride->update(['status' => 'ongoing']);

        return back()->with('success', 'Ride started! Have a safe trip.');
    }

    public function complete(Ride $ride)
    {
        if ($ride->status !== 'ongoing') {
            return back()->with('error', 'Ride must be ongoing to complete.');
        }

        $ride->update(['status' => 'completed']);

        return redirect()->route('rides.show', $ride)->with('success', 'Ride completed! Please rate your experience.');
    }

    public function cancel(Ride $ride)
    {
        if (!in_array($ride->status, ['requested', 'accepted'])) {
            return back()->with('error', 'Cannot cancel this ride anymore.');
        }

        $ride->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')->with('success', 'Ride cancelled.');
    }
}
