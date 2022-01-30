@extends('backend.layouts.admin')
@section('page_title','Admin User Management')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Admin Users</li>
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
                            @permission('create-admin')
                            <div class="btn-group">
                                <a href="{{ route('admin-users.create') }}" class="btn btn-primary btn-block"><i class="fa fa-plus-circle"></i> Add a Admin User</a>
                            </div>
                            @endpermission
                            <div class="btn-group">
                                <a href="{{ route('admin-users.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Administrative Users</h3>
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
                                        <th>Admin Name</th>
                                        <th>Email</th>
                                        <th>Contact No.</th>
                                        <th>Admin Role</th>
                                        <th>Designation</th>
                                        <th>Created Date & Time</th>
                                        <th>Updated Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data)>0)
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $row->name }}
                                                    @if($row->id != 1)
                                                        @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                        @endif
                                                    @else
                                                        <small class="badge badge-success text-white ml-1" style="font-size: 9px;">Primary</small>
                                                    @endif
                                                </td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->contact }}</td>
                                                <td>{{ $row->role_user->role->display_name }}</td>
                                                <td>{{ $row->job_title }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->updated_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin-users.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                        @permission('update-admin')
                                                        <a href="{{ route('admin-users.edit', $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        @endpermission
                                                        {{--@if($row->id != 1)--}}
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('admin-users.destroy',$row->id)}}">--}}
                                                            {{--@csrf--}}
                                                            {{--@method('DELETE')--}}
                                                        {{--</form>--}}
                                                        {{--@endif--}}
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
                    <h4 class="modal-title">Delete User?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> User?
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
@endsection
