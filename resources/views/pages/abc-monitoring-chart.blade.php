@extends('layouts.app', ['title' => 'ABC Monitoring Chart'])

@section('title', 'ABC Monitoring Charts')

@section('content')
<div class="space-y-5">

    {{-- Flash toast --}}
    @if (session('success') || session('error'))
        @php
            $isSuccess = (bool) session('success');
            $msg = session('success') ?? session('error');
        @endphp
        <div id="flash-toast"
             class="fixed top-5 right-5 z-50 w-[330px] max-w-[calc(100vw-2rem)] rounded-xl border {{ $isSuccess ? 'border-emerald-500 bg-emerald-600' : 'border-rose-500 bg-rose-600' }} text-white shadow-2xl overflow-hidden">
            <div class="flex items-start gap-3 p-4">
                <i data-lucide="{{ $isSuccess ? 'circle-check' : 'circle-x' }}" class="w-5 h-5 mt-0.5 shrink-0"></i>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold">{{ $isSuccess ? 'Success' : 'Error' }}</h4>
                    <p class="text-sm text-white/90 mt-0.5">{{ $msg }}</p>
                </div>
                <button onclick="this.closest('#flash-toast').remove()" class="text-white/70 hover:text-white">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <div class="h-1 bg-white/25">
                <div id="flash-bar" class="h-full bg-white/75 w-full" style="transition: width 4s linear;"></div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(() => { document.getElementById('flash-bar').style.width = '0%'; }, 80);
                setTimeout(() => { document.getElementById('flash-toast')?.remove(); }, 4300);
                if (window.lucide) lucide.createIcons();
            });
        </script>
    @endif

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">ABC Monitoring Charts</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ $abcMonitoringCharts->total() }} {{ Str::plural('record', $abcMonitoringCharts->total()) }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('forms.abc-monitoring-chart.export', request()->only(['search', 'date'])) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i data-lucide="download" class="h-4 w-4"></i>
                Export
            </a>

            <a href="{{ route('forms.abc-monitoring-chart.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">
                <i data-lucide="plus" class="h-4 w-4"></i>
                New ABC Chart
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-950">

        {{-- Filter bar --}}
        <form method="GET" action="{{ route('forms.abc-monitoring-chart.index') }}"
              class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap gap-3">

                {{-- Search --}}
                <div class="flex min-w-60 max-w-[420px] flex-1 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 dark:border-slate-700 dark:bg-slate-950">
                    <i data-lucide="search" class="h-4 w-4 text-slate-400 shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search participant name or address…"
                           class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 dark:text-slate-200">
                </div>

                {{-- Date --}}
                <input type="date" name="date" value="{{ request('date') }}"
                       class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">

                {{-- Filter button --}}
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    Filter
                </button>

                {{-- Clear --}}
                @if (request()->hasAny(['search', 'date']))
                    <a href="{{ route('forms.abc-monitoring-chart.index') }}"
                       class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Clear
                    </a>
                @endif

            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px]">
                <thead class="bg-slate-100 dark:bg-slate-900">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Sr. No.
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Participant Name
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Participant Address
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Date of Birth
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Submitted
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($abcMonitoringCharts as $row)
                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/60">
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700 dark:text-slate-300">
                            {{ $abcMonitoringCharts->firstItem() + $loop->index }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800 dark:text-slate-200">
                            {{ $row->participant_name }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700 dark:text-slate-300">
                            {{ $row->participant_address }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700 dark:text-slate-300">
                            {{ $row->participant_date_of_birth
                                ? \Carbon\Carbon::parse($row->participant_date_of_birth)->format('d M Y')
                                : '—' }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ $row->created_at->format('d M Y') }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('forms.abc-monitoring-chart.show', $row->id) }}"
                                   title="View"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:bg-slate-800 transition">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                                <a href="{{ route('forms.abc-monitoring-chart.edit', $row->id) }}"
                                   title="Edit"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-400 transition">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                </a>
                                <button type="button"
                                        title="Delete"
                                        onclick="openDeleteModal('{{ route('forms.abc-monitoring-chart.destroy', $row->id) }}', '{{ addslashes($row->participant_name) }}')"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400 transition">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center text-sm text-slate-400 dark:text-slate-500">
                            <i data-lucide="file-x" class="mx-auto mb-2 h-8 w-8 opacity-40"></i>
                            <p>No ABC monitoring chart records found.</p>
                            @if (request()->hasAny(['search', 'date']))
                                <a href="{{ route('forms.abc-monitoring-chart.index') }}"
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
                @if ($abcMonitoringCharts->total())
                    Showing {{ $abcMonitoringCharts->firstItem() }}–{{ $abcMonitoringCharts->lastItem() }}
                    of {{ $abcMonitoringCharts->total() }} results
                @else
                    No results
                @endif
            </p>

            @if ($abcMonitoringCharts->hasPages())
            @php
                $current = $abcMonitoringCharts->currentPage();
                $last    = $abcMonitoringCharts->lastPage();
                $pages   = collect([1]);

                for ($p = max(2, $current - 2); $p <= min($last - 1, $current + 2); $p++) {
                    $pages->push($p);
                }

                if ($last > 1) $pages->push($last);
                $pages = $pages->unique()->sort()->values();
            @endphp

            <div class="flex items-center gap-1">

                {{-- Prev --}}
                @if ($abcMonitoringCharts->onFirstPage())
                    <span class="cursor-not-allowed rounded-lg border border-slate-200 bg-white px-3 py-1.5 opacity-40 dark:border-slate-700 dark:bg-slate-950">Prev</span>
                @else
                    <a href="{{ $abcMonitoringCharts->previousPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Prev</a>
                @endif

                {{-- Numbered pages with ellipsis --}}
                @php $prev = null; @endphp
                @foreach ($pages as $page)
                    @if ($prev !== null && $page - $prev > 1)
                        <span class="px-1 text-slate-400">…</span>
                    @endif

                    @if ($page == $current)
                        <span class="rounded-lg bg-brand-600 px-3 py-1.5 font-semibold text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $abcMonitoringCharts->url($page) }}"
                           class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">{{ $page }}</a>
                    @endif

                    @php $prev = $page; @endphp
                @endforeach

                {{-- Next --}}
                @if ($abcMonitoringCharts->hasMorePages())
                    <a href="{{ $abcMonitoringCharts->nextPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Next</a>
                @else
                    <span class="cursor-not-allowed rounded-lg border border-slate-200 bg-white px-3 py-1.5 opacity-40 dark:border-slate-700 dark:bg-slate-950">Next</span>
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
            You are about to delete
            <span id="delete-name" class="font-semibold text-slate-700 dark:text-slate-200"></span>.
            This action cannot be undone.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()"
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

@endsection
