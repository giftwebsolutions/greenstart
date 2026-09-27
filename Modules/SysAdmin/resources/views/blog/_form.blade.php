@php
    $blog = $blog ?? null;
    $editing = filled($blog);
    $featuredUrl = $editing && $blog->featured_image
        ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($blog->featured_image, $blog->created_at, 'thumbnail')
        : null;
    $publishedValue = old('published_at', $blog?->published_at?->format('Y-m-d\TH:i'));
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('sysadmin.blog.update', $blog->id) : route('sysadmin.blog.store') }}" class="grid gap-4">
    @csrf
    @if($editing) @method('PATCH') @endif

    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.blog.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Blog posts</a>
            <h1 class="mt-1.5 text-xl font-bold tracking-tight text-ink">{{ $editing ? 'Edit blog post' : 'Create blog post' }}</h1>
            <p class="mt-0.5 text-xs text-ink-muted">Write the article, assign its category, then control its publication date.</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="route('sysadmin.blog.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary">{{ $editing ? 'Save post' : 'Create post' }}</x-sysadmin::btn>
        </div>
    </div>

    <div class="grid items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
        <x-sysadmin::card class="overflow-hidden">
            <div class="border-b border-hairline px-4 py-3">
                <h2 class="text-sm font-bold text-ink">Article content</h2>
                <p class="mt-0.5 text-[11.5px] text-ink-muted">Keep the title searchable and the introduction useful on listing cards.</p>
            </div>
            <div class="grid gap-4 p-4 md:grid-cols-2">
                <x-sysadmin::input label="Post title" name="title" :value="old('title', $blog?->title)" placeholder="Enter a descriptive post title" wrapper-class="md:col-span-2" size="sm" required autofocus />
                <x-sysadmin::input label="SEO keywords" name="keywords" :value="old('keywords', $blog?->keywords)" placeholder="water, treatment, maintenance" wrapper-class="md:col-span-2" size="sm" required />
                <x-sysadmin::html-field label="Description" name="description" :value="$blog?->description ?? ''" hint="Short formatted excerpt used on cards and search results." class="md:col-span-2" :rows="4" required />
                <x-sysadmin::html-field label="Article content" name="content" :value="$blog?->content ?? ''" hint="Structure long content with headings, lists and links." class="md:col-span-2" :rows="14" required />
                <x-sysadmin::input label="Video URL" name="video_url" type="url" :value="old('video_url', $blog?->video_url)" placeholder="https://youtube.com/…" wrapper-class="md:col-span-2" size="sm" hint="Optional supporting video shown with this post." />
            </div>
        </x-sysadmin::card>

        <aside class="grid min-w-0 content-start gap-4">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Publishing</h2></div>
                <div class="grid gap-4 p-4">
                    <x-sysadmin::select label="Status" name="status" size="sm" required>
                        @foreach($statuses as $key => $value)<option value="{{ $key }}" @selected((string) old('status', $blog?->status ?? 1) === (string) $key)>{{ $value }}</option>@endforeach
                    </x-sysadmin::select>
                    <x-sysadmin::input label="Publish date" name="published_at" type="datetime-local" :value="$publishedValue" size="sm" hint="Leave empty to publish immediately." />
                    <x-sysadmin::select label="Category" name="category_id" size="sm" required>
                        <option value="">Choose category</option>
                        @foreach($parentCategory as $category)<option value="{{ $category['id'] }}" @selected((string) old('category_id', $blog?->category_id) === (string) $category['id'])>{{ $category['name'] }}</option>@endforeach
                    </x-sysadmin::select>
                </div>
            </x-sysadmin::card>

            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Featured media</h2><p class="mt-0.5 text-[11px] text-ink-muted">Used on blog cards and the article header.</p></div>
                <div class="p-4">
                    <x-sysadmin::image-upload label="Featured image" name="featured_image" remove-name="remove_featured_image" :existing-url="$featuredUrl" wide />
                </div>
            </x-sysadmin::card>
        </aside>
    </div>
</form>
