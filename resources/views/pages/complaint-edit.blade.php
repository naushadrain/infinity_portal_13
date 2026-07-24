@extends('layouts.app', ['title' => 'Edit Feedback and Complaint'])
@section('title', 'Edit Feedback and Complaint')

@section('content')

@php
    $isClosed = $complaint->status === 'Closed';
@endphp

<div class="mx-auto max-w-full px-4 py-6">

    <form id="complaint-form"
          action="{{ route('forms.complaint.update', $complaint->id) }}"
          method="POST"
          novalidate
          class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-950">
        @csrf
        @method('PUT')

        {{-- Header --}}
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5 dark:border-slate-800 dark:bg-slate-900 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Edit Feedback and Complaint</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Record #{{ $complaint->id }}</p>
            </div>
            <a href="{{ route('forms.complaint.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand-600 dark:text-slate-400">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to list
            </a>
        </div>

        <div class="p-6">

            @if ($isClosed)
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300">
                    <i data-lucide="lock" class="h-4 w-4 shrink-0"></i>
                    This complaint is closed and locked from further edits.
                </div>
            @endif

            {{-- Tabs --}}
            <div class="mb-6 flex flex-wrap gap-1 border-b border-slate-200 dark:border-slate-800" role="tablist">
                <button type="button" class="tab-btn active" data-tab="details">
                    <i data-lucide="file-text" class="h-4 w-4"></i> Complaint Details
                </button>
                <button type="button" class="tab-btn" data-tab="status">
                    <i data-lucide="flag" class="h-4 w-4"></i> Status
                </button>
                <button type="button" class="tab-btn" data-tab="investigation">
                    <i data-lucide="search" class="h-4 w-4"></i> Investigation
                </button>
                <button type="button" class="tab-btn" data-tab="improvement">
                    <i data-lucide="trending-up" class="h-4 w-4"></i> Improvement
                </button>
            </div>

            {{-- Complaint Details --}}
            <div class="tab-panel" data-panel="details">
                <div class="grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-6">
                        <label class="form-label">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $complaint->name) }}" class="form-input" data-required {{ $isClosed ? 'disabled' : '' }}>
                    </div>
                    <div class="md:col-span-6">
                        <label class="form-label">Received From <span class="text-red-500">*</span></label>
                        <select name="received_from" class="form-input" data-required {{ $isClosed ? 'disabled' : '' }}>
                            <option value="">Please Select</option>
                            @foreach (['Participant Rep', 'Participant/Housing Provider Representative', 'Support Co-ordinator'] as $option)
                                <option value="{{ $option }}" {{ old('received_from', $complaint->received_from) === $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $complaint->email) }}" class="form-input" {{ $isClosed ? 'disabled' : '' }}>
                    </div>
                    <div class="md:col-span-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $complaint->contact_number) }}" class="form-input" {{ $isClosed ? 'disabled' : '' }}>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Complaint <span class="text-red-500">*</span></label>
                        <textarea name="complaint" rows="5" class="form-input resize-none" data-required {{ $isClosed ? 'disabled' : '' }}>{{ old('complaint', $complaint->complaint) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="tab-panel hidden" data-panel="status">
                <div class="grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-4">
                        <label class="form-label">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="form-input" data-required {{ $isClosed ? 'disabled' : '' }}>
                            @foreach (['New', 'In Progress', 'Closed'] as $option)
                                <option value="{{ $option }}" {{ old('status', $complaint->status) === $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-4">
                        <label class="form-label">Date Closed</label>
                        <input type="date" name="date_closed" value="{{ old('date_closed', optional($complaint->date_closed)->format('Y-m-d')) }}" class="form-input" {{ $isClosed ? 'disabled' : '' }}>
                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Automatically set to today when status is changed to Closed.</p>
                    </div>
                </div>
            </div>

            {{-- Investigation --}}
            <div class="tab-panel hidden" data-panel="investigation">
                <div class="grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-4">
                        <label class="form-label">Investigation Undertaken</label>
                        @php $invVal = old('investigation_undertaken', $complaint->investigation_undertaken); @endphp
                        <select name="investigation_undertaken" class="form-input" {{ $isClosed ? 'disabled' : '' }}>
                            <option value="" {{ !$invVal ? 'selected' : '' }}>Please Select</option>
                            <option value="yes" {{ $invVal === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ $invVal === 'no' ? 'selected' : '' }}>No</option>
                            <option value="na" {{ $invVal === 'na' ? 'selected' : '' }}>N/A</option>
                        </select>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Investigation Record of What Happened</label>
                        <textarea name="investigation_record" rows="4" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('investigation_record', $complaint->investigation_record) }}</textarea>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Investigation Findings</label>
                        <textarea name="investigation_findings" rows="4" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('investigation_findings', $complaint->investigation_findings) }}</textarea>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Investigation Actions</label>
                        <textarea name="investigation_actions" rows="4" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('investigation_actions', $complaint->investigation_actions) }}</textarea>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Complainant Feedback on Complaint Process</label>
                        <textarea name="complainant_feedback" rows="4" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('complainant_feedback', $complaint->complainant_feedback) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Improvement --}}
            <div class="tab-panel hidden" data-panel="improvement">
                <div class="grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-12">
                        <label class="form-label">Improvement Action Required</label>
                        <textarea name="improvement_action_required" rows="3" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('improvement_action_required', $complaint->improvement_action_required) }}</textarea>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Organisational Improvement Actions Identified from Complaint</label>
                        <textarea name="organisational_improvement_actions" rows="3" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('organisational_improvement_actions', $complaint->organisational_improvement_actions) }}</textarea>
                    </div>
                    <div class="md:col-span-4">
                        <label class="form-label">Improvement Implemented</label>
                        @php $impVal = old('improvement_implemented', $complaint->improvement_implemented); @endphp
                        <select name="improvement_implemented" class="form-input" {{ $isClosed ? 'disabled' : '' }}>
                            <option value="" {{ !$impVal ? 'selected' : '' }}>Please Select</option>
                            <option value="yes" {{ $impVal === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ $impVal === 'no' ? 'selected' : '' }}>No</option>
                            <option value="in_progress" {{ $impVal === 'in_progress' ? 'selected' : '' }}>On Progress</option>
                        </select>
                    </div>
                    <div class="md:col-span-12">
                        <label class="form-label">Manager's Note</label>
                        <textarea name="manager_note" rows="3" class="form-input resize-none" {{ $isClosed ? 'disabled' : '' }}>{{ old('manager_note', $complaint->manager_note) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900 sm:flex-row sm:justify-end">
            <a href="{{ route('forms.complaint.index') }}"
               class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">
                Cancel
            </a>
            <button type="submit" {{ $isClosed ? 'disabled' : '' }}
                    class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-brand-700 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:bg-brand-600">
                Save changes
            </button>
        </div>
    </form>
</div>

{{-- Close confirmation modal --}}
<div id="close-confirm-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-900">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-500/15">
            <i data-lucide="alert-triangle" class="h-6 w-6 text-amber-600 dark:text-amber-400"></i>
        </div>
        <h3 class="text-base font-bold text-slate-900 dark:text-white">Close this complaint?</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Date closed will be set to today. Once saved as Closed, this record can no longer be edited.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" id="close-confirm-cancel"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                Cancel
            </button>
            <button type="button" id="close-confirm-ok"
                    class="rounded-xl bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                Yes, mark as Closed
            </button>
        </div>
    </div>
</div>

<style>
    .form-label { display:block; font-size:0.875rem; font-weight:600; color:rgb(51 65 85); }
    .dark .form-label { color:rgb(203 213 225); }
    .form-input { margin-top:0.375rem; width:100%; border-radius:0.875rem; border:1px solid rgb(203 213 225); background:white; padding:0.7rem 0.9rem; font-size:0.875rem; color:rgb(15 23 42); outline:none; transition:border-color 0.15s; }
    .form-input:focus { border-color:rgb(37 99 235); box-shadow:0 0 0 3px rgba(37,99,235,.15); }
    .form-input.is-invalid { border-color:rgb(239 68 68); box-shadow:0 0 0 3px rgba(239,68,68,.15); }
    .form-input:disabled { background:rgb(241 245 249); color:rgb(100 116 139); cursor:not-allowed; }
    .dark .form-input { border-color:rgb(51 65 85); background:rgb(15 23 42); color:white; }
    .dark .form-input:disabled { background:rgb(30 41 59); color:rgb(148 163 184); }
    .check-card { display:flex; align-items:center; gap:0.65rem; cursor:pointer; border-radius:0.875rem; border:1px solid rgb(226 232 240); background:rgb(248 250 252); padding:0.75rem; font-size:0.875rem; color:rgb(51 65 85); transition:0.2s; }
    .check-card:hover { border-color:rgb(37 99 235); background:rgba(37,99,235,.06); }
    .dark .check-card { border-color:rgb(51 65 85); background:rgb(15 23 42); color:rgb(203 213 225); }
    .check-box { height:1rem; width:1rem; flex-shrink:0; border-radius:0.3rem; border:1px solid rgb(148 163 184); background:white; }
    .dark .check-box { background:rgb(2 6 23); border-color:rgb(100 116 139); }
    .peer:checked + .check-box { border-color:rgb(37 99 235); background:rgb(37 99 235); box-shadow:inset 0 0 0 3px white; }

    .tab-btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.65rem 1rem; font-size:0.8rem; font-weight:700; color:rgb(100 116 139); border-bottom:2px solid transparent; margin-bottom:-1px; background:none; border-top:none; border-left:none; border-right:none; cursor:pointer; }
    .tab-btn:hover { color:rgb(51 65 85); }
    .tab-btn.active { color:rgb(37 99 235); border-color:rgb(37 99 235); }
    .dark .tab-btn { color:rgb(148 163 184); }
    .dark .tab-btn:hover { color:rgb(226 232 240); }
    .dark .tab-btn.active { color:rgb(96 165 250); border-color:rgb(96 165 250); }
</style>

@push('scripts')
<script>
(function () {
    var form = document.getElementById('complaint-form');
    var tabButtons = form.parentElement.querySelectorAll('.tab-btn');
    var tabPanels = form.parentElement.querySelectorAll('.tab-panel');

    function activateTab(tab) {
        tabButtons.forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.tab === tab);
        });
        tabPanels.forEach(function (panel) {
            panel.classList.toggle('hidden', panel.dataset.panel !== tab);
        });
    }

    tabButtons.forEach(function (btn) {
        btn.addEventListener('click', function () { activateTab(btn.dataset.tab); });
    });

    form.addEventListener('submit', function (e) {
        var errors = [];
        form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });

        form.querySelectorAll('[data-required]').forEach(function (field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                var lbl = field.parentElement.querySelector('.form-label');
                errors.push((lbl ? lbl.innerText.replace(' *','').trim() : field.name) + ' is required.');
            }
        });

        if (errors.length > 0) {
            e.preventDefault();
            showToast(errors[0], 'error');
            var first = form.querySelector('.is-invalid');
            if (first) {
                var panel = first.closest('.tab-panel');
                if (panel) activateTab(panel.dataset.panel);
                first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    form.querySelectorAll('[data-required]').forEach(function (field) {
        field.addEventListener('input', function () { if (this.value.trim()) this.classList.remove('is-invalid'); });
    });

    function showToast(message, type) {
        var existing = document.getElementById('complaint-toast');
        if (existing) existing.remove();
        var bg = type === 'error' ? '#dc2626' : '#059669';
        var toast = document.createElement('div');
        toast.id = 'complaint-toast';
        toast.setAttribute('style',
            'position:fixed;top:1.25rem;right:1.25rem;z-index:9999;display:flex;align-items:center;gap:0.75rem;' +
            'background:' + bg + ';color:#fff;border-radius:0.75rem;padding:0.875rem 1.25rem;' +
            'font-size:0.875rem;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.18);max-width:22rem;');
        toast.innerHTML = '<span style="flex:1">' + message + '</span>' +
            '<button onclick="this.parentElement.remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-size:1.25rem;line-height:1;opacity:.8">&times;</button>';
        document.body.appendChild(toast);
        setTimeout(function () { if (toast.parentElement) toast.remove(); }, 5000);
    }

    // Status → Closed confirmation + auto date
    var statusSelect = form.querySelector('select[name="status"]');
    var dateClosedInput = form.querySelector('input[name="date_closed"]');
    var closeModal = document.getElementById('close-confirm-modal');

    if (statusSelect && closeModal) {
        var previousStatus = statusSelect.value;

        function openCloseModal() {
            closeModal.classList.remove('hidden');
            closeModal.classList.add('flex');
            lucide.createIcons();
        }

        function closeCloseModal() {
            closeModal.classList.add('hidden');
            closeModal.classList.remove('flex');
        }

        statusSelect.addEventListener('change', function () {
            if (this.value === 'Closed' && previousStatus !== 'Closed') {
                openCloseModal();
            } else {
                previousStatus = this.value;
            }
        });

        document.getElementById('close-confirm-cancel').addEventListener('click', function () {
            statusSelect.value = previousStatus;
            closeCloseModal();
        });

        document.getElementById('close-confirm-ok').addEventListener('click', function () {
            previousStatus = 'Closed';
            if (dateClosedInput) {
                var today = new Date();
                var y = today.getFullYear();
                var m = String(today.getMonth() + 1).padStart(2, '0');
                var d = String(today.getDate()).padStart(2, '0');
                dateClosedInput.value = y + '-' + m + '-' + d;
            }
            closeCloseModal();
        });

        closeModal.addEventListener('click', function (e) {
            if (e.target === this) {
                statusSelect.value = previousStatus;
                closeCloseModal();
            }
        });
    }
})();
</script>
@endpush

@endsection
