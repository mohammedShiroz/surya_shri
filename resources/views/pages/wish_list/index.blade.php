@extends('layouts.front')
@section('page_title','Wish List')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Wish List'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Wish List','paths'=>[
                0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
                1=>['name'=>'Wish List','route'=>''],
            ]])
    <!-- START SECTION SHOP -->
    <div class="section small_pt mt-n5">
        <div class="container">
            @include('components.wish_list.data_fetch')
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection
