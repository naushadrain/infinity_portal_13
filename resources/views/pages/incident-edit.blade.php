{{--
|--------------------------------------------------------------------------
| Page: Edit Incident Report
|--------------------------------------------------------------------------
| Edit key fields of a submitted incident report.
--}}
@extends('layouts.app', ['title' => 'Edit Incident Report'])
@section('title', 'Edit Incident Report')
@section('content')

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form id="edit-incident-form" method="POST" action="{{ route('forms.incident.update', $reporter) }}">
        @csrf
        @method('PUT')

        {{-- Reporter Details --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <div class="flex items-center justify-between mb-1">
                <h3 class="text-base font-semibold">Reporter Details</h3>
                <span class="text-xs text-slate-400 dark:text-ink-500">IR #{{ $reporter->id }}</span>
            </div>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        Reporter Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $reporter->name) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('name') ? 'border-rose-400' : 'border-slate-200 dark:border-ink-800' }} focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        Contact Number <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="contact" value="{{ old('contact', $reporter->contact) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('contact') ? 'border-rose-400' : 'border-slate-200 dark:border-ink-800' }} focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                    @error('contact')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        IR Number
                    </label>
                    <input type="text" name="ir_number" value="{{ old('ir_number', $reporter->ir_number) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        Position Title
                    </label>
                    <input type="text" name="position_title" value="{{ old('position_title', $reporter->position_title) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">City</label>
                    <select name="city"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-950 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm transition">
                        @foreach($cities as $key => $label)
                            <option value="{{ $key }}" {{ old('city', $reporter->city) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
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

        {{-- Incident Details --}}
        <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
            <h3 class="text-base font-semibold mb-1">Incident Details</h3>
            <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Date of Incident</label>
                    <input type="date" name="doi" value="{{ old('doi', $incident?->doi) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Time of Incident</label>
                    <input type="time" name="toi" value="{{ old('toi', $incident?->toi) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Address / Location</label>
                    <input type="text" name="address" value="{{ old('address', $incident?->address) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Incident Background</label>
                    <textarea name="incident_background" rows="4"
                              class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition resize-y">{{ old('incident_background', $incident?->incident_background) }}</textarea>
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
