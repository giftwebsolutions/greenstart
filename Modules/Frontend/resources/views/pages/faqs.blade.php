@php
    $settings = Config::get('site-settings');
    $phone = $settings['mobile'] ?? '';
    $whatsapp = preg_replace('/\D+/', '', $settings['whatsapp'] ?? $phone);
    $page = $faqs ?? null;
    $intro = $page?->description
        ?: 'Find quick answers about RO water purifiers, installation, service, spare parts, and enquiry support.';
    $items = [
        [
            'q' => 'Why is pure drinking water important?',
            'a' => 'Pure drinking water helps reduce unwanted dissolved salts, dust, chlorine smell, bacteria risk, and visible impurities. A suitable purifier improves taste and gives safer water for daily drinking and cooking.',
            'icon' => 'fa-droplet',
        ],
        [
            'q' => 'What is TDS level in water?',
            'a' => 'TDS means Total Dissolved Solids. It shows the amount of dissolved minerals and salts in water. High TDS water can taste salty or hard, and RO purification is usually suggested when TDS is high.',
            'icon' => 'fa-gauge-high',
        ],
        [
            'q' => 'When do I need RO purifier service?',
            'a' => 'Service is needed when water taste changes, flow becomes slow, tank filling takes too long, leakage starts, purifier makes unusual noise, or filter change time is due. Regular service keeps purifier performance stable.',
            'icon' => 'fa-headset',
        ],
        [
            'q' => 'How often should RO filters be replaced?',
            'a' => 'Sediment and carbon filters are commonly checked every 6 to 12 months depending on water quality and usage. RO membrane replacement depends on TDS, water hardness, and service condition.',
            'icon' => 'fa-filter',
        ],
        [
            'q' => 'Why does RO water taste different?',
            'a' => 'Taste can change due to TDS level, filter condition, storage tank cleanliness, or membrane performance. If the taste suddenly changes, the purifier should be checked by a technician.',
            'icon' => 'fa-mug-hot',
        ],
        [
            'q' => 'Why is water flow slow from my purifier?',
            'a' => 'Slow flow may happen because of blocked filters, low inlet pressure, membrane choking, pump issue, or tank pressure problem. A service check can identify the exact reason.',
            'icon' => 'fa-water',
        ],
        [
            'q' => 'Do I need RO, UV, or UF purifier?',
            'a' => 'RO is commonly used for high TDS or hard water. UV helps disinfect water, and UF helps filter suspended particles. The best choice depends on your water source, TDS, and usage.',
            'icon' => 'fa-flask',
        ],
        [
            'q' => 'What is needed for purifier installation?',
            'a' => 'A water inlet point, drain outlet, power socket, and suitable wall or counter space are usually required. Our team can guide placement before installation.',
            'icon' => 'fa-screwdriver-wrench',
        ],
        [
            'q' => 'Do you provide RO spare parts and service replacements?',
            'a' => 'Yes. We support filters, membranes, pumps, housings, antiscalant items, fittings, and other purifier spares for domestic and commercial RO service needs.',
            'icon' => 'fa-box-open',
        ],
        [
            'q' => 'What details should I share for a quick quote?',
            'a' => 'Share water source, TDS level if available, daily usage, required capacity, location, and whether you need new installation, service, or spare parts.',
            'icon' => 'fa-paper-plane',
        ],
    ];
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <div class="breadcrumb-area faq-breadcrumb">
        <div class="container">
            <div class="breadcrumb-content">
                <ul class="nav">
                    <li><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li>FAQ</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="faq-modern">
        <div class="container">
            <div class="faq-hero">
                <div>
                    <span class="faq-kicker">Common questions</span>
                    <h1>Water purifier help before you buy or service</h1>
                    <p>{{ $intro }}</p>
                </div>
                <div class="faq-hero-actions">
                    <a href="{{ route('frontend.enquiry') }}" class="faq-primary">
                        <i class="fa-regular fa-paper-plane"></i>
                        Send Enquiry
                    </a>
                    @if ($whatsapp)
                        <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="faq-whatsapp">
                            <i class="fa-brands fa-whatsapp"></i>
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            <div class="faq-info-grid">
                <div class="faq-info-card is-aqua">
                    <i class="fa-solid fa-droplet"></i>
                    <strong>Product selection</strong>
                    <span>RO, UV, UF, domestic and commercial purifier guidance.</span>
                </div>
                <div class="faq-info-card is-green">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <strong>Installation support</strong>
                    <span>Setup support for homes, offices, shops, and business use.</span>
                </div>
                <div class="faq-info-card is-dark">
                    <i class="fa-solid fa-headset"></i>
                    <strong>Service assistance</strong>
                    <span>Complaint handling, filter changes, and spare replacement help.</span>
                </div>
            </div>

            <div class="faq-layout">
                <aside class="faq-side-card">
                    <span>Need direct help?</span>
                    <h2>Still have a product question?</h2>
                    <p>Send your water source, usage, and location. We will suggest the right purifier or service option.</p>
                    @if ($phone)
                        <a href="tel:{{ $phone }}"><i class="fa-solid fa-phone"></i>{{ $phone }}</a>
                    @endif
                </aside>

                <div class="faq-accordion" id="faqAccordion">
                    @foreach ($items as $index => $item)
                        @php
                            $collapseId = 'faq-item-' . ($index + 1);
                        @endphp
                        <div class="faq-item">
                            <button class="faq-question {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                <span class="faq-question-icon"><i class="fa-solid {{ $item['icon'] }}"></i></span>
                                <strong>{{ $item['q'] }}</strong>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="{{ $collapseId }}" class="collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                <div class="faq-answer">{{ $item['a'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (!empty($page?->content))
                <div class="faq-cms-card">
                    {!! $page->content !!}
                </div>
            @endif
        </div>
    </section>
</x-frontend::layouts.master>
