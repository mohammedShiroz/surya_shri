@extends('layouts.front')
@section('page_title','Reset Password')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Reset Password'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Reset Your Password?','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Reset Your Password?','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="login_wrap">
                            <div class="padding_eight_all bg-white">
                                <div class="text-center order_complete">
                                    <i class="fas fa-check-circle"></i>
                                    <div class="heading_s1">
                                        <h3>RESET YOUR PASSWORD</h3>
                                    </div>
                                    <p>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</p>
                                </div>
                                <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ $token }}">
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
                                    @if ($errors->has('password'))
                                        <div class="msg-alert">
                                            <span class="msg-closebtn">&times;</span>
                                            <strong><i class="fa fa-info-circle fa-lg"></i></strong>&nbsp; {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="Your Email" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="New Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmation Password" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-fill-out btn-block" name="login">{{ __('Reset Password') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
    <!-- END MAIN CONTENT -->
@endsection
