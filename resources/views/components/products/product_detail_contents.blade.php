<div class="row">
    <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
        <div class="product-image">
            <div class="product_img_box">
                <img style="position: absolute; top:20%; left: 25%; z-index: -1;" width="100px" height="100px" class="rounded-circle img_cart{{$data->id}}" src="{{ asset(($data->thumbnail_image)? $data->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" />
                <img id="product_img"
                     width="100%"
                     height="335px"
                     src='{{ asset(($data->image)? $data->thumbnail_image: 'assets/images/product_img_none/no_product_img.jpg') }}'
                     data-zoom-image="{{ asset(($data->image)? $data->image: 'assets/images/product_img_none/no_product_img.jpg') }}"
                     alt="{{ $data->name }}"/>
                <a href="javascript:void(0)" class="product_img_zoom" title="Zoom">
                    <span class="linearicons-zoom-in"></span>
                </a>
            </div>
            <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="5" data-slides-to-scroll="1" data-infinite="false">
                <div class="item">
                    <a href="#" class="product_gallery_item active" data-image="{{ asset(($data->image)? $data->thumbnail_image: 'assets/images/product_img_none/no_product_img.jpg') }}" data-zoom-image="{{ asset(($data->image)? $data->image: 'assets/images/product_img_none/no_product_img.jpg') }}">
                        <img width="100%" style="height: 50px;" src="{{ asset(($data->image)? $data->thumbnail_image: 'assets/images/product_img_none/no_product_img.jpg') }}" alt="product_small_img1" />
                    </a>
                </div>
                @foreach($data->images as $row)
                    <div class="item">
                        <a href="#" class="product_gallery_item" data-image="{{ asset(($row->image)? $row->image_thumbnail	: 'assets/images/product_img_none/no_product_img.jpg') }}" data-zoom-image="{{ asset(($row->image)? $row->image: 'assets/images/product_img_none/no_product_img.jpg') }}">
                            <img width="100%" style="height: 50px; object-fit: cover;" src="{{ asset(($row->image)? $row->image_thumbnail : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="product_small_img" />
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="p-3 mt-2 border">
                <span>Share Now:</span>
                <div id="shareIconsCount"></div>
                <input type="hidden" id="social_share_url" value="{{ route('product.details',$data->slug) }}"/>
                <input type="hidden" id="social_share_title" value="{{ $data->name }}"/>
                <input type="hidden" id="social_share_description" value="{{ $data->description }}"/>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="pr_detail">
            <div class="product_description">
                <h4 class="product_title">{{ $data->name }}</h4>
                <input type="hidden" id="pro_name" value="{{ $data->name }}" />
                <div class="product_sort_info w-100" style="display: inline-block;">
                    <div class="product_body" style="padding: 0 !important;">{{ \Illuminate\Support\Str::limit($data->description, 200) }}</div>
                </div>
                <div class="product_price">
                    <span class="price">{{ getCurrencyFormat($data->price) }}</span>
                    @if($data->discount_price)
                        <br/>
                        <del>{{ getCurrencyFormat($data->actual_price) }}</del>
                        {{--<div class="on_sale"><span>{{$data->discount_percentage}}% Off</span></div>--}}
                        <div class="on_sale"><span>{{$data->discount_name}}</span></div>
                    @endif
                </div>
                <div class="rating_wrap">
                    <div class="rating">
                        <div class="product_rate" style="width:{{ (($data->reviews->count()>0)? (100/5)* $data->reviews->sum('rate')/$data->reviews->count() : 0) }}%"></div>
                    </div>
                    <span class="rating_num">
                        <div class="d-inline-flex">
                            <span class="mr-1 mt-1"><i class="{{ ($data->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                            <span>({{ $data->reviews->count() }})</span>
                        </div>
                    </span>
                </div>
                @if($data->description)
                    <div class="pr_desc d-block w-100 mb-2" style="margin-top: 85px">
                        <p class="product_body" style="padding: 0 !important;">{{ \Illuminate\Support\Str::limit($data->description, 200) }}</p>
                    </div>
                @else
                    <div class="pr_desc d-block w-100 mt-3"><p>&nbsp;</p></div>
                @endif
                <div class="product_sort_info mt-3 d-block w-100">
                    <table class="table no-border">
                        <tr>
                            <td><small><i class="linearicons-layers mr-1"></i>Item Code</small></td>
                            <td><small>{{ ($data->item_code)? $data->item_code : '-' }}</small></td>
                        </tr>
                        <tr>
                            <td><small><i class="ti-tag mr-1"></i>Purpose</small></td>
                            <td>
                                <small>
                                    @if(isset($data->category->parent->parent->name))
                                        <a href="{{ route('products.category.level_check',HashEncode($data->category->parent->parent->id)) }}"><span class="text-capitalize">{{ $data->category->parent->parent->name }}</span></a>
                                        <strong><i class="fa fa-angle-double-right text-sm"></i></strong>
                                    @endif
                                    @if(isset($data->category->parent->name))
                                        <a href="{{ route('products.category.level_check',HashEncode($data->category->parent->id)) }}"><span class="text-capitalize">{{ $data->category->parent->name }}</span></a>
                                        <strong><i class="fa fa-angle-double-right text-sm"></i></strong>
                                    @endif
                                    <a href="{{ route('products.category.level_check',HashEncode($data->category->id)) }}"><span class="text-capitalize">{{ $data->category->name }}</span></a>
                                </small>
                            </td>
                        </tr>
                        @auth
                            @if(\auth::user()->employee)
                            <tr>
                                <td><small>Lifetime Partner Discount and Price</small></td>
                                <td><small>{!! ($data->direct_commission)? $data->direct_commission."% <br/>(<del>".getCurrencyFormat($data->price)."</del> ".getCurrencyFormat($data->agent_pay_amount).")" : '-' !!}</small></td>
                            </tr>
                            @endif
                        @endauth
                        <tr>
                            <td><small><i class="linearicons-cube mr-1"></i> Stock</small></td>
                            <td><small>{!! (get_stock($data->id)>0)? '<span class="text-success">Available</span>' : '<span class="text-danger">Out of stock</span>' !!}
                            ({{ get_stock($data->id) }})</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr/>
            <div class="cart_extra" id="show_error_review">
                <div class="cart-product-quantity">
                    <div class="quantity">
                        <button type="button" {{ (get_stock($data->id) < 1)? 'disabled' : '' }} value="-" data-stock="{{ get_stock($data->id) }}" class="minus">-</button>
                        <input type="text" readonly name="quantity" value="1" title="Qty" id="stock_check"
                               class="qty pro_quantity_{{ $data->id }}"
                            {{ (get_stock($data->id) < 1)? 'disabled' : '' }}>
                        <input type="button" value="+" {{ (get_stock($data->id) < 1)? 'disabled' : '' }} data-stock="{{ get_stock($data->id) }}" class="plus">
                    </div>
                </div>
                <div class="cart_btn">
                    <button class="btn btn-outline-dark btn-md add_to_cart btn_cart_added_{{$data->id}}" {{ (get_stock($data->id) < 1)? 'disabled' : ''  }} data-product-id="{{$data->id}}"><i class="linearicons-bag2 mt-n2"></i> <span class="pt-5">Add To Basket</span></button>
                    {{--<a href="javascript:void(0)" class="add_compare add-to-comparison" style="margin-top: 8px;" data-product-id="{{ $data->id }}"><i class="icon-shuffle"></i></a>--}}
                    <ul class="pr_action_btn" style="position: absolute !important; margin-top: -40px; margin-left: 220px;">
                        @auth
                            <li><a href="javascript:void(0)" style="" class="btn-md rounded-circle button_wish_cart {{ (\App\Wishlist::where('product_id', $data->id)->where('user_id', \Auth::user()->id)->first())? 'clicked' : 'add-to-wish-list' }} btn_wish_cart_{{$data->id}}" data-product-id="{{ $data->id }}"><i class="icon-heart"></i><i class="fa fa-heart selected"></i></a></li>
                        @else
                            <li><a href="javascript:void(0)" class="add-to-wish-list" data-product-id="invalid_id"><i class="icon-heart"></i></a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
