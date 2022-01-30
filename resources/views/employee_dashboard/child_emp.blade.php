@if(request()->routeIs('partners.hierarchy'))
<ul>
    @foreach($child_employees as $parent)
        <li>
            <a href="javascript:void(0);">
                <div class="member-view-box">
                    <div class="member-image">
                        <img src="{{ (!empty($parent->user->profile_image))? asset($parent->user->profile_image) : asset('assets/images/avatar.png') }}" alt="Member">
                        <div class="member-details">
                            <h6 class="text-capitalize pop-up-hover">({{ getEmpInfo($parent->id)->user->employee->id }}) {{ getEmpInfo($parent->id)->user->name.((getEmpInfo($parent->id)->user->last_name)? " ".getEmpInfo($parent->id)->user->last_name[0] : '') }}
                                <div class="pop-body">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td align="left">No. of Referrals</td>
                                            <td align="right">{{ numberOfPartners($parent->id) }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left">Coupon Code</td>
                                            <td align="right">{{ \getEmpInfo($parent->id)->user->coupon_codes->first->code? getEmpInfo($parent->id)->user->coupon_codes->first->code['code'] : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left">Total Commissions Earnings</td>
                                            <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo($parent->id)->user->id)["total_in_direct_points"]) }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left">Total Network Sales</td>
                                            <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('partner_id',$parent->id)->get()->sum('paid_amount'))  }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left">Joined Date</td>
                                            <td align="right">{{ date('Y-m-d h:i:s A', strtotime(getEmpInfo($parent->id)->user->created_at)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </h6>
                        </div>
                    </div>
                </div>
            </a>
            @if($parent->child_employees->isNotEmpty())
                    @include('employee_dashboard.child_emp', [
                        'child_employees' => $parent->child_employees
                    ])
            @endif
        </li>
    @endforeach
</ul>
@endif
@if(request()->routeIs('partners.view.hierarchy'))
    <ul>
        @foreach($child_employees as $parent)
            <li>
                <a href="javascript:void(0);">
                    <div class="member-view-box">
                        <div class="member-image">
                            <img src="{{ (!empty($parent->user->profile_image))? asset($parent->user->profile_image) : asset('assets/images/avatar.png') }}" alt="Member">
                            <div class="member-details">
                                <h6 class="text-capitalize pop-up-hover">({{ getEmpInfo($parent->id)->user->employee->id }}) {{ getEmpInfo($parent->id)->user->name.((getEmpInfo($parent->id)->user->last_name)? " ".getEmpInfo($parent->id)->user->last_name[0] : '') }}
                                    <div class="pop-body">
                                        <table class="table table-bordered table-striped w-100">
                                            <tr>
                                                <td align="left">Number of Partners </td>
                                                <td align="right">{{ numberOfPartners($parent->id) }}</td>
                                            </tr>
                                            <tr>
                                                <td align="left">Total Commissions Earnings</td>
                                                <td align="right">{{ getPointsFormat(getCalPointsByUser(getEmpInfo($parent->id)->user->id)["total_in_direct_points"]) }}</td>
                                            </tr>
                                            <tr>
                                                <td align="left">Total Network Sales</td>
                                                <td align="right">{{ getCurrencyFormat(\App\Seller_payments::where('partner_id',$parent->id)->get()->sum('paid_amount'))  }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </h6>
                            </div>
                        </div>
                    </div>
                </a>
                @if($parent->child_employees->isNotEmpty())
                    @include('employee_dashboard.child_emp', [
                        'child_employees' => $parent->child_employees
                    ])
                @endif
            </li>
        @endforeach
    </ul>
@endif

<!-- Normal View -->
@if(request()->routeIs('partners.profile'))
<ul>
    @foreach($child_employees as $parent)
        <li><span><small class="badge badge-secondary text-black-50 mb-1 mr-1" style="border-radius: 100%; background: transparent; border: 1px solid grey;">{{ $parent->id }}</small> {{ getEmpInfo($parent->id)->user->name." ".getEmpInfo($parent->id)->user->last_name }}</span>
            @if($parent->child_employees->isNotEmpty())
                    @include('employee_dashboard.child_emp', [
                        'child_employees' => $parent->child_employees
                    ])
            @endif
        </li>
    @endforeach
</ul>
@endif
@if(request()->routeIs('partners.show') || request()->routeIs('sellers.show'))
    <ul>
        @foreach($child_employees as $parent)
            <li><a href="{{ route('partners.show', $parent->user->id)}}"><span class="{{ isset($data->employee->id)? ($data->employee->id == $parent->id)? 'alerts-border': '' : '' }}"><small class="badge badge-secondary text-black-50 mb-1 mr-1" style="border-radius: 100%; background: transparent; border: 1px solid grey;">{{ $parent->id }}</small> {{ getEmpInfo($parent->id)->user->name." ".getEmpInfo($parent->id)->user->last_name }}</span></a>
                @if($parent->child_employees->isNotEmpty())
                    @include('employee_dashboard.child_emp', [
                        'child_employees' => $parent->child_employees
                    ])
                @endif
            </li>
        @endforeach
    </ul>
@endif


