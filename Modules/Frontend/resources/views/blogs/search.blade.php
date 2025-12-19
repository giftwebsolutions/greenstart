@section('css')
@endsection

<x-frontend::layouts.master>
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><a href="{{ route('frontend.blog.index') }}">Blog</a></li>
                            <li>Search</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="shop-category-area blog-grid mb-60px main-blog-page">
        <div class="container">
            <div class="row">

                <!-- Main Content -->
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                    {{-- Search title --}}
                    <div class="mb-30px">
                        <h3 class="mb-10px">
                            Search Result:
                            <span class="text-muted">"{{ $q ?? request('q') }}"</span>
                        </h3>
                        @if($blogs instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="text-muted">
                                {{ $blogs->total() }} result(s) found
                            </div>
                        @endif
                    </div>

                    <div class="blog-posts">
                        <div class="row">

                            @forelse($blogs as $blog)
                                <div class="col-md-6 mb-res-sm-30px">
                                    <div class="single-blog-post mb-30px blog-grid-post">
                                        <div class="blog-post-media">
                                            <div class="blog-image">
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                    <img
                                                        src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('assets/images/blog-image/1.jpg') }}"
                                                        alt="{{ $blog->title }}"
                                                        class="img-responsive"
                                                    />
                                                </a>
                                            </div>
                                        </div>

                                        <div class="blog-post-content-inner mt-30px">
                                            <h4 class="blog-title">
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                            </h4>

                                            <ul class="blog-page-meta">
                                                <li><a href="#"><i class="ion-person"></i> {{ $blog->author->name ?? 'Admin' }}</a></li>
                                                <li>
                                                    <a href="#"><i class="ion-calendar"></i>
                                                        {{ optional($blog->published_at)->format('d M, Y') ?? optional($blog->created_at)->format('d M, Y') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->content), 160) }}</p>

                                            <a class="read-more-btn" href="{{ route('frontend.blog.show', $blog->slug) }}">
                                                Read More <i class="ion-android-arrow-dropright-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0">
                                        No results found for "{{ $q ?? request('q') }}".
                                    </div>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($blogs instanceof \Illuminate\Pagination\LengthAwarePaginator && $blogs->hasPages())
                        <div class="pro-pagination-style blog-pagination text-center mb-md-30px mb-lm-30px">
                            <div class="pages">
                                {!! $blogs->links() !!}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-res-md-60px mb-res-sm-60px">
                    @include('frontend::blogs.partials.sidebar', [
                        'categories' => $categories ?? [],
                        'recentPosts' => $recentPosts ?? [],
                        'tags' => $tags ?? [],
                        'q' => $q ?? request('q'),
                        'activeCategorySlug' => $activeCategorySlug ?? null,
                    ])
                </div>

            </div>
        </div>
    </div>
</x-frontend::layouts.master>

@section('js')
@endsection
