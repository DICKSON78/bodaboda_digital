@extends('layouts.admin')

@section('title', 'Rider Details - BodaBoda Admin Panel')
@section('page-title', 'Rider Details')
@section('page-subtitle', 'View Profile, Vehicle Info, And Performance Metrics')

@section('content')
<!-- Breadcrumb -->
<div class="mb-8 flex items-center justify-between">
    <nav class="flex items-center space-x-3 text-xs font-bold text-slate-400 capitalize tracking-tight">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#2F6B3F] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.riders') }}" class="hover:text-[#2F6B3F] transition-colors">Riders</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-900">{{ $rider->user->name }}</span>
    </nav>
    <a href="{{ route('admin.riders') }}" class="text-xs font-black text-slate-500 hover:text-[#2F6B3F] transition-all flex items-center capitalize tracking-tight">
        <i class="fas fa-arrow-left mr-2"></i> Back to Archive
    </a>
</div>

<!-- Profile Header Card -->
<div class="bg-white rounded-2xl shadow-xl border border-[#2F6B3F]/20 mb-8 overflow-hidden">
    <div class="h-40 bg-gradient-to-r from-[#2F6B3F] to-[#1a3d26] relative">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    <div class="px-8 pb-8 relative">
        <div class="flex flex-col md:flex-row md:items-end -mt-16 md:-mt-20 gap-8">
            <div class="relative group">
                <img src="{{ $rider->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($rider->user->name) . '&background=2F6B3F&color=fff' }}" 
                     class="w-32 h-32 md:w-40 md:h-40 rounded-3xl border-8 border-white shadow-2xl transition-transform duration-500 group-hover:scale-105">
                <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl border-4 border-white flex items-center justify-center shadow-lg {{ $rider->status === 'online' ? 'bg-emerald-500' : ($rider->status === 'suspended' ? 'bg-rose-500' : 'bg-slate-400') }}">
                    <i class="fas {{ $rider->status === 'online' ? 'fa-bolt' : ($rider->status === 'suspended' ? 'fa-ban' : 'fa-moon') }} text-white text-xs"></i>
                </div>
            </div>
            <div class="flex-1 pb-4">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-3xl font-black text-slate-900">{{ $rider->user->name }}</h2>
                            @if($rider->is_approved)
                                <span class="bg-emerald-50 text-emerald-700 text-[14px] font-black px-2 py-1 rounded-lg border border-emerald-200 capitalize tracking-tight">Verified Account</span>
                            @else
                                <span class="bg-amber-50 text-amber-700 text-[14px] font-black px-2 py-1 rounded-lg border border-amber-200 capitalize tracking-tight">Pending Review</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-6 text-sm font-bold text-slate-500">
                            <span class="flex items-center gap-2"><i class="fas fa-envelope text-[#2F6B3F]"></i> {{ $rider->user->email }}</span>
                            <span class="flex items-center gap-2"><i class="fas fa-phone-alt text-[#2F6B3F]"></i> {{ $rider->phone_number }}</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.riders.edit', $rider) }}" class="h-11 px-6 bg-slate-100 text-slate-700 rounded-xl text-xs font-black capitalize tracking-tight hover:bg-slate-200 transition-all flex items-center shadow-sm">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </a>
                        @if($rider->is_approved)
                            <button onclick="showConfirmModal('{{ $rider->status === 'suspended' ? 'activate' : 'suspend' }}', '{{ route($rider->status === 'suspended' ? 'admin.rider.activate' : 'admin.rider.suspend', $rider) }}', '{{ $rider->user->name }}')" 
                                    class="h-11 px-6 {{ $rider->status === 'suspended' ? 'bg-secondary-600' : 'bg-[#2F6B3F]' }} text-white rounded-xl text-xs font-black capitalize tracking-tight hover:opacity-90 transition-all shadow-lg flex items-center">
                                <i class="fas {{ $rider->status === 'suspended' ? 'fa-user-check' : 'fa-user-slash' }} mr-2"></i> {{ $rider->status === 'suspended' ? 'Activate Operator' : 'Suspend Operator' }}
                            </button>
                        @else
                             <button onclick="showConfirmModal('approve', '{{ route('admin.rider.approve', $rider) }}', '{{ $rider->user->name }}')" 
                                     class="h-11 px-6 bg-emerald-600 text-white rounded-xl text-xs font-black capitalize tracking-tight hover:bg-emerald-700 transition-all shadow-lg flex items-center">
                                 <i class="fas fa-check-double mr-2"></i> Approve Application
                             </button>
                             <button onclick="showConfirmModal('reject', '{{ route('admin.rider.reject', $rider) }}', '{{ $rider->user->name }}')" 
                                     class="h-11 px-6 bg-rose-600 text-white rounded-xl text-xs font-black capitalize tracking-tight hover:bg-rose-700 transition-all shadow-lg flex items-center">
                                 <i class="fas fa-times-circle mr-2"></i> Reject Application
                             </button>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Sidebar Info Column -->
    <div class="lg:col-span-1 space-y-8">
        <!-- Vehicle Details Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                        <i class="fas fa-motorcycle text-[#2F6B3F] text-sm"></i>
                    </div>
                    <h4 class="text-xs font-black text-slate-900 capitalize tracking-tight">Vehicle Intelligence</h4>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-[14px] font-black text-slate-400 capitalize tracking-tight mb-1">Bike Plate Id</p>
                    <p class="text-base font-black text-slate-900">{{ $rider->bike_plate }}</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-[14px] font-black text-slate-400 capitalize tracking-tight mb-1">License Registry</p>
                    <p class="text-base font-black text-slate-900">{{ $rider->license_number }}</p>
                </div>
                @if($rider->bike_image)
                <div class="pt-2">
                    <p class="text-[14px] font-black text-slate-400 capitalize tracking-tight mb-3">Unit Visualization</p>
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $rider->bike_image) }}" class="w-full rounded-xl shadow-md border border-slate-200 group-hover:scale-[1.02] transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Performance Metrics Card - All Green Design -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                        <i class="fas fa-chart-pie text-[#2F6B3F] text-sm"></i>
                    </div>
                    <h4 class="text-xs font-black text-slate-900 capitalize tracking-tight">Performance Metrics</h4>
                </div>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                <!-- Total Trips -->
                <div class="text-center p-4 bg-[#2F6B3F]/5 rounded-xl border border-[#2F6B3F]/10">
                    <p class="text-[9px] font-black text-[#2F6B3F] capitalize tracking-tight mb-1">Total Trips</p>
                    <p class="text-2xl font-black text-[#2F6B3F]">{{ $stats['total_rides'] }}</p>
                </div>
                <!-- Success -->
                <div class="text-center p-4 bg-[#2F6B3F]/5 rounded-xl border border-[#2F6B3F]/10">
                    <p class="text-[9px] font-black text-[#2F6B3F] capitalize tracking-tight mb-1">Success</p>
                    <p class="text-2xl font-black text-[#2F6B3F]">{{ $stats['completed_rides'] }}</p>
                </div>
                <!-- Quality -->
                <div class="text-center p-4 bg-[#2F6B3F]/5 rounded-xl border border-[#2F6B3F]/10">
                    <p class="text-[9px] font-black text-[#2F6B3F] capitalize tracking-tight mb-1">Quality</p>
                    <p class="text-2xl font-black text-[#2F6B3F]">{{ number_format($stats['average_rating'], 1) }}</p>
                </div>
                <!-- Revenue -->
                <div class="text-center p-4 bg-[#2F6B3F]/5 rounded-xl border border-[#2F6B3F]/10">
                    <p class="text-[9px] font-black text-[#2F6B3F] capitalize tracking-tight mb-1">Revenue</p>
                    <p class="text-sm font-black text-[#2F6B3F]">Tzs {{ number_format($stats['total_earnings'] / 1000, 1) }}k</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Operational History Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                            <i class="fas fa-history text-[#2F6B3F] text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-base font-black text-slate-900 capitalize">Operational History</h4>
                            <p class="text-slate-500 text-xs font-bold capitalize tracking-tight">Recent mission deployment</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.rides', ['search' => $rider->user->name]) }}" class="h-9 px-4 bg-slate-100 hover:bg-[#2F6B3F] hover:text-white text-slate-600 rounded-lg text-[14px] font-black capitalize tracking-tight transition-all flex items-center gap-2">
                        <i class="fas fa-chart-line text-xs"></i> Full Audit Log
                    </a>
                </div>
            </div>
            <div class="p-0">
                @if($rider->rides->isEmpty())
                    <div class="p-16 text-center text-slate-400">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                            <i class="fas fa-route text-2xl opacity-20"></i>
                        </div>
                        <p class="text-sm font-bold capitalize tracking-tight opacity-40">Zero missions deployed</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[14px] font-black text-slate-400 capitalize tracking-tight">
                                <tr>
                                    <th class="px-6 py-4">Mission Id</th>
                                    <th class="px-6 py-4">Deployment Time</th>
                                    <th class="px-6 py-4">Client Entity</th>
                                    <th class="px-6 py-4">Revenue</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($rider->rides as $ride)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <code class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[14px] font-mono border border-slate-200">#{{ str_pad($ride->id, 5, '0', STR_PAD_LEFT) }}</code>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-slate-900">{{ $ride->created_at->format('M d, Y') }}</div>
                                        <div class="text-[14px] text-slate-400 capitalize tracking-tight">{{ $ride->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $ride->passenger->name ?? 'Guest User' }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-[#2F6B3F]">Tzs {{ number_format($ride->fare, 0) }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            ];
                                            $class = $statusClasses[$ride->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-black border capitalize tracking-tighter {{ $class }}">
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

        <!-- Security Clearance Card -->
        <div class="bg-rose-50 rounded-2xl shadow-lg border border-rose-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-100 bg-gradient-to-r from-rose-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-500/20">
                            <i class="fas fa-shield-alt text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-rose-900 font-bold text-base capitalize">Security Clearance</h4>
                            <p class="text-rose-700/70 text-sm capitalize">Operator termination protocol</p>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-rose-200/50 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-rose-600 text-xs"></i>
                        <span class="text-rose-600 text-xs font-bold ml-1 capitalize">Caution zone</span>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-6 p-4 bg-rose-100/50 rounded-xl border border-rose-200">
                    <p class="text-xs text-rose-700 font-bold capitalize tracking-wider flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i> 
                        Caution: These actions are permanent and affect data integrity
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <button onclick="showConfirmModal('delete', '{{ route('admin.rider.delete', $rider) }}', '{{ $rider->user->name }}', 'DELETE')" 
                            class="h-11 px-6 rounded-xl border border-rose-200 bg-white text-[11px] font-black text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm capitalize tracking-tight flex items-center gap-2">
                        <i class="fas fa-trash-alt text-xs"></i> Delete Rider Record
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection