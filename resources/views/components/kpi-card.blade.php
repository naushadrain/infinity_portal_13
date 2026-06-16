{{--
|--------------------------------------------------------------------------
| Component: kpi-card
|--------------------------------------------------------------------------
| KPI metric tile with icon, value, delta badge and sparkline.
--}}
@props([
  'label',
  'value',
  'icon' => 'activity',
  'accent' => 'brand',           // brand|emerald|amber|rose|slate
  'delta' => null,               // e.g. "+12%" or "-3"
  'deltaUp' => true,
  'color' => '#4f46e5',          // sparkline stroke
  'points' => '0,18 14,15 28,17 42,10 56,12 70,8 84,9 100,4',
])
<div class="bg-white dark:bg-ink-900 rounded-2xl p-4 sm:p-5 shadow-soft border border-slate-100 dark:border-ink-800 hover:shadow-md hover:-translate-y-0.5 transition">
  <div class="flex items-center justify-between">
    <div class="w-10 h-10 rounded-xl bg-{{ $accent }}-50 dark:bg-{{ $accent }}-500/15 text-{{ $accent }}-600 dark:text-{{ $accent }}-300 grid place-items-center">
      <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
    </div>
    @if($delta)
      <span class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1">
        <i data-lucide="{{ $deltaUp ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>{{ $delta }}
      </span>
    @endif
  </div>
  <div class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">{{ $value }}</div>
  <div class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">{{ $label }}</div>
  <svg viewBox="0 0 100 24" class="w-full h-6 mt-3" preserveAspectRatio="none">
    <polyline fill="none" stroke="{{ $color }}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" points="{{ $points }}"/>
  </svg>
</div>
