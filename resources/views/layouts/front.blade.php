<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta name="robots" content="index,follow,all"/>
    <meta name="HandheldFriendly" content="True">
    <meta name="generator" content="Keenrabbits"/>
    {{--<meta name="google-translate-customization" content="9f841e7780177523-3214ceb76f765f38-gc38c6fe6f9d06436-c">--}}
    <!-- SITE TITLE -->
    <title>@yield('page_title','Home')  {{ env('APP_NAME')? ( !isset($main_page)? ' ::. '.env('APP_NAME') : '') : '' }}</title>
    <!-- SEO Information -->
    @yield('seo_contents',view('components.general.seo_meta'))
    <meta name="author" content="{{ env('APP_NAME','') }}">
    <meta name="msvalidate.01" content="">
    <meta name="copyright" content="{{ env('APP_NAME','') }}">
    <meta name="google-site-verification" content="">
    <link rel="alternate" hreflang="si" href="">
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon_big.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SITE CSS FILES -->
    @yield('css', view('components.css'))
    @include('components.general.FB_meta')
</head>
<body>
<div id="google_translate_element"></div>
<div id="fb-root"></div>
@if(isset($main_page))
    <style> #loader { top: 18.7%; width: 250px; height: 250px; margin: -150px 0 0 -125px; } #loader-img {  width: 400px; height: 400px;}.loaded-img { -webkit-transform: translateY(-45%); -ms-transform: translateY(-45%); transform: translateY(-45%); } </style>
@else
    <style>#loader { top: 17.7%; width: 200px; height: 200px; margin: -120px 0 0 -100px; } #loader-img {  width: 300px; height: 300px;  margin: -150px 0 0 -150px;}.loaded-img { -webkit-transform: translateY(-65%); -ms-transform: translateY(-90%); transform: translateY(-90%); } </style>
@endif
<!-- LOADER -->
<div id="preloader">
    <div id="loader-img">
        <div id="loader"></div>
    </div>
    <div id="panel_left" class='loader-section section-left'></div>
    <div id="panel_right" class='loader-section section-right'></div>
</div>
<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>
<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat"></div>
@push('script')
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "122962592432631");
        chatbox.setAttribute("attribution", "biz_inbox");
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v12.0'
            });
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endpush
@yield('top_nav',view('components.nav_bar.index',['old_search_word' => (isset($old_search_word)? $old_search_word : '')]))
@yield('body_content')
@yield('footer',view('components.footer'))
@yield('js', view('components.js'))
</body>
</html>
