@php
    $page = $page ?? $about ?? null;
    $title = $page->title ?? $page->name ?? 'About Greens Aqua World';
    $banner = $page->banner ?? $page->featured_image ?? null;
    $introText = $page?->description
        ?: \Illuminate\Support\Str::limit(trim(strip_tags($page?->content ?? '')), 220)
        ?: 'We help customers choose, install, and maintain reliable water purifier systems with quick service support across our local service network.';
    $stats = [
        ['value' => '15+', 'label' => 'Years in water purifier field'],
        ['value' => '5,000+', 'label' => 'Installations completed'],
        ['value' => '50,000+', 'label' => 'Complaints completed'],
        ['value' => '50 km', 'label' => 'Service radius coverage'],
    ];
    $expertise = [
        'Domestic RO water purifiers',
        'Commercial water purifier systems',
        'RO service and annual maintenance',
        'Filter spare parts and replacements',
        'Installation and water quality guidance',
        'Fast complaint resolution',
    ];
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <div class="breadcrumb-area about-breadcrumb">
        <div class="container">
            <div class="breadcrumb-content">
                <ul class="nav">
                    <li><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li>{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="about-modern">
        <div class="container">
            <div class="about-hero">
                <div class="about-hero-copy">
                    <span class="about-kicker">Greens Aqua World</span>
                    <h1>Trusted aqua filter experts for homes and businesses</h1>
                    <p>{{ $introText }}</p>
                    <div class="about-hero-actions">
                        <a href="{{ route('frontend.enquiry') }}" class="about-primary-btn">
                            <i class="fa-regular fa-paper-plane"></i>
                            <span>Send Enquiry</span>
                        </a>
                        <a href="{{ route('frontend.shop.index') }}" class="about-secondary-btn">
                            <i class="fa-solid fa-border-all"></i>
                            <span>View Products</span>
                        </a>
                    </div>
                </div>

                <div class="about-hero-media">
                    @if ($banner)
                        <img src="{{ asset($banner) }}" alt="{{ $title }}">
                    @else
                        <div class="about-media-fallback">
                            <i class="fa-solid fa-droplet"></i>
                            <strong>Pure water solutions</strong>
                            <span>Sales, installation, service and spare support</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="about-stat-grid">
                @foreach ($stats as $stat)
                    <div class="about-stat-card">
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="about-section about-split">
                <div>
                    <span class="about-section-label">Who we are</span>
                    <h2>Local specialists focused on clean drinking water</h2>
                </div>
                <div class="about-rich-text">
                    @if (!empty($page->description))
                        <p>{{ $page->description }}</p>
                    @endif
                    @if (!empty($page->content))
                        <div class="cms-content">{!! $page->content !!}</div>
                    @else
                        <p>
                            Greens Aqua World provides aqua filter products, purifier installation, spare parts, and service support for domestic and business customers.
                            Our work is built around practical product advice, prompt response, and dependable after-sales care.
                        </p>
                    @endif
                </div>
            </div>

            <div class="about-section">
                <div class="about-section-head">
                    <span class="about-section-label">Why choose us</span>
                    <h2>Support that continues after installation</h2>
                </div>
                <div class="about-why-grid">
                    <div class="about-why-card">
                        <i class="fa-solid fa-user-check"></i>
                        <h3>Experienced guidance</h3>
                        <p>More than 15 years of field experience helps us recommend the right purifier based on usage, water quality, and budget.</p>
                    </div>
                    <div class="about-why-card">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <h3>Installation ready</h3>
                        <p>We have completed 5,000+ installations with clear coordination from product selection to setup.</p>
                    </div>
                    <div class="about-why-card">
                        <i class="fa-solid fa-headset"></i>
                        <h3>Service response</h3>
                        <p>50,000+ complaints completed across our service history with support around a 50 km local radius.</p>
                    </div>
                </div>
            </div>

            <div class="about-section about-journey">
                <div class="about-section-head">
                    <span class="about-section-label">Our journey</span>
                    <h2>Built through service, trust, and repeat customers</h2>
                </div>
                <div class="about-timeline">
                    <div>
                        <strong>Started with service</strong>
                        <p>We began by solving purifier service and installation needs for local households.</p>
                    </div>
                    <div>
                        <strong>Expanded product solutions</strong>
                        <p>Our range grew into domestic purifiers, commercial systems, filters, and spare parts.</p>
                    </div>
                    <div>
                        <strong>Stronger support network</strong>
                        <p>Today we support customers with consultation, installation, complaint handling, and maintenance.</p>
                    </div>
                </div>
            </div>

            <div class="about-section about-expertise">
                <div>
                    <span class="about-section-label">We are expert in</span>
                    <h2>Aqua purifier products, service, and spares</h2>
                </div>
                <div class="about-expertise-grid">
                    @foreach ($expertise as $item)
                        <span><i class="fa-solid fa-check"></i>{{ $item }}</span>
                    @endforeach
                </div>
            </div>

            <div class="about-section about-vm-grid">
                <div class="about-vm-card">
                    <span class="about-section-label">Vision</span>
                    <h2>Make safe drinking water easier to access</h2>
                    <p>To become the most trusted local aqua filter partner for product selection, installation, service, and long-term maintenance.</p>
                </div>
                <div class="about-vm-card">
                    <span class="about-section-label">Mission</span>
                    <h2>Deliver dependable purifier support</h2>
                    <p>To provide honest guidance, quality products, fast service response, and practical solutions for every customer requirement.</p>
                </div>
            </div>

            @if (!empty($children) && count($children))
                <div class="about-section">
                    <div class="about-section-head">
                        <span class="about-section-label">More from us</span>
                        <h2>Explore our company pages</h2>
                    </div>
                    <div class="about-child-grid">
                        @foreach ($children as $child)
                            <a href="{{ route('frontend.cms.view', $child->slug) }}" class="about-child-card">
                                <h3>{{ $child->name }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($child->description ?? $child->content), 120) }}</p>
                                <span>Read more <i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-frontend::layouts.master>
