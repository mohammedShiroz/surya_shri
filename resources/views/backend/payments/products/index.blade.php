@extends('backend.layouts.admin')
@section('page_title','Sold Payments')
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
                        <h1>Product Sales</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Sales</li>
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
                                <a href="{{ route('product-payments.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Product Sales</h3>
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
                                        <th>Invoice Value</th>
                                        <th>Product Name</th>
                                        <th>Seller Name & ID</th>
                                        <th>Buyer Name & ID</th>
                                        <th>Item Count.</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Payment Date & Time</th>
                                        <th>Sold Date & Time</th>
                                        {{--<th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Orders::WhereNull('is_deleted')->where('payment_status','Success')->where('status','confirmed')->get()->count()>0)
                                        @foreach(\App\Orders::WhereNull('is_deleted')->where('payment_status','Success')->where('status','confirmed')->orderby('created_at','desc')->get() as $row)
                                            @foreach($row->items as $row_item)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td><a href="{{ route('orders.view', [$row->id, 'order_index']) }}">SSA/PO/{{ $row->track_id}}</a>
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                    @endif</td>
                                                <td>{{ $row_item->product->name }}</td>
                                                <td>({{ $row_item->product->seller_info->user->id }}) {{ $row_item->product->seller_info->user->name." ".$row_item->product->seller_info->user->last_name }}
                                                    <small class="d-block">( {{ ($row_item->product->seller_info->is_seller && $row_item->product->seller_info->is_doctor)? ' Doctor & Seller ' : (($row_item->product->seller_info->is_doctor)? 'Doctor' : 'Seller') }})</small>
                                                </td>
                                                <td>({{ $row->user->id }}) {{ $row->user->name." ".$row->user->last_name }}
                                                </td>
                                                <td>{{ $row_item->qty }}</td>
                                                <td>{{ getCurrencyFormat($row_item->sub_total) }}</td>
                                                <td>@if($row->payment_status == "Success")
                                                        <span class="badge badge-success pl-3 pr-3"><i class="fa fa-check"></i> Paid</span>
                                                    @else
                                                        <span class="badge badge-danger pl-3 pr-3">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-capitalize">{{ str_replace('_',' ',$row->payment->payment_method) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->payment->created_at)) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row_item->created_at)) }}</td>
                                                {{--<td>--}}
                                                    {{--<div class="btn-group">--}}
                                                        {{--<a href="{{ route('product-payments.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
                                            </tr>
                                            @endforeach
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
