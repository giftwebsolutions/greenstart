@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Modules\SysAdmin\Models\Blocks;
    // Featured = products pulled from these first-level categories (set to your real category IDs)
    $myTabs = \Modules\SysAdmin\Models\ProductCategory::where('parent_id', 0)
        ->orderBy('id')->limit(3)->pluck('id')
        ->map(fn ($id) => ['category_id' => $id])->all();
    $home_blocks = ['home-free-shipping', 'home-support'];
    $homeBlocks = Blocks::whereIn('key', $home_blocks)->get()->toArray();
@endphp
<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <!-- Slider Start -->
    <div class="slider-area">
        <div class="hero-slider-wrapper">
            <!-- Single Slider  -->
             @forelse ($sliderdata as $slider)
                <div class="single-slide slider-height-1 bg-img d-flex"
                    data-bg-image=" {{ ImageUploader::getFilePath($slider['file'], $slider['created_at']) }}">
                    <div class="container hero-copy">
                        <div class="hero-copy-inner">
                            <span class="hero-kicker">Aqua water purification systems</span>
                            <h1>Pure water solutions for homes and businesses</h1>
                            <p>Explore domestic RO, industrial RO, filters, spares, and service support from Greens Aqua World.</p>
                            <div class="hero-actions">
                                <a href="{{ route('frontend.shop.index') }}" class="hero-btn hero-btn-primary">Shop Products</a>
                                <a href="{{ route('frontend.enquiry') }}" class="hero-btn hero-btn-secondary">Request Enquiry</a>
                            </div>
                        </div>
                    </div>
                </div>
             @empty
                <div class="single-slide slider-height-1 d-flex hero-fallback">
                    <div class="container hero-copy">
                        <div class="hero-copy-inner">
                            <span class="hero-kicker">Aqua water purification systems</span>
                            <h1>Pure water solutions for homes and businesses</h1>
                            <p>Explore domestic RO, industrial RO, filters, spares, and service support from Greens Aqua World.</p>
                            <div class="hero-actions">
                                <a href="{{ route('frontend.shop.index') }}" class="hero-btn hero-btn-primary">Shop Products</a>
                                <a href="{{ route('frontend.enquiry') }}" class="hero-btn hero-btn-secondary">Request Enquiry</a>
                            </div>
                        </div>
                    </div>
                </div>
             @endforelse
        </div>
    </div>
    <!-- Slider End -->
    <!-- Static Area Start -->
    <div class="static-area">
        <div class="container">
            <div class="ga-usp-grid">
                <div class="ga-usp-card">
                    <span class="ga-usp-icon"><i class="fa-solid fa-award"></i></span>
                    <div class="ga-usp-text">
                        <h4>Quality Product</h4>
                        <p>Certified RO systems &amp; genuine parts</p>
                    </div>
                </div>
                <div class="ga-usp-card">
                    <span class="ga-usp-icon"><i class="fa-solid fa-headset"></i></span>
                    <div class="ga-usp-text">
                        <h4>On-Time Support</h4>
                        <p>Fast, reliable service every day</p>
                    </div>
                </div>
                <div class="ga-usp-card">
                    <span class="ga-usp-icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                    <div class="ga-usp-text">
                        <h4>Free Installation</h4>
                        <p>Expert setup at your doorstep</p>
                    </div>
                </div>
                <div class="ga-usp-card">
                    <span class="ga-usp-icon"><i class="fa-solid fa-droplet"></i></span>
                    <div class="ga-usp-text">
                        <h4>Make Pure Water</h4>
                        <p>Safe &amp; healthy drinking water</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Area End -->

    {{-- Popular first-level categories (horizontal scroll on mobile) --}}
    <x-frontend::popular-categories />

    {{-- Why choose us --}}
    <section class="ga-why-area">
        <div class="container">
            <div class="section-title"><h2><span>Why</span> Choose Us</h2></div>
            <div class="ga-why-grid">
                <div class="ga-why-card">
                    <span class="ga-why-icon"><i class="fa-solid fa-certificate"></i></span>
                    <h4>Certified Quality</h4>
                    <p>Genuine, tested purification systems and spares you can trust.</p>
                </div>
                <div class="ga-why-card">
                    <span class="ga-why-icon"><i class="fa-solid fa-truck-fast"></i></span>
                    <h4>Quick Installation</h4>
                    <p>Free, professional installation at your home or business.</p>
                </div>
                <div class="ga-why-card">
                    <span class="ga-why-icon"><i class="fa-solid fa-user-gear"></i></span>
                    <h4>Expert Service</h4>
                    <p>Trained technicians and dependable after-sales support.</p>
                </div>
                <div class="ga-why-card">
                    <span class="ga-why-icon"><i class="fa-solid fa-hand-holding-droplet"></i></span>
                    <h4>Healthy Water</h4>
                    <p>Safe, great-tasting drinking water for your whole family.</p>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($about))
        <section class="about-area mb-60px">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                
                        {{-- Image --}}
                        <div class="col-lg-6">
                            <div class="about-left-image mb-md-30px mb-lm-30px">
                                @php
                                    $aboutImage = ImageUploader::getFilePath(
                                        $about['image'] ?? '',
                                        $about['created_at'] ?? null,
                                        'thumbnail',
                                    );
                                @endphp

                                @if (!empty($aboutImage))
                                    <img src="{{ $aboutImage }}" alt="{{ $about['title'] ?? 'About Image' }}"
                                        class="img-responsive">
                                @endif
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="col-lg-6">
                            <div class="about-content">
                                @if (!empty($about['title']))
                                    <div class="about-title">
                                        <h2>{{ $about['title'] }}</h2>
                                    </div>
                                @endif

                                @if (!empty($about['content']))
                                    <p class="mb-30px">
                                        {!! nl2br(e($about['content'])) !!}
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Arrivel Area Start -->
    <x-frontend::new-arrivals />
    <!-- Arrivel Area End -->
    <!-- Banner Area Start -->
    {{-- <div class="banner-area mtb-60px">
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
    </div> --}}
    <!-- Banner Area End -->

    <!-- Category Tab Slider Area Start -->
    <x-frontend::category-tab-slider title="Featured Products" sub-title="Best quality parts for your vehicle"
        :tabs-config="$myTabs" :limit="8" />
    <!-- Category Tab Slider Area End -->
    <x-frontend::home-blog />

    <!-- Brand area start -->
    <div class="brand-area mb-20px">
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

    <x-frontend::testimonials :limit='6' />
    <!-- Brand area end -->
</x-frontend::layouts.master>
@section('js')
@endsection
