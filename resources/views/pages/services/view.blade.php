@extends('layouts.front')
@section('page_title',$data->name)
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __($data->name),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.jssocials')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Our Clinique','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Clinique','route'=>route('services')],
            2=>['name'=>$data->category->name,'route'=>route('services.category',$data->category->slug)],
            3=>['name'=>$data->name,'route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                                <div class="product-image">
                                    <div class="product_img_box">
                                        <img id="product_img" src='{{ asset(($data->image)? $data->image : 'assets/images/service_img_none/no_service_img.jpg') }}' data-zoom-image="{{ asset(($data->image)? $data->image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $data->name }}" />
                                        <a href="javascript:void(0)" class="product_img_zoom" title="Zoom">
                                            <span class="linearicons-zoom-in"></span>
                                        </a>
                                    </div>
                                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                                        <div class="item">
                                            <a href="#" class="product_gallery_item active" data-image="{{ asset(($data->image)? $data->image : 'assets/images/service_img_none/no_service_img.jpg') }}" data-zoom-image="{{ asset(($data->image)? $data->image : 'assets/images/service_img_none/no_service_img.jpg') }}">
                                                <img src="{{ asset(($data->image)? $data->image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $data->name }}" />
                                            </a>
                                        </div>
                                        @foreach($data->images as $row)
                                            <div class="item">
                                                <a href="#" class="product_gallery_item" data-image="{{ asset(($row->image)? $row->image_thumbnail : 'assets/images/service_img_none/no_service_img.jpg') }}" data-zoom-image="{{ asset(($row->image)? $row->image : 'assets/images/service_img_none/no_service_img.jpg') }}">
                                                    <img src="{{ asset(($row->image)? $row->image_thumbnail : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $data->name }}" />
                                                </a>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="pr_detail">
                                    <div class="product_description">
                                        <h4 class="product_title"><a href="#">{{ $data->name }}</a></h4>
                                        <h5 class="product_title" style="margin-top: -10px"><small>{{ $data->tag_code }}</small></h5>
                                        <div class="product_price">
                                            <span class="price">{{ getCurrencyFormat($data->price) }}</span>
                                            @if($data->discount_price)
                                                <br/>
                                                <div style="margin-left: -1px;">
                                                    <del>{{ getCurrencyFormat($data->actual_price) }}</del>
                                                    <div class="on_sale"><span>{{$data->discount_percentage}}% Off</span></div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:{{ (($data->reviews->count()>0)? (100/5)* $data->reviews->sum('rate')/$data->reviews->count() : 0) }}%"></div>
                                            </div>
                                            <span class="rating_num">
                                                <div class="d-inline-flex">
                                                    <span class="mr-1 mt-1"><i class="ti-comment"></i></span>
                                                    <span>({{ $data->reviews->count() }})</span>
                                                </div>
                                            </span>
                                        </div>
                                        @if($data->description)
                                            <div class="pr_desc d-block w-100" style="margin-top: 85px">
                                                <p class="product_body" style="padding: 0 !important;">{{ \Illuminate\Support\Str::limit($data->description, 200) }}</p>
                                            </div>
                                        @else
                                            <div class="pr_desc d-block w-100 mt-3"><p>&nbsp;</p></div>
                                        @endif
                                        <div class="product_sort_info">
                                            <ul>
                                                <li><i class="linearicons-clock"></i> Duration:  {{ ($data->duration_hour == null && $data->duration_minutes == null)? '-' : (($data->duration_hour? $data->duration_hour."hr " : '').($data->duration_minutes? $data->duration_minutes."min" : '')) }}</li>
                                                <li><i class="linearicons-calendar-check"></i> Available Days: {{ ($data->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$data->week_days)) : '-' }}</li>
                                                <li><i class="ti-support"></i> Status: {!! ($data->status == 'Available')? '<span class="text-success">Available</span>' : '<span class="text-danger">Not-available</span>' !!}</li>

                                            </ul>
                                            @auth
                                                @if(\auth::user()->employee)
                                                    <table>
                                                        <tr>
                                                            <td width="50%">Lifetime Partner Discount and Price:</td>
                                                            <td>{{ ($data->direct_commission)? $data->direct_commission."%" : '0%' }}<small>{!! ($data->direct_commission)? "<br/>(<del>".getCurrencyFormat($data->price)."</del> ".getCurrencyFormat($data->agent_pay_amount).")" : '-' !!}</small></td>
                                                        </tr>
                                                    </table>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="cart_extra" id="show_error_review">
                                        <div class="cart_btn">
                                            <a href="{{ route('services.booking',$data->slug) }}" class="btn btn-fill-out btn-addtocart pl-4 pr-4"><i class="linearicons-pen-add"></i> Book Now</a>
                                            @auth
                                                <button style="display: {{ (\App\Wishlist::where('user_id',\auth::user()->id)->where('service_id',$data->id)->first())? '' : 'none' }}" class="btn btn-fill-out btn-rm-fav pl-4 pr-4" data-service-id="{{$data->id}}"><i class="fas fa-heart mr-2"></i> My Favorite</button>
                                                <button style="display: {{ (\App\Wishlist::where('user_id',\auth::user()->id)->where('service_id',$data->id)->first())? 'none' : '' }}" class="btn btn-line-fill btn-add-fav pl-4 pr-4" data-service-id="{{$data->id}}"><i class="ti-heart mr-2"></i> Add To My Favorite</button>
                                            @else
                                                <button class="btn btn-line-fill btn-add-fav pl-4 pr-4" data-service-id="invalid_id"><i class="ti-heart mr-2"></i> Add To My Favorite</button>
                                            @endauth
                                        </div>
                                    </div>
                                    <hr />
                                    <ul class="product-meta">
                                        <li>Category: <a href="{{ route('services.category',$data->category->slug) }}">{{ $data->category->name }}</a></li>
                                    </ul>
                                    <div class="product_share">
                                        <span>Share Now:</span>
                                        <div id="shareIconsCount"></div>
                                        <input type="hidden" id="social_share_url" value="{{ route('services.details',[$data->category->slug,$data->slug]) }}"/>
                                        <input type="hidden" id="social_share_title" value="{{ $data->name }}"/>
                                        <input type="hidden" id="social_share_description" value="{{ $data->description }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="small_divider clearfix"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-style3">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ (session('active_tab') && session()->get("active_tab")=='reviews')? '' : 'active' }}" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Description</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (session('active_tab') && session()->get("active_tab")=='reviews')? 'active' : '' }}" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Reviews ({{ $data->reviews->count() }})</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Contact info</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content shop_info_tab">
                                        <div class="tab-pane fade {{ (session('active_tab') && session()->get("active_tab")=='reviews')? '' : 'active show' }}" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                            <p style="font-weight: 600">Regimen Description</p>
                                            {!! ($data->long_description)? $data->long_description : 'No result found!' !!}
                                        </div>
                                        <div class="tab-pane fade {{ (session('active_tab') && session()->get("active_tab")=='reviews')? 'active show' : '' }}" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                            <div class="comments">
                                                <input type="hidden" name="active_tab" value="reviews">
                                                <input type="hidden" id="service_id" name="service_id" value="{{ $data->id  }}"/>
                                                <input type="hidden" id="row" value="3">
                                                <input type="hidden" id="all_reviews_count" value="{{ $data->reviews->count() }}">
                                                <h6 class="product_tab_title mb-3" style="margin-top: -20px;">{{ $data->reviews->count() }} Reviews - <span>{{ $data->name }}</span></h6>
                                                @if ($message = Session::get('success'))
                                                    <div class="msg-alert success">
                                                        <span class="msg-closebtn">&times;</span>
                                                        <strong><i class="fa fa-check-circle fa-lg mr-1"></i></strong>
                                                        {{ $message }}
                                                    </div>
                                                    @push('js')
                                                        <script>
                                                            $('html, body').animate({
                                                                scrollTop: $("#show_error_review").offset().top
                                                            }, 1000);
                                                        </script>
                                                    @endpush
                                                @endif
                                                @if ($message = Session::get('error'))
                                                    <div class="msg-alert danger">
                                                        <span class="msg-closebtn">&times;</span>
                                                        <strong><i class="fa fa-check-circle fa-lg mr-1"></i></strong>
                                                        {{ $message }}
                                                    </div>
                                                    @push('js')
                                                        <script>
                                                            $('html, body').animate({
                                                                scrollTop: $("#show_error_review").offset().top
                                                            }, 1000);
                                                        </script>
                                                    @endpush
                                                @endif
                                                @include('components.services.service_review_data',[
                                                    'service_reviews' => \App\Service_review::where('service_id',$data->id)->whereNull('is_deleted')->orderby('created_at','DESC')->paginate(3),
                                                ])
                                            </div>
                                            @push('css')
                                                <style>
                                                    .fadeout_div{
                                                        background-color: rgba(241,241,241,0.7);
                                                        position: absolute;
                                                        top: 0;
                                                        left: 0;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        text-align: center;
                                                        width: 100%;
                                                        color: grey;
                                                        height: 100%; z-index: 99;
                                                    }
                                                </style>
                                            @endpush
                                            <div
                                                @guest
                                                    class="p-4 radius_all_5"
                                                    style="position: relative;"
                                                @else
                                                    @if(!\auth::user()->bookings)
                                                        class="p-4 radius_all_5"
                                                        style="position: relative;"
                                                    @else
                                                    @if(in_array($data->id,\App\Service_booking::where('user_id',\auth::user()->id)->where('status','Completed')->groupBy('service_id')->pluck('service_id')->toArray()))
                                                    @else
                                                        class="p-4 radius_all_5"
                                                        style="position: relative;"
                                                        @endif
                                                    @endif
                                                @endguest
                                            >
                                                @guest
                                                    <div class="fadeout_div"><i class="fa fa-info-circle mr-1"></i> Please login and give your review.</div>
                                                @endguest
                                                @auth
                                                    @if(!\auth::user()->bookings)
                                                        <div class="fadeout_div">Reviews should only be allowed to after the service booking is completed.<br/>Please book a service and give your review.</div>
                                                    @else
                                                        <?php $booking_ids=\App\Service_booking::where('user_id',\auth::user()->id)->where('status','Completed')->groupBy('service_id')->pluck('service_id')->toArray();?>
                                                        @if(in_array($data->id,$booking_ids)) @else <div class="fadeout_div">Reviews should only be allowed to after the service booking is completed.<br/>Please book a service and give your review.</div> @endif
                                                    @endif
                                                @endauth
                                                <div class="review_form field_form mt-4" id="review_form">
                                                    <h5>Add a review</h5>
                                                    <form action="{{ route('services.add.review') }}" Method="Post" class="row mt-3">
                                                        {{ csrf_field() }}
                                                        <div class="form-group col-12">
                                                            <div class="star_rating" id="review_rate">
                                                                <span data-value="1"><i class="far fa-star"></i></span>
                                                                <span data-value="2"><i class="far fa-star"></i></span>
                                                                <span data-value="3"><i class="far fa-star"></i></span>
                                                                <span data-value="4"><i class="far fa-star"></i></span>
                                                                <span data-value="5"><i class="far fa-star"></i></span>
                                                            </div>
                                                            <input type="hidden" name="active_tab" value="reviews">
                                                            <input type="hidden" id="inputRateValue" name="rate" value="0"/>
                                                            <input type="hidden" id="service_id" name="service_id" value="{{ $data->id  }}"/>
                                                            <input type="hidden" id="user_id" name="user_id" @auth value="{{ \Auth::user()->id  }}" @endauth/>
                                                            @error('rate')
                                                            <span class="text-sm text-danger"><small>Please choose the review rate.</small></span>
                                                            @push('js')
                                                                <script>
                                                                    $('html, body').animate({
                                                                        scrollTop: $("#show_review").offset().top   //id of div to be scrolled
                                                                    }, 1000);
                                                                </script>
                                                            @endpush
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-12">
                                                        <textarea required="required" placeholder="Your review *"
                                                                  class="form-control" id="comments" name="comments"
                                                                  rows="4">{{ old('comments') }}</textarea>
                                                            <span class="text-sm" id="message_error"
                                                                  style="color: darkred; display: none;"><small>Please text your review of the service.</small></span>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <input required="required" placeholder="Enter Name *"
                                                                   class="form-control" id="name" value="{{ old('name') }}" name="name"
                                                                   type="text">
                                                            @error('name')
                                                            <span class="text-sm text-danger"><small>Please text your name.</small></span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <input required="required"
                                                                   class="form-control" type="email" disabled="" placeholder="Email address" @auth value="{{ \Auth::user()->email }}" @endauth>
                                                            @error('user_id')
                                                            <span class="text-sm text-danger"><small>You already used this email to review this product.</small></span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <button type="submit" class="btn btn-fill-out">Submit Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Mobile</td>
                                                    <td><a href="tel:+94769244427">(+94) 769244427</a> </td>
                                                </tr>
                                                <tr>
                                                    <td>E-mail</td>
                                                    <td><a href="mailto:suryashri.ayurveda@gmail.com">suryashri.ayurveda@gmail.com</a> </td>
                                                </tr>
                                                <tr>
                                                    <td>Location</td>
                                                    <td>112 5th Ln, Pannipitiya 10230, Sri-lanka</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            <div class="widget">
                                <h5 class="widget_title">Categories</h5>
                                <ul class="widget_categories">
                                    <li><a href="{{ route('services') }}"><span class="categories_name">All Services</span><span class="categories_num">({{ \App\Service::all()->count() }})</span></a></li>
                                    @foreach(\App\Service_category::orderby('order','ASC')->where('visibility',1)->get() as $row)
                                        <li><a href="{{ route('services.category',$row->slug) }}"><span class="categories_name">{{ $row->name }}</span><span class="categories_num">({{ $row->services->count() }})</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget">
                                <h5 class="widget_title">Recent Services</h5>
                                <ul class="widget_recent_post">
                                    @foreach(\App\Service::where('visibility',1)->WhereNull('is_deleted')->orderby('created_at','DESC')->limit(4)->get() as $row)
                                    <li>
                                        <div class="post_img">
                                            <a href="{{ route('services.details',[$row->category->slug, $row->slug]) }}"><img class="radius_all_5" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $row->name }}"></a>
                                        </div>
                                        <div class="post_content">
                                            <h6 class="product_title"><a href="{{ route('services.details',[$row->category->slug, $row->slug]) }}">{{ $row->name }}</a></h6>
                                            <div class="product_price"><span class="price">{{ getCurrencyFormat($row->price) }}</span></div>
                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:{{ (($row->reviews->count()>0)? (100/5)* $row->reviews->sum('rate')/$row->reviews->count() : 0) }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget p-2 border">
                                <div class="shop_banner ">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="icon_box text-center">
                                                <div class="icon">
                                                    <i class="flaticon-herbal"></i>
                                                </div>
                                                <div class="icon_box_content p-0">
                                                    <h5>Prakrti Parīksha</h5>
                                                    <p>Find out which wellness and beauty products and services are recommended for you!
                                                        <br/><span style="font-weight: 600;">Balancing <span class="line">&#73;</span> Revitalizing</span></p>
                                                    <a href="{{ route('prakrti.products') }}" class="btn btn-md btn-primary pl-5 pr-5 pt-2 pb-2 bg-primary">Check Now &nbsp;</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12  mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="large_divider"></div>
                        <div class="heading_s1">
                            <h4>Related Services</h4>
                        </div>
                        <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "992":{"items": "3"}, "1199":{"items": "4"}}'>
                            @if($data->category->services->count()>0)
                                @foreach($data->category->services  as $service_row)
                                    @if($service_row->id != $data->id)
                                        <div class="item">
                                            <div class="product" style="border: 2px solid #f4f4f4; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                                <div class="product_img" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                                    <a href="{{ route('services.details',[$data->slug, $service_row->slug]) }}">
                                                        <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                                    </a>
                                                    <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$data->slug, $service_row->slug]) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                                    <div class="product_action_box">
                                                        <ul class="list_none ">
                                                            <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title"><a href="{{ route('services.details',[$data->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
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
                                                    <div class="rating_wrap ml-n1">
                                                        <span class="rating_num">
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
                                    @endif
                                @endforeach
                            @else
                                <p class="text-black mt-3" style="color: black;"><i class="fa fa-info-circle"></i> No result found!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.shorten.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/page/services_reviews.js') }}"></script>
@endpush
