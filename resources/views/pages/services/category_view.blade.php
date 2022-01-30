@extends('layouts.front')
@section('page_title',$data->name)
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __($data->name." - Clinique"),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Clinique','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Clinique','route'=>route('services')],
            2=>['name'=>$data->name,'route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION WHY CHOOSE -->
        <div class="section small_pt pb_70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="heading_s1 text-center">
                            <h2>{{ $data->name }}</h2>
                        </div>
                        <p class="text-center leads" style="margin-top: -20px;">We provide you best health and consultation clinique</p>
                    </div>
                </div>
                <div class="row">
                    @foreach($data->services  as $service_row)
                        <div class="col-3">
                            <div class="item">
                                <div class="product" style="border: 2px solid #f4f4f4; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                    @auth
                                        @push('css')
                                            <style>
                                                .pr_flash_disc {
                                                    background-color: #FF9F00;
                                                    position: absolute;
                                                    right: 10px;
                                                    top: 10px;
                                                    text-transform: uppercase;
                                                    color: #fff;
                                                    padding: 2px 8px;
                                                    font-size: 13px;
                                                    z-index: 1;
                                                }
                                            </style>
                                        @endpush
                                        @if(\auth::user()->employee)
                                            @if($service_row->direct_commission)
                                                <span class="pr_flash_disc bg-success">{{ ($service_row->direct_commission)? $service_row->direct_commission."% Off" : '' }}</span>
                                            @endif
                                        @endif
                                    @endauth
                                    <div class="product_img" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <a href="{{ route('services.details',[$data->slug, $service_row->slug]) }}">
                                            <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                        </a>
                                        <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$data->slug, $service_row->slug]) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                        <div class="product_action_box">
                                            <ul class="list_none ">
                                                <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="{{ route('services.details',[$data->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
                                            <br/><small title="{{ $service_row->tag_code }}">{{ $service_row->tag_code }}</small></h6>
                                        <div class="product_price mb-2" style="height: 95px">
                                            <small><i class="ti-alarm-clock mr-1"></i> {{ ($service_row->duration_hour == null && $service_row->duration_minutes == null)? '-' : (($service_row->duration_hour? $service_row->duration_hour."hr " : '').($service_row->duration_minutes? $service_row->duration_minutes."min" : '')) }}</small><br/>
                                            <small><i class="ti-calendar mr-1"></i> {{ ($service_row->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$service_row->week_days)) : '-' }}</small><br/>
                                            <span class="price mt-1">{{ getCurrencyFormat($service_row->price) }}</span><br/>
                                            @if($service_row->discount_price)
                                                <div class="ml-n1">
                                                    <del>{{ getCurrencyFormat($service_row->actual_price) }}</del>
                                                    <div class="on_sale">
                                                        <span>{{ $service_row->discount_percentage }}% Off</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="d-inline-block w-100" style="height: 10px;"></span>
                                            @endif
                                        </div>
                                        <div class="rating_wrap ml-n1">
                                            <span class="rating_num">
                                                <div class="d-inline-flex">
                                                    <span class="mr-1 mt-1"><i class="{{ ($service_row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                                    <span>({{ $service_row->reviews->count() }})</span>
                                                </div>
                                            </span>
                                            <div class="rating ml-2">
                                                <div class="product_rate" style="width:{{ (($service_row->reviews->count()>0)? (100/5)* $service_row->reviews->sum('rate')/$service_row->reviews->count() : 0) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- END SECTION WHY CHOOSE -->
    </div>
@endsection
