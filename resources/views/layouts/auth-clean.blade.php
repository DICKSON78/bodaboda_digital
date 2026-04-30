<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - BodaBoda Digital')</title>
    <style>
        /* Global CSS from app.blade.php */
        body { 
            background-color: #EAEFEF; 
            font-family: 'Elms Sans', sans-serif; 
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
        
        /* Ensure solid white card backgrounds */
        .bg-white {
            background-color: #ffffff !important;
            background-image: none !important;
            opacity: 1 !important;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #EAEFEF; }
        ::-webkit-scrollbar-thumb { 
            background: linear-gradient(to bottom, #2F6B3F, #3E8E5A); 
            border-radius: 10px;
        }
        
        /* Login specific styles */
        :root {
            --primary: #00965f;
            --secondary: #00b371;
        }
        
        .login-progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: rgba(0, 150, 95, 0.1);
            z-index: 9999;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease;
        }
        
        .login-progress-container.active {
            opacity: 1;
            visibility: visible;
        }
        
        .login-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #00965f, #00b371, #00965f);
            background-size: 200% 100%;
            animation: progressGradient 1.5s ease infinite;
            transition: width 0.3s ease;
        }
        
        @keyframes progressGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .login-progress-bar.indeterminate {
            width: 100%;
            animation: progressIndeterminate 1.5s ease-in-out infinite, progressGradient 1.5s ease infinite;
        }
        
        @keyframes progressIndeterminate {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 420px;
            width: 90%;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        
        .modal.active .modal-content {
            transform: scale(1);
        }
        
        /* Utility classes */
        .py-32 { padding-top: 8rem; padding-bottom: 8rem; }
        .bg-background { background-color: #f8fafc; }
        .relative { position: relative; }
        .overflow-hidden { overflow: hidden; }
        .absolute { position: absolute; }
        .top-0 { top: 0; }
        .right-0 { right: 0; }
        .w-\\[500px\\] { width: 500px; }
        .h-\\[500px\\] { height: 500px; }
        .bg-primary\\/8 { background-color: rgba(47, 107, 63, 0.08); }
        .rounded-full { border-radius: 50%; }
        .blur-\\[120px\\] { filter: blur(120px); }
        .pointer-events-none { pointer-events: none; }
        .bottom-0 { bottom: 0; }
        .left-0 { left: 0; }
        .w-\\[400px\\] { width: 400px; }
        .h-\\[400px\\] { height: 400px; }
        .bg-accent\\/5 { background-color: rgba(245, 158, 11, 0.05); }
        .blur-\\[100px\\] { filter: blur(100px); }
        .z-10 { z-index: 10; }
        .max-w-7xl { max-width: 80rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .sm\\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .lg\\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        .flex { display: flex; }
        .justify-center { justify-content: center; }
        .items-center { align-items: center; }
        .min-h-screen { min-height: 100vh; }
        .animate-in { animation: fadeIn 0.7s ease-out; }
        .fade-in { animation: fadeIn 0.7s ease-out; }
        .zoom-in { animation: zoomIn 0.7s ease-out; }
        .duration-1000 { animation-duration: 1s; }
        .max-w-md { max-width: 28rem; }
        .text-center { text-align: center; }
        .mb-8 { margin-bottom: 2rem; }
        .w-32 { width: 8rem; }
        .h-32 { height: 8rem; }
        .bg-primary\\/10 { background-color: rgba(47, 107, 63, 0.1); }
        .rounded-\\[32px\\] { border-radius: 32px; }
        .h-16 { height: 4rem; }
        .w-16 { width: 4rem; }
        .text-primary { color: #2F6B3F; }
        .text-2xl { font-size: 1.5rem; }
        .font-bold { font-weight: 700; }
        .my-2 { margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .block { display: block; }
        .text-gray-800 { color: #1f2937; }
        .text-xl { font-size: 1.25rem; }
        .text-gray-600 { color: #4b5563; }
        .mt-2 { margin-top: 0.5rem; }
        .bg-red-100 { background-color: #fef2f2; }
        .border-red-400 { border-color: #f87171; }
        .text-red-700 { color: #b91c1c; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .rounded { border-radius: 0.25rem; }
        .mb-4 { margin-bottom: 1rem; }
        .bg-green-100 { background-color: #dcfce7; }
        .border-green-400 { border-color: #4ade80; }
        .text-green-700 { color: #15803d; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .block { display: block; }
        .text-sm { font-size: 0.875rem; }
        .font-medium { font-weight: 500; }
        .text-gray-700 { color: #374151; }
        .mb-1 { margin-bottom: 0.25rem; }
        .inset-y-0 { top: 0; bottom: 0; }
        .pl-3 { padding-left: 0.75rem; }
        .pointer-events-none { pointer-events: none; }
        .pl-10 { padding-left: 2.5rem; }
        .pr-4 { padding-right: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .border-gray-300 { border-color: #d1d5db; }
        .rounded-lg { border-radius: 0.5rem; }
        .focus\\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
        .transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 0.15s; }
        .bg-white { background-color: white; }
        .justify-between { justify-content: space-between; }
        .text-xs { font-size: 0.75rem; }
        .text-blue-600 { color: #2563eb; }
        .hover\\:text-blue-600:hover { color: #2563eb; }
        .hover\\:underline:hover { text-decoration: underline; }
        .pr-10 { padding-right: 2.5rem; }
        .text-gray-500 { color: #6b7280; }
        .hover\\:text-gray-700:hover { color: #374151; }
        .h-4 { height: 1rem; }
        .w-4 { width: 1rem; }
        .pt-4 { padding-top: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .w-full { width: 100%; }
        .my-6 { margin-top: 1.5rem; margin-bottom: 1.5rem; }
        .text-primary { color: #2F6B3F; }
        .hover\\:text-primary\\/80:hover { color: rgba(47, 107, 63, 0.8); }
        
        /* Form specific styles */
        .bg-primary\\/10 { background-color: rgba(47, 107, 63, 0.1); }
        .rounded-\\[32px\\] { border-radius: 32px; }
        .h-16 { height: 4rem; }
        .w-16 { width: 4rem; }
        .text-2xl { font-size: 1.5rem; }
        .font-bold { font-weight: 700; }
        .my-2 { margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .block { display: block; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-600 { color: #4b5563; }
        .mt-2 { margin-top: 0.5rem; }
        .bg-red-100 { background-color: #fef2f2; }
        .border-red-400 { border-color: #f87171; }
        .text-red-700 { color: #b91c1c; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .rounded { border-radius: 0.25rem; }
        .mb-4 { margin-bottom: 1rem; }
        .bg-green-100 { background-color: #dcfce7; }
        .border-green-400 { border-color: #4ade80; }
        .text-green-700 { color: #15803d; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .text-sm { font-size: 0.875rem; }
        .font-medium { font-weight: 500; }
        .text-gray-700 { color: #374151; }
        .mb-1 { margin-bottom: 0.25rem; }
        .inset-y-0 { top: 0; bottom: 0; }
        .pl-3 { padding-left: 0.75rem; }
        .pl-10 { padding-left: 2.5rem; }
        .pr-4 { padding-right: 1rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .border-gray-300 { border-color: #d1d5db; }
        .rounded-lg { border-radius: 0.5rem; }
        .focus\\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
        .transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 0.15s; }
        .bg-white { background-color: white; }
        .justify-between { justify-content: space-between; }
        .text-xs { font-size: 0.75rem; }
        .text-blue-600 { color: #2563eb; }
        .hover\\:text-blue-600:hover { color: #2563eb; }
        .hover\\:underline:hover { text-decoration: underline; }
        .pr-10 { padding-right: 2.5rem; }
        .text-gray-500 { color: #6b7280; }
        .hover\\:text-gray-700:hover { color: #374151; }
        .h-4 { height: 1rem; }
        .w-4 { width: 1rem; }
        .pt-4 { padding-top: 1rem; }
        .w-full { width: 100%; }
        .py-5 { padding-top: 1.25rem; padding-bottom: 1.25rem; }
        .my-6 { margin-top: 1.5rem; margin-bottom: 1.5rem; }
        .text-xs { font-size: 0.75rem; }
        .font-black { font-weight: 900; }
        .uppercase { text-transform: uppercase; }
        .tracking-widest { letter-spacing: 0.1em; }
        .bg-blue-50 { background-color: #eff6ff; }
        .border-blue-200 { border-color: #bfdbfe; }
        .rounded-lg { border-radius: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .text-xs { font-size: 0.75rem; }
        .font-semibold { font-weight: 600; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-600 { color: #4b5563; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .space-y-1 > * + * { margin-top: 0.25rem; }
        .text-blue-500 { color: #3b82f6; }
        .mr-1 { margin-right: 0.25rem; }
        .hover\\:text-blue-600:hover { color: #2563eb; }
        .hover\\:underline:hover { text-decoration: underline; }
        .ml-1 { margin-left: 0.25rem; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
