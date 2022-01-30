@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fa fa-check-circle"></i> Success</strong> {!! $message !!}
    </div>
@endif
@if ($message = Session::get('partner_approved_success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fa fa-check-circle"></i></strong> {!! $message !!}
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fa fa-times-circle"></i> Error</strong> {{ $message }}
    </div>
@endif
@if(Session::has('old_password_error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fa fa-times-circle"></i> Oops</strong> {{Session::get('old_password_error')}}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <ul style="margin-left: 20px; list-style: none;">
            @foreach ($errors->all() as $error)
                <li><strong><i class="fa fa-times-circle mr-1"></i></strong> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{--@if($errors->has('email'))--}}
    {{--<div class="msg-alert">--}}
        {{--<span class="msg-closebtn">&times;</span>--}}
        {{--<strong><i class="fa fa-info-circle fa-lg"></i></strong>&nbsp; {{ $errors->first('email') }}--}}
    {{--</div>--}}
{{--@endif--}}
{{--@if($errors->has('password'))--}}
    {{--<div class="msg-alert">--}}
        {{--<span class="msg-closebtn">&times;</span>--}}
        {{--<strong><i class="fa fa-info-circle fa-lg"></i></strong>&nbsp; {{ $errors->first('password') }}--}}
    {{--</div>--}}
{{--@endif--}}
