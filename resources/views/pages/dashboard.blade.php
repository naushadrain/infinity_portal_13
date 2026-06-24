{{--
|--------------------------------------------------------------------------
| Page: Dashboard
|--------------------------------------------------------------------------
| KPI cards, charts and recent activity for the back-office home screen.
--}}
@extends('layouts.app', ['title' => 'Dashboard'])
@section('title', 'Dashboard')
@section('content')
    <!-- Greeting hero -->
    <section
        class="relative overflow-hidden rounded-2xl sm:rounded-2xl sm:rounded-3xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-900 text-white p-5 sm:p-5 sm:p-6 lg:p-8 mb-6">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white dark:bg-ink-900/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-10 w-72 h-72 bg-indigo-400/20 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col lg:flex-row lg:items-end justify-between gap-5">
            @php
                $hour = \Carbon\Carbon::now('Asia/Kathmandu')->hour;

                if ($hour < 12) {
                    $greeting = 'Good Morning';
                } elseif ($hour < 17) {
                    $greeting = 'Good Afternoon';
                } elseif ($hour < 20) {
                    $greeting = 'Good Evening';
                } else {
                    $greeting = 'Good Night';
                }
            @endphp
            <div>
                <div class="text-[11px] sm:text-xs uppercase tracking-[0.18em] text-white/70 font-semibold">
                    {{ date('l · j F Y') }}</div>
                <h2 class="mt-2 text-xl sm:text-2xl lg:text-3xl font-bold leading-tight">{{ $greeting }},
                    {{ auth()->user()->name ?? 'Default Name' }} 👋</h2>
                <p class="mt-1.5 text-sm text-white/75 max-w-lg">You have <b class="text-white">3 incidents</b> awaiting
                    review and <b class="text-white">2 surveys</b> closing this week.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button
                    class="px-3.5 py-2 rounded-lg bg-white dark:bg-ink-900/10 hover:bg-white dark:hover:bg-ink-900/15 backdrop-blur text-sm font-medium flex items-center gap-2 ring-1 ring-white dark:ring-ink-800/15 text-slate-900 dark:text-white">
                    <i data-lucide="calendar" class="w-4 h-4 text-slate-900 dark:text-white"></i>
                    Last 30 days
                </button>
                <button
                    class="px-3.5 py-2 rounded-lg bg-white dark:bg-ink-900 text-brand-700 dark:text-brand-300 text-sm font-semibold flex items-center gap-2 shadow-lg shadow-indigo-900/30"><i
                        data-lucide="plus" class="w-4 h-4"></i> New form</button>
            </div>
        </div>
    </section>

    <!-- KPI cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-300 grid place-items-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1"><i
                        data-lucide="trending-up" class="w-3 h-3"></i>+{{ $newUsersCount }} new</span>
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">{{ $totalUsers }}</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Active staff/members</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#4f46e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </div>
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 grid place-items-center">
                    <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1"><i
                        data-lucide="trending-up" class="w-3 h-3"></i>+12%</span>
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">389</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Forms submitted</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#10b981" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </div>
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-300 grid place-items-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1"><i
                        data-lucide="trending-down" class="w-3 h-3"></i>-3</span>
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">{{$fromIncidentsCount}}</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Open incidents</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </div>
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-500/15 text-rose-600 dark:text-rose-300 grid place-items-center">
                    <i data-lucide="message-square-heart" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1"><i
                        data-lucide="trending-up" class="w-3 h-3"></i>+24%</span>
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">1,204</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Survey responses</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#f43f5e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </div>
    </div>

    <!-- Chart + activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div
            class="lg:col-span-2 bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h3 class="font-semibold">Form submissions</h3>
                    <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Daily activity across both regions</p>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-ink-400">
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>Perth</span>
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Victoria</span>
                    </div>
                    <div class="flex gap-0.5 p-0.5 bg-slate-100 dark:bg-ink-800 rounded-lg text-xs">
                        <button class="px-3 py-1 rounded-md bg-white dark:bg-ink-700 shadow-sm font-medium">Week</button>
                        <button class="px-3 py-1 rounded-md text-slate-500 dark:text-ink-400">Month</button>
                        <button class="px-3 py-1 rounded-md text-slate-500 dark:text-ink-400">Year</button>
                    </div>
                </div>
            </div>
            <div class="relative">
                <svg viewBox="0 0 700 240" class="w-full h-48 sm:h-60" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="gPerth" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#6366f1" stop-opacity="0.35" />
                            <stop offset="100%" stop-color="#6366f1" stop-opacity="0" />
                        </linearGradient>
                        <linearGradient id="gVic" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#10b981" stop-opacity="0.28" />
                            <stop offset="100%" stop-color="#10b981" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    <g class="stroke-slate-100 dark:stroke-ink-800" stroke-width="1">
                        <line x1="0" y1="40" x2="700" y2="40" />
                        <line x1="0" y1="100" x2="700" y2="100" />
                        <line x1="0" y1="160" x2="700" y2="160" />
                        <line x1="0" y1="220" x2="700" y2="220" />
                    </g>
                    <path d="M0,180 L100,160 L200,170 L300,140 L400,150 L500,120 L600,135 L700,110 L700,240 L0,240 Z"
                        fill="url(#gVic)" />
                    <polyline fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" points="0,180 100,160 200,170 300,140 400,150 500,120 600,135 700,110" />
                    <path d="M0,140 L100,110 L200,125 L300,80 L400,95 L500,55 L600,75 L700,40 L700,240 L0,240 Z"
                        fill="url(#gPerth)" />
                    <polyline fill="none" stroke="#4f46e5" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" points="0,140 100,110 200,125 300,80 400,95 500,55 600,75 700,40" />
                    <g fill="#4f46e5">
                        <circle cx="500" cy="55" r="4" />
                        <circle cx="500" cy="55" r="8" fill="#4f46e5" fill-opacity="0.18" />
                    </g>
                </svg>
            </div>
            <div class="flex justify-between text-[11px] text-slate-400 dark:text-ink-500 mt-2 px-1">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold">Recent activity</h3>
                    <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Latest staff registrations</p>
                </div>
            </div>

            @php
                $dotColors = [
                    'bg-brand-500 ring-brand-50 dark:ring-brand-500/10',
                    'bg-emerald-500 ring-emerald-50 dark:ring-emerald-500/10',
                    'bg-amber-500 ring-amber-50 dark:ring-amber-500/10',
                    'bg-rose-500 ring-rose-50 dark:ring-rose-500/10',
                    'bg-indigo-500 ring-indigo-50 dark:ring-indigo-500/10',
                    'bg-slate-400 ring-slate-100 dark:ring-ink-800',
                ];
            @endphp

            @if ($recentUsers->isNotEmpty())
                <ol
                    class="relative space-y-5 text-sm flex-1 before:absolute before:top-1 before:bottom-1 before:left-[7px] before:w-px before:bg-slate-100 dark:before:bg-ink-800">
                    @foreach ($recentUsers as $i => $u)
                        @php
                            $dot = $dotColors[$i % count($dotColors)];
                            $initials = collect(explode(' ', $u->name))
                                ->map(fn($w) => strtoupper($w[0] ?? ''))
                                ->take(2)
                                ->implode('');
                        @endphp
                        <li class="relative pl-7">
                            <span class="absolute left-0 top-1 w-3.5 h-3.5 rounded-full ring-4 {{ $dot }}"></span>
                            <div class="font-medium leading-snug">
                                New account — <b>{{ $u->name }}</b>
                            </div>
                            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5 flex items-center gap-1.5">
                                <span>{{ $u->role->name ?? 'No role' }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-ink-600 inline-block"></span>
                                <span>{{ $u->created_at->diffForHumans() }}</span>
                            </div>
                        </li>
                    @endforeach
                </ol>
            @else
                <div
                    class="flex-1 flex flex-col items-center justify-center py-8 text-center text-sm text-slate-400 dark:text-ink-500">
                    <i data-lucide="activity" class="w-8 h-8 mb-2 opacity-40"></i>
                    <p>No recent activity yet.</p>
                </div>
            @endif

            <a href="{{ route('users.index') }}"
                class="mt-5 inline-flex items-center justify-center gap-1 text-xs font-semibold text-brand-600 dark:text-brand-300 hover:text-brand-700 border-t border-slate-100 dark:border-ink-800 pt-4">
                View all staff <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
    </div>

    <!-- Donut, tasks, quick actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6 mb-6">
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <h3 class="font-semibold mb-1">Forms by type</h3>
            <p class="text-xs text-slate-500 dark:text-ink-400 mb-4">Last 30 days</p>
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="relative w-32 h-32 shrink-0">
                    <svg viewBox="0 0 36 36" class="w-32 h-32 -rotate-90">
                        <circle cx="18" cy="18" r="15.915" fill="none"
                            class="stroke-slate-100 dark:stroke-ink-800" stroke-width="3.5" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#4f46e5"
                            stroke-width="3.5" stroke-dasharray="{{ $incidentPercent }} 100" stroke-linecap="round" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10b981"
                            stroke-width="3.5" stroke-dasharray="{{ $medicationPercent }} 100"
                            stroke-dashoffset="-{{ $incidentPercent }}"
                            stroke-linecap="round" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f59e0b"
                            stroke-width="3.5" stroke-dasharray="{{ $abcChartPercent }} 100"
                            stroke-dashoffset="-{{ $incidentPercent + $medicationPercent }}"
                            stroke-linecap="round" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f43f5e"
                            stroke-width="3.5" stroke-dasharray="{{ $otherPercent }} 100"
                            stroke-dashoffset="-{{ $incidentPercent + $medicationPercent + $abcChartPercent }}"
                            stroke-linecap="round" />
                    </svg>
                    <div class="absolute inset-0 grid place-items-center text-center">
                        <div>
                            <div class="text-2xl font-bold leading-none">{{ $formsTotal }}</div>
                            <div class="text-[10px] text-slate-500 dark:text-ink-400 mt-1">Total</div>
                        </div>
                    </div>
                </div>
                <ul class="text-sm space-y-2 flex-1 w-full">
                    <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-brand-500"></span>Incident</span><span
                            class="font-medium">{{ $incidentCount }}</span></li>
                    <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-emerald-500"></span>Medication</span><span
                            class="font-medium">{{ $medicationCount }}</span></li>
                    <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-amber-500"></span>ABC chart</span><span
                            class="font-medium">{{ $abcChartCount }}</span></li>
                    <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-rose-500"></span>Other</span><span
                            class="font-medium">{{ $otherCount }}</span></li>
                </ul>
            </div>
        </div>

        {{-- <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold">My tasks</h3>
                    <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">3 pending</p>
                </div>
                <button class="text-xs font-medium text-brand-600 dark:text-brand-300">+ Add</button>
            </div>
            <ul class="space-y-2.5 text-sm">
                <li class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-ink-800"><input
                        type="checkbox"
                        class="mt-0.5 rounded border-slate-300 dark:border-ink-700 text-brand-600 dark:text-brand-300">
                    <div class="flex-1 min-w-0">
                        <div>Review incident <b>#IN-2042</b></div>
                        <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Due today · High</div>
                    </div><span
                        class="text-[10px] px-1.5 py-0.5 rounded bg-rose-50 dark:bg-rose-500/15 text-rose-600 dark:text-rose-300 font-semibold">HIGH</span>
                </li>
                <li class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-ink-800"><input
                        type="checkbox"
                        class="mt-0.5 rounded border-slate-300 dark:border-ink-700 text-brand-600 dark:text-brand-300">
                    <div class="flex-1 min-w-0">
                        <div>Approve onboarding — Lara B.</div>
                        <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Due tomorrow</div>
                    </div><span
                        class="text-[10px] px-1.5 py-0.5 rounded bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300 font-semibold">MED</span>
                </li>
                <li class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-ink-800"><input
                        type="checkbox"
                        class="mt-0.5 rounded border-slate-300 dark:border-ink-700 text-brand-600 dark:text-brand-300"
                        checked>
                    <div class="flex-1 min-w-0">
                        <div class="line-through text-slate-400 dark:text-ink-500">Close Perth Q2 survey</div>
                        <div class="text-xs text-slate-400 dark:text-ink-500 mt-0.5">Done · Yesterday</div>
                    </div>
                </li>
                <li class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-ink-800"><input
                        type="checkbox"
                        class="mt-0.5 rounded border-slate-300 dark:border-ink-700 text-brand-600 dark:text-brand-300">
                    <div class="flex-1 min-w-0">
                        <div>Send signature banner update</div>
                        <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">This week</div>
                    </div><span
                        class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300 font-semibold">LOW</span>
                </li>
            </ul>
        </div> --}}

        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800 md:col-span-2 lg:col-span-1">
            <h3 class="font-semibold mb-1">Quick actions</h3>
            <p class="text-xs text-slate-500 dark:text-ink-400 mb-4">Jump straight to common workflows</p>
            <div class="grid grid-cols-2 gap-3">
                <a href={{ route('forms.incident.index') }}
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/40 dark:hover:bg-brand-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-300 grid place-items-center mb-2 group-hover:bg-brand-600 group-hover:text-white transition">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Incident</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Report new</div>
                </a>
                <a href={{ route('forms.medication.index') }}
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-emerald-300 hover:bg-emerald-50/40 dark:hover:bg-emerald-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 grid place-items-center mb-2 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i data-lucide="pill" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Medication</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Log error</div>
                </a>
                <a href={{ route('forms.abc-monitoring-chart.index') }}
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-amber-300 hover:bg-amber-50/40 dark:hover:bg-amber-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-300 grid place-items-center mb-2 group-hover:bg-amber-600 group-hover:text-white transition">
                        <i data-lucide="line-chart" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">ABC chart</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Monitor</div>
                </a>
                <a href={{ url('forms/survey') }}
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-rose-300 hover:bg-rose-50/40 dark:hover:bg-rose-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/15 text-rose-600 dark:text-rose-300 grid place-items-center mb-2 group-hover:bg-rose-600 group-hover:text-white transition">
                        <i data-lucide="message-square-heart" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Survey</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Send out</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Public form links -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h3 class="font-semibold">Public form links</h3>
                <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Share these URLs with participants / staff</p>
            </div>
        </div>
        
    </div>

    <!-- Latest submissions (real data) -->
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
        <div class="p-5 flex items-center justify-between border-b border-slate-100 dark:border-ink-800">
            <div>
                <h3 class="font-semibold">Latest submissions</h3>
                <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Most recent forms across all types</p>
            </div>
            <a href="{{ route('forms.incident.index') }}"
               class="text-xs font-semibold text-brand-600 dark:text-brand-300 hover:text-brand-700 inline-flex items-center gap-1">
                View all <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        @if($latestSubmissions->isNotEmpty())

        {{-- Desktop table --}}
        <div class="hidden sm:block overflow-x-auto scrollbar-thin">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 dark:bg-ink-800/60 text-[11px] uppercase tracking-wider text-slate-500 dark:text-ink-400">
                    <tr>
                        <th class="text-left font-semibold px-5 py-3">Ref</th>
                        <th class="text-left font-semibold px-5 py-3">Type</th>
                        <th class="text-left font-semibold px-5 py-3">Submitted by</th>
                        <th class="text-left font-semibold px-5 py-3">Region</th>
                        <th class="text-left font-semibold px-5 py-3">Status</th>
                        <th class="text-left font-semibold px-5 py-3">When</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestSubmissions as $row)
                    @php
                        $typeColor = match($row['type']) {
                            'Incident'   => 'bg-brand-50 dark:bg-brand-500/15 text-brand-700 dark:text-brand-300',
                            'Medication' => 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300',
                            'ABC Chart'  => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                            default      => 'bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300',
                        };
                    @endphp
                    <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800/40 transition">
                        <td class="px-5 py-3 font-medium font-mono text-xs">{{ $row['ref'] }}</td>
                        <td class="px-5 py-3">
                            <span class="text-[11px] px-2 py-0.5 rounded-full font-semibold {{ $typeColor }}">
                                {{ $row['type'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3">{{ $row['name'] ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $row['city'] }}</td>
                        <td class="px-5 py-3">
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold">
                                Submitted
                            </span>
                        </td>
                        <td class="px-5 py-3 text-slate-500 dark:text-ink-400">
                            {{ $row['when'] ? $row['when']->diffForHumans() : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <ul class="sm:hidden divide-y divide-slate-100 dark:divide-ink-800">
            @foreach($latestSubmissions as $row)
            @php
                $typeColor = match($row['type']) {
                    'Incident'   => 'bg-brand-50 dark:bg-brand-500/15 text-brand-700 dark:text-brand-300',
                    'Medication' => 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300',
                    'ABC Chart'  => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                    default      => 'bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300',
                };
            @endphp
            <li class="p-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="font-semibold text-sm font-mono">{{ $row['ref'] }}</div>
                    <span class="text-[11px] px-2 py-0.5 rounded-full font-semibold {{ $typeColor }}">
                        {{ $row['type'] }}
                    </span>
                </div>
                <div class="mt-1 text-sm">{{ $row['name'] ?? '—' }}</div>
                <div class="mt-0.5 text-xs text-slate-500 dark:text-ink-400">
                    {{ $row['city'] }} · {{ $row['when'] ? $row['when']->diffForHumans() : '—' }}
                </div>
            </li>
            @endforeach
        </ul>

        @else
        <div class="flex flex-col items-center justify-center py-16 text-center text-slate-400 dark:text-ink-500">
            <i data-lucide="inbox" class="w-10 h-10 mb-3 opacity-40"></i>
            <p class="text-sm font-medium">No submissions yet</p>
            <p class="text-xs mt-1">Forms submitted will appear here automatically.</p>
        </div>
        @endif
    </div>

    <script>
        function copyUrl(id, btn) {
            const text = document.getElementById(id).textContent.trim();
            navigator.clipboard.writeText(text).then(function () {
                const icon = btn.querySelector('[data-lucide]');
                if (icon) { icon.setAttribute('data-lucide', 'check'); lucide.createIcons(); }
                setTimeout(function () {
                    if (icon) { icon.setAttribute('data-lucide', 'copy'); lucide.createIcons(); }
                }, 1800);
            });
        }
    </script>
@endsection
