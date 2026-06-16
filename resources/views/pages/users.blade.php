{{--
|--------------------------------------------------------------------------
| Page: Users
|--------------------------------------------------------------------------
| Searchable, filterable directory of back-office users.
--}}
@extends('layouts.app', ['title' => 'Staff Accounts'])
@section('title','Staff Accounts')
@section('content')

{{-- Flash messages --}}
@if(session('success'))
  <div class="flex items-center gap-3 mb-5 px-4 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm">
    <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
    {{ session('success') }}
  </div>
@endif
@if(session('error'))
  <div class="flex items-center gap-3 mb-5 px-4 py-3 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-sm">
    <i data-lucide="circle-x" class="w-4 h-4 shrink-0"></i>
    {{ session('error') }}
  </div>
@endif

{{-- Header --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <div>
    <h2 class="text-xl font-bold">Staff Accounts</h2>
    <p class="text-sm text-slate-500 dark:text-ink-400">{{ $users->total() }} {{ Str::plural('result', $users->total()) }}</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('users.create') }}"
       class="px-3 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium flex items-center gap-2 transition">
      <i data-lucide="plus" class="w-4 h-4"></i> Add staff
    </a>
  </div>
</div>

{{-- Search & filters --}}
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
  <form method="GET" action="{{ route('users.index') }}"
        class="p-4 flex flex-wrap gap-2 border-b border-slate-100 dark:border-ink-800">

    <div class="flex items-center gap-2 flex-1 min-w-[200px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
      <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
      <input name="search" value="{{ request('search') }}"
             class="bg-transparent text-sm outline-none flex-1" placeholder="Search name or email…">
    </div>

    <select name="role"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
      <option value="">All roles</option>
      @foreach($roles as $role)
        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
          {{ $role->name }}
        </option>
      @endforeach
    </select>

    <select name="state"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
      <option value="">All states</option>
      @foreach($states as $state)
        <option value="{{ $state }}" {{ request('state') === $state ? 'selected' : '' }}>{{ $state }}</option>
      @endforeach
    </select>

    <select name="status"
            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm outline-none">
      <option value="">Any status</option>
      <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
      <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>Disabled</option>
    </select>

    <button type="submit"
            class="px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium transition">
      Filter
    </button>

    @if(request()->hasAny(['search','role','state','status']))
      <a href="{{ route('users.index') }}"
         class="px-4 py-2 rounded-lg border border-slate-200 dark:border-ink-800 text-sm text-slate-500 hover:bg-slate-50 dark:hover:bg-ink-800 transition">
        Clear
      </a>
    @endif
  </form>

  {{-- Table --}}
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full">
      <thead class="bg-slate-50 dark:bg-ink-800">
        <tr>
          <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">User</th>
          <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Email</th>
          <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Role</th>
          <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Location</th>
          <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Status</th>
          <th class="text-left font-medium text-xs text-slate-500 dark:text-ink-400 uppercase tracking-wider px-4 py-3">Created</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          @php
            $initials = collect(explode(' ', $user->name))
                          ->map(fn($w) => strtoupper($w[0] ?? ''))
                          ->take(2)
                          ->implode('');
          @endphp
          <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800/50 transition">

            {{-- User --}}
            <td class="px-4 py-3 text-sm">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-300 grid place-items-center font-semibold text-xs shrink-0">
                  {{ $initials }}
                </div>
                <div class="font-medium">{{ $user->name }}</div>
              </div>
            </td>

            {{-- Email --}}
            <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300">{{ $user->email }}</td>

            {{-- Role --}}
            <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300">
              {{ $user->role->name ?? '—' }}
            </td>

            {{-- Location --}}
            <td class="px-4 py-3 text-sm text-slate-600 dark:text-ink-300">{{ $user->state ?? '—' }}</td>

            {{-- Status --}}
            <td class="px-4 py-3 text-sm">
              @if($user->active)
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-medium">Active</span>
              @else
                <span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-ink-700 text-slate-600 dark:text-ink-300 font-medium">Disabled</span>
              @endif
            </td>

            {{-- Created --}}
            <td class="px-4 py-3 text-sm text-slate-500 dark:text-ink-400">
              {{ $user->created_at->diffForHumans() }}
            </td>

            {{-- Actions --}}
            <td class="px-4 py-3 text-sm">
              <div class="flex items-center gap-1">
                <a href="{{ route('users.edit', $user) }}"
                   class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-ink-700 transition"
                   title="Edit">
                  <i data-lucide="pencil" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i>
                </a>

                <form method="POST" action="{{ route('users.destroy', $user) }}"
                      onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="p-1.5 rounded hover:bg-rose-50 dark:hover:bg-rose-900/20 transition"
                          title="Delete">
                    <i data-lucide="trash-2" class="w-4 h-4 text-rose-500"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400 dark:text-ink-500">
              <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
              <p>No staff accounts found.</p>
              @if(request()->hasAny(['search','role','state','status']))
                <a href="{{ route('users.index') }}" class="text-brand-600 hover:underline mt-1 inline-block">Clear filters</a>
              @endif
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($users->hasPages())
    <div class="p-4 flex items-center justify-between border-t border-slate-100 dark:border-ink-800 text-sm text-slate-500 dark:text-ink-400">
      <div>Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</div>
      <div class="flex gap-1">
        {{-- Prev --}}
        @if($users->onFirstPage())
          <span class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800 opacity-40 cursor-not-allowed">Prev</span>
        @else
          <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800 transition">Prev</a>
        @endif

        {{-- Page numbers --}}
        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
          @if($page === $users->currentPage())
            <span class="px-3 py-1.5 rounded-md bg-brand-600 text-white">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800 transition">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next --}}
        @if($users->hasMorePages())
          <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800 hover:bg-slate-50 dark:hover:bg-ink-800 transition">Next</a>
        @else
          <span class="px-3 py-1.5 rounded-md border border-slate-200 dark:border-ink-800 opacity-40 cursor-not-allowed">Next</span>
        @endif
      </div>
    </div>
  @endif
</div>

@endsection
