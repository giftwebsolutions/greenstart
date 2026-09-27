@php
    $category = $category ?? null;
    $editing = filled($category);
    $featuredUrl = $editing && $category->featured_image
        ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($category->featured_image, $category->created_at, 'thumbnail')
        : null;
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('sysadmin.blog.category.update', $category->id) : route('sysadmin.blog.category.store') }}" class="grid gap-4">
    @csrf
    @if($editing) @method('PATCH') @endif

    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.blog.category.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Blog categories</a>
            <h1 class="mt-1.5 text-xl font-bold tracking-tight text-ink">{{ $editing ? 'Edit blog category' : 'Create blog category' }}</h1>
            <p class="mt-0.5 text-xs text-ink-muted">Organize articles into clear, searchable editorial sections.</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="route('sysadmin.blog.category.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary">{{ $editing ? 'Save category' : 'Create category' }}</x-sysadmin::btn>
        </div>
    </div>

    <div class="grid items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
        <x-sysadmin::card class="overflow-hidden">
            <div class="border-b border-hairline px-4 py-3">
                <h2 class="text-sm font-bold text-ink">Category content</h2>
                <p class="mt-0.5 text-[11.5px] text-ink-muted">The name automatically generates the storefront slug.</p>
            </div>
            <div class="grid gap-4 p-4">
                <x-sysadmin::input label="Category name" name="name" :value="old('name', $category?->name)" placeholder="e.g. Water treatment guides" size="sm" required autofocus />
                <x-sysadmin::input label="SEO keywords" name="keywords" :value="old('keywords', $category?->keywords)" placeholder="water, filtration, guides" size="sm" />
                <x-sysadmin::html-field label="Description" name="description" :value="$category?->description ?? ''" hint="Short formatted introduction for category cards and metadata." :rows="4" />
                <x-sysadmin::html-field label="Category content" name="content" :value="$category?->content ?? ''" hint="Optional long-form introduction displayed on the category page." :rows="12" />
            </div>
        </x-sysadmin::card>

        <aside class="grid min-w-0 content-start gap-4">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Organization</h2></div>
                <div class="grid gap-4 p-4">
                    <x-sysadmin::select label="Status" name="status" size="sm" required>
                        @foreach($statuses as $key => $value)<option value="{{ $key }}" @selected((string) old('status', $category?->status ?? 1) === (string) $key)>{{ $value }}</option>@endforeach
                    </x-sysadmin::select>
                    <x-sysadmin::select label="Parent category" name="parent_id" size="sm">
                        <option value="">No parent category</option>
                        @foreach($parents as $parent)
                            @continue($editing && (int) $parent['id'] === (int) $category->id)
                            <option value="{{ $parent['id'] }}" @selected((string) old('parent_id', $category?->parent_id ?? 0) === (string) $parent['id'])>{{ $parent['name'] }}</option>
                        @endforeach
                    </x-sysadmin::select>
                </div>
            </x-sysadmin::card>

            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Category media</h2><p class="mt-0.5 text-[11px] text-ink-muted">Used on category cards and headers.</p></div>
                <div class="p-4">
                    <x-sysadmin::image-upload label="Featured image" name="featured_image" remove-name="remove_featured_image" :existing-url="$featuredUrl" wide />
                </div>
            </x-sysadmin::card>
        </aside>
    </div>
</form>
