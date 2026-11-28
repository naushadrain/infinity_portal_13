{{--
|--------------------------------------------------------------------------
| Page: Laravel Logs (developer)
|--------------------------------------------------------------------------
| Live, readable view of storage/logs/*.log. Entries are loaded as JSON
| from logs.entries and new lines are polled by byte offset.
--}}
@extends('layouts.app', ['title' => 'Laravel Logs'])
@section('title', 'Laravel Logs')
@section('content')

@php $currentFile = request('file', $files[0]['name'] ?? null); @endphp

{{-- Header --}}
<div class="flex flex-wrap items-start justify-between gap-3 mb-5">
    <div>
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i data-lucide="terminal-square" class="w-5 h-5 text-brand-600 dark:text-brand-400"></i>
            Laravel Logs
        </h2>
        <p class="text-sm text-slate-500 dark:text-ink-400">
            <span id="fileMeta">storage/logs/{{ $currentFile ?? '—' }}</span>
            · log level <code class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-ink-800 text-xs">{{ $logLevel }}</code>
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        @if (count($files) > 1)
            <select id="fileSelect"
                class="px-3 py-2 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 text-sm">
                @foreach ($files as $f)
                    <option value="{{ $f['name'] }}" @selected($f['name'] === $currentFile)>
                        {{ $f['name'] }} ({{ $f['size'] }})
                    </option>
                @endforeach
            </select>
        @endif

        <button type="button" id="liveBtn"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border text-sm font-medium transition">
            <span id="liveDot" class="relative flex h-2.5 w-2.5">
                <span class="live-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
            <span id="liveLabel">Live</span>
        </button>

        <button type="button" id="refreshBtn" title="Reload"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 hover:bg-slate-50 dark:hover:bg-ink-800">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
        </button>

        @if ($currentFile)
            <a href="{{ route('logs.download', ['file' => $currentFile]) }}" title="Download"
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 dark:border-ink-800 bg-white dark:bg-ink-900 hover:bg-slate-50 dark:hover:bg-ink-800">
                <i data-lucide="download" class="w-4 h-4"></i>
            </a>

            <form method="POST" action="{{ route('logs.clear') }}"
                onsubmit="return confirm('Clear {{ $currentFile }}? All log entries in this file will be deleted.')">
                @csrf
                <input type="hidden" name="file" value="{{ $currentFile }}">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Clear
                </button>
            </form>
        @endif
    </div>
</div>

@if (! $currentFile)
    <div class="bg-white dark:bg-ink-900 rounded-2xl border border-slate-100 dark:border-ink-800 p-14 text-center text-sm text-slate-500 dark:text-ink-400">
        <i data-lucide="file-check-2" class="w-10 h-10 mx-auto mb-3 text-emerald-500"></i>
        No log files in <code>storage/logs</code> yet. That's a good sign.
    </div>
@else

{{-- Level summary (click to filter) --}}
<div id="levelChips" class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2 mb-4"></div>

{{-- Toolbar --}}
<div class="bg-white dark:bg-ink-900 rounded-2xl shadow-soft border border-slate-100 dark:border-ink-800 mb-4 p-3 flex flex-wrap items-center gap-2">
    <div class="flex items-center gap-2 flex-1 min-w-[220px] bg-slate-50 dark:bg-ink-800 rounded-lg px-3 py-2">
        <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
        <input id="searchInput" class="bg-transparent text-sm outline-none flex-1"
            placeholder="Search message, exception, file… (press / to focus)">
    </div>
    <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-ink-300 px-2 cursor-pointer select-none">
        <input type="checkbox" id="vendorToggle" class="accent-brand-600"> Show vendor frames
    </label>
    <span id="statusText" class="text-xs text-slate-400 dark:text-ink-500 ml-auto"></span>
</div>

<div id="truncNote" class="hidden mb-3 text-xs text-slate-500 dark:text-ink-400 flex items-center gap-1.5">
    <i data-lucide="info" class="w-3.5 h-3.5"></i>
    Showing the most recent entries only (last 1 MB of the file). Download the file for the full history.
</div>

{{-- Entries --}}
<div id="entries" class="space-y-2"></div>

<div id="emptyState" class="hidden bg-white dark:bg-ink-900 rounded-2xl border border-slate-100 dark:border-ink-800 p-14 text-center text-sm text-slate-500 dark:text-ink-400">
    <i data-lucide="search-x" class="w-9 h-9 mx-auto mb-3 opacity-50"></i>
    <p id="emptyText">No log entries.</p>
</div>

@endif

<style>
    .log-entry.flash { animation: logflash 2.5s ease-out; }
    @keyframes logflash { from { box-shadow: 0 0 0 2px rgb(99 102 241 / .7); } to { box-shadow: 0 0 0 2px transparent; } }
    .log-msg { white-space: pre-wrap; word-break: break-word; }
    .log-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; }
</style>

@if ($currentFile)
@push('scripts')
<script>
(function () {
    const ENTRIES_URL = @json(route('logs.entries'));
    const FILE = @json($currentFile);
    const POLL_MS = 5000;

    const LEVELS = {
        emergency: { label: 'Emergency', bar: 'bg-red-700',    badge: 'bg-red-700 text-white' },
        alert:     { label: 'Alert',     bar: 'bg-red-600',    badge: 'bg-red-600 text-white' },
        critical:  { label: 'Critical',  bar: 'bg-red-600',    badge: 'bg-red-600 text-white' },
        error:     { label: 'Error',     bar: 'bg-rose-500',   badge: 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300' },
        warning:   { label: 'Warning',   bar: 'bg-amber-500',  badge: 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300' },
        notice:    { label: 'Notice',    bar: 'bg-sky-500',    badge: 'bg-sky-100 text-sky-700 dark:bg-sky-500/15 dark:text-sky-300' },
        info:      { label: 'Info',      bar: 'bg-blue-500',   badge: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300' },
        debug:     { label: 'Debug',     bar: 'bg-slate-400',  badge: 'bg-slate-100 text-slate-600 dark:bg-ink-800 dark:text-ink-300' },
    };
    const CHIP_ORDER = ['all', 'emergency', 'critical', 'error', 'warning', 'info', 'debug'];

    let entries = [];
    let offset = null;
    let live = localGet('logs.live', '1') === '1';
    let levelFilter = 'all';
    let search = '';
    let showVendor = localGet('logs.vendor', '0') === '1';
    let timer = null;
    let busy = false;
    let lastCheck = null;
    const openIds = new Set();

    const $ = id => document.getElementById(id);
    const list = $('entries');

    function localGet(k, d) { try { return localStorage.getItem(k) ?? d; } catch (e) { return d; } }
    function localSet(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }

    function esc(s) {
        return String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    function ago(time) {
        const d = new Date(time.replace(' ', 'T'));
        const s = Math.round((Date.now() - d.getTime()) / 1000);
        if (isNaN(s)) return '';
        if (s < 60) return 'just now';
        if (s < 3600) return Math.floor(s / 60) + 'm ago';
        if (s < 86400) return Math.floor(s / 3600) + 'h ago';
        return Math.floor(s / 86400) + 'd ago';
    }

    function idOf(e) { return e.time + '|' + e.message.slice(0, 80); }

    async function load(initial) {
        if (busy) return;
        busy = true;
        try {
            const params = new URLSearchParams({ file: FILE });
            if (!initial && offset !== null) params.set('offset', offset);
            const res = await fetch(ENTRIES_URL + '?' + params, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();

            if (initial || data.reset) {
                entries = data.entries;
                $('truncNote').classList.toggle('hidden', !data.truncated);
                render(new Set());
            } else if (data.entries.length) {
                const fresh = new Set(data.entries.map(idOf));
                entries = data.entries.concat(entries).slice(0, 1000);
                render(fresh);
            }

            offset = data.offset;
            lastCheck = new Date();
            $('fileMeta').textContent = 'storage/logs/' + data.file + ' · ' + data.sizeHuman;
            updateStatus();
        } catch (err) {
            $('statusText').textContent = 'Failed to load logs (' + err.message + ')';
        } finally {
            busy = false;
        }
    }

    function filtered() {
        const q = search.toLowerCase();
        return entries.filter(e => {
            if (levelFilter !== 'all') {
                const group = levelFilter === 'critical' ? ['critical', 'alert'] : [levelFilter];
                if (!group.includes(e.level)) return false;
            }
            if (!q) return true;
            return (e.message + ' ' + (e.exception || '') + ' ' + (e.location ? e.location.file : '') + ' ' + e.raw)
                .toLowerCase().includes(q);
        });
    }

    function renderChips() {
        const counts = { all: entries.length };
        entries.forEach(e => {
            const k = e.level === 'alert' ? 'critical' : (e.level === 'notice' ? 'info' : e.level);
            counts[k] = (counts[k] || 0) + 1;
        });

        $('levelChips').innerHTML = CHIP_ORDER.map(k => {
            const lv = LEVELS[k];
            const active = levelFilter === k;
            return `<button type="button" data-level="${k}"
                class="text-left rounded-xl border px-3 py-2 transition ${active
                    ? 'border-brand-500 ring-2 ring-brand-100 dark:ring-brand-900 bg-white dark:bg-ink-900'
                    : 'border-slate-100 dark:border-ink-800 bg-white dark:bg-ink-900 hover:border-slate-300 dark:hover:border-ink-700'}">
                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-ink-400">
                    <span class="w-2 h-2 rounded-full ${lv ? lv.bar : 'bg-brand-500'}"></span>${lv ? lv.label : 'All'}
                </div>
                <div class="text-lg font-bold tabular-nums">${counts[k] || 0}</div>
            </button>`;
        }).join('');
    }

    function frameHtml(f) {
        if (f.vendor && !showVendor) return '';
        return `<div class="flex gap-3 px-3 py-1.5 ${f.vendor ? 'text-slate-400 dark:text-ink-500' : 'bg-brand-50/60 dark:bg-brand-600/10 text-slate-800 dark:text-ink-100'}">
            <span class="w-7 shrink-0 text-right opacity-60">#${f.n}</span>
            <div class="min-w-0">
                ${f.file ? `<div class="${f.vendor ? '' : 'font-semibold'} break-all">${esc(f.file)}<span class="opacity-70">:${f.line}</span></div>` : ''}
                <div class="break-all opacity-80">${esc(f.call)}</div>
            </div>
        </div>`;
    }

    function entryHtml(e, isNew) {
        const lv = LEVELS[e.level] || LEVELS.debug;
        const id = idOf(e);
        const open = openIds.has(id);
        const appFrames = e.frames.filter(f => !f.vendor).length;
        const hidden = e.frames.length - appFrames;
        const hasDetails = e.frames.length || e.context || e.extra;

        return `<article class="log-entry ${isNew ? 'flash' : ''} relative overflow-hidden bg-white dark:bg-ink-900 rounded-xl border border-slate-100 dark:border-ink-800 shadow-soft" data-id="${esc(id)}">
            <span class="absolute left-0 inset-y-0 w-1 ${lv.bar}"></span>
            <div class="pl-4 pr-3 py-3">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-2 py-0.5 rounded-full font-semibold uppercase tracking-wide ${lv.badge}">${lv.label}</span>
                    <span class="text-slate-500 dark:text-ink-400 log-mono" title="${esc(e.time)}">${esc(e.time)}</span>
                    <span class="text-slate-400 dark:text-ink-500">· ${ago(e.time)}</span>
                    <span class="text-slate-400 dark:text-ink-500">· ${esc(e.env)}</span>
                    ${isNew ? '<span class="px-1.5 py-0.5 rounded bg-brand-600 text-white font-semibold">NEW</span>' : ''}
                    <div class="ml-auto flex items-center gap-1">
                        <button type="button" data-act="copy" title="Copy full entry"
                            class="w-7 h-7 grid place-items-center rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 dark:hover:bg-ink-800 dark:hover:text-white">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        </button>
                        ${hasDetails ? `<button type="button" data-act="toggle"
                            class="inline-flex items-center gap-1 px-2 h-7 rounded-md text-slate-500 hover:bg-slate-100 dark:text-ink-300 dark:hover:bg-ink-800">
                            ${open ? 'Hide' : 'Details'}
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition ${open ? 'rotate-180' : ''}"></i>
                        </button>` : ''}
                    </div>
                </div>

                ${e.exception ? `<div class="mt-2 text-xs font-semibold text-rose-600 dark:text-rose-400 log-mono break-all">${esc(e.exception)}</div>` : ''}
                <div class="mt-1 text-sm font-medium text-slate-800 dark:text-ink-100 log-msg ${open ? '' : 'line-clamp-3'}">${esc(e.message) || '<span class="italic text-slate-400">(empty message)</span>'}</div>

                ${e.location ? `<div class="mt-2 inline-flex items-center gap-1.5 text-xs log-mono px-2 py-1 rounded-md bg-slate-50 dark:bg-ink-800 text-slate-600 dark:text-ink-300 break-all">
                    <i data-lucide="file-code-2" class="w-3.5 h-3.5 shrink-0"></i>${esc(e.location.file)}<span class="text-brand-600 dark:text-brand-400 font-semibold">:${e.location.line}</span>
                </div>` : ''}

                ${open ? `<div class="mt-3 space-y-3">
                    ${e.context ? `<div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-ink-400 mb-1">Context</div>
                        <pre class="log-mono text-xs rounded-lg bg-slate-50 dark:bg-ink-950 border border-slate-100 dark:border-ink-800 p-3 overflow-x-auto">${esc(JSON.stringify(e.context, null, 2))}</pre>
                    </div>` : ''}
                    ${e.extra ? `<div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-ink-400 mb-1">More</div>
                        <pre class="log-mono text-xs rounded-lg bg-slate-50 dark:bg-ink-950 border border-slate-100 dark:border-ink-800 p-3 overflow-x-auto whitespace-pre-wrap break-all">${esc(e.extra)}</pre>
                    </div>` : ''}
                    ${e.frames.length ? `<div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-ink-400 mb-1">
                            Stack trace · ${appFrames} app ${appFrames === 1 ? 'frame' : 'frames'}${!showVendor && hidden ? ` <span class="normal-case font-normal">(${hidden} vendor hidden)</span>` : ''}
                        </div>
                        <div class="log-mono text-xs rounded-lg border border-slate-100 dark:border-ink-800 divide-y divide-slate-100 dark:divide-ink-800 overflow-hidden">
                            ${e.frames.map(frameHtml).join('') || '<div class="px-3 py-2 text-slate-400">Only vendor frames — enable “Show vendor frames”.</div>'}
                        </div>
                    </div>` : ''}
                </div>` : ''}
            </div>
        </article>`;
    }

    function render(fresh) {
        renderChips();
        const rows = filtered();
        list.innerHTML = rows.map(e => entryHtml(e, fresh.has(idOf(e)))).join('');
        $('emptyState').classList.toggle('hidden', rows.length > 0);
        $('emptyText').textContent = entries.length ? 'No entries match your filter.' : 'This log file is empty.';
        if (window.lucide) lucide.createIcons();
        updateStatus();
    }

    function updateStatus() {
        const shown = filtered().length;
        const t = lastCheck ? lastCheck.toLocaleTimeString() : '—';
        $('statusText').textContent = `${shown} of ${entries.length} entries · ${live ? 'live, ' : 'paused, '}checked ${t}`;
    }

    function setLive(on) {
        live = on;
        localSet('logs.live', on ? '1' : '0');
        const btn = $('liveBtn');
        btn.className = 'inline-flex items-center gap-2 px-3 py-2 rounded-lg border text-sm font-medium transition ' + (on
            ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300'
            : 'border-slate-200 bg-white text-slate-600 dark:border-ink-800 dark:bg-ink-900 dark:text-ink-300');
        $('liveLabel').textContent = on ? 'Live' : 'Paused';
        btn.querySelector('.live-ping').classList.toggle('hidden', !on);
        btn.querySelector('#liveDot span:last-child').className = 'relative inline-flex rounded-full h-2.5 w-2.5 ' + (on ? 'bg-emerald-500' : 'bg-slate-400');
        clearInterval(timer);
        if (on) timer = setInterval(() => { if (!document.hidden) load(false); }, POLL_MS);
        updateStatus();
    }

    // Events
    $('liveBtn').addEventListener('click', () => setLive(!live));
    $('refreshBtn').addEventListener('click', () => load(true));
    $('fileSelect')?.addEventListener('change', e => {
        location.href = @json(route('logs.index')) + '?file=' + encodeURIComponent(e.target.value);
    });

    let debounce;
    $('searchInput').addEventListener('input', e => {
        clearTimeout(debounce);
        debounce = setTimeout(() => { search = e.target.value.trim(); render(new Set()); }, 150);
    });

    $('vendorToggle').checked = showVendor;
    $('vendorToggle').addEventListener('change', e => {
        showVendor = e.target.checked;
        localSet('logs.vendor', showVendor ? '1' : '0');
        render(new Set());
    });

    $('levelChips').addEventListener('click', e => {
        const b = e.target.closest('[data-level]');
        if (!b) return;
        levelFilter = b.dataset.level;
        render(new Set());
    });

    list.addEventListener('click', async e => {
        const btn = e.target.closest('[data-act]');
        if (!btn) return;
        const card = btn.closest('.log-entry');
        const id = card.dataset.id;
        const entry = entries.find(x => idOf(x) === id);
        if (!entry) return;

        if (btn.dataset.act === 'toggle') {
            openIds.has(id) ? openIds.delete(id) : openIds.add(id);
            render(new Set());
        } else if (btn.dataset.act === 'copy') {
            try {
                await navigator.clipboard.writeText(`[${entry.time}] ${entry.env}.${entry.level.toUpperCase()}: ${entry.raw}`);
                btn.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i>';
                lucide.createIcons();
                setTimeout(() => { btn.innerHTML = '<i data-lucide="copy" class="w-3.5 h-3.5"></i>'; lucide.createIcons(); }, 1500);
            } catch (err) {}
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
            e.preventDefault();
            $('searchInput').focus();
        }
    });

    // Refresh relative times every 30s
    setInterval(() => { if (!document.hidden) render(new Set()); }, 30000);

    load(true);
    setLive(live);
})();
</script>
@endpush
@endif

@endsection
