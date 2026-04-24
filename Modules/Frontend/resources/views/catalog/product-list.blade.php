@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp
<x-frontend::layouts.master>

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li>{{ $activeTitle ?? 'Products' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shop-category-area pt-30px pb-60px">
        <div class="container">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30px">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}"
                                        class="thumbnail">

                                        @php
                                            $thumbUrl = ImageUploader::getFilePath(
                                                $product->thumb ?? '',
                                                $product->created_at ?? null,
                                                'thumbnail', // stored in /Y/m/thumbnail/filename
                                            );
                                        @endphp
                                        <img class="first-img" src="{{ $thumbUrl }}" alt="{{ $product->title }}">
                                    </a>
                                </div>
                                <div class="product-decs">
                                    <h2>
                                        <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}"
                                            class="product-link">
                                            {{ $product->title }}
                                        </a>
                                    </h2>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">
                                                ₹{{ number_format($product->sales_price ?? 0, 2) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="cart-btn mt-2">
                                    <button type="button" class="btn btn-success btn-sm js-enquiry-open"
                                        data-product-id="{{ $product->id }}"
                                        data-category-id="{{ $product->category_id ?? 0 }}"
                                        data-price="{{ $product->sales_price ?? 0 }}"
                                        data-product-name="{{ $product->name ?? ($product->title ?? '') }}">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No products found.</p>
                    </div>
                @endforelse

                <div class="col-12 mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
    @include('frontend::catalog.modal');
</x-frontend::layouts.master>
