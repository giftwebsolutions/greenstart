@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;

    // fallback image
    $fallback = asset('uploads/default.jpg');
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

    <section class="blog-detail-hero">
        <div class="container">
            <span class="blog-kicker">{{ $blog->category->name ?? 'Article' }}</span>
            <h1>{{ $blog->title }}</h1>
            <div class="corp-blog-meta">
                <span><i class="fa-regular fa-user"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                <span><i class="fa-regular fa-calendar"></i> {{ optional($blog->published_at)->format('d F, Y') ?? optional($blog->created_at)->format('d F, Y') }}</span>
            </div>
        </div>
    </section>

    <div class="blog-page-wrap single-blog-page">
        <div class="container">
            <div class="row">

                <!-- Content -->
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first mb-md-30px mb-lm-30px">
                    <article class="corp-blog-detail">

                            <div class="corp-blog-detail-media">
                                    @php
                                        $img = $blog->featured_image
                                            ? ImageUploader::getFilePath($blog->featured_image, $blog->created_at)
                                            : $fallback;
                                          
                                    @endphp
                                    <img src="{{ $img }}" alt="{{ $blog->title }}" loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $fallback }}';">
                            </div>

                            <div class="corp-blog-detail-intro">
                                @if (!empty($blog->description))
                                    <p>{{ $blog->description }}</p>
                                @endif
                            </div>

                            <div class="single-post-content corp-blog-content">
                                {!! $blog->content !!}
                            </div>
                    </article>


                    <!-- Related Post -->
                    <div class="blog-related-post corp-related">
                        <div class="pd-section-head">
                            <h2>Related articles</h2>
                            <p>More guidance from Greens Aqua World.</p>
                        </div>

                        <div class="row">
                            @forelse($related as $rel)
                                @php
                                    $relImg = $rel->featured_image
                                        ? ImageUploader::getFilePath($rel->featured_image, $rel->created_at)
                                        : asset('uploads/default.jpg');
                                @endphp
                                <div class="col-md-4 mb-4">
                                    <article class="corp-blog-card compact">
                                        <div class="corp-blog-media">
                                            <a href="{{ route('frontend.blog.show', $rel->slug) }}">
                                                <img src="{{ $relImg }}" alt="{{ $rel->title }}" loading="lazy" />
                                            </a>
                                        </div>
                                        <div class="corp-blog-body">
                                        <h2>
                                            <a href="{{ route('frontend.blog.show', $rel->slug) }}">{{ \Illuminate\Support\Str::limit($rel->title, 55) }}</a>
                                        </h2>
                                        </div>
                                    </article>
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
