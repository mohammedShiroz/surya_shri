@extends('backend.layouts.admin')
@section('page_title', ((request()->routeIs('partners.*') && $data->agent_status == "Approved")? 'Partner' : 'User').' Details')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')

@php
    function getEmpInfo($id){ return \App\Agent::where('id', $id)->firstOrFail(); }
@endphp
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/hierarchy.css')}}">
@endpush
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@if((request()->routeIs('partners.*') && $data->agent_status == "Approved")) Partner
                            @elseif((request()->routeIs('sellers.*') && $data->agent_status == "Approved")) Seller
                            @elseif(request()->routeIs('doctors.*')) Doctor
                            @else Buyer
                            @endif Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            @if(request()->routeIs('users.*'))
                                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Buyer</a></li>
                                <li class="breadcrumb-item active">Buyer Details</li>
                            @elseif(request()->routeIs('sellers.*'))
                                <li class="breadcrumb-item"><a href="{{ route('sellers.index') }}">Sellers</a></li>
                                <li class="breadcrumb-item active">Sellers Details</li>
                            @elseif(request()->routeIs('doctors.*'))
                                <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">Doctors</a></li>
                                <li class="breadcrumb-item active">Doctor Details</li>
                            @elseif(request()->routeIs('partners.*'))
                                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Partners</a></li>
                                <li class="breadcrumb-item active">Partner Details</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Buyer</a></li>
                                <li class="breadcrumb-item active">Buyer Details</li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-info card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ (!empty($data->profile_image))? asset($data->profile_image) : asset('administration/img/admin_avatar.png') }}"
                                         alt="{{ $data->name }}">
                                </div>
                                <h3 class="profile-username text-center text-uppercase">{{ $data->name }} {{ $data->last_name }}</h3>
                                <p class="text-muted text-center" style="margin-top: -10px;">{{ $data->email }}</p>
                                @if($data->employee)
                                <p class="text-muted text-center" style="margin-top: -18px;">{{ $data->user_code }}</p>
                                @endif
                                <ul class="list-group list-group-unbordered mb-3">
                                    {{--<li class="list-group-item">--}}
                                        {{--<b><i class="fas fa-user-shield mr-1"></i> Activation Status</b><a class="float-right"><i class="fa {{ (!empty($data->email_verified_at))? 'fa-check-circle-o text-success': 'fa-times-circle-o text-danger' }}"></i> </a>--}}
                                    {{--</li>--}}
                                    @if($data->agent_status == "Approved")
                                    {{--<li class="list-group-item">--}}
                                        {{--<b><i class="fas fa-user-check mr-1"></i>Verified Partner</b> <a class="float-right">--}}
                                            {{--<i class="fa {{ ($data->agent_status == "Approved")? 'fa-check-circle-o text-success' : 'fa-times-circle-o text-danger' }}"></i>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    @endif
                                    @if((request()->routeIs('sellers.*') && $data->agent_status == "Approved"))
                                        @if($data->employee->is_doctor)
                                        <li class="list-group-item">
                                            <b><i class="fas fa-user-check mr-1"></i>Approved Doctor</b> <a class="float-right">
                                                <i class="fa fa-check-circle-o text-success"></i>
                                            </a>
                                        </li>
                                        @endif
                                        @if($data->employee->is_seller)
                                            <li class="list-group-item">
                                                <b><i class="fas fa-user-check mr-1"></i>Approved Seller</b> <a class="float-right">
                                                    <i class="fa fa-check-circle-o text-success"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    <li class="list-group-item">
                                        <b>Reservations</b><a class="float-right">({{ $data->bookings->count() }})</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Orders</b><a class="float-right">({{ $data->orders->count() }})</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Wish-list</b><a class="float-right">({{ $data->wishlist->count() }})</a>
                                    </li>
                                </ul>
                                <a href="@if(request()->routeIs('users.*')) {{ route('users.index') }} @elseif(request()->routeIs('sellers.*')) {{ route('sellers.index') }} @elseif(request()->routeIs('doctors.*')) {{ route('doctors.index') }} @elseif(request()->routeIs('partners.*')) {{ route('partners.index') }} @else {{ route('users.index') }} @endif" class="btn btn-info btn-block"><b>Back</b></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        {{--If partner requested to join future edit--}}
                        @if(request()->routeIs('partners.request.review') && $data->agent_status == "Requested")
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Partner review action</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('partners.request.approve') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="col-form-label">Referral User</label>
                                            <input type="text" disabled class="form-control" value="({{ $data->ref_info->id }}) - {{ $data->ref_info->user->name }}" placeholder="None">
                                            <input type="hidden" name="ref_id" value="{{ $data->ref_info->id }}">
                                            <input type="hidden" name="user_id" value="{{ $data->id }}">
                                            <input type="hidden" name="intro_id" value="{{ $data->ref_info->id }}">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="col-form-label">Requested Date & Time</label>
                                            <input type="text" disabled class="form-control" value="{{ date('Y-m-d h:i:s A', strtotime($data->agent_request_date)) }}" placeholder="Date">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="col-form-label">Placement User</label>
                                            <select class="form-control select2 @error('placement_id') is-invalid @enderror" name="placement_id" style="width: 100%;">
                                                <option value="{{ getEmpInfo($data->request_referral)->id }}" {{ (old('placement_id'))? (getEmpInfo($data->request_referral)->id == old('placement_id')? 'selected': '') : '' }}>({{ getEmpInfo($data->request_referral)->id }}) - {{ getEmpInfo($data->request_referral)->user->name }}</option>
                                                    @foreach (\App\Agent::Where('placement_id',$data->request_referral)->get() as $emp)
                                                        <option value="{{ $emp->id }}" {{ (old('placement_id'))? ($emp->id == old('placement_id')? 'selected': '') : '' }}>({{ $emp->id }}) - {{ getEmpInfo($emp->id)->user->name }}</option>
                                                        @if($emp->child_employees->isNotEmpty())
                                                            @include('backend.customers.employee.child_emp', [
                                                                'child_employees' => $emp->child_employees
                                                            ])
                                                        @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success btn-sm pull-right ml-2">Approve</button>
                                            <a href="{{ route('partners.request.reject', $data->id) }}" class="btn btn-danger btn-sm pull-right ml-2">Reject</a>
                                            <a href="{{ route('partners.request') }}" class="btn btn-info btn-sm pull-right">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        @endif
                        <div class="card card-info card-outline">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab">Personal Info</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#points" data-toggle="tab">Points</a></li>
                                    @if($data->employee)
                                        <li class="nav-item"><a class="nav-link" href="#employee_info" data-toggle="tab">Partner Info</a></li>
                                    @endif
                                        <li class="nav-item"><a class="nav-link" href="#bank_info" data-toggle="tab">Bank Details</a></li>
                                    @if($data->agent_status == "Approved")
                                        @permission('update-partners')
                                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                                        @endpermission
                                    @endif
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="personal">
                                        <div class="card-body p-0">
                                            <table class="table table-sm">
                                                <tr>
                                                    <td width="2%">1.</td>
                                                    <td width="20%">User ID</td>
                                                    <td>{{ $data->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="2%">2.</td>
                                                    <td width="20%">Full Name:</td>
                                                    <td>{{ $data->name }} {{ $data->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3.</td>
                                                    <td width="20%">Email:</td>
                                                    <td>{{ $data->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>4.</td>
                                                    <td width="20%">Contact No:</td>
                                                    <td>{{ $data->contact }}</td>
                                                </tr>
                                                <tr>
                                                    <td>5.</td>
                                                    <td width="20%">Country:</td>
                                                    <td>{{ (!empty($data->country))? $data->country : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>6.</td>
                                                    <td width="20%">City:</td>
                                                    <td>{{ (!empty($data->city))? $data->city : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>7.</td>
                                                    <td width="20%">Gender:</td>
                                                    <td>{{ (!empty($data->gender))? $data->gender : '-' }}</td>
                                                </tr>
                                                @if(request()->routeIs('sellers.*'))
                                                    @if($data->employee->is_doctor)
                                                        <tr>
                                                            <td>8.</td>
                                                            <td width="20%">Approved as Doctor:</td>
                                                            <td>{{ date('Y-m-d h:i:s A', strtotime($data->employee->is_doctor)) }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($data->employee->is_seller)
                                                        <tr>
                                                            <td>{{ ($data->employee->is_doctor)? '9' : '8' }}.</td>
                                                            <td width="20%">Approved as Seller:</td>
                                                            <td>{{ date('Y-m-d h:i:s A', strtotime($data->employee->is_seller)) }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                                <tr>
                                                    @if(request()->routeIs('sellers.*'))
                                                        <td>{{ ($data->employee->is_doctor && $data->employee->is_seller)? '10' : '9' }}.</td>
                                                    @else
                                                    <td>8.</td>
                                                    @endif
                                                    <td width="20%">Registered Date & Time</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($data->created_at)) }}</td>
                                                </tr>
                                                @if($data->employee)
                                                <tr>
                                                    <td colspan="2" width="20%">Approved as</td>
                                                    <td>
                                                        @if(($data->employee->is_doctor && $data->employee->is_seller))
                                                            Doctor & Seller
                                                        @elseif($data->employee->is_seller)
                                                            Seller
                                                        @elseif($data->employee->is_doctor)
                                                            Doctor
                                                        @else
                                                            Partner
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="2" width="20%" style="padding-top: 10px;">Newsletter Subscribe?</td>
                                                    <td style="padding-top: 10px;">
                                                        @if($data->e_subscribe == 1)
                                                            Yes
                                                        @else
                                                            Yes
                                                        @endif
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($data->address_info->count() > 0)
                                            <!-- /.card-body -->
                                            <div class="card-body">
                                                @foreach($data->address_info as $row)
                                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address #{{ $loop->index+1 }}</strong>
                                                <p class="text-muted">{{ $row->address }} - Sri-Lanka</p>
                                                <hr>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="points">
                                        <div class="card-body" style="padding: 0 !important;">
                                            <!-- START SECTION WHY CHOOSE -->
                                            <div class="pt-5">
                                                <div class="container">
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getFinalPointsByUser($data->id)["available_points"]) }}</h5>
                                                                    <p>Available Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getTransferablePoints($data->id)) }}</h5>
                                                                    <p>Transferable Point </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_transferred_points"]) }}</h5>
                                                                    <p>Sent Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_credited_points"]) }}</h5>
                                                                    <p>Received Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center text-center mt-5">
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_in_direct_points"]) }}</h5>
                                                                    <p>Network Earnings</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_refund_points"]) }}</h5>
                                                                    <p>Refunded Points</p>
                                                                    <p class="mt-n4"><small>(product or service refunds)</small></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_used_points"]) }}</h5>
                                                                    <p>Total Spent Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_withdrawal_points"]) }}</h5>
                                                                    <p>Total Withdrawal Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center text-center mt-5">
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_donated_points"]) }}</h5>
                                                                    <p>Donated Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_seller_earn_points"]) }}</h5>
                                                                    <p>Total Seller Earning Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_doctor_earn_points"]) }}</h5>
                                                                    <p>Total Doctor Earning Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    @php
                                                                        $emp_points =0;
                                                                        function numberOfPartners($id){
                                                                            global $emp_points;
                                                                            $emp_points =0;
                                                                            foreach (\App\Agent::Where('placement_id',$id)->get() as $emp){
                                                                                $emp_points += getCalPointsByUser($emp->user->id)["total_in_direct_points"];
                                                                                if($emp->child_employees->isNotEmpty()){ show_emp($emp->child_employees); }
                                                                            }
                                                                            return $emp_points;
                                                                        }
                                                                        function show_emp($child_employees){
                                                                            global $emp_points;
                                                                            foreach($child_employees as $parent){
                                                                                $emp_points += getCalPointsByUser($parent->user->id)["total_in_direct_points"];
                                                                                if($parent->child_employees->isNotEmpty()){ show_emp($parent->child_employees); }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <h5>{{ ($data->employee)? getPointsFormat(numberOfPartners($data->employee->id)) : getPointsFormat(0)  }}</h5>
                                                                    <p>Total Network Sales</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center text-center mt-5">
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_redeem_points"]) }}</h5>
                                                                    <p>Redeemed Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END SECTION WHY CHOOSE -->
                                        </div>
                                    </div>
                                    @if($data->agent_status == "Approved")
                                    <div class="tab-pane" id="employee_info">
                                        <div class="card-body p-0">
                                            <table class="table table-sm">
                                                <tr>
                                                    <td width="2%">1.</td>
                                                    <td width="20%">Partner ID:</td>
                                                    <td>{{ $data->employee->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="2%">2.</td>
                                                    <td width="20%">Partner Code:</td>
                                                    <td>{{ $data->user_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3.</td>
                                                    <td width="20%">Referred User:</td>
                                                    <td><a href="{{ isset($data->employee->referral_info->id)? route('partners.show', $data->employee->referral_info->user->id) : '' }}">{{ isset($data->employee->referral_info->user->name)? "(".$data->employee->referral_info->id.") - ".($data->employee->referral_info->user->name." ".$data->employee->referral_info->user->last_name) : '-' }}</a></td>
                                                </tr>
                                                {{--<tr>--}}
                                                    {{--<td>4.</td>--}}
                                                    {{--<td width="20%">Introduced By:</td>--}}
                                                    {{--<td><a href="{{ isset($data->employee->intro_info->id)? route('partners.show', $data->employee->intro_info->user->id) : '' }}">{{ isset($data->employee->intro_info->user->name)? "(".$data->employee->intro_info->id.") - ".($data->employee->intro_info->user->name." ".$data->employee->intro_info->user->last_name) : '-' }}</a></td>--}}
                                                {{--</tr>--}}
                                                <tr>
                                                    <td>4.</td>
                                                    <td width="20%">Direct Uplink:</td>
                                                    <td><a href="{{ isset($data->employee->placement_info->user->id)? route('partners.show', $data->employee->placement_info->user->id): ''}}">{{ isset($data->employee->placement_info->user->name)? "(".$data->employee->placement_info->id.") - ". ($data->employee->placement_info->user->name." ".$data->employee->placement_info->user->last_name) : '-' }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>5.</td>
                                                    <td width="20%">Requested Date & Time:</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($data->agent_request_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>6.</td>
                                                    <td width="20%">Partnered Date & Time:</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($data->employee->created_at)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>7.</td>
                                                    <td width="20%">Partner Status:</td>
                                                    <td>
                                                        @if(($data->employee->is_doctor && $data->employee->is_seller))
                                                            Doctor & Seller
                                                        @elseif($data->employee->is_seller)
                                                            Seller
                                                        @elseif($data->employee->is_doctor)
                                                            Doctor
                                                        @else
                                                            Partner
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8.</td>
                                                    <td width="20%">Joined Date & Time:</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($data->employee->created_at)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>9.</td>
                                                    <td width="20%">Coupon Codes joined</td>
                                                    <td>{{ (\App\UsedUserCoupons::where('partner_id',$data->employee->id)->whereNull('is_deleted')->whereNull('user_code')->get()->count()) + (\App\UsedUserCoupons::where('partner_id',$data->employee->id)->whereNull('is_deleted')->whereNotNull('user_code')->get()->count()) }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            @if(request()->routeIs('partners.*'))
                                                <div class="row mt-3">
                                                    <div class="col-md-12 col-sm-12">
                                                        <p class="mt-3 ml-3">
                                                            <strong>Coupon Codes</strong>
                                                        </p>
                                                        <hr/>
                                                        @if($data->coupon_codes->count()>0)
                                                            <table id="example1" class="table table-bordered table-striped w-100">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Coupon Code</th>
                                                                    <th>No. Joined Referral</th>
                                                                    <th>Created Date & Time</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($data->coupon_codes as $row)
                                                                    <tr>
                                                                        <td> {{ $loop->index+1 }}</td>
                                                                        <td>{{ $row->code }}
                                                                            @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                                <small class="badge badge-info" style="font-size: 8px">New</small>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $row->joined_ref->count() }}</td>
                                                                        <td>{{ date('d, M Y, h:i:s A', strtotime( $row->created_at)) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>

                                                            <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                                                <thead>

                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <p class=""><i class="fa fa-info-circle"></i> No coupon code result found.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($data->employee->parents())
                                                <div class="row mt-3">
                                                    <div class="col-md-12 col-sm-12">
                                                        <p class="mt-3 ml-3">
                                                            <strong>Hierarchy Quick View</strong>
                                                        </p>
                                                        <hr/>
                                                        <div class="hierarchy-body hierarchy-scroll">
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12">
                                                                    <ol>
                                                                        <li>
                                                                            <h3 class="level-3 rectangle text-uppercase" style="margin-left: 24px;">{{ env('APP_NAME') }}<br/><span>Company</span></h3>
                                                                            <ol class="level-4-wrapper">
                                                                                @foreach(explode(',',$data->employee->parents()) as $partner)
                                                                                    <li>
                                                                                        <h4 class="level-4 rectangle">({{getEmpInfo($partner)->user->employee->id}}) {{ getEmpInfo($partner)->user->name." ".getEmpInfo($partner)->user->last_name[0] }}
                                                                                            @if($data->employee->referral_info->id == $partner)<br/><small>(Referral)</small>@endif
                                                                                        </h4>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ol>
                                                                        </li>
                                                                    </ol>
                                                                    <div class="text-center mt-3 ml-5">
                                                                        <button type="button" class="btn btn-dark btn-sm show_detail">Show Detail View</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <div class="tab-pane" id="bank_info">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        @if($data->bank_details)
                                                            <ul class="list-unstyled bg-light p-3">
                                                                <li>
                                                                    <strong>Account Type: </strong> {{ $data->bank_details->account_name? $data->bank_details->account_name : '-' }}
                                                                </li>
                                                                <li>
                                                                    <strong>Account No: </strong> {{ $data->bank_details->account_number? $data->bank_details->account_number : '-' }}
                                                                </li>
                                                                <li>
                                                                    <strong>Bank Branch: </strong> {{ $data->bank_details->bank_branch? $data->bank_details->bank_branch: '-' }}
                                                                </li>
                                                                <li>
                                                                    <strong>Bank Name: </strong> {{ $data->bank_details->bank_name? $data->bank_details->bank_name.", " : '-'  }}
                                                                </li>
                                                                <li>
                                                                    <strong>Remarks: </strong> {{ $data->bank_details->Remarks?  $data->bank_details->Remarks : 'Customer' }}
                                                                </li>
                                                            </ul>
                                                        @else
                                                            <i class="fa fa-info-circle"></i> No Bank Result Found.
                                                        @endif
                                                        @if($data->bank_details)
                                                            <div class="row">
                                                                @if($data->bank_details->status == "Pending")
                                                                    <div class="col-6">
                                                                        <form method="post" id="reject-bank-form" class="d-inline-flex" action="{{ route('withdrawal-wallet.bank-info.reject') }}">
                                                                            @csrf
                                                                            <input type="hidden" name="detail_id" value="{{$data->bank_details->id}}"/>
                                                                            {{--                                                    <textarea name="reject_description" class="form-control mb-2" row="5">{{ old('reject_description') }}</textarea>--}}
                                                                            <button type="button" class="btn btn-danger w-40" onclick="confirm_check_bank('reject')"><i class="fas fa-close"></i> Reject</button>
                                                                        </form>
                                                                        <form method="post" id="approve-bank-form" class="d-inline-flex mt-2" action="{{ route('withdrawal-wallet.bank-info.approve') }}">
                                                                            @csrf
                                                                            <input type="hidden" name="detail_id" value="{{$data->bank_details->id}}"/>
                                                                            <button type="button" class="btn btn-success w-40" onclick="confirm_check_bank('approve')"><i class="fas fa-check"></i> Approve</button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                <div class="col-6">
                                                                    @permission('update-withdrawals')
                                                                    @push('script')
                                                                        <script>
                                                                            function confirm_check_bank(data){
                                                                                swal.fire({
                                                                                    title: '<span class="text-uppercase">'+data+' this bank details</span>',
                                                                                    text: "Are you sure want to "+data+" this bank details?",
                                                                                    type: 'warning',
                                                                                    icon: 'warning',
                                                                                    showCancelButton: true,
                                                                                    confirmButtonText: 'Yes, '+data+' it!',
                                                                                    cancelButtonText: 'No',
                                                                                    reverseButtons: true
                                                                                }).then((result) => {
                                                                                    if (result.value) {
                                                                                        $("#"+data+"-bank-form").submit();
                                                                                    } else if (
                                                                                        // Read more about handling dismissals
                                                                                        result.dismiss === Swal.DismissReason.cancel
                                                                                    ) { }
                                                                                });
                                                                            }
                                                                        </script>
                                                                    @endpush
                                                                    @endpermission
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($data->bank_details)
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <ul class="list-unstyled bg-light p-3">
                                                                        <li>
                                                                            <strong>Billing Proof: </strong>
                                                                            @if($data->bank_details->billing_proof)
                                                                                <br/>
                                                                                <img width="100%" src="{{ asset($data->bank_details->billing_proof) }}" alt="Billing Proof" />
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-6">
                                                                    <ul class="list-unstyled bg-light p-3">
                                                                        <li>
                                                                            <strong>Nic Proof: </strong>
                                                                            @if($data->bank_details->nic_proof)
                                                                                <br/>
                                                                                <img width="100%" src="{{ asset($data->bank_details->nic_proof) }}" alt="Nic Proof" />
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    @permission('update-partners')
                                    <div class="tab-pane" id="settings">
                                        @if($data->agent_status == "Approved" && request()->routeIs('partners.*') && $data->employee->id !=1)
                                        <div class="card-body border">
                                            <h5 class="title">Placement</h5>
                                            <hr/>
                                            <form class="form-horizontal" action="{{ route('partners.placement.update') }}" method="POST">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-4 col-sm-12">
                                                        <label class="col-form-label">Referred User</label>
                                                        <input type="text" disabled class="form-control" value="({{ $data->ref_info->id }}) - {{ $data->ref_info->user->name." ".$data->ref_info->user->last_name }}" placeholder="None">
                                                        <input type="hidden" name="agent_id" value="{{ $data->employee->id }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <label class="col-form-label">Partnered Date & Time</label>
                                                        <input type="text" disabled class="form-control" value="{{ date('Y-m-d h:i:s A', strtotime($data->employee->created_at)) }}" placeholder="Date">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <label class="col-form-label">Direct Uplink</label>
                                                        <select class="form-control select2 @error('placement_id') is-invalid @enderror" name="placement_id" style="width: 100%;">
                                                            <option value="{{ getEmpInfo($data->request_referral)->id }}" {{ (old('placement_id'))? (getEmpInfo($data->request_referral)->id == old('placement_id')? 'selected': '') : '' }}>({{ getEmpInfo($data->request_referral)->id }}) - {{ getEmpInfo($data->request_referral)->user->name." ".getEmpInfo($data->request_referral)->user->last_name }}</option>
                                                            @foreach (\App\Agent::Where('placement_id',$data->request_referral)->get() as $emp)
                                                                <option value="{{ $emp->id }}" {{ ($emp->id == $data->employee->placement_info->id)? 'selected' : '' }}>({{ $emp->id }}) - {{ getEmpInfo($emp->id)->user->name." ".getEmpInfo($emp->id)->user->last_name }}</option>
                                                                @if($emp->child_employees->isNotEmpty())
                                                                    @include('backend.customers.employee.child_emp', [
                                                                        'child_employees' => $emp->child_employees
                                                                    ])
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-success btn-sm pull-right ml-2">Update</button>
                                                        <a href="{{ route('partners.request') }}" class="btn btn-info btn-sm pull-right">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- /.card-body -->
                                        @else
                                            <p>No Result Found!</p>
                                        @endif
                                    </div>
                                    @endpermission
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        @if((($data->employee && $data->agent_status == "Approved")) && (\auth::user()->haspermission('read-sellers-notes') || \auth::user()->haspermission('create-sellers-notes')))
                            @if(($data->employee->is_seller || $data->employee->is_doctor) && (request()->routeIs('sellers.*') || request()->routeIs('doctors.*')))
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        @permission('read-sellers-notes')
                                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                                            <h6 class="text-secondary"><i class="fas fa-edit"></i> Additional Note</h6>
                                            <table class="w-100">
                                                @foreach($data->notes as $row)
                                                    <tr class="border mb-2">
                                                        <td class="p-2">
                                                            @if($row->is_deleted)
                                                                <del>{!! ($loop->index+1).". ".$row->additional."<br/>" !!}</del>
                                                            @else
                                                                {!! ($loop->index+1).". ".$row->additional."<br/>" !!}
                                                            @endif
                                                        </td>
                                                        @permission('delete-sellers-notes')
                                                        <td class="p-2" align="right">
                                                            @if(!$row->is_deleted)
                                                                <a href="{{ route('users.delete.notes',$row->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                            @endif
                                                        </td>
                                                        @endpermission
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        @endpermission
                                        @permission('create-sellers-notes')
                                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                                            <h6 class="text-secondary"><i class="fas fa-edit"></i> Add Additional Note</h6>
                                            <form action="{{ route('users.add.notes') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $data->id }}" />
                                                <textarea class="form-control" name="additional" rows="5">{!! old('additional')? old('additional'): $data->additional !!}</textarea>
                                                @error('additional')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                                <button class="btn btn-info float-right ml-1 mt-2" type="submit">Save Changes</button>
                                            </form>
                                        </div>
                                        @endpermission
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                    <!-- /.col -->
                    @push('script')
                        <script>
                            var toggle=false;
                            $(".show_detail").click(function(){
                                if(toggle == false){
                                    $("#partner_hierarchy").slideDown();
                                    $(".show_detail").html('Hide Detail View');
                                    toggle =true;
                                }else{
                                    $("#partner_hierarchy").slideUp();
                                    toggle =false;
                                    $(".show_detail").html('Show Detail View');
                                }
                            });
                        </script>
                    @endpush
                    @if((request()->routeIs('partners.*') && $data->agent_status == "Approved"))
                    <div class="col-md-12 col-sm-12" id="partner_hierarchy" style="display: none">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title text-center">Hierarchy View</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="hierarchy-body hierarchy-scroll">
                                    <figure>
                                        <ul class="tree">
                                            <li><span>{{ env('APP_NAME') }}<br/>Company</span>
                                                @if(\App\Agent::Where('placement_id','1')->get()->count()>0)
                                                    <ul>
                                                        @foreach (\App\Agent::Where('placement_id','1')->get() as $emp)
                                                            <li><a href="{{ route('partners.show', $emp->user->id)}}"><span class="{{ isset($data->employee->id)? ($data->employee->id == $emp->id)? 'alerts-border': '' : '' }}"><small class="badge badge-secondary text-black-50 mb-1 mr-1" style="border-radius: 100%; background: transparent; border: 1px solid grey;">{{ $emp->id }}</small> {{ getEmpInfo($emp->id)->user->name." ".getEmpInfo($emp->id)->user->last_name }}</span></a>
                                                            @if($emp->child_employees->isNotEmpty())
                                                                @include('employee_dashboard.child_emp', [
                                                                    'child_employees' => $emp->child_employees
                                                                ])
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        </ul>
                                    </figure>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                    @endif
                    @if(request()->routeIs('sellers.*'))
                        <div class="col-md-12 col-sm-12">
                            {{--<div class="card card-info card-outline">--}}
                                {{--<div class="card-header">--}}
                                    {{--<h5 class="card-title">Add Product</h5>--}}
                                    {{--<div class="card-tools">--}}
                                        {{--<button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
                                            {{--<i class="fas fa-minus"></i>--}}
                                        {{--</button>--}}
                                        {{--<button type="button" class="btn btn-tool" data-card-widget="remove">--}}
                                            {{--<i class="fas fa-times"></i>--}}
                                        {{--</button>--}}
                                    {{--</div>--}}
                                {{--</div><!-- /.card-header -->--}}
                                {{--<div class="card-body">--}}
                                    {{--<form class="form-horizontal" action="{{ route('sellers.add.product') }}" method="POST">--}}
                                        {{--@csrf--}}
                                        {{--<div class="form-group row">--}}
                                            {{--<div class="col-lg-12 col-md-12 col-sm-12">--}}
                                                {{--<label class="col-form-label">Products</label>--}}
                                                {{--<input type="hidden" name="agent_id" value="{{ $data->employee->id }}" />--}}
                                                {{--<select class="form-control select2 @error('product_id') is-invalid @enderror" name="product_id" style="width: 100%;">--}}
                                                    {{--<option disabled selected>Select a Product to enlist under this Seller</option>--}}
                                                    {{--<?php $pro_ids=array(); foreach(\App\SellerProducts::all() as $row) {array_push($pro_ids,$row->product_id); }  ?>--}}
                                                    {{--@foreach(\App\Products::WHERENULL('is_deleted')->orderby('created_at','DESC')->get() as $row)--}}
                                                        {{--@if(in_array($row->id, $pro_ids, true))--}}
                                                        {{--@else--}}
                                                            {{--<option value="{{ $row->id }}" {{ (old('placement_id'))? (($row->id == old('product_id'))? 'selected': '') : '' }}>({{ $row->id }}) - {{ $row->name }}</option>--}}
                                                        {{--@endif--}}
                                                    {{--@endforeach--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group row">--}}
                                            {{--<div class="col-12">--}}
                                                {{--<button type="submit" class="btn btn-success btn-sm pull-right ml-2">Add Product</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div><!-- /.card-body -->--}}
                            {{--</div>--}}
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Products</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Seller Price</th>
                                            <th>Stock</th>
                                            <th>Items Sold</th>
                                            <th>Visibility</th>
                                            <th>Created Date & Time</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($data->employee->products->count() > 0)
                                            @foreach($data->employee->products as $row)

                                                <tr>
                                                    <td> {{ $loop->index+1 }}</td>
                                                    <td width="5px">
                                                        <img class="rounded-circle" src="{{ (!empty($row->product_info->thumbnail_image)) ? asset($row->product_info->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" width="80" alt="{{ $row->product_info->name }}" />
                                                    </td>
                                                    <td>{{ $row->product_info->name }}
                                                        @if((new DateTime($row->product_info->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                        @endif</td>
                                                    <td> {{ getCurrencyFormat($row->product_info->price) }}</td>
                                                    <td>{{ getCurrencyFormat($row->product_info->seller_paid_amount) }}</td>
                                                    <td>{{ $row->product_info->stock }}</td>
                                                    <td>{{ $row->product_info->sold }}</td>
                                                    <td>{!! ($row->product_info->visibility == 1)? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-eye"></i> Visible</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-eye-slash"></i> Hidden</span>' !!}</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($row->product_info->created_at)) }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('products.show', $row->product_info->id)}}" class="btn btn-success"><i class="fa fa-eye"></i> Details</a>
                                                            {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->product_info->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                            {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                                  {{--action="{{route('sellers.remove.product')}}">--}}
                                                                {{--@csrf--}}
                                                                {{--<input type="hidden" name="agent_id" value="{{ $data->employee->id }}" />--}}
                                                                {{--<input type="hidden" name="product_id" value="{{ $row->product_info->id }}" />--}}
                                                            {{--</form>--}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @endif
                    @if(request()->routeIs('doctors.*'))
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Services</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Service Name</th>
                                            <th>Category</th>
                                            <th>Doctor Name</th>
                                            <th>Price</th>
                                            <th>Doctor Fee</th>
                                            <th>Reservations Booked</th>
                                            <th>Visibility</th>
                                            <th>Added Date & Time</th>
                                            <th>Updated Date & Time</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($data->employee->services->count()>0)
                                            @foreach($data->employee->services as $row)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td width="5px"><img class="rounded-circle" src="{{ (!empty($row->image)) ? asset($row->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" width="80" alt="{{ $row->name }}" /> </td>
                                                    <td>{{ $row->name }}</td>
                                                    <td> {{ $row->category->name }}</td>
                                                    <td> {{ $row->doctor_id? ($row->doctor->user->name." ".$row->doctor->user->last_name) : ' - ' }}</td>
                                                    <td>{{ $row->price }}</td>
                                                    <td>{{ getCurrencyFormat($row->seller_paid_amount) }}</td>
                                                    <td>{{ \App\Service_booking::where('service_id',$row->id)->where('status','completed')->get()->count() }}</td>
                                                    <td>{!! ($row->visibility == 1)? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-eye"></i> Visible</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-eye-slash"></i> Hidden</span>' !!}</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                    <td>{{ date('Y-m-d h:i:s A', strtotime($row->updated_at)) }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('services.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @endif
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Remove Product?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to remove <b><span id="tag_name"></span></b> Product?
                        <br/><small class="text-red category-alert"></small></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-delete-now">Remove Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content-wrapper -->
@endsection
