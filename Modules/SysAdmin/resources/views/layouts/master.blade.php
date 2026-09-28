<!DOCTYPE html>
<html lang="en" class="h-full">
@php
    $siteSettings = config('site-settings', []);
    $adminFavicon = \Modules\SysAdmin\Models\Settings::assetUrl($siteSettings['favicon'] ?? null, 'admin/images/favicon.png');
    $adminLogo = \Modules\SysAdmin\Models\Settings::assetUrl($siteSettings['site_logo'] ?? null, 'admin/images/logo/logo-icon.png');
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SysAdmin') · {{ config('app.name', 'Products') }}</title>
    <link rel="icon" href="{{ $adminFavicon }}">
    <meta name="theme-color" content="#6d28d9">
    {{ module_vite('build-sysadmin', 'resources/assets/css/app.css') }}
    @stack('styles')
    @yield('style')
    @livewireStyles
</head>
@php
    $admin = auth()->user();
    $initials = collect(preg_split('/\s+/', trim((string) ($admin?->name ?: 'Admin'))))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
    $adminRole = $admin?->roles->first()?->name;
    $adminRoleLabel = $adminRole ? str($adminRole)->replace(['-', '_'], ' ')->title() : 'Administrator';
    $canAccessRoute = function (?string $routeName) use ($admin): bool {
        if (! $routeName || $routeName === '#') {
            return true;
        }
        $permission = \Modules\SysAdmin\Support\PermissionCatalog::forRoute($routeName);
        return ! $permission || ($admin?->can($permission) ?? false);
    };
    $activeGroup = null;
    foreach (config('sysadmin.menus', []) as $candidate) {
        foreach ($candidate['children'] ?? [] as $child) {
            if (request()->routeIs(str_replace('.index', '.*', $child['route'] ?? ''))) {
                $activeGroup = $candidate;
                break 2;
            }
        }
    }
@endphp
<body class="h-full bg-[var(--bg)] font-sans text-ink antialiased"
      x-data="{ nav: false, openGroup: @js($activeGroup['key'] ?? null), toasts: @js(collect([session('success'), session('status')])->filter()->values()) }"
      x-init="if (toasts.length) setTimeout(() => toasts = [], 3200)"
      @toast.window="toasts = [$event.detail.message]; setTimeout(() => toasts = [], 3200)"
      @keydown.escape.window="nav = false">
