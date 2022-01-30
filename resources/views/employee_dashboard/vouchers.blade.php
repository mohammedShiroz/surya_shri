@extends('layouts.front')
@section('page_title','My Vouchers')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('My Vouchers'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.alert')
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'My Vouchers','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'My Vouchers','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('employee_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-uppercase">My Vouchers</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                @include('components.messages')
                                            </div>

                                            <div class="col-md-12 col-sm-12">
                                                <form action="{{ route('redeem.voucher') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-12 col-sm-12">
                                                            <label>Redeem A Voucher <span class="required">*</span></label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" required class="form-control @error('voucher_code') is-invalid @enderror" id="voucher_code" name="voucher_code" value="{{ old('voucher_code')? old('voucher_code') : '' }}" placeholder="Enter Voucher code">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-fill-out btn-sm ml-2 gererate_code">Redeem Now</button>
                                                                </div>
                                                            </div>
                                                            @error('voucher_code')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{$message}}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12">
                                                <label>Redeemed Vouchers</label>
                                                @if(\App\RedeemPoints::where('user_id',\auth::user()->id)->get()->count()>0)
                                                <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="pt-3">#</th>
                                                        <th>Voucher Code</th>
                                                        <th>Points</th>
                                                        <th>Redeemed Data & Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(\App\RedeemPoints::where('user_id',\auth::user()->id)->orderby('created_at','DESC')->get() as $row)
                                                            <tr>
                                                                <td>{{ $loop->index+1 }}</td>
                                                                <td>{{ $row->voucher->code }}</td>
                                                                <td>{{ getPointsFormat($row->points) }}</td>
                                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                    <p class="border p-3"><i class="fa fa-info-circle"></i> No Redeem Voucher Result Found!</p>
                                                @endif
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
