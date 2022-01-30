@extends('backend.layouts.admin')
@section('page_title','Vouchers')
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
                        <h1>Created Vouchers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Vouchers</li>
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
                            @permission('create-vouchers')
                            <div class="btn-group">
                                <a href="{{ route('vouchers.create') }}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Create a voucher</a>
                            </div>
                            @endpermission
                            <div class="btn-group">
                                <a href="{{ route('vouchers.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            {{--<div class="btn-group">--}}
                            {{--<button data-toggle="modal" data-target="#modal-bulk-delete"  class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete</button>--}}
                            {{--<form method="POST" id="delete-all-form" action="{{route('vouchers.destroy_all')}}">--}}
                            {{--@csrf--}}
                            {{--</form>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Created Vouchers</h3>
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
                                        <th>Name of Voucher</th>
                                        <th>Voucher Code</th>
                                        <th>Purpose</th>
                                        <th>No. of Created Vouchers</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Created Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Vouchers::WHERENULL('is_deleted')->get()->count()>0)
                                        @foreach(\App\Vouchers::WHERENULL('is_deleted')->orderby('created_at','desc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $row->name }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                    @endif</td>
                                                <td>{{ $row->code }}</td>
                                                <td>{{ $row->voucher_type }}</td>
                                                <td>{{ $row->allowed_users?$row->allowed_users:'N/A' }}</td>
                                                <td>@if($row->expiry_date){{ date('Y-m-d', strtotime($row->expiry_date)) }} On {{ date('l', strtotime($row->expiry_date)) }}@else <span class="text-center">-</span> @endif</td>
                                                <td>{!! ($row->status == 'Enabled')? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-check"></i> Enabled</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-times"></i> Disabled</span>' !!}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('vouchers.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                        @permission('update-vouchers')
                                                        <a href="{{ route('vouchers.edit', $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        @endpermission
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                        {{--action="{{route('vouchers.destroy',$row->id)}}">--}}
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
                    <h4 class="modal-title">Delete Vouchers?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> vouchers?
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
                    <h4 class="modal-title">Delete All Vouchers</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete all vouchers?</p>
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
    <form action="{{ route('admin.record.delete','vouchers') }}" id="delete-record-form" method="POST"> @csrf</form>
@endsection
