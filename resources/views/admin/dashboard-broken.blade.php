@extends('layouts.admin')

@section('title', 'Dashboard - BodaBoda Admin Panel')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Manage riders and track performance')

@section('content')
@php
// Helper function to format money with M, B, K
function formatMoney($amount) {
    if ($amount >= 1000000000) { // Billions
        return number_format($amount / 1000000000, 2) . 'B';
    } elseif ($amount >= 1000000) { // Millions
        return number_format($amount / 1000000, 2) . 'M';
    } elseif ($amount >= 1000) { // Thousands
        return number_format($amount / 1000, 1) . 'K';
    } else {
        return number_format($amount, 0);
    }
}
@endphp
<!-- Stats Cards -->
<div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Jumla ya Wapandaaji</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ number_format($totalRiders) }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-green-600 mr-1"><i class="fas fa-users"></i></span>
                    <span>{{ number_format($approvedRiders) }} wamekazwa</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-primary-100 flex items-center justify-center">
                <i class="fas fa-users text-primary-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Mapato ya Mwezi</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ formatMoney($monthlyIncome ?? 0) }} TSh</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-green-600 mr-1"><i class="fas fa-arrow-up"></i></span>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <i class="fas fa-hand-holding-usd text-green-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Matukio Yanayokuja</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ count($upcomingEvents ?? 0) }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-blue-500 mr-1"><i class="fas fa-calendar-alt"></i></span>
                    <span>Yaliyopangwa</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-blue-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Maombi ya Fedha</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-yellow-600">{{ $pendingRiders->count() }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-orange-500 mr-1"><i class="fas fa-clock"></i></span>
                    <span>Yanasubiri</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-secondary-100 flex items-center justify-center">
                <i class="fas fa-paper-plane text-secondary-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Safiri Zilizotwa</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ $totalRides }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-blue-500 mr-1"><i class="fas fa-motorcycle"></i></span>
                    <span>{{ $completedRides }} zimekamilika</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-accent-100 flex items-center justify-center">
                <i class="fas fa-motorcycle text-accent text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-6 md:mb-8">
    <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
        <i class="fas fa-bolt text-primary-500 mr-2"></i> Vitendo Vya Haraka
    </h3>
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
        <!-- Add Rider -->
        <a href="{{ route('admin.riders') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-primary-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-user-plus text-primary-500 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Ongeza Wapandaaji</h4>
                    <p class="text-xs text-gray-500 mt-1">Ongeza wapandaaji wapya</p>
                </div>
            </div>
        </a>

        <!-- View Analytics -->
        <a href="{{ route('admin.analytics') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-accent-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-chart-bar text-accent text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Takwimu</h4>
                    <p class="text-xs text-gray-500 mt-1">Ona takwimu za biashara</p>
                </div>
            </div>
        </a>

        <!-- Reports -->
        <a href="#" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-secondary-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-file-alt text-secondary-500 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Ripoti</h4>
                    <p class="text-xs text-gray-500 mt-1">Pakua ripoti za biashara</p>
                </div>
            </div>
        </a>

        <!-- Settings -->
        <a href="#" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-cog text-gray-600 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Mipangilio</h4>
                    <p class="text-xs text-gray-500 mt-1">Dhibiti mipangilio ya mfumo</p>
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
                <i class="fas fa-user-plus text-primary-500 mr-2"></i>
                Maombi Mpya
            </h3>
        </div>
        <div class="p-4 md:p-6">
            @if($recentApplications->isEmpty())
                <div class="text-center py-8">
                    <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Hakuna Maombi Mpya</h4>
                    <p class="text-gray-500">Hakuna maombi mapya ya wapandaaji</p>
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
                                    <span class="px-2 py-1 bg-success-10 text-success text-xs font-bold rounded-lg">Wamekazwa</span>
                                @else
                                    <span class="px-2 py-1 bg-warning-10 text-warning text-xs font-bold rounded-lg">Anasubiri</span>
                                @endif
                                <a href="{{ route('admin.riders.show', $rider) }}" class="text-primary hover:text-primary-80">
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
                <i class="fas fa-motorcycle text-primary-500 mr-2"></i>
                Safiri Mpya
            </h3>
        </div>
        <div class="p-4 md:p-6">
            @if($recentRides->isEmpty())
                <div class="text-center py-8">
                    <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                        <i class="fas fa-motorcycle text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Hakuna Safiri Mpya</h4>
                    <p class="text-gray-500">Hakuna safiri zilizotwa hivi punde</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentRides as $ride)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-motorcycle text-primary text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">Safiri #{{ $ride->id }}</p>
                                    <p class="text-xs text-gray-500">{{ $ride->created_at->format('M d, Y - h:i A') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($ride->status === 'completed')
                                    <span class="px-2 py-1 bg-success-10 text-success text-xs font-bold rounded-lg">Imekamilika</span>
                                    <p class="text-sm font-bold text-primary mt-1">TZS {{ number_format($ride->fare, 0) }}</p>
                                @elseif($ride->status === 'cancelled')
                                    <span class="px-2 py-1 bg-error-10 text-error text-xs font-bold rounded-lg">Imeghairishwa</span>
                                @else
                                    <span class="px-2 py-1 bg-warning-10 text-warning text-xs font-bold rounded-lg">{{ ucfirst($ride->status) }}</span>
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
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
    <div class="bg-gradient-to-r from-primary to-secondary-green p-6 md:p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight mb-2">Maombi Yanayosubiri</h2>
                <p class="text-white/80 text-sm">{{ $pendingRiders->count() }} wapandaaji wanasubiri</p>
            </div>
            <div class="h-14 w-14 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
    </div>
    
    @if($pendingRiders->isEmpty())
        <div class="p-12 md:p-16 text-center">
            <div class="h-16 w-16 bg-success-10 rounded-2xl flex items-center justify-center text-success mx-auto mb-6">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Yote Yamekazwa!</h3>
            <p class="text-gray-500">Hakuna maombi yanayosubiri</p>
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
                                            <span class="font-medium">Leseni:</span> {{ $rider->license_number }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-motorcycle text-primary mr-2"></i>
                                            <span class="font-medium">Namba ya Baiskeli:</span> {{ $rider->bike_plate }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-3">
                                <form action="{{ route('admin.rider.approve', $rider) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-primary px-4 md:px-6 py-2 md:py-3 text-xs uppercase tracking-wider shadow-lg shadow-success-20 hover:shadow-success-30 group">
                                        <i class="fas fa-check mr-2 group-hover:scale-110 transition"></i>
                                        Idhinishi
                                    </button>
                                </form>
                                <form action="{{ route('admin.rider.reject', $rider) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-error text-white px-4 md:px-6 py-2 md:py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-error-20 hover:bg-error/90 hover:shadow-error/30 transition group">
                                        <i class="fas fa-times mr-2 group-hover:scale-110 transition"></i>
                                        Kata
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
