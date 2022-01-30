@extends('layouts.front')
@section('page_title','Transaction')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Transaction'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Transaction','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Transaction','route'=>''],
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
                                <h5>TRANSACTION DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-12">
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
                                            @if(count(\auth::user()->payments)>0)
                                                @foreach(\auth::user()->payments as $row)
                                                    <tr>
                                                        <td>{{ ($row->type == "product")? 'Product Order' : 'Service Reservation' }}
                                                            @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                <small class="badge badge-info" style="font-size: 8px">New</small>
                                                            @endif</td>
                                                        <td>{{ ($row->type == "product")? "SSA/PO/".$row->order->track_id : "SSA/BK/".$row->booking->book_reference }}</td>
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
