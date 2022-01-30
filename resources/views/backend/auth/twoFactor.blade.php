@extends('backend.layouts.auth')
@section('body_content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline">
            <div class="card-header text-center">
                <img src="{{ asset('/administration/img/logo/logo.png') }}" alt="logo" />
            </div>
            <div class="card-body">
                <h2 class="text-uppercase text-center">{{ env('APP_NAME') }}</h2>
                <p class="login-box-msg mt-n2">Two Factor Verification</p>
                @if(session()->has('message'))
                    <p class="alert alert-success">
                        {{ session()->get('message') }}
                    </p>
                @endif
                <form method="POST" action="{{ route('verify.store') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                        </div>
                        <input name="two_factor_code" type="text" class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" required autofocus placeholder="Two Factor Code">
                        @if($errors->has('two_factor_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('two_factor_code') }}
                            </div>
                        @endif
                    </div>
                    <p class="text-muted">
                        You have received an email which contains verification login code.
                        If you haven't received it, Click <a href="{{ route('verify.resend') }}">here</a>.
                    </p>
                    <div class="row">
                        <div class="col-5">
                            <a href="{{ route('admin.logout') }}" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('verify-logout-form').submit();">
                                <i class="fa fa-power-off"></i>&nbsp; Sign out
                            </a>
                        </div>
                        <div class="col-7 text-right">
                            <button type="submit" class="btn btn-primary pl-5 pr-5">Verify Now</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <form id="verify-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
