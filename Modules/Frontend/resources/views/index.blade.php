@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Modules\SysAdmin\Models\Blocks;
    $myTabs = [['category_id' => 7, 'label' => 'Handle'], ['category_id' => 8, 'label' => 'Hinges']];
    $home_blocks = ['home-free-shipping', 'home-support'];
    $homeBlocks = Blocks::whereIn('key', $home_blocks)->get()->toArray();
@endphp
<x-frontend::layouts.master>
    <!-- Slider Start -->
    <div class="slider-area">
        <div class="hero-slider-wrapper">
            <!-- Single Slider  -->
             @foreach ($sliderdata as $slider)
                <div class="single-slide slider-height-1 bg-img d-flex"
                    data-bg-image=" {{ ImageUploader::getFilePath($slider['file'], $slider['created_at']) }}">
                </div>
             @endforeach
        </div>
    </div>
    <!-- Slider End -->
    <!-- Static Area Start -->
    <div class="static-area mtb-60px">
        <div class="container">
            <div class="static-area-wrap">
                <div class="row">
                    @php
                        $freeShipping = collect($homeBlocks)->firstWhere('key', 'home-free-shipping');
                    @endphp
                    <!-- Static Single Item Start -->
                    @if(!empty($freeShipping))
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img src="{{ asset(ImageUploader::getFilePath($freeShipping['thumbnail'], $freeShipping['created_at'])) }}"
                                alt="{{ $freeShipping['title'] }}" class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>{{ $freeShipping['title'] }}</h4>
                                <p>{!! $freeShipping['value'] !!}</p>
                            </div>
                        </div>
                    </div>
                    @endif
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
        :banner="asset('assets/images/icons/static-icons-1.png')" :tabs-config="$myTabs" :limit="8" />
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
