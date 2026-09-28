@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Illuminate\Support\Str;

    // fallback image if blog image is empty
    $fallback = asset('uploads/default.jpg');

    // title split (LATEST + BLOGS) like your HTML
    $titleParts = explode(' ', trim($title ?? ''), 2);
    $titleFirst = $titleParts[0] ?? 'LATEST';
    $titleRest  = $titleParts[1] ?? 'BLOGS';
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
                            <li>Blog</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <section class="blog-hero">
        <div class="container">
            <span class="blog-kicker">Insights & updates</span>
            <h1>Water purifier articles</h1>
            <p>Guides, service tips, and product knowledge for home and business water purification.</p>
        </div>
    </section>

    <!-- Blog Grid Area Start -->
    <div class="blog-page-wrap">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                    <div class="blog-posts blog-card-grid">
                        <div class="row">

                            @forelse($blogs as $blog)
                                @php
                                    // Generate blog image using ImageUploader
                                    $img = $blog->featured_image
                                        ? ImageUploader::getFilePath($blog->featured_image, $blog->created_at, 'thumbnail')
                                        : $fallback;

                                    // Author name
                                    $authorName = $blog->author->name ?? 'Admin';

                                    // Published date
                                    $publishedAt = $blog->published_at ?? $blog->created_at;

                                    // Blog excerpt
                                    $excerpt = Str::limit(strip_tags($blog->description ?? $blog->content ?? ''), 160);
                                @endphp

                                <div class="col-lg-4 col-md-6 mb-4">
                                    <article class="corp-blog-card">
                                        <div class="corp-blog-media">
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                    <img src="{{ $img }}" alt="{{ $blog->title }}" loading="lazy"
                                                        onerror="this.onerror=null;this.src='{{ $fallback }}';">
                                                </a>
                                        </div>

                                        <div class="corp-blog-body">
                                            <div class="corp-blog-meta">
                                                <span><i class="fa-regular fa-user"></i> {{ $authorName }}</span>
                                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($publishedAt)->format('d M Y') }}</span>
                                            </div>

                                            <h2>
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                    {{ $blog->title }}
                                                </a>
                                            </h2>

                                            <p>{{ $excerpt }}</p>

                                            <a class="corp-blog-link" href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                Read article <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0">
                                        No blog posts found.
                                    </div>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- Pagination Area Start -->
                    @if ($blogs instanceof \Illuminate\Pagination\LengthAwarePaginator && $blogs->hasPages())
                        <div class="pro-pagination-style blog-pagination text-center mb-md-30px mb-lm-30px">
                            <div class="pages">
                                {!! $blogs->links() !!}
                            </div>
                        </div>
                    @endif
                    <!-- Pagination Area End -->
                </div>

                <!-- Sidebar Area Start -->
                <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-res-md-60px mb-res-sm-60px">
                    @include('frontend::blogs.partials.sidebar', [
                        'categories' => $categories ?? [],
                        'recentPosts' => $recentPosts ?? [],
                        'tags' => $tags ?? [],
                        'q' => request('q'),
                        'activeCategorySlug' => null,
                    ])
                </div>
                <!-- Sidebar Area End -->
            </div>
        </div>
    </div>
    <!-- Blog Grid Area End -->
</x-frontend::layouts.master>

@section('js')
@endsection
