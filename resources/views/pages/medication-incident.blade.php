@extends('layouts.app', ['title' => ''])

@section('title', 'Medication Form')

@section('content')
<div class="space-y-5">


    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Medication Reports</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ $medications->total() }} {{ Str::plural('result', $medications->total()) }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('forms.medication.export', request()->only(['search', 'location', 'type', 'date'])) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i data-lucide="download" class="h-4 w-4"></i>
                Export
            </a>

            <a href="{{ route('forms.medication.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">
                <i data-lucide="plus" class="h-4 w-4"></i>
                New Medication Form
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-950">

        {{-- Filters --}}
        <form method="GET" action="{{ route('forms.medication.index') }}"
              class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap gap-3">

                {{-- Search --}}
                <div class="flex min-w-[240px] max-w-[400px] flex-1 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 dark:border-slate-700 dark:bg-slate-950">
                    <i data-lucide="search" class="h-4 w-4 text-slate-400 shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search reporter, participant..."
                           class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 dark:text-slate-200">
                </div>

                {{-- Location dropdown (dynamic) --}}
                <select name="location"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                    <option value="">All Locations</option>
                    @foreach ($locations as $loc)
                        <option value="{{ $loc }}" {{ request('location') === $loc ? 'selected' : '' }}>
                            {{ $loc }}
                        </option>
                    @endforeach
                </select>

                {{-- Incident type dropdown (dynamic) --}}
                <select name="type"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                    <option value="">All Types</option>
                    @foreach ($types as $t)
                        <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>

                {{-- Date --}}
                <input type="date" name="date" value="{{ request('date') }}"
                       class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">

                {{-- Filter button --}}
                <button type="submit"
                        class="inline-flex items-center gap-1 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    Filter
                </button>

                {{-- Clear (only when active) --}}
                @if (request()->hasAny(['search', 'location', 'type', 'date']))
                    <a href="{{ route('forms.medication.index') }}"
                       class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px]">
                <thead class="bg-slate-100 dark:bg-slate-900">
                    <tr>
                        <th class="table-th">Sr. No.</th>
                        <th class="table-th">Submitted</th>
                        <th class="table-th">Reporter Name</th>
                        <th class="table-th">Participant</th>
                        <th class="table-th">Incident Type</th>
                        <th class="table-th">Position</th>
                        <th class="table-th">Location</th>
                        <th class="table-th">Status</th>
                        <th class="table-th text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($medications as $row)
                    <tr class="table-row">
                        <td class="table-td">{{ $medications->firstItem() + $loop->index }}</td>
                        <td class="table-td">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="table-td font-semibold">{{ $row->pr_name }}</td>
                        <td class="table-td">{{ $row->cd_name }}</td>
                        <td class="table-td">{{ $row->incident_type }}</td>
                        <td class="table-td">{{ $row->pr_position }}</td>
                        <td class="table-td">{{ $row->cd_location }}</td>
                        <td class="table-td">
                            <span class="status-badge bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-300">
                                Submitted
                            </span>
                        </td>
                        <td class="table-td">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('forms.medication.show', $row->id) }}" class="action-btn" title="View">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                                <a href="{{ route('forms.medication.edit', $row->id) }}" class="action-btn" title="Edit">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                </a>
                                <button type="button"
                                        class="action-btn-danger"
                                        title="Delete"
                                        onclick="openDeleteModal('{{ route('forms.medication.destroy', $row->id) }}', '{{ addslashes($row->pr_name) }}')">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="table-td py-16 text-center text-slate-400 dark:text-slate-500">
                            <i data-lucide="file-x" class="mx-auto mb-2 h-8 w-8 opacity-40"></i>
                            <p>No medication incident reports found.</p>
                            @if (request()->hasAny(['search', 'location', 'type', 'date']))
                                <a href="{{ route('forms.medication.index') }}"
                                   class="mt-1 inline-block text-brand-600 hover:underline">Clear filters</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer / Pagination --}}
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
            <p>
                @if ($medications->total())
                    Showing {{ $medications->firstItem() }}–{{ $medications->lastItem() }} of {{ $medications->total() }} results
                @else
                    No results
                @endif
            </p>

            @if ($medications->hasPages())
            @php
                $current  = $medications->currentPage();
                $last     = $medications->lastPage();
                $window   = 2; // pages each side of current
                $pages    = collect();

                // Always show first page
                $pages->push(1);

                // Window around current
                for ($p = max(2, $current - $window); $p <= min($last - 1, $current + $window); $p++) {
                    $pages->push($p);
                }

                // Always show last page
                if ($last > 1) $pages->push($last);

                $pages = $pages->unique()->sort()->values();
            @endphp

            <div class="flex items-center gap-1">

                {{-- Previous --}}
                @if ($medications->onFirstPage())
                    <span class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 opacity-40 cursor-not-allowed dark:border-slate-700 dark:bg-slate-950">Prev</span>
                @else
                    <a href="{{ $medications->previousPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Prev</a>
                @endif

                {{-- Page numbers with ellipsis --}}
                @php $prev = null; @endphp
                @foreach ($pages as $page)
                    @if ($prev !== null && $page - $prev > 1)
                        <span class="px-1 text-slate-400">…</span>
                    @endif

                    @if ($page == $current)
                        <span class="rounded-lg bg-brand-600 px-3 py-1.5 text-white font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $medications->url($page) }}"
                           class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">{{ $page }}</a>
                    @endif

                    @php $prev = $page; @endphp
                @endforeach

                {{-- Next --}}
                @if ($medications->hasMorePages())
                    <a href="{{ $medications->nextPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Next</a>
                @else
                    <span class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 opacity-40 cursor-not-allowed dark:border-slate-700 dark:bg-slate-950">Next</span>
                @endif

            </div>
            @endif
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-900">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/15">
            <i data-lucide="trash-2" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
        </div>
        <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete record?</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            You are about to delete <span id="delete-name" class="font-semibold text-slate-700 dark:text-slate-200"></span>.
            This action cannot be undone.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button"
                    onclick="closeDeleteModal()"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                Cancel
            </button>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                    Yes, delete
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(action, name) {
    document.getElementById('delete-form').action = action;
    document.getElementById('delete-name').textContent = name;
    var modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    lucide.createIcons();
}
function closeDeleteModal() {
    var modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('delete-modal').addEventListener('click', function (e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
@endpush

<style>
.table-th {
    padding: 0.9rem 1rem;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: rgb(100 116 139);
    white-space: nowrap;
}
.table-td {
    padding: 1rem;
    font-size: 0.875rem;
    color: rgb(51 65 85);
    white-space: nowrap;
}
.dark .table-td { color: rgb(203 213 225); }
.table-row { transition: background 0.15s; }
.table-row:hover { background: rgb(248 250 252); }
.dark .table-row:hover { background: rgba(30, 41, 59, 0.55); }
.status-badge {
    display: inline-flex;
    align-items: center;
    border-radius: 9999px;
    padding: 0.25rem 0.7rem;
    font-size: 0.72rem;
    font-weight: 800;
}
.action-btn {
    display: inline-flex;
    height: 2rem;
    width: 2rem;
    align-items: center;
    justify-content: center;
    border-radius: 0.7rem;
    border: 1px solid rgb(226 232 240);
    background: white;
    color: rgb(71 85 105);
    transition: background 0.15s;
}
.action-btn:hover { background: rgb(241 245 249); }
.dark .action-btn {
    border-color: rgb(51 65 85);
    background: rgb(15 23 42);
    color: rgb(203 213 225);
}
.action-btn-danger {
    display: inline-flex;
    height: 2rem;
    width: 2rem;
    align-items: center;
    justify-content: center;
    border-radius: 0.7rem;
    border: 1px solid rgb(254 202 202);
    background: rgb(254 242 242);
    color: rgb(220 38 38);
    transition: background 0.15s;
}
.dark .action-btn-danger {
    border-color: rgba(239, 68, 68, .35);
    background: rgba(239, 68, 68, .12);
    color: rgb(248 113 113);
}
</style>
@endsection
