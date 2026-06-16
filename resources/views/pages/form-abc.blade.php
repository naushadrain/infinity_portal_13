{{--
|--------------------------------------------------------------------------
| Page: ABC Form
|--------------------------------------------------------------------------
| Antecedent-Behavior-Consequence incident capture form.
--}}
@extends('layouts.app', ['title' => 'ABC Monitoring Chart'])
@section('title','ABC Monitoring Chart')
@section('content')
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Participant details</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-6"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Participant name</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-6"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Date of birth</label><div class="mt-1.5"><input type="date" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-12"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Participant address</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div></div>
</section>
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">ABC observation entries</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-12 overflow-x-auto">
        <table class="w-full text-sm border border-slate-200 dark:border-ink-800 rounded-lg overflow-hidden">
          <thead class="bg-slate-50 dark:bg-ink-800 text-xs text-slate-500 dark:text-ink-400 uppercase">
            <tr><th class="p-3 text-left">Date / time</th><th class="p-3 text-left">Antecedent (before)</th><th class="p-3 text-left">Behaviour (during)</th><th class="p-3 text-left">Consequence (after)</th><th class="p-3 text-left">Staff</th></tr>
          </thead>
          <tbody><tr class="border-t border-slate-100 dark:border-ink-800">
            <td class="p-2"><input type="datetime-local" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><input class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></td>
          </tr><tr class="border-t border-slate-100 dark:border-ink-800">
            <td class="p-2"><input type="datetime-local" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><input class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></td>
          </tr><tr class="border-t border-slate-100 dark:border-ink-800">
            <td class="p-2"><input type="datetime-local" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><textarea rows="2" class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></textarea></td>
            <td class="p-2"><input class="w-full px-2 py-1.5 rounded border border-slate-200 dark:border-ink-800 text-sm"></td>
          </tr></tbody></table>
        <button class="mt-3 text-sm text-brand-600 dark:text-brand-300 font-medium inline-flex items-center gap-1"><i data-lucide="plus" class="w-4 h-4"></i> Add row</button>
        </div></div>
</section>
<div class="flex justify-end gap-2 mb-10">
  <button class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium">Cancel</button>
  <button class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft">Submit chart</button>
</div>
@endsection
