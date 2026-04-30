@extends('layouts.admin')

@section('title', 'Edit Client - BodaBoda Admin Panel')
@section('page-title', 'Edit Client')
@section('page-subtitle', 'Modify account details for ' . $client->name)

@section('content')
<!-- Breadcrumb -->
<div class="mb-6 flex items-center justify-between">
    <nav class="flex items-center space-x-2 text-xs font-medium text-gray-500 uppercase tracking-wider">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ route('admin.clients') }}" class="hover:text-primary transition-colors">Clients</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ route('admin.clients.show', $client) }}" class="hover:text-primary transition-colors">{{ $client->name }}</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-gray-900">Edit</span>
    </nav>
</div>

<form action="{{ route('admin.clients.update', $client) }}" method="POST" class="max-w-3xl">
    @csrf
    @method('PUT')

    <div class="card bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-user-edit text-blue-600 text-sm"></i>
            </div>
            <h3 class="font-bold text-gray-800">Account Information</h3>
        </div>
        <div class="p-8 space-y-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Full Name</label>
                <div class="relative">
                    <input type="text" name="name" value="{{ old('name', $client->name) }}" required
                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500/20 text-sm">
                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email', $client->email) }}" required
                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500/20 text-sm">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3">
                <a href="{{ route('admin.clients.show', $client) }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-100 hover:opacity-90 transition-all">
                    Update Account
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
