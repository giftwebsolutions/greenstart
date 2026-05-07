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

                            @if($page->parent)
                                <li>
                                    <a href="{{ route('cms.view', $page->parent->slug) }}">
                                        {{ $page->parent->name }}
                                    </a>
                                </li>
                            @endif

                            <li>{{ $page->title ?? $page->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

    <!-- CMS Page Area Start -->
    <section class="about-area mb-60px">
        <div class="container">
            <div class="container-inner">

                {{-- Main Content --}}
                <div class="row">

                    {{-- Left Image (Banner / Featured Image) --}}
                    @if(!empty($page->banner) || !empty($page->featured_image))
                        <div class="col-lg-6">
                            <div class="about-left-image mb-md-30px mb-lm-30px">
                                <img
                                    src="{{ asset($page->banner ?? $page->featured_image) }}"
                                    alt="{{ $page->title ?? $page->name }}"
                                    class="img-responsive"
                                />
                            </div>
                        </div>
                    @endif

                    {{-- Right Content --}}
                    <div class="{{ (!empty($page->banner) || !empty($page->featured_image)) ? 'col-lg-6' : 'col-lg-12' }}">
                        <div class="about-content">
                            <div class="about-title">
                                <h2>{{ $page->title ?? $page->name }}</h2>
                            </div>

                            {{-- Page Description --}}
                            @if(!empty($page->description))
                                <p class="mb-30px">
                                    {{ $page->description }}
                                </p>
                            @endif

                            {{-- Page Content (HTML from CMS) --}}
                            <div class="cms-content">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Optional Children Pages Section --}}
                @if(!empty($children) && count($children))
                    <div class="row mt-50px">
                        @foreach($children as $child)
                            <div class="col-md-4 mb-lm-30px">
                                <div class="single-about">
                                    <h4>{{ $child->name }}</h4>
                                    <p>
                                        {{ \Illuminate\Support\Str::limit(strip_tags($child->description ?? $child->content), 140) }}
                                    </p>
                                    <a href="{{ route('cms.view', $child->slug) }}" class="read-more-btn">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!-- CMS Page Area End -->

</x-frontend::layouts.master>

@section('js')
@endsection
