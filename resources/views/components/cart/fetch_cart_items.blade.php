<div id="fetch_shopping_cart_data">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                @if(!\Cart::instance('shopping')->content()->isEmpty())
                    <div class="row full_cart_show">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body cart" style="padding: 0">
                                    <div class="table-responsive shop_cart_table">
                                        <table class="table">
                                            <thead >
                                            <tr style="">
                                                <th class="product-thumbnail" style="text-align: center; font-weight: 600">Image</th>
                                                <th class="product-name" style="font-weight: 600">Product Name</th>
                                                <th class="product-price" style="font-weight: 600">Unit Price</th>
                                                @auth
                                                    @if(\auth::user()->employee)
                                                        <th class="product-price" style="font-weight: 600">Lifetime Partner Discount and Price</th>
                                                    @endif
                                                @endauth
                                                <th class="product-quantity" style="font-weight: 600">Quantity</th>
                                                <th class="product-subtotal" style="font-weight: 600">Sub total</th>
                                                <th class="product-remove" style="font-weight: 600">Remove</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(\Cart::instance('shopping')->content() as $item)
                                                <tr class="cart_row_{{$item->rowId}}">
                                                    <td class="product-thumbnail" style="text-align: left; width: 4%;">
                                                        <a href="{{ route('product.details',$item->options->item_slug) }}">
                                                            <img class="rounded-circle" src="{{ asset($item->options->img) }}" alt="{{ $item->name }}" />
                                                        </a>
                                                    </td>
                                                    <td class="product-name" data-title="Product">
                                                        <a href="{{ route('product.quick.view',$item->id) }}" class="popup-ajax">{{ $item->name }}</a>
                                                        <br/>
                                                        <small>
                                                            <?php $data_category_info=\App\Product_category::where('id',$item->options->category_id)->firstOrFail(); ?>
                                                            @if(isset($data_category_info->parent->parent->name))
                                                                <a href="{{ route('products.category.level_check',HashEncode($data_category_info->parent->parent->id)) }}">{{ $data_category_info->parent->parent->name }}</a>
                                                                <strong><i class="fa fa-angle-double-right text-sm"></i></strong>
                                                            @endif
                                                            @if(isset($data_category_info->parent->name))
                                                                <a href="{{ route('products.category.level_check',HashEncode($data_category_info->parent->id)) }}">{{ $data_category_info->parent->name }}</a>
                                                                <strong><i class="fa fa-angle-double-right text-sm"></i></strong>
                                                            @endif
                                                            <a href="{{ route('products.category.level_check',HashEncode($data_category_info->id)) }}">{{ $data_category_info->name }}</a>
                                                        </small>
                                                        <br/>
                                                        <small>Available: {{ get_stock($item->id) }}</small>
                                                    </td>
                                                    <td class="product-price" data-title="Price">
                                                        {{ getCurrencyFormat($item->price) }}
                                                    </td>
                                                    @auth
                                                        @if((\auth::user()->employee))
                                                            <td class="product-price" data-title="Price">
                                                                {{ (\auth::user()->employee)?  getCurrencyFormat($item->options->agent_pay_amount) : getCurrencyFormat($item->price) }}
                                                            </td>
                                                        @endif
                                                    @endauth
                                                    <td class="product-quantity" data-title="Quantity">
                                                        <div class="quantity">
                                                            <button type="button" value="-" data-row-id="{{$item->rowId}}" class="minus_cart">-</button>
                                                            <input type="text" name="quantity" readonly id="qty_{{$item->rowId}}"
                                                                   value="{{$item->qty}}"
                                                                   title="Qty" class="qty" size="4">
                                                            <input type="button" value="+" data-row-id="{{$item->rowId}}" class="plus_cart">
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal" data-title="Total">
                                                        @guest {{ getCurrencyFormat($item->subtotal) }}
                                                        @else  {{ (\auth::user()->employee)?  getCurrencyFormat($item->options->agent_pay_amount*$item->qty) : getCurrencyFormat($item->subtotal) }} @endif
                                                    </td>
                                                    <td class="product-remove" data-title="Remove">
                                                        <a href="javascript:void(0)" data-row-id="{{ $item->rowId }}" class="btn_cart_item_remove"><i class="ti-close"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <div class="border p-3 p-md-4 {{ (\Cart::instance('shopping')->content()->isEmpty())? 'd-none' : '' }}">
                                <div class="heading_s1 mb-3">
                                    <h6 class="text-uppercase">Checkout Invoice</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="cart_total_label text-left">Sub Total</td>
                                            <td class="cart_total_amount text-right"><strong>
                                                    <small>
                                                        @guest {{ getCurrencyFormat(\Cart::instance('shopping')->total()) }}
                                                        @else
                                                            @if(\auth::user()->employee)
                                                                @php $get_sub_total = array();
                                                                                foreach(\Cart::instance('shopping')->content() as $item){ array_push($get_sub_total,$item->options->agent_pay_amount*$item->qty); }
                                                                @endphp
                                                                {{ getCurrencyFormat(array_sum($get_sub_total)) }}
                                                            @else
                                                                {{ getCurrencyFormat(\Cart::instance('shopping')->total()) }}
                                                            @endif
                                                        @endif
                                                    </small></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label text-left">Delivery Charge</td>
                                            <td class="cart_total_amount text-right"><strong><small>{{ getCurrencyFormat(\App\Details::where('key','shipping_amount')->first()->amount) }}</small></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label text-left">Total</td>
                                            <td class="cart_total_amount text-right"><strong><small>
                                                        @guest  {{ getCurrencyFormat((\Cart::instance('shopping')->total()+\App\Details::where('key','shipping_amount')->first()->amount)) }}
                                                        @else
                                                            @if(\auth::user()->employee)
                                                                @php $get_sub_total = array();
                                                        foreach(\Cart::instance('shopping')->content() as $item){ array_push($get_sub_total,$item->options->agent_pay_amount*$item->qty); }
                                                                @endphp
                                                                {{ getCurrencyFormat((array_sum($get_sub_total)+\App\Details::where('key','shipping_amount')->first()->amount)) }}
                                                            @else
                                                                {{ getCurrencyFormat((\Cart::instance('shopping')->total()+\App\Details::where('key','shipping_amount')->first()->amount)) }}
                                                            @endif
                                                        @endif
                                                    </small>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="d-inline-flex mt-4 w-100">
                                <button class="btn btn-line-fill btn-sm delete_all_cart_items w-50">Clear Basket</button>
                                <button class="btn btn-line-fill btn-sm update_all_cart_items w-50">Update Basket</button>
                            </div>
                            <div class="mt-4 d-inline-flex w-100">
                                <a href="{{ route('products')}}" class="btn btn-fill-out btn-sm w-50">Continue Shopping</a>
                                <a href="{{ route('checkout')}}" class="btn btn-fill-out btn-sm w-50">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body cart">
                                    <div class="col-sm-12 empty-cart-cls text-center">
                                        <i class="fa fa-shopping-basket mb-3" style="font-size: 75px;"></i>
                                        <h3 class="text-uppercase"><strong>Your Wellness Basket Is Empty</strong></h3>
                                        <h6 class="mb-3">Add something to make me happy :)</h6>
                                        <a href="{{ route('products') }}" class="btn btn-fill-out btn-md"
                                           data-abc="true">Continue Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="small_divider" style="margin-top: -10px;"></div>
                            <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                            <div class="medium_divider"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
