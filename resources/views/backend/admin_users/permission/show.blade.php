@extends('backend.layouts.admin')
@section('page_title','View Permission Details')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.alert')
@section('body_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="text-capitalize">{{ $data->name }} - Permission Details</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permissions</a></li>
                            <li class="breadcrumb-item active">View Permission Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content detail-list" id="pills-tabContent">
                            <div class="tab-pane fade @if(session('active_tab')) @if(session()->get("active_tab")=='general_detail') active show @endif @else show active @endif "
                                 id="general_detail">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5>Permission Name</h5>
                                                            <strong>{{ $data->name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5>Permission Display Name</h5>
                                                            {!! $data->display_name !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5>Permission Description</h5>
                                                            <strong>{{$data->description}}</strong>
                                                        </div>
                                                    </div>
                                                </div><!-- /.row -->
                                            </div><!--end card-body-->
                                        </div><!--end card-->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end general detail-->
                        </div><!--end tab-content-->
                    </div><!--end col-->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
