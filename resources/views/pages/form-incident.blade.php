@extends('layouts.app', ['title' => 'Incident Report Form'])
@section('title', 'Incident Report Form')

@section('content')
    @php
        $inputClass =
            'form-input w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-ink-700 bg-white dark:bg-ink-950 text-slate-900 dark:text-ink-100 placeholder:text-slate-400 dark:placeholder:text-ink-500 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm transition';

        $labelClass = 'text-sm font-medium text-slate-700 dark:text-ink-200';
        $sectionTitle = 'mb-4 text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400';

        $toastMessage = session('success') ?? session('error') ?? ($errors->any() ? $errors->first() : null);
        $toastType = session('success') ? 'success' : 'error';
    @endphp

    {{-- Toaster --}}
    @if ($toastMessage)
        <div id="toastMessage"
            class="fixed top-5 right-5 z-[9999] w-[340px] max-w-[calc(100vw-2rem)] rounded-xl border text-white shadow-2xl overflow-hidden transition-all duration-300
            {{ $toastType === 'success' ? 'bg-emerald-600 border-emerald-500' : 'bg-rose-600 border-rose-500' }}">

            <div class="flex items-start gap-3 p-4">
                <i data-lucide="{{ $toastType === 'success' ? 'circle-check' : 'circle-x' }}"
                    class="w-5 h-5 mt-0.5 shrink-0"></i>

                <div class="flex-1">
                    <h4 class="text-sm font-semibold">
                        {{ $toastType === 'success' ? 'Success' : 'Error' }}
                    </h4>
                    <p class="text-sm text-white/90 mt-0.5">
                        {{ $toastMessage }}
                    </p>
                </div>

                <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <div class="h-1 bg-white/25">
                <div id="toastProgress" class="h-full bg-white/80"></div>
            </div>
        </div>
    @endif

    <form id="incidentForm" method="POST" action="{{ route('forms.incident.store') }}">
        @csrf

        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-5 md:p-6 mb-8">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    Incident Report Form
                </h2>
                <p class="text-sm text-slate-500 dark:text-ink-400 mt-1">
                    Complete the incident details below.
                </p>
            </div>

            {{-- Part 1 --}}
            <div class="mb-8">
                <h3 class="{{ $sectionTitle }}">Part 1 · Reporter Details</h3>
                <div class="h-px bg-slate-100 dark:bg-ink-800 my-5"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Name of person reporting *</label>
                        <input type="text" name="reporter_name" id="reporter_name"
                            value="{{ old('reporter_name') }}"
                            data-required="true"
                            data-message="Reporter name is required."
                            class="{{ $inputClass }} mt-1.5">
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Contact number *</label>
                        <input type="text" name="contact_number" id="contact_number"
                            value="{{ old('contact_number') }}"
                            data-required="true"
                            data-message="Contact number is required."
                            class="{{ $inputClass }} mt-1.5">
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Incident Report Number</label>
                        <input type="text" name="incident_report_number"
                            value="{{ old('incident_report_number') }}"
                            placeholder="IN-2043"
                            class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div class="md:col-span-1 xl:col-span-2">
                        <label class="{{ $labelClass }}">Position Title</label>
                        <input type="text" name="position_title"
                            value="{{ old('position_title') }}"
                            class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div class="md:col-span-1 xl:col-span-2">
                        <label class="{{ $labelClass }}">City *</label>
                        <select name="city" id="city"
                            data-required="true"
                            data-message="City is required."
                            class="{{ $inputClass }} mt-1.5">
                            <option value="">Please select</option>
                            <option value="Perth" @selected(old('city') === 'Perth')>Perth</option>
                            <option value="Victoria" @selected(old('city') === 'Victoria')>Victoria</option>
                        </select>
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>
                </div>
            </div>

            {{-- Part 2 --}}
            <div class="mb-8">
                <h3 class="{{ $sectionTitle }}">Part 2 · Incident Details</h3>
                <div class="h-px bg-slate-100 dark:bg-ink-800 my-5"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">Date of incident *</label>
                        <input type="date" name="incident_date" id="incident_date"
                            value="{{ old('incident_date') }}"
                            data-required="true"
                            data-message="Incident date is required."
                            class="{{ $inputClass }} mt-1.5">
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Time of incident *</label>
                        <input type="time" name="incident_time" id="incident_time"
                            value="{{ old('incident_time') }}"
                            data-required="true"
                            data-message="Incident time is required."
                            class="{{ $inputClass }} mt-1.5">
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Date first told</label>
                        <input type="date" name="date_first_told"
                            value="{{ old('date_first_told') }}"
                            class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Address *</label>
                        <input type="text" name="incident_address" id="incident_address"
                            value="{{ old('incident_address') }}"
                            data-required="true"
                            data-message="Incident address is required."
                            class="{{ $inputClass }} mt-1.5">
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Incident Type *</label>

                        <div id="incidentTypeBox" class="mt-4 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
                            @foreach (['Absent/Missing person', 'Behaviour', 'Breach of Privacy', 'Death', 'Drug/Alcohol', 'Illness/Injury', 'Assault (Physical/Sexual)', 'Property Damage', 'Self-Harm', 'Suicide Attempted', 'Near Miss', 'Other'] as $type)
                                <label class="flex items-center gap-2.5 text-sm text-slate-700 dark:text-ink-200 cursor-pointer">
                                    <input type="checkbox" name="incident_type[]" value="{{ $type }}"
                                        @checked(is_array(old('incident_type')) && in_array($type, old('incident_type')))
                                        class="incident-type h-4 w-4 rounded border-slate-300 dark:border-ink-700 text-brand-600 focus:ring-brand-500">
                                    <span>{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>

                        <p id="incidentTypeError" class="hidden mt-2 text-xs text-rose-500">
                            Please select at least one incident type.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Part 3 --}}
            <div class="mb-8">
                <h3 class="{{ $sectionTitle }}">Part 3 · Who was involved?</h3>
                <div class="h-px bg-slate-100 dark:bg-ink-800 my-5"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-3 text-sm font-semibold text-slate-800 dark:text-ink-100">
                        Participant details
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Full name *</label>
                        <input type="text" name="participant_name" id="participant_name"
                            value="{{ old('participant_name') }}"
                            data-required="true"
                            data-message="Participant name is required."
                            class="{{ $inputClass }} mt-1.5">
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Date of birth</label>
                        <input type="date" name="participant_dob"
                            value="{{ old('participant_dob') }}"
                            class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Involved/Witness</label>
                        <select name="participant_type" class="{{ $inputClass }} mt-1.5">
                            <option value="Involved" @selected(old('participant_type') === 'Involved')>Involved</option>
                            <option value="Witness" @selected(old('participant_type') === 'Witness')>Witness</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Address</label>
                        <input type="text" name="participant_address"
                            value="{{ old('participant_address') }}"
                            class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Injured? *</label>
                        <select name="participant_injured" class="{{ $inputClass }} mt-1.5">
                            <option value="No" @selected(old('participant_injured') === 'No')>No</option>
                            <option value="Yes" @selected(old('participant_injured') === 'Yes')>Yes</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Medical attention required? *</label>
                        <select name="participant_medical_attention" class="{{ $inputClass }} mt-1.5">
                            <option value="No" @selected(old('participant_medical_attention') === 'No')>No</option>
                            <option value="Yes" @selected(old('participant_medical_attention') === 'Yes')>Yes</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Part 4 --}}
            <div class="mb-8">
                <h3 class="{{ $sectionTitle }}">Part 4 · Incident Background</h3>
                <div class="h-px bg-slate-100 dark:bg-ink-800 my-5"></div>

                <label class="{{ $labelClass }}">What was the client doing before the incident?</label>
                <textarea name="incident_background" rows="5" class="{{ $inputClass }} mt-1.5">{{ old('incident_background') }}</textarea>
            </div>

            {{-- Part 5 --}}
            <div class="mb-8">
                <h3 class="{{ $sectionTitle }}">Part 5 · What happened?</h3>
                <div class="h-px bg-slate-100 dark:bg-ink-800 my-5"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Incident description *</label>
                        <textarea name="incident_description" id="incident_description" rows="5"
                            data-required="true"
                            data-message="Incident description is required."
                            class="{{ $inputClass }} mt-1.5">{{ old('incident_description') }}</textarea>
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Immediate action taken by staff *</label>
                        <textarea name="immediate_action" id="immediate_action" rows="4"
                            data-required="true"
                            data-message="Immediate action is required."
                            class="{{ $inputClass }} mt-1.5">{{ old('immediate_action') }}</textarea>
                        <p class="field-error hidden mt-1 text-xs text-rose-500"></p>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Was any property or equipment damaged? *</label>
                        <select name="property_damaged" class="{{ $inputClass }} mt-1.5">
                            <option value="No" @selected(old('property_damaged') === 'No')>No</option>
                            <option value="Yes" @selected(old('property_damaged') === 'Yes')>Yes</option>
                        </select>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Police contacted? *</label>
                        <select name="police_contacted" class="{{ $inputClass }} mt-1.5">
                            <option value="No" @selected(old('police_contacted') === 'No')>No</option>
                            <option value="Yes" @selected(old('police_contacted') === 'Yes')>Yes</option>
                        </select>
                    </div>

                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Details of damage</label>
                        <textarea name="damage_details" rows="3" class="{{ $inputClass }} mt-1.5">{{ old('damage_details') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Part 6 --}}
            <div>
                <h3 class="{{ $sectionTitle }}">Part 6 · Manager's Report</h3>
                <div class="h-px bg-slate-100 dark:bg-ink-800 my-5"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Manager's name</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name') }}" class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Position</label>
                        <input type="text" name="manager_position" value="{{ old('manager_position') }}" class="{{ $inputClass }} mt-1.5">
                    </div>

                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Immediate action taken to ensure safety</label>
                        <textarea name="manager_safety_action" rows="4" class="{{ $inputClass }} mt-1.5">{{ old('manager_safety_action') }}</textarea>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Family / carer / guardian notified?</label>
                        <select name="guardian_notified" class="{{ $inputClass }} mt-1.5">
                            <option value="Yes" @selected(old('guardian_notified') === 'Yes')>Yes</option>
                            <option value="No" @selected(old('guardian_notified') === 'No')>No</option>
                        </select>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Investigation undertaken?</label>
                        <select name="investigation_undertaken" class="{{ $inputClass }} mt-1.5">
                            <option value="Yes" @selected(old('investigation_undertaken') === 'Yes')>Yes</option>
                            <option value="No" @selected(old('investigation_undertaken') === 'No')>No</option>
                        </select>
                    </div>

                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Investigation record of what happened</label>
                        <textarea name="investigation_record" rows="4" class="{{ $inputClass }} mt-1.5">{{ old('investigation_record') }}</textarea>
                    </div>

                    <div class="md:col-span-3 xl:col-span-4">
                        <label class="{{ $labelClass }}">Investigation finding</label>
                        <textarea name="investigation_finding" rows="4" class="{{ $inputClass }} mt-1.5">{{ old('investigation_finding') }}</textarea>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Is this a reportable incident? *</label>
                        <select name="reportable_incident" class="{{ $inputClass }} mt-1.5">
                            <option value="Yes" @selected(old('reportable_incident') === 'Yes')>Yes</option>
                            <option value="No" @selected(old('reportable_incident') === 'No')>No</option>
                        </select>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="{{ $labelClass }}">Signature of Line Manager</label>
                        <input type="text" name="manager_signature" value="{{ old('manager_signature') }}" class="{{ $inputClass }} mt-1.5">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-2 mt-8 pt-6 border-t border-slate-100 dark:border-ink-800">
                <a href="{{ route('forms.incident.index') }}"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-ink-700 bg-white dark:bg-ink-950 text-slate-700 dark:text-ink-200 text-sm font-medium hover:bg-slate-50 dark:hover:bg-ink-800 transition">
                    Cancel
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft transition">
                    Submit incident report
                </button>
            </div>
        </section>
    </form>

    <script>
        function closeToast() {
            const toast = document.getElementById('toastMessage');

            if (toast) {
                toast.classList.add('opacity-0', 'translate-x-5');

                setTimeout(() => toast.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('incidentForm');

            if (window.lucide) {
                lucide.createIcons();
            }

            const progress = document.getElementById('toastProgress');
            if (progress) {
                progress.style.width = '100%';
                progress.style.transition = 'width 4s linear';

                setTimeout(() => {
                    progress.style.width = '0%';
                }, 100);

                setTimeout(closeToast, 4200);
            }

            if (!form) return;

            function setError(field, message) {
                field.classList.remove('border-slate-200', 'dark:border-ink-700');
                field.classList.add('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500/20');

                const error = field.parentElement.querySelector('.field-error');

                if (error) {
                    error.textContent = message;
                    error.classList.remove('hidden');
                }
            }

            function clearError(field) {
                field.classList.remove('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500/20');
                field.classList.add('border-slate-200', 'dark:border-ink-700');

                const error = field.parentElement.querySelector('.field-error');

                if (error) {
                    error.textContent = '';
                    error.classList.add('hidden');
                }
            }

            function validateIncidentTypes() {
                const checked = document.querySelectorAll('.incident-type:checked').length;
                const box = document.getElementById('incidentTypeBox');
                const error = document.getElementById('incidentTypeError');

                if (checked === 0) {
                    box.classList.add('rounded-xl', 'border', 'border-rose-500', 'p-3');
                    error.classList.remove('hidden');
                    return false;
                }

                box.classList.remove('rounded-xl', 'border', 'border-rose-500', 'p-3');
                error.classList.add('hidden');
                return true;
            }

            form.addEventListener('submit', function (e) {
                let valid = true;

                document.querySelectorAll('[data-required="true"]').forEach(function (field) {
                    if (!field.value.trim()) {
                        setError(field, field.dataset.message || 'This field is required.');
                        valid = false;
                    } else {
                        clearError(field);
                    }
                });

                if (!validateIncidentTypes()) {
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();

                    const firstError = document.querySelector('.border-rose-500');

                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });

            document.querySelectorAll('[data-required="true"]').forEach(function (field) {
                field.addEventListener('input', function () {
                    if (field.value.trim()) {
                        clearError(field);
                    }
                });

                field.addEventListener('change', function () {
                    if (field.value.trim()) {
                        clearError(field);
                    }
                });
            });

            document.querySelectorAll('.incident-type').forEach(function (checkbox) {
                checkbox.addEventListener('change', validateIncidentTypes);
            });
        });
    </script>
@endsection