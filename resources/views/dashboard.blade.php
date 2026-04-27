@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center mb-6">
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="h-16 w-16 rounded-full border-2 border-primary/20">
                    <div class="ml-4">
                        <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
                
                @if(auth()->user()->role === 'passenger')
                    <div class="space-y-4">
                        <a href="{{ route('rides.create') }}" class="block w-full text-center py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-dark transition">
                            Request a Ride
                        </a>
                        @if(!auth()->user()->rider)
                            <a href="{{ route('rider.apply') }}" class="block w-full text-center py-3 border border-primary text-primary rounded-lg font-semibold hover:bg-primary/5 transition">
                                Apply to be a Rider
                            </a>
                        @else
                            <div class="p-3 bg-yellow-50 text-yellow-700 text-sm rounded-lg text-center font-medium">
                                Rider Application Pending
                            </div>
                        @endif
                    </div>
                @elseif(auth()->user()->role === 'rider')
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-3 bg-gray-50 rounded-lg text-center">
                                <div class="text-xs text-text-secondary uppercase font-bold">Earnings</div>
                                <div class="text-lg font-bold text-primary">TZS {{ number_format($stats['total_earned']) }}</div>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg text-center">
                                <div class="text-xs text-text-secondary uppercase font-bold">Rating</div>
                                <div class="text-lg font-bold text-accent">{{ number_format($stats['avg_rating'], 1) }} ⭐</div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium">Status</span>
                            <span class="text-{{ auth()->user()->rider->status === 'online' ? 'success' : 'text-secondary' }} font-bold uppercase">
                                {{ auth()->user()->rider->status }}
                            </span>
                        </div>
                        <form action="{{ route('rider.toggle') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 {{ auth()->user()->rider->status === 'online' ? 'bg-error' : 'bg-success' }} text-white rounded-lg font-semibold hover:opacity-90 transition">
                                Go {{ auth()->user()->rider->status === 'online' ? 'Offline' : 'Online' }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Rider Request Notifications -->
            @if(auth()->user()->role === 'rider')
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4">Ride Requests</h3>
                    <div id="ride-requests-container">
                        <div class="text-center py-8 text-text-secondary">
                            <div class="h-12 w-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                                🛵
                            </div>
                            <p class="font-medium">Waiting for ride requests...</p>
                            <p class="text-sm text-text-secondary mt-2">You'll receive notifications when passengers request rides</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Ride History -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
                    
                    @if($recentRides->isEmpty())
                        <div class="text-center py-12 text-text-secondary italic">
                            No recent rides found.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($recentRides as $ride)
                                <a href="{{ route('rides.show', $ride) }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-4 text-xl">
                                            🛵
                                        </div>
                                        <div>
                                            <div class="font-bold">Ride #{{ $ride->id }}</div>
                                            <div class="text-xs text-text-secondary">{{ $ride->created_at->diffForHumans() }} • {{ $ride->status }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-primary">TZS {{ number_format($ride->fare) }}</div>
                                        <div class="text-xs text-text-secondary">View Details →</div>
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
