@extends('layouts.app', ['title' => 'Incident Report — Detail'])
@section('title', 'Incident Report — Detail')
@section('content')

<div class="space-y-5">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Participant Incident Report</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Record #{{ $reporter->id }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('forms.incident.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-ink-700 dark:bg-ink-900 dark:text-slate-200">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to list
            </a>
            <a href="{{ route('forms.reportpdf', $reporter->id) }}" target="_blank"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-ink-700 dark:bg-ink-900 dark:text-slate-200">
                <i data-lucide="file-text" class="h-4 w-4"></i> PDF
            </a>
            <a href="{{ route('forms.incident.edit', $reporter->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="pencil" class="h-4 w-4"></i> Edit
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-ink-800 dark:bg-ink-900">

        {{-- Part 1: Reporter Details --}}
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 1 · Reporter Details</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Reporter Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $reporter->name ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Contact Number</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $reporter->contact ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Position Title</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $reporter->position_title ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">IR Number</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $reporter->ir_number ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">State</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ config('settings.city_name')[$reporter->city] ?? $reporter->city ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Status</dt>
                <dd class="col-span-2 text-sm">
                    @if($reporter->completed)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Pending</span>
                    @endif
                </dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Submitted</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $reporter->created_at->format('d M Y, h:i A') }}</dd>
            </div>
        </dl>

        {{-- Part 2: Incident Details --}}
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 2 · Incident Details</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date of Incident</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $incident->doi ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Time of Incident</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $incident->toi ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Address / Location</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $incident->address ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date First Told</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $incident->date_told_about_incident ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Time First Told</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $incident->time_told_about_incident ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Incident Background</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $incident->incident_background ?? '—' }}</dd>
            </div>
            @if($incidentType)
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Incident Type(s)</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">
                    @php
                        $types = [
                            'Absent/Missing Person'           => $incidentType->absent,
                            'Behaviour'                       => $incidentType->behaviour,
                            'Death'                           => $incidentType->death,
                            'Breach of Privacy/Confidentiality' => $incidentType->confidentiality,
                            'Drug/Alcohol'                    => $incidentType->drug,
                            'Illness/Injury'                  => $incidentType->illness,
                            'Medication Error'                => $incidentType->medication_error ?? null,
                            'Assault (Physical/Sexual)'       => $incidentType->assault,
                            'Property Damage'                 => $incidentType->property_damage,
                            'Self-Harm'                       => $incidentType->self_harm,
                            'Suicide Attempted'               => $incidentType->suicide_attempted,
                            'Near Miss'                       => $incidentType->near_miss ?? null,
                            'Other'                           => $incidentType->other,
                        ];
                        $selected = array_keys(array_filter($types));
                    @endphp
                    @if($selected)
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($selected as $type)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">{{ $type }}</span>
                            @endforeach
                        </div>
                    @else
                        —
                    @endif
                </dd>
            </div>
            @endif
        </dl>

        {{-- Part 3: Who Was Involved --}}
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 3 · Who Was Involved</h3>
        </div>

        @if($participant)
        <div class="px-6 pt-4 pb-2">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-ink-500 mb-2">Participant</p>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Full Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $participant->full_name ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date of Birth</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $participant->dob ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Address</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $participant->address ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Involved / Witness</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $participant->involved_witness ? 'Involved' : 'Witness' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Injured</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $participant->injured ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Medical Attention Required</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $participant->medical_attention ? 'Yes' : 'No' }}</dd>
            </div>
        </dl>
        @endif

        @if($staff)
        <div class="px-6 pt-4 pb-2 border-t border-slate-100 dark:border-ink-800">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-ink-500 mb-2">Staff / Carer</p>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Full Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $staff->full_name ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Address</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $staff->address ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Role</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $staff->staff_other === 'STAFF' ? 'Staff' : 'Other' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Involved / Witness</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $staff->involved_witness ? 'Involved' : 'Witness' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Injured</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ (isset($staff->injured) && $staff->injured) ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Medical Attention Required</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $staff->medical_attention ? 'Yes' : 'No' }}</dd>
            </div>
        </dl>
        @endif

        {{-- Part 4/5: What Happened --}}
        @if($whatHappend)
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Parts 4 & 5 · Background & What Happened</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Description of Incident</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $whatHappend->desciption_of_incident ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Immediate Action by Staff</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $whatHappend->actoin_taken_by_staff ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Property / Equipment Damaged</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $whatHappend->property_damage ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Details of Damage</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $whatHappend->details_of_damage ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Police Contacted</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $whatHappend->police_contacted ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Reported to Line Manager</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $whatHappend->reported_to_line_manager ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Manager Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $whatHappend->manager_name ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Reporter Signature</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white italic">{{ $whatHappend->reporter_signature ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $whatHappend->date ?? '—' }}</dd>
            </div>
        </dl>
        @endif

        {{-- Part 6: Manager's Report --}}
        @if($manager)
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Part 6 · Manager's Report</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Manager Name</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->report_manager_name ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Position</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->report_manager_position ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Immediate Action Taken</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $manager->immediate_action_taken ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Family / Guardian Notified</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->family_notified ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Investigation into Possible Causes</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->investigation_possible_causes ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Investigation Record</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $manager->investigation_record ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Investigation Finding</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $manager->investigation_finding ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Outcome / Action to Mitigate</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $manager->outcome_incident ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Investigation Action Completed</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->investigation_action_completed ? 'Yes' : 'No' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Date Completed</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->informed_date ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Participant / Representative Feedback</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $manager->participant_feedback ?? '—' }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Reportable Incident</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white">{{ $manager->reportable_incident ? 'Yes' : 'No' }}</dd>
            </div>
        </dl>
        @endif

        {{-- Manager's Note --}}
        <div class="border-b border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <h3 class="text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400">Manager's Note</h3>
        </div>
        <dl class="divide-y divide-slate-100 dark:divide-ink-800">
            <div class="grid grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-slate-500 dark:text-slate-400">Manager's Note</dt>
                <dd class="col-span-2 text-sm text-slate-900 dark:text-white whitespace-pre-line">{{ $reporter->manager_note ?: '—' }}</dd>
            </div>
        </dl>

        {{-- Footer actions --}}
        <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-ink-800 dark:bg-ink-950">
            <button type="button"
                    onclick="openDeleteModal('{{ route('forms.incident.destroy', $reporter->id) }}', '{{ addslashes($reporter->name ?? 'this record') }}')"
                    class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400">
                <i data-lucide="trash-2" class="h-4 w-4"></i> Delete
            </button>
            <a href="{{ route('forms.incident.edit', $reporter->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="pencil" class="h-4 w-4"></i> Edit record
            </a>
        </div>

    </div>
</div>

{{-- Delete modal --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-ink-900">
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
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-ink-700 dark:bg-ink-950 dark:text-slate-200">
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
