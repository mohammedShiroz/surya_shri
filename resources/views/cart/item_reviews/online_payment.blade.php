<div id="fetch_online_pay">
    @php $final_total_amount = 0; @endphp
    @guest
        <input type="hidden" class="updated_total_amount" name="amount" value="{{ (\Cart::instance('shopping')->total()+\App\Details::where('key','shipping_amount')->first()->amount) }}">
    @else
        @if(\auth::user()->employee || $discount_activate)
            @php $get_sub_total = array(); foreach(\Cart::instance('shopping')->content() as $item){ array_push($get_sub_total,$item->options->agent_pay_amount*$item->qty); }
            @endphp
            <input type="hidden" class="updated_total_amount" name="amount" value="{{ (array_sum($get_sub_total)+\App\Details::where('key','shipping_amount')->first()->amount) }}">
        @else
            <input type="hidden" class="updated_total_amount" name="amount" value="{{ (\Cart::instance('shopping')->total()+\App\Details::where('key','shipping_amount')->first()->amount) }}">
        @endif
    @endif
</div>
