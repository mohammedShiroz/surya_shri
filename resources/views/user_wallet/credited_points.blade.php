@extends('layouts.front')
@section('page_title','Received Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Received Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Received Points','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'Received Points','route'=>''],
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
                                <h5 class="text-uppercase">Received Points</h5>
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
                                                        <p>Total Received Points</p>
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
                                @if(\App\Points::where('forward_user_id',\auth::user()->id)->get()->count() > 0)
                                <table id="data_table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Partner Name</th>
                                        <th>Partner ID</th>
                                        <th>Received Points</th>
                                        <th>Type</th>
                                        <th>Credited Date & Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(\App\Points::where('forward_user_id',\auth::user()->id)->get() as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $row->user_info->name }}</td>
                                            <td>{{ $row->user_info->employee->id }}</td>
                                            <td>{{ getPointsFormat($row->forward_points) }}</td>
                                            <td>Received</td>
                                            <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <p class="border p-3"><i class="fa fa-info-circle"></i> No Received Points Yet</p>
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
