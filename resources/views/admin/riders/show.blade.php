@extends('layouts.admin-kkk')

@section('title', 'Maelezo ya Wapandaaji - BodaBoda Admin Panel')
@section('page-title', 'Maelezo ya Wapandaaji')
@section('page-subtitle', 'Ona maudhui ya wapandaaji na takwimu zake')

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex items-center space-x-2 text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.riders') }}" class="hover:text-primary">Wapandaaji</a>
        <span>/</span>
        <span class="text-primary font-medium">{{ $rider->user->name }}</span>
    </nav>
</div>

<!-- Rider Profile Header -->
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6 md:mb-8">
    <div class="bg-gradient-to-r from-primary to-secondary-green p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4 md:space-x-6">
                <img src="{{ $rider->user->avatar }}" class="h-20 w-20 md:h-24 md:w-24 rounded-2xl border-4 border-white shadow-xl">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight mb-2">{{ $rider->user->name }}</h1>
                    <p class="text-white/80 text-sm font-medium mb-1">{{ $rider->user->email }}</p>
                    <p class="text-white/80 text-sm font-medium">{{ $rider->phone_number }}</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-3">
                @if($rider->is_approved)
                    @if($rider->status === 'online')
                        <span class="px-4 py-2 bg-white/20 text-white text-sm font-bold rounded-full">Anaendesha</span>
                    @elseif($rider->status === 'offline')
                        <span class="px-4 py-2 bg-white/20 text-white text-sm font-bold rounded-full">Haendi</span>
                    @else
                        <span class="px-4 py-2 bg-error/20 text-white text-sm font-bold rounded-full">Amezuiwa</span>
                    @endif
                @else
                    <span class="px-4 py-2 bg-warning/20 text-white text-sm font-bold rounded-full">Anasubiri</span>
                @endif
                <a href="{{ route('admin.riders.edit', $rider) }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 text-white text-sm font-bold rounded-full transition">
                    <i class="fas fa-edit mr-2"></i>
                    Hariri Maelezo
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
    <!-- Rider Information -->
    <div class="lg:col-span-1">
        <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas fa-user text-primary mr-2"></i>
                Maelezo ya Wapandaaji
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Jina Kamili</p>
                    <p class="text-gray-900 font-semibold">{{ $rider->first_name }} {{ $rider->last_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Anwani ya Simu</p>
                    <p class="text-gray-900">{{ $rider->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Namba ya Simu</p>
                    <p class="text-gray-900">{{ $rider->phone_number }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Namba ya Leseni</p>
                    <p class="text-gray-900 font-mono">{{ $rider->license_number }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Namba ya Baiskeli</p>
                    <p class="text-gray-900 font-mono">{{ $rider->bike_plate }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Hali</p>
                    @if($rider->status === 'online')
                        <span class="px-3 py-1 bg-success/10 text-success text-xs font-bold rounded-full">Anaendesha</span>
                    @elseif($rider->status === 'offline')
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Haendi</span>
                    @else
                        <span class="px-3 py-1 bg-error/10 text-error text-xs font-bold rounded-full">Amezuiwa</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Hali ya Idhini</p>
                    @if($rider->is_approved)
                        <span class="px-3 py-1 bg-success/10 text-success text-xs font-bold rounded-full">Imeidhinishwa</span>
                    @else
                        <span class="px-3 py-1 bg-warning/10 text-warning text-xs font-bold rounded-full">Anasubiri</span>
                    @endif
                </div>
                @if($rider->bike_image)
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wider mb-1">Picha ya Pikipa</p>
                    <img src="{{ asset('storage/' . $rider->bike_image) }}" class="w-full rounded-lg">
                </div>
                @endif
            </div>
        </div>

        <!-- Performance Stats -->
        <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas fa-chart-line text-primary mr-2"></i>
                Takwimu za Utendaji
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Jumla ya Safiri</span>
                    <span class="text-lg font-bold text-primary">{{ $stats['total_rides'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Zimekamilika</span>
                    <span class="text-lg font-bold text-success">{{ $stats['completed_rides'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Zimeghairishwa</span>
                    <span class="text-lg font-bold text-error">{{ $stats['cancelled_rides'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Mapato Jumla</span>
                    <span class="text-lg font-bold text-accent">TZS {{ number_format($stats['total_earnings'], 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Wastani wa Kati</span>
                    <div class="flex items-center">
                        <span class="text-lg font-bold text-warning">{{ number_format($stats['average_rating'], 1) }}</span>
                        <i class="fas fa-star text-warning ml-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Rides -->
    <div class="lg:col-span-2">
        <div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="p-4 md:p-6 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-700 flex items-center">
                    <i class="fas fa-motorcycle text-primary mr-2"></i>
                    Safiri Mpya
                </h3>
            </div>
            <div class="p-4 md:p-6">
                @if($rider->rides->isEmpty())
                    <div class="text-center py-8">
                        <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                            <i class="fas fa-motorcycle text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Hakuna Safiri Mpya</h4>
                        <p class="text-gray-600">Wapandaaji huyu hajafanya safiri yoyote bado.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($rider->rides as $ride)
                            <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-motorcycle text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Safiri #{{ $ride->id }}</p>
                                            <p class="text-sm text-gray-600">{{ $ride->created_at->format('M d, Y - h:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($ride->status === 'completed')
                                            <span class="px-3 py-1 bg-success/10 text-success text-xs font-bold rounded-lg">Imekamilika</span>
                                            <p class="text-sm font-bold text-primary mt-1">TZS {{ number_format($ride->fare, 0) }}</p>
                                        @elseif($ride->status === 'cancelled')
                                            <span class="px-3 py-1 bg-error/10 text-error text-xs font-bold rounded-lg">Imeghairishwa</span>
                                        @else
                                            <span class="px-3 py-1 bg-warning/10 text-warning text-xs font-bold rounded-lg">{{ ucfirst($ride->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if($ride->pickup_address && $ride->dropoff_address)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <div class="flex items-center text-sm text-gray-600 mb-1">
                                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                        {{ $ride->pickup_address }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-flag-checkered text-error mr-2"></i>
                                        {{ $ride->dropoff_address }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mt-6 md:mt-8">
            <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas fa-bolt text-primary mr-2"></i>
                Vitendo Vya Haraka
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(!$rider->is_approved)
                    <form action="{{ route('admin.rider.approve', $rider) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary w-full">
                            <i class="fas fa-check mr-2"></i>
                            Idhinishi Wapandaaji
                        </button>
                    </form>
                    <form action="{{ route('admin.rider.reject', $rider) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-error text-white px-4 py-3 rounded-xl text-sm font-bold w-full">
                            <i class="fas fa-times mr-2"></i>
                            Kata Maombi
                        </button>
                    </form>
                @else
                    @if($rider->status === 'suspended')
                        <form action="{{ route('admin.rider.activate', $rider) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary w-full">
                                <i class="fas fa-check-circle mr-2"></i>
                                Wezesha Wapandaaji
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.rider.suspend', $rider) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-warning text-white px-4 py-3 rounded-xl text-sm font-bold w-full">
                                <i class="fas fa-pause-circle mr-2"></i>
                                Zuiwe Wapandaaji
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.riders.edit', $rider) }}" class="btn-outline w-full text-center">
                        <i class="fas fa-edit mr-2"></i>
                        Hariri Maelezo
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
