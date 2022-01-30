<div class="ajax_quick_view">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jssocials.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/jssocials-theme-flat.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/datetimepicker.css') }}" />
    @include('components.products.product_detail_contents')
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jssocials.min.js')  }}"></script>
    <script>
            $("#shareIconsCount").jsSocials({
            url: $("#socail_share_url").val(),
            text: $("#socail_share_title").val(),
            description: $("#socail_share_description").val(),
            shareIn: "popup",
            showCount: false,
            showLabel: false,
            shares: [
        {share: "twitter", via: "{{ config('app.name') }}", hashtags: "{{ config('app.name') }}"},
            "facebook",
            "linkedin",
            "pinterest",
            "whatsapp",
            ]
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
</div>
