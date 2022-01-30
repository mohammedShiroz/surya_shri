    <li id="nav_update_cart_info" class="dropdown cart_dropdown">
        <a class="nav-link cart_trigger" href="#" onclick="return window.location.href = '{{ route('shopping_cart') }}'" data-toggle="dropdown">
            <i class="linearicons-bag2 shake_icon"></i>
            <span class="cart_count">{{ Cart::instance('shopping')->count()}}</span>
        </a>
        <div class="cart_box dropdown-menu dropdown-menu-right">
            <p class="pl-3 pr-3 pt-2 pb-2 text-center text-white" style="background: rgba(153,132,1,1);">My Wellness Basket</p>
            <ul class="cart_list mt-n4">
                <?php $cartData = \Cart::instance('shopping')->content();?>
                @if(count($cartData)>0)
                    @foreach($cartData as $cart_row)
                        <li style="padding: 5px; border: none !important;" class="cart_row_{{$cart_row->rowId}}">
                            <div class="card" style="padding:0; border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                                <div class="card-body" style="padding:0; margin-bottom: -1px;">
                                    <a href="{{ route('product.details',\App\Products::where('id',$cart_row->id)->first()->slug) }}">
                                        <img class="img-circle rounded-circle mt-1 ml-1 mb-1" width="65px" height="65px" src="{{$cart_row->options->img}}" alt="{{ $cart_row->name }}" />
                                        <div class="mt-1">
                                            <span class="item_name">{{ \Illuminate\Support\Str::limit($cart_row->name, 18) }}</span>
                                        </div>
                                    </a>
                                    <div style="position: absolute; top:6%; right:10px; ">
                                        <a href="javascript:void(0)" title="Trash Item" data-row-id="{{ $cart_row->rowId }}"  class="item_remove btn_cart_del text-lg">
                                            <i class="ion-trash-a" style="color: darkred"></i>
                                        </a>
                                    </div>
                                    <span class="cart_quantity" style="margin-top:0;">
                                        @guest {{ getCurrencyFormat($cart_row->price) }} <small>(X {{$cart_row->qty}})</small>
                                        @else
                                            @if(\auth::user()->employee)
                                                    {{ getCurrencyFormat(\App\Products::find($cart_row->id)->agent_pay_amount) }} <small>(X {{$cart_row->qty}})</small>
                                            @else
                                                {{ getCurrencyFormat($cart_row->price) }} <small>(X {{$cart_row->qty}})</small>
                                            @endif
                                        @endif
                                    </span>
                                    @if(\auth::check() && \auth::user()->employee)
                                    <span class="cart_quantity" style="margin-top: 0;">
                                        <span class="cart_amount">
                                            <span class="price_symbole"><small>Life time partner discount:
                                                    {{ \App\Products::find($cart_row->id)->direct_commission."% Off" }}</small>
                                            </span>
                                        </span>
                                    </span>
                                    @endif
                                    <span class="cart_quantity" style="margin-top: 0;">
                                        <span class="cart_amount">
                                            <span class="price_symbole">Total:
                                                @guest {{ getCurrencyFormat($cart_row->subtotal) }}
                                                @else
                                                    @if(\auth::user()->employee)
                                                        {{ getCurrencyFormat((\App\Products::find($cart_row->id)->agent_pay_amount)*$cart_row->qty) }}
                                                    @else
                                                        {{ getCurrencyFormat($cart_row->subtotal) }}
                                                    @endif
                                                @endif
                                                </span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li style="padding: 15px">
                        <div class="card">
                            <div class="card-body no-border" style="padding:15px; margin-bottom: -15px;">
                                <p class="text-center">Your Wellness Basket Is Empty</p>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
            <div class="cart_footer border-top">
                <p class="cart_total"><strong style="font-weight: 400;">Total</strong>
                    <span class="cart_price">
                        <span class="price_symbole">
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
                        </span>
                    </span>
                </p>
                <p class="cart_buttons justify-content-center">
                    <a href="{{ route('shopping_cart') }}" class="btn btn-line-fill view-cart">
                        <i class="linearicons-bag2"></i> <span class="mt-2">My Basket</span></a>
                    <a href="{{ url('checkout')}}" class="btn btn-fill-out btn-sm checkout">
                        <i class="linearicons-credit-card mr-2 pt-n2" style="font-size:20px;"></i>Checkout</a>
                </p>
            </div>
        </div>
    </li>
