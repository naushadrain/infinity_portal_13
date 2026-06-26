{{--
|--------------------------------------------------------------------------
| Page: Activity Logs
|--------------------------------------------------------------------------
| Audit trail of user/system events with filters and pagination.
--}}
@extends('layouts.app', ['title' => 'Activity Logs'])
@section('title', 'Activity Logs')
@section('content')

@php
$eventLabels = [
    'login'                     => ['label' => 'Login',              'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300'],
    'logout'                    => ['label' => 'Logout',             'class' => 'bg-slate-100 text-slate-600 dark:bg-ink-800 dark:text-ink-300'],
    'incident.submitted'        => ['label' => 'Incident Form',      'class' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-300'],
    'medication.submitted'      => ['label' => 'Medication Form',    'class' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/15 dark:text-purple-300'],
    'abc.submitted'             => ['label' => 'ABC Chart',          'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300'],
    'public.incident.submitted' => ['label' => 'Public Incident',    'class' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-300'],
    'customer.survey.submitted' => ['label' => 'Customer Survey',    'class' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/15 dark:text-cyan-300'],
];
@endphp

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-bold">ALl Users Activity Management</h2>
        <p class="text-sm text-slate-500 dark:text-ink-400">{{ number_format($total) }} total {{ Str::plural('entry', $total) }}</p>
    </div>
</div>

<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">

    {{-- Filters --}}
    <form method="GET" action="{{ route('activity.index') }}" class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
        <div class="flex items-center gap-2 flex-1 min-w-[200px] max-w-[400px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500 shrink-0"></i>
            <input name="search" value="{{ request('search') }}" class="bg-transparent text-sm outline-none flex-1" placeholder="Search user, event, description…">
        </div>
        <input name="date" type="date" value="{{ request('date') }}" class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
        <button type="submit" class="px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Filter</button>
        @if(request('search') || request('date'))
            <a href="{{ route('activity.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 dark:border-ink-800 text-sm">Clear</a>
        @endif
    </form>

    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-ink-800">
                <tr>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">User</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Event</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Description</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">IP</th>
                    <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">When</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                @php
                    $initials = collect(explode(' ', $log->user_name ?? 'Guest'))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                    $badge    = $eventLabels[$log->event] ?? ['label' => $log->event, 'class' => 'bg-slate-100 text-slate-600 dark:bg-ink-800 dark:text-ink-300'];
                @endphp
                <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800/50">
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300 grid place-items-center font-semibold text-xs shrink-0">
                                {{ $initials }}
                            </div>
                            <div>
                                <div class="font-medium">{{ $log->user_name ?? 'Guest' }}</div>
                                @if($log->user_id)
                                    <div class="text-xs text-slate-400 dark:text-ink-500">ID #{{ $log->user_id }}</div>
                                @else
                                    <div class="text-xs text-slate-400 dark:text-ink-500">Public</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300 max-w-xs">{{ $log->description }}</td>
                    <td class="px-4 py-3 text-sm text-slate-500 dark:text-ink-400 font-mono">{{ $log->ip_address ?? '—' }}</td>
                    <td class="px-4 py-3 text-sm text-slate-500 dark:text-ink-400 whitespace-nowrap" title="{{ $log->created_at->format('d M Y H:i') }}">
                        {{ $log->created_at->diffForHumans() }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <form method="POST" action="{{ route('activity.destroy', $log->id) }}" onsubmit="return confirm('Delete this log entry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-500 dark:text-ink-500 dark:hover:text-red-400 transition" title="Delete">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-400 dark:text-ink-500">
                        No activity logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
        <div>Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }}</div>
        <div class="flex gap-1">
            {{ $logs->onEachSide(1)->links('pagination::simple-tailwind') }}
        </div>
    </div>
</div>

@endsection
