@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    // Single main image using helper
    //$mainImage = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null);
@endphp


<x-frontend::layouts.master>

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li>Categories</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shop-category-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                @forelse ($rootCategories as $cat)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30px">
                        <div class="single-category text-center">
                            <a href="{{ route('frontend.shop.category', $cat->slug) }}">
                                <div class="category-thumb mb-2">

                                    @php
                                        $thumbUrl = ImageUploader::getFilePath(
                                            $cat->image ?? '',
                                            $cat->created_at ?? null,
                                            'thumbnail', // stored in /Y/m/thumbnail/filename
                                        );
                                    @endphp
                                    <img class="first-img" src="{{ $thumbUrl }}" alt="{{ $cat->name }}">
                                </div>
                                <h4>{{ $cat->name }}</h4>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No categories found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</x-frontend::layouts.master>
