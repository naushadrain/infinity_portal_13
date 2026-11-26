{{--
|--------------------------------------------------------------------------
| Page: Signature Banner
|--------------------------------------------------------------------------
| Single banner image. Uploading a new image replaces the current one.
--}}
@extends('layouts.app', ['title' => 'Signature & Banner'])
@section('title', 'Signature & Banner')
@section('content')

{{-- Header --}}
<div class="mb-5">
    <h2 class="text-xl font-bold">Signature Banner</h2>
    <p class="text-sm text-slate-500 dark:text-ink-400">Upload one banner image. A new upload replaces the current one.</p>
</div>

@if (session('success'))
    <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
    </div>
@endif

<div class="grid gap-5 lg:grid-cols-2">

    {{-- Current image --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-4">Current Banner</h3>

        @if ($banner && $banner->file_path)
            <a href="{{ $banner->image_url }}" target="_blank" title="Open full size">
                <img src="{{ $banner->image_url }}"
                    class="w-full max-h-80 object-contain rounded-xl border border-slate-200 dark:border-ink-700 bg-slate-50 dark:bg-ink-800"
                    alt="Signature banner">
            </a>
            <p class="mt-3 text-xs text-slate-500 dark:text-ink-400">
                Last updated {{ $banner->updated_at?->diffForHumans() }}
            </p>
        @endif

        @if ($banner)
            <dl class="mt-5 grid grid-cols-2 gap-x-4 gap-y-3 text-sm border-t border-slate-100 dark:border-ink-800 pt-4">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-ink-400">Name</dt>
                    <dd class="mt-0.5 font-medium text-slate-800 dark:text-white">{{ $banner->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-ink-400">State</dt>
                    <dd class="mt-0.5 text-slate-700 dark:text-ink-300">{{ $banner->state ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-ink-400">Category</dt>
                    <dd class="mt-0.5 text-slate-700 dark:text-ink-300">{{ $banner->category ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-ink-400">Expiry</dt>
                    <dd class="mt-0.5 text-slate-700 dark:text-ink-300">{{ \App\Support\DateFormatter::safe($banner->expiry_date) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-ink-400">Status</dt>
                    <dd class="mt-1">
                        @if ($banner->publish)
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Published</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300 font-medium">Draft</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-ink-400">Created</dt>
                    <dd class="mt-0.5 text-slate-700 dark:text-ink-300">{{ $banner->created_at?->diffForHumans() ?? '—' }}</dd>
                </div>
            </dl>
        @endif

        @if (! $banner || ! $banner->file_path)
            <div class="h-48 rounded-xl border-2 border-dashed border-slate-200 dark:border-ink-800 grid place-items-center text-center text-sm text-slate-400 dark:text-ink-500">
                <div>
                    <i data-lucide="image" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                    <p>No banner uploaded yet.</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Upload --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-4">
            {{ $banner ? 'Update Banner' : 'Upload Banner' }}
        </h3>

        @php
            $inp = 'w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:focus:ring-brand-900';
            $hasImage = $banner && $banner->file_path;
            $expiry = old('expiry_date', $banner?->expiry_date ? \Illuminate\Support\Carbon::parse($banner->expiry_date)->format('Y-m-d') : '');
        @endphp

        <form method="POST" action="{{ route('banner.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1.5">Name <span class="text-rose-500">*</span></label>
                <input name="name" required value="{{ old('name', $banner?->name) }}" class="{{ $inp }}" placeholder="e.g. Signature Banner">
                @error('name') <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">State</label>
                    @php $states = ['Western Australia', 'Victoria', 'New South Wales', 'Queensland', 'South Australia', 'Tasmania', 'Australian Capital Territory', 'Northern Territory']; $curState = old('state', $banner?->state); @endphp
                    <select name="state" class="{{ $inp }}">
                        <option value="">— Any state —</option>
                        @if ($curState && ! in_array($curState, $states))
                            <option value="{{ $curState }}" selected>{{ $curState }}</option>
                        @endif
                        @foreach ($states as $s)
                            <option value="{{ $s }}" @selected($curState === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Category</label>
                    <input name="category" value="{{ old('category', $banner?->category) }}" class="{{ $inp }}" placeholder="e.g. Email, Report">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ $expiry }}" class="{{ $inp }}">
                    @error('expiry_date') <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center gap-2 pb-2.5">
                    <input type="checkbox" name="publish" id="bannerPublish" value="1"
                        @checked(old('publish', $banner ? $banner->publish : true))
                        class="w-4 h-4 rounded border-slate-300 accent-brand-600">
                    <label for="bannerPublish" class="text-sm font-medium cursor-pointer">Published</label>
                </div>
            </div>

            <label for="bannerFile"
                class="flex flex-col items-center gap-2 border-2 border-dashed border-slate-200 dark:border-ink-800 rounded-xl p-6 text-center cursor-pointer hover:border-brand-400 transition">
                <img id="previewImg" class="hidden max-h-40 rounded-lg object-contain" alt="">
                <i id="uploadIcon" data-lucide="image-up" class="w-8 h-8 text-slate-400 dark:text-ink-500"></i>
                <span class="text-sm"><b class="text-brand-600 dark:text-brand-300">Click to choose an image</b></span>
                <span id="fileLabel" class="text-xs text-slate-500 dark:text-ink-400">{{ $hasImage ? 'Optional — leave empty to keep the current image' : 'PNG, JPG, GIF, WebP — max 2 MB' }}</span>
            </label>
            <input type="file" id="bannerFile" name="banner_file" accept="image/*" class="hidden" @if (! $hasImage) required @endif
                onchange="previewBanner(this)">

            @error('banner_file')
                <p class="text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror

            <div class="flex justify-end">
                <button type="submit" id="uploadBtn" @if (! $hasImage) disabled @endif
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="save" class="w-4 h-4"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const hasImage = @json((bool) $hasImage);

    function previewBanner(input) {
        const label = document.getElementById('fileLabel');
        const img = document.getElementById('previewImg');
        const icon = document.getElementById('uploadIcon');
        const btn = document.getElementById('uploadBtn');

        if (!input.files.length) {
            label.textContent = hasImage ? 'Optional — leave empty to keep the current image' : 'PNG, JPG, GIF, WebP — max 2 MB';
            img.classList.add('hidden');
            if (icon) icon.classList.remove('hidden');
            btn.disabled = !hasImage;
            return;
        }

        const file = input.files[0];
        label.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        if (icon) icon.classList.add('hidden');
        btn.disabled = false;
    }
</script>
@endsection
