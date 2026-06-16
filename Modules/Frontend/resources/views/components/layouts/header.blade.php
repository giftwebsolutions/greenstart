@php
    $menus    = Config::get('frontend.menus');
    $settings = Config::get('site-settings');
    $waNumber = preg_replace('/\D+/', '', $settings['whatsapp'] ?? '');
    $phone    = $settings['mobile'] ?? '';
    $email    = $settings['email'] ?? '';
    $logo     = asset('assets/images/logo/logo.png');
    $brand    = config('app.name', 'Greens Aqua World');
    $drawerCategories = \Modules\SysAdmin\Models\ProductCategory::query()
        ->where(function ($query) {
            $query->where('parent_id', 0)->orWhereNull('parent_id');
        })
        ->where('status', '1')
        ->orderBy('sort')
        ->orderBy('name')
        ->limit(10)
        ->get();
@endphp

<header class="ga-header" id="gaHeader">

    {{-- Utility bar --}}
    <div class="ga-utility">
        <div class="container ga-utility-row">
            <p class="ga-utility-note">
                <i class="fa-solid fa-droplet"></i> Pure water solutions for homes &amp; businesses
            </p>
            <div class="ga-utility-actions">
                @if ($phone)
                    <a href="tel:{{ $phone }}"><i class="fa-solid fa-phone"></i> {{ $phone }}</a>
                @endif
                @if ($email)
                    <a href="mailto:{{ $email }}"><i class="fa-regular fa-envelope"></i> {{ $email }}</a>
                @endif
                <span class="ga-utility-social">
                    @if ($waNumber)<a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>@endif
                    @if (!empty($settings['facebook']))<a href="{{ $settings['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                    @if (!empty($settings['instagram']))<a href="{{ $settings['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if (!empty($settings['youtube']))<a href="{{ $settings['youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>@endif
                </span>
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div class="ga-main">
        <div class="container ga-main-row">
            <button class="ga-burger" type="button" aria-label="Open menu" data-ga-drawer-open>
                <span></span><span></span><span></span>
            </button>

            <a href="{{ route('frontend.home') }}" class="ga-logo" aria-label="{{ $brand }}">
                <img src="{{ $logo }}" alt="{{ $brand }}" width="160" height="56">
            </a>

            <form class="ga-search" method="GET" action="{{ route('frontend.shop.search') }}" role="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ request('q') }}" autocomplete="off"
                    placeholder="Search RO purifiers, filters, spares…">
                <button type="submit">Search</button>
            </form>

            <div class="ga-actions">
                <button class="ga-icon-btn ga-only-mobile" type="button" data-ga-search-toggle aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                @if ($phone)
                    <a class="ga-icon-btn ga-call" href="tel:{{ $phone }}" aria-label="Call us">
                        <i class="fa-solid fa-phone"></i>
                    </a>
                @endif
                @if ($waNumber)
                    <a class="ga-icon-btn ga-wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                @endif
                <a class="ga-enquiry-btn ga-only-desktop" href="{{ route('frontend.enquiry') }}">
                    <i class="fa-regular fa-paper-plane"></i> Get a Quote
                </a>
            </div>
        </div>

        {{-- Mobile expandable search --}}
        <div class="ga-search-mobile" id="gaSearchMobile">
            <div class="container">
                <form method="GET" action="{{ route('frontend.shop.search') }}" role="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products…">
                    <button type="submit">Go</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Primary nav (desktop) --}}
    <div class="ga-nav">
        <div class="container ga-nav-row">
            <div class="ga-cats" data-ga-cats-wrap>
                <button class="ga-cats-btn" type="button" data-ga-cats aria-expanded="false">
                    <i class="fa-solid fa-layer-group"></i> Browse Categories
                    <i class="fa-solid fa-chevron-down ga-cats-caret"></i>
                </button>
                <div class="ga-cats-panel">
                    <x-frontend::category-menu />
                </div>
            </div>

            <nav class="ga-menu" aria-label="Primary">
                <ul class="menu-content">
                    @include('frontend::components.menu-recursive', ['items' => $menus])
                </ul>
            </nav>

            @if ($phone)
                <a class="ga-nav-phone" href="tel:{{ $phone }}">
                    <i class="fa-solid fa-headset"></i>
                    <span>
                        <small>Talk to an expert</small>
                        <strong>{{ $phone }}</strong>
                    </span>
                </a>
            @endif
        </div>
    </div>
</header>

{{-- Mobile drawer --}}
<aside class="ga-drawer" id="gaDrawer" aria-hidden="true">
    <div class="ga-drawer-head metro-drawer-head">
        <div class="metro-drawer-brand">
            <img src="{{ $logo }}" alt="{{ $brand }}">
            <span>The water filter company</span>
        </div>
        <button class="ga-drawer-close" type="button" data-ga-drawer-close aria-label="Close menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <form class="ga-drawer-search" method="GET" action="{{ route('frontend.shop.search') }}" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products…">
    </form>

    <div class="metro-drawer-section">
        <p class="ga-drawer-label">Shop categories</p>
        @forelse ($drawerCategories as $drawerCategory)
            <a href="{{ route('frontend.shop.category', $drawerCategory->slug) }}"
               class="metro-drawer-link {{ request()->is('shop/category/' . $drawerCategory->slug) ? 'active' : '' }}">
                <span class="metro-drawer-icon"><i class="fa-solid fa-droplet"></i></span>
                <span class="metro-drawer-text">
                    <strong>{{ $drawerCategory->name }}</strong>
                    <small>View products and sub categories</small>
                </span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @empty
            <a href="{{ route('frontend.shop.index') }}" class="metro-drawer-link">
                <span class="metro-drawer-icon"><i class="fa-solid fa-layer-group"></i></span>
                <span class="metro-drawer-text">
                    <strong>Shop categories</strong>
                    <small>Explore product groups</small>
                </span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @endforelse
    </div>

    <div class="metro-drawer-section">
        <p class="ga-drawer-label">More</p>
        <a href="{{ route('frontend.home') }}" class="metro-drawer-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-solid fa-house"></i></span>
            <span class="metro-drawer-text"><strong>Home</strong><small>Latest sections and products</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="{{ route('frontend.shop.index') }}" class="metro-drawer-link {{ request()->routeIs('frontend.shop.index') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-solid fa-table-cells-large"></i></span>
            <span class="metro-drawer-text"><strong>Shop</strong><small>All categories</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="{{ route('frontend.about') }}" class="metro-drawer-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-solid fa-building"></i></span>
            <span class="metro-drawer-text"><strong>About Us</strong><small>Company and service journey</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="{{ route('frontend.blog.index') }}" class="metro-drawer-link {{ request()->routeIs('frontend.blog.*') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-solid fa-newspaper"></i></span>
            <span class="metro-drawer-text"><strong>Blog</strong><small>Guides and updates</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="{{ route('frontend.faqs') }}" class="metro-drawer-link {{ request()->routeIs('frontend.faqs') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-solid fa-circle-question"></i></span>
            <span class="metro-drawer-text"><strong>FAQ</strong><small>Common purifier questions</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="{{ route('frontend.enquiry') }}" class="metro-drawer-link {{ request()->routeIs('frontend.enquiry') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-regular fa-paper-plane"></i></span>
            <span class="metro-drawer-text"><strong>Enquiry</strong><small>Request product support</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="{{ route('frontend.contact') }}" class="metro-drawer-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">
            <span class="metro-drawer-icon"><i class="fa-solid fa-envelope"></i></span>
            <span class="metro-drawer-text"><strong>Contact</strong><small>Call, WhatsApp, location</small></span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>

    <div class="ga-drawer-quick">
        @if ($phone)
            <a href="tel:{{ $phone }}"><i class="fa-solid fa-phone"></i> Call</a>
        @endif
        @if ($waNumber)
            <a class="is-wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Chat</a>
        @endif
    </div>

    <div class="ga-drawer-social">
        @if ($waNumber)<a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>@endif
        @if (!empty($settings['facebook']))<a href="{{ $settings['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
        @if (!empty($settings['instagram']))<a href="{{ $settings['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
        @if (!empty($settings['youtube']))<a href="{{ $settings['youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>@endif
    </div>
</aside>
<div class="ga-overlay" data-ga-drawer-close></div>

{{-- App-style bottom nav (mobile) --}}
<nav class="ga-bottom-nav" aria-label="Quick navigation">
    <a href="{{ route('frontend.home') }}" class="{{ request()->routeIs('frontend.home') ? 'is-active' : '' }}">
        <i class="fa-solid fa-house"></i><span>Home</span>
    </a>
    <a href="{{ route('frontend.shop.index') }}" class="{{ request()->routeIs('frontend.shop.*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-grip"></i><span>Shop</span>
    </a>
    <button type="button" data-ga-search-toggle>
        <i class="fa-solid fa-magnifying-glass"></i><span>Search</span>
    </button>
    @if ($waNumber)
        <a class="ga-bn-wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">
            <i class="fa-brands fa-whatsapp"></i><span>WhatsApp</span>
        </a>
    @endif
    @if ($phone)
        <a class="ga-bn-call" href="tel:{{ $phone }}">
            <i class="fa-solid fa-phone"></i><span>Call</span>
        </a>
    @endif
</nav>

{{-- Floating WhatsApp (desktop) --}}
@if ($waNumber)
    <a class="ga-fab-wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
@endif
