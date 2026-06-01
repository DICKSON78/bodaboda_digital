@extends('layouts.admin')

@section('title', 'Dashboard - BodaBoda Admin Panel')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('content')
<!-- SHADC Cards - Uniform Green Design (#2F6B3F) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Active Fleet -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-motorcycle text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($totalRiders) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">ACTIVE FLEET</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Verified operators</p>
                <span class="text-xs font-bold text-[#2F6B3F]">{{ $approvedRiders }} verified</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Consumer Base -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($totalClients ?? 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">CONSUMER BASE</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Active users</p>
                <span class="text-xs font-bold text-[#2F6B3F]">+4.2% growth</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Trip Velocity -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-route text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($totalRides) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">TRIP VELOCITY</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Total journeys</p>
                <span class="text-xs font-bold text-[#2F6B3F]">{{ $completedRides }} completed</span>
            </div>
        </div>
    </div>

    <!-- Card 4: Fiscal Yield -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-wallet text-white text-xl"></i>
                </div>
                <span class="text-2xl font-black text-[#2F6B3F]">TZS {{ number_format($monthlyRevenue ?? 0, 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">FISCAL YIELD</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Current month</p>
                <span class="text-xs font-bold text-[#2F6B3F]">MTD revenue</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions - Normal Cards with Green Theme (#2F6B3F) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('admin.riders') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-[#2F6B3F]/20 hover:border-[#2F6B3F]">
        <div class="p-5 flex items-center">
            <div class="w-14 h-14 bg-[#2F6B3F] rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-motorcycle text-2xl text-white"></i>
            </div>
            <div>
                <p class="text-base font-black text-slate-900 group-hover:text-[#2F6B3F] transition-colors">Manage Riders</p>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">Verification Portal →</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.clients') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-[#2F6B3F]/20 hover:border-[#2F6B3F]">
        <div class="p-5 flex items-center">
            <div class="w-14 h-14 bg-[#2F6B3F] rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-users text-2xl text-white"></i>
            </div>
            <div>
                <p class="text-base font-black text-slate-900 group-hover:text-[#2F6B3F] transition-colors">Manage Clients</p>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">Consumer Database →</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.analytics') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-[#2F6B3F]/20 hover:border-[#2F6B3F]">
        <div class="p-5 flex items-center">
            <div class="w-14 h-14 bg-[#2F6B3F] rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-chart-line text-2xl text-white"></i>
            </div>
            <div>
                <p class="text-base font-black text-slate-900 group-hover:text-[#2F6B3F] transition-colors">View Analytics</p>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">Intelligence Suite →</p>
            </div>
        </div>
    </a>
</div>

<!-- Revenue Chart + Event Stream -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Revenue Velocity Chart - White Header -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-900 font-bold text-lg">Revenue Extraction Velocity</h3>
                    <p class="text-slate-500 text-sm">Weekly fiscal performance</p>
                </div>
                <div class="px-3 py-1 bg-slate-100 rounded-lg">
                    <span class="text-slate-600 text-xs font-bold uppercase tracking-wider">Live Stream</span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="h-[350px] w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Event Stream - White Background -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-900 font-bold text-lg">Event Stream</h3>
                    <p class="text-slate-500 text-sm">Live activity feed</p>
                </div>
                <div class="animate-pulse">
                    <div class="w-3 h-3 bg-[#2F6B3F] rounded-full"></div>
                </div>
            </div>
        </div>
        <div class="p-0 max-h-[400px] overflow-y-auto">
            <div class="divide-y divide-slate-100">
                @foreach($recentRides->take(8) as $ride)
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-motorcycle text-[#2F6B3F] text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900">{{ $ride->rider->user->name ?? 'Operator' }}</div>
                                <div class="text-xs text-slate-500">{{ $ride->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-[#2F6B3F]">TZS {{ number_format($ride->fare, 0) }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100">
            <a href="{{ route('admin.rides') }}" class="block text-center py-2 bg-[#2F6B3F] hover:bg-[#235031] text-white rounded-lg text-xs font-black uppercase tracking-wider transition-colors">
                Full Operational Audit →
            </a>
        </div>
    </div>
</div>

<!-- Verification Queue - Using scn-table format -->
<div class="scn-card">
    <div class="scn-card-header border-b border-slate-100 bg-slate-50/30">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="scn-card-title">Verification Queue</h3>
                <p class="scn-card-description">Riders awaiting security clearance and platform access</p>
            </div>
            <div class="h-10 w-10 rounded-xl bg-amber-500 flex items-center justify-center text-white shadow-sm shadow-amber-500/20">
                <i class="fas fa-shield-alt text-sm"></i>
            </div>
        </div>
    </div>
    
    <div class="scn-table-container">
        <table class="scn-table">
            <thead>
                <tr>
                    <th class="uppercase tracking-wider">Rider Profile</th>
                    <th class="uppercase tracking-wider">Vehicle & Network</th>
                    <th class="uppercase tracking-wider">Access Credentials</th>
                    <th class="uppercase tracking-wider text-center">Status</th>
                    <th class="uppercase tracking-wider text-center">Verification</th>
                    <th class="uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRiders->take(5) as $rider)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img src="{{ $rider->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($rider->user->name) . '&background=F1F5F9&color=64748B' }}" 
                                     class="h-10 w-10 rounded-full border border-slate-200 shadow-sm">
                                <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white bg-slate-300"></div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 leading-none">{{ $rider->user->name }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $rider->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium text-slate-900 leading-none">{{ $rider->phone_number ?? $rider->user->phone ?? 'N/A' }}</p>
                            <div class="flex items-center text-[10px] font-semibold text-slate-500 uppercase tracking-wider">
                                <i class="fas fa-motorcycle mr-1.5 text-[#2F6B3F]"></i>
                                {{ $rider->bike_plate }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <code class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-mono border border-slate-200">
                            {{ $rider->license_number }}
                        </code>
                    </td>
                    <td class="text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border uppercase bg-amber-50 text-amber-700 border-amber-200">
                            Pending
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border uppercase bg-amber-50 text-amber-700 border-amber-200">
                            Pending
                        </span>
                    </td>
                    <td>
                        <div class="flex justify-end gap-2">
                            <button onclick="showConfirmModal('approve', '{{ route('admin.rider.approve', $rider) }}', '{{ $rider->user->name }}')" 
                                    class="h-8 px-4 rounded-md bg-[#2F6B3F] text-white text-[10px] font-black uppercase tracking-wider hover:bg-[#235031] transition-all shadow-sm">
                                Approve
                            </button>
                            <a href="{{ route('admin.riders.show', $rider) }}" class="h-8 w-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 flex items-center justify-center transition-colors shadow-sm">
                                <i class="fas fa-eye text-[10px]"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-500 text-sm italic">No pending riders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 bg-slate-50/50 border-t border-slate-100">
        <a href="{{ route('admin.riders') }}" class="btn-primary w-full !text-[10px] !font-black !uppercase !tracking-widest !bg-transparent !text-slate-600 !border !border-slate-200 !shadow-none hover:!bg-slate-50 text-center block py-2 rounded-lg">
            Access Full Verification Portal
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const revenueCanvas = document.getElementById('revenueChart');
if (revenueCanvas) {
    const ctx = revenueCanvas.getContext('2d');
    
    // Generate last 7 days labels and fill with real data
    const weeklyData = @json($weeklyRevenueData);
    const labels = [];
    const data = [];
    
    for (let i = 6; i >= 0; i--) {
        const d = new Date();
        d.setDate(d.getDate() - i);
        const dateStr = d.toISOString().split('T')[0];
        const dayName = d.toLocaleDateString('en-US', { weekday: 'long' });
        labels.push(dayName);
        data.push(weeklyData[dateStr] ? parseInt(weeklyData[dateStr].total) : 0);
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (TZS)',
                data: data,
                borderColor: '#2F6B3F',
                borderWidth: 4,
                fill: true,
                backgroundColor: 'rgba(47, 107, 63, 0.1)',
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#2F6B3F',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#235031',
                pointHoverBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f3f4f6',
                    bodyColor: '#d1d5db',
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'TZS ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'TZS ' + (value / 1000).toFixed(0) + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>
@endsection