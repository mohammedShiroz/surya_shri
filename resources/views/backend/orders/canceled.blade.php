@extends('backend.layouts.admin')
@section('page_title','Confirmed Orders')
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
                        <h1>Canceled Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                            <li class="breadcrumb-item active">Canceled Orders</li>
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
                                <a href="{{ route('orders.canceled') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Canceled Order Details</h3>
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
                                        <th>Order ID.</th>
                                        <th>Invoice No.</th>
                                        <th>Buyer</th>
                                        <th>No. of Products</th>
                                        <th>Invoice Value</th>
                                        <th>Order Status</th>
                                        <th>Delivery Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Orders::WhereNull('is_deleted')->where('status','Canceled')->get()->count()>0)
                                        @foreach(\App\Orders::WhereNull('is_deleted')->where('status','Canceled')->orderby('created_at','DESC')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $row->id }}</td>
                                                <td>SSA/PO/{{ $row->track_id}}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info" style="font-size: 8px">New</small>
                                                    @endif</td>
                                                <td>({{ $row->user->id }}) {{ $row->user->name." ".$row->user->last_name }}</td>
                                                <td align="center">{{ $row->items->count() }}</td>
                                                <td>{{ $row->total.".00" }}</td>
                                                <td align="center">
                                                    @if($row->status == "Pending")
                                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                                    @elseif($row->status == "Confirmed")
                                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Confirmed</span>
                                                    @elseif($row->status == "Rejected")
                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Rejected</span>
                                                    @elseif($row->status == "Canceled")
                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Canceled</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if($row->delivery_status == "Pending")
                                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                                    @elseif($row->delivery_status == "Delivered")
                                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Delivered</span>
                                                    @elseif($row->delivery_status == "Not-delivered")
                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Not-delivered</span>
                                                    @elseif($row->delivery_status == "Sending")
                                                        <span class="badge badge-info pt-1 pl-3 pr-3 pb-1 radius_all_10">Sending</span>
                                                    @elseif($row->delivery_status == "Hold")
                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Hold</span>
                                                    @elseif($row->delivery_status == "Self-Pickup")
                                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Self-Pickup</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                <td align="center">
                                                    <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Refunded Paid</span>
                                                </td>
                                                </td>
                                                <td>{{ date('d, M Y, h:i:s A', strtotime($row->payment->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('orders.view', [HashEncode($row->id), 'order_canceled']) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                        {{--<a href="{{ route('orders.edit', $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>--}}
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','SSA/PO/{{ $row->track_id }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                        {{--action="{{route('orders.destroy',$row->id)}}">--}}
                                                        {{--@csrf--}}
                                                        {{--@method('DELETE')--}}
                                                        {{--</form>--}}
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
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete Order?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> Order?
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
