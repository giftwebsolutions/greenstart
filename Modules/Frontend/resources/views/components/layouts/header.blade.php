<?php
$menus = Config::get('frontend.menus');
$settings = Config::get('site-settings');
//dd($menus);
?>    
    <!-- Header Section Start From Here -->
    <header class="header-wrapper">
        <!-- Header Nav Start -->
        <div class="header-nav bg-black d-none d-md-block">
            <div class="container">
                <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between">
                    <div class="header-static-nav d-flex">
                        <p>WELCOME TO GREENSTART ONLINE SHOPPING STORE !</p>
                        <div class="social-top">
                            <div class="follow d-flex">
                                <label>Follow Us:</label>
                                <ul class="link-follow">
                                    <li><a class="facebook ion-social-facebook" title="Facebook" href="#"></a></li>
                                    <li><a class="twitter ion-social-twitter" title="Twitter" href="#"></a></li>
                                    <li><a class="google ion-social-googleplus-outline" title="Google"
                                            href="#"></a>
                                    </li>
                                    <li><a class="youtube ion-social-youtube" title="Youtube" href="#"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Mobile Header Nav Start -->

        <div class="header-nav header-nav-mobile bg-black d-md-none">
            <div class="container">
                <div class="header-nav-wrapper ">
                    <div class="header-static-nav f-none text-center">
                        <p>WELCOME TO GREENSTART ONLINE SHOPPING STORE !</p>
                    </div>
                    <div class="header-menu-nav d-flex justify-content-between">
                        <div class="social-top align-self-center">
                            <div class="follow d-flex">
                                <label>Follow Us:</label>
                                <ul class="link-follow">
                                    <li><a class="facebook ion-social-facebook" title="Facebook" href="#"></a>
                                    </li>
                                    <li><a class="twitter ion-social-twitter" title="Twitter" href="#"></a></li>
                                    <li><a class="google ion-social-googleplus-outline" title="Google"
                                            href="#"></a>
                                    </li>
                                    <li><a class="youtube ion-social-youtube" title="Youtube" href="#"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mobile-menu-nav">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Header Nav End -->
        <!-- Header Nav End -->
       <div class="header-top bg-white ptb-30px d-lg-block d-none">
    <div class="container">
        <div class="row">
            <div class="col-md-3 d-flex">
                <div class="align-self-center">
                    <a href="{{ route('frontend.home') }}">
                        <img class="img-responsive logo"
                             src="{{ asset('assets/images/logo/logo.png') }}"
                             alt="{{ env('APP_NAME') }}" />
                    </a>
                </div>
            </div>

            <div class="col-md-9 align-self-center">
                <div class="header-right-element d-flex justify-content-between">

                    <!-- Updated Search Form -->
                    <div class="search-element media-body me-20px">
                        <form class="d-flex" method="GET" action="{{ route('frontend.shop.search') }}">
                            <input 
                                type="text" 
                                name="q"
                                class="form-control"
                                value="{{ $q ?? request('q') }}"
                                placeholder="Search entire store here ..."
                            />
                            <button class="btn btn-primary" type="submit">
                                <i class="icon-search"></i>
                            </button>
                        </form>
                    </div>

                    <!--Cart info Start-->
                    <!-- Your cart code here -->
                    <!--Cart info End-->

                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Header Nav End -->
        <div class="header-menu bg-red sticky-nav d-lg-block d-none padding-0px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="header-menu-vertical">
                            <h4 class="menu-title">Browse Categories </h4>
                             <x-frontend::category-menu />
                            <!-- menu content -->
                        </div>
                        <!-- header menu vertical -->
                    </div>
                    <div class="col-lg-9">
                        <div class="header-horizontal-menu">
                            <ul class="menu-content">
                                  @include('frontend::components.menu-recursive', ['items' => $menus])
                            </ul>
                        </div>
                        <div class="contact-link">
                            <a href="tel:{{$settings['mobile']}}">{{$settings['mobile']}}</a>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- header menu -->
    </header>
    <!-- Header Section End Here -->

    <!-- Mobile Header Section Start -->
    <div class="mobile-header d-lg-none sticky-nav white-bg ptb-20px">
        <div class="container">
            <div class="row align-items-center">

                <!-- Header Logo Start -->
                <div class="col d-flex">
                    <div class="mobile-menu-toggle home-2">
                        <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                            <svg viewBox="0 0 800 600">
                                <path
                                    d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                    id="top"></path>
                                <path d="M300,320 L540,320" id="middle"></path>
                                <path
                                    d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                    id="bottom"
                                    transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <div class="header-logo  mt-7px">
                      <a href="{{ route('frontend.home') }}"><img class="img-responsive logo"
                                    src="{{asset('assets/images/logo/logo.png')}}" alt="{{ env('APP_NAME') }}" /></a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Header Tools Start -->
               
                <!-- Header Tools End -->

            </div>
        </div>
    </div>

    <!-- Search Category Start -->
    <div class="mobile-search-area d-lg-none mb-15px">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="search-element media-body">
                    <form method="GET" action="{{ route('frontend.shop.search') }}" class="d-flex">
                        <input 
                            type="text" 
                            name="q"
                            class="form-control"
                            value="{{ $q ?? request('q') }}"
                            placeholder="Search products..."
                        />
                        <button class="btn btn-primary" type="submit">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Search Category End -->
   <div class="mobile-category-nav d-lg-none mb-15px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--=======  category menu  =======-->
                <div class="hero-side-category">

                    <!-- Category Toggle Wrap -->
                    <div class="category-toggle-wrap">
                        <button class="category-toggle">
                            <i class="fa fa-bars"></i> All Categories
                        </button>
                    </div>

                    <!-- Dynamic Category Menu -->
                    <nav class="category-menu">
                        <x-frontend::category-menu />
                    </nav>

                </div>
                <!--=======  End of category menu =======-->

            </div>
        </div>
    </div>
