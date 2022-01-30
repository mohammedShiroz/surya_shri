@extends('layouts.front')
@section('page_title','Recommended Service')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Recommended Service'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.alert')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Recommended Service','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Clinique','route'=>route('services')],
            2=>['name'=>'Recommended Service','route'=>''],
        ]]);
    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
                        <div class="col-12">
                            <div class="product_header">
                                <div class="dashboard_menu">
                                    <ul class="nav nav-tabs flex-column border" style="background: transparent !important;">
                                        <li class="nav-item">
                                            <a class="nav-link">
                                                <i class="fa fa-info-circle"></i> {{ $services->count() }} recommended result found!
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product_header_right">
                                    <div class="products_view">
                                        <a href="javascript:void(0)" class="shorting_icon-delete btn-re-check"><i class="ti-reload"></i> Re-Check Prakurthi</a>
                                        <form action="{{ route('prakrti.re_check') }}" method="post" class="d-none" id="re-check-form">@csrf</form>
                                        @push('script')
                                            <script>
                                                $(".btn-re-check").click(function(){
                                                    swal.fire({
                                                        title: '<span class="text-uppercase">Re-Check?</span>',
                                                        text: "Do you want to re-check your 'Prakrti' (Body constitution)?",
                                                        type: 'warning',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Yes, check it!',
                                                        cancelButtonText: 'No, Thanks!',
                                                        reverseButtons: true
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            document.getElementById('re-check-form').submit();
                                                        } else if (
                                                            // Read more about handling dismissals
                                                            result.dismiss === Swal.DismissReason.cancel
                                                        ) { }
                                                    });
                                                });
                                            </script>
                                        @endpush
                                        <a href="javascript:Void(0);" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                        <a href="javascript:Void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.services.recommended_services_data_fetch')
                </div>
                <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                    <div class="sidebar">
                        <div class="widget">
                            <button class="accordion-cus">TOP SERVICE CATEGORY</button>
                            <div class="accordion-panel">
                                <div class="cart_box cart_list_filter">
                                    <ul class="widget_categories">
                                        <li><a href="{{ route('services') }}"><span class="categories_name">All Clinique</span><span class="categories_num">({{ \App\Service::all()->count() }})</span></a></li>
                                        @foreach(\App\Service_category::orderby('order','ASC')->where('visibility',1)->get() as $row)
                                            <li><a href="{{ route('services.category',$row->slug) }}"><span class="categories_name">{{ $row->name }}</span><span class="categories_num">({{ $row->services->count() }})</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button class="accordion-cus text-uppercase mt-3">Recommended Products</button>
                            <div class="accordion-panel mt-2">
                                <ul class="widget_recent_post">
                                    @if($products->count()>0)
                                        @foreach($products as $row)
                                            <li>
                                                <div class="post_img">
                                                    <a href="{{ route('product.details',$row->slug) }}">
                                                        <img class="radius_all_5" src="{{ asset(($row->thumbnail_image)? $row->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $row->name }}">
                                                    </a>
                                                </div>
                                                <div class="post_content">
                                                    <h6 class="product_title"><a href="{{ route('product.details',$row->slug) }}">{{ $row->name }}</a></h6>
                                                    <div class="product_price" style="margin-top: -7px; line-height: 17px !important;">
                                                        <span class="price">{{ getCurrencyFormat($row->price) }}</span>
                                                        @if($row->discount_price)
                                                            <del>{{ getCurrencyFormat($row->actual_price) }}</del>
                                                            <div class="on_sale">
                                                                <span>{{ $row->discount_percentage }}% Off</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="rating_wrap" style="margin-top: -3px;">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:{{ (($row->reviews->count()>0)? (100/5)* $row->reviews->sum('rate')/$row->reviews->count() : 0) }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <p>No Result found!</p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
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
                                    <a href="{{ route('prakrti.products') }}" class="btn btn-primary pl-5 pr-5 pt-2 pb-2 bg-primary">Check Boutique</a>
                                </div>
                                <div class="medium_divider clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/category_filter_accordion.js') }}"></script>
@endpush
