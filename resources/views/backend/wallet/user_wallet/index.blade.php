@extends('backend.layouts.admin')
@section('page_title','Partner Wallet')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Partner Wallet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Partner Wallet</li>
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
                                <a href="{{ route('user-wallet.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Partner Points</h3>
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
                                        <th>Contact No.</th>
                                        <th>Partner Status</th>
                                        <th>Available Points</th>
                                        <th>Total Spent Points</th>
                                        <th>Total Withdrawal Points</th>
                                        <th>Total Refund Points</th>
                                        <th>Joined Date & Time</th>
                                        <th>Last Activity</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\User::whereNull('is_deleted')->whereNotNull('agent_id')->get()->count()>0)
                                        @foreach(\App\User::whereNull('is_deleted')->whereNotNull('agent_id')->orderby('created_at','asc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td><a href="{{ route('users.show', $row->id)}}">({{ isset($row->employee->id)? $row->employee->id : '' }}) {{ $row->name." ".$row->last_name }}</a>
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ $row->contact }}</td>
                                                <td>
                                                    @if(($row->is_doctor && $row->is_seller))
                                                        Doctor & Seller
                                                    @elseif($row->is_seller)
                                                        Seller
                                                    @elseif($row->is_doctor)
                                                        Doctor
                                                    @else
                                                        Partner
                                                    @endif
                                                </td>
                                                <td>{{ getPointsFormat(getFinalPointsByUser($row->id)["available_points"]) }}</td>
                                                <td>{{ getPointsFormat(getCalPointsByUser($row->id)["total_used_points"]) }}</td>
                                                <td>{{ getPointsFormat(getCalPointsByUser($row->id)["total_withdrawal_points"]) }}</td>
                                                <td>{{ getPointsFormat(getCalPointsByUser($row->id)["total_refund_points"]) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>{{ isset($row->activity->last()->created_at)? $row->activity->last()->created_at->diffForHumans() : '-' }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('user-wallet.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
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
