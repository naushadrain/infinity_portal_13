{{--
|--------------------------------------------------------------------------
| Page: Form View
|--------------------------------------------------------------------------
| Read-only display of a submitted form, including history and signatures.
--}}
@extends('layouts.app', ['title' => 'Incident Report — View'])
@section('title', 'Incident Report — View')
@section('content')
<div class="flex flex-wrap justify-between gap-3 mb-5">
  <div><h2 class="text-xl font-bold">Incident Report #IN-2042</h2><p class="text-sm text-slate-500 dark:text-ink-400">Submitted by James Kelly · 8 Jun 2026</p></div>
  <div class="flex gap-2">
    <button class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm flex items-center gap-2"><i data-lucide="printer" class="w-4 h-4"></i> Print</button>
    <button class="px-3 py-2 rounded-lg bg-brand-600 text-white text-sm font-medium flex items-center gap-2"><i data-lucide="file-down" class="w-4 h-4"></i> Export PDF</button>
  </div>
</div>
<div class="grid lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 space-y-6">
    <section class="bg-white dark:bg-ink-900 rounded-2xl p-6 shadow-soft border border-slate-100 dark:border-ink-800">
      <h3 class="font-semibold mb-4">Reporter</h3>
      <div class="grid grid-cols-2 gap-4"><div><div class="text-xs text-slate-500 dark:text-ink-400">Name</div><div class="text-sm font-medium mt-0.5">James Kelly</div></div><div><div class="text-xs text-slate-500 dark:text-ink-400">Position</div><div class="text-sm font-medium mt-0.5">Support Worker</div></div><div><div class="text-xs text-slate-500 dark:text-ink-400">Phone</div><div class="text-sm font-medium mt-0.5">+61 412 345 678</div></div><div><div class="text-xs text-slate-500 dark:text-ink-400">City</div><div class="text-sm font-medium mt-0.5">Perth</div></div></div>
    </section>
    <section class="bg-white dark:bg-ink-900 rounded-2xl p-6 shadow-soft border border-slate-100 dark:border-ink-800">
      <h3 class="font-semibold mb-4">Incident</h3>
      <div class="grid grid-cols-3 gap-4 mb-4"><div><div class="text-xs text-slate-500 dark:text-ink-400">Date</div><div class="text-sm font-medium mt-0.5">08/06/2026</div></div><div><div class="text-xs text-slate-500 dark:text-ink-400">Time</div><div class="text-sm font-medium mt-0.5">14:32</div></div><div><div class="text-xs text-slate-500 dark:text-ink-400">Type</div><div class="text-sm font-medium mt-0.5">Behaviour</div></div></div>
      <p class="text-sm text-slate-600 dark:text-ink-300 leading-relaxed">Participant became agitated during meal preparation. Staff used de-escalation techniques outlined in the behaviour support plan. No injuries sustained.</p>
    </section>
    <section class="bg-white dark:bg-ink-900 rounded-2xl p-6 shadow-soft border border-slate-100 dark:border-ink-800">
      <h3 class="font-semibold mb-4">Attachments</h3>
      <div class="grid sm:grid-cols-2 gap-3">
        <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-ink-800"><i data-lucide="file-text" class="w-5 h-5 text-rose-500"></i><div><div class="text-sm font-medium">witness-statement.pdf</div><div class="text-xs text-slate-500 dark:text-ink-400">214 KB</div></div></div>
        <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-ink-800"><i data-lucide="image" class="w-5 h-5 text-brand-500"></i><div><div class="text-sm font-medium">scene-photo.jpg</div><div class="text-xs text-slate-500 dark:text-ink-400">1.8 MB</div></div></div>
      </div>
    </section>
  </div>
  <div class="space-y-6">
    <section class="bg-white dark:bg-ink-900 rounded-2xl p-6 shadow-soft border border-slate-100 dark:border-ink-800">
      <h3 class="font-semibold mb-3">Status</h3>
      <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Submitted</span>
      <div class="mt-5 space-y-3 text-sm">
        <div class="flex justify-between"><span class="text-slate-500 dark:text-ink-400">Reportable</span><span class="font-medium">No</span></div>
        <div class="flex justify-between"><span class="text-slate-500 dark:text-ink-400">Manager</span><span class="font-medium">D. Wong</span></div>
        <div class="flex justify-between"><span class="text-slate-500 dark:text-ink-400">Location</span><span class="font-medium">Perth</span></div>
      </div>
    </section>
    <section class="bg-white dark:bg-ink-900 rounded-2xl p-6 shadow-soft border border-slate-100 dark:border-ink-800">
      <h3 class="font-semibold mb-3">Timeline</h3>
      <ol class="space-y-3 text-sm">
        <li class="flex gap-3"><div class="w-2 h-2 rounded-full bg-brand-500 mt-2"></div><div><div>Submitted</div><div class="text-xs text-slate-500 dark:text-ink-400">James K · 14:42</div></div></li>
        <li class="flex gap-3"><div class="w-2 h-2 rounded-full bg-amber-500 mt-2"></div><div><div>Manager assigned</div><div class="text-xs text-slate-500 dark:text-ink-400">D. Wong · 15:10</div></div></li>
        <li class="flex gap-3"><div class="w-2 h-2 rounded-full bg-slate-300 mt-2"></div><div><div>Investigation</div><div class="text-xs text-slate-500 dark:text-ink-400">pending</div></div></li>
      </ol>
    </section>
  </div>
</div>
@endsection
