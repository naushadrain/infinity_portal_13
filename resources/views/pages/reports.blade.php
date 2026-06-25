{{--
|--------------------------------------------------------------------------
| Page: Reports
|--------------------------------------------------------------------------
| Dynamic operational reports with date / region filters.
--}}
@extends('layouts.app', ['title' => 'Reports'])
@section('title', 'Reports')
@section('content')

{{-- ── Header ────────────────────────────────────────────────────────────── --}}
<div class="flex flex-wrap justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-bold">Reports</h2>
        <p class="text-sm text-slate-500 dark:text-ink-400">Operational summary for the last {{ $days }} days</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('forms.incident.export', array_filter(['days' => $days, 'city' => $city])) }}"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-ink-800 transition">
            <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i> Export CSV
        </a>
    </div>
</div>

{{-- ── Filters ───────────────────────────────────────────────────────────── --}}
<form method="GET" action="{{ route('reports.index') }}"
    class="flex flex-wrap gap-2 mb-6">
    <select name="days" onchange="this.form.submit()"
        class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
        @foreach ([7 => 'Last 7 days', 30 => 'Last 30 days', 90 => 'Last 90 days', 180 => 'Last 6 months', 365 => 'Last year'] as $val => $label)
            <option value="{{ $val }}" @selected($days == $val)>{{ $label }}</option>
        @endforeach
    </select>

    <select name="city" onchange="this.form.submit()"
        class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
        <option value="">All regions</option>
        @foreach (array_filter($cityNames) as $key => $name)
            <option value="{{ $key }}" @selected($city == $key)>{{ $name }}</option>
        @endforeach
    </select>

    @if ($city)
        <a href="{{ route('reports.index', ['days' => $days]) }}"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 transition">
            <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
        </a>
    @endif
</form>

