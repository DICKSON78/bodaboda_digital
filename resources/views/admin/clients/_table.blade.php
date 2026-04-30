<div class="scn-table-container">
    <table class="scn-table">
                <thead>
                    <tr>
                        <th class="uppercase tracking-wider">Passenger Identity</th>
                        <th class="uppercase tracking-wider">Network Access</th>
                        <th class="uppercase tracking-wider">Ride Analytics</th>
                        <th class="uppercase tracking-wider text-center">Status</th>
                        <th class="uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ $client->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($client->name) . '&background=F1F5F9&color=64748B' }}" 
                                 class="h-10 w-10 rounded-full border border-slate-200 shadow-sm">
                            <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white {{ $client->suspended_at ? 'bg-rose-500' : 'bg-emerald-500' }}"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 leading-none">{{ $client->name }}</p>
                            <p class="text-xs text-slate-500 mt-1">ID: #{{ str_pad($client->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-medium text-slate-900 leading-none">{{ $client->email }}</p>
                        <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Joined {{ $client->created_at->format('M d, Y') }}</p>
                    </div>
                </td>
                <td>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-sky-50 text-sky-700 border border-sky-200">
                        {{ $client->rides_as_passenger_count ?? 0 }} Rides
                    </span>
                </td>
                <td class="text-center">
                    @if($client->suspended_at)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-rose-50 text-rose-700 border border-rose-200">
                            Suspended
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Active
                        </span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center justify-end gap-2">
                        <!-- View -->
                        <a href="{{ route('admin.clients.show', $client) }}" class="h-8 w-8 rounded-md border border-slate-200 bg-white text-blue-500 hover:bg-blue-50 hover:border-blue-200 flex items-center justify-center transition-colors shadow-sm" title="View Details">
                            <i class="fas fa-eye text-[10px]"></i>
                        </a>
                        
                        <!-- Suspend/Activate -->
                        @if($client->suspended_at)
                            <button onclick="showConfirmModal('activate', '{{ route('admin.client.activate', $client) }}', '{{ $client->name }}')" 
                                    class="h-8 w-8 rounded-md bg-emerald-600 text-white hover:bg-emerald-700 flex items-center justify-center transition-colors shadow-sm" title="Activate">
                                <i class="fas fa-user-check text-[10px]"></i>
                            </button>
                        @else
                            <button onclick="showConfirmModal('suspend', '{{ route('admin.client.suspend', $client) }}', '{{ $client->name }}')" 
                                    class="h-8 w-8 rounded-md bg-amber-600 text-white hover:bg-amber-700 flex items-center justify-center transition-colors shadow-sm" title="Suspend">
                                <i class="fas fa-user-slash text-[10px]"></i>
                            </button>
                        @endif
                        
                        <!-- Delete -->
                        <button onclick="showConfirmModal('delete', '{{ route('admin.client.delete', $client) }}', '{{ $client->name }}', 'DELETE')" 
                                class="h-8 w-8 rounded-md border border-slate-200 bg-white text-rose-500 hover:bg-rose-50 hover:border-rose-200 flex items-center justify-center transition-colors shadow-sm" title="Delete">
                            <i class="fas fa-trash text-[10px]"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="h-24 text-center text-slate-500 text-sm italic">
                    No clients found in the system.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($clients->hasPages())
<div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
    {{ $clients->links() }}
</div>
@endif
