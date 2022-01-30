@extends('backend.layouts.admin')
@section('page_title','Create Voucher')
@include('backend.components.plugins.datetimepicker')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Voucher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
                            <li class="breadcrumb-item active">Create Voucher</li>
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
                        <form action="{{ route('vouchers.store') }}" method="post" class="form-horizontal" role="form">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Voucher type details</h3>
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
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Name of Voucher*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Voucher name ...">
                                        @error('name')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Voucher Code*</label>
                                        <div class="input-group mb-3">
                                            <input type="text" readonly class="form-control @error('code') is-invalid @enderror voucher_code" id="code" required name="code" value="{{ old('code') }}" placeholder="Voucher Code ...">
                                            <div class="input-group-append">
                                                <button type="button" {{ old('code')? 'disabled':'' }} class="btn btn-outline-info" id="generate-coupon-code">Generate Code</button>
                                            </div>
                                        </div>
                                        @error('code')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                        @php
                                            function generate_coupon_code($length = 20) {
                                                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                $charactersLength = strlen($characters);
                                                $randomString = '';
                                                for ($i = 0; $i < $length; $i++) {
                                                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                                                }
                                                return $randomString;
                                            }
                                            $voucher_get_code = generate_coupon_code(10);
                                            if(!\App\Vouchers::where('code',generate_coupon_code(10))->first()){
                                                $voucher_code = $voucher_get_code;
                                            }else{
                                                $voucher_code = rand(0,10)+$voucher_get_code;
                                            }
                                        @endphp
                                        @push('script')
                                            <script>
                                                $("#generate-coupon-code").on('click',function(){
                                                    $(".voucher_code").val('{{ $voucher_code }}');
                                                });
                                            </script>
                                        @endpush
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Voucher type*</label>
                                        <select class="form-control select2 @error('voucher_type') is-invalid @enderror" required name="voucher_type" style="width: 100%;">
                                            <option value="Purchase" {{ (old('voucher_type') == "Purchase")? 'selected' : '' }}>Purchase</option>
                                            <option value="Shipping Amount" {{ (old('voucher_type') == "Shipping Amount")? 'selected' : '' }}>Shipping Amount</option>
                                            <option value="Reservation" {{ (old('voucher_type') == "Reservation")? 'selected' : '' }}>Reservation</option>
                                        </select>
                                        @error('voucher_type')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Discount type*</label>
                                        <select class="form-control select2 @error('discount_type') is-invalid @enderror" required name="discount_type" style="width: 100%;">
                                            <option value="price" {{ (old('discount_type') == "price")? 'selected' : '' }}>Price</option>
                                            <option value="percentage" {{ (old('discount_type') == "percentage")? 'selected' : '' }}>Percentage</option>
                                        </select>

                                        @error('discount_type')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Discount*</label>
                                        <input type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') }}" placeholder="Discount ...">
                                        @error('discount')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Minimum purchase</label>
                                        <input type="text" class="form-control @error('minimum_total') is-invalid @enderror" name="minimum_total" value="{{ old('minimum_total') }}" placeholder="Minimum purchase ...">
                                        @error('minimum_total')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Number of Users</label>
                                        <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control @error('allowed_users') is-invalid @enderror" name="allowed_users" value="{{ old('allowed_users')?old('allowed_users'): '' }}" placeholder="Number of users ...">
                                        @error('allowed_users')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Accept Type*</label>
                                        <select class="form-control select2 @error('allow_type') is-invalid @enderror" required name="allow_type" style="width: 100%;">
                                            <option value="single" {{ (old('allow_type') == "single")? 'selected' : '' }}>Single</option>
                                            <option value="multiple" {{ (old('allow_type') == "multiple")? 'selected' : '' }}>Multiple</option>
                                        </select>
                                        @error('allow_type')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Expiry Date</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <div class="input-group-append">
                                                <span class="">
                                                    <div class="border" style="padding: 7px 4px 5px 10px;">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" {{ old('expiry_check')? 'checked': '' }} id="expiry_check" name="expiry_check" >
                                                            <label for="expiry_check"></label>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                            <input type="text" id="expiry_date" disabled class="form-control datetimepicker-input" name="voucher_expiry_date" data-target="#reservationdate" value="" placeholder="Expiry date ..."/>
                                            <div class="input-group-append"  data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text" id="show_cal"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('expiry_date')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Status*</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror" required name="status" style="width: 100%;">
                                            <option value="Enabled" {{ (old('status') == "Enabled")? 'selected' : '' }}>Enable</option>
                                            <option value="Disabled" {{ (old('status') == "Disabled")? 'selected' : '' }}>Disabled</option>
                                        </select>
                                        @error('status')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3" placeholder="About voucher ...">{{ old('description')? old('description'): '' }}</textarea>
                                        @error('description')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 pull-right">
                                        <a href="{{ route('vouchers.index') }}" class="btn btn-danger btn-flat"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
                                        <button type="reset" class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i> Reset</button>
                                        <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check-circle"></i> Save & changes</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            @push('script')
                                <script>
                                    $('#reservationdate').datetimepicker({
                                        format: 'L'
                                    });
                                    $("#expiry_check").click(function(){
                                        if($(this).prop("checked") == true){
                                            $("#expiry_date").prop('disabled', false);
                                        }
                                        else if($(this).prop("checked") == false){
                                            $("#expiry_date").prop('disabled', true);
                                            $("#expiry_date").val(null);
                                        }
                                    });

                                    $('#expiry_date').click(function () {
                                        $("#show_cal").trigger('click');
                                    });
                                </script>
                            @endpush
                        </div>
                        <!-- /.card -->
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
