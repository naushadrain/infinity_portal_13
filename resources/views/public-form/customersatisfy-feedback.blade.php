<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback, Compliments & Complaints</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-50 text-slate-800">

@include('public-form.partials._header')

@php
    $inp = 'w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none text-sm transition mt-1.5';
    $lbl = 'block text-sm font-medium text-slate-700';
    $section = 'text-sky-600 font-bold text-lg mb-3 flex items-center gap-2';
    $option = 'flex items-center gap-2 text-sm text-slate-700 cursor-pointer';
    $radio = 'w-4 h-4 text-sky-600 border-slate-300 focus:ring-sky-500';
@endphp

<main class="max-w-4xl mx-auto px-4 py-10">

    <div class="rounded-2xl shadow-lg overflow-hidden border border-slate-200">

        <div class="bg-sky-600 text-white text-center px-6 py-8">
            <h2 class="text-2xl font-bold mb-1">Feedback, Compliments &amp; Complaints</h2>
            <p class="text-sky-50/90 text-sm">
                Infinite Ability is committed to providing high quality services and values your feedback.
            </p>
        </div>

        <div class="bg-white p-6 md:p-10">

            @if (session('success'))
                <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 mb-6 text-sm">
                    <p class="font-semibold flex items-center gap-2 mb-1">
                        <i data-lucide="x-circle" class="w-5 h-5 shrink-0"></i>
                        Please fix the following:
                    </p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('feedback.store') }}" id="feedbackForm">
                @csrf
                <input type="hidden" name="city_name" value="General">

                <div class="flex gap-3 bg-sky-50 border-l-4 border-sky-600 rounded-lg p-4 mb-8">
                    <i data-lucide="shield-check" class="w-5 h-5 text-sky-600 shrink-0 mt-0.5"></i>
                    <div>
                        <h3 class="font-bold text-slate-900 mb-1">Your Privacy &amp; Confidentiality</h3>
                        <p class="text-slate-600 text-sm">
                            The information you provide is strictly confidential and will only be viewed by
                            authorised staff to respond to your feedback or complaint.
                        </p>
                    </div>
                </div>

                <div class="pb-6 border-b border-slate-200">
                    <h3 class="{{ $section }}"><i data-lucide="user" class="w-4 h-4"></i> Your Contact Details</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="{{ $lbl }}">Full Name</label>
                            <input type="text" name="name" class="{{ $inp }}">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Email Address</label>
                            <input type="email" name="email" class="{{ $inp }}">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="{{ $lbl }}">Address</label>
                            <textarea name="address" rows="2" class="{{ $inp }}"></textarea>
                        </div>
                    </div>
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}"><i data-lucide="languages" class="w-4 h-4"></i> Interpreter Required?</h3>
                    <div class="grid md:grid-cols-2 gap-4 items-start">
                        <label class="{{ $option }} mt-2.5">
                            <input type="checkbox" name="wants_interpreter" value="1" class="w-4 h-4 rounded text-sky-600 border-slate-300 focus:ring-sky-500">
                            Yes, I would like a FREE Interpreter
                        </label>
                        <div>
                            <label class="{{ $lbl }}">Language</label>
                            <input type="text" name="interpreter_language" class="{{ $inp }}">
                        </div>
                    </div>
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}"><i data-lucide="message-circle" class="w-4 h-4"></i> Would you like a response?</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-6 mt-2.5">
                            <label class="{{ $option }}">
                                <input type="radio" name="wants_response" value="1" class="{{ $radio }}"> Yes
                            </label>
                            <label class="{{ $option }}">
                                <input type="radio" name="wants_response" value="0" class="{{ $radio }}"> No
                            </label>
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Preferred Contact Method</label>
                            <select name="preferred_contact_method" class="{{ $inp }}">
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="post">Mail</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}"><i data-lucide="tag" class="w-4 h-4"></i> Complain Type</h3>
                    <div class="grid md:grid-cols-3 gap-3">
                        <label class="{{ $option }}">
                            <input type="radio" name="feedback_type" value="compliment" class="{{ $radio }}"> Compliment
                        </label>
                        <label class="{{ $option }}">
                            <input type="radio" name="feedback_type" value="complaint" class="{{ $radio }}"> Complaint
                        </label>
                        <label class="{{ $option }}">
                            <input type="radio" name="feedback_type" value="comment" class="{{ $radio }}"> Comment
                        </label>
                    </div>
                    @error('feedback_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}"><i data-lucide="users" class="w-4 h-4"></i> Role</h3>
                    <div class="grid md:grid-cols-3 gap-3">
                        <label class="{{ $option }}">
                            <input type="radio" name="respondent_type" value="participant" class="{{ $radio }}"> Participant
                        </label>
                        <label class="{{ $option }}">
                            <input type="radio" name="respondent_type" value="family_member" class="{{ $radio }}"> Family Member
                        </label>
                        <label class="{{ $option }}">
                            <input type="radio" name="respondent_type" value="participants_representative" class="{{ $radio }}"> Participant's Representative
                        </label>
                        <label class="{{ $option }}">
                            <input type="radio" name="respondent_type" value="staff_member" class="{{ $radio }}"> Staff Member
                        </label>
                        <label class="{{ $option }}">
                            <input type="radio" name="respondent_type" value="staff_on_behalf_of_participant" class="{{ $radio }}"> Staff on behalf of Participant
                        </label>
                        <div>
                            <label class="{{ $option }} mb-1.5">
                                <input type="radio" name="respondent_type" value="other" class="{{ $radio }}" id="respondentOther"> Other
                            </label>
                            <input type="text" name="respondent_type_other" class="{{ $inp }} mt-0 hidden" id="respondentOtherInput" placeholder="Please specify">
                        </div>
                    </div>
                    @error('respondent_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}"><i data-lucide="pen-line" class="w-4 h-4"></i> Please tell us about your experience</h3>
                    <textarea name="experience" rows="5" class="{{ $inp }}"></textarea>
                    @error('experience')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6">
                    <h3 class="{{ $section }}"><i data-lucide="lightbulb" class="w-4 h-4"></i> Suggestions / Ideas</h3>
                    <textarea name="suggestions" rows="5" class="{{ $inp }}"></textarea>
                    @error('suggestions')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-8 flex items-center justify-center gap-3">
                    <button type="submit" id="submitBtn"
                        class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-8 py-3 text-sm font-bold text-white shadow-lg hover:bg-sky-700 transition disabled:opacity-60 disabled:cursor-not-allowed">
                        <span id="submitLabel">Submit Feedback</span>
                        <svg id="submitSpinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </button>
                    <button type="reset"
                        class="rounded-xl border border-slate-300 px-8 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-8">
        <h3 class="text-sky-600 font-bold text-lg mb-4 flex items-center gap-2">
            <i data-lucide="info" class="w-4 h-4"></i> How to Lodge Feedback
        </h3>

        <ul class="space-y-2 text-sm text-slate-700 mb-6">
            <li class="flex items-center gap-2">
                <i data-lucide="user-round" class="w-4 h-4 text-sky-600 shrink-0"></i> Directly with a staff member.
            </li>
            <li class="flex items-center gap-2">
                <i data-lucide="mail" class="w-4 h-4 text-sky-600 shrink-0"></i> Email: <strong>info@infiniteability.com.au</strong>
            </li>
            <li class="flex items-center gap-2">
                <i data-lucide="phone" class="w-4 h-4 text-sky-600 shrink-0"></i> Phone: <strong>1300 044 422</strong>
            </li>
            <li class="flex items-center gap-2">
                <i data-lucide="map-pin" class="w-4 h-4 text-sky-600 shrink-0"></i> Mail: Infinite Ability, 268 Settlement Rd, Thomastown, VIC 3074
            </li>
            <li class="flex items-center gap-2">
                <i data-lucide="inbox" class="w-4 h-4 text-sky-600 shrink-0"></i> Anonymous Suggestion Box.
            </li>
        </ul>

        <p class="text-sm text-slate-600 border-t border-slate-200 pt-4">
            <strong class="text-slate-900">Response Time:</strong> Complaints will be acknowledged
            within <strong>2 working days</strong> and responded to within
            <strong>28 days</strong> wherever possible.
        </p>
    </div>

</main>

@include('public-form.partials._footer')

<script>
    lucide.createIcons();

    document.getElementById('feedbackForm').addEventListener('submit', function () {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitSpinner').classList.remove('hidden');
    });

    var otherInput = document.getElementById('respondentOtherInput');
    document.querySelectorAll('input[name="respondent_type"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            otherInput.classList.toggle('hidden', !document.getElementById('respondentOther').checked);
        });
    });
</script>

</body>
</html>
