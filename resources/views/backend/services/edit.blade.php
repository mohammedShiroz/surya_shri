@extends('backend.layouts.admin')
@section('page_title','Edit Service Details')
@include('backend.components.plugins.slugify')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.dropfy')
@include('backend.components.plugins.summer_note')
@include('backend.components.plugins.alert')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit {{ $data->name }} Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
                            <li class="breadcrumb-item active">{{ $data->name }} Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('services.update',$data->id) }}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Service Category Details</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-12 col-sm-12">
                                                    <label for="inputEmail3" class="col-form-label">Service Category</label>
                                                    <select class="form-control select2 @error('category_id') is-invalid @enderror" required name="category_id" id="category_id" style="width: 100%;">
                                                        <option disabled="disabled" value="null" selected="selected">Select Service Category</option>
                                                        @foreach(\App\Service_category::orderby('order', 'ASC')->get() as $row)
                                                            <option value="{{ $row->id }}" {{ old('category_id')? ((old('category_id') == $row->id)? 'selected': '') : (($data->category_id == $row->id)? 'selected' : '') }}>{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Who does this service belongs to?</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-12 col-sm-12">
                                                    <label for="inputEmail3" class="col-form-label">Doctor</label>
                                                    <select class="form-control select2 @error('doctor_id') is-invalid @enderror" required name="doctor_id" id="doctor_id" style="width: 100%;">
                                                        <option disabled="disabled" value="null" selected="selected">Select a Doctor</option>
                                                        @foreach(\App\Agent::with('user')->whereNotNull('is_doctor')->orderby('id', 'ASC')->get() as $row)
                                                            <option value="{{ $row->id }}" {{ old('doctor_id')? ((old('doctor_id') == $row->id) ? 'selected': '') : (($data->doctor_id == $row->id)? 'selected' : '') }}>{{ $row->user->name." ".$row->user->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('doctor_id')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Service Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 mb-4">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Service Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')? old('name') : $data->name }}" placeholder="Service Name">
                                        @error('name')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Tag Description</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control @error('tag_code') is-invalid @enderror" name="tag_code" value="{{ old('tag_code')? old('tag_code') : $data->tag_code }}" placeholder="Tag Description">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                            </div>
                                        </div>
                                        @error('tag_code')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Service Code</label>
                                        <input type="text" class="form-control @error('service_code') is-invalid @enderror" name="service_code" value="{{ old('service_code')? old('service_code') : $data->service_code }}" placeholder="Service code">
                                        @error('service_code')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Status</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror" name="status" id="status" style="width: 100%;">
                                            <option value="Available" {{ old('status')? (old('status') == "Available") ? 'selected': '' : (($data->status == 'Available')? 'selected':'') }}>Available</option>
                                            <option value="Not-available" {{ old('status')? (old('status') == "Not-available") ? 'selected': '' : (($data->status == 'Not-available')? 'selected':'') }} >Not-available</option>
                                        </select>
                                        @error('status')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Available Days</label>
                                        <div class="input-group mb-3">
                                            @php
                                                $days=explode(',',str_replace(array( '\'', '"',';', '[', ']' ),"",$data->week_days));
                                            @endphp
                                            <select class="select2bs4" name="week_days[]" multiple="multiple" data-placeholder="Select week days" >
                                                <option value="Mon" {{ old('week_days')? (old('week_days') == "Mon")? 'selected': '' : (in_array('Mon',$days,true)? 'selected':'') }}>Monday</option>
                                                <option value="Tue" {{ old('week_days')? (old('week_days') == "Tue")? 'selected': '' : (in_array('Tue',$days,true)? 'selected':'') }}>Tuesday</option>
                                                <option value="Wed" {{ old('week_days')? (old('week_days') == "Wed")? 'selected': '' : (in_array('Wed',$days,true)? 'selected':'') }}>Wednesday</option>
                                                <option value="Thu" {{ old('week_days')? (old('week_days') == "Thu")? 'selected': '' : (in_array('Thu',$days,true)? 'selected':'') }}>Thursday</option>
                                                <option value="Fri" {{ old('week_days')? (old('week_days') == "Fri")? 'selected': '' : (in_array('Fri',$days,true)? 'selected':'') }}>Friday</option>
                                                <option value="Sat" {{ old('week_days')? (old('week_days') == "Sat")? 'selected': '' : (in_array('Sat',$days,true)? 'selected':'') }}>Saturday</option>
                                                <option value="Sun" {{ old('week_days')? (old('week_days') == "Sun")? 'selected': '' : (in_array('Sun',$days,true)? 'selected':'') }}>Sunday</option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        @error('week_days')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Duration</label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="duration_hour" class="form-control @error('duration_hour') is-invalid @enderror" name="duration_hour" value="{{ old('duration_hour')? old('duration_hour') : $data->duration_hour }}" placeholder="Duration hour">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock mr-1"></i> Hour</span>
                                                    </div>
                                                </div>
                                                @error('duration_hour')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror" name="duration_minutes" value="{{ old('duration_minutes')? old('duration_minutes') : $data->duration_minutes }}" placeholder="Duration minutes">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock mr-1"></i> Minutes</span>
                                                    </div>
                                                </div>
                                                @error('duration_minutes')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="input-group mb-3">
                                                    <input type="number" min="0" oninput="validity.valid||(value='');" id="buffer_time" class="form-control @error('buffer_time') is-invalid @enderror" name="buffer_time" value="{{ old('buffer_time')? old('buffer_time') : $data->buffer_time }}" placeholder="Buffer time">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock mr-1"></i> Buffer Time (Min)</span>
                                                    </div>
                                                </div>
                                                @error('buffer_time')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Sequence</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" value="{{ old('order')? old('order'): ($data->order? $data->order : (\App\Service::orderby('order','Desc')->first()->order+1)) }}" name="order" placeholder="Sequence">
                                        @error('order')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">&nbsp;</label>
                                        <div class="border" style="border-radius: 4px; padding: 6.5px;">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" {{ ($data->visibility == 1)? 'checked':'' }} id="visibility" name="visibility_status" >
                                                <label for="visibility">
                                                    Visible
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Form Type</label>
                                        <select class="select2bs4 w-100" id="form_type" name="form_type" data-placeholder="Select form type" >
                                            <option value="Standard Form" {{ old('form_type')? (old('form_type') == "Standard Form")? 'selected': '' : (($data->form_type == 'Standard Form')? 'selected':'') }}>Standard Form</option>
                                            <option value="Specific Form" {{ old('form_type')? (old('form_type') == "Specific Form")? 'selected': '' : (($data->form_type == 'Specific Form')? 'selected':'') }}>Specific Form</option>
                                        </select>
                                        @error('form_type')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    @push('script')
                                        <script>
                                            $("#form_type").change(function(){
                                                if($("#form_type option:selected").val() == "Standard Form"){
                                                    reset();
                                                }else if($("#form_type option:selected").val() == "Specific Form"){
                                                    reset();
                                                    $("#additional_question").slideDown();
                                                }
                                            });
                                            function reset(){
                                                $("#additional_question").slideUp();
                                                $("#a_question_one").val(null);
                                                $("#a_question_two").val(null);
                                                $("#a_question_three").val(null);
                                            }
                                        </script>
                                    @endpush
                                    <div class="col-md-12 col-sm-12 mt-4" id="additional_question" style="display: {{ ($data->form_type == 'Standard Form')? 'none' : '' }};">
                                        <h5>Additional Questions?</h5>
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Question #1</label>
                                        <input type="text" class="form-control @error('a_question_one') is-invalid @enderror" id="a_question_one" name="a_question_one" value="{{ old('a_question_one')? old('a_question_one') : $data->a_question_one }}" placeholder="Question one">
                                        @error('a_question_one')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror

                                        <label for="inputEmail3" class="col-sm-4 col-form-label mt-2">Question #2</label>
                                        <input type="text" class="form-control @error('a_question_two') is-invalid @enderror" id="a_question_two" name="a_question_two" value="{{ old('a_question_two')? old('a_question_two') : $data->a_question_two }}" placeholder="Question two">
                                        @error('a_question_two')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror

                                        <label for="inputEmail3" class="col-sm-4 col-form-label mt-2">Question #3</label>
                                        <input type="text" class="form-control @error('a_question_three') is-invalid @enderror" id="a_question_three" name="a_question_three" value="{{ old('a_question_three')? old('a_question_three') : $data->a_question_three }}" placeholder="Question three">
                                        @error('a_question_three')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Service Price Margin Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12">
                                        <p>Final Discounted Price View</p>
                                        <div class="bg-gray py-2 px-3 mb-3" style="margin-top: -10px;">
                                            <h2 class="mb-0" id="show_final_price">
                                                {{ getCurrencyFormat($data->price) }}
                                            </h2>
                                            <h4 class="mt-0">
                                                <del><small id="show_discount_price">{{ getCurrencyFormat(($data->discount_price)? $data->actual_price : '0') }}</small></del> <small><span id="show_discount_percentage">{{ ($data->discount_percentage)? $data->discount_percentage : '0' }}</span>% Off</small>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Actual price?</label>
                                        <div class="input-group mb-3">
                                            <input type="hidden" id="item_final_price" name="price" value="{{ old('price')? old('price') :  $data->price  }}">
                                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="item_price" name="actual_price" value="{{ old('actual_price')? old('actual_price') : $data->actual_price  }}" placeholder="Price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('price')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Site Discount</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2 discount_mode" name="discount_mode">
                                                <option value="none" {{ (old('discount_mode'))? (old('discount_mode')== 'none')? 'selected': '' : (($data->discount_mode=="none" || $data->discount_mode==null)? 'selected' : '') }}>None</option>
                                                <option value="price" {{ (old('discount_mode'))? (old('discount_mode')== 'price')? 'selected': '' : (($data->discount_mode=="price")? 'selected' : '') }}>Discounted Price</option>
                                                <option value="percentage" {{ (old('discount_mode'))? (old('discount_mode')== 'percentage')? 'selected': '' : (($data->discount_mode=="percentage")? 'selected' : '') }}>Percentage</option>
                                            </select>
                                            <input type="text" class="form-control discount_none_el" disabled style="display: {{ (old('discount_mode')? ((old('discount_mode')== 'none')? '' : 'none') : (($data->discount_mode=="none" || $data->discount_mode==null)? '' : 'none')) }};">
                                            <div class="input-group-append discount_none_el" style="display: {{ (old('discount_mode')? ((old('discount_mode')== 'none')? '' : 'none') : (($data->discount_mode=="none" || $data->discount_mode==null)? '' : 'none')) }};">
                                                <span class="input-group-text">?</span>
                                            </div>
                                            <input style="display: {{ (old('discount_mode')? ((old('discount_mode')== 'price')? '': 'none') : (($data->discount_mode=="price")? '' : 'none')) }};" type="text" class="form-control discount_price_el @error('discount_price') is-invalid @enderror" name="discount_price" id="discount_price" value="{{ old('discount_price')? old('discount_price') : $data->discount_price }}" placeholder="Discount price">
                                            <div class="input-group-append discount_price_el" style="display: {{ (old('discount_mode'))? (old('discount_mode')== 'price')? '': 'none' : (($data->discount_mode=="price")? '' : 'none') }};">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                            <input type="number" min="0" oninput="validity.valid||(value='');" style="display: {{ (old('discount_mode')? (old('discount_mode')== 'percentage')? '': 'none' : (($data->discount_mode=="percentage")? '' : 'none')) }};" class="form-control maxType discount_percentage_el @error('discount_percentage') is-invalid @enderror" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage')? old('discount_percentage') : $data->discount_percentage }}" placeholder="Discount percentage">
                                            <div class="input-group-append discount_percentage_el" style="display: {{ (old('discount_mode')? (old('discount_mode')== 'percentage')? '': 'none' : (($data->discount_mode=="percentage")? '' : 'none')) }};">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        @error('discount_price')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                        @error('discount_percentage')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Direct Partner Discount</label>
                                        <div class="input-group mb-3">
                                            <input type="number"  min="0" oninput="validity.valid||(value='');" size="3" maxlength="3"  class="form-control  maxType direct_commission @error('direct_commission') is-invalid @enderror" name="direct_commission" value="{{ old('direct_commission')? old('direct_commission') : $data->direct_commission  }}" placeholder="Direct Commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="direct_commission_price" class="form-control direct_commission_price" readonly value="{{ old('direct_commission_price')? old('direct_commission_price') : $data->direct_commission_price }}" placeholder="Direct commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('direct_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Lifetime Partner Pay Amount</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="agent_pay_amount" class="form-control agent_pay_amount @error('agent_pay_amount') is-invalid @enderror" readonly value="{{ old('agent_pay_amount')? old('agent_pay_amount') : $data->agent_pay_amount  }}" placeholder="(Is partner) pay amount?">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('agent_pay_amount')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">1st level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType first_level_commission @error('first_level_commission') is-invalid @enderror" name="first_level_commission" value="{{ old('first_level_commission')? old('first_level_commission') : $data->first_level_commission }}" placeholder="1st level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="first_level_commission_price" class="form-control first_level_commission_price" readonly value="{{ old('first_level_commission_price')? old('first_level_commission_price') : $data->first_level_commission_price }}" placeholder="1st level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('first_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">2nd level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType second_level_commission @error('second_level_commission') is-invalid @enderror" name="second_level_commission" value="{{ old('second_level_commission')? old('second_level_commission') : $data->second_level_commission }}" placeholder="2nd level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="second_level_commission_price" class="form-control second_level_commission_price" readonly value="{{ old('second_level_commission_price')? old('second_level_commission_price') : $data->second_level_commission_price }}" placeholder="2nd level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('second_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">3rd level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType third_level_commission @error('third_level_commission') is-invalid @enderror" name="third_level_commission" value="{{ old('third_level_commission')? old('third_level_commission') : $data->third_level_commission }}" placeholder="3rd level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="third_level_commission_price" class="form-control third_level_commission_price"  value="{{ old('third_level_commission_price')? old('third_level_commission_price') : $data->third_level_commission_price }}" placeholder="3rd level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('third_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">4th level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType fourth_level_commission @error('fourth_level_commission') is-invalid @enderror" name="fourth_level_commission" value="{{ old('fourth_level_commission')? old('fourth_level_commission') : $data->fourth_level_commission }}" placeholder="4th level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="fourth_level_commission_price" class="form-control fourth_level_commission_price"  value="{{ old('fourth_level_commission_price')? old('fourth_level_commission_price') : $data->fourth_level_commission_price }}" placeholder="4th level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('fourth_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Global commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType fifth_level_commission @error('fifth_level_commission') is-invalid @enderror" name="fifth_level_commission" value="{{ old('fifth_level_commission')? old('fifth_level_commission') : $data->fifth_level_commission }}" placeholder="Global commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="fifth_level_commission_price" class="form-control fifth_level_commission_price"  value="{{ old('fifth_level_commission_price')? old('fifth_level_commission_price') : $data->fifth_level_commission_price }}" placeholder="Global commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('fifth_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Network Bonus/Gifts</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType bonus_commission @error('bonus_commission') is-invalid @enderror" name="bonus_commission" value="{{ old('bonus_commission')? old('bonus_commission') : $data->bonus_commission  }}" placeholder="Bonus commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="bonus_commission_price" class="form-control bonus_commission_price" readonly value="{{ old('bonus_commission_price')? old('bonus_commission_price') : $data->bonus_commission_price }}" placeholder="Bonus commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('bonus_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Site account (expenses& profit)</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType expenses_commission @error('expenses_commission') is-invalid @enderror" name="expenses_commission" value="{{ old('expenses_commission')? old('expenses_commission') : $data->expenses_commission }}" placeholder="Expenses commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="expenses_commission_price" class="form-control expenses_commission_price" value="{{ old('expenses_commission_price')? old('expenses_commission_price') : $data->expenses_commission_price  }}" placeholder="Expenses commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('expenses_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Donations</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType donations_commission @error('donations_commission') is-invalid @enderror" name="donations_commission" value="{{ old('donations_commission')? old('donations_commission') : $data->donations_commission }}" placeholder="Donations commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="donations_commission_price" class="form-control donations_commission_price" readonly value="{{ old('donations_commission_price')? old('donations_commission_price') : $data->donations_commission_price  }}" placeholder="Donations commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('donations_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Doctor's Fee</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" readonly class="form-control maxType seller_paid @error('seller_paid') is-invalid @enderror" name="seller_paid" value="{{ old('seller_paid')? old('seller_paid') : $data->seller_paid }}" placeholder="To seller pay rate?">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="seller_paid_amount" class="form-control seller_paid_amount" readonly value="{{ old('seller_paid_amount')?  old('seller_paid_amount') : $data->seller_paid_amount }}" placeholder="Seller paid amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('seller_paid')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Service Image</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-2 col-sm-12">
                                        <img class="elevation-2" src="{{ (!empty($data->image)) ? asset($data->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" width="200px" height="200px" alt="{{ $data->name }}">
                                    </div>
                                    <div class="col-md-10 col-sm-12">
                                        <input type="file"
                                               name="image"
                                               id="image"
                                               class="dropify"
                                               data-min-width="540"
                                               data-min-height="600"
                                               {{--data-max-width="1000"--}}
                                               {{--data-max-height="1000"--}}
                                               data-allowed-file-extensions="jpeg jpg png gif"
                                               data-max-file-size="3M"
                                               data-max-file-size-preview="3M"
                                               {{--data-allowed-formats="portrait square"--}}
                                               data-errors-position="outside"
                                               data-show-errors="true"
                                               data-show-loader="true"
                                               data-show-remove="true"
                                        />
                                        @error('image')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Service Description</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="inputEmail3" class="col-form-label">Small Description</label>
                                            <textarea class="form-control" name="description" rows="5" placeholder="Small Description">{{ old('description')? old('description'): $data->description }}</textarea>
                                            @error('description')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-sm-12 mt-2">
                                            <label for="inputEmail3" class="col-form-label">Long Description</label>
                                            <textarea class="form-control" id="summernote" name="long_description" rows="5">{!! old('long_description')? old('long_description'): $data->long_description !!}</textarea>
                                            @error('long_description')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 pull-right">
                                            <a href="" class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i> Reset</a>
                                            <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check-circle"></i> Save Changes</button>
                                            <a href="{{ route('services.index') }}" class="btn btn-danger btn-flat"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Services Images</h4>
                    </div>
                    <div class="card-body">
                        <h4>Add More Images</h4>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <form action="{{ route('services.add.more.image') }}" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $data->id }}"/>
                                    <input type="file"
                                           name="image"
                                           id="image"
                                           class="dropify"
                                           data-min-width="540"
                                           data-min-height="600"
                                           {{--data-max-width="1000"--}}
                                           {{--data-max-height="1000"--}}
                                           data-allowed-file-extensions="jpeg jpg png gif"
                                           data-max-file-size="3M"
                                           data-max-file-size-preview="3M"
                                           {{--data-allowed-formats="portrait square"--}}
                                           data-errors-position="outside"
                                           data-show-errors="true"
                                           data-show-loader="true"
                                           data-show-remove="true"
                                    />
                                    @error('image')
                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                    @enderror
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            @if($data->images->count()>0)
                                @foreach($data->images as $row)
                                    <div class="col-sm-2">
                                        <button type="button" data-image-id="{{ $row->id }}" class="btn btn-danger w-100 delete-image" style="border-radius: 0">Remove</button>
                                        <a href="{{ asset($row->image) }}" data-toggle="lightbox" data-title="{{ $data->name }}" data-gallery="gallery">
                                            <img src="{{ asset($row->image_thumbnail) }}" class="img-fluid mb-2" alt="{{ $data->name }}"/>
                                        </a>
                                        <form action="{{ route('services.delete.more.image') }}" method="POST" id="delete-form-{{$row->id}}">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $data->id }}"/>
                                            <input type="hidden" name="image_id" value="{{ $row->id }}"/>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <p><i class="fa fa-info-circle mr-2"></i> No More Image Result Found! </p>
                            @endif
                        </div>
                        @push('script')
                            <script>
                                $(".delete-image").click(function(){
                                    var row_id=$(this).attr('data-image-id');
                                    swal.fire({
                                        title: '<span class="text-uppercase">Delete Image?</span>',
                                        text: "Are you sure want to delete this image?",
                                        type: 'warning',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes',
                                        cancelButtonText: 'No',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.value) {
                                            document.getElementById('delete-form-'+row_id).submit();
                                        } else if (
                                            // Read more about handling dismissals
                                            result.dismiss === Swal.DismissReason.cancel
                                        ) {
                                        }
                                    });
                                });
                            </script>
                        @endpush
                    </div>
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Service Question type</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Main content -->
                        <div class=" mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas {{ isset($edit_enabled)? 'fa-edit' : 'fa-plus-circle' }} "></i> {{ isset($edit_enabled)? 'Edit '.$data->name : 'Add' }} Question & Answers
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="card-body">
                                <form action="{{ route('services-questions.store') }}" method="post" class="form-horizontal" role="form">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Question</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="service_id" value="{{ $data->id }}" />
                                            <select class="form-control select2 @error('question_id') is-invalid @enderror" required name="question_id" id="question_id" style="width: 100%;">
                                                <option disabled="disabled" value="null" selected="selected">Select Question</option>
                                                @foreach(\App\Questions::orderby('order', 'asc')->get() as $row)
                                                    <option value="{{ $row->id }}"><small>({{ ($row->order)? $row->order : ($loop->index+1) }})</small> {{ $row->question }}</option>
                                                @endforeach
                                            </select>
                                            @error('question_id')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Answer</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2 @error('answer_id') is-invalid @enderror" multiple="multiple" required name="answer_id[]" id="answer_id" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                    <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-info-circle"></i> All <strong>{{ $data->name }}</strong>'s Question Answers
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Created Date & Time</th>
                                            <th>Updated Date & Time</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $alphas = range('a', 'z'); @endphp
                                        @if(\App\Service_questions_answers::where('service_id', $data->id)->groupby('question_id')->get()->count() > 0)
                                            @foreach(\App\Service_questions_answers::where('service_id', $data->id)->groupby('question_id')->get() as $row)
                                                <tr>
                                                    <td>{{ ($loop->index+1) }}</td>
                                                    <td>{{ $row->question_info->question }}</td>
                                                    <td>
                                                        @foreach(\App\Service_questions_answers::where('service_id', $data->id)->where('question_id',$row->question_id)->get() as $k=>$item)
                                                            <small>({{ $alphas[(($item->answer_info->order)? ($item->answer_info->order-1) : ($k))] }})</small> {{ $item->answer_info->answer }}<br/>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($row->updated_at)) }}</td>
                                                    <td align="center">
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->question_info->question }}')"><i class="fas fa-trash"></i> Remove Question</button>
                                                        <form class="d-none" method="POST" id="{{'delete-form-'.$row->id}}" action="{{route('services-questions.destroy',$row->id)}}">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.invoice -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete Question Answer?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> Question and answers details?
                        <br/><small class="text-red category-alert"></small></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-delete-now">Delete Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('script')
    <script>
        $('#question_id').on('change', function () {
            Get_answers(this.value, '{{route('products.question.answers')}}', '#answer_id');
        });
        function Get_answers(selected_value, url, data_fetch_id) {
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
    </script>
@endpush
@push('script')
    <script>
        $(document).keypress(
            function(event){
                if (event.which == '13') {
                    event.preventDefault();
                }
            });
        $('#item_price').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('#discount_price').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $("#item_price").on("input", function(){ set_commissions(); });
        $(".discount_mode").on("change", function(){
            var value = $(this).children("option:selected").val();
            if(value == "price"){
                $(".discount_none_el").hide(); $(".discount_price_el").show(); $(".discount_percentage_el").hide();
            }else if(value == "percentage"){
                $(".discount_none_el").hide(); $(".discount_price_el").hide(); $(".discount_percentage_el").show();
            }else{
                var item_pr=0;
                if($("#item_price").val()){ item_pr=$("#item_price").val(); }
                $(".discount_none_el").show(); $(".discount_price_el").hide();
                $(".discount_percentage_el").hide(); $("#show_final_price").html(formatAmount(item_pr));
                $("#item_final_price").val(item_pr.toFixed(2)); $(".agent_pay_amount").val(item_pr.toFixed(2));
                $("#show_discount_price").html(formatAmount(0)); $("#discount_price").val(null);
                $("#show_discount_percentage").html(0); $("#discount_percentage").val(null); set_commissions();
            }
        });
        $("#discount_percentage").on("input", function(){ set_commissions(); });
        $("#discount_price").on("input", function(){ set_commissions(); });
        function set_commissions(){
            var actual_price = $("#item_price").val();
            var discount_mode = $(".discount_mode").children("option:selected").val();
            var discount_price = $("#discount_price").val();
            var discount_percentage = $("#discount_percentage").val();
            var direct_commission = $(".direct_commission").val();
            var first_level_commission = $(".first_level_commission").val();
            var second_level_commission = $(".second_level_commission").val();
            var third_level_commission = $(".third_level_commission").val();
            var fourth_level_commission = $(".fourth_level_commission").val();
            var fifth_level_commission = $(".fifth_level_commission").val();
            var bonus_commission =  $(".bonus_commission").val();
            var expenses_commission = $(".expenses_commission").val();
            var donations_commission = $(".donations_commission").val();
            var seller_paid = $(".seller_paid").val();

            if($("#item_price").val()){
                if(discount_mode == 'price'){
                    if(discount_price){
                        $("#show_final_price").html(formatAmount(discount_price));
                        $("#item_final_price").val(discount_price);
                        $(".agent_pay_amount").val(discount_price);
                        $("#show_discount_price").html(formatAmount(actual_price));
                        var cal_discount_percentage = ((parseFloat(actual_price) - parseFloat(discount_price)) * 100) / parseFloat(actual_price);
                        if (cal_discount_percentage < 0) { cal_discount_percentage =0; }
                        $("#discount_percentage").val(cal_discount_percentage.toFixed(0));
                        $("#show_discount_percentage").html(cal_discount_percentage.toFixed(0));
                    }else{
                        $("#show_final_price").html(formatAmount(actual_price));
                        $("#item_final_price").val(actual_price); $(".agent_pay_amount").val(actual_price);
                        $("#show_discount_price").html(formatAmount(0)); $("#discount_percentage").val(0); $("#show_discount_percentage").html(0);
                    }
                }else if(discount_mode == 'percentage'){
                    var cal_final_price = (parseFloat(actual_price) - ((discount_percentage / 100) * parseFloat(actual_price)));
                    $("#show_final_price").html(formatAmount(cal_final_price)); $("#item_final_price").val(cal_final_price);
                    $("#show_discount_price").html(formatAmount(actual_price)); $(".agent_pay_amount").val(cal_final_price);
                    $("#discount_price").val(cal_final_price); $("#show_discount_percentage").html(discount_percentage);
                }else{
                    $("#show_final_price").html(formatAmount(actual_price)); $("#item_final_price").val(actual_price); $(".agent_pay_amount").val(actual_price);
                }
                if(direct_commission){
                    var discount_direct_price = (((direct_commission / 100) * $("#item_final_price").val()));
                    $(".direct_commission_price").val(discount_direct_price.toFixed(2));
                    $(".agent_pay_amount").val(($("#item_final_price").val()-discount_direct_price).toFixed(2));
                }
                if(first_level_commission){  $(".first_level_commission_price").val((((first_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(second_level_commission){ $(".second_level_commission_price").val((((second_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2));}
                if(third_level_commission){ $(".third_level_commission_price").val((((third_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(fourth_level_commission){ $(".fourth_level_commission_price").val((((fourth_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(fifth_level_commission){ $(".fifth_level_commission_price").val((((fifth_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(bonus_commission){ $(".bonus_commission_price").val((((bonus_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(expenses_commission){ $(".expenses_commission_price").val((((expenses_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(donations_commission){ $(".donations_commission_price").val((((donations_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(seller_paid){ $(".seller_paid_amount").val((((seller_paid / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                set_seller_percentage();
            }else{
                $("#show_final_price").html(formatAmount(0)); $("#item_final_price").val(0);
                $("#show_discount_price").html(formatAmount(0)); $(".agent_pay_amount").val(0);
                $("#show_discount_percentage").html(0);  $(".direct_commission_price").val(null);
                $(".first_level_commission_price").val(null); $(".second_level_commission_price").val(null);
                $(".third_level_commission_price").val(null); $(".fourth_level_commission_price").val(null);
                $(".fifth_level_commission_price").val(null);  $(".bonus_commission_price").val(null);
                $(".expenses_commission_price").val(null); $(".donations_commission").val(null); $(".seller_paid_amount").val(null);
                set_seller_percentage();
            }
        }
        $(".direct_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $("#item_final_price").val()));
                        $(".direct_commission_price").val(discount_price.toFixed(2));
                        $(".agent_pay_amount").val(($("#item_final_price").val()-discount_price).toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".direct_commission_price").val(null); $(".agent_pay_amount").val($("#item_final_price").val()); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".first_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".first_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".first_level_commission_price").val(null); }
                set_seller_percentage();
            }else{  alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".second_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".second_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".second_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".third_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".third_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".third_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".fourth_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".fourth_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".fourth_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".fifth_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".fifth_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".fifith_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".bonus_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".bonus_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".bonus_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".expenses_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".expenses_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".expenses_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".donations_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".donations_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".donations_commission_price").val(null); }
                set_seller_percentage();

            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".seller_paid").on("input", function(){
            // if($("#item_price").val()) {
            //     if ($(this).val() != '') {
            //         var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
            //     } else { $(".seller_paid_amount").val(null); }
            // }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        function formatAmount(number,text ,decPlaces, decSep, thouSep) {
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                decSep = typeof decSep === "undefined" ? "." : decSep;
            thouSep = typeof thouSep === "undefined" ? "," : thouSep;
            var sign = number < 0 ? "-" : "";
            var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
            var j = (j = i.length) > 3 ? j % 3 : 0;
            if(!text){ text="LKR. "; }
            return text+ sign +
                (j ? i.substr(0, j) + thouSep : "") +
                i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
                (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
        }
        $(".maxType").keypress(function(event){ if(parseInt($(this).val()+String.fromCharCode(event.which)) > 100){ return false; }else{ return true; } });
        function set_seller_percentage(){
            var per_total=0;
            var per_price =0;
            if($(".direct_commission").val()){
                // per_total += parseInt($(".direct_commission").val());
            }
            if($(".first_level_commission").val()){
                per_total += parseInt($(".first_level_commission").val());
                per_price += parseFloat($(".first_level_commission_price").val());
            }
            if($(".second_level_commission").val()){
                per_total += parseInt($(".second_level_commission").val());
                per_price += parseFloat($(".second_level_commission_price").val());
            }
            if($(".third_level_commission").val()){
                per_total += parseInt($(".third_level_commission").val());
                per_price += parseFloat($(".third_level_commission_price").val());
            }
            if($(".fourth_level_commission").val()){
                per_total += parseInt($(".fourth_level_commission").val());
                per_price += parseFloat($(".fourth_level_commission_price").val());
            }
            if($(".fifth_level_commission").val()){
                per_total += parseInt($(".fifth_level_commission").val());
                per_price += parseFloat($(".fifth_level_commission_price").val());
            }
            if($(".bonus_commission").val()){
                per_total += parseInt($(".bonus_commission").val());
                per_price += parseFloat($(".bonus_commission_price").val());
            }
            if($(".expenses_commission").val()){
                per_total += parseInt($(".expenses_commission").val());
                per_price += parseFloat($(".expenses_commission_price").val());
            }
            if($(".donations_commission").val()){
                per_total += parseInt($(".donations_commission").val());
                per_price += parseFloat($(".donations_commission_price").val());
            }
            if(per_total <= 100){
                $(".seller_paid_amount").val(($(".agent_pay_amount").val() - per_price));
                $(".seller_paid").val(100-per_total);
            }else{
                alert('You can\'t enter more than 100%.');
            }

            return per_total;
        }
    </script>
@endpush
