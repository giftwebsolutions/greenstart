@php
    $settings = Config::get('site-settings');
    $menus    = Config::get('frontend.menus');
    $waNumber = preg_replace('/\D+/', '', $settings['whatsapp'] ?? '');
    $phone    = $settings['mobile'] ?? '';
    $email    = $settings['email'] ?? '';
    $address  = $settings['address'] ?? '';
    $logo     = asset('assets/images/logo/logo.png');
    $brand    = config('app.name', 'Greens Aqua World');
@endphp

<footer class="ga-footer">
    <div class="ga-footer-top">
        <div class="container ga-footer-grid">

            <div class="ga-footer-brand">
                <a href="{{ route('frontend.home') }}" class="ga-footer-logo">
                    <img src="{{ $logo }}" alt="{{ $brand }}">
                </a>
                <p>Domestic &amp; industrial RO purifiers, filters, spares and trusted service support.</p>
                @if ($address)
                    <p class="ga-footer-addr"><i class="fa-solid fa-location-dot"></i> {{ $address }}</p>
                @endif
            </div>

            <div class="ga-footer-col">
                <h4>Quick Links</h4>
                <ul class="ga-footer-links">
                    @foreach ($menus as $item)
                        <li>
                            <a href="{{ \Modules\Frontend\Helpers\MenuHelper::url($item) }}">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="ga-footer-col">
                <h4>Get in touch</h4>
                <ul class="ga-footer-contact">
                    @if ($phone)
                        <li><a href="tel:{{ $phone }}"><i class="fa-solid fa-phone"></i> {{ $phone }}</a></li>
                    @endif
                    @if ($waNumber)
                        <li><a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp</a></li>
                    @endif
                    @if ($email)
                        <li><a href="mailto:{{ $email }}"><i class="fa-regular fa-envelope"></i> {{ $email }}</a></li>
                    @endif
                </ul>

                <div class="ga-footer-social">
                    @if ($waNumber)<a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>@endif
                    @if (!empty($settings['facebook']))<a href="{{ $settings['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                    @if (!empty($settings['instagram']))<a href="{{ $settings['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if (!empty($settings['youtube']))<a href="{{ $settings['youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>@endif
                </div>
            </div>

        </div>
    </div>

    <div class="ga-footer-bottom">
        <div class="container">
            <p>© {{ date('Y') }} {{ $brand }}. All rights reserved.</p>
            <p>Developed by Gift Web Solutions</p>
        </div>
    </div>
</footer>
