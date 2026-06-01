@extends('layouts.admin')

@section('title', 'Analytics - BodaBoda Admin Panel')
@section('page-title', 'Analytics & Trends')
@section('page-subtitle', 'Deep dive into platform performance and growth')

@section('content')
<!-- Stats Row - Consistent with Dashboard Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Monthly Income Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-wallet text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">TZS {{ number_format($monthlyIncome, 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">MONTHLY INCOME</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Platform revenue</p>
                <span class="text-xs font-bold text-emerald-600">↑ 12.5% vs last month</span>
            </div>
        </div>
    </div>

    <!-- Service Volume Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-route text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($monthlyRides->sum('count')) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">SERVICE VOLUME</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Total completed trips</p>
                <span class="text-xs font-bold text-[#2F6B3F]">✓ Verified</span>
            </div>
        </div>
    </div>

    <!-- Quality Index Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($overallAvgRating, 1) }} <span class="text-sm font-normal text-slate-400">/ 5.0</span></span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">QUALITY INDEX</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Fleet average rating</p>
                <div class="flex text-[10px] text-amber-400">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Fleet Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-motorcycle text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($topPerformers->count()) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">ACTIVE FLEET</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Top performing riders</p>
                <span class="text-xs font-bold text-[#2F6B3F]">🏆 Elite</span>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Intelligence Filter - Consistent Design -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-100 mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-[#2F6B3F] flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-brain text-sm"></i>
                </div>
                <div>
                    <h3 class="text-slate-900 font-bold text-base">Intelligence Matrix</h3>
                    <p class="text-slate-500 text-sm">Configure analysis parameters</p>
                </div>
            </div>
            <div class="px-3 py-1 bg-[#2F6B3F]/10 rounded-lg">
                <i class="fas fa-chart-line text-[#2F6B3F] text-xs"></i>
                <span class="text-[#2F6B3F] text-xs font-bold ml-1">Advanced Analytics</span>
            </div>
        </div>
    </div>
    <div class="p-6">
        <form id="analyticsForm" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-calendar-alt text-[10px] text-[#2F6B3F]"></i>
                    Temporal Range
                </label>
                <select name="year" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                    <option value="{{ now()->year }}">Fiscal Year {{ now()->year }}</option>
                    <option value="{{ now()->year - 1 }}">Fiscal Year {{ now()->year - 1 }}</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-microchip text-[10px] text-[#2F6B3F]"></i>
                    Data Layer
                </label>
                <select name="data_layer" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                    <option value="trips">Trip Velocity</option>
                    <option value="revenue">Revenue Flow</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-file-export text-[10px] text-[#2F6B3F]"></i>
                    Output Format
                </label>
                <select class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                    <option>Standard View</option>
                    <option>Raw CSV Data</option>
                </select>
            </div>
            <button id="refreshAnalytics" type="button" class="h-12 px-4 rounded-xl bg-[#2F6B3F] text-xs font-bold text-white hover:bg-[#235031] transition-all flex items-center justify-center gap-2 shadow-md">
                <i class="fas fa-sync text-[11px]"></i> REFRESH ANALYSIS
            </button>
        </form>
    </div>
</div>

<!-- Charts and Top Performers Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Ride Volume Chart -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-900 font-bold text-base">Mobility Growth Velocity</h3>
                        <p class="text-slate-500 text-sm">Temporal mapping of platform trip distribution</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="h-9 px-4 rounded-lg bg-[#2F6B3F] text-[10px] font-bold text-white shadow-sm">MONTHLY</button>
                        <button class="h-9 px-4 rounded-lg border border-slate-200 bg-white text-[10px] font-bold text-slate-600 hover:bg-slate-50 hover:border-[#2F6B3F]/30 transition-colors">WEEKLY</button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-[350px] w-full">
                    <canvas id="ridesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performing Riders - Consistent Card Design -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-amber-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-900 font-bold text-base">Elite Fleet Index</h3>
                        <p class="text-slate-500 text-sm">Top performing service operators</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-amber-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-trophy text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="scn-table-container">
                <table class="scn-table">
                    <thead>
                        <tr>
                            <th class="uppercase tracking-wider">Operator</th>
                            <th class="uppercase tracking-wider text-center">Trips</th>
                            <th class="uppercase tracking-wider text-right">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($topPerformers as $performer)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="{{ $performer->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($performer->user->name) . '&background=F1F5F9&color=64748B' }}" 
                                             class="h-9 w-9 rounded-full border-2 border-slate-200 shadow-sm">
                                        <div class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-white bg-emerald-500"></div>
                                    </div>
                                    <span class="text-sm font-bold text-slate-900 truncate max-w-[100px]">{{ $performer->user->name }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="text-sm font-black text-[#2F6B3F]">{{ number_format($performer->rides_count) }}</span>
                            </td>
                            <td class="text-right">
                                <div class="inline-flex items-center gap-1 text-amber-500 font-bold">
                                    <i class="fas fa-star text-[10px]"></i>
                                    <span class="text-sm">{{ number_format($performer->avg_rating, 1) }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/30">
                <button class="w-full h-10 rounded-xl border border-slate-200 bg-white text-[10px] font-bold text-slate-600 hover:bg-slate-50 hover:border-[#2F6B3F]/30 transition-all uppercase tracking-wider shadow-sm">
                    View Full Leaderboard →
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

const ridesCanvas = document.getElementById('ridesChart');
if (ridesCanvas) {
    const ctx = ridesCanvas.getContext('2d');
    const monthlyData = @json($monthlyRides);
    const data = new Array(12).fill(0);
    
    monthlyData.forEach(item => {
        data[item.month - 1] = parseInt(item.count);
    });

    const ridesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Trips',
                data: data,
                backgroundColor: '#2F6B3F',
                borderRadius: 8,
                barPercentage: 0.65,
                categoryPercentage: 0.8,
                hoverBackgroundColor: '#235031'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f3f4f6',
                    bodyColor: '#d1d5db',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' trips';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                    ticks: { 
                        font: { size: 10, weight: '500' },
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: '500' } }
                }
            }
        }
    });

    // Filter refresh
    document.getElementById('refreshAnalytics')?.addEventListener('click', function() {
        const selects = document.querySelectorAll('#analyticsForm select');
        const params = new URLSearchParams();
        params.set('ajax', '1');
        selects.forEach(s => { if (s.name) params.set(s.name, s.value); });

        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

        fetch('{{ route('admin.analytics') }}?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            const chartData = data.chartData.map(v => parseInt(v));
            ridesChart.data.datasets[0].data = chartData;
            ridesChart.update();
            showFlashMessage('Analytics refreshed', 'success');
        })
        .catch(() => showFlashMessage('Failed to refresh analytics', 'error'))
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-sync text-[11px]"></i> REFRESH ANALYSIS';
        });
    });
}
</script>
@endsection