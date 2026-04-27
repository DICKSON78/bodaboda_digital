@extends('layouts.admin-kkk')

@section('title', 'Mipangilio - BodaBoda Admin Panel')
@section('page-title', 'Mipangilio')
@section('page-subtitle', 'Dhibiti mipangilio ya mfumo wa BodaBoda')

@section('content')
<!-- Settings Navigation -->
<div class="mb-6">
    <div class="flex space-x-4 border-b border-gray-200" role="tablist">
        <button id="generalTab" class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-t-md focus:outline-none focus:ring-2 focus:ring-primary-300 transition-all duration-200" role="tab" aria-selected="true" aria-controls="generalSettings">
            Mipangilio Mkuu
        </button>
        <button id="paymentTab" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-t-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="paymentSettings">
            Malipo
        </button>
        <button id="notificationTab" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-t-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="notificationSettings">
        </button>
        <button id="securityTab" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-t-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="securitySettings">
            Usalama
        </button>
    </div>
</div>

<!-- General Settings -->
<div id="generalSettings" class="block">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
            <i class="fas fa-cog text-primary mr-2"></i>
            Mipangilio Mkuu ya Mfumo
        </h3>
        
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jina la Kampuni</label>
                    <input type="text" value="BodaBoda Digital" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anwani ya Barua Pepe</label>
                    <input type="email" value="info@bodaboda.co.tz" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Namba ya Simu</label>
                    <input type="tel" value="+255 712 345 678" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anwani ya Mtandao</label>
                    <input type="url" value="https://bodaboda.co.tz" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maelezo ya Kampuni</label>
                <textarea rows="4" 
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20"
                          placeholder="Andika maelezo fupi kuhusu kampuni...">BodaBoda Digital ni mfumo wa kisasa wa kusimamia huduma za usafiri wa baiskeli nchini Tanzania. Tunatoa suluhu salama na rahisi kwa wapandaaji na abiria.</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alama ya Kampuni</label>
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 bg-gray-100 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                        <i class="fas fa-motorcycle text-gray-400 text-2xl"></i>
                    </div>
                    <button type="button" class="btn-outline">
                        <i class="fas fa-upload mr-2"></i>
                        Pakua Alama Mpya
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Payment Settings (Hidden by default) -->
<div id="paymentSettings" class="hidden">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
            <i class="fas fa-credit-card text-primary mr-2"></i>
            Mipangilio ya Malipo
        </h3>
        
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Njia ya Malipo ya Chaguomsingi</label>
                <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
                    <option value="cash">Fedha Taslimu</option>
                    <option value="mobile">Simu ya Mkononi</option>
                    <option value="both">Zote</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Asilimia ya Malipo (%)</label>
                <input type="number" value="10" min="0" max="100"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bei ya Chini ya Safiri (TSh)</label>
                <input type="number" value="1000" min="0"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bei ya Juu ya Safiri (TSh)</label>
                <input type="number" value="50000" min="0"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20">
            </div>
        </form>
    </div>
</div>

<!-- Notification Settings (Hidden by default) -->
<div id="notificationSettings" class="hidden">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
            <i class="fas fa-bell text-primary mr-2"></i>
            Mipangilio ya Arifa
        </h3>
        
        <form class="space-y-6">
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-3 h-4 w-4 text-primary focus:ring-primary-500 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Arifa za Maombi Mpya</span>
                </label>
                <p class="text-xs text-gray-500 ml-7">Pokea arifa wakati wapandaji wapya wanaomba kujiunga</p>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-3 h-4 w-4 text-primary focus:ring-primary-500 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Arifa za Malipo</span>
                </label>
                <p class="text-xs text-gray-500 ml-7">Pokea arifa wakati malipo yanafanyika</p>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-3 h-4 w-4 text-primary focus:ring-primary-500 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Arifa za Matatizo</span>
                </label>
                <p class="text-xs text-gray-500 ml-7">Pokea arifa wakati kuna matatizo kwenye mfumo</p>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-3 h-4 w-4 text-primary focus:ring-primary-500 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Arifa za Ripoti ya Kila Siku</span>
                </label>
                <p class="text-xs text-gray-500 ml-7">Pokea ripoti ya kila siku kuhusu utendaji wa biashara</p>
            </div>
        </form>
    </div>
</div>

<!-- Security Settings (Hidden by default) -->
<div id="securitySettings" class="hidden">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
            <i class="fas fa-shield-alt text-primary mr-2"></i>
            Mipangilio ya Usalama
        </h3>
        
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nenosiri la Sasa</label>
                <input type="password" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20"
                       placeholder="Andika nenosiri lako la sasa">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nenosiri Jipya</label>
                <input type="password" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20"
                       placeholder="Andika nenosiri jipya">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Thibitisha Nenosiri Jipya</label>
                <input type="password" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-20"
                       placeholder="Andika tena nenosiri jipya">
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-3 h-4 w-4 text-primary focus:ring-primary-500 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Uthibitisho wa Vihati Vya Sehemu Mbili (2FA)</span>
                </label>
                <p class="text-xs text-gray-500 ml-7">Ongeza kiwango cha usalama kwa kutumia 2FA</p>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-3 h-4 w-4 text-primary focus:ring-primary-500 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Arifa za Kuingia</span>
                </label>
                <p class="text-xs text-gray-500 ml-7">Pokea arifa wakati mtu anajaribu kuingia kwenye akaunti yako</p>
            </div>
        </form>
    </div>
</div>

<!-- Save Button -->
<div class="flex justify-end">
    <button type="button" onclick="saveSettings()" class="btn-primary px-6 py-3">
        <i class="fas fa-save mr-2"></i>
        Hifadhi Mipangilio
    </button>
</div>

<script>
// Tab switching functionality
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('[id$="Settings"]').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('[id$="Tab"]').forEach(tab => {
        tab.classList.remove('text-white', 'bg-primary-500');
        tab.classList.add('text-gray-700', 'bg-gray-100');
        tab.setAttribute('aria-selected', 'false');
    });
    
    // Show selected tab content
    document.getElementById(tabName + 'Settings').classList.remove('hidden');
    
    // Add active state to selected tab
    const activeTab = document.getElementById(tabName + 'Tab');
    activeTab.classList.remove('text-gray-700', 'bg-gray-100');
    activeTab.classList.add('text-white', 'bg-primary-500');
    activeTab.setAttribute('aria-selected', 'true');
}

// Add click listeners to tabs
document.getElementById('generalTab').addEventListener('click', () => switchTab('general'));
document.getElementById('paymentTab').addEventListener('click', () => switchTab('payment'));
document.getElementById('notificationTab').addEventListener('click', () => switchTab('notification'));
document.getElementById('securityTab').addEventListener('click', () => switchTab('security'));

function saveSettings() {
    // Show loading state
    const button = event.target;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Inahifadhi...';
    button.disabled = true;
    
    // Simulate saving
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-save mr-2"></i> Hifadhi Mipangilio';
        button.disabled = false;
        alert('Mipangilio imehifadhiwa kwa mafanikio!');
    }, 2000);
}
</script>
@endsection
