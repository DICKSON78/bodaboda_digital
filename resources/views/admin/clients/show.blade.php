@extends('layouts.admin')

@section('title', 'Client Details - BodaBoda Admin Panel')
@section('page-title', 'Client Details')
@section('page-subtitle', 'View passenger profile and ride history')

@section('content')
<!-- Breadcrumb -->
<div class="mb-8 flex items-center justify-between">
    <nav class="flex items-center space-x-3 text-xs font-bold text-slate-400 uppercase tracking-widest">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#2F6B3F] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.clients') }}" class="hover:text-[#2F6B3F] transition-colors">Clients</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-900">{{ $client->name }}</span>
    </nav>
    <a href="{{ route('admin.clients') }}" class="text-xs font-black text-slate-500 hover:text-[#2F6B3F] transition-all flex items-center uppercase tracking-widest">
        <i class="fas fa-arrow-left mr-2"></i> Back to Archive
    </a>
</div>

<!-- Profile Header Card -->
<div class="bg-white rounded-2xl shadow-xl border border-[#2F6B3F]/10 mb-8 overflow-hidden">
    <div class="h-40 bg-gradient-to-r from-[#2F6B3F] to-[#1a3d26] relative">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    <div class="px-8 pb-8 relative">
        <div class="flex flex-col md:flex-row md:items-end -mt-16 md:-mt-20 gap-8">
            <div class="relative group">
                <img src="{{ $client->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($client->name) . '&background=2F6B3F&color=fff' }}" 
                     class="w-32 h-32 md:w-40 md:h-40 rounded-3xl border-8 border-white shadow-2xl transition-transform duration-500 group-hover:scale-105">
                <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl border-4 border-white flex items-center justify-center shadow-lg {{ $client->suspended_at ? 'bg-rose-500' : 'bg-emerald-500' }}">
                    <i class="fas {{ $client->suspended_at ? 'fa-user-slash' : 'fa-user-check' }} text-white text-xs"></i>
                </div>
            </div>
            <div class="flex-1 pb-4">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-3xl font-black text-slate-900">{{ $client->name }}</h2>
                            @if($client->suspended_at)
                                <span class="bg-rose-50 text-rose-700 text-[10px] font-black px-2 py-1 rounded-lg border border-rose-200 uppercase tracking-widest">Suspended Account</span>
                            @else
                                <span class="bg-emerald-50 text-emerald-700 text-[10px] font-black px-2 py-1 rounded-lg border border-emerald-200 uppercase tracking-widest">Active Account</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-6 text-sm font-bold text-slate-500">
                            <span class="flex items-center gap-2"><i class="fas fa-envelope text-[#2F6B3F]"></i> {{ $client->email }}</span>
                            <span class="flex items-center gap-2"><i class="fas fa-calendar-alt text-[#2F6B3F]"></i> Joined {{ $client->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="h-11 px-6 bg-slate-100 text-slate-700 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center shadow-sm">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </a>
                        <button onclick="showConfirmModal('{{ $client->suspended_at ? 'activate' : 'suspend' }}', '{{ route($client->suspended_at ? 'admin.client.activate' : 'admin.client.suspend', $client) }}', '{{ $client->name }}')" 
                                class="h-11 px-6 {{ $client->suspended_at ? 'bg-emerald-600' : 'bg-orange-600' }} text-white rounded-xl text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-lg flex items-center">
                            <i class="fas {{ $client->suspended_at ? 'fa-user-check' : 'fa-user-slash' }} mr-2"></i> {{ $client->suspended_at ? 'Restore Access' : 'Suspend Access' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Sidebar Info Column -->
    <div class="lg:col-span-1 space-y-8">
        <!-- Usage Statistics -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center"><i class="fas fa-chart-pie mr-2 text-[#2F6B3F]"></i> Platform Metrics</h4>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center p-5 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Total Rides</span>
                    <span class="text-2xl font-black text-emerald-800">{{ $client->rides_as_passenger_count ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center p-5 bg-[#2F6B3F] rounded-2xl shadow-lg">
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Gross Expenditure</span>
                    <span class="text-lg font-black text-white">TZS {{ number_format($client->rides_as_passenger->where('status', 'completed')->sum('fare'), 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Account Metadata</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500 font-bold">Email Verified</span>
                    <span class="text-[#2F6B3F] font-black uppercase tracking-widest text-[10px]">✓ Confirmed</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500 font-bold">Wallet Balance</span>
                    <span class="text-slate-900 font-black">TZS 0.00</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Ride History -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                <div>
                    <h4 class="text-base font-black text-slate-900">Operational History</h4>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Recent mission participation</p>
                </div>
                <a href="{{ route('admin.rides', ['search' => $client->name]) }}" class="h-9 px-4 bg-slate-100 hover:bg-[#2F6B3F] hover:text-white text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex items-center">
                    Full Audit Log
                </a>
            </div>
            <div class="p-0">
                @if($client->rides_as_passenger->isEmpty())
                    <div class="p-16 text-center text-slate-400">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                            <i class="fas fa-route text-2xl opacity-20"></i>
                        </div>
                        <p class="text-sm font-bold uppercase tracking-widest opacity-40">Zero missions participating</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Mission ID</th>
                                    <th class="px-6 py-4">Deployment Time</th>
                                    <th class="px-6 py-4">Operator</th>
                                    <th class="px-6 py-4">Revenue</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($client->rides_as_passenger->take(10) as $ride)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <code class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-mono border border-slate-200">#{{ str_pad($ride->id, 5, '0', STR_PAD_LEFT) }}</code>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-slate-900">{{ $ride->created_at->format('M d, Y') }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $ride->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $ride->rider->user->name ?? 'System Assigned' }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-[#2F6B3F]">TZS {{ number_format($ride->fare, 0) }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            ];
                                            $class = $statusClasses[$ride->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-black border uppercase tracking-tighter {{ $class }}">
                                            {{ $ride->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Administrative Actions -->
        <div class="bg-rose-50 rounded-2xl shadow-lg border border-rose-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-100 bg-rose-100/30 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-500/20">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-rose-900 font-bold text-base">Security Clearance</h4>
                        <p class="text-rose-700/70 text-sm">Client termination protocol</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-xs text-rose-700 font-bold uppercase tracking-wider mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Caution: These actions are permanent and affect data integrity
                </p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="showConfirmModal('delete', '{{ route('admin.client.delete', $client) }}', '{{ $client->name }}', 'DELETE')" 
                            class="h-11 px-6 rounded-xl border border-rose-200 bg-white text-[11px] font-black text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-trash-alt text-xs"></i> Delete Client Record
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
