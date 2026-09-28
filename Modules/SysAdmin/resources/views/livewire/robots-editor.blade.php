<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div><p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Search crawling</p><h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">robots.txt editor</h1><p class="mt-1 max-w-2xl text-[13px] text-ink-muted">Control which storefront paths search-engine crawlers may visit.</p></div>
        <div class="flex flex-wrap gap-2"><x-sysadmin::btn href="{{ route('sysadmin.tools.index') }}">{!! \Modules\SysAdmin\Support\Icon::get('server', 'h-4 w-4') !!} System tools</x-sysadmin::btn>@if($exists)<x-sysadmin::btn href="{{ $publicUrl }}" target="_blank" rel="noopener">{!! \Modules\SysAdmin\Support\Icon::get('eye', 'h-4 w-4') !!} Open public file</x-sysadmin::btn>@endif</div>
    </div>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
        <x-sysadmin::card>
            <form wire:submit="save">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4"><div><h2 class="text-base font-bold text-ink">File content</h2><p class="mt-1 text-xs text-ink-muted">Saved directly as <code>/public/robots.txt</code>.</p></div><span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10.5px] font-bold {{ $exists ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}"><span class="size-1.5 rounded-full bg-current"></span>{{ $exists ? 'Published' : 'Not created' }}</span></div>
                <div class="p-5"><label for="robots-content" class="sr-only">robots.txt content</label><textarea id="robots-content" wire:model="content" rows="20" spellcheck="false" class="w-full rounded-xl border bg-[#111827] px-4 py-4 font-mono text-[12px] leading-6 text-slate-200 caret-white focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has('content') ? 'border-red-500' : 'border-slate-700' }}"></textarea>@error('content')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror</div>
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-hairline bg-[#fafbfc] px-5 py-4"><button type="button" wire:click="restoreDefault" class="text-[12px] font-bold text-ink-soft hover:text-primary">Restore recommended content</button><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled"><span wire:loading.remove wire:target="save">Save robots.txt</span><span wire:loading wire:target="save">Saving…</span></x-sysadmin::btn></div>
            </form>
        </x-sysadmin::card>

        <div class="grid content-start gap-5">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">File information</h2></div>
                <dl class="divide-y divide-hairline px-5 text-[12px]"><div class="flex justify-between gap-3 py-3"><dt class="text-ink-muted">Size</dt><dd class="font-semibold text-ink">{{ number_format($bytes) }} bytes</dd></div><div class="flex justify-between gap-3 py-3"><dt class="text-ink-muted">Modified</dt><dd class="text-right font-semibold text-ink">{{ $modifiedAt ?? 'Not saved' }}</dd></div><div class="py-3"><dt class="text-ink-muted">Public URL</dt><dd class="mt-1 break-all font-mono text-[10px] text-primary">{{ $publicUrl }}</dd></div></dl>
            </x-sysadmin::card>

            <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-[12px] text-amber-950"><strong class="block">Avoid blocking the whole site</strong><p class="mt-1 leading-5 text-amber-800"><code>Disallow: /</code> prevents compliant search engines from crawling every storefront page.</p></div>
            <div class="rounded-xl border border-sky-200 bg-sky-50 p-5 text-[12px] text-sky-950"><strong class="block">Sitemap location</strong><p class="mt-1 break-all leading-5 text-sky-800">{{ $sitemapUrl }}</p></div>
        </div>
    </div>
</div>
