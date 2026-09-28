<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Operations</p>
            <h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">System tools</h1>
            <p class="mt-1 max-w-2xl text-[13px] text-ink-muted">Maintain framework caches, inspect the runtime and verify writable application directories.</p>
        </div>
        <div class="flex flex-wrap gap-2"><x-sysadmin::btn href="{{ route('sysadmin.media.code.robot') }}">{!! \Modules\SysAdmin\Support\Icon::get('bot', 'h-4 w-4') !!} Edit robots.txt</x-sysadmin::btn><x-sysadmin::btn href="{{ route('sysadmin.media.sitemap.index') }}">{!! \Modules\SysAdmin\Support\Icon::get('map', 'h-4 w-4') !!} Manage sitemap</x-sysadmin::btn></div>
    </div>

    <div class="flex gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[12px] text-amber-950">
        <span class="mt-0.5 shrink-0 text-amber-600">{!! \Modules\SysAdmin\Support\Icon::get('info', 'h-4 w-4') !!}</span>
        <div><strong class="block">Use production tools deliberately.</strong><span class="mt-0.5 block text-amber-800">An optimization or cache clear may briefly make the next request slower while Laravel rebuilds its cached files.</span></div>
    </div>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(320px,.75fr)]">
        <x-sysadmin::card>
            <div class="border-b border-hairline px-5 py-4">
                <h2 class="text-base font-bold text-ink">Laravel maintenance</h2>
                <p class="mt-1 text-xs text-ink-muted">Only the fixed, permission-protected commands below can be executed.</p>
            </div>
            <div class="grid gap-3 p-5 md:grid-cols-2">
                @foreach($commands as $key => $tool)
                    <button
                        type="button"
                        wire:click="runCommand('{{ $key }}')"
                        wire:loading.attr="disabled"
                        wire:target="runCommand('{{ $key }}')"
                        class="group flex min-h-28 items-start gap-3 rounded-xl border border-hairline p-4 text-left transition hover:border-primary-200 hover:bg-primary-50/50 disabled:cursor-wait disabled:opacity-60"
                    >
                        <span class="grid size-9 shrink-0 place-items-center rounded-lg {{ $tool['tone'] === 'success' ? 'bg-emerald-50 text-emerald-600' : ($tool['tone'] === 'primary' ? 'bg-primary-50 text-primary' : 'bg-slate-100 text-ink-soft') }}">
                            <span wire:loading.remove wire:target="runCommand('{{ $key }}')">{!! \Modules\SysAdmin\Support\Icon::get($key === 'optimize' ? 'bolt' : 'refresh', 'h-4 w-4') !!}</span>
                            <span wire:loading wire:target="runCommand('{{ $key }}')" class="size-4 animate-spin rounded-full border-2 border-current border-r-transparent"></span>
                        </span>
                        <span><strong class="block text-[13px] text-ink">{{ $tool['label'] }}</strong><small class="mt-1 block text-[11px] leading-5 text-ink-muted">{{ $tool['description'] }}</small></span>
                    </button>
                @endforeach
            </div>
        </x-sysadmin::card>

        <div class="grid content-start gap-5">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">Runtime</h2><p class="mt-1 text-xs text-ink-muted">Current application environment.</p></div>
                <dl class="divide-y divide-hairline px-5">
                    @foreach($environment as $item)
                        <div class="flex items-center justify-between gap-4 py-3 text-[12px]"><dt class="text-ink-muted">{{ $item['label'] }}</dt><dd class="font-semibold text-ink">{{ $item['value'] }}</dd></div>
                    @endforeach
                </dl>
            </x-sysadmin::card>

            <a href="{{ route('sysadmin.media.sitemap.index') }}" class="group rounded-xl border border-primary-100 bg-gradient-to-br from-primary-50 to-white p-5 shadow-sm transition hover:border-primary-200">
                <span class="grid size-10 place-items-center rounded-xl bg-white text-primary shadow-sm">{!! \Modules\SysAdmin\Support\Icon::get('map', 'h-5 w-5') !!}</span>
                <h2 class="mt-4 text-[15px] font-bold text-ink">XML sitemap</h2>
                <p class="mt-1 text-xs leading-5 text-ink-muted">Generate storefront, catalog, CMS and blog URLs for search engines.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-primary">Open sitemap manager <span aria-hidden="true">→</span></span>
            </a>

            <a href="{{ route('sysadmin.media.code.robot') }}" class="group rounded-xl border border-sky-100 bg-gradient-to-br from-sky-50 to-white p-5 shadow-sm transition hover:border-sky-200">
                <span class="grid size-10 place-items-center rounded-xl bg-white text-sky-700 shadow-sm">{!! \Modules\SysAdmin\Support\Icon::get('bot', 'h-5 w-5') !!}</span>
                <h2 class="mt-4 text-[15px] font-bold text-ink">robots.txt</h2>
                <p class="mt-1 text-xs leading-5 text-ink-muted">Manage crawler access rules and advertise the XML sitemap.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-sky-700">Open robots editor <span aria-hidden="true">→</span></span>
            </a>
        </div>
    </div>

    <x-sysadmin::card>
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4">
            <div><h2 class="text-base font-bold text-ink">Directory health</h2><p class="mt-1 text-xs text-ink-muted">Laravel must be able to write to these paths.</p></div>
            <x-sysadmin::btn wire:click="prepareDirectories" wire:loading.attr="disabled" wire:target="prepareDirectories">
                <span wire:loading.remove wire:target="prepareDirectories">Prepare directories</span><span wire:loading wire:target="prepareDirectories">Preparing…</span>
            </x-sysadmin::btn>
        </div>
        <div class="grid gap-px bg-hairline sm:grid-cols-2 xl:grid-cols-3">
            @foreach($directories as $directory)
                <div class="flex items-start gap-3 bg-white p-4">
                    <span class="grid size-8 shrink-0 place-items-center rounded-lg {{ $directory['writable'] ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">{!! \Modules\SysAdmin\Support\Icon::get($directory['writable'] ? 'check' : 'info', 'h-4 w-4') !!}</span>
                    <div class="min-w-0"><p class="text-[12.5px] font-bold text-ink">{{ $directory['label'] }}</p><p class="mt-0.5 truncate font-mono text-[10px] text-ink-muted" title="{{ $directory['path'] }}">{{ $directory['path'] }}</p><p class="mt-1 text-[10px] font-semibold {{ $directory['writable'] ? 'text-emerald-700' : 'text-red-700' }}">{{ ! $directory['exists'] ? 'Missing' : ($directory['writable'] ? 'Writable' : 'Not writable') }}</p></div>
                </div>
            @endforeach
        </div>
    </x-sysadmin::card>

    @if($lastAction)
        <div class="rounded-xl border px-5 py-4 {{ $result === 'success' ? 'border-emerald-200 bg-emerald-50' : 'border-red-200 bg-red-50' }}">
            <div class="flex items-center gap-2 text-[13px] font-bold {{ $result === 'success' ? 'text-emerald-800' : 'text-red-800' }}">{!! \Modules\SysAdmin\Support\Icon::get($result === 'success' ? 'check' : 'info', 'h-4 w-4') !!} Last operation</div>
            <pre class="mt-2 max-h-56 overflow-auto whitespace-pre-wrap rounded-lg bg-white/70 p-3 font-mono text-[11px] leading-5 text-ink-soft">{{ $output !== '' ? $output : 'Command completed successfully.' }}</pre>
        </div>
    @endif
</div>
