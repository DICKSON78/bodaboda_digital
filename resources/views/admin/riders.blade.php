@extends('layouts.admin-kkk')

@section('title', 'Wapandaaji - BodaBoda Admin Panel')
@section('page-title', 'Usimamizi wa Wapandaaji')
@section('page-subtitle', 'Ongeza na usimamie wapandaaji wote')

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
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<!-- Header with Export and Add Buttons -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h3 class="text-lg font-medium text-gray-700 flex items-center">
        <i class="fas fa-users text-primary-500 mr-2"></i> Orodha ya Wapandaaji
        <span class="ml-2 text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $members->total() }} wapandaaji</span>
    </h3>
    
    <div class="flex items-center space-x-3">
        <!-- Add Rider Button -->
        <button onclick="switchToAddTab()"
                class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-all duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i> Ongeza Wapandaaji
        </button>
        
        <!-- Export Button -->
        <button onclick="exportMembers()"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 flex items-center">
            <i class="fas fa-download mr-2"></i> Pakua
        </button>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="mb-6">
    <div class="flex space-x-4 border-b border-gray-200" role="tablist">
        <button id="allMembersTab" class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-t-md focus:outline-none focus:ring-2 focus:ring-primary-300 transition-all duration-200" role="tab" aria-selected="true" aria-controls="membersTableContainer">
            Wapandaaji Wote
        </button>
        <button id="addMemberTab" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-t-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="addMemberFormContainer">
            Ongeza Wapandaaji
        </button>
    </div>
</div>

<!-- Members Table Container -->
<div id="membersTableContainer" class="block">
    <!-- Filter Section -->
    <div class="mb-6 bg-white rounded-xl border border-gray-200 shadow-sm p-4" id="filterSection">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h3 class="text-lg font-medium text-gray-700 flex items-center">
                <i class="fas fa-filter text-primary-500 mr-2"></i> Tafuta Wapandaaji
            </h3>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchMember" class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 bg-white shadow-sm text-gray-900 placeholder-gray-500" placeholder="Tafuta kwa jina, namba ya simu..." value="{{ $search ?? '' }}">
                </div>
                <select id="statusFilter" class="bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 py-2 px-3 text-sm w-full sm:w-48">
                    <option value="">Hali Zote</option>
                    <option value="active" {{ $request->input('status') == 'active' ? 'selected' : '' }}">Anaendesha</option>
                    <option value="inactive" {{ $request->input('status') == 'inactive' ? 'selected' : '' }}">Haendi</option>
                    <option value="transferred" {{ $request->input('status') == 'transferred' ? 'selected' : '' }}">Amehamishwa</option>
                </select>
                <select id="genderFilter" class="bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 py-2 px-3 text-sm w-full sm:w-48">
                    <option value="">Jinsia Zote</option>
                    <option value="male" {{ $request->input('gender') == 'male' ? 'selected' : '' }}">Mwanaume</option>
                    <option value="female" {{ $request->input('gender') == 'female' ? 'selected' : '' }}">Mwanamke</option>
                </select>
                <button onclick="clearFilters()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Futa Uchaguzi
                </button>
            </div>
        </div>
    </div>

    <!-- Table Container - KKKTAGAPE STYLE -->
    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="py-3.5 px-6 text-left font-semibold">Jina Kamili</th>
                        <th class="py-3.5 px-6 text-left font-semibold">Namba ya Simu</th>
                        <th class="py-3.5 px-6 text-left font-semibold">Hali</th>
                        <th class="py-3.5 px-6 text-left font-semibold">Jinsia</th>
                        <th class="py-3.5 px-6 text-left font-semibold">Tarehe ya Kujiunga</th>
                        <th class="py-3.5 px-6 text-left font-semibold">Vitendo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $member->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" 
                                         class="h-10 w-10 rounded-lg border-2 border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $member->phone ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-900">{{ $member->email }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($member->status === 'active')
                                    <span class="px-3 py-1 bg-success/10 text-success text-xs font-bold rounded-full">Anaendesha</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Haendi</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-900">{{ $member->gender ?? 'N/A' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-900">{{ $member->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-2">
                                    <button class="text-primary hover:text-primary/80 font-medium text-sm" title="Onaona Maelezo">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-accent hover:text-accent/80 font-medium text-sm" title="Hariri Maelezo">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-success hover:text-success/80 font-medium text-sm" title="Hariri Hali">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                    <button class="text-error hover:text-error/80 font-medium text-sm" title="Futa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-center">
                                    <div class="h-16 w-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                                        <i class="fas fa-users text-2xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Hamuna Wapandaji</h4>
                                    <p class="text-gray-500">Anza kuongeza wapandaji wapya</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Member Form Container (Hidden by default) -->
<div id="addMemberFormContainer" class="hidden">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Ongeza Wapandaaji Mpya</h3>
        
        <form id="addMemberForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jina Kamili</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Namba ya Simu</label>
                    <input type="tel" name="phone" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Barua Pepe</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe ya Kuzaliwa</label>
                    <input type="date" name="date_of_birth" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jinsia</label>
                    <select name="gender" required
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Chagua Jinsia</option>
                        <option value="male">Mwanaume</option>
                        <option value="female">Mwanamke</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hali</label>
                    <select name="status" required
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="active">Anaendesha</option>
                        <option value="inactive">Haendi</option>
                        <option value="transferred">Amehamishwa</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Anwani ya Makanisa</label>
                <textarea name="church_affiliation" rows="3"
                          class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                          placeholder="Andika anwani ya makanisa..."></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Picha ya Profaili</label>
                <input type="file" name="profile_photo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="switchToTableTab()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i> Ghairi
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Hifadhi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab switching functionality
function switchToAddTab() {
    document.getElementById('allMembersTab').setAttribute('aria-selected', 'false');
    document.getElementById('addMemberTab').setAttribute('aria-selected', 'true');
    document.getElementById('membersTableContainer').classList.add('hidden');
    document.getElementById('addMemberFormContainer').classList.remove('hidden');
}

function switchToTableTab() {
    document.getElementById('allMembersTab').setAttribute('aria-selected', 'true');
    document.getElementById('addMemberTab').setAttribute('aria-selected', 'false');
    document.getElementById('addMemberFormContainer').classList.add('hidden');
    document.getElementById('membersTableContainer').classList.remove('hidden');
}

function clearFilters() {
    document.getElementById('searchMember').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('genderFilter').value = '';
}

function exportMembers() {
    // Export functionality would go here
    alert('Pakua kazi utaendelea...');
}
</script>
@endsection
