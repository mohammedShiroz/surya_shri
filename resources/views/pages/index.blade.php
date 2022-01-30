@extends('layouts.front',['main_page' => 'yes'])
@section('page_title', env('APP_NAME').' Home')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Surya Sri Ayurweda Home'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('top_nav',view('components.nav_bar.index'))
@section('body_content')
    <!-- START SECTION BANNER -->
    <!-- START SECTION BANNER -->
    <div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap" style="margin-top: 55px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="carouselExampleControls" class="carousel slide light_arrow" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active background_bg" data-vidbg-bg="mp4: ../assets/video/production.mp4, webm: ..assets/video/300052515.webm, poster: ../assets/video/video-img.webp" data-vidbg-options="loop: true, muted: true, overlay: true">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-12 col-12">
                                        <div class="banner_content overflow-hidden">
                                            <h2 class="staggered-animation text-white text-center text-md-left">WELLNESS  WITH  <br/>AYURVEDA</h2>
                                            <a class="btn btn-fill-out rounded-0 text-uppercase btn-fill-out-white btn-md d-none d-md-inline-block" href="{{ route('prakrti.products') }}">What's Your Prakrti?</a>
                                        </div>
                                        <div class="text-center d-sm-inline d-md-none d-lg-none">
                                            <a href="{{ route('prakrti.products') }}" class="btn btn-fill-out btn-fill-out-white btn-md btn-lg staggered-animation text-uppercase" data-animation="fadeInUp" data-animation-delay="0.5s">What's Your Prakrti?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item background_bg" data-img-src="{{ asset('assets/images/banners/1.png') }}">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-12 col-12">
                                        <div class="banner_content overflow-hidden">
                                            <h2 class="staggered-animation text-center text-md-left text-white" data-animation="fadeIn" data-animation-delay="0.3s" style="font-size: 40px; font-weight: 500;">Pamper yourself with pure<br/><strong style="font-family: 'surya_front' !important;">TREASURES</strong></h2>
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase d-none d-md-inline-block d-lg-inline-block" href="{{ route('products') }}">Shop Now</a>
                                        </div>
                                        <div class="text-center d-sm-inline d-md-none d-lg-none">
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase" href="{{ route('products') }}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item background_bg" data-img-src="{{ asset('assets/images/banners/2.png') }}">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-12 col-12">
                                        <div class="banner_content overflow-hidden">
                                            <h2 class="staggered-animation text-white text-center text-md-left" data-animation="fadeIn" data-animation-delay="0.3s" style="font-size: 40px; font-weight: 500;">Indulge in authentic ayurveda<br/><strong style="font-family: 'surya_front' !important;">REGIMENS</strong></h2>
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase d-none d-md-inline-block d-lg-inline-block" href="{{ route('services') }}">Book Now</a>
                                        </div>
                                        <div class="text-center d-sm-inline d-md-none d-lg-none">
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase" href="{{ route('services') }}">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item background_bg" data-img-src="{{ asset('assets/images/banners/3.png') }}">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-12 col-12">
                                        <div class="banner_content overflow-hidden">
                                            <h2 class="staggered-animation text-white text-center text-md-left" data-animation="fadeIn" data-animation-delay="0.3s" style="font-size: 40px; font-weight: 500;">Take home the goodness of<br/><strong style="font-family: 'surya_front' !important;">SELF-CARE</strong></h2>
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase d-none d-md-inline-block d-lg-inline-block" href="{{ route('products') }}">Shop Now</a>
                                        </div>
                                        <div class="text-center d-sm-inline d-md-none d-lg-none">
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase" href="{{ route('products') }}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item background_bg" data-img-src="{{ asset('assets/images/banners/4.png') }}">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-12 col-12">
                                        <div class="banner_content overflow-hidden">
                                            <h2 class="staggered-animation text-white text-center text-md-left" data-animation="fadeIn" data-animation-delay="0.3s" style="font-size: 40px; font-weight: 500;">Pamper yourself with pure <br/><strong style="font-family: 'surya_front' !important;">INGREDIENTS</strong></h2>
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase d-none d-md-inline-block d-lg-inline-block" href="{{ route('products') }}">Shop Now</a>
                                        </div>
                                        <div class="text-center d-sm-inline d-md-none d-lg-none">
                                            <a class="btn btn-fill-out btn-fill-out-white btn-md staggered-animation text-uppercase" href="{{ route('products') }}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ol class="carousel-indicators indicators_style1">
                            <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="1"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="2"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="3"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="4"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BANNER -->
    <!-- END MAIN CONTENT -->
    <div>
        <!-- START SECTION CATEGORIES -->
        {{--<div class="section small_pt mt-3 pb-3">--}}
            {{--<div class="container">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-12">--}}
                        {{--<div class="radius_all_5">--}}
                            {{--<div class="row align-items-center">--}}
                                {{--<div class="col-lg-3 col-md-4">--}}
                                    {{--<div class="text-center text-md-left">--}}
                                        {{--<h4>Popular Categories</h4>--}}
                                        {{--<p class="mb-2">There are many variations of products with us</p>--}}
                                        {{--<a href="{{ route('products') }}" class="btn btn-line-fill btn-sm d-none d-sm-none d-md-inline-block">View All</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-9 col-md-8">--}}
                                    {{--<div class="cat_slider mt-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5" data-loop="true" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "1"}, "380":{"items": "2"}, "991":{"items": "3"}, "1199":{"items": "4"}}'>--}}
                                        {{--<?php $get_all_parent_ids=\App\Product_category::where('parent_id',0)->pluck('id')->toArray(); ?>--}}
                                        {{--@foreach(\App\Product_category::where('parent_id',0)->limit(3)->orderby('name','asc')->get() as $row)--}}
                                                {{--<div class="item">--}}
                                                    {{--<div class="categories_box">--}}
                                                        {{--<a href="{{ route('products.category.level_one',HashEncode($row->id)) }}">--}}
                                                            {{--<i class="flaticon-herbal"></i>--}}
                                                            {{--<span>{{ $row->name }}</span>--}}
                                                        {{--</a>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--@foreach($row->children as $child)--}}
                                                    {{--<div class="item">--}}
                                                        {{--<div class="categories_box">--}}
                                                            {{--<a href="{{ route('products.category.level_two',[HashEncode($child->parent->id),HashEncode($child->id)]) }}">--}}
                                                                {{--<i class="flaticon-herbal"></i>--}}
                                                                {{--<span>{{ $child->name }}</span>--}}
                                                            {{--</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--@foreach($child->children as $sub)--}}
                                                        {{--<div class="item">--}}
                                                            {{--<div class="categories_box">--}}
                                                                {{--<a href="{{ route('products.category.level_three',[HashEncode($sub->parent->parent->id),HashEncode($sub->parent->id),HashEncode($sub->id)]) }}">--}}
                                                                    {{--<i class="flaticon-herbal"></i>--}}
                                                                    {{--<span>{{ $sub->name }}</span>--}}
                                                                {{--</a>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--@endforeach--}}
                                                {{--@endforeach--}}
                                        {{--@endforeach--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- END SECTION CATEGORIES -->
        <!-- START SECTION SHOP -->
        <div class="section large_padding pb_70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s4 text-center">
                            <h2>Wellness Boutique</h2>
                        </div>
                        {{--<p class="text-center leads" style="margin-top: -10px;">We use natural Ayurvedic formulations for all products to your peace of mind</p>--}}
                    </div>
                </div>
                <div class="row shop_container">
                    @foreach(\App\Products::where('status','PUBLISHED')->where('visibility','1')->whereNull('is_deleted')->orderby('created_at','desc')->limit(4)->get() as  $row)
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product_box text-center">
                                @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                    <span class="pr_flash bg-success ml-3 radius_all_5">New</span>
                                @endif
                                <div class="product_img">
                                    <a href="{{ route('product.details',$row->slug) }}">
                                        <img style="position: absolute; top:0; left: 0; z-index: -1;" class="rounded-circle img_cart{{$row->id}}" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" />
                                        <img style="object-fit: cover !important;" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $row->name }}">
                                    </a>
                                    <div class="product_action_box" onclick='window.location.href = "{{ route('product.details',$row->slug) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            <input type="hidden" id="pro_name{{ $row->id }}" value="{{$row->name}}"/>
                                            <input type="hidden" class="pro_quantity_{{ $row->id }}" value="1"/>
                                            {{--<li><a href="javascript:void(0)" class="add-to-comparison" data-product-id="{{ $row->id }}"><i class="icon-shuffle"></i></a></li>--}}
                                            <li><a href="{{ route('product.quick.view',$row->id) }}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                            @auth
                                                <li><a href="javascript:void(0)" class="button_wish_cart {{ (\App\Wishlist::where('product_id', $row->id)->where('user_id', \Auth::user()->id)->first())? 'clicked' : 'add-to-wish-list' }} btn_wish_cart_{{$row->id}}" data-product-id="{{ $row->id }}"><i class="icon-heart"></i><i class="fa fa-heart selected-long"></i></a></li>
                                            @else
                                                <li><a href="javascript:void(0)" class="add-to-wish-list" data-product-id="invalid_id"><i class="icon-heart"></i></a></li>
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title"><a href="{{ route('product.details',$row->slug) }}">{{ $row->name }}</a></h6>
                                    <div class="product_price">
                                        <span class="price">{{ getCurrencyFormat($row->price) }}</span><br/>
                                        @if($row->discount_price)
                                            <del>{{ getCurrencyFormat($row->actual_price) }}</del>
                                            <div class="on_sale">
                                                <span>{{ $row->discount_percentage }}% Off</span>
                                            </div>
                                        @else
                                            <span class="d-inline-block w-100" style="height: 10px;"></span>
                                        @endif
                                    </div>
                                    <div class="rating_wrap">
                                        <span class="rating_num">
                                            <div class="d-inline-flex">
                                                <span class="mr-1 mt-1"><i class="{{ ($row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                                <span>({{ $row->reviews->count() }})</span>
                                            </div>
                                        </span>
                                        <div class="rating ml-2">
                                            <div class="product_rate" style="width:{{ (($row->reviews->count()>0)? (100/5)* $row->reviews->sum('rate')/$row->reviews->count() : 0) }}%"></div>
                                        </div>
                                    </div>
                                    <div class="pr_desc">
                                        <p>{{ \Illuminate\Support\Str::limit($row->description, 200) }}</p>
                                    </div>
                                    <div class="add-to-cart">
                                        <a href="JavaScript:void(0)" class="btn btn-line-fill btn-sm add_to_cart button_add_cart btn_cart_added_{{$row->id}}" data-product-id="{{$row->id}}">
                                            <i class="linearicons-bag2 mt-n2"></i>
                                            <span class="mt-5">Add To Basket</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(\App\Products::where('status','PUBLISHED')->where('visibility','1')->whereNull('is_deleted')->orderby('created_at','desc')->get()->count() > 4)
                    <div class="text-center">
                        <a href="{{ route('products') }}" class="btn btn-line-fill btn-radius pl-5 pr-5 pt-md-2 pb-md-2 pt-sm-1 pb-sm-1">View More</a>
                    </div>
                @endif
            </div>
        </div>
        <!-- END SECTION SHOP -->
        <div class="section small_pt pb_70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-sm-12">
                        <div class="icon_box icon_box_style4" style="background: #FFF4B0;">
                            <div class="row align-items-center flex-row-reverse">
                                <div class="col-md-7 offset-md-1">
                                    <div class="medium_divider d-none d-md-block clearfix"></div>
                                    <div class="trand_banner_text text-center text-md-left">
                                        <div class="heading_s1 mb-3">
                                            <h2 class="">Start Your Wellness Journey With Us</h2>
                                        </div>
                                        <p class="mb-4" style="color: #000000;">Suryā  Shri  is  an  oasis  for  well  being
                                            that  proudly  offers  a  large  selection of  products and  services.
                                            We  believe  in  taking  a  holistic  approach to  health,  nurturing  the  physical,  mental  and  emotional  self.
                                            We  integrate  both  traditional  Ceylonese  and  authentic  Ayurvedic  approaches within  all  of  our  practices,  which  aim  to  provide  a  complete  and  exclusive  wellness experience  to  all  of  our  clients.</p>
                                        <a href="{{ route('about-us') }}" class="btn btn-fill-line pl-5 pr-5 pt-2 pb-2 d-md-inline d-lg-inline mb-5">Explore More</a>
                                    </div>
                                    <div class="medium_divider clearfix"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center tranding_img ml-2">
                                        <img class="img-circle rounded-circle img-responsive" src="{{ asset('assets/images/banners/middleBannerImages.png') }}" alt="about_image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb_70 mt-n4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s4 text-center">
                            <h2>Our Authentic Ayurveda Clinique</h2>
                        </div>
                    </div>
                </div>
                <!-- END SECTION BANNER -->
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header text-center">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs justify-content-center justify-content-md-end" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="service-tab-all" data-toggle="tab" href="#service_all" role="tab" aria-controls="service_all" aria-selected="true">All</a>
                                    </li>
                                    @foreach(\App\Service_category::orderby('order','ASC')->where('visibility',1)->whereNull('is_deleted')->get() as $row)
                                        <li class="nav-item">
                                            <a class="nav-link" id="service-tab-{{ $loop->index }}" data-toggle="tab" href="#service_{{ $loop->index }}" role="tab" aria-controls="service_{{ $loop->index }}" aria-selected="true">{{ $row->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab_slider">
                            <div class="tab-pane fade show active" id="service_all" role="tabpanel" aria-labelledby="service-tab-all">
                                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1 dot_style1" data-loop="false" data-dots="false" data-nav="false" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                                    @foreach(\App\Service::whereNull('is_deleted')->where('visibility','1')->orderby('created_at','DESC')->limit(4)->get()  as $service_row)
                                        <div class="item">
                                            <div class="product" style="border: 2px solid #f4f4f4; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                                @auth
                                                    @if(\auth::user()->employee)
                                                        @push('css')
                                                            <style>
                                                                .pr_flash_disc {
                                                                    background-color: #FF9F00;
                                                                    position: absolute;
                                                                    right: 10px;
                                                                    top: 10px;
                                                                    text-transform: uppercase;
                                                                    color: #fff;
                                                                    padding: 2px 8px;
                                                                    font-size: 13px;
                                                                    z-index: 1;
                                                                }
                                                            </style>
                                                        @endpush
                                                        @if($service_row->direct_commission)
                                                            <span class="pr_flash_disc bg-success">{{ ($service_row->direct_commission)? $service_row->direct_commission."% Off" : '' }}</span>
                                                        @endif
                                                    @endif
                                                @endauth
                                                <div class="product_img" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                                    <a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">
                                                        <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                                    </a>
                                                    <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$row->slug, $service_row->slug]) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                                    <div class="product_action_box">
                                                        <ul class="list_none ">
                                                            <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title"><a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
                                                        <br/><small title="{{ $service_row->tag_code }}">{{ $service_row->tag_code }}</small></h6>
                                                    <div class="product_price mb-2" style="height: 95px">
                                                        <small><i class="ti-alarm-clock mr-1"></i> {{ ($service_row->duration_hour == null && $service_row->duration_minutes == null)? '-' : (($service_row->duration_hour? $service_row->duration_hour."hr " : '').($service_row->duration_minutes? $service_row->duration_minutes."min" : '')) }}</small><br/>
                                                        <small><i class="ti-calendar mr-1"></i> {{ ($service_row->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$service_row->week_days)) : '-' }}</small><br/>
                                                        <span class="price mt-1 ml-n0">
                                                            {{ getCurrencyFormat($service_row->price) }}
                                                        </span><br/>
                                                        @if($service_row->discount_price)
                                                            <div class="ml-n1">
                                                                <del>{{ getCurrencyFormat($service_row->actual_price) }}</del>
                                                                <div class="on_sale">
                                                                    <span>{{ $service_row->discount_percentage }}% Off</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="d-inline-block w-100" style="height: 10px;"></span>
                                                        @endif
                                                    </div>
                                                    <div class="rating_wrap">
                                                        <span class="rating_num" style="margin-left: 0">
                                                            <div class="d-inline-flex">
                                                                <span class="mr-1 mt-1"><i class="{{ ($service_row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                                                <span>({{ $service_row->reviews->count() }})</span>
                                                            </div>
                                                        </span>
                                                        <div class="rating ml-2">
                                                            <div class="product_rate" style="width:{{ (($service_row->reviews->count()>0)? (100/5)* $service_row->reviews->sum('rate')/$service_row->reviews->count() : 0) }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if(\App\Service::whereNull('is_deleted')->where('visibility','1')->get()->count()  > 4)
                                    <div class="text-center mt-5">
                                        <a href="{{ route('services') }}" class="btn btn-line-fill btn-radius pl-5 pr-5 pt-md-2 pb-md-2 pt-sm-1 pb-sm-1">View More</a>
                                    </div>
                                @endif
                            </div>
                            @foreach(\App\Service_category::orderby('order','ASC')->whereNull('is_deleted')->where('visibility','1')->get() as $row)
                                <div class="tab-pane fade" id="service_{{ $loop->index }}" role="tabpanel" aria-labelledby="service-tab-{{ $loop->index }}">
                                    <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1 dot_style1" data-loop="false" data-dots="false" data-nav="false" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                                        @if(\App\Service::where('category_id',$row->id)->whereNull('is_deleted')->where('visibility','1')->orderby('created_at','DESC')->limit(4)->get()->count()>0)
                                            @foreach(\App\Service::where('category_id',$row->id)->whereNull('is_deleted')->where('visibility','1')->orderby('created_at','DESC')->limit(4)->get()  as $service_row)
                                                <div class="item">
                                                    <div class="product" style="border: 2px solid #f4f4f4; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                                        @auth
                                                            @push('css')
                                                                <style>
                                                                    .pr_flash_disc {
                                                                        background-color: #FF9F00;
                                                                        position: absolute;
                                                                        right: 10px;
                                                                        top: 10px;
                                                                        text-transform: uppercase;
                                                                        color: #fff;
                                                                        padding: 2px 8px;
                                                                        font-size: 13px;
                                                                        z-index: 1;
                                                                    }
                                                                </style>
                                                            @endpush
                                                            @if(\auth::user()->employee)
                                                                @if($service_row->direct_commission)
                                                                    <span class="pr_flash_disc bg-success">{{ ($service_row->direct_commission)? $service_row->direct_commission."% Off" : '' }}</span>
                                                                @endif
                                                            @endif
                                                        @endauth
                                                        <div class="product_img" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                                            <a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">
                                                                <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                                            </a>
                                                            <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$row->slug, $service_row->slug]) }}";' style="position: absolute; bottom: 0; background: transparent; height: 140px;"></div>
                                                            <div class="product_action_box">
                                                                <ul class="list_none ">
                                                                    <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="product_info">
                                                            <h6 class="product_title"><a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
                                                                <br/><small title="{{ $service_row->tag_code }}">{{ $service_row->tag_code }}</small></h6>
                                                            <div class="product_price mb-2" style="height: 95px">
                                                                <small><i class="ti-alarm-clock mr-1"></i> {{ ($service_row->duration_hour == null && $service_row->duration_minutes == null)? '-' : (($service_row->duration_hour? $service_row->duration_hour."hr " : '').($service_row->duration_minutes? $service_row->duration_minutes."min" : '')) }}</small><br/>
                                                                <small><i class="ti-calendar mr-1"></i> {{ ($service_row->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$service_row->week_days)) : '-' }}</small><br/>
                                                                <span class="price mt-1">{{ getCurrencyFormat($service_row->price) }}</span><br/>
                                                                @if($service_row->discount_price)
                                                                    <div class="ml-n1">
                                                                        <del>{{ getCurrencyFormat($service_row->actual_price) }}</del>
                                                                        <div class="on_sale">
                                                                            <span>{{ $service_row->discount_percentage }}% Off</span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <span class="d-inline-block w-100" style="height: 10px;"></span>
                                                                @endif
                                                            </div>
                                                            <div class="rating_wrap">
                                                                <span class="rating_num" style="margin-left: 0">
                                                                    <div class="d-inline-flex">
                                                                        <span class="mr-1 mt-1"><i class="{{ ($service_row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                                                        <span>({{ $service_row->reviews->count() }})</span>
                                                                    </div>
                                                                </span>
                                                                <div class="rating ml-2">
                                                                    <div class="product_rate" style="width:{{ (($service_row->reviews->count()>0)? (100/5)* $service_row->reviews->sum('rate')/$service_row->reviews->count() : 0) }}%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-center mt-3"><i class="fa fa-info-circle"></i> No result found!</p>
                                        @endif
                                    </div>
                                    @if($row->services->count()  > 4)
                                        <div class="text-center mt-5">
                                            <a href="{{ route('services.category',$row->slug) }}" class="btn btn-line-fill btn-radius pl-5 pr-5 pt-md-2 pb-md-2 pt-sm-1 pb-sm-1">View More</a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
        <div class="section small_pt pb_70 mt-n4">
            <div class="container">
                <!-- START SECTION TESTIMONIAL -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s1 text-center">
                            <h2>Client Appreciation</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2" data-nav="false" data-dots="true" data-center="true" data-loop="true" data-autoplay="true" data-items='1'>
                            <div class="testimonial_box">
                                <div class="testimonial_desc">
                                    <p>This is your Testimonial quote. It’s a great place to share reviews about you, your personal qualities and your services. Add client details for extra credibility and get your future clients excited from day one!</p>
                                </div>
                                <div class="author_wrap">
                                    <div class="author_img">
                                        <img src="{{ asset('assets/images/avatar.png') }}" class="rounded-circle" alt="Avatar" />
                                    </div>
                                    <div class="author_name">
                                        <h6>Avery Smith</h6>
                                        <span class="d-block mt-n1"><small>Customer</small></span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial_box">
                                <div class="testimonial_desc">
                                    <p>This is your Testimonial quote. It’s a great place to share reviews about you, your personal qualities and your services. Add client details for extra credibility and get your future clients excited from day one!</p>
                                </div>
                                <div class="author_wrap">
                                    <div class="author_img">
                                        <img src="{{ asset('assets/images/avatar.png') }}" class="rounded-circle" alt="Avatar" />
                                    </div>
                                    <div class="author_name">
                                        <h6>Avery Smith</h6>
                                        <span class="d-block mt-n1"><small>Customer</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SECTION TESTIMONIAL -->
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
@endsection
@push('js')
    <!-- video -->
    <script src="{{ asset('assets/plugins/video/jquery.vide.js') }}"></script>
@endpush
