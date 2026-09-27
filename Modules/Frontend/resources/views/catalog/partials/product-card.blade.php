@php
    use Carbon\Carbon;
    use Modules\SysAdmin\Helpers\ImageUploader;

    $thumbUrl = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null, 'thumbnail');
    $title = $product->title ?? $product->name ?? 'Product';
    $categoryName = optional($product->category ?? null)->name ?? optional($product->productCategory ?? null)->name ?? null;
    $productUrl = route('frontend.shop.product.show', $product->slug ?? $product->id);
    $price = (float) ($product->sales_price ?? 0);
    $mrp = (float) ($product->mrp ?? 0);
    $hasDiscount = $mrp > 0 && $mrp > $price;
    $discountPercent = $hasDiscount ? round((($mrp - $price) / $mrp) * 100) : 0;
    $createdAt = $product->created_at ?? null;
    $createdDate = is_numeric($createdAt) ? Carbon::createFromTimestamp((int) $createdAt) : ($createdAt ? Carbon::parse($createdAt) : null);
    $isNew = $createdDate ? $createdDate->diffInDays(now()) <= 30 : false;
    $siteSettings = config('site-settings', []);
    $currencySymbol = $siteSettings['currency_symbol'] ?? '₹';
    $showPrices = filter_var($siteSettings['show_product_prices'] ?? true, FILTER_VALIDATE_BOOL);
    $enableEnquiries = filter_var($siteSettings['enable_enquiries'] ?? true, FILTER_VALIDATE_BOOL);
@endphp

<article class="pcard">
    <a class="pcard-img-wrap" href="{{ $productUrl }}" aria-label="{{ $title }}">
        <img
            class="pcard-img"
            src="{{ $thumbUrl }}"
            alt="{{ $title }}"
            loading="lazy"
            onerror="this.onerror=null;this.src='{{ asset('uploads/default.jpg') }}';"
        >
        @if ($hasDiscount)
            <span class="pbadge pbadge-sale">-{{ $discountPercent }}%</span>
        @elseif ($isNew)
            <span class="pbadge pbadge-new">New</span>
        @endif
    </a>

    <div class="pcard-body">
        @if ($categoryName)
            <span class="pcard-kicker">{{ $categoryName }}</span>
        @endif
        <h3 class="pcard-title">
            <a href="{{ $productUrl }}">{{ $title }}</a>
        </h3>
        @if ($showPrices)
            <div class="pcard-price">
                <span class="price-new">{{ $currencySymbol }}{{ number_format($price) }}</span>
                @if ($hasDiscount)
                    <span class="price-old">{{ $currencySymbol }}{{ number_format($mrp) }}</span>
                    <span class="price-off">{{ $discountPercent }}% off</span>
                @endif
            </div>
        @endif
        @if ($enableEnquiries)
            <button
                type="button"
                class="btn btn-sw-green btn-sm w-100 js-enquiry-open"
                data-product-id="{{ $product->id }}"
                data-category-id="{{ $product->product_category ?? $product->category_id ?? 0 }}"
                data-price="{{ $price }}"
                data-product-name="{{ $title }}"
            >
                Enquiry
            </button>
        @endif
    </div>
</article>
