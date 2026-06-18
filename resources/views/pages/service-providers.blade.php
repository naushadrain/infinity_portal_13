@extends('layouts.app', ['title' => 'Service Providers'])
@section('title', 'Service Providers')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-bold">Service Providers</h2>
        <p class="text-sm text-slate-500 dark:text-ink-400">
            {{ $serviceProviders->total() }} results
        </p>
    </div>

    <div class="flex gap-2">
        <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2">
            <i data-lucide="download" class="w-4 h-4"></i> Export
        </button>

        <a href="{{ route('service-providers.create') }}"
            class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Add provider
        </a>
    </div>
</div>

<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">

    <form method="GET" action="{{ route('service-providers.index') }}"
        class="p-4 grid grid-cols-1 md:grid-cols-4 gap-3 border-b border-slate-100 dark:border-ink-800">

        <div class="flex items-center gap-2 bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
            <input
                name="provider_name"
                value="{{ request('provider_name') }}"
                class="bg-transparent text-sm outline-none flex-1"
                placeholder="Search provider name..."
            >
        </div>

        <select name="state"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
            <option value="">All states</option>
            @foreach ($states as $state)
                <option value="{{ $state }}" @selected(request('state') == $state)>
                    {{ config('settings.state_names.' . $state, $state) }}
                </option>
            @endforeach
        </select>

        <select name="service_name"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
            <option value="">All services</option>
            @foreach ($serviceIds as $id)
                <option value="{{ $id }}" @selected(request('service_name') == $id)>
                    {{ $serviceList[$id] ?? $id }}
                </option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit"
                class="px-4 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium">
                Filter
            </button>

            <a href="{{ route('service-providers.index') }}"
                class="px-4 py-2 rounded-lg border border-slate-200 dark:border-ink-800 text-sm">
                Reset
            </a>
        </div>
    </form>

    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-ink-800">
                <tr>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">ID</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Name</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Service</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">State</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Phone</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Address</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Email</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Website</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($serviceProviders as $index => $item)
                    @php
                        $services = $item->provider_services;

                        if (is_string($services)) {
                            $decoded = json_decode($services, true);

                            if (json_last_error() === JSON_ERROR_NONE) {
                                $services = $decoded;
                            } else {
                                $services = explode(',', $services);
                            }
                        }

                        $services = is_array($services) ? $services : [$services];

                        $serviceNames = collect($services)
                            ->map(fn ($id) => config('settings.service_lists.' . trim($id), trim($id)))
                            ->implode(', ');
                    @endphp

                    <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800">
                        <td class="px-4 py-3 text-sm">
                            {{ $serviceProviders->firstItem() + $index }}
                        </td>

                        <td class="px-4 py-3 text-sm">{{ $item->provider_name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $serviceNames }}</td>
                        <td class="px-4 py-3 text-sm">
                            {{ config('settings.state_names.' . $item->state, $item->state) }}
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $item->phone }}</td>
                        <td class="px-4 py-3 text-sm">{{ $item->address }}</td>
                        <td class="px-4 py-3 text-sm">{{ $item->email }}</td>
                        <td class="px-4 py-3 text-sm">{{ $item->website }}</td>

                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">

                                <a href="{{ route('service-providers.edit', $item->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 text-xs font-medium">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                    Edit
                                </a>

                                <button
                                    type="button"
                                    onclick="openDeleteModal('{{ route('service-providers.destroy', $item->id) }}', '{{ addslashes($item->provider_name) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 text-xs font-medium">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    Delete
                                </button>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-sm text-slate-500">
                            No service providers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
        <div>
            Showing {{ $serviceProviders->firstItem() ?? 0 }}
            –
            {{ $serviceProviders->lastItem() ?? 0 }}
            of
            {{ $serviceProviders->total() }}
        </div>

        <div>
            {{ $serviceProviders->links() }}
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div id="deleteModal"
     class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60 px-4">

    <div class="w-full max-w-md rounded-2xl bg-white dark:bg-ink-900 border border-slate-100 dark:border-ink-800 shadow-2xl p-6">

        <div class="flex items-start gap-4">
            <div class="h-11 w-11 rounded-full bg-red-100 dark:bg-red-500/10 flex items-center justify-center">
                <i data-lucide="trash-2" class="w-5 h-5 text-red-600 dark:text-red-400"></i>
            </div>

            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                    Delete Service Provider?
                </h3>

                <p class="mt-2 text-sm text-slate-500 dark:text-ink-400">
                    Are you sure you want to delete
                    <span id="deleteProviderName" class="font-semibold text-slate-900 dark:text-white"></span>?
                    This action cannot be undone.
                </p>
            </div>
        </div>

        <form id="deleteForm" method="POST" class="mt-6">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-slate-700 dark:text-ink-200 text-sm font-medium">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                    Yes, Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, providerName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const name = document.getElementById('deleteProviderName');

        form.action = actionUrl;
        name.textContent = providerName;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection