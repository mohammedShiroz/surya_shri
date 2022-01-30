@extends('layouts.front')
@section('page_title','Wellness Basket')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Shopping Basket'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Wellness Basket','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Wellness Basket','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-70">
            @include('components.cart.fetch_cart_items')
        </div>
    </div>
    <!-- END MAIN CONTENT -->
@endsection
@push('script')
    <script src="{{ asset('assets/js/page/shopping_cart.js') }}"></script>
@endpush
