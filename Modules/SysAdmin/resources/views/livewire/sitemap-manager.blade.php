<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Search visibility</p>
            <h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">XML sitemap</h1>
            <p class="mt-1 max-w-2xl text-[13px] text-ink-muted">Publish discoverable storefront pages, catalog records and blog content in a search-engine friendly XML file.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-sysadmin::btn href="{{ route('sysadmin.tools.index') }}">{!! \Modules\SysAdmin\Support\Icon::get('settings', 'h-4 w-4') !!} System tools</x-sysadmin::btn>
            @if($status['exists'])
                <x-sysadmin::btn href="{{ $status['url'] }}" target="_blank" rel="noopener">{!! \Modules\SysAdmin\Support\Icon::get('eye', 'h-4 w-4') !!} Open XML</x-sysadmin::btn>
            @endif
            <x-sysadmin::btn variant="primary" wire:click="generate" wire:loading.attr="disabled" wire:target="generate">
                <span wire:loading.remove wire:target="generate">{!! \Modules\SysAdmin\Support\Icon::get('refresh', 'h-4 w-4') !!} {{ $status['exists'] ? 'Regenerate sitemap' : 'Generate sitemap' }}</span>
                <span wire:loading wire:target="generate">Generating…</span>
            </x-sysadmin::btn>
        </div>
    </div>

    @if($message !== '')
        <div class="flex items-start gap-3 rounded-xl border px-4 py-3 text-[12px] {{ $result === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-900' : 'border-red-200 bg-red-50 text-red-900' }}">
            {!! \Modules\SysAdmin\Support\Icon::get($result === 'success' ? 'check' : 'info', 'mt-0.5 h-4 w-4 shrink-0') !!}<span>{{ $message }}</span>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Status</p><div class="mt-2 flex items-center gap-2"><span class="size-2 rounded-full {{ $status['exists'] ? 'bg-emerald-500' : 'bg-amber-500' }}"></span><strong class="text-[17px] text-ink">{{ $status['exists'] ? 'Published' : 'Not generated' }}</strong></div></x-sysadmin::card>
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Indexed URLs</p><p class="mt-2 text-[22px] font-bold text-ink">{{ number_format($status['url_count']) }}</p></x-sysadmin::card>
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">File size</p><p class="mt-2 text-[22px] font-bold text-ink">{{ $status['exists'] ? number_format($status['bytes'] / 1024, 1).' KB' : '—' }}</p></x-sysadmin::card>
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Last generated</p><p class="mt-2 text-[13px] font-bold text-ink">{{ $status['modified_at']?->diffForHumans() ?? 'Never' }}</p>@if($status['modified_at'])<p class="mt-1 text-[10px] text-ink-muted">{{ $status['modified_at']->format('d M Y, h:i A') }}</p>@endif</x-sysadmin::card>
    </div>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(300px,.55fr)]">
        <x-sysadmin::card>
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4"><div><h2 class="text-base font-bold text-ink">Generated XML</h2><p class="mt-1 text-xs text-ink-muted">Read-only preview. Content is rebuilt from published database records.</p></div>@if($status['exists'])<code class="rounded-lg bg-slate-100 px-3 py-1.5 text-[10px] text-ink-soft">/sitemap.xml</code>@endif</div>
            @if($status['exists'])
                <pre class="max-h-[560px] overflow-auto whitespace-pre-wrap break-all bg-[#111827] p-5 font-mono text-[11px] leading-5 text-slate-200">{{ $status['preview'] }}</pre>
                @if($status['bytes'] > 12000)<p class="border-t border-hairline bg-[#fafbfc] px-5 py-3 text-[10px] text-ink-muted">Preview is truncated. Open the XML file to inspect the full sitemap.</p>@endif
            @else
                <div class="grid min-h-72 place-items-center px-5 py-12 text-center"><div><span class="mx-auto grid size-12 place-items-center rounded-2xl bg-primary-50 text-primary">{!! \Modules\SysAdmin\Support\Icon::get('map', 'h-6 w-6') !!}</span><h3 class="mt-4 text-[14px] font-bold text-ink">No sitemap yet</h3><p class="mt-1 max-w-sm text-xs leading-5 text-ink-muted">Generate the file to publish all currently eligible storefront URLs.</p></div></div>
            @endif
        </x-sysadmin::card>

        <div class="grid content-start gap-5">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">Included content</h2><p class="mt-1 text-xs text-ink-muted">Only public, published records are exported.</p></div>
                <ul class="divide-y divide-hairline px-5 text-[12px]">
                    @foreach(['Core storefront pages', 'Published CMS pages', 'Active product categories', 'Published products', 'Active blog categories', 'Published blog posts'] as $contentType)
                        <li class="flex items-center gap-2 py-3 text-ink-soft"><span class="text-emerald-600">{!! \Modules\SysAdmin\Support\Icon::get('check', 'h-4 w-4') !!}</span>{{ $contentType }}</li>
                    @endforeach
                </ul>
            </x-sysadmin::card>

            <div class="rounded-xl border border-sky-200 bg-sky-50 p-5 text-[12px] text-sky-950">
                <strong class="block">Search Console tip</strong>
                <p class="mt-1 leading-5 text-sky-800">After generation, submit <code class="rounded bg-white/70 px-1 py-0.5">{{ $status['url'] }}</code> in your search-engine webmaster account.</p>
            </div>
        </div>
    </div>
</div>
