@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;

    // fallback image
    $fallback = asset('assets/images/blog-image/3.jpg');
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li>{{ $blog->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="shop-category-area single-blog-page mb-60px main-blog-page">
        <div class="container">
            <div class="row">

                <!-- Content -->
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first mb-md-30px mb-lm-30px">
                    <div class="blog-posts">
                        <div class="single-blog-post blog-grid-post">

                            <div class="blog-post-media">
                                <div class="blog-image single-blog">
                                    @php
                                        $img = $blog->featured_image
                                            ? ImageUploader::getFilePath($blog->featured_image, $blog->created_at)
                                            : $fallback;
                                          
                                    @endphp
                                    <img src="{{ $img }}" alt="{{ $blog->title }}" />
                                </div>
                            </div>

                            <div class="blog-post-content-inner mt-30px">
                                <h4 class="blog-title">
                                    <a href="{{ route('frontend.blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h4>

                                <ul class="blog-page-meta">
                                    <li><a href="#"><i class="ion-person"></i> {{ $blog->author->name ?? 'Admin' }}</a></li>
                                    <li><a href="#"><i class="ion-calendar"></i> {{ optional($blog->published_at)->format('d F, Y') ?? optional($blog->created_at)->format('d F, Y') }}</a></li>
                                    @if (!empty($blog->category))
                                        <li><a href="{{ route('frontend.blog.category', $blog->category->slug) }}"><i class="ion-ios-folder"></i> {{ $blog->category->name }}</a></li>
                                    @endif
                                </ul>

                                @if (!empty($blog->description))
                                    <p>{{ $blog->description }}</p>
                                @endif
                            </div>

                            <div class="single-post-content">
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>


                    <!-- Related Post -->
                    <div class="blog-related-post">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="section-title underline-shape">
                                    <h2>Related Post</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @forelse($related as $rel)
                                @php
                                    $relImg = $rel->featured_image
                                        ? ImageUploader::getFilePath($rel->featured_image, $rel->created_at)
                                        : asset('assets/images/blog-image/1.jpg');
                                @endphp
                                <div class="col-md-4 mb-lm-30px">
                                    <div class="blog-post-media">
                                        <div class="blog-image single-blog">
                                            <a href="{{ route('frontend.blog.show', $rel->slug) }}">
                                                <img class="img-responsive" src="{{ $relImg }}" alt="{{ $rel->title }}" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="blog-post-content-inner mt-30px">
                                        <h4 class="blog-title">
                                            <a href="{{ route('frontend.blog.show', $rel->slug) }}">{{ \Illuminate\Support\Str::limit($rel->title, 55) }}</a>
                                        </h4>

                                        <ul class="blog-page-meta">
                                            <li><a href="#"><i class="ion-person"></i> {{ $rel->author->name ?? 'Admin' }}</a></li>
                                            <li><a href="#"><i class="ion-calendar"></i> {{ optional($rel->published_at)->format('d M, Y') ?? optional($rel->created_at)->format('d M, Y') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">No related posts found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-res-md-60px mb-res-sm-60px">
                    @include('frontend::blogs.partials.sidebar', [
                        'categories' => $categories ?? [],
                        'recentPosts' => $recentPosts ?? [],
                        'tags' => $tags ?? [],
                        'q' => request('q'),
                        'activeCategorySlug' => optional($blog->category)->slug,
                    ])
                </div>
                <!-- Sidebar End -->

            </div>
        </div>
    </div>
</x-frontend::layouts.master>

@section('js')
@endsection
