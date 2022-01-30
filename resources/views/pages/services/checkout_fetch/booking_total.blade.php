<div id="fetch_amount">
    <div class="heading_s1 mb-3">
        <h6 class="text-uppercase">RESERVATION PAYMENTS Details</h6>
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
                <td class="cart_total_label">Subtotal</td>
                @if(\auth::user()->employee || $discount_activate)
                    @php $final_sub_total = $data->agent_pay_amount; @endphp
                @else
                    @php $final_sub_total = $data->price; @endphp
                @endif
                <input type="hidden" value="{{ $final_sub_total }}" name="cart_sub_total" id="cart_sub_total" />
                <td class="cart_total_amount"><small class="update_cart_total_amount">{{ getCurrencyFormat($final_sub_total) }}</small></td>
            </tr>
            <tr>
                <td class="cart_total_label"><strong>Total</strong></td>
                <input type="hidden" value="{{ $final_sub_total }}" id="default_total_amount" />
                <input type="hidden" value="{{ $final_sub_total }}" name="total" class="updated_total_amount" />
                <td class="cart_total_amount"><strong class="updated_total_amount">{{ getCurrencyFormat($final_sub_total) }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
