<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Complaint Form</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    @include('public-form.partials._header')

    <section class="relative h-[350px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/4.jpg" alt="Public Complaint" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-6xl font-bold">Public Complaint Form</h1>
            <p class="text-white/90 mt-4 text-lg">Complete the details below to lodge a complaint</p>
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

    <main class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10">

            @if(session('success'))
                <div class="mb-8 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5"></i>
                    <p class="text-emerald-800 font-semibold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <h2 class="text-2xl font-bold mb-1">Complaint Details</h2>
            <p class="text-slate-500 mb-8 text-sm">
                Use this form to raise a complaint. All complaints are reviewed by our team.
            </p>

            <form id="complaintForm" method="POST" action="{{ route('complaint.public.store') }}" novalidate>
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $lbl }}">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Name" class="{{ $inp }}" data-required>
                        <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                    </div>

                    <div>
                        <label class="{{ $lbl }}">Received From <span class="text-red-500">*</span></label>
                        <select name="received_from" class="{{ $inp }}" data-required>
                            <option value="">Please Select</option>
                            <option value="Participant Rep" {{ old('received_from') === 'Participant Rep' ? 'selected' : '' }}>Participant Rep</option>
                            <option value="Participant/Housing Provider Representative" {{ old('received_from') === 'Participant/Housing Provider Representative' ? 'selected' : '' }}>Participant/Housing Provider Representative</option>
                            <option value="Support Co-ordinator" {{ old('received_from') === 'Support Co-ordinator' ? 'selected' : '' }}>Support Co-ordinator</option>
                        </select>
                        <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                    </div>

                    <div>
                        <label class="{{ $lbl }}">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="{{ $inp }}">
                    </div>

                    <div>
                        <label class="{{ $lbl }}">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="Enter Here" class="{{ $inp }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="{{ $lbl }}">Complaint <span class="text-red-500">*</span></label>
                        <textarea name="complaint" rows="6" placeholder="Describe the complaint" class="{{ $inp }} resize-none" data-required>{{ old('complaint') }}</textarea>
                        <p class="err hidden text-red-500 text-xs mt-1">This field is required.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-sky-700">
                        Submit Complaint
                    </button>
                </div>
            </form>
        </div>
    </main>

    @include('public-form.partials._footer')

    @push('scripts')
    @endpush

    <script>
        lucide.createIcons();

        (function () {
            var form = document.getElementById('complaintForm');
            form.addEventListener('submit', function (e) {
                var hasError = false;
                form.querySelectorAll('[data-required]').forEach(function (field) {
                    var errEl = field.parentElement.querySelector('.err');
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        if (errEl) errEl.classList.remove('hidden');
                        hasError = true;
                    } else {
                        field.classList.remove('border-red-500');
                        if (errEl) errEl.classList.add('hidden');
                    }
                });
                if (hasError) {
                    e.preventDefault();
                    var firstError = form.querySelector('.border-red-500');
                    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        })();

        var toast = document.getElementById('toast');
        if (toast) {
            setTimeout(function () { toast.remove(); }, 5000);
        }
    </script>
</body>

</html>
