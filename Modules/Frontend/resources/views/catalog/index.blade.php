@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul class="nav">
                    <li><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li>Shop</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="shop-category-landing">
        <div class="container">
            <div class="shop-category-hero">
                <div>
                    <span class="shop-category-kicker">Aqua product catalogue</span>
                    <h1>Shop by category</h1>
                    <p>Choose a purifier, RO system, dispenser, membrane, pump, or spare category to view matching products.</p>
                </div>
                <label class="shop-category-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" placeholder="Search categories or spare parts..." data-category-search>
                </label>
            </div>

            <div class="shop-category-grid" data-category-grid>
                @foreach ($rootCategories as $category)
                    @php
                        $imageSource = $categoryImages[$category->id] ?? $category->image;
                        $image = is_array($imageSource)
                            ? ImageUploader::getFilePath($imageSource['file'] ?? '', $imageSource['created_at'] ?? null, 'thumbnail')
                            : ($imageSource
                                ? ImageUploader::getFilePath($imageSource, $category->created_at ?? null, 'thumbnail')
                                : asset('uploads/default.jpg'));
                        $count = $categoryProductCounts[$category->id] ?? 0;
                    @endphp

                    <article class="shop-category-card" data-category-card data-search="{{ strtolower($category->name . ' ' . $category->children->pluck('name')->implode(' ')) }}">
                        <a href="{{ route('frontend.shop.category', $category->slug) }}" class="shop-category-main">
                            <span class="shop-category-thumb">
                                <img src="{{ $image }}" alt="{{ $category->name }}" loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('uploads/default.jpg') }}';">
                            </span>
                            <span class="shop-category-copy">
                                <span class="shop-category-name">{{ $category->name }}</span>
                                <span class="shop-category-count">{{ $count }} {{ $count === 1 ? 'product' : 'products' }}</span>
                                <span class="shop-category-action">Browse products</span>
                            </span>
                            <span class="shop-category-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                        </a>

                        @if ($category->children->count())
                            <div class="shop-subcategory-title">Sub categories</div>
                            <div class="shop-subcategory-list">
                                @foreach ($category->children as $child)
                                    @php
                                        $childCount = $categoryProductCounts[$child->id] ?? 0;
                                        $subHref = route('frontend.shop.category', $category->slug) . '?s_cat=' . $child->id;
                                        $childImageSource = $categoryImages[$child->id] ?? $child->image;
                                        $childImage = is_array($childImageSource)
                                            ? ImageUploader::getFilePath($childImageSource['file'] ?? '', $childImageSource['created_at'] ?? null, 'thumbnail')
                                            : ($childImageSource
                                                ? ImageUploader::getFilePath($childImageSource, $child->created_at ?? null, 'thumbnail')
                                                : asset('uploads/default.jpg'));
                                    @endphp
                                    <a href="{{ $subHref }}" class="shop-subcategory-chip">
                                        <img src="{{ $childImage }}" alt="{{ $child->name }}" loading="lazy"
                                            onerror="this.onerror=null;this.src='{{ asset('uploads/default.jpg') }}';">
                                        <span>{{ $child->name }}</span>
                                        <small>{{ $childCount }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="shop-category-empty" data-category-empty hidden>
                <strong>No categories found</strong>
                <span>Try another search term.</span>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(function () {
                var $cards = $('[data-category-card]');
                var $empty = $('[data-category-empty]');

                $('[data-category-search]').on('input', function () {
                    var query = $.trim($(this).val()).toLowerCase();
                    var visible = 0;

                    $cards.each(function () {
                        var matches = !query || String($(this).data('search')).indexOf(query) !== -1;
                        $(this).toggle(matches);
                        if (matches) {
                            visible++;
                        }
                    });

                    $empty.prop('hidden', visible !== 0);
                });
            });
        </script>
    @endpush

</x-frontend::layouts.master>
