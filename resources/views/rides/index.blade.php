@extends('layouts.app')

@section('content')
<div class="py-24 honeycomb min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 animate-in fade-in slide-in-from-top duration-700">
            <div class="badge-pill mb-4">
                <span class="badge-dot"></span>
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">History</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-text-primary tracking-tighter uppercase leading-none">Your Rides</h1>
        </div>

        <div class="scn-card animate-in fade-in slide-in-from-bottom duration-700">
            <div class="scn-card-content p-0">
                @if($rides->isEmpty())
                    <div class="text-center py-16 text-slate-400">
                        <div class="text-4xl mb-4 opacity-20">🛵</div>
                        <p class="font-black uppercase tracking-widest text-[10px]">No rides yet.</p>
                        @if(auth()->user()->role === 'passenger')
                            <a href="{{ route('rides.create') }}" class="inline-block mt-6 btn-primary py-4 px-8 text-sm uppercase tracking-widest">Request a Ride</a>
                        @endif
                    </div>
                @else
                    <div class="divide-y divide-slate-50">
                        @foreach($rides as $ride)
                            <a href="{{ route('rides.show', $ride) }}" class="flex items-center justify-between p-5 hover:bg-slate-50/50 transition duration-300 group">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 text-xl group-hover:bg-primary group-hover:text-white transition duration-500">
                                        <i class="fas fa-motorcycle"></i>
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 uppercase tracking-tight text-xs">Ride #{{ $ride->id }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[9px] font-bold text-slate-400">{{ $ride->created_at->format('M d, Y H:i') }}</span>
                                            <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[8px] font-black uppercase tracking-widest
                                                @if($ride->status === 'completed') text-success
                                                @elseif($ride->status === 'cancelled') text-red-500
                                                @else text-primary
                                                @endif">{{ $ride->status }}</span>
                                        </div>
                                        @if($ride->pickup_address)
                                            <div class="text-[10px] text-slate-400 mt-1">{{ $ride->pickup_address }} → {{ $ride->destination_address }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-primary">TZS {{ number_format($ride->fare) }}</div>
                                    <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mt-1 group-hover:text-primary transition">Details →</div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="p-6 border-t border-slate-50">
                        {{ $rides->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
