<div class="products_headers">
    <ul class="header_list">
        @guest
            <li class="mr-lg-2 mr-md-2 mr-sm-0">
                <a href="{{ route('login') }}">
                    <div class="d-inline-flex">
                        <p class=""><i class="fa fa-user"></i></p>
                        <p class="ml-1" style="margin-top: 2px">Account</p>
                    </div>
                </a>
            </li>
        @else
        {{--<li class="dropdown cart_dropdown mt-1">--}}
            {{--<a class="cart_trigger" href="javascript:void(0)">--}}
                {{--<i class="fa fa-user"></i> Hi {{ \auth::user()->name }} {{ \auth::user()->last_name }}--}}
            {{--</a>--}}
            {{--<div class="cart_box dropdown-menu dropdown-menu-right">--}}
                {{--<ul style="list-style: none;">--}}
                    {{--<li>--}}
                        {{--<div class="border-0">--}}
                            {{--<ul class="text-left p-0" style="list-style: none;">--}}
                                {{--<li class="pt-2"><a class="dropdown-item menu-link" href="{{ route('dashboard') }}"><i class="ti-user"></i> My Account</a></li>--}}
                                {{--<li><a class="dropdown-item menu-link" href="{{ route('wallet') }}"><i class="ti-wallet"></i> My wallet</a></li>--}}
                                {{--<li><a class="dropdown-item menu-link" href="{{ route('dashboard.orders') }}"><i class="fa fa-shopping-basket" style="color: grey;"></i> My Orders</a></li>--}}
                                {{--<li class="pb-2"><a class="dropdown-item menu-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> Logout</a>--}}
                                    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</li>--}}
        <li class="dropdown cart_dropdown" style="margin-right: -2px;">
            <a class="nav-link cart_trigger pb-2 pb-md-2" href="javascript:void(0)"  data-toggle="dropdown">
                <i class="fa fa-user"></i> Hi {{ \auth::user()->name }} {{ \auth::user()->last_name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <ul style="list-style: none;">
                    <li>
                        <div class="border-0">
                            <ul class="text-left p-0" style="list-style: none;">
                                <li class="pt-2"><a class="dropdown-item menu-link" href="{{ route('dashboard') }}"><i class="fa fa-user"></i> My Account</a></li>
                                <li><a class="dropdown-item menu-link" href="{{ route('wallet') }}"><i class="ti-wallet"></i> My Wallet</a></li>
                                <li><a class="dropdown-item menu-link" href="{{ route('dashboard.orders') }}"><i class="linearicons-bag2" style="color: grey;"></i> My Orders</a></li>
                                <li class="pb-2"><a class="dropdown-item menu-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
        @endguest
    </ul>
</div>
