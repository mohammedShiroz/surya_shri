@extends('backend.layouts.auth')
@section('page_title','Delete all '.$data_type.' details')
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
                <form method="POST" action="{{ route('admin.verify.delete') }}">
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
                    <input type="hidden" value="{{ $data_type }}" name="type" />
                    <p class="text-muted">
                        You have received an email which contains verification code to delete all {{ $data_type }} records.
                        If you haven't received it, Click <a href="{{ route('admin.resend.verification',$data_type) }}">here</a>.
                    </p>
                    <div class="row">
                        <div class="col-12 d-inline-block">
                            <a @if($data_type == "users")
                               href="{{ route('users.index') }}"
                               @elseif($data_type == "orders")
                               href="{{ route('orders.index') }}"
                               @elseif($data_type == "questions")
                               href="{{ route('questions.index') }}"
                               @elseif($data_type == "product-categories")
                               href="{{ route('product-category.index') }}"
                               @elseif($data_type == "products")
                               href="{{ route('products.index') }}"
                               @elseif($data_type == "vouchers")
                               href="{{ route('vouchers.index') }}"
                               @elseif($data_type == "voucher-customers")
                               href="{{ route('voucher-customers.index') }}"
                               @elseif($data_type == "service-categories")
                               href="{{ route('service-category.index') }}"
                               @elseif($data_type == "services")
                               href="{{ route('services.index') }}"
                               @elseif($data_type == "reservations")
                               href="{{ route('reservations.index') }}"
                               @endif
                               class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary pl-5 pr-5 float-right">Verify & Delete</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
@endsection
