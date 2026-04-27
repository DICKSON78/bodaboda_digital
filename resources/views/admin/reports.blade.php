@extends('layouts.admin-kkk')

@section('title', 'Ripoti - BodaBoda Admin Panel')
@section('page-title', 'Ripoti')
@section('page-subtitle', 'Pakua na ona ripoti za biashara')

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
<!-- Report Filters -->
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <h3 class="text-lg font-medium text-gray-700 flex items-center">
            <i class="fas fa-filter text-primary mr-2"></i> Chaguo la Ripoti
        </h3>
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-48">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-calendar text-gray-400"></i>
                </div>
                <input type="date" id="startDate" class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 bg-white shadow-sm text-gray-900 placeholder-gray-500" placeholder="Tarehe ya Kuanza">
            </div>
            <div class="relative w-full md:w-48">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-calendar text-gray-400"></i>
                </div>
                <input type="date" id="endDate" class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 bg-white shadow-sm text-gray-900 placeholder-gray-500" placeholder="Tarehe ya Mwisho">
            </div>
            <select id="reportType" class="bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 py-2 px-3 text-sm w-full md:w-48">
                <option value="">Aina ya Ripoti</option>
                <option value="daily">Ripoti ya Kila Siku</option>
                <option value="weekly">Ripoti ya Kila Wiki</option>
                <option value="monthly">Ripoti ya Kila Mwezi</option>
                <option value="yearly">Ripoti ya Kila Mwaka</option>
            </select>
            <button onclick="generateReport()" class="btn-primary px-4 py-2 text-sm font-medium">
                <i class="fas fa-file-export mr-2"></i> Zalisha Ripoti
            </button>
        </div>
    </div>
</div>

<!-- Quick Report Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
    <!-- Daily Report -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200 cursor-pointer" onclick="generateQuickReport('daily')">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Ripoti ya Kila Siku</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-gray-900">{{ formatMoney($dailyRevenue ?? 0) }} TSh</p>
                <p class="mt-1 text-xs text-gray-500">Mapato ya leo</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-primary-100 flex items-center justify-center">
                <i class="fas fa-calendar-day text-primary text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Weekly Report -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200 cursor-pointer" onclick="generateQuickReport('weekly')">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Ripoti ya Kila Wiki</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-gray-900">{{ formatMoney($weeklyRevenue ?? 0) }} TSh</p>
                <p class="mt-1 text-xs text-gray-500">Mapato ya wiki hii</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-accent-100 flex items-center justify-center">
                <i class="fas fa-calendar-week text-accent text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Monthly Report -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200 cursor-pointer" onclick="generateQuickReport('monthly')">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Ripoti ya Kila Mwezi</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-gray-900">{{ formatMoney($monthlyRevenue ?? 0) }} TSh</p>
                <p class="mt-1 text-xs text-gray-500">Mapato ya mwezi huu</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-success-100 flex items-center justify-center">
                <i class="fas fa-calendar text-success text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Yearly Report -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200 cursor-pointer" onclick="generateQuickReport('yearly')">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Ripoti ya Kila Mwaka</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-gray-900">{{ formatMoney($yearlyRevenue ?? 0) }} TSh</p>
                <p class="mt-1 text-xs text-gray-500">Mapato ya mwaka huu</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-warning-100 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-warning text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
    <div class="p-4 md:p-6 border-b border-gray-100">
        <h3 class="text-lg font-medium text-gray-700 flex items-center">
            <i class="fas fa-history text-primary mr-2"></i>
            Ripoti Zilizotengenezwa Hivi Punde
        </h3>
    </div>
    <div class="p-4 md:p-6">
        @if(empty($recentReports))
            <div class="text-center py-8">
                <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-700 mb-2">Hakuna Ripoti Mpya</h4>
                <p class="text-gray-500">Anza kuzalisha ripoti za biashara</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($recentReports as $report)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-primary"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $report->name }}</p>
                                <p class="text-xs text-gray-500">{{ $report->created_at->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 bg-success-10 text-success text-xs font-bold rounded-lg">{{ $report->type }}</span>
                            <button class="text-primary hover:text-primary-80" title="Pakua">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="text-error hover:text-error-80" title="Futa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
function generateReport() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const reportType = document.getElementById('reportType').value;
    
    if (!startDate || !endDate || !reportType) {
        alert('Tafadhali chaguo tarehe na aina ya ripoti');
        return;
    }
    
    // Show loading state
    const button = event.target;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Inazalisha...';
    button.disabled = true;
    
    // Simulate report generation
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-file-export mr-2"></i> Zalisha Ripoti';
        button.disabled = false;
        alert('Ripoti imetengenezwa kwa mafanikio!');
    }, 2000);
}

function generateQuickReport(type) {
    const typeNames = {
        'daily': 'Ripoti ya Kila Siku',
        'weekly': 'Ripoti ya Kila Wiki',
        'monthly': 'Ripoti ya Kila Mwezi',
        'yearly': 'Ripoti ya Kila Mwaka'
    };
    
    alert(`Inazalisha ${typeNames[type]}...`);
    
    // Simulate report generation
    setTimeout(() => {
        alert(`${typeNames[type]} imetengenezwa kwa mafanikio!`);
    }, 1500);
}
</script>
@endsection
