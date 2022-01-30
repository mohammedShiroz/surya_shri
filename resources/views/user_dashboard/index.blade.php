@extends('layouts.front')
@section('page_title','Dashboard')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Dashboard'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Dashboard','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>''],
    ]]))
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 pb-5">
                        @include('components.messages')
                        <div class="tab-content dashboard_content">
                            <div class="container_profile">
                                <div class="card_profile">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 user-cart-profile">
                                            <img class="img-circle p-3 mt-2" width="240" height="240" style="border: 2px solid #f9f9f6; border-radius: 50%" src="{{ (!empty(\auth::user()->profile_image))? asset(\auth::user()->profile_image) : asset('assets/images/avatar.png') }}" alt="{{ \auth::user()->name }}">
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <div class="description">
                                                <h2 class="text-uppercase">{{ \auth::user()->name }} {{ \auth::user()->last_name }}</h2>
                                                <h4 class="text-black-50">{{ \auth::user()->email }}</h4>
                                                <p class="mt-n2">{{ \auth::user()->user_code }}</p>
                                                <p>Your dashboard provides you easy access to all information regarding your activities
                                                    at SURYA SHRI. You can also monitor your transactions, orders, reservations plus
                                                    your team’s performance and growth through here as well.</p>
                                                <div class="tags pl-3">
                                                    <ul>
                                                        <li><a href="{{ route('shopping_cart') }}"><i class="fa fa-shopping-basket"></i> {{ \Cart::instance('shopping')->count() }}</a></li>
                                                        <li><a href="{{ route('wish-list') }}"><i class="fa fa-heart color"></i> {{ \App\Wishlist::where('user_id', \auth::user()->id)->get()->count() }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(\auth::user()->answer)
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-5">
                        <div class="sidebar">
                            <div class="widget">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3 text-center">
                                        <h5>MY PRAKRTI ANALYZED REPORT</h5>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="contact_wrap contact_style3">
                                            <div class="contact_icon">
                                                <span class="vata-progress-count">{{ (\auth::user()->answer->vata)? round(\auth::user()->answer->vata,0) : '0' }}%</span>
                                            </div>
                                            <div class="contact_text">
                                                <p class="text-uppercase"><strong>Vāta</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="contact_wrap contact_style3">
                                            <div class="contact_icon">
                                                <span class="pitta-progress-count">{{ (\auth::user()->answer->pitta)? round(\auth::user()->answer->pitta,0) : '0' }}%</span>
                                            </div>
                                            <div class="contact_text">
                                                <p class="text-uppercase"><strong>Pitta</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="contact_wrap contact_style3">
                                            <div class="contact_icon">
                                                <span class="kapha-progress-count">{{ (\auth::user()->answer->kapha)? round(\auth::user()->answer->kapha,0) : '0' }}%</span>
                                            </div>
                                            <div class="contact_text">
                                                <p class="text-uppercase"><strong>Kapha</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card" >
                                    <div class="card-header">
                                        <h5 class="text-uppercase text-center">DASHBOARD</h5>
                                    </div>
                                    <div class="card-body">
                                        @include('user_dashboard.nav.layout')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card" >
                                    <div class="card-header">
                                        <h5 class="text-uppercase text-center">My Wallet</h5>
                                    </div>
                                    <div class="card-body">
                                        @include('user_wallet.nav.layout')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('employee_dashboard.index')
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
    @if(\Auth::user()->agent_status == "Not Approved")
        @include('components.popup.employee_request')
    @endif
@endsection
