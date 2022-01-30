@extends('layouts.front')
@section('page_title','Affiliate Policy')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Affiliate Policy'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Affiliate Policy','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Affiliate Policy','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- STAT SECTION FAQ -->
        <div class="section small_pt">
            <div class="container">
                @include('components.policy.affiliate_policy_contents')
            </div>
        </div>
        <!-- END SECTION FAQ -->
    </div>
@endsection
