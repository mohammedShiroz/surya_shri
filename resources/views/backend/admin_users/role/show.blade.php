@extends('backend.layouts.admin')
@section('page_title','View Role Details')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.alert')
@section('body_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="text-capitalize">{{ $data->name }} - Role Details</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                            <li class="breadcrumb-item active">View Role Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(session('active_tab')) @if(session()->get("active_tab")=='general_detail') active @endif @else active @endif"
                                           id="general_detail_tab" data-toggle="pill"
                                           href="#general_detail">General Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(session('active_tab') && session()->get("active_tab")=='permission_detail') active show @endif"
                                           id="permission_detail_tab" data-toggle="pill" href="#permission_detail">Permission</a>
                                    </li>
                                </ul>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content detail-list" id="pills-tabContent">
                            <div class="tab-pane fade @if(session('active_tab')) @if(session()->get("active_tab")=='general_detail') active show @endif @else show active @endif"
                                id="general_detail">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-question-circle-o pr-2"></i> Name</h5>
                                                            <strong>{{ $data->name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-eye pr-2"></i> Display Name</h5>
                                                            {!! $data->display_name !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-text-height pr-2"></i> Description</h5>
                                                            <strong>{{ ($data->description)? $data->description : '-' }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="callout callout-info">
                                                            <h5><i class="fa fa-calendar pr-2"></i> Created date & time</h5>
                                                            <strong>{{ date('Y-m-d h:i:s A', strtotime($data->created_at)) }}</strong>
                                                        </div>
                                                    </div>
                                                </div><!-- /.row -->
                                            </div><!--end card-body-->
                                        </div><!--end card-->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end general detail-->
                            <div
                                class="tab-pane fade @if(session('active_tab') && session()->get("active_tab")=='permission_detail') active show @endif"
                                id="permission_detail">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="media setting-card">
                                                        <div class="media-body align-self-center">
                                                            <div class="setting-detail">
                                                                <a href="javascript:void(0)" class="mb-0 mt-0 h5">{{$permission->display_name}}</a>
                                                                <p class="text-muted mb-0">{{$permission->description}}</p>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="custom-control custom-switch switch-dark mb-2 ">
                                                                    <input type="checkbox"
                                                                           class="custom-control-input"
                                                                           id="{{$permission->name}}"
                                                                           {{$data->hasPermission($permission->name)?'checked':''}} onchange="switchChange('form-{{$permission->id}}')">
                                                                    <label class="custom-control-label"
                                                                           for="{{$permission->name}}"></label>
                                                                    <form action="{{route('laratrus.role_permission')}}"
                                                                          method="POST" id="form-{{$permission->id}}">
                                                                        @csrf
                                                                        <input type="hidden" value="permission_detail"
                                                                               name="active_tab">
                                                                        <input type="hidden" name="role_id"
                                                                               value="{{HashEncode($data->id)}}">
                                                                        <input type="hidden" name="permission_id"
                                                                               value="{{HashEncode($permission->id)}}">
                                                                        <input type="hidden"
                                                                               name="type"
                                                                               value="{{$data->hasPermission($permission->name)?'detach':'attach'}}">
                                                                    </form>
                                                                </div><!--end btn-group-->
                                                            </div> <!--end /div-->
                                                        </div><!--end media body-->
                                                    </div><!--end media-->
                                                </div><!--end card-body-->
                                            </div><!--end card-->
                                        </div>
                                    @endforeach
                                </div><!--end row-->
                            </div><!--end education detail-->
                        </div><!--end tab-content-->
                    </div><!--end col-->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('script')
    <script>
        function switchChange(form) {
            $('#' + form).submit();
        }
    </script>
@endpush
