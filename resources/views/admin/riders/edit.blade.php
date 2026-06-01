@extends('layouts.admin')

@section('title', 'Edit Rider - BodaBoda Admin Panel')
@section('page-title', 'Edit Rider')
@section('page-subtitle', 'Modify account and vehicle details for ' . $rider->user->name)

@section('content')
<!-- Breadcrumb -->
<div class="mb-8 flex items-center justify-between">
    <nav class="flex items-center space-x-3 text-xs font-bold text-slate-400 capitalize tracking-tight">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#2F6B3F] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.riders') }}" class="hover:text-[#2F6B3F] transition-colors">Riders</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.riders.show', $rider) }}" class="hover:text-[#2F6B3F] transition-colors">{{ $rider->user->name }}</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-900">Edit</span>
    </nav>
    <a href="{{ route('admin.riders.show', $rider) }}" class="text-xs font-black text-slate-500 hover:text-[#2F6B3F] transition-all flex items-center capitalize tracking-tight">
        <i class="fas fa-arrow-left mr-2"></i> Back to Profile
    </a>
</div>

<form id="editRiderForm" action="{{ route('admin.riders.update', $rider) }}" method="POST" class="space-y-8" onsubmit="return submitEditRider(event)">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Form Sections -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                            <i class="fas fa-user text-[#2F6B3F] text-sm"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 capitalize tracking-tight">Personal Information</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">First Name</label>
                            <div class="relative">
                                <input type="text" name="first_name" id="riderFirstName" value="{{ old('first_name', $rider->first_name) }}" required
                                       class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                                <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">Last Name</label>
                            <div class="relative">
                                <input type="text" name="last_name" id="riderLastName" value="{{ old('last_name', $rider->last_name) }}" required
                                       class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                                <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">Phone Number</label>
                            <div class="relative">
                                <input type="tel" name="phone_number" id="riderPhone" value="{{ old('phone_number', $rider->phone_number) }}" required
                                       class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                                <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>
                            <p id="riderPhoneError" class="text-xs text-rose-500 mt-1 hidden"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle & License Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                            <i class="fas fa-motorcycle text-[#2F6B3F] text-sm"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 capitalize tracking-tight">Vehicle & License Details</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">License Number</label>
                            <div class="relative">
                                <input type="text" name="license_number" id="riderLicense" value="{{ old('license_number', $rider->license_number) }}" required
                                       class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                                <i class="fas fa-id-badge absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">Bike Plate Number</label>
                            <div class="relative">
                                <input type="text" name="bike_plate" id="riderPlate" value="{{ old('bike_plate', $rider->bike_plate) }}" required
                                       class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-200 bg-white text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all">
                                <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Status & Save -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Account Settings Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                            <i class="fas fa-cog text-[#2F6B3F] text-sm"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 capitalize tracking-tight">Account Settings</h3>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">Availability Status</label>
                        <select name="status" id="riderStatus" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                            <option value="online" {{ $rider->status === 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ $rider->status === 'offline' ? 'selected' : '' }}>Offline</option>
                            <option value="suspended" {{ $rider->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 capitalize tracking-tight">Approval Status</label>
                        <select name="is_approved" id="riderApproved" class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#2F6B3F]/20 focus:border-[#2F6B3F] transition-all cursor-pointer">
                            <option value="1" {{ $rider->is_approved ? 'selected' : '' }}>Approved</option>
                            <option value="0" {{ !$rider->is_approved ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div id="editRiderFormError" class="hidden p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm font-bold text-rose-700"></div>

                    <div class="pt-4 space-y-3">
                        <button type="submit" id="editRiderSubmitBtn" class="w-full h-12 bg-[#2F6B3F] text-white rounded-xl font-black capitalize tracking-tight shadow-lg shadow-[#2F6B3F]/20 hover:bg-[#235031] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-save text-sm"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.riders.show', $rider) }}" class="w-full h-12 bg-slate-100 text-slate-600 rounded-xl font-black capitalize tracking-tight text-center block leading-[3rem] hover:bg-slate-200 transition-all">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-[#2F6B3F]/10 flex items-center justify-center">
                            <i class="fas fa-user-circle text-[#2F6B3F] text-sm"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 capitalize tracking-tight">Profile Summary</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $rider->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($rider->user->name) . '&background=2F6B3F&color=fff' }}" 
                             class="w-14 h-14 rounded-xl shadow-md border-2 border-white">
                        <div>
                            <p class="font-black text-slate-900 text-sm capitalize">{{ $rider->user->name }}</p>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Joined {{ $rider->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-tight mb-1">Email (Read Only)</p>
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $rider->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function submitEditRider(e) {
    e.preventDefault();
    const form = document.getElementById('editRiderForm');
    const btn = document.getElementById('editRiderSubmitBtn');
    const formError = document.getElementById('editRiderFormError');
    document.querySelectorAll('#riderPhoneError').forEach(el => el.classList.add('hidden'));
    formError.classList.add('hidden');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    fetch(form.action, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        body: new FormData(form)
    })
    .then(response => response.json().then(data => ({ status: response.status, data })))
    .then(({ status, data }) => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save text-sm"></i> Save Changes';

        if (status === 422 && data.errors) {
            Object.keys(data.errors).forEach(field => {
                const errEl = document.getElementById('rider' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
                if (errEl) {
                    errEl.textContent = data.errors[field][0];
                    errEl.classList.remove('hidden');
                }
            });
            if (data.errors.phone_number) {
                document.getElementById('riderPhoneError').textContent = data.errors.phone_number[0];
                document.getElementById('riderPhoneError').classList.remove('hidden');
            }
            return;
        }

        if (data.success) {
            showFlashMessage(data.message, 'success');
            if (data.redirect) {
                setTimeout(() => { window.location.href = data.redirect; }, 1000);
            }
        } else {
            formError.textContent = data.message || 'Update failed.';
            formError.classList.remove('hidden');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save text-sm"></i> Save Changes';
        formError.textContent = 'Network error. Please try again.';
        formError.classList.remove('hidden');
    });

    return false;
}
</script>
@endsection