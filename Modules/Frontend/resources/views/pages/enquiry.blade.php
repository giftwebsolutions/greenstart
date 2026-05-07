@php

    $settings = Config::get('site-settings');
@endphp
@section('css')
@endsection
<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">

 <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <ul class="nav">
                                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                                <li>Enquiry</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- contact area start -->
    <div class="contact-area mb-60px">
        <div class="container">
            <div class="custom-row-2">
                <div class="col-lg-4 col-md-5 mb-lm-60px col-sm-12 col-xs-12 w-sm-100">
                    <div class="contact-info-wrap">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="ion-android-call"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p><a href="tel:{{ $settings['mobile'] ?? '' }}">{{ $settings['mobile'] ?? '' }}</a></p>
                                <p><a href="tel:{{ $settings['mobile-1'] ?? '' }}">{{ $settings['mobile-1'] ?? '' }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="ion-android-globe"></i>
                            </div>
                            <div class="contact-info-dec">
                                <a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a>
                                <a href="mailto:{{ $settings['username'] ?? '' }}">{{ $settings['username'] ?? '' }}</a>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="ion-android-pin"></i>
                            </div>
                            <div class="contact-info-dec">

                                <p>{{ $settings['address'] }}</p>
                            </div>
                        </div>
                        <div class="contact-social">
                            <h3>Follow Us</h3>
                            <div class="social-info">
                                <ul>
                                    <li>
                                        <a class="fa-brands fa-whatsapp" title="WhatsApp"
                                            href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}" target="_blank">
                                        </a>
                                    </li>
                                    <li>
                                        <a class="fa-brands fa-facebook-f" title="Facebook"
                                            href="{{ $settings['facebook'] ?? '' }}"> </a>
                                    </li>
                                    <li>
                                    <li><a class="fa-brands fa-instagram" title="Facebook"
                                            href="{{ $settings['instagram'] ?? '' }}"></a></li>
                                    </li>
                                    <li>
                                        <a class="fa-brands fa-youtube" title="Facebook"
                                            href="{{ $settings['youtube'] ?? '' }}"> </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                    <div class="contact-form">
                        <div class="contact-title mb-30">
                            <h2>Get In Touch</h2>
                        </div>
                        <form class="contact-form-style" id="enquiry-form"
                            action="{{ route('frontend.enquiry.store') }}" method="post">
                            @csrf
                            <div id="enquiry-form-errors"
                                style="display:none; margin-bottom:15px; padding:12px 15px; border:1px solid #dc3545; background:#f8d7da; color:#842029;">
                                <ul style="margin:0; padding-left:18px;"></ul>
                            </div>
                            <div id="enquiry-form-message"
                                style="display:none; margin-bottom:15px; padding:12px 15px; border:1px solid #198754; background:#d1e7dd; color:#0f5132;">
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input name="name" placeholder="Name*" type="text" />
                                </div>
                                <div class="col-lg-6">
                                    <input name="mobile" placeholder="Mobile*" type="text" />
                                </div>
                                <div class="col-lg-6">
                                    <input name="email" placeholder="Email*" type="email" />
                                </div>
                                <div class="col-lg-12">
                                    <input name="subject" placeholder="Subject*" type="text" />
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="message" placeholder="Your Message*"></textarea>
                                    <button class="submit" type="submit">SEND</button>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area end -->
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

                function hideBox($box) {
                    $box.hide().html('');
                }

                function showErrors(messages) {
                    let errorHtml = '<ul style="margin:0; padding-left:18px; list-style:disc;">';

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
                        messages.push('Subject is required.');
                    }

                    if (!message) {
                        messages.push('Message is required.');
                    }

                    return messages;
                }

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

                    $submitButton.prop('disabled', true);

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
                            alert(message);
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
                            $submitButton.prop('disabled', false);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-frontend::layouts.master>
