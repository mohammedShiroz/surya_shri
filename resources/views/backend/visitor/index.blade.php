@extends('backend.layouts.admin')
@section('page_title','Web Visitors')
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
                        <h1>Web Visitors</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Web Visitors</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="margin" style="margin-bottom: 10px;">
                            <div class="btn-group">
                                <a href="" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Web Visitors Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>IP</th>
                                        <th>View Count</th>
                                        <th>Country &amp; City </th>
                                        <th>Browser - OS</th>
                                        <th>Last Seen</th>
                                        <th>Action <i class="fa fa-cogs bigger-110"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($visitors)>0)
                                        @foreach($visitors as $visitor)
                                            <tr id="delete-rec-{{$visitor->id}}">
                                                <td>{{ $loop->index+1 }}</td>
                                                <td> {{ $visitor->ip }}
                                                    @if((new DateTime($visitor->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                    @endif
                                                    @if(empty($visitor->viewstatus))
                                                        <span class="badge badge-warning float-right" id="status-{{ $visitor->id }}" style="margin-right:5px;">Unseen</span>
                                                    @endif
                                                </td>
                                                <td>{{ $visitor->view_count }}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            @if( isset($visitor->country_flag))
                                                                <img style="margin-top:3px; width:40px;" src="{{ $visitor->country_flag}}" alt="{{ $visitor->country_name}}" />
                                                            @else
                                                                <img style="margin-top:8px; width:40px;" src="{{ asset('admin/no_flag.png') }}" alt="No flag" />
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-9">
                                                            Country: {{  $visitor->country_name}} <br/>City: {{ $visitor->city }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ preg_replace('/[^a-z-]/i', '',$visitor->browser)}} - {{ $visitor->os }}</td>
                                                <td title="{{ $visitor->updated_at}}- {{ $visitor->created_at}}"> {{ isset($visitor->last_visit) ? $visitor->last_visit : ''}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-view" onclick="view_data({{$visitor->id }})"><i class="fas fa-eye"></i> View</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('script')
    <script>
        var get_temp_id;
        function view_data(id) {
            get_temp_id=id;
            var loc_lat;
            var loc_lng;
            $.ajax({
                type: 'get',
                url: '/admin/get-visitors-info',
                data:{'id':get_temp_id},
                success:function(data) {
                    document.getElementById("title").innerHTML = data['ip'] + " Details";
                    document.getElementById("v_id").innerHTML = data.id;
                    document.getElementById("v_ip").innerHTML = data.ip;
                    document.getElementById("v_browser").innerHTML = data.browser;
                    document.getElementById("v_os").innerHTML = data.os;
                    document.getElementById("v_count_view").innerHTML = data.user_view_count;
                    document.getElementById("v_user_name").innerHTML = data.user_name;
                    document.getElementById("v_countrycode").innerHTML = data.country_code;
                    document.getElementById("v_regionname").innerHTML = data.region_name;
                    document.getElementById("v_zip_code").innerHTML = data.zip_code;
                    document.getElementById("v_capital_city").innerHTML = data.capital+' - '+ data.city;
                    document.getElementById("v_languages").innerHTML = data.languages;
                    document.getElementById("v_time_zone").innerHTML = data.time_zone;
                    document.getElementById("v_geoname_id").innerHTML = data.geoname_id;
                    document.getElementById("v_connection_asn").innerHTML = data.connection_asn;
                    document.getElementById("v_connection_isp").innerHTML = data.connection_isp;
                    document.getElementById("v_latitude").innerHTML = data.latitude+", "+data.longitude+"<br/>";
                    document.getElementById("v_lastseen").innerHTML = data.last_visit;
                    document.getElementById("v_visited").innerHTML =data.time;
                    if (data.country_flag != null) {
                        document.getElementById("v_countryname").innerHTML = "<img style='width:20px;' src='" + data.country_flag + "' /> " + data.country_name;
                    } else{
                        document.getElementById("v_countryname").innerHTML = data.country_name;
                    }
                    loc_lat=data.latitude;
                    loc_lng=data.longitude;
                    if(data.view_status !=1){
                        $('#top-view-status-'+get_temp_id).hide("slow");
                        $('#status-'+get_temp_id).hide("slow");
                        var getUpdateCount=$('#count-new-views').text();
                        $('#count-new-views').text((getUpdateCount-1));
                        $('#change-visitor-value').text((getUpdateCount-1));
                    }
                }
            });
        }

        $(function () {
            $('#data-table-top').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "bSort": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "scrollX": "100%",
                "sScrollY": "400px",
            });
        });
    </script>

@endpush
