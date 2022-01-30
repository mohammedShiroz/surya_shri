<div class="top-header dark_skin w-100" id="top-header" style="z-index: 9999;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="d-inline-flex">
                    <div class="lng_dropdown mr-2">
                        <div class="d-inline-flex">
                            <p class=""><i class="ti-world"></i></p>
                            <p class="ml-1" style="margin-top: -1px">EN</p>
                        </div>
                    </div>
                    {{--<div class="lng_dropdown mr-2">--}}
                        {{--<select name="countries" class="custome_select" id="des_lag" onchange="change_des_lag()" translate="no" class="notranslate">--}}
                            {{--<option value='en'--}}
                                    {{--{{ isset($_COOKIE['googtrans'])? (($_COOKIE['googtrans'] == "/en/en")? 'selected': '') : '' }}--}}
                                    {{--data-image="{{ asset('assets/images/eng.png') }}" data-title="English"  translate="no" class="notranslate"> English--}}
                            {{--</option>--}}
                            {{--<option value='ta'--}}
                                    {{--{{ isset($_COOKIE['googtrans'])? (($_COOKIE['googtrans'] == "/en/ta")? 'selected': '') : '' }}--}}
                                    {{--data-image="{{ asset('assets/images/india_flg.png') }}" data-title="Tamil" translate="no" class="notranslate"> Tamil--}}
                            {{--</option>--}}
                            {{--<option value='si'--}}
                                    {{--{{ isset($_COOKIE['googtrans'])? (($_COOKIE['googtrans'] == "/en/si")? 'selected': '') : '' }}--}}
                                    {{--data-image="{{ asset('assets/images/srilanka_flg.png') }}" translate="no" class="notranslate" data-title="Sinhala"> Sinhala--}}
                            {{--</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="mr-3">--}}
                        {{--<select name="countries" class="custome_select">--}}
                            {{--<option value='LKR' data-title="LKR">LKR</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<ul class="contact_detail text-center text-lg-left">--}}
                        {{--<li><a href="tel:0769244427"><i class="ti-mobile text-white"></i><span>0769244427</span></a></li>--}}
                    {{--</ul>--}}
                </div>

                <div class="d-flex float-right text-right">
                    @include('components.nav_bar.top.headers')
                </div>
            </div>
        </div>
    </div>
</div>
