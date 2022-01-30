@extends('administration.layouts.admin')
@section('head_section')
    @include('administration.components.head_elements')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('body_content')
    @include('administration.components.top_navigation')
    @include('administration.components.left_navigation')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if(isset($is_pending_del_orders))
                            <h1>Pending Delivery Orders</h1>
                        @elseif(isset($is_delivered_orders))
                            <h1>Delivered Orders</h1>
                        @else
                        <h1>Delivery Orders</h1>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            @if(isset($is_pending_del_orders))
                                <li class="breadcrumb-item"><a href="{{ route('delivery.orders') }}">Orders</a></li>
                                <li class="breadcrumb-item active">Pending Delivery Orders</li>
                            @elseif(isset($is_delivered_orders))
                                <li class="breadcrumb-item"><a href="{{ route('delivery.orders') }}">Orders</a></li>
                                <li class="breadcrumb-item active">Delivered Orders</li>
                            @else
                                <li class="breadcrumb-item active">Delivery Orders</li>
                            @endif
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
                                <h3 class="card-title">Order Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Delivery Status</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Date & Time</th>
                                        <th>Operation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($orders)>0)
                                        @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ isset($order->buyer_info->last()->buyer_name)? $order->buyer_info->last()->buyer_name : '' }}</td>
                                                    <td>
                                                        @if($order->delivery_status == "PENDING")
                                                            <span class="badge badge-danger">Pending</span>
                                                        @elseif($order->delivery_status == "DELIVERED")
                                                            <span class="badge badge-success">Delivered</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($order->payment_status == "PENDING")
                                                            <span class="badge badge-danger">Pending</span>
                                                        @elseif($order->payment_status == "SUCCESS")
                                                            <span class="badge badge-success">Success</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($order->order_status == "CONFIRMED")
                                                            <span class="badge badge-success">Confirmed</span>
                                                        @elseif($order->order_status == "DRAFTED")
                                                            <span class="badge badge-info">Drafted</span>
                                                        @elseif($order->order_status == "PENDING")
                                                            <span class="badge badge-danger">Pending</span>
                                                        @elseif($order->order_status == "REJECTED")
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @elseif($order->order_status == "DELIVERED")
                                                            <span class="badge badge-danger">Delivered</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d M Y h:i:s A', strtotime($order->created_at)) }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('delivery.orders.review',$order->id) }}" class="btn btn-info"><i class="fa fa-eye"></i> View</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Delivery Status</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Date & Time</th>
                                        <th>Operation</th>
                                    </tr>
                                    </tfoot>
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
@section('script_section')
    @include('administration.components.footer_script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('administration/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection