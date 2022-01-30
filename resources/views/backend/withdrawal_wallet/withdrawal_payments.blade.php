@extends('backend.layouts.admin')
@section('page_title','Withdrawal Payments')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Withdrawal Payments Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Withdrawal Payments</li>
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
                                <a href="{{ route('withdrawal-wallet.index') }}" class="btn btn-success btn-block">View Withdrawal Points</a>
                            </div>
                            <div class="btn-group">
                                <a href="" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Withdrawal Payments Details</h3>
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
                                        <th>Withdrawable Points</th>
                                        <th>Requested Points</th>
                                        <th>Approved Points</th>
                                        <th>Paid Withdrawal Fee</th>
                                        <th>Status</th>
                                        <th>Requested Date & Time</th>
                                        <th>Paid Amount</th>
                                        <th>Paid Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Withdrawal_points::where('status','Approved')->orWhere('status','Provided')->get()->count()>0)
                                        @foreach(\App\Withdrawal_points::where('status','Approved')->orWhere('status','Provided')->orderby('created_at','DESC')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td><a href="{{ route('partners.show', $row->user->id)}}">{{ $row->user->name." ".$row->user->last_name }}</a>
                                                    <br/>
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ getPointsFormat((getWithdrawalablePointsByAdmin($row->user->id)["total_Withdrawalable_points"])) }}</td>
                                                <td>{{ getPointsFormat($row->withdrawal_points) }}</td>
                                                <td>{{ getPointsFormat($row->withdrawal_points - ($row->fee_amount*\App\Details::where('key', 'points_rate')->first()->amount)) }}</td>
                                                <td>{{ getCurrencyFormat($row->fee_amount) }}</td>
                                                <td>
                                                    @if($row->status == "Requested")
                                                        <span class="badge badge-info">Requested</span>
                                                    @elseif($row->status == "Rejected")
                                                        <span class="badge badge-danger">Danger</span>
                                                    @elseif($row->status == "Approved")
                                                        <span class="badge badge-warning">Approved</span>
                                                    @elseif($row->status == "Provided")
                                                        <span class="badge badge-success">Paid</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>{{ ($row->amount)? getCurrencyFormat($row->amount) : "Not Paid" }}</td>
                                                <td>{{ $row->given_date? date('Y-m-d h:i:s A', strtotime($row->given_date)) : '-' }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('withdrawal-wallet.show.payments', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i> Review</a>
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
