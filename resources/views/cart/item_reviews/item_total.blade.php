<div id="fetch_total_amount">
    <div class="heading_s1 mb-3">
        <h6 class="text-uppercase">CART PAYMENTS Details</h6>
    </div>
    <div class="table-responsive">
        <table class="table">
            <tbody>
            <tr id="discount_show_slot" style="background: #edebcd; display: none;">
                <td class="cart_total_label">Voucher Discount</td>
                <td>
                    <small class="update_discount_amount"></small>
                </td>
            </tr>
            <tr id="points_show_slot" style="background: #e1dfc1; display: none;">
                <input type="hidden" value="{{ \App\Details::where('key','points_rate')->firstOrFail()->amount }}" id="per_points_amount" name="per_points_amount" />
                <td class="cart_total_label">Earn Points</td>
                <td>
                    <small class="update_earned_points"></small>
                </td>
            </tr>
            <tr>
                <td class="cart_total_label">Cart Subtotal
                    @php $final_sub_total = 0; @endphp
                    @guest
                        @php $final_sub_total = \Cart::instance('shopping')->total(); @endphp
                    @else
                        @if(\auth::user()->employee || $discount_activate)
                            @php $get_sub_total = array();
                                foreach(\Cart::instance('shopping')->content() as $item){ array_push($get_sub_total,$item->options->agent_pay_amount*$item->qty); }
                            @endphp
                            @php $final_sub_total = array_sum($get_sub_total); @endphp
                        @else
                            @php $final_sub_total = \Cart::instance('shopping')->total(); @endphp
                        @endif
                    @endif
                    <input type="hidden" value="{{ $final_sub_total }}" name="cart_sub_total" id="cart_sub_total" />
                <td class="cart_total_amount"><small class="update_cart_total_amount">{{ getCurrencyFormat($final_sub_total) }}</small></td>
            </tr>

            <tr>
                <td class="cart_total_label">Delivery Fee</td>
                <td class="cart_total_amount update_shipping_fees">
                    <input type="hidden" value="{{ \App\Details::where('key','shipping_amount')->first()->amount }}" id="default_shipping_amount" />
                    <input type="hidden" value="{{ \App\Details::where('key','shipping_amount')->first()->amount }}" name="shipping_amount" class="updated_shipping_amount" />
                    <small class="updated_shipping_amount">{{ getCurrencyFormat(\App\Details::where('key','shipping_amount')->first()->amount) }}</small>
                </td>
            </tr>
            <tr>
                <td class="cart_total_label"><strong>Total</strong></td>
                @php $final_total_amount = 0; @endphp
                @guest
                    @php $final_sub_total = (\Cart::instance('shopping')->total()+\App\Details::where('key','shipping_amount')->first()->amount); @endphp
                @else
                    @if(\auth::user()->employee || $discount_activate)
                        @php $get_sub_total = array();
                            foreach(\Cart::instance('shopping')->content() as $item){ array_push($get_sub_total,$item->options->agent_pay_amount*$item->qty); }
                        @endphp
                        @php $final_sub_total = (array_sum($get_sub_total)+\App\Details::where('key','shipping_amount')->first()->amount); @endphp
                    @else
                        @php $final_sub_total = (\Cart::instance('shopping')->total()+\App\Details::where('key','shipping_amount')->first()->amount); @endphp
                    @endif
                @endif
                <input type="hidden" value="{{ $final_sub_total }}" id="default_total_amount" />
                <input type="hidden" value="{{ $final_sub_total }}" name="total" class="updated_total_amount" />
                <td class="cart_total_amount"><strong class="updated_total_amount">{{ getCurrencyFormat($final_sub_total) }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
