{{--
|--------------------------------------------------------------------------
| Page: Surveys
|--------------------------------------------------------------------------
| List of surveys with response counts and status.
--}}
@extends('layouts.app', ['title' => 'Surveys'])
@section('title','Surveys')
@section('content')
<div class="flex gap-1 bg-slate-100 dark:bg-ink-800 p-1 rounded-lg w-fit mb-5">
  <button class="px-4 py-1.5 rounded-md bg-white dark:bg-ink-900 shadow-sm text-sm font-medium">All</button>
  <button class="px-4 py-1.5 rounded-md text-sm text-slate-600 dark:text-ink-300">Perth</button>
  <button class="px-4 py-1.5 rounded-md text-sm text-slate-600 dark:text-ink-300">Victoria</button>
  <button class="px-4 py-1.5 rounded-md text-sm text-slate-600 dark:text-ink-300">Staff</button>
  <button class="px-4 py-1.5 rounded-md text-sm text-slate-600 dark:text-ink-300">Client</button>
</div>
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <div>
    <h2 class="text-xl font-bold">Surveys</h2>
    <p class="text-sm text-slate-500 dark:text-ink-400">4 results</p>
  </div>
  <div class="flex gap-2">
    <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Export</button>
    <a href="survey-create.html" class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Create survey</a>
  </div>
</div>
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
  <div class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
    <div class="flex items-center gap-2 flex-1 min-w-[200px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
      <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
      <input class="bg-transparent text-sm outline-none flex-1" placeholder="Search…">
    </div>
    
  </div>
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full">
      <thead class="bg-slate-50 dark:bg-ink-800"><tr><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Title</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Audience</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Region</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Responses</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Status</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Closes</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3"></th></tr></thead>
      <tbody><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">Staff Wellbeing Q2</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-brand-50 dark:bg-brand-600/20 text-brand-700 dark:text-brand-300 font-medium">Staff</span></td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Perth</span></td><td class="px-4 py-3 text-sm">142 / 180</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Open</span></td><td class="px-4 py-3 text-sm">30 Jun 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">Client Satisfaction</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300 font-medium">Client</span></td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Victoria</span></td><td class="px-4 py-3 text-sm">89 / 120</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Open</span></td><td class="px-4 py-3 text-sm">15 Jul 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">Annual Staff Review</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-brand-50 dark:bg-brand-600/20 text-brand-700 dark:text-brand-300 font-medium">Staff</span></td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Perth</span></td><td class="px-4 py-3 text-sm">180 / 180</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Closed</span></td><td class="px-4 py-3 text-sm">1 Apr 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">NDIS Feedback</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300 font-medium">Client</span></td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Victoria</span></td><td class="px-4 py-3 text-sm">204 / 250</td><td class="px-4 py-3 text-sm"><span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-800 text-slate-600 dark:text-ink-300 font-medium">Closed</span></td><td class="px-4 py-3 text-sm">1 Mar 2026</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr></tbody>
    </table>
  </div>
  <div class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
    <div>Showing 1–4 of 4</div>
    <div class="flex gap-1">
      <button class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">Prev</button>
      <button class="px-3 py-1.5 rounded-md bg-brand-600 text-white">1</button>
      <button class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">2</button>
      <button class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800">Next</button>
    </div>
  </div>
</div>
@endsection
