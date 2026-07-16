{{--
|--------------------------------------------------------------------------
| Page: Login
|--------------------------------------------------------------------------
| Public login screen for staff members.
--}}
@extends('layouts.auth')
@section('title', 'Sign In')
@section('content')
<div class="min-h-screen grid lg:grid-cols-2">
  <!-- Brand panel -->
  <div class="hidden lg:flex relative bg-gradient-to-br from-brand-600 via-brand-700 to-emerald-900 text-white p-12 flex-col justify-between overflow-hidden">
    <div class="absolute inset-0 grid-dots opacity-40"></div>
    <div class="absolute -top-32 -right-32 w-[28rem] h-[28rem] bg-brand-400/30 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -left-24 w-[26rem] h-[26rem] bg-emerald-500/20 rounded-full blur-3xl"></div>

    <div class="relative inline-flex items-center gap-3 bg-white rounded-xl px-4 py-2.5 shadow-lg w-fit">
      <img src={{asset('assets/logo.png')}} alt="Infinite Ability" class="h-9 w-auto" />
    </div>

    <div class="relative space-y-7 max-w-md">
      <h2 class="text-4xl xl:text-5xl font-bold leading-tight tracking-tight">Operations that just work.</h2>
      <p class="text-white/80 text-base leading-relaxed">Manage staff, incidents, surveys and providers from one fast, modern workspace built for NDIS teams.</p>
      <ul class="space-y-3 text-sm text-white/90">
        <li class="flex items-center gap-3"><span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center"><i data-lucide="check" class="w-4 h-4"></i></span>Incident & medication reporting</li>
        <li class="flex items-center gap-3"><span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center"><i data-lucide="check" class="w-4 h-4"></i></span>Staff & client surveys with PDF export</li>
        <li class="flex items-center gap-3"><span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center"><i data-lucide="check" class="w-4 h-4"></i></span>Activity logs & compliance ready reports</li>
      </ul>
    </div>

    <div class="relative flex items-center justify-between text-xs text-white/60">
      <span>© Infinity Ability</span>
    </div>
  </div>

  <!-- Form panel -->
  <div class="flex items-center justify-center p-6 sm:p-12">
    <div class="w-full max-w-sm">
      <div class="lg:hidden mb-8 flex justify-center">
        <img src="logo.png" alt="Infinite Ability" class="h-10 w-auto" />
      </div>

      <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Login</h1>
      </div>

      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Global error banner (e.g. inactive account) --}}
        @if ($errors->any() && ! $errors->has('email') && ! $errors->has('password'))
          <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-700 dark:text-red-300">
            {{ $errors->first() }}
          </div>
        @endif

        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-ink-200 mb-1.5 uppercase tracking-wide">Email</label>
          <div class="relative">
            <i data-lucide="mail" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              autocomplete="email"
              class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-white dark:bg-ink-900 border {{ $errors->has('email') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} focus:ring-4 outline-none transition"
              placeholder="you@infinityability.com.au"
            />
          </div>
          @error('email')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          
          <div class="relative">
            <i data-lucide="lock" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input
              id="pw"
              type="password"
              name="password"
              required
              autocomplete="current-password"
              class="w-full pl-10 pr-10 py-2.5 rounded-lg bg-white dark:bg-ink-900 border {{ $errors->has('password') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} focus:ring-4 outline-none transition"
              placeholder="••••••••"
            />
            <button type="button" onclick="var p=document.getElementById('pw');p.type=p.type==='password'?'text':'password';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600">
              <i data-lucide="eye" class="w-4 h-4"></i>
            </button>
          </div>
          @error('password')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-ink-300 select-none">
          <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-ink-700 text-brand-600 focus:ring-brand-500/30"> Keep me signed in
        </label>

        <button class="w-full py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-soft transition flex items-center justify-center gap-2">
          Sign in <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
      </form>

      
    </div>
  </div>
</div>


@endsection
