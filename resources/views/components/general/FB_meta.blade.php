@if(isset($fb_customs_product_info))
    @if($fb_customs_product_info==true)
        <meta property="og:site_name" content="{{ env('APP_NAME') }}">
        <?php if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') $link = "https";
        else $link = "http";
        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];
        $link .= $_SERVER['REQUEST_URI'];?>
        <meta property="og:url" content="{{ $link }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:locale" content="tr_TR">
        <meta property="og:title" content="{{ $data->name }}"/>
        <meta property="og:description" content="{{ $data->description }}"/>
        <meta property="og:image" content="{{ asset(($data->thumbnail_image)? $data->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}"/>
    @endif
@elseif(isset($fb_customs_service_info))
    @if($fb_customs_service_info==true)
        <meta property="og:site_name" content="{{ env('APP_NAME') }}">
        <?php if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') $link = "https";
        else $link = "http";
        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];
        $link .= $_SERVER['REQUEST_URI'];?>
        <meta property="og:url" content="{{ $link }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:locale" content="tr_TR">
        <meta property="og:title" content="{{ $data->name }}"/>
        <meta property="og:description" content="{{ $data->description }}"/>
        <meta property="og:image" content="{{ asset(($data->thumbnail_image)? $data->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}"/>
    @endif
@else
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:url" content="https://www.suryashri.com/"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="tr_TR">
    <meta property="og:title" content="{{ env('APP_NAME') }}"/>
    <meta property="og:description" content="{{ env('APP_NAME') }}"/>
    <meta property="og:image" content="{{ asset('logo.png') }}"/>
@endif
