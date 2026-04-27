@extends('layouts.app')

@section('content')
{{-- ============================================================
     CONTACT PAGE — BodaBoda Digital
     Design: matches welcome.blade.php & about.blade.php
     honeycomb bg, primary green, uppercase tracking,
     card hover effects, blob glows, map integration
     ============================================================ --}}

{{-- ── HERO ── --}}
<section class="relative min-h-[50vh] flex items-end bg-background overflow-hidden honeycomb pb-0">
    {{-- Ambient glows --}}
    <div class="absolute top-0 right-0 w-[700px] h-[700px] bg-primary/10 rounded-full blur-[140px] -translate-y-1/3 translate-x-1/4 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-accent/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-20">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-8">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Get in Touch</span>
            </div>
            <h1 class="text-6xl md:text-7xl font-black text-text-primary tracking-tighter leading-[0.9] mb-6">
                Let's Talk.
            </h1>
            <p class="text-xl text-text-secondary leading-relaxed max-w-xl mx-auto">
                Have questions, feedback, or partnership ideas? We're here to help you move better in Dodoma.
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

{{-- ── MAIN CONTACT SECTION ── --}}
<section class="py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">

            {{-- LEFT: Contact Info --}}
            <div class="animate-in slide-in-from-left duration-1000">
                <h2 class="text-4xl md:text-5xl font-black text-text-primary tracking-tighter uppercase mb-6 leading-tight">
                    We'd Love To<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-green">Hear From You.</span>
                </h2>
                <p class="text-lg text-text-secondary mb-12 leading-relaxed">
                    Whether you're a passenger, a rider, or a business partner — our team is ready to assist you within 24 hours.
                </p>

                {{-- Contact details --}}
                <div class="space-y-8">
                    {{-- Phone --}}
                    <div class="group flex items-start gap-5 p-5 bg-background rounded-3xl transition duration-500 hover:bg-primary hover:shadow-xl">
                        <div class="h-14 w-14 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-white/20 transition duration-500">
                            <svg class="h-7 w-7 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-1 group-hover:text-white/70 transition">Call Center</div>
                            <div class="text-xl font-bold text-text-primary group-hover:text-white transition">+255 700 000 000</div>
                            <p class="text-sm text-text-secondary group-hover:text-white/60 transition mt-1">Mon-Fri, 8AM - 8PM</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="group flex items-start gap-5 p-5 bg-background rounded-3xl transition duration-500 hover:bg-primary hover:shadow-xl">
                        <div class="h-14 w-14 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-white/20 transition duration-500">
                            <svg class="h-7 w-7 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-1 group-hover:text-white/70 transition">Email Support</div>
                            <div class="text-xl font-bold text-text-primary group-hover:text-white transition">hi@bodaboda.co.tz</div>
                            <p class="text-sm text-text-secondary group-hover:text-white/60 transition mt-1">support@bodaboda.co.tz</p>
                        </div>
                    </div>

                    {{-- Office --}}
                    <div class="group flex items-start gap-5 p-5 bg-background rounded-3xl transition duration-500 hover:bg-primary hover:shadow-xl">
                        <div class="h-14 w-14 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-white/20 transition duration-500">
                            <svg class="h-7 w-7 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-1 group-hover:text-white/70 transition">Office Location</div>
                            <div class="text-lg font-bold text-text-primary group-hover:text-white transition">Uhuru Street, Dodoma CBD</div>
                            <p class="text-sm text-text-secondary group-hover:text-white/60 transition mt-1">Dodoma, Tanzania</p>
                        </div>
                    </div>
                </div>

                {{-- Social links --}}
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <div class="text-[10px] font-black text-text-secondary uppercase tracking-[0.2em] mb-4">Follow Us</div>
                    <div class="flex gap-4">
                        <a href="#" class="h-12 w-12 bg-background rounded-2xl flex items-center justify-center hover:bg-primary hover:text-white transition duration-300 shadow-md">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="h-12 w-12 bg-background rounded-2xl flex items-center justify-center hover:bg-primary hover:text-white transition duration-300 shadow-md">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/></svg>
                        </a>
                        <a href="#" class="h-12 w-12 bg-background rounded-2xl flex items-center justify-center hover:bg-primary hover:text-white transition duration-300 shadow-md">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zM12 16c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="h-12 w-12 bg-background rounded-2xl flex items-center justify-center hover:bg-primary hover:text-white transition duration-300 shadow-md">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Contact Form --}}
            <div class="animate-in slide-in-from-right duration-1000 delay-200">
                <div class="bg-white rounded-[48px] shadow-2xl shadow-black/5 border border-gray-100 p-8 md:p-12">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center gap-2 bg-primary/5 rounded-full px-4 py-1.5 mb-4">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                            <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Send a Message</span>
                        </div>
                        <h3 class="text-2xl font-black text-text-primary uppercase tracking-tight">We Reply Within 24h</h3>
                    </div>

                    <form class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-text-secondary uppercase tracking-[0.2em] mb-2">Full Name</label>
                                <input type="text" 
                                       class="w-full bg-background border border-gray-100 rounded-2xl px-5 py-4 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition text-base font-medium"
                                       placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-text-secondary uppercase tracking-[0.2em] mb-2">Phone Number</label>
                                <input type="tel" 
                                       class="w-full bg-background border border-gray-100 rounded-2xl px-5 py-4 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition text-base font-medium"
                                       placeholder="+255 700 000 000">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-text-secondary uppercase tracking-[0.2em] mb-2">Email Address</label>
                            <input type="email" 
                                   class="w-full bg-background border border-gray-100 rounded-2xl px-5 py-4 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition text-base font-medium"
                                   placeholder="hello@bodaboda.com">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-text-secondary uppercase tracking-[0.2em] mb-2">Subject</label>
                            <select class="w-full bg-background border border-gray-100 rounded-2xl px-5 py-4 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition text-base font-medium cursor-pointer">
                                <option>General Inquiry</option>
                                <option>Rider Partnership</option>
                                <option>Corporate Account</option>
                                <option>Complaint / Feedback</option>
                                <option>Career Opportunities</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-text-secondary uppercase tracking-[0.2em] mb-2">Your Message</label>
                            <textarea rows="5" 
                                      class="w-full bg-background border border-gray-100 rounded-2xl px-5 py-4 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition text-base font-medium resize-none"
                                      placeholder="Tell us how we can help..."></textarea>
                        </div>
                        <button type="button" 
                                class="btn-primary w-full py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 flex items-center justify-center gap-3 group">
                            Send Message
                            <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </button>
                        <p class="text-[11px] text-text-secondary text-center">
                            By sending, you agree to our <a href="#" class="text-primary font-bold">Privacy Policy</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── MAP SECTION ── --}}
