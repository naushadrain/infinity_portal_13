{{--
|--------------------------------------------------------------------------
| Page: Reports
|--------------------------------------------------------------------------
| Generated reports with date filters and export actions.
--}}
@extends('layouts.app', ['title' => 'Reports'])
@section('title', 'Reports')
@section('content')
    <div class="flex flex-wrap justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-bold">Reports</h2>
            <p class="text-sm text-slate-500 dark:text-ink-400">Generate and export operational reports</p>
        </div>
        <div class="flex gap-2">
            <button
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i
                    data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i> Export Excel</button>
            <button
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i
                    data-lucide="file-down" class="w-4 h-4 text-rose-600"></i> Export PDF</button>
        </div>
    </div>
    <div class="grid md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white dark:bg-ink-900 rounded-2xl p-5 shadow-soft border border-slate-100 dark:border-ink-800">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white grid place-items-center">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">+12%</span>
            </div>
            <div class="mt-4 text-2xl font-bold">389</div>
            <div class="text-sm text-slate-500 dark:text-ink-400">Total forms</div>
        </div>


        <div class="bg-white dark:bg-ink-900 rounded-2xl p-5 shadow-soft border border-slate-100 dark:border-ink-800">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white grid place-items-center">
                    <i data-lucide="poll" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">+24%</span>
            </div>
            <div class="mt-4 text-2xl font-bold">1,204</div>
            <div class="text-sm text-slate-500 dark:text-ink-400">Survey responses</div>
        </div>


        <div class="bg-white dark:bg-ink-900 rounded-2xl p-5 shadow-soft border border-slate-100 dark:border-ink-800">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 text-white grid place-items-center">
                    <i data-lucide="timer" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">-18%</span>
            </div>
            <div class="mt-4 text-2xl font-bold">2.4 h</div>
            <div class="text-sm text-slate-500 dark:text-ink-400">Avg. response time</div>
        </div>

    </div>
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Forms by type</h3>
            <div class="flex gap-2 text-xs">
                <select class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">
                    <option>Last 30 days</option>
                </select>
                <select class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">
                    <option>All regions</option>
                    <option>Perth</option>
                    <option>Victoria</option>
                </select>
            </div>
        </div>
        <div class="space-y-3 text-sm">
            <div>
                <div class="flex justify-between mb-1"><span>Incident Reports</span><span
                        class="text-slate-500 dark:text-ink-400">182</span></div>
                <div class="h-2 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-brand-400 to-brand-600" style="width:90%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1"><span>Medication Errors</span><span
                        class="text-slate-500 dark:text-ink-400">94</span></div>
                <div class="h-2 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-brand-400 to-brand-600" style="width:48%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1"><span>ABC Monitoring</span><span
                        class="text-slate-500 dark:text-ink-400">73</span></div>
                <div class="h-2 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-brand-400 to-brand-600" style="width:38%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1"><span>Other</span><span
                        class="text-slate-500 dark:text-ink-400">40</span></div>
                <div class="h-2 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-brand-400 to-brand-600" style="width:20%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
            <h3 class="font-semibold mb-4">Top incident types</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                            class="w-2 h-2 rounded-full bg-brand-500"></span>Behaviour</span><span
                        class="font-medium">42</span></li>
                <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                            class="w-2 h-2 rounded-full bg-brand-500"></span>Near miss</span><span
                        class="font-medium">28</span></li>
                <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                            class="w-2 h-2 rounded-full bg-brand-500"></span>Illness/Injury</span><span
                        class="font-medium">19</span></li>
                <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                            class="w-2 h-2 rounded-full bg-brand-500"></span>Property damage</span><span
                        class="font-medium">11</span></li>
                <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                            class="w-2 h-2 rounded-full bg-brand-500"></span>Other</span><span class="font-medium">6</span>
                </li>
            </ul>
        </div>
        <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
            <h3 class="font-semibold mb-4">Regional breakdown</h3>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="p-4 rounded-xl bg-brand-50">
                    <div class="text-3xl font-bold text-brand-700 dark:text-brand-300">218</div>
                    <div class="text-sm text-slate-600 dark:text-ink-300">Perth</div>
                </div>
                <div class="p-4 rounded-xl bg-amber-50">
                    <div class="text-3xl font-bold text-amber-700">171</div>
                    <div class="text-sm text-slate-600 dark:text-ink-300">Victoria</div>
                </div>
            </div>
        </div>
    </div>
@endsection
