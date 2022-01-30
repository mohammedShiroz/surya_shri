<div id="fetch_online_pay">
    @if(\auth::user()->employee || $discount_activate)
        <input type="hidden" id="paid_payment_amount" class="updated_total_amount" name="amount" value="{{ $data->agent_pay_amount }}">
    @else
        <input type="hidden" id="paid_payment_amount" class="updated_total_amount" name="amount" value="{{ $data->price }}">
    @endif
</div>
