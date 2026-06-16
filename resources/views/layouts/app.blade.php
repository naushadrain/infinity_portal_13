{{--
|--------------------------------------------------------------------------
| Layout: app
|--------------------------------------------------------------------------
| Authenticated shell used by every dashboard page.
| Provides: sidebar, topbar, theme bootstrap (no FOUC), CSRF token,
| icon library, and a content yield slot.
|
| Built for Laravel 13.x (PHP 8.3+).
| PHP 8.2+ required.
--}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Dashboard') · Infinity Back Office</title>
    <link rel="icon" href="/favicon.ico " />
    <link rel="shortcut icon" type="image/x-icon" href={{ asset('assets/logo.png') }} />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    {{-- Apply persisted/system theme before first paint to avoid a flash --}}
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('theme');
                var dark  = saved
                    ? saved === 'dark'
                    : window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (dark) document.documentElement.classList.add('dark');
            } catch (e) {}
        })();
    </script>

    {{--
        DEV: Tailwind CDN keeps the preview zero-config.
        PROD: replace these two <script> tags with @vite(['resources/css/app.css','resources/js/app.js']).
    --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <script>
        // Shared design tokens — keep in sync with tailwind.config.js when compiling for production.
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81'},
                        ink:   {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#0b1220'}
                    },
                    boxShadow: { soft: '0 1px 2px rgba(15,23,42,.04), 0 4px 16px rgba(15,23,42,.05)' }
                }
            }
        };
    </script>

    <style>
        html, body { font-family: 'Inter', system-ui, sans-serif; }
        body       { background: #f6f7fb; color: #0f172a; }
        .dark body { background: #0b1220; color: #e2e8f0; }
        .scrollbar-thin::-webkit-scrollbar       { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #334155; }
    </style>

    @stack('head')
</head>
<body class="min-h-screen">

    @include('partials.sidebar')

    {{-- Mobile sidebar backdrop --}}
    <div id="sb-overlay"
         onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"
         class="hidden lg:hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30"></div>

    <div class="lg:pl-64 min-h-screen w-full">
        @include('partials.topbar', ['title' => $title ?? 'Dashboard'])

        <main class="p-4 sm:p-6 lg:p-8 2xl:p-10 w-full max-w-none xl:max-w-[1500px] 2xl:max-w-[1800px] mx-auto">
            @yield('content')
        </main>
    </div>

    <script>
        // Render Lucide icons once on load (pages can call lucide.createIcons() again after AJAX swaps).
        lucide.createIcons();

        // Manual theme toggle — persists to localStorage so the inline head script picks it up on reload.
        document.getElementById('theme-toggle')?.addEventListener('click', function () {
            var isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html>
