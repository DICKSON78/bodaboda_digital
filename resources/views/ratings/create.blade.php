@extends('layouts.app')

@section('content')
<div class="pt-32 pb-20 min-h-screen bg-background relative overflow-hidden">
    <div class="honeycomb absolute inset-0 opacity-10"></div>
    
    <div class="max-w-md mx-auto px-4 relative z-10">
        <div class="card p-12 animate-in fade-in zoom-in duration-700">
            <div class="text-center mb-12">
                <div class="h-16 w-16 bg-accent/10 rounded-2xl flex items-center justify-center text-accent mx-auto mb-6 group-hover:rotate-12 transition">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
                <h1 class="text-4xl font-black text-primary tracking-tighter uppercase mb-2">Rate Your Experience</h1>
                <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest">How was your ride with {{ $toUser->name }}?</p>
            </div>

            <form action="{{ route('ratings.store', $ride) }}" method="POST" class="space-y-10">
                @csrf
                
                <div class="flex justify-center space-x-4 mb-12">
                    @foreach(range(1, 5) as $i)
                        <label class="cursor-pointer group relative">
                            <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                            <div class="relative">
                                <svg class="h-16 w-16 text-gray-200 peer-checked:text-accent group-hover:text-accent/50 transition-all duration-300 transform group-hover:scale-110 peer-checked:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                @if($i == 1)
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-[8px] text-text-secondary font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Poor</span>
                                @elseif($i == 2)
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-[8px] text-text-secondary font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Fair</span>
                                @elseif($i == 3)
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-[8px] text-text-secondary font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Good</span>
                                @elseif($i == 4)
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-[8px] text-text-secondary font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Great</span>
                                @else
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-[8px] text-text-secondary font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Excellent</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Add a Comment (Optional)</label>
                    <textarea name="comment" rows="4" 
                        class="w-full px-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold text-sm resize-none" 
                        placeholder="Share your experience..."></textarea>
                </div>

                <button type="submit" class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 group">
                    Submit Rating
                    <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
