@extends('backend.layouts.admin')
@section('page_title','Activity Log Detail')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>{{ $data->admin->name }} - Activity Log Detail</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('activity-log.index') }}">Activity Log</a></li>
                            <li class="breadcrumb-item active">Activity log details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-tags pr-2"></i> Activity Type</h5>
                            <strong>{{ $data->log_name }}</strong>

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Description</h5>
                            <strong>{{ $data->description }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Admin Name</h5>
                            <strong>{{ $data->admin->name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-users pr-2"></i> Access Role</h5>
                            <Strong><span class="text-capitalize">Nan</span></Strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-calendar-alt pr-2"></i> Activity date & time</h5>
                            <strong>{{ date('Y-m-d h:i:s A',strtotime($data->created_at))." On ".date('l',strtotime($data->created_at)) }}</strong>
                        </div>
                    </div>
                </div><!-- /.row -->

                @if($data->properties)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Activity Subjects</h3>
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
                                        <th>Subject Name</th>
                                        <th>Subject Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(json_decode($data->properties, TRUE))
                                        @foreach(json_decode($data->properties, TRUE) as $k=>$row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td class="text-capitalize">{{ $k }}</td>
                                                <td>{{ $row }}</td>
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
                    @endif
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <!-- /.content-wrapper -->
    </div>
@endsection
