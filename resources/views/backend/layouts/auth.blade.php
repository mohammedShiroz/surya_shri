<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title','Admin Login') ::. {{ env('APP_NAME','Surya Sri') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('administration/plugins/fontawesome-free/css/all.min.css') }}">
    @yield('css', view('backend.components.css'))


    <!-- icheck bootstrap -->
    {{--<link rel="stylesheet" href="{{ asset('administration/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">--}}
    <!-- Theme style -->
    {{--<link rel="stylesheet" href="{{ asset('administration/css/adminlte.min.css') }}">--}}
    <style>
        body{ background-image: url('/administration/img/admin_bg.jpg'); background-size: 100% 100%; }
        .btn-primary{ background: #837000; border-color: #837000; }
        .btn-primary:hover{ background: #605000; border-color: #605000; }
        body:before{
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position:absolute;
            top:0;
            left:0;
            background: linear-gradient(to bottom, rgba(131, 112, 0, 0.6), rgba(32, 35, 5, .6));
        }
    </style>
</head>
<body class="hold-transition login-page">
    @include('backend.components.messages')
    @yield('body_content')
</div>
</body>
</html>
