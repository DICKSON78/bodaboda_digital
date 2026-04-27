<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use App\Models\User;
use App\Models\Ride;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Dashboard Statistics
        $totalRiders = Rider::count();
        $approvedRiders = Rider::where('is_approved', true)->count();
        $pendingRiders = Rider::where('is_approved', false)->with('user')->get();
        $onlineRiders = Rider::where('status', 'online')->count();
        $totalRides = Ride::count();
        $completedRides = Ride::where('status', 'completed')->count();
        $pendingRides = Ride::where('status', 'pending')->count();
        
        // Recent activities
        $recentRides = Ride::with(['rider.user', 'passenger'])->latest()->take(5)->get();
        $recentApplications = Rider::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRiders', 'approvedRiders', 'pendingRiders', 'onlineRiders',
            'totalRides', 'completedRides', 'pendingRides',
            'recentRides', 'recentApplications'
        ));
    }

    public function riders()
    {
        $riders = Rider::with('user')->latest()->paginate(20);
        return view('admin.riders.index', compact('riders'));
    }

    public function showRider(Rider $rider)
    {
        $rider->load(['user', 'rides' => function($query) {
            $query->latest()->take(10);
        }]);
        
        $stats = [
            'total_rides' => $rider->rides()->count(),
            'completed_rides' => $rider->rides()->where('status', 'completed')->count(),
            'cancelled_rides' => $rider->rides()->where('status', 'cancelled')->count(),
            'total_earnings' => $rider->rides()->where('status', 'completed')->sum('fare'),
            'average_rating' => $rider->rides()->whereNotNull('rating')->avg('rating') ?? 0,
        ];

        return view('admin.riders.show', compact('rider', 'stats'));
    }

    public function editRider(Rider $rider)
    {
        return view('admin.riders.edit', compact('rider'));
    }

    public function updateRider(Request $request, Rider $rider)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'license_number' => 'required|string|unique:riders,license_number,' . $rider->id,
            'bike_plate' => 'required|string',
            'status' => 'required|in:online,offline,suspended',
            'is_approved' => 'required|boolean',
        ]);

        $rider->update($request->all());

        // Update user name if changed
        if ($request->first_name || $request->last_name) {
            $rider->user->update([
                'name' => $request->first_name . ' ' . $request->last_name
            ]);
        }

        return redirect()->route('admin.riders.show', $rider)
            ->with('success', 'Rider information updated successfully.');
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

    public function suspendRider(Rider $rider)
    {
        $rider->update(['status' => 'suspended']);
        return back()->with('success', 'Rider suspended successfully.');
    }

    public function activateRider(Rider $rider)
    {
        $rider->update(['status' => 'offline']);
        return back()->with('success', 'Rider activated successfully.');
    }

    public function deleteRider(Rider $rider)
    {
        $rider->user->delete();
        $rider->delete();
        return redirect()->route('admin.riders')
            ->with('success', 'Rider deleted successfully.');
    }

    public function analytics()
    {
        // Get monthly ride statistics
        $monthlyRides = Ride::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)')
            ->get();

        // Get top performing riders
        $topPerformers = Rider::with('user')
            ->withCount(['rides' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['rides' => function($query) {
                $query->where('status', 'completed')->select('fare');
            }])
            ->withAvg('ratings.rating')
            ->orderBy('rides_count', 'desc')
            ->limit(10)
            ->get();

        // Get revenue data
        $monthlyIncome = Ride::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('fare');

        return view('admin.analytics', compact(
            'monthlyRides', 'topPerformers', 'monthlyIncome'
        ));
    }

    public function reports()
    {
        // Get report data
        $dailyRevenue = Ride::whereDate('created_at', now()->toDateString())
            ->where('status', 'completed')
            ->sum('fare');

        $weeklyRevenue = Ride::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'completed')
            ->sum('fare');

        $monthlyRevenue = Ride::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('fare');

        $yearlyRevenue = Ride::whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('fare');

        $recentReports = collect([
            [
                'name' => 'Ripoti ya Kila Siku',
                'type' => 'Daily',
                'created_at' => now()
            ],
            [
                'name' => 'Ripoti ya Kila Wiki',
                'type' => 'Weekly',
                'created_at' => now()->subDays(7)
            ],
            [
                'name' => 'Ripoti ya Kila Mwezi',
                'type' => 'Monthly',
                'created_at' => now()->subDays(30)
            ]
        ]);

        return view('admin.reports', compact(
            'dailyRevenue', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue', 'recentReports'
        ));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
