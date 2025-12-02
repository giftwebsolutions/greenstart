{{-- Modules/Frontend/Resources/views/product/index.blade.php --}}
<x-frontend::layouts.master>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Products</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shop-category-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">
                            <div id="shop-1" class="tab-pane active">
                                <div class="row">

                                    @forelse ($products as $product)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-30px">
                                            <article class="list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="{{ route('frontend.products.show', $product->slug ?? $product->id) }}"
                                                           class="thumbnail">
                                                            <img class="first-img"
                                                                 src="{{ $product->thumb_path ?? asset('assets/images/product-image/placeholder.jpg') }}"
                                                                 alt="{{ $product->title }}">
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2>
                                                            <a href="{{ route('frontend.products.show', $product->slug ?? $product->id) }}"
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
                                                    <div class="cart-btn mt-2">
                                                        <a href="{{ route('frontend.products.show', $product->slug ?? $product->id) }}"
                                                           class="btn btn-primary btn-sm">
                                                            Buy Now
                                                        </a>
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
                                        {{-- L5 paginate() returns Laravel LengthAwarePaginator --}}
                                        {{ $products->links() }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div> {{-- col-lg-12 --}}
            </div>
        </div>
    </div>
</x-frontend::layouts.master>