</div>


    <!-- Mobile Header Section End -->
    <!-- OffCanvas Wishlist Start -->
    <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
        <div class="inner">
            <div class="head">
                <span class="title">Wishlist</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list">
                    <li>
                        <a href="single-product.html" class="image"><img src="assets/images/product-image/1.jpg"
                                alt="Cart product Image"></a>
                        <div class="content">
                            <a href="single-product.html" class="title">Walnut Cutting Board</a>
                            <span class="quantity-price">1 x <span class="amount">£91.86</span></span>
                            <a href="#" class="remove">×</a>
                        </div>
                    </li>
                    <li>
                        <a href="single-product.html" class="image"><img src="assets/images/product-image/2.jpg"
                                alt="Cart product Image"></a>
                        <div class="content">
                            <a href="single-product.html" class="title">Lucky Wooden Elephant</a>
                            <span class="quantity-price">1 x <span class="amount">£453.28</span></span>
                            <a href="#" class="remove">×</a>
                        </div>
                    </li>
                    <li>
                        <a href="single-product.html" class="image"><img src="assets/images/product-image/3.jpg"
                                alt="Cart product Image"></a>
                        <div class="content">
                            <a href="single-product.html" class="title">Fish Cut Out Set</a>
                            <span class="quantity-price">1 x <span class="amount">£87.34</span></span>
                            <a href="#" class="remove">×</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="foot">
                <div class="buttons">
                    <a href="wishlist.html" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
                </div>
            </div>
        </div>
    </div>
    <!-- OffCanvas Wishlist End -->

    <!-- OffCanvas Cart Start -->
    <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
        <div class="inner">
            <div class="head">
                <span class="title">Cart</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list">
                    <li>
                        <a href="single-product.html" class="image"><img src="assets/images/product-image/1.jpg"
                                alt="Cart product Image"></a>
                        <div class="content">
                            <a href="single-product.html" class="title">Walnut Cutting Board</a>
                            <span class="quantity-price">1 x <span class="amount">£91.86</span></span>
                            <a href="#" class="remove">×</a>
                        </div>
                    </li>
                    <li>
                        <a href="single-product.html" class="image"><img src="assets/images/product-image/2.jpg"
                                alt="Cart product Image"></a>
                        <div class="content">
                            <a href="single-product.html" class="title">Lucky Wooden Elephant</a>
                            <span class="quantity-price">1 x <span class="amount">£453.28</span></span>
                            <a href="#" class="remove">×</a>
                        </div>
                    </li>
                    <li>
                        <a href="single-product.html" class="image"><img src="assets/images/product-image/3.jpg"
                                alt="Cart product Image"></a>
                        <div class="content">
                            <a href="single-product.html" class="title">Fish Cut Out Set</a>
                            <span class="quantity-price">1 x <span class="amount">£87.34</span></span>
                            <a href="#" class="remove">×</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="foot">
                <div class="sub-total">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-left">Sub-Total :</td>
                                <td class="text-right">£523.30</td>
                            </tr>
                            <tr>
                                <td class="text-left">Eco Tax (-2.00) :</td>
                                <td class="text-right">£4.52</td>
                            </tr>
                            <tr>
                                <td class="text-left">VAT (20%) :</td>
                                <td class="text-right">£104.66</td>
                            </tr>
                            <tr>
                                <td class="text-left">Total :</td>
                                <td class="text-right theme-color">£632.48</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="buttons">
                    <a href="cart.html" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
                    <a href="checkout.html" class="btn btn-outline-dark current-btn">checkout</a>
                </div>
                <p class="minicart-message">Free Shipping on All Orders Over $100!</p>
            </div>
        </div>
    </div>
    <!-- OffCanvas Cart End -->

    <!-- OffCanvas Search Start -->
   <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner customScroll">

        <!-- Header -->
        <div class="head d-flex justify-content-between align-items-center">
            <span class="title">&nbsp;</span>
            <button class="offcanvas-close">×</button>
        </div>

        <!-- Search -->
        <div class="offcanvas-menu-search-form">
            <form method="GET" action="{{ route('frontend.shop.search') }}">
                <input 
                    type="text" 
                    name="q"
                    value="{{ $q ?? request('q') }}"
                    placeholder="Search products..."
                >
                <button type="submit"><i class="lnr lnr-magnifier"></i></button>
            </form>
        </div>

     

        <!-- Dynamic Menu (Matches Desktop Menu) -->
        <div class="offcanvas-menu">
            <ul class="menu-content">
                @include('frontend::components.menu-recursive', ['items' => $menus])
            </ul>
        </div>

        <!-- Social Icons -->
        <div class="offcanvas-social mt-30px">
            <ul>
                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                <li><a href="#"><i class="ion-social-google"></i></a></li>
                <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                <li><a href="#"><i class="ion-social-instagram"></i></a></li>
            </ul>
        </div>

    </div>
</div>

<!-- Mobile Contact -->
<div class="contact-link d-lg-none">
    <a href="tel:{{ $settings['mobile'] }}">{{ $settings['mobile'] }}</a>
</div>

    <div class="offcanvas-overlay"></div>
