@extends('layouts.app')

@section('content')

{{-- ============================================================
     WELCOME PAGE — BodaBoda Digital  (REDESIGNED v2)
     Consistent with about.blade.php & services.blade.php:
     honeycomb bg · primary green · uppercase bold tracking
     card hover effects · blob glows · wave dividers
     NEW: testimonials, app download strip, animated counter,
          rider showcase, full-bleed CTA
     ============================================================ --}}

{{-- ── HERO ── --}}
<section class="relative min-h-[90vh] flex items-end bg-background overflow-hidden honeycomb pb-0">
    {{-- Ambient glows --}}
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/10 rounded-full blur-[160px] -translate-y-1/3 translate-x-1/4 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-0 left-0  w-[600px] h-[600px] bg-accent/10  rounded-full blur-[120px] translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 w-[400px] h-[400px] bg-primary/5 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Left copy --}}
            <div class="animate-in slide-in-from-left duration-1000">
                <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-8">
                    <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Dodoma's #1 Ride-Hailing</span>
                </div>

                <h1 class="text-7xl md:text-[96px] font-black text-text-primary tracking-tighter leading-[0.88] mb-6">
                    Smart <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-green">Mobility.</span>
                </h1>

                {{-- Typing animation strip --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-0.5 w-8 bg-primary/40 rounded-full"></div>
                    <div class="h-9">
                        <span class="text-xl md:text-2xl font-bold text-primary" id="typing-text"></span><span class="text-xl md:text-2xl font-bold text-primary animate-pulse">|</span>
                    </div>
                </div>

                <p class="text-xl text-text-secondary leading-relaxed max-w-lg mb-10">
                    Experience the future of BodaBoda — real-time tracking, transparent pricing, and professional riders at your fingertips across Dodoma.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('rides.create') }}"
                       class="btn-primary inline-flex items-center justify-center gap-3 px-10 py-5 text-sm uppercase tracking-widest shadow-2xl shadow-primary/30 hover:-translate-y-1 transition duration-300">
                        Book a Ride Now
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('about') }}"
                       class="btn-outline inline-flex items-center justify-center gap-3 px-10 py-5 text-sm uppercase tracking-widest hover:-translate-y-1 transition duration-300">
                        Learn More
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

                {{-- Trust strip --}}
                <div class="mt-10 flex items-center gap-6">
                    <div class="flex -space-x-3">
                        @foreach(['#2f6b3f','#3d8b52','#52a86c','#68c484'] as $c)
                        <div class="h-10 w-10 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-black" style="background:{{ $c }}">
                            ★
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <div class="text-sm font-black text-text-primary">10,000+ Happy Passengers</div>
                        <div class="text-xs text-text-secondary">★★★★★ 4.9 Average Rating</div>
                    </div>
                </div>
            </div>

            {{-- Right: stats + floating cards --}}
            <div class="animate-in slide-in-from-right duration-1000 delay-300 relative">
                {{-- Main stats grid --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['10K+',  'Happy Passengers',  'bg-primary text-white'],
                        ['50+',   'Active Riders Daily', 'bg-white border border-gray-100'],
                        ['4.9★',  'Avg Rating',          'bg-white border border-gray-100'],
                        ['3 Min', 'Avg Pickup Time',      'bg-white border border-gray-100'],
                    ] as [$val, $label, $cls])
                    <div class="rounded-[28px] p-7 text-center shadow-xl shadow-black/5 {{ $cls }}">
                        <div class="text-3xl font-black mb-1 {{ str_contains($cls,'bg-primary') ? 'text-white' : 'text-primary' }}">{{ $val }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest leading-tight {{ str_contains($cls,'bg-primary') ? 'text-white/70' : 'text-text-secondary' }}">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Floating badge --}}
                <div class="absolute -bottom-8 -right-4 z-20 bg-white rounded-3xl px-6 py-4 shadow-2xl shadow-black/10 border border-gray-100 transform rotate-2">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-primary/10 rounded-xl flex items-center justify-center">
                            <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-black text-text-primary uppercase tracking-wide">Verified Riders</div>
                            <div class="text-[10px] text-text-secondary">100% Background Checked</div>
                        </div>
                    </div>
                </div>

                {{-- Floating live indicator --}}
                <div class="absolute -top-4 -left-4 z-20 bg-primary text-white rounded-2xl px-5 py-3 shadow-xl shadow-primary/40 transform -rotate-1">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                        <span class="text-[11px] font-black uppercase tracking-wider">Live Tracking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none pointer-events-none">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-[80px]">
            <path d="M0,50 C300,90 600,10 900,50 C1100,80 1300,20 1440,50 L1440,80 L0,80 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

{{-- ── HOW IT WORKS ── --}}
<section class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-6">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Simple Process</span>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter mb-4 uppercase leading-none">
                Ride in <br> 3 Easy Steps
            </h2>
            <p class="text-lg text-text-secondary">Get moving in less than a minute — our process is optimized for speed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            {{-- Connector line (desktop) --}}
            <div class="hidden md:block absolute top-[72px] left-[calc(16.6%+40px)] right-[calc(16.6%+40px)] h-0.5 bg-gradient-to-r from-primary/20 via-primary/50 to-primary/20 z-0"></div>

            @foreach([
                ['Step 01', 'Set Pickup',         'Enter your location or drop a pin on our map. We\'ll find the nearest rider.',   'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'bg-primary/10'],
                ['Step 02', 'Select Destination', 'Choose your destination and see the exact fare before you confirm.',              'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'bg-accent/10'],
                ['Step 03', 'Enjoy the Ride',     'Your rider arrives in minutes. Track live, pay digitally, rate your experience.','M13 10V3L4 14h7v7l9-11h-7z', 'bg-success/10'],
            ] as [$step, $title, $body, $path, $iconBg])
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden text-center z-10">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-20 w-20 {{ $iconBg }} rounded-[24px] flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-3 transition duration-500">{{ $step }}</div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-4 transition duration-500">{{ $title }}</h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">{{ $body }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-14">
            <a href="{{ route('rides.create') }}" class="btn-primary inline-flex items-center gap-3 px-10 py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20">
                Book Your Ride
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ── SERVICES SECTION ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/8 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-accent/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div>
                <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-6">
                    <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">What We Offer</span>
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase leading-none mb-4">
                    Our <br> Services
                </h2>
                <p class="text-lg text-text-secondary max-w-md">Comprehensive mobility for every need — from quick rides to corporate logistics.</p>
            </div>
            <a href="{{ route('services') }}" class="btn-outline inline-flex items-center gap-2 px-7 py-4 text-sm uppercase tracking-widest whitespace-nowrap">
                All Services
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['01', 'Quick Ride',      'The fastest way to navigate Dodoma\'s streets with ease and reliability.',             'M13 10V3L4 14h7v7l9-11h-7z'],
                ['02', 'Parcel Delivery', 'Safe, swift delivery of parcels and documents anywhere in the city.',                  'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4'],
                ['03', 'Corporate Fleet', 'Reliable logistics and transport solutions tailored for Dodoma businesses.',            'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ] as [$num, $title, $body, $path])
            <div class="group relative bg-white rounded-[32px] p-10 hover:bg-primary transition duration-500 overflow-hidden cursor-pointer shadow-xl shadow-black/5 border border-gray-100/50">
                <div class="absolute top-6 right-6 text-6xl font-black text-primary/5 group-hover:text-white/10 transition duration-500 leading-none select-none">{{ $num }}</div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-primary/10 rounded-[24px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">{{ $title }}</h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">{{ $body }}</p>
                    <div class="mt-6 flex items-center gap-2 text-primary group-hover:text-white/80 transition duration-500">
                        <span class="text-sm font-black uppercase tracking-widest">Explore</span>
                        <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── LIVE STATS COUNTER STRIP ── --}}
<section class="py-20 bg-primary relative overflow-hidden">
    <div class="absolute inset-0 honeycomb opacity-10 pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/5 rounded-full blur-[80px] pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach([
                ['10,000+', 'Happy Passengers'],
                ['50+',     'Verified Riders'],
                ['3 Min',   'Avg Pickup Time'],
                ['4.9 / 5', 'Passenger Rating'],
            ] as [$num, $label])
            <div class="group">
                <div class="text-4xl md:text-5xl font-black text-white mb-2 group-hover:scale-110 transition duration-300">{{ $num }}</div>
                <div class="text-[11px] font-black text-white/60 uppercase tracking-[0.2em]">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US ── --}}
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div>
                <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase leading-none mb-4">
                    Why <br> Choose Us
                </h2>
                <p class="text-lg text-text-secondary max-w-md">The principles guiding every decision, every ride, every single day.</p>
            </div>
            <div class="text-[120px] font-black text-primary/5 leading-none select-none hidden lg:block">04</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['01', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Safety First',        'Every rider is vetted, trained, and equipped with safety gear before their first trip.'],
                ['02', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'Clear Pricing',        'See the full fare before confirming. No surge, no surprises, ever.'],
                ['03', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                                                                                                                                              'Quick Response',       'Average rider arrival under 3 minutes anywhere in Dodoma city.'],
                ['04', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',                                                   '24 / 7 Support',       'Our team is always on call — nights, weekends, and public holidays.'],
            ] as [$num, $path, $title, $body])
            <div class="group relative bg-background rounded-[32px] p-8 hover:bg-primary transition duration-500 overflow-hidden cursor-default">
                <div class="absolute top-4 right-6 text-7xl font-black text-primary/8 group-hover:text-white/10 transition duration-500 leading-none select-none">{{ $num }}</div>
                <div class="relative z-10">
                    <div class="h-14 w-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-7 w-7 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">{{ $title }}</h4>
                    <p class="text-sm text-text-secondary group-hover:text-white/75 leading-relaxed transition duration-500">{{ $body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── TESTIMONIALS ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-6">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Real Passengers</span>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase leading-none mb-4">
                What They Say
            </h2>
            <p class="text-lg text-text-secondary">Over 10,000 people trust BodaBoda every day in Dodoma.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['Amina J.',    'Dodoma Central',  '★★★★★', 'The best boda experience I\'ve ever had. The rider was punctual, polite, and the app showed me exactly where he was. Will use every day!'],
                ['Said M.',     'Makole Ward',     '★★★★★', 'Transparent pricing is what sold me. I knew the fare before I even booked. No haggling, no surprises. This is how boda should work.'],
                ['Grace K.',    'Chang\'ombe',     '★★★★★', 'Sent a package across Dodoma in under 20 minutes. The delivery service is incredibly fast. I use it for my small business now.'],
            ] as [$name, $location, $stars, $review])
            <div class="card p-8 group hover:bg-primary transition duration-500 border-none shadow-xl shadow-black/5 relative overflow-hidden">
                <div class="relative z-10">
                    <div class="text-primary group-hover:text-white/80 text-xl mb-4 transition duration-500">{{ $stars }}</div>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed mb-6 transition duration-500 italic">
                        "{{ $review }}"
                    </p>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100 group-hover:border-white/20 transition duration-500">
                        <div class="h-10 w-10 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-white/20 transition duration-500">
                            <span class="text-xs font-black text-primary group-hover:text-white transition duration-500">{{ substr($name, 0, 1) }}</span>
                        </div>
                        <div>
                            <div class="text-sm font-black text-text-primary group-hover:text-white uppercase tracking-wide transition duration-500">{{ $name }}</div>
                            <div class="text-[10px] text-text-secondary group-hover:text-white/60 uppercase tracking-wider transition duration-500">{{ $location }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CONTACT STRIP ── --}}
