@forelse ($products as $product)
    <div class="col-lg-3 col-md-4 col-6 mb-4 product-item">
        @include('frontend::catalog.partials.product-card', ['product' => $product])
    </div>
@empty
    <div class="col-12">
        <div class="shop-empty-state">
            <strong>No products found</strong>
            <span>Try adjusting your filters or search term.</span>
        </div>
    </div>
@endforelse
