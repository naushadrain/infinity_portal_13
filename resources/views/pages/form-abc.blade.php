{{--
|--------------------------------------------------------------------------
| Page: ABC Form
|--------------------------------------------------------------------------
| Antecedent-Behavior-Consequence incident capture form.
--}}
@extends('layouts.app', ['title' => 'New ABC Monitoring Chart'])
@section('title', 'New ABC Monitoring Chart')
@section('content')

    <form id="abc-form"
          action="{{ route('forms.abc-monitoring-chart.store') }}"
          method="POST"
          novalidate>
        @csrf

        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <h3 class="text-base font-semibold mb-1">Participant details</h3>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-12 gap-4">

                <div class="md:col-span-6">
                    <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                        Participant name <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1.5">
                        <input type="text"
                               id="participant_name"
                               name="participant_name"
                               value="{{ old('participant_name') }}"
                               class="abc-input w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"
                               data-label="Participant name" />
                    </div>
                </div>

                <div class="md:col-span-6">
                    <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                        Date of birth <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1.5">
                        <input type="date"
                               id="participant_date_of_birth"
                               name="participant_date_of_birth"
                               value="{{ old('participant_date_of_birth') }}"
                               class="abc-input w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"
                               data-label="Date of birth" />
                    </div>
                </div>

                <div class="md:col-span-12">
                    <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                        Participant address <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1.5">
                        <input type="text"
                               id="participant_address"
                               name="participant_address"
                               value="{{ old('participant_address') }}"
                               class="abc-input w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"
                               data-label="Participant address" />
                    </div>
                </div>

                <div class="md:col-span-12">
                    <label class="text-sm font-medium text-slate-700 dark:text-ink-200">BSP practices</label>
                    <div class="mt-1.5">
                        <textarea id="BSP_practices"
                                  name="BSP_practices"
                                  rows="4"
                                  class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm resize-none">{{ old('BSP_practices') }}</textarea>
                    </div>
                </div>

            </div>
        </section>

        <div class="flex justify-end gap-2 mb-10">
            <button type="button"
                    onclick="window.history.back()"
                    class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium">
                Cancel
            </button>
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft">
                Submit chart
            </button>
        </div>

    </form>

@push('scripts')
<script>
(function () {
    var form = document.getElementById('abc-form');

    form.addEventListener('submit', function (e) {
        var fields = form.querySelectorAll('.abc-input[data-label]');
        var errors = [];

        fields.forEach(function (field) {
            field.style.borderColor = '';
            field.style.boxShadow  = '';

            if (!field.value.trim()) {
                errors.push(field.getAttribute('data-label') + ' is required.');
                field.style.borderColor = 'rgb(239 68 68)';
                field.style.boxShadow   = '0 0 0 3px rgba(239,68,68,.15)';
            }
        });

        if (errors.length > 0) {
            e.preventDefault();
            showToast(errors[0], 'error');
            form.querySelector('.abc-input[data-label]').focus();
        }
    });

    // Clear error style on input
    form.querySelectorAll('.abc-input[data-label]').forEach(function (field) {
        field.addEventListener('input', function () {
            if (this.value.trim()) {
                this.style.borderColor = '';
                this.style.boxShadow   = '';
            }
        });
    });

    function showToast(message, type) {
        var existing = document.getElementById('abc-toast');
        if (existing) existing.remove();

        var bg = type === 'error' ? '#dc2626' : '#059669';
        var toast = document.createElement('div');
        toast.id = 'abc-toast';
        toast.setAttribute('style',
            'position:fixed;top:1.25rem;right:1.25rem;z-index:9999;' +
            'display:flex;align-items:center;gap:0.75rem;' +
            'background:' + bg + ';color:#fff;' +
            'border-radius:0.75rem;padding:0.875rem 1.25rem;' +
            'font-size:0.875rem;font-weight:600;' +
            'box-shadow:0 8px 24px rgba(0,0,0,.18);max-width:22rem;');
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
@endpush

@endsection
