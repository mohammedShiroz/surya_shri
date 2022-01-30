<!-- START FOOTER -->
{{--style="background: linear-gradient(to top, #ab8f00, #705a00);"--}}
<footer class="footer_dark text-white" style="background:#231F01;">
    <div class="footer_top small_pt">
        <div class="container">
            <div class="row pb-4 mb-0 mb-md-0">
                <div class="col-lg-4 col-12">
                    <div class="widget">
                        <div class="footer_logo">
                            <h6 class="widget_title text-uppercase">{{ env('APP_SURE_NAME') }}</h6>
                            <p>OUR VISION – To offer authentic ancient Ayurvedic remedies to ensure health and wellbeing of our local and global communities</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="widget">
                                <h6 class="widget_title text-white">QUICK LINKS</h6>
                                <ul class="widget_links">
                                    <li><a href="{{ route('about-us') }}">About us</a></li>
                                    <li><a href="{{ route('services') }}">Clinique</a></li>
                                    <li><a href="{{ route('products') }}">Boutique</a></li>
                                    {{--<li><a href="{{ route('blog') }}">Blog</a></li>--}}
                                    <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="widget">
                                <h6 class="widget_title">INFORMATION</h6>
                                <ul class="widget_links">
                                    <li><a href="{{ route('termsAndCondition') }}">Terms & Condition</a></li>
                                    <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('affiliate_policy') }}">Affiliate Policy</a></li>
                                    <li><a href="{{ route('transaction_policy') }}">Transaction Policy</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="widget">
                                <h6 class="widget_title text-white">ACCOUNT</h6>
                                <ul class="widget_links">
                                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('wallet') }}">My Wallet</a></li>
                                    <li><a href="{{ route('dashboard.orders') }}">Order History</a></li>
                                    {{--<li><a href="{{ route('dashboard.transactions') }}">Transactions</a></li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="middle_footer mt-n5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shopping_info">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <a href="https://goo.gl/maps/sJYKEEFMPyo1Vd3z9"><i class="ti-location-pin"></i></a>
                                    </div>
                                    <div class="icon_box_content">
                                        <h5>Location</h5>
                                        <p><a href="https://goo.gl/maps/sJYKEEFMPyo1Vd3z9">112, 5th lane, Kendahenawatta road, Depanama</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="linearicons-envelope-open"></i>
                                    </div>
                                    <div class="icon_box_content">
                                        <h5>Email us</h5>
                                        <p><a href="mailto:suryashri.ayurveda@gmail.com">suryashri.ayurveda@gmail.com</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="flaticon-support"></i>
                                        <i class="fa fa-circle" style="font-size: 15px; position: absolute; top:0; left:0; color: #837000; display: flex; justify-content:center; align-content: center; align-items: center; width: 100%;"><span class="text-white position-absolute" style=" display: flex; justify-content:center; align-content: center; align-items: center; width: 100%;">w</span></i>
                                    </div>
                                    <div class="icon_box_content">
                                        <h5>WhatsApp Us</h5>
                                        <p>8 am – 5 pm Sri Lankan time<br/>
                                           <a href="tel:+94769244427">+94769244427</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <p class="mb-lg-0 text-center">Copyrights © 2021 <span class="text-capitalize">{{ env('APP_NAME','Suryā Shri') }}</span>. All Rights Reserved. Developed by <a href="https://keenrabbits.com/">Keenrabbits</a> </p>
                </div>
                <div class="col-lg-4 order-lg-first">
                    <div class="widget mb-lg-0">
                        <ul class="social_icons text-center text-lg-left">
                            <li><a href="https://www.facebook.com/DoctorMahe" class="sc_facebook"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="https://twitter.com/Suryashri7" class="sc_twitter"><i class="ion-social-twitter"></i></a></li>
                            {{--<li><a href="#" class="sc_linkedin"><i class="ion-social-linkedin"></i></a></li>--}}
                            <li><a href="https://www.youtube.com/channel/UClDtEMYOROiXpl3ZjfRPSMg" class="sc_youtube"><i class="ion-social-youtube-outline"></i></a></li>
                            <li><a href="https://www.instagram.com/surya_shri_sl" class="sc_instagram"><i class="ion-social-instagram-outline"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="footer_payment text-center text-lg-right">
{{--                        <li><a href="{{ route('admin.login') }}"><img src="{{ asset('assets/images/admin_lock.png')}}" alt="admin_login"></a></li>--}}
                        <li><img src="{{ asset('assets/images/visa.webp') }}" alt="visa"></li>
                        <li><img src="{{ asset('assets/images/discover.webp') }}" alt="discover"></li>
                        <li><img src="{{ asset('assets/images/master_card.webp') }}" alt="master_card"></li>
                        <li><img src="{{ asset('assets/images/paypal.webp') }}" alt="paypal"></li>
                        <li><img src="{{ asset('assets/images/amarican_express.webp') }}" alt="amarican_express"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->
