@extends('backend.layouts.admin')
@section('page_title','Seller Wallet Withdrawals')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Seller Wallet Withdrawals</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('withdrawal-wallet.index') }}">Withdrawals</a></li>
                            <li class="breadcrumb-item active">Seller Wallet Withdrawals</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @permission('read-Withdrawal-Details')
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-uppercase">Seller Withdrawal Fee Details</h3>
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
                                    <div class="col-md-12 col-sm-12">
                                        <form action="{{ route('withdrawal-details.update',(\App\WithdrawalDetails::where('type','Seller')->firstOrFail()->id)) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label>Wallet Type</label>
                                                    <input type="text" name="type" readonly value="{{ old('type')? old('type') : 'Seller'  }}" class="form-control" placeholder="Wallet type" />
                                                    @error('type')<div class="form-control-feedback text-danger text-sm">{{$message}}</div>@enderror
                                                </div>
                                                <div class="form-group col-3">
                                                    <label>Withdrawal Fee <span class="required">*</span></label>
                                                    <input type="text" id="withdrawal_fee" name="fee_amount" value="{{ old('fee_amount')? old('fee_amount') : ((\App\WithdrawalDetails::where('type','Seller')->firstOrFail()->fee_amount)? \App\WithdrawalDetails::where('type','Seller')->firstOrFail()->fee_amount : null)  }}" class="form-control" placeholder="Withdrawal Fee Amount" />
                                                    @error('fee_amount') <div class="form-control-feedback text-danger text-sm">{{$message}}</div>@enderror
                                                </div>
                                                <div class="form-group col-3">
                                                    <label>Withdrawal Percentage <span class="required">*</span></label>
                                                    <input type="number" min="0" oninput="validity.valid||(value='');"  id="withdrawal_fee_percentage" name="percentage" value="{{ old('percentage')? old('percentage') : ((\App\WithdrawalDetails::where('type','Seller')->firstOrFail()->percentage)? \App\WithdrawalDetails::where('type','Seller')->firstOrFail()->percentage : null)  }}" class="form-control maxType" placeholder="Withdrawal Fee Percentage" />
                                                    @error('percentage') <div class="form-control-feedback text-danger text-sm">{{$message}}</div>@enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Minimum limit <span class="required">*</span></label>
                                                    <input type="text" id="minimum_limit" name="minimum_limit" value="{{ old('minimum_limit')? old('minimum_limit') : ((\App\WithdrawalDetails::where('type','Seller')->firstOrFail()->minimum_limit)? \App\WithdrawalDetails::where('type','Seller')->firstOrFail()->minimum_limit : '0')  }}" class="form-control" placeholder="Withdrawal Minimum limit" />
                                                    @error('minimum_limit') <div class="form-control-feedback text-danger text-sm">{{$message}}</div>@enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Maximum limit <span class="required">*</span></label>
                                                    <input type="text" id="maximum_limit" name="maximum_limit" value="{{ old('maximum_limit')? old('maximum_limit') : ((\App\WithdrawalDetails::where('type','Seller')->firstOrFail()->maximum_limit)? \App\WithdrawalDetails::where('type','Seller')->firstOrFail()->maximum_limit : '0')  }}" class="form-control" placeholder="Withdrawal Maximum limit" />
                                                    @error('maximum_limit') <div class="form-control-feedback text-danger text-sm">{{$message}}</div>@enderror
                                                </div>
                                                @permission('update-Withdrawal-Details')
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary btn-sm" id="submit_btn">Save Changes</button>
                                                </div>
                                                @endpermission
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    @endpermission
                    <div class="col-12">
                        <div class="margin" style="margin-bottom: 10px;">
                            <div class="btn-group">
                                <a href="" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Seller Wallet Withdrawals Details</h3>
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
                                        <th>Seller Name & ID</th>
                                        <th>Withdrawable Points</th>
                                        <th>Withdrawn Points</th>
                                        <th>Paid Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Agent::whereNotNull('is_seller')->get()->count()>0)
                                        @foreach(\App\Agent::whereNotNull('is_seller')->orderby('created_at','DESC')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td><a href="{{ route('users.show', $row->user->id)}}">({{ $row->user->id }}) {{ $row->user->name." ".$row->user->last_name }}</a></td>
                                                <td>{{ getPointsFormat((getWithdrawalablePointsByUser($row->user->id)["total_Withdrawalable_points"])) }}</td>
                                                <td>{{ getPointsFormat(getCalPointsByUser($row->user->id)['total_withdrawal_points']) }}</td>
                                                <td>{{ getCurrencyFormat(getCalPointsByUser($row->user->id)['total_withdrawal_paid']) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('withdrawal-wallet.show-details', ['Sellers',$row->user->id])}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
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
@push('script')
    <script>
        $('#withdrawal_fee').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) { event.preventDefault(); return false; }
            $("#withdrawal_fee_percentage").val(null);
        });
        $("#withdrawal_fee_percentage").on("input", function(event){
            $("#withdrawal_fee").val(null);
        });
        $(".maxType").keypress(function(event){ if(parseInt($(this).val()+String.fromCharCode(event.which)) > 100){ return false; }else{ return true; } });
        $('#minimum_limit').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) { event.preventDefault(); return false; }
        });
        $('#maximum_limit').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) { event.preventDefault(); return false; }
        });
    </script>
@endpush
