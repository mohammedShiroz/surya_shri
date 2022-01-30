@extends('layouts.front')
@section('page_title','Register')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Create an account'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/customs_radio.css')}}">
    <style>.select2-container .select2-selection--single { height: 50px} .select2-container--default .select2-selection--single { padding-top: 10px;}  .select2-container--default .select2-selection--single .select2-selection__arrow { top: 13px;}  input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }  input[type=number] { -moz-appearance: textfield; }#pass{ margin-left:25%; height:45px; width:500px; border-radius:3px; border:1px solid grey; padding:10px; font-size:18px;}#meter_wrapper {border:none; margin-top:2px; width:100%; height:10px; border-radius:5px; }#meter { width:0px;margin-top:2px;height:7.5px;border-radius:5px;}#pass_type{display: block;width: 100%;justify-content: right;align-content: right;top:0;right: 0;font-size:12px;margin-top: -10px;text-transform: uppercase;text-align:right;color:grey;font-weight: bold;}</style>
@endpush
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Create an account','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Create an account','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-5">
            <div class="container">
                <div class="">
                    <form method="POST" action="{{ route('register') }}" id="register_form" aria-label="{{ __('Register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 offset-md-3 col-sm-12 mb-3">
                                <blockquote class="blockquote_style3">
                                    <p>If you already have an account with us, please <a href="{{route('login')}}"> login</a>.</p>
                                </blockquote>
                            </div>
                            <div class="col-lg-6 col-md-6 offset-md-3 col-sm-12">
                                @include('components.messages')
                            </div>
                            <div class="col-lg-6 col-md-6 offset-md-3 col-sm-12 mt-2">
                                <div class="bg-white">
                                    <h5 class="text-uppercase">Registration Form<br/><span class="text-main">_____</span></h5>
                                    <div class="form-group mt-4">
                                        <label>First Name<span class="text-danger">*</span></label>
                                        <input type="hidden" name="register_user" value="new_user" />
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Your first name" required autofocus>
                                        <p class="text-danger name_error"  style="margin-bottom:-2px; display: none;"></p>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group mt-4">
                                        <label>Last Name<span class="text-danger">*</span></label>
                                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="Your last name">
                                        <p class="text-danger last_name_error"  style="margin-bottom:-2px; display: none;"></p>
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Email<span class="text-danger">*</span></label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your email address" required>
                                        <p class="text-danger email_error"  style="margin-bottom:-2px; display: none;"></p>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Gender<span class="text-danger">*</span></label>
                                        <select name="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                            <option value="Male" {{ (old('gender') == "Male")? 'selected' : 'selected' }}>Male</option>
                                            <option value="Female" {{ (old('gender') == "Female")? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ (old('gender') == "Other")? 'selected' : '' }}>Other</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Telephone<span class="text-danger">*</span></label>
                                        <input id="phone" type="text"
                                               class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{ old('contact') }}" placeholder="Your phone number" required>
                                        <p class="text-danger phone_error"  style="margin-bottom:-2px; display: none;"></p>
                                        @if ($errors->has('contact'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="bg-white mt-5">
                                    <h5>YOUR PASSWORD<br/><span class="text-main">_____</span></h5>
                                    <div class="form-group">
                                        <label>Password<span class="text-danger">*</span></label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Your Password" required>
                                        <p class="text-danger password_error"  style="margin-bottom:-2px; display: none;"></p>
                                        <div id="meter_wrapper">
                                            <div id="meter"></div>
                                            <span id="pass_type"></span>
                                        </div>
                                        <div class="border p-2 mt-2 radius_all_5 d-none password-info">
                                            <small>Password should be at least<br/>1 letter between lowercase [ a - z ]</small><br/>
                                            <small>At least 1 letter between uppercase [ A - Z ]</small><br/>
                                            <small>At least 1 number between [ 0 - 9 ]</small><br/>
                                            <small>At least 1 character from [ $@#&! ]</small><br/>
                                            <small>Minimum length of password is 6</small><br/>
                                        </div>
                                        <div id="meter_wrapper">
                                            <div id="meter"></div>
                                            <span id="pass_type"></span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('password') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password<span class="text-danger">*</span></label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"required>
                                        <p class="text-danger password_confirm_error"  style="margin-bottom:-2px; display: none;"></p>
                                    </div>
                                    <h5 class="mt-5">NEWSLETTER SUBSCRIPTION<br/><span class="text-main">_____</span></h5>
                                    <div class="form-group border radius_all_5 pl-3 pb-1" style="padding-top: 15px;">
                                        <label class="mr-2">Subscribe</label>
                                        <div class="d-inline-block custome-checkbox">
                                            <input class="form-check-input" id="yes" type="checkbox" name="newsletter" value="1">
                                            <label class="form-check-label" for="yes"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white mt-5">
                                    <h5>BECOME A PARTNER<br/><span class="text-main">_____</span></h5>
                                    <div class="form-group border radius_all_5 pl-3 pb-1 pr-3" style="padding-top: 15px;">
                                        <label class="mr-3">Become a Partner ?</label>
                                        <div class="d-inline-block custome-checkbox">
                                            <input class="form-check-input ref-btn" id="agent_yes" type="checkbox" name="become_partner" value="1">
                                            <label class="form-check-label" for="agent_yes">Yes</label>
                                        </div>
                                        <div class="form-group mt-4" id="agent_ref_field" style="display: {{ (old('become_agent') == 1)? '': 'none' }};">
                                            <label>Coupon Code/Partner Code/Partner Email<span class="text-danger">*</span></label>
                                            <input id="referral" type="hidden" name="referral" value="{{ old('referral') }}">
                                            <div class="input-group mb-3">
                                                <input type="text" id="partner_name" class="form-control" name="partner_name" value="{{ old('partner_name') }}" placeholder="Coupon Code/Partner Code/Partner Email">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-fill-out btn-block check-partner-code">Check now</button>
                                                </div>
                                                <small id="ref-error" class="w-100" role="alert" ></small>
                                                <p class="text-danger partner_name_error"  style="margin-bottom:-2px; display: none;"></p>
                                            </div>
                                            <div class="form-control" style="height: auto">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input affiliate_check" id="affiliate_btn" type="checkbox" name="affiliate_check" value="0">
                                                    <label class="form-check-label" for="affiliate_btn">
                                                        <span>I agree to your <a href="javascript:void(0)" id="affiliate-link"><small>Affiliate Policy</small></a>.</span></label>
                                                </div>
                                                <p class="text-danger affiliate_error"  style="margin-bottom:-2px; display: none;"></p>
                                            </div>
                                            @if ($errors->has('partner_name'))
                                                <span class="invalid-feedback" id="ref-error" role="alert">
                                                    <strong>{{ $errors->first('partner_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="captcha">Please complete the captcha validation below<span class="text-danger">*</span></label>
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-control mb-3" style="padding-top: 10px; height: auto">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input privacy_check" id="privacy_btn" type="checkbox" name="privacy_check" value="0">
                                            <label class="form-check-label" for="privacy_btn">
                                                <span>I agree to your <a href="javascript:void(0)" id="terms-link"><small>Terms and Condition</small></a> <small>&amp;</small> <a href="javascript:void(0)" id="privacy-link"><small>Privacy policy</small></a>.</span></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <small class="mb-2 text-gray d-block" style="color: #837000;">Please read above user agreements and policies fully before selecting to agree with them</small>
                                        <button type="button" id="submit_btn" disabled="" class="btn btn-fill-out btn-block" name="register">Register now </button>
                                        <button type="button" id="submitting" disabled="" class="btn btn-fill-out btn-block d-none"><i class="fas fa-spinner fa-spin"></i> Progressing</button>
                                    </div>
                                    <div class="different_login">
                                        <span> or</span>
                                    </div>
                                    <!--
                                    <ul class="btn-login list_none text-center">
                                        <li><a href="#" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>
                                        <li><a href="#" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>
                                    </ul>-->
                                    <div class="form-note text-center">Already have an account? <a href="{{ route('login') }}">Log in</a></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END LOGIN SECTION -->
    </div>
    <!-- END MAIN CONTENT -->
    <!-- terms and privacy Popup Section -->
    @include('components.popup.terms_and_policy')
    <!-- End Screen Load Popup Section -->
@endsection
@push('script')
    <script>
        $('#name').on('keypress', function (event) {
            var regex = new RegExp("^[a-zA-Z\\s]+$"); var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) { event.preventDefault(); return false; }
        });
        $('#last_name').on('keypress', function (event) {
            var regex = new RegExp("^[a-zA-Z\\s]+$"); var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {event.preventDefault();return false;}
        });
        $('#phone').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$"); var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) { event.preventDefault(); return false; }
        });
        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        $(document).ready(function() {
            $('.ref-btn').click(function(){
                if($("#agent_yes")[0].checked){ $('#agent_ref_field').slideDown(); }
                else{ $('#agent_ref_field').slideUp(); }
            });
            $('.check-partner-code').on('click', function() { valid_partner_code($("#partner_name").val()); });
            $("#terms-link").click(function(){ $("#terms-popup").modal('show', {}, 500); });
            $("#privacy-link").click(function(){ $("#privacy-popup").modal('show', {}, 500); });
            $("#affiliate-link").click(function(){ $("#affiliate-popup").modal('show', {}, 500); });
            function valid_partner_code(code){
                $("#ref-error").html('');
                if($("#partner_name").val()) {
                    $.ajax({
                        url: "{{ route('partner.valid.check') }}",
                        method: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {code: code},
                        success: function (data) {
                            if (data.status == "valid") {
                                $("#referral").val(data['partner_id']);
                                $("#ref-error").fadeIn(); $("#ref-error").html('The email/code you entered match. Your referral partner is '+data.partner_name);
                                $("#ref-error").removeClass('text-danger'); $("#ref-error").addClass('text-success');
                                $("#partner_name").removeClass('is-invalid'); $("#partner_name").addClass('is-valid');
                            } else {
                                $("#ref-error").fadeIn(); $("#ref-error").html('The email/code you entered does not match.');
                                $("#ref-error").removeClass('text-success'); $("#ref-error").addClass('text-danger');
                                $("#partner_name").removeClass('is-valid'); $("#partner_name").removeClass('is-invalid');
                                $("#partner_name").addClass('is-invalid'); $("#referral").val(null);
                            }
                        }
                    });
                }else{
                    $("#referral").val(null); $("#ref-error").html('Please enter valid user code or email.');
                    $("#ref-error").removeClass('text-success'); $("#ref-error").addClass('text-danger');
                    $("#partner_name").removeClass('is-valid'); $("#partner_name").removeClass('is-invalid');
                    $("#partner_name").addClass('is-invalid'); $("#ref-error").fadeIn();
                }
            }
            $('.privacy_check').click(function(){
                if($("#privacy_btn")[0].checked){ document.getElementById("submit_btn").disabled = false;
                }else{ document.getElementById("submit_btn").disabled = true; }
            });
            $('#submit_btn').click(function(){
                var errors=false;
                if($("#agent_yes").is(":checked")){
                    if($(".affiliate_check").is(":checked")){ errors=false;
                        $(".affiliate_error").html(''); $(".affiliate_error").slideUp('slow');
                    }
                    else if($(".affiliate_check").is(":not(:checked)")){
                        $(".affiliate_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is check required.');
                        $(".affiliate_error").slideDown('slow');
                        $("#affiliate_check").focus();
                        errors=true;
                    }else{ $(".affiliate_error").html(''); $(".affiliate_error").slideUp('slow'); }
                    if (!$("#partner_name").val()) {
                        $(".partner_name_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required.');
                        $(".partner_name_error").slideDown('slow');
                        $("#partner_name").focus();
                        errors=true;
                    }else{ $(".partner_name_error").html(''); $(".partner_name_error").slideUp('slow'); }
                }else{ errors=false; }

                if ($("#pass_type").html() == "Weak" || $("#pass_type").html() == "Very Weak") {
                    $(".password_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required strong password.');
                    $(".password_error").slideDown('slow');
                    $("#password").focus();
                    errors=true;
                }else{ $(".password_error").html(''); $(".password_error").slideUp('slow'); }
                if (!$("#password").val()) {
                    $(".password_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required.');
                    $(".password_error").slideDown('slow');
                    $("#password").focus();
                    errors=true;
                }else{
                    if ($("#pass_type").html() == "Weak" || $("#pass_type").html() == "Very Weak") {}else{ $(".password_error").html(''); $(".password_error").slideUp('slow');}
                }

                if ($("#password").val() != $("#password-confirm").val()) {
                    $(".password_confirm_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is confirmed password not matched.');
                    $(".password_confirm_error").slideDown('slow');
                    $("#password-confirm").focus();
                    errors=true;
                }
                else{ $(".password_confirm_error").html(''); $(".password_confirm_error").slideUp('slow'); }
                if (!$("#phone").val()) {
                    $(".phone_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required.');
                    $(".phone_error").slideDown('slow');
                    $("#phone").focus();
                    errors=true;
                }
                else{ $(".phone_error").html(''); $(".phone_error").slideUp('slow'); }
                if (!validateEmail($("#email").val())) {
                    $(".email_error").html('<i class="fa fa-info-circle fa-sm"></i> This field has to be a valid email address.');
                    $(".email_error").slideDown('slow');
                    $("#email").focus();
                    errors=true;
                }else{ $(".email_error").html(''); $(".email_error").slideUp('slow'); }
                if (!$("#email").val()) {
                    $(".email_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required.');
                    $(".email_error").slideDown('slow');
                    $("#email").focus();
                    errors=true;
                }else{
                    if (validateEmail($("#email").val())){ $(".email_error").html(''); $(".email_error").slideUp('slow'); }
                }
                if (!$("#last_name").val()) {
                    $(".last_name_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required.');
                    $(".last_name_error").slideDown('slow');
                    $("#last_name").focus();
                    errors=true;
                }else{ $(".last_name_error").html(''); $(".last_name_error").slideUp('slow'); }
                if (!$("#name").val()) {
                    $(".name_error").html('<i class="fa fa-info-circle fa-sm"></i> This field is required.');
                    $(".name_error").slideDown('slow');
                    $("#name").focus();
                    errors=true;
                }else{ $(".name_error").html(''); $(".name_error").slideUp('slow'); }
                if(errors == false){
                    $("#loading_ani").show(); document.getElementById("submit_btn").disabled = true;
                    $("#register_form").submit();
                    $("#submit_btn").hide(); $("#submitting").removeClass('d-none');
                    $("#submitting").addClass('ml-0');
                }
            });
            $("#password").keyup(function(){
                validate_strong_password();
            });
            function validate_strong_password()
            {
                var val=document.getElementById("password").value;
                var meter=document.getElementById("meter");
                var no=0;
                if(val!="")
                {
                    // If the password length is less than or equal to 6
                    if(val.length<=6)no=1;
                    // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
                    if(val.length>6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))no=2;
                    // If the password length is greater than 6 and contain alphabet,number,special character respectively
                    if(val.length>6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))no=3;
                    // If the password length is greater than 6 and must contain alphabets,numbers and special characters
                    if(val.length>6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))no=4;
                    if(no==1)
                    {
                        $("#meter").animate({width:'25%'},300);
                        meter.style.backgroundColor="red";
                        document.getElementById("pass_type").innerHTML="Very Weak";
                        $(".password-info").removeClass('d-none').slideDown('slow');
                    }

                    if(no==2)
                    {
                        $("#meter").animate({width:'50%'},300);
                        meter.style.backgroundColor="#fff51a";
                        document.getElementById("pass_type").innerHTML="Weak";
                    }

                    if(no==3)
                    {
                        $("#meter").animate({width:'75%'},300);
                        meter.style.backgroundColor="#FF8000";
                        document.getElementById("pass_type").innerHTML="Good";
                    }

                    if(no==4)
                    {
                        $("#meter").animate({width:'85%'},300);
                        meter.style.backgroundColor="#3ab300";
                        document.getElementById("pass_type").innerHTML="Strong";
                    }
                }
                else
                {
                    meter.style.backgroundColor="white";
                    document.getElementById("pass_type").innerHTML="";
                    $(".password-info").addClass('d-none').slideUp('slow');
                }
            }
        });
    </script>
@endpush
