@extends('backend.layouts.admin')
@section('page_title','Voucher customers')
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
                        <h1>Used Vouchers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Used Vouchers</li>
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
                                <a href="{{ route('voucher-customers.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            {{--<div class="btn-group">--}}
                                {{--<button data-toggle="modal" data-target="#modal-bulk-delete"  class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete</button>--}}
                                {{--<form method="POST" id="delete-all-form" action="{{route('voucher-customers.destroy_all')}}">--}}
                                    {{--@csrf--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Used Vouchers</h3>
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
                                        <th>User Name & ID</th>
                                        <th>Done By</th>
                                        <th>Voucher Name</th>
                                        <th>Voucher Type</th>
                                        <th>Voucher Code</th>
                                        <th>Invoice No.</th>
                                        <th>Used Count</th>
                                        <th>Created Date & Time</th>
                                        <th>Redeemed Date & Time</th>
                                        {{--<th>Actions</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Voucher_customers::all()->count()>0)
                                        @foreach(\App\Voucher_customers::groupBy('user_id', 'voucher_id')->orderby('created_at','desc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>({{ $row->user->id }}) {{ $row->user->name." ".$row->user->last_name }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                    @endif</td>
                                                <td>@if($row->order_id)
                                                        Product Order
                                                    @else
                                                        Service Reservation
                                                    @endif
                                                </td>
                                                <td><a href="{{ route('vouchers.show', $row->voucher->id)}}">{{ $row->voucher->name }}</a></td>
                                                <td>{{ $row->voucher->voucher_type }}</td>
                                                <td>{{ $row->voucher->code }}</td>
                                                <td>@if($row->order_id)
                                                        {{  "SSA/PO/".$row->order->track_id }}
                                                    @elseif($row->booking)
                                                        {{  "SSA/BK/".$row->booking->book_reference }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td align="center">{{ \App\Voucher_customers::where('user_id',$row->user_id)->where('voucher_id',$row->voucher_id)->get()->count() }}</td>
                                                <td>{{ date('Y-m-d h:i:s', strtotime($row->voucher->created_at)) }} On {{ date('l', strtotime($row->voucher->created_at)) }}</td>
                                                <td>{{ date('Y-m-d h:i:s', strtotime($row->created_at)) }} On {{ date('l', strtotime($row->created_at)) }}</td>
                                                {{--<td align="center">--}}
                                                    {{--<div class="btn-group">--}}
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->user->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('voucher-customers.destroy',$row->id)}}">--}}
                                                            {{--@csrf--}}
                                                            {{--@method('DELETE')--}}
                                                        {{--</form>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
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
                    <h4 class="modal-title">Delete Customer?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> customer?
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
    <div class="modal fade" id="modal-bulk-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete All Customers</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete all customers?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-record-form').submit();">Delete All Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <form action="{{ route('admin.record.delete','voucher-customers') }}" id="delete-record-form" method="POST"> @csrf</form>
@endsection
