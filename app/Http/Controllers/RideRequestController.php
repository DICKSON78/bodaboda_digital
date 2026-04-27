<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\Rider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RideRequestController extends Controller
{
    // Calculate distance using Haversine formula
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $R = 6371; // Earth's radius in kilometers
        $dLat = ($lat2 - $lat1) * M_PI / 180;
        $dLng = ($lng2 - $lng1) * M_PI / 180;
        $a = sin($dLat/2) * sin($dLat/2) +
              cos($lat1 * M_PI / 180) * cos($lat2 * M_PI / 180) *
              sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }

    // Find nearby drivers within radius (default 5km)
    private function findNearbyDrivers($pickupLat, $pickupLng, $radiusKm = 5)
    {
        return Rider::where('status', 'online')
                    ->where('is_approved', true)
                    ->whereNotNull('current_lat')
                    ->whereNotNull('current_lng')
                    ->with('user:id,name,avatar,phone_number')
                    ->get()
                    ->filter(function($rider) use ($pickupLat, $pickupLng, $radiusKm) {
                        $distance = $this->calculateDistance(
                            $pickupLat, $pickupLng,
                            $rider->current_lat, $rider->current_lng
                        );
                        return $distance <= $radiusKm;
                    })
                    ->sortBy(function($rider) use ($pickupLat, $pickupLng) {
                        $distance = $this->calculateDistance(
                            $pickupLat, $pickupLng,
                            $rider->current_lat, $rider->current_lng
                        );
                        return $distance;
                    })
                    ->values();
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
                'user_id' => $validated['user_id'],
                'pickup_lat' => $validated['pickup_lat'],
                'pickup_lng' => $validated['pickup_lng'],
                'dest_lat' => $validated['dest_lat'],
                'dest_lng' => $validated['dest_lng'],
                'pickup_address' => $validated['pickup_address'],
                'destination_address' => $validated['destination_address'],
                'fare' => $validated['fare'],
                'distance' => $validated['distance'],
                'status' => 'REQUESTED'
            ]);

            // Find nearby drivers
            $nearbyDrivers = $this->findNearbyDrivers(
                $validated['pickup_lat'], 
                $validated['pickup_lng']
            );

            Log::info("Ride {$ride->id} requested, found {$nearbyDrivers->count()} nearby drivers");

            // Broadcast ride request to nearby drivers
            if ($nearbyDrivers->isNotEmpty()) {
                // In real implementation, this would use WebSockets/Pusher
                // For now, we'll log and return driver info
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

            // Check if ride is still REQUESTED
            if ($ride->status !== 'REQUESTED') {
                return response()->json([
                    'success' => false,
                    'message' => 'This ride is no longer available.'
                ], 400);
            }

            // Check if rider is online
            $rider = Rider::findOrFail($validated['rider_id']);
            if ($rider->status !== 'online') {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be online to accept rides.'
                ], 400);
            }

            // Lock ride and assign driver
            DB::transaction(function() use ($ride, $rider) {
                $ride->update([
                    'driver_id' => $rider->id,
                    'status' => 'ACCEPTED',
                    'accepted_at' => now()
                ]);
            });

            Log::info("Ride {$ride->id} accepted by rider {$rider->id}");

            // Broadcast acceptance to rider
            // In real implementation, this would use WebSockets/Pusher

            return response()->json([
                'success' => true,
                'ride' => $ride->fresh(['driver.user']),
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
                'status' => 'required|in:DRIVER_ARRIVING,DRIVER_ARRIVED,TRIP_STARTED,TRIP_COMPLETED,CANCELLED',
                'rider_id' => 'required|exists:riders,id'
            ]);

            // Verify this rider is assigned to this ride
            if ($ride->driver_id !== $validated['rider_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not assigned to this ride.'
                ], 403);
            }

            // Update status and timestamp
            $updateData = ['status' => $validated['status']];
            
            switch ($validated['status']) {
                case 'DRIVER_ARRIVING':
                    $updateData['accepted_at'] = now();
                    break;
                case 'DRIVER_ARRIVED':
                    $updateData['driver_arrived_at'] = now();
                    break;
                case 'TRIP_STARTED':
                    $updateData['trip_started_at'] = now();
                    break;
                case 'TRIP_COMPLETED':
                    $updateData['trip_completed_at'] = now();
                    break;
            }

            $ride->update($updateData);

            Log::info("Ride {$ride->id} status updated to {$validated['status']}");

            // Broadcast status update
            // In real implementation, this would use WebSockets/Pusher

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

            // Broadcast location update
            // In real implementation, this would use WebSockets/Pusher

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
