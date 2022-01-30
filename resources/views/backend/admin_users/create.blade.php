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
                    <h1>Add a New Admin User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin-users.index') }}">Admin Users</a></li>
                        <li class="breadcrumb-item active">Add a New Admin User</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add a New Admin User Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" action="{{ route('admin-users.store') }}" method="Post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" autofocus value="{{ old('name')? old('name') : '' }}" required placeholder="Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Contact No.</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="contact" value="{{ old('contact')? old('contact') : '' }}" required placeholder="Contact No.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" value="{{ old('email')? old('email') : '' }}"  required name="email" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Designation</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="{{ old('job_title')? old('job_title') : '' }}" name="job_title" placeholder="Designation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Admin Role</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="role_id">
                                                    @foreach(\App\Role::all() as $row)
                                                    <option {{ old('role_id')? ((old('role_id') == $row->id)? 'selected': '') : ''}} value="{{ $row->id }}">{{ $row->display_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                <a href="{{ route('admin-users.index') }}" style="margin-right:5px;" class="btn btn-danger float-right">Cancel</a>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
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
