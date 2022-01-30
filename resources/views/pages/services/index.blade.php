@extends('layouts.front')
@section('page_title','Clinique')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Clinique'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/customs_popup.css')}}">
@endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'CLINIQUE','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Clinique','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION WHY CHOOSE -->
        <div class="section small_pt pb_70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="heading_s1 text-center">
                            <h2>Our Authentic Ayurveda Clinique</h2>
                        </div>
                        <p class="text-center leads" style="margin-top: -20px;">Authentic Ayurveda Regimens for Prevention & Cure</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if(isset($_COOKIE['load_popup']))
                            @if($_COOKIE['load_popup'] == "true")
                            @endif
                        @endif
                        <button class="button button--warning d-none" id="show_question_popup" data-for="js_question-popup"></button>
                        <div class="popup popup--icon -question js_question-popup">
                            <div class="popup__background"></div>
                            <div class="popup__content">
                                <button type="button" class="close" data-for="js_question-popup">
                                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                                </button>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="background_bg h-100 radius_all_5" data-img-src="{{ asset('assets/images/prakrti-pop-up-image.png') }}"></div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="popup_content p-2">
                                            <div class="popup-text">
                                                <div class="heading_s1 pt-md-2 pt-sm-1">
                                                    <h3>Prakrti Parīksha</h3>
                                                </div>
                                                <p style="font-weight: 400; line-height: 20px;" class="mt-n4">Understand yourself better<br/>by assessing your Prakrti!</p>
                                                <p style="line-height: 20px;" class="p-1">Let's evaluate your 'Prakrti' (body constitution) to see what wellness and beauty Products and Services best suit you! Make sure you select the most suitable answer option that fits your natural state.</p>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <a class="button button--check--now btn-block text-uppercase rounded-0" href="{{ route('prakrti.products') }}" title="Check Now">Check Now</a>
                                            </div>
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="popup-show" id="popup-show" value="">
                                                    <label class="form-check-label" for="popup-show"><span>Don't show this popup again!</span></label>
                                                </div>
                                            </div>
                                            <p class="mt-1 pb-0" style="margin-bottom: -10px;"><a href="javascript:void(0)" data-for="js_question-popup" class="small">Skip it</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @push('script')
                            <script>
                                $( document ).ready(function() {
                                    setTimeout(function () {
                                        @auth @if(!\App\Customers_answers::where('user_id',\auth::user()->id)->first()) $('#show_question_popup').trigger('click'); @endif
                                        @else $('#show_question_popup').trigger('click'); @endauth
                                    }, 2000);
                                });
                                const addButtonTrigger = el => {
                                    el.addEventListener('click', () => {
                                        const popupEl = document.querySelector(`.${el.dataset.for}`);
                                        popupEl.classList.toggle('popup--visible');
                                    });
                                };
                                Array.from(document.querySelectorAll('button[data-for]')).
                                forEach(addButtonTrigger);
                                Array.from(document.querySelectorAll('a[data-for]')).
                                forEach(addButtonTrigger);
                                $("#popup-show").click(function(){
                                    if($("input:checkbox[name='popup-show']").is(":checked")) {
                                        set_cookie('false'); }else{ set_cookie('true');
                                    }
                                });
                                function set_cookie(status){
                                    $.ajax({
                                        url:"prakrti-parīksha/popup-curd",
                                        method: "POST",
                                        data:{status:status},
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        success: function (data) {}
                                    });
                                }
                            </script>
                        @endpush
                    </div>
                    <div class="col-12">
                        <div class="heading_tab_header text-center">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs justify-content-center justify-content-md-end" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="service-tab-all" data-toggle="tab" href="#service_all" role="tab" aria-controls="service_all" aria-selected="true">All</a>
                                    </li>
                                    @foreach(\App\Service_category::orderby('order','ASC')->where('visibility',1)->get() as $row)
                                        <li class="nav-item">
                                            <a class="nav-link" id="service-tab-{{ $loop->index }}" data-toggle="tab" href="#service_{{ $loop->index }}" role="tab" aria-controls="service_{{ $loop->index }}" aria-selected="true">{{ $row->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab_slider">
                            <div class="tab-pane fade show active" id="service_all" role="tabpanel" aria-labelledby="service-tab-all">
                                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1 dot_style1" data-loop="false" data-dots="true" data-nav="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                                    @foreach(\App\Service::whereNull('is_deleted')->where('visibility',1)->inRandomOrder()->get()  as $service_row)
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
                                                    <a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">
                                                        <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                                    </a>
                                                    <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$row->slug, $service_row->slug]) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                                    <div class="product_action_box">
                                                        <ul class="list_none ">
                                                            <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title"><a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
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
                                    @endforeach
                                </div>
                            </div>
                            @foreach(\App\Service_category::orderby('order','ASC')->where('visibility',1)->get() as $row)
                                <div class="tab-pane fade" id="service_{{ $loop->index }}" role="tabpanel" aria-labelledby="service-tab-{{ $loop->index }}">
                                    @if($row->services->count()>0)
                                        <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1" data-loop="false" data-dots="false" data-nav="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                                            @foreach($row->services  as $service_row)
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
                                                            <a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">
                                                                <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                                            </a>
                                                            <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$row->slug, $service_row->slug]) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                                            <div class="product_action_box">
                                                                <ul class="list_none ">
                                                                    <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="product_info">
                                                            <h6 class="product_title"><a href="{{ route('services.details',[$row->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
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
                                            @endforeach
                                        </div>
                                        @if($row->services->count() > 4)
                                            <div class="small_divider"></div>
                                            <div class="d-block text-center">
                                                <a href="{{ route('services.category',$row->slug) }}" class="btn btn-line-fill btn-radius pl-5 pr-5 pt-md-2 pb-md-2 pt-sm-1 pb-sm-1">View More</a>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-center mt-3"><i class="fa fa-info-circle"></i> No result found!</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION WHY CHOOSE -->
        <div class="section pb_40 small_pt mt-md-n5 mt-sm-n1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-sm-12">
                        <div class="icon_box icon_box_style4 border border-1">
                            <div class="row align-items-center flex-row-reverse">
                                <div class="col-md-12">
                                    <div class="medium_divider d-none d-md-block clearfix"></div>
                                    <div class="trand_banner_text text-center">
                                        <div class="heading_s1 mb-3">
                                            <h2 class="">Prakrti Parīksha</h2>
                                        </div>
                                        <p class="mb-4" style="color: #000000;">Find out which wellness and beauty products and services are recommended for you!
                                            <br/><span style="font-weight: 600;">Balancing <span class="line">&#73;</span> Revitalizing</span></p>
                                        <a href="{{ route('prakrti.products') }}" class="btn btn-primary pl-5 pr-5 pt-2 pb-2 bg-primary">Check Now &nbsp;</a>
                                    </div>
                                    <div class="medium_divider clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
