@extends('layouts.front')
@section('page_title','Partner Account')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Partner Account'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Partner Account','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Partner Account','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('employee_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">Partner Account</h5>
                            </div>
                            <div class="card-body" style="padding: 0 !important;">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('partners.profile') }}">
                                                        <i class="ti-user"></i>
                                                        <span>Partner Profile</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('partners.hierarchy') }}">
                                                        <i class="ti-anchor"></i>
                                                        <span>Partner Hierarchy</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('partners.products') }}">
                                                        <img src="{{ asset('assets/images/my_products Icon.png') }}" alt="my services" />
                                                        <span>My Product</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 pb-3">
                                            <div class="item">
                                                <div class="categories_box-2">
                                                    <a href="{{ route('partners.services') }}">
                                                        <img src="{{ asset('assets/images/my_service_icon.png') }}" alt="my services" />
                                                        <span>My Services</span>
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
