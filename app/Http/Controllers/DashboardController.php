<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $recentRides = [];
        $stats = [];

        if ($user->role === 'passenger') {
            $recentRides = Ride::where('passenger_id', $user->id)
                                ->latest()
                                ->take(5)
                                ->get();
            
            $stats = [
                'total_rides' => Ride::where('passenger_id', $user->id)->count(),
                'completed_rides' => Ride::where('passenger_id', $user->id)->where('status', 'completed')->count(),
            ];
        } elseif ($user->role === 'rider' && $user->rider) {
            $recentRides = Ride::where('rider_id', $user->rider->id)
                                ->latest()
                                ->take(5)
                                ->get();

            $stats = [
                'total_earned' => Ride::where('rider_id', $user->rider->id)->where('status', 'completed')->sum('fare'),
                'avg_rating' => $user->ratingsReceived()->avg('rating') ?: 0,
                'total_trips' => Ride::where('rider_id', $user->rider->id)->where('status', 'completed')->count(),
            ];
        }

        return view('dashboard', compact('user', 'recentRides', 'stats'));
    }
}
