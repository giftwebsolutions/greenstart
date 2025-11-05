<?php
$menus = Config::get('sysadmin.menus');
?>
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('sysadmin.index') }}"><img class="img-fluid for-light"
                    src="{{ asset('admin/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('admin/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('sysadmin.index') }}"><img class="img-fluid"
                    src="{{ asset('admin/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="bi bi-arrow-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    @foreach ($menus as $menu)

                        @if (!empty($menu['children']))
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#'.$menu['icon']) }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#'.$menu['icon']) }}"></use>
                                    </svg><span>{{ $menu['name'] }}</span></a>
                                @if (!empty($menu['children']))
                                    <ul class="sidebar-submenu">
                                        @foreach ($menu['children'] as $child)
                                            <li><a href="{{ route($child['route']) }}">{{ $child['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @else
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title"
                                    href="{{ route($menu['route']) }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#'.$menu['icon']) }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#'.$menu['icon']) }}"></use>
                                    </svg><span>{{ $menu['name'] }}</span></a>
                            </li>
                        @endif

                    @endforeach
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
