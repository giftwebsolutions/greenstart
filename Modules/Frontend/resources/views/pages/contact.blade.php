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
                        <form class="contact-form-style" id="contact-form" action="{{ route('frontend.enquiry.store') }}" method="post">
                        @csrf    
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
                <iframe  class="map-size" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4926.818832493571!2d79.3703598!3d10.965336599999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3baacda0cc324971%3A0xbda2f5806211e0d8!2sGreens%20Aqua%20World(%20The%20Water%20Filter%20Company)!5e1!3m2!1sen!2sin!4v1777961164887!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <!-- contact area end -->
</x-frontend::layouts.master>
@section('js')
@endsection
