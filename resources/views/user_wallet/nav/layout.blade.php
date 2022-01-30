<div class="row align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
        <div class="item">
            <div class="categories_box-2">
                <a href="{{ route('wallet.points') }}">
                    <i class="fa fa-coins"></i>
                    <span>My Points</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
        <div class="item">
            <div class="categories_box-2">
                <a href="{{ route('wallet.transfer_points') }}">
                    <i class="ti-exchange-vertical"></i>
                    <span>Transfer Points</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="item">
            <div class="categories_box-2">
                <a href="{{ route('wallet.withdrawal_points') }}">
                    <img src="{{ asset('assets/images/withdraw.png') }}" alt="Withdrawals" />
                    <span>Withdrawals</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="item">
            <div class="categories_box-2">
                <a href="{{ route('wallet.withdrawal_points') }}">
                    <img src="{{ asset('assets/images/payment_history.png') }}" alt="Wallet History" />
                    <span>Wallet History</span>
                </a>
            </div>
        </div>
    </div>
    {{--<div class="col-lg-6 col-md-6 col-sm-6 pb-3">--}}
        {{--<div class="item">--}}
            {{--<div class="categories_box-2">--}}
                {{--<a href="{{ route('wallet.credited_points') }}">--}}
                    {{--<i class="ti-bar-chart"></i>--}}
                    {{--<span>Received Points</span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-6 col-md-6 col-sm-6 pb-3">--}}
        {{--<div class="item">--}}
            {{--<div class="categories_box-2">--}}
                {{--<a href="{{ route('wallet.used_points') }}">--}}
                    {{--<i class="ti-pie-chart"></i>--}}
                    {{--<span>Used Points</span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-6 col-md-6 col-sm-12">--}}
        {{--<div class="item">--}}
            {{--<div class="categories_box-2">--}}
                {{--<a href="{{ route('wallet.refund_points') }}">--}}
                    {{--<i class="ti-reload"></i>--}}
                    {{--<span>Refund Points</span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-6 col-md-6 col-sm-12">--}}
        {{--<div class="item">--}}
            {{--<div class="categories_box-2">--}}
                {{--<a href="{{ route('wallet.withdrawal_points') }}">--}}
                    {{--<i class="ti-bar-chart-alt"></i>--}}
                    {{--<span>Withdrawal Points</span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
