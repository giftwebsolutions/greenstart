<form wire:submit="save" class="grid gap-5" novalidate>
    <div class="flex flex-wrap items-end justify-between gap-3"><div><a href="{{ route('sysadmin.catalog.product.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Products</a><h1 class="mt-2 text-[22px] font-bold tracking-tight text-ink">{{ $productId ? 'Edit product' : 'Create product' }}</h1><p class="mt-1 text-[13px] text-ink-muted">Complete the guided setup, then manage family attributes and variants.</p></div>@if($productId)<x-sysadmin::btn :href="route('sysadmin.catalog.product.attributes', $productId)">Manage attributes</x-sysadmin::btn>@endif</div>

    <nav class="grid overflow-hidden rounded-xl border border-hairline bg-white shadow-sm sm:grid-cols-2 xl:grid-cols-4" aria-label="Product setup progress">
        @foreach([1=>['Basics','Identity and content'],2=>['Commerce','Price and classification'],3=>['Media','Images and visibility'],4=>['Review','Confirm and save']] as $number=>[$label,$help])
        <button type="button" wire:click="goToStep({{ $number }})" @disabled($number > $step) class="relative flex items-center gap-3 border-b border-hairline px-4 py-4 text-left last:border-0 sm:border-r xl:border-b-0 {{ $step === $number ? 'bg-primary-50' : 'bg-white' }} disabled:cursor-not-allowed disabled:opacity-50"><span class="grid size-8 shrink-0 place-items-center rounded-full text-xs font-bold {{ $step >= $number ? 'bg-primary text-white' : 'bg-slate-100 text-ink-muted' }}">{{ $step > $number ? '✓' : $number }}</span><span><strong class="block text-[13px] {{ $step === $number ? 'text-primary-600' : 'text-ink' }}">{{ $label }}</strong><small class="text-[10.5px] text-ink-muted">{{ $help }}</small></span>@if($step === $number)<span class="absolute inset-x-0 bottom-0 h-0.5 bg-primary"></span>@endif</button>
        @endforeach
    </nav>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">
        <x-sysadmin::card class="overflow-hidden">
            <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">{{ [1=>'Product basics',2=>'Commerce and classification',3=>'Media and visibility',4=>'Review product'][$step] }}</h2><p class="mt-1 text-xs text-ink-muted">{{ [1=>'Use clear searchable names and stable catalog identifiers.',2=>'The selected family controls grouped product fields and variants.',3=>'Upload optimized images and choose storefront placement.',4=>'Confirm the setup before saving.'][$step] }}</p></div>
            <div class="p-5" wire:key="product-wizard-step-{{ $step }}">
                @if($step === 1)
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2"><x-sysadmin::input label="Product title" name="title" wire:model="title" required autofocus/></div>
                    <x-sysadmin::input label="Slug" name="slug" wire:model="slug" placeholder="Generated from title when empty" class="font-mono"/>
                    <x-sysadmin::input label="Parent SKU" name="sku" wire:model="sku" hint="Variant products use this as their parent SKU."/>
                    <x-sysadmin::input label="Product code" name="productCode" wire:model="productCode"/>
                    <x-sysadmin::input label="Model" name="modelNumber" wire:model="modelNumber"/>
                    <div class="md:col-span-2"><x-sysadmin::input label="Search keywords" name="keywords" wire:model="keywords"/></div>
                    <x-sysadmin::rich-text label="Short description" model="shortDescription" hint="A concise formatted summary shown in compact product views." class="md:col-span-2" />
                    <x-sysadmin::rich-text label="Description" model="description" hint="Use headings, lists, links and emphasis for structured product content." class="md:col-span-2" />
                </div>
                @elseif($step === 2)
                <div class="grid gap-4 md:grid-cols-2">
                    <x-sysadmin::input label="MRP (₹)" name="mrp" type="number" min="0" step="0.01" wire:model="mrp" required/>
                    <x-sysadmin::input label="Sales price (₹)" name="salesPrice" type="number" min="0" step="0.01" wire:model="salesPrice" required/>
                    <x-sysadmin::input label="Simple product stock" name="stock" type="number" min="0" step="1" wire:model="stock" hint="Used until variants are configured. Variant products use each variant's stock." required/>
                    <x-sysadmin::select label="Main category" name="productCategory" wire:model.live.change="productCategory" placeholder="Choose main category" required>
                        @foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach
                    </x-sysadmin::select>
                    <div wire:key="subcategory-field-{{ $productCategory ?: 'none' }}">
                        <x-sysadmin::select label="Subcategory" name="subProductCategory" wire:model="subProductCategory" placeholder="{{ $productCategory ? ($subCategories->isEmpty() ? 'No subcategories available' : 'Choose subcategory') : 'Select a main category first' }}" :disabled="! $productCategory || $subCategories->isEmpty()">
                            @foreach($subCategories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach
                        </x-sysadmin::select>
                        <p class="mt-1.5 text-[11px] text-ink-muted" wire:loading.remove wire:target="productCategory">
                            {{ $productCategory ? $subCategories->count().' matching subcategories' : 'Options load after selecting a main category.' }}
                        </p>
                        <p class="mt-1.5 text-[11px] font-medium text-primary" wire:loading wire:target="productCategory">Loading subcategories…</p>
                    </div>
                    <fieldset class="md:col-span-2"><legend class="mb-2 text-[12.5px] font-bold">Attribute family <span class="text-red-600">*</span></legend><div class="grid gap-2 md:grid-cols-2">@forelse($families as $family)<label class="flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition {{ (string)$attributeFamilyId === (string)$family->id ? 'border-primary bg-primary-50 ring-1 ring-primary' : 'border-hairline hover:border-primary/40' }}"><input wire:model.live="attributeFamilyId" type="radio" value="{{ $family->id }}" class="size-4 text-primary"><span><strong class="block text-[13px] text-ink">{{ $family->name }}</strong><small class="text-[11px] text-ink-muted">{{ $family->code }} · {{ $family->groups_count }} groups · {{ $family->products_count }} products</small></span></label>@empty<div class="rounded-xl bg-amber-50 px-4 py-3 text-[13px] text-amber-700">Create an attribute family before adding products.</div>@endforelse</div>@error('attributeFamilyId')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror</fieldset>
                </div>
                @elseif($step === 3)
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[12.5px] font-bold">Primary thumbnail</label>
                        <input wire:model="thumb" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary">
                        <p class="mt-1.5 text-[11px] text-ink-muted">JPG, PNG or WebP up to 4 MB.</p>
                        <p class="mt-1.5 text-[11px] font-medium text-primary" wire:loading wire:target="thumb">Preparing thumbnail…</p>
                        @error('thumb')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[12.5px] font-bold">Gallery images</label>
                        <input wire:model="galleryImages" type="file" multiple accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary">
                        <p class="mt-1.5 text-[11px] text-ink-muted">Up to 12 images total. New images are appended in selection order.</p>
                        <p class="mt-1.5 text-[11px] font-medium text-primary" wire:loading wire:target="galleryImages">Preparing gallery previews…</p>
                        @error('galleryImages')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        @error('galleryImages.*')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    @if($thumb || ($product?->thumb && ! $removeThumb))
                        <div class="md:col-span-2 flex items-center justify-between gap-3 rounded-xl border border-hairline bg-[#fafbfc] p-3" wire:key="product-thumbnail-preview">
                            <div class="flex items-center gap-3">
                                <img src="{{ $thumb ? $thumb->temporaryUrl() : $product->thumb_url }}" alt="Product thumbnail preview" class="size-20 rounded-lg border border-hairline object-cover">
                                <span><strong class="block text-xs text-ink">{{ $thumb ? 'New thumbnail' : 'Current thumbnail' }}</strong><small class="mt-1 block text-[11px] text-ink-muted">Used on product cards and listing pages.</small></span>
                            </div>
                            <button type="button" wire:click="removeThumbnail" class="rounded-lg px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">Remove</button>
                        </div>
                    @endif

                    @if($existingGalleryImages !== [] || $galleryImages !== [])
                        <section class="md:col-span-2 overflow-hidden rounded-xl border border-hairline" wire:key="product-gallery-manager">
                            <header class="flex items-center justify-between border-b border-hairline bg-[#fafbfc] px-4 py-3">
                                <div><h3 class="text-xs font-bold text-ink">Gallery order</h3><p class="mt-0.5 text-[10.5px] text-ink-muted">Existing images can be reordered before saving.</p></div>
                                <span class="rounded-full bg-white px-2.5 py-1 text-[10.5px] font-semibold text-ink-muted">{{ count($existingGalleryImages) + count($galleryImages) }} / 12</span>
                            </header>
                            <div class="grid gap-3 p-3 sm:grid-cols-2 xl:grid-cols-3">
                                @foreach($existingGalleryImages as $index => $image)
                                    <article class="overflow-hidden rounded-lg border border-hairline bg-white" wire:key="stored-gallery-{{ $image['id'] }}">
                                        <img src="{{ $image['url'] }}" alt="Gallery image {{ $index + 1 }}" class="h-32 w-full object-cover">
                                        <footer class="flex items-center justify-between gap-2 p-2">
                                            <span class="text-[10.5px] font-semibold text-ink-muted">Position {{ $index + 1 }}</span>
                                            <div class="flex gap-1">
                                                <button type="button" wire:click="moveExistingGalleryImage({{ $index }}, 'up')" class="grid size-7 place-items-center rounded-md border border-hairline text-xs disabled:opacity-30" title="Move left" @disabled($loop->first)>←</button>
                                                <button type="button" wire:click="moveExistingGalleryImage({{ $index }}, 'down')" class="grid size-7 place-items-center rounded-md border border-hairline text-xs disabled:opacity-30" title="Move right" @disabled($loop->last)>→</button>
                                                <button type="button" wire:click="removeExistingGalleryImage({{ $image['id'] }})" wire:confirm="Remove this gallery image when the product is saved?" class="grid size-7 place-items-center rounded-md border border-red-100 text-sm text-red-600" title="Remove image">×</button>
                                            </div>
                                        </footer>
                                    </article>
                                @endforeach
                                @foreach($galleryImages as $index => $image)
                                    <article class="overflow-hidden rounded-lg border border-primary/25 bg-primary-50/30" wire:key="pending-gallery-{{ $index }}">
                                        <img src="{{ $image->temporaryUrl() }}" alt="New gallery image {{ $index + 1 }}" class="h-32 w-full object-cover">
                                        <footer class="flex items-center justify-between gap-2 p-2">
                                            <span class="text-[10.5px] font-semibold text-primary">New image</span>
                                            <button type="button" wire:click="removePendingGalleryImage({{ $index }})" class="rounded-md px-2 py-1 text-[10.5px] font-semibold text-red-600 hover:bg-red-50">Remove</button>
                                        </footer>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <x-sysadmin::input label="Video URL" name="video" type="url" wire:model="video" placeholder="https://…"/>
                    <x-sysadmin::input label="Catalog URL" name="catalog" type="url" wire:model="catalog" placeholder="https://…"/>
                    <x-sysadmin::select label="Status" name="status" wire:model="status"><option value="1">Published</option><option value="2">Draft</option><option value="0">Disabled</option></x-sysadmin::select>
                    <x-sysadmin::input label="Sort order" name="sortOrder" type="number" min="0" wire:model="sortOrder"/>
                    @foreach([['isFeatured','Featured product','Highlight in curated storefront areas.'],['slider','Homepage slider','Allow this product in slider placements.']] as [$model,$label,$help])<label class="flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-hairline p-4"><span><strong class="block text-[13px]">{{ $label }}</strong><small class="text-[11px] text-ink-muted">{{ $help }}</small></span><input type="checkbox" wire:model="{{ $model }}" class="peer sr-only"><span class="relative h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:size-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></span></label>@endforeach
                </div>
                @else
                <dl class="grid gap-3 md:grid-cols-2">@foreach([['Product',$title ?: '—',($sku ?: 'No SKU').' · '.($productCode ?: 'No product code')],['Pricing','₹'.number_format((float)$salesPrice,2),'MRP ₹'.number_format((float)$mrp,2)],['Category',$categories->firstWhere('id',(int)$productCategory)?->name ?? '—',$subCategories->firstWhere('id',(int)$subProductCategory)?->name ?? 'No subcategory'],['Attribute family',$families->firstWhere('id',(int)$attributeFamilyId)?->name ?? '—','Determines grouped fields and variants'],['Visibility',[0=>'Disabled',1=>'Published',2=>'Draft'][$status] ?? 'Draft',$isFeatured ? 'Featured product' : 'Standard product'],['Media',$thumb || ($product?->thumb && ! $removeThumb) ? 'Thumbnail ready' : 'No thumbnail',(count($existingGalleryImages) + count($galleryImages)).' gallery image(s)']] as [$term,$value,$detail])<div class="rounded-xl border border-hairline p-4"><dt class="text-[11px] font-bold uppercase tracking-wide text-ink-muted">{{ $term }}</dt><dd class="mt-1 text-[14px] font-bold text-ink">{{ $value }}</dd><small class="mt-1 block text-[11px] text-ink-muted">{{ $detail }}</small></div>@endforeach</dl><div class="mt-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-[13px] text-blue-700"><strong>Next:</strong> save and continue to family attributes and product variants.</div>
                @endif
            </div>
            <div class="flex items-center justify-between gap-2 border-t border-hairline bg-[#fafbfc] px-5 py-4"><div>@if($step > 1)<x-sysadmin::btn wire:click="previousStep">← Back</x-sysadmin::btn>@endif</div><div class="flex gap-2">@if($step < 4)<x-sysadmin::btn variant="primary" wire:click="nextStep">Continue →</x-sysadmin::btn>@else<x-sysadmin::btn wire:click="save(false)" wire:loading.attr="disabled">Save product</x-sysadmin::btn><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled">Save & manage attributes →</x-sysadmin::btn>@endif</div></div>
        </x-sysadmin::card>

        <aside><x-sysadmin::card class="sticky top-24 p-5"><h2 class="text-base font-bold text-ink">Setup summary</h2><p class="mt-1 text-xs text-ink-muted">Validated one section at a time.</p><div class="mt-5 flex justify-between text-xs"><span class="text-ink-muted">Completed</span><strong>{{ $step - 1 }} of 4</strong></div><div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-primary transition-all" style="width: {{ (($step - 1) / 4) * 100 }}%"></div></div><dl class="mt-5 divide-y divide-hairline">@foreach([['Title',$title ?: 'Not set'],['Family',$families->firstWhere('id',(int)$attributeFamilyId)?->name ?? 'Not selected'],['Price','₹'.number_format((float)$salesPrice,2)]] as [$label,$value])<div class="flex justify-between gap-3 py-3 text-[12.5px]"><dt class="text-ink-muted">{{ $label }}</dt><dd class="truncate font-semibold text-ink">{{ $value }}</dd></div>@endforeach</dl></x-sysadmin::card></aside>
    </div>
</form>
