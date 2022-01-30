<!-- Animation CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
<!-- Latest Bootstrap min CSS -->

<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css')}}">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<!-- Icon Font CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/linearicons.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/flaticon.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css')}}">
@stack('css_top')
<!--- owl carousel CSS-->
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.default.min.css')}}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css')}}">
<!-- Slick CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/slick.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css')}}">
<!-- Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert.min.css') }}">
<style>
    #google_translate_element{ display: none !important;}
    .goog-te-banner-frame,.custom-translate { display: none !important; }
    .goog-te-banner-frame.skiptranslate { display: none !important; }
    body { top: 0 !important; }
    .goog-tooltip { display: none !important; }
    .goog-tooltip:hover { display: none !important; }
    .goog-text-highlight { background-color: transparent !important; border: none !important; box-shadow: none !important; }
</style>
@stack('css')
