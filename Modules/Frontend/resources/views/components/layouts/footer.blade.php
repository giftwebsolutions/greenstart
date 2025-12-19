@php
    $settings = Config::get('site-settings');
@endphp
<!-- Footer Area Start -->
<div class="footer-area">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <div class="footer-logo">
                                <a href="{{ route('frontend.home') }}"><img class="img-responsive" src="{{asset('assets/images/logo/logo.png')}}"
                                        alt="{{ env('APP_NAME') }}" /></a>
                            </div>
                            <div class="need_help">
                                <p class="add"><span class="address">Address</span>4710-4890 Breckinridge
                                    St,Fayetteville</p>
                                <p class="phone"><span class="call us">Need Help?</span> <a href="tel:1-800-345-6789">
                                        Call: 1-800-345-6789</a></p>
                                <p class="phone"><span class="call us">Products & Sales</span> <a
                                        href="tel:1-800-345-6789"> Call: 1-800-345-6789</a></p>
                            </div>
                            <div class="contact-us-btn">
                                <a href="contact.html">Contact us</a>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-4 col-lg-4">
                        <div class="single-wedge">
                            <h4 class="footer-herading">CUSTOM LINKS</h4>
                            <div class="footer-links">
                                <div class="footer-row">
                                    <ul class="align-items-center">
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="#">Delivery Information</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Terms & Conditions</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                        <li><a href="#">Site Map</a></li>
                                        <li><a href="#">Order History</a></li>
                                    </ul>
                                    <ul class="align-items-center">
                                        <li><a href="#">Brands</a></li>
                                        <li><a href="#">Gift Certificates</a></li>
                                        <li><a href="#">Affiliate</a></li>
                                        <li><a href="#">Specials</a></li>
                                        <li><a href="#">Returns</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-lg-4 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                        
                            <h4 class="footer-herading">Follow Us:</h4>
                            <div class="social-info">
                                <ul class="link-follow">
                                    <li><a class="facebook ion-social-facebook" title="Facebook"
                                            href="#"><span>facebook</span></a></li>
                                    <li><a class="twitter ion-social-twitter" title="Twitter"
                                            href="#"><span>twitter</span></a></li>
                                    <li><a class="google ion-social-googleplus-outline" title="Google"
                                            href="#"><span>google </span></a></li>
                                    <li><a class="youtube ion-social-youtube" title="Youtube"
                                            href="#"><span>youtube
                                            </span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
        
        <div class="footer-bottom">
            <div class="col-md-12 text-center">
                <p class="copy-text">Copyright © Green Start. All Rights Reserved</p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area End -->
