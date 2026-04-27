@extends('layouts.admin')

@section('title', 'Dashboard - BodaBoda Admin Panel')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Manage riders and track performance')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Total Riders</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ $totalRiders }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-green-600 mr-1"><i class="fas fa-users"></i></span>
                    <span>{{ $approvedRiders }} approved</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                <i class="fas fa-users text-primary text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Online Riders</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ $onlineRiders }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-green-600 mr-1"><i class="fas fa-circle"></i></span>
                    <span>Currently active</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-success/10 flex items-center justify-center">
                <i class="fas fa-circle text-success text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Total Rides</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ $totalRides }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-blue-600 mr-1"><i class="fas fa-motorcycle"></i></span>
                    <span>{{ $completedRides }} completed</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-accent/10 flex items-center justify-center">
                <i class="fas fa-motorcycle text-accent text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Pending</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-yellow-600">{{ $pendingRiders->count() }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-orange-500 mr-1"><i class="fas fa-clock"></i></span>
                    <span>Applications waiting</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-warning/10 flex items-center justify-center">
                <i class="fas fa-clock text-warning text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-6 md:mb-8">
    <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
        <i class="fas fa-bolt text-primary mr-2"></i> Quick Actions
    </h3>
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
        <!-- Manage Riders -->
        <a href="{{ route('admin.riders') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-primary/10 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-users text-primary text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Manage Riders</h4>
                    <p class="text-xs text-gray-500 mt-1">View and edit riders</p>
                </div>
            </div>
        </a>

        <!-- View Analytics -->
        <a href="{{ route('admin.analytics') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-accent/10 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-chart-bar text-accent text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Analytics</h4>
                    <p class="text-xs text-gray-500 mt-1">View statistics</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
    <!-- Recent Applications -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-4 md:p-6 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-700 flex items-center">
                <i class="fas fa-user-plus text-primary mr-2"></i>
                Recent Applications
            </h3>
        </div>
        <div class="p-4 md:p-6">
            @if($recentApplications->isEmpty())
                <div class="text-center py-8">
                    <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">No Recent Applications</h4>
                    <p class="text-gray-500 text-sm">No new rider applications in the last 5 days.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentApplications as $rider)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $rider->user->avatar }}" class="h-8 w-8 rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">{{ $rider->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $rider->user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($rider->is_approved)
                                    <span class="px-2 py-1 bg-success/10 text-success text-xs font-bold rounded-lg">Approved</span>
                                @else
                                    <span class="px-2 py-1 bg-warning/10 text-warning text-xs font-bold rounded-lg">Pending</span>
                                @endif
                                <a href="{{ route('admin.riders.show', $rider) }}" class="text-primary hover:text-primary/80">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Rides -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-4 md:p-6 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-700 flex items-center">
                <i class="fas fa-motorcycle text-primary mr-2"></i>
                Recent Rides
            </h3>
        </div>
        <div class="p-4 md:p-6">
            @if($recentRides->isEmpty())
                <div class="text-center py-8">
                    <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                        <i class="fas fa-motorcycle text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">No Recent Rides</h4>
                    <p class="text-gray-500 text-sm">No rides have been completed recently.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentRides as $ride)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-motorcycle text-primary text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">Ride #{{ $ride->id }}</p>
                                    <p class="text-xs text-gray-500">{{ $ride->created_at->format('M d, Y - h:i A') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($ride->status === 'completed')
                                    <span class="px-2 py-1 bg-success/10 text-success text-xs font-bold rounded-lg">Completed</span>
                                    <p class="text-sm font-bold text-primary mt-1">TZS {{ number_format($ride->fare, 0) }}</p>
                                @elseif($ride->status === 'cancelled')
                                    <span class="px-2 py-1 bg-error/10 text-error text-xs font-bold rounded-lg">Cancelled</span>
                                @else
                                    <span class="px-2 py-1 bg-warning/10 text-warning text-xs font-bold rounded-lg">{{ ucfirst($ride->status) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pending Applications -->
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm mt-6 md:mt-8">
    <div class="bg-gradient-to-r from-primary to-secondary-green p-6 md:p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight mb-2">Pending Applications</h2>
                <p class="text-white/80 text-sm">{{ $pendingRiders->count() }} riders waiting approval</p>
            </div>
            <div class="h-14 w-14 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    @if($pendingRiders->isEmpty())
        <div class="p-12 md:p-16 text-center">
            <div class="h-16 w-16 bg-success/10 rounded-2xl flex items-center justify-center text-success mx-auto mb-6">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">All Clear!</h3>
            <p class="text-gray-500">No pending rider applications</p>
        </div>
    @else
        <div class="p-6 md:p-8">
            <div class="space-y-4 md:space-y-6">
                @foreach($pendingRiders as $rider)
                    <div class="bg-gray-50 rounded-xl p-4 md:p-6 hover:bg-gray-100 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 md:space-x-6">
                                <img src="{{ $rider->user->avatar }}" class="h-12 w-12 md:h-16 md:w-16 rounded-xl border-2 border-white shadow-lg">
                                <div>
                                    <h4 class="text-base md:text-lg font-bold text-gray-800">{{ $rider->user->name }}</h4>
                                    <p class="text-sm text-gray-600 font-medium mb-2">{{ $rider->user->email }}</p>
                                    <div class="flex flex-col md:flex-row md:space-x-6 text-xs">
                                        <div class="flex items-center text-gray-600 mb-1 md:mb-0">
                                            <i class="fas fa-id-card text-primary mr-2"></i>
                                            <span class="font-medium">License:</span> {{ $rider->license_number }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-motorcycle text-primary mr-2"></i>
                                            <span class="font-medium">Plate:</span> {{ $rider->bike_plate }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-3">
                                <form action="{{ route('admin.rider.approve', $rider) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-primary px-4 md:px-6 py-2 md:py-3 text-xs uppercase tracking-wider shadow-lg shadow-success/20 hover:shadow-success/30 group">
                                        <i class="fas fa-check mr-2 group-hover:scale-110 transition"></i>
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.rider.reject', $rider) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-error text-white px-4 md:px-6 py-2 md:py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-error/20 hover:bg-error/90 hover:shadow-error/30 transition group">
                                        <i class="fas fa-times mr-2 group-hover:scale-110 transition"></i>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

            <div class="card p-6 hover:shadow-xl transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-success/10 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-success">{{ $onlineRiders }}</span>
                </div>
                <h3 class="text-sm font-bold text-text-secondary uppercase tracking-widest">Online Riders</h3>
                <p class="text-xs text-text-muted mt-1">Currently active</p>
            </div>

            <div class="card p-6 hover:shadow-xl transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-accent/10 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-accent">{{ $totalRides }}</span>
                </div>
                <h3 class="text-sm font-bold text-text-secondary uppercase tracking-widest">Total Rides</h3>
                <p class="text-xs text-text-muted mt-1">{{ $completedRides }} completed</p>
            </div>

            <div class="card p-6 hover:shadow-xl transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-warning/10 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-warning">{{ $pendingRiders->count() }}</span>
                </div>
                <h3 class="text-sm font-bold text-text-secondary uppercase tracking-widest">Pending</h3>
                <p class="text-xs text-text-muted mt-1">Applications waiting</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="card p-6">
                <h3 class="text-lg font-bold text-text-primary mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.riders') }}" class="btn-primary w-full text-center">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Manage Riders
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="btn-outline w-full text-center">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        View Analytics
                    </a>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="card p-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-text-primary">Recent Applications</h3>
                    <a href="{{ route('admin.riders') }}" class="text-sm text-primary hover:text-primary/80">View All</a>
                </div>
                @if($recentApplications->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-text-muted">No recent applications</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentApplications as $rider)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $rider->user->avatar }}" class="h-10 w-10 rounded-lg">
                                    <div>
                                        <p class="font-semibold text-text-primary">{{ $rider->user->name }}</p>
                                        <p class="text-xs text-text-muted">{{ $rider->user->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($rider->is_approved)
                                        <span class="px-2 py-1 bg-success/10 text-success text-xs font-bold rounded-lg">Approved</span>
                                    @else
                                        <span class="px-2 py-1 bg-warning/10 text-warning text-xs font-bold rounded-lg">Pending</span>
                                    @endif
                                    <a href="{{ route('admin.riders.show', $rider) }}" class="text-primary hover:text-primary/80">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Applications Card -->
        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-secondary-green p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tighter uppercase mb-2">Pending Applications</h2>
                        <p class="text-white/80 text-sm font-bold uppercase tracking-widest">{{ $pendingRiders->count() }} riders waiting approval</p>
                    </div>
                    <div class="h-16 w-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            @if($pendingRiders->isEmpty())
                <div class="p-16 text-center">
                    <div class="h-16 w-16 bg-success/10 rounded-2xl flex items-center justify-center text-success mx-auto mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text-primary mb-2">All Clear!</h3>
                    <p class="text-text-secondary font-bold uppercase tracking-widest text-sm">No pending rider applications</p>
                </div>
            @else
                <div class="p-8">
                    <div class="space-y-6">
                        @foreach($pendingRiders as $rider)
                            <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-6">
                                        <img src="{{ $rider->user->avatar }}" class="h-16 w-16 rounded-2xl border-4 border-white shadow-lg">
                                        <div>
                                            <h4 class="text-lg font-bold text-text-primary">{{ $rider->user->name }}</h4>
                                            <p class="text-sm text-text-secondary font-bold uppercase tracking-widest mb-2">{{ $rider->user->email }}</p>
                                            <div class="flex space-x-8 text-xs">
                                                <div class="flex items-center text-text-secondary">
                                                    <svg class="h-4 w-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="font-bold uppercase tracking-widest">License:</span> {{ $rider->license_number }}
                                                </div>
                                                <div class="flex items-center text-text-secondary">
                                                    <svg class="h-4 w-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="font-bold uppercase tracking-widest">Plate:</span> {{ $rider->bike_plate }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <form action="{{ route('admin.rider.approve', $rider) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-primary px-6 py-3 text-xs uppercase tracking-widest shadow-lg shadow-success/20 hover:shadow-success/30 group">
                                                <svg class="inline h-4 w-4 mr-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.rider.reject', $rider) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-6 py-3 bg-error text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-error/20 hover:bg-error/90 hover:shadow-error/30 transition group">
                                                <svg class="inline h-4 w-4 mr-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
