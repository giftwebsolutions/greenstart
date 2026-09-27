<form wire:submit="save" class="catalog-workspace" novalidate>
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <a href="{{ route('sysadmin.catalog.product.index') }}" class="small text-decoration-none">← Products</a>
            <h4 class="mt-2 mb-1">{{ $productId ? 'Edit product' : 'Create product' }}</h4>
            <p class="text-muted mb-0">Complete the guided setup, then manage family attributes and variants.</p>
        </div>
        @if ($productId)
            <a href="{{ route('sysadmin.catalog.product.attributes', $productId) }}" class="btn btn-outline-primary">Manage attributes</a>
        @endif
    </div>

    @include('sysadmin::layouts.alert')

    @if ($errors->any())
        <div class="alert alert-danger"><strong>Please check the highlighted fields.</strong></div>
    @endif

    <nav class="product-wizard mb-4" aria-label="Product setup progress">
        @foreach ([1 => ['Basics', 'Identity and content'], 2 => ['Commerce', 'Price and classification'], 3 => ['Media', 'Images and visibility'], 4 => ['Review', 'Confirm and save']] as $number => [$label, $help])
            <button type="button" wire:click="goToStep({{ $number }})" class="wizard-step {{ $step === $number ? 'active' : '' }} {{ $step > $number ? 'complete' : '' }}" @disabled($number > $step)>
                <span>{{ $step > $number ? '✓' : $number }}</span>
                <strong>{{ $label }}</strong>
                <small>{{ $help }}</small>
            </button>
        @endforeach
    </nav>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                @if ($step === 1)
                    <div class="card-header bg-white py-3"><h5 class="mb-1">Product basics</h5><small class="text-muted">Use clear searchable names and stable catalog identifiers.</small></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">Product title <span class="text-danger">*</span></label><input wire:model="title" class="form-control @error('title') is-invalid @enderror" autofocus>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Slug</label><input wire:model="slug" class="form-control font-monospace @error('slug') is-invalid @enderror" placeholder="Generated from title when empty">@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-3"><label class="form-label">Product code</label><input wire:model="productCode" class="form-control @error('productCode') is-invalid @enderror">@error('productCode')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-3"><label class="form-label">Model</label><input wire:model="modelNumber" class="form-control @error('modelNumber') is-invalid @enderror">@error('modelNumber')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Parent SKU</label><input wire:model="sku" class="form-control @error('sku') is-invalid @enderror"><div class="form-text">Variant products can use a parent SKU plus individual variant SKUs.</div>@error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Search keywords</label><input wire:model="keywords" class="form-control @error('keywords') is-invalid @enderror">@error('keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label class="form-label">Short description</label><textarea wire:model="shortDescription" rows="3" class="form-control @error('shortDescription') is-invalid @enderror"></textarea>@error('shortDescription')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label class="form-label">Description</label><textarea wire:model="description" rows="9" class="form-control @error('description') is-invalid @enderror"></textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        </div>
                    </div>
                @elseif ($step === 2)
                    <div class="card-header bg-white py-3"><h5 class="mb-1">Commerce and classification</h5><small class="text-muted">The selected family controls the grouped product fields in the next screen.</small></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">MRP <span class="text-danger">*</span></label><div class="input-group"><span class="input-group-text">₹</span><input wire:model="mrp" type="number" min="0" step="0.01" class="form-control @error('mrp') is-invalid @enderror"></div>@error('mrp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Sales price <span class="text-danger">*</span></label><div class="input-group"><span class="input-group-text">₹</span><input wire:model="salesPrice" type="number" min="0" step="0.01" class="form-control @error('salesPrice') is-invalid @enderror"></div>@error('salesPrice')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Category <span class="text-danger">*</span></label><select wire:model.live="productCategory" class="form-select @error('productCategory') is-invalid @enderror"><option value="">Choose category</option>@foreach ($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select>@error('productCategory')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Subcategory</label><select wire:model="subProductCategory" class="form-select @error('subProductCategory') is-invalid @enderror"><option value="">No subcategory</option>@foreach ($subCategories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select>@error('subProductCategory')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12">
                                <label class="form-label">Attribute family <span class="text-danger">*</span></label>
                                <div class="family-selector">
                                    @forelse ($families as $family)
                                        <label class="family-selector-option {{ (string) $attributeFamilyId === (string) $family->id ? 'selected' : '' }}">
                                            <input wire:model.live="attributeFamilyId" type="radio" value="{{ $family->id }}">
                                            <span><strong>{{ $family->name }}</strong><small><code>{{ $family->code }}</code> · {{ $family->groups_count }} groups · {{ $family->products_count }} products</small></span>
                                        </label>
                                    @empty
                                        <div class="alert alert-warning mb-0">Create an attribute family before adding products.</div>
                                    @endforelse
                                </div>
                                @error('attributeFamilyId')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                @elseif ($step === 3)
                    <div class="card-header bg-white py-3"><h5 class="mb-1">Media and visibility</h5><small class="text-muted">Upload optimized product images and choose storefront placement.</small></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Thumbnail</label><input wire:model="thumb" type="file" accept="image/jpeg,image/png,image/webp" class="form-control @error('thumb') is-invalid @enderror">@error('thumb')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Gallery images</label><input wire:model="galleryImages" type="file" multiple accept="image/jpeg,image/png,image/webp" class="form-control @error('galleryImages.*') is-invalid @enderror">@error('galleryImages.*')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            @if ($thumb || $product?->thumb)
                                <div class="col-12"><div class="media-preview">@if ($thumb)<img src="{{ $thumb->temporaryUrl() }}" alt="New thumbnail">@elseif ($product)<img src="{{ $product->thumb_url }}" alt="Current thumbnail">@endif<span>{{ $thumb ? 'New thumbnail' : 'Current thumbnail' }}</span></div></div>
                            @endif
                            <div class="col-md-6"><label class="form-label">Video URL</label><input wire:model="video" type="url" class="form-control @error('video') is-invalid @enderror" placeholder="https://…">@error('video')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label">Catalog URL</label><input wire:model="catalog" type="url" class="form-control @error('catalog') is-invalid @enderror" placeholder="https://…">@error('catalog')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-sm-4"><label class="form-label">Status</label><select wire:model="status" class="form-select"><option value="1">Published</option><option value="2">Draft</option><option value="0">Disabled</option></select></div>
                            <div class="col-sm-4"><label class="form-label">Sort order</label><input wire:model="sortOrder" type="number" min="0" class="form-control @error('sortOrder') is-invalid @enderror"></div>
                            <div class="col-sm-4"><label class="form-label">Slider order</label><input wire:model="displayOrder" type="number" min="0" class="form-control @error('displayOrder') is-invalid @enderror"></div>
                            <div class="col-md-6"><label class="behavior-switch"><span><strong>Featured product</strong><small>Highlight this product on curated storefront areas.</small></span><input wire:model="isFeatured" type="checkbox" class="form-check-input" role="switch"></label></div>
                            <div class="col-md-6"><label class="behavior-switch"><span><strong>Homepage slider</strong><small>Allow this product in slider placements.</small></span><input wire:model="slider" type="checkbox" class="form-check-input" role="switch"></label></div>
                        </div>
                    </div>
                @else
                    <div class="card-header bg-white py-3"><h5 class="mb-1">Review product</h5><small class="text-muted">Confirm the core setup. Attributes and variants are managed immediately after save.</small></div>
                    <div class="card-body">
                        <dl class="review-grid">
                            <div><dt>Product</dt><dd>{{ $title ?: '—' }}<small>{{ $sku ?: 'No SKU' }} · {{ $productCode ?: 'No product code' }}</small></dd></div>
                            <div><dt>Pricing</dt><dd>₹{{ number_format((float) $salesPrice, 2) }}<small>MRP ₹{{ number_format((float) $mrp, 2) }}</small></dd></div>
                            <div><dt>Category</dt><dd>{{ $categories->firstWhere('id', (int) $productCategory)?->name ?? '—' }}<small>{{ $subCategories->firstWhere('id', (int) $subProductCategory)?->name ?? 'No subcategory' }}</small></dd></div>
                            <div><dt>Attribute family</dt><dd>{{ $families->firstWhere('id', (int) $attributeFamilyId)?->name ?? '—' }}<small>Determines grouped fields and variants</small></dd></div>
                            <div><dt>Visibility</dt><dd>{{ [0 => 'Disabled', 1 => 'Published', 2 => 'Draft'][$status] ?? 'Draft' }}<small>{{ $isFeatured ? 'Featured' : 'Standard' }}{{ $slider ? ' · Slider' : '' }}</small></dd></div>
                            <div><dt>Media</dt><dd>{{ $thumb || $product?->thumb ? 'Thumbnail ready' : 'No thumbnail' }}<small>{{ count($galleryImages) }} new gallery image(s)</small></dd></div>
                        </dl>
                        <div class="alert alert-info mb-0"><strong>Next:</strong> save and continue to fill family attributes and configure product variants.</div>
                    </div>
                @endif

                <div class="card-footer bg-white d-flex justify-content-between gap-2 py-3">
                    <div>@if ($step > 1)<button type="button" wire:click="previousStep" class="btn btn-outline-secondary">← Back</button>@endif</div>
                    <div class="d-flex gap-2">
                        @if ($step < 4)
                            <button type="button" wire:click="nextStep" class="btn btn-primary">Continue →</button>
                        @else
                            <button type="button" wire:click="save(false)" wire:loading.attr="disabled" class="btn btn-outline-primary">Save product</button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">Save & manage attributes →</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <aside class="col-xl-4">
            <div class="card border-0 shadow-sm sticky-xl-top" style="top: 1rem">
                <div class="card-header bg-white py-3"><h5 class="mb-1">Setup summary</h5><small class="text-muted">Progress is validated one section at a time.</small></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Completed</span><strong>{{ $step - 1 }} of 4</strong></div>
                    <div class="progress mb-4" style="height: .45rem"><div class="progress-bar" style="width: {{ (($step - 1) / 4) * 100 }}%"></div></div>
                    <div class="summary-list"><div><span>Title</span><strong>{{ $title ?: 'Not set' }}</strong></div><div><span>Family</span><strong>{{ $families->firstWhere('id', (int) $attributeFamilyId)?->name ?? 'Not selected' }}</strong></div><div><span>Price</span><strong>₹{{ number_format((float) $salesPrice, 2) }}</strong></div></div>
                </div>
            </div>
        </aside>
    </div>
</form>
