@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp



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
                            <img src="{{ asset('assets/images/icons/static-icons-1.png') }}" alt=""
                                class="img-responsive" />
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
                            <img src="{{ asset('assets/images/icons/static-icons-2.png') }}" alt=""
                                class="img-responsive" />
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
                            <img src="{{ asset('assets/images/icons/static-icons-3.png') }}" alt=""
                                class="img-responsive" />
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
                            <img src="{{ asset('assets/images/icons/static-icons-4.png') }}" alt=""
                                class="img-responsive" />
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
    <x-frontend::new-arrivals />
    <!-- Arrivel Area End -->
    <!-- Banner Area Start -->
    <div class="banner-area mtb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-lm-30px">
                    <div class="banner-wrapper">
                        <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/1.jpg') }}"
                                alt="" /></a>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="banner-wrapper">
                        <a href="shop-4-column.html"><img src="{{ asset('assets/images/banner-image/2.jpg') }}"
                                alt="" /></a>
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
                <div class="col-lg-12 col-md-12 mb-md-60px">
                    <div class="hot-deal-area">
                        <div class="section-title">
                            <h2><span>THIS WEEK’S</span> HOT DEALS</h2>
                        </div>

                    </div>
                    <!-- Banner Area Start -->
                    <div class="testimonial-slider-wrapper">

                        @forelse ($testimonials as $testimonial)
                            @php
                                $imageUrl = $testimonial->image
                                    ? ImageUploader::getFilePath(
                                        $testimonial->image,
                                        $testimonial->created_at,
                                        'thumbnail',
                                    )
                                    : asset('assets/images/testimonial-image/default.png');
                            @endphp

                            <div class="testimonial-slider-item text-center">

                                <div class="testimonial-image">
                                    <img src="{{ $imageUrl }}" alt="{{ $testimonial->name }}"
                                        class="testimonial-avatar">
                                </div>

                                <div class="testimonial-content">
                                    <p>
                                        {{ \Illuminate\Support\Str::limit(strip_tags($testimonial->content), 140) }}
                                    </p>
                                </div>

                                <div class="testimonial-author">
                                    <h4>{{ $testimonial->name }}</h4>
                                </div>

                            </div>

                        @empty
                            <p class="text-center">No testimonials available.</p>
                        @endforelse

                    </div>
                    <!-- Banner Area End -->

                </div>
            </div>
        </div>
    </div>
    <!-- Custom Block Area End -->
    <!-- Category Tab Slider Area Start -->
    <x-frontend::category-tab-slider />
    <!-- Category Tab Slider Area End -->
    <x-frontend::home-blog />

    <!-- Brand area start -->
    <div class="brand-area mb-60px">
        <div class="container">
            <div class="brand-slider">
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/1.png') }}"
                            alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive" src="{{ asset('assets/images/brand-logo/2.png') }}"
                            alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive"
                            src="{{ asset('assets/images/brand-logo/3.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive"
                            src="{{ asset('assets/images/brand-logo/1.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive"
                            src="{{ asset('assets/images/brand-logo/4.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive"
                            src="{{ asset('assets/images/brand-logo/5.png') }}" alt="" /></a>
                </div>
                <div class="brand-slider-item">
                    <a href="#"><img class=" img-responsive"
                            src="{{ asset('assets/images/brand-logo/6.png') }}" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand area end -->
</x-frontend::layouts.master>
@section('js')
@endsection
