@extends('layouts.admin')

@section('title', 'Clients Management - BodaBoda Admin Panel')
@section('page-title', 'Clients Management')
@section('page-subtitle', 'Manage all passengers and their ride history')

@section('content')
<!-- Stats Row - Consistent with Dashboard Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Clients Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($clients->total()) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">TOTAL CLIENTS</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Registered passengers</p>
                <span class="text-xs font-bold text-[#2F6B3F]">All time</span>
            </div>
        </div>
    </div>

    <!-- Active Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-user-check text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($stats['active']) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">ACTIVE</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Verified & approved</p>
                <span class="text-xs font-bold text-[#2F6B3F]">In good standing</span>
            </div>
        </div>
    </div>

    <!-- Suspended Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#2F6B3F]/5 to-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#2F6B3F]/10 rounded-full -mr-10 -mt-10"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#2F6B3F] rounded-xl shadow-lg">
                    <i class="fas fa-user-slash text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-[#2F6B3F]">{{ number_format($stats['suspended']) }}</span>
            </div>
            <h3 class="text-slate-700 font-bold text-sm mb-1">SUSPENDED</h3>
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500">Safety restrictions</p>
                <span class="text-xs font-bold text-rose-600">Action needed</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters Card - Consistent Design -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-100 mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-slate-900 font-bold text-base">Filter Management</h3>
                <p class="text-slate-500 text-sm">Search and filter passenger database</p>
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
                    Search Identity
                </label>
                <div class="relative">
                    <input type="text" name="search" id="searchInput" placeholder="Search by name, email or phone..." 
                           class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                    <i class="fas fa-user-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <i class="fas fa-filter text-[10px] text-[#2F6B3F]"></i>
                    Access Status
                </label>
                <select name="status" id="statusFilter" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                    <option value="">ALL STATUS</option>
                    <option value="active">ACTIVE ONLY</option>
                    <option value="suspended">SUSPENDED ONLY</option>
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
<div class="scn-card" id="clientsTableContainer">
    @include('admin.clients._table')
</div>
@endsection

@section('scripts')
<script>
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const tableContainer = document.getElementById('clientsTableContainer');

    let filterTimeout;

    function fetchClients() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData).toString();
        
        tableContainer.style.opacity = '0.5';
        
        fetch(`{{ route('admin.clients') }}?${params}`, {
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
            console.error('Error fetching clients:', error);
            tableContainer.style.opacity = '1';
        });
    }

    function resetFilters() {
        filterForm.reset();
        fetchClients();
    }

    [searchInput, statusFilter].forEach(el => {
        if (el) {
            el.addEventListener('change', fetchClients);
            if (el.tagName === 'INPUT') {
                el.addEventListener('input', () => {
                    clearTimeout(filterTimeout);
                    filterTimeout = setTimeout(fetchClients, 500);
                });
            }
        }
    });

    document.addEventListener('click', function(e) {
        const link = e.target.closest('#clientsTableContainer .pagination a');
        if (link) {
            e.preventDefault();
            const url = link.href;
            tableContainer.style.opacity = '0.5';
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                tableContainer.style.opacity = '1';
                window.scrollTo({ top: tableContainer.offsetTop - 100, behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error fetching paginated clients:', error);
                tableContainer.style.opacity = '1';
            });
        }
    });
</script>
@endsection
