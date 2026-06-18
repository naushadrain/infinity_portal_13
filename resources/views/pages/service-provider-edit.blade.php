@extends('layouts.app', ['title' => 'Service Providers Edit'])
@section('title', 'Service Providers Edit')

@section('content')
@php
    $selectedServices = old('provider_services', $serviceProvider->provider_services ?? []);

    if (is_string($selectedServices)) {
        $decoded = json_decode($selectedServices, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $selectedServices = $decoded;
        } else {
            $selectedServices = explode(',', $selectedServices);
        }
    }

    $selectedServices = array_map('strval', (array) $selectedServices);
@endphp

<form id="serviceProviderForm"
      method="POST"
      action="{{ route('service-providers.update', $serviceProvider->id) }}">
    @csrf
    @method('PUT')

    <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
        <div class="flex items-center justify-between gap-3 mb-5">
            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                    Edit Service Provider
                </h3>
                <p class="text-sm text-slate-500 dark:text-ink-400 mt-1">
                    Update provider details.
                </p>
            </div>

            <a href="{{ route('service-providers.index') }}"
               class="px-4 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
                Back
            </a>
        </div>

        <div class="h-px bg-slate-100 dark:bg-ink-800 mb-6"></div>

        <div class="grid md:grid-cols-12 gap-4">

            <div class="md:col-span-6">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    Provider Name <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    id="provider_name"
                    name="provider_name"
                    value="{{ old('provider_name', $serviceProvider->provider_name) }}"
                    class="form-input mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-900 dark:text-white text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                >

                <p class="error-message hidden mt-1 text-xs text-red-500"></p>

                @error('provider_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-6">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    State <span class="text-red-500">*</span>
                </label>

                <select
                    id="state"
                    name="state"
                    class="form-input mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-900 dark:text-white text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    <option value="">Please select</option>

                    @foreach (config('settings.state_names') as $id => $state)
                        <option value="{{ $id }}" @selected(old('state', $serviceProvider->state) == $id)>
                            {{ $state }}
                        </option>
                    @endforeach
                </select>

                <p class="error-message hidden mt-1 text-xs text-red-500"></p>

                @error('state')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-12">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    Services Offered <span class="text-red-500">*</span>
                </label>

                <div id="servicesBox" class="mt-4 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
                    @foreach (config('settings.service_lists') as $id => $name)
                        <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-700 dark:text-ink-200">
                            <input
                                type="checkbox"
                                name="provider_services[]"
                                value="{{ $id }}"
                                @checked(in_array((string) $id, $selectedServices))
                                class="service-checkbox h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                            >
                            <span>{{ $name }}</span>
                        </label>
                    @endforeach
                </div>

                <p id="servicesError" class="hidden mt-2 text-xs text-red-500">
                    Please select at least one service.
                </p>

                @error('provider_services')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-12">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    Address <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    id="address"
                    name="address"
                    value="{{ old('address', $serviceProvider->address) }}"
                    class="form-input mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-900 dark:text-white text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                >

                <p class="error-message hidden mt-1 text-xs text-red-500"></p>

                @error('address')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-4">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    Phone <span class="text-red-500">*</span>
                </label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $serviceProvider->phone) }}"
                    class="form-input mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-900 dark:text-white text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                >

                <p class="error-message hidden mt-1 text-xs text-red-500"></p>

                @error('phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-4">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    Email <span class="text-red-500">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $serviceProvider->email) }}"
                    class="form-input mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-900 dark:text-white text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                >

                <p class="error-message hidden mt-1 text-xs text-red-500"></p>

                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-4">
                <label class="text-sm font-medium text-slate-700 dark:text-ink-200">
                    Website
                </label>

                <input
                    type="text"
                    id="website"
                    name="website"
                    value="{{ old('website', $serviceProvider->website) }}"
                    placeholder="https://example.com"
                    class="form-input mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-900 dark:text-white text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                >

                <p class="error-message hidden mt-1 text-xs text-red-500"></p>

                @error('website')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('service-providers.index') }}"
               class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium">
                Cancel
            </a>

            <button
                type="submit"
                class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft">
                Update Provider
            </button>
        </div>
    </section>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('serviceProviderForm');

        if (!form) return;

        const fields = {
            provider_name: 'Provider name is required.',
            state: 'State is required.',
            address: 'Address is required.',
            phone: 'Phone is required.',
            email: 'Email is required.',
        };

        function setError(input, message) {
            input.classList.remove('border-slate-200', 'dark:border-ink-800');
            input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');

            const error = input.parentElement.querySelector('.error-message');
            if (error) {
                error.textContent = message;
                error.classList.remove('hidden');
            }
        }

        function clearError(input) {
            input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
            input.classList.add('border-slate-200', 'dark:border-ink-800');

            const error = input.parentElement.querySelector('.error-message');
            if (error) {
                error.textContent = '';
                error.classList.add('hidden');
            }
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function validateServices() {
            const serviceChecked = document.querySelectorAll('.service-checkbox:checked').length;
            const servicesError = document.getElementById('servicesError');
            const servicesBox = document.getElementById('servicesBox');

            if (!servicesError || !servicesBox) return true;

            if (serviceChecked === 0) {
                servicesError.classList.remove('hidden');
                servicesBox.classList.add('rounded-lg', 'border', 'border-red-500', 'p-3');
                return false;
            }

            servicesError.classList.add('hidden');
            servicesBox.classList.remove('rounded-lg', 'border', 'border-red-500', 'p-3');
            return true;
        }

        form.addEventListener('submit', function (e) {
            let valid = true;

            Object.keys(fields).forEach(function (id) {
                const input = document.getElementById(id);

                if (!input) return;

                if (!input.value.trim()) {
                    setError(input, fields[id]);
                    valid = false;
                } else {
                    clearError(input);
                }
            });

            const email = document.getElementById('email');

            if (email && email.value.trim() && !isValidEmail(email.value.trim())) {
                setError(email, 'Please enter a valid email address.');
                valid = false;
            }

            if (!validateServices()) {
                valid = false;
            }

            if (!valid) {
                e.preventDefault();

                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        });

        document.querySelectorAll('.form-input').forEach(function (input) {
            input.addEventListener('input', function () {
                if (input.value.trim()) {
                    clearError(input);
                }
            });

            input.addEventListener('change', function () {
                if (input.value.trim()) {
                    clearError(input);
                }
            });
        });

        document.querySelectorAll('.service-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                validateServices();
            });
        });
    });
</script>
@endsection