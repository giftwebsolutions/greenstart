@php
    $settings = Config::get('site-settings');
    //dd($settings);
@endphp
@section('css')
@endsection
<x-frontend::layouts.master>
 <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <ul class="nav">
                                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                                <li>Contact us</li>
                            </ul>
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
                               <p><a href="tel:{{ $settings['mobile-1'] ?? '' }}">{{ $settings['mobile-1'] ?? '' }}</a></p>
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
                               
                              <p>{{$settings['address']}}</p>
                            </div>
                        </div>
                        <div class="contact-social">
                            <h3>Follow Us</h3>
                            <div class="social-info">
                            <ul>
                                    <li>
                                        <a class="fa-brands fa-whatsapp" title="WhatsApp" href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}" target="_blank">  </a>
                                    </li>
                                    <li>
                                        <a class="fa-brands fa-facebook-f" title="Facebook" href="{{ $settings['facebook'] ?? '' }}"> </a>
                                    </li>
                                    <li>
                                         <li><a class="fa-brands fa-instagram" title="Facebook" href="{{ $settings['instagram'] ?? '' }}" ></a></li>
                                    </li>
                                    <li>
                                        <a class="fa-brands fa-youtube" title="Facebook"   href="{{ $settings['youtube'] ?? '' }}"> </a>
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
                        <form class="contact-form-style" id="contact-form" action="https://htmldemo.net/sharma/sharma/assets/php/mail.php" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input name="name" placeholder="Name*" type="text" />
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
             <div class="contact-map mb-10">
                <iframe class="map-size"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.693667617067!2d144.946279515845!3d-37.82064364221098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4cee0cec83%3A0xd019c5f69915a4a0!2sCollins%20St%2C%20West%20Melbourne%20VIC%203003%2C%20Australia!5e0!3m2!1sen!2sbd!4v1607512676761!5m2!1sen!2sbd">
                </iframe>
            </div>
        </div>
    </div>
    <!-- contact area end -->
</x-frontend::layouts.master>
@section('js')
@endsection
