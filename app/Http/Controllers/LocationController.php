<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Services\MqttService;
use App\Services\GeoService;
use App\Events\DriverLocationUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    protected MqttService $mqtt;

    public function __construct(MqttService $mqtt)
    {
        $this->mqtt = $mqtt;
    }

    public function update(Request $request, GeoService $geo)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $rider = Auth::user()->rider;
        
        if (!$rider) {
            return response()->json(['error' => 'Not a rider'], 403);
        }

        $rider->update([
            'current_lat' => $request->lat,
            'current_lng' => $request->lng,
        ]);

        if ($rider->status === 'online') {
            $geo->setLocation($rider->id, $request->lat, $request->lng);
        }

        $this->mqtt->publish(
            $this->mqtt->driverLocationRawTopic($rider->id),
            [
                'rider_id' => $rider->id,
                'lat' => (float) $request->lat,
                'lng' => (float) $request->lng,
            ]
        );

        // Dispatch Laravel event for WebSocket/Pusher broadcasting
        DriverLocationUpdated::dispatch(
            (int) $rider->id,
            (float) $request->lat,
            (float) $request->lng
        );

        return response()->json(['success' => true]);
    }

    public function getRiderLocation(Ride $ride)
    {
        if (!$ride->rider) {
            return response()->json(['error' => 'No rider assigned'], 404);
        }

        return response()->json([
            'lat' => $ride->rider->current_lat,
            'lng' => $ride->rider->current_lng,
            'status' => $ride->status,
        ]);
    }

    public function getAllOnlineRiders()
    {
        $riders = \App\Models\Rider::where('status', 'online')
                                    ->where('is_approved', true)
                                    ->with('user:id,name,avatar')
                                    ->get();

        return response()->json($riders);
    }

    public function getLocations()
    {
        $locations = \App\Models\Location::where('is_active', true)
                                       ->orderBy('area')
                                       ->orderBy('name')
                                       ->get(['id', 'name', 'area', 'latitude', 'longitude']);

        return response()->json($locations);
    }
}
