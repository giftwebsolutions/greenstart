@if ($products && $products->count())
    <section class="arrival-area">
        <div class="container">
            <div class="ga-arrival-head">
                <div class="section-title">
                    <h2><span>New</span> Arrivals</h2>
                </div>
                <a class="ga-viewall" href="{{ route('frontend.shop.new-arrivals') }}">
                    View shop <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="ga-prow">
                @foreach ($products as $product)
                    @include('frontend::catalog.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
@endif
