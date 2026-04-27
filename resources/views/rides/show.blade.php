@extends('layouts.app')

@section('content')
<div class="h-[calc(100vh-120px)] flex flex-col lg:flex-row bg-background relative overflow-hidden mt-[120px]">
    <!-- Ride Information & Status -->
    <div class="w-full lg:w-[450px] bg-white border-r border-gray-100 flex flex-col h-full shadow-2xl z-20 relative animate-in slide-in-from-left duration-700">
        <div class="p-8 flex-1 overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-3xl font-black text-primary tracking-tighter uppercase leading-tight">Ride #{{ $ride->id }}</h2>
                    <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest">{{ $ride->created_at->format('M d, Y • H:i') }}</p>
                </div>
                <div id="status-badge" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest
                    @if($ride->status === 'requested') bg-yellow-100 text-yellow-700 shadow-[0_0_15px_rgba(250,204,21,0.3)]
                    @elseif($ride->status === 'accepted') bg-blue-100 text-blue-700 shadow-[0_0_15px_rgba(59,130,246,0.3)]
                    @elseif($ride->status === 'ongoing') bg-primary/10 text-primary shadow-[0_0_15px_rgba(47,107,63,0.3)]
                    @elseif($ride->status === 'completed') bg-success/10 text-success shadow-[0_0_15px_rgba(34,197,94,0.3)]
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $ride->status }}
                </div>
            </div>

            <div class="space-y-8 mb-12">
                <div class="flex gap-5">
                    <div class="flex flex-col items-center gap-1 mt-1">
                        <div class="h-3.5 w-3.5 rounded-full bg-green-500 ring-4 ring-green-500/20 shadow-lg"></div>
                        <div class="w-0.5 h-16 bg-dashed border-l-2 border-gray-100"></div>
                        <div class="h-3.5 w-3.5 rounded-full bg-primary ring-4 ring-primary/20 shadow-lg"></div>
                    </div>
                    <div class="flex-1 space-y-10">
                        <div>
                            <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest mb-1">Pickup Point</p>
                            <p class="text-sm font-bold text-text-primary">Location A ({{ round($ride->pickup_lat, 4) }}, {{ round($ride->pickup_lng, 4) }})</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest mb-1">Destination</p>
                            <p class="text-sm font-bold text-text-primary">Location B ({{ round($ride->dest_lat, 4) }}, {{ round($ride->dest_lng, 4) }})</p>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-50">
                    <div class="flex justify-between items-center">
                        <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Total Fare</p>
                        <p class="text-4xl font-black text-primary tracking-tighter">TZS {{ number_format($ride->fare) }}</p>
                    </div>
                </div>
            </div>

            <!-- Rider/Driver Details -->
            <div id="rider-card" class="relative">
                <h3 class="text-xs font-black text-primary uppercase tracking-widest mb-8">Assigned Professional</h3>
                
                @if($ride->rider)
                    <div class="p-6 bg-gray-50 rounded-[32px] border border-gray-100 relative overflow-hidden group">
                        <div class="flex items-center gap-6 relative z-10">
                            <div class="relative">
                                <img src="{{ $ride->rider->user->avatar }}" class="h-20 w-20 rounded-[28px] border-4 border-white shadow-xl">
                                <div class="absolute -bottom-1 -right-1 h-8 w-8 bg-success rounded-full border-4 border-white flex items-center justify-center text-white">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-xl font-black text-text-primary tracking-tighter uppercase leading-none">{{ $ride->rider->first_name }} {{ $ride->rider->last_name }}</h4>
                                <p class="text-[10px] font-black text-primary uppercase tracking-widest">Certified Rider</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <a href="tel:{{ $ride->rider->phone_number }}" class="px-4 py-2 bg-white rounded-xl shadow-sm text-[10px] font-black text-primary uppercase hover:bg-primary hover:text-white transition">Call Rider</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 grid grid-cols-2 gap-4 relative z-10">
                            <div class="p-4 bg-white rounded-2xl shadow-sm">
                                <p class="text-[8px] font-black text-text-secondary uppercase tracking-widest mb-1">Plate Number</p>
                                <p class="text-xs font-bold text-text-primary uppercase">{{ $ride->rider->bike_plate }}</p>
                            </div>
                            <div class="p-4 bg-white rounded-2xl shadow-sm">
                                <p class="text-[8px] font-black text-text-secondary uppercase tracking-widest mb-1">License</p>
                                <p class="text-xs font-bold text-text-primary uppercase">{{ substr($ride->rider->license_number, 0, 8) }}...</p>
                            </div>
                        </div>

                        <!-- Action for Rider -->
                        @if(auth()->check() && auth()->user()->role === 'rider' && $ride->status === 'accepted')
                            <form action="{{ route('rides.start', $ride) }}" method="POST" class="mt-8 relative z-10">
                                @csrf
                                <button class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 group">
                                    Start Trip Now
                                </button>
                            </form>
                        @endif

                        @if(auth()->check() && auth()->user()->role === 'rider' && $ride->status === 'ongoing')
                            <form action="{{ route('rides.complete', $ride) }}" method="POST" class="mt-8 relative z-10">
                                @csrf
                                <button class="w-full bg-success text-white py-5 rounded-[20px] font-black text-sm uppercase tracking-widest shadow-xl shadow-success/20 hover:opacity-90 transition">
                                    Complete Trip
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-[32px] border-2 border-dashed border-gray-200">
                        <div class="relative h-16 w-16 mb-6">
                            <div class="absolute inset-0 rounded-full bg-primary/10 animate-ping"></div>
                            <div class="relative h-16 w-16 bg-white rounded-full shadow-lg flex items-center justify-center text-primary">
                                <svg class="h-8 w-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>
                        <p class="text-xs font-black text-text-secondary uppercase tracking-widest text-center px-8">Finding the nearest driver for your route...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right: Tracking Map -->
    <div class="flex-1 relative bg-gray-100 z-10">
        <div id="live-map" class="absolute inset-0 h-full w-full"></div>
        
        <!-- Live Status Overlay -->
        <div class="absolute top-8 right-8 z-[1000] flex flex-col items-end gap-3">
            <div class="bg-white/90 backdrop-blur-xl px-6 py-4 rounded-3xl shadow-2xl border border-white/20 flex items-center gap-4 animate-in slide-in-from-right duration-700">
                <div class="relative h-3 w-3">
                    <div class="absolute inset-0 bg-red-500 rounded-full animate-ping"></div>
                    <div class="relative h-3 w-3 bg-red-600 rounded-full border-2 border-white"></div>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-text-primary">Live Tracking System</span>
            </div>

            <div class="bg-white/90 backdrop-blur-xl px-6 py-4 rounded-3xl shadow-2xl border border-white/20 flex items-center gap-4 animate-in slide-in-from-right duration-700 delay-100">
                <div class="h-10 w-10 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black uppercase tracking-widest text-text-secondary">Current Region</p>
                    <p class="text-sm font-black text-primary uppercase">Dodoma Central District</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #2F6B3F; border-radius: 10px; }
    .marker-pin {
        width: 30px; height: 30px; border-radius: 50% 50% 50% 0; position: absolute;
        transform: rotate(-45deg); left: 50%; top: 50%; margin: -15px 0 0 -15px;
        border: 4px solid white; box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .marker-pin::after {
        content: ''; width: 14px; height: 14px; margin: 4px 0 0 4px;
        background: white; position: absolute; border-radius: 50%;
    }
    .rider-marker {
        transition: all 1s linear;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pickup = [{{ $ride->pickup_lat }}, {{ $ride->pickup_lng }}];
        const dest = [{{ $ride->dest_lat }}, {{ $ride->dest_lng }}];
        
        const map = L.map('live-map', { zoomControl: false }).setView(pickup, 15);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png').addTo(map);

        const createMarkerIcon = (color) => L.divIcon({
            className: 'custom-marker',
            html: `<div class="marker-pin" style="background: ${color}"></div>`,
            iconSize: [30, 42],
            iconAnchor: [15, 42]
        });

        const riderIcon = L.divIcon({
            className: 'rider-marker',
            html: `<div class="p-3 bg-white rounded-3xl shadow-2xl border-2 border-primary flex items-center justify-center text-3xl relative">
                    <div class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full animate-ping"></div>
                    🛵
                  </div>`,
            iconSize: [60, 60],
            iconAnchor: [30, 30]
        });

        L.marker(pickup, { icon: createMarkerIcon('#22c55e') }).addTo(map).bindPopup("Pickup");
        L.marker(dest, { icon: createMarkerIcon('#2F6B3F') }).addTo(map).bindPopup("Destination");

        let riderMarker;
        const isRider = {{ (auth()->check() && auth()->user()->role === 'rider') ? 'true' : 'false' }};
        const status = "{{ $ride->status }}";

        function updateTracking() {
            if (isRider && (status === 'accepted' || status === 'ongoing')) {
                navigator.geolocation.getCurrentPosition(p => {
                    fetch("{{ route('location.update') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ lat: p.coords.latitude, lng: p.coords.longitude })
                    });
                });
            }

            fetch("{{ route('rides.location', $ride) }}")
                .then(res => res.json())
                .then(data => {
                    if (data.lat && data.lng) {
                        const pos = [data.lat, data.lng];
                        if (!riderMarker) {
                            riderMarker = L.marker(pos, { icon: riderIcon }).addTo(map);
                            map.flyTo(pos, 16);
                        } else {
                            riderMarker.setLatLng(pos);
                        }
                    if (data.status !== status) {
                        // Smoothly update UI instead of full reload if possible, 
                        // but for now we reload only when status changes to keep logic simple.
                        // However, we ensure location is updated WITHOUT reload.
                        window.location.reload();
                    }
                });
        }

        updateTracking();
        setInterval(updateTracking, 3000); // 3 seconds for smoother tracking
    });
</script>
@endpush
@endsection
