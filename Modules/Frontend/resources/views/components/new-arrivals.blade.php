@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp

<div class="arrival-area">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2><span>NEW</span> ARRIVALS</h2>
                </div>
            </div>
        </div>

        <div class="arrival-wrapper">
            <div class="arrival-slider slider-nav-style-1">

                @foreach ($products as $product)
                    @php
                        $thumb = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at, 'thumbnail');
                    @endphp

                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">

                                <div class="img-block">
                                    <a href="{{ route('frontend.shop.product.show', $product->slug) }}"
                                        class="thumbnail">
                                        <img class="first-img" src="{{ $thumb }}" alt="{{ $product->title }}">
                                        <img class="second-img" src="{{ $thumb }}" alt="{{ $product->title }}">
                                    </a>

                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>

                                <div class="product-decs">
                                    <h2>
                                        <a href="{{ route('frontend.shop.product.show', $product->slug) }}"
                                            class="product-link">
                                            {{ $product->title }}
                                        </a>
                                    </h2>

                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">
                                                ₹{{ number_format($product->price, 2) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="cart-btn">
                                    <a href="{{ route('frontend.shop.product.show', $product->slug) }}"
                                        class="add-to-curt">
                                        <i class="icon-shopping-cart"></i> Buy Now
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
