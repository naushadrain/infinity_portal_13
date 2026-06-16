{{--
|--------------------------------------------------------------------------
| Component: donut
|--------------------------------------------------------------------------
| SVG donut chart for proportional breakdowns.
--}}
@props([
  'title' => 'Forms by type',
  'subtitle' => 'Last 30 days',
  'total' => 0,
  'segments' => [], // [['label'=>..,'value'=>..,'color'=>'#..','accent'=>'brand']]
])
@php
  $offset = 0;
@endphp
<x-card :title="$title" :subtitle="$subtitle" class="{{ $attributes->get('class') }}">
  <div class="flex flex-col sm:flex-row items-center gap-6">
    <div class="relative w-32 h-32 shrink-0">
      <svg viewBox="0 0 36 36" class="w-32 h-32 -rotate-90">
        <circle cx="18" cy="18" r="15.915" fill="none" class="stroke-slate-100 dark:stroke-ink-800" stroke-width="3.5"/>
        @foreach($segments as $seg)
          @php
            $pct = $total > 0 ? round($seg['value']/$total*100) : 0;
            $dash = $pct.' '.(100-$pct);
            $dashoff = -$offset;
            $offset += $pct;
          @endphp
          <circle cx="18" cy="18" r="15.915" fill="none" stroke="{{ $seg['color'] }}" stroke-width="3.5" stroke-dasharray="{{ $dash }}" stroke-dashoffset="{{ $dashoff }}" stroke-linecap="round"/>
        @endforeach
      </svg>
      <div class="absolute inset-0 grid place-items-center text-center">
        <div><div class="text-2xl font-bold leading-none">{{ number_format($total) }}</div><div class="text-[10px] text-slate-500 dark:text-ink-400 mt-1">Total</div></div>
      </div>
    </div>
    <ul class="text-sm space-y-2 flex-1 w-full">
      @foreach($segments as $seg)
        <li class="flex items-center justify-between"><span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full" style="background:{{ $seg['color'] }}"></span>{{ $seg['label'] }}</span><span class="font-medium">{{ number_format($seg['value']) }}</span></li>
      @endforeach
    </ul>
  </div>
</x-card>
