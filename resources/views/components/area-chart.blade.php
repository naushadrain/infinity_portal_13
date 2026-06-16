{{--
|--------------------------------------------------------------------------
| Component: area-chart
|--------------------------------------------------------------------------
| Lightweight SVG area chart. Pass labeled series to render gradient-filled trends.
--}}
@props([
  'title' => 'Form submissions',
  'subtitle' => 'Daily activity',
  'series' => [
    // ['name'=>'Perth','color'=>'#4f46e5','gradId'=>'gPerth','area'=>'...','line'=>'...'],
  ],
  'labels' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
  'ranges' => ['Week','Month','Year'],
])
<x-card :title="$title" :subtitle="$subtitle" class="{{ $attributes->get('class') }}">
  <x-slot:action>
    <div class="flex items-center gap-3 flex-wrap">
      <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-ink-400">
        @foreach($series as $s)
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full" style="background:{{ $s['color'] }}"></span>{{ $s['name'] }}</span>
        @endforeach
      </div>
      <div class="flex gap-0.5 p-0.5 bg-slate-100 dark:bg-ink-800 rounded-lg text-xs">
        @foreach($ranges as $i => $r)
          <button class="px-3 py-1 rounded-md {{ $i===0 ? 'bg-white dark:bg-ink-700 shadow-sm font-medium' : 'text-slate-500 dark:text-ink-400' }}">{{ $r }}</button>
        @endforeach
      </div>
    </div>
  </x-slot:action>

  <div class="relative">
    <svg viewBox="0 0 700 240" class="w-full h-48 sm:h-60" preserveAspectRatio="none">
      <defs>
        @foreach($series as $s)
          <linearGradient id="{{ $s['gradId'] }}" x1="0" x2="0" y1="0" y2="1">
            <stop offset="0%" stop-color="{{ $s['color'] }}" stop-opacity="0.32"/>
            <stop offset="100%" stop-color="{{ $s['color'] }}" stop-opacity="0"/>
          </linearGradient>
        @endforeach
      </defs>
      <g class="stroke-slate-100 dark:stroke-ink-800" stroke-width="1">
        <line x1="0" y1="40" x2="700" y2="40"/><line x1="0" y1="100" x2="700" y2="100"/>
        <line x1="0" y1="160" x2="700" y2="160"/><line x1="0" y1="220" x2="700" y2="220"/>
      </g>
      @foreach($series as $s)
        <path d="{{ $s['area'] }}" fill="url(#{{ $s['gradId'] }})"/>
        <polyline fill="none" stroke="{{ $s['color'] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="{{ $s['line'] }}"/>
      @endforeach
    </svg>
  </div>
  <div class="flex justify-between text-[11px] text-slate-400 dark:text-ink-500 mt-2 px-1">
    @foreach($labels as $l)<span>{{ $l }}</span>@endforeach
  </div>
</x-card>
