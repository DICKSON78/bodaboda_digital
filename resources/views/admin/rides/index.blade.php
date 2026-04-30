@extends('layouts.admin')

@section('title', 'Ride History - BodaBoda Admin Panel')
@section('page-title', 'Ride Tracking')
@section('page-subtitle', 'Monitor all platform activity and transactions')

@section('content')
<!-- Stats Row - Consistent with Dashboard Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Missions Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-route text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($stats['total']) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">TOTAL MISSIONS</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Cumulative trips</p>
                <span class="text-xs font-bold text-[#2F6B3F]">All time</span>
            </div>
        </div>
    </div>

    <!-- Successful Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($stats['completed']) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">SUCCESSFUL</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Completed rides</p>
                <span class="text-xs font-bold text-[#2F6B3F]">Success rate</span>
            </div>
        </div>
    </div>

    <!-- Live Ops Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($stats['ongoing']) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">LIVE OPS</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Currently active</p>
                <span class="text-xs font-bold text-[#2F6B3F] animate-pulse">Live</span>
            </div>
        </div>
    </div>

    <!-- Terminated Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-times-circle text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($stats['cancelled']) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">TERMINATED</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">User cancellations</p>
                <span class="text-xs font-bold text-rose-600">{{ $stats['total'] > 0 ? round(($stats['cancelled'] / $stats['total']) * 100, 1) : 0 }}% rate</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters Card - Consistent Design -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-100 mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-slate-900 font-bold text-base">Ride Intelligence Filter</h3>
                <p class="text-slate-500 text-sm">Search and filter ride transactions</p>
            </div>
            <div class="px-3 py-1 bg-[#2F6B3F]/10 rounded-lg">
                <i class="fas fa-filter text-[#2F6B3F] text-xs"></i>
                <span class="text-[#2F6B3F] text-xs font-bold ml-1">Advanced</span>
            </div>
        </div>
    </div>
    <div class="p-6">
        <form id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="md:col-span-2 space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-search text-[10px] text-[#2F6B3F]"></i>
                    Search Parameters
                </label>
                <div class="relative">
                    <input type="text" name="search" id="searchInput" placeholder="Ride ID, Rider name, or Client name..." 
                           class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                    <i class="fas fa-fingerprint absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-layer-group text-[10px] text-[#2F6B3F]"></i>
                    Activity Status
                </label>
                <select name="status" id="statusFilter" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                    <option value="">ALL ACTIVITY</option>
                    <option value="completed">✓ COMPLETED</option>
                    <option value="ongoing">⟳ ONGOING</option>
                    <option value="pending">⏳ PENDING</option>
                    <option value="cancelled">✗ CANCELLED</option>
                </select>
            </div>
            <div>
                <button type="button" onclick="resetFilters()" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 hover:border-[#2F6B3F]/30 transition-all flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-undo-alt text-[11px] text-[#2F6B3F]"></i> Reset Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Table Card - Consistent scn-table format -->
<div class="scn-card" id="ridesTableContainer">
    @include('admin.rides._table')
</div>
@endsection

@section('scripts')
<script>
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const tableContainer = document.getElementById('ridesTableContainer');

    let filterTimeout;

    function fetchRides() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData).toString();
        
        tableContainer.style.opacity = '0.5';
        
        fetch(`{{ route('admin.rides') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            tableContainer.innerHTML = html;
            tableContainer.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error fetching rides:', error);
            tableContainer.style.opacity = '1';
        });
    }

    function resetFilters() {
        filterForm.reset();
        fetchRides();
    }

    [searchInput, statusFilter].forEach(el => {
        if (el) {
            el.addEventListener('change', fetchRides);
            if (el.tagName === 'INPUT') {
                el.addEventListener('input', () => {
                    clearTimeout(filterTimeout);
                    filterTimeout = setTimeout(fetchRides, 500);
                });
            }
        }
    });

    document.addEventListener('click', function(e) {
        const link = e.target.closest('#ridesTableContainer .pagination a');
        if (link) {
            e.preventDefault();
            const url = link.href;
            tableContainer.style.opacity = '0.5';
            fetch(url, { 
                headers: { 'X-Requested-With': 'XMLHttpRequest' } 
            })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                tableContainer.style.opacity = '1';
                window.scrollTo({ top: tableContainer.offsetTop - 100, behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error fetching paginated rides:', error);
                tableContainer.style.opacity = '1';
            });
        }
    });
</script>
@endsection
