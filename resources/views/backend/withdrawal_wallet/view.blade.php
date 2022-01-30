@extends('backend.layouts.admin')
@section('page_title','View Withdrawal Points Details')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Withdrawal Points Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.requested') }}">Withdrawal Points Request</a></li>
                            <li class="breadcrumb-item active">Withdrawal Points Details</li>
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
                    <h3 class="card-title text-uppercase">{{ $data->user->name." ".$data->user->last_name }} POINTS DETAILS</h3>
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
                        <div class="col-12 col-md-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Withdrawable Points</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getPointsFormat((getWithdrawalablePointsByAdmin($data->user->id)["total_Withdrawalable_points"])) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Requested Points</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getPointsFormat($data->withdrawal_points) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Paid Withdrawal Fees</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getPointsFormat(($data->fee_amount*\App\Details::where('key', 'points_rate')->first()->amount)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted"><strong>Payable Points</strong></span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getPointsFormat($data->withdrawal_points - ($data->fee_amount*\App\Details::where('key', 'points_rate')->first()->amount)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Paid Amount</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getCurrencyFormat($data->amount) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Status</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $data->status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-md-12 col-lg-12">
                            <h5 class="pb-3 text-secondary text-uppercase"><i class="fas fa-coins"></i> User Points Details</h5>
                            <div class="card-body" style="padding: 0 !important;">
                                <!-- START SECTION WHY CHOOSE -->
                                <div class="pt-5">
                                    @if(! $data->user->employee)
                                        <div class="container">
                                            <div class="row justify-content-center text-center">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getFinalPointsByUser($data->user->id)["available_points"]) }}</h5>
                                                            <p>Available Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_used_points"]) }}</h5>
                                                            <p>Total Spent Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat((getWithdrawalablePointsByAdmin($data->user->id)["total_Withdrawalable_points"])) }}</h5>
                                                            <p>Total Withdrawable Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_withdrawal_points"]) }}</h5>
                                                            <p>Total Withdrawn Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 mt-5">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_refund_points"]) }}</h5>
                                                            <p>Points</p>
                                                            <p class="mt-n4"><small>(product or service refunds)</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="container">
                                            <div class="row justify-content-center text-center">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getFinalPointsByUser($data->user->id)["available_points"]) }}</h5>
                                                            <p>Available Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat((getCalPointsByUser($data->user->id)["total_direct_points"] + getCalPointsByUser($data->user->id)["total_in_direct_points"]) - getCalPointsByUser($data->user->id)["total_transferred_points"] - getCalPointsByUser($data->user->id)["pending_withdrawal_points"] - getCalPointsByUser($data->user->id)["total_withdrawal_points"]) }}</h5>
                                                            <p>Transferable Point </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_transferred_points"]) }}</h5>
                                                            <p>Sent Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_credited_points"]) }}</h5>
                                                            <p>Received Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center text-center mt-4">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_in_direct_points"]) }}</h5>
                                                            <p>Seller Network Earnings</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_refund_points"]) }}</h5>
                                                            <p>Points</p>
                                                            <p class="mt-n4"><small>(product or service refunds)</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_used_points"]) }}</h5>
                                                            <p>Total Spent Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat((getWithdrawalablePointsByAdmin($data->user->id)["total_Withdrawalable_points"])) }}</h5>
                                                            <p>Total Withdrawable Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 mt-5">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_withdrawal_points"]) }}</h5>
                                                            <p>Total Withdrawn Points</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 mt-5">
                                                    <div class="icon_box icon_box_style4">
                                                        <div class="icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="icon_box_content">
                                                            <h5>{{ getPointsFormat(getCalPointsByUser($data->user->id)["total_seller_earn_points"]) }}</h5>
                                                            <p>Total Earn From Products</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- END SECTION WHY CHOOSE -->
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-user"></i> User Details</h6>
                            <hr style="margin-top: 10px;"/>
                            <ul class="list-unstyled bg-light p-3">
                                <li>
                                    <i class="fa fa-user mr-2"></i> {{ $data->user->name? ($data->user->name." ".$data->user->last_name) : 'Unknown' }}
                                </li>
                                <li>
                                    <i class="fa fa-phone-square mr-2"></i> {{ $data->user->contact? $data->user->contact : '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope mr-2"></i> {{ $data->user->email? $data->user->email: '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-globe mr-2"></i> {{ $data->user->city? $data->user->city.", " : '-'  }} {{ $data->user->country? $data->user->country : ''  }}
                                </li>
                                <li>
                                    <i class="fas fa-user-shield mr-2"></i>{!! $data->user->employee? '<span class="text-success">Our Partner</span>' : 'Customer' !!}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-user"></i> Bank Details</h6>
                            <hr style="margin-top: 10px;"/>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    @if($data->user->bank_details)
                                    <ul class="list-unstyled bg-light p-3">
                                        <li>
                                            <strong>Account Type: </strong> {{ $data->user->bank_details->account_name? $data->user->bank_details->account_name : '-' }}
                                        </li>
                                        <li>
                                            <strong>Account No: </strong> {{ $data->user->bank_details->account_number? $data->user->bank_details->account_number : '-' }}
                                        </li>
                                        <li>
                                            <strong>Bank Branch: </strong> {{ $data->user->bank_details->bank_branch? $data->user->bank_details->bank_branch: '-' }}
                                        </li>
                                        <li>
                                            <strong>Bank Name: </strong> {{ $data->user->bank_details->bank_name? $data->user->bank_details->bank_name.", " : '-'  }}
                                        </li>
                                        <li>
                                            <strong>Remarks: </strong> {{ $data->user->bank_details->Remarks?  $data->user->bank_details->Remarks : 'Customer' }}
                                        </li>
                                    </ul>
                                    @else
                                        <i class="fa fa-info-circle"></i> Invalid Bank Details.
                                    @endif
                                    @if($data->user->bank_details)
                                    <div class="row">
                                        @if($data->user->bank_details->status == "Pending")
                                            <div class="col-6">
                                                <form method="post" id="reject-bank-form" class="d-inline-flex" action="{{ route('withdrawal-wallet.bank-info.reject') }}">
                                                    @csrf
                                                    <input type="hidden" name="detail_id" value="{{$data->user->bank_details->id}}"/>
{{--                                                    <textarea name="reject_description" class="form-control mb-2" row="5">{{ old('reject_description') }}</textarea>--}}
                                                    <button type="button" class="btn btn-danger w-40" onclick="confirm_check_bank('reject')"><i class="fas fa-close"></i> Reject</button>
                                                </form>
                                                <form method="post" id="approve-bank-form" class="d-inline-flex mt-2" action="{{ route('withdrawal-wallet.bank-info.approve') }}">
                                                    @csrf
                                                    <input type="hidden" name="detail_id" value="{{$data->user->bank_details->id}}"/>
                                                    <button type="button" class="btn btn-success w-40" onclick="confirm_check_bank('approve')"><i class="fas fa-check"></i> Approve</button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="col-6">
                                            @permission('update-withdrawals')
                                            @push('script')
                                                <script>
                                                    function confirm_check_bank(data){
                                                        swal.fire({
                                                            title: '<span class="text-uppercase">'+data+' this bank details</span>',
                                                            text: "Are you sure want to "+data+" this bank details?",
                                                            type: 'warning',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Yes, '+data+' it!',
                                                            cancelButtonText: 'No',
                                                            reverseButtons: true
                                                        }).then((result) => {
                                                            if (result.value) {
                                                                $("#"+data+"-bank-form").submit();
                                                            } else if (
                                                                // Read more about handling dismissals
                                                                result.dismiss === Swal.DismissReason.cancel
                                                            ) { }
                                                        });
                                                    }
                                                </script>
                                            @endpush
                                            @endpermission
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @if($data->user->bank_details)
                                <div class="col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="list-unstyled bg-light p-3">
                                                <li>
                                                    <strong>Billing Proof: </strong>
                                                    @if($data->user->bank_details->billing_proof)
                                                        <br/>
                                                        <img width="100%" src="{{ asset($data->user->bank_details->billing_proof) }}" alt="Billing Proof" />
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="list-unstyled bg-light p-3">
                                                <li>
                                                    <strong>Nic Proof: </strong>
                                                    @if($data->user->bank_details->nic_proof)
                                                        <br/>
                                                        <img width="100%" src="{{ asset($data->user->bank_details->nic_proof) }}" alt="Nic Proof" />
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <hr/>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <h6 class="mt-4  text-secondary"><i class="fas fa-clipboard-list"></i> Actions</h6>
                            <hr style="margin-top: 10px;"/>
                            <div class="row">
                                @if($data->status == "Requested")
                                    <div class="col-6">
                                        <form method="post" id="reject-form" action="{{ route('withdrawal-wallet.requested.reject') }}">
                                            @csrf
                                            <input type="hidden" name="point_id" value="{{$data->id}}"/>
                                            <textarea name="reject_description" class="form-control mb-2" row="5">{{ old('description') }}</textarea>
                                            <button type="button" class="btn btn-danger w-100" onclick="confirm_check('reject')"><i class="fas fa-close"></i> Reject</button>
                                        </form>
                                    </div>
                                @endif
                                <div class="col-6">
                                    <a href="{{ route('withdrawal-wallet.requested') }}"
                                       class="btn btn-info w-25">
                                        <i class="fa fa-long-arrow-left mr-1"></i> Back
                                    </a>
                                    @permission('update-withdrawals')
                                    @if($data->status == "Requested")
                                        <button class="btn btn-success w-25" onclick="confirm_check('confirm')"><i class="fa fa-check"></i> Confirm</button>
                                    @endif
                                    <form method="post" id="confirm-form" action="{{ route('withdrawal-wallet.requested.confirm') }}">@csrf<input type="hidden" name="point_id" value="{{$data->id}}"/></form>
                                    @push('script')
                                        <script>
                                            function confirm_check(data){
                                                swal.fire({
                                                    title: '<span class="text-uppercase">'+data+' Request</span>',
                                                    text: "Are you sure want to "+data+" this request?",
                                                    type: 'warning',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Yes, '+data+' it!',
                                                    cancelButtonText: 'No',
                                                    reverseButtons: true
                                                }).then((result) => {
                                                    if (result.value) {
                                                        $("#"+data+"-form").submit();
                                                    } else if (
                                                        // Read more about handling dismissals
                                                        result.dismiss === Swal.DismissReason.cancel
                                                    ) { }
                                                });
                                            }
                                        </script>
                                    @endpush
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
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