<section class="py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-black text-text-primary tracking-tighter uppercase mb-4 leading-none">
                Let's Connect
            </h2>
            <p class="text-lg text-text-secondary">Have questions or feedback? We're here to help you move better in Dodoma.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            <div class="card p-8 group hover:bg-primary transition duration-500 border-none shadow-xl shadow-black/5 flex items-center gap-6">
                <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition duration-500 shrink-0">
                    <svg class="h-8 w-8 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-1 transition">Call Center</div>
                    <div class="text-xl font-black text-text-primary group-hover:text-white transition">+255 700 000 000</div>
                </div>
            </div>
            <div class="card p-8 group hover:bg-primary transition duration-500 border-none shadow-xl shadow-black/5 flex items-center gap-6">
                <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition duration-500 shrink-0">
                    <svg class="h-8 w-8 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-1 transition">Email Support</div>
                    <div class="text-xl font-black text-text-primary group-hover:text-white transition">hi@bodaboda.co.tz</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── FULL-BLEED HERO CTA ── --}}
<section class="py-32 bg-primary relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-0 right-0 w-[700px] h-[700px] bg-white/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0  w-[600px] h-[600px] bg-white/5 rounded-full blur-[100px]  translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
    <div class="absolute inset-0 honeycomb opacity-10 pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-3 bg-white/10 border border-white/20 rounded-full px-5 py-2 mb-8">
            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
            <span class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Join Our Movement</span>
        </div>

        <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-[0.9] mb-8 uppercase">
            Your City, <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/50">Your Ride.</span>
        </h2>
        <p class="text-xl text-white/70 mb-14 max-w-xl mx-auto leading-relaxed">
            Whether you need a quick ride, a fast delivery, or a full corporate fleet — BodaBoda is the platform for Dodoma.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
            <a href="{{ route('rides.create') }}"
               class="inline-flex items-center justify-center gap-3 bg-white text-primary font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest shadow-2xl shadow-black/20 hover:shadow-black/30 hover:-translate-y-1 transition duration-300">
                Book a Ride
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('rider.apply') }}"
               class="inline-flex items-center justify-center gap-3 bg-white/10 border border-white/25 text-white font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest hover:bg-white/20 hover:-translate-y-1 transition duration-300">
                Become a Rider
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </a>
        </div>

        {{-- Bottom trust badges --}}
        <div class="flex flex-wrap justify-center gap-6">
            @foreach(['✓ No Hidden Fees', '✓ Live GPS Tracking', '✓ 24/7 Support', '✓ Verified Riders'] as $badge)
            <div class="flex items-center gap-2 text-white/70 text-sm font-bold">
                <span>{{ $badge }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<style>
/* ── Scroll reveal — identical to about.blade.php & services.blade.php ── */
.card { will-change: transform; }

@media (prefers-reduced-motion: no-preference) {
    [data-reveal] {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.22,1,0.36,1);
    }
    [data-reveal].revealed {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    /* Scroll reveal */
    document.querySelectorAll('.card, section > .max-w-7xl > *').forEach((el, i) => {
        el.setAttribute('data-reveal', '');
        el.style.transitionDelay = (i * 60) + 'ms';
    });
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('revealed');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));

    /* ── Typing animation ── */
    const words = ['Fastest Deliveries', 'Safe City Rides', 'Corporate Logistics', 'Real-time Tracking'];
    let wordIndex = 0, charIndex = 0, isDeleting = false;
    const el = document.getElementById('typing-text');

    function type() {
        const word = words[wordIndex];
        if (isDeleting) {
            el.textContent = word.substring(0, charIndex - 1);
            charIndex--;
        } else {
            el.textContent = word.substring(0, charIndex + 1);
            charIndex++;
        }
        let delta = isDeleting ? 50 : 100;
        if (!isDeleting && charIndex === word.length) { isDeleting = true; delta = 2000; }
        else if (isDeleting && charIndex === 0)        { isDeleting = false; wordIndex = (wordIndex + 1) % words.length; delta = 500; }
        setTimeout(type, delta);
    }
    type();
});
</script>
@endpush

@endsection