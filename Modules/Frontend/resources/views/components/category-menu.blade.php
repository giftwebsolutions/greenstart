@php
    //dd($verticalCategories);
@endphp

<ul class="menu-content display-none">
    @foreach($verticalCategories as $category)
        <li class="menu-item">
            <a href="{{ route('frontend.shop.category', $category->slug) }}">
                {{ $category->name }}
                @if($category->children->count())
                    <i class="ion-ios-arrow-right"></i>
                @endif
            </a>

            @if($category->children->count())
                <ul class="sub-menu sub-menu-2">
                    <li>
                        <ul class="submenu-item">
                            @foreach($category->children as $child)
                                <li>
                                    <a href="{{ route('frontend.shop.category', $child->slug) }}">
                                        {{ $child->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endif
        </li>
    @endforeach
</ul>
