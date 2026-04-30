<div class="scn-table-container">
    <table class="scn-table">
                <thead>
                    <tr>
                        <th class="uppercase tracking-wider">Transaction ID</th>
                        <th class="uppercase tracking-wider">Rider Entity</th>
                        <th class="uppercase tracking-wider">Passenger Client</th>
                        <th class="uppercase tracking-wider">Revenue Unit</th>
                        <th class="uppercase tracking-wider text-center">Status</th>
                        <th class="uppercase tracking-wider">Deployment Date</th>
                        <th class="uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
        <tbody>
            @forelse($rides as $ride)
            <tr>
                <td>
                    <code class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-mono border border-slate-200">
                        #{{ str_pad($ride->id, 6, '0', STR_PAD_LEFT) }}
                    </code>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-md bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-motorcycle text-[10px]"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-900 truncate max-w-[120px]">{{ $ride->rider->user->name ?? 'Unknown' }}</span>
                    </div>
                </td>
                <td class="text-xs text-slate-600">{{ $ride->passenger->name ?? 'Guest' }}</td>
                <td class="text-sm font-semibold text-slate-900">TZS {{ number_format($ride->fare, 0) }}</td>
                <td class="text-center">
                    @php
                        $statusClasses = [
                            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'ongoing' => 'bg-sky-50 text-sky-700 border-sky-200',
                        ];
                        $class = $statusClasses[$ride->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium border {{ $class }}">
                        {{ ucfirst($ride->status) }}
                    </span>
                </td>
                <td class="text-xs text-slate-500 uppercase">{{ $ride->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.rides.show', $ride) }}" class="h-8 w-8 rounded-md border border-slate-200 bg-white text-blue-500 hover:bg-blue-50 hover:border-blue-200 flex items-center justify-center transition-colors shadow-sm" title="Audit Log">
                            <i class="fas fa-eye text-[10px]"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="h-24 text-center text-slate-500 text-sm italic">
                    No rides found in the historical archive.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($rides->hasPages())
<div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
    {{ $rides->links() }}
</div>
@endif
