<section class="testimonial-area">
    <div class="container">

        <!-- Swiper Container -->
        <div class="swiper testimonial-swiper">
            <div class="swiper-wrapper">

                @forelse ($testimonials as $testimonial)
                    @php
                        $imageUrl = $testimonial->image
                            ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath(
                                $testimonial->image,
                                $testimonial->created_at,
                                'thumbnail'
                            )
                            : asset('assets/images/testimonial-image/default.png');
                        $initials = collect(explode(' ', trim($testimonial->name ?? 'Customer')))
                            ->filter()
                            ->take(2)
                            ->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))
                            ->implode('');
                    @endphp

                    <div class="swiper-slide">
                        <div class="testimonial-card">

                            <div class="testimonial-image">
                                @if ($testimonial->image)
                                    <img src="{{ $imageUrl }}" alt="{{ $testimonial->name }}" loading="lazy" onerror="this.closest('.testimonial-image').classList.add('has-initials');this.remove();">
                                @endif
                                <span class="testimonial-initials">{{ $initials ?: 'GA' }}</span>
                            </div>

                            <p class="testimonial-content">
                                {{ \Illuminate\Support\Str::limit(strip_tags($testimonial->content), 140) }}
                            </p>

                            <h4 class="testimonial-author">{{ $testimonial->name }}</h4>

                        </div>
                    </div>
                @empty
                    <p class="text-center">No testimonials available.</p>
                @endforelse

            </div>

            <!-- Slider Pagination -->
            <div class="swiper-pagination"></div>

        </div>
    </div>
</section>
