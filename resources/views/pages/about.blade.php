@extends('layouts.app')

@section('content')

{{-- ============================================================
     ABOUT PAGE — BodaBoda Digital
     Design: matches welcome.blade.php — honeycomb bg, primary green,
     uppercase tracking, card hover effects, blob glows
     ============================================================ --}}

{{-- ── HERO ── --}}
<section class="relative min-h-[70vh] flex items-end bg-background overflow-hidden honeycomb pb-0">
    {{-- Ambient glows --}}
    <div class="absolute top-0 right-0 w-[700px] h-[700px] bg-primary/10 rounded-full blur-[140px] -translate-y-1/3 translate-x-1/4 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-0 left-0  w-[500px] h-[500px] bg-accent/10  rounded-full blur-[100px]  translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-end">

            {{-- Left copy --}}
            <div class="animate-in slide-in-from-left duration-1000">
                <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-8">
                    <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Our Story</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black text-text-primary tracking-tighter leading-[0.88] mb-6">
                    Riding <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-green">Forward.</span>
                </h1>
                <p class="text-xl text-text-secondary leading-relaxed max-w-lg">
                    Tanzania's most trusted motorcycle ride-hailing platform — built for Dodoma, powered by community.
                </p>
            </div>

            {{-- Right stats strip --}}
            <div class="animate-in slide-in-from-right duration-1000 delay-200">
                <div class="grid grid-cols-3 gap-4">
                    @foreach([
                        ['10K+',  'Active Riders'],
                        ['50K+',  'Happy Riders'],
                        ['4.9★',  'Avg Rating'],
                    ] as $stat)
                    <div class="bg-white/70 backdrop-blur border border-white rounded-3xl p-6 text-center shadow-xl shadow-black/5">
                        <div class="text-3xl font-black text-primary mb-1">{{ $stat[0] }}</div>
                        <div class="text-[10px] font-black text-text-secondary uppercase tracking-widest leading-tight">{{ $stat[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none pointer-events-none">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-[60px]">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

{{-- ── WHO WE ARE ── --}}
<section class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">

            {{-- Image collage --}}
            <div class="relative animate-in zoom-in duration-1000">
                <div class="absolute -top-16 -left-16 w-80 h-80 bg-primary/5 rounded-full blur-[80px]"></div>

                {{-- Main card --}}
                <div class="relative z-10 rounded-[48px] overflow-hidden shadow-2xl border-[14px] border-white transform -rotate-2">
                    <img src="{{ asset('assets/images/hands.png') }}" alt="Team" class="w-full h-[480px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/70 to-transparent"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <div class="text-4xl font-black mb-1">Since 2022</div>
                        <div class="text-xs font-black uppercase tracking-[0.2em] opacity-80">Serving Dodoma</div>
                    </div>
                </div>

                {{-- Floating badge --}}
                <div class="absolute -bottom-6 -right-6 z-20 bg-primary text-white rounded-3xl px-7 py-5 shadow-2xl shadow-primary/40 transform rotate-3">
                    <div class="text-2xl font-black leading-none">100%</div>
                    <div class="text-[10px] font-black uppercase tracking-widest opacity-80 mt-1">Locally Built</div>
                </div>
            </div>

            {{-- Copy --}}
            <div class="animate-in slide-in-from-right duration-1000 delay-200">
                <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-8 leading-[0.9]">
                    Who <br> We Are
                </h2>
                <div class="space-y-5 text-text-secondary leading-relaxed text-lg mb-12">
                    <p>BodaBoda is Tanzania's premier motorcycle ride-hailing platform, built specifically for the streets and people of Dodoma.</p>
                    <p>We believe in formalising the informal. Our platform equips local riders with world-class tools — GPS tracking, digital payments, safety protocols — while giving passengers unmatched peace of mind.</p>
                    <p>Every ride creates opportunity. Every trip builds trust.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('rides.create') }}" class="btn-primary px-8 py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 flex items-center justify-center gap-3">
                        Book a Ride
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#contact" class="btn-outline px-8 py-5 text-sm uppercase tracking-widest flex items-center justify-center">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── MISSION & VISION ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/8 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-none">
                What Drives Us
            </h2>
            <p class="text-lg text-text-secondary">Our purpose is bigger than a ride. It's about building the future of Dodoma's mobility.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Mission --}}
            <div class="card p-12 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mb-8 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-8 w-8 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-3 transition duration-500">Our Mission</div>
                    <h3 class="text-3xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-5 transition duration-500 leading-tight">
                        Seamless Connectivity
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        To provide fast, safe, and affordable transport to every corner of Dodoma — making the city smaller, closer, and more livable for all.
                    </p>
                </div>
            </div>

            {{-- Vision --}}
            <div class="card p-12 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden">
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mb-8 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-8 w-8 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-3 transition duration-500">Our Vision</div>
                    <h3 class="text-3xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-5 transition duration-500 leading-tight">
                        Most Trusted Partner
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        To become the most trusted mobility partner for every citizen in Tanzania's capital — setting the standard for digital transport across East Africa.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── VALUES ── --}}
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div>
                <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase leading-none mb-4">
                    Our <br> Core Values
                </h2>
                <p class="text-lg text-text-secondary max-w-md">The principles that guide every decision, every ride, every day.</p>
            </div>
            <div class="text-[120px] font-black text-primary/5 leading-none select-none hidden lg:block">04</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                [
                    'num'   => '01',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                    'title' => 'Safety First',
                    'body'  => 'Every rider goes through rigorous background checks and mandatory helmet protocols.',
                ],
                [
                    'num'   => '02',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'title' => 'Transparent Pricing',
                    'body'  => 'What you see is what you pay — no surge surprises, no hidden fees.',
                ],
                [
                    'num'   => '03',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'title' => 'Community First',
                    'body'  => 'We invest in our riders — better income, better tools, better lives.',
                ],
                [
                    'num'   => '04',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                    'title' => 'Always Improving',
                    'body'  => 'We iterate daily based on real feedback from riders and passengers alike.',
                ],
            ] as $val)
            <div class="group relative bg-background rounded-[32px] p-8 hover:bg-primary transition duration-500 overflow-hidden cursor-default">
                {{-- Big number watermark --}}
                <div class="absolute top-4 right-6 text-7xl font-black text-primary/8 group-hover:text-white/10 transition duration-500 leading-none select-none">
                    {{ $val['num'] }}
                </div>
                <div class="relative z-10">
                    <div class="h-14 w-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-7 w-7 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $val['icon'] !!}
                        </svg>
                    </div>
                    <h4 class="text-lg font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        {{ $val['title'] }}
                    </h4>
                    <p class="text-sm text-text-secondary group-hover:text-white/75 leading-relaxed transition duration-500">
                        {{ $val['body'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── TIMELINE ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-4 leading-none">
                Our Journey
            </h2>
            <p class="text-lg text-text-secondary">From idea to Dodoma's go-to mobility platform.</p>
        </div>

        <div class="relative">
            {{-- Vertical line --}}
            <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary via-primary/40 to-transparent -translate-x-1/2 hidden md:block"></div>

            <div class="space-y-12">
                @foreach([
                    ['2022', 'Founded',              'BodaBoda launched with 5 riders in Dodoma Central.',            'left'],
                    ['2023', '1,000 Rides',          'Reached our first 1,000 completed rides in under 6 months.',   'right'],
                    ['2023', 'Live Tracking',        'Introduced real-time GPS tracking for every ride.',             'left'],
                    ['2024', '10,000+ Users',        'Crossed 10,000 registered passengers across Dodoma City.',     'right'],
                    ['2025', 'Corporate Tier',       'Launched our corporate logistics and delivery service.',        'left'],
                ] as [$year, $title, $body, $side])
                <div class="relative flex items-center {{ $side === 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }} flex-col md:gap-12 gap-4">
                    {{-- Content card --}}
                    <div class="md:w-[calc(50%-2rem)] w-full">
                        <div class="card p-8 group hover:bg-primary transition duration-500 border-none shadow-xl shadow-black/5">
                            <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-2 transition duration-500">{{ $year }}</div>
                            <h4 class="text-xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">{{ $title }}</h4>
                            <p class="text-sm text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">{{ $body }}</p>
                        </div>
                    </div>

                    {{-- Centre dot --}}
                    <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 h-6 w-6 rounded-full bg-primary border-4 border-white shadow-lg z-10 items-center justify-center">
                        <div class="h-2 w-2 rounded-full bg-white"></div>
                    </div>

                    {{-- Empty space on other side --}}
                    <div class="md:w-[calc(50%-2rem)] hidden md:block"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ── TEAM CTA ── --}}
<section class="py-32 bg-primary relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-white/5 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0  w-[500px] h-[500px] bg-white/5 rounded-full blur-[80px]  translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
    {{-- Honeycomb texture overlay --}}
    <div class="absolute inset-0 honeycomb opacity-10 pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-3 bg-white/10 border border-white/20 rounded-full px-5 py-2 mb-8">
            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
            <span class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Join Our Movement</span>
        </div>

        <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-[0.9] mb-8 uppercase">
            Ride With <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/60">
                Purpose.
            </span>
        </h2>
        <p class="text-xl text-white/70 mb-14 max-w-xl mx-auto leading-relaxed">
            Whether you're looking for a ride or want to become a rider, BodaBoda is the platform for you.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('rides.create') }}"
               class="inline-flex items-center justify-center gap-3 bg-white text-primary font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest shadow-2xl shadow-black/20 hover:shadow-black/30 hover:-translate-y-0.5 transition duration-300">
                Book a Ride
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="#"
               class="inline-flex items-center justify-center gap-3 bg-white/10 border border-white/25 text-white font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest hover:bg-white/20 hover:-translate-y-0.5 transition duration-300">
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
/* ── scroll-reveal for timeline items ── */
.card {
    will-change: transform;
}

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
    /* Add reveal attribute to cards/sections */
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
});
</script>
@endpush

@endsection
