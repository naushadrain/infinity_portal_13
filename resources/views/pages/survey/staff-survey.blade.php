@extends('layouts.app', ['title' => 'Staff Surveys'])

@section('title', 'Staff Surveys')

@section('content')

    <div class="flex flex-wrap gap-1 bg-slate-100 dark:bg-ink-800 p-1 rounded-lg w-fit mb-5">
        <a href="{{ route(request()->route()->getName(), array_merge(request()->except('page'), ['city' => 'all'])) }}"
           class="px-4 py-1.5 rounded-md text-sm font-medium {{ ($selectedCity == 'all' || !$selectedCity) ? 'bg-white dark:bg-ink-900 shadow-sm' : 'text-slate-600 dark:text-ink-300' }}">
            All
        </a>

        <a href="{{ route(request()->route()->getName(), array_merge(request()->except('page'), ['city' => 'Victoria'])) }}"
           class="px-4 py-1.5 rounded-md text-sm font-medium {{ $selectedCity == 'Victoria' ? 'bg-white dark:bg-ink-900 shadow-sm' : 'text-slate-600 dark:text-ink-300' }}">
            Victoria
        </a>

        <a href="{{ route(request()->route()->getName(), array_merge(request()->except('page'), ['city' => 'Perth'])) }}"
           class="px-4 py-1.5 rounded-md text-sm font-medium {{ $selectedCity == 'Perth' ? 'bg-white dark:bg-ink-900 shadow-sm' : 'text-slate-600 dark:text-ink-300' }}">
            Perth
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-bold">Staff Surveys</h2>
            <p class="text-sm text-slate-500 dark:text-ink-400">
                {{ $staffSurveys->total() }} results
            </p>
        </div>

        <div class="flex gap-2">
            <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">

        <form method="GET" action="{{ route(request()->route()->getName()) }}"
              class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">

            <div class="flex items-center gap-2 flex-1 min-w-[220px] max-w-md bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    class="bg-transparent text-sm outline-none flex-1"
                    placeholder="Search city..."
                >
            </div>

            <select name="year"
                    class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
                <option value="">All Years</option>

                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>

            <input type="hidden" name="city" value="{{ $selectedCity ?? 'all' }}">

            <button type="submit"
                    class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Filter
            </button>

            <a href="{{ route(request()->route()->getName()) }}"
               class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
                Reset
            </a>
        </form>

        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-ink-800">
                    <tr>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">S.N</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">City Name</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Enjoy Working</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Satisfied With Career Growth</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Job Responsibilities Match Your Strengths?</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Work Life Balance</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Comfortable Feel Voicing Concerns</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Feel Stressed Work</th>
                        <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Meaningful Feel Your Work</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($staffSurveys as $row)
                        <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800">
                            <td class="px-4 py-3 text-sm">
                                {{ ($staffSurveys->currentPage() - 1) * $staffSurveys->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.city_name')[$row->city_name] ?? $row->city_name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.enjoy_working')[$row->enjoy_working] ?? $row->enjoy_working ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.satisfied_career_growth')[$row->satisfied_career_growth] ?? $row->satisfied_career_growth ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.match_strengths')[$row->responsibility_match_strength] ?? $row->responsibility_match_strength ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.work_life_balance')[$row->work_life_balance] ?? $row->work_life_balance ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.comfortable_voicing')[$row->comfortable_feel] ?? $row->comfortable_feel ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.feel_stressed_work')[$row->feel_stressed] ?? $row->feel_stressed ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.meaningful_work')[$row->meaningful_work] ?? $row->meaningful_work ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-sm text-slate-400 dark:text-ink-500">
                                No staff survey responses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
            <div>
                Showing {{ $staffSurveys->firstItem() ?? 0 }}–{{ $staffSurveys->lastItem() ?? 0 }} of {{ $staffSurveys->total() }}
            </div>

            <div>
                {{ $staffSurveys->links() }}
            </div>
        </div>
    </div>

@endsection