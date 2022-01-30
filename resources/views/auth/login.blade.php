@extends('layouts.front')
@section('page_title','Login')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Login'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Login','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Login','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        @include('components.messages')
                    </div>
                    <div class="col-md-6 col-sm-12 mb-5 mt-5 mt-md-0 mt-sm-5 order-1 order-sm-1 order-md-0">
                        <div class="mt-5 mt-md-0"></div>
                        <div class="bg-white">
                            <h5 class="mb-3">NEW USER<br/><span class="text-main">_____</span></h5>
                            <div class="form-group">
                                <p class="text-justify">Create an account to enjoy lifelong royalty discounts, smoother shopping experiences, hassle-free reservations, revenue bonuses, wellness and lifestyle enhancement updates while being au courant on giveaways, new arrivals,
                                    seasonal offers and much much more...</p>
                                <a style="margin-top: -10px;" href="{{ route('register') }}" class="btn btn-sm btn-line-fill">Register Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 order-0 order-sm-0 order-md-1">
                        <h5 class="mb-3">MEMBER LOGIN<br/><span class="text-main">_____</span></h5>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email*</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Your email" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password*</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                            </div>
                            @if(\Session::has('required_verify'))
                                <div class="form-group">
                                    <a href="{{ route('activation.verify.resend',\Session::get('required_verify')) }}" class="text-primary">Resent Verification Link</a>
                                </div>
                            @endif
                            <div class="login_footer form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember"><span>{{ __('Remember Me') }}</span></label>
                                    </div>
                                </div>
                                <a href="{{ route('password.request') }}">Forgot password?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-md btn-block" name="login">{{ __('Login') }}</button>
                            </div>
                        </form>
                        <div class="different_login">
                            <span> or</span>
                        </div>
                        <div class="form-note text-center">Don't Have an Account? <a href="{{ route('register') }}">Register Now</a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LOGIN SECTION -->
    </div>
    <!-- END MAIN CONTENT -->
@endsection
