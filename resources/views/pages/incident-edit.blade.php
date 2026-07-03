{{--
|--------------------------------------------------------------------------
| Page: Edit Incident Report
|--------------------------------------------------------------------------
| Edit the full submitted incident report (mirrors incident-show.blade.php).
--}}
@extends('layouts.app', ['title' => 'Edit Incident Report'])
@section('title', 'Edit Incident Report')
@section('content')

    @php
        $lbl = 'block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5';
        $inp = 'w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition';
        $selectedTypes = old('incident_type', [
            'absent'            => $incidentType->absent ?? false,
            'behaviour'         => $incidentType->behaviour ?? false,
            'confidentiality'   => $incidentType->confidentiality ?? false,
            'drug'              => $incidentType->drug ?? false,
            'illness'           => $incidentType->illness ?? false,
            'medication_error'  => $incidentType->medication_error ?? false,
            'assault'           => $incidentType->assault ?? false,
            'property_damage'   => $incidentType->property_damage ?? false,
            'self_harm'         => $incidentType->self_harm ?? false,
            'suicide_attempted' => $incidentType->suicide_attempted ?? false,
            'death'             => $incidentType->death ?? false,
            'other'             => $incidentType->other ?? false,
            'near_miss'         => $incidentType->near_miss ?? false,
        ]);
        // old('incident_type') comes back as a plain list of checked keys; normalize both shapes to a lookup array.
        $checkedTypes = is_array($selectedTypes) && array_is_list($selectedTypes)
            ? array_fill_keys($selectedTypes, true)
            : array_filter($selectedTypes);
    @endphp

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form id="edit-incident-form" method="POST" action="{{ route('forms.incident.update', $reporter) }}">
        @csrf
        @method('PUT')

        {{-- Part 1: Reporter Details --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <div class="flex items-center justify-between mb-1">
                <h3 class="text-base font-semibold">Part 1 · Reporter Details</h3>
                <span class="text-xs text-slate-400 dark:text-ink-500">IR #{{ $reporter->id }}</span>
            </div>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label class="{{ $lbl }}">Reporter Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $reporter->name) }}" required
                           class="{{ $inp }} {{ $errors->has('name') ? 'border-rose-400' : '' }}">
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lbl }}">Contact Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="contact" value="{{ old('contact', $reporter->contact) }}" required
                           class="{{ $inp }} {{ $errors->has('contact') ? 'border-rose-400' : '' }}">
                    @error('contact') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lbl }}">IR Number</label>
                    <input type="text" name="ir_number" value="{{ old('ir_number', $reporter->ir_number) }}" class="{{ $inp }}">
                </div>

                <div>
                    <label class="{{ $lbl }}">Position Title</label>
                    <input type="text" name="position_title" value="{{ old('position_title', $reporter->position_title) }}" class="{{ $inp }}">
                </div>

                <div>
                    <label class="{{ $lbl }}">City</label>
                    <select name="city" class="{{ $inp }}">
                        @foreach($cities as $key => $label)
                            <option value="{{ $key }}" {{ old('city', $reporter->city) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="completed" value="0">
                        <input type="checkbox" name="completed" value="1" class="sr-only peer"
                               {{ old('completed', $reporter->completed) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:ring-2 peer-focus:ring-brand-300 rounded-full peer dark:bg-ink-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-600"></div>
                        <span class="ml-3 text-sm font-medium text-slate-700 dark:text-ink-200">Mark as Completed</span>
                    </label>
                </div>

            </div>
        </section>

        {{-- Part 2: Incident Details --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <h3 class="text-base font-semibold mb-1">Part 2 · Incident Details</h3>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label class="{{ $lbl }}">Date of Incident</label>
                    <input type="date" name="doi" value="{{ old('doi', $incident?->doi) }}" class="{{ $inp }}">
                </div>

                <div>
                    <label class="{{ $lbl }}">Time of Incident</label>
                    <input type="time" name="toi" value="{{ old('toi', $incident?->toi) }}" class="{{ $inp }}">
                </div>

                <div>
                    <label class="{{ $lbl }}">Date First Told</label>
                    <input type="date" name="date_told_about_incident" value="{{ old('date_told_about_incident', $incident?->date_told_about_incident) }}" class="{{ $inp }}">
                </div>

                <div>
                    <label class="{{ $lbl }}">Time First Told</label>
                    <input type="time" name="time_told_about_incident" value="{{ old('time_told_about_incident', $incident?->time_told_about_incident) }}" class="{{ $inp }}">
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Address / Location</label>
                    <input type="text" name="address" value="{{ old('address', $incident?->address) }}" class="{{ $inp }}">
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Incident Background</label>
                    <textarea name="incident_background" rows="4" class="{{ $inp }} resize-y">{{ old('incident_background', $incident?->incident_background) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Incident Type(s)</label>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach ([
                            'absent'            => 'Absent/Missing Person',
                            'behaviour'         => 'Behaviour',
                            'death'             => 'Death',
                            'confidentiality'   => 'Breach of Privacy/Confidentiality',
                            'drug'              => 'Drug/Alcohol',
                            'illness'           => 'Illness/Injury',
                            'medication_error'  => 'Medication Error',
                            'assault'           => 'Assault (Physical/Sexual)',
                            'property_damage'   => 'Property Damage',
                            'self_harm'         => 'Self-Harm',
                            'suicide_attempted' => 'Suicide Attempted',
                            'near_miss'         => 'Near Miss',
                            'other'             => 'Other',
                        ] as $key => $label)
                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-ink-200">
                                <input type="checkbox" name="incident_type[]" value="{{ $key }}"
                                       {{ !empty($checkedTypes[$key]) ? 'checked' : '' }}
                                       class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>
        </section>

        {{-- Part 3: Who Was Involved --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <h3 class="text-base font-semibold mb-1">Part 3 · Who Was Involved</h3>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-ink-500 mb-3">Participant</p>
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="{{ $lbl }}">Full Name</label>
                    <input type="text" name="participant_full_name" value="{{ old('participant_full_name', $participant?->full_name) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Date of Birth</label>
                    <input type="date" name="participant_dob" value="{{ old('participant_dob', $participant?->dob) }}" class="{{ $inp }}">
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Address</label>
                    <input type="text" name="participant_address" value="{{ old('participant_address', $participant?->address) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Involved / Witness</label>
                    <select name="participant_involved_witness" class="{{ $inp }}">
                        <option value="1" {{ old('participant_involved_witness', $participant?->involved_witness) ? 'selected' : '' }}>Involved</option>
                        <option value="0" {{ !old('participant_involved_witness', $participant?->involved_witness) ? 'selected' : '' }}>Witness</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Injured</label>
                    <select name="participant_injured" class="{{ $inp }}">
                        <option value="1" {{ old('participant_injured', $participant?->injured) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('participant_injured', $participant?->injured) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Medical Attention Required</label>
                    <select name="participant_medical_attention" class="{{ $inp }}">
                        <option value="1" {{ old('participant_medical_attention', $participant?->medical_attention) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('participant_medical_attention', $participant?->medical_attention) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-ink-500 mb-3 pt-4 border-t border-slate-100 dark:border-ink-800">Staff / Carer</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="{{ $lbl }}">Full Name</label>
                    <input type="text" name="staff_full_name" value="{{ old('staff_full_name', $staff?->full_name) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Role</label>
                    <select name="staff_other" class="{{ $inp }}">
                        <option value="STAFF" {{ old('staff_other', $staff?->staff_other) === 'STAFF' ? 'selected' : '' }}>Staff</option>
                        <option value="OTHER" {{ old('staff_other', $staff?->staff_other) !== 'STAFF' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Address</label>
                    <input type="text" name="staff_address" value="{{ old('staff_address', $staff?->address) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Involved / Witness</label>
                    <select name="staff_involved_witness" class="{{ $inp }}">
                        <option value="1" {{ old('staff_involved_witness', $staff?->involved_witness) ? 'selected' : '' }}>Involved</option>
                        <option value="0" {{ !old('staff_involved_witness', $staff?->involved_witness) ? 'selected' : '' }}>Witness</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Injured</label>
                    <select name="staff_injured" class="{{ $inp }}">
                        <option value="1" {{ old('staff_injured', $staff?->injured) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('staff_injured', $staff?->injured) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Medical Attention Required</label>
                    <select name="staff_medical_attention" class="{{ $inp }}">
                        <option value="1" {{ old('staff_medical_attention', $staff?->medical_attention) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('staff_medical_attention', $staff?->medical_attention) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
        </section>

        {{-- Parts 4 & 5: Background & What Happened --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <h3 class="text-base font-semibold mb-1">Parts 4 & 5 · Background & What Happened</h3>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Description of Incident</label>
                    <textarea name="description_of_incident" rows="4" class="{{ $inp }} resize-y">{{ old('description_of_incident', $whatHappend?->desciption_of_incident) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Immediate Action by Staff</label>
                    <textarea name="action_taken_by_staff" rows="3" class="{{ $inp }} resize-y">{{ old('action_taken_by_staff', $whatHappend?->actoin_taken_by_staff) }}</textarea>
                </div>
                <div>
                    <label class="{{ $lbl }}">Property / Equipment Damaged?</label>
                    <select name="wh_property_damage" class="{{ $inp }}">
                        <option value="1" {{ old('wh_property_damage', $whatHappend?->property_damage) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('wh_property_damage', $whatHappend?->property_damage) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Police Contacted?</label>
                    <select name="police_contacted" class="{{ $inp }}">
                        <option value="1" {{ old('police_contacted', $whatHappend?->police_contacted) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('police_contacted', $whatHappend?->police_contacted) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Details of Damage</label>
                    <textarea name="details_of_damage" rows="3" class="{{ $inp }} resize-y">{{ old('details_of_damage', $whatHappend?->details_of_damage) }}</textarea>
                </div>
                <div>
                    <label class="{{ $lbl }}">Reported to Line Manager?</label>
                    <select name="reported_to_line_manager" class="{{ $inp }}">
                        <option value="1" {{ old('reported_to_line_manager', $whatHappend?->reported_to_line_manager) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('reported_to_line_manager', $whatHappend?->reported_to_line_manager) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Manager Name</label>
                    <input type="text" name="wh_manager_name" value="{{ old('wh_manager_name', $whatHappend?->manager_name) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Reporter Signature</label>
                    <input type="text" name="reporter_signature" value="{{ old('reporter_signature', $whatHappend?->reporter_signature) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Date</label>
                    <input type="date" name="wh_date" value="{{ old('wh_date', $whatHappend?->date) }}" class="{{ $inp }}">
                </div>
            </div>
        </section>

        {{-- Part 6: Manager's Report --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <h3 class="text-base font-semibold mb-1">Part 6 · Manager's Report</h3>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="{{ $lbl }}">Manager Name</label>
                    <input type="text" name="report_manager_name" value="{{ old('report_manager_name', $manager?->report_manager_name) }}" class="{{ $inp }}">
                </div>
                <div>
                    <label class="{{ $lbl }}">Position</label>
                    <input type="text" name="report_manager_position" value="{{ old('report_manager_position', $manager?->report_manager_position) }}" class="{{ $inp }}">
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Immediate Action Taken</label>
                    <textarea name="immediate_action_taken" rows="3" class="{{ $inp }} resize-y">{{ old('immediate_action_taken', $manager?->immediate_action_taken) }}</textarea>
                </div>
                <div>
                    <label class="{{ $lbl }}">Family / Guardian Notified?</label>
                    <select name="family_notified" class="{{ $inp }}">
                        <option value="1" {{ old('family_notified', $manager?->family_notified) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('family_notified', $manager?->family_notified) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Investigation into Possible Causes?</label>
                    <select name="investigation_possible_causes" class="{{ $inp }}">
                        <option value="1" {{ old('investigation_possible_causes', $manager?->investigation_possible_causes) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('investigation_possible_causes', $manager?->investigation_possible_causes) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Investigation Record</label>
                    <textarea name="investigation_record" rows="3" class="{{ $inp }} resize-y">{{ old('investigation_record', $manager?->investigation_record) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Investigation Finding</label>
                    <textarea name="investigation_finding" rows="3" class="{{ $inp }} resize-y">{{ old('investigation_finding', $manager?->investigation_finding) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Outcome / Action to Mitigate</label>
                    <textarea name="outcome_incident" rows="3" class="{{ $inp }} resize-y">{{ old('outcome_incident', $manager?->outcome_incident) }}</textarea>
                </div>
                <div>
                    <label class="{{ $lbl }}">Investigation Action Completed?</label>
                    <select name="investigation_action_completed" class="{{ $inp }}">
                        <option value="1" {{ old('investigation_action_completed', $manager?->investigation_action_completed) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('investigation_action_completed', $manager?->investigation_action_completed) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="{{ $lbl }}">Date Completed</label>
                    <input type="date" name="informed_date" value="{{ old('informed_date', $manager?->informed_date) }}" class="{{ $inp }}">
                </div>
                <div class="md:col-span-2">
                    <label class="{{ $lbl }}">Participant / Representative Feedback</label>
                    <textarea name="participant_feedback" rows="3" class="{{ $inp }} resize-y">{{ old('participant_feedback', $manager?->participant_feedback) }}</textarea>
                </div>
                <div>
                    <label class="{{ $lbl }}">Reportable Incident?</label>
                    <select name="reportable_incident" class="{{ $inp }}">
                        <option value="1" {{ old('reportable_incident', $manager?->reportable_incident) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('reportable_incident', $manager?->reportable_incident) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
        </section>

        {{-- Actions --}}
        <div class="flex justify-between gap-2 mb-10">
            <a href="{{ route('forms.incident.index') }}"
               class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium hover:bg-slate-50 dark:hover:bg-ink-800 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft transition">
                Save Changes
            </button>
        </div>

    </form>

@endsection
