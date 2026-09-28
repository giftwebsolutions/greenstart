@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Illuminate\Support\Str;

    $fallback = asset('uploads/default.jpg');
    $titleParts = explode(' ', trim($title), 2);
    $titleFirst = $titleParts[0] ?? 'Latest';
    $titleRest  = $titleParts[1] ?? 'Blogs';
@endphp

@if (!empty($blogs) && count($blogs))
    <section class="ga-blog-area">
        <div class="container">
            <div class="ga-blog-head">
                <div>
                    <div class="section-title">
                        <h2><span>{{ $titleFirst }}</span> {{ $titleRest }}</h2>
                    </div>
                    <p>Water purifier tips, service guidance, and RO buying advice.</p>
                </div>
                <a href="{{ route('frontend.blog.index') }}" class="ga-section-link">
                    View blog <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="ga-blogrow">
                @foreach ($blogs as $blog)
                    @php
                        $img = ImageUploader::getFilePath($blog->featured_image ?? null, $blog->created_at, 'thumbnail');
                        $date = $blog->published_at ?? $blog->created_at;
                        $day = \Carbon\Carbon::parse($date)->format('d');
                        $month = \Carbon\Carbon::parse($date)->format('M');
                        $titleText = $blog->title ?? $blog->name ?? 'Blog';
                        $excerptText = $blog->short_description
                            ?? $blog->excerpt
                            ?? Str::limit(strip_tags($blog->description ?? $blog->content ?? ''), 90);
                        $url = isset($blog->slug) ? route('frontend.blog.show', $blog->slug) : '#';
                    @endphp

                    <article class="ga-blog-card">
                        <a class="ga-blog-thumb" href="{{ $url }}">
                            <img src="{{ $img }}" alt="{{ e($titleText) }}" loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $fallback }}';">
                            <span class="ga-blog-date"><strong>{{ $day }}</strong> {{ $month }}</span>
                        </a>
                        <div class="ga-blog-body">
                            <a class="ga-blog-title" href="{{ $url }}">{{ $titleText }}</a>
                            <p class="ga-blog-excerpt">{{ $excerptText }}</p>
                            <a class="ga-blog-more" href="{{ $url }}">Read more <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
