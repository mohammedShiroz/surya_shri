@extends('backend.layouts.admin')
@section('page_title','Voucher Detail')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.jssocials')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>{{ $data->name }} - Voucher Detail</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
                            <li class="breadcrumb-item active">Voucher details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-tags pr-2"></i> Voucher Type</h5>
                            <strong>{{ $data->voucher_type }}</strong>

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Name</h5>
                            <strong>{{ $data->name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Code</h5>
                            <strong>{{ $data->code }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-eye pr-2"></i> Status</h5>
                            {!! ($data->status == 'Enabled')? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-check"></i> Enabled</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-times"></i> Disabled</span>' !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Discount Type</h5>
                            <span class="text-capitalize"><strong>{{ $data->discount_type }}</strong></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-money pr-2"></i> Discount</h5>
                            <strong>{{ ($data->discount_type == "price")? getCurrencyFormat($data->discount) : $data->discount."%" }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-money pr-2"></i> Minimum purchase</h5>
                            <strong>{{ $data->minimum_total? getCurrencyFormat($data->minimum_total) : '-' }}</strong>

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-users pr-2"></i> Number of Users</h5>
                            <strong>{{ $data->allowed_users? $data->allowed_users : 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-users pr-2"></i> Accept Type</h5>
                            <Strong><span class="text-capitalize">{{ $data->allow_type? $data->allow_type : '' }}</span></Strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-calendar-alt pr-2"></i> Expiry Date</h5>
                            <strong>{{ $data->expiry_date? date('Y-m-d',strtotime($data->expiry_date))." On ".date('l',strtotime($data->expiry_date)) : '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-calendar-alt pr-2"></i> Created date & time</h5>
                            <strong>{{ date('Y-m-d h:i:s A',strtotime($data->created_at))." On ".date('l',strtotime($data->created_at)) }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-user-check pr-2"></i> Voucher used count</h5>
                            <strong>{{ $data->customers->count() }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="d-inline-block p-3 w-100" style="border: 1px solid grey; border-radius: 5px;">
                            <p class="mb-n2">Share:</p>
                            <div id="shareIconsCount"></div>
                            <input type="hidden" id="social_share_url" value="{{ route('share_voucher_code',HashEncode($data->id))}}"/>
                            <input type="hidden" id="social_share_title" value="{{ env('APP_NAME') }} Voucher Code"/>
                            <input type="hidden" id="social_share_description" value="You can use this code to get discount."/>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-list-alt pr-2"></i> Description</h5>
                            <strong>{{ $data->description? $data->description : '' }}</strong>
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Used Customers</h3>
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
                                        <th>Invoice No.</th>
                                        <th>Redeemed Date & Time</th>
                                        {{--<th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($data->customers->count()>0)
                                        @foreach($data->customers as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>({{ $row->user->id }}) {{ $row->user->name }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                    @endif</td>
                                                <td>
                                                @if($row->order)
                                                    SSA/PO/{{ $row->order->track_id }}
                                                @elseif($row->booking)
                                                    SSA/BK/{{ $row->booking->book_reference }}
                                                @else
                                                    -
                                                @endif
                                                </td>
                                                <td>{{ date('Y-m-d h:i:s', strtotime($row->created_at)) }} On {{ date('l', strtotime($row->created_at)) }}</td>
                                                {{--<td align="center">--}}
                                                    {{--<div class="btn-group">--}}
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->user->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('voucher-customers.destroy',$row->id)}}">--}}
                                                            {{--@csrf--}}
                                                            {{--@method('DELETE')--}}
                                                        {{--</form>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
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
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <!-- /.content-wrapper -->
    </div>
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete Customer?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> customer?
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
@endsection
