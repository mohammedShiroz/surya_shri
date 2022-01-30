@extends('layouts.front')
@section('page_title','Comparison')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Comparison'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@push('js') <script src="{{ asset('assets/js/page/comparison_script.js') }}"></script> @endpush
@push('css') <style> .row_title{ text-align: left; } .btn-outline-danger:hover{ color: white !important; } </style> @endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Comparison','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Products','route'=>route('products')],
            2=>['name'=>'Comparison','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section pb-2">
            <div class="custom-container">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="row">
                            <div class="col-12 pb-2">
                                <div class="dashboard_menu">
                                    <ul class="nav nav-tabs flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab">
                                                <i class="ti-control-shuffle"></i>PRODUCT COMPARISION</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if(\Cart::instance('comparison')->content()->count()>0)
                                    <div class="compare_box">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center">
                                                <tbody>
                                                <tr class="pr_image">
                                                    <td class="row_title">Product Image</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="row_img row_key_{{$loop->index}}">
                                                            <img class="img_cart{{$item->id}} rounded-circle"
                                                                 width="150px" height="150px"
                                                                 src="{{ $item->options->img }}"
                                                                 alt="{{ $item->name }}"></td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_title">
                                                    <td class="row_title">Product Name</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="product_name row_key_{{$loop->index}}"><a
                                                                    href="{{ url('/quick_view/fetch_data/'.$item->id) }}"
                                                                    class="popup-ajax">{{ $item->name }}</a></td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_price">
                                                    <td class="row_title">Price</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="product_price row_key_{{$loop->index}}"><span class="price">
                                                                {{getCurrencyFormat($item->price)}}</span></td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_price">
                                                    <td class="row_title">Discount Actual Price</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="product_price row_key_{{$loop->index}}">
                                                            <span class="price">
                                                                @if($item->options->discount_price)
                                                                    <del>{{ getCurrencyFormat($item->options->actual_price)  }}</del>
                                                                @else
                                                                    -
                                                                @endif
                                                            </span>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_rating">
                                                    <td class="row_title">Rating</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                    <td class="row_btn row_key_{{$loop->index}}">
                                                        <div class="rating_wrap">
                                                            <span class="rating_num">({{ $item->options->reviews_count }})<i class="{{ ($item->options->reviews_count>0)? 'ti-comment-alt' :' ti-comment' }}"></i> </span>
                                                            <div class="rating ml-2">
                                                                <div class="product_rate"
                                                                     @if(round($item->options->reviews_avg_rate,2) < round(100.00,2))
                                                                     @if(round($item->options->reviews_avg_rate,2) < 5 && round($item->options->reviews_avg_rate,2) > 1)
                                                                     style="width:{{ ($item->options->reviews_avg_rate+6) }}%"
                                                                     @else
                                                                     style="width:{{ $item->options->reviews_avg_rate }}%"
                                                                     @endif
                                                                     @elseif($item->options->reviews_avg_rate > 100)
                                                                     style="width:100%"
                                                                    @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_add_to_cart">
                                                    <td class="row_title">Add To Cart</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="row_btn row_key_{{$loop->index}}">
                                                            <input type="hidden" id="pro_name{{ $item->id }}" value="{{$item->name}}"/>
                                                            <input type="hidden" class="pro_quantity_{{ $item->id }}" value="1"/>
                                                            <div class="cart_btn">
                                                                <button class="cart-button-item add_to_cart btn_cart_added_{{$item->id}}" data-product-id="{{$item->id}}"><span class="add-to-cart"> Add To Cart</span><span class="added">Item Added</span> <i class="icon-basket-loaded"></i> <i class="fa fa-circle-thin"></i> <i class="fa fa-check"></i> </button>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                <tr class="description">
                                                    <td class="row_title">Description</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="row_text text-center row_key_{{$loop->index}}">
                                                            <p>{{ \Illuminate\Support\Str::limit($item->options->description, 150) }}</p>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_stock">
                                                    <td class="row_title">Item Availability</td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="row_stock row_key_{{$loop->index}}">
                                                            <span class="{{ ($item->options->stock > 0)? 'in-stock' : 'out-stock' }}">{{ ($item->options->stock > 0)? 'Stock Available' : 'Out of stock' }}</span>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                <tr class="pr_remove">
                                                    <td class="row_remove" align="left">
                                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm remove_comparison_all_item">
                                                        <i class="ti-trash"></i> <span>Remove all</span></a>
                                                    </td>
                                                    @foreach(\Cart::instance('comparison')->content() as $item)
                                                        <td class="row_remove row_key_{{$loop->index}}">
                                                            <a href="javascript:void(0)" class="btn btn-outline-danger remove_comparison_item"
                                                               data-row-id="{{ $item->rowId }}" data-key-id="{{$loop->index}}">
                                                               <i class="ti-trash"></i><span>Remove</span>
                                                            </a>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="">
                                        <div class="card-body cart no-border">
                                            <div class="col-sm-12 empty-cart-cls text-center">
                                                <img src="{{ asset('assets/images/comparision_empty.jpg') }}"
                                                        width="530" height="530" class="img-fluid mb-4 mr-3">
                                                <h3 class="text-uppercase"><strong>Your comparison bucket is empty</strong></h3>
                                                <p>Looks like you haven't made your choice yet.</p>
                                                <a href="{{ route('products') }}" class="btn btn-fill-out"
                                                   data-abc="true">continue shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="show_empty_list" style="display: none">
                                    <div class="card-body cart no-border">
                                        <div class="col-sm-12 empty-cart-cls text-center"><img
                                                    src="{{ asset('assets/images/comparision_empty.jpg') }}"
                                                    width="530" height="530" class="img-fluid mb-4 mr-3">
                                            <h3><strong>Your comparison bucket is empty</strong></h3>
                                            <p>Looks like you haven't made your choice yet.</p>
                                            <a href="{{ route('products') }}" class="btn btn-fill-out"
                                               data-abc="true">continue shopping</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="large_divider clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            <div class="widget">
                                <div class="dashboard_menu">
                                    <ul class="nav nav-tabs flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab"><i class="ti-tag"></i>Categories</a>
                                        </li>
                                    </ul>
                                </div>
                                <h5 class="widget_title"></h5>
                                <ul class="widget_categories">
                                    @if(\App\Product_category::where('parent_id',0)->orderby('name','asc')->get()->count()>0)
                                        <li><a href="{{ route('products') }}"><span class="categories_name">All Categories</span></a></li>
                                        @foreach(\App\Product_category::where('parent_id',0)->orderby('name','asc')->get() as $row)
                                            <li><a href=""><span class="categories_name"> {{ $row->name }}</span>
                                                    <span class="categories_num"></span></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="widget">
                                <h5 class="widget_title">Recent Items</h5>
                                <ul class="widget_recent_post">
                                    {{--@if(count($recent_products)>0)--}}
                                        {{--@foreach($recent_products as $item)--}}
                                            {{--<li>--}}
                                                {{--<div class="post_img">--}}
                                                    {{--@if(!empty($item->product_img))--}}
                                                        {{--<a href="{{ route('view_product',[$item->categories->parent->slug,$item->categories->slug,$item->product_slug]) }}"><img--}}
                                                                    {{--src="{{ asset('uploads/products_images/thumbnail/'.$item->product_img) }}"--}}
                                                                    {{--alt="{{ $item->product_name }}"></a>--}}
                                                    {{--@else--}}
                                                        {{--<a href="{{ route('view_product',[$item->categories->parent->slug,$item->categories->slug,$item->product_slug]) }}"><img--}}
                                                                    {{--src="{{ asset('assets/images/product_img_none/no_product_img.jpg') }}"--}}
                                                                    {{--alt="{{ $item->product_name }}"></a>--}}
                                                    {{--@endif--}}
                                                {{--</div>--}}
                                                {{--<div class="post_content">--}}
                                                    {{--<h6 class="product_title"><a--}}
                                                                {{--href="{{ route('view_product',[$item->categories->parent->slug,$item->categories->slug,$item->product_slug]) }}">{{ $item->product_name }}</a>--}}
                                                    {{--</h6>--}}
                                                    {{--<div class="product_price"><span--}}
                                                                {{--class="price">Rs.{{ $item->product_price }}</span>--}}
                                                        {{--@if(!empty($item->product_spl_price))--}}
                                                            {{--<del>Rs.{{ $item->product_spl_price }}</del>--}}
                                                        {{--@endif--}}
                                                    {{--</div>--}}
                                                    {{--<div class="rating_wrap">--}}
                                                        {{--<div class="rating">--}}
                                                            {{--@if($item->product_condition =="New")--}}
                                                                {{--<div class="product_rate" style="width:100%"></div>--}}
                                                            {{--@elseif($item->product_condition =="Medium")--}}
                                                                {{--<div class="product_rate" style="width:55%"></div>--}}
                                                            {{--@elseif($item->product_condition =="Used")--}}
                                                                {{--<div class="product_rate" style="width:45%"></div>--}}
                                                            {{--@else--}}
                                                                {{--<div class="product_rate" style="width:0%"></div>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                        {{--@endforeach--}}
                                    {{--@else--}}
                                        {{--<p>No Result found!</p>--}}
                                    {{--@endif--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
@endsection

