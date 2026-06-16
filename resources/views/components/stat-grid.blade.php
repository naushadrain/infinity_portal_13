{{--
|--------------------------------------------------------------------------
| Component: stat-grid
|--------------------------------------------------------------------------
| Responsive grid container for KPI cards and small stats.
--}}
@props(['cols' => '2 lg:4'])
@php
  [$base, $lg] = array_pad(explode(' ', $cols), 2, null);
  $baseCls = 'grid-cols-'.$base;
  $lgCls = $lg ? 'lg:'.$lg : '';
@endphp
<div class="grid {{ $baseCls }} {{ $lgCls }} gap-3 sm:gap-4 {{ $attributes->get('class') }}">
  {{ $slot }}
</div>
