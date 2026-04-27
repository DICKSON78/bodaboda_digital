@extends('layouts.app')

@section('content')
{{-- ============================================================
     SERVICES PAGE — BodaBoda Digital
     Design: matches welcome.blade.php & about.blade.php
     honeycomb bg, primary green, uppercase tracking,
     card hover effects, blob glows, service categories
     ============================================================ --}}

{{-- ── HERO ── --}}
<section class="relative min-h-[60vh] flex items-end bg-background overflow-hidden honeycomb pb-0">
    {{-- Ambient glows --}}
    <div class="absolute top-0 right-0 w-[700px] h-[700px] bg-primary/10 rounded-full blur-[140px] -translate-y-1/3 translate-x-1/4 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-accent/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-20">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-8">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">What We Offer</span>
            </div>
            <h1 class="text-6xl md:text-7xl font-black text-text-primary tracking-tighter leading-[0.9] mb-6">
                Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-green">Services.</span>
            </h1>
            <p class="text-xl text-text-secondary leading-relaxed max-w-xl mx-auto">
                Comprehensive mobility solutions for every need — from quick rides to corporate logistics.
            </p>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none pointer-events-none">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-[60px]">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

{{-- ── MAIN SERVICES GRID ── --}}
<section class="py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            {{-- Service 1: City Ride --}}
            <div class="group relative bg-background rounded-[32px] p-10 hover:bg-primary transition duration-500 overflow-hidden cursor-pointer shadow-xl shadow-black/5 border border-gray-100">
                <div class="absolute top-6 right-6 text-6xl font-black text-primary/5 group-hover:text-white/10 transition duration-500 leading-none select-none">
                    01
                </div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-primary/10 rounded-[24px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        {{-- Motorcycle / Ride Icon --}}
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        City Ride
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Quick and efficient transportation within Dodoma city limits. Get to your destination in minutes with our professional riders.
                    </p>
                    <div class="mt-6 flex items-center gap-2 text-primary group-hover:text-white/80 transition duration-500">
                        <span class="text-sm font-bold uppercase tracking-wider">Book Now</span>
                        <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Service 2: Instant Delivery --}}
            <div class="group relative bg-background rounded-[32px] p-10 hover:bg-primary transition duration-500 overflow-hidden cursor-pointer shadow-xl shadow-black/5 border border-gray-100">
                <div class="absolute top-6 right-6 text-6xl font-black text-primary/5 group-hover:text-white/10 transition duration-500 leading-none select-none">
                    02
                </div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-primary/10 rounded-[24px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        {{-- Package / Delivery Icon --}}
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 0v4m0-4h4m-4 0H8"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        Instant Delivery
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Need a package delivered? Our riders can handle small parcels, documents, and goods with care and speed across Dodoma.
                    </p>
                    <div class="mt-6 flex items-center gap-2 text-primary group-hover:text-white/80 transition duration-500">
                        <span class="text-sm font-bold uppercase tracking-wider">Send Package</span>
                        <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Service 3: Corporate Fleet --}}
            <div class="group relative bg-background rounded-[32px] p-10 hover:bg-primary transition duration-500 overflow-hidden cursor-pointer shadow-xl shadow-black/5 border border-gray-100">
                <div class="absolute top-6 right-6 text-6xl font-black text-primary/5 group-hover:text-white/10 transition duration-500 leading-none select-none">
                    03
                </div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-primary/10 rounded-[24px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        {{-- Corporate / Building Icon --}}
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        Corporate Fleet
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Customized transportation solutions for businesses and organizations in Dodoma. Dedicated riders, priority support.
                    </p>
                    <div class="mt-6 flex items-center gap-2 text-primary group-hover:text-white/80 transition duration-500">
                        <span class="text-sm font-bold uppercase tracking-wider">Contact Sales</span>
                        <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── EXTENDED SERVICES (with features) ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-none">
                Why Choose <br> Our Services?
            </h2>
            <p class="text-lg text-text-secondary">Every service is backed by our commitment to safety, transparency, and reliability.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['shield', 'Safety First', 'All riders are vetted, trained, and equipped with safety gear.'],
                ['currency', 'Transparent Pricing', 'No surge pricing. See the fare before you confirm.'],
                ['clock', 'Quick Response', 'Average arrival time of under 5 minutes in Dodoma.'],
                ['headset', '24/7 Support', 'Our customer service team is always ready to help.'],
            ] as $feature)
            <div class="text-center p-8 bg-white rounded-[32px] shadow-xl shadow-black/5 hover:shadow-2xl transition duration-500 group">
                <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mx-auto mb-5 group-hover:bg-primary transition duration-500">
                    @if($feature[0] == 'shield')
                    <svg class="h-8 w-8 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    @elseif($feature[0] == 'currency')
                    <svg class="h-8 w-8 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @elseif($feature[0] == 'clock')
                    <svg class="h-8 w-8 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @elseif($feature[0] == 'headset')
                    <svg class="h-8 w-8 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.972 5.972 0 00-.841-2.373m-4.983 5.521c-.293.081-.594.133-.904.133-.31 0-.611-.052-.904-.133m4.983-5.521c-.375-.691-.902-1.289-1.537-1.723m-2.542 2.244c.375-.691.902-1.289 1.537-1.723m-2.542 2.244c.124.118.257.226.397.323m-2.363-1.657a5.972 5.972 0 01-.841 2.373m0 0c-.375.691-.902 1.289-1.537 1.723m0 0a5.972 5.972 0 01-.841-2.373m0 0c.375-.691.902-1.289 1.537-1.723m-2.542 2.244c-.124.118-.257.226-.397.323"/>
                    </svg>
                    @endif
                </div>
                <h4 class="text-base font-black text-text-primary uppercase tracking-tight mb-2 group-hover:text-primary transition">{{ $feature[1] }}</h4>
                <p class="text-sm text-text-secondary">{{ $feature[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── PRICING / PACKAGES ── --}}
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-6">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Transparent Pricing</span>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-none">
                Simple, Fair <br> Rates.
            </h2>
            <p class="text-lg text-text-secondary">No hidden fees. What you see is what you pay.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            {{-- City Ride Pricing --}}
            <div class="bg-background rounded-[32px] p-8 text-center hover:shadow-2xl transition duration-500 border border-gray-100">
                <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-2">City Ride</h3>
                <div class="text-4xl font-black text-primary my-4">TZS 1,500</div>
                <p class="text-sm text-text-secondary mb-6">Starting fare</p>
                <ul class="text-left space-y-3 text-sm">
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> 2km included</li>
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> TZS 500 per additional km</li>
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> Free waiting (5 mins)</li>
                </ul>
            </div>

            {{-- Instant Delivery Pricing --}}
            <div class="bg-background rounded-[32px] p-8 text-center hover:shadow-2xl transition duration-500 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-primary text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">Popular</div>
                <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-2">Instant Delivery</h3>
                <div class="text-4xl font-black text-primary my-4">TZS 2,000</div>
                <p class="text-sm text-text-secondary mb-6">Starting fare</p>
                <ul class="text-left space-y-3 text-sm">
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> 3km included</li>
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> TZS 400 per additional km</li>
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> Insurance included</li>
                </ul>
            </div>

            {{-- Corporate Fleet Pricing --}}
            <div class="bg-background rounded-[32px] p-8 text-center hover:shadow-2xl transition duration-500 border border-gray-100">
                <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-2">Corporate Fleet</h3>
                <div class="text-4xl font-black text-primary my-4">Custom</div>
                <p class="text-sm text-text-secondary mb-6">Tailored to your needs</p>
                <ul class="text-left space-y-3 text-sm">
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> Dedicated account manager</li>
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> Monthly invoicing</li>
                    <li class="flex items-center gap-2"><span class="text-primary">✓</span> Priority dispatch</li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('rides.create') }}" class="btn-primary inline-flex items-center gap-3 px-10 py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20">
                Book a Ride Now
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ── HOW IT WORKS (quick steps) ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-none">
                How It Works
            </h2>
            <p class="text-lg text-text-secondary">Get moving in less than a minute. Our process is optimized for speed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center group">
                <div class="h-24 w-24 bg-primary/5 rounded-[32px] flex items-center justify-center mx-auto mb-8 group-hover:bg-primary group-hover:text-white transition duration-500 transform group-hover:scale-110">
                    <svg class="h-10 w-10 text-primary group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-3">1. Set Pickup</h3>
                <p class="text-text-secondary text-sm">Enter your current location or drop a pin on our map.</p>
            </div>
            <div class="text-center group">
                <div class="h-24 w-24 bg-accent/5 rounded-[32px] flex items-center justify-center mx-auto mb-8 group-hover:bg-accent group-hover:text-white transition duration-500 transform group-hover:scale-110">
                    <svg class="h-10 w-10 text-primary group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-3">2. Select Destination</h3>
                <p class="text-text-secondary text-sm">Choose where you're going and see the estimate instantly.</p>
            </div>
            <div class="text-center group">
                <div class="h-24 w-24 bg-success/5 rounded-[32px] flex items-center justify-center mx-auto mb-8 group-hover:bg-success group-hover:text-white transition duration-500 transform group-hover:scale-110">
                    <svg class="h-10 w-10 text-primary group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-3">3. Enjoy the Ride</h3>
                <p class="text-text-secondary text-sm">A nearby rider will pick you up and take you there safely.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── CTA SECTION ── --}}
