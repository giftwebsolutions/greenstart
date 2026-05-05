@php
    $settings = Config::get('site-settings');
    // dd($settings);
    $menus = Config::get('frontend.menus');
@endphp

<div class="footer-area">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <!-- FOOTER COLUMN 1 -->
                    <div class="col-md-4 col-lg-4">
                        <div class="single-wedge">
                            <div class="footer-logo">
                                <a href="{{ route('frontend.home') }}">
                                    <img class="img-responsive logo w-25 h-100" src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ env('APP_NAME') }}">
                                </a>
                            </div>

                            <div class="need_help">
                                <p class="add">
                                    <span class="address">Address</span>
                                    {{ $settings['address'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER COLUMN 2 (DYNAMIC MENU) -->
                    <div class="col-md-4 col-lg-4">
                        <div class="single-wedge">
                            <h4 class="footer-herading">CUSTOM LINKS</h4>
                            <div class="footer-links">
                                <ul class="align-items-center">
                                    @include('frontend::components.menu-recursive', [
                                        'items' => $menus
                                    ])
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER COLUMN 3 -->
                    <div class="col-md-4 col-lg-4 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                       
                            <h4 class="footer-herading">Follow Us:</h4>
                            <div class="social-info">
                                <ul class="link-follow">                        
                                  <li>
                                      <a class="fa-brands fa-whatsapp"
                                         title="WhatsApp"
                                          href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}"
                                         target="_blank">
                                          <span>Whatsapp</span>
                                      </a>
                                 </li>


                                    <li><a class="fa-brands fa-facebook-f" title="Facebook"
                                              href="{{ $settings['facebook'] ?? '' }}" 
                                                ><span>Facebook</span>
                                        </a>
                                    </li>

                                    <li><a class="fa-brands fa-instagram" title="Facebook"
                                              href="{{ $settings['instagram'] ?? '' }}" 
                                                ><span>Instagram</span>
                                        </a>
                                    </li>

                                          <li><a class="fa-brands fa-youtube" title="Facebook"
                                              href="{{ $settings['youtube'] ?? '' }}" 
                                                ><span>Youtube</span>
                                        </a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
 

                </div>
            </div>
        </div>

        <div class="footer-bottom text-center">
            <p>Copyright{{ date('Y') }} © Developed By Gift Web Solutions </p>
        </div>
    </div>
</div>
