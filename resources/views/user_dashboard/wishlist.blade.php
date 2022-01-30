@extends('layouts.front')
@section('page_title','Wish-list')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Wish-list'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Wishlist','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Wishlist','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>MY WISHLIST</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-12">
                                        <?php $products=\App\Products::whereIn('id', \App\Wishlist::where('user_id', \auth::user()->id)->orderby('created_at','DESC')->pluck('product_id')->toArray())->where('status', 'PUBLISHED')->wherenull('is_deleted')->paginate(6);?>
                                        @if(count($products)>0)
                                            <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Actions</th>
                                                    <th>Remove</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($products as $row)
                                                    <tr id="pro_view_{{$row->id}}">
                                                        <td class="product-thumbnail"><a href="{{ route('product.details',$row->slug) }}">
                                                                <div class="product_img">
                                                                    <img style="position: absolute; top:0; left: 0; z-index: -1;" class="rounded-circle img_cart{{$row->id}}" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" />
                                                                    <img class="radius_all_5" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $row->name }}">
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="product-name" data-title="Product">
                                                            <a href="{{ route('product.details',$row->slug) }}">
                                                                {{ $row->name }}</a>
                                                            <div class="rating_wrap">
                                                                <span class="rating_num" style="margin-left: 0px;">
                                                                    <div class="d-inline-flex">
                                                                        <span class="mr-1 mt-1"><i class="{{ ($row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                                                        <span>({{ ($row->reviews->count()>0)? round($row->reviews->sum('rate')/$row->reviews->count(),2) : 0 }})</span>
                                                                    </div>
                                                                </span>
                                                                <div class="rating ml-2">
                                                                    <div class="product_rate" style="width:{{ (($row->reviews->count()>0)? (100/5)* $row->reviews->sum('rate')/$row->reviews->count() : 0) }}%"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="product-price" data-title="Price">
                                                            <span class="price">{{ $row->price.".00" }}</span>
                                                            @if($row->discount_price)
                                                                <br/><del style="margin-left: -1px;">{{ $row->actual_price.".00" }}</del>
                                                                <div class="on_sale">
                                                                    <span>{{ $row->discount_percentage }}% Off</span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="product-stock-status" data-title="Stock Status">{!! ($row->stock > 0)? '<span class="badge badge-pill badge-success">In Stock</span>' : '<span class="badge badge-pill badge-danger">Out of stock</span>' !!}</td>
                                                        <td class="product-add-to-cart">
                                                            <input type="hidden" id="pro_name{{ $row->id }}" value="{{$row->name}}"/>
                                                            <input type="hidden" class="pro_quantity_{{ $row->id }}" value="1"/>
                                                            <a href="javascript:void(0)" class="btn btn-fill-out add_to_cart btn_cart_added_{{$row->id}}" data-product-id="{{$row->id}}"><i class="icon-basket-loaded"></i> Add to Cart</a>
                                                        </td>
                                                        <td class="product-remove text-center" data-title="Remove">
                                                            <a href="javascript:void(0)" class="wish_list_remove_product_btn" data-product-id="{{$row->id}}"><i class="ti-close"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="row">
                                                <div class="col-md-12 col-12 grid_item pb-lg-0" id="empty_wish_show">
                                                    <div class="">
                                                        <div class="card-body cart no-border">
                                                            <div class="col-sm-12 empty-cart-cls text-center"><img
                                                                    src="{{ asset('assets/images/empty_wish_list.jpg') }}"
                                                                    width="530" height="530" class="img-fluid mb-4 mr-3">
                                                                <h3 class="text-uppercase"><strong>Your WishList is Empty</strong></h3>
                                                                <p>Seems like you don't have wishes here, choose wish product <br/>and make me happy :)</p>
                                                                <a href="{{ route('products') }}" class="btn btn-fill-out"
                                                                   data-abc="true">Add Product</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
