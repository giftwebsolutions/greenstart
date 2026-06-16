@if ($products && $products->count())
    <section class="arrival-area">
        <div class="container">
            <div class="section-title">
                <h2><span>New</span> Arrivals</h2>
                <a class="ga-viewall" href="{{ route('frontend.shop.new-arrivals') }}">View All <i class="fa-solid fa-angle-right"></i></a>
            </div>

            <div class="ga-prow">
                @foreach ($products as $product)
                    @include('frontend::catalog.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
@endif
