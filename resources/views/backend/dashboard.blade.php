@extends('backend.layouts.admin')
@include('backend.components.plugins.event_calendar')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1 class="m-0 text-uppercase">{{ env('APP_NAME') }} Dashboard</h1> </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(Session::has('welcome_msg'))
                    <div class="alert alert-success messages alert-dismissible">
                        <button type="button" class="close text-white" data-dismiss="alert">&times;</button>
                        <h6><i class="icon fas fa-user"></i> Welcome {{\auth::user()->name}}! welcome back to {{ env('APP_NAME') }} dashboard.</h6>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('users.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3 class="text-white">{{ \App\User::WhereNull('is_deleted')->get()->count() }}</h3>
                                <p class="text-white">Users/Buyers</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-house-user"></i>
                            </div>
                            <a href="{{ route('users.index') }}" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('products.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ \App\Products::WhereNull('is_deleted')->get()->count() }}</h3>
                                <p>Boutique</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-"><img src="{{ asset('assets/images/my_products Icon.png') }}" width="70px" alt="my products" /></i>

                            </div>
                            <a href="{{ route('products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('services.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ \App\Service::WhereNull('is_deleted')->get()->count() }}</h3>
                                <p>Cliniques</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-md"></i>
                            </div>
                            <a href="{{ route('services.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('site-visitors.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-gradient-purple">
                            <div class="inner">
                                <h3 class="text-white">{{ \App\Visit_logs::sum('view_count') }}</h3>
                                <p class="text-white">Web Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-ninja"></i>
                            </div>
                            <a href="{{ route('site-visitors.index') }}" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('orders.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 class="text-white">{{ \App\Orders::WhereNull('is_deleted')->get()->count() }}</h3>
                                <p class="text-white">Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('orders.index') }}" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('reservations.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ \App\Service_booking::WhereNull('is_deleted')->get()->count() }}</h3>
                                <p>Reservations</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-check" style="color: #94121e"></i>
                            </div>
                            <a href="{{ route('reservations.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->


                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('user-points.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3 class="text-white">{{ \App\Points::all()->count() }}</h3>
                                <p class="text-white">Wallet</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <a href="{{ route('user-points.index') }}" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6" onclick=" return window.location.href = '{{ route('withdrawal-wallet.index') }}'">
                        <!-- small box -->
                        <div class="small-box bg-cyan">
                            <div class="inner">
                                <h3 class="text-white">{{ \App\Withdrawal_points::all()->count() }}</h3>
                                <p class="text-white">Withdrawals</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa"><img src="{{ asset('assets/images/withdraw.png') }}" width="70px" alt="Withdrawals" /></i>
                            </div>
                            <a href="{{ route('withdrawal-wallet.index') }}" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
                <!-- Small boxes (Stat box) -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-xl-4 col-lg-6 col-md-12 connectedSortable">
                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header">
                                <h3 class="card-title">Clinique Reservations</h3>
                                <div class="card-tools">
                                    <span title="3 New Messages" class="badge badge-primary">{{ \App\Service_booking::whereDate('book_date', '>=', \Carbon\Carbon::today()->toDateString())->get()->count() }}</span>
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
                                <div class="ms-panel-body calendar-wedgit">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer pl-4 pt-2" style="padding: 0">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><div class="event-category dark-red"></div> <small>Expired</small></li>
                                    <li class="list-inline-item"><div class="event-category orange"></div> <small>Pending</small></li>
                                    <li class="list-inline-item"><div class="event-category green"></div> <small>Confirmed</small></li>
                                    <li class="list-inline-item"><div class="event-category black"></div> <small>Rejected</small></li>
                                    <li class="list-inline-item"><div class="event-category red"></div> <small>Canceled</small></li>
                                    <li class="list-inline-item"><div class="event-category dark-green"></div> <small>Completed</small></li>
                                </ul>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!--/.direct-chat -->
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recently Added Products</h3>

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
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @if(\App\Products::WHERENULL('is_deleted')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->get()->count()>0)
                                        @foreach(\App\Products::WHERENULL('is_deleted')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->orderby('created_at','desc')->get() as $row)
                                    <li class="item">
                                        <div class="product-img">
                                            <img class="img-size-50 rounded-circle" src="{{ (!empty($row->thumbnail_image)) ? asset($row->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" width="80" alt="{{ $row->name }}" />
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('products.show', $row->id)}}" class="product-title">{{ $row->name }}
                                                <span class="badge badge-warning float-right">{{ getCurrencyFormat($row->price) }}</span></a>
                                            <span class="product-description">
                                            {{ \Illuminate\Support\Str::limit($row->description, 100) }}
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                    @endforeach
                                    @else
                                        <li class="item">
                                            <div class="pl-2">
                                                <span class="product-description"><i class="fa fa-info-circle"></i> No products found!</span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('products.index') }}" class="uppercase">View All Products</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recently Added Services</h3>
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
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @if(\App\Service::WHERENULL('is_deleted')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->get()->count()>0)
                                        @foreach(\App\Service::WHERENULL('is_deleted')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->orderby('created_at','desc')->get() as $row)
                                            <li class="item">
                                                <div class="product-img">
                                                    <img class="img-size-50 rounded-circle" src="{{ (!empty($row->thumbnail_image)) ? asset($row->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" width="80" alt="{{ $row->name }}" />
                                                </div>
                                                <div class="product-info">
                                                    <a href="{{ route('services.show', $row->id)}}" class="product-title">{{ $row->name }}
                                                        <span class="badge badge-warning float-right">{{ getCurrencyFormat($row->price) }}</span></a>
                                                    <span class="product-description">
                                                        {{ \Illuminate\Support\Str::limit($row->description, 100) }}
                                                    </span>
                                                </div>
                                            </li>
                                            <!-- /.item -->
                                        @endforeach
                                    @else
                                        <li class="item">
                                            <div class="pl-2">
                                                <span class="product-description"><i class="fa fa-info-circle"></i> No services found!</span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('services.index') }}" class="uppercase">View All Services</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-xl-8 col-lg-6 col-md-12 connectedSortable">

                        <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Latest Orders</h3>

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
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(\App\Orders::WhereNull('is_deleted')->get()->count()>0)
                                            @foreach(\App\Orders::WhereNull('is_deleted')->orderby('created_at','DESC')->limit(8)->get() as $row)
                                            <tr>
                                                <td><a href="{{ route('orders.view', [$row->id, 'order_index']) }}">
                                                        SSA/PO/{{ $row->track_id}}
                                                        @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                            <small class="badge badge-info" style="font-size: 8px">New</small>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td>{{ $row->customer->name }}</td>
                                                <td>
                                                    @if($row->status == "Pending")
                                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                                    @elseif($row->status == "Confirmed")
                                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Confirmed</span>
                                                    @elseif($row->status == "Rejected")
                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Rejected</span>
                                                    @elseif($row->status == "Canceled")
                                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Canceled</span>
                                                    @endif
                                                </td>
                                                <td>{{ getCurrencyFormat($row->total) }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Latest Partners</h3>
                                <div class="card-tools">
                                    <span class="badge badge-danger">{{\App\User::with('employee')
                                                            ->join('agents', 'agents.user_id', '=', 'users.id')
                                                            ->where('agent_status','Approved')
                                                            ->orderBy('agents.created_at', 'DESC')
                                                            ->where('agents.created_at', '>=', \Carbon\Carbon::now()->subDays(7))
                                                            ->get()->count()}} New Members</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="users-list clearfix">
                                    @if(\App\User::whereNull('is_deleted')->where('agent_status','Approved')->get()->count()>0)
                                        @foreach(\App\User::with('employee')
                                                            ->join('agents', 'agents.user_id', '=', 'users.id')
                                                            ->where('agent_status','Approved')
                                                            ->orderBy('agents.created_at', 'DESC')
                                                            ->limit(8)
                                                            ->get()
                                        as $row)
                                        <li>
                                            <img class="img-size-50" src="{{ (!empty($row->user->profile_image))? asset($row->user->profile_image) : asset('administration/img/admin_avatar.png') }}" alt="User Image">
                                            <a class="users-list-name" href="{{ route('partners.show', $row->employee->user->id)}}">({{ $row->id }}) {{ $row->name }}</a>
                                            <span class="users-list-date">{{ $row->employee->created_at->diffForHumans() }}</span>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('partners.index') }}">View All Partners</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!--/.card -->
                        @permission('read-sales-point-summary')
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Sales and Points</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th>Mode</th>
                                        <th>Amount</th>
                                        <th>Order Items / booked service</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Payments::WhereNull('is_deleted')->get()->count()>0)
                                        @foreach(\App\Payments::WhereNull('is_deleted')->limit(8)->get() as $row)
                                            <tr>
                                                <td>{{ $row->user->name }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info" style="font-size: 8px">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ ($row->type == "product")? 'Product Order' : 'Service Reservation' }}</td>
                                                <td>{{ ($row->payment_method == "online_payment")? 'Online Card Payment' : 'Used Points' }}</td>
                                                <td>{{ ($row->payment_method == "online_payment")? getCurrencyFormat($row->paid_amount) : getPointsFormat($row->paid_points)." Points" }}</td>
                                                <td>{{ ($row->type == "product")? $row->order->items->count()." Items" : $row->booking->service->name." service" }} </td>
                                                <td>{{ $row->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                        @endpermission
                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('script')
    <script>
        !function() {
            $.ajax({
                url: '{{ route('bookings.events.all') }}',
                method: "GET",
                success: function (data) {
                    var calendar = new Calendar('#calendar',data);
                }
            });
        }();
    </script>
@endpush
