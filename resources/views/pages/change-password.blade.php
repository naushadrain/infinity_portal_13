{{--
|--------------------------------------------------------------------------
| Page: Change Password
|--------------------------------------------------------------------------
| Authenticated user password change with strength meter and show/hide.
--}}
@extends('layouts.app', ['title' => 'Change Password'])
@section('title', 'Change Password')
@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Back link --}}
    <a href="{{ route('profile') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-ink-400 hover:text-slate-800 dark:hover:text-white mb-5 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Profile
    </a>

    {{-- Header card --}}
    <div class="bg-gradient-to-br from-brand-600 to-indigo-700 dark:from-ink-900 dark:to-brand-900 rounded-2xl p-6 mb-6 text-white shadow-sm overflow-hidden relative">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center shrink-0">
                <i data-lucide="key-round" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold">Change Password</h2>
                <p class="text-sm text-white/75 mt-0.5">Keep your account secure with a strong, unique password.</p>
            </div>
        </div>
    </div>

    {{-- Success --}}
    @if(session('password_success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm mb-5">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
            {{ session('password_success') }}
        </div>
    @endif

    {{-- Form card --}}
    <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">

        <form method="POST" action="{{ route('profile.password') }}" id="change-password-form" novalidate>
            @csrf
            @method('PUT')

            <div class="space-y-5">

                {{-- Current password --}}
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        Current password <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your current password"
                               class="w-full pr-10 px-3.5 py-2.5 rounded-lg border
                                      {{ $errors->has('current_password')
                                          ? 'border-rose-400 focus:ring-rose-400/20'
                                          : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }}
                                      bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
                        <button type="button" onclick="togglePassword('current_password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-ink-200 transition" tabindex="-1">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <hr class="border-slate-100 dark:border-ink-800">

                {{-- New password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        New password <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="At least 8 characters"
                               oninput="updateStrength(this.value)"
                               class="w-full pr-10 px-3.5 py-2.5 rounded-lg border
                                      {{ $errors->has('password')
                                          ? 'border-rose-400 focus:ring-rose-400/20'
                                          : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }}
                                      bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
                        <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-ink-200 transition" tabindex="-1">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- Strength bar --}}
                    <div class="mt-2.5 space-y-1.5" id="strength-wrap" style="display:none">
                        <div class="flex gap-1.5">
                            <div class="h-1.5 flex-1 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                                <div id="bar-1" class="h-full rounded-full transition-all duration-300 w-0"></div>
                            </div>
                            <div class="h-1.5 flex-1 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                                <div id="bar-2" class="h-full rounded-full transition-all duration-300 w-0"></div>
                            </div>
                            <div class="h-1.5 flex-1 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                                <div id="bar-3" class="h-full rounded-full transition-all duration-300 w-0"></div>
                            </div>
                            <div class="h-1.5 flex-1 rounded-full bg-slate-100 dark:bg-ink-800 overflow-hidden">
                                <div id="bar-4" class="h-full rounded-full transition-all duration-300 w-0"></div>
                            </div>
                        </div>
                        <p id="strength-label" class="text-xs font-medium"></p>
                    </div>
                </div>

                {{-- Confirm password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
                        Confirm new password <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="Repeat new password"
                               oninput="checkMatch()"
                               class="w-full pr-10 px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10 bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-ink-200 transition" tabindex="-1">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p id="match-msg" class="mt-1.5 text-xs hidden"></p>
                </div>

                {{-- Requirements checklist --}}
                <div class="rounded-xl bg-slate-50 dark:bg-ink-800 border border-slate-100 dark:border-ink-700 p-4">
                    <p class="text-xs font-semibold text-slate-500 dark:text-ink-400 uppercase tracking-wider mb-3">Password requirements</p>
                    <ul class="space-y-1.5 text-sm" id="req-list">
                        <li class="flex items-center gap-2 req-item" data-req="length">
                            <i data-lucide="circle" class="w-3.5 h-3.5 text-slate-300 dark:text-ink-600 shrink-0 req-icon"></i>
                            <span class="text-slate-500 dark:text-ink-400">At least 8 characters</span>
                        </li>
                        <li class="flex items-center gap-2 req-item" data-req="upper">
                            <i data-lucide="circle" class="w-3.5 h-3.5 text-slate-300 dark:text-ink-600 shrink-0 req-icon"></i>
                            <span class="text-slate-500 dark:text-ink-400">At least one uppercase letter</span>
                        </li>
                        <li class="flex items-center gap-2 req-item" data-req="number">
                            <i data-lucide="circle" class="w-3.5 h-3.5 text-slate-300 dark:text-ink-600 shrink-0 req-icon"></i>
                            <span class="text-slate-500 dark:text-ink-400">At least one number</span>
                        </li>
                        <li class="flex items-center gap-2 req-item" data-req="special">
                            <i data-lucide="circle" class="w-3.5 h-3.5 text-slate-300 dark:text-ink-600 shrink-0 req-icon"></i>
                            <span class="text-slate-500 dark:text-ink-400">At least one special character</span>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between mt-6 pt-5 border-t border-slate-100 dark:border-ink-800">
                <a href="{{ route('profile') }}"
                   class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-700 bg-white dark:bg-ink-800 text-sm font-medium text-slate-600 dark:text-ink-300 hover:bg-slate-50 dark:hover:bg-ink-700 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition shadow-soft">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Update password
                </button>
            </div>

        </form>
    </div>

</div>

@push('scripts')
<script>
(function () {

    // ── Show / hide password toggle ───────────────────────────────────────
    window.togglePassword = function (id, btn) {
        var input = document.getElementById(id);
        var isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        // swap icon
        btn.innerHTML = isText
            ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
    };

    // ── Strength meter ────────────────────────────────────────────────────
    var strengthLevels = [
        { label: 'Too weak',  color: '#ef4444' },
        { label: 'Weak',      color: '#f97316' },
        { label: 'Fair',      color: '#eab308' },
        { label: 'Strong',    color: '#22c55e' },
    ];

    function scorePassword(val) {
        var score = 0;
        if (val.length >= 8)                   score++;
        if (/[A-Z]/.test(val))                 score++;
        if (/[0-9]/.test(val))                 score++;
        if (/[^A-Za-z0-9]/.test(val))          score++;
        return score; // 0–4
    }

    window.updateStrength = function (val) {
        var wrap  = document.getElementById('strength-wrap');
        var label = document.getElementById('strength-label');

        if (!val) { wrap.style.display = 'none'; updateReqs(''); return; }

        wrap.style.display = 'block';
        var score = scorePassword(val);
        var level = strengthLevels[score > 0 ? score - 1 : 0];

        for (var i = 1; i <= 4; i++) {
            var bar = document.getElementById('bar-' + i);
            bar.style.width   = i <= score ? '100%' : '0%';
            bar.style.background = i <= score ? level.color : '';
        }

        label.textContent  = level.label;
        label.style.color  = level.color;

        updateReqs(val);
        checkMatch();
    };

    // ── Requirements checklist ────────────────────────────────────────────
    function updateReqs(val) {
        var checks = {
            length:  val.length >= 8,
            upper:   /[A-Z]/.test(val),
            number:  /[0-9]/.test(val),
            special: /[^A-Za-z0-9]/.test(val),
        };

        document.querySelectorAll('.req-item').forEach(function (li) {
            var key  = li.dataset.req;
            var icon = li.querySelector('.req-icon');
            var text = li.querySelector('span');
            if (checks[key]) {
                icon.outerHTML = '<svg class="w-3.5 h-3.5 shrink-0 req-icon text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                text.classList.add('text-emerald-600', 'dark:text-emerald-400');
                text.classList.remove('text-slate-500', 'dark:text-ink-400');
            } else {
                icon.outerHTML = '<svg class="w-3.5 h-3.5 shrink-0 req-icon text-slate-300 dark:text-ink-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
                text.classList.remove('text-emerald-600', 'dark:text-emerald-400');
                text.classList.add('text-slate-500', 'dark:text-ink-400');
            }
        });
    }

    // ── Confirm match ─────────────────────────────────────────────────────
    window.checkMatch = function () {
        var pw   = document.getElementById('password').value;
        var conf = document.getElementById('password_confirmation').value;
        var msg  = document.getElementById('match-msg');

        if (!conf) { msg.classList.add('hidden'); return; }

        msg.classList.remove('hidden');
        if (pw === conf) {
            msg.textContent  = '✓ Passwords match';
            msg.className    = 'mt-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400';
        } else {
            msg.textContent  = '✗ Passwords do not match';
            msg.className    = 'mt-1.5 text-xs font-medium text-rose-500';
        }
    };

    // Re-init lucide after page load (icons rendered via outerHTML replacement need re-init)
    // We use raw SVGs above so lucide.createIcons() only needs to run once on load.

})();
</script>
@endpush

@endsection
