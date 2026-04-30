@extends('layouts.admin')

@section('title', 'Reports - BodaBoda Admin Panel')
@section('page-title', 'Financial Reports')
@section('page-subtitle', 'Generate and export platform revenue data')

@section('content')
<!-- Revenue Performance Matrix - Consistent Dashboard Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Daily Performance Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">TZS {{ number_format($dailyRevenue, 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">DAILY PERFORMANCE</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Real-time earnings</p>
                <span class="text-xs font-bold text-[#2F6B3F] animate-pulse">LIVE FEED</span>
            </div>
        </div>
    </div>

    <!-- Weekly Cycle Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-calendar-week text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">TZS {{ number_format($weeklyRevenue, 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">WEEKLY CYCLE</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Last 7 operational days</p>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg">CYCLE ACTIVE</span>
            </div>
        </div>
    </div>

    <!-- Monthly Yield Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">TZS {{ number_format($monthlyRevenue, 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">MONTHLY YIELD</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Current month aggregate</p>
                <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-lg">FISCAL</span>
            </div>
        </div>
    </div>

    <!-- Annual Index Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-globe text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">TZS {{ number_format($yearlyRevenue, 0) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">ANNUAL INDEX</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Platform lifetime value</p>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-lg">TOTAL</span>
            </div>
        </div>
    </div>
</div>

<!-- Report Configuration Engine - Consistent Design -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-100 mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-[#2F6B3F] flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-sliders-h text-sm"></i>
                </div>
                <div>
                    <h3 class="text-slate-900 font-bold text-base">Report Configuration Engine</h3>
                    <p class="text-slate-500 text-sm">Define data extraction parameters</p>
                </div>
            </div>
            <div class="px-3 py-1 bg-[#2F6B3F]/10 rounded-lg">
                <i class="fas fa-chart-pie text-[#2F6B3F] text-xs"></i>
                <span class="text-[#2F6B3F] text-xs font-bold ml-1">Data Extraction</span>
            </div>
        </div>
    </div>
    <div class="p-6">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="md:col-span-2 space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-calendar-range text-[10px] text-[#2F6B3F]"></i>
                    Temporal Scope
                </label>
                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-1.5 h-12">
                    <input type="date" class="flex-1 border-none bg-transparent px-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-0">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">→</span>
                    <input type="date" class="flex-1 border-none bg-transparent px-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-0">
                </div>
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-file-invoice-dollar text-[10px] text-[#2F6B3F]"></i>
                    Export Format
                </label>
                <select class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                    <option>PDF DOCUMENT</option>
                    <option>EXCEL SPREADSHEET</option>
                    <option>RAW CSV FEED</option>
                </select>
            </div>
            <button type="button" class="h-12 px-4 rounded-xl bg-[#2F6B3F] text-xs font-bold text-white hover:bg-[#235031] transition-all flex items-center justify-center gap-2 shadow-md">
                <i class="fas fa-rocket text-[11px]"></i> EXECUTE EXTRACTION
            </button>
        </form>
    </div>
</div>

<!-- Asset Intelligence Ledger - Consistent Table Format -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 shadow-inner">
                    <i class="fas fa-archive text-sm"></i>
                </div>
                <div>
                    <h3 class="text-slate-900 font-bold text-base">Asset Intelligence Ledger</h3>
                    <p class="text-slate-500 text-sm">Archived platform financial data exports</p>
                </div>
            </div>
            <div class="px-3 py-1 bg-slate-100 rounded-lg">
                <i class="fas fa-database text-slate-500 text-xs"></i>
                <span class="text-slate-500 text-xs font-bold ml-1">{{ count($recentReports) }} Assets</span>
            </div>
        </div>
    </div>
    <div class="scn-table-container">
        <table class="scn-table">
            <thead>
                <tr>
                    <th class="uppercase tracking-wider">Asset Identity</th>
                    <th class="uppercase tracking-wider text-center">Data Unit</th>
                    <th class="uppercase tracking-wider">Extraction Date</th>
                    <th class="uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($recentReports as $report)
                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 shadow-sm">
                                <i class="fas fa-file-pdf text-xs"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-900">{{ $report['name'] }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-tighter">
                            {{ $report['type'] }}
                        </span>
                    </td>
                    <td>
                        <span class="text-xs text-slate-600 font-medium">
                            {{ \Carbon\Carbon::parse($report['created_at'])->format('M d, Y • H:i A') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <button class="h-9 w-9 rounded-lg border border-slate-200 bg-white text-[#2F6B3F] hover:bg-[#2F6B3F] hover:text-white hover:border-[#2F6B3F] flex items-center justify-center transition-all shadow-sm" title="Download Asset">
                                <i class="fas fa-download text-xs"></i>
                            </button>
                            <button class="h-9 w-9 rounded-lg border border-slate-200 bg-white text-rose-500 hover:bg-rose-50 hover:border-rose-200 flex items-center justify-center transition-all shadow-sm" title="Purge Asset">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(isset($recentReports) && method_exists($recentReports, 'links'))
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $recentReports->links() }}
    </div>
    @endif
</div>
@endsection