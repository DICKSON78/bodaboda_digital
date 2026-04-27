<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BodaBoda')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2F6B3F',
                        'primary-dark': '#255732',
                        background: '#EAEFEF',
                        'secondary-green': '#3E8E5A',
                        accent: '#F4A261',
                        'text-primary': '#1A1A1A',
                        'text-secondary': '#6B7280',
                        error: '#E63946',
                        success: '#2A9D8F',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    borderRadius: {
                        'xl': '12px',
                        '2xl': '16px',
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            background-color: #EAEFEF; 
            font-family: 'Poppins', sans-serif; 
            color: #1A1A1A; 
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(47, 107, 63, 0.03) 0%, transparent 20%),
                radial-gradient(circle at 0% 0%, rgba(47, 107, 63, 0.02) 0%, transparent 20%),
                linear-gradient(30deg, transparent 40%, rgba(47, 107, 63, 0.03) 50%, transparent 60%);
            background-size: 100px 100px, 150px 150px, 200px 200px;
        }
        .honeycomb {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%232F6B3F' stroke-opacity='0.12' stroke-width='1.5'/%3E%3C/svg%3E");
        }
        .btn-primary { background-color: #2F6B3F; color: white; border-radius: 12px; font-weight: bold; transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-primary:hover { background-color: #255732; transform: translateY(-1px); }
        .btn-outline { border: 2px solid #2F6B3F; color: #2F6B3F; border-radius: 12px; font-weight: bold; transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-outline:hover { background-color: #2F6B3F; color: white; transform: translateY(-1px); }
        .card { background-color: white; border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.02); }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #EAEFEF; }
        ::-webkit-scrollbar-thumb { 
            background: linear-gradient(to bottom, #2F6B3F, #3E8E5A); 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover { background: #1A3D24; }
        
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-background font-sans text-text-primary antialiased selection:bg-primary/20 selection:text-primary honeycomb">
    <div class="min-h-screen flex flex-col relative">
        <header class="fixed top-0 left-0 right-0 z-[1000] bg-white/40 backdrop-blur-xl border-b-2 border-primary shadow-lg transition-all duration-500" id="main-header">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 transition-all duration-500" id="header-container">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-black text-primary tracking-tighter flex items-center mr-12 group">
                            <div class="mr-3 h-10 w-10 bg-primary/10 rounded-xl flex items-center justify-center group-hover:rotate-12 transition duration-300">
                                <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            BodaBoda Digital
                        </a>
                        <nav class="hidden lg:flex items-center space-x-10">
                            <a href="{{ route('home') }}" class="text-xs font-black {{ request()->routeIs('home') ? 'text-primary' : 'text-text-secondary' }} hover:text-primary transition uppercase tracking-widest {{ request()->routeIs('home') ? 'border-b-2 border-primary' : '' }}">Home</a>
                            <a href="{{ route('about') }}" class="text-xs font-black {{ request()->routeIs('about') ? 'text-primary' : 'text-text-secondary' }} hover:text-primary transition uppercase tracking-widest {{ request()->routeIs('about') ? 'border-b-2 border-primary' : '' }}">About</a>
                            <a href="{{ route('services') }}" class="text-xs font-black {{ request()->routeIs('services') ? 'text-primary' : 'text-text-secondary' }} hover:text-primary transition uppercase tracking-widest {{ request()->routeIs('services') ? 'border-b-2 border-primary' : '' }}">Services</a>
                            <a href="{{ route('contact') }}" class="text-xs font-black {{ request()->routeIs('contact') ? 'text-primary' : 'text-text-secondary' }} hover:text-primary transition uppercase tracking-widest {{ request()->routeIs('contact') ? 'border-b-2 border-primary' : '' }}">Contact</a>
                        </nav>
                    </div>
                    @auth
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-text-secondary hover:text-primary transition">Dashboard</a>
                            <a href="{{ route('rides.create') }}" class="btn-primary px-6 py-2 text-sm">Book Now</a>
                            <div class="flex items-center pl-6 border-l border-gray-200">
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full border-2 border-primary/10 shadow-sm">
                                <div class="ml-3 hidden md:block">
                                    <div class="text-sm font-bold text-text-primary leading-tight">{{ auth()->user()->name }}</div>
                                    <div class="text-[10px] uppercase tracking-widest text-text-secondary font-bold">{{ auth()->user()->role }}</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-2 text-text-secondary hover:text-error transition" title="Logout">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('rides.create') }}" class="text-xs font-black text-primary hover:underline uppercase tracking-widest">Find a Ride</a>
                            <a href="{{ route('login') }}" class="text-xs font-black text-text-secondary hover:text-primary transition uppercase tracking-widest">Login</a>
                            <a href="{{ route('rider.apply') }}" class="btn-primary px-8 py-4 text-xs uppercase tracking-widest">Become a Rider</a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-grow">
            @yield('content')
        </main>



        <!-- Rider Login Modal -->
        <div id="rider-login-modal" class="fixed inset-0 z-[2000] hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleModal('rider-login-modal')"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
                <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 border border-gray-100">
                    <div class="p-10">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-3xl font-black text-primary tracking-tighter uppercase">Rider Login</h2>
                            <button onclick="toggleModal('rider-login-modal')" class="text-text-secondary hover:text-error transition">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Email Address</label>
                                <input type="email" name="email" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="john@example.com">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Password</label>
                                <input type="password" name="password" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="••••••••">
                            </div>
                            <button type="submit" class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 mt-4">Sign In</button>
                            <div class="text-center pt-4">
                                <p class="text-sm text-text-secondary">New rider? <button type="button" onclick="openRiderRegister()" class="text-primary font-bold hover:underline">Register Now</button></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rider Register Modal (Step-wise) -->
        <div id="rider-register-modal" class="fixed inset-0 z-[2000] hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleModal('rider-register-modal')"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
                <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 border border-gray-100">
                    <div class="p-10">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h2 class="text-3xl font-black text-primary tracking-tighter uppercase">Join the Fleet</h2>
                                <p class="text-xs font-bold text-text-secondary uppercase tracking-widest mt-1" id="step-indicator">Step 1 of 3: Personal Info</p>
                            </div>
                            <button onclick="toggleModal('rider-register-modal')" class="text-text-secondary hover:text-error transition">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 h-1.5 rounded-full mb-10 overflow-hidden">
                            <div id="reg-progress" class="bg-primary h-full w-1/3 transition-all duration-500"></div>
                        </div>

                        <form action="{{ route('rider.store') }}" method="POST" enctype="multipart/form-data" id="rider-reg-form">
                            @csrf
                            
                            <!-- Step 1: Personal -->
                            <div id="step-1" class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">First Name</label>
                                        <input type="text" name="first_name" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="John">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Last Name</label>
                                        <input type="text" name="last_name" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="Doe">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Phone Number</label>
                                    <input type="text" name="phone_number" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="+255 000 000 000">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Email Address</label>
                                    <input type="email" name="email" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="john@example.com">
                                </div>
                                <button type="button" onclick="goToStep(2)" class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 mt-4">Next Step</button>
                            </div>

                            <!-- Step 2: Security -->
                            <div id="step-2" class="space-y-6 hidden">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Create Password</label>
                                    <input type="password" name="password" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="••••••••">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Confirm Password</label>
                                    <input type="password" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="••••••••">
                                </div>
                                <div class="flex gap-4">
                                    <button type="button" onclick="goToStep(1)" class="flex-1 btn-outline py-5 text-sm uppercase tracking-widest">Back</button>
                                    <button type="button" onclick="goToStep(3)" class="flex-[2] btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20">Next Step</button>
                                </div>
                            </div>

                            <!-- Step 3: Vehicle -->
                            <div id="step-3" class="space-y-6 hidden">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">License Number</label>
                                    <input type="text" name="license_number" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="DL-0000000">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Bike Plate Number</label>
                                    <input type="text" name="bike_plate" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold" required placeholder="MC 000 ABC">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Bike Image (Optional)</label>
                                    <div class="relative group cursor-pointer">
                                        <input type="file" name="bike_image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                        <div class="w-full p-8 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl flex flex-col items-center justify-center group-hover:border-primary transition">
                                            <svg class="h-8 w-8 text-text-secondary mb-2 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Click to upload photo</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4 mt-6">
                                    <button type="button" onclick="goToStep(2)" class="flex-1 btn-outline py-5 text-sm uppercase tracking-widest">Back</button>
                                    <button type="submit" class="flex-[2] btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20">Submit App</button>
                                </div>
                                <div class="text-center pt-4">
                                    <p class="text-sm text-text-secondary">Already have a rider account? <button type="button" onclick="openRiderLogin()" class="text-primary font-bold hover:underline">Login here</button></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleModal(id) {
                const modal = document.getElementById(id);
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }

            function openRiderLogin() {
                const regModal = document.getElementById('rider-register-modal');
                if (!regModal.classList.contains('hidden')) regModal.classList.add('hidden');
                toggleModal('rider-login-modal');
            }

            function openRiderRegister() {
                const loginModal = document.getElementById('rider-login-modal');
                if (!loginModal.classList.contains('hidden')) loginModal.classList.add('hidden');
                goToStep(1); // Reset to step 1
                toggleModal('rider-register-modal');
            }

            function goToStep(step) {
                // Hide all steps
                document.getElementById('step-1').classList.add('hidden');
                document.getElementById('step-2').classList.add('hidden');
                document.getElementById('step-3').classList.add('hidden');

                // Show target step
                document.getElementById('step-' + step).classList.remove('hidden');

                // Update indicator
                const indicators = [
                    "Step 1 of 3: Personal Info",
                    "Step 2 of 3: Security",
                    "Step 3 of 3: Vehicle Info"
                ];
                document.getElementById('step-indicator').innerText = indicators[step-1];

                // Update progress bar
                const progress = document.getElementById('reg-progress');
                if (step === 1) progress.style.width = '33.33%';
                if (step === 2) progress.style.width = '66.66%';
                if (step === 3) progress.style.width = '100%';
            }


        </script>

        <footer class="bg-[#1A3D24] text-white pt-32 pb-12 relative overflow-hidden honeycomb">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-[120px]"></div>
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-accent/5 rounded-full blur-[100px]"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-24">
                    <div class="lg:col-span-1">
                        <a href="/" class="text-3xl font-black text-white tracking-tighter flex items-center mb-8 group">
                            <div class="mr-4 h-12 w-12 bg-white/10 rounded-2xl flex items-center justify-center group-hover:rotate-12 transition duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            BodaBoda Digital
                        </a>
                        <p class="text-white/60 leading-relaxed mb-8 text-lg">
                            Pioneering the future of urban mobility in Tanzania. Reliable, safe, and efficient.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="h-12 w-12 bg-white/5 rounded-xl flex items-center justify-center hover:bg-primary transition duration-300 border border-white/10">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="#" class="h-12 w-12 bg-white/5 rounded-xl flex items-center justify-center hover:bg-primary transition duration-300 border border-white/10">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                            <a href="#" class="h-12 w-12 bg-white/5 rounded-xl flex items-center justify-center hover:bg-primary transition duration-300 border border-white/10">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126s1.355 1.078 2.14 1.384c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384s1.078-1.355 1.384-2.14c.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126s-1.355-1.078-2.14-1.384c-.765-.296-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.237-.421-.563-.224-.96-.479-1.382-.899-.419-.419-.679-.824-.896-1.38-.164-.42-.36-1.065-.413-2.235-.057-1.274-.07-1.649-.07-4.859 0-3.211.015-3.586.074-4.859.061-1.171.256-1.816.421-2.237.224-.563.479-.96.899-1.382.419-.419.824-.679 1.38-.896.42-.164 1.065-.36 2.235-.413 1.274-.057 1.649-.07 4.859-.07zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-white font-black uppercase tracking-widest mb-8 text-sm">Quick Links</h4>
                        <ul class="space-y-4">
                            <li><a href="#home" class="text-white/60 hover:text-primary transition duration-300">Home</a></li>
                            <li><a href="#about" class="text-white/60 hover:text-primary transition duration-300">About Us</a></li>
                            <li><button onclick="openRiderLogin()" class="text-white/60 hover:text-primary transition duration-300 text-left">Rider Portal</button></li>
                            <li><button onclick="openRiderRegister()" class="text-white/60 hover:text-primary transition duration-300 text-left">Become a Rider</button></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-black uppercase tracking-widest mb-8 text-sm">Services</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-white/60 hover:text-primary transition duration-300">City Rides</a></li>
                            <li><a href="#" class="text-white/60 hover:text-primary transition duration-300">Parcel Delivery</a></li>
                            <li><a href="#" class="text-white/60 hover:text-primary transition duration-300">Corporate Fleet</a></li>
                            <li><a href="#" class="text-white/60 hover:text-primary transition duration-300">Rider Training</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-black uppercase tracking-widest mb-8 text-sm">Newsletter</h4>
                        <p class="text-white/60 mb-6 text-sm leading-relaxed">Stay updated with the latest mobility news in Dodoma.</p>
                        <form class="flex flex-col space-y-3">
                            <input type="email" placeholder="Email address" class="bg-white/5 border border-white/10 rounded-xl px-5 py-3 outline-none focus:border-primary transition">
                            <button type="button" class="btn-primary py-3 rounded-xl">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="pt-12 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-white/40 text-sm">
                        &copy; {{ date('Y') }} BodaBoda Digital. All rights reserved.
                    </p>
                    <div class="flex space-x-8 text-sm">
                        <a href="#" class="text-white/40 hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="text-white/40 hover:text-white transition">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
