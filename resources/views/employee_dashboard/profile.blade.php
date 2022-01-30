@extends('layouts.front')
@section('page_title','Partner Profile')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Partner Profile'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/hierarchy.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/jssocials/css/jssocials.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endpush
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Partner Profile','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Partner Profile','route'=>''],
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
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">Partner PROFILE</h5>
                            </div>
                            <div class="card-body">
                                @include('components.messages')
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive" style="margin-top: -40px;">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td align="center" colspan="2" style="border: none !important;">
                                                        <div class="heading_s1 justify-content-center mt-2">
                                                            <div class="user_photo text-center">
                                                                <img class="main-profile-img img-circle p-3" style="border-radius: 100%;" width="160" height="160" src="{{ (!empty(Auth::user()->profile_image))? asset(Auth::user()->profile_image) : asset('assets/images/avatar.png') }}" />
                                                            </div>
                                                            <h5 class="text-uppercase mt-2" style="margin-top: -15px;">{{ \auth::user()->name." ".\auth::user()->last_name }}</h5>
                                                            <p>{{ \auth::user()->email }}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td class="cart_total_label" width="39%" ><i class="ti-tag"></i> Partner ID</td>
                                                    <td class="cart_total_amount">{{ \Auth::user()->employee->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cart_total_label" width="39%" ><i class="ti-ticket"></i> Partner Code</td>
                                                    <td class="cart_total_amount" style="display: inline-flex"><a href="javascript:void(0)" class="copy_link_by_text" data-copy-code="{{ \auth::user()->user_code }}">{{ \Auth::user()->user_code }}</a></td>
                                                </tr>
                                                @if(\auth::user()->user_name)
                                                {{--<tr>--}}
                                                    {{--<td class="cart_total_label" width="39%" ><i class="ti-ticket"></i> Customs Partner Code</td>--}}
                                                    {{--<td class="cart_total_amount" style="display: inline-flex"><a href="javascript:void(0)" class="copy_link" data-copy-code="{{\auth::user()->user_name}}">{{ \Illuminate\Support\Str::limit(\Auth::user()->user_name, 15) }}</a> <button type="button" class="btn btn-secondary btn-group-sm ml-2 copy_link" style="display: inline-flex" data-copy-code="{{\auth::user()->user_name}}"><i class="fa fa-copy"></i></button></td>--}}
                                                {{--</tr>--}}
                                                @endif
                                                {{--<tr>--}}
                                                    {{--<td class="cart_total_label"><i class="ti-alarm-clock"></i> Requested Date</td>--}}
                                                    {{--<td class="cart_total_amount">{{ date('Y-m-d h:i:s A', strtotime(\Auth::user()->agent_request_date)) }}</td>--}}
                                                {{--</tr>--}}
                                                <tr>
                                                    <td class="cart_total_label"><i class="ti-alarm-clock"></i> Joined Date</td>
                                                    <td class="cart_total_amount">{{ date('Y-m-d h:i:s A', strtotime(\Auth::user()->employee->created_at)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cart_total_label" width="35%"><i class="fas fa-user-alt"></i> Your Referrer</td>
                                                    <td class="cart_total_amount">{{ \Auth::user()->employee->referral_info->user->name }} {{ \Auth::user()->employee->referral_info->user->last_name }}</td>
                                                </tr>
                                                {{--<tr>--}}
                                                    {{--<td class="cart_total_label"><i class="ti-user"></i> Introduce By</td>--}}
                                                    {{--<td class="cart_total_amount">{{ \Auth::user()->employee->referral_info->user->name }}</td>--}}
                                                {{--</tr>--}}
                                                {{--<tr>--}}
                                                    {{--<td class="cart_total_label"><i class="ti-user"></i> Placement</td>--}}
                                                    {{--<td class="cart_total_amount">{{ \Auth::user()->employee->placement_info->user->name }}</td>--}}
                                                {{--</tr>--}}
                                                <tr>
                                                    <td class="cart_total_label"><i class="ti-info"></i> Seller Status</td>
                                                    <td class="cart_total_amount">{!!  (!empty(\Auth::user()->employee->is_seller))? '<small class="badge badge-success p-2">Active</small>' : '<small class="badge badge-secondary p-2">In-Active</small>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cart_total_label"><i class="ti-id-badge"></i> Coupon Codes joined</td>
                                                    <td class="cart_total_amount">{{ (\App\UsedUserCoupons::where('partner_id',\Auth::user()->employee->id)->whereNull('is_deleted')->whereNull('user_code')->get()->count()) + (\App\UsedUserCoupons::where('partner_id',\Auth::user()->employee->id)->whereNull('is_deleted')->whereNotNull('user_code')->get()->count()) }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="background: #f8f8f8; border-radius: 10px;" class="mt-2">
                                            <?php function getEmpInfo($id){ return \App\Agent::where('id', $id)->firstOrFail(); } ?>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <p class="mt-3 ml-3">
                                                        <strong>Hierarchy Quick View</strong>
                                                    </p>
                                                    <hr/>
                                                    <div class="hierarchy-body hierarchy-scroll">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                <ol>
                                                                    <li>
                                                                        <h3 class="level-3 rectangle text-uppercase">({{ getEmpInfo(\Auth::user()->employee->id)->referral_info->user->id }}) {{ getEmpInfo(\Auth::user()->employee->id)->referral_info->user->name." ".getEmpInfo(\Auth::user()->employee->id)->referral_info->user->last_name[0] }}<br/><small class="text-lowercase text-capitalize text-sm">(Your Referral)</small></h3>
                                                                        <ol class="level-4-wrapper">
                                                                            @foreach(explode(',',\App\Agent::Where('id',\Auth::user()->employee->id)->first()->parents()) as $partner)
                                                                                @if(\Auth::user()->employee->referral_info->id == $partner)
{{--                                                                                    <li>--}}
{{--                                                                                        <h4 class="level-4 rectangle">({{ getEmpInfo($partner)->user->employee->id }}) {{ getEmpInfo($partner)->user->name." ".getEmpInfo($partner)->user->last_name[0] }}--}}
{{--                                                                                            <br/><small>(Your Referral)</small>--}}
{{--                                                                                        </h4>--}}
{{--                                                                                    </li>--}}
                                                                                @elseif($partner == \Auth::user()->employee->id)
                                                                                    <li>
                                                                                        <h4 class="level-4 rectangle" >({{ getEmpInfo($partner)->user->employee->id }}) {{ getEmpInfo($partner)->user->name." ".getEmpInfo($partner)->user->last_name[0] }} </h4>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ol>
                                                                    </li>
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td align="right"  style="border: none !important;">
                                                        <a href="{{ route('partners.hierarchy') }}" class="btn btn-line-fill btn-sm"><small>Detail View</small></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <!-- START SECTION WHY CHOOSE -->
                                        <div class="p-5" style="background: #fdfaea; border-radius: 10px;">
                                            <div class="">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="heading_s1 text-center">
                                                            <div class="icon">
                                                                <i class="fas fa-user-alt"></i>
                                                            </div>
                                                            <h2>Invite Your Friends</h2>
                                                        </div>
                                                        <p class="text-center leads" style="margin-top: -10px;">Invite your friends and followers to spread the good word of wellness. For starters you will earn extra points while your friends will receive lifetime membership discounts on every purchase they make, followed by numerous wellness benefits for everyone. Hurry up and share with your friends today!</p>
                                                        <div class="text-center">
                                                            <input type="hidden" value="{{ route('partners.register',[HashEncode(\auth::user()->employee->id), \Auth::user()->user_code]) }}" id="copy_url" />
                                                            <div id="shareRoundIcons"></div>
                                                            <input type="hidden" id="social_share_url" value="{{ route('partners.register',[HashEncode(\auth::user()->employee->id), \Auth::user()->user_code]) }}" />
                                                            <input type="hidden" id="social_share_title" value="{{ config('app.url') }} - Partner Register" />
                                                            <input type="hidden" id="social_share_description" value="Invite your friends and followers to spread the good word of wellness. For starters you will earn extra points while your friends will receive lifetime membership discounts on every purchase they make, followed by numerous wellness benefits for everyone. Hurry up and share with your friends today!" />
                                                            <button class="btn btn-sm btn-primary mb-3" onclick="copy_link()"><i class="fa fa-copy"></i> Copy Link</button>
                                                        </div>
                                                        <div class="align-content-center text-center p-2 d-block border mb-4">
                                                            <a href="javascript:void(0)" class="copy_link_partner_code" data-copy-code="{{ \Auth::user()->user_code }}">{{ \Auth::user()->user_code }}</a>
                                                            <button type="button" class="btn btn-fill-out ml-2 mr-2 copy_link_partner_code" data-copy-code="{{ \Auth::user()->user_code }}"><i class="fa fa-copy"></i> Copy Partner Code</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END SECTION WHY CHOOSE -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>Generate Custom Coupon Code</h5>
                            </div>
                            <div class="card-body">
                                <p>You can create three (3) ‘Coupon Codes’ for your partner account to share amongst your friends and followers, like your Instagram or TikTok user name etc. So be creative and choose wisely!</p>
                                <form action="{{ route('dashboard.add.coupon-codes') }}" method="POST">
                                    <input type="hidden" value="{{ \auth::user()->id }}" name="user_id" />
                                    @csrf
                                    <div class="form-group text-left">
                                        <div class="input-group mb-3">
                                            <input required=""
                                                   id="coupon_code"
                                                   class="form-control @error('code') is-invalid @enderror" name="code" type="text" placeholder="Your Coupon Code"
                                                   value="{{ old('code') }}">
                                            <div id="counter_code"></div>
                                            <p class="text-danger coupon_code_error"  style="margin-bottom:-2px; display: none;"></p>
                                            @error('code')
                                            <div class="form-control-feedback col-12 text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-fill-out btn-md" name="submit" value="Submit">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>Coupon Codes</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @if(\auth::user()->coupon_codes->count()>0)
                                            <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Coupon Code</th>
                                                    <th>No. Joined Referral</th>
                                                    <th>Created Date & Time</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(\auth::user()->coupon_codes as $row)
                                                    <tr>
                                                        <td>{{ $row->code }}
                                                            @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                                <small class="badge badge-info" style="font-size: 8px">New</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->joined_ref->count() }}</td>
                                                        <td>{{ date('d, M Y, h:i:s A', strtotime( $row->created_at)) }}</td>
                                                        <td align="center">
                                                            <button type="button" class="btn btn-fill-out ml-2 btn-block mr-2 copy_link" data-copy-code="{{ $row->code }}"><i class="fa fa-copy"></i> Copy Coupon Code</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class=""><i class="fa fa-info-circle"></i> No coupon code result found.</p>
                                        @endif
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
@push('js')
    <script src="{{ asset('administration/plugins/jssocials/js/jssocials.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/MaxLength.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $("[id*=coupon_code]").MaxLength(
            {
                MaxLength: 20,
                CharacterCountControl: $('#counter_coupon')
            });
    </script>
@endpush
@push('script')
    <script>
        $('#coupon_code').on('keypress', function (event) {
            var regex = new RegExp("^[A-z-0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) { event.preventDefault(); return false; }
            // if(event.which === 32)
            //     return false;
        });

        $(".copy_link").click(function(){
           var code =$(this).attr('data-copy-code');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(code).select();
            document.execCommand("copy");
            $temp.remove();
            swal("Code Copied", "Your Coupon Codes has been copied", "success");
        });
        $(".copy_link_partner_code").click(function(){
            var code =$(this).attr('data-copy-code');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(code).select();
            document.execCommand("copy");
            $temp.remove();
            swal("Code Copied", "Your partner invitation code has been copied", "success");
        });

        $(".copy_link_by_text").click(function(){
            var code =$(this).attr('data-copy-code');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(code).select();
            document.execCommand("copy");
            $temp.remove();
            swal("Code Copied", "Your partner invitation code has been copied", "success");
        });
        function copy_link() {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($("#copy_url").val()).select();
            document.execCommand("copy");
            $temp.remove();
            swal("Link Copied", "Your partner invitation link has been copied", "success");
        }
        $("#shareRoundIcons").jsSocials({
            url: $("#social_share_url").val(),
            text: $("#social_share_title").val(),
            description: $("#social_share_description").val(),
            shareIn: "popup",
            showCount: true,
            showLabel: false,
            shares: [
                {share:  "twitter", via: "{{ config('app.name') }}", hashtags: "{{ config('app.name') }}"},
                "facebook",
                "linkedin",
                "pinterest",
                "whatsapp",
            ]
        });
    </script>
@endpush
