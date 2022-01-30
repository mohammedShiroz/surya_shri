@extends('backend.layouts.admin')
@section('page_title', 'Partner Hierarchy')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@push('css')
    <style>
        .pop-up-hover {
            transition: all 0.3s ease;
            z-index: 10000;
        }
        .pop-up-hover:hover {
            background: rgba(246, 246, 246, 0.3);
        }
        .pop-up-hover:hover > .pop-body {
            opacity: 1;
            padding-top: 15px;
            width: auto;
            height: auto;
        }
        .pop-body {
            opacity: 0;
            width: 0;
            height: 0;
            margin: auto;
            transition: all 0.3s ease;
        }
    </style>
@endpush
@php
    function getEmpInfo($id){ return \App\Agent::where('id', $id)->firstOrFail(); }
@endphp
@include('backend.components.plugins.hierarchy')
@section('body_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Partner Hierarchy</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Partner Hierarchy</li>
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
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="btn-group">
                                <a href="{{ route('partners.index') }}" class="btn btn-info"><i class="fa fa-backward mr-1"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">All Partner Hierarchy</h5>
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
                                    @php
                                        $emp_count =0;
                                        function numberOfPartners($id){
                                            global $emp_count;
                                            $emp_count =0;
                                            foreach (\App\Agent::Where('placement_id',$id)->get() as $emp){
                                                $emp_count++;
                                                if($emp->child_employees->isNotEmpty()){
                                                    show_emp($emp->child_employees);
                                                }
                                            }
                                            return $emp_count;
                                        }
                                        function show_emp($child_employees){
                                            global $emp_count;
                                            foreach($child_employees as $parent){
                                                $emp_count ++;
                                                if($parent->child_employees->isNotEmpty()){
                                                    show_emp($parent->child_employees);
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="genealogy-body genealogy-scroll">
                                        <div class="genealogy-tree">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <div class="member-view-box">
                                                            <div class="member-image">
                                                                <img src="{{ asset('assets/images/avatar.png') }}" alt="Member">
                                                                <div class="member-details">
                                                                    <h6 class="text-capitalize pop-up-hover">Company
                                                                        <div class="pop-body">
                                                                            <table class="table table-bordered table-striped">
                                                                                <tr>
                                                                                    <td align="left">Number of Partners </td>
                                                                                    <td align="right">{{ numberOfPartners(1) }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left">Total Commissions Earnings</td>
                                                                                    <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo(1)->user->id)["total_in_direct_points"]) }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left">Total Network Sales</td>
                                                                                    <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('user_id',getEmpInfo(1)->user->id)->get()->sum('paid_amount'))  }}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    @if(\App\Agent::Where('placement_id',1)->get()->count() > 0)
                                                        <ul class="active">
                                                            @foreach (\App\Agent::Where('placement_id',1)->get() as $emp)
                                                                <li>
                                                                    <a href="javascript:void(0);">
                                                                        <div class="member-view-box">
                                                                            <div class="member-image">
                                                                                <img src="{{ (!empty($emp->user->profile_image))? asset($emp->user->profile_image) : asset('assets/images/avatar.png') }}" alt="Member">
                                                                                <div class="member-details">
                                                                                    <h6 class="text-capitalize pop-up-hover">({{$emp->id}}) {{ getEmpInfo($emp->id)->user->name." ".getEmpInfo($emp->id)->user->last_name[0] }}
                                                                                        <div class="pop-body">
                                                                                            <table class="table table-bordered table-striped">
                                                                                                <tr>
                                                                                                    <td align="left">Number of Partners </td>
                                                                                                    <td align="right">{{ numberOfPartners($emp->id) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="left">Total Commissions Earnings</td>
                                                                                                    <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo($emp->id)->user->id)["total_in_direct_points"]) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="left">Total Network Sales</td>
                                                                                                    <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('user_id',getEmpInfo($emp->id)->user->id)->get()->sum('paid_amount'))  }}</td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    @if($emp->child_employees->isNotEmpty())
                                                                        @include('employee_dashboard.child_emp', [
                                                                            'child_employees' => $emp->child_employees
                                                                        ])
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
