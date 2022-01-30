@extends('backend.layouts.auth')
@section('body_content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline">
            <div class="card-header text-center">
                <img src="{{ asset('/administration/img/logo/logo.png') }}" alt="logo" />
            </div>
            <div class="card-body">
                @if ($errors->has('email'))
                    <p class="login-box-msg text-red">{{ $errors->first('email') }}</p>
                @elseif($errors->has('password'))
                    <p class="login-box-msg text-red">{{ $errors->first('password') }}</p>
                @elseif(session('error'))
                    <p class="login-box-msg text-red">{{  session('error') }}</p>
                @else
                    <h2 class="text-uppercase text-center">{{ env('APP_NAME') }}</h2>
                    <p class="login-box-msg">Reset Reset</p>
                @endif
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('admin.password.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }} mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }} mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} mb-3">
                        <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
@endsection
