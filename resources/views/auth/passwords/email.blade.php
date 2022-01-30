@extends('layouts.front')
@section('page_title','Forget Password')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Forget Password'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Forget Your Password?','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Login','route'=>route('login')],
        2=>['name'=>'Forget Your Password?','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="">
                            <div class="padding_eight_all bg-white">
                                <div class="text-center order_complete">
                                    <i class="fas fa-question-circle"></i>
                                    <div class="heading_s1">
                                        <h3>FORGOT YOUR PASSWORD?</h3>
                                    </div>
                                    <p>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</p>
                                </div>
                                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                                    {{ csrf_field() }}
                                    @if (session('status'))
                                        <div class="msg-alert success">
                                            <span class="msg-closebtn">&times;</span>
                                            <strong><i class="fa fa-check-circle fa-lg"></i></strong>&nbsp; {{ session('status') }}
                                        </div>
                                    @endif
                                    @if ($errors->has('email'))
                                        <div class="msg-alert">
                                            <span class="msg-closebtn">&times;</span>
                                            <strong><i class="fa fa-info-circle fa-lg"></i></strong>&nbsp; {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your Email" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-fill-out btn-block" name="login">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </form>
                                <div class="different_login">
                                    <span> or</span>
                                </div>
                                <div class="form-note text-center">I remember my password? <a href="{{ route('login') }}">Login</a></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection



