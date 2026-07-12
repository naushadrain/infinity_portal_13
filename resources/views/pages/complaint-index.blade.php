@extends('layouts.app', ['title' => ''])

@section('title', 'Public Complaint')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Public Complaints</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ $complaints->total() }} {{ Str::plural('result', $complaints->total()) }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('forms.complaint.export', request()->only(['search', 'status', 'date'])) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i data-lucide="download" class="h-4 w-4"></i>
                Export
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-950">

        {{-- Filters --}}
        <form method="GET" action="{{ route('forms.complaint.index') }}"
              class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap gap-3">

                {{-- Search --}}
                <div class="flex min-w-[240px] max-w-[400px] flex-1 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 dark:border-slate-700 dark:bg-slate-950">
                    <i data-lucide="search" class="h-4 w-4 text-slate-400 shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search name, email, contact..."
                           class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 dark:text-slate-200">
                </div>

                {{-- Status dropdown (dynamic) --}}
                <select name="status"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ $s }}
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
                @if (request()->hasAny(['search', 'status', 'date']))
                    <a href="{{ route('forms.complaint.index') }}"
                       class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead class="bg-slate-100 dark:bg-slate-900">
                    <tr>
                        <th class="table-th">Sr. No.</th>
                        <th class="table-th">Submitted</th>
                        <th class="table-th">Name</th>
                        <th class="table-th">Received From</th>
                        <th class="table-th">Contact</th>
                        <th class="table-th">Status</th>
                        <th class="table-th text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($complaints as $row)
                    <tr class="table-row">
                        <td class="table-td">{{ $complaints->firstItem() + $loop->index }}</td>
                        <td class="table-td">{{ ($row->submitted_at ?? $row->created_at)->format('d M Y') }}</td>
                        <td class="table-td font-semibold">{{ $row->name }}</td>
                        <td class="table-td">{{ $row->received_from }}</td>
                        <td class="table-td">{{ $row->contact_number ?: '—' }}</td>
                        <td class="table-td">
                            <span class="status-badge bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-300">
                                {{ $row->status }}
                            </span>
                        </td>
                        <td class="table-td">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('forms.complaint.show', $row->id) }}" class="action-btn" title="View">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                                <a href="{{ route('forms.complaint.edit', $row->id) }}" class="action-btn" title="Edit">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                </a>
                                <button type="button"
                                        class="action-btn-danger"
                                        title="Delete"
                                        onclick="openDeleteModal('{{ route('forms.complaint.destroy', $row->id) }}', '{{ addslashes($row->name) }}')">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="table-td py-16 text-center text-slate-400 dark:text-slate-500">
                            <i data-lucide="file-x" class="mx-auto mb-2 h-8 w-8 opacity-40"></i>
                            <p>No public complaints found.</p>
                            @if (request()->hasAny(['search', 'status', 'date']))
                                <a href="{{ route('forms.complaint.index') }}"
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
                @if ($complaints->total())
                    Showing {{ $complaints->firstItem() }}–{{ $complaints->lastItem() }} of {{ $complaints->total() }} results
                @else
                    No results
                @endif
            </p>

            @if ($complaints->hasPages())
            @php
                $current = $complaints->currentPage();
                $last    = $complaints->lastPage();
                $firstBlock = range(1, min(10, $last));
                $tailBlock  = $last > 11 ? [$last - 1, $last] : [];
                $tailBlock  = array_filter($tailBlock, fn($p) => $p > 10);
                $showEllipsis = $last > 11;
            @endphp

            <div class="flex flex-wrap items-center gap-1">

                {{-- Prev --}}
                @if ($complaints->onFirstPage())
                    <span class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm opacity-40 cursor-not-allowed dark:border-slate-700 dark:bg-slate-950">Prev</span>
                @else
                    <a href="{{ $complaints->previousPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Prev</a>
                @endif

                {{-- Pages 1–10 --}}
                @foreach ($firstBlock as $page)
                    @if ($page == $current)
                        <span class="rounded-lg bg-brand-600 px-3 py-1.5 text-sm text-white font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $complaints->url($page) }}"
                           class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Ellipsis + tail (second-to-last, last) --}}
                @if ($showEllipsis)
                    <span class="px-1 text-slate-400 text-sm select-none">…</span>
                    @foreach ($tailBlock as $page)
                        @if ($page == $current)
                            <span class="rounded-lg bg-brand-600 px-3 py-1.5 text-sm text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $complaints->url($page) }}"
                               class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif

                {{-- Next --}}
                @if ($complaints->hasMorePages())
                    <a href="{{ $complaints->nextPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Next</a>
                @else
                    <span class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm opacity-40 cursor-not-allowed dark:border-slate-700 dark:bg-slate-950">Next</span>
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
