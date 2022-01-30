@extends('backend.layouts.admin')
@section('page_title','Canceled Reservations')
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
                        <h1>Canceled Reservations</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Canceled Reservations</li>
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
                        <div class="margin" style="margin-bottom: 10px;">
                            <div class="btn-group">
                                <a href="{{ route('reservations.confirmed') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            {{--<div class="btn-group">--}}
                                {{--<button data-toggle="modal" data-target="#modal-bulk-delete"  class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete</button>--}}
                                {{--<form method="POST" id="delete-all-form"--}}
                                      {{--action="{{route('reservations.destroy_all')}}">--}}
                                    {{--@csrf--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Canceled Reservations</h3>
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
                                        <th>Patient</th>
                                        <th>Service Name</th>
                                        <th>Invoice No.</th>
                                        <th>Reservation Date & Time</th>
                                        <th>Status</th>
                                        <th>Canceled Date & Time</th>
                                        <th>Payment Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Service_booking::whereNull('is_deleted')->where('status','Canceled')->get()->count()>0)
                                        @foreach(\App\Service_booking::whereNull('is_deleted')->where('status','Canceled')->orderby('created_at','DESC')->get() as $row)
                                            <tr>
                                                <td width="5px">{{  ($loop->index+1) }}</td>
                                                <td>{{ isset($row->customer->name)? $row->customer->name." ".$row->customer->last_name : '-' }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ isset($row->service->name)?$row->service->name:'' }}</td>
                                                <td>{{ isset($row->book_reference)?"SSA/BK/".$row->book_reference:'' }}</td>
                                                <td>{{ date('D',strtotime($row->book_date)) }} {{ date('d M, Y',strtotime($row->book_date)) }} - {{ $row->book_time }}</td>
                                                <td>
                                                    @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($row->book_date)))
                                                        @if($row->status == "Completed")
                                                            <span class="badge badge-success">Completed</span>
                                                        @else
                                                            <span class="badge badge-danger">Expired</span>
                                                        @endif
                                                    @else
                                                        @if($row->status == "Pending")
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($row->status == "Confirmed")
                                                            <span class="badge badge-success">Confirmed</span>
                                                        @elseif($row->status == "Rejected")
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @elseif($row->status == "Canceled")
                                                            <span class="badge badge-danger">Canceled</span>
                                                        @elseif($row->status == "Completed")
                                                            <span class="badge badge-success">Completed</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ date('D', strtotime($row->canceled_date)) }} {{ date('Y-m-d h:i:s A', strtotime($row->canceled_date)) }}</td>
                                                <td>{{ date('D', strtotime($row->payment->created_at)) }} {{ date('Y-m-d h:i:s A', strtotime($row->payment->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('reservations.canceled.show', HashEncode($row->id))}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->customer->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('reservations.destroy',$row->id)}}">--}}
                                                            {{--@csrf--}}
                                                            {{--@method('DELETE')--}}
                                                        {{--</form>--}}
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
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete Reservations</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> reservations?
                        <br/><small class="text-red category-alert"></small></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-delete-now">Delete Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-bulk-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete All Reservations</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete all reservations?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-record-form').submit();">Delete All Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <form action="{{ route('admin.record.delete','reservations') }}" id="delete-record-form" method="POST"> @csrf</form>
@endsection
@push('script')
    <script>
        function invalid_msg() {
            swal.fire(
                {
                    type: 'info',
                    icon: "info",
                    title: '<span class="text-uppercase">Edit Operation Fail</span>',
                    text: 'You are unable to edit',
                    showConfirmButton: false,
                    timer: 2500
                }
            );
        }
        function expired_msg(){
            swal.fire(
                {
                    type: 'error',
                    icon: "error",
                    title: '<span class="text-uppercase">Reservation Expired!</span>',
                    text: 'Due to the reservation expired. You are unable to edit.',
                    showConfirmButton: false,
                    timer: 2500
                }
            );
        }
    </script>
@endpush
