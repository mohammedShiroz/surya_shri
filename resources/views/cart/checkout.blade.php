@extends('layouts.front')
@section('page_title','Product Purchase')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Product Purchase'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.alert')
@push('css')
    <link href="{{ asset('assets/css/customs.css') }}" rel="stylesheet"/>
    <style>.wizard > div.wizard-inner {text-align: right;}.select2-container .select2-selection--single { height: 50px}.select2-container--default .select2-selection--single { padding-top: 10px;}.select2-container--default .select2-selection--single .select2-selection__arrow { top: 13px;}</style>
@endpush
@include('backend.components.plugins.select2')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Product Purchase','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Product Purchase','route'=>''],
        ]])
    <!-- Make_track_id -->
    @php $order_code = \Auth::user()->id . rand(10, 100) . date('ymdhis'); @endphp
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <section class="signup-step-container">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="wizard justify-content-center">
                            <div class="wizard-inner">
                                <div class="connecting-line" style="width: 50%;"></div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#step1" data-toggle="tab"
                                           aria-controls="step1" role="tab"
                                           aria-expanded="true"><span class="round-tab">1 </span>
                                            <i>Step 1</i>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step2" id="step_2" data-toggle="tab" data-type="shipping_info"
                                           aria-controls="step2" role="tab"
                                           aria-expanded="false" class="check_validation_by_number step_2"><span class="round-tab">2</span> <i>Step
                                                2</i>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step3" data-toggle="tab" data-type="review_cart"
                                           aria-controls="step3" role="tab" class="check_validation_by_number step_3"><span class="round-tab">3</span> <i>Step
                                                3</i>
                                        </a>
                                    </li>
                                    <li disabled onclick="{ return false;}" class="d-none">
                                        <a href="javascript:void(0)" data-type="block" disabled><span class="round-tab">4<i class="fa fa-check" aria-label=""></i></span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="row mt-1 mb-n5">
                                <div class="col-12">
                                    @include('components.messages')
                                </div>
                            </div>
                            <form method="POST" action="{{ route('order.create') }}" id="place-order-form">
                                @csrf
                                <input type="hidden" id="track_id" name="track_id" value="{{ $order_code }}" />
                                <input type="hidden" name="user_id" id="user_id" value="{{ \auth::user()->id }}" />
                                <input type="hidden" class="voucher_id" name="voucher_id" value="" />
                                <input type="hidden" class="voucher_provide_by" name="voucher_provide_by" value="" />
                                <input type="hidden" class="voucher_ref_by" name="voucher_ref_by" value="" />
                                <input type="hidden" class="coupon_id" name="coupon_id" value="" />
                                <input type="hidden" class="user_code" name="user_code" value="" />
                                <input type="hidden" id="get_payment_method" name="payment_method" value=""/>
                                <div class="tab-content" id="main_form">
                                    <div class="tab-pane active" role="tabpanel" id="step1">
                                        <div class="row mt-2">
                                            <div class="col-md-12 pb-5">
                                                <div class="toggle_info">
                                                    <span><i class="fas fa-truck"></i>Step 1: Add Delivery Details</span>
                                                </div>
                                                <div class="panel-collapse show collapse login_form" id="billing_info"
                                                     aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        @if(count(\Cart::instance('shopping')->content())>0)
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <div>
                                                                    <div class="form-group">
                                                                        <label>Buyer Name*</label>
                                                                        <input type="text" required class="form-control @error('name') is-invalid @enderror input_identity" id="shipping_name"
                                                                               name="name"
                                                                               placeholder="Name *"
                                                                               value="{{ old('name')?old('name') : \auth::user()->name }}">
                                                                        <p class="text-danger shipping_name_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Delivery Address*</label>
                                                                        <div class="custom_select">
                                                                            <select class="form-control input_identity select2 @error('address') is-invalid @enderror" name="address" id="shipping_address" style="width: 100%;">
                                                                                <option selected="selected" disabled value="null">Choose the Shipping Address</option>
                                                                                @foreach(\auth::user()->address_info as $row)
                                                                                    <option value="{{ $row->address." - ".$row->postal_code }}" {{ ($loop->index == 0)?'selected': '' }} {{ (old('address')==($row->address." - ".$row->postal_code))?'selected':'' }}>{{ $row->address }} - ({{$row->postal_code}}) </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <a href="{{ route('dashboard.account') }}"><span class="mt-2 d-block"><i class="fa fa-plus fa-sm"></i> {{ (\auth::user()->address_info->count()>0)? 'Add Another Address' : 'Add your Address' }}</span></a>
                                                                        <p class="text-danger shipping_address_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="custom_select">
                                                                            <label>Delivery Country*</label>
                                                                            <select class="form-control input_identity select2 @error('country') is-invalid @enderror" disabled name="country" id="shipping_country" style="width: 100%;">
                                                                                <option selected="selected" disabled value="">Choose the Country</option>
                                                                                @if(\App\Location::where('parent_id',0)->get()->count() > 0)
                                                                                    @foreach(\App\Location::where('parent_id',0)->get() as $row)
                                                                                        <option value="{{ $row->name }}" {{ (old('country') == $row->name)? 'selected' : (($row->id == 189 )? 'selected' : '') }} data-id="{{ $row->id }}">{{ $row->name }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                        <p class="text-danger shipping_country_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="custom_select">
                                                                            <label>Shipping City*</label>
                                                                            <select class="form-control input_identity select2 @error('city') is-invalid @enderror" name="city" id="shipping_city" style="width: 100%;">
                                                                                <option selected="selected" disabled value="">Choose the city</option>
                                                                                @foreach(\App\Location::where('parent_id', 189)->orderby('name','ASC')->get() as $row)
                                                                                    <option value="{{ $row->name }}" {{ (\auth::user()->city == $row->name)? 'selected' : '' }}>{{ $row->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <p class="text-danger shipping_city_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>
                                                                    @push('script')
                                                                        <script>
                                                                            $('#shipping_country').on('change', function () {
                                                                                Get_city_name($(this).find(':selected').attr('data-id'), '{{route('user.fetch.city')}}', '#shipping_city');
                                                                            });
                                                                            function Get_city_name(selected_value, url, data_fetch_id) {
                                                                                $.ajax({
                                                                                    url: url,
                                                                                    type: "POST",
                                                                                    data: {
                                                                                        id: selected_value,
                                                                                        _token: '{{ csrf_token()}}',
                                                                                    },
                                                                                    cache: true,
                                                                                    success: function (data) {
                                                                                        $(data_fetch_id).html('');
                                                                                        $(data_fetch_id).append(data);
                                                                                    }
                                                                                });
                                                                            }

                                                                            $('#shipping_name').on('keypress', function (event) {
                                                                                var regex = new RegExp("^[A-Z-a-z]+$");
                                                                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                                                                                if (!regex.test(key)) {
                                                                                    event.preventDefault();
                                                                                    return false;
                                                                                }
                                                                            });

                                                                            $('#shipping_phone').on('keypress', function (event) {
                                                                                var regex = new RegExp("^[0-9+]+$");
                                                                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                                                                                if (!regex.test(key)) {
                                                                                    event.preventDefault();
                                                                                    return false;
                                                                                }
                                                                            });
                                                                        </script>
                                                                    @endpush
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <div>
                                                                    <div class="form-group">
                                                                        <label>Contact*</label>
                                                                        <input class="form-control @error('contact') is-invalid @enderror input_identity" required id="shipping_phone" type="text"
                                                                               name="contact"
                                                                               value="{{ old('contact')? old('contact'):\auth::user()->contact }}"
                                                                               placeholder="Contact *">
                                                                        <p class="text-danger shipping_phone_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email*</label>
                                                                        <input class="form-control input_identity" required type="email"
                                                                               id="shipping_email"
                                                                               value="{{ old('email')? old('email'):\auth::user()->email }}"
                                                                               name="email"
                                                                               placeholder="Email *">
                                                                        <p class="text-danger shipping_email_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Preferred Delivery Method*</label>
                                                                        <select class="form-control input_identity select2 @error('delivery_method') is-invalid @enderror" name="delivery_method" id="shipping_delivery_method" style="width: 100%;">
                                                                            <option selected="selected" disabled value="null">Choose the delivery method</option>
                                                                            <option value="Delivery" {{ (old('delivery_method')? ((old('delivery_method') == "Delivery")? 'selected' : '') : '') }}>Delivery</option>
                                                                            <option value="Store Pickup" {{ (old('delivery_method')? ((old('delivery_method') == "Store Pickup")? 'selected' : '') : '') }}>Store Pickup</option>
                                                                        </select>
                                                                        <p class="text-danger shipping_delivery_method_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>

                                                                    <div class="form-group" id="show-pre-address" style="display: none;">
                                                                        <label>Pre-entered or New address </label>
                                                                        <input type="text" required class="form-control @error('pre_address') is-invalid @enderror input_identity" id="pre_address"
                                                                               name="pre_address"
                                                                               placeholder="Pre-entered or New address *"
                                                                               value="{{ old('pre_address')?old('pre_address') : '' }}">
                                                                        <p class="text-danger shipping_pre_address_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                    </div>

                                                                    <div class="form-group mb-2" id="show-contact-details" style="display: none;">
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <td colspan="2"><strong>Our Contact Details</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Mobile</td>
                                                                                <td><a href="tel:+94769244427">(+94) 769244427</a> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>E-mail</td>
                                                                                <td><a href="mailto:suryashri.ayurveda@gmail.com">suryashri.ayurveda@gmail.com</a> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Location</td>
                                                                                <td>112 5th Ln, Pannipitiya 10230, Sri-lanka</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="heading_s1">
                                                                        <h4>Additional Note</h4>
                                                                    </div>
                                                                    <div class="form-group mb-0">
                                                                        <textarea rows="5" class="form-control" id="customer_note"
                                                                                  name="note" placeholder="Notes"></textarea>
                                                                        <div id="counter_note"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="">
                                                                        <div class="card-body cart">
                                                                            <div class="col-sm-12 empty-cart-cls text-center"><img src="{{ asset('assets/images/comparision_empty.jpg') }}" width="260px" height="260px" class="img-fluid mb-4 mr-3">
                                                                                <h3><strong>Your Wellness Basket Is Empty</strong></h3>
                                                                                <h6>Add something and place your order :)</h6>
                                                                                <a href="{{ route('products') }}" class="btn btn-fill-out"
                                                                                   data-abc="true">Continue Shopping</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(count(\Cart::instance('shopping')->content())>0)
                                            <div class="pull-right float-right mb-5" style="margin-top: -25px;">
                                                <button data-type="shipping_info" type="button"
                                                        class="btn btn-fill-out pl-5 pr-5 next-step">
                                                    Continue
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step2">
                                        <div class="row mt-2">
                                            <div class="col-md-12 pb-5">
                                                <div class="toggle_info">
                                                    <span><i class="fas fa-cubes"></i>Step 2: Review Orders</span>
                                                </div>
                                                <div class="panel-collapse show collapse login_form" id="billing_info"
                                                     aria-labelledby="headingOne">
                                                    <div class="panel-body" style="padding: 0;">
                                                        <div class="row full_cart_show">
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-body cart" style="padding: 0">
                                                                        @include('cart.item_reviews.order_items',['discount_activate'=> null])
                                                                        <div class="table-responsive shop_cart_table">
                                                                            <table class="table">
                                                                                <tfoot>
                                                                                <tr>
                                                                                    <td colspan="6" class="px-0">
                                                                                        <div class="row no-gutters align-items-center">
                                                                                            <div class="col-lg-12 col-md-12 mb-3 mb-md-0 pl-3">
                                                                                                <div class="coupon field_form input-group">
                                                                                                    <div class="input-group-append mx-sm-0">
                                                                                                        <a href="{{ route('shopping_cart') }}" class="btn btn-fill-out btn-sm"
                                                                                                           data-abc="true"><i class="fa fa-shopping-basket text-gray-dark"></i> View Wellness Basket</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-9 offset-1">
                                                                <div class="small_divider"></div>
                                                                <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                                                                <div class="small_divider"></div>
                                                            </div>
                                                        </div>
                                                        <div class="pt-0 pl-5 pr-5 pb-5">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="toggle_info">
                                                                        <span><i class="fas fa-tag"></i>Have a Coupon/Partner Code? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a></span>
                                                                    </div>
                                                                    <div class="panel-collapse collapse coupon_form" id="coupon">
                                                                        <div class="panel-body">
                                                                            <p>{{ \auth::user()->employee? 'Your lifetime coupon code is activated!' : 'If you have a voucher code, please apply it below.' }}</p>
{{--                                                                            <div class="check-form mb-2 mt-n3">--}}
{{--                                                                                <div class="custome-checkbox">--}}
{{--                                                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="by_partner" value="">--}}
{{--                                                                                    <label class="form-check-label" for="by_partner"><span>Provide by partner?</span></label>--}}
{{--                                                                                </div>--}}
{{--                                                                            </div>--}}
                                                                            <div class="coupon field_form input-group">
                                                                                <input type="text" value="" {{ (\auth::user()->employee)? 'disabled' : '' }} class="form-control" id="voucher_code" name="voucher_code" placeholder="Enter Coupon/Partner Code ...">
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-fill-out btn-sm apply_code" {{ (\auth::user()->employee)? 'disabled' : '' }} type="button">Apply</button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="order_review mt-3" id="voucher_slot" style="display: none;">
                                                                                <div class="heading_s1">
                                                                                    <h4 class="text-center voucher_name"></h4>
                                                                                </div>
                                                                                <P style="margin-top: -10px;" class="text-center voucher_description"></P>
                                                                                <div class="text-center">
                                                                                    @push('css')
                                                                                        <style>.btn-radius:hover{ color: #790003 !important; border: 1px solid #790003 !important; }</style>
                                                                                    @endpush
                                                                                    <button class="btn btn-fill-out btn-radius btn-sm remove_code" type="button">Remove</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="border p-3 p-md-4">
                                                                        @include('cart.item_reviews.item_total',['discount_activate' => null])
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right float-right mb-5" style="margin-top: -25px;">
                                            <button type="button" class="btn btn-fill-out pl-5 pr-5 prev-step">
                                                Back
                                            </button>
                                            <button type="button" data-type="review_cart" class="btn btn-fill-out pl-5 pr-5 next-step" >
                                                Continue
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step3">
                                        <div class="row mt-2">
                                            <div class="col-md-12 pb-5">
                                                <div class="toggle_info">
                                                    <span><i class="fas fa-credit-card"></i>Step 3: Payment Method</span>
                                                </div>
                                                <div class="panel-collapse show collapse login_form" id="billing_info"
                                                     aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-12 col-sm-12 pb-3">
                                                                <div class="dashboard_menu">
                                                                    <ul class="nav row" role="tablist">
                                                                        <li class="col-lg-12 col-md-12 col-sm-12 d-none">
                                                                            <a class="active" id="intro-pay-tab"
                                                                               data-toggle="tab" href="#intro_payment_tab" role="tab"
                                                                               onclick="set_pay_method('null')"
                                                                               aria-controls="intro_payment_tab" aria-selected="false">
                                                                            </a>
                                                                        </li>
                                                                        <li class="col-lg-12 col-md-12 col-sm-12 pb-2">
                                                                            <a class="btn btn-sm nav-link btn-fill-line"
                                                                               id="online-pay-tab" data-toggle="tab" href="#online_payment_tab"
                                                                               role="tab"
                                                                               aria-controls="online_payment_tab" aria-selected="false"
                                                                               onclick="set_pay_method('online_payment')"
                                                                               style="padding: 10px 3px 10px 3px; width: 100% !important;">
                                                                                <i class="fa fa-credit-card fa-lg" style="font-size: 15px;"></i>
                                                                                <br/>
                                                                                <small>Online Payment</small>
                                                                            </a>
                                                                        </li>
                                                                        <li class="col-lg-12 col-md-12 col-sm-12">
                                                                            <a class="btn btn-sm nav-link btn-line-fill" id="points_payment-tab"
                                                                               data-toggle="tab" href="#points_payment_tab" role="tab"
                                                                               aria-controls="points_payment_tab" aria-selected="false"
                                                                               onclick="set_pay_method('points_payment')"
                                                                               style="padding: 10px 3px 10px 3px; width: 100% !important;"><i class="fas fa-coins fa-lg" style="font-size: 15px"></i>
                                                                                <br/>
                                                                                <small>Points Payment</small>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-9 col-md-12 col-sm-12">
                                                                <div class="tab-content dashboard_content">
                                                                    <div class="tab-pane fade active show " id="intro_payment_tab" style="padding: 0 !important;"  role="tabpanel" aria-labelledby="intro-pay-tab">
                                                                        <div class="card-header" style="padding: 0 0 10px 0 !important;"><h5>Choose Payment Mode</h5></div>
                                                                        <div class="card-body" style="padding:5px 0 20px 0">
                                                                            <p>Now you can choose to pay using the following payment methods from worldwide. Please select your preferred payment method below.</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade " style="padding: 0 !important;" id="online_payment_tab" role="tabpanel" aria-labelledby="online-pay-tab">
                                                                        <div class="card-header" style="padding: 0 0 10px 0 !important;"><h5>Online Payment</h5></div>
                                                                        <div class="card-body" style="padding:5px 0 20px 0">
                                                                            <p>We are accepting worldwide online payments. Now you can make your payment through any of the following facilities.</p>
                                                                            <img height="300px" class="next-step" data-type="pay-and-order"
                                                                                 src="{{ asset('assets/images/payment_type2.png')}}"
                                                                                 alt="pay_methods">
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" style="padding: 0 !important;" id="points_payment_tab" role="tabpanel" aria-labelledby="points_payment-tab">
                                                                        <div class="card-header" style="padding: 0 0 10px 0 !important;"><h5>Points Payment</h5></div>
                                                                        <div class="card-body" style="padding: 0 0 0 0 !important;">
                                                                            <div class="row justify-content-center">
                                                                                <div class="col-lg-6 col-sm-6">
                                                                                    <div class="icon_box icon_box_style4" style="background: #afa25a !important;">
                                                                                        <div class="icon_box_content">
                                                                                            <input type="hidden" value="{{ getFinalPoints()["available_points"] }}" id="available_points" />
                                                                                            <h5 class="text-white">{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                                                            <p class="text-white">Available Points</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 col-sm-6">
                                                                                    <div class="icon_box icon_box_style4" style="background: #837000 !important;">
                                                                                        <div class="icon_box_content">
                                                                                            <input type="hidden" name="paid_points" class="set-pay-points" value=""/>
                                                                                            <h5 class="text-white set-pay-points"></h5>
                                                                                            <p class="text-white">Points Deducted</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="alert alert-info enough-points-msg" style="margin-top: -10px; display: none;">
                                                                                <small>Congratulations! You've enough points to place your order.</small>
                                                                            </div>
                                                                            <div class="not-enough-points-msg" style="margin-top: -10px; display: none;">
                                                                                <small>Looks like you don't have enough points to reserve this service. Please use the Online Payment option.</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right float-right mb-5" style="margin-top: -25px;">
                                            <button type="button" class="btn btn-fill-out pl-5 pr-5 prev-step">Back</button>
                                            @if(!\Cart::instance('shopping')->content()->isEmpty())
                                                <button type="button" class="btn btn-fill-out next-step pl-5 pr-5" style="text-transform: none;" data-type="pay-and-order" id="pay-and-order">
                                                    Proceed to Payment
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                            <form method="post" id="order_payment_form" action="{{ env('PAYMENT_GATEWAY_URL', 'https://sandbox.payhere.lk/pay/checkout') }}"
                                  enctype="application/x-www-form-urlencoded" style="display: none">
                                <input type="hidden" name="host_url" class="host_url" value="{{ route('home') }}"/>
                                <input type="hidden" name="merchant_id" value="{{ env('PAYMENT_GATEWAY_MERCHANT_ID','1217801') }}">
                                <input type="hidden" name="return_url" class="set_param_url" value="">
                                <input type="hidden" name="cancel_url" value="{{ route('order.payment.failed') }}">
                                <input type="hidden" name="notify_url" value="{{ route('order.payment.notify') }}">
                                <input type="hidden" id="order_code" name="order_id" value="{{ $order_code }}">
                                <input type="hidden" name="items" value="{{ env('APP_NAME','Surya Sri Ayurweda') }} - Product Shopping"><br>
                                <input type="hidden" name="currency" value="{{ \App\Details::where('key','payment_gateway_currency_format')->first()->value }}">
                                @include('cart.item_reviews.online_payment',['discount_activate' => null])
                                <input type="hidden" name="first_name" value="@if(Auth::check()){{ \Auth::user()->name }}@endif">
                                <input type="hidden" name="last_name" value="@if(Auth::check()){{ \Auth::user()->name }}@endif">
                                <input type="hidden" name="email" value="@if(Auth::check()){{ \Auth::user()->email }}@endif">
                                <input type="hidden" name="phone" value="@if(Auth::check()){{ \Auth::user()->contact }}@endif">
                                <input type="hidden" name="address" value="@if(Auth::check()){{ \Auth::user()->city }}@endif">
                                <input type="hidden" name="city" value="@if(Auth::check()){{ \Auth::user()->city }}@endif">
                                <input type="hidden" name="country" value="@if(Auth::check()){{ \Auth::user()->country }}@endif">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- END MAIN CONTENT -->
@endsection
@push('js')
    <script src="{{ asset('assets/js/page/checkout_validation.js') }}"></script>
    <script src="{{ asset('assets/js/page/voucher_code_validation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/MaxLength.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $("[id*=customer_note]").MaxLength(
            {
                MaxLength: 150,
                CharacterCountControl: $('#counter_note')
            });

        $(document).ready(function () {
            $('#horizontalTab').easyResponsiveTabs({
                type: 'default', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true,   // 100% fit in a container
                closed: 'accordion', // Start closed if in accordion view
                activate: function (event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#tabInfo');
                    var $name = $('span', $info);
                    $name.text($tab.text());
                    $info.show();
                }
            });
            $('#verticalTab').easyResponsiveTabs({
                type: 'vertical',
                width: 'auto',
                fit: true
            });
        });
    </script>
@endpush
