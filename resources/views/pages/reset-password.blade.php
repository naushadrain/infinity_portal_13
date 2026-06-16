@extends('layouts.auth')
@section('title', 'Set new password')
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
            <h2 class="text-4xl xl:text-5xl font-bold leading-tight tracking-tight">Almost there.</h2>
            <p class="text-white/80 text-base leading-relaxed">Set a strong new password to secure your Infinity workspace.</p>
            <ul class="space-y-3 text-sm text-white/90">
                <li class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </span>
                    At least 8 characters
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </span>
                    Include a number or symbol
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </span>
                    Avoid reusing old passwords
                </li>
            </ul>
        </div>

        <div class="relative flex items-center justify-between text-xs text-white/60">
            <span>© Infinity Care · Perth · Victoria</span>
            <span class="inline-flex items-center gap-1.5">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Secured
            </span>
        </div>
    </div>

    {{-- Form panel --}}
    <div class="flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-sm">

            <div class="mb-8">
                <div class="w-12 h-12 rounded-xl bg-brand-50 dark:bg-brand-900/20 flex items-center justify-center mb-4">
                    <i data-lucide="lock-keyhole" class="w-6 h-6 text-brand-600 dark:text-brand-400"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Set a new password</h1>
                <p class="text-sm text-slate-500 dark:text-ink-400 mt-1.5">Make it at least 8 characters.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-700 dark:text-red-300 flex items-start gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5" id="reset-form">
                @csrf

                {{-- New password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-ink-200 mb-1.5 uppercase tracking-wide">
                        New password
                    </label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            id="pw"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            oninput="checkStrength(this.value); checkMatch();"
                            class="w-full pl-10 pr-10 py-2.5 rounded-lg bg-white dark:bg-ink-900 border {{ $errors->has('password') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} focus:ring-4 outline-none transition"
                            placeholder="••••••••"
                        />
                        <button type="button" onclick="togglePw('pw','eye-pw')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600">
                            <i id="eye-pw" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>

                    {{-- Strength bar --}}
                    <div class="mt-2 space-y-1">
                        <div class="flex gap-1">
                            <div id="bar-1" class="h-1 flex-1 rounded-full bg-slate-200 dark:bg-ink-700 transition-all"></div>
                            <div id="bar-2" class="h-1 flex-1 rounded-full bg-slate-200 dark:bg-ink-700 transition-all"></div>
                            <div id="bar-3" class="h-1 flex-1 rounded-full bg-slate-200 dark:bg-ink-700 transition-all"></div>
                            <div id="bar-4" class="h-1 flex-1 rounded-full bg-slate-200 dark:bg-ink-700 transition-all"></div>
                        </div>
                        <p id="strength-label" class="text-xs text-slate-400 dark:text-ink-500"></p>
                    </div>

                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-ink-200 mb-1.5 uppercase tracking-wide">
                        Confirm password
                    </label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            id="pw2"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            oninput="checkMatch();"
                            class="w-full pl-10 pr-10 py-2.5 rounded-lg bg-white dark:bg-ink-900 border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10 focus:ring-4 outline-none transition"
                            placeholder="••••••••"
                        />
                        <button type="button" onclick="togglePw('pw2','eye-pw2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600">
                            <i id="eye-pw2" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p id="match-msg" class="mt-1.5 text-xs hidden"></p>
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-soft transition flex items-center justify-center gap-2">
                    Update password <i data-lucide="check" class="w-4 h-4"></i>
                </button>
            </form>

        </div>
    </div>

</div>

<script>
function togglePw(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon  = document.getElementById(iconId);
    var show  = input.type === 'password';
    input.type = show ? 'text' : 'password';
    icon.setAttribute('data-lucide', show ? 'eye-off' : 'eye');
    lucide.createIcons();
}

function checkStrength(val) {
    var score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    var colors = ['', 'bg-red-400', 'bg-amber-400', 'bg-yellow-400', 'bg-green-500'];
    var labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];

    for (var i = 1; i <= 4; i++) {
        var bar = document.getElementById('bar-' + i);
        bar.className = 'h-1 flex-1 rounded-full transition-all ' + (i <= score ? colors[score] : 'bg-slate-200 dark:bg-ink-700');
    }

    var lbl = document.getElementById('strength-label');
    lbl.textContent = val.length ? 'Strength: ' + (labels[score] || 'Weak') : '';
    lbl.className   = 'text-xs ' + (['', 'text-red-500', 'text-amber-500', 'text-yellow-500', 'text-green-600'][score] || 'text-slate-400');
}

function checkMatch() {
    var pw  = document.getElementById('pw').value;
    var pw2 = document.getElementById('pw2').value;
    var msg = document.getElementById('match-msg');

    if (!pw2) { msg.classList.add('hidden'); return; }

    if (pw === pw2) {
        msg.textContent = '✓ Passwords match';
        msg.className   = 'mt-1.5 text-xs text-green-600';
        msg.classList.remove('hidden');
    } else {
        msg.textContent = 'Passwords do not match';
        msg.className   = 'mt-1.5 text-xs text-red-500';
        msg.classList.remove('hidden');
    }
}
</script>

@endsection
