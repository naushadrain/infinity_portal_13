@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')

<div class="min-h-screen grid lg:grid-cols-2">

    {{-- Brand panel --}}
    <div class="hidden lg:flex relative bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-900 text-white p-12 flex-col justify-between overflow-hidden">
        <div class="absolute -top-32 -right-32 w-[28rem] h-[28rem] bg-brand-400/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-24 w-[26rem] h-[26rem] bg-indigo-500/20 rounded-full blur-3xl"></div>

        <div class="relative inline-flex items-center gap-3 bg-white rounded-xl px-4 py-2.5 shadow-lg w-fit">
            <img src="{{ asset('assets/logo.png') }}" alt="Infinite Ability" class="h-9 w-auto" />
        </div>

        <div class="relative space-y-7 max-w-md">
            <h2 class="text-4xl xl:text-5xl font-bold leading-tight tracking-tight">Operations that just work.</h2>
            <p class="text-white/80 text-base leading-relaxed">Manage staff, incidents, surveys and providers from one fast, modern workspace built for NDIS teams.</p>
            <ul class="space-y-3 text-sm text-white/90">
                <li class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                    </span>
                    Secure OTP-based password reset
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </span>
                    Code sent to your registered email
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </span>
                    Expires automatically in 10 minutes
                </li>
            </ul>
        </div>

        <div class="relative flex items-center justify-between text-xs text-white/60">
            <span>© Infinity Care · Perth · Victoria</span>
            <span class="inline-flex items-center gap-1.5">
                <i data-lucide="shield" class="w-3.5 h-3.5"></i> Secured
            </span>
        </div>
    </div>

    {{-- Form panel --}}
    <div class="flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-sm">

            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-ink-400 hover:text-slate-700 dark:hover:text-ink-200 transition mb-8">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to sign in
            </a>

            <div class="mb-8">
                <div class="w-12 h-12 rounded-xl bg-brand-50 dark:bg-brand-900/20 flex items-center justify-center mb-4">
                    <i data-lucide="key-round" class="w-6 h-6 text-brand-600 dark:text-brand-400"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Forgot your password?</h1>
                <p class="text-sm text-slate-500 dark:text-ink-400 mt-1.5">Enter your email and we'll send a 6-digit OTP to reset it.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-start gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-700 dark:text-red-300 flex items-start gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.sendOtp') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-ink-200 mb-1.5 uppercase tracking-wide">
                        Email address
                    </label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-white dark:bg-ink-900 border {{ $errors->has('email') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} focus:ring-4 outline-none transition"
                            placeholder="you@infinitycare.com.au"
                        />
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-soft transition flex items-center justify-center gap-2">
                    Send OTP <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </form>

            <p class="mt-8 text-xs text-slate-400 dark:text-ink-500 text-center flex items-center justify-center gap-1.5">
                <i data-lucide="shield" class="w-3.5 h-3.5"></i> OTP expires in 10 minutes for your security.
            </p>
        </div>
    </div>

</div>

@endsection
