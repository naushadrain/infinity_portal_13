{{--
|--------------------------------------------------------------------------
| Page: Edit User
|--------------------------------------------------------------------------
| Edit an existing back-office staff account.
--}}
@extends('layouts.app', ['title' => 'Edit Staff'])
@section('title','Edit Staff')
@section('content')

<form id="update-user-form" method="POST" action="{{ route('users.update', $user) }}">
@csrf
@method('PUT')

{{-- Account details --}}
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <div class="flex items-center justify-between mb-1">
    <h3 class="text-base font-semibold">Account details</h3>
    <span class="text-xs text-slate-400 dark:text-ink-500">ID #{{ $user->id }}</span>
  </div>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

  <div class="grid md:grid-cols-2 gap-4">

    {{-- Full name --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
        Full name <span class="text-rose-500">*</span>
      </label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" required
             placeholder="e.g. Sarah Mitchell"
             class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('name') ? 'border-rose-400' : 'border-slate-200 dark:border-ink-800' }} focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
      @error('name')
        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
      @enderror
    </div>

    {{-- Email --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
        Email address <span class="text-rose-500">*</span>
      </label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required
             placeholder="name@infinitycare.com.au"
             class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-rose-400' : 'border-slate-200 dark:border-ink-800' }} focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
      @error('email')
        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
      @enderror
    </div>

  </div>
</section>

{{-- Access & role --}}
<section class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 p-6 mb-6">
  <h3 class="text-base font-semibold mb-1">Access &amp; role</h3>
  <div class="h-px bg-slate-100 dark:bg-ink-800 mb-5"></div>

  <div class="grid md:grid-cols-3 gap-4 mb-4">

    {{-- Role --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">
        Role <span class="text-rose-500">*</span>
      </label>
      <select name="role_id" required
              class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('role_id') ? 'border-rose-400' : 'border-slate-200 dark:border-ink-800' }} bg-white dark:bg-ink-950 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm transition">
        <option value="">— Select role —</option>
        @foreach($roles as $role)
          <option value="{{ $role->id }}"
            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
            {{ $role->name }}
          </option>
        @endforeach
      </select>
      @error('role_id')
        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
      @enderror
    </div>

    {{-- Location --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Location</label>
      <select name="state"
              class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-950 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm transition">
        <option value="">— Select state —</option>
        @foreach($states as $state)
          <option value="{{ $state }}"
            {{ old('state', $user->state) === $state ? 'selected' : '' }}>
            {{ $state }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Status</label>
      <select name="active"
              class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-950 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm transition">
        <option value="1" {{ old('active', $user->active ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('active', $user->active ? '1' : '0') === '0' ? 'selected' : '' }}>Disabled</option>
      </select>
    </div>

  </div>

  {{-- Reset password (optional) --}}
  <div class="border-t border-slate-100 dark:border-ink-800 pt-4">
    <p class="text-sm font-medium text-slate-700 dark:text-ink-200 mb-3">
      Reset password
      <span class="text-xs font-normal text-slate-400 dark:text-ink-500 ml-1">(leave blank to keep current password)</span>
    </p>
    <div class="grid md:grid-cols-2 gap-4">

      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">New password</label>
        <input type="password" name="password"
               placeholder="Min. 8 characters"
               class="w-full px-3.5 py-2.5 rounded-lg border {{ $errors->has('password') ? 'border-rose-400' : 'border-slate-200 dark:border-ink-800' }} focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
        @error('password')
          <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-ink-200 mb-1.5">Confirm new password</label>
        <input type="password" name="password_confirmation"
               placeholder="Repeat new password"
               class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none text-sm bg-white dark:bg-ink-950 transition">
      </div>

    </div>
  </div>
</section>

</form>

{{-- Actions --}}
<div class="flex justify-between gap-2 mb-10">
  {{-- Delete --}}
  @if($user->id !== auth()->id())
    <form method="POST" action="{{ route('users.destroy', $user) }}"
          onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}? This cannot be undone.')">
      @csrf
      @method('DELETE')
      <button type="submit"
              class="px-4 py-2.5 rounded-lg border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-sm font-medium hover:bg-rose-50 dark:hover:bg-rose-900/20 transition">
        Delete account
      </button>
    </form>
  @else
    <div></div>
  @endif

  <div class="flex gap-2">
    <a href="{{ route('users.index') }}"
       class="px-4 py-2.5 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm font-medium hover:bg-slate-50 dark:hover:bg-ink-800 transition">
      Cancel
    </a>
    <button type="submit" form="update-user-form"
            class="px-5 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-soft transition">
      Save changes
    </button>
  </div>
</div>
@endsection
