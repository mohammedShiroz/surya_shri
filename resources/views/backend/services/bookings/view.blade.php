@extends('backend.layouts.admin')
@section('page_title','Reservations Details')
@include('backend.components.plugins.alert')
@push('css') <style>.no-underline { text-decoration: none !important}</style> @endpush
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>{{ $data->user->name." ".$data->user->last_name }} Reservations Details</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            @if(request()->routeIs('reservations.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservations</a></li>
                            @elseif(request()->routeIs('reservations.pending.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.pending') }}">Pending Reservations</a></li>
                            @elseif(request()->routeIs('reservations.confirmed.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.confirmed') }}">Confirmed Reservations</a></li>
                            @elseif(request()->routeIs('reservations.canceled.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.canceled') }}">Canceled Reservations</a></li>
                            @elseif(request()->routeIs('reservations.rejected.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.rejected') }}">Rejected Reservations</a></li>
                            @elseif(request()->routeIs('reservations.expired.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.expired') }}">Expired Reservations</a></li>
                            @elseif(request()->routeIs('reservations.completed.show'))
                                <li class="breadcrumb-item"><a href="{{ route('reservations.completed') }}">Completed Reservations</a></li>
                            @endif
                            <li class="breadcrumb-item active">Reservations Details</li>
                        </ol>
                    </div>
                    <hr/>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header">
                                <h3 class="widget-user-username text-uppercase"><strong>{{ $data->service->name }}</strong></h3>
                                <h5 class="widget-user-desc"><small>{{ $data->service->category->name }}</small></h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="{{ (!empty($data->service->thumbnail_image)) ? asset($data->service->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" style="width:128px; height: 128px; " width="128px" height="128px" alt="{{ $data->service->thumbnail_image }}">
                            </div>
                            <div class="card-footer" style="padding-top: 100px">
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">
                                                @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                                    @if($data->status == "Completed")
                                                        <span class="badge badge-success">Completed</span>
                                                    @else
                                                        <span class="badge badge-danger">Expired</span>
                                                    @endif
                                                @else
                                                    @if($data->status == "Pending")
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($data->status == "Confirmed")
                                                        <span class="badge badge-success">Confirmed</span>
                                                    @elseif($data->status == "Rejected")
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @elseif($data->status == "Canceled")
                                                        <span class="badge badge-danger">Canceled</span>
                                                    @elseif($data->status == "Completed")
                                                        <span class="badge badge-success">Completed</span>
                                                    @endif
                                                @endif
                                            </h5>
                                            <span class="description-text">Status</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">{!! ($data->payment->payment_method == "online_payment")? getCurrencyFormat($data->payment->paid_amount): "(".getPointsFormat($data->payment->paid_points).") Points as <small>".getCurrencyFormat($data->price)."</small>" !!}</h5>
                                            <span class="description-text">Paid Amount</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">
                                                {!! ($data->payment->payment_status == "success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</h5>
                                            <span class="description-text">Payment Status</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    <div class="col-12">
                        @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-info-circle"></i> Expired!</h5>
                                Reservation has been expired On {{ date('D',strtotime($data->book_date)) }} {{ date('d M, Y',strtotime($data->book_date)) }}.
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><strong><i class="fa fa-bookmark-o pr-2 pb-2"></i> Booking Details </strong></h5>
                            <table class="table border pt-2  w-100">
                                <tr>
                                    <td width="35%"><b>Invoice No.</b></td>
                                    <td width="65%">SSA/BK/{{ $data->book_reference }}</td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Booked By</b></td>
                                    <td width="65%">({{ $data->user->id }}) {{ $data->user->name." ".$data->user->last_name }}</td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Booked Type</b></td>
                                    <td width="65%" title="Booked Type">{{ $data->type }}</td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Reservation Date & Time</b></td>
                                    <td width="65%" title="Scheduled Date & Time: {{$data->book_date}} {{ $data->book_time }}">On {{ date('l',strtotime($data->book_date)) }} {{ date('d M, Y',strtotime($data->book_date)) }} at {{ $data->book_time }}
                                    @if($data->old_book_date || $data->old_book_time) <sup class="badge badge-success">Modified by Admin</sup><br/>
                                        <del>On {{ date('l',strtotime($data->old_book_date)) }} {{ date('d M, Y',strtotime($data->old_book_date)) }} at {{ $data->old_book_date }}</del>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Booked Date & Time</b></td>
                                    <td width="65%" title="Booked Date & Time: {{ date('Y-F-d | h:i:s A', strtotime($data->created_at)) }}">On {{ date('l',strtotime($data->created_at)) }} {{ date('Y-m-d | h:i:s A', strtotime($data->created_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="callout callout-info">
                            <h5><strong><i class="fa fa-support pr-2 pb-2"></i> Service Details</strong></h5>
                            <table class="table border pt-2  w-100">
                                <tr>
                                    <td width="25%"><b>Service Name</b></td>
                                    <td width="75%"><a href="{{ route('services.show', $data->service->id)}}" target="_blank" class="text-info no-underline">{{ $data->service->name }}</a>
                                        @if($data->service->tag_code)<br/><small>({{ $data->service->tag_code }})</small>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>Service Duration</b></td>
                                    <td width="75%">{{ $data->service->duration_hour? $data->service->duration_hour."hr" : '' }} {{ $data->service->duration_minutes? $data->service->duration_minutes."min" : '' }}</td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>Available Days</b></td>
                                    <td width="75%">{{ ($data->service->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$data->service->week_days)) : '-' }}</td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>Service Charge</b></td>
                                    <td width="75%">{{ getCurrencyFormat($data->service->price) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="callout callout-info">
                            <h5><strong><i class="fas fa-money pr-2"></i> Payment Details</strong></h5>
                            <table class="table border pt-2  w-100">
                                <tr>
                                    <td width="30%"><b>Payment Type</b></td>
                                    <td width="70%" class="text-capitalize">{{ $data->payment->type }}</td>
                                </tr>
                                <tr>
                                    <td><b>Payment Method</b></td>
                                    <td>{{ ($data->payment->payment_method == "online_payment")? 'Online Payment' : 'Points Payment' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Transaction Code</b></td>
                                    <td>{{ $data->payment->transaction_id? $data->payment->transaction_id : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Paid</b></td>
                                    <td>{!! ($data->payment->payment_method == "online_payment")? getCurrencyFormat($data->payment->paid_amount): "(".getPointsFormat($data->payment->paid_points).") Points as <small>".getCurrencyFormat($data->payment->paid_points*1)."</small>" !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Payment Status</b></td>
                                    <td>{!! ($data->payment->payment_status == "success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Payment Signature</b></td>
                                    <td>{{ $data->payment->payment_signature }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><strong><i class="fas fa-user-tag pr-2"></i> Patient Details</strong></h5>
                            <table class="table border pt-2  w-100">
                                <tr>
                                    <td width="30%"><b>Patient</b></td>
                                    <td width="70%">{{ $data->customer->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Patient Email</b></td>
                                    <td>{{ $data->customer->email }}</td>
                                </tr>
                                <tr>
                                    <td><b>Contact No.</b></td>
                                    <td>{{ $data->customer->contact }}</td>
                                </tr>
                                <tr>
                                    <td><b>NIC/Passport Number</b></td>
                                    <td>{{ $data->customer->nic }}</td>
                                </tr>
                                <tr>
                                    <td><b>Additional Note</b></td>
                                    <td>{{ $data->customer->note }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="callout callout-info">
                            <h5><strong><i class="fas fa-user-tag pr-2"></i> Doctor Details</strong></h5>
                            <table class="table border pt-2  w-100">
                                <tr>
                                    <td width="30%"><b>Doctor Name & ID</b></td>
                                    <td width="70%">({{ $data->service->doctor->user->id }}) {{ $data->service->doctor->user->name." ".$data->service->doctor->user->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Doctor Email</b></td>
                                    <td>{{ $data->service->doctor->user->email }}</td>
                                </tr>
                                <tr>
                                    <td><b>Contact No.</b></td>
                                    <td>{{ $data->service->doctor->user->contact }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="callout callout-info">
                            <h5><strong><i class="fas fa-question-circle pr-2"></i> Additional Questions Details</strong></h5>
                            @if($data->customer->a_question_one)
                                <table class="table border pt-2  w-100">
                                    <tr>
                                        <td width="30%"><b>{{ $data->customer->a_question_one }}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="70%">{{ $data->customer->a_answer_one }}</td>
                                    </tr>
                                </table>
                            @endif
                            @if($data->customer->a_question_two)
                                <table class="table border pt-2  w-100">
                                    <tr>
                                        <td width="30%"><b>{{ $data->customer->a_question_two }}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="70%">{{ $data->customer->a_answer_two }}</td>
                                    </tr>
                                </table>
                            @endif
                            @if($data->customer->a_question_three)
                                <table class="table border pt-2  w-100">
                                    <tr>
                                        <td width="30%"><b>{{ $data->customer->a_question_three }}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="70%">{{ $data->customer->a_answer_three }}</td>
                                    </tr>
                                </table>
                            @endif
                            @if(!$data->customer->a_question_one && !$data->customer->a_question_two && !$data->customer->a_question_three)
                                <p>No result found!</p>
                            @endif
                        </div>
                        @if(\auth::user()->haspermission('read-reservation-notes') || \auth::user()->haspermission('create-reservation-notes'))
                        <div class="callout callout-info">
                            @permission('read-reservation-notes')
                            <h5><strong><i class="fas fa-edit pr-2 mb-2"></i> Admin Additional Note</strong></h5>
                            <div class="mb-5">
                                <table class="w-100 ">
                                    @foreach($data->notes as $row)
                                        <tr class="border mb-2">
                                            <td class="p-2">
                                                @if($row->is_deleted)
                                                    <del>{!! ($loop->index+1).". ".$row->additional."<br/>" !!}</del>
                                                @else
                                                    {!! ($loop->index+1).". ".$row->additional."<br/>" !!}
                                                @endif
                                            </td>
                                            @permission('delete-reservation-notes')
                                            <td class="p-2" align="right">
                                                @if(!$row->is_deleted)
                                                    <a href="{{ route('booking.delete.notes',$row->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                            @endpermission
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            @endpermission
                            @permission('create-reservation-notes')
                            <div class="mb-5">
                                <label>Add Additional Note</label>
                                <form action="{{ route('booking.add.notes') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $data->id }}" />
                                    <textarea class="form-control" name="additional" rows="3">{!! old('additional')? old('additional'): $data->additional !!}</textarea>
                                    @error('additional')
                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                    @enderror
                                    <button class="btn btn-info float-right ml-1 mt-2" type="submit">Save Changes</button>
                                </form>
                            </div>
                            @endpermission
                        </div>
                        @endif
                        <div class="callout callout-info">
                            <h5><strong><i class="fas {{ ($data->status == "Pending")? 'fa-spin fa-spinner mb-2' : 'fa-user-check mr-1 mb-2' }}"></i> Status Actions</strong></h5>
                            <table class="table border pt-2  w-100">
                                <tr>
                                    <td width="35%"><b>Booking Status</b></td>
                                    <td width="65%">
                                        @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                            @if($data->status == "Completed")
                                                <span class="badge badge-success pl-3 pr-3 pt-1 pb-1">Completed</span>
                                            @else
                                                <span class="badge badge-danger pl-3 pr-3 pt-1 pb-1">Expired</span>
                                            @endif
                                        @else
                                            @if($data->status == "Pending")
                                                <span class="badge badge-warning pl-3 pr-3 pt-1 pb-1">Pending</span>
                                            @elseif($data->status == "Confirmed")
                                                <span class="badge badge-success pl-3 pr-3 pt-1 pb-1">Confirmed</span>
                                            @elseif($data->status == "Rejected")
                                                <span class="badge badge-danger pl-3 pr-3 pt-1 pb-1">Rejected</span>
                                            @elseif($data->status == "Canceled")
                                                <span class="badge badge-danger pl-3 pr-3 pt-1 pb-1">Canceled</span>
                                            @elseif($data->status == "Completed")
                                                <span class="badge badge-success pl-3 pr-3 pt-1 pb-1">Completed</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                                    @if($data->status == "Confirmed")
                                    <tr>
                                        <td width="35%"><b>Confirmed Date & Time</b></td>
                                        <td width="65%" title="{{ date('Y-M-d | h:i:s A', strtotime($data->confirmed_date)) }}">On {{ date('l',strtotime($data->confirmed_date)) }} {{ date('Y-m-d | h:i:s A', strtotime($data->confirmed_date)) }}</td>
                                    </tr>
                                    @endif
                                    @if($data->status == "Rejected")
                                    <tr>
                                        <td width="35%"><b>Rejected Date & Time</b></td>
                                        <td width="65%" title="{{ date('Y-M-d | h:i:s A', strtotime($data->rejected_date)) }}">On {{ date('l',strtotime($data->rejected_date)) }} {{ date('Y-m-d | h:i:s A', strtotime($data->rejected_date)) }}</td>
                                    </tr>
                                    @endif
                                    @if($data->reject_reason)
                                        <tr>
                                            <td width="35%"><b>Reason for Rejection</b></td>
                                            <td width="65%" title="">{{ $data->reject_reason }}</td>
                                        </tr>
                                    @endif
                                    @if($data->status == "Canceled")
                                    <tr>
                                        <td width="35%"><b>Canceled Date & Time</b></td>
                                        <td width="65%" title="{{ date('Y-m-d | h:i:s A', strtotime($data->canceled_date)) }}">On {{ date('l',strtotime($data->canceled_date)) }} {{ date('Y-m-d | h:i:s A', strtotime($data->canceled_date)) }}</td>
                                    </tr>
                                    @endif
                            </table>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="d-block">
                                        <a class="btn btn-outline-secondary no-underline w-100"
                                           @if(request()->routeIs('reservations.show'))
                                           href="{{ route('reservations.index') }}"
                                           @elseif(request()->routeIs('reservations.pending.show'))
                                           href="{{ route('reservations.pending') }}"
                                           @elseif(request()->routeIs('reservations.confirmed.show'))
                                           href="{{ route('reservations.confirmed') }}"
                                           @elseif(request()->routeIs('reservations.canceled.show'))
                                           href="{{ route('reservations.canceled') }}"
                                           @elseif(request()->routeIs('reservations.rejected.show'))
                                           href="{{ route('reservations.rejected') }}"
                                           @elseif(request()->routeIs('reservations.expired.show'))
                                           href="{{ route('reservations.expired') }}"
                                           @elseif(request()->routeIs('reservations.completed.show'))
                                           href="{{ route('reservations.completed') }}"
                                            @endif
                                        >Back to Reservation</a>
                                        @permission('update-reservations')
                                        <form action="{{ route('reservations.completed.book',$data->id) }}" id="completed-form" method="POST">@csrf</form>
                                        @if(!\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                            @if($data->status == "Pending")
                                                <button class="btn btn-outline-success w-100 mt-2" onclick="confirm_book()">Confirm Reservation</button>
                                                <form action="{{ route('reservations.confirm.book',$data->id) }}" id="confirm-form" method="POST">@csrf</form>
                                                <button class="btn btn-outline-warning w-100 mt-2" onclick="cancel_book()">Cancel Reservation</button>
                                                <form action="{{ route('reservations.cancel.book',$data->id) }}" id="cancel-form" method="POST">@csrf</form>
                                            @endif
                                        @endif
                                        @if($data->status == "Confirmed" || \Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                            <button class="btn btn-outline-success w-100 ml-2" onclick="completed_book()">Completed Reservation</button>
                                        @endif
                                        @endpermission
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    @if(!\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                        @if($data->status == "Pending")
                                        <form id="reject-form" method="POST" action="{{ route('reservations.reject.book',[$data->user->id,$data->id]) }}">
                                            @csrf
                                            <textarea class="form-control d-block w-100 mb-1" id="reject_reason" name="reject_reason" row="3" placeholder="Reason for Rejection"></textarea>
                                            <button type="button" class="btn btn-danger btn-block w-100" onclick="reject_book()"><i class="fas fa-close"></i> Reject Reservation</button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            @push('script')
                                <script>
                                    function confirm_book(){
                                        swal.fire({
                                            title: "<span class='text-uppercase'>Confirm Reservation?<span>",
                                            text: "Are you sure want to confirm this reservation?",
                                            icon: "warning",
                                            type: 'warning',
                                            buttons: ["No", "Yes"],
                                            dangerMode: true,
                                            showCancelButton: true,
                                            confirmButtonText: 'Confirm',
                                            cancelButtonText: 'Cancel',
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.value) {
                                                swal.fire(
                                                    {
                                                        type: 'info',
                                                        icon: "warning",
                                                        title: 'Reservation Confirmed',
                                                        showConfirmButton: false,
                                                        timer: 1000
                                                    }
                                                );
                                                setTimeout(function () {
                                                    document.getElementById('confirm-form').submit();
                                                }, 1000);
                                            } else if (
                                                // Read more about handling dismissals
                                                result.dismiss === Swal.DismissReason.cancel
                                            ) {
                                                //TODO:: cancel function
                                            }
                                        });

                                    }

                                    function cancel_book(){
                                        swal.fire({
                                            title: "<span class='text-uppercase'>Cancel Reservation?<span>",
                                            text: "Are you sure want to cancel this reservation?",
                                            icon: "warning",
                                            type: 'warning',
                                            buttons: ["No", "Yes"],
                                            dangerMode: true,
                                            showCancelButton: true,
                                            confirmButtonText: 'Cancel Reservation',
                                            cancelButtonText: 'No',
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.value) {
                                                swal.fire(
                                                    {
                                                        type: 'info',
                                                        icon: "warning",
                                                        title: 'Reservation Canceled',
                                                        showConfirmButton: false,
                                                        timer: 1000
                                                    }
                                                );
                                                setTimeout(function () {
                                                    document.getElementById('cancel-form').submit();
                                                }, 1000);
                                            } else if (
                                                // Read more about handling dismissals
                                                result.dismiss === Swal.DismissReason.cancel
                                            ) {
                                                //TODO:: cancel function
                                            }
                                        });
                                    }

                                    function completed_book(){
                                        swal.fire({
                                            title: "<span class='text-uppercase'>Complete Reservation?<span>",
                                            text: "Are you sure want to complete this reservation?",
                                            icon: "warning",
                                            type: 'warning',
                                            buttons: ["No", "Yes"],
                                            dangerMode: true,
                                            showCancelButton: true,
                                            confirmButtonText: 'Completed',
                                            cancelButtonText: 'Cancel',
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.value) {
                                                swal.fire(
                                                    {
                                                        type: 'info',
                                                        icon: "warning",
                                                        title: 'Reservation Completed',
                                                        showConfirmButton: false,
                                                        timer: 1000
                                                    }
                                                );
                                                setTimeout(function () {
                                                    document.getElementById('completed-form').submit();
                                                }, 1000);
                                            } else if (
                                                // Read more about handling dismissals
                                                result.dismiss === Swal.DismissReason.cancel
                                            ) { }
                                        });

                                    }
                                    function reject_book(){
                                        if($("#reject_reason").val()) {

                                            swal.fire({
                                                title: "<span class='text-uppercase'>Reject Reservation?<span>",
                                                text: "Are you sure want to reject this reservation?",
                                                icon: "warning",
                                                type: 'warning',
                                                buttons: ["No", "Yes"],
                                                dangerMode: true,
                                                showCancelButton: true,
                                                confirmButtonText: 'Reject',
                                                cancelButtonText: 'Cancel',
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.value) {
                                                    swal.fire(
                                                        {
                                                            type: 'info',
                                                            icon: "warning",
                                                            title: 'Reservation Rejected',
                                                            showConfirmButton: false,
                                                            timer: 1000
                                                        }
                                                    );
                                                    setTimeout(function () {
                                                        document.getElementById('reject-form').submit();
                                                    }, 1000);
                                                } else if (
                                                    // Read more about handling dismissals
                                                    result.dismiss === Swal.DismissReason.cancel
                                                ) {
                                                    //TODO:: cancel function
                                                }
                                            });
                                        }else{
                                            swal.fire(
                                                {
                                                    type: 'info',
                                                    icon: "warning",
                                                    title: 'Required Reject Reason',
                                                }
                                            );
                                        }
                                    }
                                </script>
                            @endpush
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