<section class="py-24 bg-primary relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-white/5 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-white/5 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-3 bg-white/10 border border-white/20 rounded-full px-5 py-2 mb-8">
            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
            <span class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Ready To Ride?</span>
        </div>
        <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-[1.1] mb-6 uppercase">
            Experience The <br> BodaBoda Difference
        </h2>
        <p class="text-xl text-white/70 mb-10 max-w-xl mx-auto">
            Download the app or book online — your ride is just a tap away.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('rides.create') }}" class="inline-flex items-center justify-center gap-3 bg-white text-primary font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest shadow-xl hover:-translate-y-0.5 transition duration-300">
                Book a Ride
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="#" class="inline-flex items-center justify-center gap-3 bg-white/10 border border-white/25 text-white font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest hover:bg-white/20 hover:-translate-y-0.5 transition duration-300">
                Become a Rider
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<style>
    .animate-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .animate-in.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Card hover animations */
    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(4px);
    }
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Add reveal animation to elements
        document.querySelectorAll('.group, section .max-w-7xl > .text-center, .grid > .bg-background').forEach((el, i) => {
            if (!el.hasAttribute('data-reveal')) {
                el.setAttribute('data-reveal', '');
                el.style.opacity = '0';
                el.style.transform = 'translateY(24px)';
                el.style.transition = `opacity 0.6s ease, transform 0.6s cubic-bezier(0.22, 1, 0.36, 1)`;
                el.style.transitionDelay = `${(i % 6) * 80}ms`;
            }
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.style.opacity = '1';
                    e.target.style.transform = 'translateY(0)';
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));
    });
</script>
@endpush

@endsection