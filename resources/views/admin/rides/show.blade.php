@extends('layouts.admin')

@section('title', 'Ride Details - BodaBoda Admin Panel')
@section('page-title', 'Ride Details')
@section('page-subtitle', 'Detailed breakdown of Ride #' . $ride->id)

@section('content')
<!-- Breadcrumb -->
<div class="mb-8 flex items-center justify-between">
    <nav class="flex items-center space-x-3 text-xs font-bold text-slate-400 uppercase tracking-widest">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#2F6B3F] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.rides') }}" class="hover:text-[#2F6B3F] transition-colors">Rides</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-900">Ride #{{ $ride->id }}</span>
    </nav>
    <a href="{{ route('admin.rides') }}" class="text-xs font-black text-slate-500 hover:text-[#2F6B3F] transition-all flex items-center uppercase tracking-widest">
        <i class="fas fa-arrow-left mr-2"></i> Back to Archive
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Ride Summary Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900">Mission Parameters</h3>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Temporal and spatial logistics</p>
                </div>
                @php
                    $statusClasses = [
                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'ongoing' => 'bg-sky-50 text-sky-700 border-sky-200',
                    ];
                    $class = $statusClasses[$ride->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                @endphp
                <span class="px-3 py-1 rounded-lg text-[10px] font-black border uppercase tracking-widest {{ $class }}">
                    {{ $ride->status }}
                </span>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                    <div class="relative">
                        <div class="absolute left-4 top-10 bottom-0 w-0.5 bg-slate-100 border-l border-dashed border-slate-300"></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fas fa-circle text-[6px] text-emerald-500"></i> Deployment Origin
                        </p>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 border border-emerald-100 shadow-sm">
                                <i class="fas fa-map-marker-alt text-emerald-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-900 font-bold leading-relaxed">{{ $ride->pickup_address ?? 'Spatial coordinate data unavailable' }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Pickup Coordinate</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fas fa-circle text-[6px] text-rose-500"></i> Operational Target
                        </p>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 border border-rose-100 shadow-sm">
                                <i class="fas fa-flag-checkered text-rose-600 text-sm"></i>
                            </div>
                            <div>
                                 <p class="text-sm text-slate-900 font-bold leading-relaxed">{{ $ride->destination_address ?? 'Spatial coordinate data unavailable' }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Destination Target</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Spatial Span</p>
                        <p class="text-xl font-black text-slate-900">{{ number_format($ride->distance ?? 0, 1) }} <span class="text-[10px]">KM</span></p>
                    </div>
                         <div>
                             <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Temporal Span</p>
                             @php
                                 $durationInMinutes = null;
                                 if ($ride->trip_started_at && $ride->trip_completed_at) {
                                     $durationInMinutes = $ride->trip_started_at->diffInMinutes($ride->trip_completed_at);
                                 } elseif ($ride->accepted_at && $ride->trip_completed_at) {
                                     $durationInMinutes = $ride->accepted_at->diffInMinutes($ride->trip_completed_at);
                                 } elseif ($ride->created_at && $ride->trip_completed_at) {
                                     $durationInMinutes = $ride->created_at->diffInMinutes($ride->trip_completed_at);
                                 }
                             @endphp
                             <p class="text-xl font-black text-slate-900">{{ $durationInMinutes ?? '--' }} <span class="text-[10px]">MIN</span></p>
                         </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Yield Unit</p>
                        <p class="text-xl font-black text-[#2F6B3F]">{{ number_format($ride->fare, 0) }}</p>
                    </div>
                         <div>
                             <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Transaction</p>
                             <p class="text-base font-black text-slate-900 uppercase tracking-tighter">Cash</p>
                         </div>
                </div>
            </div>
        </div>

        <!-- Rating & Feedback -->
        @if($ride->ratings->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-amber-50 to-white flex items-center">
                <div class="h-10 w-10 rounded-xl bg-amber-500 flex items-center justify-center text-white shadow-lg mr-3">
                    <i class="fas fa-star text-sm"></i>
                </div>
                <div>
                    <h3 class="text-slate-900 font-bold text-base">Client Quality Audit</h3>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Subjective performance feedback</p>
                </div>
            </div>
            <div class="p-8">
                @foreach($ride->ratings as $rating)
                <div class="flex items-start gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div class="relative">
                        <img src="{{ $rating->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($rating->user->name) }}" class="w-12 h-12 rounded-xl shadow-md border-2 border-white">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-amber-500 rounded-lg flex items-center justify-center border-2 border-white text-white text-[10px] font-black">
                            {{ $rating->rating }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-black text-slate-900 text-sm">{{ $rating->user->name }}</h4>
                            <div class="flex text-amber-400 text-[10px] gap-0.5">
                                @for($i=1; $i<=5; $i++)
                                <i class="fa{{ $i <= $rating->rating ? 's' : 'r' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-medium italic bg-white p-3 rounded-xl border border-slate-100">"{{ $rating->comment }}"</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Side Cards -->
    <div class="lg:col-span-1 space-y-8">
        <!-- Rider Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Assigned Operator</h4>
                <a href="{{ route('admin.riders.show', $ride->rider) }}" class="text-[9px] font-black text-[#2F6B3F] uppercase hover:underline tracking-widest">Full Profile →</a>
            </div>
            <div class="p-6">
                <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-[#2F6B3F]/30 transition-all group">
                    <img src="{{ $ride->rider->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($ride->rider->user->name ?? 'U') }}" class="w-14 h-14 rounded-xl mr-4 shadow-md group-hover:scale-105 transition-transform duration-300">
                    <div>
                        <p class="font-black text-slate-900 text-sm">{{ $ride->rider->user->name ?? 'Unknown Operator' }}</p>
                        <p class="text-[10px] font-black text-[#2F6B3F] uppercase tracking-widest mt-1">{{ $ride->rider->bike_plate ?? 'Unidentified' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Consumer Entity</h4>
                @if($ride->passenger)
                <a href="{{ route('admin.clients.show', $ride->passenger) }}" class="text-[9px] font-black text-[#2F6B3F] uppercase hover:underline tracking-widest">Full Profile →</a>
                @endif
            </div>
            <div class="p-6">
                <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-[#2F6B3F]/30 transition-all group">
                    <img src="{{ $ride->passenger->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($ride->passenger->name ?? 'G') }}" class="w-14 h-14 rounded-xl mr-4 shadow-md group-hover:scale-105 transition-transform duration-300">
                    <div>
                        <p class="font-black text-slate-900 text-sm">{{ $ride->passenger->name ?? 'Guest Participant' }}</p>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Consumer Asset</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Clearance -->
        <div class="bg-rose-50 rounded-2xl shadow-lg border border-rose-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-100 bg-rose-100/30 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-500/20">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-rose-900 font-bold text-base">Security Clearance</h4>
                        <p class="text-rose-700/70 text-sm">Mission termination protocol</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-xs text-rose-700 font-bold uppercase tracking-wider mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Caution: These actions affect mission data integrity
                </p>
                <div class="flex flex-wrap gap-4">
                    @if($ride->status !== 'cancelled')
                    <button onclick="showConfirmModal('cancel', '{{ route('admin.ride.cancel', $ride) }}', 'Ride #{{ $ride->id }}')"
                            class="h-11 px-6 rounded-xl border border-rose-200 bg-white text-[11px] font-black text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm capitalize tracking-tight flex items-center gap-2">
                        <i class="fas fa-ban text-xs"></i> Cancel Ride
                    </button>
                    @endif
                    <button onclick="showConfirmModal('delete', '{{ route('admin.ride.delete', $ride) }}', 'Ride #{{ $ride->id }}', 'DELETE')"
                            class="h-11 px-6 rounded-xl border border-rose-200 bg-white text-[11px] font-black text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm capitalize tracking-tight flex items-center gap-2">
                        <i class="fas fa-trash-alt text-xs"></i> Delete Ride Record
                    </button>
                </div>
            </div>
        </div>

        <!-- System Metadata -->
        <div class="bg-slate-900 rounded-2xl shadow-xl p-6 text-white border border-slate-800 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -mr-12 -mt-12"></div>
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Mission Metadata</h4>
            <div class="space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-400 font-medium">Deployment Date</span>
                    <span class="font-bold">{{ $ride->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-400 font-medium">Deployment Time</span>
                    <span class="font-bold">{{ $ride->created_at->format('H:i:s') }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-400 font-medium">Session Token</span>
                    <span class="font-mono text-[9px] opacity-60">#{{ strtoupper(substr(md5($ride->id), 0, 12)) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
