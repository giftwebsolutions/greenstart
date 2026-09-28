<div class="grid gap-5" x-data="{ addSlideOpen: @entangle('showAddItem') }">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.slider.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Sliders</a>
            <h1 class="mt-2 text-[22px] font-bold tracking-tight text-ink">{{ $sliderId ? $name : 'Create slider' }}</h1>
            <p class="mt-1 text-[13px] text-ink-muted">Manage the slider identity, HTML content, images, links and slide order.</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="route('sysadmin.slider.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn variant="primary" wire:click="saveDetails" wire:loading.attr="disabled"><span wire:loading.remove wire:target="saveDetails">{{ $sliderId ? 'Save slider' : 'Create slider' }}</span><span wire:loading wire:target="saveDetails">Saving…</span></x-sysadmin::btn>
        </div>
    </div>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">
        <div class="grid content-start gap-5">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">Slider details</h2><p class="mt-1 text-xs text-ink-muted">Use a stable slug for storefront placement and API references.</p></div>
                <form wire:submit="saveDetails" class="grid gap-4 p-5 md:grid-cols-2">
                    <x-sysadmin::input label="Slider name" name="name" wire:model.live.blur="name" required autofocus />
                    <x-sysadmin::input label="Slug" name="slug" wire:model="slug" required class="font-mono" />
                    <x-sysadmin::rich-text label="Description" model="description" hint="Formatted context for administrators or storefront presentation." class="md:col-span-2" />
                    <x-sysadmin::select label="Status" name="status" wire:model="status"><option value="1">Active</option><option value="0">Inactive</option></x-sysadmin::select>
                    <div class="flex items-end"><x-sysadmin::btn type="submit" variant="primary">Save details</x-sysadmin::btn></div>
                </form>
            </x-sysadmin::card>

            @if($sliderId)
                <section class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm">
                    <header class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4">
                        <div><h2 class="text-base font-bold text-ink">Slides</h2><p class="mt-1 text-xs text-ink-muted">The image, title, description and destination below are rendered on the homepage for the active <span class="font-mono">home</span> slider.</p></div>
                        <x-sysadmin::btn x-on:click="addSlideOpen = ! addSlideOpen">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} Add slide</x-sysadmin::btn>
                    </header>

                    <div x-show="addSlideOpen" x-cloak x-transition class="border-b border-hairline bg-[#fafbfc] p-5">
                        <form wire:submit="addItem" class="grid gap-4 md:grid-cols-2">
                            <x-sysadmin::input label="Slide title" name="newItemTitle" wire:model="newItemTitle" required />
                            <x-sysadmin::input label="Button destination path or URL" name="newItemPath" wire:model="newItemPath" placeholder="/catalog/new-arrivals or https://example.com" required />
                            <x-sysadmin::select label="Open link in" name="newItemTarget" wire:model="newItemTarget"><option value="_self">Same window</option><option value="_blank">New window</option></x-sysadmin::select>
                            <div><label class="mb-1.5 block text-[12.5px] font-bold text-ink">Slide image <span class="text-red-600">*</span></label><input type="file" wire:model="newItemFile" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary">@error('newItemFile')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                            <x-sysadmin::rich-text label="Slide description" model="newItemDescription" class="md:col-span-2" />
                            @if($newItemFile)<div class="md:col-span-2 flex items-center gap-3 rounded-xl border border-hairline bg-white p-3"><img src="{{ $newItemFile->temporaryUrl() }}" class="h-24 w-48 rounded-lg object-cover" alt="New slide preview"><span class="text-xs font-semibold text-ink-soft">New slide image preview</span></div>@endif
                            <div class="flex gap-2 md:col-span-2"><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled">Add slide</x-sysadmin::btn><x-sysadmin::btn x-on:click="addSlideOpen = false">Close</x-sysadmin::btn></div>
                        </form>
                    </div>

                    @if($items === [])
                        <div class="grid place-items-center px-5 py-14 text-center"><span class="grid size-11 place-items-center rounded-xl bg-primary-50 text-primary">{!! \Modules\SysAdmin\Support\Icon::get('image') !!}</span><h3 class="mt-3 text-[13px] font-bold text-ink">No slides added</h3><p class="mt-1 text-xs text-ink-muted">Add the first promotional image and destination.</p></div>
                    @else
                        <div class="grid gap-3 bg-[#fafbfc] p-4">
                            @foreach($items as $index => $item)
                                <article wire:key="slide-item-{{ $item['id'] }}" class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm">
                                    <header class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline bg-white px-4 py-3"><div class="flex items-center gap-2"><span class="cursor-grab text-ink-muted">⋮⋮</span><strong class="text-[12.5px] text-ink">Slide {{ $index + 1 }}</strong><span class="text-[10.5px] text-ink-muted">{{ $item['title'] }}</span></div><div class="flex"><button type="button" wire:click="moveItem({{ $index }}, 'up')" class="grid size-8 place-items-center rounded-lg text-ink-muted hover:bg-slate-100" aria-label="Move up">↑</button><button type="button" wire:click="moveItem({{ $index }}, 'down')" class="grid size-8 place-items-center rounded-lg text-ink-muted hover:bg-slate-100" aria-label="Move down">↓</button><button type="button" wire:click="deleteItem({{ $item['id'] }})" wire:confirm="Delete this slide and its image?" class="grid size-8 place-items-center rounded-lg text-red-600 hover:bg-red-50" aria-label="Delete slide">×</button></div></header>
                                    <div class="grid gap-4 p-4 lg:grid-cols-[220px_minmax(0,1fr)]">
                                        <div>
                                            @php
                                                $slidePreview = isset($itemUploads[$index])
                                                    ? $itemUploads[$index]->temporaryUrl()
                                                    : \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($item['file'], $item['created_at']);
                                            @endphp
                                            <img src="{{ $slidePreview }}" class="aspect-[3/1] w-full rounded-lg border border-hairline object-cover" alt="{{ $item['title'] }}">
                                            <input type="file" wire:model="itemUploads.{{ $index }}" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-[10.5px] file:mr-2 file:rounded-md file:border-0 file:bg-primary-50 file:px-2 file:py-1.5 file:font-semibold file:text-primary">
                                            @error('itemUploads.'.$index)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="grid gap-3 md:grid-cols-2">
                                            <x-sysadmin::input label="Title" name="items.{{ $index }}.title" wire:model="items.{{ $index }}.title" required />
                                            <x-sysadmin::input label="Button destination" name="items.{{ $index }}.path" wire:model="items.{{ $index }}.path" required />
                                            <x-sysadmin::select label="Open link in" name="items.{{ $index }}.target" wire:model="items.{{ $index }}.target"><option value="_self">Same window</option><option value="_blank">New window</option></x-sysadmin::select>
                                            <x-sysadmin::rich-text label="Description" model="items.{{ $index }}.description" class="md:col-span-2" />
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between gap-3 border-t border-hairline px-5 py-4"><p class="text-xs text-ink-muted">{{ count($items) }} slides @if($itemsDirty)<span class="font-semibold text-amber-700">· Unsaved order</span>@endif</p><x-sysadmin::btn variant="primary" wire:click="saveItems" wire:loading.attr="disabled">Save slides & order</x-sysadmin::btn></div>
                    @endif
                </section>
            @else
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-[13px] text-blue-700">Create the slider details first. Slide images and destinations will then become available.</div>
            @endif
        </div>

        <aside>
            <x-sysadmin::card class="sticky top-24 overflow-hidden">
                <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">Thumbnail</h2><p class="mt-1 text-xs text-ink-muted">Used in admin previews and optional storefront placements.</p></div>
                <div class="p-5">
                    <input type="file" wire:model="newThumbnail" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary">
                    @error('newThumbnail')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    @php
                        $thumbnailPreview = $newThumbnail
                            ? $newThumbnail->temporaryUrl()
                            : (($thumbnail && ! $removeThumbnail && $slider) ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($thumbnail, $slider->created_at, 'thumbnail') : null);
                    @endphp
                    @if($thumbnailPreview)<img src="{{ $thumbnailPreview }}" class="mt-4 aspect-video w-full rounded-xl border border-hairline object-cover" alt="Slider thumbnail"><button type="button" wire:click="$set('removeThumbnail', true)" class="mt-2 text-xs font-semibold text-red-600">Remove thumbnail</button>@else<div class="mt-4 grid aspect-video place-items-center rounded-xl border border-dashed border-hairline-strong bg-[#fafbfc] text-xs text-ink-muted">No thumbnail</div>@endif
                    @if($sliderId)<dl class="mt-5 divide-y divide-hairline"><div class="flex justify-between gap-3 py-3 text-xs"><dt class="text-ink-muted">Status</dt><dd class="font-semibold {{ $status ? 'text-emerald-700' : 'text-ink-muted' }}">{{ $status ? 'Active' : 'Inactive' }}</dd></div><div class="flex justify-between gap-3 py-3 text-xs"><dt class="text-ink-muted">Slides</dt><dd class="font-semibold text-ink">{{ count($items) }}</dd></div><div class="flex justify-between gap-3 py-3 text-xs"><dt class="text-ink-muted">Slug</dt><dd class="max-w-40 truncate font-mono text-ink">{{ $slug }}</dd></div></dl>@endif
                </div>
            </x-sysadmin::card>
        </aside>
    </div>
</div>
