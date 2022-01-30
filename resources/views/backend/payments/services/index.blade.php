@extends('backend.layouts.admin')
@section('page_title','Service Payments')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service Payments</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="margin" style="margin-bottom: 10px;">
                            <div class="btn-group">
                                <a href="{{ route('service-payments.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                        </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Service Sales</h3>
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Service Name</th>
                                        <th>Invoice No.</th>
                                        <th>Invoice Value</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Paid Date&Time</th>
                                        {{--<th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Service_booking::whereNull('is_deleted')->get()->count()>0)
                                        @foreach(\App\Service_booking::whereNull('is_deleted')->orderby('created_at','DESC')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ isset($row->user->name)? ("(".$row->user->id.") ".$row->user->name." ".$row->user->last_name) : '-' }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ isset($row->service->name)?$row->service->name:'' }}</td>
                                                <td>{{ isset($row->book_reference)?"SSA/BK/".$row->book_reference:'' }}</td>
                                                <td>{!! ($row->payment->payment_method == "online_payment")? getCurrencyFormat($row->payment->paid_amount): "(".getPointsFormat($row->payment->paid_points).") Points as <small>".getCurrencyFormat($row->price)."</small>" !!}</td>
                                                <td><span class="text-capitalize">{{ $row->payment->payment_method }}</span> </td>
                                                <td>{!! ($row->payment->payment_status == "success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</td>
                                                <td>{{ date('D', strtotime($row->created_at)) }} {{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
