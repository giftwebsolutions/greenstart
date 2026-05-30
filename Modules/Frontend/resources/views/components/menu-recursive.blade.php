@foreach($items as $item)

    {{-- Dropdown --}}
    @if(!empty($item['children']) && is_array($item['children']))
        <li class="menu-dropdown {{ \Modules\Frontend\Helpers\MenuHelpers::isActive($item) }}">
            <a href="{{ \Modules\Frontend\Helpers\MenuHelpers::url($item) }}">
                {{ $item['label'] }} <i class="ion-ios-arrow-down"></i>
            </a>

            <ul class="main-sub-menu">
                @include('frontend::components.menu-recursive', ['items' => $item['children']])
            </ul>
        </li>

    @else
        {{-- Normal link --}}
        <li class="{{ \Modules\Frontend\Helpers\MenuHelpers::isActive($item) }}">
            <a href="{{ \Modules\Frontend\Helpers\MenuHelpers::url($item) }}">
                {{ $item['label'] }}
            </a>
        </li>
    @endif

@endforeach
