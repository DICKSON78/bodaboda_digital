@extends('layouts.app')

@section('content')
<div class="pt-32 pb-20 min-h-screen bg-background relative overflow-hidden flex items-center justify-center">
    <div class="honeycomb absolute inset-0 opacity-10"></div>
    
    <div class="max-w-md w-full px-4 relative z-10">
        <div class="card p-10 animate-in fade-in zoom-in duration-700">
            <div class="text-center mb-10">
                <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-6 group-hover:rotate-12 transition">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h1 class="text-4xl font-black text-primary tracking-tighter uppercase mb-2">Welcome Back</h1>
                <p class="text-[10px] font-black text-text-secondary uppercase tracking-widest">Sign in to your BodaBoda account</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-error/10 border border-error/20 rounded-2xl text-error text-xs font-bold uppercase tracking-tight">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-secondary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold text-sm" 
                            placeholder="name@example.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-[10px] font-black text-text-secondary uppercase tracking-widest">Password</label>
                        <a href="#" class="text-[8px] font-black text-primary uppercase tracking-widest hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-secondary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" required 
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition font-bold text-sm" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full btn-primary py-5 text-sm uppercase tracking-widest shadow-xl shadow-primary/20 group">
                        Sign In
                        <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </div>
            </form>

            <div class="mt-10 pt-10 border-t border-gray-50 text-center">
                <p class="text-xs text-text-secondary font-bold uppercase tracking-widest">
                    New to BodaBoda? 
                    <a href="#" class="text-primary hover:underline ml-1">Create Account</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
