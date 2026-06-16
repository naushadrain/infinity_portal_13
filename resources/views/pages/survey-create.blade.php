{{--
|--------------------------------------------------------------------------
| Page: New Survey
|--------------------------------------------------------------------------
| Builder for creating a new survey with question types.
--}}
@extends('layouts.app', ['title' => 'Create survey'])
@section('title','Create survey')
@section('content')
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Basics</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-8"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Survey title</label><div class="mt-1.5"><input type="text" placeholder="e.g. Q3 staff wellbeing" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-2"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Audience</label><div class="mt-1.5"><select class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"><option>Staff</option><option>Client</option></select></div></div><div class="md:col-span-2"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Region</label><div class="mt-1.5"><select class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"><option>Perth</option><option>Victoria</option><option>Both</option></select></div></div><div class="md:col-span-12"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Description</label><div class="mt-1.5"><textarea rows="3" placeholder="Short description shown to respondents…" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"></textarea></div></div><div class="md:col-span-6"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Opens</label><div class="mt-1.5"><input type="date" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-6"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Closes</label><div class="mt-1.5"><input type="date" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div></div>
</section>
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Questions</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-12 space-y-3">
          <div class="p-4 border border-slate-200 dark:border-ink-800 rounded-xl">
            <div class="flex items-center justify-between mb-2"><span class="text-xs font-semibold text-slate-500 dark:text-ink-400">QUESTION 1</span><select class="text-xs px-2 py-1 rounded border border-slate-200 dark:border-ink-800"><option>Short answer</option><option>Long answer</option><option>Multiple choice</option><option>Rating 1–5</option></select></div>
            <input class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 text-sm" placeholder="Type question here">
          </div>
          <div class="p-4 border border-slate-200 dark:border-ink-800 rounded-xl">
            <div class="flex items-center justify-between mb-2"><span class="text-xs font-semibold text-slate-500 dark:text-ink-400">QUESTION 2</span><select class="text-xs px-2 py-1 rounded border border-slate-200 dark:border-ink-800"><option>Rating 1–5</option></select></div>
            <input class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 text-sm" placeholder="Type question here">
          </div>
          <button class="w-full py-3 rounded-xl border-2 border-dashed border-slate-200 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400 hover:border-brand-400 hover:text-brand-600 dark:text-brand-300 inline-flex items-center justify-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Add question</button>
        </div></div>
</section>
<div class="flex justify-end gap-2 mb-10">
  <button class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium">Cancel</button>
  <button class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft">Publish survey</button>
</div>
@endsection
