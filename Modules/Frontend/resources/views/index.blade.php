@section('css')
@endsection
<x-frontend::layouts.master>
        <!-- Slider Start -->
    <div class="slider-area">
        <div class="hero-slider-wrapper">
            <!-- Single Slider  -->
            <div class="single-slide slider-height-1 bg-img d-flex"
                data-bg-image=" {{ asset('assets/images/slider-image/sample-1.jpg') }}">
                <div class="container align-self-center">
                    <div class="slider-content-1 slider-animated-1 text-left">
                        <span class="title theme-color">Black Friday.</span>
                        <h1 class="animated color-white">Car Brake Pads <br> Sale 50% Off</h1>
                        <p class="animated color-white">Lets diagnose your vehicle’s brake prodblems and offer solutions
                            that fit your budget.</p>
                        <a href="shop-4-column.html" class="shop-btn animated">Shopping Now</a>
                    </div>
                </div>
            </div>
            <!-- Single Slider  -->
            <div class="single-slide slider-height-1 bg-img d-flex"
                data-bg-image=" {{ asset('assets/images/slider-image/sample-2.jpg') }}">
                <div class="container align-self-center">
                    <div class="slider-content-1 slider-animated-2 text-left">
                        <span class="title color-white">New Arrivals</span>
                        <h1 class="animated color-white">Quadrum <br> 1100MM Wheels </h1>
                        <p class="animated color-white">Strong All-Season Perfomance for your CUV/SUV with a 60K
                            warranty</p>
                        <a href="shop-4-column.html" class="shop-btn animated">Shopping Now</a>
                    </div>
                </div>
            </div>
            <!-- Single Slider  -->
            <div class="single-slide slider-height-1 bg-img d-flex"
                data-bg-image=" {{ asset('assets/images/slider-image/sample-3.jpg') }}">
                <div class="container align-self-center">
                    <div class="slider-content-1 slider-animated-3 text-left">
                        <span class="title theme-color">T1 - series 2018</span>
                        <h1 class="animated color-white">Led Headlight <br> Bulbs</h1>
                        <p class="animated color-white">Headlights at low internet prices from the UK’s leading vehicle
                            headlights specialist</p>
                        <a href="shop-4-column.html" class="shop-btn animated">Shopping Now</a>
                    </div>
                </div>
            </div>
            <!-- Single Slider  -->
        </div>
    </div>
    <!-- Slider End -->
    <!-- Static Area Start -->
    <div class="static-area mtb-60px">
        <div class="container">
            <div class="static-area-wrap">
                <div class="row">
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img src="{{ asset('assets/images/icons/static-icons-1.png') }}" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Free Shipping</h4>
                                <p>Free shipping on all US orde</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img src="{{ asset('assets/images/icons/static-icons-2.png') }}" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Support 24/7</h4>
                                <p>Contact us 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-sm-30px">
                        <div class="single-static">
                            <img src="{{ asset('assets/images/icons/static-icons-3.png') }}" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>100% Money Back</h4>
                                <p>You have 30 days to Return</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                        <div class="single-static">
                            <img src="{{ asset('assets/images/icons/static-icons-4.png') }}" alt="" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Payment Secure</h4>
                                <p>We ensure secure payment</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Static Area End -->

    <!-- Arrivel Area Start -->
    <div class="arrival-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2> <span>NEW</span> ARRIVALS</h2>
                    </div>
                </div>
            </div>
            <div class="arrival-wrapper">
                <div class="arrival-slider slider-nav-style-1">
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/1.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/1.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Koss KPH7 Lightweight
                                            Portable Headphone 2</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star color-gray"></i>
                                        <i class="ion-android-star color-gray"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£69.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Kodak PIXPRO Astro Zoom AZ421
                                            16 MP 2</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£87.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">JBL Flip 3 Splashproof
                                            Portable Bluetooth 2</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£469.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/4.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro
                                            Bluetooth Speaker 2</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£91.86</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/5.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/5.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless On-Ear
                                            Headphones 2</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£905.05</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/6.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/6.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Nokia Steel HR Hybrid
                                            Smartwatch</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£87.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/7.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/7.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                        <li class="new discount">-7%</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Marshall Portable Bluetooth
                                            Speaker</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£69.27</li>
                                            <li class="old-price">£89.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">JBL Flip 3 Splashproof
                                            Portable Bluetooth</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£469.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Beats EP Wired On-Ear
                                            Headphone-Black</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£91.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/10.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/10.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">New</li>
                                        <li class=" new discount">-2%</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Sony KD55X72 55-Inch 4k Ultra
                                            HD</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£59.27</li>
                                            <li class="old-price">£60.12</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/11.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/11.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Roush Performance Front Brake
                                            Rotor</a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£69.27</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="arrval-slider-item">
                        <article class="list-product text-left">
                            <div class="product-inner">
                                <div class="img-block">
                                    <a href="single-product.html" class="thumbnail">
                                        <img class="first-img" src="{{ asset('assets/images/product-image/12.jpg') }}" alt="" />
                                        <img class="second-img" src="{{ asset('assets/images/product-image/12.jpg') }}" alt="" />
                                    </a>
                                    <div class="add-to-link">
                                        <ul>
                                            <li>
                                                <a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="compare.html" title="Add to compare"><i
                                                        class="icon-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a class="quick_view" href="#" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="discount">-7%</li>
                                    </ul>
                                </div>
                                <div class="product-decs">
                                    <h2><a href="single-product.html" class="product-link">Koss Porta Pro On Ear
                                            Headphones </a></h2>
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <div class="pricing-meta">
                                        <ul>
                                            <li class="current-price">£69.27</li>
                                            <li class="old-price">£60.72</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cart-btn">
                                    <a href="#" class="add-to-curt" title="Add to cart"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Arrivel Area End -->
    <!-- Banner Area Start -->
    <div class="banner-area mtb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-lm-30px">
                    <div class="banner-wrapper">
                        <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/1.jpg') }}" alt="" /></a>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="banner-wrapper">
                        <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/2.jpg') }}" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Area End -->
    <!-- Custom Block Area Start -->
    <div class="custom-block-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-md-60px">
                    <div class="hot-deal-area">
                        <div class="section-title">
                            <h2><span>THIS WEEK’S</span> HOT DEALS</h2>
                        </div>
                        <div class="box-style">
                            <div class="hot-deal-slider-wrapper slider-nav-style-1">
                                <div class="slider-single-item">
                                    <article class="list-product text-left">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.html" class="thumbnail">
                                                    <img class="first-img" src="{{ asset('assets/images/product-image/9.jpg') }}"
                                                        alt="" />
                                                    <img class="second-img" src="{{ asset('assets/images/product-image/9.jpg') }}"
                                                        alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                                    class="icon-heart"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" title="Add to compare"><i
                                                                    class="icon-repeat"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                                title="Quick view" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">
                                                                <i class="icon-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <ul class="product-flag">
                                                    <li class="discount">-7%</li>
                                                </ul>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.html" class="product-link">Apple iPad with
                                                        Retina Display HD</a></h2>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">£69.27</li>
                                                        <li class="old-price">£60.72</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cart-btn">
                                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                                        class="icon-shopping-cart"></i></a>
                                            </div>
                                            <div class="clockdiv d-flex">
                                                <p class="text-hurryup align-self-center">Hurry up! <span>Offer ends
                                                        in:</span></p>
                                                <div data-countdown="2023/03/01"></div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="slider-single-item">
                                    <article class="list-product text-left">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.html" class="thumbnail">
                                                    <img class="first-img" src="{{ asset('assets/images/product-image/12.jpg') }}"
                                                        alt="" />
                                                    <img class="second-img" src="{{ asset('assets/images/product-image/12.jpg') }}"
                                                        alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                                    class="icon-heart"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" title="Add to compare"><i
                                                                    class="icon-repeat"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                                title="Quick view" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">
                                                                <i class="icon-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <ul class="product-flag">
                                                    <li class="discount">-7%</li>
                                                </ul>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.html" class="product-link">Koss Porta Pro On
                                                        Ear Headphones </a></h2>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">£69.27</li>
                                                        <li class="old-price">£60.72</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cart-btn">
                                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                                        class="icon-shopping-cart"></i></a>
                                            </div>
                                            <div class="clockdiv d-flex">
                                                <p class="text-hurryup align-self-center">Hurry up! <span>Offer ends
                                                        in:</span></p>
                                                <div data-countdown="2023/03/01"></div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="slider-single-item">
                                    <article class="list-product text-left">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.html" class="thumbnail">
                                                    <img class="first-img" src="{{ asset('assets/images/product-image/7.jpg') }}"
                                                        alt="" />
                                                    <img class="second-img" src="{{ asset('assets/images/product-image/7.jpg') }}"
                                                        alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                                    class="icon-heart"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" title="Add to compare"><i
                                                                    class="icon-repeat"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                                title="Quick view" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">
                                                                <i class="icon-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <ul class="product-flag">
                                                    <li class="discount">-7%</li>
                                                </ul>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.html" class="product-link">Marshall Portable
                                                        Bluetooth Speaker</a></h2>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">£69.27</li>
                                                        <li class="old-price">£60.72</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cart-btn">
                                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                                        class="icon-shopping-cart"></i></a>
                                            </div>
                                            <div class="clockdiv d-flex">
                                                <p class="text-hurryup align-self-center">Hurry up! <span>Offer ends
                                                        in:</span></p>
                                                <div data-countdown="2023/03/01"></div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="slider-single-item">
                                    <article class="list-product text-left">
                                        <div class="product-inner">
                                            <div class="img-block">
                                                <a href="single-product.html" class="thumbnail">
                                                    <img class="first-img" src="{{ asset('assets/images/product-image/10.jpg') }}"
                                                        alt="" />
                                                    <img class="second-img" src="{{ asset('assets/images/product-image/10.jpg') }}"
                                                        alt="" />
                                                </a>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                                    class="icon-heart"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" title="Add to compare"><i
                                                                    class="icon-repeat"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                                title="Quick view" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">
                                                                <i class="icon-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <ul class="product-flag">
                                                    <li class="discount">-7%</li>
                                                </ul>
                                            </div>
                                            <div class="product-decs">
                                                <h2><a href="single-product.html" class="product-link">Sony KD55X72
                                                        55-Inch 4k Ultra HD</a></h2>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                                <div class="pricing-meta">
                                                    <ul>
                                                        <li class="current-price">£69.27</li>
                                                        <li class="old-price">£60.72</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cart-btn">
                                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                                        class="icon-shopping-cart"></i></a>
                                            </div>
                                            <div class="clockdiv d-flex">
                                                <p class="text-hurryup align-self-center">Hurry up! <span>Offer ends
                                                        in:</span></p>
                                                <div data-countdown="2023/03/01"></div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Banner Area Start -->
                    <div class="banner-area banner-style-2 mtb-60px">
                        <div class="banner-wrapper">
                            <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/3.jpg') }}" alt="" /></a>
                            <div class="text">
                                <h3> <span class="theme-color">New</span> Led Headlight</h3>
                                <h4 class="color-yellow">Cre-Xhp-50 Lamp Bead</h4>
                                <p>Adjustable Bracket High Lumen 11390lms</p>
                            </div>
                        </div>
                    </div>
                    <!-- Banner Area End -->
                    <div class="feature-area mb-lm-60px">
                        <div class="section-title">
                            <h2><span>FEATURED </span> PRODUCTS</h2>
                        </div>
                        <div class="feature-slider-wrapper slider-nav-style-1">
                            <div class="feature-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/13.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/13.jpg') }}"
                                                    alt="" />
                                            </a>
                                            <div class="add-to-link">
                                                <ul>
                                                    <li>
                                                        <a href="wishlist.html" title="Add to Wishlist"><i
                                                                class="icon-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" title="Add to compare"><i
                                                                class="icon-repeat"></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="quick_view" href="#" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Amazon Cloud Cam
                                                    Security Camera</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£69.27</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <a href="#" class="add-to-curt" title="Add to cart"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="feature-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/14.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/14.jpg') }}"
                                                    alt="" />
                                            </a>
                                            <div class="add-to-link">
                                                <ul>
                                                    <li>
                                                        <a href="wishlist.html" title="Add to Wishlist"><i
                                                                class="icon-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" title="Add to compare"><i
                                                                class="icon-repeat"></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="quick_view" href="#" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <ul class="product-flag">
                                                <li class="new discount">-7%</li>
                                            </ul>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Apple iPad with
                                                    Retina Display MD510LL/A </a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£52.27</li>
                                                    <li class="old-price">£59.72</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <a href="#" class="add-to-curt" title="Add to cart"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="feature-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/9.jpg') }}"
                                                    alt="" />
                                            </a>
                                            <div class="add-to-link">
                                                <ul>
                                                    <li>
                                                        <a href="wishlist.html" title="Add to Wishlist"><i
                                                                class="icon-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" title="Add to compare"><i
                                                                class="icon-repeat"></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="quick_view" href="#" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">JBeats EP Wired
                                                    On-Ear Headphone-Black</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£91.27</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <a href="#" class="add-to-curt" title="Add to cart"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="feature-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/15.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/11.jpg') }}"
                                                    alt="" />
                                            </a>
                                            <div class="add-to-link">
                                                <ul>
                                                    <li>
                                                        <a href="wishlist.html" title="Add to Wishlist"><i
                                                                class="icon-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" title="Add to compare"><i
                                                                class="icon-repeat"></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="quick_view" href="#" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Beats Solo Wireless
                                                    On-Ear Headphone</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£182.27</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <a href="#" class="add-to-curt" title="Add to cart"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="feature-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/8.jpg') }}"
                                                    alt="" />
                                            </a>
                                            <div class="add-to-link">
                                                <ul>
                                                    <li>
                                                        <a href="wishlist.html" title="Add to Wishlist"><i
                                                                class="icon-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html" title="Add to compare"><i
                                                                class="icon-repeat"></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="quick_view" href="#" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">JBL Flip 3
                                                    Splashproof Portable Bluetooth</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£453.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <a href="#" class="add-to-curt" title="Add to cart"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="best-sell-area">
                        <div class="section-title">
                            <h2><span> BEST </span> SELLERS</h2>
                        </div>
                        <div class="best-sell-slider-wrapper bg-white slider-nav-style-1">
                            <div class="best-sell-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/11.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/11.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Roush Performance
                                                    Front Brake Rotor</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£53.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/12.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/12.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Koss Porta Pro On Ear
                                                    Headphones </a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£60.28</li>
                                                    <li class="old-price">£64.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/16.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/16.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro
                                                    Bluetooth Speaker</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£53.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/10.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/10.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Sony KD55X72 55-Inch
                                                    4k Ultra HD</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£59.00</li>
                                                    <li class="old-price">£60.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="best-sell-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/14.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/14.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Apple iPad with
                                                    Retina Display MD510LL/A </a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£53.28</li>
                                                    <li class="old-price">£59.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/9.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Beats EP Wired On-Ear
                                                    Headphone-Black</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£53.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/13.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/13.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Amazon Cloud Cam
                                                    Security Camera</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£45.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/17.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/17.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Beats Solo2 Solo 2
                                                    Wired On-Ear Headphone</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£453.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="best-sell-slider-item">
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/6.jpg') }}" alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/7.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Nokia Steel HR Hybrid
                                                    Smartwatch</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£78.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/4.jpg') }}" alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/3.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro
                                                    Bluetooth Speaker 2</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£153.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/18.jpg') }}"
                                                    alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/17.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless
                                                    On-Ear Headphones</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£45.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="list-product text-left">
                                    <div class="product-inner">
                                        <div class="img-block">
                                            <a href="single-product.html" class="thumbnail">
                                                <img class="first-img" src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                <img class="second-img" src="{{ asset('assets/images/product-image/3.jpg') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-decs">
                                            <h2><a href="single-product.html" class="product-link">Kodak PIXPRO Astro
                                                    Zoom AZ421 16 MP 2</a></h2>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star color-gray"></i>
                                                <i class="ion-android-star color-gray"></i>
                                            </div>
                                            <div class="pricing-meta">
                                                <ul>
                                                    <li class="current-price">£73.28</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial Start -->
                    <div class="testimonial-area slider-dot-style-1">
                        <div class="testimonial-slider-wrapper">
                            <!-- Testimonial item Start -->
                            <div class="testimonial-slider-item">
                                <div class="testimonial-image">
                                    <img src="{{ asset('assets/images/testimonial-image/1.png') }}" alt="man-image">
                                </div>
                                <div class="testimonial-content">
                                    <a href="#"> This is Photoshops version of Lorem Ipsum. Proin gravida nibh vel
                                        velit.Lorem ipsum dolor sit amet, consectetur adipiscing elit...</a>
                                </div>
                                <div class="testimonial-author">
                                    <h4>Rebecka Filson</h4>
                                </div>
                            </div>
                            <!-- Testimonial item End -->
                            <!-- Testimonial item Start -->
                            <div class="testimonial-slider-item">
                                <div class="testimonial-image">
                                    <img src="{{ asset('assets/images/testimonial-image/2.png') }}" alt="man-image">
                                </div>
                                <div class="testimonial-content">
                                    <a href="#"> Mauris blandit, metus a venenatis lacinia, felis enim tincidunt est,
                                        condimentum vulputate orci augue eu metus. Fusce dictum, nis..</a>
                                </div>
                                <div class="testimonial-author">
                                    <h4>Nathanael Jaworski</h4>
                                </div>
                            </div>
                            <!-- Testimonial item End -->
                            <!-- Testimonial item Start -->
                            <div class="testimonial-slider-item">
                                <div class="testimonial-image">
                                    <img src="{{ asset('assets/images/testimonial-image/3.png') }}" alt="man-image">
                                </div>
                                <div class="testimonial-content">
                                    <a href="#"> Sed vel urna at dui iaculis gravida. Maecenas pretium, velit vitae
                                        placerat faucibus, velit quam facilisis elit, sit amet lacinia..</a>
                                </div>
                                <div class="testimonial-author">
                                    <h4>Magdalena Valencia</h4>
                                </div>
                            </div>
                            <!-- Testimonial item End -->
                        </div>
                    </div>
                    <!-- Testimonial End -->
                    <!-- Banner Area Start -->
                    <div class="banner-area mtb-60px">
                        <div class="banner-wrapper">
                            <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/4.jpg') }}" alt="" /></a>
                        </div>
                    </div>
                    <!-- Banner Area End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Custom Block Area End -->
    <!-- Category Tab Slider Area Start -->
    <div class="category-tab-slider-area mb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2><span> WHEELS </span>& TIRES</h2>
                        <div class="box-tab ">
                            <ul class="tab-heading tabs-categorys nav nav-tabs">
                                <li>
                                    <a class="active" data-bs-toggle="pill" href="#tab-1">
                                        <span>Wheel Bearings</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="pill" href="#tab-2">
                                        <span>Wheel Rim Screws</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="pill" href="#tab-3">
                                        <span>Wheel Simulators</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="category-tab-block">
                        <div class="category-image">
                            <!-- Banner Area Start -->
                            <div class="banner-area">
                                <div class="banner-wrapper">
                                    <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/5.jpg') }}"
                                            alt="" /></a>
                                </div>
                            </div>
                            <!-- Banner Area End -->
                        </div>
                        <div class="category-tab">
                            <!-- Tab Content Start -->
                            <div class="tab-content">
                                <!-- 1st tab -->
                                <div id="tab-1" class="tab-pane active">
                                    <!-- Tab Slider Start -->
                                    <div class="tab-product-slider-wrappwer">
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Apple</span></a>
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose
                                                                SoundLink Micro Bluetooth Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Canon</span></a>
                                                        <h2><a href="single-product.html" class="product-link">Beats EP
                                                                Wired On-Ear Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£93.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/16.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/16.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose
                                                                SoundLink Micro Bluetooth Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/17.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats
                                                                Solo2 Solo 2 Wired On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Hewlett-Packard</span></a>
                                                        <h2><a href="single-product.html" class="product-link">Beats
                                                                Solo Wireless On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/13.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/13.jpg') }}" alt="" />
                                                        </a>
                                                        <ul class="product-flag">
                                                            <li class="discount">-7%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple
                                                                iPad with Retina Display MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                                <li class="old-price">£75.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/14.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/14.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- Tab Slider End -->
                                </div>
                                <!-- 1st tab -->
                                <!-- 2nd tab -->
                                <div id="tab-2" class="tab-pane fade">
                                    <!-- Tab Slider Start -->
                                    <div class="tab-product-slider-wrappwer">
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Canon</span></a>
                                                        <h2><a href="single-product.html" class="product-link">Beats EP
                                                                Wired On-Ear Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£93.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/16.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/16.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose
                                                                SoundLink Micro Bluetooth Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/17.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats
                                                                Solo2 Solo 2 Wired On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Apple</span></a>
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose
                                                                SoundLink Micro Bluetooth Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Hewlett-Packard</span></a>
                                                        <h2><a href="single-product.html" class="product-link">Beats
                                                                Solo Wireless On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/13.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/13.jpg') }}" alt="" />
                                                        </a>
                                                        <ul class="product-flag">
                                                            <li class="discount">-7%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple
                                                                iPad with Retina Display MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                                <li class="old-price">£75.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/14.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/14.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- Tab Slider End -->
                                </div>
                                <!-- 2nd tab -->
                                <!-- 3rd tab -->
                                <div id="tab-3" class="tab-pane fade">
                                    <!-- Tab Slider Start -->
                                    <div class="tab-product-slider-wrappwer">
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/2.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Apple</span></a>
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/3.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose
                                                                SoundLink Micro Bluetooth Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/8.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/9.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Canon</span></a>
                                                        <h2><a href="single-product.html" class="product-link">Beats EP
                                                                Wired On-Ear Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£93.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/16.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/16.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Bose
                                                                SoundLink Micro Bluetooth Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/17.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Beats
                                                                Solo2 Solo 2 Wired On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/15.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="shop-4-column.html"
                                                            tabindex="0"><span>Hewlett-Packard</span></a>
                                                        <h2><a href="single-product.html" class="product-link">Beats
                                                                Solo Wireless On-Ear Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"> <i
                                                            class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/13.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/13.jpg') }}" alt="" />
                                                        </a>
                                                        <ul class="product-flag">
                                                            <li class="discount">-7%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">Apple
                                                                iPad with Retina Display MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                                <li class="old-price">£75.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="single-product.html" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('assets/images/product-image/14.jpg') }}" alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('assets/images/product-image/14.jpg') }}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="single-product.html" class="product-link">JBL Flip
                                                                3 Splashproof Portable Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart" tabindex="0"><i
                                                            class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- Tab Slider End -->
                                </div>
                                <!-- 3rd tab -->
                            </div>
                            <!-- Tab Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category Tab Slider Area End -->
    <!-- Blog Area Start -->
    <div class="main-blog-area mb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2><span>LATEST </span>BLOGS</h2>
                    </div>
                </div>
            </div>
            <!-- Blog Slider Start -->
            <div class="main-blog-slider-wrapper slider-nav-style-1">
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="blog-grid-left-sidebar.html"><img src="{{ asset('assets/images/blog-image/1.jpg') }}"
                                    alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">06</span>
                                    <span class="month-post">Sep</span>
                                    <span class="year-post">2022</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Buy Used Engines and Used
                                    Transmissions</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>It's no secret, engines and transmissions can be very expensive...</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="blog-grid-left-sidebar.html"><img src="{{ asset('assets/images/blog-image/2.jpg') }}"
                                    alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">30</span>
                                    <span class="month-post">Oct</span>
                                    <span class="year-post">2022</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Get Your Car or Truck
                                    Ready for the Summer Heat!</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>Summer is beautiful in Colorado but we can get some very, very, hot daytime
                                        temps...</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="blog-grid-left-sidebar.html"><img src="{{ asset('assets/images/blog-image/3.jpg') }}"
                                    alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">08</span>
                                    <span class="month-post">Nov</span>
                                    <span class="year-post">2022</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Minor Wreck? We Got The
                                    Auto Parts!</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>It’s winter in Colorado and we’ve had a number of snowy days and hairy
                                        commutes...</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="blog-grid-left-sidebar.html"><img src="{{ asset('assets/images/blog-image/4.jpg') }}"
                                    alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">30</span>
                                    <span class="month-post">Oct</span>
                                    <span class="year-post">2022</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Purchasing New Auto Parts
                                    in our Online Store</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>Central Auto Parts has been a quality provider of used automotive parts in the
                                        Denver...</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="blog-grid-left-sidebar.html"><img src="{{ asset('assets/images/blog-image/5.jpg') }}"
                                    alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">30</span>
                                    <span class="month-post">Oct</span>
                                    <span class="year-post">2022</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">The Life Cycle of Used
                                    Auto Parts and Wrecked Vehicles</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>I am often asked questions about my business when people find out what I do for a
                                        living.</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
            </div>
            <!-- Blog Slider End -->
        </div>
    </div>
    <!-- Blog Area End -->
    <!-- Brand area start -->
    <div class="brand-area mb-60px">
        <div class="container">
            <div class="brand-slider">
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/1.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/2.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/3.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/1.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/4.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/5.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/6.png') }}" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand area end -->
</x-frontend::layouts.master>
@section('js')
@endsection