{{--
|--------------------------------------------------------------------------
| Page: Service Providers
|--------------------------------------------------------------------------
| Directory of service providers with status and contact info.
--}}
@extends('layouts.app', ['title' => 'Service Providers'])
@section('title','Service Providers')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <div>
    <h2 class="text-xl font-bold">Service Providers</h2>
    <p class="text-sm text-slate-500 dark:text-ink-400">4 results</p>
  </div>
  <div class="flex gap-2">
    <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Export</button>
    <a href="service-provider-create.html" class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Add provider</a>
  </div>
</div>
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
  <div class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">
    <div class="flex items-center gap-2 flex-1 min-w-[200px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
      <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-ink-500"></i>
      <input class="bg-transparent text-sm outline-none flex-1" placeholder="Search…">
    </div>
    <select class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm"><option>All states</option><option>WA</option><option>VIC</option></select>
  </div>
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full">
      <thead class="bg-slate-50 dark:bg-ink-800"><tr><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Provider</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Services</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">State</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">City</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Phone</th><th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3"></th></tr></thead>
      <tbody><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">Sunrise Therapy</td><td class="px-4 py-3 text-sm">Assessment Counselling, Group recreation</td><td class="px-4 py-3 text-sm">WA</td><td class="px-4 py-3 text-sm">Perth</td><td class="px-4 py-3 text-sm">08 9123 4567</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">Bright Path Care</td><td class="px-4 py-3 text-sm">Assistance for Daily Activities, SIL/STA</td><td class="px-4 py-3 text-sm">VIC</td><td class="px-4 py-3 text-sm">Melbourne</td><td class="px-4 py-3 text-sm">03 9876 5432</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">NorthStar Allied Health</td><td class="px-4 py-3 text-sm">High Intensity Support, Community Nursing</td><td class="px-4 py-3 text-sm">WA</td><td class="px-4 py-3 text-sm">Joondalup</td><td class="px-4 py-3 text-sm">08 9555 1212</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr><tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:bg-ink-800"><td class="px-4 py-3 text-sm">Harmony Living</td><td class="px-4 py-3 text-sm">SDA, Cleaning & Gardening</td><td class="px-4 py-3 text-sm">VIC</td><td class="px-4 py-3 text-sm">Geelong</td><td class="px-4 py-3 text-sm">03 5222 1010</td><td class="px-4 py-3 text-sm"><div class="flex gap-1"><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="eye" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i></button><button class="p-1.5 rounded hover:bg-slate-100 dark:bg-ink-800"><i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i></button></div></td></tr></tbody>
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
