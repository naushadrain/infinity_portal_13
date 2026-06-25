{{--
|--------------------------------------------------------------------------
| Page: Signature Banner
|--------------------------------------------------------------------------
| CRUD list for email signature & banner images.
--}}
@extends('layouts.app', ['title' => 'Signature & Banner'])
@section('title', 'Signature & Banner')
@section('content')

{{-- Toast --}}
@if (session('success') || session('error'))
    @php
        $type       = session('success') ? 'success' : 'error';
        $msg        = session('success') ?? session('error');
        $toastClass = $type === 'success' ? 'bg-emerald-600 border-emerald-500' : 'bg-rose-600 border-rose-500';
        $icon       = $type === 'success' ? 'circle-check' : 'circle-x';
        $title      = $type === 'success' ? 'Success' : 'Error';
    @endphp
    <div id="toastMessage"
        class="fixed top-5 right-5 z-9999 w-[330px] max-w-[calc(100vw-2rem)] rounded-xl border {{ $toastClass }} text-white shadow-2xl overflow-hidden">
        <div class="flex items-start gap-3 p-4">
            <i data-lucide="{{ $icon }}" class="w-5 h-5 mt-0.5 shrink-0"></i>
            <div class="flex-1">
                <h4 class="text-sm font-semibold">{{ $title }}</h4>
                <p class="text-sm text-white/90 mt-0.5">{{ $msg }}</p>
            </div>
            <button onclick="document.getElementById('toastMessage').remove()" class="text-white/80 hover:text-white">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <div class="h-1 bg-white/25"><div id="toastProgress" class="h-full bg-white/80"></div></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const p = document.getElementById('toastProgress');
            if (p) {
                p.style.width = '100%';
                p.style.transition = 'width 4s linear';
                setTimeout(() => p.style.width = '0%', 100);
            }
            setTimeout(() => document.getElementById('toastMessage')?.remove(), 4300);
            if (window.lucide) lucide.createIcons();
        });
    </script>
@endif

