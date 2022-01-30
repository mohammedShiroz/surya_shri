@extends('layouts.front')
@section('page_title','View Commission Details')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('View Commission Details'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@include('backend.components.plugins.alert')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'View Commission Details','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        3=>['name'=>'Partner Hierarchy','route'=>route('partners.hierarchy')],
        4=>['name'=>'Commission Details','route'=>''],
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
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-uppercase">{{ $data->name." ".$data->last_name }} COMMISSION DETAILS</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" >
                                            <div class="col-12">
                                                <table id="data_table" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="pt-2">Partner Name & ID</th>
                                                        <th>Commission</th>
                                                        <th>Type</th>
                                                        <th>Received Date & Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(\App\Points_Commission::where('user_id',\auth::user()->id)->where('type','User')->where('agent_id',$data->employee->id)->get() as $row)
                                                        <tr>
                                                            <td>{{ $loop->index+1 }}</td>
                                                            <td>({{ $data->id }}) {{ $data->name." ".$data->last_name }}</td>
                                                            <td>{{ getPointsFormat($row->commission_points) }}</td>
                                                            <td>@if($row->order) Product Purchase @elseif($row->booking) Service Reservation @else - @endif</td>
                                                            <td>{{  date('d, M Y, h:i:s A', strtotime($row->created_at)) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
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
