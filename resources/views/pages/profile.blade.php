{{--
|--------------------------------------------------------------------------
| Page: Profile
|--------------------------------------------------------------------------
| Current user profile and account preferences.
--}}
@extends('layouts.app', ['title' => 'My Profile'])
@section('title','My Profile')
@section('content')

<div class="grid lg:grid-cols-3 gap-6">

  {{-- ── Left: avatar card ──────────────────────────────────────────── --}}
  <div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 flex flex-col items-center text-center h-fit">
    <div class="relative">
      <img src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/120?img=12' }}"
           class="w-24 h-24 rounded-full mx-auto ring-4 ring-brand-100 dark:ring-brand-900/40 object-cover"
           alt="{{ $user->name }}">
      <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-emerald-400 ring-2 ring-white dark:ring-ink-900"></span>
    </div>

    <h3 class="font-semibold text-lg mt-4">{{ $user->name }}</h3>
    <p class="text-sm text-slate-500 dark:text-ink-400 mt-0.5">
      {{ $user->role->name ?? 'No role assigned' }}
      @if($user->state)
        · {{ $user->state }}
      @endif
    </p>

    <div class="w-full mt-4 pt-4 border-t border-slate-100 dark:border-ink-800 space-y-2 text-left text-sm">
      <div class="flex items-center gap-2 text-slate-600 dark:text-ink-300">
        <i data-lucide="mail" class="w-4 h-4 text-slate-400 shrink-0"></i>
        <span class="truncate">{{ $user->email }}</span>
      </div>
      <div class="flex items-center gap-2 text-slate-600 dark:text-ink-300">
        <i data-lucide="shield-check" class="w-4 h-4 text-slate-400 shrink-0"></i>
        <span>{{ $user->active ? 'Active account' : 'Inactive account' }}</span>
      </div>
      <div class="flex items-center gap-2 text-slate-600 dark:text-ink-300">
        <i data-lucide="calendar" class="w-4 h-4 text-slate-400 shrink-0"></i>
        <span>Joined {{ $user->created_at->format('M Y') }}</span>
      </div>
    </div>
  </div>

  {{-- ── Right: forms ────────────────────────────────────────────────── --}}
  <div class="lg:col-span-2 space-y-6">

    {{-- Profile success message --}}
    @if(session('profile_success'))
      <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm">
        <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
        {{ session('profile_success') }}
      </div>
    @endif

    {{-- ── Profile info form ───────────────────────────────────────── --}}
    <section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
      <h3 class="font-semibold mb-1">Profile Information</h3>
      <p class="text-sm text-slate-500 dark:text-ink-400 mb-5">Update your name, email address and location.</p>

      <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-4">

          {{-- Full name --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
              Full name <span class="text-rose-500">*</span>
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   required
                   placeholder="Your full name"
                   class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('name') ? 'border-rose-400 focus:ring-rose-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
            @error('name')
              <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Email --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
              Email address <span class="text-rose-500">*</span>
            </label>
            <input type="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   placeholder="you@example.com"
                   class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-rose-400 focus:ring-rose-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
            @error('email')
              <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Role — read-only --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Role</label>
            <input type="text"
                   value="{{ $user->role->name ?? '—' }}"
                   readonly
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-slate-50 dark:bg-ink-800 text-sm text-slate-500 dark:text-ink-400 cursor-not-allowed outline-none">
          </div>

          {{-- State / Location --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Location / State</label>
            <select name="state"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-950 text-sm outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition">
              <option value="">— Select state —</option>
              @foreach(['Western Australia','Victoria','New South Wales','Queensland','South Australia','Tasmania','Australian Capital Territory','Northern Territory'] as $state)
                <option value="{{ $state }}" {{ old('state', $user->state) === $state ? 'selected' : '' }}>
                  {{ $state }}
                </option>
              @endforeach
            </select>
          </div>

        </div>

        <div class="flex justify-end mt-5">
          <button type="submit"
                  class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition shadow-soft">
            Save changes
          </button>
        </div>
      </form>
    </section>

    {{-- Password success message --}}
    @if(session('password_success'))
      <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm">
        <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
        {{ session('password_success') }}
      </div>
    @endif

    {{-- ── Change password form ────────────────────────────────────── --}}
    <section id="password-section" class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6">
      <h3 class="font-semibold mb-1">Change Password</h3>
      <p class="text-sm text-slate-500 dark:text-ink-400 mb-5">Use at least 8 characters with a mix of letters and numbers.</p>

      <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-3 gap-4">

          {{-- Current password --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
              Current password <span class="text-rose-500">*</span>
            </label>
            <input type="password"
                   name="current_password"
                   required
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('current_password') ? 'border-rose-400 focus:ring-rose-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
            @error('current_password')
              <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- New password --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
              New password <span class="text-rose-500">*</span>
            </label>
            <input type="password"
                   name="password"
                   required
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('password') ? 'border-rose-400 focus:ring-rose-400/20' : 'border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10' }} bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
            @error('password')
              <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Confirm password --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
              Confirm password <span class="text-rose-500">*</span>
            </label>
            <input type="password"
                   name="password_confirmation"
                   required
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-brand-500/10 bg-white dark:bg-ink-950 text-sm outline-none focus:ring-4 transition">
          </div>

        </div>

        <div class="flex justify-end mt-5">
          <button type="submit"
                  class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition shadow-soft">
            Update password
          </button>
        </div>
      </form>
    </section>

  </div>
</div>

@endsection
