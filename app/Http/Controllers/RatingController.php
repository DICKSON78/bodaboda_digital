<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Ride $ride)
    {
        // Check if user is part of the ride and ride is completed
        if ($ride->status !== 'completed') {
            return redirect()->route('rides.show', $ride)->with('error', 'You can only rate completed rides.');
        }

        $isPassenger = $ride->passenger_id === Auth::id();
        $isRider = $ride->rider && $ride->rider->user_id === Auth::id();

        if (!$isPassenger && !$isRider) {
            abort(403);
        }

        // Check if user already rated this ride
        $existingRating = Rating::where('ride_id', $ride->id)
                                ->where('from_user_id', Auth::id())
                                ->first();

        if ($existingRating) {
            return redirect()->route('rides.show', $ride)->with('error', 'You have already rated this ride.');
        }

        $toUser = $isPassenger ? $ride->rider->user : $ride->passenger;

        return view('ratings.create', compact('ride', 'toUser'));
    }

    public function store(Request $request, Ride $ride)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $isPassenger = $ride->passenger_id === Auth::id();
        $isRider = $ride->rider && $ride->rider->user_id === Auth::id();

        if (!$isPassenger && !$isRider) {
            abort(403);
        }

        $toUser = $isPassenger ? $ride->rider->user : $ride->passenger;

        Rating::create([
            'ride_id' => $ride->id,
            'from_user_id' => Auth::id(),
            'to_user_id' => $toUser->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('rides.show', $ride)->with('success', 'Thank you for your rating!');
    }
}
