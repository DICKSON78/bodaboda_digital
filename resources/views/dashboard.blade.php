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

                <!-- Ride History -->
                <div class="scn-card">
                    <div class="scn-card-header border-b border-slate-50">
                        <div class="flex items-center justify-between">
                            <h3 class="scn-card-title !text-sm !font-black !uppercase !tracking-tight">Recent Activity</h3>
                            <a href="#" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">View All</a>
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
@if(auth()->user()->role === 'rider')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for new ride requests every 5 seconds
    let requestInterval = setInterval(checkRideRequests, 5000);
    
    function checkRideRequests() {
        fetch('/api/ride-requests')
            .then(response => response.json())
            .then(data => {
                if (data.requests && data.requests.length > 0) {
                    displayRideRequests(data.requests);
                } else {
                    showNoRequests();
                }
            })
            .catch(error => {
                console.error('Error checking ride requests:', error);
            });
    }
    
    function displayRideRequests(requests) {
        const container = document.getElementById('ride-requests-container');
        
        const requestsHtml = requests.map(request => `
            <div class="border-l-4 border-primary bg-gradient-to-r from-primary/5 to-transparent p-6 rounded-xl mb-4 animate-in slide-in-from-right duration-500">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <img src="${request.user.avatar}" class="h-12 w-12 rounded-full border-2 border-primary/20 mr-4">
                        <div>
                            <h4 class="font-black text-primary">${request.user.name}</h4>
                            <p class="text-sm text-text-secondary">📞 ${request.user.phone}</p>
                            <p class="text-xs text-text-secondary mt-1">Requested ${request.created_at}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-black text-primary">TZS ${request.fare}</div>
                        <div class="text-xs text-text-secondary">${request.distance} km</div>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 ring-4 ring-green-500/20"></div>
                        <div class="flex-1">
                            <p class="text-xs font-black text-text-secondary uppercase">Pickup</p>
                            <p class="text-sm font-bold">${request.pickup_address}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-2.5 w-2.5 rounded-full bg-primary ring-4 ring-primary/20"></div>
                        <div class="flex-1">
                            <p class="text-xs font-black text-text-secondary uppercase">Destination</p>
                            <p class="text-sm font-bold">${request.dest_address}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="acceptRide(${request.id})" class="flex-1 px-4 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition shadow-lg shadow-primary/20">
                        Accept Ride
                    </button>
                    <button onclick="declineRide(${request.id})" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition">
                        Decline
                    </button>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = requestsHtml;
        
        // Play notification sound (if available)
        playNotificationSound();
    }
    
    function showNoRequests() {
        const container = document.getElementById('ride-requests-container');
        container.innerHTML = `
            <div class="text-center py-8 text-text-secondary">
                <div class="h-12 w-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                    🛵
                </div>
                <p class="font-medium">Waiting for ride requests...</p>
                <p class="text-sm text-text-secondary mt-2">You'll receive notifications when passengers request rides</p>
            </div>
        `;
    }
    
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
                // Redirect to ride tracking page
                window.location.href = `/rides/${rideId}`;
            } else {
                alert('Unable to accept ride. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error accepting ride:', error);
            alert('Error accepting ride. Please try again.');
        });
    };
    
    window.declineRide = function(rideId) {
        if (confirm('Are you sure you want to decline this ride request?')) {
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
                    // Remove the request from display
                    checkRideRequests();
                }
            })
            .catch(error => {
                console.error('Error declining ride:', error);
            });
        }
    };
    
    function playNotificationSound() {
        // Create a simple beep sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    }
    
    // Initial check
    checkRideRequests();
});
</script>
@endif
@endpush
