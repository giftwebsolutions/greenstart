<!DOCTYPE html>
<html lang="en" class="h-full">
@php
    $siteSettings = config('site-settings', []);
    $adminFavicon = \Modules\SysAdmin\Models\Settings::assetUrl($siteSettings['favicon'] ?? null, 'admin/images/favicon.png');
@endphp
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') · {{ config('app.name', 'Products') }}</title>
    <link rel="icon" href="{{ $adminFavicon }}">
    {{ module_vite('build-sysadmin', 'resources/assets/css/app.css') }}
    @livewireStyles
</head>
<body class="min-h-screen bg-[var(--bg)] font-sans text-ink antialiased"><main class="grid min-h-screen place-items-center px-4 py-10">@isset($slot){{ $slot }}@else @yield('content') @endisset</main>{{ module_vite('build-sysadmin', 'resources/assets/js/app.js') }}@livewireScripts</body>
</html>
