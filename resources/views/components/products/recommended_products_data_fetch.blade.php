<div class="filter_data">
    <div class="row shop_container loadmore" data-item="20" data-item-show="4"
         data-finish-message="No More products to Show" data-btn="Load More">
        @if($products->count() > 0)
            @foreach($products as  $row)
                <div class="col-md-4 col-6 grid_item" id="pro_view_{{$row->id}}">
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
                                    <li class="add-to-cart"><a href="JavaScript:void(0)" class="add_to_cart button_add_cart btn_cart_added_{{$row->id}}" data-product-id="{{$row->id}}" ><i class="icon-basket-loaded"></i><i class="icon-check"></i></a></li>
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
                                    <span><i class="ti-tag"></i><a href="">{{ $row->category->name }} Product</a></span>
                                @endif
                            </div>
                            <div class="rating_wrap">
                                <span class="rating_num" style="margin-left: -1px">
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
                                <span class="rating_num {{ (get_stock($row->id) > 0)? 'text-success' : 'text-danger' }} mb-1"><i class="flaticon-herbal mr-2"></i> {{ (get_stock($row->id) > 0)? 'Stock Available' : 'Out of stock' }}</span>
                            </div>
                            <div class="list_product_action_box">
                                <ul class="list_none pr_action_btn">
                                    <li class="add-to-cart">
                                        <button class="cart-button-offline add_to_cart btn_cart_added_{{$row->id}}" data-product-id="{{$row->id}}"> <span class="add-to-cart"> Add To Cart</span> <span class="added">Item Added</span> <i class="icon-basket-loaded"></i> <i class="fa fa-circle-thin"></i> <i class="fa fa-check"></i> </button>
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
            <div class="col-md-12 col-12 grid_item pb-lg-0">
                <div class="msg-alert warning bg-transparent text-black-50 border-bottom border-left border-top border-right">
                    <span class="msg-closebtn text-black-50">&times;</span>
                    <strong><i class="fa fa-info fa-lg "></i></strong>&nbsp; No Result found!
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            {{ $products->links('pagination.default') }}
        </div>
    </div>
</div>
