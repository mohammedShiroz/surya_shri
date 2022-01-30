@extends('layouts.front')
@section('page_title','Withdrawal Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Withdrawal Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@include('backend.components.plugins.alert')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Withdrawal Points','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'Withdrawal Points','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_wallet.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="text-uppercase">Withdrawal Points</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        @if(\App\WithdrawalUsersBankDetails::where('user_id',\auth::user()->id)->whereNotnull('is_deleted')->orderby('created_at','Desc')->first() && !\auth::user()->bank_details)
                                        <div class="alert alert-danger alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            Your bank details has been rejected. Please update your bank details to withdraw your points.
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" id="available_points" value="{{ (getCalPoints()["total_direct_points"]+getCalPoints()["total_in_direct_points"] - getCalPoints()["total_transferred_points"]) }}" />
                                                        <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                        <p>Available Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" id="withdrawable_points" value="{{ (getWithdrawalablePointsByUser(\auth::user()->id)["total_Withdrawalable_points"]) }}" />
                                                        <h5>{{ getPointsFormat((getWithdrawalablePointsByUser(\auth::user()->id)["total_Withdrawalable_points"])) }}</h5>
                                                        <p>Withdrawable Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getCalPoints()["pending_withdrawal_points"]) }}</h5>
                                                        <p>Pending Withdrawal Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getCalPoints()["pending_paid_points"]) }}</h5>
                                                        <p>Pending Paid Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getCalPoints()["total_withdrawal_points"]) }}</h5>
                                                        <p>Total Withdrawn Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <h4 class="mb-2 text-uppercase">Withdrawal request form</h4>
                                        <p class="mb-3">For authenticity and safety of withdrawals please provide a Bank Account that
                                            matches your registration information. You will only be allowed to enter one set
                                            of banking details. If you need to change your existing banking details, please
                                            Contact Us for support.</p>
                                        <form action="{{ route('wallet.points.withdrawal.store.bank-details') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ \auth::user()->id }}" />
                                            @if(!\auth::user()->employee)
                                                <input type="hidden" name="type" value="User" />
                                            @else
                                                @if(\auth::user()->employee->is_seller)
                                                    <input type="hidden" name="type" value="Seller" />
                                                @elseif(\auth::user()->employee->is_doctor)
                                                    <input type="hidden" name="type" value="Doctor" />
                                                @else
                                                    <input type="hidden" name="type" value="User" />
                                                @endif
                                            @endif
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label>Account Type <span class="required">*</span></label>
                                                    <input type="text" {{ (\auth::user()->bank_details)? 'disabled' : 'required' }} name="account_name" id="w-account_name" value="{{ old('account_name')? old('account_name') : ((\auth::user()->bank_details)? \auth::user()->bank_details->account_name : '')  }}" class="form-control" placeholder="Account type" />
                                                    @error('account_name')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Bank Account Number <span class="required">*</span></label>
                                                    <input type="text" required  name="account_number" {{ (\auth::user()->bank_details)? 'disabled' : 'required' }} id="w-account_number" value="{{ old('account_number')? old('account_number') : ((\auth::user()->bank_details)? \auth::user()->bank_details->account_number : '')  }}" class="form-control" placeholder="Bank account number" />
                                                    @error('account_number')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Bank Branch <span class="required">*</span></label>
                                                    <input type="text" required name="bank_branch" {{ (\auth::user()->bank_details)? 'disabled' : 'required' }} id="w-bank_branch" value="{{ old('bank_branch')? old('bank_branch') : ((\auth::user()->bank_details)? \auth::user()->bank_details->bank_branch : '')  }}" class="form-control" placeholder="Bank branch" />
                                                    @error('bank_branch')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Bank Name <span class="required">*</span></label>
                                                    <input type="text" required name="bank_name" {{ (\auth::user()->bank_details)? 'disabled' : 'required' }} id="w-bank_name" value="{{ old('bank_name')? old('bank_name') : ((\auth::user()->bank_details)? \auth::user()->bank_details->bank_name : '') }}" class="form-control" placeholder="Bank name" />
                                                    @error('bank_name')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Remarks </label>
                                                    <textarea name="remarks" placeholder="Remarks" {{ (\auth::user()->bank_details)? 'disabled' : '' }} row="5" class="form-control">{{ old('remarks')? old('remarks') : ((\auth::user()->bank_details)? \auth::user()->bank_details->remarks : '') }}</textarea>
                                                    @error('remarks')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Upload requested Billing Proofs</label>
                                                    <div class="row">
                                                        @isset(\auth::user()->bank_details->billing_proof)
                                                        <div class="col-3 d-inline-flex">
                                                            @if(\auth::user()->bank_details->billing_proof)
                                                                <div class=" align-content-center justify-content-center">
                                                                    <img class="radius_all_5" src="{{ asset(\auth::user()->bank_details->billing_proof) }}" width="50px" height="50px" alt="" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="{{ \auth::user()->bank_details->billing_proof? 'col-9' : 'col-12' }}">
                                                            <input type="file" name="billing_proof" {{ (\auth::user()->bank_details)? 'disabled' : '' }} class="form-control" />
                                                        </div>
                                                        @else
                                                            <div class="col-12">
                                                                <input type="file" name="billing_proof" {{ (\auth::user()->bank_details)? 'disabled' : '' }} class="form-control" />
                                                            </div>
                                                        @endisset
                                                    </div>
                                                    @error('billing_proofs')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Upload NIC/DL/Passport Proofs</label>
                                                    <div class="row">
                                                        @isset(\auth::user()->bank_details->nic_proof)
                                                        <div class="col-3 d-inline-flex">
                                                            @if(\auth::user()->bank_details->nic_proof)
                                                                <div class=" align-content-center justify-content-center">
                                                                    <img class="radius_all_5" src="{{ asset(\auth::user()->bank_details->nic_proof) }}" width="50px" height="50px" alt="" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="{{ \auth::user()->bank_details->nic_proof? 'col-9' : 'col-12' }}">
                                                            <input type="file" {{ (\auth::user()->bank_details)? 'disabled' : 'required' }} name="nic_proof" class="form-control" />
                                                        </div>
                                                        @else
                                                            <div class="col-12">
                                                                <input type="file" {{ (\auth::user()->bank_details)? 'disabled' : 'required' }} name="nic_proof" class="form-control" />
                                                            </div>
                                                        @endisset
                                                    </div>
                                                    @error('nic_proof')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                @if(!\auth::user()->bank_details && !\App\WithdrawalUsersBankDetails::where('user_id',\auth::user()->id)->whereNotnull('is_deleted')->orderby('created_at','Desc')->first())
                                                    <div class="col-md-12">
                                                        <div class="pl-0 pt-3 pb-3">
                                                            <button type="submit" class="btn btn-fill-out btn-sm">Save Changes</button>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(\App\WithdrawalUsersBankDetails::where('user_id',\auth::user()->id)->whereNotnull('is_deleted')->orderby('created_at','Desc')->first() && !\auth::user()->bank_details)
                                                <div class="col-md-12">
                                                    <div class="pl-0 pt-3 pb-3">
                                                        <button type="submit" class="btn btn-fill-out btn-sm">Save Changes</button>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </form>
                                        <form action="{{ route('wallet.points.withdrawal') }}" class="mt-5" method="POST" id="withdrawalFrom">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ \auth::user()->id }}" />
                                            @if(!\auth::user()->employee)
                                                <input type="hidden" name="type" value="User" />
                                            @else
                                                @if(\auth::user()->employee->is_seller)
                                                    <input type="hidden" name="type" value="Seller" />
                                                @elseif(\auth::user()->employee->is_doctor)
                                                    <input type="hidden" name="type" value="Doctor" />
                                                @else
                                                    <input type="hidden" name="type" value="User" />
                                                @endif
                                            @endif
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Withdrawal Points<span class="required">*</span></label>
                                                    <input type="text" name="points" id="w-points" value="{{ old('points')? old('points') : '0'  }}" required class="form-control" />
                                                    @error('points')
                                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-fill-out btn-sm" id="submit_btn">Request a Withdrawal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if(\App\Withdrawal_points::where('user_id',\auth::user()->id)->get()->count() > 0)
                                    <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Account Name</th>
                                            <th>Account No.</th>
                                            <th>Points</th>
                                            <th>Withdrawal Fee</th>
                                            <th>Requested Date</th>
                                            <th>Request Status</th>
                                            <th>Withdrawal Status</th>
                                            <th>Transaction ID</th>
                                            <th>Paid Amount</th>
                                            <th>Proof of Transfer Image</th>
                                            <th>Withdrawal Completion Date and Time</th>
                                            <th>Rejected Date</th>
                                            <th>Rejected Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Withdrawal_points::where('user_id',\auth::user()->id)->orderby('status','DESC')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ isset(\auth::user()->bank_details->account_name)? \auth::user()->bank_details->account_name : '' }}</td>
                                                <td>{{ isset(\auth::user()->bank_details->account_number)? \auth::user()->bank_details->account_number : '' }}</td>
                                                <td>{{ getPointsFormat($row->withdrawal_points - ($row->fee_amount*\App\Details::where('key', 'points_rate')->first()->amount)) }}
                                                    <br/>
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info" style="font-size: 8px">New</small>
                                                    @endif</td>
                                                <td>{{ getCurrencyFormat($row->fee_amount) }}</td>
                                                <td>{{ date('d, M Y, h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>
                                                    @if($row->status == "Requested")
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($row->status == "Rejected")
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @elseif($row->status == "Approved")
                                                        <span class="badge badge-success">Confirmed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->status == "Provided")
                                                        <span class="badge badge-success">Completed</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $row->transaction_id? "SS/WP/T-".$row->transaction_id : '-' }}</td>
                                                <td>{{ $row->amount? getCurrencyFormat($row->amount) : 'Progressing...' }}</td>
                                                <td>
                                                    @if($row->proofe_image)
                                                        <img src="{{ asset($row->proofe_image) }}" alt="" width="100%" class="radius_all_5" />
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>{{ $row->given_date? date('d, M Y, h:i:s A', strtotime($row->given_date)) : '-' }}</td>
                                                <td>{{ $row->rejected_at? date('d, M Y, h:i:s A', strtotime($row->rejected_at)) : '-' }}</td>
                                                <td>{{ $row->reject_description? $row->reject_description : '-' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p><i class="fa fa-info-circle"></i> No Withdrawal Point Yet</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
@push('script')
    <script>
        $('#w-points').on('keypress', function (event) {
            var regex = new RegExp("^[0-9\.]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $("#submit_btn").click(function(){
            if(parseFloat($("#withdrawable_points").val()) < parseFloat($("#w-points").val())){
                swal.fire({
                    title: 'Notice!',
                    text:'You do not have sufficient points for this withdrawal.',
                    icon: "info",
                });
            }else{
                swal.fire({
                    title: '<span class="text-uppercase">CONFIRMATION REQUIRED!</span>',
                    text: "You are requesting to withdrawal, "+$("#w-points").val() +" points. Are you sure you want to proceed with this request?”",
                    type: 'warning',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $("#withdrawalFrom").submit();
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });
            }
        });
    </script>
@endpush
