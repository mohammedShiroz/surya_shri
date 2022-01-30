<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title','Dashboard') ::. {{ env('APP_NAME','Surya Sri Ayurweda') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css')}}">
    @yield('css', view('backend.components.css'))
    <!-- Scripts -->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    @include('backend.components.messages')
    @yield('body_content')
    @yield('top_nav',view('backend.components.top_navigation'))
    <?php $get_page_title = null; if(isset($page_name)){$get_page_title = $page_name; }
          $get_width_type = null; if(isset($width_type)){$get_width_type = $width_type; }
    ?>
    @yield('left_nav',view('backend.components.left_navigation',['page_name' => $get_page_title, 'width_type' =>$get_width_type]))
    <footer class="main-footer navbar-dark border-top-0 text-sm" style="background:#231F01;">
        <strong>Copyrights © <script type="text/JavaScript"> document.write(new Date().getFullYear()); </script> Suryā Shri. </strong>
        All Rights Reserved.<div class="float-right d-none d-sm-inline-block"> Developed BY <b>Keen rabbits</b></div>
    </footer>
    @include('backend.visitor.visitorview')
    <!-- /.control-sidebar -->
    @yield('js', view('backend.components.js'))
</div>
</body>
</html>
