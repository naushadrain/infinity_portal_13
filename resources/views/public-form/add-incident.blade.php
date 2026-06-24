<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Report Form</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-6 flex items-start justify-start gap-10 text-sm font-semibold text-slate-800">
            <span class="flex items-center gap-2">
                <i data-lucide="mail" class="w-5 h-5 text-sky-500"></i>
                info@infiniteability.com.au
            </span>
            <span class="flex items-center gap-2">
                <i data-lucide="phone" class="w-5 h-5 text-sky-500"></i>
                1300044422
            </span>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png" class="h-14" alt="Infinite Ability Logo">
            </div>
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#" class="hover:text-sky-600">About Us</a>
                <a href="#" class="hover:text-sky-600">Services</a>
                <a href="#" class="hover:text-sky-600">About NDIS</a>
                <a href="#" class="text-lime-500">Referral</a>
                <a href="#" class="hover:text-sky-600">Gallery</a>
                <a href="#" class="hover:text-sky-600">Contact Us</a>
            </nav>
        </div>
    </header>

    <section class="relative h-[350px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/4.jpg" alt="Incident Report" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-6xl font-bold">Incident Report Form</h1>
            <p class="text-white/90 mt-4 text-lg">Complete the incident details below</p>
        </div>
    </section>

    @php
        $inp = 'w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none text-sm transition mt-1.5';
        $lbl = 'block text-sm font-medium text-slate-700';
    @endphp

    @if(session('success'))
        <div id="toast" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="toast" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            <i data-lucide="x-circle" class="w-5 h-5"></i>
            {{ session('error') }}
        </div>
    @endif

    <main class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10">

            <h2 class="text-2xl font-bold mb-1">Participant Incident Report Form</h2>
            <p class="text-slate-500 mb-8 text-sm">
                Complete this form to report incidents involving and/or impacting upon Participants in services delivered by Infinite Ability.
            </p>

            <form id="incidentForm" method="POST" action="{{ route('incident.public.store') }}" novalidate>
                @csrf

                <!-- ── Part 1: Reporter Details ────────────────────────────── -->
                <div class="mb-8">
                    <h3 class="text-sm font-black uppercase tracking-wide text-blue-600 mb-1">Part 1 · Reporter Details</h3>
                    <div class="h-px bg-slate-100 mb-5"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">Name of the person reporting this incident <span class="text-red-500">*</span></label>
                            <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" placeholder="Enter Name" class="{{ $inp }}" data-required>
                            <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                        </div>

                        <div>
                            <label class="{{ $lbl }}">Contact number <span class="text-red-500">*</span></label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="Enter Here" class="{{ $inp }}" data-required>
                            <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                        </div>

                        <div>
                            <label class="{{ $lbl }}">Incident Project Number</label>
                            <input type="text" name="ir_number" value="{{ old('ir_number') }}" placeholder="IN-2043" class="{{ $inp }}">
                        </div>

                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">Position Title</label>
                            <input type="text" name="position_title" value="{{ old('position_title') }}" placeholder="Enter Here" class="{{ $inp }}">
                        </div>

                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">City <span class="text-red-500">*</span></label>
                            <select name="city" class="{{ $inp }}" data-required>
                                <option value="">Please Select</option>
                                <option value="Perth" {{ old('city') === 'Perth' ? 'selected' : '' }}>Perth</option>
                                <option value="Victoria" {{ old('city') === 'Victoria' ? 'selected' : '' }}>Victoria</option>
                            </select>
                            <p class="err hidden text-red-500 text-xs mt-1">Please select a city.</p>
                        </div>
                    </div>
                </div>

                <!-- ── Part 2: Incident Details ───────────────────────────── -->
                <div class="mb-8">
                    <h3 class="text-sm font-black uppercase tracking-wide text-blue-600 mb-1">Part 2 · Incident Details</h3>
                    <div class="h-px bg-slate-100 mb-5"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">Date of incident <span class="text-red-500">*</span></label>
                            <input type="date" name="incident_date" value="{{ old('incident_date') }}" class="{{ $inp }}" data-required>
                            <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                        </div>

                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">Time of incident <span class="text-red-500">*</span></label>
                            <input type="time" name="incident_time" value="{{ old('incident_time') }}" class="{{ $inp }}" data-required>
                            <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                        </div>

                        <div class="md:col-span-2 xl:col-span-4">
                            <label class="{{ $lbl }}">Address</label>
                            <input type="text" name="incident_address" value="{{ old('incident_address') }}" placeholder="Enter Here" class="{{ $inp }}">
                        </div>

                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">Date first told you about the incident (if applicable)</label>
                            <input type="date" name="date_first_told" value="{{ old('date_first_told') }}" class="{{ $inp }}">
                        </div>

                        <div class="xl:col-span-2">
                            <label class="{{ $lbl }}">Time first told you about the incident (if applicable)</label>
                            <input type="time" name="time_first_told" value="{{ old('time_first_told') }}" class="{{ $inp }}">
                        </div>

                        <div class="md:col-span-2 xl:col-span-4">
                            <label class="{{ $lbl }} mb-2">Incident Type <span class="text-red-500">*</span></label>
                            <p id="incident_type_err" class="hidden text-red-500 text-xs mb-1">Please select at least one incident type.</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-2 mt-1.5">
                                @php
                                    $types = [
                                        'Absent/Missing persons',
                                        'Behaviour',
                                        'Breach of Privacy/Confidentiality',
                                        'Death',
                                        'Drug/Alcohol',
                                        'Emergency',
                                        'Medication',
                                        'Physical/Restraint',
                                        'Property damage',
                                        'Self Abuse',
                                        'Suicide Attempted',
                                        'None',
                                        'Other',
                                    ];
                                    $oldTypes = old('incident_type', []);
                                @endphp
                                @foreach($types as $type)
                                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                        <input type="checkbox" name="incident_type[]" value="{{ $type }}"
                                            class="w-4 h-4 accent-sky-600"
                                            {{ in_array($type, $oldTypes) ? 'checked' : '' }}>
                                        {{ $type }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Part 3: Who was involved? ──────────────────────────── -->
                <div class="mb-8">
                    <h3 class="text-sm font-black uppercase tracking-wide text-blue-600 mb-1">Part 3 · Who was involved?</h3>
                    <div class="h-px bg-slate-100 mb-5"></div>

                    <!-- Participants -->
                    <div class="mb-6">
                        <h4 class="text-base font-bold text-slate-800 mb-4">Participants: details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            <div>
                                <label class="{{ $lbl }}">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="participant_name" value="{{ old('participant_name') }}" placeholder="Enter Here" class="{{ $inp }}" data-required>
                                <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Date Of Birth</label>
                                <input type="date" name="participant_dob" value="{{ old('participant_dob') }}" class="{{ $inp }}">
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Address</label>
                                <input type="text" name="participant_address" value="{{ old('participant_address') }}" placeholder="Enter Here" class="{{ $inp }}">
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Involved/Witness</label>
                                <select name="participant_involved_witness" class="{{ $inp }}">
                                    <option value="Involved" {{ old('participant_involved_witness', 'Involved') === 'Involved' ? 'selected' : '' }}>Involved</option>
                                    <option value="Witness" {{ old('participant_involved_witness') === 'Witness' ? 'selected' : '' }}>Witness</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Injured?</label>
                                <select name="participant_injured" class="{{ $inp }}">
                                    <option value="Yes" {{ old('participant_injured', 'Yes') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('participant_injured') === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Medical Attention required?</label>
                                <select name="participant_medical_attention" class="{{ $inp }}">
                                    <option value="Yes" {{ old('participant_medical_attention', 'Yes') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('participant_medical_attention') === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Staff/Carer -->
                    <div>
                        <h4 class="text-base font-bold text-slate-800 mb-4">Staff/Carer or Others: details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            <div>
                                <label class="{{ $lbl }}">Full Name</label>
                                <input type="text" name="staff_name" value="{{ old('staff_name') }}" placeholder="Enter Here" class="{{ $inp }}">
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Address</label>
                                <input type="text" name="staff_address" value="{{ old('staff_address') }}" placeholder="Enter Here" class="{{ $inp }}">
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Staff/Other</label>
                                <select name="staff_other" class="{{ $inp }}">
                                    <option value="Staff" {{ old('staff_other', 'Staff') === 'Staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="Other" {{ old('staff_other') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Involved/Witness</label>
                                <select name="staff_involved_witness" class="{{ $inp }}">
                                    <option value="Involved" {{ old('staff_involved_witness', 'Involved') === 'Involved' ? 'selected' : '' }}>Involved</option>
                                    <option value="Witness" {{ old('staff_involved_witness') === 'Witness' ? 'selected' : '' }}>Witness</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Injured?</label>
                                <select name="staff_injured" class="{{ $inp }}">
                                    <option value="Yes" {{ old('staff_injured', 'Yes') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('staff_injured') === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Medical Attention required?</label>
                                <select name="staff_medical_attention" class="{{ $inp }}">
                                    <option value="Yes" {{ old('staff_medical_attention', 'Yes') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('staff_medical_attention') === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Part 4: Incident Background ────────────────────────── -->
                <div class="mb-8">
                    <h3 class="text-sm font-black uppercase tracking-wide text-blue-600 mb-1">Part 4 · Incident Background</h3>
                    <div class="h-px bg-slate-100 mb-5"></div>
                    <p class="text-xs text-slate-500 mb-2">Eg. What was client doing before incident?</p>
                    <textarea name="incident_background" rows="4" placeholder="Enter Here" class="{{ $inp }}">{{ old('incident_background') }}</textarea>
                </div>

                <!-- ── Part 5: What happened? ──────────────────────────────── -->
                <div class="mb-8">
                    <h3 class="text-sm font-black uppercase tracking-wide text-blue-600 mb-1">Part 5 · What happened?</h3>
                    <div class="h-px bg-slate-100 mb-5"></div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="{{ $lbl }}">Incident Description <span class="text-red-500">*</span></label>
                            <textarea name="incident_description" rows="6" placeholder="Enter Here" class="{{ $inp }}" data-required>{{ old('incident_description') }}</textarea>
                            <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                        </div>

                        <div>
                            <label class="{{ $lbl }}">Immediate action taken by Staff <span class="text-red-500">*</span></label>
                            <textarea name="immediate_action" rows="5" placeholder="Enter Here" class="{{ $inp }}" data-required>{{ old('immediate_action') }}</textarea>
                            <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="{{ $lbl }}">Was any property or equipment damaged?</label>
                                <select name="property_damaged" class="{{ $inp }}">
                                    <option value="No" {{ old('property_damaged', 'No') === 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Yes" {{ old('property_damaged') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Police Contacted?</label>
                                <select name="police_contacted" class="{{ $inp }}">
                                    <option value="No" {{ old('police_contacted', 'No') === 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Yes" {{ old('police_contacted') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="{{ $lbl }}">Details of Damage (if applicable)</label>
                            <textarea name="damage_details" rows="3" placeholder="Enter Here" class="{{ $inp }}">{{ old('damage_details') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="{{ $lbl }}">Incident reported to Line Manager?</label>
                                <select name="reported_to_manager" class="{{ $inp }}">
                                    <option value="Yes" {{ old('reported_to_manager', 'Yes') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('reported_to_manager') === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Manager's name</label>
                                <input type="text" name="manager_name" value="{{ old('manager_name') }}" placeholder="Enter Here" class="{{ $inp }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="{{ $lbl }}">Date</label>
                                <input type="date" name="report_date" value="{{ old('report_date') }}" class="{{ $inp }}">
                            </div>

                            <div>
                                <label class="{{ $lbl }}">Reporter's Signature</label>
                                <input type="text" name="reporter_signature" value="{{ old('reporter_signature') }}" placeholder="Enter Here" class="{{ $inp }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Actions ────────────────────────────────────────────── -->
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <button type="reset" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm font-medium hover:bg-slate-50 transition">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition flex items-center gap-2">
                        <span id="submitLabel">Submit incident report</span>
                        <svg id="submitSpinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-slate-900 text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-4 gap-8">
            <div>
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png" class="h-14 bg-white rounded p-1 mb-4" alt="Logo">
                <p class="text-sm text-slate-300">Infinite Ability incident report form.</p>
            </div>
            <div>
                <h3 class="font-bold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>Home</li><li>About Us</li><li>About NDIS</li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold mb-3">Services</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>Supported Independent Living</li>
                    <li>NDIS Support Coordination</li>
                    <li>Personal Care</li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold mb-3">Contact</h3>
                <p class="text-sm text-slate-300">info@infiniteability.com.au</p>
                <p class="text-sm text-slate-300">1300044422</p>
            </div>
        </div>
        <div class="border-t border-slate-700 py-4 text-center text-sm text-slate-400">
            Copyright &copy; 2026 Infinite Ability. All rights reserved.
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Auto-hide toast
        const toast = document.getElementById('toast');
        if (toast) setTimeout(() => toast.remove(), 5000);

        // Client-side validation
        document.getElementById('incidentForm').addEventListener('submit', function (e) {
            let valid = true;

            // Text/select required fields
            this.querySelectorAll('[data-required]').forEach(function (field) {
                const err = field.nextElementSibling;
                if (!field.value.trim()) {
                    field.classList.add('border-red-400', 'ring-1', 'ring-red-300');
                    if (err && err.classList.contains('err')) err.classList.remove('hidden');
                    valid = false;
                } else {
                    field.classList.remove('border-red-400', 'ring-1', 'ring-red-300');
                    if (err && err.classList.contains('err')) err.classList.add('hidden');
                }
            });

            // Incident type: at least one checkbox
            const checkboxes = document.querySelectorAll('input[name="incident_type[]"]');
            const typeErr = document.getElementById('incident_type_err');
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            if (!anyChecked) {
                typeErr.classList.remove('hidden');
                valid = false;
            } else {
                typeErr.classList.add('hidden');
            }

            if (!valid) {
                e.preventDefault();
                // Scroll to first error
                const firstErr = document.querySelector('.border-red-400, #incident_type_err:not(.hidden)');
                if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            // Show spinner
            document.getElementById('submitLabel').textContent = 'Submitting...';
            document.getElementById('submitSpinner').classList.remove('hidden');
            document.getElementById('submitBtn').disabled = true;
        });

        // Live validation: remove error on input
        document.querySelectorAll('[data-required]').forEach(function (field) {
            field.addEventListener('input', function () {
                if (this.value.trim()) {
                    this.classList.remove('border-red-400', 'ring-1', 'ring-red-300');
                    const err = this.nextElementSibling;
                    if (err && err.classList.contains('err')) err.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
