@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp

<ul class="menu-content display-none">
    @if ($verticalCategories && $verticalCategories->count() > 0)
        @foreach ($verticalCategories as $category)
            <li class="menu-item">
                <a href="{{ route('frontend.shop.category', $category->slug) }}">
                    {{ $category->name }}
                    @if ($category->children->count())
                        <i class="ion-ios-arrow-right"></i>
                    @endif
                </a>

                @if ($category->children->count())
                    <ul class="sub-menu sub-menu-2">
                        <li>
                            <ul class="submenu-item">
                                @foreach ($category->children as $child)
                                    @php
                                        $childQs2 = \Illuminate\Support\Arr::query([
                                            's_cat' => $child->id
                                        ]);
                                        $subHref2 = route('frontend.shop.category', $category->slug) . ($childQs2 ? '?' . $childQs2 : '');
                                    @endphp
                                    <li>
                                        <!-- route('frontend.shop.category', [$category->slug ,'s_cat=' . $child->id]) -->
                                        <a href="{{ $subHref2 }}">
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
    @endif
</ul>
