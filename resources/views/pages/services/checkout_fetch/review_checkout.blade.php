<div id="fetch_booking_items">
    @if(\auth::user()->employee || $discount_activate)
        {!! ($data->direct_commission)? "<del>".getCurrencyFormat($data->price)."</del> ".getCurrencyFormat($data->agent_pay_amount)."" : '-' !!}
        <br/><small>(Direct Partner Commission {{ ($data->direct_commission)? $data->direct_commission."%" : '0%' }})</small>
    @else
        {{ getCurrencyFormat($data->price) }}
    @endif
</div>
