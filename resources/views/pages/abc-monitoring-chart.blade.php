@extends('layouts.app', ['title' => 'ABC Monitoring Charts'])

@section('title', 'ABC Monitoring Charts')

@section('content')
<div class="space-y-5">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                Manage ABC Monitoring Chart
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                View and manage participant ABC monitoring chart records
            </p>
        </div>

        <a href="{{ route('forms.abc-monitoring-chart.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">
            <i data-lucide="plus" class="h-4 w-4"></i>
            New ABC Chart
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-950">

        <div class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="flex min-w-[240px] items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 dark:border-slate-700 dark:bg-slate-950">
                <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                <input type="text"
                       placeholder="Search participant name or address..."
                       class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 dark:text-slate-200">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px]">
                <thead class="bg-slate-100 dark:bg-slate-900">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            S.N
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Participant Name
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Participant Address
                        </th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Participant Date of Birth
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
                            {{ $row->participant_date_of_birth ? \Carbon\Carbon::parse($row->participant_date_of_birth)->format('d M Y') : '—' }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('forms.abc-monitoring-chart.show', $row->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:bg-slate-800">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                                <a href="{{ route('forms.abc-monitoring-chart.edit', $row->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:bg-slate-800">
                                    <i data-lucide="edit" class="h-4 w-4"></i>
                                </a>
                                <button type="button"
                                        onclick="openDeleteModal('{{ route('forms.abc-monitoring-chart.destroy', $row->id) }}', '{{ addslashes($row->participant_name) }}')"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-16 text-center text-sm text-slate-400 dark:text-slate-500">
                            No ABC monitoring chart records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
            <p>
                @if($abcMonitoringCharts->total())
                    Showing {{ $abcMonitoringCharts->firstItem() }} to {{ $abcMonitoringCharts->lastItem() }} of {{ $abcMonitoringCharts->total() }} results
                @else
                    No results
                @endif
            </p>

            @if($abcMonitoringCharts->hasPages())
            <div class="flex gap-2">
                @if($abcMonitoringCharts->onFirstPage())
                    <span class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 opacity-40 dark:border-slate-700 dark:bg-slate-950">Previous</span>
                @else
                    <a href="{{ $abcMonitoringCharts->previousPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Previous</a>
                @endif

                @foreach($abcMonitoringCharts->getUrlRange(1, $abcMonitoringCharts->lastPage()) as $page => $url)
                    @if($page == $abcMonitoringCharts->currentPage())
                        <span class="rounded-lg bg-brand-600 px-3 py-1.5 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">{{ $page }}</a>
                    @endif
                @endforeach

                @if($abcMonitoringCharts->hasMorePages())
                    <a href="{{ $abcMonitoringCharts->nextPageUrl() }}"
                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:hover:bg-slate-800">Next</a>
                @else
                    <span class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 opacity-40 dark:border-slate-700 dark:bg-slate-950">Next</span>
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
</script>
@endpush

@endsection