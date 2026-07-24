@extends('layouts.app', ['title' => 'Medication Report — Detail'])
@section('title', 'Medication Report — Detail')
@section('content')

<div class="space-y-5">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Medication Incident Report</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Record #{{ $medication->id }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('forms.medication.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to list
            </a>
            <a href="{{ route('forms.medication.edit', $medication->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="edit" class="h-4 w-4"></i> Edit
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-950">

        {{-- Part 1 --}}
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 1 · Person Reporting Details</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-slate-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Reporter Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->pr_name }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Position</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->pr_position }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date Occurred</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">
                    {{ \App\Support\DateFormatter::safe($medication->pr_date_occured) }}
                </dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Time of Incident</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->pr_time_occured }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date Reported</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">
                    {{ \App\Support\DateFormatter::safe($medication->pr_date_reported) }}
                </dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Reported To</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->pr_incident_reported_to }}</dd>
            </div>
        </dl>

        {{-- Part 2 --}}
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 2 · Client / Participant Details</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-slate-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Participant Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->cd_name }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Location</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->cd_location }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Person Responsible</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->cd_responsible ?: '—' }}</dd>
            </div>
        </dl>

        {{-- Part 3 --}}
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 3 · Incident Details</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-slate-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Incident Type(s)</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->incident_type ?: '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Incident Background</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $medication->incident_background }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Incident Details</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $medication->incident_details }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Cause(s)</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->cause_factor ?: '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Immediate Action(s)</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->immediate_action ?: '—' }}</dd>
            </div>
        </dl>

        {{-- Part 4 --}}
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 4 · Manager Report</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-slate-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Follow-up Action(s)</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->follow_up_action ?: '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Follow-up Explanation</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $medication->action_explaination ?: '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Action Taken By</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->action_taken_by ?: '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date Completed</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">
                    {{ \App\Support\DateFormatter::safe($medication->date_completed) }}
                </dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Signature</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $medication->signature ?: '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Manager's Note</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $medication->manager_note ?: '—' }}</dd>
            </div>
        </dl>

        {{-- Footer actions --}}
        <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900">
            <button type="button"
                    onclick="openDeleteModal('{{ route('forms.medication.destroy', $medication->id) }}', '{{ addslashes($medication->pr_name) }}')"
                    class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400">
                <i data-lucide="trash-2" class="h-4 w-4"></i> Delete
            </button>
            <a href="{{ route('forms.medication.edit', $medication->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="edit" class="h-4 w-4"></i> Edit record
            </a>
        </div>

    </div>
</div>

{{-- Delete modal --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-900">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/15">
            <i data-lucide="trash-2" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
        </div>
        <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete record?</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            You are about to delete <span id="delete-name" class="font-semibold text-slate-700 dark:text-slate-200"></span>.
            This action cannot be undone.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                Cancel
            </button>
            <form id="delete-form" method="POST">
                @csrf @method('DELETE')
                <button type="submit"
                        class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                    Yes, delete
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(action, name) {
    document.getElementById('delete-form').action = action;
    document.getElementById('delete-name').textContent = name;
    var modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    lucide.createIcons();
}
function closeDeleteModal() {
    var modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endpush

@endsection
