<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Satisfaction Form</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    <header class="bg-white shadow-sm">
        <!-- Top Contact Bar -->
        <div
            class="max-w-7xl mx-auto px-4 py-6 flex items-start justify-start gap-10 text-sm font-semibold text-slate-800">
            <span class="flex items-center gap-2">
                <i data-lucide="mail" class="w-5 h-5 text-sky-500"></i>
                info@infiniteability.com.au
            </span>

            <span class="flex items-center gap-2">
                <i data-lucide="phone" class="w-5 h-5 text-sky-500"></i>
                1300044422
            </span>
        </div>

        <!-- Logo + Navigation -->
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png" class="h-14"
                    alt="Infinite Ability Logo">
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
                Customer Satisfaction Form
            </h1>
            <p class="text-white/90 mt-4 text-lg">
                We want to hear from our customers
            </p>
        </div>

    </section>
    @php
        $inputClass =
            'form-input w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-ink-700 bg-white dark:bg-ink-950 text-slate-900 dark:text-ink-100 placeholder:text-slate-400 dark:placeholder:text-ink-500 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm transition';

        $labelClass = 'text-sm font-medium text-slate-700 dark:text-ink-200';
        $sectionTitle = 'mb-4 text-sm font-black uppercase tracking-wide text-brand-600 dark:text-brand-400';

        $toastMessage = session('success') ?? (session('error') ?? ($errors->any() ? $errors->first() : null));
        $toastType = session('success') ? 'success' : 'error';
    @endphp
    <main class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10">

            <h2 class="text-2xl font-bold mb-2">
                We want to hear from our Customer!
            </h2>
            <p class="text-slate-500 mb-8">
                Please share your honest responses to the following questions.
            </p>

           <form id="incidentForm" method="POST">
    <section class="bg-white rounded-2xl shadow border border-slate-100 p-5 md:p-6 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-900">
                Incident Report Form
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Complete the incident details below.
            </p>
        </div>

        <!-- Part 1 -->
        <div class="mb-8">
            <h3 class="mb-4 text-sm font-black uppercase tracking-wide text-blue-600">
                Part 1 · Reporter Details
            </h3>

            <div class="h-px bg-slate-100 my-5"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="xl:col-span-2">
                    <label class="text-sm font-medium text-slate-700">Name of person reporting *</label>
                    <input type="text" name="reporter_name"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Contact number *</label>
                    <input type="text" name="contact_number"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Incident Report Number</label>
                    <input type="text" name="incident_report_number" placeholder="IN-2043"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                </div>

                <div class="xl:col-span-2">
                    <label class="text-sm font-medium text-slate-700">Position Title</label>
                    <input type="text" name="position_title"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                </div>

                <div class="xl:col-span-2">
                    <label class="text-sm font-medium text-slate-700">City *</label>
                    <select name="city"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                        <option value="">Please select</option>
                        <option value="Perth">Perth</option>
                        <option value="Victoria">Victoria</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Part 5 -->
        <div class="mb-8">
            <h3 class="mb-4 text-sm font-black uppercase tracking-wide text-blue-600">
                Part 5 · What happened?
            </h3>

            <div class="h-px bg-slate-100 my-5"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="md:col-span-3 xl:col-span-4">
                    <label class="text-sm font-medium text-slate-700">Incident description *</label>
                    <textarea name="incident_description" rows="5"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5"></textarea>
                </div>

                <div class="md:col-span-3 xl:col-span-4">
                    <label class="text-sm font-medium text-slate-700">Immediate action taken by staff *</label>
                    <textarea name="immediate_action" rows="4"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5"></textarea>
                </div>

                <div class="xl:col-span-2">
                    <label class="text-sm font-medium text-slate-700">Was any property or equipment damaged? *</label>
                    <select name="property_damaged"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <label class="text-sm font-medium text-slate-700">Police contacted? *</label>
                    <select name="police_contacted"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>

                <div class="md:col-span-3 xl:col-span-4">
                    <label class="text-sm font-medium text-slate-700">Details of damage</label>
                    <textarea name="damage_details" rows="3"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 mt-1.5"></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8 pt-6 border-t border-slate-100">
            <button type="button"
                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm font-medium">
                Cancel
            </button>

            <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">
                Submit incident report
            </button>
        </div>
    </section>
</form>
        </div>
    </main>

    <footer class="bg-slate-900 text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-4 gap-8">
            <div>
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png"
                    class="h-14 bg-white rounded p-1 mb-4" alt="Logo">
                <p class="text-sm text-slate-300">
                    Infinite Ability customer support and service feedback form.
                </p>
            </div>

            <div>
                <h3 class="font-bold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>Home</li>
                    <li>About Us</li>
                    <li>About NDIS</li>
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
            Copyright © 2026 Infinite Ability. All rights reserved.
        </div>
    </footer>

</body>

</html>
