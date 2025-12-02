<x-frontend::layouts.master>

<!-- Breadcrumb -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>{{ $product->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Details -->
<section class="product-details-area">
    <div class="container">
        <div class="container-inner">
            <div class="row">

                <!-- Left Images -->
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-img product-details-tab">

                        {{-- Main Images --}}
                        <div class="zoompro-wrap zoompro-2">
                            @foreach($product->gallery_images ?? [$product->thumb_path] as $img)
                                <div class="zoompro-border zoompro-span">
                                    <img class="zoompro" src="{{ $img }}" data-zoom-image="{{ $img }}" alt="{{ $product->title }}"/>
                                </div>
                            @endforeach
                        </div>

                        {{-- Thumbnail Slider --}}
                        <div id="gallery" class="product-dec-slider-2">
                            @foreach($product->gallery_images ?? [$product->thumb_path] as $img)
                                <div class="single-slide-item">
                                    <img class="img-responsive"
                                         data-image="{{ $img }}"
                                         data-zoom-image="{{ $img }}"
                                         src="{{ $img }}" alt="{{ $product->title }}"/>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-content">

                        <h2>{{ $product->title }}</h2>

                        <!-- Rating (static for now) -->
                        <div class="pro-details-rating-wrap">
                            <div class="rating-product">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                            </div>
                        </div>

                        <!-- PRICE -->
                        <div class="pricing-meta">
                            <ul>
                                <li class="cuttent-price">
                                    ₹{{ number_format($product->price,2) }}
                                </li>
                                @if($product->old_price)
                                    <li class="old-price">
                                        ₹{{ number_format($product->old_price,2) }}
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Extra Info -->
                        <div class="product-classify">
                            <ul>
                                <li>SKU: <span>{{ $product->sku }}</span></li>
                                <li>Availability: 
                                    <span>{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Short Description -->
                        <div class="pro-details-list">
                            <p>{{ $product->short_description }}</p>
                        </div>

                        <!-- Buy Now Only -->
                        <div class="pro-details-quality mt-0px">
                            <div class="pro-details-cart btn-hover">
                                <a href="#" onclick="alert('Implement Buy Now'); return false;">BUY NOW</a>
                            </div>
                        </div>

                        <!-- Share -->
                        <div class="pro-details-social-info">
                            <span>Share</span>
                            <div class="social-info">
                                <ul>
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Policies -->
                        <div class="pro-details-policy">
                            <ul>
                                <li><img src="/assets/images/icons/policy.png" alt="" /><span>Free Shipping</span></l>
                                <li><img src="/assets/images/icons/policy-2.png" alt="" /><span>Easy Returns</span></l>
                                <li><img src="/assets/images/icons/policy-3.png" alt="" /><span>Best Price</span></l>
                            </ul>
                        </div>

                    </div>
                </div> <!-- Right -->

            </div>
        </div>
    </div>
</section>

<!-- Description, Info, Reviews -->
<div class="description-review-area ptb-60px">
    <div class="container">
        <div class="description-review-wrapper">

            <div class="description-review-topbar nav">
                <a class="active" data-bs-toggle="tab" href="#details">Product Details</a>
                <a data-bs-toggle="tab" href="#description">Description</a>
            </div>

            <div class="tab-content description-review-bottom">

                <div id="details" class="tab-pane active">
                    <div class="product-anotherinfo-wrapper">
                        {!! $product->additional_info ?? '<p>No additional details...</p>' !!}
                    </div>
                </div>

                <div id="description" class="tab-pane">
                    <div class="product-description-wrapper">
                        {!! $product->description !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- RELATED PRODUCTS -->
@if($related->count())
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

                @foreach($related as $rel)
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">

                                <div class="img-block">
                                    <a href="{{ route('frontend.products.show', $rel->slug ?? $rel->id) }}" class="thumbnail">
                                        <img class="first-img" src="{{ $rel->thumb_path }}" alt="{{ $rel->title }}"/>
                                    </a>
                                </div>

                                <div class="product-decs">
                                    <h2>
                                        <a href="{{ route('frontend.products.show', $rel->slug ?? $rel->id) }}" class="product-link">
                                            {{ $rel->title }}
                                        </a>
                                    </h2>

                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">₹{{ number_format($rel->price,2) }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="cart-btn">
                                    <a href="{{ route('frontend.products.show', $rel->slug ?? $rel->id) }}" class="btn btn-primary btn-sm">
                                        BUY NOW
                                    </a>
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
