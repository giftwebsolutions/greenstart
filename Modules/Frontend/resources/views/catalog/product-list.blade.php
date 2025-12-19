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

    <div class="shop-category-area pt-60px pb-60px">
        <div class="container">

            {{-- Search bar on top (optional) --}}
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="mb-0">{{ $activeTitle ?? 'Products' }}</h3>
                </div>
                <div class="col-md-4">
                    <form method="GET" action="{{ route('frontend.shop.search') }}">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" value="{{ $q ?? request('q') }}"
                                placeholder="Search products...">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

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
                                                ₹{{ number_format($product->price ?? 0, 2) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn mt-2">
                                    <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}"
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
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

</x-frontend::layouts.master>
