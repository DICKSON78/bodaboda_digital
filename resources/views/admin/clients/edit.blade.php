@extends('layouts.admin')

@section('title', 'Edit Client - BodaBoda Admin Panel')
@section('page-title', 'Edit Client')
@section('page-subtitle', 'Modify account details for ' . $user->name)

@section('content')
<div class="mb-6 flex items-center justify-between">
    <nav class="flex items-center space-x-3 text-xs font-bold text-slate-400 uppercase tracking-widest">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#2F6B3F] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.clients') }}" class="hover:text-[#2F6B3F] transition-colors">Clients</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('admin.clients.show', $user) }}" class="hover:text-[#2F6B3F] transition-colors">{{ $user->name }}</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-900">Edit</span>
    </nav>
</div>

<form id="editClientForm" action="{{ route('admin.clients.update', $user) }}" method="POST" class="max-w-3xl" onsubmit="return submitEditForm(event)">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl shadow-lg border border-[#2F6B3F]/20 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center">
            <div class="h-10 w-10 rounded-xl bg-[#2F6B3F]/10 flex items-center justify-center mr-3">
                <i class="fas fa-user-edit text-[#2F6B3F] text-sm"></i>
            </div>
            <h3 class="text-slate-900 font-bold text-base">Account Information</h3>
        </div>
        <div class="p-8 space-y-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Full Name</label>
                <div class="relative">
                    <input type="text" name="name" id="clientName" value="{{ old('name', $user->name) }}" required
                           class="w-full pl-10 pr-4 h-12 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#2F6B3F]/20 text-sm font-bold text-slate-900">
                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                <p id="clientNameError" class="text-xs font-bold text-rose-600 mt-1 hidden"></p>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" id="clientEmail" value="{{ old('email', $user->email) }}" required
                           class="w-full pl-10 pr-4 h-12 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#2F6B3F]/20 text-sm font-bold text-slate-900">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                <p id="clientEmailError" class="text-xs font-bold text-rose-600 mt-1 hidden"></p>
            </div>

            <div id="editFormError" class="hidden p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm font-bold text-rose-700"></div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.clients.show', $user) }}" class="h-12 px-6 rounded-xl border border-slate-200 bg-white text-xs font-black text-slate-600 hover:bg-slate-50 hover:border-[#2F6B3F]/30 transition-all uppercase tracking-widest flex items-center">
                    Cancel
                </a>
                <button type="submit" id="editSubmitBtn" class="h-12 px-8 rounded-xl bg-[#2F6B3F] text-xs font-black text-white hover:bg-[#235031] transition-all shadow-lg flex items-center gap-2 uppercase tracking-widest">
                    <i class="fas fa-save text-[11px]"></i> Update Account
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function submitEditForm(e) {
    e.preventDefault();
    const form = document.getElementById('editClientForm');
    const btn = document.getElementById('editSubmitBtn');
    const formError = document.getElementById('editFormError');
    document.querySelectorAll('#clientNameError, #clientEmailError').forEach(el => el.classList.add('hidden'));
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
        btn.innerHTML = '<i class="fas fa-save text-[11px]"></i> Update Account';

        if (status === 422 && data.errors) {
            if (data.errors.name) {
                document.getElementById('clientNameError').textContent = data.errors.name[0];
                document.getElementById('clientNameError').classList.remove('hidden');
            }
            if (data.errors.email) {
                document.getElementById('clientEmailError').textContent = data.errors.email[0];
                document.getElementById('clientEmailError').classList.remove('hidden');
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
        btn.innerHTML = '<i class="fas fa-save text-[11px]"></i> Update Account';
        formError.textContent = 'Network error. Please try again.';
        formError.classList.remove('hidden');
    });

    return false;
}
</script>
@endsection
