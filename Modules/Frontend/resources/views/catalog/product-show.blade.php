@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    // Single main image using helper
    $mainImage = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null);

    // If you have gallery images stored somewhere, map them through helper,
    // otherwise just use the main image as an array with one element.
    $images = $product->gallery_images ?? [$mainImage];
@endphp

<x-frontend::layouts.master>

    {{-- Breadcrumb --}}
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li>{{ $product->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Details --}}
    <section class="product-details-area ">
        <div class="container">
            <div class="container-inner">
                <div class="row">
                    {{-- Images --}}
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="product-details-img product-details-tab">
                            <div class="zoompro-wrap zoompro-2">
                                @foreach ($images as $img)
                                    <div class="zoompro-border zoompro-span">
                                        <img class="zoompro" src="{{ $img }}"
                                            data-zoom-image="{{ $img }}" alt="{{ $product->title }}" />
                                    </div>
                                @endforeach
                            </div>
                            <div id="gallery" class="product-dec-slider-2">
                                @foreach ($images as $img)
                                    <div class="single-slide-item">
                                        <img class="img-responsive" data-image="{{ $img }}"
                                            data-zoom-image="{{ $img }}" src="{{ $img }}"
                                            alt="{{ $product->title }}" />
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="product-details-content">
                            <h2>{{ $product->title }}</h2>

                            <div class="pro-details-rating-wrap">
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>

                            <div class="pricing-meta">
                                <ul>
                                    <li class="cuttent-price">
                                        ₹{{ number_format($product->sales_price ?? 0, 2) }}
                                    </li>
                                   <li class="cuttent-price">
    <del class="text-muted fs-6">
        ₹{{ number_format($product->mrp ?? 0, 2) }}
    </del>
</li>

                                </ul>
                            </div>

                            <div class="product-classify">
                                <ul>
                                    <li>SKU:<span> {{ $product->sku }}</span></li>
                                    <li>Availability:<span>
                                            {{ ($product->stock ?? 0) > 0 ? 'In Stock' : 'Out of Stock' }}</span></li>
                                </ul>
                            </div>

                            <div class="pro-details-list">
                                <p>{{ $product->short_description }}</p>
                            </div>

                            {{-- Simple "Buy Now" for overall product --}}
                            <div class="pro-details-quality mt-0px mb-3">
                                <div class="pro-details-cart btn-hover">
                                    <a href="#" onclick="alert('Implement Buy Now flow'); return false;">Buy
                                        Now</a>
                                </div>
                            </div>

                            {{-- Variant table (only for variable products type=2) --}}
                            @if ((int) $product->type === 2 && $product->variants->count())
                                <h5 class="mb-2">Available Variants</h5>
                                <div class="table-responsive mb-3">
                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Variant Name</th>
                                                <th>SKU</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                @php
                                                    // get distinct configurable attributes from variant values
                                                    $variantAttributes = collect();
                                                    foreach ($product->variants as $variant) {
                                                        foreach ($variant->values as $val) {
                                                            $variantAttributes->push($val->attribute);
                                                        }
                                                    }
                                                    $variantAttributes = $variantAttributes->filter()->unique('id');
                                                @endphp
                                                @foreach ($variantAttributes as $attr)
                                                    <th>{{ $attr->name }}</th>
                                                @endforeach
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->variants as $variant)
                                                <tr>
                                                    <td>{{ $variant->name ?? 'Variant ' . $variant->id }}</td>
                                                    <td>{{ $variant->sku }}</td>
                                                    <td>₹{{ number_format($variant->price, 2) }}</td>
                                                    <td>{{ $variant->stock }}</td>

                                                    @foreach ($variantAttributes as $attr)
                                                        @php
                                                            $val = $variant->values->firstWhere(
                                                                'attribute_id',
                                                                $attr->id,
                                                            );
                                                        @endphp
                                                        <td>{{ $val?->attributeValue?->value ?? '-' }}</td>
                                                    @endforeach

                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary"
                                                            onclick="alert('Implement Buy Now for variant {{ $variant->sku }}'); return false;">
                                                            Buy Now
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Description tabs --}}
    <div class="description-review-area ptb-60px">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav">
                    <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                    <a data-bs-toggle="tab" href="#des-details2">Additional Info</a>
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details1" class="tab-pane active">
                        <div class="product-description-wrapper">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div id="des-details2" class="tab-pane">
                        <div class="product-anotherinfo-wrapper">
                            {!! $product->additional_info ?? '<p>No additional information.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if ($related->count())
        <div class="arrival-area mb-60px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><span>RELATED </span>PRODUCTS</h2>
                        </div>
                    </div>
                </div>
                <div class="arrival-wrapper">
                    <div class="arrival-slider slider-nav-style-1">
                        @foreach ($related as $rel)
                            <div class="arrval-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="{{ route('frontend.shop.product.show', $rel->slug ?? $rel->id) }}"
                                                class="thumbnail">
                                                @php
                                                    $relThumb = ImageUploader::getFilePath(
                                                        $rel->thumb ?? '',
                                                        $rel->created_at ?? null,
                                                        'thumbnail',
                                                    );
                                                @endphp

                                                <img class="first-img" src="{{ $relThumb }}"
                                                    alt="{{ $rel->title }}">
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="{{ route('frontend.shop.product.show', $rel->slug ?? $rel->id) }}"
                                                    class="product-link">{{ $rel->title }}</a></h2>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">₹{{ number_format($rel->price ?? 0, 2) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <a href="{{ route('frontend.shop.product.show', $rel->slug ?? $rel->id) }}"
                                                class="btn btn-success btn-sm">Buy Now</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-frontend::layouts.master>