<div class="flex min-h-full">
    <aside class="fixed inset-y-0 left-0 z-40 flex h-dvh w-[280px] -translate-x-full flex-col overflow-hidden border-r border-hairline bg-white transition-transform lg:translate-x-0" :class="nav && 'translate-x-0'">
        <a href="{{ route('sysadmin.index') }}" class="flex h-[76px] shrink-0 items-center gap-3 border-b border-hairline px-5">
            <span class="grid size-11 place-items-center overflow-hidden rounded-xl bg-primary-50"><img src="{{ $adminLogo }}" alt="{{ config('app.name') }}" class="size-9 object-contain"></span>
            <span class="min-w-0"><span class="block truncate text-[17px] font-bold tracking-tight text-ink">{{ config('app.name', 'Products') }}</span><span class="block text-[12px] font-medium text-ink-muted">Commerce administration</span></span>
        </a>
        <nav class="sidebar-scroll min-h-0 flex-1 overflow-y-auto px-2.5 py-5 text-[14px] font-semibold">
            <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-ink-muted">Workspace</p>
            @foreach(config('sysadmin.menus', []) as $menu)
                @php
                    $children = collect($menu['children'] ?? [])->filter(fn ($child) => $canAccessRoute($child['route'] ?? null))->values()->all();
                    $routeName = $menu['route'] ?? null;
                    $isActive = ($routeName && $routeName !== '#' && request()->routeIs(str_replace('.index', '.*', $routeName))) || collect($children)->contains(fn ($child) => request()->routeIs(str_replace('.index', '.*', $child['route'] ?? '')));
                    $itemClass = 'flex min-h-11 w-full items-center gap-3 rounded-lg px-3 text-left transition hover:bg-[var(--bg)] hover:text-ink '.($isActive ? 'bg-primary-50 text-primary-600' : 'text-ink-soft');
                @endphp
                @if(count($children))
                    <div class="mt-0.5">
                        <button type="button" class="{{ $itemClass }}" @click="openGroup = openGroup === @js($menu['key']) ? null : @js($menu['key'])">
                            {!! \Modules\SysAdmin\Support\Icon::get($menu['icon'] ?? 'grid') !!}<span class="flex-1">{{ $menu['name'] }}</span><span class="transition" :class="openGroup === @js($menu['key']) && 'rotate-180'">{!! \Modules\SysAdmin\Support\Icon::get('chevron-down', 'h-4 w-4') !!}</span>
                        </button>
                        <div x-show="openGroup === @js($menu['key'])" x-collapse x-cloak class="ml-5 border-l border-hairline py-1 pl-3">
                            @foreach($children as $child)
                                <a href="{{ route($child['route']) }}" class="my-0.5 flex items-center gap-2.5 rounded-lg px-3 py-2 text-[13px] {{ request()->routeIs(str_replace('.index', '.*', $child['route'])) ? 'bg-primary-50 text-primary-600' : 'text-ink-muted hover:bg-[var(--bg)] hover:text-ink' }}">{!! \Modules\SysAdmin\Support\Icon::get($child['icon'] ?? 'grid', 'h-3.5 w-3.5 shrink-0') !!}<span>{{ $child['name'] }}</span></a>
                            @endforeach
                        </div>
                    </div>
                @elseif($routeName && $routeName !== '#' && $canAccessRoute($routeName))
                    <a href="{{ route($routeName) }}" class="{{ $itemClass }} mt-0.5">{!! \Modules\SysAdmin\Support\Icon::get($menu['icon'] ?? 'grid') !!}<span>{{ $menu['name'] }}</span></a>
                @endif
            @endforeach
        </nav>
    </aside>
    <div x-show="nav" x-cloak @click="nav = false" class="fixed inset-0 z-30 bg-black/30 lg:hidden"></div>
    <div class="flex min-h-full flex-1 flex-col lg:pl-[280px]">
        <header class="sticky top-0 z-20 flex h-[76px] items-center gap-3 border-b border-hairline bg-white/95 px-4 backdrop-blur lg:px-7">
            <button @click="nav = !nav" class="grid size-10 place-items-center rounded-lg bg-[var(--bg)] text-ink-soft lg:hidden" aria-label="Toggle navigation">{!! \Modules\SysAdmin\Support\Icon::get('menu') !!}</button>
            @unless(request()->routeIs('sysadmin.index'))<button type="button" onclick="history.back()" class="grid size-10 place-items-center rounded-lg border border-hairline bg-white text-ink-soft hover:bg-[var(--bg)] hover:text-primary" aria-label="Go back">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left') !!}</button>@endunless
            <div class="hidden flex-1 sm:block"><p class="text-[11px] font-bold uppercase tracking-wider text-ink-muted">SysAdmin</p><div class="text-[15px] font-bold text-ink">@yield('page-title', trim(strip_tags($__env->yieldContent('breadcrumb-title'))) ?: 'Dashboard')</div></div>
            <div class="flex-1 sm:hidden"></div>
            <div class="flex items-center gap-3 border-l border-hairline pl-4">
                <span class="grid size-10 place-items-center rounded-full bg-primary text-xs font-bold text-white">{{ $initials ?: 'A' }}</span>
                <div class="hidden leading-tight sm:block"><div class="text-[13.5px] font-bold text-ink">{{ $admin?->name ?? 'Administrator' }}</div><div class="text-[12px] text-ink-muted">{{ $adminRoleLabel }}</div></div>
                <form method="POST" action="{{ route('sysadmin.logout') }}">@csrf<button type="submit" class="grid size-9 place-items-center rounded-lg text-ink-soft hover:bg-[var(--bg)] hover:text-ink" title="Sign out" aria-label="Sign out">{!! \Modules\SysAdmin\Support\Icon::get('logout') !!}</button></form>
            </div>
        </header>
        <main class="w-full flex-1 px-4 py-5 lg:px-7">
            @if(isset($errors) && $errors->any())<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700"><p class="font-bold">Please check the highlighted information.</p><ul class="mt-1 list-disc pl-5 text-xs">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
    </div>
    <div class="fixed bottom-5 left-1/2 z-50 -translate-x-1/2" aria-live="polite"><template x-for="toast in toasts"><div class="rounded-lg bg-ink px-4 py-3 text-[13px] text-white shadow-lg" x-text="toast"></div></template></div>
</div>
{{ module_vite('build-sysadmin', 'resources/assets/js/app.js') }}
@stack('scripts')
@yield('script')
@livewireScripts
</body>
</html>
