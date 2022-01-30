@extends('backend.layouts.admin')
@section('page_title','View'.$width_type.' Withdrawal Points Details')
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
                        <h1>{{ $width_type }} Withdrawal Points Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            @if($width_type == "Users")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.user') }}">Users Wallet Withdrawals</a></li>
                            @elseif($width_type == "Sellers")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.seller') }}">Sellers Wallet Withdrawals</a></li>
                            @elseif($width_type == "Doctors")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.doctors') }}">Doctors Wallet Withdrawals</a></li>
                            @elseif($width_type == "Site")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.site') }}">Site Wallet Withdrawals</a></li>
                            @elseif($width_type == "Global")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.global') }}">Global Wallet Withdrawals</a></li>
                            @elseif($width_type == "Bonus/Gift")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.gift') }}">Gift Wallet Withdrawals</a></li>
                            @elseif($width_type == "Donations")
                                <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.donations') }}">Donations Wallet Withdrawals</a></li>
                            @endif
                            <li class="breadcrumb-item active">{{ $width_type }} Withdrawal Points Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase">{{ $data->name." ".$data->last_name }} POINTS DETAILS</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Withdrawable Points</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ getPointsFormat((getWithdrawalablePointsByUser($data->id)["total_Withdrawalable_points"])) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total Withdrawn Points</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ getPointsFormat(getCalPointsByUser($data->id)['total_withdrawal_points']) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total Paid Amount</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ getCurrencyFormat(getCalPointsByUser($data->id)['total_withdrawal_paid']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="list-unstyled bg-light p-3">
                                <li>
                                    <i class="fa fa-user mr-2"></i> {{ $data->name? ($data->name." ".$data->last_name) : 'Unknown' }}
                                </li>
                                <li>
                                    <i class="fa fa-phone-square mr-2"></i> {{ $data->contact? $data->contact : '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope mr-2"></i> {{ $data->email? $data->email: '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-globe mr-2"></i> {{ $data->city? $data->city.", " : '-'  }} {{ $data->country? $data->country : ''  }}
                                </li>
                                <li>
                                    <i class="fas fa-user-shield mr-2"></i>{!! $data->employee? '<span class="text-success">Our Partner</span>' : 'Customer' !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase">Withdrawn POINTS DETAILS</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Requested Points</th>
                            <th>Status</th>
                            <th>Requested Date & Time</th>
                            <th>Paid Amount</th>
                            <th>Paid Date</th>
                            <th>Rejected Date</th>
                            <th>Rejected Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(\App\Withdrawal_points::where('user_id',$data->id)->count()>0)
                            @foreach(\App\Withdrawal_points::where('user_id',$data->id)->orderby('created_at','DESC')->get() as $row)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ getPointsFormat($row->withdrawal_points) }}</td>
                                    <td>
                                        @if($row->status == "Requested")
                                            <span class="badge badge-info">Requested</span>
                                        @elseif($row->status == "Rejected")
                                            <span class="badge badge-danger">Rejected</span>
                                        @elseif($row->status == "Approved")
                                            <span class="badge badge-warning">Approved</span>
                                        @elseif($row->status == "Provided")
                                            <span class="badge badge-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                    <td>{{ $row->amount? getCurrencyFormat($row->amount) : 'Not Paid' }}</td>
                                    <td>{{ $row->given_date? date('d, M Y, h:i:s A', strtotime($row->given_date)) : '-' }}</td>
                                    <td>{{ $row->rejected_at? date('d, M Y, h:i:s A', strtotime($row->rejected_at)) : '-' }}</td>
                                    <td>{{ $row->reject_description? $row->reject_description : '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('script')
@endpush
