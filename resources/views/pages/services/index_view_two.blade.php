@extends('layouts.front')
@section('page_title','Clinique')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Clinique'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@include('backend.components.plugins.range_slider')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/customs_popup.css')}}">
@endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'CLINIQUE','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Clinique','route'=>''],
        ]])
    <!-- START SECTION SHOP -->
    <div class="section small_pt">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
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
                            <div class="product_header">
                                <div class="product_header_left">
                                    <div class="custom_select">
                                        <input type="hidden" id="get_sorting_value" value="" />
                                        <select class="form-control form-control-sm" id="sorting_filter">
                                            <option value="New" selected>Latest</option>
                                            <option value="Old">Earliest</option>
                                            <option value="Low_to_high">Sort by price: low to high</option>
                                            <option value="High_to_low">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="product_header_right">
                                    <div class="products_view">
                                        <a href="javascript:Void(0);" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                        <a href="javascript:Void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                    </div>
                                    <div class="custom_select">
                                        <input type="hidden" id="get_showing_number" value="" />
                                        <select class="form-control form-control-sm" id="show_filter">
                                            <option>Showing</option>
                                            <option value="4">4</option>
                                            <option value="8">8</option>
                                            <option value="12">12</option>
                                            <option value="20" selected>20</option>
                                            <option value="24">24</option>
                                            <option value="28">28</option>
                                            <option value="32">32</option>
                                            <option value="36">36</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.services.service_data_fetch')
                </div>
                <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                    @include('components.services.category_filter')
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
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" id="first_lvl_tag" value="{{ isset($first_lvl_category_detail)? $first_lvl_category_detail->id : '' }}" />
@endsection
@push('js')
    <script src="{{ asset('assets/js/category_filter_accordion.js') }}"></script>
@endpush
@push('script')
    <script>
        $(document).ready(function () {
            //:If Category has in the url
            if(!$("#search_check").val()){ filter_data(); }
            function get_filter(class_name) {
                var filter = [];
                $('.' + class_name + ':checked').each(function () {
                    filter.push($(this).val());
                });
                return filter;
            }
            $('.common_selector').click(function () {
                if ($("#stock_check").is(':checked')) {
                    $("#available_check").val('yes');
                }else{
                    $("#available_check").val("no");
                }
                filter_data();
            });
            function filter_data() {
                $(".shop_container").append('<div class="loading_pr"><div class="mfp-preloader"></div></div>');
                var action = 'fetch_data';
                var minimum_price = parseInt($('#minimum_price').val());
                var maximum_price = parseInt($('#maximum_price').val());
                var available = $("#available_check").val();
                var show_item =parseInt($("#get_showing_number").val());
                var sorting= $("#get_sorting_value").val();
                var page=$("#hidden_page").val();
                var first_lvl_tag= $("#first_lvl_tag").val();
                $.ajax({
                    url:"/cliniques/fetch-data/service-data?page="+page+"&minimum_price="+minimum_price+"&maximum_price="+maximum_price+"&available="+available+"&show_item="+show_item+"&sorting="+sorting+"&first_lvl_tag="+first_lvl_tag,
                    method: "POST",
                    data:{},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        //console.log(data);
                        $('.loading_pr').remove();
                        $('.filter_data').empty().html(data.view);
                    }
                });
            }
            var parent = document.querySelector(".price-slider");
            if(!parent) return;
            var rangeS = parent.querySelectorAll("input[type=range]"),
                numberS = parent.querySelectorAll("input[type=number]");
            rangeS.forEach(function(el) {
                el.oninput = function() {
                    var slide1 = parseFloat(rangeS[0].value),
                        slide2 = parseFloat(rangeS[1].value);

                    if (slide1 > slide2) {
                        [slide1, slide2] = [slide2, slide1];
                    }
                    numberS[0].value = slide1;
                    numberS[1].value = slide2;
                    $("#minimum_price").val($(".minimum_price").val());
                    $("#maximum_price").val($(".maximum_price").val());
                    filter_data();
                    $("#narrow-clear").fadeIn();
                }
            });
            numberS.forEach(function(el) {
                el.oninput = function() {
                    var number1 = parseFloat(numberS[0].value),
                        number2 = parseFloat(numberS[1].value);

                    if (number1 > number2) {
                        var tmp = number1;
                        numberS[0].value = number2;
                        numberS[1].value = tmp;
                    }
                    rangeS[0].value = number1;
                    rangeS[1].value = number2;
                }
            });
            // grep the price only once...
            var price_text = parseFloat($(".minimum_price").text());
            function updatePrice() {
                $("#minimum_price").val($(".minimum_price").val());
                $("#maximum_price").val($(".maximum_price").val());
                filter_data();
                $("#narrow-clear").fadeIn();
            }
            $(document).on("change, mouseup, keyup", ".minimum_price", updatePrice);
            $(document).on("change, mouseup, keyup", ".maximum_price", updatePrice);
            $("#sorting_filter").change(function () {
                $("#get_sorting_value").val($(this).val());
                filter_data();
            });

            $("#show_filter").change(function () {
                $("#get_showing_number").val($(this).val());
                filter_data();
            });
            $(document).on('click', '.pagination a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                if(page !=undefined){
                    filter_data();
                }
            });
            $(document).on('click', '.popup-ajax', function(event){
                event.preventDefault();
                $('.popup-ajax').magnificPopup({
                    type: 'ajax',
                    callbacks: {
                        ajaxContentAdded: function() {
                            carousel_slider();
                            slick_slider();
                        }
                    }
                });
            });
        });
    </script>
@endpush


