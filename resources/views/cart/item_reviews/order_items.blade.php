<div class="table-responsive shop_cart_table no-border" id="fetch_order_items">
    <table class="table no-border">
        <thead class="no-border">
        <tr style="" class="no-border">
            <th class="product-thumbnail" align="center">Image</th>
            <th class="product-name" style="font-weight: 600">Product Name</th>
            <th class="product-price" style="font-weight: 600">Unit Price</th>
            @if(\auth::user()->employee  || $discount_activate)
                <th class="product-price" style="font-weight: 600">Lifetime Partner Discount and Price</th>
            @endif
            <th class="product-quantity" style="font-weight: 600">Quantity</th>
            <th class="product-subtotal" style="font-weight: 600">Sub total</th>
        </tr>
        </thead>
        <tbody class="no-border">
        @foreach(\Cart::instance('shopping')->content() as $item)
            <tr class="cart_row_{{$item->rowId}}">
                <td class="product-thumbnail" style="text-align: left; width: 4%;">
                    <a href="{{ route('product.details',$item->options->item_slug) }}">
                        <img class="rounded-circle" src="{{ asset($item->options->img) }}" alt="{{ $item->name }}" />
                    </a>
                </td>
                <td class="product-name" data-title="Product">
                    <a href="{{ route('product.quick.view',$item->id) }}" class="popup-ajax"><strong>{{ $item->name }}</strong></a>
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
                @if((\auth::user()->employee) || $discount_activate)
                    <td class="product-price" data-title="Price">
                        {{ (\auth::user()->employee || $discount_activate)?  getCurrencyFormat($item->options->agent_pay_amount) : getCurrencyFormat($item->price) }}
                    </td>
                @endif
                <td class="product-quantity" data-title="Quantity">
                    <div class="quantity">{{$item->qty}}</div>
                </td>
                <td class="product-subtotal" data-title="Total">
                    {{ (\auth::user()->employee || $discount_activate)?  getCurrencyFormat($item->options->agent_pay_amount*$item->qty) : getCurrencyFormat($item->subtotal) }}
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>
