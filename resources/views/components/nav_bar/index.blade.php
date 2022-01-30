<!-- START HEADER -->
<div class="main-header-top">
    <header class="header_wrap dd_dark_skin transparent_header" id="fetch_header_data" style="position: fixed !important; top: 0; margin-bottom: 200px;">
        @include('components.nav_bar.top.index')
        <div class="bottom_header dark_skin main_menu_uppercase bg-white test-bg" id="header-bar">
            <div class="container">
                <a class="center-logo-nav header_nav d-none d-md-flex d-sm-none" href="{{ route('home') }}">
                    <img class="logo_dark logo_nav header_nav" src="{{ asset('assets/images/logo_light.png') }}" alt="logo" />
                </a>
                <nav class="navbar navbar-expand-lg">
                    <button class="navbar-toggler nav-elements header_nav" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false">
                        <span class="ion-android-menu"></span>
                    </button>
                    <a href="{{ route('home') }}"><img class="logo-nav-left header_nav" src="{{ asset('assets/images/logo_light_home.png') }}" alt="logo" /></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            {{--<li><a class="nav-link nav-first nav_item @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Home</a></li>--}}
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-first nav-link @if(request()->routeIs('services') || request()->routeIs('services.category') || request()->routeIs('services.details') || request()->routeIs('services.booking') || request()->routeIs('services.booking.done')) active @endif" href="{{ route('services') }}" data-toggle="dropdown"><span onclick="{ window.location.href = '{{ route('services') }}';}">CLINIQUE</span></a>
                                <div class="dropdown-menu">
                                    <ul>
                                        @foreach(\App\Service_category::orderby('order','ASC')->whereNull('is_deleted')->where('visibility',1)->get() as $row)
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('services.category',$row->slug) }}">{{ $row->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link @if(request()->routeIs('products') || request()->routeIs('product.details') || request()->routeIs('products.category.level_one') || request()->routeIs('products.category.level_two') || request()->routeIs('products.category.level_three') || request()->routeIs('products.search_product')) active @endif" href="{{ route('products') }}" data-toggle="dropdown"><span onclick="{ window.location.href = '{{ route('products') }}';}">Boutique</span></a>
                                <div class="dropdown-menu ">
                                    <ul>
                                        @foreach(\App\Product_category::whereNull('parent_id')->whereNull('is_deleted')->limit(6)->orderby('order','asc')->get() as $row)
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="{{ route('products.category.level_one',HashEncode($row->id)) }}"><span onclick="{ window.location.href = '{{ route('products.category.level_one',HashEncode($row->id)) }}';}">{{ $row->name }}</span></a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        @foreach($row->children as $child)
                                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('products.category.level_two',[HashEncode($child->parent->id),HashEncode($child->id)]) }}">{{ $child->name }}</a>
                                                            @foreach($child->children as $sub)
                                                                <li><a class="dropdown-item nav-link nav_item" href="{{ route('products.category.level_three',[HashEncode($sub->parent->parent->id),HashEncode($sub->parent->id),HashEncode($sub->id)]) }}">{{ $sub->name }}</a></li>
                                                            @endforeach
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li><a class="nav-link nav_item @if(request()->routeIs('about-us')) active @endif" href="{{ url('about-us') }}">About Us</a></li>
                            <li><a class="nav-link nav_item @if(request()->routeIs('careers')) active @endif" href="{{ route('careers') }}">Careers</a></li>
                            <li><a class="nav-link nav_item @if(request()->routeIs('contact-us')) active @endif" href="{{ route('contact-us') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="search_wrap-search bg-white search-mobile test-bg @if(isset($old_search_word)) @if($old_search_word) d-md-block @endif @endif" style="width: 320px;">
                        <form action="{{ route('products.search_product') }}"  method="GET">
                            <div class="input-group">
                                <input class="form-control search_bar_text" name="keyword" placeholder="Search ..." required="" value="{{ isset($old_search_word)? ( ($old_search_word)? $old_search_word : '') : '' }}"  type="text">
                                <button type="submit" class="search_btn2"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav attr-nav align-items-center nav-elements header_nav">
                        <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a></li>
                        <li class="d-md-block d-none">
                            <a href="{{ route('wish-list') }}" class="nav-link" title="Wishlist">
                                <i class="ti-heart"></i><span class="wishlist_count" id="wish-list-products-count">@auth {{ \App\Wishlist::where('user_id', \Auth::user()->id)->get()->count() }} @else 0 @endauth</span>
                            </a>
                        </li>
                        @include('components.nav_bar.cart')
                        @guest
                            <li class="header_nav user-block"><a href="{{ route('login') }}" class="nav-link"><i class="fa fa-user ml-2"></i></a></li>
                        @else
                            <li id="nav_update_cart_info" class="dropdown cart_dropdown header_nav user-block">
                                <a class="nav-link cart_trigger" href="#" onclick="return false;" data-toggle="dropdown">
                                    <i class="fa fa-user"></i>
                                </a>
                                <div class="cart_box dropdown-menu dropdown-menu-right" style="width: 100px;">
                                    <ul class="text-left" style="list-style: none;">
                                        <li><a class="dropdown-item menu-link" href="{{ route('dashboard') }}"><i class="fa fa-user"></i> My Account</a></li>
                                        <li><a class="dropdown-item menu-link" href="{{ route('wallet') }}"><i class="ti-wallet"></i> My Wallet</a></li>
                                        <li><a class="dropdown-item menu-link" href="{{ route('dashboard.orders') }}"><i class="linearicons-bag2" style="color: grey;"></i> My Orders</a></li>
                                        <li><a class="dropdown-item menu-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </div>
        <div class="search_wrap-search bg-white test-bg d-md-none d-sm-block" @if(isset($old_search_word)) @if($old_search_word) style="display: block;" @endif @endif>
            <div class="container">
                <form action="{{ route('products.search_product') }}"  method="GET">
                    <div class="input-group">
                        <input class="form-control search_bar_text" autofocus  name="keyword" placeholder="Search ..." required="" value="{{ isset($old_search_word)? ( ($old_search_word)? $old_search_word : '') : '' }}"  type="text">
                        <button type="submit" class="search_btn2"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </header>
</div>
