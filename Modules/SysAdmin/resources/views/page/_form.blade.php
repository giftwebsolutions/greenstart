@php
    $page = $page ?? null;
    $editing = filled($page);
    $featuredUrl = $editing && $page->featured_image
        ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($page->featured_image, $page->created_at, 'thumbnail')
        : null;
    $bannerUrl = $editing && $page->banner
        ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($page->banner, $page->created_at, 'thumbnail')
        : null;
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('sysadmin.cms.page.update', $page->id) : route('sysadmin.cms.page.store') }}" class="grid gap-4">
    @csrf
    @if($editing) @method('PATCH') @endif

    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.cms.page.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Pages</a>
            <h1 class="mt-1.5 text-xl font-bold tracking-tight text-ink">{{ $editing ? 'Edit page' : 'Create page' }}</h1>
            <p class="mt-0.5 text-xs text-ink-muted">Manage page content, hierarchy, search metadata and storefront media.</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="route('sysadmin.cms.page.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary">{{ $editing ? 'Save page' : 'Create page' }}</x-sysadmin::btn>
        </div>
    </div>

    <div class="grid items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
        <x-sysadmin::card class="overflow-hidden">
            <div class="border-b border-hairline px-4 py-3">
                <h2 class="text-sm font-bold text-ink">Page content</h2>
                <p class="mt-0.5 text-[11.5px] text-ink-muted">Use a concise navigation name and a descriptive browser title.</p>
            </div>
            <div class="grid gap-4 p-4 md:grid-cols-2">
                <x-sysadmin::input label="Page name" name="name" :value="old('name', $page?->name)" placeholder="e.g. About us" wrapper-class="md:col-span-1" size="sm" required autofocus />
                <x-sysadmin::input label="Page title" name="title" :value="old('title', $page?->title)" placeholder="Browser and search title" wrapper-class="md:col-span-1" size="sm" required />
                <x-sysadmin::input label="SEO keywords" name="keywords" :value="old('keywords', $page?->keywords)" placeholder="water treatment, services" wrapper-class="md:col-span-2" size="sm" required />
                <x-sysadmin::html-field label="Description" name="description" :value="$page?->description ?? ''" hint="Short formatted summary used by page listings and search metadata." class="md:col-span-2" :rows="4" required />
                <x-sysadmin::html-field label="Page content" name="content" :value="$page?->content ?? ''" hint="Use headings, lists and links to create a readable page." class="md:col-span-2" :rows="12" required />
            </div>
        </x-sysadmin::card>

        <aside class="grid min-w-0 content-start gap-4">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Publishing</h2></div>
                <div class="grid gap-4 p-4">
                    <x-sysadmin::select label="Status" name="status" size="sm" required>
                        @foreach($statuses as $key => $value)<option value="{{ $key }}" @selected((string) old('status', $page?->status ?? 1) === (string) $key)>{{ $value }}</option>@endforeach
                    </x-sysadmin::select>
                    <x-sysadmin::select label="Parent page" name="parent_id" size="sm">
                        <option value="">No parent page</option>
                        @foreach($parents as $parent)
                            @continue($editing && (int) $parent['id'] === (int) $page->id)
                            <option value="{{ $parent['id'] }}" @selected((string) old('parent_id', $page?->parent_id ?? 0) === (string) $parent['id'])>{{ $parent['name'] }}</option>
                        @endforeach
                    </x-sysadmin::select>
                </div>
            </x-sysadmin::card>

            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Page media</h2><p class="mt-0.5 text-[11px] text-ink-muted">Preview changes locally, then save to upload.</p></div>
                <div class="grid gap-4 p-4">
                    <x-sysadmin::image-upload label="Featured image" name="featured_image" remove-name="remove_featured_image" :existing-url="$featuredUrl" />
                    <div class="border-t border-hairline pt-4">
                        <x-sysadmin::image-upload label="Banner image" name="banner" remove-name="remove_banner" :existing-url="$bannerUrl" wide />
                    </div>
                </div>
            </x-sysadmin::card>
        </aside>
    </div>
</form>
