@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    // Expected variables:
    // $categories, $recentPosts, $tags
    // optional: $q (search text), $activeCategorySlug
@endphp

<aside class="corp-blog-sidebar">

    {{-- Search --}}
    <div class="corp-side-card">
        <h3>Search</h3>
        <div class="corp-search-widget">
            <form action="{{ route('frontend.blog.search') }}" method="GET">
                <input name="q" value="{{ $q ?? request('q') }}" placeholder="Search articles..." type="text" />
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>

    {{-- Categories --}}
    <div class="corp-side-card">
        <h3>Categories</h3>
        <div class="corp-category-list">
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
    <div class="corp-side-card">
        <h3>Recent posts</h3>

        <div class="corp-recent-posts">
            @forelse($recentPosts ?? [] as $rp)
                <div class="recent-single-post d-flex">
                    <div class="thumb-side">
                        <a href="{{ route('frontend.blog.show', $rp->slug) }}">
                            <img
                                src="{{ $rp->featured_image ? ImageUploader::getFilePath($rp->featured_image, $rp->created_at, 'thumbnail') : asset('assets/images/blog-image/1.jpg') }}"
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
    <div class="corp-side-card">
        <h3>Tags</h3>

        <div class="corp-tag-list">
            <ul>
                @forelse($tags ?? [] as $tag)
                    <li><a href="{{ route('frontend.blog.search', ['q' => $tag]) }}">{{ $tag }}</a></li>
                @empty
                    <li><a href="javascript:void(0)">No Tags</a></li>
                @endforelse
            </ul>
        </div>
    </div>

</aside>
