@extends('backend.layouts.admin')
@section('page_title','Notifications')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Notifications</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Notifications</li>
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
                                <a href="" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            {{--<div class="btn-group">--}}
                                {{--<button data-toggle="modal" data-target="#modal-bulk-delete"  class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete</button>--}}
                                {{--<form method="POST" id="delete-all-form" action="{{route('orders.destroy_all')}}">--}}
                                    {{--@csrf--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>

                        <div class="row">
                            <!-- /.col -->
                            @foreach(\App\Notifications::orderby('created_at','DESC')->limit(20)->get() as $row)
                                <div class="col-md-12 col-sm-12">
                                    <!-- Box Comment -->
                                    <div class="card card-widget">
                                        <div class="card-header">
                                            <div class="user-block">
                                                <img class="img-circle" src="{{ asset('administration/dist/img/bell.png') }}" alt="User Image">
                                                <span class="username">
                                                    @if($row->type == "App\Notifications\NewLogin")
                                                        Admin Login From New Device
                                                    @elseif($row->type == "App\Notifications\NewVisit")
                                                        Web Visit Notification
                                                    @elseif($row->type == "App\Notifications\NewUser")
                                                        New User Notification
                                                    @elseif($row->type == "App\Notifications\QuestionCompleted")
                                                        Questionnaire Completion Notification
                                                    @elseif($row->type == "App\Notifications\NewOrder")
                                                        Order Purchase Notification
                                                    @elseif($row->type == "App\Notifications\NewBooking")
                                                        Service Reservation Notification
                                                    @elseif($row->type == "App\Notifications\NewWithdrawal")
                                                        Withdrawal Request Notification
                                                    @elseif($row->type == "App\Notifications\NewVoucher")
                                                        Voucher Usage Notification
                                                    @elseif($row->type == "App\Notifications\NewFund")
                                                        Fund Transfer Notification
                                                    @elseif($row->type == "App\Notifications\NewDonation")
                                                        Donation Notification
                                                    @endif
                                                        @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                        @endif
                                                </span>
                                                <span class="description">{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }} - {{ $row->created_at->diffForHumans() }}</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="card-tools">
                                                {{--<button type="button" class="btn btn-tool" title="Mark as read">--}}
                                                    {{--<i class="far fa-circle"></i>--}}
                                                {{--</button>--}}
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- post text -->
                                            <p class="text-capitalize">You've a new
                                                @if($row->type == "App\Notifications\NewLogin")
                                                    Admin Login
                                                @elseif($row->type == "App\Notifications\NewVisit")
                                                    Web Visit Notification
                                                @elseif($row->type == "App\Notifications\NewUser")
                                                    New User Notification
                                                @elseif($row->type == "App\Notifications\QuestionCompleted")
                                                    Questionnaire Completion Notification
                                                @elseif($row->type == "App\Notifications\NewOrder")
                                                    Order Purchase Notification
                                                @elseif($row->type == "App\Notifications\NewBooking")
                                                    Service Reservation Notification
                                                @elseif($row->type == "App\Notifications\NewWithdrawal")
                                                    Withdrawal Request Notification
                                                @elseif($row->type == "App\Notifications\NewVoucher")
                                                    Voucher Usage Notification
                                                @elseif($row->type == "App\Notifications\NewFund")
                                                    Fund Transfer Notification
                                                @elseif($row->type == "App\Notifications\NewDonation")
                                                    Donation Notification
                                                @endif from

                                                @foreach(json_decode($row->data) as $key=>$val)
                                                    @if($row->type == "App\Notifications\NewLogin")
                                                        {{ isset($val->name)? $val->name : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewVisit")
                                                        {{ isset($val->ip)? $val->ip : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewUser")
                                                        @isset($val->id)
                                                            @isset(\App\User::find($val->id)->name)
                                                                \App\User::find($val->id)->name." ".\App\User::find($val->id)->last_name
                                                            @endisset
                                                        @endisset
                                                    @elseif($row->type == "App\Notifications\QuestionCompleted")
                                                        {{ isset($val->user_id)? \App\User::find($val->user_id)->name." ".\App\User::find($val->user_id)->last_name : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewOrder")
                                                        {{ isset($val->user_id)? \App\User::find($val->user_id)->name." ".\App\User::find($val->user_id)->last_name : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewBooking")
                                                        {{ isset($val->user_id)? \App\User::find($val->user_id)->name." ".\App\User::find($val->user_id)->last_name : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewWithdrawal")
                                                        {{ isset($val->user_id)? \App\User::find($val->user_id)->name." ".\App\User::find($val->user_id)->last_name : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewVoucher")
                                                        {{ isset($val->user_id)? \App\User::find($val->user_id)->name." ".\App\User::find($val->user_id)->last_name : '-' }}
                                                    @elseif($row->type == "App\Notifications\NewFund")
                                                        {{ isset($val->user_id)? \App\User::find($val->user_id)->name." ".\App\User::find($val->user_id)->last_name : '-' }}
                                                        TO
                                                        {{ isset($val->forward_user_id)? \App\User::find($val->forward_user_id)->name." ".\App\User::find($val->forward_user_id)->last_name : '' }}
                                                    @elseif($row->type == "App\Notifications\NewDonation")
                                                        {{ isset($val->agent_id)? \App\Agent::find($val->agent_id)->user->name." ".\App\Agent::find($val->agent_id)->user->last_name : '-' }}
                                                    @endif
                                                @endforeach
                                            </p>
                                            @if($row->read_at)
                                            <p class="mt-n3"><small>Read At {{ date('Y-m-d h:i:s A', strtotime($row->read_at)) }} - {{ $row->created_at->diffForHumans() }}</small></p>
                                            @endif
                                            <!-- Social sharing buttons -->
                                            <a
                                            @if($row->type == "App\Notifications\NewLogin")
                                                href="{{ route('activity-log.index') }}"
                                            @elseif($row->type == "App\Notifications\NewVisit")
                                                href="{{ route('site-visitors.index') }}"
                                            @elseif($row->type == "App\Notifications\NewUser")
                                                href="{{ route('users.index') }}"
                                            @elseif($row->type == "App\Notifications\QuestionCompleted")
                                                href="{{ route('submitted-questionnaires.index') }}"
                                            @elseif($row->type == "App\Notifications\NewOrder")
                                                href="{{ route('orders.pending') }}"
                                            @elseif($row->type == "App\Notifications\NewBooking")
                                                href="{{ route('reservations.index') }}"
                                            @elseif($row->type == "App\Notifications\NewWithdrawal")
                                                href="{{ route('withdrawal-wallet.requested') }}"
                                            @elseif($row->type == "App\Notifications\NewVoucher")
                                                href="{{ route('voucher-customers.index') }}"
                                            @elseif($row->type == "App\Notifications\NewFund")
                                                href="{{ route('user-wallet.index') }}"
                                            @elseif($row->type == "App\Notifications\NewDonation")
                                                href="{{ route('donation-wallet.index') }}"
                                            @endif
                                                class="btn btn-default btn-sm"><i class="fas fa-share"></i> View More</a>
                                            @if($row->read_at)
                                            <span class="float-right text-muted">Read by {{ \App\Admins::find($row->read_by)->name }}</span>
                                            @endif
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            @endforeach
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
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
