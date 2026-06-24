{{--
|--------------------------------------------------------------------------
| Partial: topbar
|--------------------------------------------------------------------------
| Top bar with page title, search, theme toggle and account menu.
--}}
<header class="sticky top-0 z-30 h-16 bg-white/80 dark:bg-ink-900/80 backdrop-blur border-b border-slate-200 dark:border-ink-800 flex items-center px-4 lg:px-8 gap-3">

  {{-- Sidebar toggle (mobile + desktop) --}}
  <button onclick="toggleSidebar()"
          class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-ink-800"
          title="Toggle sidebar">
    <i data-lucide="panel-left" class="w-5 h-5"></i>
  </button>

  {{-- Page title --}}
  <div class="flex-1 min-w-0">
    <h1 class="text-base font-semibold truncate">{{ $title }}</h1>
  </div>

  {{-- Search --}}
  <form action="{{ url('/search') }}" method="GET"
        class="hidden md:flex items-center gap-2 bg-slate-100 dark:bg-ink-800 rounded-lg px-3 py-2 w-56 lg:w-72">
    <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
    <input name="q" placeholder="Search…" class="bg-transparent text-sm outline-none flex-1" />
    <kbd class="text-[10px] text-slate-400 border border-slate-200 dark:border-ink-700 rounded px-1.5 py-0.5">⌘K</kbd>
  </form>

  {{-- Theme toggle --}}
  <button id="theme-toggle" title="Toggle theme" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-ink-800">
    <i data-lucide="sun"  class="w-5 h-5 hidden dark:inline"></i>
    <i data-lucide="moon" class="w-5 h-5 inline  dark:hidden"></i>
  </button>

  {{-- Notifications --}}
  <button class="relative p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-ink-800">
    <i data-lucide="bell" class="w-5 h-5"></i>
    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
  </button>

  {{-- ── Account dropdown ───────────────────────────────────────────── --}}
  <div class="relative" id="user-menu-wrap">

    {{-- Trigger button --}}
    <button id="user-menu-btn"
            class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-100 dark:hover:bg-ink-800 transition focus:outline-none">
      <img src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/40?img=12' }}"
           class="w-9 h-9 rounded-full ring-2 ring-white dark:ring-ink-800 shadow-sm object-cover"
           alt="{{ auth()->user()->name ?? 'User' }}" />
      <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 hidden sm:inline transition-transform duration-200" id="user-chevron"></i>
    </button>

    {{-- Dropdown panel --}}
    <div id="user-dropdown"
         class="hidden absolute right-0 top-full mt-2 w-60 bg-white dark:bg-ink-900 rounded-xl shadow-lg border border-slate-200 dark:border-ink-800 z-50 overflow-hidden">

      {{-- User info --}}
      <div class="flex items-center gap-3 px-4 py-3.5 border-b border-slate-100 dark:border-ink-800">
        <img src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/40?img=12' }}"
             class="w-10 h-10 rounded-full ring-2 ring-slate-200 dark:ring-ink-700 object-cover shrink-0"
             alt="{{ auth()->user()->name ?? 'User' }}" />
        <div class="min-w-0">
          <p class="text-sm font-semibold text-slate-800 dark:text-ink-100 truncate">
            {{ auth()->user()->name ?? 'User' }}
          </p>
          <p class="text-xs text-slate-500 dark:text-ink-400 truncate">
            {{ auth()->user()->email ?? '' }}
          </p>
        </div>
      </div>

      {{-- Navigation items --}}
      <div class="py-1">
        <a href="{{ route('profile') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-ink-200 hover:bg-slate-50 dark:hover:bg-ink-800 transition">
          <span class="w-7 h-7 rounded-lg bg-brand-50 dark:bg-brand-900/30 flex items-center justify-center shrink-0">
            <i data-lucide="user" class="w-4 h-4 text-brand-600 dark:text-brand-400"></i>
          </span>
          Profile
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-ink-200 hover:bg-slate-50 dark:hover:bg-ink-800 transition">
          <span class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-ink-800 flex items-center justify-center shrink-0">
            <i data-lucide="settings" class="w-4 h-4 text-slate-500 dark:text-ink-400"></i>
          </span>
          Settings
        </a>

        <a href="{{ route('password.request') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-ink-200 hover:bg-slate-50 dark:hover:bg-ink-800 transition">
          <span class="w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center shrink-0">
            <i data-lucide="key-round" class="w-4 h-4 text-amber-600 dark:text-amber-400"></i>
          </span>
          Change Password
        </a>
      </div>

      {{-- Logout --}}
      <div class="border-t border-slate-100 dark:border-ink-800 py-1">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition text-left">
            <span class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center shrink-0">
              <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i>
            </span>
            Sign out
          </button>
        </form>
      </div>

    </div>{{-- /dropdown --}}
  </div>{{-- /user-menu-wrap --}}

</header>

@push('scripts')
<script>
(function () {
  var btn      = document.getElementById('user-menu-btn');
  var dropdown = document.getElementById('user-dropdown');
  var chevron  = document.getElementById('user-chevron');

  if (!btn || !dropdown) return;

  btn.addEventListener('click', function (e) {
    e.stopPropagation();
    var isOpen = !dropdown.classList.contains('hidden');
    dropdown.classList.toggle('hidden', isOpen);
    chevron && chevron.classList.toggle('rotate-180', !isOpen);
    lucide.createIcons();
  });

  // Close when clicking anywhere outside
  document.addEventListener('click', function (e) {
    if (!document.getElementById('user-menu-wrap').contains(e.target)) {
      dropdown.classList.add('hidden');
      chevron && chevron.classList.remove('rotate-180');
    }
  });
})();
</script>
@endpush
