@if(\Auth::user()->agent_status == "Not Approved")
    <div class="col-lg-12 col-sm-12 mt-3">
        <div class="card" >
            <div class="card-body">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-6 offset-md-1">
                        <div class="medium_divider d-none d-md-block clearfix"></div>
                        <div class="trand_banner_text text-center text-md-left">
                            <div class="heading_s1 mb-3">
                                <span class="sub_heading">New Member</span>
                                <h2 class="text-uppercase">Become a Partner</h2>
                            </div>
                            <p class="mb-4" style="margin-top: -15px;">If you are one of our partner? you can have variety of benefits. you can earn more points and more...</p>
                            <a href="#" class="btn btn-fill-out rounded-0" data-toggle="modal" data-target="#employee-Request-popup">Start Now</a>
                        </div>
                        <div class="medium_divider clearfix"></div>
                    </div>
                    <div class="col-md-5">
                        <div class="text-center trading_img mt-3">
                            <img src="{{ asset('assets//images/become_employee.jpg') }}" alt="employee request"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(\Auth::user()->agent_status == "Requested")
    <div class="col-lg-12 col-sm-12 mt-3">
        <div class="card" >
            <div class="card-body">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-6 offset-md-1">
                        <div class="medium_divider d-none d-md-block clearfix"></div>
                        <div class="trand_banner_text text-center text-md-left">
                            <div class="heading_s1 mb-3">
                                <span class="sub_heading">New Member</span>
                                <h2 class="text-uppercase">Become a Partner</h2>
                            </div>
                            <p class="mb-4 text-success" style="margin-top: -15px;">Congratulations your request progressing on it. please be patient until we approve your request.</p>
                            <button class="btn btn-fill-out rounded-0" disabled=""><i class="fa fa-spin fa-spinner"></i> Requesting ...</button>
                        </div>
                        <div class="medium_divider clearfix"></div>
                    </div>
                    <div class="col-md-5">
                        <div class="text-center trading_img mt-3">
                            <img src="{{ asset('assets//images/become_employee.jpg') }}" alt="employee request"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(\Auth::user()->agent_status == "Approved")
    <div class="col-lg-12 col-sm-12 mt-3">
        <div class="tab-content dashboard_content">
            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                 aria-labelledby="dashboard-tab">
                <div class="card" >
                    <div class="card-header">
                        <h5 class="text-uppercase text-center">Partner Account</h5>
                    </div>
                    <div class="card-body">
                        @include('employee_dashboard.nav.layout')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
