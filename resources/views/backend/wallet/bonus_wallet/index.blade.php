@extends('backend.layouts.admin')
@section('page_title','Bonus Wallet Points')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bonus/Gift Wallet Points</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Bonus/Gift Wallet Points</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body" style="padding: 0 !important;">
                                <!-- START SECTION WHY CHOOSE -->
                                <div class="row justify-content-center text-center p-5">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="icon_box icon_box_style4">
                                            <div class="icon">
                                                <i class="fas fa-coins" style="font-size: 25px;"></i>
                                            </div>
                                            <div class="icon_box_content">
                                                <h1>{{ getPointsFormat(getFinalPointsByUser(\App\User::where('prefix','Bonus')->first()->id)["total_points"]) }}</h1>
                                                <p>Total Network Bonus/Gifts Points</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END SECTION WHY CHOOSE -->
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-uppercase">Bonus Wallet Withdrawal Request</h3>
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
                                        <h4 class="mb-2 text-uppercase">Withdrawal request form</h4>
                                        <p class="mb-3">For authenticity and safety of withdrawals please provide a Bank Account that
                                            matches your registration information.</p>
                                        <form action="{{ route('withdrawal-wallet.send.request') }}" method="POST" id="withdrawalFrom" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ \App\User::where('prefix','Bonus')->first()->id }}" />
                                            <input type="hidden" name="type" value="Bonus" />
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label>Account Type <span class="required">*</span></label>
                                                    <input type="text" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : 'required' }} name="account_name" id="w-account_name" value="{{ old('account_name')? old('account_name') : ((\App\User::where('prefix','Bonus')->first()->bank_details)? \App\User::where('prefix','Bonus')->first()->bank_details->account_name : '')  }}" class="form-control" placeholder="Account type" />
                                                    @error('account_name')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Bank Account Number <span class="required">*</span></label>
                                                    <input type="text" name="account_number" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : 'required' }} id="w-account_number" value="{{ old('account_number')? old('account_number') : ((\App\User::where('prefix','Bonus')->first()->bank_details)? \App\User::where('prefix','Bonus')->first()->bank_details->account_number : '')  }}" class="form-control" placeholder="Bank account number" />
                                                    @error('account_number')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Bank Branch <span class="required">*</span></label>
                                                    <input type="text" name="bank_branch" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : 'required' }} id="w-bank_branch" value="{{ old('bank_branch')? old('bank_branch') : ((\App\User::where('prefix','Bonus')->first()->bank_details)? \App\User::where('prefix','Bonus')->first()->bank_details->bank_branch : '')  }}" class="form-control" placeholder="Bank branch" />
                                                    @error('bank_branch')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Bank Name <span class="required">*</span></label>
                                                    <input type="text" name="bank_name" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : 'required' }} id="w-bank_name" value="{{ old('bank_name')? old('bank_name') : ((\App\User::where('prefix','Bonus')->first()->bank_details)? \App\User::where('prefix','Bonus')->first()->bank_details->bank_name : '') }}" class="form-control" placeholder="Bank name" />
                                                    @error('bank_name')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Remarks </label>
                                                    <textarea placeholder="Remarks" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : '' }} row="5" class="form-control" name="remarks" >{{ old('remarks')? old('remarks') : ((\App\User::where('prefix','Bonus')->first()->bank_details)? \App\User::where('prefix','Bonus')->first()->bank_details->remarks : '') }}</textarea>
                                                    @error('remarks')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Upload requested Billing Proofs</label>
                                                    <div class="row">
                                                        @isset(\App\User::where('prefix','Bonus')->first()->bank_details->billing_proof)
                                                            <div class="col-3 d-inline-flex">
                                                                @if(\App\User::where('prefix','Bonus')->first()->bank_details->billing_proof)
                                                                    <div class=" align-content-center justify-content-center">
                                                                        <img class="radius_all_5" src="{{ asset(\App\User::where('prefix','Bonus')->first()->bank_details->billing_proof) }}" width="100px" height="100px" alt="" />
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="{{ \App\User::where('prefix','Bonus')->first()->bank_details->billing_proof? 'col-9' : 'col-12' }}">
                                                                <input type="file" name="billing_proof" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : '' }} class="form-control" />
                                                            </div>
                                                        @else
                                                            <div class="col-12">
                                                                <input type="file" name="billing_proof" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : '' }} class="form-control" />
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
                                                        @isset(\App\User::where('prefix','Bonus')->first()->bank_details->nic_proof)
                                                            <div class="col-3 d-inline-flex">
                                                                @if(\App\User::where('prefix','Bonus')->first()->bank_details->nic_proof)
                                                                    <div class=" align-content-center justify-content-center">
                                                                        <img class="radius_all_5" src="{{ asset(\App\User::where('prefix','Bonus')->first()->bank_details->nic_proof) }}" width="100px" height="100px" alt="" />
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="{{ \App\User::where('prefix','Bonus')->first()->bank_details->nic_proof? 'col-9' : 'col-12' }}">
                                                                <input type="file" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : 'required' }} name="nic_proof" class="form-control" />
                                                            </div>
                                                        @else
                                                            <div class="col-12">
                                                                <input type="file" {{ (\App\User::where('prefix','Bonus')->first()->bank_details)? 'disabled' : 'required' }} name="nic_proof" class="form-control" />
                                                            </div>
                                                        @endisset
                                                    </div>
                                                    @error('nic_proof')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Withdrawal Points<span class="required">*</span></label>
                                                    <input type="number" min="1" oninput="validity.valid||(value='');" name="points" id="w-points" value="{{ old('points')? old('points') : '0'  }}" required class="form-control" />
                                                    @error('points')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary btn-sm" id="submit_btn">Request a Withdrawal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Bonus Points Details</h3>
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
                                        <th>Type</th>
                                        <th>User Name & ID</th>
                                        <th>Invoice No.</th>
                                        <th>Product/Service Name</th>
                                        <th>Earn Points</th>
                                        <th>Date & Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Points_Commission::where('user_id',\App\User::where('prefix','Bonus')->first()->id)->where('type','Bonus')->get()->count()>0)
                                        @foreach(\App\Points_Commission::where('user_id',\App\User::where('prefix','Bonus')->first()->id)->where('type','Bonus')->orderby('created_at','asc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $row->pay_type }}</td>
                                                <td>
                                                    @if($row->order)
                                                        <a href="{{ route('users.show', $row->order->user->id)}}">({{ $row->order->user->id }}) {{ $row->order->user->name." ".$row->order->user->last_name }}</a>
                                                        @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                        @endif
                                                    @elseif($row->booking)
                                                        <a href="{{ route('users.show', $row->booking->user->id)}}">({{ $row->booking->user->id }}) {{ $row->booking->user->name." ".$row->booking->user->last_name }}</a>
                                                        @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->order_id)
                                                        <a href="{{ route('orders.view', [$row->order->id, 'order_index']) }}">SSA/PO/{{ $row->order->track_id}}</a>
                                                    @elseif($row->booking)
                                                        <a href="{{ route('reservations.show', $row->booking->id) }}">SSA/BK/{{ $row->booking->book_reference }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->order_id)
                                                        {{ isset($row->product->name)? $row->product->name : '-' }}
                                                    @elseif($row->booking)
                                                        {{ isset($row->service->name)? $row->service->name : '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ getPointsFormat($row->commission_points) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
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
