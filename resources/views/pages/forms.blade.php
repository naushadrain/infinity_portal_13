{{--
|--------------------------------------------------------------------------
| Page: Forms Index
|--------------------------------------------------------------------------
| Searchable list of all submitted forms across types.
--}}
@extends('layouts.app', ['title' => 'Forms'])
@section('title','Forms')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <div>
    <h2 class="text-xl font-bold">Forms</h2>
    <p class="text-sm text-slate-500 dark:text-ink-400">5 results</p>
  </div>
  <div class="flex gap-2">
    <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Export</button>
    <a href="#" class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> New form</a>
  </div>
</div>
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
  <div class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
    <div class="flex items-center gap-2 flex-1 min-w-[200px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
      <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
      <input class="bg-transparent text-sm outline-none flex-1" placeholder="Search…">
    </div>
    
<select class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm"><option>All form types</option><option>Incident</option><option>Medication</option><option>ABC Monitoring</option></select>
<select class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm"><option>All states</option><option>Perth</option><option>Victoria</option></select>
<input type="date" class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">

  </div>
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full">
      <thead class="bg-slate-50 dark:bg-ink-800"><tr><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Ref</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Type</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Participant</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Status</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Location</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Submitted</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3"></th></tr></thead>
      <tbody><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">#IN-2042</td><td class="px-4 py-3 text-sm">Incident Report</td><td class="px-4 py-3 text-sm">Mark Webb</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Submitted</span></td><td class="px-4 py-3 text-sm">Perth</td><td class="px-4 py-3 text-sm">8 Jun 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">#MD-0114</td><td class="px-4 py-3 text-sm">Medication Error</td><td class="px-4 py-3 text-sm">Sophie L.</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300 font-medium">In review</span></td><td class="px-4 py-3 text-sm">Victoria</td><td class="px-4 py-3 text-sm">8 Jun 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">#AB-0571</td><td class="px-4 py-3 text-sm">ABC Monitoring</td><td class="px-4 py-3 text-sm">Tara N.</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Submitted</span></td><td class="px-4 py-3 text-sm">Perth</td><td class="px-4 py-3 text-sm">7 Jun 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">#IN-2041</td><td class="px-4 py-3 text-sm">Incident Report</td><td class="px-4 py-3 text-sm">Mark Webb</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Closed</span></td><td class="px-4 py-3 text-sm">Victoria</td><td class="px-4 py-3 text-sm">5 Jun 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">#MD-0113</td><td class="px-4 py-3 text-sm">Medication Error</td><td class="px-4 py-3 text-sm">Sophie L.</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Closed</span></td><td class="px-4 py-3 text-sm">Perth</td><td class="px-4 py-3 text-sm">4 Jun 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr></tbody>
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
