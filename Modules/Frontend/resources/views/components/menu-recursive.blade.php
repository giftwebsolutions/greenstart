@php
    //dd($items);
@endphp

@foreach($items as $item)

    {{-- If it has children → dropdown --}}
    @if(isset($item['children']))

        <li class="menu-dropdown {{ \Modules\Frontend\Helpers\MenuHelper::isActive($item) }}">
            <a href="#">
                {{ $item['label'] }} <i class="ion-ios-arrow-down"></i>
            </a>

            <ul class="main-sub-menu">
                {{-- Recursive call for submenu --}}
                @include('frontend::components.menu-recursive', ['items' => $item['children']])
            </ul>
        </li>

    @else
        {{-- Normal Link (route or URL) --}}
        <li class="{{ \Modules\Frontend\Helpers\MenuHelper::isActive($item) }}">
            <a href="{{ $item['route'] ? route($item['route']) : $item['url'] }}">
                {{ $item['label'] }}
            </a>
        </li>
    @endif

@endforeach
