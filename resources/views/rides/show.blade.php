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
                            <p class="text-sm font-bold text-text-primary">{{ $ride->pickup_address ?? 'Location A (' . round($ride->pickup_lat, 4) . ', ' . round($ride->pickup_lng, 4) . ')' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest mb-1">Destination</p>
                            <p class="text-sm font-bold text-text-primary">{{ $ride->destination_address ?? 'Location B (' . round($ride->dest_lat, 4) . ', ' . round($ride->dest_lng, 4) . ')' }}</p>
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
                <div id="rider-card-content">
                    @if($ride->rider)
                        <div class="driver-card p-6 bg-gray-50 rounded-[32px] border border-gray-100 relative overflow-hidden group">
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
                            @if(auth()->check() && auth()->user()->role === 'rider' && $ride->status === 'accepted')
                                <form action="{{ route('rides.start', $ride) }}" method="POST" class="ride-action-btn mt-8 relative z-10">
                                    @csrf
                                    <button class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 group">Start Trip Now</button>
                                </form>
                            @endif
                            @if(auth()->check() && auth()->user()->role === 'rider' && $ride->status === 'ongoing')
                                <form action="{{ route('rides.complete', $ride) }}" method="POST" class="ride-action-btn mt-8 relative z-10">
                                    @csrf
                                    <button class="w-full bg-success text-white py-5 rounded-[20px] font-black text-sm uppercase tracking-widest shadow-xl shadow-success/20 hover:opacity-90 transition">Complete Trip</button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="waiting-for-driver flex flex-col items-center justify-center py-16 bg-gray-50 rounded-[32px] border-2 border-dashed border-gray-200">
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

            <!-- Passenger Actions -->
            @if(auth()->check() && auth()->user()->role === 'passenger' && $ride->passenger_id === auth()->id())
                @if($ride->status === 'requested')
                    <div class="mt-8">
                        <form action="{{ route('rides.cancel', $ride) }}" method="POST">
                            @csrf
                            <button class="w-full py-4 bg-red-500 text-white rounded-[20px] font-black text-sm uppercase tracking-widest shadow-xl shadow-red-500/20 hover:opacity-90 transition">
                                Cancel Ride
                            </button>
                        </form>
                    </div>
                @endif

                @if($ride->status === 'completed')
                    <div class="mt-8 p-6 bg-gray-50 rounded-[32px] border border-gray-100">
                        <h3 class="text-xs font-black text-primary uppercase tracking-widest mb-6">Trip Receipt</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Base Fare</span>
                                <span class="text-sm font-bold text-text-primary">TZS {{ number_format($ride->fare * 0.8) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Service Fee</span>
                                <span class="text-sm font-bold text-text-primary">TZS {{ number_format($ride->fare * 0.2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                                <span class="text-xs font-black text-primary uppercase tracking-widest">Total</span>
                                <span class="text-2xl font-black text-primary">TZS {{ number_format($ride->fare) }}</span>
                            </div>
                            @if($ride->distance)
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Distance</span>
                                    <span class="text-sm font-bold text-text-primary">{{ number_format($ride->distance, 1) }} km</span>
                                </div>
                            @endif
                            @if($ride->trip_started_at && $ride->trip_completed_at)
                                @php
                                    $duration = $ride->trip_started_at->diffInMinutes($ride->trip_completed_at);
                                @endphp
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Duration</span>
                                    <span class="text-sm font-bold text-text-primary">{{ $duration }} mins</span>
                                </div>
                            @endif
                        </div>
                        @php
                            $hasRated = $ride->ratings()->where('from_user_id', auth()->id())->exists();
                        @endphp
                        @if(!$hasRated)
                            <a href="{{ route('ratings.create', $ride) }}" class="block w-full text-center mt-6 py-4 bg-accent text-white rounded-[20px] font-black text-sm uppercase tracking-widest shadow-xl shadow-accent/20 hover:opacity-90 transition">
                                Rate This Ride
                            </a>
                        @else
                            <div class="mt-6 p-4 bg-white rounded-2xl text-center">
                                <p class="text-[10px] font-black text-success uppercase tracking-widest">✓ Thank you for your feedback!</p>
                            </div>
                        @endif
                    </div>
                @endif
            @endif

            @if(auth()->check() && auth()->user()->role === 'rider' && $ride->status === 'completed' && $ride->rider && $ride->rider->user_id === auth()->id())
                @php
                    $hasRated = $ride->ratings()->where('from_user_id', auth()->id())->exists();
                @endphp
                @if(!$hasRated)
                    <div class="mt-8">
                        <a href="{{ route('ratings.create', $ride) }}" class="block w-full text-center py-4 bg-accent text-white rounded-[20px] font-black text-sm uppercase tracking-widest shadow-xl shadow-accent/20 hover:opacity-90 transition">
                            Rate Passenger
                        </a>
                    </div>
                @endif
            @endif
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
<script src="https://unpkg.com/mqtt@5.3.4/dist/mqtt.min.js"></script>
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
    .rider-marker { transition: all 1s linear; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickup = [{{ $ride->pickup_lat }}, {{ $ride->pickup_lng }}];
    const dest = [{{ $ride->dest_lat }}, {{ $ride->dest_lng }}];
    const rideId = {{ $ride->id }};
    const rideToken = '{{ $ride->ride_token }}';
    const statusTopic = 'ride/status/' + rideId + '/' + rideToken;
    const locTopic = 'driver/location/';
    @php $riderId = $ride->rider ? $ride->rider->id : 'null'; @endphp
    let currentRiderId = {{ $riderId }};

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

    let riderMarker = null;
    let gpsInterval = null;
    const isRider = {{ (auth()->check() && auth()->user()->role === 'rider') ? 'true' : 'false' }};
    const isPassenger = {{ (auth()->check() && auth()->user()->role === 'passenger' && $ride->passenger_id === auth()->id()) ? 'true' : 'false' }};
    const statusBadge = document.getElementById('status-badge');
    const riderCard = document.getElementById('rider-card');
    const riderCardContent = document.getElementById('rider-card-content');

    // --- MQTT WebSocket Connection (authenticated, token-protected topics) ---
    const wsUrl = `ws://${window.location.hostname}:9001`;
    const mqttClient = mqtt.connect(wsUrl, {
        clientId: (isRider ? 'driver' : 'passenger') + '_' + rideId + '_' + Math.random().toString(16).slice(2, 8),
        clean: false,
        username: '{{ config("mqtt.client_username", "app_client") }}',
        password: '{{ config("mqtt.client_password", "") }}',
    });

    mqttClient.on('connect', () => {
        mqttClient.subscribe(statusTopic, { qos: 1 });
        if (currentRiderId) {
            mqttClient.subscribe(locTopic + currentRiderId, { qos: 1 });
        }
    });

    mqttClient.on('message', (topic, payload) => {
        try {
            const msg = JSON.parse(payload.toString());

            if (topic === statusTopic) {
                handleStatusUpdate(msg);
            }

            if (currentRiderId && topic === locTopic + currentRiderId) {
                if (msg.lat && msg.lng) {
                    const pos = [msg.lat, msg.lng];
                    if (!riderMarker) {
                        riderMarker = L.marker(pos, { icon: riderIcon }).addTo(map);
                        map.flyTo(pos, 16);
                    } else {
                        riderMarker.setLatLng(pos);
                    }
                }
            }
        } catch (e) {
            console.error('MQTT parse error:', e);
        }
    });

    function handleStatusUpdate(msg) {
        updateStatusBadge(msg.status);

        if (msg.status === 'accepted' && msg.driver) {
            if (!currentRiderId) {
                currentRiderId = msg.driver.id;
                mqttClient.subscribe('driver/location/' + msg.driver.id);
            }
            renderRiderCard(msg.driver);
            if (isRider) {
                showActionButton('start');
            }
        }

        if (msg.status === 'ongoing') {
            if (isRider) {
                showActionButton('complete');
            }
        }

        if (msg.status === 'completed') {
            if (isPassenger) {
                setTimeout(() => window.location.reload(), 1000);
            }
            if (isRider) {
                showActionButton('none');
            }
            stopGpsTracking();
        }

        if (msg.status === 'cancelled') {
            window.location.href = '/dashboard';
        }
    }

    function updateStatusBadge(status) {
        if (!statusBadge) return;
        statusBadge.textContent = status.toUpperCase();
        statusBadge.className = 'px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest ' +
            (status === 'requested' ? 'bg-yellow-100 text-yellow-700' :
            status === 'accepted' ? 'bg-blue-100 text-blue-700' :
            status === 'ongoing' ? 'bg-primary/10 text-primary' :
            status === 'completed' ? 'bg-success/10 text-success' : 'bg-gray-100 text-gray-700');
    }

    function renderRiderCard(driver) {
        if (!riderCard) return;
        const waitingEl = riderCard.querySelector('.waiting-for-driver');
        if (waitingEl) waitingEl.remove();

        const existing = riderCard.querySelector('.driver-card');
        if (existing) existing.remove();

        const card = document.createElement('div');
        card.className = 'driver-card p-6 bg-gray-50 rounded-[32px] border border-gray-100 relative overflow-hidden group';
        card.innerHTML = `
            <div class="flex items-center gap-6 relative z-10">
                <div class="relative">
                    <img src="${driver.avatar}" class="h-20 w-20 rounded-[28px] border-4 border-white shadow-xl">
                    <div class="absolute -bottom-1 -right-1 h-8 w-8 bg-success rounded-full border-4 border-white flex items-center justify-center text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xl font-black text-text-primary tracking-tighter uppercase leading-none">${driver.first_name} ${driver.last_name}</h4>
                    <p class="text-[10px] font-black text-primary uppercase tracking-widest">Certified Rider</p>
                    <div class="flex items-center gap-2 mt-2">
                        <a href="tel:${driver.phone}" class="px-4 py-2 bg-white rounded-xl shadow-sm text-[10px] font-black text-primary uppercase hover:bg-primary hover:text-white transition">Call Rider</a>
                    </div>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-4 relative z-10">
                <div class="p-4 bg-white rounded-2xl shadow-sm">
                    <p class="text-[8px] font-black text-text-secondary uppercase tracking-widest mb-1">Plate Number</p>
                    <p class="text-xs font-bold text-text-primary uppercase">${driver.bike_plate}</p>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-sm">
                    <p class="text-[8px] font-black text-text-secondary uppercase tracking-widest mb-1">License</p>
                    <p class="text-xs font-bold text-text-primary uppercase">${driver.license_number ? driver.license_number.slice(0, 8) + '...' : 'N/A'}</p>
                </div>
            </div>
        `;
        riderCard.appendChild(card);
    }

    function showActionButton(action) {
        document.querySelectorAll('.ride-action-btn').forEach(el => el.remove());

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (action === 'start') {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/rides/' + rideId + '/start';
            form.className = 'ride-action-btn mt-8 relative z-10';
            form.innerHTML = '<input type="hidden" name="_token" value="' + csrf + '"><button class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 group">Start Trip Now</button>';
            document.querySelector('.driver-card')?.appendChild(form);
        }

        if (action === 'complete') {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/rides/' + rideId + '/complete';
            form.className = 'ride-action-btn mt-8 relative z-10';
            form.innerHTML = '<input type="hidden" name="_token" value="' + csrf + '"><button class="w-full bg-success text-white py-5 rounded-[20px] font-black text-sm uppercase tracking-widest shadow-xl shadow-success/20 hover:opacity-90 transition">Complete Trip</button>';
            document.querySelector('.driver-card')?.appendChild(form);
        }
    }

    // GPS Tracking for riders with watchdog & wake-lock
    let gpsFailCount = 0;
    let wakeLock = null;

    async function requestWakeLock() {
        try {
            if ('wakeLock' in navigator) {
                wakeLock = await navigator.wakeLock.request('screen');
                wakeLock.addEventListener('release', () => { wakeLock = null; });
            }
        } catch(e) { /* wake-lock not supported */ }
    }

    function sendLocation(lat, lng) {
        if (navigator.sendBeacon) {
            const blob = new Blob([JSON.stringify({ lat, lng })], { type: 'application/json' });
            navigator.sendBeacon("{{ route('location.update') }}?_token={{ csrf_token() }}", blob);
        } else {
            fetch("{{ route('location.update') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ lat, lng })
            });
        }
    }

    function getPositionWithFallback() {
        navigator.geolocation.getCurrentPosition(
            p => {
                gpsFailCount = 0;
                sendLocation(p.coords.latitude, p.coords.longitude);
            },
            err => {
                gpsFailCount++;
                console.warn('GPS error (' + gpsFailCount + '):', err.message);
                // Fallback: use last known position from map center
                if (gpsFailCount >= 5 && map) {
                    const center = map.getCenter();
                    sendLocation(center.lat, center.lng);
                    gpsFailCount = 0;
                }
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 5000 }
        );
    }

    function startGpsTracking() {
        if (gpsInterval) return;
        requestWakeLock();
        getPositionWithFallback();
        gpsInterval = setInterval(getPositionWithFallback, 5000);
    }

    function stopGpsTracking() {
        if (gpsInterval) {
            clearInterval(gpsInterval);
            gpsInterval = null;
        }
        if (wakeLock) {
            wakeLock.release().catch(() => {});
            wakeLock = null;
        }
    }

    // Start GPS if rider with active ride
    if (isRider && currentRiderId && ("{{ $ride->status }}" === 'accepted' || "{{ $ride->status }}" === 'ongoing')) {
        startGpsTracking();
    }
});
</script>
@endpush
@endsection
