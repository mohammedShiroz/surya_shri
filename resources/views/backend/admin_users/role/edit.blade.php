@extends('backend.layouts.admin')
@section('page_title','Add A Roles')
@include('backend.components.plugins.alert')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit {{ $data->name }} Admin Role</h1>
                        <p class="text-muted mb-3">Roles can be assigned to admin users of the system</p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                            <li class="breadcrumb-item active">Edit Role</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('role.update',HashEncode($data->id)) }}" method="post" class="form-horizontal" role="form">
                            @method('put')
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Role Details</h3>
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
                                    <div class="form-group row">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Role Name</label>
                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')? old('name') : $data->name }}" autofocus placeholder="Role name">
                                            @error('name')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Display Role Name</label>
                                            <input type="text" id="display_name" class="form-control @error('display_name') is-invalid @enderror" name="display_name" value="{{ old('display_name') ? old('display_name') : $data->display_name }}" placeholder="Role display name">
                                            @error('display_name')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="inputEmail3" class="col-form-label">Role Description</label>
                                            <div class="input-group mb-3">
                                                <input type="text" id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') ? old('description') : $data->description  }}" placeholder="Role description">
                                            </div>
                                            @error('description')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 pull-right">
                                            <a href="" class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i> Reset</a>
                                            <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check-circle"></i> Save Changes</button>
                                            <a href="{{ route('role.index') }}" class="btn btn-danger btn-flat"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </form>
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
@push('script')
    <script>
        $('#name').keyup(function () {
            $('#display_name').val(this.value.toUpperCase());
            $('#description').val(this.value.toUpperCase());
        });
    </script>
@endpush
