@extends('layouts.auth')
@section('title', 'Verify OTP')
@section('content')

<div class="min-h-screen flex items-center justify-center p-6 sm:p-12 bg-[#f6f7fb] dark:bg-[#0b1220]">
    <div class="w-full max-w-md">

        <a href="{{ route('password.request') }}"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-ink-400 hover:text-slate-700 dark:hover:text-ink-200 transition mb-8">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
        </a>

        <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft p-8 border border-slate-100 dark:border-ink-800">

            <div class="text-center mb-7">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 dark:bg-brand-900/20 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="mail-check" class="w-7 h-7 text-brand-600 dark:text-brand-400"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Check your email</h1>
                <p class="text-sm text-slate-500 dark:text-ink-400 mt-1.5">
                    We sent a 6-digit code to<br>
                    <span class="font-semibold text-slate-700 dark:text-ink-200">{{ $email }}</span>
                </p>
            </div>

            {{-- Countdown --}}
            <div id="timer-wrap" class="flex items-center justify-center gap-2 mb-6 text-sm">
                <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                <span class="text-slate-500 dark:text-ink-400">Code expires in</span>
                <span id="countdown" class="font-mono font-semibold text-brand-600 dark:text-brand-400">10:00</span>
            </div>
            <div id="expired-banner" class="hidden mb-6 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 px-4 py-3 text-sm text-amber-700 dark:text-amber-300 items-start gap-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                OTP has expired. <a href="{{ route('password.request') }}" class="underline font-medium ml-1">Request a new one.</a>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-start gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-700 dark:text-red-300 flex items-start gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="otp-form" method="POST" action="{{ route('password.checkOtp') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-ink-200 mb-3 text-center uppercase tracking-wide">
                        Enter your code
                    </label>

                    {{-- 6-box OTP input --}}
                    <div class="flex gap-2 justify-center" id="otp-boxes">
                        @for ($i = 0; $i < 6; $i++)
                            <input
                                type="text"
                                inputmode="numeric"
                                pattern="[0-9]"
                                maxlength="1"
                                class="otp-digit w-12 h-14 text-center text-xl font-bold rounded-xl border border-slate-200 dark:border-ink-700 bg-white dark:bg-ink-900 text-slate-900 dark:text-ink-100 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition caret-transparent"
                                autocomplete="off"
                            />
                        @endfor
                    </div>

                    <input type="hidden" name="otp" id="otp-hidden" />

                    @error('otp')
                        <p class="mt-2 text-xs text-red-500 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="verify-btn"
                    class="w-full py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-soft transition flex items-center justify-center gap-2">
                    Verify Code <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            {{-- Resend --}}
            <div class="mt-5 text-center">
                <p class="text-sm text-slate-500 dark:text-ink-400">Didn't receive it?</p>
                <form method="POST" action="{{ route('password.resendOtp') }}" class="inline">
                    @csrf
                    <button type="submit" id="resend-btn" disabled
                        class="mt-1.5 text-sm font-medium text-brand-600 dark:text-brand-400 hover:underline disabled:opacity-40 disabled:no-underline disabled:cursor-not-allowed transition">
                        Resend in <span id="resend-timer">60</span>s
                    </button>
                </form>
            </div>

        </div>

        <p class="mt-6 text-xs text-slate-400 dark:text-ink-500 text-center flex items-center justify-center gap-1.5">
            <i data-lucide="shield" class="w-3.5 h-3.5"></i> Protected by activity logging. Unauthorised access is monitored.
        </p>

    </div>
</div>

<script>
(function () {
    // ── OTP box behaviour ──────────────────────────────────────────────
    const digits  = Array.from(document.querySelectorAll('.otp-digit'));
    const hidden  = document.getElementById('otp-hidden');
    const form    = document.getElementById('otp-form');
    const verifyBtn = document.getElementById('verify-btn');

    function sync() {
        hidden.value = digits.map(d => d.value).join('');
    }

    digits.forEach((el, i) => {
        el.addEventListener('input', () => {
            el.value = el.value.replace(/\D/g, '').slice(-1);
            sync();
            if (el.value && i < digits.length - 1) digits[i + 1].focus();
        });

        el.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !el.value && i > 0) digits[i - 1].focus();
            if (e.key === 'ArrowLeft'  && i > 0)              digits[i - 1].focus();
            if (e.key === 'ArrowRight' && i < digits.length - 1) digits[i + 1].focus();
        });

        el.addEventListener('paste', e => {
            e.preventDefault();
            const raw = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            raw.split('').slice(0, 6).forEach((ch, j) => { if (digits[j]) digits[j].value = ch; });
            sync();
            const next = digits.findIndex(d => !d.value);
            (next >= 0 ? digits[next] : digits[digits.length - 1]).focus();
        });
    });

    form.addEventListener('submit', e => {
        sync();
        if (hidden.value.length !== 6) {
            e.preventDefault();
            digits[0].focus();
        }
    });

    if (digits[0]) digits[0].focus();

    // ── Countdown timer ────────────────────────────────────────────────
    const expiresAt  = new Date('{{ $expiresAt }}');
    const resendAt   = new Date('{{ $resendAt }}');
    const countdownEl  = document.getElementById('countdown');
    const timerWrap    = document.getElementById('timer-wrap');
    const expiredBanner = document.getElementById('expired-banner');
    const resendBtn    = document.getElementById('resend-btn');
    const resendTimerEl = document.getElementById('resend-timer');

    function tick() {
        const now = new Date();

        // Expiry countdown
        const expSecs = Math.max(0, Math.floor((expiresAt - now) / 1000));
        const mm = String(Math.floor(expSecs / 60)).padStart(2, '0');
        const ss = String(expSecs % 60).padStart(2, '0');
        countdownEl.textContent = `${mm}:${ss}`;

        if (expSecs === 0) {
            timerWrap.classList.add('hidden');
            expiredBanner.style.display = 'flex';
            form.classList.add('opacity-50', 'pointer-events-none');
            verifyBtn.disabled = true;
        }

        // Resend countdown
        const resendSecs = Math.max(0, Math.floor((resendAt - now) / 1000));
        if (resendSecs > 0) {
            resendBtn.disabled = true;
            resendTimerEl.textContent = resendSecs;
            resendBtn.innerHTML = `Resend in <span id="resend-timer">${resendSecs}</span>s`;
        } else {
            resendBtn.disabled = false;
            resendBtn.textContent = 'Resend OTP';
        }
    }

    tick();
    setInterval(tick, 1000);
})();
</script>

@endsection
