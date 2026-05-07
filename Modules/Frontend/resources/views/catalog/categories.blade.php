@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    // Single main image using helper
    //$mainImage = ImageUploader::getFilePath($product->thumb ?? '', $product->created_at ?? null);
@endphp


<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">

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

    <div class="shop-category-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                    <div class="has-thumb banner-area">
                        <div class="banner-wrapper">
                            <a href="shop-4-column.html"><img src="public\assets\images\coming-soon-bg\reference-banner-image.jpg" alt="" /></a>
                        </div>
                        <h3 class="text-refine">Shop</h3>
                    </div>   
                    <!-- Shop Top Area Start -->
                    <div class="shop-top-bar">
                        <!-- Left Side start -->
                        <div class="shop-tab nav">
                            <a class="active grid-3" href="#shop-1" data-bs-toggle="tab">
                                
                            </a>
                            <a class="grid-4" href="#shop-2" data-bs-toggle="tab">
                                
                            </a>
                            <a class="list-views" href="#shop-3" data-bs-toggle="tab">
                                
                            </a>
                        </div>
                        <div class="toolbar-amaount">
                            <p>Showing 1 to 9 of 20 (3 Pages)</p>
                        </div>
                        <div class="sorter">
                            <label for="input-limit">Sort By:</label>
                            <select>
                                <option value="">Default</option>
                                <option value="">Name (A - Z)</option>
                                <option value=""> Name (Z - A)</option>
                                <option value="">Price (Low > High)</option>
                                <option value="">Price (High > Low)</option>
                                <option value="">Rating (Highest)</option>
                                <option value="">Rating (Lowest)</option>
                                <option value="">Model (A - Z)</option>
                                <option value="">Model (Z - A)</option>
                            </select>
                        </div>
                        <div class="limiter">
                            <label for="input-limit">Show:</label>
                            <select>
                                <option value="">9</option>
                                <option value="">25</option>
                                <option value=""> 50</option>
                                <option value="">75</option>
                                <option value="">100</option>
                            </select>
                        </div>
                        <!-- Right Side End -->
                    </div>
                    <!-- Shop Top Area End -->

                        <div class="shop-category-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30px">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}"
                                        class="thumbnail">

                                        @php
                                            $thumbUrl = ImageUploader::getFilePath(
                                                $product->thumb ?? '',
                                                $product->created_at ?? null,
                                                'thumbnail', // stored in /Y/m/thumbnail/filename
                                            );
                                        @endphp
                                        <img class="first-img" src="{{ $thumbUrl }}" alt="{{ $product->title }}">
                                    </a>
                                </div>
                                <div class="product-decs">
                                    <h2>
                                        <a href="{{ route('frontend.shop.product.show', $product->slug ?? $product->id) }}"
                                            class="product-link">
                                            {{ $product->title }}
                                        </a>
                                    </h2>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">
                                                ₹{{ number_format($product->sales_price ?? 0, 2) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="cart-btn mt-2">
                                    <button type="button" class="btn btn-success btn-sm js-enquiry-open"
                                        data-product-id="{{ $product->id }}"
                                        data-category-id="{{ $product->category_id ?? 0 }}"
                                        data-price="{{ $product->sales_price ?? 0 }}"
                                        data-product-name="{{ $product->name ?? ($product->title ?? '') }}">
                                        Enquiry
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

                    <!-- Shop Bottom Area Start -->
                    <div class="shop-bottom-area mt-35">
                        <!-- Shop Tab Content Start -->
                        <div class="tab-content jump">
                            <!-- Amazon Cloud Cam  Security Camera -->
                            <div id="shop-1" class="tab-pane active">
                                <div class="row m-0">
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/8.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/9.jpg" alt="" />
                                                        </a>
                                                    </div>
                                                    <ul class="product-flag">
                                                        <li class="discount">-10%</li>
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Amazon Cloud Cam  Security Camera</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="old-price">£23.90</li>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Single Item -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab One End -->
                            <!-- Tab Two Start -->
                            <div id="shop-2" class="tab-pane">
                                <div class="row m-0">
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/8.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/9.jpg" alt="" />
                                                        </a>
                                                    </div>
                                                    <ul class="product-flag">
                                                        <li class="discount">-12%</li>
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Amazon Cloud Cam  Security Camera</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="old-price">£23.90</li>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Single Item -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Two End -->
                            <!-- Tab Three Start -->
                            <div id="shop-3" class="tab-pane">
                                <div class="shop-list-wrap scroll-zoom">
                                    <div class="slider-single-item">
                                        <div class="row list-product m-0px">
                                            <div class="col-md-12 padding-0px product-inner">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                        <div class="left-img">
                                                            <div class="img-block">
                                                                <a href="single-product.html" class="thumbnail">
                                                                    <img class="first-img" src="assets/images/product-image/7.jpg" alt="" />
                                                                    <img class="second-img" src="assets/images/product-image/8.jpg" alt="" />
                                                                </a>
                                                                <ul class="product-flag">
                                                                    <li class="new">new</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Amazon Cloud Cam  Security Camera</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>More room to move.With 80GB or 160GB of storage and up to 40 hours of battery life, the new iPod classic lets you enjoy up to 40,000 songs or..</p>
                                                                </div>
                                                            </div>
                                                            <div class="box-inner d-flex">
                                                                <div class="align-self-center">
                                                                    <div class="pricing-meta">
                                                                        <ul>
                                                                            <li class="current-price">£18.50</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="in-stock">Availability: <span>299 In Stock</span></div>
                                                                    <div class="cart-btn">
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Enquiry</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Two End -->
                        </div>
                        <!-- Shop Tab Content End -->
                        <!--  Pagination Area Start -->
                        <div class="pro-pagination-style  mtb-50px">
                            <div class="pages">
                                <ul>
                                    <li>
                                        <a class="prev" href="#">|<i class="ion-ios-arrow-left"></i></a>
                                    </li>
                                    <li>
                                        <a class="prev" href="#"><i class="ion-ios-arrow-left"></i></a>
                                    </li>
                                    <li>
                                        <a class="prev" href="#">1</a>
                                    </li>
                                    <li><a class="active" href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li>
                                        <a class="next" href="#"><i class="ion-ios-arrow-right"></i></a>
                                    </li>
                                    <li>
                                        <a class="next" href="#"><i class="ion-ios-arrow-right"></i>|</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="toolbar-amaount">
                                <p>Showing 1 to 9 of 20 (3 Pages)</p>
                            </div>
                        </div>
                        <!--  Pagination Area End -->
                    </div>
                    <!-- Shop Bottom Area End -->
                </div>
                <!-- Sidebar Area Start -->
                
                <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-md-60px mb-lm-60px">
                    <div class="shop-sidebar-wrap">
                            <div class="sidebar-widget mb-30px bg-white">
                                    <h3 class="sidebar-title">CATEGORIES</h3>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                             @forelse ($rootCategories as $cat)
                                                <div class="card-header" id="headingOne">
                                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">{{ $cat->name }}</a>
                                                </div>
                                                @php
                                                    $childrens = $cat->children;
                                                @endphp
                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <ul class="category-list">
                                                        @forelse ($childrens as $children)
                                                            <li><a href="{{ Route('frontend.shop.category' , $children->slug) }}">{{ $children->name }}</a></li>
                                                        @empty
                                                            <div class="col-12">
                                                                <p class="text-center">No categories found.</p>
                                                            </div>
                                                        @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <p class="text-center">No categories found.</p>
                                                </div>
                                            @endforelse
                                        </div> <!-- card -->
                                    </div>
                                </div>
                            <!-- Sidebar single item -->
                            <div class="sidebar-widget-group bg-white mt-20">
                                <div class="sidebar-widget mt-20">
                                <h3 class="sidebar-title">FILLTER BY PRICE</h3>
                                    <div class="price-filter">
                                        <div id="slider-range"></div>
                                        <div class="price-slider-amount">
                                            <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Sidebar single item -->
                                <div class="sidebar-widget mt-20">
                                    <h3 class="sidebar-title">MANUFACTURER</h3>
                                    <div class="sidebar-widget-list">
                                        <ul>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" /> <a href="#">Christian Dior<span>(6)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Diesel<span>(10)</span></a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Sidebar single item -->
                                <div class="sidebar-widget mt-30 b-b-0">
                                    <h3 class="sidebar-title">SELECT BY COLOR</h3>
                                    <div class="sidebar-widget-list-column">
                                        <div class="sidebar-widget-list">
                                            <ul>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" /> <a href="#">Black<span>(6)</span> </a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" value="" /> <a href="#">Blue<span>(7)</span></a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" value="" /> <a href="#">Brown<span>(4)</span> </a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" value="" /> <a href="#">Green<span>(9)</span> </a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="sidebar-widget-list">
                                            <ul>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" /> <a href="#">Pink<span>(7)</span> </a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" value="" /> <a href="#">Red<span>(7)</span></a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" value="" /> <a href="#">White<span>(9)</span> </a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="sidebar-widget-list-left">
                                                        <input type="checkbox" value="" /> <a href="#">Yellow<span>(10)</span> </a>
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="banner-area mt-30px">
                            <div class="banner-wrapper">
                                <a href="shop-4-column.html"><img src="assets/images/banner-image/10.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 

</x-frontend::layouts.master>
