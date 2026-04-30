@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp
@if ($tabs && count($tabs) > 0)
    <div class="category-tab-slider-area mb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    {{-- Section title + tabs --}}
                    <div class="section-title">
                        <h2>
                            <span>{{ $title }}</span>
                        </h2>

                        <div class="box-tab">
                            <ul class="tab-heading tabs-categorys nav nav-tabs">
                                @foreach ($tabs as $i => $tab)
                                    <li>
                                        <a class="{{ $i === 0 ? 'active' : '' }}" data-bs-toggle="pill"
                                            href="#{{ $tab['id'] }}">
                                            <span>{{ $tab['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="category-tab-block">
                        {{-- Left banner --}}
                        <div class="category-image">
                            <div class="banner-area">
                                <div class="banner-wrapper">
                                    @if ($banner)
                                        <a
                                            href="{{ route('frontend.shop.product.show', $tabs[0]['category']->slug ?? '') }}">
                                            <img src="{{ $banner }}" alt="">
                                        </a>
                                    @else
                                        <a href="#">
                                            <img src="{{ asset('assets/images/banner-image/5.jpg') }}" alt="">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Right tab contents --}}
                        <div class="category-tab">
                            <div class="tab-content">

                                @foreach ($tabs as $i => $tab)
                                    @php
                                        $products = $tab['products'] ?? collect();
                                    @endphp

                                    <div id="{{ $tab['id'] }}" class="tab-pane {{ $i === 0 ? 'active' : 'fade' }}">
                                        @if ($products && $products->count() > 0)
                                            <div class="tab-product-slider-wrappwer">
                                                @foreach ($products->chunk(3) as $chunk)
                                                    <div class="product-slider-item">

                                                        @foreach ($chunk as $product)
                                                            @php

                                                                //dd($product);
                                                                $thumb = ImageUploader::getFilePath(
                                                                    $product->thumb ?? '',
                                                                    $product->created_at,
                                                                    'thumbnail',
                                                                );

                                                                // If you have relation `variants`, you can adjust this:
                                                                $price =
                                                                    optional($product->variants->first())->price ?? 0;
                                                            @endphp

                                                            <article class="product-layout list-product text-left">
                                                                <div class="product-inner">
                                                                    <div class="img-block">
                                                                        <a href="{{ route('frontend.shop.product.show', $product->slug ?? '') }}"
                                                                            class="thumbnail">
                                                                            <img class="first-img"
                                                                                src="{{ $thumb }}"
                                                                                alt="{{ $product->title }}">
                                                                            <img class="second-img"
                                                                                src="{{ $thumb }}"
                                                                                alt="{{ $product->title }}">
                                                                        </a>
                                                                    </div>

                                                                    <div class="product-decs">
                                                                        <a class="inner-link"
                                                                            href="{{ route('frontend.shop.categories', $tab['category']->slug ?? '') }}">
                                                                            <span>{{ $tab['category']->name }}</span>
                                                                        </a>

                                                                        <h2>
                                                                            <a href="{{ route('frontend.shop.product.show', $product->slug ?? '') }}"
                                                                                class="product-link">
                                                                                {{ $product->title }}
                                                                            </a>
                                                                        </h2>

                                                                        {{-- static 4/5 rating icons, change when rating system ready --}}
                                                                        <div class="rating-product">
                                                                            <i class="ion-android-star"></i>
                                                                            <i class="ion-android-star"></i>
                                                                            <i class="ion-android-star"></i>
                                                                            <i class="ion-android-star"></i>
                                                                            <i class="ion-android-star color-gray"></i>
                                                                        </div>

                                                                        <div class="pricing-meta">
                                                                            <ul>
                                                                                <li class="current-price">
                                                                                    ₹{{ number_format($price, 2) }}
                                                                                </li>
                                                                            </ul>

                                                                            <div class="cart-btn d-md-block d-none">
                                                                                <a href="{{ route('frontend.shop.product.show', $product->slug ?? '') }}"
                                                                                    class="add-to-curt">
                                                                                    View Details
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="cart-btn d-md-none">
                                                                    <a href="{{ route('frontend.shop.product.show', $product->slug ?? '') }}"
                                                                        class="add-to-curt">
                                                                        <i class="icon-shopping-cart"></i>
                                                                    </a>
                                                                </div>
                                                            </article>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            {{-- Optional: Empty state --}}
                                            <div class="text-center p-4">
                                                <p>No products available</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div> {{-- tab-content --}}
                        </div> {{-- category-tab --}}
                    </div> {{-- category-tab-block --}}
                </div>
            </div>
        </div>
    </div>
@endif
