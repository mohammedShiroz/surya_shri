<div class="modal fade" id="modal-view">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #837000;">
                <h4 class="modal-title text-white" id="title">Visitor Info</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>ID</td>
                                        <td id="v_id"></td>
                                    </tr>
                                    <tr>
                                        <td>IP</td>
                                        <td id="v_ip"></td>
                                    </tr>
                                    <tr>
                                        <td>Browser</td>
                                        <td id="v_browser"></td>
                                    </tr>
                                    <tr>
                                        <td>OS</td>
                                        <td id="v_os"></td>
                                    </tr>
                                    <tr>
                                        <td>Count Views</td>
                                        <td id="v_count_view"></td>
                                    </tr>
                                    <tr>
                                        <td>User Name</td>
                                        <td id="v_user_name"></td>
                                    </tr>
                                    <tr>
                                        <td>Country Code</td>
                                        <td id="v_countrycode"></td>
                                    </tr>
                                    <tr>
                                        <td>Country Name</td>
                                        <td id="v_countryname"></td>
                                    </tr>
                                    <tr>
                                        <td>Capital & City</td>
                                        <td id="v_capital_city"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Region</td>
                                        <td id="v_regionname"></td>
                                    </tr>
                                    <tr>
                                        <td>Zip_code</td>
                                        <td id="v_zip_code"></td>
                                    </tr>

                                    <tr>
                                        <td>Time Zone</td>
                                        <td id="v_time_zone"></td>
                                    </tr>
                                    <tr>
                                        <td>GEONAME Id</td>
                                        <td id="v_geoname_id"></td>
                                    </tr>
                                    <tr>
                                        <td>Connection ASN</td>
                                        <td id="v_connection_asn"></td>
                                    </tr>
                                    <tr>
                                        <td>Connection ISP</td>
                                        <td id="v_connection_isp"></td>
                                    </tr>
                                    <tr>
                                        <td>Last Seen</td>
                                        <td id="v_lastseen"></td>
                                    </tr>
                                    <tr>
                                        <td>Visited Seen</td>
                                        <td id="v_visited"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                    <table class="table">
                                        <tbody>

                                        <tr>
                                            <td>Country Languages</td>
                                            <td id="v_languages"></td>
                                        </tr>
                                        <tr>
                                            <td>GEO Location<br/><small>(Latitude & Longitude}</small></td>
                                            <td id="v_latitude"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="stop-hacking btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="fa fa-times"></i>
                    Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
