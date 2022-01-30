@extends('backend.layouts.admin')
@section('page_title','Seller Payments')
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
                        <h1>Seller Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Seller Payments</li>
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
                                <a href="{{ route('seller-payments.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Seller Payments</h3>
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
                                        <th>Seller Name</th>
                                        <th>Order Invoice No.</th>
                                        <th>Product Name</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Sold Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Seller_payments::where('type','product')->whereNotNull('order_id')->get()->count()>0)
                                        @foreach(\App\Seller_payments::where('type','product')->whereNotNull('order_id')->orderby('created_at','desc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>({{ $row->partner->user->id }}) {{ $row->partner->user->name." ".$row->partner->user->last_name }}
                                                    <small class="d-block">( {{ ($row->partner->is_seller && $row->partner->is_doctor)? ' Doctor & Seller ' : (($row->partner->is_doctor)? 'Doctor' : 'Seller') }}) @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                        @endif
                                                    </small>
                                                </td>
                                                <td><a href="{{ route('orders.view', [$row->order_id, 'order_index']) }}">SSA/PO/{{ $row->order->track_id}}</a>
                                                    </td>
                                                <td>{{ $row->product->name }}</td>
                                                <td>{{ getCurrencyFormat($row->paid_amount) }}</td>
                                                <td>{!! ($row->payment_status == "Paid")? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-check"></i> Paid</span>': '<span class="badge badge-danger pl-3 pr-3">Pending</span>' !!}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('seller-payments.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </td>
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
