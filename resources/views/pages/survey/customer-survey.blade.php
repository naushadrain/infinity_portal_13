@extends('layouts.app', ['title' => 'Customer Surveys'])

@section('title', 'Customer Surveys')

@section('content')
    <div class="flex gap-1 bg-slate-100 dark:bg-ink-800 p-1 rounded-lg w-fit mb-5">
        <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['city' => 'all'])) }}"
            class="px-4 py-1.5 rounded-md text-sm font-medium {{ $selectedCity == 'all' || !$selectedCity ? 'bg-white dark:bg-ink-900 shadow-sm' : 'text-slate-600 dark:text-ink-300' }}">
            All
        </a>

        <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['city' => 'Victoria'])) }}"
            class="px-4 py-1.5 rounded-md text-sm font-medium {{ $selectedCity == 'Victoria' ? 'bg-white dark:bg-ink-900 shadow-sm' : 'text-slate-600 dark:text-ink-300' }}">
            Victoria
        </a>

        <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['city' => 'Perth'])) }}"
            class="px-4 py-1.5 rounded-md text-sm font-medium {{ $selectedCity == 'Perth' ? 'bg-white dark:bg-ink-900 shadow-sm' : 'text-slate-600 dark:text-ink-300' }}">
            Perth
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-bold">Surveys</h2>
            <p class="text-sm text-slate-500 dark:text-ink-400">
                {{ $customer->total() }} results
            </p>
        </div>

        <div class="flex gap-2">
            <a href="#"
                class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export
            </a>
        </div>
    </div>

    <div
        class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
        <form method="GET" action="{{ route(request()->route()->getName()) }}"
            class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">

            <div
                class="flex items-center gap-2 flex-1 min-w-[200px] max-w-[350px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
                <input type="text" name="search" value="{{ $search }}"
                    class="bg-transparent text-sm outline-none flex-1" placeholder="Search city...">
            </div>

            <select name="year"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
                <option value="">All Years</option>

                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>

            <input type="hidden" name="city" value="{{ $selectedCity }}">

            <button type="submit"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2">
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
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            S.N</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            City Name</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Overall Satisfy</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Employee Behave</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Resolving Customer’s concerns</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Willingness To Help You</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Employees Explain Information</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Rate Quality Service</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Recommend Infinite Ability To a Friend or Collegue</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Infinite Ability Meets Your Needs</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Suggesstions</th>
                        <th
                            class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">
                            Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($customer as $row)
                        <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800">

                            <td class="px-4 py-3 text-sm">
                                {{ ($customer->currentPage() - 1) * $customer->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.city_name.' . $row->city_name, $row->city_name) }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.overall_satisfaction_willingness.' . $row->overall_satisfy, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.employees_behave.' . $row->employee_behave, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.resolving_concerns.' . $row->resolving_ability, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.overall_satisfaction_willingness.' . $row->staff_will, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.explain_info.' . $row->employees_explain, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.rate_quality_service.' . $row->rate_quality, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.recommend_friend_colleague.' . $row->like_recommend, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{ config('settings.meets_your_needs.' . $row->meet_needs, '-') }}
                            </td>

                            <td class="px-4 py-3 text-sm max-w-xs">
                                {{ $row->suggestions ?: '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                {{ $row->created_at?->format('d M Y') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-4 py-8 text-center text-sm text-slate-400 dark:text-ink-500">
                                No survey responses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div
            class="p-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
            <div>
                Showing {{ $customer->firstItem() ?? 0 }}–{{ $customer->lastItem() ?? 0 }} of {{ $customer->total() }}
            </div>

            <div>
                {{ $customer->links() }}
            </div>
        </div>
    </div>
@endsection
