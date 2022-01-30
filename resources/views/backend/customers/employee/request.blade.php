@extends('backend.layouts.admin')
@section('page_title','Employee Requests')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Requests</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Employee requests</li>
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
                                <a href="{{ route('partners.request') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Requested Users</h3>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Referral user</th>
                                        <th>Requested Date & Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\User::whereNull('is_deleted')->where('agent_status','Requested')->get()->count()>0)
                                        @foreach(\App\User::whereNull('is_deleted')->where('agent_status','Requested')->orderby('agent_request_date','desc')->get() as $row)
                                            <tr>
                                                <td>{{ $row->name }}
                                                    @if((new DateTime($row->agent_request_date))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->contact }}</td>
                                                <td>{{ "(".$row->ref_info->id.") - ".$row->ref_info->user->name }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->agent_request_date)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('partners.request.review', $row->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Review</a>
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
@endsection
