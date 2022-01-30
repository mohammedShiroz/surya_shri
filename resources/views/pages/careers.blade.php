@extends('layouts.front')
@section('page_title','Careers')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Careers'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Careers','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Careers','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- STAT SECTION ABOUT -->
        <div class="section small_pt">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="blog_post blog_style2 box_shadow1">
                            <div class="blog_img">
                                <a href="#">
                                    <img src="{{ asset('assets/images/careers/career1.jpg') }}" alt="career image">
                                </a>
                            </div>
                            <div class="blog_content bg-white text-center">
                                <div class="blog_text">
                                    <h5 class="blog_title" style="height: 70px;"><a href="javascript:void(0)">CALMING BREATHING TECHNIQUES</a></h5>
                                    <p>January 27, 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog_post blog_style2 box_shadow1">
                            <div class="blog_img">
                                <a href="#">
                                    <img src="{{ asset('assets/images/careers/career2.jpg') }}" alt="career image">
                                </a>
                            </div>
                            <div class="blog_content bg-white text-center">
                                <div class="blog_text">
                                    <h5 class="blog_title" style="height: 70px;"><a href="javascript:void(0)">APPLYING WELLNESS TO ALL ASPECTS OF LIFE</a></h5>
                                    <p>January 27, 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog_post blog_style2 box_shadow1">
                            <div class="blog_img">
                                <a href="#">
                                    <img src="{{ asset('assets/images/careers/career3.jpg') }}" alt="career image">
                                </a>
                            </div>
                            <div class="blog_content bg-white text-center">
                                <div class="blog_text">
                                    <h5 class="blog_title" style="height: 70px;"><a href="javascript:void(0)">SIMPLE SELF-CARE HABITS</a></h5>
                                    <p>January 27, 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
