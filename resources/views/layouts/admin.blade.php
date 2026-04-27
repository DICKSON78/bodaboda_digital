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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
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
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* ============================================
           SIDEBAR STYLES - BODABODA VERSION
           ============================================ */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            background: linear-gradient(180deg, #2F6B3F 0%, #255732 50%, #1a3d26 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            overflow-x: visible;
            overflow-y: auto;
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
            padding: 2rem;
        }

        /* ============================================
           CARD STYLES - KKKTAGAPE STYLE
           ============================================ */
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2F6B3F 0%, #f59e0b 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover::before {
            opacity: 1;
        }

        /* ============================================
           BUTTON STYLES - KKKTAGAPE STYLE
           ============================================ */
        .btn-primary {
            background: linear-gradient(135deg, #2F6B3F 0%, #255732 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.875rem;
            box-shadow: 0 4px 12px rgba(47, 107, 63, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #255732 0%, #1a3d26 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(47, 107, 63, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: #2F6B3F;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #2F6B3F;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.875rem;
            position: relative;
            overflow: hidden;
        }

        .btn-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(47, 107, 63, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .btn-outline:hover::before {
            left: 100%;
        }

        .btn-outline:hover {
            background: #2F6B3F;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(47, 107, 63, 0.3);
        }

        /* ============================================
           HEADER STYLES - KKKTAGAPE STYLE
           ============================================ */
        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
            width: 100%;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn {
            width: 42px;
            height: 42px;
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .notification-btn:hover {
            background: #f3f4f6;
            color: #2F6B3F;
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-menu-btn:hover {
            background: #f3f4f6;
        }

        /* ============================================
           TABLE STYLES - KKKTAGAPE STYLE
           ============================================ */
        .table-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
        }

        .data-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
            position: relative;
        }

        .data-table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #2F6B3F 0%, #f59e0b 100%);
        }

        .data-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.875rem;
            color: #374151;
            transition: all 0.2s ease;
        }

        .data-table tbody tr:hover td {
            background: #f8fafc;
        }

        .data-table tbody tr:hover {
            transform: scale(1.01);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* ============================================
           TEXT COLORS
           ============================================ */
        .text-primary { color: #2F6B3F; }
        .text-secondary { color: #f59e0b; }
        .text-accent { color: #06b6d4; }
        .text-success { color: #10b981; }
        .text-warning { color: #f59e0b; }
        .text-error { color: #ef4444; }
        .text-muted { color: #6b7280; }
        .text-gray-700 { color: #374151; }
        .text-gray-900 { color: #111827; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-500 { color: #6b7280; }

        /* ============================================
           BACKGROUND COLORS
           ============================================ */
        .bg-primary { background-color: #2F6B3F; }
        .bg-secondary { background-color: #f59e0b; }
        .bg-accent { background-color: #06b6d4; }
        .bg-success { background-color: #10b981; }
        .bg-warning { background-color: #f59e0b; }
        .bg-error { background-color: #ef4444; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-200 { background-color: #e5e7eb; }

        /* ============================================
           BORDER COLORS
           ============================================ */
        .border-gray-100 { border-color: #f3f4f6; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
    </style>
</head>
<body>
    <!-- ============================================
       SIDEBAR
       ============================================ -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo flex items-center mb-8">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-motorcycle text-primary text-xl"></i>
            </div>
            <span class="logo-text text-white font-bold text-xl">BodaBoda</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center text-white hover:bg-white/10 rounded-lg transition-all duration-200 p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span class="sidebar-text ml-3">Dashboard</span>
                </a>

                <!-- Riders Management -->
                <a href="{{ route('admin.riders') }}" class="sidebar-link flex items-center text-white hover:bg-white/10 rounded-lg transition-all duration-200 p-3 {{ request()->routeIs('admin.riders*') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span class="sidebar-text ml-3">Riders Management</span>
                </a>

                <!-- Analytics -->
                <a href="{{ route('admin.analytics') }}" class="sidebar-link flex items-center text-white hover:bg-white/10 rounded-lg transition-all duration-200 p-3 {{ request()->routeIs('admin.analytics') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-chart-bar w-5 text-center"></i>
                    <span class="sidebar-text ml-3">Analytics</span>
                </a>

                <!-- Reports -->
                <a href="#" class="sidebar-link flex items-center text-white hover:bg-white/10 rounded-lg transition-all duration-200 p-3">
                    <i class="fas fa-file-alt w-5 text-center"></i>
                    <span class="sidebar-text ml-3">Reports</span>
                </a>

                <!-- Settings -->
                <a href="#" class="sidebar-link flex items-center text-white hover:bg-white/10 rounded-lg transition-all duration-200 p-3">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span class="sidebar-text ml-3">Settings</span>
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
       MAIN CONTENT
       ============================================ -->
    <main class="main-content">
        <!-- Header - KKKTAGAPE STYLE -->
        <header class="header">
            <div class="header-left">
                <button class="toggle-btn" onclick="toggleDesktopSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-gray-600 text-sm mt-1">@yield('page-subtitle', 'BodaBoda Admin Panel')</p>
                </div>
            </div>
            <div class="header-right">
                <!-- Notifications -->
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>
                
                <!-- User Menu -->
                <button class="user-menu-btn">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                         class="h-8 w-8 rounded-full border-2 border-white shadow-lg">
                    <i class="fas fa-chevron-down text-gray-600 text-sm"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- ============================================
       SCRIPTS
       ============================================ -->
    <script>
        // Show page when CSS is ready
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('css-ready');
        });

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
                    const sidebar = document.getElementById('sidebar');
                    sidebar.classList.remove('mobile-expanded');
                }
            }, 250);
        });
    </script>
</body>
</html>
