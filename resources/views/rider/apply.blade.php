@extends('layouts.app')

@section('content')
<div class="pt-32 pb-20 min-h-screen bg-background relative overflow-hidden">
    <div class="honeycomb absolute inset-0 opacity-10"></div>
    
    <div class="max-w-2xl mx-auto px-4 relative z-10">
        <div class="card p-12 animate-in fade-in zoom-in duration-700">
            <div class="text-center mb-12">
                <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-6 group-hover:rotate-12 transition">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h1 class="text-4xl font-black text-primary tracking-tighter uppercase mb-2">Become a Rider</h1>
                <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Join our network of professional riders</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-error/10 border border-error/20 rounded-2xl text-error text-xs font-bold uppercase tracking-tight">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('rider.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Driving License Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-secondary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <input type="text" name="license_number" id="license_number" required 
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold text-sm" 
                            placeholder="e.g. DL123456">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Bike Plate Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-secondary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <input type="text" name="bike_plate" id="bike_plate" required 
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold text-sm" 
                            placeholder="e.g. T123ABC">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Bike Image</label>
                    <div class="relative">
                        <input type="file" name="bike_image" id="bike_image" accept="image/*" 
                            class="w-full px-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                    <p class="text-xs text-text-secondary">Upload a clear photo of your motorcycle (optional)</p>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 group">
                        Submit Application
                        <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