{{-- ── KPI Cards ─────────────────────────────────────────────────────────── --}}
<div class="grid md:grid-cols-3 gap-4 mb-6">

    {{-- Total Forms --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl p-5 shadow-soft border border-slate-100 dark:border-ink-800">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-linear-to-br from-brand-500 to-brand-700 text-white grid place-items-center">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            </div>
            @if ($formsTrend >= 0)
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">
                    +{{ $formsTrend }}%
                </span>
            @else
                <span class="text-xs px-2 py-1 rounded-full bg-rose-50 dark:bg-rose-500/15 text-rose-700 dark:text-rose-300 font-medium">
                    {{ $formsTrend }}%
                </span>
            @endif
        </div>
        <div class="mt-4 text-2xl font-bold">{{ number_format($totalForms) }}</div>
        <div class="text-sm text-slate-500 dark:text-ink-400">Total forms submitted</div>
    </div>

    {{-- Survey Responses --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl p-5 shadow-soft border border-slate-100 dark:border-ink-800">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-linear-to-br from-emerald-500 to-emerald-700 text-white grid place-items-center">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
            @if ($surveysTrend >= 0)
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">
                    +{{ $surveysTrend }}%
                </span>
            @else
                <span class="text-xs px-2 py-1 rounded-full bg-rose-50 dark:bg-rose-500/15 text-rose-700 dark:text-rose-300 font-medium">
                    {{ $surveysTrend }}%
                </span>
            @endif
        </div>
        <div class="mt-4 text-2xl font-bold">{{ number_format($totalSurveys) }}</div>
        <div class="text-sm text-slate-500 dark:text-ink-400">Survey responses</div>
    </div>

    {{-- Pending Incidents --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl p-5 shadow-soft border border-slate-100 dark:border-ink-800">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-linear-to-br from-amber-500 to-amber-600 text-white grid place-items-center">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            @php
                $total = $completedCount + $pendingCount;
                $pct   = $total > 0 ? round(($completedCount / $total) * 100) : 0;
            @endphp
            <span class="text-xs px-2 py-1 rounded-full bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300 font-medium">
                {{ $pct }}% done
            </span>
        </div>
        <div class="mt-4 text-2xl font-bold">{{ number_format($pendingCount) }}</div>
        <div class="text-sm text-slate-500 dark:text-ink-400">Pending incidents</div>
    </div>

</div>

{{-- ── Forms by type ─────────────────────────────────────────────────────── --}}
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
    <h3 class="font-semibold mb-4">Forms by type</h3>
    <div class="space-y-3 text-sm">

        @php
            $formTypes = [
                'Incident Reports' => $incidentCount,
                'Medication Errors' => $medicationCount,
                'ABC Monitoring'   => $abcCount,
            ];
            $maxBar = max(array_values($formTypes) ?: [1]);
        @endphp

        @foreach ($formTypes as $label => $count)
            @php $width = $maxBar > 0 ? round(($count / $maxBar) * 100) : 0; @endphp
            <div>
                <div class="flex justify-between mb-1">
                    <span>{{ $label }}</span>
                    <span class="text-slate-500 dark:text-ink-400">{{ number_format($count) }}</span>
                </div>
                <div class="h-2 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                    <div class="h-full rounded-full bg-linear-to-r from-brand-400 to-brand-600 transition-all duration-500"
                        style="width: {{ $width }}%"></div>
                </div>
            </div>
        @endforeach

    </div>
</div>

{{-- ── Bottom two panels ─────────────────────────────────────────────────── --}}
<div class="grid lg:grid-cols-2 gap-6">

    {{-- Top incident types --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
        <h3 class="font-semibold mb-4">Top incident types</h3>
        @if (array_sum($topIncidentTypes) > 0)
            <ul class="space-y-2.5 text-sm">
                @foreach ($topIncidentTypes as $type => $count)
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-brand-500 shrink-0"></span>
                            {{ $type }}
                        </span>
                        <span class="font-medium tabular-nums">{{ number_format($count) }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-slate-400 dark:text-ink-500 text-center py-6">No incident type data yet.</p>
        @endif
    </div>

    {{-- Regional breakdown --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
        <h3 class="font-semibold mb-4">Regional breakdown</h3>
        @if (count($regionBreakdown) > 0)
            @php
                $regionColors = ['bg-brand-50 text-brand-700', 'bg-amber-50 text-amber-700', 'bg-emerald-50 text-emerald-700', 'bg-rose-50 text-rose-700'];
                $regionTotal  = array_sum($regionBreakdown);
            @endphp
            <div class="grid grid-cols-2 gap-3">
                @foreach ($regionBreakdown as $regionName => $regionCount)
                    @php $colorClass = $regionColors[$loop->index % count($regionColors)]; @endphp
                    <div class="p-4 rounded-xl {{ $colorClass }} dark:bg-opacity-10">
                        <div class="text-3xl font-bold">{{ number_format($regionCount) }}</div>
                        <div class="text-sm mt-0.5">{{ $regionName }}</div>
                        @if ($regionTotal > 0)
                            <div class="text-xs mt-1 opacity-70">{{ round(($regionCount / $regionTotal) * 100) }}% of total</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-400 dark:text-ink-500 text-center py-6">No regional data for this period.</p>
        @endif
    </div>

</div>

{{-- ── Completion status card ────────────────────────────────────────────── --}}
<div class="mt-6 bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
    <h3 class="font-semibold mb-4">Incident completion status</h3>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="flex items-center gap-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10">
            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-500/20 grid place-items-center shrink-0">
                <i data-lucide="circle-check" class="w-5 h-5 text-emerald-600 dark:text-emerald-400"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ number_format($completedCount) }}</div>
                <div class="text-sm text-slate-600 dark:text-ink-300">Completed</div>
            </div>
        </div>
        <div class="flex items-center gap-4 p-4 rounded-xl bg-amber-50 dark:bg-amber-500/10">
            <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-500/20 grid place-items-center shrink-0">
                <i data-lucide="clock" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ number_format($pendingCount) }}</div>
                <div class="text-sm text-slate-600 dark:text-ink-300">Pending</div>
            </div>
        </div>
    </div>

    @if ($completedCount + $pendingCount > 0)
        @php $completionPct = round(($completedCount / ($completedCount + $pendingCount)) * 100); @endphp
        <div class="mt-4">
            <div class="flex justify-between text-xs text-slate-500 dark:text-ink-400 mb-1">
                <span>Completion rate</span>
                <span>{{ $completionPct }}%</span>
            </div>
            <div class="h-2.5 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                <div class="h-full rounded-full bg-linear-to-r from-emerald-400 to-emerald-600 transition-all duration-500"
                    style="width: {{ $completionPct }}%"></div>
            </div>
        </div>
    @endif
</div>

{{-- ── Survey split ──────────────────────────────────────────────────────── --}}
@if ($totalSurveys > 0)
<div class="mt-6 bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
    <h3 class="font-semibold mb-4">Survey responses breakdown</h3>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="flex items-center gap-4 p-4 rounded-xl bg-brand-50 dark:bg-brand-500/10">
            <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-500/20 grid place-items-center shrink-0">
                <i data-lucide="users" class="w-5 h-5 text-brand-600 dark:text-brand-400"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-brand-700 dark:text-brand-300">{{ number_format($customerSurveyCount) }}</div>
                <div class="text-sm text-slate-600 dark:text-ink-300">Customer surveys</div>
            </div>
        </div>
        <div class="flex items-center gap-4 p-4 rounded-xl bg-indigo-50 dark:bg-indigo-500/10">
            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-500/20 grid place-items-center shrink-0">
                <i data-lucide="briefcase" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-indigo-700 dark:text-indigo-300">{{ number_format($staffSurveyCount) }}</div>
                <div class="text-sm text-slate-600 dark:text-ink-300">Staff surveys</div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
