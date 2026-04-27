<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BodaBoda Digital')</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            background-color: #f8fafc;
            color: #1a202c;
            line-height: 1.6;
        }
        
        /* Honeycomb Background Effect */
        .honeycomb {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5 L55 20 L55 40 L30 55 L5 40 L5 20 Z' fill='none' stroke='%232f6b3f' stroke-width='0.5' stroke-opacity='0.08' /%3E%3C/svg%3E");
            background-repeat: repeat;
        }
        
        /* Utility classes */
        .min-h-screen { min-height: 100vh; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .overflow-hidden { overflow: hidden; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .max-w-md { max-width: 28rem; }
        .w-full { width: 100%; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .z-10 { z-index: 10; }
        .p-10 { padding: 2.5rem; }
        .text-center { text-align: center; }
        .mb-10 { margin-bottom: 2.5rem; }
        .h-16 { height: 4rem; }
        .w-16 { width: 4rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .mb-6 { margin-bottom: 1.5rem; }
        .group:hover { }
        .transition { transition: all 0.3s ease; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .block { display: block; }
        .relative { position: relative; }
        .inset-y-0 { top: 0; bottom: 0; }
        .left-0 { left: 0; }
        .pl-4 { padding-left: 1rem; }
        .pointer-events-none { pointer-events: none; }
        .w-full { width: 100%; }
        .pl-11 { padding-left: 2.75rem; }
        .pr-4 { padding-right: 1rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .outline-none { outline: none; }
        .font-bold { font-weight: 700; }
        .text-sm { font-size: 0.875rem; }
        .pt-4 { padding-top: 1rem; }
        .w-full { width: 100%; }
        .py-5 { padding-top: 1.25rem; padding-bottom: 1.25rem; }
        .ml-2 { margin-left: 0.5rem; }
        .h-4 { height: 1rem; }
        .w-4 { width: 1rem; }
        .mt-10 { margin-top: 2.5rem; }
        .pt-10 { padding-top: 2.5rem; }
        .border-t { border-top-width: 1px; }
        .text-xs { font-size: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .ml-1 { margin-left: 0.25rem; }
        
        /* Color classes */
        .bg-primary { color: #2f6b3f; }
        .text-primary { color: #2f6b3f; }
        .text-text-secondary { color: #4a5568; }
        .bg-background { background-color: #f8fafc; }
        .bg-gray-50 { background-color: #f9fafb; }
        .border-gray-100 { border-color: #f3f4f6; }
        .border-gray-50 { border-color: #f9fafb; }
        .text-error { color: #ef4444; }
        .bg-error { background-color: #ef4444; }
        .text-white { color: white; }
        .bg-white { background-color: white; }
        
        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #2f6b3f 0%, #3d8b52 100%);
            color: white;
            border: none;
            padding: 1.25rem 2.5rem;
            border-radius: 0.75rem;
            font-weight: 900;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            box-shadow: 0 25px 50px -12px rgba(47, 107, 63, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(47, 107, 63, 0.4);
        }
        
        .btn-primary .group:hover .translate-x-1 {
            transform: translateX(0.25rem);
        }
        
        /* Card styles */
        .card {
            background: white;
            border-radius: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Form styles */
        input {
            width: 100%;
            padding-left: 2.75rem;
            padding-right: 1rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: #f9fafb;
            border: 1px solid #f3f4f6;
            border-radius: 1rem;
            outline: none;
            transition: all 0.3s ease;
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        input:focus {
            box-shadow: 0 0 0 3px rgba(47, 107, 63, 0.1);
            border-color: #2f6b3f;
        }
        
        /* Typography */
        .text-4xl { font-size: 2.25rem; line-height: 1; }
        .font-black { font-weight: 900; }
        .tracking-tighter { letter-spacing: -0.05em; }
        .uppercase { text-transform: uppercase; }
        .text-[10px] { font-size: 0.625rem; }
        .tracking-widest { letter-spacing: 0.1em; }
        .text-[8px] { font-size: 0.5rem; }
        .text-xs { font-size: 0.75rem; }
        .hover\:underline:hover { text-decoration: underline; }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .animate-in {
            animation: fadeIn 0.7s ease-out;
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Error styles */
        .bg-error\/10 { background-color: rgba(239, 68, 68, 0.1); }
        .border-error\/20 { border-color: rgba(239, 68, 68, 0.2); }
        .text-error { color: #ef4444; }
        
        /* Icon styles */
        svg {
            width: 1em;
            height: 1em;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .h-8 { height: 2rem; }
        .w-8 { width: 2rem; }
        .h-6 { height: 1.5rem; }
        .w-6 { width: 1.5rem; }
        
        /* Glow effects */
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .shadow-black\/10 { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-background">
    <main class="flex-grow">
        @yield('content')
    </main>
</body>
</html>
