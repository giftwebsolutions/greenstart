@section('css')
@endsection

@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Illuminate\Support\Str;

    // fallback image if blog image is empty
    $fallback = asset('assets/images/blog-image/1.jpg');

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

    <!-- Blog Grid Area Start -->
    <div class="shop-category-area blog-grid mb-60px main-blog-page">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                    <div class="blog-posts">
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

                                <div class="col-md-4 mb-res-sm-30px">
                                    <div class="single-blog-post mb-30px blog-grid-post">
                                        <div class="blog-post-media">
                                            <div class="blog-image">
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                    <img src="{{ $img }}" alt="{{ $blog->title }}" class="img-responsive" />
                                                </a>
                                            </div>
                                        </div>

                                        <div class="blog-post-content-inner mt-30px">
                                            <h4 class="blog-title">
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                    {{ $blog->title }}
                                                </a>
                                            </h4>

                                            <ul class="blog-page-meta">
                                                <li>
                                                    <a href="#">
                                                        <i class="ion-person"></i>
                                                        {{ $authorName }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="ion-calendar"></i>
                                                        {{ \Carbon\Carbon::parse($publishedAt)->format('d M, Y') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <p>{{ $excerpt }}</p>

                                            <a class="read-more-btn" href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                Read More <i class="ion-android-arrow-dropright-circle"></i>
                                            </a>
                                        </div>
                                    </div>
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
