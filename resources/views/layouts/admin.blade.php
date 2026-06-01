<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Prevent caching - prevents access after logout via browser back button -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'BodaBoda Admin Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/bodaboda-logo.png') }}">

    <!-- CRITICAL: Prevent FOUC - Hide page until CSS loads -->
    <style id="critical-css">
        /* Hide everything until CSS is ready */
        html { visibility: hidden; opacity: 0; }
        html.css-ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease; }

        /* Critical layout - ensure sidebar and content don't overlap */
        .sidebar {
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            width: 280px !important;
            height: 100vh !important;
            z-index: 1000 !important;
            background: linear-gradient(180deg, #2F6B3F 0%, #255732 50%, #1a3d26 100%) !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .main-content {
            margin-left: 280px !important;
            width: calc(100% - 280px) !important;
            min-height: 100vh !important;
            background: #f8fafc !important;
        }
        /* Collapsed sidebar state */
        body.sidebar-collapsed-state .sidebar { width: 70px !important; }
        body.sidebar-collapsed-state .main-content { margin-left: 70px !important; width: calc(100% - 70px) !important; }

        @media (max-width: 1024px) {
            .sidebar { width: 70px !important; }
            .main-content { margin-left: 70px !important; width: calc(100% - 70px) !important; }
        }
        @media (max-width: 480px) {
            .sidebar { width: 60px !important; }
            .main-content { margin-left: 60px !important; width: calc(100% - 60px) !important; }
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Elms+Sans:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Turbo for SPA-like navigation (no full page reloads) -->
    <script type="module">
        import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017-esm.min.js';
        Turbo.start();
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Elms Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#2F6B3F',
                            600: '#255732',
                            700: '#1a3d26',
                            800: '#0f2818',
                        },
                        secondary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        accent: {
                            50: '#ecfeff',
                            100: '#dbeafe',
                            500: '#06b6d4',
                            600: '#0891b2',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: #2F6B3F;
            --secondary: #f59e0b;
            --accent: #06b6d4;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Elms Sans', sans-serif;
        }
        body {
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Sidebar Styles - KEEP ORIGINAL BACKGROUND */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #2F6B3F 0%, #255732 50%, #1a3d26 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }
        .sidebar-link:hover { background: rgba(255, 255, 255, 0.1); color: white; }
        .sidebar-link-active { background: white !important; color: #2F6B3F !important; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .sidebar-link-active i {
            color: #2F6B3F !important;
        }
        .sidebar-link-active:hover {
            background: #f0fdf4 !important;
            color: #255732 !important;
        }

        /* Sidebar link base styles */
        .sidebar-link {
            position: relative;
            height: 48px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .sidebar-link i {
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .sidebar-text {
            font-size: 0.9375rem;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Sidebar nav scroll */
        .sidebar-nav {
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }

        /* Tooltip for collapsed sidebar */
        .sidebar-tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1a3d26;
            color: white;
            padding: 0.5rem 0.875rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            margin-left: 0.875rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            pointer-events: none;
            z-index: 1001;
        }
        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #1a3d26;
        }
        @media (min-width: 1025px) {
            .sidebar.collapsed .sidebar-link:hover .sidebar-tooltip { opacity: 1; visibility: visible; }
        }
        @media (max-width: 1024px) {
            .sidebar:not(.mobile-expanded) .sidebar-link:hover .sidebar-tooltip { opacity: 1; visibility: visible; }
            .sidebar:not(.mobile-expanded) .sidebar-text { display: none; }
            .sidebar:not(.mobile-expanded) .sidebar-link { justify-content: center; padding: 0.875rem; width: 48px; margin: 0.5rem auto; }
            .sidebar:not(.mobile-expanded) .sidebar-logo { justify-content: center; }
            .sidebar:not(.mobile-expanded) .user-details { display: none; }
            .sidebar:not(.mobile-expanded) .user-container { justify-content: center; }
            .sidebar.mobile-expanded .sidebar-text, .sidebar.mobile-expanded .user-details { display: block; }
            .sidebar.mobile-expanded .sidebar-link { justify-content: flex-start; padding: 0.875rem 1rem; width: auto; margin: 0.5rem 0; }
        }

        /* Toggle button */
        .toggle-btn {
            width: 42px; height: 42px; background: transparent; border: none;
            color: #6b7280; cursor: pointer; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s ease; flex-shrink: 0;
        }
        .toggle-btn:hover { background: #f3f4f6; color: #2F6B3F; transform: scale(1.05); }
        .toggle-btn:active { transform: scale(0.95); }
        .toggle-btn i { font-size: 1.375rem; }

        /* Smooth page transitions for Turbo navigation */
        .main-content {
            animation: fadeInContent 0.25s ease-out;
        }
        @keyframes fadeInContent {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Honeycomb pattern overlay - KEEP ORIGINAL */
        .sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%23ffffff' stroke-opacity='0.07' stroke-width='1'/%3E%3Cpath d='M28 0L28 34L0 50L0 16L28 0z' fill='%23ffffff' fill-opacity='0.02'/%3E%3C/svg%3E");
            background-size: 42px 75px;
            animation: honeycomb-shimmer 12s ease-in-out infinite alternate;
            opacity: 1;
        }

        @keyframes honeycomb-shimmer {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }

        /* Ensure sidebar children sit above the honeycomb overlay */
        .sidebar > * {
            position: relative;
            z-index: 1;
        }

        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Desktop - Expanded sidebar by default */
        @media (min-width: 1025px) {
            .sidebar {
                width: 280px;
                padding: 1.5rem;
            }
            .sidebar.collapsed {
                width: 70px;
                padding: 1rem 0.5rem;
            }
            .main-content {
                margin-left: 280px;
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                width: calc(100% - 280px);
            }
            .main-content.sidebar-collapsed {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            /* Hide text elements when collapsed */
            .sidebar.collapsed .sidebar-text,
            .sidebar.collapsed .logo-text,
            .sidebar.collapsed .user-details {
                display: none;
            }

            .sidebar.collapsed .request-badge {
                display: none;
            }

            /* Center items when collapsed */
            .sidebar.collapsed .sidebar-logo {
                justify-content: center;
                padding: 1rem 0;
            }

            .sidebar.collapsed .sidebar-link {
                justify-content: center;
                padding: 0.875rem;
                width: 48px;
                margin: 0.5rem auto;
            }

            .sidebar.collapsed .sidebar-user {
                padding: 1rem 0;
                justify-content: center;
            }

            .sidebar.collapsed .user-container {
                justify-content: center;
            }
        }

        /* Tablet/Mobile - Collapsed by default */
        @media (max-width: 1024px) {
            .sidebar {
                width: 70px;
                padding: 1rem 0.5rem;
            }
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            /* When expanded on mobile */
            .sidebar.mobile-expanded {
                width: 280px;
                padding: 1.5rem;
                box-shadow: 2px 0 25px rgba(0, 0, 0, 0.3);
            }

            .sidebar.mobile-expanded .sidebar-text,
            .sidebar.mobile-expanded .logo-text,
            .sidebar.mobile-expanded .user-details {
                display: block;
            }

            .sidebar.mobile-expanded .sidebar-link {
                justify-content: flex-start;
                padding: 0.875rem 1rem;
                width: auto;
                margin: 0.5rem 0;
            }

            .sidebar.mobile-expanded .sidebar-logo {
                justify-content: flex-start;
                padding: 1rem 0;
            }

            .sidebar.mobile-expanded .sidebar-user {
                padding: 1rem 0;
                justify-content: flex-start;
            }

            .sidebar.mobile-expanded .user-container {
                justify-content: flex-start;
            }
        }

        /* ============================================
           MAIN CONTENT STYLES
           ============================================ */
        .main-content {
            min-height: 100vh;
            background: #f8fafc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .page-container {
            padding: 2rem;
        }

        /* ============================================
           SHADCN-INSPIRED DESIGN SYSTEM (STANDARD)
           ============================================ */
        .scn-card {
            background-color: white;
            border-radius: 1rem; /* rounded-2xl (16px) */
            border: 1px solid #e2e8f0; /* border-slate-200 */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        .scn-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .scn-card-header {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .scn-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.025em;
            color: #0f172a;
        }
        .scn-card-description {
            font-size: 0.875rem;
            color: #64748b;
        }
        .scn-card-content {
            padding: 1.5rem;
            padding-top: 0;
        }

        /* Standardized Table Design */
        .scn-table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .scn-table {
            width: 100%;
            caption-side: bottom;
            font-size: 0.875rem;
            border-collapse: collapse;
        }
        .scn-table thead tr {
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .scn-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s;
        }
        .scn-table tbody tr:hover { background-color: #f8fafc; }
        .honeycomb {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%232F6B3F' stroke-opacity='0.12' stroke-width='1.5'/%3E%3C/svg%3E");
        }
        .scn-table th {
            height: 3rem;
            padding: 0 1.25rem;
            text-align: left;
            vertical-align: middle;
            font-weight: 700;
            color: #475569;
            font-size: 0.6875rem;
            text-transform: capitalize;
            letter-spacing: 0.05em;
        }
        .scn-table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            color: #1e293b;
            font-weight: 500;
        }

        /* Buttons */
        .btn-primary {
            background-color: #2F6B3F;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.875rem;
            text-transform: capitalize;
            letter-spacing: 0.05em;
        }
        .btn-primary:hover { background-color: #255732; transform: translateY(-1px); }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.125rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }
    </style>
</head>
<body>
    <!-- ============================================
       SIDEBAR - KEEP ORIGINAL DESIGN
       ============================================ -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo flex items-center mb-8">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-motorcycle text-primary-500 text-xl"></i>
            </div>
            <span class="logo-text text-white font-bold text-xl">BodaBoda</span>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav flex-1">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center rounded-xl transition-all duration-200 p-3 {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-tachometer-alt w-6 text-center text-lg"></i>
                    <span class="sidebar-text ml-3">Dashboard</span>
                    <span class="sidebar-tooltip">Dashboard</span>
                </a>

                <!-- Riders Management -->
                <a href="{{ route('admin.riders') }}" class="sidebar-link flex items-center rounded-xl transition-all duration-200 p-3 {{ request()->routeIs('admin.riders*') ? 'sidebar-link-active' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-motorcycle w-6 text-center text-lg"></i>
                    <span class="sidebar-text ml-3">Riders</span>
                    <span class="sidebar-tooltip">Riders</span>
                </a>

                <!-- Clients Management -->
                <a href="{{ route('admin.clients') }}" class="sidebar-link flex items-center rounded-xl transition-all duration-200 p-3 {{ request()->routeIs('admin.clients*') ? 'sidebar-link-active' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-users w-6 text-center text-lg"></i>
                    <span class="sidebar-text ml-3">Clients</span>
                    <span class="sidebar-tooltip">Clients</span>
                </a>

                <!-- Analytics -->
                <a href="{{ route('admin.analytics') }}" class="sidebar-link flex items-center rounded-xl transition-all duration-200 p-3 {{ request()->routeIs('admin.analytics') ? 'sidebar-link-active' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-chart-bar w-6 text-center text-lg"></i>
                    <span class="sidebar-text ml-3">Analytics</span>
                    <span class="sidebar-tooltip">Analytics</span>
                </a>

                <!-- Reports -->
                <a href="{{ route('admin.reports') }}" class="sidebar-link flex items-center rounded-xl transition-all duration-200 p-3 {{ request()->routeIs('admin.reports') ? 'sidebar-link-active' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-file-alt w-6 text-center text-lg"></i>
                    <span class="sidebar-text ml-3">Reports</span>
                    <span class="sidebar-tooltip">Reports</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings') }}" class="sidebar-link flex items-center rounded-xl transition-all duration-200 p-3 {{ request()->routeIs('admin.settings') ? 'sidebar-link-active' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-cog w-6 text-center text-lg"></i>
                    <span class="sidebar-text ml-3">Settings</span>
                    <span class="sidebar-tooltip">Settings</span>
                </a>
            </div>
        </nav>

        <!-- User Profile -->
        <div class="sidebar-user border-t border-white/20 pt-4">
            <div class="user-container flex items-center">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                     class="w-8 h-8 rounded-full border-2 border-white/30">
                <div class="user-details ml-3">
                    <p class="text-white text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-white/70 text-xs">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- ============================================
       MAIN CONTENT - IMPROVED HEADER
       ============================================ -->
    <main class="main-content">
        <!-- IMPROVED HEADER - Consistent with SHADC Design -->
        <header class="sticky top-0 z-[100] bg-white border-b border-slate-200 shadow-sm">
            <div class="px-8 py-4 flex items-center justify-between">
                <!-- Left Section with Toggle Button -->
                <div class="flex items-center gap-4">
                    <button class="toggle-btn" onclick="toggleDesktopSidebar()">
                        <i class="fas fa-bars text-slate-600 text-xl"></i>
                    </button>
                    <div class="flex flex-col">
                        <h2 class="text-xl font-black text-primary-500 capitalize tracking-tight leading-none">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-[20px] font-bold text-slate-600 capitalize tracking-tight mt-1">@yield('page-subtitle', 'Platform Operations')</p>
                    </div>
                </div>
                
                <!-- Right Section -->
                <div class="flex items-center gap-6">
                    <!-- Date Display -->
                    <div class="hidden lg:flex flex-col items-end">
                        <span class="text-[15px] font-black text-slate-600 capitalize tracking-tight leading-none">{{ now()->format('l') }}</span>
                        <span class="text-xs font-bold text-primary-500 mt-0.5">{{ now()->format('M d, Y') }}</span>
                    </div>

                    <!-- Action Group -->
                    <div class="flex items-center gap-3">
                        <!-- Notification Bell -->
                        <button class="relative w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#2F6B3F]/10 hover:text-[#2F6B3F] transition-all flex items-center justify-center">
                            <i class="fas fa-bell text-sm"></i>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
                        </button>
                        
                        <!-- Divider -->
                        <div class="h-8 w-px bg-slate-200"></div>

                        <!-- User Profile -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-primary-500 capitalize tracking-tight leading-none">{{ auth()->user()->name }}</p>
                                <p class="text-[9px] font-bold text-[#2F6B3F] capitalize tracking-widest mt-1">Administrator</p>
                            </div>
                            <div class="relative group cursor-pointer">
                                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2F6B3F&color=fff' }}" 
                                     class="h-10 w-10 rounded-xl border-2 border-white shadow-md group-hover:border-[#2F6B3F] transition-all">
                                <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-container">
            <!-- Flash Messages -->
            @if(session('success'))
            <div id="flashMessage" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 animate-fadeIn">
                <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                </div>
                <p class="flex-1 text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div id="flashMessage" class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 animate-fadeIn">
                <div class="w-9 h-9 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-times-circle text-rose-600 text-base"></i>
                </div>
                <p class="flex-1 text-sm font-semibold text-rose-800">{{ session('error') }}</p>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

         <!-- ============================================
        CONFIRM ACTION MODAL
        ============================================ -->
     <div id="confirmModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden" style="z-index:9999">
         <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300" id="confirmModalContent" style="transform:scale(0.95)">
             <div class="p-6 text-center">
                 <div id="confirmIcon" class="mx-auto mb-4" style="height:64px;width:64px;border-radius:50%;display:flex;align-items:center;justify-content:center"></div>
                 <h3 id="confirmTitle" class="text-xl font-bold text-gray-900 mb-2"></h3>
                 <p id="confirmMessage" class="text-gray-600 mb-2"></p>
                 <p id="confirmName" class="text-lg font-semibold mb-6"></p>
                 <div class="flex gap-3">
                     <button onclick="closeConfirmModal()" class="flex-1 px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-all">
                         <i class="fas fa-times mr-2"></i>Cancel
                     </button>
                     <form id="confirmForm" method="POST" class="flex-1" onsubmit="return executeConfirmAction(event)">
                         @csrf
                         <input type="hidden" name="_method" id="confirmMethod" value="POST">
                         <button type="submit" id="confirmBtn" class="w-full px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2">
                             <i id="confirmBtnIcon" class="fas fa-check"></i>
                             <span id="confirmBtnText">Confirm</span>
                         </button>
                     </form>
                 </div>
             </div>
         </div>
     </div>

     <!-- ============================================
        SCRIPTS
        ============================================ -->
      <script>
          // FOUC prevention - runs immediately (critical CSS is inlined)
          document.documentElement.classList.add('css-ready');

          // Show any persisted flash message from a previous AJAX action
          showPersistedFlashMessage();

          // Auto-dismiss flash messages after 5s
          setTimeout(function() {
              const flash = document.getElementById('flashMessage');
              if (flash) flash.style.display = 'none';
          }, 5000);

         // Mobile sidebar toggle
         function toggleSidebar() {
             const sidebar = document.getElementById('sidebar');
             sidebar.classList.toggle('mobile-expanded');
         }

         // Desktop sidebar toggle
         function toggleDesktopSidebar() {
             const sidebar = document.getElementById('sidebar');
             const mainContent = document.querySelector('.main-content');
             const body = document.body;
             sidebar.classList.toggle('collapsed');
             mainContent.classList.toggle('sidebar-collapsed');
             body.classList.toggle('sidebar-collapsed-state');
         }

         // Add mobile menu button for tablets/mobile
         if (window.innerWidth <= 1024) {
             const mobileMenuBtn = document.createElement('button');
             mobileMenuBtn.className = 'fixed top-4 left-4 z-50 p-2 bg-primary text-white rounded-lg shadow-lg md:hidden';
             mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
             mobileMenuBtn.onclick = toggleSidebar;
             document.body.appendChild(mobileMenuBtn);
         }

         // Handle window resize
         let resizeTimer;
         window.addEventListener('resize', function() {
             clearTimeout(resizeTimer);
             resizeTimer = setTimeout(function() {
                 if (window.innerWidth > 1024) {
                     document.getElementById('sidebar').classList.remove('mobile-expanded');
                 }
             }, 250);
         });

         // Confirm Modal
         function showConfirmModal(action, url, name, method) {
             method = method || 'POST';
             const modal = document.getElementById('confirmModal');
             const form = document.getElementById('confirmForm');
             const icon = document.getElementById('confirmIcon');
             const title = document.getElementById('confirmTitle');
             const msg = document.getElementById('confirmMessage');
             const nameEl = document.getElementById('confirmName');
             const btn = document.getElementById('confirmBtn');
             const btnText = document.getElementById('confirmBtnText');
             const btnIcon = document.getElementById('confirmBtnIcon');
             document.getElementById('confirmMethod').value = method;
             form.action = url;
             nameEl.textContent = name;

             const configs = {
                 'approve':  { bg:'bg-green-100', ic:'fas fa-check-circle text-3xl text-green-600', t:'Confirm Approval', m:'Approve this rider?', btnCls:'bg-green-600 hover:bg-green-700', btnTxt:'Approve', btnIc:'fas fa-check' },
                 'suspend':  { bg:'bg-yellow-100', ic:'fas fa-user-slash text-3xl text-yellow-600', t:'Confirm Suspension', m:'Suspend this user?', btnCls:'bg-yellow-600 hover:bg-yellow-700', btnTxt:'Suspend', btnIc:'fas fa-user-slash' },
                 'activate': { bg:'bg-green-100', ic:'fas fa-user-check text-3xl text-green-600', t:'Confirm Activation', m:'Activate this user?', btnCls:'bg-green-600 hover:bg-green-700', btnTxt:'Activate', btnIc:'fas fa-user-check' },
                 'delete':   { bg:'bg-red-100', ic:'fas fa-trash-alt text-3xl text-red-600', t:'Confirm Deletion', m:'This action cannot be undone.', btnCls:'bg-red-600 hover:bg-red-700', btnTxt:'Delete', btnIc:'fas fa-trash' },
                 'reject':   { bg:'bg-red-100', ic:'fas fa-times-circle text-3xl text-red-600', t:'Confirm Rejection', m:'Reject this application?', btnCls:'bg-red-600 hover:bg-red-700', btnTxt:'Reject', btnIc:'fas fa-times' },
                 'cancel':   { bg:'bg-red-100', ic:'fas fa-ban text-3xl text-red-600', t:'Confirm Cancellation', m:'Cancel this ride?', btnCls:'bg-red-600 hover:bg-red-700', btnTxt:'Cancel Ride', btnIc:'fas fa-ban' },
             };
             const c = configs[action] || configs['delete'];
             icon.className = 'mx-auto mb-4 ' + c.bg;
             icon.style.cssText = 'height:64px;width:64px;border-radius:50%;display:flex;align-items:center;justify-content:center';
             icon.innerHTML = '<i class="' + c.ic + '"></i>';
             title.textContent = c.t;
             msg.textContent = c.m;
             btn.className = 'w-full px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 ' + c.btnCls;
             btnText.textContent = c.btnTxt;
             btnIcon.className = c.btnIc;
             modal.classList.remove('hidden');
         }
         function closeConfirmModal() {
             document.getElementById('confirmModal').classList.add('hidden');
         }
         document.getElementById('confirmModal')?.addEventListener('click', function(e) {
             if (e.target === this) closeConfirmModal();
         });
         document.addEventListener('keydown', function(e) {
             if (e.key === 'Escape') closeConfirmModal();
         });

         // Execute confirm action via AJAX
         function executeConfirmAction(e) {
             e.preventDefault();
             const form = document.getElementById('confirmForm');
             const btn = document.getElementById('confirmBtn');
             const originalBtnHtml = btn.innerHTML;
             const url = form.action;
             const method = document.getElementById('confirmMethod').value;
             
             // Disable button and show loading state
             btn.disabled = true;
             btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
             
             // Prepare form data
             const formData = new FormData(form);
             
             fetch(url, {
                 method: method,
                 headers: {
                     'X-Requested-With': 'XMLHttpRequest',
                     'Accept': 'application/json',
                 },
                 body: formData
             })
             .then(response => response.json())
             .then(data => {
                 btn.disabled = false;
                 btn.innerHTML = originalBtnHtml;
                 closeConfirmModal();
                 
                 if (data.success) {
                     // Persist flash message for after reload
                     persistFlashMessage(data.message, 'success');
                     
                     // If redirect is provided, go there; otherwise reload current page
                     if (data.redirect) {
                         window.location.href = data.redirect;
                     } else {
                         // Reload after short delay to show flash message
                         setTimeout(() => {
                             window.location.reload();
                         }, 1500);
                     }
                 } else {
                     showFlashMessage(data.message || 'Action failed', 'error');
                 }
             })
             .catch(error => {
                 btn.disabled = false;
                 btn.innerHTML = originalBtnHtml;
                 closeConfirmModal();
                 showFlashMessage('An error occurred. Please try again.', 'error');
             });
         }

         // Flash message functions
         function showFlashMessage(message, type) {
             // Remove any existing flash message
             const existingFlash = document.getElementById('flashMessage');
             if (existingFlash) {
                 existingFlash.remove();
             }
             
             const container = document.querySelector('.page-container');
             if (!container) return;
             
             const flash = document.createElement('div');
             flash.id = 'flashMessage';
             flash.className = 'mb-6 p-4 ' + (type === 'success' ? 'bg-emerald-50 border-emerald-200' : 'bg-rose-50 border-rose-200') + ' rounded-2xl flex items-center gap-3 animate-fadeIn';
             
             const iconClass = type === 'success' ? 'fas fa-check-circle text-emerald-600' : 'fas fa-times-circle text-rose-600';
             
             flash.innerHTML = `
                 <div class="w-9 h-9 ${type === 'success' ? 'bg-emerald-100' : 'bg-rose-100'} rounded-xl flex items-center justify-center flex-shrink-0">
                     <i class="${iconClass} text-base"></i>
                 </div>
                 <p class="flex-1 text-sm font-semibold ${type === 'success' ? 'text-emerald-800' : 'text-rose-800'}">${message}</p>
                 <button onclick="this.parentElement.remove()" class="text-${type === 'success' ? 'emerald-400' : 'rose-400'} hover:text-${type === 'success' ? 'emerald-600' : 'rose-600'} transition-colors">
                     <i class="fas fa-times text-xs"></i>
                 </button>
             `;
             
             container.insertBefore(flash, container.firstChild);
             
             // Auto-dismiss after 5s
             setTimeout(() => {
                 if (flash.parentElement) flash.remove();
             }, 5000);
         }
         
         function persistFlashMessage(message, type) {
             sessionStorage.setItem('flash_message', JSON.stringify({ message, type }));
         }
         
         function showPersistedFlashMessage() {
             const flashData = sessionStorage.getItem('flash_message');
             if (flashData) {
                 const { message, type } = JSON.parse(flashData);
                 showFlashMessage(message, type);
                 sessionStorage.removeItem('flash_message');
             }
         }
     </script>
     <style>
         @keyframes fadeIn {
             from { opacity: 0; transform: translateY(-10px); }
             to { opacity: 1; transform: translateY(0); }
         }
         .animate-fadeIn {
             animation: fadeIn 0.3s ease-out;
         }
     </style>
     @yield('scripts')
</body>
</html>