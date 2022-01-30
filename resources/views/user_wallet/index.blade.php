@extends('layouts.front')
@section('page_title','My Wallet')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('My Wallet'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'My Wallet','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_wallet.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">My Wallet</h5>
                            </div>
                            <div class="card-body" style="padding: 0 !important;">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 col-md-4 col-sm-6 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('wallet.points') }}">
                                                        <i class="fa fa-coins"></i>
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat(getFinalPoints()["available_points"]) }}</p>
                                                        <span>My Points</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('wallet.transfer_points') }}">
                                                        <i class="ti-exchange-vertical"></i>
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat(getCalPoints()["total_transferred_points"]) }}</p>
                                                        <span>Transfer Points</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('wallet.withdrawal_points') }}">
                                                        <img src="{{ asset('assets/images/withdraw.png') }}" alt="Withdrawals" />
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat((getWithdrawalablePointsByUser(\auth::user()->id)["total_Withdrawalable_points"])) }}</p>
                                                        <span>Withdrawable Points</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('wallet.refund_points') }}">
                                                        <i class="ti-reload"></i>
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat(getCalPoints()["total_refund_points"]) }}</p>
                                                        <span>Refund Points</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('dashboard.transactions') }}">
                                                        <i class="ti-money"></i>
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat(getCalPoints()["total_used_points"]) }}</p>
                                                        <span>Payments</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('wallet.history') }}">
                                                        <img src="{{ asset('assets/images/payment_history.png') }}" height="75px" alt="Wallet History" />
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat(getFinalPoints()["available_points"]) }}</p>
                                                        <span>Wallet History</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('wallet.history') }}">
                                                        <img src="{{ asset('assets/images/redeemed_vocuher.png') }}" height="50px" alt="Redeemed History" />
                                                        <p class="mt-2 mb-n2">{{ getPointsFormat(getCalPoints()["total_redeem_points"]) }}</p>
                                                        <span><small>Redeemed Voucher Points</small></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
