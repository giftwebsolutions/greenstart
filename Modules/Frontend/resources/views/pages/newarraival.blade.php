@section('css')
@endsection
<x-frontend::layouts.master>
   <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <ul class="nav">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>New Arrival</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Breadcrumb Area End-->
    
    <!-- Shop Category Area End -->
    <div class="shop-category-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                    <div class="has-thumb banner-area">
                        <div class="banner-wrapper">
                            <a href="shop-4-column.html"><img src="assets/images/banner-image/19.jpg" alt="" /></a>
                        </div>
                        <h3 class="text-refine">Shop</h3>
                    </div>
                   
                    <div class="custom-category">
                        <h4><a href="#">Product Compare (0)</a></h4>
                    </div>   
                    <!-- Shop Top Area Start -->
                    <div class="shop-top-bar">
                        <!-- Left Side start -->
                        <div class="shop-tab nav">
                            <a class=" grid-3" href="#shop-1" data-bs-toggle="tab">
                                
                            </a>
                            <a class="grid-4" href="#shop-2" data-bs-toggle="tab">
                                
                            </a>
                            <a class="active list-views" href="#shop-3" data-bs-toggle="tab">
                                
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

                    <!-- Shop Bottom Area Start -->
                    <div class="shop-bottom-area mt-35">
                        <!-- Shop Tab Content Start -->
                        <div class="tab-content jump">
                            <!-- Tab One Start -->
                            <div id="shop-1" class="tab-pane">
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
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
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
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/12.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/13.jpg" alt="" />
                                                        </a>
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple iPad with Retina  Display MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple iPhone SE 16GB  Factory Unlocked</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats EP Wired On-Ear  Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/6.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/7.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="product-flag">
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats Solo2 Solo 2 On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#"  class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/4.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/5.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="product-flag">
                                                        <li class="new">new</li>
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless  On-Ear Headphones</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
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
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="product-flag">
                                                        <li class="discount">-10%</li>
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless  On-Ear Headphones 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
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
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/12.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/13.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro  Bluetooth Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-4 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro  Bluetooth Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
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
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
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
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/12.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/13.jpg" alt="" />
                                                        </a>
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple iPad with Retina  Display MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple iPhone SE 16GB  Factory Unlocked</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats EP Wired On-Ear  Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/6.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/7.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="product-flag">
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats Solo2 Solo 2 On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#"  class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/4.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/5.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="product-flag">
                                                        <li class="new">new</li>
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless  On-Ear Headphones</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
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
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="product-flag">
                                                        <li class="discount">-10%</li>
                                                    </ul>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless  On-Ear Headphones 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
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
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/12.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/13.jpg" alt="" />
                                                        </a>
                                        
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro  Bluetooth Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="mb-30px col-md-3 col-sm-6  p-0">
                                        <div class="slider-single-item">
                                            <!-- Single Item -->
                                            <article class="list-product p-0 ">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                            <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                        </a>
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li>
                                                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro  Bluetooth Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£21.51</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Two End -->
                            <!-- Tab Three Start -->
                            <div id="shop-3" class="tab-pane active">
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                <div class="shop-list-wrap scroll-zoom">
                                    <div class="slider-single-item">
                                        <div class="row list-product m-0px">
                                            <div class="col-md-12 padding-0px product-inner">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                        <div class="left-img">
                                                            <div class="img-block">
                                                                <a href="single-product.html" class="thumbnail">
                                                                    <img class="first-img" src="assets/images/product-image/12.jpg" alt="" />
                                                                    <img class="second-img" src="assets/images/product-image/13.jpg" alt="" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Apple iPad with Retina  Display MD510LL/A </a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Stop your co-workers in their tracks with the stunning new 30-inch diagonal HP LP3065 Flat Panel Monitor. This flagship monitor features best-in-class..</p>
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                <div class="shop-list-wrap scroll-zoom">
                                    <div class="slider-single-item">
                                        <div class="row list-product m-0px">
                                            <div class="col-md-12 padding-0px product-inner">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                        <div class="left-img">
                                                            <div class="img-block">
                                                                <a href="single-product.html" class="thumbnail">
                                                                    <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                                    <img class="second-img" src="assets/images/product-image/17.jpg" alt="" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Apple iPhone SE 16GB  Factory Unlocked</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Born to be worn. Clip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including fou..</p>
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                <div class="shop-list-wrap scroll-zoom">
                                    <div class="slider-single-item">
                                        <div class="row list-product m-0px">
                                            <div class="col-md-12 padding-0px product-inner">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                        <div class="left-img">
                                                            <div class="img-block">
                                                                <a href="single-product.html" class="thumbnail">
                                                                    <img class="first-img" src="assets/images/product-image/16.jpg" alt="" />
                                                                    <img class="second-img" src="assets/images/product-image/9.jpg" alt="" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Beats EP Wired On-Ear  Headphone-Black</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Canon's press material for the EOS 5D states that it 'defines (a) new D-SLR category', while we're not typically too concerned with marketing talk thi..</p>
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Beats Solo2 Solo 2  Wired On-Ear Headphone</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Intel Core 2 Duo processor Powered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, the new MacBook is the fastest ever. 1GB memo..</p>
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                <div class="shop-list-wrap scroll-zoom">
                                    <div class="slider-single-item">
                                        <div class="row list-product m-0px">
                                            <div class="col-md-12 padding-0px product-inner">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                        <div class="left-img">
                                                            <div class="img-block">
                                                                <a href="single-product.html" class="thumbnail">
                                                                    <img class="first-img" src="assets/images/product-image/4.jpg" alt="" />
                                                                    <img class="second-img" src="assets/images/product-image/5.jpg" alt="" />
                                                                </a>
                                                                <ul class="product-flag">
                                                                    <li class="discount">-12%</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless  On-Ear Headphones 2</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Unprecedented power. The next generation of processing technology has arrived. Built into the newest VAIO notebooks lies Intel's latest, most powe..</p>
                                                                </div>
                                                            </div>
                                                            <div class="box-inner d-flex">
                                                                <div class="align-self-center">
                                                                    <div class="pricing-meta">
                                                                        <ul>
                                                                            <li class="old-price">£28.50</li>
                                                                            <li class="current-price">£18.50</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="in-stock">Availability: <span>299 In Stock</span></div>
                                                                    <div class="cart-btn">
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                                                <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro  Bluetooth Speaker</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Canon's press material for the EOS 5D states that it 'defines (a) new D-SLR category', while we're not typically too concerned with marketing talk thi..</p>
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                <div class="shop-list-wrap scroll-zoom">
                                    <div class="slider-single-item">
                                        <div class="row list-product m-0px">
                                            <div class="col-md-12 padding-0px product-inner">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                        <div class="left-img">
                                                            <div class="img-block">
                                                                <a href="single-product.html" class="thumbnail">
                                                                    <img class="first-img" src="assets/images/product-image/12.jpg" alt="" />
                                                                    <img class="second-img" src="assets/images/product-image/13.jpg" alt="" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                        <div class="product-desc-wrap">
                                                            <div class="product-decs">
                                                                <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro  Bluetooth Speaker 2</a></h2>
                                                                <div class="rating-product">
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                    <i class="ion-android-star color-gray"></i>
                                                                </div>
                                                                <div class="product-intro-info">
                                                                    <p>Canon's press material for the EOS 5D states that it 'defines (a) new D-SLR category', while we're not typically too concerned with marketing talk thi..</p>
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
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                                                    <li class="new discount">-10%</li>
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
                                                                            <li class="old-price">£21.90</li>
                                                                            <li class="current-price">£18.50</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="in-stock">Availability: <span>299 In Stock</span></div>
                                                                    <div class="cart-btn">
                                                                        <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                                    </div>
                                                                    <div class="add-to-link">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
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
                                            <div class="card-header" id="headingOne">
                                                <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">Accessories (7)</a>
                                            </div>

                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Dresses</a></li>
                                                        <li><a href="#">Jackets &amp; Coats</a></li>
                                                        <li><a href="#">Sweaters</a></li>
                                                        <li><a href="#">Jeans</a></li>
                                                        <li><a href="#">Blouses &amp; Shirts</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Body Parts (20)</a>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Handbag (10)</a></li>
                                                        <li><a href="#">Accessories (7)</a></li>
                                                        <li><a href="#">Clothing (8)</a></li>
                                                        <li><a href="#">Shoes (3)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingThree">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Brake Parts (16)</a>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Brake Tools (6)</a></li>
                                                        <li><a href="#">Drive shafts (3)</a></li>
                                                        <li><a href="#">Emergency Brake (3)</a></li>
                                                        <li><a href="#">Spools (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingFour">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Car Seats (0)</a>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Booster (0)</a></li>
                                                        <li><a href="#">Convertible (0)</a></li>
                                                        <li><a href="#">Infant (0)</a></li>
                                                        <li><a href="#">Toddler (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingFive">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Engine Parts</a>
                                            </div>
                                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Calculators (0)</a></li>
                                                        <li><a href="#">Check Trousers (0)</a></li>
                                                        <li><a href="#">Ink & Toner (0)</a></li>
                                                        <li><a href="#">Low-Cut Jeans (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingSix">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Indoor Living</a>
                                            </div>
                                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Bridge (0)</a></li>
                                                        <li><a href="#">Hub (0)</a></li>
                                                        <li><a href="#">Repeater (0)</a></li>
                                                        <li><a href="#">Switch (0)</a></li>
                                                        <li><a href="#">Video Games Cosoles (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingSeven">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">Lighting</a>
                                            </div>
                                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Bulbs (0)</a></li>
                                                        <li><a href="#">Headlights (0)</a></li>
                                                        <li><a href="#">Light Bars (0)</a></li>
                                                        <li><a href="#">Light Kits (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingEight">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">Moto Oil</a>
                                            </div>
                                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">2-Stroke (0)</a></li>
                                                        <li><a href="#">4-Stroke (0)</a></li>
                                                        <li><a href="#">Diesel (0)</a></li>
                                                        <li><a href="#">Gasoline (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingNine">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">Repair Parts</a>
                                            </div>
                                            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Bearings (0)</a></li>
                                                        <li><a href="#">Rim Screws (0)</a></li>
                                                        <li><a href="#">Seals & Hubs (0)</a></li>
                                                        <li><a href="#">Simulators (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingTen">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">Shop</a>
                                            </div>
                                            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Saws (0)</a></li>
                                                        <li><a href="#">Concrete Tools (8)</a></li>
                                                        <li><a href="#">Drills (2)</a></li>
                                                        <li><a href="#">Sanders (1)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card -->
                                        <div class="card">
                                            <div class="card-header" id="headingEleven">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">Turbo Systems</a>
                                            </div>
                                            <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Turbo Blanket (4)</a></li>
                                                        <li><a href="#">Turbo Kits (4)</a></li>
                                                        <li><a href="#">Turbo Wrap (4)</a></li>
                                                        <li><a href="#">Turbocharger (0)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> <!-- card --> 
                                        <div class="card">
                                            <div class="card-header" id="headingTwelve">
                                                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">Wheels &amp; Tires</a>
                                            </div>
                                            <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-bs-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul class="category-list">
                                                        <li><a href="#">Wheel Simulators (3)</a></li>
                                                        <li><a href="#">Seals & Hubs (10)</a></li>
                                                        <li><a href="#">Wheel Rim Screws (11)</a></li>
                                                        <li><a href="#">Wheel Bearings (9)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
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
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">ferragamo<span>(13)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">hermes<span>(17)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">louis vuitton<span>(16)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Tommy Hilfiger<span>(0)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Versace<span>(0)</span> </a>
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
    <!-- Shop Category Area End -->
</x-frontend::layouts.master>
@section('js')
@endsection
