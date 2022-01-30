@extends('layouts.front')
@section('page_title','Used Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Used Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Used Points','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'Used Points','route'=>''],
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
                                <h5 class="text-uppercase">Used Points</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                        <p>Available Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getCalPoints()["total_used_points"]) }}</h5>
                                                        <p>Total Used Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if(\App\Payments::where('user_id',\auth::user()->id)->whereNotNull('paid_points')->get()->count() > 0)
                                <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Transaction Id</th>
                                        <th>Payment Method</th>
                                        <th>Points</th>
                                        <th>Data and Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\App\Payments::where('user_id',\auth::user()->id)->whereNotNull('paid_points')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ ($row->type == "product")? 'Product Order' : 'Service Reservation' }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info" style="font-size: 8px">New</small>
                                                    @endif</td>
                                                <td>{{ ($row->type == "product")? "SSA/PO/".$row->order->track_id : "SSA/BK/".$row->booking->book_reference }}</td>
                                                <td>{{ ($row->payment_method == "online_payment")? 'Online Card Payment' : 'Used Points' }}</td>
                                                <td>{{ ($row->payment_method == "online_payment")? getCurrencyFormat($row->paid_amount) : getPointsFormat($row->paid_points)." Points" }}</td>
                                                <td>{{ date('d, M Y, h:i:s A', strtotime($row->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <p class="border p-3"><i class="fa fa-info-circle"></i> No Used Point Yet</p>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
