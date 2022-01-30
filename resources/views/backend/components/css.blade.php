<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('administration/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('administration/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('administration/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('administration/plugins/toastr/toastr.min.css') }}">
@stack('css_top')
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('administration/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('administration/css/adminlte.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('administration/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('administration/css/nav_cus.css') }}">
<link rel="stylesheet" href="{{ asset('administration/css/customs.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('administration/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('administration/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<style>
    .set-right{ position: absolute; right: 0.7rem; top: .7rem; }
    .nav-sidebar .nav-item > .nav-link .set-right { transition: transform ease-in-out 0.3s; }
    .nav-sidebar .menu-open > .nav-link i.set-right,.nav-sidebar .menu-is-opening > .nav-link i.set-right { transform: rotate(-90deg);}
    .nav .nav-item .active{ color: #e1c500 !important;}
    .card-header .nav-pills .nav-item .active{ color: #f5f5f5 !important;}
</style>
@stack('css')
