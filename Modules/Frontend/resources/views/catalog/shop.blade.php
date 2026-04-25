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

    $formAction = isset($category)
        ? route('frontend.shop.category', $category->slug)
        : route('frontend.shop.index');

    function shopFilterUrl(string $baseUrl, array $currentAttrs, int $attrId, int $valueId, ?int $cCat, ?int $sCat, ?string $sort, ?string $search): string
    {
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
        ]);
        if (!empty($attrs)) {
            foreach ($attrs as $aId => $vIds) {
                foreach ($vIds as $vId) {
                    $query["attr[{$aId}][]"] = $vId;
                }
            }
        }
        return $baseUrl . (empty($query) ? '' : '?' . http_build_query($query));
    }

    $activeChips = [];
    foreach ($currentAttrs as $attrId => $valueIds) {
        foreach ($filterGroups as $group) {
            foreach ($group->attributes as $attr) {
                if ((int) $attr->id !== (int) $attrId) continue;
                foreach ($attr->values as $val) {
                    if (in_array((int) $val->id, array_map('intval', (array) $valueIds))) {
                        $removeUrl     = shopFilterUrl($formAction, $currentAttrs, (int) $attrId, (int) $val->id, $currentCCat, $currentSCat, $currentSort, $currentSearch);
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
@endphp

<x-frontend::layouts.master>

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
                <div class="col-lg-3 col-md-4 mb-4">

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
                                <input type="range" id="sw-price-min-r" min="0" max="100000" step="100"
                                       value="{{ request('price_min', 0) }}" class="sw-range-input">
                                <input type="range" id="sw-price-max-r" min="0" max="100000" step="100"
                                       value="{{ request('price_max', 100000) }}" class="sw-range-input">
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:.8rem;color:#555">
                                <span>₹<span id="sw-price-lbl-min">{{ number_format(request('price_min', 0)) }}</span></span>
                                <span>₹<span id="sw-price-lbl-max">{{ number_format(request('price_max', 100000)) }}</span></span>
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
                                <input type="hidden" name="price_min" id="pf-min" value="{{ request('price_min', 0) }}">
                                <input type="hidden" name="price_max" id="pf-max" value="{{ request('price_max', 100000) }}">
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
                                                $toggleUrl = shopFilterUrl($formAction, $currentAttrs, (int) $attr->id, (int) $val->id, $currentCCat, $currentSCat, $currentSort, $currentSearch);
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
                            <a href="{{ isset($category) ? route('frontend.shop.category', $category->slug) : route('frontend.shop.index') }}"
                               class="btn btn-outline-danger btn-sm w-100">
                                Clear All Filters
                            </a>
                        </div>
                    @endif

                </div>{{-- /sidebar --}}

                {{-- ══════════════════════════════════════════
                     MAIN CONTENT
                ══════════════════════════════════════════ --}}
                <div class="col-lg-9 col-md-8">

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
                                <label class="toolbar-label mb-0">Show:</label>
                                <select name="per_page" class="form-select form-select-sm toolbar-sel"
                                        onchange="document.getElementById('pp-form').submit()">
                                    @foreach ([9, 18, 27, 36] as $pp)
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
                                @if ($perPageCount != 9)
                                    <input type="hidden" name="per_page" value="{{ $perPageCount }}">
                                @endif
                                <label class="toolbar-label mb-0">Sort By:</label>
                                <select name="sort" class="form-select form-select-sm toolbar-sel"
                                        onchange="document.getElementById('sort-form').submit()">
                                    <option value="newest"     @selected($currentSort === 'newest')>Default</option>
                                    <option value="price_asc"  @selected($currentSort === 'price_asc')>Price: Low → High</option>
                                    <option value="price_desc" @selected($currentSort === 'price_desc')>Price: High → Low</option>
                                    <option value="name_asc"   @selected($currentSort === 'name_asc')>Name A–Z</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Product grid --}}
                    <div class="row product-grid" id="product-grid">
                        @forelse ($products as $product)
                            @php
                                $thumbUrl    = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null, 'thumbnail');
                                $hasDiscount = $product->mrp > 0 && $product->mrp > $product->sales_price;
                                $discPct     = $hasDiscount ? round((($product->mrp - $product->sales_price) / $product->mrp) * 100) : 0;
                                $isNew = isset($product->created_at)  && Carbon::createFromTimestamp($product->created_at)->diffInDays(now()) <= 30;
                            @endphp
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-4 product-item">
                                <div class="pcard">
                                    <div class="pcard-img-wrap">
                                        <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}">
                                            <img class="pcard-img" src="{{ $thumbUrl }}" alt="{{ $product->title }}">
                                        </a>
                                        @if ($hasDiscount)
                                            <span class="pbadge pbadge-sale">-{{ $discPct }}%</span>
                                        @elseif ($isNew)
                                            <span class="pbadge pbadge-new">NEW</span>
                                        @endif
                                    </div>
                                    <div class="pcard-body">
                                        <h6 class="pcard-title">
                                            <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}">
                                                {{ $product->title }}
                                            </a>
                                        </h6>
                                        <div class="pcard-stars mb-1">
                                            <span class="star filled">&#9733;</span><span class="star filled">&#9733;</span><span class="star filled">&#9733;</span><span class="star filled">&#9733;</span><span class="star">&#9733;</span>
                                        </div>
                                        <div class="pcard-price">
                                            @if ($hasDiscount)
                                                <span class="price-old">₹{{ number_format($product->mrp, 2) }}</span>
                                            @endif
                                            <span class="price-new">₹{{ number_format($product->sales_price ?? 0, 2) }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button"
                                                    class="btn btn-sw-green btn-sm w-100 js-enquiry-open"
                                                    data-product-id="{{ $product->id }}"
                                                    data-category-id="{{ $product->product_category ?? 0 }}"
                                                    data-price="{{ $product->sales_price ?? 0 }}"
                                                    data-product-name="{{ $product->title }}">
                                                Buy Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center py-5 text-muted">No products found. Try adjusting your filters.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Bottom bar: count + pagination --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-2">
                        <span class="toolbar-count">
                            Showing {{ $from }} to {{ $to }} of {{ $totalProducts }}
                            ({{ $lastPage }} {{ $lastPage === 1 ? 'Page' : 'Pages' }})
                        </span>
                        <div class="shop-pager">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>

                </div>{{-- /col main --}}
            </div>
        </div>
    </div>

    @include('frontend::catalog.modal')

    <style>
        /* ── Green palette ── */
        :root {
            --sg: #2e7d32;
            --sg-h: #1b5e20;
            --sg-l: #43a047;
        }

        /* ── Sidebar widget box ── */
        .sw-box {
            background: #fff;
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 14px 16px;
        }
        .sw-title {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            color: #333;
            border-bottom: 2px solid #efefef;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        /* Search button */
        .btn-sw-search {
            background: var(--sg);
            color: #fff;
            border: none;
            padding: 0 12px;
        }
        .btn-sw-search:hover { background: var(--sg-h); color: #fff; }

        /* Category list */
        .sw-cat-list { margin: 0; }
        .sw-cat-item { border-bottom: 1px solid #f3f3f3; }
        .sw-cat-item:last-child { border-bottom: none; }
        .sw-cat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sw-cat-link {
            display: block;
            flex: 1;
            padding: 7px 0;
            font-size: .85rem;
            color: #444;
            text-decoration: none;
        }
        .sw-cat-link:hover, .sw-cat-link.active { color: var(--sg); font-weight: 600; }
        .sw-chevron-btn {
            background: none;
            border: none;
            padding: 0 4px;
            cursor: pointer;
            color: #888;
            line-height: 1;
        }
        .sw-chevron { transition: transform .2s; }
        .sw-chevron.open { transform: rotate(180deg); }
        .sw-chevron-static { color: #bbb; }
        .sw-sub-list {
            margin: 2px 0 8px 12px;
            padding: 0;
        }
        .sw-sub-link {
            display: block;
            padding: 4px 0;
            font-size: .8rem;
            color: #555;
            text-decoration: none;
        }
        .sw-sub-link:hover, .sw-sub-link.active { color: var(--sg); font-weight: 600; }

        /* Price range slider */
        .sw-price-track {
            position: relative;
            height: 5px;
            background: #ddd;
            border-radius: 3px;
            margin: 14px 0 6px;
        }
        .sw-price-fill {
            position: absolute;
            height: 100%;
            background: var(--sg);
            border-radius: 3px;
            pointer-events: none;
        }
        .sw-range-input {
            position: absolute;
            width: 100%;
            top: -6px;
            left: 0;
            background: transparent;
            -webkit-appearance: none;
            appearance: none;
            pointer-events: none;
            height: 18px;
        }
        .sw-range-input::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px; height: 16px;
            border-radius: 50%;
            background: var(--sg);
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px var(--sg);
            cursor: pointer;
            pointer-events: all;
        }
        .sw-range-input::-moz-range-thumb {
            width: 16px; height: 16px;
            border-radius: 50%;
            background: var(--sg);
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px var(--sg);
            cursor: pointer;
            pointer-events: all;
        }

        /* Checkbox filter list */
        .sw-check-list { margin: 0; }
        .sw-check-list.two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px 8px;
        }
        .sw-check-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 4px 0;
            font-size: .83rem;
            color: #444;
            text-decoration: none;
        }
        .sw-check-link:hover, .sw-check-link.checked { color: var(--sg); }
        .sw-check-link.checked { font-weight: 600; }
        .sw-cb {
            flex-shrink: 0;
            width: 14px; height: 14px;
            border: 1px solid #aaa;
            border-radius: 3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .sw-cb.checked {
            background: var(--sg);
            border-color: var(--sg);
        }
        .sw-cb.checked::after {
            content: '✓';
            color: #fff;
            font-size: 9px;
            line-height: 1;
        }

        /* Green button */
        .btn-sw-green {
            background: var(--sg);
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: .82rem;
        }
        .btn-sw-green:hover { background: var(--sg-h); color: #fff; }

        /* ── Main: headings / refine ── */
        .shop-h4 { font-size: 1.4rem; font-weight: 700; color: #222; }
        .refine-box {
            background: #f9f9f9;
            border: 1px solid #e8e8e8;
            border-radius: 4px;
            padding: 12px 16px;
            font-size: .85rem;
        }
        .refine-label { font-size: .85rem; color: #333; }
        .refine-list { margin: 6px 0 0; display: flex; flex-wrap: wrap; gap: 2px 0; }
        .refine-list li { margin-right: 12px; }
        .refine-link { color: #555; text-decoration: none; }
        .refine-link:hover, .refine-link.active { color: var(--sg); font-weight: 600; }

        /* Active filter chips */
        .chip-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #666;
            color: #fff;
            font-size: .75rem;
            padding: 3px 9px;
            border-radius: 20px;
            text-decoration: none;
        }
        .chip-badge:hover { background: #444; color: #fff; }

        /* ── Toolbar ── */
        .shop-toolbar {
            background: #f5f5f5;
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 8px 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .view-btns { display: flex; gap: 3px; }
        .vbtn {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 5px 7px;
            cursor: pointer;
            color: #777;
            line-height: 1;
        }
        .vbtn:hover, .vbtn.active {
            background: var(--sg);
            border-color: var(--sg);
            color: #fff;
        }
        .toolbar-count { font-size: .8rem; color: #666; }
        .toolbar-label { font-size: .8rem; color: #666; white-space: nowrap; }
        .toolbar-sel   { font-size: .8rem; min-width: 75px; }

        /* ── Product cards ── */
        .product-grid { }
        .pcard {
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            background: #fff;
            overflow: hidden;
            transition: box-shadow .2s ease;
            height: 100%;
        }
        .pcard:hover { box-shadow: 0 4px 18px rgba(0,0,0,.10); }
        .pcard-img-wrap {
            position: relative;
            background: #fafafa;
            text-align: center;
            padding: 12px;
            overflow: hidden;
        }
        .pcard-img {
            max-height: 190px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            transition: transform .3s ease;
        }
        .pcard:hover .pcard-img { transform: scale(1.06); }
        .pbadge {
            position: absolute;
            top: 8px;
            left: 8px;
            font-size: .7rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 3px;
            color: #fff;
            letter-spacing: .02em;
        }
        .pbadge-sale { background: #e53935; }
        .pbadge-new  { background: #1a237e; }
        .pcard-body { padding: 12px 14px 14px; }
        .pcard-title {
            font-size: .875rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            line-height: 1.4;
        }
        .pcard-title a { color: inherit; text-decoration: none; }
        .pcard-title a:hover { color: var(--sg); }
        .pcard-stars .star { color: #ddd; font-size: .9rem; }
        .pcard-stars .star.filled { color: #f5a623; }
        .pcard-price { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }
        .price-old { font-size: .78rem; color: #aaa; text-decoration: line-through; }
        .price-new { font-size: 1rem; font-weight: 700; color: var(--sg); }

        /* ── Pagination ── */
        .shop-pager .pagination { margin: 0; gap: 3px; flex-wrap: wrap; }
        .shop-pager .page-link {
            border-radius: 3px !important;
            font-size: .82rem !important;
            font-family: inherit !important;
            line-height: 1.4 !important;
            padding: 5px 10px;
            color: #555;
            border-color: #ddd;
        }
        .shop-pager .page-item.active .page-link {
            background: var(--sg);
            border-color: var(--sg);
            color: #fff;
        }
        .shop-pager .page-link:hover {
            background: var(--sg-l);
            border-color: var(--sg-l);
            color: #fff;
        }
        .shop-pager .page-item.disabled .page-link { opacity: .5; }

        /* ── List view ── */
        #product-grid.list-view .product-item {
            flex: 0 0 100%;
            max-width: 100%;
        }
        #product-grid.list-view .pcard {
            display: flex;
            flex-direction: row;
        }
        #product-grid.list-view .pcard-img-wrap {
            width: 170px;
            flex-shrink: 0;
        }
        #product-grid.list-view .pcard-img { max-height: 140px; }
        #product-grid.list-view .pcard-body { flex: 1; padding: 16px; }

        /* ── Grid 4 ── */
        #product-grid.grid-4 .product-item {
            flex: 0 0 25%;
            max-width: 25%;
        }
    </style>

    <script>
    $(function () {

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

    });
    </script>

</x-frontend::layouts.master>
