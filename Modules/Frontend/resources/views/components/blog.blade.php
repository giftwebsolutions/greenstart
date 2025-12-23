@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Illuminate\Support\Str;

    // fallback image if blog image is empty
    $fallback = asset('assets/images/blog-image/1.jpg');

    // title split (LATEST + BLOGS) like your HTML
    $titleParts = explode(' ', trim($title), 2);
    $titleFirst = $titleParts[0] ?? 'LATEST';
    $titleRest  = $titleParts[1] ?? 'BLOGS';
@endphp

@if(!empty($blogs) && count($blogs))
    <!-- Blog Area Start -->
    <div class="main-blog-area mb-60px">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2><span>{{ $titleFirst }} </span>{{ $titleRest }}</h2>
                    </div>
                </div>
            </div>

            <!-- Blog Slider Start -->
            <div class="main-blog-slider-wrapper slider-nav-style-1">

                @foreach($blogs as $blog)
                    @php
                        /**
                         * IMPORTANT:
                         * Update these field names to match your Blog table/model:
                         * - image column: $blog->thumb OR $blog->image OR $blog->banner
                         * - title column: $blog->title
                         * - content column: $blog->short_description OR $blog->description
                         */

                        $imageValue = $blog->featured_image ?? null;

                        // ImageUploader format similar to your product code:
                        // getFilePath(file, created_at, 'thumbnail')
                        $img = ImageUploader::getFilePath($imageValue, $blog->created_at, 'thumbnail');
                        //dd($img);

                        $date = $blog->published_at ?? $blog->created_at;
                        $day   = \Carbon\Carbon::parse($date)->format('d');
                        $month = \Carbon\Carbon::parse($date)->format('M');
                        $year  = \Carbon\Carbon::parse($date)->format('Y');

                        $titleText = $blog->title ?? $blog->name ?? 'Blog';

                        $excerptText =
                            $blog->short_description
                            ?? $blog->excerpt
                            ?? Str::limit(strip_tags($blog->description ?? $blog->content ?? ''), 100);

                        // route (change to your real route name)
                        // Example: route('frontend.blog.show', $blog->slug)
                        $url = isset($blog->slug)
                            ? route('frontend.blog.show', $blog->slug)
                            : '#';

                        // author (optional)
                        $authorName = $blog->author_name ?? (optional($blog->author)->name ?? 'Admin');
                        $authorUrl  = $blog->author_url ?? '#';
                    @endphp

                    <!-- Blog Slider Single Item -->
                    <div class="blog-slider-item">
                        <div class="blog-slider-inner">
                            <div class="aritcles-image">
                                <a href="{{ $url }}">
                                    <img src="{{ $img }}" alt="{{ e($titleText) }}">
                                </a>

                                <p class="date-time-post">
                                    <span>
                                        <span class="date-post">{{ $day }}</span>
                                        <span class="month-post">{{ $month }}</span>
                                        <span class="year-post">{{ $year }}</span>
                                    </span>
                                </p>
                            </div>

                            <div class="aritcles-content">
                                <div class="content-inner">
                                    <a class="articles-name" href="{{ $url }}">
                                        {{ $titleText }}
                                    </a>

                                    <p class="author-name">
                                        By <a href="{{ $authorUrl }}">{{ $authorName }}</a>
                                    </p>

                                    <div class="articles-intro">
                                        <p>{{ $excerptText }}</p>
                                    </div>

                                    <a class="read-more" href="{{ $url }}">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blog Slider Single Item -->
                @endforeach

            </div>
            <!-- Blog Slider End -->
        </div>
    </div>
    <!-- Blog Area End -->
@endif
