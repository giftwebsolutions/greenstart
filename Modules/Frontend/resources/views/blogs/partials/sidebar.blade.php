@php
    // Expected variables:
    // $categories, $recentPosts, $tags
    // optional: $q (search text), $activeCategorySlug
@endphp

<div class="left-sidebar shop-sidebar-wrap">

    {{-- Search --}}
    <div class="sidebar-widget">
        <h3 class="sidebar-title"><span>Search</span></h3>
        <div class="search-widget">
            <form action="{{ route('frontend.blog.search') }}" method="GET">
                <input name="q" value="{{ $q ?? request('q') }}" placeholder="Search entire store here ..." type="text" />
                <button type="submit"><i class="ion-ios-search-strong"></i></button>
            </form>
        </div>
    </div>

    {{-- Categories --}}
    <div class="sidebar-widget mt-40px">
        <h3 class="sidebar-title"><span>Categories</span></h3>
        <div class="category-post">
            <ul>
                @forelse($categories ?? [] as $cat)
                    <li>
                        <a
                            href="{{ route('frontend.blog.category', $cat->slug) }}"
                            class="{{ (($activeCategorySlug ?? null) === $cat->slug) ? 'active' : '' }}"
                        >
                            {{ $cat->name }} ({{ $cat->blogs_count ?? 0 }})
                        </a>
                    </li>
                @empty
                    <li><a href="javascript:void(0)">No Categories</a></li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Recent Posts --}}
    <div class="sidebar-widget mt-40px">
        <h3 class="sidebar-title"><span>Recent Post</span></h3>

        <div class="recent-post-widget">
            @forelse($recentPosts ?? [] as $rp)
                <div class="recent-single-post d-flex">
                    <div class="thumb-side">
                        <a href="{{ route('frontend.blog.show', $rp->slug) }}">
                            <img
                                src="{{ $rp->featured_image ? asset($rp->featured_image) : asset('assets/images/blog-image/1.jpg') }}"
                                alt="{{ $rp->title }}"
                            />
                        </a>
                    </div>
                    <div class="media-side">
                        <h5>
                            <a href="{{ route('frontend.blog.show', $rp->slug) }}">
                                {{ \Illuminate\Support\Str::limit($rp->title, 45) }}
                            </a>
                        </h5>
                        <span class="date">
                            {{ optional($rp->published_at)->format('M d, Y') ?? optional($rp->created_at)->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-muted">No recent posts.</div>
            @endforelse
        </div>
    </div>

    {{-- Tags --}}
    <div class="sidebar-widget mt-40px">
        <h3 class="sidebar-title"><span>Tags</span></h3>

        <div class="sidebar-widget-tag">
            <ul>
                @forelse($tags ?? [] as $tag)
                    <li><a href="{{ route('frontend.blog.search', ['q' => $tag]) }}">{{ $tag }}</a></li>
                @empty
                    <li><a href="javascript:void(0)">No Tags</a></li>
                @endforelse
            </ul>
        </div>
    </div>

</div>
