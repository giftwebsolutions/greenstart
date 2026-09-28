@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Carbon\Carbon;
    /**
     * Variables available:
     *   $products       – LengthAwarePaginator
     *   $filterGroups   – Collection<AttributeGroup>  (each has ->attributes with ->values)
     *   $rootCategories – Collection<ProductCategory>  (with ->children)
     *   $filters        – array  [c_cat, s_cat, search, attrs, sort]
     *   $activeTitle    – string
     *   $category       – ProductCategory|null
     *   $subCategories  – Collection|null
     *   $q              – string|null
     */

    $currentAttrs  = $filters['attrs']  ?? [];
    $currentCCat   = $filters['c_cat']  ?? null;
    $currentSCat   = $filters['s_cat']  ?? null;
    $currentSort   = $filters['sort']   ?? 'newest';
    $currentSearch = $filters['search'] ?? null;

    $formAction = match (true) {
        isset($category) => route('frontend.shop.category', $category->slug),
        request()->routeIs('frontend.shop.search') => route('frontend.shop.search'),
        default => route('frontend.shop.new-arrivals'),
    };
    $priceFloor = (int) ($filters['price_min'] ?? 0);
    $priceLimit = (int) ($filters['price_max'] ?? $priceCeiling ?? 1000);
    $hasPriceFilter = isset($filters['price_min']) || isset($filters['price_max']);

    $shopFilterUrl = static function (string $baseUrl, array $currentAttrs, int $attrId, int $valueId, ?int $cCat, ?int $sCat, ?string $sort, ?string $search, ?int $priceMin, ?int $priceMax): string {
        $attrs    = $currentAttrs;
        $existing = array_map('intval', (array) ($attrs[$attrId] ?? []));
        if (in_array($valueId, $existing)) {
            $existing = array_values(array_filter($existing, fn($v) => $v !== $valueId));
        } else {
            $existing[] = $valueId;
        }
        if (empty($existing)) {
            unset($attrs[$attrId]);
        } else {
            $attrs[$attrId] = $existing;
        }
        $query = array_filter([
            'c_cat' => $cCat,
            's_cat' => $sCat,
            'sort'  => $sort !== 'newest' ? $sort : null,
            'q'     => $search,
            'price_min' => $priceMin,
            'price_max' => $priceMax,
        ], fn ($value) => $value !== null && $value !== '');
        if (!empty($attrs)) {
            foreach ($attrs as $aId => $vIds) {
                $query['attr'][(int) $aId] = array_values(array_map('intval', (array) $vIds));
            }
        }
        return $baseUrl . (empty($query) ? '' : '?' . http_build_query($query));
    };

    $activeChips = [];
    foreach ($currentAttrs as $attrId => $valueIds) {
        foreach ($filterGroups as $group) {
            foreach ($group->attributes as $attr) {
                if ((int) $attr->id !== (int) $attrId) continue;
                foreach ($attr->values as $val) {
                    if (in_array((int) $val->id, array_map('intval', (array) $valueIds))) {
                        $removeUrl = $shopFilterUrl($formAction, $currentAttrs, (int) $attrId, (int) $val->id, $currentCCat, $currentSCat, $currentSort, $currentSearch, $hasPriceFilter ? $priceFloor : null, $hasPriceFilter ? $priceLimit : null);
                        $activeChips[] = ['label' => $attr->name . ': ' . $val->value, 'url' => $removeUrl];
                    }
                }
            }
        }
    }

    $totalProducts = $products->total();
    $from          = $products->firstItem() ?? 0;
    $to            = $products->lastItem()  ?? 0;
    $lastPage      = $products->lastPage();
    $perPageCount  = $products->perPage();
    $currencySymbol = config('site-settings.currency_symbol', '₹');
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            @isset($category)
                                <li><a href="{{ route('frontend.shop.index') }}">Shop</a></li>
                            @endisset
                            <li>{{ $activeTitle }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shop-area pt-30px pb-60px">
        <div class="container">
            <div class="row">

                {{-- ══════════════════════════════════════════
                     LEFT SIDEBAR
                ══════════════════════════════════════════ --}}
                <div class="col-lg-3 col-md-4 mb-4 shop-sidebar" id="shopSidebar">

                    <div class="shop-filter-head d-lg-none">
                        <strong><i class="fa-solid fa-sliders"></i> Filters</strong>
                        <button type="button" class="shop-filter-close" data-shop-filter-close aria-label="Close filters">&times;</button>
                    </div>

                    {{-- Search --}}
                    <div class="sw-box mb-3">
                        <form method="GET" action="{{ route('frontend.shop.search') }}">
                            <div class="input-group input-group-sm">
                                <input type="text" name="q" class="form-control"
                                       placeholder="Search products…"
                                       value="{{ $currentSearch ?? old('q') }}">
                                <button class="btn btn-sw-search" type="submit">
                                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Categories --}}
                    <div class="sw-box mb-3">
                        <h6 class="sw-title">CATEGORIES</h6>
                        <ul class="list-unstyled sw-cat-list mb-0">
                            @foreach ($rootCategories as $cat)
                                @php
                                    $isCurrent   = isset($category) && $category->id === $cat->id;
                                    $hasSubs     = $isCurrent && isset($subCategories) && $subCategories->isNotEmpty();
                                    $catId       = 'cat-sub-' . $cat->id;
                                @endphp
                                <li class="sw-cat-item">
                                    <div class="sw-cat-row">
                                        <a href="{{ route('frontend.shop.category', $cat->slug) }}"
                                           class="sw-cat-link {{ $isCurrent ? 'active' : '' }}">
                                            {{ $cat->name }}
                                        </a>
                                        @if ($hasSubs)
                                            <button class="sw-chevron-btn" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $catId }}"
                                                    aria-expanded="{{ $isCurrent ? 'true' : 'false' }}">
                                                <svg class="sw-chevron {{ $isCurrent ? 'open' : '' }}" width="10" height="10" viewBox="0 0 12 12" fill="currentColor">
                                                    <path d="M6 8L1 3h10z"/>
                                                </svg>
                                            </button>
                                        @else
                                            <svg class="sw-chevron-static" width="10" height="10" viewBox="0 0 12 12" fill="currentColor">
                                                <path d="M4 2l5 4-5 4V2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    @if ($hasSubs)
                                        <div class="collapse {{ $isCurrent ? 'show' : '' }}" id="{{ $catId }}">
                                            <ul class="list-unstyled sw-sub-list">
                                                @foreach ($subCategories as $sub)
                                                    @php
                                                        $isActiveSub = (int) $currentSCat === (int) $sub->id;
                                                        $subQs = $isActiveSub
                                                            ? \Illuminate\Support\Arr::query(array_filter(['c_cat' => $currentCCat, 'sort' => $currentSort !== 'newest' ? $currentSort : null, 'q' => $currentSearch]))
                                                            : \Illuminate\Support\Arr::query(array_filter(['s_cat' => $sub->id, 'sort' => $currentSort !== 'newest' ? $currentSort : null, 'q' => $currentSearch]));
                                                        $subHref = route('frontend.shop.category', $cat->slug) . ($subQs ? '?' . $subQs : '');
                                                    @endphp
                                                    <li>
                                                        <a href="{{ $subHref }}"
                                                           class="sw-sub-link {{ $isActiveSub ? 'active' : '' }}">
                                                            {{ $sub->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Filter by Price --}}
                    <div class="sw-box mb-3">
                        <h6 class="sw-title">FILTER BY PRICE</h6>
                        <div class="px-1">
                            <div id="sw-price-slider" class="sw-price-track mb-2">
                                <div class="sw-price-fill" id="sw-price-fill"></div>
                                <input type="range" id="sw-price-min-r" min="0" max="{{ $priceCeiling }}" step="100"
                                       value="{{ $priceFloor }}" class="sw-range-input">
                                <input type="range" id="sw-price-max-r" min="0" max="{{ $priceCeiling }}" step="100"
                                       value="{{ $priceLimit }}" class="sw-range-input">
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:.8rem;color:#555">
                                <span>{{ $currencySymbol }}<span id="sw-price-lbl-min">{{ number_format($priceFloor) }}</span></span>
                                <span>{{ $currencySymbol }}<span id="sw-price-lbl-max">{{ number_format($priceLimit) }}</span></span>
                            </div>
                            <form method="GET" action="{{ $formAction }}" id="price-filter-form">
                                @if ($currentSCat)
                                    <input type="hidden" name="s_cat" value="{{ $currentSCat }}">
                                @endif
                                @if ($currentSearch)
                                    <input type="hidden" name="q" value="{{ $currentSearch }}">
                                @endif
                                @foreach ($currentAttrs as $attrId => $valueIds)
                                    @foreach ((array) $valueIds as $vId)
                                        <input type="hidden" name="attr[{{ $attrId }}][]" value="{{ $vId }}">
                                    @endforeach
                                @endforeach
                                @if ($currentSort !== 'newest')
                                    <input type="hidden" name="sort" value="{{ $currentSort }}">
                                @endif
                                <input type="hidden" name="price_min" id="pf-min" value="{{ $priceFloor }}">
                                <input type="hidden" name="price_max" id="pf-max" value="{{ $priceLimit }}">
                                <button type="submit" class="btn btn-sw-green btn-sm">Apply</button>
                            </form>
                        </div>
                    </div>

                    {{-- Attribute group filters --}}
                    @foreach ($filterGroups as $group)
                        <div class="sw-box mb-3">
                            <h6 class="sw-title">{{ strtoupper($group->name) }}</h6>
                            @foreach ($group->attributes as $attr)
                                @if ($attr->values->isNotEmpty())
                                    @php $cols = $attr->values->count() > 6 ? 2 : 1; @endphp
                                    <ul class="list-unstyled sw-check-list {{ $cols === 2 ? 'two-col' : '' }} mb-0">
                                        @foreach ($attr->values as $val)
                                            @php
                                                $isChecked = in_array((int) $val->id, array_map('intval', (array) ($currentAttrs[$attr->id] ?? [])));
                                                $toggleUrl = $shopFilterUrl($formAction, $currentAttrs, (int) $attr->id, (int) $val->id, $currentCCat, $currentSCat, $currentSort, $currentSearch, $hasPriceFilter ? $priceFloor : null, $hasPriceFilter ? $priceLimit : null);
                                            @endphp
                                            <li>
                                                <a href="{{ $toggleUrl }}"
                                                   class="sw-check-link {{ $isChecked ? 'checked' : '' }}">
                                                    <span class="sw-cb {{ $isChecked ? 'checked' : '' }}"></span>
                                                    <span class="sw-check-label">{{ $val->value }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                    @endforeach

                    {{-- Clear all filters --}}
                    @if (!empty($activeChips))
                        <div class="mb-3">
                            <a href="{{ $formAction }}"
                               class="btn btn-outline-danger btn-sm w-100">
                                Clear All Filters
                            </a>
                        </div>
                    @endif

                    <div class="shop-filter-apply d-lg-none">
                        <button type="button" class="btn-sw-green" data-shop-filter-close>View results</button>
                    </div>

                </div>{{-- /sidebar --}}

                {{-- ══════════════════════════════════════════
                     MAIN CONTENT
                ══════════════════════════════════════════ --}}
                <div class="col-lg-9 col-md-8">

                    <button type="button" class="shop-filter-trigger d-lg-none" data-shop-filter-open>
                        <i class="fa-solid fa-sliders"></i> Filters &amp; Categories
                    </button>

                    {{-- Page heading --}}
                    <h4 class="shop-h4 mb-2">{{ $activeTitle }}</h4>

                    {{-- Refine search (subcategories shown as links) --}}
                    @if (isset($subCategories) && $subCategories->isNotEmpty())
                        <div class="refine-box mb-3">
                            <strong class="refine-label">Refine Search</strong>
                            <ul class="list-unstyled refine-list mb-0">
                                @foreach ($subCategories as $sub)
                                    @php
                                        $isActiveSub = (int) $currentSCat === (int) $sub->id;
                                        $subQs2 = $isActiveSub
                                            ? \Illuminate\Support\Arr::query(array_filter(['c_cat' => $currentCCat, 'sort' => $currentSort !== 'newest' ? $currentSort : null, 'q' => $currentSearch]))
                                            : \Illuminate\Support\Arr::query(array_filter(['s_cat' => $sub->id, 'sort' => $currentSort !== 'newest' ? $currentSort : null, 'q' => $currentSearch]));
                                        $subHref2 = route('frontend.shop.category', $category->slug) . ($subQs2 ? '?' . $subQs2 : '');
                                    @endphp
                                    <li>
                                        <a href="{{ $subHref2 }}"
                                           class="refine-link {{ $isActiveSub ? 'active' : '' }}">
                                            {{ $sub->name }}
                                            @if (isset($sub->products_count))
                                                ({{ $sub->products_count }})
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Active filter chips --}}
                    @if (!empty($activeChips))
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach ($activeChips as $chip)
                                <a href="{{ $chip['url'] }}" class="chip-badge">
                                    {{ $chip['label'] }} <span>&times;</span>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Toolbar --}}
                    <div class="shop-toolbar mb-3">
                        <div class="d-flex align-items-center gap-2">
                            {{-- View toggles --}}
                            <div class="view-btns">
                                <button class="vbtn active" id="v-grid3" title="3 columns">
                                    <svg width="16" height="16" viewBox="0 0 15 15" fill="currentColor">
                                        <rect x="0" y="0" width="4" height="4"/><rect x="5.5" y="0" width="4" height="4"/><rect x="11" y="0" width="4" height="4"/>
                                        <rect x="0" y="5.5" width="4" height="4"/><rect x="5.5" y="5.5" width="4" height="4"/><rect x="11" y="5.5" width="4" height="4"/>
                                        <rect x="0" y="11" width="4" height="4"/><rect x="5.5" y="11" width="4" height="4"/><rect x="11" y="11" width="4" height="4"/>
                                    </svg>
                                </button>
                                <button class="vbtn" id="v-grid4" title="4 columns">
                                    <svg width="16" height="16" viewBox="0 0 15 15" fill="currentColor">
                                        <rect x="0" y="0" width="3" height="4"/><rect x="4" y="0" width="3" height="4"/><rect x="8" y="0" width="3" height="4"/><rect x="12" y="0" width="3" height="4"/>
                                        <rect x="0" y="5.5" width="3" height="4"/><rect x="4" y="5.5" width="3" height="4"/><rect x="8" y="5.5" width="3" height="4"/><rect x="12" y="5.5" width="3" height="4"/>
                                        <rect x="0" y="11" width="3" height="4"/><rect x="4" y="11" width="3" height="4"/><rect x="8" y="11" width="3" height="4"/><rect x="12" y="11" width="3" height="4"/>
                                    </svg>
                                </button>
                                <button class="vbtn" id="v-list" title="List view">
                                    <svg width="16" height="16" viewBox="0 0 15 15" fill="currentColor">
                                        <rect x="0" y="0" width="4" height="4"/><rect x="6" y="1" width="9" height="2"/>
                                        <rect x="0" y="5.5" width="4" height="4"/><rect x="6" y="6.5" width="9" height="2"/>
                                        <rect x="0" y="11" width="4" height="4"/><rect x="6" y="12" width="9" height="2"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="toolbar-count">
                                Showing {{ $from }} to {{ $to }} of {{ $totalProducts }}
                                ({{ $lastPage }} {{ $lastPage === 1 ? 'Page' : 'Pages' }})
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            {{-- Show per page --}}
                            <form method="GET" action="{{ $formAction }}" id="pp-form" class="d-flex align-items-center gap-1">
                                @if ($currentSCat)
                                    <input type="hidden" name="s_cat" value="{{ $currentSCat }}">
                                @endif
                                @if ($currentSearch)
                                    <input type="hidden" name="q" value="{{ $currentSearch }}">
                                @endif
                                @foreach ($currentAttrs as $attrId => $valueIds)
                                    @foreach ((array) $valueIds as $vId)
                                        <input type="hidden" name="attr[{{ $attrId }}][]" value="{{ $vId }}">
                                    @endforeach
                                @endforeach
                                @if ($currentSort !== 'newest')
                                    <input type="hidden" name="sort" value="{{ $currentSort }}">
                                @endif
                                @if ($hasPriceFilter)
                                    <input type="hidden" name="price_min" value="{{ $priceFloor }}">
                                    <input type="hidden" name="price_max" value="{{ $priceLimit }}">
                                @endif
                                <label class="toolbar-label mb-0">Show:</label>
                                <select name="per_page" class="form-select form-select-sm toolbar-sel">
                                    @foreach ([12, 24, 36] as $pp)
                                        <option value="{{ $pp }}" @selected($perPageCount == $pp)>{{ $pp }}</option>
                                    @endforeach
                                </select>
                            </form>

                            {{-- Sort --}}
                            <form method="GET" action="{{ $formAction }}" id="sort-form" class="d-flex align-items-center gap-1">
                                @if ($currentSCat)
                                    <input type="hidden" name="s_cat" value="{{ $currentSCat }}">
                                @endif
                                @if ($currentSearch)
                                    <input type="hidden" name="q" value="{{ $currentSearch }}">
                                @endif
                                @foreach ($currentAttrs as $attrId => $valueIds)
                                    @foreach ((array) $valueIds as $vId)
                                        <input type="hidden" name="attr[{{ $attrId }}][]" value="{{ $vId }}">
                                    @endforeach
                                @endforeach
                                @if ($perPageCount != 12)
                                    <input type="hidden" name="per_page" value="{{ $perPageCount }}">
                                @endif
                                @if ($hasPriceFilter)
                                    <input type="hidden" name="price_min" value="{{ $priceFloor }}">
                                    <input type="hidden" name="price_max" value="{{ $priceLimit }}">
                                @endif
                                <label class="toolbar-label mb-0">Sort By:</label>
                                <select name="sort" class="form-select form-select-sm toolbar-sel">
                                    <option value="newest"     @selected($currentSort === 'newest')>Default</option>
                                    <option value="price_asc"  @selected($currentSort === 'price_asc')>Price: Low → High</option>
                                    <option value="price_desc" @selected($currentSort === 'price_desc')>Price: High → Low</option>
                                    <option value="name_asc"   @selected($currentSort === 'name_asc')>Name A–Z</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Product grid --}}
                    <div class="row product-grid" id="product-grid" aria-live="polite">
                        @include('frontend::catalog.partials.product-grid', ['products' => $products])
                    </div>

                    {{-- Bottom bar: count + infinite loader --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-center my-3 gap-2">
                        <span class="toolbar-count" data-product-count>
                            @include('frontend::catalog.partials.product-count', ['products' => $products])
                        </span>
                    </div>

                    <div class="shop-infinite" data-infinite-wrap data-next-url="{{ $products->withQueryString()->nextPageUrl() }}">
                        <button type="button" class="shop-load-more" data-load-more @disabled(!$products->hasMorePages())>
                            <span class="shop-load-label">{{ $products->hasMorePages() ? 'Load more products' : 'No more products' }}</span>
                            <span class="shop-load-spinner" aria-hidden="true"></span>
                        </button>
                    </div>

                </div>{{-- /col main --}}
            </div>
        </div>
        <div class="shop-filter-overlay" data-shop-filter-close></div>
    </div>

    @include('frontend::catalog.modal')

    <style>
        :root { --sg:#05a9a6; --sg-h:#087f82; --sg-l:#36a852; }

        .shop-area { background: linear-gradient(180deg, #f6fcfc, #fff); }

        /* ── Sidebar widget ── */
        .sw-box { background:#fff; border:1px solid var(--aqua-line); border-radius:16px; padding:18px; box-shadow:var(--shadow-sm); }
        .sw-title { font-size:.78rem; font-weight:800; letter-spacing:.06em; color:var(--aqua-ink); padding-bottom:12px; margin-bottom:14px; border-bottom:1px solid var(--aqua-line); }

        .sw-box .input-group .form-control { border:1px solid var(--aqua-line); border-right:0; border-radius:12px 0 0 12px; min-height:44px; }
        .sw-box .input-group .form-control:focus { box-shadow:none; border-color:var(--aqua); }
        .btn-sw-search { background:linear-gradient(135deg,var(--aqua),var(--leaf)); color:#fff; border:0; padding:0 14px; border-radius:0 12px 12px 0; }
        .btn-sw-search:hover { filter:brightness(1.05); color:#fff; }

        /* Category list */
        .sw-cat-item { border-bottom:1px solid var(--aqua-line); }
        .sw-cat-item:last-child { border-bottom:0; }
        .sw-cat-row { display:flex; align-items:center; justify-content:space-between; }
        .sw-cat-link { display:block; flex:1; padding:9px 0; font-size:.9rem; font-weight:600; color:var(--aqua-ink); text-decoration:none; }
        .sw-cat-link:hover, .sw-cat-link.active { color:var(--aqua-dark); }
        .sw-chevron-btn { background:none; border:0; padding:0 4px; cursor:pointer; color:var(--aqua-muted); line-height:1; }
        .sw-chevron { transition:transform .2s; }
        .sw-chevron.open { transform:rotate(180deg); }
        .sw-chevron-static { color:var(--aqua-muted); }
        .sw-sub-list { margin:2px 0 10px 10px; padding:0; }
        .sw-sub-link { display:block; padding:6px 0; font-size:.84rem; color:var(--aqua-muted); text-decoration:none; }
        .sw-sub-link:hover, .sw-sub-link.active { color:var(--aqua-dark); font-weight:600; }

        /* Price slider */
        .sw-price-track { position:relative; height:5px; background:var(--aqua-line); border-radius:3px; margin:16px 0 8px; }
        .sw-price-fill { position:absolute; height:100%; background:var(--aqua); border-radius:3px; pointer-events:none; }
        .sw-range-input { position:absolute; width:100%; top:-6px; left:0; background:transparent; -webkit-appearance:none; appearance:none; pointer-events:none; height:18px; }
        .sw-range-input::-webkit-slider-thumb { -webkit-appearance:none; appearance:none; width:18px; height:18px; border-radius:50%; background:#fff; border:3px solid var(--aqua); box-shadow:var(--shadow-sm); cursor:pointer; pointer-events:all; }
        .sw-range-input::-moz-range-thumb { width:18px; height:18px; border-radius:50%; background:#fff; border:3px solid var(--aqua); cursor:pointer; pointer-events:all; }

        /* Checkbox list */
        .sw-check-list { margin:0; }
        .sw-check-list.two-col { display:grid; grid-template-columns:1fr 1fr; gap:2px 10px; }
        .sw-check-link { display:flex; align-items:center; gap:9px; padding:6px 0; font-size:.86rem; color:var(--aqua-ink); text-decoration:none; }
        .sw-check-link:hover { color:var(--aqua-dark); }
        .sw-check-link.checked { color:var(--aqua-dark); font-weight:600; }
        .sw-cb { flex-shrink:0; width:18px; height:18px; border:1.5px solid var(--aqua-line); border-radius:6px; display:inline-flex; align-items:center; justify-content:center; transition:.15s; }
        .sw-cb.checked { background:var(--aqua); border-color:var(--aqua); }
        .sw-cb.checked::after { content:'✓'; color:#fff; font-size:11px; line-height:1; }

        .btn-sw-green { background:linear-gradient(135deg,var(--aqua-dark),var(--aqua)); color:#fff; border:0; border-radius:999px; font-weight:800; padding:9px 22px; }
        .btn-sw-green:hover { filter:brightness(1.05); color:#fff; }

        /* ── Main headings / refine ── */
        .shop-h4 { font-size:1.5rem; font-weight:900; color:var(--aqua-ink); }
        .refine-box { background:#fff; border:1px solid var(--aqua-line); border-radius:14px; padding:14px 16px; box-shadow:var(--shadow-sm); }
        .refine-label { font-weight:800; color:var(--aqua-ink); }
        .refine-list { margin:8px 0 0; display:flex; flex-wrap:wrap; gap:8px; }
        .refine-list li { margin:0; }
        .refine-link { display:inline-flex; padding:6px 13px; border-radius:999px; background:var(--aqua-soft); color:var(--aqua-dark); font-weight:600; font-size:.82rem; text-decoration:none; }
        .refine-link:hover, .refine-link.active { background:var(--aqua); color:#fff; }

        /* Active chips */
        .chip-badge { display:inline-flex; align-items:center; gap:6px; background:var(--aqua-soft); color:var(--aqua-dark); font-size:.78rem; font-weight:700; padding:5px 12px; border-radius:999px; text-decoration:none; }
        .chip-badge span { font-size:1rem; line-height:1; }
        .chip-badge:hover { background:var(--danger); color:#fff; }

        /* ── Toolbar ── */
        .shop-toolbar { background:#fff; border:1px solid var(--aqua-line); border-radius:14px; padding:10px 14px; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:10px; box-shadow:var(--shadow-sm); }
        .view-btns { display:flex; gap:4px; }
        .vbtn { background:#fff; border:1px solid var(--aqua-line); border-radius:10px; padding:7px 9px; cursor:pointer; color:var(--aqua-muted); line-height:1; }
        .vbtn:hover, .vbtn.active { background:var(--aqua); border-color:var(--aqua); color:#fff; }
        .toolbar-count { font-size:.84rem; color:var(--aqua-muted); }
        .toolbar-label { font-size:.84rem; color:var(--aqua-muted); white-space:nowrap; font-weight:600; }
        .toolbar-sel { font-size:.84rem; min-width:90px; border-radius:10px; border-color:var(--aqua-line); }

        /* ── Product cards ── */
        .pcard { border:1px solid var(--aqua-line); border-radius:16px; background:#fff; overflow:hidden; height:100%; transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        .pcard:hover { transform:translateY(-3px); border-color:rgba(5,169,166,.45); box-shadow:var(--shadow-md); }
        .pcard-img-wrap { position:relative; display:block; background:linear-gradient(180deg,#f7fcfc,#edf8f7); text-align:center; padding:18px; }
        .pcard-img { max-height:200px; width:auto; max-width:100%; object-fit:contain; transition:transform .25s ease; }
        .pcard:hover .pcard-img { transform:scale(1.05); }
        .pbadge { position:absolute; top:10px; left:10px; font-size:.7rem; font-weight:800; padding:4px 9px; border-radius:999px; color:#fff; }
        .pbadge-sale { background:var(--danger); }
        .pbadge-new { background:var(--aqua-dark); }
        .pcard-body { padding:14px; display:grid; gap:8px; }
        .pcard-kicker { color:var(--aqua-dark); font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.03em; }
        .pcard-title { font-size:.92rem; font-weight:700; color:var(--aqua-ink); margin:0; line-height:1.35; min-height:2.5em; }
        .pcard-title a { color:inherit; text-decoration:none; }
        .pcard-title a:hover { color:var(--aqua-dark); }
        .pcard-price { display:flex; align-items:baseline; gap:8px; flex-wrap:wrap; }
        .price-old { font-size:.8rem; color:#9fb0b5; text-decoration:line-through; }
        .price-new { font-size:1.05rem; font-weight:900; color:var(--aqua-dark); }

        /* ── Empty state ── */
        .shop-empty-state { border:1px dashed var(--aqua-line); border-radius:16px; padding:48px 20px; text-align:center; display:grid; gap:6px; color:var(--aqua-muted); background:var(--aqua-soft); }
        .shop-empty-state strong { color:var(--aqua-ink); font-size:1.15rem; }

        /* ── List / grid-4 views ── */
        #product-grid.list-view .product-item { flex:0 0 100%; max-width:100%; }
        #product-grid.list-view .pcard { display:flex; flex-direction:row; }
        #product-grid.list-view .pcard-img-wrap { width:200px; flex-shrink:0; }
        #product-grid.list-view .pcard-img { max-height:150px; }
        #product-grid.list-view .pcard-body { flex:1; align-content:start; }
        #product-grid.grid-4 .product-item { flex:0 0 25%; max-width:25%; }
        #product-grid.is-loading { opacity:.55; pointer-events:none; transition:opacity .18s ease; }

        /* ── Mobile filter drawer ── */
        .shop-filter-trigger { width:100%; display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:48px; border:0; border-radius:14px; font-weight:800; color:#fff; background:linear-gradient(135deg,var(--aqua-dark),var(--aqua)); margin-bottom:16px; }
        .shop-filter-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .shop-filter-head strong { font-size:1.05rem; color:var(--aqua-ink); }
        .shop-filter-close { width:40px; height:40px; border:0; border-radius:12px; background:var(--aqua-soft); color:var(--aqua-dark); font-size:20px; }
        .shop-filter-apply { position:sticky; bottom:0; background:#fbfdfd; padding:12px 0 4px; margin-top:8px; }
        .shop-filter-apply .btn-sw-green { width:100%; min-height:48px; }
        .shop-filter-overlay { display:none; }

        @media (min-width:992px) {
            .shop-sidebar { position:sticky; top:90px; align-self:flex-start; }
        }
        @media (max-width:991px) {
            .shop-sidebar { position:fixed; top:0; left:0; height:100%; width:min(88vw,360px); background:#fbfdfd; z-index:1200; transform:translateX(-100%); transition:transform .28s ease; overflow-y:auto; padding:16px !important; box-shadow:0 18px 50px rgba(6,40,46,.25); }
            body.shop-filter-open .shop-sidebar { transform:none; }
            .shop-filter-overlay { display:block; position:fixed; inset:0; background:rgba(6,40,46,.5); opacity:0; visibility:hidden; transition:.28s; z-index:1100; }
            body.shop-filter-open .shop-filter-overlay { opacity:1; visibility:visible; }
            body.shop-filter-open { overflow:hidden; }
        }
        @media (max-width:767px) {
            #product-grid.grid-4 .product-item,
            #product-grid .product-item { flex:0 0 50%; max-width:50%; }
            #product-grid.list-view .pcard { display:block; }
            #product-grid.list-view .pcard-img-wrap { width:100%; }
            .pcard-title { font-size:.85rem; min-height:2.4em; }
            .price-new { font-size:.98rem; }
        }

    </style>
    @push('scripts')
    <script>
    $(function () {

        /* ── Mobile filter drawer ── */
        $(document).on('click', '[data-shop-filter-open]', function () { $('body').addClass('shop-filter-open'); });
        $(document).on('click', '[data-shop-filter-close]', function () { $('body').removeClass('shop-filter-open'); });
        $(document).on('keyup', function (e) { if (e.key === 'Escape') $('body').removeClass('shop-filter-open'); });

        /* ── View toggles ── */
        var $grid = $('#product-grid');

        function setView(cls) {
            $grid.removeClass('list-view grid-4');
            if (cls) $grid.addClass(cls);
            $('.vbtn').removeClass('active');
        }

        $('#v-grid3').on('click', function () { setView('');         $(this).addClass('active'); });
        $('#v-grid4').on('click', function () { setView('grid-4');   $(this).addClass('active'); });
        $('#v-list').on('click',  function () { setView('list-view'); $(this).addClass('active'); });

        /* ── Price range slider ── */
        var $minR    = $('#sw-price-min-r');
        var $maxR    = $('#sw-price-max-r');
        var $fill    = $('#sw-price-fill');
        var $lblMin  = $('#sw-price-lbl-min');
        var $lblMax  = $('#sw-price-lbl-max');
        var $pfMin   = $('#pf-min');
        var $pfMax   = $('#pf-max');

        if ($minR.length && $maxR.length) {

            function fmtNum(n) {
                return Number(n).toLocaleString('en-IN');
            }

            function updateSlider() {
                var min   = parseInt($minR.val());
                var max   = parseInt($maxR.val());
                var lo    = parseInt($minR.attr('min'));
                var hi    = parseInt($minR.attr('max'));
                var range = hi - lo;
                $fill.css({ left: ((min - lo) / range * 100) + '%', right: ((hi - max) / range * 100) + '%' });
                $lblMin.text(fmtNum(min));
                $lblMax.text(fmtNum(max));
                $pfMin.val(min);
                $pfMax.val(max);
            }

            $minR.on('input', function () {
                if (parseInt($minR.val()) > parseInt($maxR.val()) - 100) {
                    $minR.val(parseInt($maxR.val()) - 100);
                }
                updateSlider();
            });

            $maxR.on('input', function () {
                if (parseInt($maxR.val()) < parseInt($minR.val()) + 100) {
                    $maxR.val(parseInt($minR.val()) + 100);
                }
                updateSlider();
            });

            updateSlider();
        }

        var ajaxTimer;

        var $infiniteWrap = $('[data-infinite-wrap]');
        var infiniteLoading = false;

        function updateInfinite(response) {
            var nextUrl = response.next_page_url || '';
            $infiniteWrap.attr('data-next-url', nextUrl);
            $('[data-load-more]').prop('disabled', !nextUrl)
                .find('.shop-load-label').text(nextUrl ? 'Load more products' : 'No more products');
        }

        function updateAppendCount(response) {
            var loaded = $('#product-grid .product-item').length;
            var total = response.total || loaded;
            $('[data-product-count]').text('Showing 1 to ' + loaded + ' of ' + total);
        }

        function loadListing(url, pushState, append) {
            if (append && infiniteLoading) {
                return;
            }
            infiniteLoading = !!append;
            $grid.addClass('is-loading').attr('aria-busy', 'true');
            $('[data-load-more]').addClass('is-loading').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function (response) {
                    if (append) {
                        $grid.append(response.grid || '');
                        updateAppendCount(response);
                    } else {
                        $grid.html(response.grid || '');
                        $('[data-product-count]').html(response.count || '');
                    }
                    updateInfinite(response);
                    if (pushState !== false) {
                        window.history.pushState({}, '', url);
                    }
                },
                complete: function () {
                    infiniteLoading = false;
                    $grid.removeClass('is-loading').removeAttr('aria-busy');
                    $('[data-load-more]').removeClass('is-loading').prop('disabled', !$infiniteWrap.attr('data-next-url'));
                }
            });
        }

        $(document).on('click', '.sw-box a, .chip-badge, .refine-link', function (event) {
            var href = $(this).attr('href');
            if (!href || href === '#') {
                return;
            }
            event.preventDefault();
            loadListing(href);
        });

        $('#sort-form, #pp-form, #price-filter-form').on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);
            loadListing($form.attr('action') + '?' + $form.serialize());
        });

        $('#sort-form select, #pp-form select').on('change', function () {
            $(this).closest('form').trigger('submit');
        });

        $('#price-filter-form input').on('input', function () {
            clearTimeout(ajaxTimer);
            ajaxTimer = setTimeout(function () {
                $('#price-filter-form').trigger('submit');
            }, 450);
        });

        window.addEventListener('popstate', function () {
            loadListing(window.location.href, false);
        });

        $(document).on('click', '[data-load-more]', function () {
            var nextUrl = $infiniteWrap.attr('data-next-url');
            if (nextUrl) {
                loadListing(nextUrl, false, true);
            }
        });

        function maybeLoadMore() {
            var nextUrl = $infiniteWrap.attr('data-next-url');
            if (!nextUrl || infiniteLoading || !$infiniteWrap.length) {
                return;
            }
            var triggerTop = $infiniteWrap.offset().top - window.innerHeight - 220;
            if ($(window).scrollTop() > triggerTop) {
                loadListing(nextUrl, false, true);
            }
        }

        $(window).on('scroll', maybeLoadMore);

    });
    </script>
    @endpush

</x-frontend::layouts.master>
