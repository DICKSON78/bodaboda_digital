<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingRiders = Rider::where('is_approved', false)->with('user')->get();
        return view('admin.dashboard', compact('pendingRiders'));
    }

    public function approveRider(Rider $rider)
    {
        $rider->update(['is_approved' => true]);
        
        // Change user role to rider
        $rider->user->update(['role' => 'rider']);

        return back()->with('success', 'Rider approved successfully.');
    }

    public function rejectRider(Rider $rider)
    {
        // For now just delete the application
        $rider->delete();
        return back()->with('success', 'Rider application rejected.');
    }
}
