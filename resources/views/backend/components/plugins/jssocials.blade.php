@push('css')
    <link rel="stylesheet" href="{{ asset('administration/plugins/jssocials/css/jssocials.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/jssocials/css/jssocials-theme-flat.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endpush
@push('js')
    <script src="{{ asset('administration/plugins/jssocials/js/jssocials.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $("#shareIconsCount").jsSocials({
            url: $("#social_share_url").val(),
            text: $("#social_share_title").val(),
            description: $("#social_share_description").val(),
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
@endpush
