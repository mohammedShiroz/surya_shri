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
                        <h1>Add a Permission</h1>
                        <p class="text-muted mb-3">Permissions can be assigned to role of the system</p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permissions</a></li>
                            <li class="breadcrumb-item active">Add a Permissions</li>
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
                        <form action="{{ route('crud.permission') }}" method="post" class="form-horizontal" role="form">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Permission Details</h3>
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
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Permission Name</label>
                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus placeholder="Permission name">
                                            @error('name')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Display Permission Name</label>
                                            <input type="text" id="display_name" class="form-control @error('display_name') is-invalid @enderror" name="display_name" value="{{ old('display_name') }}" placeholder="Permission display name">
                                            @error('display_name')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="inputEmail3" class="col-form-label">Permission Description</label>
                                            <div class="input-group mb-3">
                                                <input type="text" id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" placeholder="Permission description">
                                            </div>
                                            @error('description')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-lg-7">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="crud">
                                                <label class="custom-control-label" for="crud">CRUD</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 pl-5">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" disabled name="create" class="custom-control-input crud"
                                                       id="create">
                                                <label class="custom-control-label" for="create">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 pl-5">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" disabled name="read" class="custom-control-input crud"
                                                       id="read">
                                                <label class="custom-control-label" for="read">Read</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 pl-5">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" disabled name="update" class="custom-control-input crud"
                                                       id="update">
                                                <label class="custom-control-label" for="update">Update</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 pl-5">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" disabled name="delete" class="custom-control-input crud"
                                                       id="delete">
                                                <label class="custom-control-label" for="delete">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 pull-right">
                                            <a href="" class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i> Reset</a>
                                            <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check-circle"></i> Save Changes</button>
                                            <a href="{{ route('permission.index') }}" class="btn btn-danger btn-flat"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
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
@push('script')
    <script>
        $('#crud').change(function () {
            if ($('#crud').is(":checked")) {
                $('.crud').attr("checked", true).attr('disabled', false);
                $('#display_name').attr('disabled', true);
                $('#description').attr('disabled', true);
            } else {
                $('.crud').attr("checked", false).attr('disabled', true);
                $('#display_name').attr('disabled', false);
                $('#description').attr('disabled', false);
            }
        });
    </script>
@endpush
