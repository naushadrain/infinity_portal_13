{{--
|--------------------------------------------------------------------------
| Page: Forms Index
|--------------------------------------------------------------------------
| Searchable list of all submitted forms across types.
--}}
@extends('layouts.app', ['title' => ''])
@section('title', 'Incident Form')
@php $isAdmin = auth()->user()->role_id == 1; @endphp
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-bold">Manage Incident Form</h2>
            <p class="text-sm text-slate-500 dark:text-ink-400">{{ $incidents->total() }} results</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('forms.incident.export', request()->only(['search', 'city', 'date'])) }}"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export
            </a>
            <a href="{{ route('forms.incident.create') }}"
                class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i
                    data-lucide="plus" class="w-4 h-4"></i> New Incident Form</a>
        </div>
    </div>

    @if (session('success'))
        <div
            class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div
        class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
        <form method="GET" action="{{ route('forms.incident.index') }}"
            class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
            <div
                class="flex items-center gap-2 flex-1 min-w-[200px] max-w-[400px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
                <input name="search" value="{{ request('search') }}" class="bg-transparent text-sm outline-none flex-1"
                    placeholder="Search reporter, participant…">
            </div>
            <select name="city"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
                <option value="">All states</option>
                @foreach (config('settings.city_name', []) as $key => $name)
                    @if ($key != 0)
                        <option value="{{ $key }}" @selected(request('city') == $key)>{{ $name }}</option>
                    @endif
                @endforeach
            </select>
            <input type="date" name="date" value="{{ request('date') }}"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
            @if (request()->hasAny(['search', 'city', 'date']))
                <a href="{{ route('forms.incident.index') }}"
                    class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
                </a>
            @endif
            <button type="submit" class="px-4 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium">
                Filter
            </button>
        </form>
        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-ink-800">
                    <tr>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Sr. No.</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Submitted</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Participant Name

                        </th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Reporter Name</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Contact</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            IR Number</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Position</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            City</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Link
                        </th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Status</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidents as $incident)
                        <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800">
                            <td class="px-4 py-3 text-sm">
                                {{ $loop->iteration + ($incidents->currentPage() - 1) * $incidents->perPage() }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->participant->full_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->contact ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->ir_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->position_title ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">
                                {{ $incident->city == 0 ? '—' : config('settings.city_name')[$incident->city] ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('forms.reportpdf', $incident->id) }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1 text-brand-600 hover:underline">
                                    <i data-lucide="file-text" class="w-4 h-4"></i> View PDF
                                </a>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if ($incident->completed)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    @if ($isAdmin)
                                        <a href="{{ route('forms.incident.show', $incident) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-slate-600 hover:bg-slate-100 dark:bg-ink-800 dark:text-ink-300 transition"
                                            title="View">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                    @if ($isAdmin || !$incident->completed)
                                        <a href="{{ route('forms.incident.edit', $incident) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 transition"
                                            title="Edit">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                    @if ($isAdmin)
                                        <form method="POST" action="{{ route('forms.incident.destroy', $incident) }}"
                                            onsubmit="return confirm('Delete this incident report? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 transition"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-sm text-slate-400 dark:text-ink-500">
                                No incident reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div
            class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
            <div>
                @if ($incidents->total())
                    Showing {{ $incidents->firstItem() }}–{{ $incidents->lastItem() }} of {{ $incidents->total() }}
                @else
                    No results
                @endif
            </div>
            <div>{{ $incidents->links() }}</div>
        </div>
    </div>
@endsection
