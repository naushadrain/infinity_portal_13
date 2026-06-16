{{--
|--------------------------------------------------------------------------
| Component: status-badge
|--------------------------------------------------------------------------
| Pill badge that maps a status string to a semantic color.
--}}
@props(['status' => 'Submitted'])
@php
  $map = [
    'submitted' => 'emerald',
    'in review' => 'amber',
    'pending'   => 'amber',
    'closed'    => 'slate',
    'failed'    => 'rose',
  ];
  $key = strtolower(trim($status));
  $c = $map[$key] ?? 'slate';
@endphp
@if($c === 'slate')
  <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300 font-semibold">{{ $status }}</span>
@else
  <span class="text-[11px] px-2 py-0.5 rounded-full bg-{{ $c }}-50 dark:bg-{{ $c }}-500/15 text-{{ $c }}-700 dark:text-{{ $c }}-300 font-semibold">{{ $status }}</span>
@endif
