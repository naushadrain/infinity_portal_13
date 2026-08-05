{{--
|--------------------------------------------------------------------------
| Page: Dashboard
|--------------------------------------------------------------------------
| KPI cards, Chart.js graph (Perth vs Victoria), donut and recent activity.
--}}
@extends('layouts.app', ['title' => 'Dashboard'])
@section('title', 'Dashboard')
@section('content')

    @php
        $hour = \Carbon\Carbon::now('Asia/Kathmandu')->hour;
        $greeting = match (true) {
            $hour < 12 => 'Good Morning',
            $hour < 17 => 'Good Afternoon',
            $hour < 20 => 'Good Evening',
            default => 'Good Night',
        };

    @endphp

    <!-- Greeting hero -->
    <section
        class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-900 dark:from-ink-900 dark:via-brand-900 dark:to-indigo-950 text-white p-5 sm:p-6 lg:p-8 mb-6 shadow-sm">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-10 w-72 h-72 bg-indigo-400/25 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-end justify-between gap-5">
            <div>
                <div class="text-[11px] uppercase tracking-[0.18em] text-white/80 dark:text-white/70 font-semibold">
                    {{ date('l · j F Y') }}
                </div>

                <h2 class="mt-2 text-xl sm:text-2xl lg:text-3xl font-bold leading-tight text-white">
                    {{ $greeting }}, {{ Auth::user()->name ?? 'User' }} 👋
                </h2>

                <p class="mt-1.5 text-sm text-white/80 dark:text-white/75 max-w-lg">
                    Showing data for <b class="text-white font-semibold">{{ $periodLabel }}</b> across all regions.
                </p>
            </div>

            <div
                class="flex items-center gap-1.5 p-1 bg-white/15 dark:bg-white/10 rounded-xl backdrop-blur ring-1 ring-white/25 dark:ring-white/15">
                <a href="{{ request()->fullUrlWithQuery(['period' => '30']) }}"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition
                    {{ $period === '30'
                        ? 'bg-white text-brand-700 dark:text-brand-800 shadow'
                        : 'text-white hover:bg-white/20 dark:hover:bg-white/15' }}">
                    Last 30 days
                </a>

                <a href="{{ request()->fullUrlWithQuery(['period' => 'all']) }}"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition
                    {{ $period === 'all'
                        ? 'bg-white text-brand-700 dark:text-brand-800 shadow'
                        : 'text-white hover:bg-white/20 dark:hover:bg-white/15' }}">
                    All time
                </a>
            </div>
        </div>
    </section>

    <!-- KPI period filter strip -->
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-slate-500 dark:text-ink-400">
            Showing: <span class="font-semibold text-slate-800 dark:text-white">{{ $periodLabel }}</span>
        </p>
        
    </div>

    <!-- KPI cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mb-6">

       

        {{-- 3. Incidents (period-based) --}}
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-300 grid place-items-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">{{ number_format($incidentCount) }}</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Incidents · {{ $periodLabel }}</div>
            <div class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-medium">{{ number_format($incidentCompletedCount) }} completed</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </div>

        {{-- 4. Medication (period-based) --}}
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-500/15 text-teal-600 dark:text-teal-300 grid place-items-center">
                    <i data-lucide="pill" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">{{ number_format($medicationCount) }}</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Medication · {{ $periodLabel }}</div>
            <div class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-medium">{{ number_format($medicationCompletedCount) }} completed</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#14b8a6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </div>

        {{-- 5. Feedback and Complaint (period-based) --}}
        <a href="{{ route('forms.complaint.index') }}"
            class="block bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-center justify-between">
                <div
                    class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-500/15 text-rose-600 dark:text-rose-300 grid place-items-center">
                    <i data-lucide="message-square-warning" class="w-5 h-5"></i>
                </div>
                @if ($feedbackChange !== null)
                    <span
                        class="text-[11px] px-2 py-0.5 rounded-full font-semibold flex items-center gap-1
                        {{ $feedbackChange >= 0
                            ? 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300'
                            : 'bg-rose-50 dark:bg-rose-500/15 text-rose-700 dark:text-rose-300' }}">
                        <i data-lucide="{{ $feedbackChange >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>
                        {{ $feedbackChange >= 0 ? '+' : '' }}{{ $feedbackChange }}%
                    </span>
                @endif
            </div>
            <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">{{ number_format($feedbackCount) }}</div>
            <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Feedback and Complaint · {{ $periodLabel }}</div>
            <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
                <polyline fill="none" stroke="#f43f5e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    points="0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4" />
            </svg>
        </a>

    </div>

    <!-- Chart + activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">

        {{-- Line chart: Form submissions by type --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h3 class="font-semibold">Form submissions</h3>
                    <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Incident · Medication over time
                    </p>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-ink-400 flex-wrap">
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>Incident</span>
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Medication</span>
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>Feedback</span>
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-violet-500"></span>Survey</span>
                    </div>
                    <div class="flex gap-0.5 p-0.5 bg-slate-100 dark:bg-ink-800 rounded-lg text-xs">
                        <button data-range="month"
                            class="range-tab px-3 py-1 rounded-md bg-white dark:bg-ink-700 shadow-sm font-medium">Month</button>
                        <button data-range="year"
                            class="range-tab px-3 py-1 rounded-md text-slate-500 dark:text-ink-400">Year</button>
                        <button data-range="all"
                            class="range-tab px-3 py-1 rounded-md text-slate-500 dark:text-ink-400">All</button>
                    </div>
                </div>
            </div>
            <div class="relative h-48 sm:h-60">
                <canvas id="submissionsChart"></canvas>
            </div>
        </div>

        {{-- Recent activity --}}
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
                        @php $dot = $dotColors[$i % count($dotColors)]; @endphp
                        <li class="relative pl-7">
                            <span
                                class="absolute left-0 top-1 w-3.5 h-3.5 rounded-full ring-4 {{ $dot }}"></span>
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

    <!-- Donut + Quick actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">

        {{-- Donut: Forms by type --}}
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <h3 class="font-semibold mb-1">Forms by type</h3>
            <p class="text-xs text-slate-500 dark:text-ink-400 mb-4">{{ $periodLabel }}</p>
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="relative w-32 h-32 shrink-0">
                    <svg viewBox="0 0 36 36" class="w-32 h-32 -rotate-90">
                        <circle cx="18" cy="18" r="15.915" fill="none"
                            class="stroke-slate-100 dark:stroke-ink-800" stroke-width="3.5" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#4f46e5"
                            stroke-width="3.5" stroke-dasharray="{{ $incidentPercent }} 100" stroke-linecap="round" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10b981"
                            stroke-width="3.5" stroke-dasharray="{{ $medicationPercent }} 100"
                            stroke-dashoffset="-{{ $incidentPercent }}" stroke-linecap="round" />
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f43f5e"
                            stroke-width="3.5" stroke-dasharray="{{ $otherPercent }} 100"
                            stroke-dashoffset="-{{ $incidentPercent + $medicationPercent }}" stroke-linecap="round" />
                    </svg>
                    <div class="absolute inset-0 grid place-items-center text-center">
                        <div>
                            <div class="text-2xl font-bold leading-none">{{ $formsTotal }}</div>
                            <div class="text-[10px] text-slate-500 dark:text-ink-400 mt-1">Total</div>
                        </div>
                    </div>
                </div>
                <ul class="text-sm space-y-2 flex-1 w-full">
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-brand-500"></span>Incident</span>
                        <span class="font-medium">{{ $incidentCount }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-emerald-500"></span>Medication</span>
                        <span class="font-medium">{{ $medicationCount }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2"><span
                                class="w-2 h-2 rounded-full bg-rose-500"></span>Feedback</span>
                        <span class="font-medium">{{ $otherCount }}</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Quick actions --}}
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <h3 class="font-semibold mb-1">Quick actions</h3>
            <p class="text-xs text-slate-500 dark:text-ink-400 mb-4">Jump straight to common workflows</p>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('forms.incident.index') }}"
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/40 dark:hover:bg-brand-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-300 grid place-items-center mb-2 group-hover:bg-brand-600 group-hover:text-white transition">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Incident</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Report new</div>
                </a>
                <a href="{{ route('forms.medication.index') }}"
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-emerald-300 hover:bg-emerald-50/40 dark:hover:bg-emerald-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 grid place-items-center mb-2 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i data-lucide="pill" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Medication</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Log error</div>
                </a>
                <a href="{{ url('forms/survey') }}"
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-rose-300 hover:bg-rose-50/40 dark:hover:bg-rose-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/15 text-rose-600 dark:text-rose-300 grid place-items-center mb-2 group-hover:bg-rose-600 group-hover:text-white transition">
                        <i data-lucide="message-square-heart" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Survey</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">Send out</div>
                </a>
                <a href="{{ route('forms.complaint.index') }}"
                    class="group p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-rose-300 hover:bg-rose-50/40 dark:hover:bg-rose-500/10 transition">
                    <div
                        class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/15 text-rose-600 dark:text-rose-300 grid place-items-center mb-2 group-hover:bg-rose-600 group-hover:text-white transition">
                        <i data-lucide="message-square-warning" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-sm">Feedback</div>
                    <div class="text-[11px] text-slate-500 dark:text-ink-400 mt-0.5">View all</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Form Status + Complaint status pie chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">

        {{-- Status --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <h3 class="font-semibold mb-1">Status</h3>
            <p class="text-xs text-slate-500 dark:text-ink-400 mb-4">Active vs completed, all time</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <a href="{{ route('forms.incident.index') }}"
                    class="p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/40 dark:hover:bg-brand-500/10 transition">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-brand-500"></i>
                        <span class="text-sm font-semibold">Incident</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <div>
                            <div class="text-xs text-amber-600 dark:text-amber-400 font-medium">Active</div>
                            <div class="text-xl font-bold mt-0.5">{{ number_format($incidentActiveCount) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Completed</div>
                            <div class="text-xl font-bold mt-0.5">{{ number_format($incidentStatusCompleted) }}</div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('forms.medication.index') }}"
                    class="p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-teal-300 hover:bg-teal-50/40 dark:hover:bg-teal-500/10 transition">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="pill" class="w-4 h-4 text-teal-500"></i>
                        <span class="text-sm font-semibold">Medication</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <div>
                            <div class="text-xs text-amber-600 dark:text-amber-400 font-medium">Active</div>
                            <div class="text-xl font-bold mt-0.5">{{ number_format($medicationActiveCount) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Completed</div>
                            <div class="text-xl font-bold mt-0.5">{{ number_format($medicationStatusCompleted) }}</div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('forms.complaint.index') }}"
                    class="p-4 rounded-xl border border-slate-100 dark:border-ink-800 hover:border-rose-300 hover:bg-rose-50/40 dark:hover:bg-rose-500/10 transition">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="message-square-warning" class="w-4 h-4 text-rose-500"></i>
                        <span class="text-sm font-semibold">Feedback and Complaint</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <div>
                            <div class="text-xs text-amber-600 dark:text-amber-400 font-medium">Active</div>
                            <div class="text-xl font-bold mt-0.5">{{ number_format($complaintActiveCount) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Completed</div>
                            <div class="text-xl font-bold mt-0.5">{{ number_format($complaintStatusCompleted) }}</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Complaint status pie chart --}}
        <div
            class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-6 shadow-soft border border-slate-100 dark:border-ink-800">
            <h3 class="font-semibold mb-1">Complaint status</h3>
            <p class="text-xs text-slate-500 dark:text-ink-400 mb-4">New · In Progress · Closed, all time</p>
            @if ($complaintStatusTotal > 0)
                <div class="flex flex-col items-center gap-5">
                    <div class="relative w-32 h-32 shrink-0">
                        <svg viewBox="0 0 36 36" class="w-32 h-32 -rotate-90">
                            <circle cx="18" cy="18" r="15.915" fill="none"
                                class="stroke-slate-100 dark:stroke-ink-800" stroke-width="3.5" />
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#0ea5e9"
                                stroke-width="3.5" stroke-dasharray="{{ $complaintStatusPercents['new'] }} 100"
                                stroke-linecap="round" />
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f59e0b"
                                stroke-width="3.5" stroke-dasharray="{{ $complaintStatusPercents['in_progress'] }} 100"
                                stroke-dashoffset="-{{ $complaintStatusPercents['new'] }}" stroke-linecap="round" />
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10b981"
                                stroke-width="3.5" stroke-dasharray="{{ $complaintStatusPercents['closed'] }} 100"
                                stroke-dashoffset="-{{ $complaintStatusPercents['new'] + $complaintStatusPercents['in_progress'] }}"
                                stroke-linecap="round" />
                        </svg>
                        <div class="absolute inset-0 grid place-items-center text-center">
                            <div>
                                <div class="text-2xl font-bold leading-none">{{ $complaintStatusTotal }}</div>
                                <div class="text-[10px] text-slate-500 dark:text-ink-400 mt-1">Total</div>
                            </div>
                        </div>
                    </div>
                    <ul class="text-sm space-y-2 w-full">
                        <li class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span
                                    class="w-2 h-2 rounded-full bg-sky-500"></span>New</span>
                            <span class="font-medium">{{ $complaintStatusCounts['new'] }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span
                                    class="w-2 h-2 rounded-full bg-amber-500"></span>In Progress</span>
                            <span class="font-medium">{{ $complaintStatusCounts['in_progress'] }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span
                                    class="w-2 h-2 rounded-full bg-emerald-500"></span>Closed</span>
                            <span class="font-medium">{{ $complaintStatusCounts['closed'] }}</span>
                        </li>
                    </ul>
                </div>
            @else
                <div
                    class="flex flex-col items-center justify-center py-8 text-center text-sm text-slate-400 dark:text-ink-500">
                    <i data-lucide="pie-chart" class="w-8 h-8 mb-2 opacity-40"></i>
                    <p>No complaints yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Latest submissions -->
    <div
        class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
        <div class="p-5 flex items-center justify-between border-b border-slate-100 dark:border-ink-800">
            <div>
                <h3 class="font-semibold">Latest submissions</h3>
                <p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">Most recent forms across all types</p>
            </div>
            <a href="{{ route('forms.incident.index') }}" aria-label="View all submissions"
                class="text-xs font-semibold text-brand-600 dark:text-brand-300 hover:text-brand-700 inline-flex items-center gap-1">
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        @if ($latestSubmissions->isNotEmpty())
            {{-- Desktop table --}}
            <div class="hidden sm:block overflow-x-auto scrollbar-thin">
                <table class="w-full text-sm">
                    <thead
                        class="bg-slate-50 dark:bg-ink-800/60 text-[11px] uppercase tracking-wider text-slate-500 dark:text-ink-400">
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
                        @foreach ($latestSubmissions as $row)
                            @php
                                $typeColor = match ($row['type']) {
                                    'Incident' => 'bg-brand-50 dark:bg-brand-500/15 text-brand-700 dark:text-brand-300',
                                    'Medication'
                                        => 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300',
                                    default => 'bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300',
                                };
                            @endphp
                            <tr
                                class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800/40 transition">
                                <td class="px-5 py-3 font-medium font-mono text-xs">{{ $row['ref'] }}</td>
                                <td class="px-5 py-3">
                                    <span
                                        class="text-[11px] px-2 py-0.5 rounded-full font-semibold {{ $typeColor }}">{{ $row['type'] }}</span>
                                </td>
                                <td class="px-5 py-3">{{ $row['name'] ?? '—' }}</td>
                                <td class="px-5 py-3">{{ $row['city'] }}</td>
                                <td class="px-5 py-3">
                                    <span
                                        class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold">Submitted</span>
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
                @foreach ($latestSubmissions as $row)
                    @php
                        $typeColor = match ($row['type']) {
                            'Incident' => 'bg-brand-50 dark:bg-brand-500/15 text-brand-700 dark:text-brand-300',
                            'Medication'
                                => 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300',
                            default => 'bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300',
                        };
                    @endphp
                    <li class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="font-semibold text-sm font-mono">{{ $row['ref'] }}</div>
                            <span
                                class="text-[11px] px-2 py-0.5 rounded-full font-semibold {{ $typeColor }}">{{ $row['type'] }}</span>
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

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            // ── Chart.js: Perth vs Victoria submissions ───────────────────────────────
            const raw = @json($chartData);

            const isDark = () => document.documentElement.classList.contains('dark');

            const gridColor = () => isDark() ? 'rgba(255,255,255,.06)' : 'rgba(0,0,0,.06)';
            const labelColor = () => isDark() ? '#94a3b8' : '#64748b';

            const chartCtx = document.getElementById('submissionsChart').getContext('2d');

            const chart = new Chart(chartCtx, {
                type: 'line',
                data: {
                    labels: raw.month.labels,
                    datasets: [{
                            label: 'Incident',
                            data: raw.month.incident,
                            borderColor: '#eab308',
                            backgroundColor: 'rgba(234,179,8,.10)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            borderWidth: 2.5,
                        },
                        {
                            label: 'Medication',
                            data: raw.month.medication,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16,185,129,.08)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            borderWidth: 2.5,
                        },
                        {
                            label: 'Feedback',
                            data: raw.month.feedback,
                            borderColor: '#f43f5e',
                            backgroundColor: 'rgba(244,63,94,.08)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            borderWidth: 2.5,
                        },
                        {
                            label: 'Survey',
                            data: raw.month.survey,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139,92,246,.08)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            borderWidth: 2.5,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}`
                            }
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: labelColor,
                                font: {
                                    size: 11
                                }
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: labelColor,
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: gridColor
                            },
                        },
                    },
                },
            });

            // ── Range tabs ────────────────────────────────────────────────────────────
            document.querySelectorAll('.range-tab').forEach(btn => {
                btn.addEventListener('click', function() {
                    const range = this.dataset.range;

                    chart.data.labels = raw[range].labels;
                    chart.data.datasets[0].data = raw[range].incident;
                    chart.data.datasets[1].data = raw[range].medication;
                    chart.data.datasets[2].data = raw[range].feedback;
                    chart.data.datasets[3].data = raw[range].survey;
                    chart.update();

                    document.querySelectorAll('.range-tab').forEach(b => {
                        const active = b === this;
                        b.classList.toggle('bg-white', active);
                        b.classList.toggle('dark:bg-ink-700', active);
                        b.classList.toggle('shadow-sm', active);
                        b.classList.toggle('font-medium', active);
                        b.classList.toggle('text-slate-500', !active);
                        b.classList.toggle('dark:text-ink-400', !active);
                    });
                });
            });

            // ── Dropdown menus ────────────────────────────────────────────────────────
            function closeAll() {
                document.querySelectorAll('[id$="-menu"]').forEach(m => m.classList.add('hidden'));
            }

            document.querySelectorAll('[data-dropdown]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const menu = document.getElementById(this.dataset.dropdown);
                    const wasHidden = menu.classList.contains('hidden');
                    closeAll();
                    if (wasHidden) {
                        menu.classList.remove('hidden');
                        lucide.createIcons();
                    }
                });
            });

            document.addEventListener('click', closeAll);
        })();
    </script>
@endpush
