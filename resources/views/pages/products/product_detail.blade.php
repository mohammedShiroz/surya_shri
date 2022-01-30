@extends('layouts.front')
@section('page_title',$data->name)
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __($data->name),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.jssocials')
@push('css')
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
@endpush
@push('js')
    <!-- magnific-popup min js  -->
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
@endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>$data->name,'paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Products','route'=>route('products')],
        2=>['name'=>$data->name,'route'=>''],
    ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content mt-2">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        @include('components.products.product_detail_contents')
                        <div class="row" id="show_review">
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
                                            <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Additional info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (session('active_tab') && session()->get("active_tab")=='reviews')? 'active' : '' }}" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Reviews ({{ $data->reviews->count() }})</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content shop_info_tab">
                                        <div class="tab-pane fade {{ (session('active_tab') && session()->get("active_tab")=='reviews')? '' : 'active show' }}" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                            {!! ($data->long_description) ? $data->long_description : '-' !!}
                                        </div>
                                        <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Stock</td>
                                                    <td>{{ get_stock($data->id) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Reviews</td>
                                                    <td>
                                                        <div class="rating_wrap">
                                                            <div class="rating">
                                                                <div class="product_rate" style="width:{{ (($data->reviews->count()>0)? (100/5)* $data->reviews->sum('rate')/$data->reviews->count() : 0) }}%"></div>
                                                            </div>
                                                            <small>({{ $data->reviews->count() }})</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade {{ (session('active_tab') && session()->get("active_tab")=='reviews')? 'active show' : '' }}" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                            <div class="comments">
                                                <input type="hidden" name="active_tab" value="reviews">
                                                <input type="hidden" id="product_id" name="product_id" value="{{ $data->id  }}"/>
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
                                                @include('components.products.product_review_data',[
                                                    'product_reviews' => \App\Product_reviews::where('product_id',$data->id)->whereNull('is_deleted')->where('status','1')->orderby('created_at','DESC')->paginate(3),
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
                                                    @if(!\auth::user()->orders)
                                                        class="p-4 radius_all_5"
                                                        style="position: relative;"
                                                    @else
                                                        <?php $order_ids=\App\Orders::where('user_id',\auth::user()->id)->where('status','Confirmed')->where('delivery_status','Delivered')->pluck('id')->toArray(); $order_pic_ids=\App\Orders::where('user_id',\auth::user()->id)->where('status','Confirmed')->where('delivery_status','Self-Pickup')->pluck('id')->toArray(); $order_products =\App\Order_items::whereIn('order_id',array_merge($order_ids,$order_pic_ids))->groupBy('product_id')->pluck('product_id')->toArray();?>
                                                        @if(in_array($data->id,$order_products))
                                                        @else
                                                            class="p-4 radius_all_5"
                                                            style="position: relative;"
                                                        @endif
                                                    @endif
                                                @endguest
                                            >
                                                @guest <div class="fadeout_div"><i class="fa fa-info-circle mr-1"></i> Please login and give your review.</div>@endguest
                                                @auth
                                                    @if(!\auth::user()->orders)
                                                        <div class="fadeout_div"><i class="fa fa-info-circle mr-1"></i> Please buy this product and give your review.</div>
                                                    @else
                                                        <?php $order_ids=\App\Orders::where('user_id',\auth::user()->id)->where('status','Confirmed')->where('delivery_status','Delivered')->pluck('id')->toArray(); $order_pic_ids=\App\Orders::where('user_id',\auth::user()->id)->where('status','Confirmed')->where('delivery_status','Self-Pickup')->pluck('id')->toArray(); $order_products =\App\Order_items::whereIn('order_id',array_merge($order_ids,$order_pic_ids))->groupBy('product_id')->pluck('product_id')->toArray();?>
                                                        @if(in_array($data->id,$order_products)) @else <div class="fadeout_div">Reviews should only be allowed to after the products delivery is completed.<br/>Please buy a this product and give your review.</div> @endif
                                                    @endif
                                                @endauth
                                                <div class="review_form field_form mt-5" id="review_form">
                                                    <h5>Add a review</h5>
                                                    <form action="{{ route('product.add.review') }}" Method="Post" class="row mt-3">
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
                                                            <input type="hidden" id="product_id" name="product_id" value="{{ $data->id  }}"/>
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
                                                                  style="color: darkred; display: none;"><small>Please text your review of the product.</small></span>
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
                                                            <button type="submit" class="btn btn-fill-out">Submit Review
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-4">
                            <div class="col-12">
                            </div>
                        </div>
                        @if(\App\Products::where('status','PUBLISHED')->where('visibility',1)->where('seller_id',$data->seller_id)->where('id','!=',$data->id)->orderby('created_at','DESC')->get()->count()>0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading_s1">
                                        <h5>Related Seller Products</h5>
                                    </div>
                                    <div class="releted_product_slider carousel_slider owl-carousel owl-theme"
                                         data-margin="20"
                                         data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "3"}}'>
                                        @foreach(\App\Products::where('status','PUBLISHED')->where('visibility',1)->where('seller_id',$data->seller_id)->where('id','!=',$data->id)->orderby('created_at','DESC')->get() as $row)
                                            <div class="item">
                                                <div class="product">
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <span class="pr_flash bg-success">New</span>
                                                    @endif
                                                    <div class="product_img">
                                                        <a href="{{ route('product.details',$row->slug) }}">
                                                            <img style="position: absolute; top:0; left: 0; z-index: -1;" class="rounded-circle img_cart{{$row->id}}" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" />
                                                            <img src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $row->name }}">
                                                        </a>
                                                        <div class="product_action_box" onclick='window.location.href = "{{ route('product.details',$row->slug) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <input type="hidden" id="pro_name{{ $row->id }}" value="{{$row->name}}"/>
                                                                <input type="hidden" class="pro_quantity_{{ $row->id }}" value="1"/>
                                                                <li class="add-to-cart"><a href="JavaScript:void(0)" class="add_to_cart button_add_cart btn_cart_added_{{$row->id}}" data-product-id="{{$row->id}}" ><i class="linearicons-bag2"></i><i class="icon-check"></i></a></li>
                                                                {{--<li><a href="javascript:void(0)" class="add-to-comparison" data-product-id="{{ $row->id }}"><i class="icon-shuffle"></i></a></li>--}}
                                                                <li><a href="{{ route('product.quick.view',$row->id) }}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                                @auth
                                                                    <li><a href="javascript:void(0)" class="button_wish_cart {{ (\App\Wishlist::where('product_id', $row->id)->where('user_id', \Auth::user()->id)->first())? 'clicked' : 'add-to-wish-list' }} btn_wish_cart_{{$row->id}}" data-product-id="{{ $row->id }}"><i class="icon-heart"></i><i class="fa fa-heart selected"></i></a></li>
                                                                @else
                                                                    <li><a href="javascript:void(0)" class="add-to-wish-list" data-product-id="invalid_id"><i class="icon-heart"></i></a></li>
                                                                @endauth
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_title">
                                                            <a href="{{ route('product.details',$row->slug) }}">{{ $row->name }}</a></h6>
                                                        <div class="product_price">
                                                            <span class="price">{{ getCurrencyFormat($row->price) }}</span><br/>
                                                            @if($row->discount_price)
                                                                <del>{{ getCurrencyFormat($row->actual_price) }}</del>
                                                                <div class="on_sale">
                                                                    <span>{{ $row->discount_percentage }}% Off</span>
                                                                </div>
                                                            @else
                                                                <span><i class="ti-tag"></i><a href="">{{ $row->category->name }} Product</a></span>
                                                            @endif
                                                        </div>
                                                        <div class="rating_wrap">
                                                            <span class="rating_num" style="margin-left: -1px;">
                                                                <div class="d-inline-flex">
                                                                    <span class="mr-1 mt-1"><i class="{{ ($row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                                                    <span>({{ $row->reviews->count() }})</span>
                                                                </div>
                                                            </span>
                                                            <div class="rating ml-2">
                                                                <div class="product_rate" style="width:{{ (($row->reviews->count()>0)? (100/5)* $row->reviews->sum('rate')/$row->reviews->count() : 0) }}%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="pr_switch_wrap">
                                                            <span class="rating_num {{ (get_stock($row->id) > 0)? 'text-success' : 'text-danger' }} mb-1">{{ (get_stock($row->id) > 0)? 'Stock Available' : 'Out of stock' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-4 mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            <div class="widget">
                                <h5 class="widget_title">Top Categories</h5>
                                <ul class="widget_categories">
                                    <li><a href="{{ route('products') }}"><span class="categories_name">All Categories <span class="categories_num text-danger">({{ \App\Products::where('status','PUBLISHED')->where('visibility',1)->where('stock','>',0)->whereNull('is_deleted')->get()->count() }})</span></span></a></li>
                                    @foreach(\App\Product_category::whereIn('parent_id',\App\Product_category::whereNull('parent_id')->whereNull('is_deleted')->pluck('id')->toArray())->limit(6)->whereNull('is_deleted')->orderby('name','asc')->get() as $row)
                                        @foreach($row->children as $child)
                                            <li>
                                                <a href="{{ route('products.category.level_two',[HashEncode($row->id),HashEncode($child->id)]) }}">
                                                    <span>{{ $child->name }}
                                                        <span class="categories_num text-danger">
                                                            (<?php $second_category_Ids = \App\Product_category::where('parent_id', $child->id)->pluck('id')->push($child->id)->all(); $third_category_Ids = $second_category_Ids = \App\Product_category::whereIn('parent_id', $second_category_Ids)->pluck('id')->push($child->id)->all(); echo \App\Products::whereIn('category_id', $third_category_Ids)->get()->count(); ?>)
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget">
                                <h5 class="widget_title">Recent Items</h5>
                                <ul class="widget_recent_post">
                                    @if(\App\Products::where('status','PUBLISHED')->where('visibility',1)->where('id','!=',$data->id)->orderby('created_at','DESC')->limit(6)->get()->count()>0)
                                        @foreach(\App\Products::where('status','PUBLISHED')->where('visibility',1)->where('id','!=',$data->id)->orderby('created_at','DESC')->limit(6)->get() as $row)
                                            <li>
                                                <div class="post_img">
                                                    <a href="{{ route('product.details',$row->slug) }}">
                                                        <img class="radius_all_5" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $row->name }}"></a>
                                                </div>
                                                <div class="post_content">
                                                    <h6 class="product_title"><a href="{{ route('product.details',$row->slug) }}">{{ $row->name }}</a>
                                                    </h6>
                                                    <div class="product_price" style="margin-top: -7px;">
                                                        <Small>
                                                            <span class="price">{{ getCurrencyFormat($row->price) }}</span>
                                                        </Small>
                                                    </div>
                                                    @if($row->discount_price)
                                                    <div class="product_price" style="margin-left: -3px; margin-top: -7px;">
                                                        <Small>
                                                                <del>{{ getCurrencyFormat($row->actual_price) }}</del>
                                                                <div class="on_sale">
                                                                    <span>{{ $row->discount_percentage }}% Off</span>
                                                                </div>
                                                        </Small>
                                                    </div>
                                                    @endif
                                                    <div class="rating_wrap" style="margin-top: -3px;">
                                                        <small class="mr-1">({{ $row->reviews->count() }})</small>
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:{{ (($row->reviews->count()>0)? (100/5)* $row->reviews->sum('rate')/$row->reviews->count() : 0) }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <p>No Result found!</p>
                                    @endif
                                </ul>
                            </div>
                            <div class="widget">
                                <h5 class="widget_title">Purpose</h5>
                                <div class="tags">
                                    @if(\App\Product_category::whereNull('parent_id')->wherenull('is_deleted')->limit(6)->orderby('order','asc')->get()->count()>0)
                                        @foreach(\App\Product_category::whereNull('parent_id')->wherenull('is_deleted')->limit(4)->orderby('name','asc')->get() as $row)
                                            <a href="{{ route('products.category.level_one',HashEncode($row->id)) }}">{{ $row->name }}</a>
                                        @endforeach
                                    @else
                                        <p>No Result found!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
    <!-- END MAIN CONTENT -->
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.shorten.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/page/product_reviews.js') }}"></script>
@endpush
