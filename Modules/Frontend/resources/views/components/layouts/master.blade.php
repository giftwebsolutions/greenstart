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

    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:site_name" content="{{ $metaSiteName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaCanonical }}">
    <meta property="og:image" content="{{ $metaImage }}">

    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    @include('frontend::components.layouts.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @foreach ($structuredDataItems as $schema)
        @if (!empty($schema))
            <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif
    @endforeach
</head>

<body>
    @include('frontend::components.layouts.header')
    {{ $slot }}

    @include('frontend::components.layouts.footer')
    @include('frontend::components.layouts.script')
    @stack('scripts')
</body>

</html>
