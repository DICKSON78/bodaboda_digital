@extends('layouts.admin')

@section('title', 'Settings - BodaBoda Admin Panel')
@section('page-title', 'System Settings')
@section('page-subtitle', 'Configure platform preferences and security')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Navigation Tabs -->
    <div class="lg:col-span-1">
        <!-- Settings Categories Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-900 font-bold text-base">Settings Categories</h3>
                        <p class="text-slate-500 text-sm">Configure specific platform layers</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-[#2F6B3F]/10 flex items-center justify-center text-[#2F6B3F]">
                        <i class="fas fa-sliders-h text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <nav class="flex flex-col gap-1">
                    <button class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl bg-[#2F6B3F] text-white shadow-lg transition-all">
                        <i class="fas fa-cog text-xs"></i>
                        General Core
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#2F6B3F] transition-all">
                        <i class="fas fa-lock text-xs opacity-70"></i>
                        Security Protocol
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#2F6B3F] transition-all">
                        <i class="fas fa-bell text-xs opacity-70"></i>
                        Alert Network
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#2F6B3F] transition-all">
                        <i class="fas fa-database text-xs opacity-70"></i>
                        System Archives
                    </button>
                </nav>
            </div>
        </div>
        
        <!-- Technical Oversight Card - Consistent with SHADC Design -->
        <div class="mt-6 relative overflow-hidden bg-gradient-to-br from-[#2F6B3F] to-[#1a3d26] rounded-2xl shadow-xl p-6 text-white border border-[#2F6B3F]/20 hover:shadow-2xl transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full -ml-12 -mb-12"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center shadow-lg">
                        <i class="fas fa-microchip text-xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black mb-0">Technical Oversight</h3>
                        <p class="text-white/70 text-xs font-medium uppercase tracking-widest">Hardware & Network Diagnostics</p>
                    </div>
                </div>
                <p class="text-sm text-white/80 leading-relaxed mb-6">
                    Access advanced engineering support for hardware and network level platform diagnostics.
                </p>
                <button class="w-full h-12 rounded-xl border border-white/30 bg-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-white/20 transition-all backdrop-blur-md shadow-lg hover:shadow-xl">
                    Request Diagnostics →
                </button>
            </div>
        </div>
    </div>

    <!-- Right Column: Core Parameters Form -->
    <div class="lg:col-span-2">
        <!-- Core Parameters Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-900 font-bold text-base">Core Parameters</h3>
                        <p class="text-slate-500 text-sm">Configure the fundamental platform logic</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-[#2F6B3F]/10 flex items-center justify-center text-[#2F6B3F]">
                        <i class="fas fa-sliders-h text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-fingerprint text-[10px] text-[#2F6B3F]"></i> Platform Identity
                            </label>
                            <input type="text" value="BodaBoda Digital" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-at text-[10px] text-[#2F6B3F]"></i> Network Gateway
                            </label>
                            <input type="email" value="support@bodaboda.digital" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-money-bill-wave text-[10px] text-[#2F6B3F]"></i> Base Currency Unit (TZS)
                            </label>
                            <input type="number" value="1000" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-black text-[#2F6B3F] focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-tachometer-alt text-[10px] text-[#2F6B3F]"></i> Mobility Coefficient (Per KM)
                            </label>
                            <input type="number" value="500" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-black text-[#2F6B3F] focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" class="h-12 px-6 rounded-xl border border-slate-200 bg-white text-xs font-black text-slate-600 hover:bg-slate-50 hover:border-[#2F6B3F]/30 transition-all uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-undo-alt text-[11px]"></i> Cancel
                        </button>
                        <button type="button" class="h-12 px-8 rounded-xl bg-[#2F6B3F] text-xs font-black text-white hover:bg-[#235031] transition-all shadow-lg flex items-center gap-2 uppercase tracking-widest">
                            <i class="fas fa-save text-[11px]"></i> Commit Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone - Consistent Design -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg border border-rose-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-100 bg-gradient-to-r from-rose-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-500/20">
                            <i class="fas fa-skull-crossbones text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-rose-900 font-bold text-base">Critical Operations</h3>
                            <p class="text-rose-700/70 text-sm">System termination layer</p>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-rose-100 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-rose-600 text-xs"></i>
                        <span class="text-rose-600 text-xs font-bold ml-1">Warning Zone</span>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-6 p-4 bg-rose-50 rounded-xl border border-rose-200">
                    <p class="text-xs text-rose-700 font-bold uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i> 
                        Warning: These actions bypass safety protocols and cannot be undone
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <button class="h-11 px-6 rounded-xl border border-rose-200 bg-white text-[11px] font-black text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-trash-alt text-[10px]"></i> Flush System Cache
                    </button>
                    <button class="h-11 px-6 rounded-xl border border-rose-200 bg-white text-[11px] font-black text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-sync-alt text-[10px]"></i> Reset Search Indices
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection