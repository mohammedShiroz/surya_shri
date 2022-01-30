@extends('layouts.front')
@section('page_title','Partner Hierarchy')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Partner Hierarchy'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.hierarchy')
@include('backend.components.plugins.data_table_front')
@push('css')
    <style>
        .pop-up-hover {
            transition: all 0.3s ease;
            z-index: 10000;
        }
        .pop-up-hover:hover {
            background: rgba(246, 246, 246, 0.3);
        }
        .pop-up-hover:hover > .pop-body {
            opacity: 1;
            padding-top: 15px;
            width: auto;
            height: auto;
        }
        .pop-body {
            opacity: 0;
            width: 0;
            height: 0;
            margin: auto;
            transition: all 0.3s ease;
        }
    </style>
@endpush
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Partner Hierarchy','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        3=>['name'=>'Partner Hierarchy','route'=>''],
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
                                <h5 class="text-uppercase">Partner Hierarchy</h5>
                            </div>
                            <div class="card-body">
                                @include('components.messages')
                                <?php function getEmpInfo($id){ return \App\Agent::where('id', $id)->firstOrFail(); } ?>
                                @php
                                    $emp_count =0;
                                    function numberOfPartners($id){
                                        global $emp_count;
                                        $emp_count =0;
                                        foreach (\App\Agent::Where('placement_id',$id)->get() as $emp){
                                            $emp_count++; if($emp->child_employees->isNotEmpty()){ show_emp($emp->child_employees); }
                                        }
                                        return $emp_count;
                                    }
                                    function show_emp($child_employees){
                                        global $emp_count;
                                        foreach($child_employees as $parent){
                                            $emp_count ++;
                                            if($parent->child_employees->isNotEmpty()){ show_emp($parent->child_employees); }
                                        }
                                    }
                                @endphp
                                <div class="genealogy-body genealogy-scroll">
                                    <div class="genealogy-tree">
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="member-view-box">
                                                        <div class="member-image">
                                                            <img src="{{ asset('assets/images/logo_loader.png') }}" alt="Company">
                                                            <div class="member-details">
                                                                <h6 class="text-capitalize pop-up-hover">{{ env('APP_NAME') }}<br/><small>Company</small>
                                                                    <div class="pop-body">
                                                                        <table class="table table-bordered table-striped">
{{--                                                                            <tr>--}}
{{--                                                                                <td align="left">Partner Name</td>--}}
{{--                                                                                <td align="right">Company</td>--}}
{{--                                                                            </tr>--}}
{{--                                                                            <tr>--}}
{{--                                                                                <td align="left">Partner ID</td>--}}
{{--                                                                                <td align="right">1</td>--}}
{{--                                                                            </tr>--}}
                                                                            <tr>
                                                                                <td align="left">No. of Referrals</td>
                                                                                <td align="right">{{ numberOfPartners(getEmpInfo(1)) }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left">Coupon Code</td>
                                                                                <td align="right">{{ \App\User::find(1)->coupon_codes->first->code? \App\User::find(1)->coupon_codes->first->code['code'] : '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left">Total Commissions Earnings</td>
                                                                                <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo(1)->user->id)["total_in_direct_points"]) }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left">Total Network Sales</td>
                                                                                <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('partner_id',1)->get()->sum('paid_amount'))  }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left">Joined Date</td>
                                                                                <td align="right">{{ date('Y-m-d h:i:s A', strtotime(\auth::user()->created_at)) }}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul class="active">
                                                    <li>
                                                        <a href="javascript:void(0);">
                                                            <div class="member-view-box">
                                                                <div class="member-image">
                                                                    <img src="{{ (!empty(\Auth::user()->employee->referral_info->user->profile_image))? asset(\Auth::user()->employee->referral_info->user->profile_image) : asset('assets/images/avatar.png') }}" alt="Member">
                                                                    <div class="member-details">
                                                                        <h6 class="text-capitalize pop-up-hover">({{ \Auth::user()->employee->referral_info->user->employee->id }}) {{ \Auth::user()->employee->referral_info->user->name }} {{ (\Auth::user()->employee->referral_info->user->last_name)? " ".\Auth::user()->employee->referral_info->user->last_name[0] : '' }}<br/><small>(Your Referral)</small>
                                                                            <div class="pop-body">
                                                                                <table class="table table-bordered table-striped">
{{--                                                                                    <tr>--}}
{{--                                                                                        <td align="left">Partner Name</td>--}}
{{--                                                                                        <td align="right">{{ \Auth::user()->employee->referral_info->user->name ." ".(\Auth::user()->employee->referral_info->user->last_name)? \Auth::user()->employee->referral_info->user->last_name : '' }}</td>--}}
{{--                                                                                    </tr>--}}
{{--                                                                                    <tr>--}}
{{--                                                                                        <td align="left">Partner ID</td>--}}
{{--                                                                                        <td align="right">{{ \Auth::user()->employee->referral_info->user->employee->id }}</td>--}}
{{--                                                                                    </tr>--}}
                                                                                    <tr>
                                                                                        <td align="left">No. of Referrals</td>
                                                                                        <td align="right">{{ numberOfPartners(getEmpInfo(\Auth::user()->employee->referral_info->id)->id) }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left">Coupon Code</td>
                                                                                        <td align="right">{{ getEmpInfo(\Auth::user()->employee->referral_info->id)->user->coupon_codes->first->code? getEmpInfo(\Auth::user()->employee->referral_info->id)->user->coupon_codes->first->code['code'] : '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left">Total Commissions Earnings</td>
                                                                                        <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo(\Auth::user()->employee->referral_info->id)->user->id)["total_in_direct_points"]) }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left">Total Network Sales</td>
                                                                                        <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('partner_id',\auth::user()->employee->referral_info->id)->get()->sum('paid_amount'))  }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left">Joined Date</td>
                                                                                        <td align="right">{{ date('Y-m-d h:i:s A', strtotime(getEmpInfo(\Auth::user()->employee->referral_info->id)->user->created_at)) }}</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box">
                                                                        <div class="member-image">
                                                                            <img src="{{ (!empty(Auth::user()->profile_image))? asset(Auth::user()->profile_image) : asset('assets/images/avatar.png') }}" alt="Member">
                                                                            <div class="member-details">
                                                                                <h6 class="text-capitalize pop-up-hover">({{ \auth::user()->employee->id }}) {{ \auth::user()->name.((\auth::user()->last_name)? " ".\auth::user()->name[0] : '') }}
                                                                                    <div class="pop-body">
                                                                                        <table class="table table-bordered table-striped">
{{--                                                                                            <tr>--}}
{{--                                                                                                <td align="left">Partner Name</td>--}}
{{--                                                                                                <td align="right">{{ \auth::user()->name.((\auth::user()->name)? " ".\auth::user()->last_name : '') }}</td>--}}
{{--                                                                                            </tr>--}}
{{--                                                                                            <tr>--}}
{{--                                                                                                <td align="left">Partner ID</td>--}}
{{--                                                                                                <td align="right">{{ \auth::user()->employee->id }}</td>--}}
{{--                                                                                            </tr>--}}
                                                                                            <tr>
                                                                                                <td align="left">No. of Referrals</td>
                                                                                                <td align="right">{{ numberOfPartners(\auth::user()->employee->id) }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="left">Coupon Code</td>
                                                                                                <td align="right">{{ \auth::user()->coupon_codes->first->code? \auth::user()->coupon_codes->first->code['code'] : '-' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="left">Total Commissions Earnings</td>
                                                                                                <td align="right">{{ getPointsFormat(getCalPointsByUser(\auth::user()->id)["total_in_direct_points"]) }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="left">Total Network Sales</td>
                                                                                                <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('partner_id',\auth::user()->employee->id)->get()->sum('paid_amount'))  }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="left">Joined Date</td>
                                                                                                <td align="right">{{ date('Y-m-d h:i:s A', strtotime(\auth::user()->created_at)) }}</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                @if(\App\Agent::Where('placement_id',\Auth::user()->employee->id)->get()->count() > 0)
                                                                    <ul>
                                                                        @foreach (\App\Agent::Where('placement_id',\Auth::user()->employee->id)->get() as $emp)
                                                                            <li>
                                                                                <a href="javascript:void(0);">
                                                                                    <div class="member-view-box">
                                                                                        <div class="member-image">
                                                                                            <img src="{{ (!empty($emp->user->profile_image))? asset($emp->user->profile_image) : asset('assets/images/avatar.png') }}" alt="Member">
                                                                                            <div class="member-details">
                                                                                                <h6 class="text-capitalize pop-up-hover">({{ getEmpInfo($emp->id)->user->employee->id }}) {{ getEmpInfo($emp->id)->user->name.((getEmpInfo($emp->id)->user->last_name)? " ".getEmpInfo($emp->id)->user->last_name[0] : '') }}
                                                                                                    <div class="pop-body">
                                                                                                        <table class="table table-bordered table-striped">
{{--                                                                                                            <tr>--}}
{{--                                                                                                                <td align="left">Partner Name</td>--}}
{{--                                                                                                                <td align="right">{{ getEmpInfo($emp->id)->user->name." ".getEmpInfo($emp->id)->user->last_name }}</td>--}}
{{--                                                                                                            </tr>--}}
{{--                                                                                                            <tr>--}}
{{--                                                                                                                <td align="left">Partner ID</td>--}}
{{--                                                                                                                <td align="right">{{ $emp->id }}</td>--}}
{{--                                                                                                            </tr>--}}
                                                                                                            <tr>
                                                                                                                <td align="left">No. of Referrals</td>
                                                                                                                <td align="right">{{ numberOfPartners($emp->id) }}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="left">Coupon Code</td>
                                                                                                                <td align="right">{{ \getEmpInfo($emp->id)->user->coupon_codes->first->code? getEmpInfo($emp->id)->user->coupon_codes->first->code['code'] : '-' }}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="left">Total Commissions Earnings</td>
                                                                                                                <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo($emp->id)->user->id)["total_in_direct_points"]) }}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="left">Total Network Sales</td>
                                                                                                                <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('partner_id',$emp->id)->get()->sum('paid_amount'))  }}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="left">Joined Date</td>
                                                                                                                <td align="right">{{ date('Y-m-d h:i:s A', strtotime(getEmpInfo($emp->id)->user->created_at)) }}</td>
                                                                                                            </tr>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </h6>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                                @if($emp->child_employees->isNotEmpty())
                                                                                    @include('employee_dashboard.child_emp', [
                                                                                        'child_employees' => $emp->child_employees
                                                                                    ])
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="text-uppercase">My Down Liners</h5>
                            </div>
                            @php
                                $upliners =null;
                                function liner_partner($id){
                                    global $upliners;
                                    $partners= \App\Agent::Where('placement_id',$id)->get();
                                    foreach ($partners as $key=>$emp){
                                            $upliners .= $emp->id.",";
                                        if($emp->child_employees->isNotEmpty()){ show_emps($emp->child_employees); }
                                    }
                                    return $upliners;
                                }
                                function show_emps($child_employees){
                                    global $upliners;
                                    foreach($child_employees as $key=>$parent){
                                        $upliners .= $parent->id.",";
                                        if($parent->child_employees->isNotEmpty()){ show_emps($parent->child_employees); }
                                    }
                                }
                            @endphp
                            <div class="card-body">
                                <table id="data_table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Partner Name</th>
                                        <th>Partner ID</th>
                                        <th>Coupon Code</th>
                                        <th>Sales Down</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(explode(',',liner_partner(\Auth::user()->employee->id)) as $id)
                                        @if($id)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ getEmpInfo($id)->user->name." ".getEmpInfo($id)->user->last_name }}</td>
                                                <td>{{ getEmpInfo($id)->user->id }}</td>
                                                <td>
                                                    @if(getEmpInfo($id)->user->coupon_codes->count()>0)
                                                        @foreach(getEmpInfo($id)->user->coupon_codes as $row)
                                                            @if($loop->last) {{ $row->code }} @else {!! $row->code."<br/>" !!} @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ getPointsFormat(\App\Points_Commission::where('user_id',\auth::user()->id)->where('type','User')->where('agent_id',$id)->get()->sum('commission_points'))  }}</td>
                                                <td>
                                                    <div class="mb-2" role="group" aria-label="Basic example">
                                                        <a href="{{ route('partners.hierarchy.commission',HashEncode(getEmpInfo($id)->user->id)) }}" class="btn btn-line-fill btn-radius btn-sm"><small>View Details</small></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
