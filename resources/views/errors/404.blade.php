<!doctype html>
<html lang="en" class="">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>404 · Page Not Found · Infinity Back Office</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />
    <script>
        (function () {
            try {
                var s = localStorage.getItem('theme');
                var d = s ? s === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (d) document.documentElement.classList.add('dark');
            } catch (e) {}
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-12px); }
        }
        .float { animation: float 4s ease-in-out infinite; }

        @keyframes pulse-ring {
            0%   { transform: scale(0.9); opacity: 0.6; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    {{-- Background blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[36rem] h-[36rem] bg-brand-400/10 dark:bg-brand-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[32rem] h-[32rem] bg-indigo-300/10 dark:bg-indigo-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center text-center max-w-lg w-full">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="mb-10 inline-flex items-center gap-3 bg-white dark:bg-ink-900 rounded-2xl px-5 py-3 shadow-soft border border-slate-100 dark:border-ink-800">
            <img src="{{ asset('assets/logo.png') }}" alt="Infinity Care" class="h-8 w-auto" />
        </a>

        {{-- Animated 404 --}}
        <div class="relative mb-8 float">
            {{-- Pulse rings --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-40 h-40 rounded-full border-2 border-brand-300/40 dark:border-brand-500/30 pulse-ring"></div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center" style="animation-delay:.6s">
                <div class="w-40 h-40 rounded-full border-2 border-brand-300/20 dark:border-brand-500/15 pulse-ring"></div>
            </div>

            {{-- Icon circle --}}
            <div class="relative w-36 h-36 rounded-full bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center shadow-lg mx-auto">
                <i data-lucide="file-search" class="w-16 h-16 text-white/90"></i>
            </div>
        </div>

        {{-- Error code --}}
        <div class="mb-3 inline-flex items-center gap-2 bg-brand-50 dark:bg-brand-900/30 border border-brand-200 dark:border-brand-800 rounded-full px-4 py-1.5 text-brand-600 dark:text-brand-300 text-xs font-semibold tracking-widest uppercase">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
            Error 404
        </div>

        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-ink-900 dark:text-white mb-3">
            Page Not Found
        </h1>

        <p class="text-base text-slate-500 dark:text-ink-400 leading-relaxed mb-10 max-w-sm">
            The page you're looking for doesn't exist or may have been moved. Double-check the URL or head back to safety.
        </p>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            @auth
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-soft transition-all duration-150 text-sm">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                Go to Dashboard
            </a>
            @else
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-soft transition-all duration-150 text-sm">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                Back to Login
            </a>
            @endauth

            <button onclick="history.back()"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white dark:bg-ink-900 hover:bg-slate-50 dark:hover:bg-ink-800 border border-slate-200 dark:border-ink-700 text-slate-700 dark:text-ink-200 font-semibold shadow-soft transition-all duration-150 text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Go Back
            </button>
        </div>

        {{-- Footer note --}}
        <p class="mt-12 text-xs text-slate-400 dark:text-ink-600 flex items-center gap-1.5">
            <i data-lucide="shield" class="w-3.5 h-3.5"></i>
            Infinity Back Office · Infinity Care Perth &amp; Victoria
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
