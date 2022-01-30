@extends('layouts.front')
@section('page_title','Thanks For Your Booking')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Thanks For Your Booking'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Thank You','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Reservation Success','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center order_complete">
                            <i class="fas fa-check-circle"></i>
                            <div class="heading_s1">
                                <h3 class="text-uppercase">YOUR RESERVATION WAS SUCCESSFUL!</h3>
                            </div>
                            <p>Thank you for reserving our services! You will receive a confirmation email once your reservation is processed.</p>
                            <a href="{{ route('home') }}" class="btn btn-fill-out">Back to home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