{{-- Header --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-bold">Signature & Banner</h2>
        <p class="text-sm text-slate-500 dark:text-ink-400">{{ $banners->total() }} {{ Str::plural('banner', $banners->total()) }}</p>
    </div>
    <button onclick="openBannerModal()"
        class="px-3 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium flex items-center gap-2 transition">
        <i data-lucide="plus" class="w-4 h-4"></i> New Banner
    </button>
</div>

{{-- Table --}}
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-ink-800">
                <tr>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Name</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">State</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Category</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Expiry</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Status</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Created</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($banners as $banner)
                    <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800/50 transition">
                        <td class="px-4 py-3 text-sm font-medium text-slate-800 dark:text-white">
                            <div class="flex items-center gap-2">
                                @if ($banner->file_path)
                                    <img src="{{ asset('storage/' . $banner->file_path) }}"
                                        class="w-8 h-8 rounded object-cover border border-slate-200 dark:border-ink-700" alt="">
                                @else
                                    <div class="w-8 h-8 rounded bg-slate-100 dark:bg-ink-800 grid place-items-center">
                                        <i data-lucide="image" class="w-4 h-4 text-slate-400"></i>
                                    </div>
                                @endif
                                {{ $banner->name }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300">{{ $banner->state ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300">{{ $banner->category ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300">
                            {{ $banner->expiry_date ? \Carbon\Carbon::parse($banner->expiry_date)->format('d M Y') : '—' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if ($banner->publish)
                                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Published</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300 font-medium">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-500 dark:text-ink-400">{{ $banner->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if ($banner->file_path)
                                    <a href="{{ asset('storage/' . $banner->file_path) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-slate-600 hover:bg-slate-100 dark:bg-ink-800 dark:text-ink-300 transition"
                                        title="View Image">
                                        <i data-lucide="image" class="w-4 h-4"></i>
                                    </a>
                                @endif
                                <button type="button"
                                    onclick="editBanner(
                                        {{ $banner->id }},
                                        @js($banner->name),
                                        @js($banner->state ?? ''),
                                        @js($banner->category ?? ''),
                                        @js($banner->expiry_date ?? ''),
                                        {{ $banner->publish ? 'true' : 'false' }},
                                        @js($banner->details ?? '')
                                    )"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 transition"
                                    title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <button type="button"
                                    onclick="openDeleteModal('{{ route('banner.destroy', $banner) }}', @js($banner->name))"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 transition"
                                    title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-14 text-center text-sm text-slate-400 dark:text-ink-500">
                            <i data-lucide="image" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                            <p>No banners yet. Create your first one.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($banners->hasPages())
        <div class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
            <div>Showing {{ $banners->firstItem() }}–{{ $banners->lastItem() }} of {{ $banners->total() }}</div>
            <div>{{ $banners->links() }}</div>
        </div>
    @endif
</div>

{{-- Create / Edit Modal --}}
<div id="bannerModal" class="fixed inset-0 z-9999 hidden items-center justify-center bg-black/60 px-4">
    <div class="w-full max-w-lg rounded-2xl bg-white dark:bg-ink-900 border border-slate-100 dark:border-ink-800 shadow-2xl max-h-[90vh] flex flex-col">

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100 dark:border-ink-800 shrink-0">
            <h3 id="modalTitle" class="text-base font-semibold text-slate-900 dark:text-white">New Banner</h3>
            <button onclick="closeBannerModal()" class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-ink-800 transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="bannerForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
            @csrf
            <span id="methodField"></span>

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium mb-1.5">Name <span class="text-rose-500">*</span></label>
                <input name="name" id="bannerName" required
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:focus:ring-brand-900"
                    placeholder="e.g. Perth Office Banner">
            </div>

            {{-- State + Category --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">State</label>
                    <select name="state" id="bannerState"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none focus:border-brand-500">
                        <option value="">— Any state —</option>
                        @foreach (['Western Australia', 'Victoria', 'New South Wales', 'Queensland', 'South Australia', 'Tasmania', 'Australian Capital Territory', 'Northern Territory'] as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Category</label>
                    <input name="category" id="bannerCategory"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                        placeholder="e.g. Email, Report">
                </div>
            </div>

            {{-- Expiry + Publish --}}
            <div class="grid grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Expiry Date</label>
                    <input type="date" name="expiry_date" id="bannerExpiry"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none focus:border-brand-500">
                </div>
                <div class="flex items-center gap-2 pb-2.5">
                    <input type="checkbox" name="publish" id="bannerPublish" value="1"
                        class="w-4 h-4 rounded border-slate-300 accent-brand-600">
                    <label for="bannerPublish" class="text-sm font-medium cursor-pointer">Publish immediately</label>
                </div>
            </div>

            {{-- Signature details --}}
            <div>
                <label class="block text-sm font-medium mb-1.5">Signature / Details</label>
                <textarea name="details" id="bannerDetails" rows="4"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 resize-none"
                    placeholder="Kind regards,&#10;Infinite Ability Team&#10;1300 000 000 · infiniteability.com.au"></textarea>
            </div>

            {{-- Banner image upload --}}
            <div>
                <label class="block text-sm font-medium mb-1.5">Banner Image</label>
                <label for="bannerFile"
                    class="flex flex-col items-center gap-2 border-2 border-dashed border-slate-200 dark:border-ink-800 rounded-xl p-5 text-center cursor-pointer hover:border-brand-400 transition">
                    <i data-lucide="image-up" class="w-7 h-7 text-slate-400 dark:text-ink-500"></i>
                    <span class="text-sm"><b class="text-brand-600 dark:text-brand-300">Click to upload</b> or drag and drop</span>
                    <span id="fileLabel" class="text-xs text-slate-500 dark:text-ink-400">PNG, JPG, WebP — max 2 MB</span>
                </label>
                <input type="file" id="bannerFile" name="banner_file" accept="image/*" class="hidden"
                    onchange="showFileName(this)">
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-0.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="flex justify-end gap-2 pt-1">
                <button type="button" onclick="closeBannerModal()"
                    class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-700 dark:text-ink-200 text-sm font-medium">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="fixed inset-0 z-9999 hidden items-center justify-center bg-black/60 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white dark:bg-ink-900 border border-slate-100 dark:border-ink-800 shadow-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="h-11 w-11 rounded-full bg-rose-100 dark:bg-rose-500/10 flex items-center justify-center shrink-0">
                <i data-lucide="trash-2" class="w-5 h-5 text-rose-600 dark:text-rose-400"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Delete Banner?</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-ink-400">
                    Are you sure you want to delete
                    <span id="deleteBannerName" class="font-semibold text-slate-900 dark:text-white"></span>?
                    This action cannot be undone.
                </p>
            </div>
        </div>
        <form id="deleteForm" method="POST" class="mt-6">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-700 dark:text-ink-200 text-sm font-medium">
                    Cancel
                </button>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Yes, Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const storeUrl = '{{ route('banner.store') }}';

    function openBannerModal() {
        document.getElementById('modalTitle').textContent = 'New Banner';
        document.getElementById('bannerForm').action = storeUrl;
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('bannerName').value = '';
        document.getElementById('bannerState').value = '';
        document.getElementById('bannerCategory').value = '';
        document.getElementById('bannerExpiry').value = '';
        document.getElementById('bannerPublish').checked = false;
        document.getElementById('bannerDetails').value = '';
        document.getElementById('fileLabel').textContent = 'PNG, JPG, WebP — max 2 MB';
        showModal('bannerModal');
    }

    function editBanner(id, name, state, category, expiry, publish, details) {
        document.getElementById('modalTitle').textContent = 'Edit Banner';
        document.getElementById('bannerForm').action = '/signature-banner/' + id;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('bannerName').value = name;
        document.getElementById('bannerState').value = state;
        document.getElementById('bannerCategory').value = category;
        document.getElementById('bannerExpiry').value = expiry;
        document.getElementById('bannerPublish').checked = publish;
        document.getElementById('bannerDetails').value = details;
        document.getElementById('fileLabel').textContent = 'Leave empty to keep the current image';
        showModal('bannerModal');
    }

    function closeBannerModal() { hideModal('bannerModal'); }

    function openDeleteModal(url, name) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteBannerName').textContent = name;
        showModal('deleteModal');
    }

    function closeDeleteModal() { hideModal('deleteModal'); }

    function showModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
        if (window.lucide) lucide.createIcons();
    }

    function hideModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    function showFileName(input) {
        document.getElementById('fileLabel').textContent =
            input.files.length ? input.files[0].name : 'PNG, JPG, WebP — max 2 MB';
    }

    // Re-open modal with errors if validation failed (form was submitted)
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => showModal('bannerModal'));
    @endif

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeBannerModal(); closeDeleteModal(); }
    });

    ['bannerModal', 'deleteModal'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', function (e) {
            if (e.target === this) hideModal(id);
        });
    });
</script>
@endsection
