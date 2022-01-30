@extends('layouts.front')
@section('page_title','Order activities')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Order activities'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Orders','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Orders','route'=>''],
    ]])
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
                                <h5>MY ORDERS</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-12">
                                        @if(count(\App\Orders::WhereNull('is_deleted')->where('user_id', \auth::user()->id)->get())>0)
                                        <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Order No.</th>
                                                    <th>Order Value</th>
                                                    <th>Payment Method</th>
                                                    <th>Payment Date and Time</th>
                                                    <th>Order Status</th>
                                                    <th>Delivery Status</th>
                                                    <th>Delivery Date and Time</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(\App\Orders::WhereNull('is_deleted')->where('user_id', \auth::user()->id)->orderby('created_at','DESC')->get() as $row)
                                                    <tr>
                                                        <td><a href="{{ route('dashboard.orders.detail',HashEncode($row->id)) }}"><small>SSA/PO/{{ $row->track_id}}</small></a>
                                                            @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                <small class="badge badge-info" style="font-size: 8px">New</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ getCurrencyFormat($row->total) }}</td>
                                                        <td>{{ ($row->payment_method == "points_payment")? 'Points Payment' : 'Card Payment' }}</td>
                                                        <td>{{ date('d, M Y, h:i:s A', strtotime( $row->payment->created_at)) }}</td>
                                                        <td align="center">
                                                            @if($row->status == "Pending")
                                                                <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                                            @elseif($row->status == "Confirmed")
                                                                <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Confirmed</span>
                                                            @elseif($row->status == "Rejected")
                                                                <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Rejected</span>
                                                            @elseif($row->status == "Canceled")
                                                                <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Canceled</span>
                                                            @endif
                                                        </td>
                                                        <td align="center">
                                                            @if($row->delivery_status == "Pending")
                                                                <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                                            @elseif($row->delivery_status == "Delivered")
                                                                <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Delivered</span>
                                                            @elseif($row->delivery_status == "Not-delivered")
                                                                <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Not-delivered</span>
                                                            @elseif($row->delivery_status == "Sending")
                                                                <span class="badge badge-info pt-1 pl-3 pr-3 pb-1 radius_all_10">Sending</span>
                                                            @elseif($row->delivery_status == "Hold")
                                                                <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Hold</span>
                                                            @elseif($row->delivery_status == "Self-Pickup")
                                                                <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Self-Pickup</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->delivery_date?  date('d, M Y, h:i:s A', strtotime($row->delivery_date)) : '-' }}</td>
                                                        <td>
                                                            <div class="mb-2" role="group" aria-label="Basic example">
                                                                <a href="{{ route('dashboard.orders.detail',HashEncode($row->id)) }}" class="btn btn-line-fill btn-radius btn-sm"><small>View Details</small></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                            <p class="border p-3"><i class="fa fa-info-circle"></i> No order yet ...</p>
                                        @endif
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
