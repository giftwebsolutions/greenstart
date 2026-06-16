@php
    $menus    = Config::get('frontend.menus');
    $settings = Config::get('site-settings');
    $waNumber = preg_replace('/\D+/', '', $settings['whatsapp'] ?? '');
    $phone    = $settings['mobile'] ?? '';
    $email    = $settings['email'] ?? '';
    $logo     = asset('assets/images/logo/logo.png');
    $brand    = config('app.name', 'Greens Aqua World');
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
    <div class="ga-drawer-head">
        <a href="{{ route('frontend.home') }}" class="ga-drawer-logo">
            <img src="{{ $logo }}" alt="{{ $brand }}">
        </a>
        <button class="ga-drawer-close" type="button" data-ga-drawer-close aria-label="Close menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <form class="ga-drawer-search" method="GET" action="{{ route('frontend.shop.search') }}" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products…">
    </form>

    <div class="ga-drawer-quick">
        @if ($phone)
            <a href="tel:{{ $phone }}"><i class="fa-solid fa-phone"></i> Call us</a>
        @endif
        @if ($waNumber)
            <a class="is-wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
        @endif
    </div>

    <div class="ga-drawer-label">Menu</div>
    <nav class="ga-drawer-menu">
        <ul class="menu-content">
            @include('frontend::components.menu-recursive', ['items' => $menus])
        </ul>
    </nav>

    <div class="ga-drawer-label">Shop by category</div>
    <nav class="ga-drawer-cats">
        <x-frontend::category-menu />
    </nav>

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
