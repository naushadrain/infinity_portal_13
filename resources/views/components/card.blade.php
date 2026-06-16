{{--
|--------------------------------------------------------------------------
| Component: card
|--------------------------------------------------------------------------
| Generic content card with optional title/subtitle/actions slots.
--}}
@props([
  'title' => null,
  'subtitle' => null,
  'action' => null,
  'padding' => 'p-4 sm:p-6',
])
<div {{ $attributes->class(['bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800']) }}>
  @if($title || $subtitle || $action)
    <div class="flex items-center justify-between gap-3 {{ $padding }} pb-0">
      <div>
        @if($title)<h3 class="font-semibold">{{ $title }}</h3>@endif
        @if($subtitle)<p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">{{ $subtitle }}</p>@endif
      </div>
      @if($action)<div>{{ $action }}</div>@endif
    </div>
  @endif
  <div class="{{ $padding }}">{{ $slot }}</div>
</div>
