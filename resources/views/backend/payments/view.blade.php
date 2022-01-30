@extends('backend.layouts.admin')
@section('page_title','Payment Details')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@if(request()->routeIs('product-payments.*')) Sold
                            @elseif(request()->routeIs('service-payments.*')) Service
                            @elseif(request()->routeIs('seller-payments.*')) Seller @endif Payment Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Seller Payments</a></li>
                            <li class="breadcrumb-item active">
                                @if(request()->routeIs('product-payments.*')) Sold
                                @elseif(request()->routeIs('service-payments.*')) Service
                                @elseif(request()->routeIs('seller-payments.*')) Seller @endif Payment Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $data->partner->user->name }} PAYMENT DETAILS</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Paid Amount</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getCurrencyFormat($data->paid_amount) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Seller Or Doctor Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{$data->partner->user->name." ". $data->partner->user->last_name}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Payment Status</span>
                                    <span class="info-box-number text-center text-muted mb-0">{!! ($data->payment_status == "Success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-md-6 col-lg-6 col-sm-12">
                            <h6 class="text-secondary"><i class="fas fa-clipboard-list"></i> Order details</h6>
                            <hr style="margin-top: 10px;"/>
                            <div class="text-muted bg-light p-3">
                                <p class="text-sm">Order ID
                                    <strong class="d-block">{{ $data->order->id }}</strong>
                                </p>
                                <p class="text-sm">Order No.
                                    <strong class="d-block">SSA/PO/{{ $data->order->track_id }}</strong>
                                </p>
                                <p class="text-sm">Payment Method
                                    <b class="d-block text-uppercase">{{ ($data->order->payment_method == 'online_payment')? 'Card Payment' : 'Points Payment' }}</b>
                                </p>
                                <p class="text-sm">Paid Amount / Points
                                    <strong class="d-block text-uppercase">{{ ($data->order->payment_method == 'online_payment')? getCurrencyFormat($data->order->total) : getPointsFormat($data->order->payment->paid_points)." Points" }}</strong>
                                </p>
                                <p class="text-sm">Order date & time
                                    <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->order->created_at)) }} {{ date('d, M Y, h:i:s A', strtotime($data->order->created_at)) }}</strong>
                                </p>
                                <p class="text-sm">Order Status<br/>
                                    @if($data->order->status == "Pending")
                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                    @elseif($data->order->status == "Confirmed")
                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Confirmed</span>
                                    @elseif($data->order->status == "Rejected")
                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Rejected</span>
                                    @elseif($data->order->status == "Canceled")
                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Canceled</span>
                                    @endif
                                </p>
                                @if($data->order->confirmed_date)
                                    <p class="text-sm">Order confirmed date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->order->confirmed_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->order->confirmed_date)) }}</strong>
                                    </p>
                                @elseif($data->order->rejected_date)
                                    <p class="text-sm">Order rejected date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->order->rejected_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->order->rejected_date)) }}</strong>
                                    </p>
                                @elseif($data->order->canceled_date)
                                    <p class="text-sm">Order canceled date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->order->canceled_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->order->canceled_date)) }}</strong>
                                    </p>
                                @endif
                                <p class="text-sm">Delivery Status<br/>
                                    @if($data->order->delivery_status == "Pending")
                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                    @elseif($data->order->delivery_status == "Delivered")
                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Delivered</span>
                                    @elseif($data->order->delivery_status == "Not-delivered")
                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Not-delivered</span>
                                    @elseif($data->order->delivery_status == "Sending")
                                        <span class="badge badge-info pt-1 pl-3 pr-3 pb-1 radius_all_10">Sending</span>
                                    @elseif($data->order->delivery_status == "Hold")
                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Hold</span>
                                    @endif
                                </p>
                                @if($data->order->delivery_send_date)
                                    <p class="text-sm">Delivery send date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->order->Delivered)) }} {{ date('d, M Y, h:i:s A', strtotime($data->order->Delivered)) }}</strong>
                                    </p>
                                @endif
                                @if($data->order->delivery_date)
                                    <p class="text-sm">Delivered date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->order->delivery_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->order->delivery_date)) }}</strong>
                                    </p>
                                @endif
                                <hr>
                                <p class="text-sm"><strong>Additional Note</strong>
                                    <span class="text-muted d-block">{{ $data->order->customer->note? $data->order->customer->note: '-' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                            <h6 class="text-secondary"><i class="fas fa-user"></i> Seller Details</h6>
                            <hr style="margin-top: 10px;"/>
                            <ul class="list-unstyled bg-light p-3">
                                <li>
                                    <i class="fa fa-user mr-2"></i> {{ $data->partner->user->name? ("(".$data->partner->user->employee->id.") ".$data->partner->user->name." ".$data->partner->user->last_name) : 'Unknown' }}
                                </li>
                                <li>
                                    <i class="fa fa-phone-square mr-2"></i> {{ $data->partner->user->contact? $data->partner->user->contact : '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope mr-2"></i> {{ $data->partner->user->email? $data->partner->user->email: '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-globe mr-2"></i> {{ $data->partner->user->city? $data->partner->user->city.", " : '-'  }} {{ $data->partner->user->country? $data->partner->user->country : ''  }}
                                </li>
                            </ul>
                            <div class="mt-2">
                                <h6 class="mt-4 text-secondary"><i class="fas fa-clipboard-list"></i> Seller Payment Details</h6>
                                <hr style="margin-top: 10px;"/>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td width="25%"><strong>Amount:</strong></td>
                                        <td width="75%">{{  getCurrencyFormat($data->paid_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Status:</td>
                                        <td width="75%">{!! ($data->payment_status == "Paid")? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-check mr-1"></i> Amount Paid</span>': '<span class="badge badge-danger pl-3 pr-3">Pending</span>' !!}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-5 bg-light p-3 w-100" style="margin-top: 15px !important;">
                                <h5 class="pb-3 text-secondary text-uppercase"><i class="fas fa-user-cog mr-1"></i> Action</h5>
                                <div class="row">
                                    <div class="col-12">
                                        @if(request()->routeIs('seller-payments.*'))
                                            @if($data->payment_status == "Pending")
                                            <a href="{{ route('seller-payments.payment.paid',$data->id) }}"
                                               class="btn btn-success" style="margin-right: 5px;">
                                                <i class="fa fa-check mr-1"></i> Payment Done
                                            </a>
                                            @else
                                                <a href="{{ route('seller-payments.payment.pending',$data->id) }}"
                                                   class="btn btn-warning" style="margin-right: 5px;">
                                                    <i class="fa fa-refresh mr-1"></i> Set Pending
                                                </a>
                                            @endif
                                        @endif
                                        <a href="@if(request()->routeIs('product-payments.*')) {{ route('product-payments.index') }}
                                        @elseif(request()->routeIs('service-payments.*')) {{ route('service-payments.index') }}
                                        @elseif(request()->routeIs('seller-payments.*')) {{ route('seller-payments.index') }} @endif"
                                           class="btn btn-info" style="margin-right: 5px;">
                                            <i class="fa fa-long-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
