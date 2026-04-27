@extends('layouts.admin-kkk')

@section('title', 'Takwimu - BodaBoda Admin Panel')
@section('page-title', 'Takwimu')
@section('page-subtitle', 'Ona takwimu za biashara na utendaji')

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
<!-- Analytics Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Jumla ya Safiri</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ formatMoney($monthlyRides->sum('count') ?? 0) }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500">Miezi 12 iliyopita</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-primary-100 flex items-center justify-center">
                <i class="fas fa-motorcycle text-primary text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Mapato ya Mwezi</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ formatMoney($topPerformers->sum('total_earnings') ?? 0) }} TSh</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-success-100 flex items-center justify-center">
                <i class="fas fa-hand-holding-usd text-success text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Wapandaji Wanaofanya Kazi</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ $topPerformers->count() }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500">Walioidhinishwa</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-accent-100 flex items-center justify-center">
                <i class="fas fa-users text-accent text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Wastani wa Kati</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ number_format($topPerformers->avg('average_rating') ?? 0, 1) }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500">Kati ya nyota 5</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-warning-100 flex items-center justify-center">
                <i class="fas fa-star text-warning text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
    <!-- Monthly Ride Statistics -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-4 md:p-6 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-700 flex items-center">
                <i class="fas fa-chart-line text-primary mr-2"></i>
                Takwimu za Safiri Kwa Mwezi
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <div class="space-y-3">
                @foreach($monthlyRides as $monthly)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-700 w-20">{{ date('M Y', strtotime($monthly->month)) }}</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-6 relative overflow-hidden">
                                <div class="bg-gradient-to-r from-primary to-secondary-green h-full rounded-full transition-all duration-500" 
                                     style="width: {{ ($monthly->count / $monthlyRides->max('count')) * 100 }}%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-primary">{{ $monthly->count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Performing Riders -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-4 md:p-6 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-700 flex items-center">
                <i class="fas fa-trophy text-primary mr-2"></i>
                Wapandaaji Bora zaidi
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <div class="space-y-4">
                @foreach($topPerformers as $index => $performer)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-bold text-primary">{{ $index + 1 }}</span>
                            </div>
                            <img src="{{ $performer['rider']->user->avatar }}" class="h-10 w-10 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $performer['rider']->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $performer['rider']->phone_number }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-primary">{{ $performer['total_rides'] }} safiri</p>
                            <p class="text-sm font-bold text-success">TZS {{ formatMoney($performer['total_earnings']) }}</p>
                            <div class="flex items-center justify-end">
                                <span class="text-sm font-bold text-warning">{{ number_format($performer['average_rating'], 1) }}</span>
                                <i class="fas fa-star text-warning ml-1"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm mt-6 md:mt-8">
    <div class="p-4 md:p-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
            <i class="fas fa-chart-bar text-primary mr-2"></i>
            Viwango Vya Biashara
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <div class="text-center">
                <div class="h-20 w-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-motorcycle text-primary text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-primary">{{ formatMoney($monthlyRides->sum('count') ?? 0) }}</h4>
                <p class="text-sm font-medium text-gray-700">Jumla ya Safiri</p>
                <p class="text-xs text-gray-500 mt-1">Miezi 12 iliyopita</p>
            </div>
            <div class="text-center">
                <div class="h-20 w-20 bg-success-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-usd text-success text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-success">{{ formatMoney($topPerformers->sum('total_earnings') ?? 0) }} TSh</h4>
                <p class="text-sm font-medium text-gray-700">Mapato Jumla</p>
                <p class="text-xs text-gray-500 mt-1">Mapato yote wakati wote</p>
            </div>
            <div class="text-center">
                <div class="h-20 w-20 bg-accent-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-accent text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-accent">{{ $topPerformers->count() }}</h4>
                <p class="text-sm font-medium text-gray-700">Wapandaji Wanaofanya Kazi</p>
                <p class="text-xs text-gray-500 mt-1">Walioidhinishwa</p>
            </div>
        </div>
    </div>
</div>
@endsection
