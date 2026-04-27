@extends('layouts.admin-kkk')

@section('title', 'Hariri Maelezo ya Wapandaaji - BodaBoda Admin Panel')
@section('page-title', 'Hariri Maelezo')
@section('page-subtitle', 'Badili maelezo na mipangilio ya wapandaaji')

@section('content')
@php
// Helper function to format money with M, B, K
function formatMoney($amount) {
    if ($amount >= 1000000000) { // Billions
        return number_format($amount / 1000000000, 2) . 'B';
    } elseif ($amount >= 1000000) { // Millions
        return number_format($amount / 1000000, 2) . 'M';
    } elseif ($amount >= 1000) { // Thousands
        return number_format($amount / 1000, 1) . 'K';
    } else {
        return number_format($amount, 0);
    }
}
@endphp
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex items-center space-x-2 text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.riders') }}" class="hover:text-primary">Wapandaaji</a>
        <span>/</span>
        <a href="{{ route('admin.riders.show', $rider) }}" class="hover:text-primary">{{ $rider->user->name }}</a>
        <span>/</span>
        <span class="text-primary font-medium">Hariri</span>
    </nav>
</div>

<!-- Edit Form -->
<div class="card bg-white rounded-xl border border-gray-200 shadow-sm">
    <div class="p-4 md:p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Hariri Maelezo ya Wapandaaji</h2>
            <p class="text-gray-600 text-sm">Badili maelezo na mipangilio ya wapandaaji</p>
        </div>
        
        <form action="{{ route('admin.riders.update', $rider) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jina la Kwanza</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $rider->first_name) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jina la Mwisho</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $rider->last_name) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Anwani ya Barua Pepe</label>
                <input type="email" value="{{ $rider->user->email }}" readonly
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500">
                <p class="text-xs text-gray-500 mt-1">Anwani haibadilishwi</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Namba ya Simu</label>
                <input type="tel" name="phone_number" value="{{ old('phone_number', $rider->phone_number) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                @error('phone_number')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Namba ya Leseni</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $rider->license_number) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                    @error('license_number')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Namba ya Baiskeli</label>
                    <input type="text" name="bike_plate" value="{{ old('bike_plate', $rider->bike_plate) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                    @error('bike_plate')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hali</label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <option value="online" {{ $rider->status === 'online' ? 'selected' : '' }}>Anaendesha</option>
                        <option value="offline" {{ $rider->status === 'offline' ? 'selected' : '' }}>Haendi</option>
                        <option value="suspended" {{ $rider->status === 'suspended' ? 'selected' : '' }}>Amezuiwa</option>
                    </select>
                    @error('status')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hali ya Idhini</label>
                    <select name="is_approved" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <option value="1" {{ $rider->is_approved ? 'selected' : '' }}">Imeidhinishwa</option>
                        <option value="0" {{ !$rider->is_approved ? 'selected' : '' }}">Anasubiri</option>
                    </select>
                    @error('is_approved')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.riders.show', $rider) }}" class="btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Ghairi
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Hifadhi Mabadiliko
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
