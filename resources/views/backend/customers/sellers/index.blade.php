@extends('backend.layouts.admin')
@section('page_title','Sellers')
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
                        <h1>Sellers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sellers</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @permission('create-sellers')
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Add Seller</h5>
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
                                <form class="form-horizontal" action="{{ route('sellers.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label class="col-form-label">Partners</label>
                                            <select class="form-control select2 @error('agent_id') is-invalid @enderror" name="agent_id" style="width: 100%;">
                                                <option disabled selected>Select Partner to add as a Seller</option>
                                                @foreach(\App\Agent::WHERENULL('is_seller')->ORDERBY('created_at','DESC')->get() as $row)
                                                    <option value="{{ $row->id }}" {{ (old('agent_id'))? (($row->id == old('agent_id'))? 'selected': '') : '' }}>({{ $row->id }}) - {{ $row->user->name." ".$row->user->last_name[0] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success btn-sm pull-right ml-2">Approve</button>
                                            <a href="{{ route('sellers.index') }}" class="btn btn-info btn-sm pull-right">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                    @endpermission
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="margin" style="margin-bottom: 10px;">
                            <div class="btn-group">
                                <a href="{{ route('sellers.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Sellers</h3>
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
                                        <th>Type</th>
                                        <th>Email</th>
                                        <th>Last Activity</th>
                                        <th>Contact No</th>
                                        <th>No. of Listings</th>
                                        <th>Registered Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Agent::whereNotNull('is_seller')->get()->count()>0)
                                        @foreach(\App\Agent::whereNotNull('is_seller')->orderby("is_seller",'desc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>({{ $row->user->employee->id }}) {{ $row->user->name }} {{ $row->user->last_name }}
                                                    @if((new DateTime($row->is_seller))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                    @endif
                                                </td>
                                                <td><span class="badge badge-{{ ($row->is_doctor && $row->is_seller)? 'success' : (($row->is_seller)? 'info': 'info') }}">{{ ($row->is_doctor && $row->is_seller)? 'Doctor & Seller' : (($row->is_seller)? 'Seller': 'Doctor') }}</span></td>
                                                <td>{{ $row->user->email }}</td>
                                                <td>{{ isset($row->user->activity->last()->created_at)? $row->user->activity->last()->created_at->diffForHumans() : '-' }}</td>
                                                <td>{{ $row->user->contact }}</td>
                                                <td>
                                                    @if($row->is_doctor && $row->is_seller)
                                                        {{$row->services->count()}} Service<br/>{{$row->products->count()}} Product
                                                    @elseif($row->is_seller)
                                                        {{ $row->products->count() }} Products
                                                    @endif
                                                </td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime(($row->is_seller)? $row->is_seller : $row->is_doctor)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('sellers.show', $row->user->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Details</a>
                                                        {{--<button type="button" class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->user->name }}')"><i class="fas fa-trash-alt"></i> Remove</button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('sellers.destroy',$row->id)}}">--}}
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
                    <h4 class="modal-title">Remove Doctor/Seller?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to remove <b><span id="tag_name"></span></b> doctor/seller?
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
