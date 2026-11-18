<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medication Incident</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: rgb(51 65 85);
        }
    
        .dark .form-label {
            color: rgb(203 213 225);
        }
    
        .form-input {
            margin-top: 0.375rem;
            width: 100%;
            border-radius: 0.875rem;
            border: 1px solid rgb(203 213 225);
            background: white;
            padding: 0.7rem 0.9rem;
            font-size: 0.875rem;
            color: rgb(15 23 42);
            outline: none;
            transition: border-color 0.15s;
        }
    
        .form-input:focus {
            border-color: rgb(37 99 235);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
        }
    
        .form-input.is-invalid {
            border-color: rgb(239 68 68);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .15);
        }
    
        .dark .form-input {
            border-color: rgb(51 65 85);
            background: rgb(15 23 42);
            color: white;
        }
    
        .check-card {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            cursor: pointer;
            border-radius: 0.875rem;
            border: 1px solid rgb(226 232 240);
            background: rgb(248 250 252);
            padding: 0.75rem;
            font-size: 0.875rem;
            color: rgb(51 65 85);
            transition: 0.2s;
        }
    
        .check-card:hover {
            border-color: rgb(37 99 235);
            background: rgba(37, 99, 235, .06);
        }
    
        .dark .check-card {
            border-color: rgb(51 65 85);
            background: rgb(15 23 42);
            color: rgb(203 213 225);
        }
    
        .check-box {
            height: 1rem;
            width: 1rem;
            flex-shrink: 0;
            border-radius: 0.3rem;
            border: 1px solid rgb(148 163 184);
            background: white;
        }
    
        .dark .check-box {
            background: rgb(2 6 23);
            border-color: rgb(100 116 139);
        }
    
        .peer:checked + .check-box {
            border-color: rgb(37 99 235);
            background: rgb(37 99 235);
            box-shadow: inset 0 0 0 3px white;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    @include('public-form.partials._header')

    <section class="relative h-[350px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/4.jpg" alt="Medication Incident Report" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-6xl font-bold">Medication Incident Form</h1>
            <p class="text-white/90 mt-4 text-lg">Complete the medication incident / error details below</p>
        </div>
    </section>

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

    @if($errors->any())
        <div class="max-w-5xl mx-auto px-4 pt-6">
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="max-w-5xl mx-auto px-4 py-10">
    <form id="medication-form"
          action="{{ route('medication.public.store') }}"
          method="POST"
          novalidate
          class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
        @csrf

        {{-- Header --}}
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
            <h2 class="text-xl font-black text-slate-900">
                Medication Incident
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Please complete all relevant details about the medication incident or error.
            </p>
        </div>

        <div class="space-y-8 p-6">

            {{-- Part 1 --}}
            <section>
                <h2 class="mb-4 text-sm font-black uppercase tracking-wide text-blue-600">
                    Part 1 · Person Reporting Details
                </h2>

                <div class="grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-6">
                        <label class="form-label">Name of person reporting <span class="text-red-500">*</span></label>
                        <input type="text" name="pr_name" value="{{ old('pr_name') }}" class="form-input" data-required>
                    </div>

                    <div class="md:col-span-6">
                        <label class="form-label">Position <span class="text-red-500">*</span></label>
                        <input type="text" name="pr_position" value="{{ old('pr_position') }}" class="form-input" data-required>
                    </div>

                    <div class="md:col-span-4">
                        <label class="form-label">Date incident/error occurred <span class="text-red-500">*</span></label>
                        <input type="date" name="pr_date_occured" value="{{ old('pr_date_occured') }}" class="form-input" data-required>
                    </div>

                    <div class="md:col-span-4">
                        <label class="form-label">Time of incident/error <span class="text-red-500">*</span></label>
                        <input type="time" name="pr_time_occured" value="{{ old('pr_time_occured') }}" class="form-input" data-required>
                    </div>

                    <div class="md:col-span-4">
                        <label class="form-label">Date incident/error reported <span class="text-red-500">*</span></label>
                        <input type="date" name="pr_date_reported" value="{{ old('pr_date_reported') }}" class="form-input" data-required>
                    </div>

                    <div class="md:col-span-12">
                        <label class="form-label">Incident/Error reported to <span class="text-red-500">*</span></label>
                        <input type="text" name="pr_incident_reported_to" value="{{ old('pr_incident_reported_to') }}" class="form-input" data-required>
                    </div>
                </div>
            </section>

            {{-- Part 2 --}}
            <section class="border-t border-slate-200 pt-8">
                <h2 class="mb-4 text-sm font-black uppercase tracking-wide text-blue-600">
                    Part 2 · Client / Participant Details
                </h2>

                <div class="grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-6">
                        <label class="form-label">Client / Participant name <span class="text-red-500">*</span></label>
                        <input type="text" name="cd_name" value="{{ old('cd_name') }}" class="form-input" data-required>
                    </div>

                    <div class="md:col-span-6">
                        <label class="form-label">Location of incident/error <span class="text-red-500">*</span></label>
                        <select name="cd_location" class="form-input" data-required>
                            <option value="">Please Select</option>
                            <option value="Perth" {{ old('cd_location') === 'Perth' ? 'selected' : '' }}>Perth</option>
                            <option value="Victoria" {{ old('cd_location') === 'Victoria' ? 'selected' : '' }}>Victoria</option>
                        </select>
                    </div>

                    <div class="md:col-span-12">
                        <label class="form-label">Name of person responsible, if not reporter</label>
                        <input type="text" name="cd_responsible" value="{{ old('cd_responsible') }}" class="form-input">
                    </div>
                </div>
            </section>

            {{-- Part 3 --}}
            <section class="border-t border-slate-200 pt-8">
                <h2 class="mb-4 text-sm font-black uppercase tracking-wide text-blue-600">
                    Part 3 · Incident Details
                </h2>

                <label class="form-label">Type of incident / error <span class="text-red-500">*</span></label>
                <div class="mt-2 grid gap-2 sm:grid-cols-2 lg:grid-cols-3" id="incident-type-group">
                    @foreach([
                        'Wrong Client/Participant',
                        'Wrong Date',
                        'Wrong Time',
                        'Wrong Type of Medication',
                        'Wrong Route',
                        'Wrong Dose',
                        'Incorrect Documentation',
                        'Pharmacy Error',
                        'Client refusal',
                        'Other'
                    ] as $type)
                        <label class="check-card">
                            <input type="checkbox" name="med_type[]" value="{{ $type }}"
                                   {{ in_array($type, old('med_type', [])) ? 'checked' : '' }}
                                   class="peer sr-only">
                            <span class="check-box"></span>
                            <span>{{ $type }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-5">
                    <label class="form-label">Incident background <span class="text-red-500">*</span></label>
                    <textarea name="incident_background" rows="4" class="form-input resize-none" data-required>{{ old('incident_background') }}</textarea>
                </div>

                <div class="mt-5">
                    <label class="form-label">Details of incident/error <span class="text-red-500">*</span></label>
                    <textarea name="incident_details" rows="4" class="form-input resize-none" data-required>{{ old('incident_details') }}</textarea>
                </div>

                <div class="mt-5">
                    <label class="form-label">Cause(s) or contributing factor(s)</label>
                    <div class="mt-2 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach([
                            'Missing Information',
                            'Missing Labels',
                            'Storage',
                            'Delivery Device issues',
                            'Environmental',
                            'Training Deficit',
                            'Other'
                        ] as $cause)
                            <label class="check-card">
                                <input type="checkbox" name="med_cause[]" value="{{ $cause }}"
                                       {{ in_array($cause, old('med_cause', [])) ? 'checked' : '' }}
                                       class="peer sr-only">
                                <span class="check-box"></span>
                                <span>{{ $cause }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5">
                    <label class="form-label">Immediate action taken</label>
                    <div class="mt-2 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach([
                            'Notified to on call',
                            'Called nurse On call',
                            'Notified to Line Manager',
                            'Notified Client/Participant',
                            'Notified Pharmacy',
                            'Notified General Practitioner',
                            'Telephoned Ambulance',
                            'Other'
                        ] as $action)
                            <label class="check-card">
                                <input type="checkbox" name="med_action[]" value="{{ $action }}"
                                       {{ in_array($action, old('med_action', [])) ? 'checked' : '' }}
                                       class="peer sr-only">
                                <span class="check-box"></span>
                                <span>{{ $action }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Part 4 --}}
            <section class="border-t border-slate-200 pt-8">
                <h2 class="mb-4 text-sm font-black uppercase tracking-wide text-blue-600">
                    Part 4 · Manager Report
                </h2>

                <label class="form-label">Follow-up action(s)</label>
                <div class="mt-2 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach([
                        'Resolved with Pharmacy',
                        'Resolved with General Practitioner',
                        'Further training provided',
                        'Environmental factors resolved',
                        'Other'
                    ] as $follow)
                        <label class="check-card">
                            <input type="checkbox" name="med_follow[]" value="{{ $follow }}"
                                   {{ in_array($follow, old('med_follow', [])) ? 'checked' : '' }}
                                   class="peer sr-only">
                            <span class="check-box"></span>
                            <span>{{ $follow }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-5">
                    <label class="form-label">Follow-up action(s) — detailed explanation</label>
                    <textarea name="action_explaination" rows="5" class="form-input resize-none">{{ old('action_explaination') }}</textarea>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-12">
                    <div class="md:col-span-4">
                        <label class="form-label">Action taken by</label>
                        <input type="text" name="action_taken_by" value="{{ old('action_taken_by') }}" class="form-input">
                    </div>

                    <div class="md:col-span-4">
                        <label class="form-label">Date completed</label>
                        <input type="date" name="date_completed" value="{{ old('date_completed') }}" class="form-input">
                    </div>

                    <div class="md:col-span-4">
                        <label class="form-label">Signature</label>
                        <input type="text" name="signature" value="{{ old('signature') }}" class="form-input">
                    </div>
                </div>
            </section>

        </div>

        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
            <button type="reset"
                    class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                Reset
            </button>

            <button type="submit" id="submitBtn"
                    class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-blue-700 disabled:opacity-60">
                <span id="submitLabel">Submit medication report</span>
            </button>
        </div>
    </form>
    </main>

    @include('public-form.partials._footer')

<script>
(function () {
    var form = document.getElementById('medication-form');

    form.addEventListener('submit', function (e) {
        var errors = [];

        // Clear previous invalid states
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        var typeGroup = document.getElementById('incident-type-group');
        typeGroup.style.outline = '';

        // Required text / date / time / textarea fields
        form.querySelectorAll('[data-required]').forEach(function (field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                var labelEl = field.closest('div')?.previousElementSibling
                    || field.closest('div')?.querySelector('.form-label');
                var label = field.closest('section')?.querySelector('.form-label')?.innerText
                    || field.name;
                // Get the label text from the parent div
                var parentDiv = field.parentElement;
                var lbl = parentDiv.querySelector('.form-label');
                errors.push((lbl ? lbl.innerText.replace(' *', '').trim() : field.name) + ' is required.');
            }
        });

        // At least one incident type must be checked
        if (form.querySelectorAll('input[name="med_type[]"]:checked').length === 0) {
            typeGroup.style.outline = '2px solid rgb(239 68 68)';
            typeGroup.style.outlineOffset = '4px';
            typeGroup.style.borderRadius = '0.75rem';
            errors.push('Please select at least one type of incident / error.');
        }

        if (errors.length > 0) {
            e.preventDefault();
            showToast(errors[0], 'error');
            // Scroll to first invalid field
            var first = form.querySelector('.is-invalid') || typeGroup;
            first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Clear invalid state on input
    form.querySelectorAll('[data-required]').forEach(function (field) {
        field.addEventListener('input', function () {
            if (this.value.trim()) this.classList.remove('is-invalid');
        });
    });
    form.querySelectorAll('input[name="med_type[]"]').forEach(function (cb) {
        cb.addEventListener('change', function () {
            if (form.querySelectorAll('input[name="med_type[]"]:checked').length > 0) {
                var g = document.getElementById('incident-type-group');
                g.style.outline = '';
            }
        });
    });

    function showToast(message, type) {
        var existing = document.getElementById('med-toast');
        if (existing) existing.remove();

        var colors = type === 'error'
            ? 'background:#dc2626;color:#fff'
            : 'background:#059669;color:#fff';

        var toast = document.createElement('div');
        toast.id = 'med-toast';
        toast.setAttribute('style',
            colors + ';position:fixed;top:1.25rem;right:1.25rem;z-index:9999;' +
            'display:flex;align-items:center;gap:0.75rem;' +
            'border-radius:0.75rem;padding:0.875rem 1.25rem;' +
            'font-size:0.875rem;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.18);' +
            'max-width:22rem;');
        toast.innerHTML =
            '<span style="flex:1">' + message + '</span>' +
            '<button onclick="this.parentElement.remove()" ' +
            'style="background:none;border:none;color:inherit;cursor:pointer;font-size:1.25rem;line-height:1;opacity:.8">' +
            '&times;</button>';

        document.body.appendChild(toast);
        setTimeout(function () { if (toast.parentElement) toast.remove(); }, 5000);
    }
})();
</script>
    <script>
        lucide.createIcons();
        const toast = document.getElementById('toast');
        if (toast) setTimeout(() => toast.remove(), 5000);
    </script>
</body>
</html>
