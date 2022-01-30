@extends('layouts.front')
@section('page_title','Terms & Condition')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Terms & Condition'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Our Terms & Condition','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Terms & Condition','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- STAT SECTION FAQ -->
        <div class="section small_pt">
            <div class="container">
                @include('components.policy.terms_condition_contents')
            </div>
        </div>
        <!-- END SECTION FAQ -->
    </div>
@endsection
