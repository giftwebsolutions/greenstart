@php
    $settings = Config::get('site-settings');
    $phone = $settings['mobile'] ?? '';
    $phoneAlt = $settings['mobile-1'] ?? '';
    $email = $settings['email'] ?? '';
    $whatsapp = preg_replace('/\D+/', '', $settings['whatsapp'] ?? $phone);
    $categories = collect($category ?? []);
@endphp

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">
    <div class="breadcrumb-area enquiry-breadcrumb">
        <div class="container">
            <div class="breadcrumb-content">
                <ul class="nav">
                    <li><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li>Enquiry</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="enquiry-page">
        <div class="container">
            <div class="enquiry-hero">
                <div>
                    <span class="enquiry-kicker">Water purifier consultation</span>
                    <h1>Tell us your water purifier requirement</h1>
                    <p>Share your home, office, or spare requirement. Our team will suggest the right aqua filter solution and contact you quickly.</p>
                </div>
                <div class="enquiry-hero-actions">
                    @if ($phone)
                        <a href="tel:{{ $phone }}" class="enquiry-action enquiry-action-call">
                            <i class="fa-solid fa-phone"></i>
                            <span>Call Expert</span>
                        </a>
                    @endif
                    @if ($whatsapp)
                        <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="enquiry-action enquiry-action-wa">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="enquiry-shell">
                <aside class="enquiry-side">
                    <div class="enquiry-card enquiry-contact-card">
                        <span class="enquiry-card-label">Need help choosing?</span>
                        <h2>Greens Aqua World support</h2>
                        <p>Get product selection, installation support, and service assistance from one place.</p>

                        <div class="enquiry-support-list">
                            <div>
                                <i class="fa-solid fa-droplet"></i>
                                <span>Aqua purifier solution</span>
                            </div>
                            <div>
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                <span>Installation support</span>
                            </div>
                            <div>
                                <i class="fa-solid fa-headset"></i>
                                <span>Service assistance</span>
                            </div>
                        </div>
                    </div>

                    <div class="enquiry-card enquiry-detail-card">
                        @if ($phone)
                            <a href="tel:{{ $phone }}" class="enquiry-detail-row">
                                <i class="fa-solid fa-phone"></i>
                                <span>
                                    <small>Primary phone</small>
                                    {{ $phone }}
                                </span>
                            </a>
                        @endif
                        @if ($phoneAlt)
                            <a href="tel:{{ $phoneAlt }}" class="enquiry-detail-row">
                                <i class="fa-solid fa-mobile-screen"></i>
                                <span>
                                    <small>Alternative phone</small>
                                    {{ $phoneAlt }}
                                </span>
                            </a>
                        @endif
                        @if ($email)
                            <a href="mailto:{{ $email }}" class="enquiry-detail-row">
                                <i class="fa-solid fa-envelope"></i>
                                <span>
                                    <small>Email</small>
                                    {{ $email }}
                                </span>
                            </a>
                        @endif
                        @if (!empty($settings['address']))
                            <div class="enquiry-detail-row">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>
                                    <small>Location</small>
                                    {{ $settings['address'] }}
                                </span>
                            </div>
                        @endif
                    </div>
                </aside>

                <div class="enquiry-form-card">
                    <div class="enquiry-form-head">
                        <span class="enquiry-card-label">Quick enquiry</span>
                        <h2>Request product guidance</h2>
                        <p>Fill the details below and we will call back with the best matching purifier or spare part option.</p>
                    </div>

                    <div class="enquiry-process">
                        <div>
                            <span>1</span>
                            <strong>Share requirement</strong>
                            <small>Product, service, or spare part need</small>
                        </div>
                        <div>
                            <span>2</span>
                            <strong>Expert callback</strong>
                            <small>We confirm water usage and location</small>
                        </div>
                        <div>
                            <span>3</span>
                            <strong>Right solution</strong>
                            <small>Product, installation, or service plan</small>
                        </div>
                    </div>

                    @if ($categories->isNotEmpty())
                        <div class="enquiry-category-strip">
                            <span>Popular categories</span>
                            <div>
                                @foreach ($categories->take(5) as $item)
                                    <button type="button" class="enquiry-category-chip" data-category-id="{{ $item['id'] ?? '' }}">
                                        {{ $item['name'] ?? '' }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form class="enquiry-form" id="enquiry-form" action="{{ route('frontend.enquiry.store') }}" method="post">
                        @csrf
                        <div id="enquiry-form-errors" class="enquiry-alert enquiry-alert-error" style="display:none;">
                            <ul></ul>
                        </div>
                        <div id="enquiry-form-message" class="enquiry-alert enquiry-alert-success" style="display:none;"></div>

                        <div class="enquiry-grid">
                            <label class="enquiry-field enquiry-field-wide">
                                <span>Name <b>*</b></span>
                                <input name="name" placeholder="Enter your name" type="text" autocomplete="name" />
                            </label>

                            <label class="enquiry-field">
                                <span>Mobile <b>*</b></span>
                                <input name="mobile" placeholder="Mobile number" type="tel" autocomplete="tel" />
                            </label>

                            <label class="enquiry-field">
                                <span>Email</span>
                                <input name="email" placeholder="Email address" type="email" autocomplete="email" />
                            </label>

                            <label class="enquiry-field">
                                <span>Category</span>
                                <select name="category_id">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item['id'] ?? '' }}">{{ $item['name'] ?? '' }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="enquiry-field">
                                <span>Requirement <b>*</b></span>
                                <input name="subject" placeholder="RO purifier, service, spare part..." type="text" />
                            </label>

                            <label class="enquiry-field">
                                <span>City</span>
                                <input name="city" placeholder="Your city" type="text" autocomplete="address-level2" />
                            </label>

                            <label class="enquiry-field">
                                <span>State</span>
                                <input name="state" placeholder="Your state" type="text" autocomplete="address-level1" />
                            </label>

                            <label class="enquiry-field enquiry-field-wide">
                                <span>Message <b>*</b></span>
                                <textarea name="message" placeholder="Tell us about usage, current issue, capacity, or preferred product."></textarea>
                            </label>
                        </div>

                        <div class="enquiry-submit-row">
                            <button class="enquiry-submit" type="submit">
                                <i class="fa-regular fa-paper-plane"></i>
                                <span>Send Enquiry</span>
                            </button>
                            @if ($whatsapp)
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="enquiry-whatsapp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>Chat on WhatsApp</span>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(function() {
                const $form = $('#enquiry-form');

                if (!$form.length) {
                    return;
                }

                const $submitButton = $form.find('button[type="submit"]');
                const $errorBox = $('#enquiry-form-errors');
                const $messageBox = $('#enquiry-form-message');
                const $categorySelect = $form.find('select[name="category_id"]');

                function hideBox($box) {
                    $box.hide();

                    if ($box.attr('id') === 'enquiry-form-errors') {
                        $box.html('<ul></ul>');
                    } else {
                        $box.text('');
                    }
                }

                function showErrors(messages) {
                    let errorHtml = '<ul>';

                    $.each(messages, function(index, message) {
                        errorHtml += '<li>' + message + '</li>';
                    });

                    errorHtml += '</ul>';

                    $errorBox.html(errorHtml).show();
                }

                function showMessage(message) {
                    $messageBox.text(message).show();
                }

                function scrollToBox($box) {
                    $('html, body').animate({
                        scrollTop: $box.offset().top - 120
                    }, 300);
                }

                function getFormErrors() {
                    const messages = [];
                    const name = $.trim($form.find('input[name="name"]').val());
                    const mobile = $.trim($form.find('input[name="mobile"]').val());
                    const subject = $.trim($form.find('input[name="subject"]').val());
                    const message = $.trim($form.find('textarea[name="message"]').val());

                    if (!name) {
                        messages.push('Name is required.');
                    }

                    if (!mobile) {
                        messages.push('Mobile is required.');
                    }

                    if (!subject) {
                        messages.push('Requirement is required.');
                    }

                    if (!message) {
                        messages.push('Message is required.');
                    }

                    return messages;
                }

                $('.enquiry-category-chip').on('click', function() {
                    const categoryId = $(this).data('category-id');
                    $('.enquiry-category-chip').removeClass('active');
                    $(this).addClass('active');
                    $categorySelect.val(categoryId);
                });

                $form.on('submit', function(event) {
                    event.preventDefault();

                    hideBox($errorBox);
                    hideBox($messageBox);

                    const formErrors = getFormErrors();

                    if (formErrors.length) {
                        showErrors(formErrors);
                        scrollToBox($errorBox);
                        return;
                    }

                    $submitButton.prop('disabled', true).addClass('is-loading');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: new FormData($form[0]),
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            const message = response.message || 'Enquiry submitted successfully.';
                            showMessage(message);
                            scrollToBox($messageBox);
                            $form[0].reset();
                        },
                        error: function(xhr) {
                            let response = xhr.responseJSON || {};

                            if ($.isEmptyObject(response) && xhr.responseText) {
                                try {
                                    response = JSON.parse(xhr.responseText);
                                } catch (e) {
                                    response = {};
                                }
                            }

                            let errors = [];

                            if (response.errors) {
                                errors = Object.values(response.errors).flat();
                            } else if (response.message) {
                                errors = [response.message];
                            } else if (xhr.status === 422) {
                                errors = ['Please fill in all required fields correctly.'];
                            } else if (xhr.status === 0) {
                                errors = ['Network error. Please try again.'];
                            } else {
                                errors = ['Something went wrong. Please try again.'];
                            }

                            showErrors(errors);
                            scrollToBox($errorBox);
                        },
                        complete: function() {
                            $submitButton.prop('disabled', false).removeClass('is-loading');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-frontend::layouts.master>
