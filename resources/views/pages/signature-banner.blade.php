{{--
|--------------------------------------------------------------------------
| Page: Signature Banner
|--------------------------------------------------------------------------
| Manage the global signature banner shown on printed/exported forms.
--}}
@extends('layouts.app', ['title' => 'Signature & Banner'])
@section('title','Signature & Banner')
@section('content')
<div class="grid lg:grid-cols-3 gap-6">
  <section class="lg:col-span-2 bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
    <h3 class="font-semibold mb-1">Email signature & banner</h3>
    <p class="text-sm text-slate-500 dark:text-ink-400 mb-5">Updates apply to all outgoing system emails.</p>
    <div class="space-y-4">
      <div><label class="text-sm font-medium">Signature text</label>
        <textarea rows="5" class="mt-1.5 w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm">Kind regards,
Infinity Care Team
1300 000 000 · infinitycare.com.au</textarea></div>
      <div><label class="text-sm font-medium">Banner image</label>
        <div class="mt-1.5 border-2 border-dashed border-slate-200 dark:border-ink-800 rounded-xl p-8 text-center">
          <i data-lucide="image-up" class="w-8 h-8 text-slate-400 dark:text-ink-500 mx-auto"></i>
          <p class="text-sm mt-2"><b class="text-brand-600 dark:text-brand-300">Click to upload</b> or drag and drop</p>
          <p class="text-xs text-slate-500 dark:text-ink-400">PNG, JPG up to 2 MB · recommended 1200×300</p>
        </div>
      </div>
    </div>
    <div class="flex justify-end gap-2 mt-6">
      <button class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 text-sm font-medium">Cancel</button>
      <button class="px-5 py-2.5 rounded-lg bg-brand-600 text-white text-sm font-semibold">Save changes</button>
    </div>
  </section>
  <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
    <h3 class="font-semibold mb-3">Preview</h3>
    <div class="rounded-xl border border-slate-200 dark:border-ink-800 overflow-hidden">
      <div class="aspect-[4/1] bg-gradient-to-r from-brand-600 to-indigo-700 grid place-items-center text-white text-sm font-medium">Banner preview</div>
      <div class="p-4 text-sm text-slate-600 dark:text-ink-300 whitespace-pre-line">Kind regards,
Infinity Care Team
1300 000 000 · infinitycare.com.au</div>
    </div>
  </section>
</div>
@endsection
