@php
    use Modules\SysAdmin\Helpers\ImageUploader;

    $title = $product->title ?? 'Product';
    $category = $product->category ?? null;
    $subCategory = $product->subCategory ?? null;
    $mainImage = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null);
    $thumbImage = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null, 'thumbnail');
    $gallery = collect([[
        'thumb' => $thumbImage,
        'full' => $mainImage,
        'alt' => $title,
    ]]);

    if ($product->relationLoaded('images')) {
        $gallery = $gallery->merge($product->images->map(fn ($image) => [
            'thumb' => $image->image_url,
            'full' => $image->original_image_url,
            'alt' => $title,
        ]));
    }

    $gallery = $gallery->unique('full')->values();
    $price = (float) ($product->sales_price ?? 0);
    $mrp = (float) ($product->mrp ?? 0);
    $hasDiscount = $mrp > 0 && $mrp > $price;
    $discountPercent = $hasDiscount ? round((($mrp - $price) / $mrp) * 100) : 0;
    $inStock = (int) ($product->stock ?? 1) > 0;
    $settings = Config::get('site-settings', []);
    $phone = $settings['mobile'] ?? '';
    $currencySymbol = $settings['currency_symbol'] ?? '₹';
    $showPrices = filter_var($settings['show_product_prices'] ?? true, FILTER_VALIDATE_BOOL);
    $enableEnquiries = filter_var($settings['enable_enquiries'] ?? true, FILTER_VALIDATE_BOOL);
    $enableWhatsApp = filter_var($settings['enable_whatsapp'] ?? true, FILTER_VALIDATE_BOOL);
    $waNumber = $enableWhatsApp ? preg_replace('/\D+/', '', $settings['whatsapp'] ?? '') : '';
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul class="nav">
                    <li><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li><a href="{{ route('frontend.shop.index') }}">Shop</a></li>
                    @if ($category)
                        <li><a href="{{ route('frontend.shop.category', $category->slug) }}">{{ $category->name }}</a></li>
                    @endif
                    <li>{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="pd-hero">
        <div class="container">
            <div class="pd-shell">
                <div class="pd-gallery" data-pd-gallery>
                    <div class="pd-main-image">
                        <img src="{{ $gallery->first()['full'] ?? $mainImage }}" alt="{{ $title }}" data-pd-main
                            onerror="this.onerror=null;this.src='{{ asset('uploads/default.jpg') }}';">
                        @if ($hasDiscount)
                            <span class="pd-badge">{{ $discountPercent }}% off</span>
                        @endif
                    </div>

                    @if ($gallery->count() > 1)
                        <div class="pd-thumbs">
                            @foreach ($gallery as $index => $image)
                                <button type="button" class="pd-thumb {{ $index === 0 ? 'is-active' : '' }}"
                                    data-full="{{ $image['full'] }}" aria-label="View image {{ $index + 1 }}">
                                    <img src="{{ $image['thumb'] }}" alt="{{ $image['alt'] }}" loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ asset('uploads/default.jpg') }}';">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="pd-summary">
                    <div class="pd-label-row">
                        @if ($category)
                            <a href="{{ route('frontend.shop.category', $category->slug) }}" class="pd-category">{{ $category->name }}</a>
                        @endif
                        @if ($subCategory)
                            <span class="pd-category muted">{{ $subCategory->name }}</span>
                        @endif
                    </div>

                    <h1>{{ $title }}</h1>

                    <div class="pd-meta">
                        @if (!empty($product->sku))
                            <span>SKU: <strong>{{ $product->sku }}</strong></span>
                        @endif
                        <span class="{{ $inStock ? 'is-stock' : 'is-out' }}">{{ $inStock ? 'Available' : 'Out of stock' }}</span>
                    </div>

                    @if ($showPrices)
                        <div class="pd-price-row">
                            <strong class="pd-price">{{ $currencySymbol }}{{ number_format($price) }}</strong>
                            @if ($hasDiscount)
                                <span class="pd-mrp">{{ $currencySymbol }}{{ number_format($mrp) }}</span>
                                <span class="pd-save">Save {{ $currencySymbol }}{{ number_format($mrp - $price) }}</span>
                            @endif
                        </div>
                    @endif

                    @if (!empty($product->short_description))
                        <p class="pd-short">{{ $product->short_description }}</p>
                    @endif

                    <div class="pd-trust">
                        <span><i class="fa-solid fa-droplet"></i> Aqua purifier solution</span>
                        <span><i class="fa-solid fa-screwdriver-wrench"></i> Installation support</span>
                        <span><i class="fa-solid fa-headset"></i> Service assistance</span>
                    </div>

                    <div class="pd-actions">
                        @if ($enableEnquiries)
                            <button type="button" class="pd-primary js-enquiry-open"
                                data-product-id="{{ $product->id }}"
                                data-category-id="{{ $product->product_category ?? 0 }}"
                                data-price="{{ $price }}"
                                data-product-name="{{ $title }}">
                                <i class="fa-regular fa-paper-plane"></i> Send Enquiry
                            </button>
                        @endif
                        <a class="pd-secondary" href="{{ $phone ? 'tel:' . $phone : route('frontend.contact') }}">
                            <i class="fa-solid fa-phone"></i> Talk to Expert
                        </a>
                        @if ($waNumber)
                            <a class="pd-whatsapp" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp Chat
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ((int) $product->type === 2 && $product->variants->count())
        <section class="pd-section">
            <div class="container">
                <div class="pd-panel">
                    <div class="pd-section-head">
                        <h2>Available Variants</h2>
                        <p>Choose the matching configuration for your water system.</p>
                    </div>
                    @php
                        $variantAttributes = collect();
                        foreach ($product->variants as $variant) {
                            foreach ($variant->values as $val) {
                                $variantAttributes->push($val->attribute);
                            }
                        }
                        $variantAttributes = $variantAttributes->filter()->unique('id');
                    @endphp
                    <div class="table-responsive pd-variant-table">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Variant</th>
                                    <th>SKU</th>
                                    @foreach ($variantAttributes as $attr)
                                        <th>{{ $attr->name }}</th>
                                    @endforeach
                                    @if ($showPrices)<th>Price</th>@endif
                                    <th>Stock</th>
                                    @if ($enableEnquiries)<th></th>@endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->variants as $variant)
                                    <tr>
                                        <td>{{ $variant->name ?? 'Variant ' . $variant->id }}</td>
                                        <td>{{ $variant->sku ?: '-' }}</td>
                                        @foreach ($variantAttributes as $attr)
                                            @php $val = $variant->values->firstWhere('attribute_id', $attr->id); @endphp
                                            <td>{{ $val?->attributeValue?->value ?? '-' }}</td>
                                        @endforeach
                                        @if ($showPrices)<td>{{ $currencySymbol }}{{ number_format($variant->sales_price ?? $variant->price ?? $price) }}</td>@endif
                                        <td>{{ $variant->stock ?? '-' }}</td>
                                        @if ($enableEnquiries)
                                            <td>
                                                <button type="button" class="pd-mini-btn js-enquiry-open"
                                                    data-product-id="{{ $product->id }}"
                                                    data-category-id="{{ $product->product_category ?? 0 }}"
                                                    data-price="{{ $variant->sales_price ?? $variant->price ?? $price }}"
                                                    data-product-name="{{ $title }} - {{ $variant->name ?? 'Variant ' . $variant->id }}">
                                                    Enquire
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="pd-section">
        <div class="container">
            <div class="pd-panel">
                <div class="description-review-topbar nav pd-tabs">
                    <a class="active" data-bs-toggle="tab" href="#pd-description">Description</a>
                    <a data-bs-toggle="tab" href="#pd-info">Additional Info</a>
                </div>
                <div class="tab-content pd-tab-content">
                    <div id="pd-description" class="tab-pane active">
                        {!! $product->description ?: '<p>No description available.</p>' !!}
                    </div>
                    <div id="pd-info" class="tab-pane">
                        {!! $product->additional_info ?? '<p>No additional information available.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($related->count())
        <section class="pd-section pd-related">
            <div class="container">
                <div class="pd-section-head">
                    <h2>Related Products</h2>
                    <p>More aqua purification products from the same range.</p>
                </div>
                <div class="row product-grid">
                    @foreach ($related as $rel)
                        <div class="col-lg-3 col-md-4 col-6 mb-4 product-item">
                            @include('frontend::catalog.partials.product-card', ['product' => $rel])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('frontend::catalog.modal')

    @push('scripts')
        <script>
            $(function () {
                $(document).on('click', '.pd-thumb', function () {
                    var full = $(this).data('full');
                    $('[data-pd-main]').attr('src', full);
                    $('.pd-thumb').removeClass('is-active');
                    $(this).addClass('is-active');
                });
            });
        </script>
    @endpush
</x-frontend::layouts.master>
