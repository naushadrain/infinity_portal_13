{{--
|--------------------------------------------------------------------------
| Component: data-table
|--------------------------------------------------------------------------
| Responsive data table with desktop columns and a mobile card fallback.
--}}
@props([
  'title' => null,
  'subtitle' => null,
  'viewAllUrl' => null,
  'columns' => [],   // ['Ref','Type',...]
  'rows' => [],      // [['cells'=>[...], 'mobile' => ['title'=>..,'subtitle'=>..,'meta'=>..,'status'=>..]]]
])
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 overflow-hidden">
  @if($title || $viewAllUrl)
  <div class="p-5 flex items-center justify-between border-b border-slate-100 dark:border-ink-800">
    <div>
      @if($title)<h3 class="font-semibold">{{ $title }}</h3>@endif
      @if($subtitle)<p class="text-xs text-slate-500 dark:text-ink-400 mt-0.5">{{ $subtitle }}</p>@endif
    </div>
    @if($viewAllUrl)
      <a href="{{ $viewAllUrl }}" class="text-xs font-semibold text-brand-600 dark:text-brand-300 hover:text-brand-700 inline-flex items-center gap-1">View all <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></a>
    @endif
  </div>
  @endif

  {{-- Desktop / tablet --}}
  <div class="hidden sm:block overflow-x-auto scrollbar-thin">
    <table class="w-full text-sm">
      <thead class="bg-slate-50/60 dark:bg-ink-800/60 text-[11px] uppercase tracking-wider text-slate-500 dark:text-ink-400">
        <tr>
          @foreach($columns as $c)<th class="text-left font-semibold px-5 py-3">{{ $c }}</th>@endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $r)
          <tr class="border-t border-slate-100 dark:border-ink-800 hover:bg-slate-50/60 dark:hover:bg-ink-800/40">
            @foreach($r['cells'] as $cell)
              <td class="px-5 py-3">{!! $cell !!}</td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Mobile: stacked cards --}}
  <ul class="sm:hidden divide-y divide-slate-100 dark:divide-ink-800">
    @foreach($rows as $r)
      @php $m = $r['mobile'] ?? null; @endphp
      <li class="p-4">
        <div class="flex items-center justify-between gap-3">
          <div class="font-semibold text-sm">{{ $m['title'] ?? '' }}</div>
          @if(!empty($m['status']))<x-status-badge :status="$m['status']" />@endif
        </div>
        @if(!empty($m['subtitle']))<div class="mt-1 text-sm">{{ $m['subtitle'] }}</div>@endif
        @if(!empty($m['meta']))<div class="mt-0.5 text-xs text-slate-500 dark:text-ink-400">{{ $m['meta'] }}</div>@endif
      </li>
    @endforeach
  </ul>
</div>
