@extends('layouts.front')
@section('page_title','Wallet History')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Wallet History'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Wallet History','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'My Wallet','route'=>route('wallet')],
        2=>['name'=>'Wallet History','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Wallet History</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-12">
                                        <div class="heading_tab_header text-center">
                                            <div class="tab-style3">
                                                <ul class="nav nav-tabs justify-content-center justify-content-md-end" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="card-payments-tab" data-toggle="tab" href="#card_payments" role="tab" aria-controls="card_payments" aria-selected="true"><small>Card Payments</small></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="points-payments-tab" data-toggle="tab" href="#points_payments" role="tab" aria-controls="points_payments" aria-selected="true"><small>Points Payments</small></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="withdrawals-tab" data-toggle="tab" href="#withdrawals" role="tab" aria-controls="withdrawals" aria-selected="true"><small>Withdrawals to Bank</small></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="points-transactions-tab" data-toggle="tab" href="#points_transactions" role="tab" aria-controls="points_transactions" aria-selected="true"><small>Point Transactions</small></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="redeemed-vouchers-tab" data-toggle="tab" href="#redeemed_vouchers" role="tab" aria-controls="redeemed_vouchers" aria-selected="true"><small>Redeemed vouchers</small></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="tab_slider">
                                            <div class="tab-pane fade show active" id="card_payments" role="tabpanel" aria-labelledby="card-payments-tab">
                                                <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Transaction Id</th>
                                                        <th>Payment Method</th>
                                                        <th>Paid</th>
                                                        <th>Status</th>
                                                        <th>Data and Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(\App\Payments::where('user_id',\auth::user()->id)->where('payment_method','online_payment')->get()->count()>0)
                                                        @foreach(\App\Payments::where('user_id',\auth::user()->id)->where('payment_method','online_payment')->get() as $row)
                                                            <tr>
                                                                <td>{{ ($row->type == "product")? 'Product Order' : 'Service Reservation' }}
                                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                        <small class="badge badge-info" style="font-size: 8px">New</small>
                                                                    @endif</td>
                                                                <td>@if($row->type == "product") SSA/PO/{{ $row->order->track_id }} @elseif($row->type == "service") SSA/BK/{{ $row->booking->book_reference }} @else - @endif</td>
                                                                <td>{{ ($row->payment_method == "online_payment")? 'Online Card Payment' : 'Used Points' }}</td>
                                                                <td>{{ ($row->payment_method == "online_payment")? $row->paid_amount.".00" : getPointsFormat($row->paid_points)." Points" }}</td>
                                                                <td align="center">
                                                                    @if($row->payment_status == "success")
                                                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Success</span>
                                                                    @elseif($row->payment_status == "failed")
                                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Failed</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ date('d, M Y, h:i:s A', strtotime($row->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="points_payments" role="tabpanel" aria-labelledby="points-payments-tab">
                                                <table class="table table-striped table-bordered data_tables" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Transaction Id</th>
                                                        <th>Payment Method</th>
                                                        <th>Paid</th>
                                                        <th>Status</th>
                                                        <th>Data and Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(\App\Payments::where('user_id',\auth::user()->id)->where('payment_method','points_payment')->get()->count()>0)
                                                        @foreach(\App\Payments::where('user_id',\auth::user()->id)->where('payment_method','points_payment')->get() as $row)
                                                            <tr>
                                                                <td>{{ ($row->type == "product")? 'Product Order' : 'Service Reservation' }}
                                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                        <small class="badge badge-info" style="font-size: 8px">New</small>
                                                                    @endif</td>
                                                                <td>@if($row->type == "product") SSA/PO/{{ $row->order->track_id }} @elseif($row->type == "service") SSA/BK/{{ $row->booking->book_reference }} @else - @endif</td>
                                                                <td>{{ ($row->payment_method == "online_payment")? 'Online Card Payment' : 'Used Points' }}</td>
                                                                <td>{{ ($row->payment_method == "online_payment")? $row->paid_amount.".00" : getPointsFormat($row->paid_points)." Points" }}</td>
                                                                <td align="center">
                                                                    @if($row->payment_status == "success")
                                                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Success</span>
                                                                    @elseif($row->payment_status == "failed")
                                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Failed</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ date('d, M Y, h:i:s A', strtotime($row->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="withdrawals" role="tabpanel" aria-labelledby="withdrawals-tab">
                                                <table class="data_tables table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Account Name</th>
                                                        <th>Account No.</th>
                                                        <th>Requested Points</th>
                                                        <th>Withdrawal Status</th>
                                                        <th>Paid Amount</th>
                                                        <th>Withdrawal Completion Date and Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(\App\Withdrawal_points::where('user_id',\auth::user()->id)->orderby('status','DESC')->get() as $row)
                                                        <tr>
                                                            <td>{{ $loop->index+1 }}</td>
                                                            <td>{{ isset(\auth::user()->bank_details->account_name)? \auth::user()->bank_details->account_name : '' }}
                                                                @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                    <small class="badge badge-info" style="font-size: 8px">New</small>
                                                                @endif</td>
                                                            </td>
                                                            <td>{{ isset(\auth::user()->bank_details->account_number)? \auth::user()->bank_details->account_number : '' }}</td>
                                                            <td>{{ getPointsFormat($row->withdrawal_points) }}
                                                            <td>
                                                                @if($row->status == "Provided")
                                                                    <span class="badge badge-success">Completed</span>
                                                                @else
                                                                    <span class="badge badge-warning">Pending</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $row->amount? getCurrencyFormat($row->amount) : 'Progressing...' }}</td>
                                                            <td>{{ $row->given_date? date('d, M Y, h:i:s A', strtotime($row->given_date)) : '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="points_transactions" role="tabpanel" aria-labelledby="points-transactions-tab">
                                                <?php
                                                $transfer_points_ids = \App\Points::where('user_id', \Auth::user()->id)->WhereNotNull('forward_points')->pluck('id')->toArray();
                                                $credited_points_ids = \App\Points::where('forward_user_id',\auth::user()->id)->pluck('id')->toArray();
                                                $points_ids = array_merge($transfer_points_ids,$credited_points_ids);
                                                ?>
                                                <table class="data_tables table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Partner Name</th>
                                                        <th>Transferred Points</th>
                                                        <th>Transfer Type</th>
                                                        <th>Transferred Date & Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(\App\Points::whereIn('id',$points_ids)->get() as $row)
                                                        <tr>
                                                            <td>{{ $loop->index+1 }}</td>
                                                            <td>
                                                                @if($row->forward_user_info->id == \auth::user()->id)
                                                                    {{ $row->user_info->name." ".$row->user_info->last_name }}
                                                                @elseif($row->user_info)
                                                                    {{ $row->forward_user_info->name." ".$row->forward_user_info->last_name }}
                                                                @endif
                                                            </td>
                                                            <td>{{ getPointsFormat($row->forward_points) }}</td>
                                                            <td>
                                                                @if($row->forward_user_info->id == \auth::user()->id)
                                                                    Received
                                                                @elseif($row->user_info)
                                                                    Send
                                                                @endif
                                                            </td>
                                                            <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="redeemed_vouchers" role="tabpanel" aria-labelledby="redeemed-vouchers-tab">
                                                <table class="data_tables table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Voucher Name</th>
                                                        <th>Voucher Code</th>
                                                        <th>Invoice</th>
                                                        <th>Used Date & Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(\App\Voucher_customers::where('user_id',\auth::user()->id)->get() as $row)
                                                        <tr>
                                                            <td>{{ $loop->index+1 }}</td>
                                                            <td>{{ $row->voucher->name }}</td>
                                                            <td>{{ $row->voucher->code }}</td>
                                                            <td>@if($row->order) SSA/PO/{{ $row->order->track_id }} @elseif($row->booking) SSA/BK/{{ $row->booking->book_reference }} @else -  @endif</td>
                                                            <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
