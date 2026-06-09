@extends('layouts.app')

@section('content')
<div class="py-24 honeycomb min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Header -->
        <div class="mb-12 animate-in fade-in slide-in-from-top duration-700">
            <div class="badge-pill mb-4">
                <span class="badge-dot"></span>
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Live Portal</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase leading-none">
                Habari, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-green">{{ explode(' ', auth()->user()->name)[0] }}!</span>
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile & Quick Stats -->
            <div class="space-y-8 animate-in fade-in slide-in-from-left duration-700 delay-100">
                <!-- Profile Card -->
                <div class="scn-card">
                    <div class="scn-card-header border-b border-slate-50 bg-slate-50/30">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="h-16 w-16 rounded-xl border-2 border-white shadow-md object-cover">
                                <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div>
                                <h2 class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ auth()->user()->name }}</h2>
                                <p class="text-[9px] font-bold text-primary uppercase tracking-widest mt-1">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="scn-card-content pt-6">
                        @if(auth()->user()->role === 'passenger')
                            <div class="space-y-3">
                                <a href="{{ route('rides.create') }}" class="btn-premium w-full !rounded-xl !py-4 flex items-center justify-center gap-2 !text-[11px] !font-black !tracking-widest">
                                    REQUEST A RIDE
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                                @if(!auth()->user()->rider)
                                    <a href="{{ route('rider.apply') }}" class="block w-full text-center py-3 border border-slate-200 text-slate-600 rounded-xl font-black text-[9px] uppercase tracking-widest hover:bg-slate-50 transition">
                                        Become a Rider
                                    </a>
                                @else
                                    <div class="p-3 bg-amber-50 border border-amber-100 text-amber-700 text-[9px] rounded-xl text-center font-black uppercase tracking-widest">
                                        Application Pending
                                    </div>
                                @endif
                            </div>
                        @elseif(auth()->user()->role === 'rider')
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100 text-center">
                                        <div class="text-[8px] text-slate-500 uppercase font-black tracking-widest mb-1">Earnings</div>
                                        <div class="text-base font-black text-primary">TZS {{ number_format($stats['total_earned']) }}</div>
                                    </div>
                                    <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100 text-center">
                                        <div class="text-[8px] text-slate-500 uppercase font-black tracking-widest mb-1">Rating</div>
                                        <div class="text-base font-black text-amber-500">{{ number_format($stats['avg_rating'], 1) }} ⭐</div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('rider.toggle') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-4 !rounded-xl !text-[10px] !font-black !uppercase !tracking-widest shadow-lg transition duration-300 {{ auth()->user()->rider->status === 'online' ? 'bg-rose-500 text-white shadow-rose-500/20' : 'bg-emerald-500 text-white shadow-emerald-500/20' }}">
                                        Go {{ auth()->user()->rider->status === 'online' ? 'Offline' : 'Online' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- App Download Card -->
                <div class="scn-card bg-primary group border-0 shadow-xl shadow-primary/20">
                    <div class="scn-card-header">
                        <h3 class="scn-card-title !text-white !font-black !uppercase !tracking-tight">Mobile App</h3>
                        <p class="text-white/70 text-[10px] font-medium leading-relaxed mt-1">Take BodaBoda everywhere with our upcoming mobile application.</p>
                    </div>
                    <div class="scn-card-content">
                        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-lg px-3 py-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                            <span class="text-[8px] font-black text-white uppercase tracking-widest">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Main Content -->
            <div class="lg:col-span-2 space-y-8 animate-in fade-in slide-in-from-right duration-700 delay-200">
                
                @if(auth()->user()->role === 'rider')
                    <!-- Rider Request Notifications -->
                    <div class="scn-card">
                        <div class="scn-card-header border-b border-slate-50 bg-slate-50/30">
                            <div class="flex items-center justify-between">
                                <h3 class="scn-card-title !text-sm !font-black !uppercase !tracking-tight">Active Requests</h3>
                                <div class="badge-pill !bg-emerald-50 !border-emerald-100">
                                    <span class="badge-dot !bg-emerald-500"></span>
                                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Listening</span>
                                </div>
                            </div>
                        </div>
                        <div class="scn-card-content p-0">
                            <div id="ride-requests-container">
                                <div class="text-center py-12 text-slate-400">
                                    <div class="h-16 w-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4">
                                        <i class="fas fa-bolt text-2xl animate-pulse"></i>
                                    </div>
                                    <p class="font-black uppercase tracking-widest text-[10px]">Searching for rides...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->role === 'passenger' && $activeRide)
                    <div class="scn-card border-l-4 border-primary">
                        <div class="scn-card-header border-b border-slate-50 bg-primary/5">
                            <div class="flex items-center justify-between">
                                <h3 class="scn-card-title !text-sm !font-black !uppercase !tracking-tight !text-primary">Active Ride</h3>
                                <div class="badge-pill !bg-primary/10 !border-primary/20">
                                    <span class="badge-dot !bg-primary"></span>
                                    <span class="text-[9px] font-black text-primary uppercase tracking-widest">Live</span>
                                </div>
                            </div>
                        </div>
                        <div class="scn-card-content">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="font-black text-slate-900 uppercase tracking-tight text-sm">Ride #{{ $activeRide->id }}</div>
                                    <div class="text-[10px] text-slate-500 mt-1">{{ $activeRide->status }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-black text-primary">TZS {{ number_format($activeRide->fare) }}</div>
                                </div>
                            </div>
                            @if($activeRide->rider)
                                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl mb-4">
                                    <img src="{{ $activeRide->rider->user->avatar }}" class="h-10 w-10 rounded-xl">
                                    <div>
                                        <div class="text-xs font-black text-slate-900">{{ $activeRide->rider->first_name }} {{ $activeRide->rider->last_name }}</div>
                                        <div class="text-[9px] text-slate-500">{{ $activeRide->rider->bike_plate }}</div>
                                    </div>
                                </div>
                            @endif
                            <a href="{{ route('rides.show', $activeRide) }}" class="block w-full text-center py-3 bg-primary text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-primary/90 transition">
                                View Ride
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Ride History -->
                <div class="scn-card">
                    <div class="scn-card-header border-b border-slate-50">
                        <div class="flex items-center justify-between">
                            <h3 class="scn-card-title !text-sm !font-black !uppercase !tracking-tight">Recent Activity</h3>
                            <a href="{{ route('rides.index') }}" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">View All</a>
                        </div>
                    </div>
                    <div class="scn-card-content p-0">
                        @if($recentRides->isEmpty())
                            <div class="text-center py-16 text-slate-400 italic">
                                <div class="text-3xl mb-3 opacity-20">🛵</div>
                                <p class="font-bold uppercase tracking-widest text-[10px]">No rides yet.</p>
                            </div>
                        @else
                            <div class="divide-y divide-slate-50">
                                @foreach($recentRides as $ride)
                                    <a href="{{ route('rides.show', $ride) }}" class="flex items-center justify-between p-5 hover:bg-slate-50/50 transition duration-300 group">
                                        <div class="flex items-center gap-4">
                                            <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 text-xl group-hover:bg-primary group-hover:text-white transition duration-500">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            <div>
                                                <div class="font-black text-slate-900 uppercase tracking-tight text-xs">Ride #{{ $ride->id }}</div>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-[9px] font-bold text-slate-400">{{ $ride->created_at->diffForHumans() }}</span>
                                                    <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                                                    <span class="text-[8px] font-black uppercase tracking-widest text-primary">{{ $ride->status }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-base font-black text-primary">TZS {{ number_format($ride->fare) }}</div>
                                            <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mt-1 group-hover:text-primary transition">Details →</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/mqtt@5.3.4/dist/mqtt.min.js"></script>
@if(auth()->user()->role === 'rider')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wsUrl = `ws://${window.location.hostname}:9001`;
    const container = document.getElementById('ride-requests-container');
    let pendingRequests = new Map();

    // Connect to Mosquitto via WebSocket with auth
    const mqttClient = mqtt.connect(wsUrl, {
        clientId: 'driver_dash_' + Math.random().toString(16).slice(2, 10),
        clean: false,
        username: '{{ config("mqtt.client_username", "app_client") }}',
        password: '{{ config("mqtt.client_password", "") }}',
    });

    mqttClient.on('connect', () => {
        mqttClient.subscribe('ride/request', { qos: 1 });
    });

    mqttClient.on('reconnect', () => {
        console.log('Reconnecting to MQTT broker...');
    });

    mqttClient.on('message', (topic, payload) => {
        try {
            const msg = JSON.parse(payload.toString());
            if (topic === 'ride/request') {
                addRideRequest(msg);
            }
        } catch (e) {
            console.error('MQTT message parse error:', e);
        }
    });

    function addRideRequest(msg) {
        if (pendingRequests.has(msg.ride_id)) return;
        pendingRequests.set(msg.ride_id, msg);

        if (container.querySelector('.no-requests')) {
            container.innerHTML = '';
        }

        const card = document.createElement('div');
        card.id = 'ride-' + msg.ride_id;
        card.className = 'border-l-4 border-primary bg-gradient-to-r from-primary/5 to-transparent p-6 rounded-xl mb-4 animate-in slide-in-from-right duration-500';
        card.innerHTML = `
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <img src="${msg.passenger.avatar}" class="h-12 w-12 rounded-full border-2 border-primary/20 mr-4">
                    <div>
                        <h4 class="font-black text-primary">${msg.passenger.name}</h4>
                        <p class="text-sm text-text-secondary">📞 ${msg.passenger.phone}</p>
                        <p class="text-xs text-text-secondary mt-1">Requested just now</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-black text-primary">TZS ${Number(msg.fare).toLocaleString()}</div>
                    <div class="text-xs text-text-secondary">${msg.distance} km</div>
                </div>
            </div>
            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 ring-4 ring-green-500/20"></div>
                    <div class="flex-1">
                        <p class="text-xs font-black text-text-secondary uppercase">Pickup</p>
                        <p class="text-sm font-bold">${msg.pickup.address}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="h-2.5 w-2.5 rounded-full bg-primary ring-4 ring-primary/20"></div>
                    <div class="flex-1">
                        <p class="text-xs font-black text-text-secondary uppercase">Destination</p>
                        <p class="text-sm font-bold">${msg.destination.address}</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="acceptRide(${msg.ride_id})" class="flex-1 px-4 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition shadow-lg shadow-primary/20">
                    Accept Ride
                </button>
                <button onclick="declineRide(${msg.ride_id})" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition">
                    Decline
                </button>
            </div>
        `;
        container.prepend(card);
        playNotificationSound();
    }

    function showNoRequests() {
        container.innerHTML = `
            <div class="no-requests text-center py-8 text-text-secondary">
                <div class="h-12 w-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">🛵</div>
                <p class="font-medium">Waiting for ride requests...</p>
                <p class="text-sm text-text-secondary mt-2">You'll receive notifications when passengers request rides</p>
            </div>
        `;
    }

    // Initial load of existing pending requests
    fetch('/api/ride-requests')
        .then(r => r.json())
        .then(data => {
            if (data.requests && data.requests.length > 0) {
                data.requests.forEach(r => {
                    if (!pendingRequests.has(r.id)) {
                        pendingRequests.set(r.id, r);
                        addRideRequest({
                            ride_id: r.id,
                            passenger: r.user,
                            pickup: { address: r.pickup_address },
                            destination: { address: r.dest_address },
                            fare: r.fare,
                            distance: r.distance,
                        });
                    }
                });
            } else {
                showNoRequests();
            }
        })
        .catch(() => showNoRequests());

    window.acceptRide = function(rideId) {
        fetch(`/rides/${rideId}/accept`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `/rides/${rideId}`;
            } else {
                alert(data.message || 'Unable to accept ride.');
            }
        })
        .catch(error => {
            console.error('Error accepting ride:', error);
            alert('Error accepting ride. Please try again.');
        });
    };

    window.declineRide = function(rideId) {
        if (confirm('Decline this ride request?')) {
            fetch(`/rides/${rideId}/decline`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = document.getElementById('ride-' + rideId);
                    if (card) card.remove();
                    pendingRequests.delete(rideId);
                    if (pendingRequests.size === 0) showNoRequests();
                }
            })
            .catch(error => {
                console.error('Error declining ride:', error);
            });
        }
    };

    function playNotificationSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.frequency.value = 800;
            osc.type = 'sine';
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.5);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.5);
        } catch(e) {}
    }
});
</script>
@endif
@endpush
