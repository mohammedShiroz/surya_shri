@extends('layouts.front')
@section('page_title','Purchase Success')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Purchase Success'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Thank You','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Purchase Success','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center order_complete">
                            <i class="fas fa-check-circle"></i>
                            <div class="heading_s1">
                                <h3 class="text-uppercase">YOUR ORDER WAS SUCCESSFUL!</h3>
                            </div>
                            @if(\Session::get('order_success') != "success")
                                <p>Congratulations {{ \auth::user()->name." ".\auth::user()->last_name }}. Now you are approved as one of our partner by used {{ \App\Agent::find(\Session::get('order_success'))->user->name." ".\App\Agent::find(\Session::get('order_success'))->user->last_name }}'s voucher. And, Thank you for your purchase! You will receive a confirmation email once your order is processed.</p>
                                <a href="{{ route('dashboard.orders') }}" class="btn btn-line-fill btn-radius">Track Order</a>
                                <a href="{{ route('partners.profile') }}" class="btn btn-outline-dark btn-radius"><small>Partner Profile</small></a>
                            @else
                            <p>Thank you for your purchase! You will receive a confirmation email once your order is processed</p>
                            <a href="{{ route('dashboard.orders') }}" class="btn btn-line-fill btn-radius"><small>Track Order</small></a>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
