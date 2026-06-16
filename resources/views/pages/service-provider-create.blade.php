{{--
|--------------------------------------------------------------------------
| Page: New Service Provider
|--------------------------------------------------------------------------
| Form to register a new external service provider.
--}}
@extends('layouts.app', ['title' => 'Add Service Provider'])
@section('title','Add Service Provider')
@section('content')
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Provider details</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-8"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Provider name</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">ABN</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div></div>
</section>
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Services offered</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-12"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Select all that apply</label><div class="mt-1.5"><div class="grid sm:grid-cols-2 gap-2"><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Assessment Counselling and Therapy</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Assistance for Daily Activities</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>High intensity Support</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>SIL/STA/MTA</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Participate community</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Group recreation and leisure</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Support coordination</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Individual skill development and Coaching</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Assistive Technology</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Meal delivery</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Community Nursing</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>SDA</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Assist Employment</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Cleaning & Gardening</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Mental health services</span></label><label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-200 dark:border-ink-800 hover:border-brand-300 hover:bg-brand-50/30 cursor-pointer text-sm">
          <input type="checkbox" name="services[]" class="peer sr-only">
          <span class="chk-box w-4 h-4 rounded border border-slate-300 dark:border-ink-700 grid place-items-center"><svg class="w-3 h-3 text-white opacity-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></span>
          <span>Other</span></label></div></div></div></div>
</section>
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Location & contact</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>
  <div class="grid md:grid-cols-12 gap-4"><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">State</label><div class="mt-1.5"><select class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm"><option>Please select</option><option>WA</option><option>VIC</option><option>NSW</option><option>QLD</option><option>SA</option><option>TAS</option><option>NT</option><option>ACT</option></select></div></div><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">City</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Postcode</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-12"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Address</label><div class="mt-1.5"><input type="text" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Phone</label><div class="mt-1.5"><input type="tel" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Email</label><div class="mt-1.5"><input type="email" placeholder="" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div><div class="md:col-span-4"><label class="text-sm font-medium text-slate-700 dark:text-ink-200">Website</label><div class="mt-1.5"><input type="text" placeholder="https://" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm" /></div></div></div>
</section>
<div class="flex justify-end gap-2 mb-10">
  <button class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium">Cancel</button>
  <button class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft">Add provider</button>
</div>
@endsection
