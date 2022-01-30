@extends('layouts.front')
@section('page_title','Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'MY POINTS','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'My Points','route'=>''],
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
                                <h5 class="text-uppercase">MY POINTS</h5>
                            </div>
                            <div class="card-body" style="padding: 0 !important;">
                                <!-- START SECTION WHY CHOOSE -->
                                <div class="pt-5">
                                    @if(\Auth::user()->employee)
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                            <p>Available Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--<div class="col-lg-3 col-sm-6">--}}
                                                    {{--<div class="icon_box icon_box_style4">--}}
                                                        {{--<div class="icon">--}}
                                                            {{--<i class="fa fa-coins"></i>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="icon_box_content">--}}
                                                            {{--<h5>{{ getPointsFormat(getFinalPoints()["total_points"]) }}</h5>--}}
                                                            {{--<p>My Total Points</p>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_transferred_points"]) }}</h5>
                                                            <p>Transferred Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat((getCalPoints()["total_direct_points"]+getCalPoints()["total_in_direct_points"]) - getCalPoints()["total_transferred_points"]) }}</h5>
                                                            <p>Transferable Point</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_credited_points"]) }}</h5>
                                                            <p>Received Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_in_direct_points"]) }}</h5>
                                                            <p>Network Earnings</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_refund_points"]) }}</h5>
                                                            <p>Total Refund<br/>Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_used_points"]) }}</h5>
                                                            <p>Total Used<br/>Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_withdrawal_points"]) }}</h5>
                                                            <p>Total Withdrawal Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat((getWithdrawalablePointsByUser(\auth::user()->id)["total_Withdrawalable_points"]-getCalPoints()["pending_withdrawal_points"])) }}</h5>
                                                            <p>Points Available to Withdraw</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_seller_earn_points"]) }}</h5>
                                                            <p>Total Seller Earning Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_doctor_earn_points"]) }}</h5>
                                                            <p>Total Doctors Earning Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_in_direct_points"]) }}</h5>
                                                            <p>Total Network Sales</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                            <p>Available Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_refund_points"]) }}</h5>
                                                            <p>Total Refund<br/>Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_used_points"]) }}</h5>
                                                            <p>Total Used<br/>Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fa fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPoints()["total_withdrawal_points"]) }}</h5>
                                                            <p>Total Withdrawal Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                                <!-- END SECTION WHY CHOOSE -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
