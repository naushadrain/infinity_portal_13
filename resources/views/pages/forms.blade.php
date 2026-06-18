{{--
|--------------------------------------------------------------------------
| Page: Forms Index
|--------------------------------------------------------------------------
| Searchable list of all submitted forms across types.
--}}
@extends('layouts.app', ['title' => 'Forms'])
@section('title', 'Forms')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-bold">Forms</h2>
            <p class="text-sm text-slate-500 dark:text-ink-400">{{ $incidents->total() }} results</p>
        </div>
        <div class="flex gap-2">
            <button
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i
                    data-lucide="download" class="w-4 h-4"></i> Export</button>
            <a href="{{ route('forms.incident.create') }}"
                class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i
                    data-lucide="plus" class="w-4 h-4"></i> New form</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div
        class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
        <form method="GET" action="{{ route('forms.incident.index') }}"
            class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
            <div class="flex items-center gap-2 flex-1 min-w-[200px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
                <input name="search" value="{{ request('search') }}"
                    class="bg-transparent text-sm outline-none flex-1" placeholder="Search reporter, participant…">
            </div>
            <select name="city"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm"
                onchange="this.form.submit()">
                <option value="">All states</option>
                <option value="Perth" @selected(request('city') === 'Perth')>Perth</option>
                <option value="Victoria" @selected(request('city') === 'Victoria')>Victoria</option>
            </select>
            <input type="date" name="date" value="{{ request('date') }}"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm"
                onchange="this.form.submit()">
            @if(request()->hasAny(['search', 'city', 'date']))
                <a href="{{ route('forms.incident.index') }}"
                    class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
                </a>
            @endif
        </form>
        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-ink-800">
                    <tr>
                      <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Sr. No.</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Submitted</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Reporter Name</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Contact</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">IR Number</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Position</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">City</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Status</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidents as $incident)
                        <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800">
                              <td class="px-4 py-3 text-sm">{{ $loop->iteration + ($incidents->currentPage() - 1) * $incidents->perPage() }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->contact ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->ir_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $incident->position_title ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ config('settings.city_name')[$incident->city] ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($incident->completed)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm flex items-center gap-3">
                                <a href="{{ route('forms.incident.edit', $incident) }}"
                                    class="text-brand-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('forms.incident.destroy', $incident) }}"
                                    onsubmit="return confirm('Delete this incident report?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm text-slate-400 dark:text-ink-500">
                                No incident reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
            <div>
                @if($incidents->total())
                    Showing {{ $incidents->firstItem() }}–{{ $incidents->lastItem() }} of {{ $incidents->total() }}
                @else
                    No results
                @endif
            </div>
            <div>{{ $incidents->links() }}</div>
        </div>
    </div>
@endsection
