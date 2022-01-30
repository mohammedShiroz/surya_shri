@extends('backend.layouts.admin')
@php $route_type =null;
    if(request()->routeIs('user-points.*')){ $route_type = "User Wallet Point"; }
    elseif(request()->routeIs('user-wallet.*')){ $route_type = "Partner Wallet"; }
    elseif(request()->routeIs('global-wallet.*')){ $route_type = "Global Wallet"; }
    elseif(request()->routeIs('site-wallet.*')){ $route_type = "Site Wallet"; }
    elseif(request()->routeIs('bonus-wallet.*')){ $route_type = "Bonus Wallet"; }
@endphp
@section('page_title', $route_type)
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
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
                        <h1>{{ $route_type }} Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $route_type }} Details</li>
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
                                <h3 class="profile-username text-center text-uppercase">{{ $data->name." ".$data->last_name }}</h3>
                                <p class="text-muted text-center" style="margin-top: -10px;">{{ $data->email }}</p>
                                <ul class="list-group list-group-unbordered mb-3">
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
                                </ul>
                                <a href="@if(request()->routeIs('user-points.*'))
                                            {{ route('user-points.index') }}
                                         @elseif(request()->routeIs('user-wallet.*'))
                                        {{ route('user-wallet.index') }}
                                        @else {{ route('user-points.index') }} @endif" class="btn btn-info btn-block"><b>Back</b></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        {{--If partner requested to join future edit--}}
                        <div class="card card-info card-outline">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#points" data-toggle="tab">Points Details</a></li>
                                    @if(request()->routeIs('user-wallet.*'))
                                        <li class="nav-item"><a class="nav-link" href="#points_commission" data-toggle="tab">Summary Details</a></li>
                                    @endif
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane active" id="points">
                                        <div class="card-body" style="padding: 0 !important;">
                                            <!-- START SECTION WHY CHOOSE -->
                                            <div class="pt-5">
                                                @if($route_type == "User Wallet Point")
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
                                                                        <h5>{{ getPointsFormat((getWithdrawalablePointsByUser($data->id)["total_Withdrawalable_points"])) }}</h5>
                                                                        <p>Total Withdrawable Points</p>
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
                                                                        <p>Total Withdrawn Points</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6 mt-5">
                                                                <div class="icon_box icon_box_style4">
                                                                    <div class="icon">
                                                                        <i class="fas fa-coins"></i>
                                                                    </div>
                                                                    <div class="icon_box_content">
                                                                        <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_refund_points"]) }}</h5>
                                                                        <p>Points</p>
                                                                        <p class="mt-n4"><small>(product or service refunds)</small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
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
                                                    <div class="row justify-content-center text-center mt-4">
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
                                                                    <p>Points</p>
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
                                                                    <h5>{{ getPointsFormat((getWithdrawalablePointsByAdmin($data->id)["total_Withdrawalable_points"])) }}</h5>
                                                                    <p>Total Withdrawable Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6 mt-5">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_withdrawal_points"]) }}</h5>
                                                                    <p>Total Withdrawn Points</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6 mt-5">
                                                            <div class="icon_box icon_box_style4">
                                                                <div class="icon">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                                <div class="icon_box_content">
                                                                    <h5>{{ getPointsFormat(getCalPointsByUser($data->id)["total_seller_earn_points"]) }}</h5>
                                                                    <p>Total Earn From Products</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <!-- END SECTION WHY CHOOSE -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    @if(request()->routeIs('user-wallet.*'))
                                        <div class="tab-pane" id="points_commission">
                                            <div class="card-body" style="padding: 0 !important;">
                                                <table id="example1" class="table table-bordered table-striped w-100">
                                                    <thead>
                                                    <tr>
                                                        <th>Invoice No.</th>
                                                        <th>Type</th>
                                                        <th>Product/Service Name</th>
                                                        <th>Commission Points</th>
                                                        <th>Date & Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(\App\Points_Commission::where('user_id',$data->id)->where('type','User')->get()->count()>0)
                                                        @foreach(\App\Points_Commission::where('user_id',$data->id)->where('type','User')->orderby('created_at','asc')->get() as $row)
                                                            <tr>
                                                                <td>
                                                                    @if($row->order)
                                                                    <a href="{{ route('orders.view', [$row->order->id, 'order_index']) }}">SSA/PO/{{ $row->order->track_id}}</a>
                                                                    @elseif($row->booking)
                                                                        <a href="{{ route('reservations.show', $row->booking->id)}}">{{ isset($row->booking->book_reference)? "SSA/BK/".$row->booking->book_reference:'' }}</a>
                                                                    @endif
                                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                        <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($row->order)
                                                                        Order
                                                                    @elseif($row->booking)
                                                                        Reservation
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($row->order)
                                                                        {{ $row->product->name }}
                                                                    @elseif($row->booking)
                                                                        {{ isset($row->booking->service->name)?$row->booking->service->name:'' }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ getPointsFormat($row->commission_points) }}</td>
                                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- /.tab-content -->
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
