@extends('backend.layouts.admin')
@section('page_title','Profile')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Profile Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ asset('administration/img/admin_avatar.png') }}"
                                         alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ \auth::user()->name }}</h3>
                                <p class="text-muted text-center mt-n2">{{ \auth::user()->job_title }}</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Access Level</b> <a class="float-right">{{ \auth::user()->role_user->role->display_name }}</a>
                                    </li>
                                </ul>
                                <a href="{{ route('admin.logout') }}" class="btn btn-primary btn-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link @if(session('active_tab')) @if(session()->get("active_tab")=='profile_detail') active @endif @else active @endif" href="#settings" data-toggle="tab">Profile Setting</a></li>
                                    <li class="nav-item"><a class="nav-link @if(session('active_tab') && session()->get("active_tab")=='password_detail') active show @endif" href="#change_password" data-toggle="tab">Change password</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane @if(session('active_tab')) @if(session()->get("active_tab")=='profile_detail') active show @endif @else show active @endif" id="settings">
                                        <form class="form-horizontal" method="Post" action="{{ route('admin.update_profile') }}">
                                           @csrf
                                            <input type="hidden" value="profile_detail" name="active_tab">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" id="inputName" value="{{ old('name')? old('name') : \auth::user()->name }}" autofocus placeholder="Name">
                                                    @error('name')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" disabled class="form-control @error('name') is-invalid @enderror" id="inputEmail" name="email" placeholder="Email" value="{{ old('email')? old('email') : \auth::user()->email }}">
                                                    @error('email')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Contact</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control @error('contact') is-invalid @enderror" id="inputEmail" name="contact" placeholder="Contact" value="{{ old('contact')? old('contact') : \auth::user()->contact }}">
                                                    @error('contact')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Designation</label>
                                                <div class="col-sm-10">
                                                    @permission(['update-designation'])
                                                        <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="inputName2" value="{{ old('job_title')? old('job_title') : \auth::user()->job_title }}" placeholder="Designation" name="job_title">
                                                    @else
                                                        <input type="text" disabled="" class="form-control @error('job_title') is-invalid @enderror" id="inputName2" value="{{ old('job_title')? old('job_title') : \auth::user()->job_title }}" placeholder="Designation" name="job_title">
                                                    @endpermission
                                                    @error('job_title')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-info">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane @if(session('active_tab') && session()->get("active_tab")=='password_detail') active show @endif" id="change_password">
                                        <form class="form-horizontal" method="Post" action="{{ route('admin.change_password') }}">
                                            @csrf
                                            <input type="hidden" value="password_detail" name="active_tab">
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Old Password <span class="required">*</span></label>
                                                <div class="col-sm-10">
                                                    <input id="old_password" type="password" class="form-control {{ \Session::has('old_password_error') ? ' is-invalid' : '' }}" name="old_password" placeholder="Your Old Password" required>
                                                    @if(\Session::has('old_password_error'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{Session::get('old_password_error')}}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">New Password</label>
                                                <div class="col-sm-10">
                                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Your New Password" required>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">New Password</label>
                                                <div class="col-sm-10">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-info">Change Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
