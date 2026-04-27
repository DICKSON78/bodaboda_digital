<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderController extends Controller
{
    public function apply()
    {
        return view('rider.apply');
    }

    public function showRegister()
    {
        return view('rider.auth.register');
    }

    public function showLogin()
    {
        return view('rider.auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'license_number' => 'required|string|unique:riders',
            'bike_plate' => 'required|string',
            'bike_image' => 'nullable|image|max:2048',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => 'rider',
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->first_name),
        ]);

        $bikeImagePath = null;
        if ($request->hasFile('bike_image')) {
            $bikeImagePath = $request->file('bike_image')->store('bikes', 'public');
        }

        Rider::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'license_number' => $request->license_number,
            'bike_plate' => $request->bike_plate,
            'bike_image' => $bikeImagePath,
            'status' => 'offline',
            'is_approved' => false,
            'current_lat' => -6.1731,
            'current_lng' => 35.7419,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Your application has been submitted and is pending approval.');
    }

    public function toggleStatus()
    {
        $rider = Auth::user()->rider;
        
        if (!$rider || !$rider->is_approved) {
            return back()->with('error', 'You must be an approved rider to toggle status.');
        }

        $rider->status = $rider->status === 'online' ? 'offline' : 'online';
        $rider->save();

        return back()->with('success', 'Status updated to ' . $rider->status);
    }
}
