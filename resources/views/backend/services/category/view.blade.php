@extends('backend.layouts.admin')
@section('page_title','service Category Detail')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.slugify')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>{{ $data->name }} - service Category Detail</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service-category.index') }}">Service Categories</a></li>
                            <li class="breadcrumb-item active">{{ $data->name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Name</h5>
                            <strong>{{ $data->name }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-eye pr-2"></i> Visibility</h5>
                            {!! ($data->visibility == 1)? '<span class="badge badge-success pl-3 pr-3">Visible</span>': '<span class="badge badge-danger pl-3 pr-3">Hidden</span>' !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-list-alt pr-2"></i> Rank</h5>
                            <strong>{{ ($data->order == null)? 0 : $data->order }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-text-height pr-2"></i> Description</h5>
                            <strong>{{ ($data->description)? $data->description : '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-calendar pr-2"></i> Created date & time</h5>
                            <strong>{{ date('Y-m-d h:i:s A', strtotime($data->created_at)) }}</strong>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
