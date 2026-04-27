@extends('layouts.admin')

@section('title', 'Riders Management - BodaBoda Admin Panel')
@section('page-title', 'Riders Management')
@section('page-subtitle', 'Manage all riders and their information')

@section('content')
<div class="pt-32 pb-20 min-h-screen bg-background relative overflow-hidden">
    <div class="honeycomb absolute inset-0 opacity-10"></div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-primary tracking-tighter uppercase mb-2">Riders Management</h1>
                    <p class="text-lg text-text-secondary">Manage all riders and their information</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.analytics') }}" class="btn-outline">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Analytics
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6 md:mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" placeholder="Search riders..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-sm font-bold text-text-secondary uppercase tracking-widest mb-2">Status</label>
                    <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <option value="">All Status</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-text-secondary uppercase tracking-widest mb-2">Approval</label>
                    <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <option value="">All</option>
                        <option value="1">Approved</option>
                        <option value="0">Pending</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="btn-primary w-full">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Riders Table -->
        <div class="card overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-text-primary">All Riders ({{ $riders->total() }})</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-text-muted">Show</span>
                        <select class="px-3 py-1 border border-gray-200 rounded-lg text-sm">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-text-secondary uppercase tracking-widest">Rider</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-text-secondary uppercase tracking-widest">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-text-secondary uppercase tracking-widest">License</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-text-secondary uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-text-secondary uppercase tracking-widest">Approval</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-text-secondary uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($riders as $rider)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $rider->user->avatar }}" class="h-10 w-10 rounded-lg border-2 border-white shadow-sm">
                                        <div>
                                            <p class="font-semibold text-text-primary">{{ $rider->user->name }}</p>
                                            <p class="text-xs text-text-muted">{{ $rider->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <p class="text-text-primary">{{ $rider->phone_number }}</p>
                                        <p class="text-xs text-text-muted">Plate: {{ $rider->bike_plate }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-text-primary font-mono">{{ $rider->license_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($rider->status === 'online')
                                        <span class="px-3 py-1 bg-success/10 text-success text-xs font-bold rounded-full">Online</span>
                                    @elseif($rider->status === 'offline')
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Offline</span>
                                    @else
                                        <span class="px-3 py-1 bg-error/10 text-error text-xs font-bold rounded-full">Suspended</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($rider->is_approved)
                                        <span class="px-3 py-1 bg-success/10 text-success text-xs font-bold rounded-full">Approved</span>
                                    @else
                                        <span class="px-3 py-1 bg-warning/10 text-warning text-xs font-bold rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.riders.show', $rider) }}" class="text-primary hover:text-primary/80" title="View Details">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.riders.edit', $rider) }}" class="text-accent hover:text-accent/80" title="Edit">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        @if($rider->is_approved)
                                            @if($rider->status === 'suspended')
                                                <form action="{{ route('admin.rider.activate', $rider) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-success hover:text-success/80" title="Activate">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.rider.suspend', $rider) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-warning hover:text-warning/80" title="Suspend">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                        <form action="{{ route('admin.rider.delete', $rider) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this rider?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-error hover:text-error/80" title="Delete">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="h-16 w-16 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-text-primary mb-2">No Riders Found</h3>
                                    <p class="text-text-muted">Start by approving rider applications or adding new riders.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($riders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $riders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
