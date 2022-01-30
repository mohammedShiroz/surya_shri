@extends('backend.layouts.admin')
@section('page_title','View Admin User Details')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.alert')
@section('body_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="text-capitalize">{{ $data->name }} - Admin User Details</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin-users.index') }}">Admin Users</a></li>
                            <li class="breadcrumb-item active">View Admin User Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(session('active_tab')) @if(session()->get("active_tab")=='general_detail') active @endif @else active @endif"
                                           id="general_detail_tab" data-toggle="pill"
                                           href="#general_detail">General Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(session('active_tab') && session()->get("active_tab")=='activity_log_detail') active show @endif"
                                           id="permission_detail_tab" data-toggle="pill" href="#permission_detail">Activity Log</a>
                                    </li>
                                </ul>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content detail-list" id="pills-tabContent">
                            <div class="tab-pane fade @if(session('active_tab')) @if(session()->get("active_tab")=='general_detail') active show @endif @else show active @endif "
                                id="general_detail">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-user pr-2"></i> Name</h5>
                                                            <strong>{{ $data->name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-envelope pr-2"></i> Email</h5>
                                                            {!! $data->email !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-phone pr-2"></i> Contact No.</h5>
                                                            <strong>{{ ($data->contact)? $data->contact : '-' }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fas fa-user-shield pr-2"></i> Admin Role</h5>
                                                            <strong>{{ $data->role_user->role->display_name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fas fa-user-shield pr-2"></i> Admin Designation</h5>
                                                            <strong>{{ $data->job_title }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-calendar pr-2"></i> Created date & time</h5>
                                                            <strong>{{ date('Y-m-d h:i:s A', strtotime($data->created_at)) }}</strong>
                                                        </div>
                                                    </div>
                                                </div><!-- /.row -->
                                            </div><!--end card-body-->
                                        </div><!--end card-->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end general detail-->
                            <div
                                class="tab-pane fade @if(session('active_tab') && session()->get("active_tab")=='activity_log_detail') active show @endif"
                                id="permission_detail">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table w-100 table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Activity</th>
                                                        <th>Description</th>
                                                        <th>Activity Date & Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($data->activity->count()>0)
                                                        @foreach($data->activity as $row)
                                                            <tr>
                                                                <td>{{ $loop->index+1 }}</td>
                                                                <td>{{ $row->log_name  }}
                                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $row->description }}</td>
                                                                <td>{{ $row->created_at->diffForHumans() }}<br/>
                                                                    {{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a href="{{ route('activity-log.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end education detail-->
                        </div><!--end tab-content-->
                    </div><!--end col-->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
