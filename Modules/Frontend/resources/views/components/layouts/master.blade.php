@props(['seo' => [], 'structuredData' => []])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $seoData       = array_merge($defaultSeo ?? [], $seo ?? []);
    $metaTitle       = $seoData['title']        ?? config('app.name', 'Laravel');
    $metaDescription = $seoData['description']  ?? ($description ?? '');
    $metaKeywords    = $seoData['keywords']      ?? ($keywords ?? '');
    $metaAuthor      = $seoData['author']        ?? config('app.name', 'Laravel');
    $metaCanonical   = $seoData['canonical']     ?? url()->current();
    $metaRobots      = $seoData['robots']        ?? 'index,follow';
    $metaImage       = $seoData['image']         ?? asset('assets/images/logo/logo.png');
    $metaType        = $seoData['type']          ?? 'website';
    $metaSiteName    = $seoData['site_name']     ?? config('app.name', 'Laravel');
    $twitterCard     = $seoData['twitter_card']  ?? 'summary_large_image';
    $structuredDataItems = $structuredData ?? [];
    $siteSettings = config('site-settings', []);
    $favicon = \Modules\SysAdmin\Models\Settings::assetUrl($siteSettings['favicon'] ?? null, 'assets/images/favicon/favicon.png');
    $themePrimary = preg_match('/^#[0-9a-fA-F]{6}$/', $siteSettings['theme_primary_color'] ?? '') ? $siteSettings['theme_primary_color'] : '#05a9a6';
    $themePrimaryDark = preg_match('/^#[0-9a-fA-F]{6}$/', $siteSettings['theme_primary_dark'] ?? '') ? $siteSettings['theme_primary_dark'] : '#087f82';
    $themeAccent = preg_match('/^#[0-9a-fA-F]{6}$/', $siteSettings['theme_accent_color'] ?? '') ? $siteSettings['theme_accent_color'] : '#36a852';
    $themeText = preg_match('/^#[0-9a-fA-F]{6}$/', $siteSettings['theme_text_color'] ?? '') ? $siteSettings['theme_text_color'] : '#11252d';
    $themeRadius = in_array($siteSettings['theme_radius'] ?? '', ['4px', '8px', '12px', '16px'], true) ? $siteSettings['theme_radius'] : '8px';
    $googleAnalyticsId = preg_match('/^(G-[A-Z0-9]+|AW-[0-9]+|UA-[0-9]+-[0-9]+)$/i', $siteSettings['google_analytics_id'] ?? '') ? $siteSettings['google_analytics_id'] : null;
    $googleTagManagerId = preg_match('/^GTM-[A-Z0-9]+$/i', $siteSettings['google_tag_manager_id'] ?? '') ? $siteSettings['google_tag_manager_id'] : null;
    $metaPixelId = preg_match('/^[0-9]{5,30}$/', $siteSettings['meta_pixel_id'] ?? '') ? $siteSettings['meta_pixel_id'] : null;
    $facebookAppId = preg_match('/^[0-9]{5,30}$/', $siteSettings['facebook_app_id'] ?? '') ? $siteSettings['facebook_app_id'] : null;
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $metaTitle }}</title>

    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="author" content="{{ $metaAuthor }}">
    <meta name="robots" content="{{ $metaRobots }}">
    <link rel="canonical" href="{{ $metaCanonical }}">
    <link rel="icon" href="{{ $favicon }}">
    <meta name="theme-color" content="{{ $themePrimary }}">

    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:site_name" content="{{ $metaSiteName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaCanonical }}">
    <meta property="og:image" content="{{ $metaImage }}">
    @if($facebookAppId)<meta property="fb:app_id" content="{{ $facebookAppId }}">@endif

    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    @include('frontend::components.layouts.css')

    <style>:root{--aqua:{{ $themePrimary }};--aqua-dark:{{ $themePrimaryDark }};--leaf:{{ $themeAccent }};--aqua-ink:{{ $themeText }};--radius:{{ $themeRadius }};}</style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if($googleAnalyticsId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config',@json($googleAnalyticsId));</script>
    @endif
    @if($googleTagManagerId)
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f)})(window,document,'script','dataLayer',@json($googleTagManagerId));</script>
    @endif
    @if($metaPixelId)
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=true;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=true;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init',@json($metaPixelId));fbq('track','PageView');</script>
    @endif

    {!! $siteSettings['custom_head_code'] ?? '' !!}

    @foreach ($structuredDataItems as $schema)
        @if (!empty($schema))
            <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif
    @endforeach
</head>

<body>
    @if($googleTagManagerId)<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $googleTagManagerId }}" height="0" width="0" class="hidden invisible"></iframe></noscript>@endif
    @if($metaPixelId)<noscript><img height="1" width="1" class="hidden" src="https://www.facebook.com/tr?id={{ $metaPixelId }}&amp;ev=PageView&amp;noscript=1" alt=""></noscript>@endif
    {!! $siteSettings['custom_body_start_code'] ?? '' !!}
    @include('frontend::components.layouts.header')
    {{ $slot }}

    @include('frontend::components.layouts.footer')
    @include('frontend::components.layouts.script')
    <script src="{{ asset('assets/js/aqua-ui.js') }}"></script>
    @stack('scripts')
    {!! $siteSettings['custom_body_end_code'] ?? '' !!}
</body>

</html>
