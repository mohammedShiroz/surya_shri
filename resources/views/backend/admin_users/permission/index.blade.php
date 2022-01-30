@extends('backend.layouts.admin')
@section('page_title','Admin Permissions')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.alert')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Permissions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Admin Permissions</li>
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
                            @permission('create-permission')
                            <div class="btn-group">
                                <a href="{{ route('permission.create') }}" class="btn btn-info btn-block"><i class="fa fa-plus-circle"></i> Add a Permission</a>
                            </div>
                            @endpermission
                            <div class="btn-group">
                                <a href="{{ route('permission.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Admin Permission</h3>
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
                                        <th>Key</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created Date & Time</th>
                                        <th>Updated Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td><a href="{{route('permission.show',HashEncode($row->id))}}">{{$row->name}}</a></td>
                                            <td>{{$row->display_name}}</td>
                                            <td>{{$row->description}}</td>
                                            <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                            <td>{{ date('Y-m-d h:i:s A', strtotime($row->updated_at)) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{--<a href="{{ route('permission.show', HashEncode($row->id))}}" class="btn btn-success"><i class="fa fa-eye"></i></a>--}}
                                                    @permission('update-permission')
                                                    <a href="{{ route('permission.edit', HashEncode($row->id))}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                    @endpermission
                                                    {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                    {{--<form method="POST" id="{{'delete-form-'.$row->id}}" action="{{route('role.destroy',$row->id)}}">--}}
                                                    {{--@csrf @method('DELETE')--}}
                                                    {{--</form>--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
