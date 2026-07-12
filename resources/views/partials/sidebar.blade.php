{{--
|--------------------------------------------------------------------------
| Partial: sidebar
|--------------------------------------------------------------------------
| Primary left navigation. Auto-expands the group containing the active route.

[
            'label' => 'Monitoring Chart',
            'route' => 'forms.abc-monitoring-chart.index',
            'prefix' => 'forms.abc-monitoring-chart',
            'icon' => 'clipboard-list',
        ],
--}}

@php

    $isManager = auth()->user()->role_id === 2;
    $isStaff = auth()->user()->role_id === 3;

    $nav = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'layout-dashboard', 'managerHidden' => true],
        [
            'label' => 'User Management',
            'route' => 'users.index',
            'prefix' => 'users',
            'icon' => 'users',
            'managerHidden' => true,
            'children' => [
                ['label' => 'All Users', 'route' => 'users.index'],
                ['label' => 'New User', 'route' => 'users.create'],
            ],
        ],
        [
            'label' => 'Incident Form',
            'route' => 'forms.incident.index',
            'prefix' => 'forms.incident',
            'icon' => 'clipboard-list',
        ],
        [
            'label' => 'Medication Form',
            'route' => 'forms.medication.index',
            'prefix' => 'forms.medication',
            'icon' => 'clipboard-list',
        ],
        [
            'label' => 'Public Complaint',
            'route' => 'forms.complaint.index',
            'prefix' => 'forms.complaint',
            'icon' => 'message-square-warning',
        ],

        [
            'label' => 'Surveys',
            'route' => 'surveys.index',
            'prefix' => 'surveys',
            'icon' => 'vote',
            'children' => [
                ['label' => 'Customer', 'route' => 'surveys.customer'],
                ['label' => 'Staff', 'route' => 'surveys.staff'],
            ],
        ],
        // ['label' => 'Reports',          'route' => 'reports.index',  'icon' => 'bar-chart-3', 'staffHidden' => true],
        ['label' => 'Activity Logs', 'route' => 'activity.index', 'icon' => 'activity', 'managerHidden' => true],
        ['label' => 'Signature Banner', 'route' => 'banner.index', 'icon' => 'image'],
    ];

    // Match against 'prefix' when set so any sub-route (create/show/edit/update/destroy)
    // keeps the parent nav item highlighted.
    $isActive = function (string $pattern): bool {
        return request()->routeIs($pattern) || request()->routeIs($pattern . '.*');
    };

@endphp

<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-ink-900 border-r border-slate-200 dark:border-ink-800 -translate-x-full lg:translate-x-0 transition-transform overflow-y-auto">
    <div class="h-16 flex items-center gap-2 px-5 border-b border-slate-100 dark:border-ink-800">
        {{-- logo --}}
        <img src={{ asset('assets/logo.png') }} alt="Infinite Ability" class="h-9 w-auto" />
        <button type="button" onclick="document.getElementById('sidebar').classList.add('-translate-x-full')"
            class="lg:hidden ml-auto p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-ink-800">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    <nav class="p-3 space-y-1 text-sm pb-28">
        @foreach ($nav as $item)
            @php
                $matchOn = $item['prefix'] ?? $item['route'];
                $parentActive = $isActive($matchOn);
                $childActive = collect($item['children'] ?? [])->contains(
                    fn($c) => $isActive($c['prefix'] ?? $c['route']),
                );
                $open = $parentActive || $childActive;
            @endphp

            @if ((!empty($item['managerHidden']) && $isManager) || (!empty($item['staffHidden']) && $isStaff))
                {{-- hidden by role --}}
            @elseif (empty($item['children']))
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                  {{ $parentActive
                      ? 'bg-brand-50 dark:bg-brand-600/20 text-brand-700 dark:text-brand-300 font-semibold'
                      : 'text-slate-600 dark:text-ink-300 hover:bg-slate-50 dark:hover:bg-ink-800' }}">
                    <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>{{ $item['label'] }}
                </a>
            @else
                <details {{ $open ? 'open' : '' }} class="group">
                    <summary
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer list-none
                          {{ $open
                              ? 'bg-brand-50 dark:bg-brand-600/20 text-brand-700 dark:text-brand-300 font-semibold'
                              : 'text-slate-600 dark:text-ink-300 hover:bg-slate-50 dark:hover:bg-ink-800' }}">
                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                        <span class="flex-1">{{ $item['label'] }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="mt-1 ml-7 pl-3 border-l border-slate-200 dark:border-ink-800 space-y-0.5">
                        @foreach ($item['children'] as $child)
                            @php $ca = $isActive($child['route']); @endphp
                            <a href="{{ route($child['route']) }}"
                                class="block px-3 py-2 rounded-md text-[13px]
                        {{ $ca
                            ? 'text-brand-700 dark:text-brand-300 font-medium bg-brand-50/60 dark:bg-brand-600/10'
                            : 'text-slate-500 dark:text-ink-400 hover:bg-slate-50 dark:hover:bg-ink-800 hover:text-slate-800 dark:hover:text-ink-100' }}">
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @endif
        @endforeach
    </nav>

    <div class="absolute bottom-0 inset-x-0 p-3 border-t border-slate-100 dark:border-ink-800 bg-white dark:bg-ink-900">
        <a href="{{ route('profile') }}"
            class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-ink-800">

            <img src="{{ asset('assets/user.png') }}"
                class="w-10 h-10 rounded-full bg-slate-100 dark:bg-ink-700 ring-2 ring-slate-200 dark:ring-slate-600 shadow-sm object-cover p-1 dark:brightness-110 dark:contrast-125"
                alt="{{ auth()->user()->name ?? 'User' }}">

            <div class="text-sm">
                <div class="font-medium">
                    {{ auth()->user()->name ?? 'Default Name' }}
                </div>

                <div class="text-xs text-slate-500 dark:text-ink-400">
                    {{ auth()->user()->role->name ?? 'Administrator' }}
                </div>
            </div>
        </a>
    </div>
</aside>
