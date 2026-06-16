@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp

@if ($categories && $categories->count())
    <section class="ga-cat-area">
        <div class="container">
            <div class="section-title">
                <h2><span>Shop</span> by Category</h2>
            </div>

            <div class="ga-cat-rail">
                @foreach ($categories as $cat)
                    @php
                        $img = $cat->image
                            ? ImageUploader::getFilePath($cat->image, $cat->created_at ?? null, 'thumbnail')
                            : asset('uploads/default.jpg');
                    @endphp
                    <a class="ga-cat-card" href="{{ route('frontend.shop.category', $cat->slug) }}">
                        <span class="ga-cat-thumb">
                            <img src="{{ $img }}" alt="{{ $cat->name }}" loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('uploads/default.jpg') }}';">
                        </span>
                        <span class="ga-cat-name">{{ $cat->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