<section class="py-24 bg-background relative overflow-hidden honeycomb">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-text-primary tracking-tighter uppercase mb-4">
                Find Us In Dodoma
            </h2>
            <p class="text-text-secondary">Visit our headquarters — we're right in the heart of the city.</p>
        </div>
        
        <div class="rounded-[48px] overflow-hidden shadow-2xl border-8 border-white relative">
            <div id="contact-map" class="h-[400px] md:h-[450px] w-full" style="filter: saturate(0.8) contrast(1.1);"></div>
            <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur rounded-2xl px-5 py-3 shadow-lg">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs font-black uppercase tracking-wider">Uhuru Street, Dodoma CBD</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ / QUICK HELP ── --}}
<section class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 bg-primary/10 border border-primary/20 rounded-full px-5 py-2 mb-6">
                <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Quick Help</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-text-primary tracking-tighter uppercase">
                Frequently Asked
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                ['How do I book a ride?', 'Simply open the app, set your pickup location, choose your destination, and confirm. A nearby rider will be assigned instantly.'],
                ['Is my payment secure?', 'Yes! All payments are processed through our secure gateway. You can pay via cash, mobile money, or card.'],
                ['How do I become a rider?', 'Click "Become a Rider" on our homepage, fill out the application, and our team will contact you within 48 hours.'],
                ['What areas do you cover?', 'We currently serve all wards in Dodoma City, including Nzuguni, Hombolo, and the Central Business District.'],
                ['How is my safety ensured?', 'All riders go through background verification, mandatory helmet policy, and real-time ride tracking.'],
                ['Can I schedule a ride in advance?', 'Yes! Our app allows you to schedule rides up to 7 days in advance.'],
            ] as $faq)
            <div class="group p-6 bg-background rounded-3xl hover:bg-primary transition duration-500 cursor-pointer">
                <div class="flex justify-between items-start gap-4">
                    <h4 class="font-black text-text-primary group-hover:text-white uppercase tracking-tight text-base transition">
                        {{ $faq[0] }}
                    </h4>
                    <span class="h-6 w-6 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-white/20 transition">
                        <svg class="h-3 w-3 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </span>
                </div>
                <p class="text-text-secondary group-hover:text-white/80 text-sm leading-relaxed mt-3 transition">
                    {{ $faq[1] }}
                </p>
            </div>
            @endforeach
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
            <span class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Join The Movement</span>
        </div>
        <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-[1.1] mb-6 uppercase">
            Ready To Ride?
        </h2>
        <p class="text-xl text-white/70 mb-10 max-w-xl mx-auto">
            Download the BodaBoda app and experience smarter mobility in Dodoma.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#" class="inline-flex items-center justify-center gap-3 bg-white text-primary font-black px-10 py-5 rounded-2xl text-sm uppercase tracking-widest shadow-xl hover:-translate-y-0.5 transition duration-300">
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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map for contact page
        var contactMap = L.map('contact-map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-6.1624, 35.7519], 15); // Dodoma CBD coordinates

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(contactMap);

        // BodaBoda Office Marker
        var officeIcon = L.divIcon({
            html: `<div class="relative">
                    <div class="h-14 w-14 rounded-2xl bg-primary border-4 border-white shadow-2xl flex items-center justify-center transform rotate-3">
                        <svg class="h-7 w-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-3 h-3 bg-primary rounded-full"></div>
                   </div>`,
            className: 'office-marker',
            iconSize: [56, 56],
            iconAnchor: [28, 56]
        });

        L.marker([-6.1624, 35.7519], { icon: officeIcon })
            .addTo(contactMap)
            .bindPopup(`
                <div class="text-center p-2">
                    <div class="font-black text-primary uppercase tracking-tight">BodaBoda HQ</div>
                    <div class="text-xs text-gray-600 mt-1">Uhuru Street, Dodoma CBD</div>
                    <div class="text-[10px] font-bold mt-2">📞 +255 700 000 000</div>
                </div>
            `)
            .openPopup();

        // Disable zoom on map if needed
        contactMap.scrollWheelZoom.disable();
        contactMap.on('click', function() { contactMap.scrollWheelZoom.enable(); });
    });

    // Scroll reveal animations
    document.querySelectorAll('.animate-in').forEach(el => {
        el.classList.add('revealed');
    });
</script>

<style>
    .office-marker {
        background: none;
        border: none;
    }
    #contact-map {
        border-radius: 32px;
    }
    .animate-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .animate-in.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    .slide-in-from-left {
        transform: translateX(-30px);
    }
    .slide-in-from-left.revealed {
        transform: translateX(0);
    }
    .slide-in-from-right {
        transform: translateX(30px);
    }
    .slide-in-from-right.revealed {
        transform: translateX(0);
    }
</style>
@endpush

@endsection