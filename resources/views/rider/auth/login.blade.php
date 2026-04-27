@extends('layouts.app')

@section('content')
<div class="py-24 bg-background min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-4">
        <div class="card">
            <h1 class="text-3xl font-black text-primary mb-2 tracking-tighter text-center">RIDER LOGIN</h1>
            <p class="text-text-secondary text-center mb-8">Access your rider dashboard.</p>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Password</label>
                    <input type="password" name="password" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                </div>
                <button type="submit" class="btn-primary w-full py-4 text-lg">Login</button>
            </form>
            
            <div class="mt-6 text-center text-xs text-text-secondary italic">
                Secure authentication for registered riders.
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-100 text-center text-sm">
                New rider? <a href="{{ route('rider.register') }}" class="text-primary font-bold">Register as a Rider</a>
            </div>
        </div>
    </div>
</div>
@endsection
