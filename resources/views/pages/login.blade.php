{{--
|--------------------------------------------------------------------------
| Page: Login
|--------------------------------------------------------------------------
| Public login screen for staff members.
--}}
@extends('layouts.auth')
@section('title','Sign in')
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
      <span>© Infinity Care · Perth · Victoria</span>
      <span class="inline-flex items-center gap-1.5"><i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Secure sign in</span>
    </div>
  </div>

  <!-- Form panel -->
  <div class="flex items-center justify-center p-6 sm:p-12">
    <div class="w-full max-w-sm">
      <div class="lg:hidden mb-8 flex justify-center">
        <img src="logo.png" alt="Infinite Ability" class="h-10 w-auto" />
      </div>

      <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Welcome back</h1>
        <p class="text-sm text-slate-500 dark:text-ink-400 mt-1.5">Sign in to your Infinity workspace.</p>
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
              placeholder="you@infinitycare.com.au"
            />
          </div>
          @error('email')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <div class="flex justify-between items-center mb-1.5">
            <label class="text-xs font-semibold text-slate-700 dark:text-ink-200 uppercase tracking-wide">Password</label>
            <a href="{{ route('password.request') }}" class="text-brand-600 dark:text-brand-300 hover:underline text-xs font-medium">Forgot?</a>
          </div>
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

      <div class="relative my-6 text-center">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200 dark:border-ink-800"></div></div>
        <span class="relative bg-[#f6f7fb] dark:bg-[#0b1220] px-3 text-xs text-slate-400">or</span>
      </div>

      <button type="button" class="w-full py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 hover:bg-slate-50 dark:hover:bg-ink-800 text-sm font-medium flex items-center justify-center gap-2">
        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.99.66-2.25 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84C6.71 7.31 9.14 5.38 12 5.38z"/></svg>
        Continue with Google
      </button>

      <p class="mt-8 text-xs text-slate-400 dark:text-ink-500 text-center flex items-center justify-center gap-1.5">
        <i data-lucide="shield" class="w-3.5 h-3.5"></i> Protected by activity logging. Unauthorised access is monitored.
      </p>
    </div>
  </div>
</div>


@endsection
