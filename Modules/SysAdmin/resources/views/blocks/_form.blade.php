@php
    $block = $block ?? null;
    $editing = filled($block);
    $thumbnailUrl = $editing && $block->thumbnail
        ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($block->thumbnail, $block->created_at, 'thumbnail')
        : null;
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('sysadmin.cms.block.update', $block->id) : route('sysadmin.cms.block.store') }}" class="grid gap-4">
    @csrf
    @if($editing) @method('PATCH') @endif

    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.cms.block.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Content blocks</a>
            <h1 class="mt-1.5 text-xl font-bold tracking-tight text-ink">{{ $editing ? 'Edit content block' : 'Create content block' }}</h1>
            <p class="mt-0.5 text-xs text-ink-muted">Reusable HTML content that can be placed in storefront sections.</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="route('sysadmin.cms.block.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary">{{ $editing ? 'Save block' : 'Create block' }}</x-sysadmin::btn>
        </div>
    </div>

    <div class="grid items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
        <x-sysadmin::card class="overflow-hidden">
            <div class="border-b border-hairline px-4 py-3">
                <h2 class="text-sm font-bold text-ink">Block content</h2>
                <p class="mt-0.5 text-[11.5px] text-ink-muted">The key is used by templates, so avoid changing it after launch.</p>
            </div>
            <div class="grid gap-4 p-4 md:grid-cols-2">
                <x-sysadmin::input label="Block title" name="title" :value="old('title', $block?->title)" placeholder="e.g. Homepage introduction" wrapper-class="md:col-span-1" size="sm" required />
                <x-sysadmin::input label="Template key" name="key" :value="old('key', $block?->key)" placeholder="homepage_intro" wrapper-class="md:col-span-1" class="font-mono" size="sm" required autofocus />
                <x-sysadmin::html-field label="Block value" name="value" :value="$block?->value ?? ''" hint="Add the formatted content rendered wherever this block key is used." class="md:col-span-2" :rows="14" required />
            </div>
        </x-sysadmin::card>

        <aside class="grid min-w-0 content-start gap-4">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Display</h2></div>
                <div class="p-4">
                    <x-sysadmin::input label="Icon class" name="icon" :value="old('icon', $block?->icon)" placeholder="fa fa-pencil" size="sm" hint="Optional icon class used by compatible templates." />
                </div>
            </x-sysadmin::card>

            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Block media</h2><p class="mt-0.5 text-[11px] text-ink-muted">Preview first; upload occurs when the block is saved.</p></div>
                <div class="p-4">
                    <x-sysadmin::image-upload label="Thumbnail" name="thumbnail" remove-name="remove_thumbnail" :existing-url="$thumbnailUrl" />
                </div>
            </x-sysadmin::card>
        </aside>
    </div>
</form>
