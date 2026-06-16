{{--
|--------------------------------------------------------------------------
| Layout: auth
|--------------------------------------------------------------------------
| Minimal shell for login / forgot-password / reset-password pages.
| Same theme bootstrap as the app layout, but no sidebar/topbar.
--}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') · Infinity Back Office</title>
    <link rel="shortcut icon" type="image/x-icon" href={{ asset('assets/logo.png') }} />
    {{-- Apply persisted/system theme before first paint to avoid a flash --}}
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
            theme: { extend: {
                fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: {50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81'},
                    ink:   {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#0b1220'}
                },
                boxShadow: { soft: '0 1px 2px rgba(15,23,42,.04), 0 4px 16px rgba(15,23,42,.05)' }
            }}
        };
    </script>

    <style>
        html, body { font-family: 'Inter', system-ui, sans-serif; }
        body       { background: #f6f7fb; color: #0f172a; }
        .dark body { background: #0b1220; color: #e2e8f0; }
    </style>
</head>
<body class="min-h-screen">
    @yield('content')
    <script>lucide.createIcons();</script>
</body>
</html>
