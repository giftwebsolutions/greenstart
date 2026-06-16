@php
    // Merge products from all configured category tabs into one modern row.
    $featured = collect($tabs ?? [])
        ->flatMap(fn ($tab) => $tab['products'] ?? collect())
        ->unique('id')
        ->take($limit ?? 8)
        ->values();
@endphp

@if ($featured->count())
    <section class="category-tab-slider-area">
        <div class="container">
            <div class="section-title">
                <h2><span>{{ $title ?? 'Featured' }}</span></h2>
            </div>

            <div class="ga-prow">
                @foreach ($featured as $product)
                    @include('frontend::catalog.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
@endif
