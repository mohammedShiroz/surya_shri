@extends('administration.layouts.admin')
@section('head_section')
    @include('administration.components.head_elements')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="/administration/plugins/ekko-lightbox/ekko-lightbox.css">
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
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('delivery.orders') }}">Orders</a></li>
                            <li class="breadcrumb-item active">View Order</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ORDER DETAILS</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Delivery Items</span>
                                            <span class="info-box-number text-center text-muted mb-0">
                                                {{ \App\Order_products::where('order_id',$order->id)->where('delivery_status','DELIVERED')->get()->count() }} /
                                                {{ count($order->order_items) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Delivery Amount</span>
                                            <span class="info-box-number text-center text-muted mb-0">Rs.{{ $order->shipping_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Payment Status</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $order->payment_status }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="pb-3">ORDER ITEMS</h4>
                                    <div class="card-body">
                                        <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                                        <div id="accordion">
                                            @if(count($order->order_items)>0)
                                                @foreach($order->order_items as $k=> $item)
                                            <div class="card @if($item->delivery_status == "DELIVERED") @else card-danger @endif">
                                                @if($item->delivery_status == "DELIVERED")
                                                <div class="ribbon-wrapper ribbon-xl">
                                                    <div class="ribbon bg-success text-lg">
                                                        <i class="fa fa-check-circle"></i> Delivered
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        <a class="d-block w-100" data-toggle="collapse" href="#collapse{{$k}}">
                                                            Item #{{($k+1)}} <span class="float-right">Qty:{{ $item->qty }}</span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{$k}}" class="collapse show" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="active tab-pane" id="activity">
                                                            <!-- Post -->
                                                            <div class="post">
                                                                <div class="user-block">
                                                                    @if(empty($item->product_info->product_parent))
                                                                        <a target="_blank" href="{{ route('view_product',[$item->product_info->categories->parent->slug,$item->product_info->categories->slug,$item->product_info->product_slug]) }}">
                                                                            @if(!empty($item->product_info->product_img))
                                                                                <img src="{{ asset('uploads/products_images/thumbnail/'.$item->product_info->product_img) }}"
                                                                                     class="img-circle img-bordered-sm"
                                                                                     alt="{{ $item->product_info->product_name }}">
                                                                            @else
                                                                                <img class="img-circle img-bordered-sm"
                                                                                     src="{{ asset('assets/images/product_img_none/no_product_img.jpg') }}"
                                                                                     alt="{{ $item->product_info->product_name }}">
                                                                            @endif
                                                                        </a>
                                                                    @else
                                                                        <a target="_blank" href="{{ route('view_product',[$item->product_info->product_parent->categories->parent->slug,$item->product_info->product_parent->categories->slug,$item->product_info->product_parent->product_slug]) }}">
                                                                            @if(!empty($item->product_info->product_parent['product_img']))
                                                                                <img src="{{ asset('uploads/products_images/thumbnail/'.$item->product_info->product_parent['product_img']) }}"
                                                                                     class="img-circle img-bordered-sm"
                                                                                     alt="{{ $item->product_info->product_name }}">
                                                                            @else
                                                                                <img class="img-circle img-bordered-sm"
                                                                                     src="{{ asset('assets/images/product_img_none/no_product_img.jpg') }}"
                                                                                     alt="{{ $item->product_info->product_name }}">
                                                                            @endif
                                                                        </a>
                                                                    @endif
                                                                    <span class="username">
                                                                      <a target="_blank"
                                                                         @if(empty($item->product_info->product_parent))
                                                                         href="{{ route('view_product',[$item->product_info->categories->parent->slug,$item->product_info->categories->slug,$item->product_info->product_slug]) }}"
                                                                         @else
                                                                         href="{{ route('view_product',[$item->product_info->product_parent->categories->parent->slug,$item->product_info->product_parent->categories->slug,$item->product_info->product_parent->product_slug]) }}"
                                                                              @endif
                                                                      >{{ $item->product_info->product_name }}</a>
                                                                    </span>
                                                                    <span class="description">{{ $item->product_info->categories->parent->parent->name }} - {{ $item->product_info->categories->parent->name }}
                                                                        - {{ $item->product_info->categories->name }}</span>
                                                                    <span class="description"><strong>Item Color: </strong><span class="mt-2" style="display:inline-block; border: 1px solid grey; background: #{{$item->color}}; width: 15px; height: 15px;"></span>
                                                                        &nbsp;&nbsp; | @if($item->size !=0) <strong>Size:</strong> {{ App\Product_size::where('id', $item->size)->select('prefix')->first()->prefix }} @endif | <strong>Qty:</strong> {{ $item->qty }}
                                                                    </span>
                                                                </div>
                                                                <!-- /.user-block -->
                                                                @if(strlen($item->propposed_delivery_date) > 0)
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="alert alert-warning alert-dismissible">
                                                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                                                            This order has to be delivered on {{ $item->propposed_delivery_date }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="callout callout-info">
                                                                            <h5><strong>FROM:</strong> {{ isset($item->product_info->users->name)? $item->product_info->users->name: '' }} {{ isset($item->product_info->users->l_name)? $item->product_info->users->l_name: '' }}</h5>
                                                                            <p> Phone: {{ isset($item->product_info->users->contact)? $item->product_info->users->contact:'' }}<br>
                                                                                Email: {{ isset($item->product_info->users->email)? $item->product_info->users->email: '' }}<br/>
                                                                                Address: {{ isset($item->product_info->users->address)? $item->product_info->users->address:'' }}<br>
                                                                                Location: {{ isset($item->product_info->users->location)? $item->product_info->users->location: '' }} - {{ isset($item->product_info->users->city)? $item->product_info->users->city: '' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="callout callout-warning">
                                                                            <h5><strong>TO:</strong><br/></h5>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <p>
                                                                                        @foreach($order->buyer_info as $info)
                                                                                            @if($info->product_id == $item->product_id) Name: {{ $info->buyer_name }} <br/>@endif
                                                                                            @if($info->product_id == $item->product_id) Phone: {{$info->phone}}<br>@endif
                                                                                            @if($info->product_id == $item->product_id) Email: <small>{{$info->email}}</small><br/>@endif
                                                                                            @if($info->product_id == $item->product_id) Additional: {{$info->additional_info}}<br/>@endif
                                                                                        @endforeach
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p>
                                                                                        @foreach($order->buyer_info as $info)
                                                                                            @if($info->product_id == $item->product_id) Address: {{$info->buyer_address}}<br>@endif
                                                                                            @if($info->product_id == $item->product_id) Postal Code: {{$info->postal_code}}<br>@endif
                                                                                            @if($info->product_id == $item->product_id) Location: {{$info->city }} {{ $info->country }}@endif
                                                                                        @endforeach
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if($item->delivery_status != "DELIVERED")
                                                                <form action="{{ route('delivery.update.status') }}" method="POST" enctype="multipart/form-data">
                                                                    {{ csrf_field() }}
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <input type="hidden" name="order_id" value="{{ $order->id }}" />
                                                                        <input type="hidden" name="product_id" value="{{ $item->product_info->product_id }}" />
                                                                        <input type="hidden" name="product_name" value="{{ $item->product_info->product_name }}" />
                                                                        <input type="hidden" name="product_qty" value="{{ $item->qty }}" />
                                                                        <input type="hidden" name="is_reseller_item" value="{{ $item->is_resell_pro }}" />
                                                                        <input type="hidden" name="user_id" value="{{ $order->user_id }}" />
                                                                        <label><i class="far fa-comments mr-1"></i> Comments</label>
                                                                        <input class="form-control form-control-sm" name="delivery_comment_{{ $item->product_info->product_id }}" type="text" placeholder="Type a comment">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><i class="far fa-image mr-1"></i> Receipt Image</label>
                                                                        <input class="form-control form-control-sm" name="delivery_proof_{{ $item->product_info->product_id }}" type="file" required placeholder="Upload Invoice">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <button class="btn btn-info mt-2"  type="submit">Item Delivered</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                                @endif
                                                            </div>
                                                            <!-- /.post -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script_section')
    @include('administration.components.footer_script')
    <script src="/administration/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
        $(function () {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
            $('.filter-container').filterizr({gutterPixels: 3});
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
@endsection