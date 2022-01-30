<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link navbar-cyan" style="background: #837000">
        <img src="{{ asset('administration/img/logo-white.png') }}" alt="Selladz Logo" class="brand-image  " style="opacity: .8">
        <span class="brand-text font-weight-light text-md text-uppercase"><strong>{{ env('APP_NAME') }}</strong></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden" style="background: #231F01"><div class="os-resize-observer-host"><div class="os-resize-observer observed" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer observed"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 671px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll; right: 0px; bottom: 0px;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            <li class="nav-item active">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard') || request()->routeIs('admin.home')) active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            @permission('read-users')
                            <li class="nav-item has-treeview @if(request()->routeIs('users.*') || request()->routeIs('partners.*') || request()->routeIs('sellers.*') || request()->routeIs('doctors.*')) menu-open @endif">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-house-user"></i>
                                    <p>Users<i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-buyers')
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}" class="nav-link @if(request()->routeIs('users.*')) active @endif">
                                            <i class="fas fa-user-lock nav-icon"></i>
                                            <p>Buyers</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    <!--
                                    <li class="nav-item">
                                        <a href="{{ route('partners.request') }}" class="nav-link @if(request()->routeIs('partners.request')) active @endif">
                                            <i class="fas fa-user-plus nav-icon"></i>
                                            <p>Employee Request</p>
                                        </a>
                                    </li>-->
                                    @permission('read-partners')
                                    <li class="nav-item">
                                        <a href="{{ route('partners.index') }}" class="nav-link @if(request()->routeIs('partners.*')) active @endif">
                                            <i class="fas fa-user-tag nav-icon"></i>
                                            <p>Partners</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission(['read-sellers'])
                                    <li class="nav-item">
                                        <a href="{{ route('sellers.index') }}" class="nav-link @if(request()->routeIs('sellers.*')) active @endif">
                                            <i class="fas fa-user-check nav-icon"></i>
                                            <p>Sellers</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission(['read-doctors'])
                                    <li class="nav-item">
                                        <a href="{{ route('doctors.index') }}" class="nav-link @if(request()->routeIs('doctors.*')) active @endif">
                                            <i class="fas fa-user-md nav-icon"></i>
                                            <p>Doctors</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('read-boutique')
                            <li class="nav-item has-treeview @if(request()->routeIs('products.*') || request()->routeIs('product-category.*')) menu-open @endif">
                                <a href="" class="nav-link @if(request()->routeIs('products.*') || request()->routeIs('product-category.*')) active @endif">
                                    <i class="nav-icon fas fa-object-group"></i>
                                    <p>Boutique<i class="fas fa-angle-right set-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-product-category')
                                    <li class="nav-item">
                                        <a href="{{ route('product-category.index') }}" class="nav-link @if(request()->routeIs('product-category.*')) active @endif">
                                            <i class="fa fa-list nav-icon"></i>
                                            <p>Product Categories</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-products')
                                    <li class="nav-item">
                                        <a href="{{ route('products.index') }}" class="nav-link @if(request()->routeIs('products.*')) active @endif">
                                            <i class="fa fa-skyatlas nav-icon"></i>
                                            <p>Products</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-orders')
                            <li class="nav-item has-treeview @if(request()->routeIs('orders.*')) menu-open @endif">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>Orders <i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.index') }}" class="nav-link @if(request()->routeIs('orders.index') || ($page_name == "order_index")) active @endif">
                                            <i class="fa fa-shopping-basket nav-icon"></i>
                                            <p>Orders</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-pending-orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.pending') }}" class="nav-link @if(request()->routeIs('orders.pending') || ($page_name == "order_pending")) active @endif">
                                            <i class="fa fa-question-circle nav-icon"></i>
                                            <p>Pending Orders</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-confirmed-orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.confirmed') }}" class="nav-link @if(request()->routeIs('orders.confirmed') || ($page_name == "order_confirmed")) active @endif">
                                            <i class="fa fa-question-circle nav-icon"></i>
                                            <p>Confirmed Orders</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-pending-delivery')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.pending.delivery') }}" class="nav-link @if(request()->routeIs('orders.pending.delivery') || ($page_name == "delivery_pending")) active @endif">
                                            <i class="fas fa-truck-loading nav-icon"></i>
                                            <p>Pending Deliveries</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-completed-orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.completed') }}" class="nav-link @if(request()->routeIs('orders.completed') || ($page_name == "orders.completed")) active @endif">
                                            <i class="fa fa-check-circle nav-icon"></i>
                                            <p>Completed Orders</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-canceled-orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.canceled') }}" class="nav-link @if(request()->routeIs('orders.canceled') || ($page_name == "order_canceled")) active @endif">
                                            <i class="fa fa-times-circle nav-icon"></i>
                                            <p>Canceled Orders</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-rejected-orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.rejected') }}" class="nav-link @if(request()->routeIs('orders.rejected') || ($page_name == "order_rejected")) active @endif">
                                            <i class="fa fa-close nav-icon"></i>
                                            <p>Rejected Orders</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-clinique')
                            <li class="nav-item has-treeview @if(request()->routeIs('service-category.*') || request()->routeIs('services.*')) menu-open @endif">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-clinic-medical"></i>
                                    <p>Clinique<i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-service-category')
                                    <li class="nav-item">
                                        <a href="{{ route('service-category.index') }}" class="nav-link @if(request()->routeIs('service-category.*')) active @endif">
                                            <i class="fas fa-user-nurse nav-icon"></i>
                                            <p>Service Categories</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-service')
                                    <li class="nav-item">
                                        <a href="{{ route('services.index') }}" class="nav-link @if(request()->routeIs('services.*')) active @endif">
                                            <i class="fas fa-support nav-icon"></i>
                                            <p>Services</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-reservations')
                            <li class="nav-item has-treeview @if(request()->routeIs('reservations.*')) menu-open @endif">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-calendar"></i>
                                    <p>Reservations<i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.index') }}" class="nav-link @if(request()->routeIs('reservations.index') || request()->routeIs('reservations.show')) active @endif">
                                            <i class="fas fa-user-nurse nav-icon"></i>
                                            <p>Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-pending-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.pending') }}" class="nav-link @if(request()->routeIs('reservations.pending') || request()->routeIs('reservations.pending.show')) active @endif">
                                            <i class="fas fa-question-circle nav-icon"></i>
                                            <p>Pending Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-completed-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.completed') }}" class="nav-link @if(request()->routeIs('reservations.completed') || request()->routeIs('reservations.completed.show')) active @endif">
                                            <i class="fas fa-check-double nav-icon"></i>
                                            <p>Completed Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-postponed-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.expired') }}" class="nav-link @if(request()->routeIs('reservations.expired') || request()->routeIs('reservations.expired.show')) active @endif">
                                            <i class="fa fa-calendar-check nav-icon"></i>
                                            <p style="font-size: 11px">Postponed/Expired Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-confirmed-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.confirmed') }}" class="nav-link @if(request()->routeIs('reservations.confirmed') || request()->routeIs('reservations.confirmed.show')) active @endif">
                                            <i class="fa fa-check-circle nav-icon"></i>
                                            <p>Confirmed Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-canceled-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.canceled') }}" class="nav-link @if(request()->routeIs('reservations.canceled') || request()->routeIs('reservations.canceled.show')) active @endif">
                                            <i class="fa fa-times-circle nav-icon"></i>
                                            <p>Canceled Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-rejected-reservations')
                                    <li class="nav-item">
                                        <a href="{{ route('reservations.rejected') }}" class="nav-link @if(request()->routeIs('reservations.rejected') || request()->routeIs('reservations.rejected.show')) active @endif">
                                            <i class="fa fa-close nav-icon"></i>
                                            <p>Rejected Reservations</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-sales')
                            <li class="nav-item has-treeview @if(request()->routeIs('product-payments.*') || request()->routeIs('service-payments.*') || request()->routeIs('seller-payments.*')) menu-open @endif">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-money-bill-wave"></i>
                                    <p>Sales<i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-product-sales')
                                    <li class="nav-item">
                                        <a href="{{ route('product-payments.index') }}" class="nav-link @if(request()->routeIs('product-payments.*')) active @endif">
                                            <i class="fas fa-credit-card nav-icon"></i>
                                            <p>Product Sales</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-sellers-payments')
                                    <li class="nav-item">
                                        <a href="{{ route('seller-payments.index') }}" class="nav-link @if(request()->routeIs('seller-payments.*')) active @endif">
                                            <i class="fas fa-user-secret nav-icon"></i>
                                            <p>Seller Payments</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-service-sales')
                                    <li class="nav-item">
                                        <a href="{{ route('service-payments.index') }}" class="nav-link @if(request()->routeIs('service-payments.*')) active @endif">
                                            <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                            <p>Service Sales</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-wallet')
                            <li class="nav-item has-treeview @if(request()->routeIs('user-points.*') || request()->routeIs('user-wallet.*') || request()->routeIs('global-wallet.*') || request()->routeIs('site-wallet.*') || request()->routeIs('bonus-wallet.*') || request()->routeIs('donation-wallet.*') || request()->routeIs('seller-wallet.*') || request()->routeIs('doctor-wallet.*')) menu-open @endif">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                    <p>Wallet<i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-user-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('user-points.index') }}" class="nav-link @if(request()->routeIs('user-points.*')) active @endif">
                                            <i class="fas fa-coins nav-icon"></i>
                                            <p>User Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-partner-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('user-wallet.index') }}" class="nav-link @if(request()->routeIs('user-wallet.*')) active @endif">
                                            <i class="fas fa-wallet nav-icon"></i>
                                            <p>Partner Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-seller-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('seller-wallet.index') }}" class="nav-link @if(request()->routeIs('seller-wallet.*')) active @endif">
                                            <i class="fas fa-user-check nav-icon"></i>
                                            <p>Seller Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-doctor-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('doctor-wallet.index') }}" class="nav-link @if(request()->routeIs('doctor-wallet.*')) active @endif">
                                            <i class="fas fa-wallet nav-icon"></i>
                                            <p>Doctor Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-site-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('site-wallet.index') }}" class="nav-link @if(request()->routeIs('site-wallet.*')) active @endif">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>Site Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-global-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('global-wallet.index') }}" class="nav-link @if(request()->routeIs('global-wallet.*')) active @endif">
                                            <i class="fas fa-globe-asia nav-icon"></i>
                                            <p>Global Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-bonus-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('bonus-wallet.index') }}" class="nav-link @if(request()->routeIs('bonus-wallet.*')) active @endif">
                                            <i class="fas fa-network-wired nav-icon"></i>
                                            <p>Bonus/Gift Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-donation-wallet')
                                    <li class="nav-item">
                                        <a href="{{ route('donation-wallet.index') }}" class="nav-link @if(request()->routeIs('donation-wallet.*')) active @endif">
                                            <i class="fas fa-donate nav-icon"></i>
                                            <p>Donations Wallet</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-withdrawals')
                            <li class="nav-item has-treeview @if(request()->routeIs('withdrawal-wallet.*')) menu-open @endif">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-hand-holding-usd"></i>
                                    <p>Withdrawals<i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.index') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.index')) active @endif">
                                            <i class="fas fa-coins nav-icon"></i>
                                            <p>Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-user-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.user') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.user') || $width_type == "Users") active @endif">
                                            <i class="fas fa-coins nav-icon"></i>
                                            <p>User Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-seller-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.seller') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.seller') || $width_type == "Sellers") active @endif">
                                            <i class="fas fa-user-check nav-icon"></i>
                                            <p>Seller Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-doctor-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.doctors') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.doctors') || $width_type == "Doctors") active @endif">
                                            <i class="fas fa-wallet nav-icon"></i>
                                            <p>Doctor Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-site-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.site') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.site') || $width_type == "Site") active @endif">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>Site Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-global-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.global') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.global') || $width_type == "Global") active @endif">
                                            <i class="fas fa-globe-asia nav-icon"></i>
                                            <p>Global Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-bonus-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.gift') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.gift') || $width_type == "Bonus/Gift") active @endif">
                                            <i class="fas fa-network-wired nav-icon"></i>
                                            <p>Bonus/Gift Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-donation-withdrawals')
                                    <li class="nav-item">
                                        <a href="{{ route('withdrawal-wallet.donations') }}" class="nav-link @if(request()->routeIs('withdrawal-wallet.donations') || $width_type == "Donations") active @endif">
                                            <i class="fas fa-donate nav-icon"></i>
                                            <p>Donations Wallet Withdrawals</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-vouchers')
                            <li class="nav-item has-treeview @if(request()->routeIs('vouchers.*') || request()->routeIs('voucher-customers.*')) menu-open @endif">
                                <a href="" class="nav-link @if(request()->routeIs('vouchers.*') || request()->routeIs('voucher-customers.*')) active @endif">
                                    <i class="nav-icon fa fa-ticket"></i>
                                    <p>Vouchers<i class="fas fa-angle-right set-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-vouchers')
                                    <li class="nav-item">
                                        <a href="{{ route('vouchers.index') }}" class="nav-link @if(request()->routeIs('vouchers.*')) active @endif">
                                            <i class="fas fa-ticket-alt nav-icon"></i>
                                            <p>Created Vouchers</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-used-vouchers')
                                    <li class="nav-item">
                                        <a href="{{ route('voucher-customers.index') }}" class="nav-link @if(request()->routeIs('voucher-customers.*')) active @endif">
                                            <i class="fas fa-user-tag nav-icon"></i>
                                            <p>Used Vouchers</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-questionnaire')
                            <li class="nav-item has-treeview @if(request()->routeIs('questions.*') || request()->routeIs('question-type.*') || request()->routeIs('submitted-questionnaires.*') || request()->routeIs('answers.*')) menu-open @endif">
                                <a href="" class="nav-link @if(request()->routeIs('questions.*') || request()->routeIs('question-type.*') || request()->routeIs('submitted-questionnaires.*') || request()->routeIs('answers.*')) active @endif">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>Questionnaire <i class="fas fa-angle-right set-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <!--
                                    <li class="nav-item">
                                        <a href="{{ route('question-type.index') }}" class="nav-link @if(request()->routeIs('question-type.*')) active @endif">
                                            <i class="fa fa-list nav-icon"></i>
                                            <p>Categories</p>
                                        </a>
                                    </li>-->
                                    @permission('read-questionnaire')
                                    <li class="nav-item">
                                        <a href="{{ route('questions.index') }}" class="nav-link @if(request()->routeIs('questions.*')) active @endif">
                                            <i class="fa fa-question-circle-o nav-icon"></i>
                                            <p>Questions</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-submitted-questionnaires')
                                    <li class="nav-item">
                                        <a href="{{ route('submitted-questionnaires.index') }}" class="nav-link @if(request()->routeIs('submitted-questionnaires.*')) active @endif">
                                            <i class="fa fa-check-circle nav-icon"></i>
                                            <p>Submitted Questionnaires</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission(['view-admin-privilege'])
                            <li class="nav-item has-treeview @if(request()->routeIs('role.*') || request()->routeIs('permission.*') || request()->routeIs('admin-users.*')) menu-open @endif">
                                <a href="" class="nav-link @if(Request::is('admin/role/*')||Request::is('admin/permission/*')||Request::is('admin/admin-users/*')) active @endif">
                                    <i class="nav-icon fas fa-lock"></i>
                                    <p>Admin Privilege <i class="fas fa-angle-right set-right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @permission('read-admin')
                                    <li class="nav-item">
                                        <a href="{{ route('admin-users.index') }}" class="nav-link @if(request()->routeIs('admin-users.*')) active @endif">
                                            <i class="nav-icon fas fa-user-shield"></i>
                                            <p>Admin Users</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-role')
                                    <li class="nav-item">
                                        <a href="{{ route('role.index') }}" class="nav-link @if(request()->routeIs('role.*')) active @endif">
                                            <i class="fas fa-user-cog nav-icon"></i>
                                            <p>Role</p>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('read-permission')
                                    <li class="nav-item">
                                        <a href="{{ route('permission.index') }}" class="nav-link @if(request()->routeIs('permission.*')) active @endif">
                                            <i class="fas fa-lock-open nav-icon"></i>
                                            <p>Permission</p>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission
                            @permission('view-web-viewers')
                            <li class="nav-item @if(request()->routeIs('site-visitors.*')) active @endif">
                                <a href="{{ route('site-visitors.index') }}" class="nav-link @if(request()->routeIs('site-visitors.*')) active @endif">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Web Viewers</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('view-profile-settings')
                            <li class="nav-item @if(request()->routeIs('admin.profile') || request()->routeIs('admin.profile')) active @endif">
                                <a href="{{ route('admin.profile') }}" class="nav-link @if(request()->routeIs('admin.profile')) active @endif">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Admin Profile Settings</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('view-activity-log')
                            <li class="nav-item @if(request()->routeIs('activity-log.*') || request()->routeIs('activity-log.*')) active @endif">
                                <a href="{{ route('activity-log.index') }}" class="nav-link @if(request()->routeIs('activity-log.*')) active @endif">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>Activity Log</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-auto-hidden os-scrollbar-unusable"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 56.7568%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
    <!-- /.sidebar -->
</aside>
