@extends('layouts.front')
@section('page_title','Commission Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Commission Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@include('backend.components.plugins.data_table')
@push('css')
    <style>
        .select2-container .select2-selection--single {
            height: 50px}
        .select2-container--default .select2-selection--single {
            padding-top: 10px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 13px;}
    </style>
@endpush
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Wallet - Commission Points','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Wallet','route'=>route('wallet')],
        2=>['name'=>'Commission Points','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_wallet.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="text-uppercase">Commission Points</h5>
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
                                                                <h5>{{ getPointsFormat(getCalPoints()["total_credited_points"]) }}</h5>
                                                                <p>Total Commission Points</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(\App\Points::where('user_id', \Auth::user()->id)->WhereNotNull('forward_points')->get()->count() > 0)
                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>From:<small>Name</small></th>
                                                    <th>Credited Points</th>
                                                    <th>Week</th>
                                                    <th>Date & Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(\App\Points::where('forward_user_id', \Auth::user()->id)->WhereNotNull('forward_points')->get() as $row)
                                                    <tr>
                                                        <td>{{ $row->user_info->name }}</td>
                                                        <td>{{ getPointsFormat($row->forward_points) }}</td>
                                                        <td>{{ $row->week }}</td>
                                                        <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
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
