<x-frontend::layouts.master>

<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
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
                                <img src="{{ $cat->image ? asset('uploads/category/'.$cat->image) : asset('assets/images/category-placeholder.jpg') }}"
                                     alt="{{ $cat->name }}">
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
