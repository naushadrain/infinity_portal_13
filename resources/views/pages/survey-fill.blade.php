{{--
|--------------------------------------------------------------------------
| Page: Fill Survey
|--------------------------------------------------------------------------
| Public-facing survey response form.
--}}
@extends('layouts.app', ['title' => 'Fill Survey'])
@section('title', 'Fill Survey')
@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
    <div class="h-2 bg-slate-100 dark:bg-ink-800"><div class="h-full w-1/3 bg-brand-600"></div></div>
    <div class="p-8">
      <div class="text-xs uppercase tracking-wider text-brand-600 dark:text-brand-300 font-semibold mb-2">Staff Wellbeing · Q2</div>
      <h2 class="text-2xl font-bold">How supported do you feel by your team this quarter?</h2>
      <p class="text-sm text-slate-500 dark:text-ink-400 mt-2">Question 3 of 9</p>
      <div class="mt-6 grid grid-cols-5 gap-2">
        <button class="py-4 rounded-xl border border-slate-200 dark:border-ink-800 hover:border-brand-500 hover:bg-brand-50 font-semibold">1</button><button class="py-4 rounded-xl border border-slate-200 dark:border-ink-800 hover:border-brand-500 hover:bg-brand-50 font-semibold">2</button><button class="py-4 rounded-xl border border-slate-200 dark:border-ink-800 hover:border-brand-500 hover:bg-brand-50 font-semibold">3</button><button class="py-4 rounded-xl border border-slate-200 dark:border-ink-800 hover:border-brand-500 hover:bg-brand-50 font-semibold">4</button><button class="py-4 rounded-xl border border-slate-200 dark:border-ink-800 hover:border-brand-500 hover:bg-brand-50 font-semibold">5</button>
      </div>
      <p class="mt-3 flex justify-between text-xs text-slate-500 dark:text-ink-400"><span>Not at all</span><span>Extremely</span></p>
      <div class="mt-8 flex justify-between">
        <button class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium">Back</button>
        <button class="px-5 py-2.5 rounded-lg bg-brand-600 text-white text-sm font-semibold">Next →</button>
      </div>
    </div>
  </div>
</div>
@endsection
