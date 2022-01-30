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
                <p class="login-box-msg">Sign in to see your dashboard</p>
            @endif
            <form action="{{ route('admin.login.submit') }}" method="post">
               @csrf
                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }} mb-3">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }} mb-3">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" style="font-weight: normal">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="{{ route('admin.password.request') }}">Forgot password?</a>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary btn-block">Sign-in</button>
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
