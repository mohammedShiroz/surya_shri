@extends('layouts.front')
@section('page_title','Service Booking')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Service Booking'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))

@push('css')
    <link href="{{ asset('assets/css/customs.css') }}" rel="stylesheet"/>
@endpush
@include('backend.components.plugins.full_calendar')

{{--@include('backend.components.plugins.alert')--}}
@push('css')<style>.fc-day{ font-weight: bold !important; }.fc-day-today{ font-weight: bold !important; }  .fc-day:hover{ background: rgba(156,118,30,0.1); cursor: pointer; }.fc-highlight { background: rgba(156,118,30,0.3) !important; color: white !important; }  .sticky-bar{ position:-webkit-sticky; position:sticky; top:125px; } .cellBg { background: rgba(255, 255, 255, 0.9) !important; color: black !important; font-weight: bolder !important; border: 2px solid darkblue !important; }  .text-black{ color:black !important; }</style>@endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Clinique Reservation','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Clinique','route'=>route('services')],
            2=>['name'=>$data->name,'route'=>route('services.details',[$data->category->slug, $data->slug])],
            3=>['name'=>'Reservations','route'=>''],
        ]])
    @php $reservation_code = \Auth::user()->id . rand(10, 100) . date('ymdhis'); @endphp
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION BLOG -->
        <div class="section small_pt pb_70">
            <div class="container">
                <div class="row">
                    @include('components.messages')
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 pt-5">
                                    <div class="wizard">
                                        <div class="wizard-inner">
                                            <div class="connecting-line"></div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active" id="select_step1">
                                                    <a href="#step1" data-toggle="tab"
                                                       aria-controls="step1" role="tab"
                                                       aria-expanded="true"><span class="round-tab">1 </span>
                                                        <i>Step 1</i>
                                                    </a>
                                                </li>
                                                <li role="presentation" class="disabled" id="select_step2">
                                                    <a href="#step2" data-toggle="tab"
                                                       aria-controls="step2" role="tab" class="check_validation_by_number step_2"><span class="round-tab">2</span> <i>Step 2</i></a>
                                                </li>
                                                <li role="presentation" class="disabled" id="select_step3">
                                                    <a href="#step3" id="step_2" data-toggle="tab" aria-controls="step3" role="tab"
                                                       aria-expanded="false" class="check_validation_by_number step_3"><span class="round-tab">3</span> <i>Step 3</i>
                                                    </a>
                                                </li>
                                                <li role="presentation" class="disabled" id="select_step4">
                                                    <a href="#step4" data-toggle="tab"
                                                       aria-controls="step4" role="tab" class="check_validation_by_number step_4"><span class="round-tab">4</span> <i>Step 4</i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <form method="POST" action="{{ route('services.store.booking') }}" id="booking_service_form">
                                            @csrf
                                            <input type="hidden" id="book_reference" name="book_reference" value="{{ old('book_reference')? old('book_reference') : $reservation_code }}"/>
                                            <input type="hidden" id="book_date" name="book_date" class="booked_date" value="{{ old('booked_date')? old('booked_date') : '' }}" />
                                            <input type="hidden" id="book_time" name="book_time" class="booked_time" value="{{ old('booked_time')? old('booked_time') : '' }}" />
                                            <input type="hidden" id="service_id" name="service_id" value="{{ old('service_id')? old('service_id') : $data->id }}" />
                                            <input type="hidden" id="user_id" name="user_id" value="{{ old('user_id')? old('user_id') : \Auth::user()->id }}" />
                                            <input type="hidden" id="price" name="price" value="{{ old('price')? old('price') : $data->price }}" />
                                            <input type="hidden" id="get_payment_method" name="payment_method" value="{{ old('payment_method')? old('payment_method') : '' }}"/>
                                            <input type="hidden" class="voucher_id" name="voucher_id" value="" />
                                            <input type="hidden" class="voucher_provide_by" name="voucher_provide_by" value="" />
                                            <input type="hidden" class="voucher_ref_by" name="voucher_ref_by" value="" />
                                            <input type="hidden" class="coupon_id" name="coupon_id" value="" />
                                            <input type="hidden" class="users_code" name="user_code" value="" />
                                            <input type="hidden" class="users_code_id" value="" />
                                            <div class="tab-content" id="main_form">
                                                <div class="tab-pane active" role="tabpanel" id="step1">
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <div class="toggle_info">
                                                                <span><i class="fas fa-calendar-check"></i>Step 1: Reservation Schedule.</span>
                                                            </div>
                                                            <div class="panel-collapse show collapse login_form">
                                                                <div class="panel-body" style="border: none !important; padding: 0 !important;">
                                                                    <div id="calendar"></div>
                                                                    <div id="time_slot_scroll"></div>
                                                                    <div class="border mt-3" id="time_slot" style="display: none;">
                                                                        @include('pages.services.booking_time_slot')
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" role="tabpanel" id="step2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-12 pb-1">
                                                            <div class="toggle_info">
                                                                <span><i class="fas fa-user-tag"></i>Step 2: Reservation Form.</span>
                                                            </div>
                                                            <div class="panel-collapse show collapse login_form">
                                                                <div class="panel-body" style="border: none !important; padding: 0 !important;">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12">
                                                                            <div>
                                                                                <div class="form-group">
                                                                                    <label>Who are you making this reservation for?</label>
                                                                                    <select class="form-control input_identity select2 @error('type') is-invalid @enderror" name="type" id="booking_type" style="width: 100%;">
                                                                                        <option selected="selected" disabled value="null">Who are you making this reservation for?</option>
                                                                                        <option value="For myself" {{ (old('type')? ((old('type') == "For myself")? 'selected' : '') : '') }}>For myself</option>
                                                                                        <option value="For someone else" {{ (old('type')? ((old('type') == "For someone else")? 'selected' : '') : '') }}>For someone else</option>
                                                                                    </select>
                                                                                    <p class="text-danger booking_type_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>First Name*</label>
                                                                                    <input type="text" required class="form-control input_identity" id="first_name"
                                                                                           name="first_name"
                                                                                           placeholder="Your First Name ..."
                                                                                           value="@auth{{ old('first_name')? old('first_name') :\Auth::user()->name}}@endauth">
                                                                                    <p class="text-danger first_name_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Last Name*</label>
                                                                                    <input type="text" required class="form-control input_identity" id="last_name"
                                                                                           name="last_name"
                                                                                           placeholder="Your Last Name ..."
                                                                                           value="@auth{{ old('last_name')? old('last_name') :\Auth::user()->last_name}}@endauth">
                                                                                    <p class="text-danger last_name_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Email*</label>
                                                                                    <input class="form-control" id="user_email" required type="email" name="email" readonly
                                                                                           value="@auth{{ old('email')? old('email') : \auth::user()->email }}@endauth"
                                                                                           placeholder="Email address ...">
                                                                                    <p class="text-danger user_email_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Contact*</label>
                                                                                    <input class="form-control input_identity" required id="user_contact" type="text"
                                                                                           name="user_contact"
                                                                                           onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;"
                                                                                           value="@auth{{ old('user_contact')?old('user_contact'):\Auth::user()->contact }}@endauth"
                                                                                           placeholder="Contact Number ...">
                                                                                    <p class="text-danger user_contact_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>NIC/DL/Passport *</label>
                                                                                <input class="form-control input_identity" required id="user_nic" type="text"
                                                                                       name="user_nic"
                                                                                       disabled
                                                                                       onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;"
                                                                                       value="@auth{{ old('user_nic')?old('user_nic'):'' }}@endauth"
                                                                                       placeholder="NIC/Passport Number ...">
                                                                                <p class="text-danger user_nic_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                            </div>
                                                                            <input type="hidden" id="form_type" value="{{ $data->form_type }}" />
                                                                            @if($data->a_question_one)
                                                                            <div class="form-group">
                                                                                <label>{{ $data->a_question_one }} *</label>
                                                                                <input type="hidden" id="a_question_one" name="a_question_one" value="{{ $data->a_question_one }}" />
                                                                                <input type="text" required class="form-control input_identity" id="a_answer_one"
                                                                                       name="a_answer_one"
                                                                                       placeholder="{{ $data->a_question_one }} ..."
                                                                                       value="{{ old('a_answer_one')? old('a_answer_one') : ''}}">
                                                                                <p class="text-danger a_answer_one_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                            </div>
                                                                            @endif
                                                                            @if($data->a_question_two)
                                                                                <div class="form-group">
                                                                                    <label>{{ $data->a_question_two }} *</label>
                                                                                    <input type="hidden" id="a_question_two" name="a_question_two" value="{{ $data->a_question_two }}" />
                                                                                    <input type="text" required class="form-control input_identity" id="a_answer_two"
                                                                                           name="a_answer_two"
                                                                                           placeholder="{{ $data->a_question_two }} ..."
                                                                                           value="{{ old('a_answer_two')? old('a_answer_two') : ''}}">
                                                                                    <p class="text-danger a_answer_two_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                            @endif
                                                                            @if($data->a_question_three)
                                                                                <div class="form-group">
                                                                                    <label>{{ $data->a_question_three }} *</label>
                                                                                    <input type="hidden" id="a_question_three" name="a_question_three" value="{{ $data->a_question_three }}" />
                                                                                    <input type="text" required class="form-control input_identity" id="a_answer_three"
                                                                                           name="a_answer_three"
                                                                                           placeholder="{{ $data->a_question_three }} ..."
                                                                                           value="{{ old('a_answer_three')? old('a_answer_three') : ''}}">
                                                                                    <p class="text-danger a_answer_three_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                                </div>
                                                                            @endif
                                                                            <div class="form-group mb-0">
                                                                                <label>Additional Note</label>
                                                                                <textarea rows="5" class="form-control user_note_text" id="user_note" name="user_note" placeholder="Allergies, areas to avoid or give more attention, special notes, etc.,">{{ old('user_note')?old('user_note'):'' }}</textarea>
                                                                                <div id="counter_note"></div>
                                                                                <p class="text-danger user_note_error"  style="margin-bottom:-2px; display: none;"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pull-right float-right mt-2">
                                                                <button type="button" class="btn btn-fill-out pl-5 pr-5 prev-step">
                                                                    <i class="ti-arrow-circle-left"></i> Back
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" role="tabpanel" id="step3">
                                                    <div class="row mt-2">
                                                        <div class="col-md-12 pb-1">
                                                            <div class="toggle_info">
                                                                <span><i class="ti-receipt"></i>Step 3: Review Reservation.</span>
                                                            </div>
                                                            <div class="panel-collapse show collapse login_form">
                                                                <div class="panel-body" style="border: none !important; padding: 0 !important;">
                                                                    <div class="table-responsive border">
                                                                        <table class="table text-left">
                                                                            <tr class="text-left">
                                                                                <td align="left" width="27%"><strong>Service</strong></td>
                                                                                <td align="left"><p>{{ $data->name }}<br/><small>{{ $data->tag_code }}</small></p></td>
                                                                            </tr>
                                                                            <tr class="text-left">
                                                                                <td align="left"><strong>Price</strong></td>
                                                                                <td align="left">
                                                                                    @include('pages.services.checkout_fetch.review_checkout',['discount_activate'=> null])
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="text-left">
                                                                                <td align="left"><strong>Duration</strong></td>
                                                                                <td align="left">{{ ($data->duration_hour == null && $data->duration_minutes == null)? '-' : (($data->duration_hour? $data->duration_hour."hr " : '').($data->duration_minutes? $data->duration_minutes."min" : '')) }}</td>
                                                                            </tr>
                                                                            <tr class="text-left">
                                                                                <td align="left"><strong>Book Date & Time</strong></td>
                                                                                <td align="left"><span class="show_selected_date">-</span> <span class="show_selected_time"></span></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-6">
                                                                            <div class="toggle_info">
                                                                                <span><i class="fas fa-tag"></i>Have a Coupon/Partner Code? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a></span>
                                                                            </div>
                                                                            <div class="panel-collapse collapse coupon_form" id="coupon">
                                                                                <div class="panel-body">
                                                                                    <p>{{ \auth::user()->employee? 'Your lifetime coupon code is activated!' : 'If you have a voucher code, please apply it below.' }}</p>
{{--                                                                                    <div class="check-form mb-2 mt-n3">--}}
{{--                                                                                        <div class="custome-checkbox">--}}
{{--                                                                                            <input class="form-check-input" type="checkbox" name="checkbox" id="by_partner" value="">--}}
{{--                                                                                            <label class="form-check-label" for="by_partner"><span>Provide by partner?</span></label>--}}
{{--                                                                                        </div>--}}
{{--                                                                                    </div>--}}
                                                                                    <div class="coupon field_form input-group">
                                                                                        <input type="text" value="" class="form-control" {{ (\auth::user()->employee)? 'disabled' : '' }} id="voucher_code" name="voucher_code" placeholder="Enter Coupon/Partner Code..">
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
                                                                                @php $final_sub_total = 0; @endphp
                                                                                @include('pages.services.checkout_fetch.booking_total',['discount_activate'=> null])
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pull-right float-right mt-2">
                                                                        <button type="button" class="btn btn-fill-out pl-5 pr-5 prev-step">
                                                                            <i class="ti-arrow-circle-left"></i> Back
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" role="tabpanel" id="step4">
                                                    <div class="row mt-2">
                                                        <div class="col-md-12 pb-1">
                                                            <div class="toggle_info">
                                                                <span><i class="fas fa-credit-card"></i>Step 4: Payment Method</span>
                                                            </div>
                                                            <div class="panel-collapse show collapse login_form">
                                                                <div class="panel-body" style="border: none !important; padding: 0 !important;">
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
                                                                                        <img height="300px"
                                                                                            src="{{ asset('assets/images/payment_types.png')}}"
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
                                                                                                        <input type="hidden" name="paid_points" class="set-pay-points" value="{{ old('paid_points')?old('paid_points'): ($final_sub_total*(\App\Details::where('key','points_rate')->first()->amount)) }}"/>
                                                                                                        <h5 class="text-white set-pay-points">{{ getPointsFormat(($final_sub_total*(\App\Details::where('key','points_rate')->first()->amount))) }}</h5>
                                                                                                        <p class="text-white">Points Deducted</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="alert alert-info enough-points-msg" style="margin-top: -10px; display: none;">
                                                                                            <small>Congratulations! You've enough point to reserve this service.</small>
                                                                                        </div>
                                                                                        <div class="not-enough-points-msg" style="margin-top: -10px; display: none;">
                                                                                            <small>Looks like you don't have enough points to reserve this service. Please use the Online Payment option.</small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pull-right float-right mt-5">
                                                                        <button type="button" class="btn btn-fill-out pl-5 pr-5 prev-step">
                                                                            <i class="ti-arrow-circle-left"></i> Back
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form method="post" id="service_payment_form" action="{{ env('PAYMENT_GATEWAY_URL', 'https://sandbox.payhere.lk/pay/checkout') }}"
                                              enctype="application/x-www-form-urlencoded" style="display: none">
                                            <input type="hidden" name="host_url" class="host_url" value="{{ route('home') }}"/>
                                            <input type="hidden" name="merchant_id" value="{{ env('PAYMENT_GATEWAY_MERCHANT_ID','1217801') }}">
                                            <input type="hidden" name="return_url" class="set_param_url" value="">
                                            <input type="hidden" name="cancel_url" value="{{ route('services.booking.payment.failed') }}">
                                            <input type="hidden" name="notify_url" class="set_param_url" value="">
                                            <input type="hidden" id="order_code" name="order_id" value="{{ $reservation_code }}">
                                            <input type="hidden" name="items" value="{{ $data->name }} - Service"><br>
                                            <input type="hidden" name="currency" value="{{ \App\Details::where('key','payment_gateway_currency_format')->first()->value }}">
                                            @include('pages.services.checkout_fetch.online_pay',['discount_activate'=> null])
                                            <input type="hidden" name="first_name" value="@if(\auth::check()){{ \auth::user()->name }}@endif">
                                            <input type="hidden" name="last_name" value="@if(\auth::check()){{ \auth::user()->name }}@endif">
                                            <input type="hidden" name="email" value="@if(\auth::check()){{ \auth::user()->email }}@endif">
                                            <input type="hidden" name="phone" value="@if(\auth::check()){{ \auth::user()->contact }}@endif">
                                            <input type="hidden" name="address" value="@if(\auth::check()){{ \auth::user()->city }}@endif">
                                            <input type="hidden" name="city" value="@if(\auth::check()){{ \auth::user()->city }}@endif">
                                            <input type="hidden" name="country" value="@if(\auth::check()){{ \auth::user()->country }}@endif">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar sticky-bar first">
                            <div class="widget border p-3">
                                <h5 class="widget_title text-center">{{ $data->name }}</h5>
                                <p class="text-center leads" style="margin-top: -25px;"><small>{{ $data->tag_code }}</small></p>
                                <hr style="margin-top: -25px;"/>
                                <div class="product_sort_info">
                                    <ul>
                                        <li><i class="linearicons-clock"></i> {{ ($data->duration_hour == null && $data->duration_minutes == null)? '-' : (($data->duration_hour? $data->duration_hour."hr " : '').($data->duration_minutes? $data->duration_minutes."min" : '')) }}</li>
                                        @if($data->week_days)<li><i class="linearicons-calendar-check"></i> {{ ($data->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$data->week_days)) : '-' }}</li>@endif
                                        <li><i class="ti-money"></i> {{ getCurrencyFormat($data->price) }}</li>
                                        <li><i class="ti-support"></i> {!! ($data->status == 'Available')? '<span class="text-success">Available</span>' : '<span class="text-danger">Not-available</span>' !!}</li>
                                    </ul>
                                    <hr/>
                                    @auth
                                        @if(\auth::user()->employee)
                                            <table>
                                                <tr>
                                                    <td width="50%" align="center"><small>Lifetime Partner Discount and Price:</small></td>
                                                </tr>
                                                <tr>
                                                    <td align="center">{{ ($data->direct_commission)? $data->direct_commission."%" : '0%' }}<small>{!! ($data->direct_commission)? "<br/>(<del>".getCurrencyFormat($data->price)."</del> ".getCurrencyFormat($data->agent_pay_amount).")" : '-' !!}</small></td>
                                                </tr>
                                            </table>
                                        @endif
                                    @endauth
                                </div>
                                <hr style="margin-top: -10px;"/>
                                <input type="hidden" class="get_selected_date" value=""/>
                                <p id="selected_date_cl" style="display: none"><span class="text-black show_selected_date"></span> <span class="text-black show_selected_time"></span><br/>
{{--                                    <small class="mt-2 text-black" id="view_time_tag" style="line-height: 18px; display: none;">Consulting Doctor - Online Session</small>--}}
                                    {{--<small class="d-block mt-2 text-black" style="line-height: 18px;">You will receive a Zoom link once you’ve booked this service.</small>--}}
                                </p>
                                @if($data->status == 'Available')
                                    <button class="btn btn-fill-out w-100 mb-2 next-step" id="submit_btn">Continue <i class="icon-arrow-right"></i></button>
                                @else
                                    <small class="text-danger">You can't continue due to the service Un-available.</small>
                                @endif
                                <small class="text-danger" id="error_txt" style="display: none;"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION BLOG -->
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/page/service_pay_validation.js') }}"></script>
    <script src="{{ asset('assets/js/page/service_calendar_curd.js') }}"></script>
    <script src="{{ asset('assets/js/page/service_voucher_code_validation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/MaxLength.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $("[id*=user_note]").MaxLength(
            {
                MaxLength: 150,
                CharacterCountControl: $('#counter_note')
            });
        var errors=false;
        $(document).on('click', '.set_time', function(){
            var set_time=$(this).attr('data-time');
            var index = $('.set_time').index(this);
            $.ajax({
                url: '{{ route('reservation.check.bookings') }}',
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    'book_date':$('.get_selected_date').val(),
                    'time':$(this).attr('data-time'),
                    'service_id' : $("#service_id").val(),
                },
                success: function (data) {
                    // console.log(data);
                    if(data == "failed"){
                        swal("Notice!", "This "+$('.get_selected_date').val()+" - "+set_time+" date and time is already booked! Please choose another. Call us to check if there are additional openings", "info");
                    }else if(data == "failed_time"){
                        swal("Notice!", "This "+$('.get_selected_date').val()+" - "+set_time+" date and time has already reserved! Please choose another time. Call us to check if there are additional openings", "info");
                    }
                    else{
                        $(".set_time").removeClass('btn-dark text-white');
                        $('.set_time').eq(index).addClass('btn-dark text-white');
                        $(".booked_time").val(set_time);
                        $(".show_selected_time").html("- "+$(".booked_time").val());
                        $("#view_time_tag").css('display','block');
                    }
                }
            });
        });
        $(document).keypress(
            function(event){
                if (event.which == '13') {
                    event.preventDefault();
                    $('.next-step').trigger('click');
                }
            });
    </script>
@endpush
