{{--
|--------------------------------------------------------------------------
| Page: Activity Logs
|--------------------------------------------------------------------------
| Audit trail of user/system events with filters and pagination.
--}}
@extends('layouts.app', ['title' => 'Activity Logs'])
@section('title','Activity Logs')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <div>
    <h2 class="text-xl font-bold">Activity Logs</h2>
    <p class="text-sm text-slate-500 dark:text-ink-400">5 results</p>
  </div>
  <div class="flex gap-2">
    <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Export</button>
    <a href="#" class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Export logs</a>
  </div>
</div>
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
  <div class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
    <div class="flex items-center gap-2 flex-1 min-w-[200px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
      <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
      <input class="bg-transparent text-sm outline-none flex-1" placeholder="Search…">
    </div>
    <select class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm"><option>All users</option></select><input type="date" class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
  </div>
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full">
      <thead class="bg-slate-50 dark:bg-ink-800"><tr><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">User</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Action</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Route</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">IP</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">When</th></tr></thead>
      <tbody><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 dark:text-brand-300 grid place-items-center font-semibold text-xs">SM</div><div><div class="font-medium">Sarah Mitchell</div></div></div></td><td class="px-4 py-3 text-sm">Logged in</td><td class="px-4 py-3 text-sm">/dashboard</td><td class="px-4 py-3 text-sm">203.45.12.9</td><td class="px-4 py-3 text-sm">Just now</td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 dark:text-brand-300 grid place-items-center font-semibold text-xs">JK</div><div><div class="font-medium">James Kelly</div></div></div></td><td class="px-4 py-3 text-sm">Submitted incident #IN-2042</td><td class="px-4 py-3 text-sm">/forms/incident</td><td class="px-4 py-3 text-sm">10.1.1.4</td><td class="px-4 py-3 text-sm">12 min ago</td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 dark:text-brand-300 grid place-items-center font-semibold text-xs">PS</div><div><div class="font-medium">Priya Sharma</div></div></div></td><td class="px-4 py-3 text-sm">Updated profile</td><td class="px-4 py-3 text-sm">/profile</td><td class="px-4 py-3 text-sm">10.1.1.7</td><td class="px-4 py-3 text-sm">1 h ago</td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 dark:text-brand-300 grid place-items-center font-semibold text-xs">DW</div><div><div class="font-medium">Daniel Wong</div></div></div></td><td class="px-4 py-3 text-sm">Created service provider</td><td class="px-4 py-3 text-sm">/providers</td><td class="px-4 py-3 text-sm">10.1.1.10</td><td class="px-4 py-3 text-sm">3 h ago</td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 dark:text-brand-300 grid place-items-center font-semibold text-xs">SM</div><div><div class="font-medium">Sarah Mitchell</div></div></div></td><td class="px-4 py-3 text-sm">Exported report</td><td class="px-4 py-3 text-sm">/reports</td><td class="px-4 py-3 text-sm">203.45.12.9</td><td class="px-4 py-3 text-sm">Yesterday</td></tr></tbody>
    </table>
  </div>
  <div class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
    <div>Showing 1–5 of 5</div>
    <div class="flex gap-1">
      <button class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">Prev</button>
      <button class="px-3 py-1.5 rounded-md bg-brand-600 text-white">1</button>
      <button class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">2</button>
      <button class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">Next</button>
    </div>
  </div>
</div>
@endsection
