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
            @forelse($riders as $rider)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ $rider->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($rider->user->name) . '&background=F1F5F9&color=64748B' }}" 
                                 class="h-10 w-10 rounded-full border border-slate-200 shadow-sm">
                            <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white {{ $rider->status === 'online' ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 leading-none">{{ $rider->user->name }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $rider->user->email }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-medium text-slate-900 leading-none">{{ $rider->phone_number }}</p>
                        <div class="flex items-center text-[10px] font-semibold text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-motorcycle mr-1.5 text-primary-500"></i>
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
                    @php
                        $statusClasses = [
                            'online' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'offline' => 'bg-slate-50 text-slate-500 border-slate-200',
                            'suspended' => 'bg-rose-50 text-rose-700 border-rose-200',
                        ];
                        $class = $statusClasses[$rider->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border uppercase {{ $class }}">
                        {{ $rider->status }}
                    </span>
                </td>
                <td class="text-center">
                    @if($rider->is_approved)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border uppercase bg-emerald-50 text-emerald-700 border-emerald-200">
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border uppercase bg-amber-50 text-amber-700 border-amber-200">
                            Pending
                        </span>
                    @endif
                </td>
                <td>
                     <div class="flex justify-end gap-2">
                         <a href="{{ route('admin.riders.show', $rider) }}" class="h-8 w-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 flex items-center justify-center transition-colors shadow-sm">
                             <i class="fas fa-eye text-[10px]"></i>
                         </a>
                         
                         @if(!$rider->is_approved)
                             <button onclick="showConfirmModal('approve', '{{ route('admin.rider.approve', $rider) }}', '{{ $rider->user->name }}')" 
                                     class="h-8 w-8 rounded-md border border-slate-200 bg-emerald-600 text-white hover:bg-emerald-700 flex items-center justify-center transition-colors shadow-sm">
                                 <i class="fas fa-check text-[10px]"></i>
                             </button>
                             <button onclick="showConfirmModal('reject', '{{ route('admin.rider.reject', $rider) }}', '{{ $rider->user->name }}')" 
                                     class="h-8 w-8 rounded-md border border-slate-200 bg-red-600 text-white hover:bg-red-700 flex items-center justify-center transition-colors shadow-sm">
                                 <i class="fas fa-times text-[10px]"></i>
                             </button>
                         @else
                             <button onclick="showConfirmModal('delete', '{{ route('admin.rider.delete', $rider) }}', '{{ $rider->user->name }}', 'DELETE')" 
                                     class="h-8 w-8 rounded-md border border-slate-200 bg-white text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors shadow-sm">
                                 <i class="fas fa-trash-alt text-[10px]"></i>
                             </button>
                         @endif
                     </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-12 text-slate-500 text-sm italic">No riders found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($riders->hasPages())
<div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-xl">
    {{ $riders->links() }}
</div>
@endif
