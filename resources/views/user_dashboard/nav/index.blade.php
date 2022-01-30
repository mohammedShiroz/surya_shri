@push('css')
<style>
    .accordion-wrapper{
        padding:30px 0px 30px 20px;
    }
    .accordion{
        max-width:700px;
        margin-inline:auto;
    }
    .accordion-section{
    }
    .accordion-body{
        position:relative;
        transition:0.5s all;
    }
    .label{
        position:relative;
        font-size:15px;
        font-weight:500;
        padding: 5px;
    }
    .label:before{
        font-family: "Font Awesome 5 Free";
        content:'\f0d7';
        top:50%;
        transform:translatey(-50%);
        right:15px;
        position:absolute;
        font-weight:700;
        color: #000000;
        cursor:pointer;
        transition:0.5s all;
    }

    .content{
        font-weight:300;
        text-align:justify;
        margin-top:10px;
        height:0;
        overflow:hidden;
        transition:0.5s;
        background-color:white;
        margin-bottom: 20px;
    }

    .accordion-body.active .content{
        height:auto;
    }
    .accordion-body.active .label:before{
        font-family: "Font Awesome 5 Free";
        content:'\f0d8';
        font-weight:700;
    }

    .nav-link{
        border-bottom: 0 !important;
    }
    .nav-link.active{
        background: transparent !important;
        color: #837000 !important;
    }
</style>
    @endpush
@push('script')
    <script>
        const accordion = document.getElementsByClassName('accordion-body');
        for (i=0; i<accordion.length; i++) {
            accordion[i].addEventListener('click', function(){
                this.classList.toggle('active')
            });
        }
    </script>
    @endpush
<div class="dashboard_menu">
    <div class="accordion-wrapper">
        <div class="accordion">
            <div class="accordion-section">
                <div class="accordion-body @if(request()->routeIs('dashboard') || request()->routeIs('dashboard.orders') || request()->routeIs('dashboard.orders.detail') || request()->routeIs('dashboard.reservations') || request()->routeIs('dashboard.reservations.view') || request()->routeIs('dashboard.account')) active @endif text-uppercase">
                    <div class="label">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="ti-layout-grid2 mr-1"></i> Dashboard
                        </a>
                    </div>
                    <div class="content">
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('dashboard.orders') || request()->routeIs('dashboard.orders.detail')) active @endif" href="{{ route('dashboard.orders') }}">
                                    <i class="ti-shopping-cart-full"></i> Orders
                                </a>
                            </li>
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link @if(request()->routeIs('dashboard.wish-list')) active @endif text-uppercase" href="{{ route('dashboard.wish-list') }}">--}}
                                    {{--<i class="ti-heart"></i>My Wishlist</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link @if(request()->routeIs('dashboard.address')) active @endif text-uppercase" href="{{ route('dashboard.address') }}">--}}
                                    {{--<i class="ti-location-pin"></i>My Address</a>--}}
                            {{--</li>--}}

                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('dashboard.reservations') || request()->routeIs('dashboard.reservations.view')) active @endif" href="{{ route('dashboard.reservations') }}">
                                    <i class="ti-bookmark-alt"></i>Reservations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('dashboard.account')) active @endif" href="{{ route('dashboard.account') }}">
                                    <i class="ti-settings"></i>Account Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="accordion-body @if(request()->routeIs('wallet') || request()->routeIs('wallet.points') || request()->routeIs('wallet.transfer_points') || request()->routeIs('partners.vouchers') || request()->routeIs('wallet.withdrawal_points') || request()->routeIs('dashboard.transactions') || request()->routeIs('wallet.history')) active @endif text-uppercase">
                    <div class="label">
                        <a href="{{ route('wallet') }}" class="nav-link @if(request()->routeIs('wallet')) active @endif">
                            <i class="fas fa-coins mr-1"></i> My Wallet
                        </a>
                    </div>
                    <div class="content">
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('wallet.points')) active @endif" href="{{ route('wallet.points') }}">
                                    <i class="fa fa-coins"></i>My Points</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('wallet.transfer_points')) active @endif" href="{{ route('wallet.transfer_points') }}">
                                    <i class="ti-exchange-vertical"></i>Transfer Points</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('partners.vouchers')) active @endif" href="{{ route('partners.vouchers') }}">
                                <i class="ti-ticket"></i>My Vouchers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('wallet.withdrawal_points')) active @endif" href="{{ route('wallet.withdrawal_points') }}">

                                        <img width="20px" src="{{ asset('assets/images/withdraw.png') }}" alt="Withdrawals" />

                                    </i>Withdrawals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('dashboard.transactions')) active @endif" href="{{ route('dashboard.transactions') }}">
                                <i class="ti-money"></i>Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('wallet.history')) active @endif" href="{{ route('wallet.history') }}">
                                <i class="ti-bar-chart"></i>Wallet History</a>
                            </li>
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link @if(request()->routeIs('wallet.credited_points')) active @endif text-uppercase" href="{{ route('wallet.credited_points') }}">--}}
                                    {{--<i class="ti-bar-chart"></i>Received Points</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link @if(request()->routeIs('wallet.used_points')) active @endif text-uppercase" href="{{ route('wallet.used_points') }}">--}}
                                    {{--<i class="ti-pie-chart"></i>Used Points</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link @if(request()->routeIs('wallet.refund_points')) active @endif text-uppercase" href="{{ route('wallet.refund_points') }}">--}}
                                    {{--<i class="ti-reload"></i>Refund Points</a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>

                <div class="accordion-body @if(request()->routeIs('partners')  || request()->routeIs('partners.profile') || request()->routeIs('partners.hierarchy') || request()->routeIs('partners.products') || request()->routeIs('partners.services') || request()->routeIs('partners.hierarchy.commission')) active @endif">
                    <div class="label text-uppercase">
                        <a href="{{ route('partners') }}" class="nav-link @if(request()->routeIs('partners')) active @endif">
                            <i class="ti-user mr-1"></i> Partner Account
                        </a>
                    </div>
                    <div class="content">
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('partners.profile')) active @endif" href="{{ route('partners.profile') }}">
                                    <i class="ti-user"></i>Partner Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('partners.hierarchy') || request()->routeIs('partners.hierarchy.commission')) active @endif" href="{{ route('partners.hierarchy') }}">
                                    <i class="ti-anchor"></i>Partner Hierarchy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('partners.products')) active @endif" href="{{ route('partners.products') }}">
                                    <i class="ti-export"></i>My Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('partners.services')) active @endif" href="{{ route('partners.services') }}">
                                    <i class="ti-support"></i>My Services</a>
                            </li>
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link @if(request()->routeIs('partners.vouchers')) active @endif" href="{{ route('partners.vouchers') }}">--}}
                                    {{--<i class="ti-ticket"></i>My Vouchers</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                            {{--<a class="nav-link @if(request()->routeIs('partners.summary')) active @endif text-uppercase" href="{{ route('partners.summary') }}">--}}
                            {{--<i class="ti-bar-chart-alt"></i>Summary</a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
