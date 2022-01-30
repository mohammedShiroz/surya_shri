@extends('layouts.front')
@section('page_title','Order Failed')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Order Failed'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Order Failed','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Order Failed','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center order_complete">
                            <i class="fas fa-times-circle"></i>
                            <div class="heading_s1">
                                <h3 class="text-uppercase">Unable to complete transaction!</h3>
                            </div>
                            <p>Sorry for the inconvenience, due to the payment transaction declined, we can't able to make your order done. Please be patient and try again later.</p>
                            <a href="{{ route('products') }}" class="btn btn-fill-out">Back to Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
