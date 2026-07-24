<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback, Compliments and Complaints</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-slate-50 text-slate-800">

    @include('public-form.partials._header')

    <section class="relative h-[450px] flex items-center justify-center overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/4.jpg" alt="Customer Satisfaction"
                class="w-full h-full object-cover">
        </div>

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Content -->
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-6xl font-bold">
                Feedback, Compliments and Complaints
            </h1>
            <p class="text-white/90 mt-4 text-lg">
                We want to hear from our customers
            </p>
        </div>

    </section>

    <main class="max-w-5xl mx-auto px-4 py-10 space-y-8">

        @php
            $inp = 'w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none text-sm transition mt-1.5';
            $lbl = 'block text-sm font-medium text-slate-700';
            $section = 'text-sky-600 font-bold text-lg mb-3';
        @endphp

        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10">

            <div class="bg-sky-50 border-l-4 border-sky-600 rounded-lg p-4 mb-8">
                <h3 class="font-bold text-slate-900 mb-1">Your Privacy &amp; Confidentiality</h3>
                <p class="text-slate-600 text-sm">
                    The information you provide is strictly confidential and will only be viewed by
                    authorised staff to respond to your feedback or complaint.
                </p>
            </div>

            <form method="POST" action="{{ route('feedback.perth.store') }}">

                @csrf

                <!-- Hidden city_name field - passes "Perth" without displaying -->
                <input type="hidden" name="city_name" value="Perth">

                <div class="pb-6 border-b border-slate-200">
                    <h3 class="{{ $section }}">Your Contact Details</h3>
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
                            @error('address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}">Interpreter Required?</h3>
                    <div class="grid md:grid-cols-2 gap-4 items-center">
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="wants_interpreter" value="1"> Yes, I would like a FREE Interpreter
                        </label>
                        <div>
                            <label class="{{ $lbl }}">Language</label>
                            <input type="text" name="interpreter_language" class="{{ $inp }}">
                        </div>
                    </div>
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}">Would you like a response?</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="wants_response" value="1"> Yes
                            </label>
                            <label class="flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="wants_response" value="0"> No
                            </label>
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Preferred Contact Method</label>
                            <select name="preferred_contact_method" class="{{ $inp }}">
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="post">Post</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}">This is a</h3>
                    <div class="grid md:grid-cols-3 gap-3">
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="feedback_type" value="compliment"> Compliment
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="feedback_type" value="complaint"> Complaint
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="feedback_type" value="comment"> Comment
                        </label>
                    </div>
                    @error('feedback_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}">I am a</h3>
                    <div class="grid md:grid-cols-3 gap-3">
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="respondent_type" value="participant"> Participant
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="respondent_type" value="family_member"> Family Member
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="respondent_type" value="participants_representative"> Participant's Representative
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="respondent_type" value="staff_member"> Staff Member
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="respondent_type" value="staff_on_behalf_of_participant"> Staff on behalf of Participant
                        </label>
                        <div>
                            <label class="flex items-center gap-2 text-sm text-slate-700 mb-1.5">
                                <input type="radio" name="respondent_type" value="other"> Other
                            </label>
                            <input type="text" name="respondent_type_other" class="{{ $inp }} mt-0">
                        </div>
                    </div>
                    @error('respondent_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="py-6 border-b border-slate-200">
                    <h3 class="{{ $section }}">Please tell us about your experience</h3>
                    <textarea name="experience" rows="5" class="{{ $inp }}"></textarea>
                    @error('experience')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6">
                    <h3 class="{{ $section }}">Suggestions / Ideas</h3>
                    <textarea name="suggestions" rows="5" class="{{ $inp }}"></textarea>
                    @error('suggestions')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6 flex items-center gap-3">
                    <button type="submit"
                        class="rounded-xl bg-sky-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-sky-700 transition">
                        Submit Feedback
                    </button>
                    <button type="reset"
                        class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Reset
                    </button>
                </div>
            </form>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mt-6">
                    <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mt-6">
                    <h3 class="font-semibold text-red-800 mb-2">Please fix the errors:</h3>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10 space-y-6 text-slate-700 text-sm leading-relaxed">
            <div>
                <h3 class="font-semibold text-slate-900 mb-2">Feedback, compliments and complaints can be lodged:</h3>
                <ul class="list-disc list-inside space-y-1">
                    <li>Directly with a staff member, either verbally or by submitting this form;</li>
                    <li>By email to: <a href="mailto:info@infiniteability.com.au" class="text-sky-600 hover:underline">info@infiniteability.com.au</a>;</li>
                    <li>By phone on: 1300 044 422;</li>
                    <li>In writing to: Infinite Ability, 268 Settlement Rd, Thomastown, Vic 3074; or</li>
                    <li>Anonymously, using the Suggestion Box located at Infinite Ability's Office.</li>
                </ul>
            </div>

            <p>
                Your complaint will be formally acknowledged within two working days. We aim to respond to
                all complaints and grievances as quickly as possible, and within 28 days from acknowledgement.
                All feedback and complaints will be used by Infinite Ability to continuously improve our
                service delivery. Thank you for taking the time to provide feedback about our service.
            </p>

            <p>
                If you feel a complaint has not been sufficiently or appropriately addressed, you can seek
                further support from Infinite Ability's General Manager, or alternatively through any of the
                following agencies:
            </p>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-slate-900">NDIS Quality and Safeguards Commission</h4>
                    <p>Online: <a href="https://www.ndiscommission.gov.au" target="_blank" class="text-sky-600 hover:underline">www.ndiscommission.gov.au</a></p>
                    <p>Phone: 1800 035 544</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Victorian Department of Health and Human Services</h4>
                    <p>Email: <a href="mailto:complaints.reception@dhhs.vic.gov.au" class="text-sky-600 hover:underline">complaints.reception@dhhs.vic.gov.au</a></p>
                    <p>Phone: 1300 884 706</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Victorian Disability Services Commission</h4>
                    <p>Email: <a href="mailto:complaints@odsc.vic.gov.au" class="text-sky-600 hover:underline">complaints@odsc.vic.gov.au</a></p>
                    <p>Phone: 1800 677 342 (TTY 1300 726 563)</p>
                    <p>Online: <a href="https://www.odsc.vic.gov.au" target="_blank" class="text-sky-600 hover:underline">www.odsc.vic.gov.au</a></p>
                    <p>Skype: call or email to make an appointment first</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Australian Human Rights Commission</h4>
                    <p>Phone: 1300 656 419</p>
                    <p>Online: <a href="https://humanrights.gov.au" target="_blank" class="text-sky-600 hover:underline">humanrights.gov.au</a></p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Commission for Children and Young People Victoria</h4>
                    <p>Email: <a href="mailto:childsafe@ccyp.vic.gov.au" class="text-sky-600 hover:underline">childsafe@ccyp.vic.gov.au</a></p>
                    <p>Phone: 1300 78 29 78</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Office of the Commissioner for Privacy and Data Protection</h4>
                    <p>Phone: 1300 666 444</p>
                    <p>Online: <a href="https://www.cpdp.vic.gov.au" target="_blank" class="text-sky-600 hover:underline">www.cpdp.vic.gov.au</a></p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Office of the Public Advocate</h4>
                    <p>Phone: 1300 309 337, (03) 9603 9500 or TTY: (03) 9603 9259</p>
                    <p>Online: <a href="https://www.publicadvocate.vic.gov.au/opa-feedback-and-complaints" target="_blank" class="text-sky-600 hover:underline">www.publicadvocate.vic.gov.au/opa-feedback-and-complaints</a></p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Independent Broad-based Anti-corruption Commission</h4>
                    <p>Phone: 1300 735 135</p>
                    <p>Online: <a href="https://www.ibac.vic.gov.au" target="_blank" class="text-sky-600 hover:underline">www.ibac.vic.gov.au</a></p>
                </div>
            </div>

            <p>
                NDIS participants purchasing products and services have rights and protections under the
                Australian Consumer Law (ACL), including provisions on customer guarantees and unfair
                contract terms. Consumer Affairs Victoria provides information and advice and, in some cases,
                dispute resolution services for customer disputes under the ACL. In addition to Consumer
                Affairs Victoria, you can also contact the Australian Securities and Investments Commission
                (ASIC) if you have concerns regarding consumer protection in relation to your finances.
            </p>
        </div>
    </main>

    @include('public-form.partials._footer')

    <script>lucide.createIcons();</script>
</body>

</html>
