@extends('layouts.front')
@section('page_title','Seller Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Seller Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@include('backend.components.plugins.alert')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Seller Points','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'Seller Points','route'=>''],
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
                                <h5 class="text-uppercase">Seller Points</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" id="available_points" value="{{ getFinalPoints()["available_points"] }}" />
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
                                                        <h5>{{ getPointsFormat(getCalPoints()["total_seller_earn_points"]) }}</h5>
                                                        <p>Total Seller Earn Points</p>
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
                                @if(\App\Seller_points::where('user_id',\auth::user()->id)->get()->count()>0)
                                    <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                            <th>Earn Points</th>
                                            <th>Earn Date & Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Seller_points::where('user_id',\auth::user()->id)->orderby('created_at','DESC')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>By <span class="text-capitalize">{{ $row->type }}</span>
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ $row->product->name }}</td>
                                                <td>{{ $row->qty }}</td>
                                                <td>{{ getPointsFormat($row->earn_points) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p><i class="fa fa-info-circle"></i> No Seller Earn Point Yet</p>
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
