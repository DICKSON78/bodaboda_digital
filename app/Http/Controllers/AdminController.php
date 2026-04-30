<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use App\Models\User;
use App\Models\Ride;
use App\Models\Rating;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalRiders = Rider::count();
        $approvedRiders = Rider::where('is_approved', true)->count();
        $pendingRiders = Rider::where('is_approved', false)->with('user')->get();
        $onlineRiders = Rider::where('status', 'online')->count();
        $totalRides = Ride::count();
        $completedRides = Ride::where('status', 'completed')->count();
        $pendingRides = Ride::where('status', 'pending')->count();
        $totalClients = User::where('role', 'passenger')->count();
        $monthlyRevenue = Ride::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('fare');

        $recentRides = Ride::with(['rider.user', 'passenger'])->latest()->take(5)->get();
        $recentApplications = Rider::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRiders', 'approvedRiders', 'pendingRiders', 'onlineRiders',
            'totalRides', 'completedRides', 'pendingRides', 'totalClients',
            'monthlyRevenue', 'recentRides', 'recentApplications'
        ));
    }

    public function riders(Request $request)
    {
        $query = Rider::with('user');

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('phone_number', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%")
                  ->orWhere('bike_plate', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->has('is_approved') && $request->is_approved !== '') {
            $query->where('is_approved', $request->is_approved);
        }

        $riders = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => Rider::count(),
            'online' => Rider::where('status', 'online')->count(),
            'pending' => Rider::where('is_approved', false)->count(),
            'suspended' => Rider::where('status', 'suspended')->count(),
        ];

        if ($request->ajax()) {
            return view('admin.riders._table', compact('riders', 'stats'));
        }

        return view('admin.riders.index', compact('riders', 'stats'));
    }

    public function showRider(Rider $rider)
    {
        $rider->load(['user', 'rides' => fn($q) => $q->latest()->take(10)]);
        
        $stats = [
            'total_rides' => $rider->rides()->count(),
            'completed_rides' => $rider->rides()->where('status', 'completed')->count(),
            'cancelled_rides' => $rider->rides()->where('status', 'cancelled')->count(),
            'total_earnings' => $rider->rides()->where('status', 'completed')->sum('fare'),
            'average_rating' => $rider->user->ratingsReceived()->avg('rating') ?? 0,
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

        if ($request->first_name || $request->last_name) {
            $rider->user->update(['name' => $request->first_name . ' ' . $request->last_name]);
        }

        return redirect()->route('admin.riders.show', $rider)->with('success', 'Rider updated successfully.');
    }

    public function approveRider(Rider $rider)
    {
        $rider->update(['is_approved' => true]);
        $rider->user->update(['role' => 'rider']);
        return back()->with('success', 'Rider approved successfully.');
    }

    public function rejectRider(Rider $rider)
    {
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
        return redirect()->route('admin.riders')->with('success', 'Rider deleted successfully.');
    }

    // ==========================================
    // Client (Passenger) Management
    // ==========================================

    public function clients(Request $request)
    {
        $query = User::where('role', 'passenger');

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->whereNull('suspended_at');
            } elseif ($request->status === 'suspended') {
                $query->whereNotNull('suspended_at');
            }
        }

        $clients = $query->withCount('ridesAsPassenger')->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => User::where('role', 'passenger')->count(),
            'active' => User::where('role', 'passenger')->whereNull('suspended_at')->count(),
            'suspended' => User::where('role', 'passenger')->whereNotNull('suspended_at')->count(),
            'with_rides' => User::where('role', 'passenger')->has('ridesAsPassenger')->count(),
        ];

        if ($request->ajax()) {
            return view('admin.clients._table', compact('clients', 'stats'));
        }

        return view('admin.clients.index', compact('clients', 'stats'));
    }

    public function showClient(User $user)
    {
        $user->load(['ridesAsPassenger' => fn($q) => $q->with('rider.user')->latest()->take(10)]);

        $stats = [
            'total_rides' => $user->ridesAsPassenger()->count(),
            'completed_rides' => $user->ridesAsPassenger()->where('status', 'completed')->count(),
            'cancelled_rides' => $user->ridesAsPassenger()->where('status', 'cancelled')->count(),
            'total_spent' => $user->ridesAsPassenger()->where('status', 'completed')->sum('fare'),
        ];

        return view('admin.clients.show', compact('user', 'stats'));
    }

    public function editClient(User $user)
    {
        return view('admin.clients.edit', compact('user'));
    }

    public function updateClient(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));
        return redirect()->route('admin.clients.show', $user)->with('success', 'Client updated successfully.');
    }

    public function suspendClient(User $user)
    {
        $user->update(['suspended_at' => now()]);
        return back()->with('success', 'Client suspended successfully.');
    }

    public function activateClient(User $user)
    {
        $user->update(['suspended_at' => null]);
        return back()->with('success', 'Client activated successfully.');
    }

    public function deleteClient(User $user)
    {
        $user->delete();
        return redirect()->route('admin.clients')->with('success', 'Client deleted successfully.');
    }

    // ==========================================
    // Rides Management
    // ==========================================

    public function rides(Request $request)
    {
        $query = Ride::with(['rider.user', 'passenger']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('rider.user', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('passenger', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $rides = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => Ride::count(),
            'completed' => Ride::where('status', 'completed')->count(),
            'cancelled' => Ride::where('status', 'cancelled')->count(),
            'ongoing' => Ride::where('status', 'ongoing')->count(),
        ];

        if ($request->ajax()) {
            return view('admin.rides._table', compact('rides', 'stats'));
        }

        return view('admin.rides.index', compact('rides', 'stats'));
    }

    public function showRide(Ride $ride)
    {
        $ride->load(['rider.user', 'passenger', 'ratings']);
        return view('admin.rides.show', compact('ride'));
    }

    // ==========================================
    // Analytics & Reports
    // ==========================================

    public function analytics()
    {
        $monthlyRides = Ride::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        $topPerformers = Rider::with('user')
            ->withCount(['rides' => fn($q) => $q->where('status', 'completed')])
            ->orderBy('rides_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function($rider) {
                $rider->avg_rating = $rider->user->ratingsReceived()->avg('rating') ?? 0;
                return $rider;
            });

        $monthlyIncome = Ride::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('fare');

        $overallAvgRating = Rating::avg('rating') ?? 0;

        return view('admin.analytics', compact('monthlyRides', 'topPerformers', 'monthlyIncome', 'overallAvgRating'));
    }

    public function reports()
    {
        $dailyRevenue = Ride::whereDate('created_at', now()->toDateString())->where('status', 'completed')->sum('fare');
        $weeklyRevenue = Ride::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('status', 'completed')->sum('fare');
        $monthlyRevenue = Ride::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('status', 'completed')->sum('fare');
        $yearlyRevenue = Ride::whereYear('created_at', now()->year)->where('status', 'completed')->sum('fare');

        $recentReports = collect([
            ['name' => 'Daily Report', 'type' => 'Daily', 'created_at' => now()],
            ['name' => 'Weekly Report', 'type' => 'Weekly', 'created_at' => now()->subDays(7)],
            ['name' => 'Monthly Report', 'type' => 'Monthly', 'created_at' => now()->subDays(30)],
        ]);

        return view('admin.reports', compact('dailyRevenue', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue', 'recentReports'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
