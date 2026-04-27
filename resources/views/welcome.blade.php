@extends('layouts.app')

@section('content')

{{-- ============================================================
     WELCOME PAGE — BodaBoda Digital
     Design: matches about.blade.php — honeycomb bg, primary green,
     uppercase tracking, card hover effects, blob glows
     ============================================================ --}}

{{-- ── HERO ── --}}
<section class="relative min-h-[70vh] flex items-end bg-background overflow-hidden honeycomb pb-0">
    {{-- Ambient glows --}}
    <div class="absolute top-0 right-0 w-[700px] h-[700px] bg-primary/10 rounded-full blur-[140px] -translate-y-1/3 translate-x-1/4 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-accent/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-end">

            {{-- Left copy --}}
            <div class="animate-in slide-in-from-left duration-1000">
                <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-8">
                    <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Dodoma's #1 Ride-Hailing</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black text-text-primary tracking-tighter leading-[0.88] mb-6">
                    Smart <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-green">Mobility.</span>
                </h1>
                <div class="h-12 mb-4">
                    <span class="text-2xl md:text-3xl font-bold text-primary" id="typing-text"></span>
                    <span class="text-2xl md:text-3xl font-bold text-primary animate-pulse">|</span>
                </div>
                <p class="text-xl text-text-secondary leading-relaxed max-w-lg">
                    Experience the future of BodaBoda — real-time tracking, transparent pricing, and professional riders at your service.
                </p>
            </div>

            {{-- Right stats strip --}}
            <div class="animate-in slide-in-from-right duration-1000 delay-200">
                <div class="grid grid-cols-3 gap-4">
                    @foreach([
                        ['10K+',  'Happy Riders'],
                        ['50+',   'Active Daily'],
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

{{-- ── HOW IT WORKS ── --}}
<section class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-6">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Simple Process</span>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter mb-6 uppercase">Easy 3 Steps</h2>
            <p class="text-lg text-text-secondary">Get moving in less than a minute. Our process is optimized for speed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Step 1 --}}
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden text-center">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-primary/10 rounded-[24px] flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-3 transition duration-500">Step 01</div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-4 transition duration-500">
                        Set Pickup
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Enter your current location or drop a pin on our map.
                    </p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden text-center">
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-accent/10 rounded-[24px] flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-3 transition duration-500">Step 02</div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-4 transition duration-500">
                        Select Destination
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Choose where you're going and see the estimate instantly.
                    </p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden text-center">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-success/10 rounded-[24px] flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-10 w-10 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] font-black text-primary group-hover:text-white/70 uppercase tracking-[0.2em] mb-3 transition duration-500">Step 03</div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-4 transition duration-500">
                        Enjoy the Ride
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        A nearby rider will pick you up and take you there safely.
                    </p>
                </div>
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

{{-- ── SERVICES SECTION ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/8 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-none">
                Our Services
            </h2>
            <p class="text-lg text-text-secondary">We offer a range of services tailored to meet the needs of every citizen in Dodoma.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Quick Ride --}}
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-8 w-8 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        Quick Ride
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        The fastest way to navigate through Dodoma's traffic with ease.
                    </p>
                </div>
            </div>

            {{-- Parcel Delivery --}}
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden">
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-8 w-8 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        Parcel Delivery
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Safe and secure delivery of your items across the city instantly.
                    </p>
                </div>
            </div>

            {{-- Corporate --}}
            <div class="card p-10 group hover:bg-primary transition duration-500 border-none shadow-2xl shadow-black/5 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:bg-white/5 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="h-16 w-16 bg-primary/10 rounded-[20px] flex items-center justify-center mb-6 group-hover:bg-white/20 transition duration-500">
                        <svg class="h-8 w-8 text-primary group-hover:text-white transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-text-primary group-hover:text-white uppercase tracking-tight mb-3 transition duration-500">
                        Corporate
                    </h3>
                    <p class="text-text-secondary group-hover:text-white/80 leading-relaxed transition duration-500">
                        Reliable logistics and transport solutions for Dodoma businesses.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US (VALUES) ── --}}
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div>
                <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase leading-none mb-4">
                    Why <br> Choose Us
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
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'title' => 'Quick Response',
                    'body'  => 'Average arrival time of under 5 minutes in Dodoma.',
                ],
                [
                    'num'   => '04',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>',
                    'title' => '24/7 Support',
                    'body'  => 'Our customer service team is always ready to help you.',
                ],
            ] as $val)
            <div class="group relative bg-background rounded-[32px] p-8 hover:bg-primary transition duration-500 overflow-hidden cursor-default">
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

{{-- ── CONTACT SECTION ── --}}
<section class="py-32 bg-background relative overflow-hidden honeycomb">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-none">
                Let's Connect
            </h2>
            <p class="text-lg text-text-secondary">Have questions or feedback? We're here to help you move better in Dodoma.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="card p-8 group hover:bg-primary transition duration-500 border-none shadow-xl shadow-black/5 flex items-center gap-6">
                <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition duration-500">
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
                <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition duration-500">
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

        <div class="text-center mt-12">
            <a href="{{ route('rides.create') }}" class="btn-primary inline-flex items-center gap-3 px-10 py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20">
                Book a Ride
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
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

.honeycomb {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5 L55 20 L55 40 L30 55 L5 40 L5 20 Z' fill='none' stroke='%232f6b3f' stroke-width='0.5' stroke-opacity='0.08' /%3E%3C/svg%3E");
    background-repeat: repeat;
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

// Typing Animation
const words = ["Fastest Deliveries", "Safe City Rides", "Corporate Logistics", "Real-time Tracking"];
let wordIndex = 0;
let charIndex = 0;
let isDeleting = false;
const typingText = document.getElementById('typing-text');
const typeSpeed = 100;
const eraseSpeed = 50;
const delayBetweenWords = 2000;

function type() {
    const currentWord = words[wordIndex];
    
    if (isDeleting) {
        typingText.textContent = currentWord.substring(0, charIndex - 1);
        charIndex--;
    } else {
        typingText.textContent = currentWord.substring(0, charIndex + 1);
        charIndex++;
    }

    let delta = isDeleting ? eraseSpeed : typeSpeed;

    if (!isDeleting && charIndex === currentWord.length) {
        isDeleting = true;
        delta = delayBetweenWords;
    } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        wordIndex = (wordIndex + 1) % words.length;
        delta = 500;
    }

    setTimeout(type, delta);
}

document.addEventListener('DOMContentLoaded', type);
</script>
@endpush

@endsection