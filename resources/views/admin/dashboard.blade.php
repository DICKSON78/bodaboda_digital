@extends('layouts.app')

@section('content')
<div class="pt-32 pb-20 min-h-screen bg-background relative overflow-hidden">
    <div class="honeycomb absolute inset-0 opacity-10"></div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="mb-12">
            <h1 class="text-5xl font-black text-primary tracking-tighter uppercase mb-4">Admin Dashboard</h1>
            <p class="text-lg text-text-secondary">Manage rider applications and system operations</p>
        </div>

        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-secondary-green p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tighter uppercase mb-2">Pending Applications</h2>
                        <p class="text-white/80 text-sm font-bold uppercase tracking-widest">{{ $pendingRiders->count() }} riders waiting approval</p>
                    </div>
                    <div class="h-16 w-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>
            
            @if($pendingRiders->isEmpty())
                <div class="p-16 text-center">
                    <div class="h-16 w-16 bg-success/10 rounded-2xl flex items-center justify-center text-success mx-auto mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                                                    <svg class="h-4 w-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    <span class="font-bold uppercase tracking-widest">License:</span> {{ $rider->license_number }}
                                                </div>
                                                <div class="flex items-center text-text-secondary">
                                                    <svg class="h-4 w-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <span class="font-bold uppercase tracking-widest">Plate:</span> {{ $rider->bike_plate }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <form action="{{ route('admin.rider.approve', $rider) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-primary px-6 py-3 text-xs uppercase tracking-widest shadow-lg shadow-success/20 hover:shadow-success/30 group">
                                                <svg class="inline h-4 w-4 mr-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.rider.reject', $rider) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-6 py-3 bg-error text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-error/20 hover:bg-error/90 hover:shadow-error/30 transition group">
                                                <svg class="inline h-4 w-4 mr-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
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
