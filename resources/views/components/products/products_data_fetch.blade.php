<div class="filter_data">
    <div class="row shop_container loadmore" data-item="20" data-item-show="4"
         data-finish-message="No More products to Show" data-btn="Load More">
        @if(isset($old_search_word))
            @if($products->count() > 0)
            <div class="col-md-12 col-12 grid_item pb-lg-0">
                <div class="msg-alert warning bg-transparent text-black-50 border-bottom border-left border-top border-right">
                    <span class="msg-closebtn text-black-50">&times;</span>
                    <strong><i class="fa fa-search"></i></strong>&nbsp; <strong>{{ $products->count() }}</strong> Result found!
                </div>
            </div>
            @endif
        @endif
        @if($products->count() > 0)
            @foreach($products as  $row)
                <div class="col-md-4 col-6 grid_item" id="pro_view_{{$row->id}}">
                    @if($is_wish_list_available == true)
                        <span class="pr_flash_button wish_list_remove_product_btn" data-product-id="{{$row->id}}"><i class="ti-trash mr-1"></i> Remove</span>
                    @endif
                    <div class="product">
                        @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                            <span class="pr_flash bg-success">New</span>
                        @endif
                        @if($row->discount_percentage)
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
                            <span class="pr_flash_disc bg-success">{{ $row->discount_percentage }}% Off</span>
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
                                        <li><a href="javascript:void(0)" class="button_wish_cart {{ (\App\Wishlist::where('product_id', $row->id)->where('user_id', \Auth::user()->id)->first())? 'clicked' : '' }} add-to-wish-list btn_wish_cart_{{$row->id}}" data-product-id="{{ $row->id }}"><i class="icon-heart"></i><i class="fa fa-heart selected"></i></a></li>
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
                                <span class="price">{{ getCurrencyFormat($row->price) }}</span>
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
                                <span class="rating_num" style="margin-left: 0px;">
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
                            <div class="pr_switch_wrap">
                                <span style="margin-left: 0px;" class="rating_num {{ (get_stock($row->id) > 0)? 'text-success' : 'text-danger' }} mb-1">{{ (get_stock($row->id) > 0)? 'Stock Available' : 'Out of stock' }}</span>
                            </div>
                            <div class="list_product_action_box">
                                <ul class="list_none pr_action_btn">
                                    <li class="add-to-cart">
                                        <button class="cart-button-offline add_to_cart btn_cart_added_{{$row->id}}" data-product-id="{{$row->id}}" > <span class="add-to-cart"> Add To Cart</span> <span class="added">Item Added</span> <i class="icon-basket-loaded"></i> <i class="fa fa-circle-thin"></i> <i class="fa fa-check"></i> </button>
                                        <!--<a href="#" class="add_to_cart button_add_cart"><i class="icon-basket-loaded"></i> </a>-->
                                    </li>
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
                    </div>
                </div>
            @endforeach
        @else
            @if($is_wish_list_available == true)
                <div class="col-md-12 col-12 grid_item pb-lg-0" id="empty_wish_show">
                    <div class="">
                        <div class="card-body cart no-border">
                            <div class="col-sm-12 empty-cart-cls text-center"><img
                                        src="{{ asset('assets/images/empty_wish_list.jpg') }}"
                                        width="530" height="530" class="img-fluid mb-4 mr-3">
                                <h3 class="text-uppercase"><strong>Your WishList is Empty</strong></h3>
                                <p>Seems like you don't have wishes here, choose wish product <br/>and make me happy :)</p>
                                <a href="{{ route('products') }}" class="btn btn-fill-out"
                                   data-abc="true">continue shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12 col-12 grid_item pb-lg-0">
                    <div class="msg-alert warning bg-transparent text-black-50 border-bottom border-left border-top border-right">
                        <span class="msg-closebtn text-black-50">&times;</span>
                        <strong><i class="fa fa-info fa-lg "></i></strong>&nbsp; No Result found!
                    </div>
                </div>
            @endif
        @endif
    </div>
    @if($is_wish_list_available != true)
    <div class="row">
        <div class="col-12">
            {{ $products->links('pagination.default') }}
        </div>
    </div>
    @endif
</div>
