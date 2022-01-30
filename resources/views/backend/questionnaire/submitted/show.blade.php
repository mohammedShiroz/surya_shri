@extends('backend.layouts.admin')
@section('page_title','Question Details')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@section('body_content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Submitted Questionnaires Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('submitted-questionnaires.index') }}">Submitted Questionnaires</a></li>
                        <li class="breadcrumb-item active">View Submitted Questionnaires details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{--<div class="callout callout-info">--}}
                        {{--<h5><strong><i class="fa fa-tags pr-2"></i> Question Type:</strong> {{ $data->category->name }}</h5>--}}
                    {{--</div>--}}
                    <div class="callout callout-info">
                        <h5><i class="fas fa-user-alt pr-2"></i> User Name & ID</h5>
                        <strong>({{ $data->user->id }}) {{ $data->user->name." ".$data->user->last_name }}</strong>
                    </div>
                </div>
                <div class="col-4">
                    <div class="callout callout-info">
                        <h5><i class="fa fa-pie-chart pr-2"></i> Vata</h5>
                        <strong>{{ $data->vata."%" }}</strong>
                    </div>
                </div>
                <div class="col-4">
                    <div class="callout callout-info">
                        <h5><i class="fa fa-pie-chart pr-2"></i> Pitta </h5>
                        <strong>{{ $data->pitta."%" }}</strong>
                    </div>
                </div>
                <div class="col-4">
                    <div class="callout callout-info">
                        <h5><i class="fa fa-pie-chart pr-2"></i> Kapha </h5>
                        <strong>{{ $data->kapha."%" }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice">
                        <!-- title row -->
                        <div class="card-body">
                            <h4>Answered Questions</h4>
                            <div class="row">
                                @php
                                function answer($id){
                                    return \App\Answers::find($id);
                                }
                                @endphp
                                @foreach(explode(',',$data->answer_ids) as $key=>$answer_id)
                                <div class="col-12">
                                    <div class="callout callout-info">
                                        <h5><i class="fa fa-question-circle pr-2"></i> {{ answer($answer_id)->question->question }} </h5>
                                        <i class="fa fa-check-circle pr-2"></i> {{ answer($answer_id)->answer }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
