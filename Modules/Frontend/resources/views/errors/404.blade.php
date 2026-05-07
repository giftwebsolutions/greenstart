@section('css')
@endsection

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li>404</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

    <!-- 404 Content Area -->
    <section class="about-area mb-60px">
        <div class="container">
            <div class="container-inner">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">

                        <div class="about-content">
                            <div class="about-title">
                                <h2>404 – Page Not Found</h2>
                            </div>

                            <p class="mb-30px">
                                Sorry, the page you are looking for does not exist or has been moved.
                            </p>

                            <a href="{{ route('frontend.home') }}" class="btn btn-primary">
                                <i class="ion-ios-home"></i> Go to Home
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-frontend::layouts.master>

@section('js')
@endsection
