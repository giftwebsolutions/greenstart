@if ($products->count())
    <section class="ga-home-products">
        <div class="container">
            <div class="ga-home-products-head">
                <div>
                    <div class="section-title">
                        <h2>{!! $title !!}</h2>
                    </div>
                    @if ($subtitle)
                        <p>{{ $subtitle }}</p>
                    @endif
                </div>

                @if ($categories->count() === 1)
                    <a href="{{ route('frontend.shop.category', $categories->first()->slug) }}" class="ga-section-link">
                        View all <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('frontend.shop.index') }}" class="ga-section-link">
                        View shop <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            @if ($categories->count() > 1)
                <div class="ga-home-cat-chips">
                    @foreach ($categories as $category)
                        <a href="{{ route('frontend.shop.category', $category->slug) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif

            <div class="row ga-home-product-grid">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-6 mb-4 product-item">
                        @include('frontend::catalog.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
