@extends('backend.layouts.admin')
@section('page_title','View Withdrawal Payment Details')
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
                        <h1>Withdrawal Payment Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.payments') }}">Withdrawal Payments</a></li>
                            <li class="breadcrumb-item active">Withdrawal Payment Details</li>
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
                    <h3 class="card-title text-uppercase">{{ $data->user->name." ".$data->user->last_name }} PAYMENT DETAILS</h3>
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
                                    <span class="info-box-text text-center text-muted"><strong>Approved Points</strong></span>
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
                                    <span class="info-box-number text-center text-muted mb-0">{{ ($data->amount)? 'Paid' : 'Not Paid' }}</span>
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
                                                            <h5>{{ getPointsFormat((getCalPointsByUser($data->user->id)["total_direct_points"] + getCalPointsByUser($data->user->id)["total_in_direct_points"]) - getCalPointsByUser($data->user->id)["total_transferred_points"] - getCalPointsByUser($data->user->id)["pending_withdrawal_points"] - getCalPointsByUser($data->user->id)["total_withdrawal_points"]) }} </h5>
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
                        <div class="col-md-6 col-lg-6 col-sm-12">
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
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <h6 class="mt-4  text-secondary"><i class="fas fa-clipboard-list"></i> Action</h6>
                            <hr style="margin-top: 10px;"/>
                            <form method="post" id="confirm-form" enctype="multipart/form-data" action="{{ route('withdrawal-wallet.payment.confirm') }}">
                                @csrf
                                <input type="hidden" name="point_id" value="{{$data->id}}"/>
                                <input type="hidden" name="paid_amount" class="form-control" value="{{ ($data->withdrawal_points - ($data->fee_amount*\App\Details::where('key', 'points_rate')->first()->amount)) }}" />
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label>Paid Amount</label>
                                            <input type="text" readonly class="form-control col-12" value="{{ getCurrencyFormat($data->withdrawal_points - ($data->fee_amount*\App\Details::where('key', 'points_rate')->first()->amount))}}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Upload Transfer Proofs</label>
                                        <div class="row">
                                            @if($data->proofe_image)
                                                <div class="col-12 d-inline-flex">
                                                    <div class=" align-content-center justify-content-center">
                                                        <img class="radius_all_5" src="{{ asset($data->proofe_image) }}" width="100%" alt="" />
                                                    </div>
                                                </div>
                                            @endif
                                            @if(!$data->amount)
                                            <div class="col-12">
                                                <input type="file" id="pay_proof" required name="pay_proof" class="" />
                                            </div>
                                            @endif
                                        </div>
                                        @error('pay_proof')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                        <hr/>
                                    </div>
                                    <div class="col-12">
                                        <a href="{{ route('withdrawal-wallet.payments') }}"
                                           class="btn btn-info float-right ml-2" style="margin-right: 5px;">
                                            <i class="fa fa-long-arrow-left mr-1"></i> Back
                                        </a>
                                        @permission('update-withdrawals')
                                        @if(!$data->amount)
                                            <button class="btn btn-success float-right ml-2" type="button" onclick="confirm_check('confirm')"><i class="fa fa-check"></i> Paid</button>
                                        @endif
                                        @push('script')
                                            <script>
                                                function confirm_check(data){
                                                    if ($('#pay_proof')[0].files.length === 0) {
                                                        swal.fire({
                                                            title: '<span class="text-uppercase">Required Payment Proof</span>',
                                                            text: "Please upload payment proof to continue",
                                                            type: 'warning',
                                                            icon: 'warning',
                                                        });
                                                    } else {
                                                        swal.fire({
                                                            title: '<span class="text-uppercase">'+data+' Paid</span>',
                                                            text: "Are you sure want to "+data+" this payment?",
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
                                                }
                                            </script>
                                        @endpush
                                        @endpermission
                                    </div>
                                </div>
                            </form>
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
