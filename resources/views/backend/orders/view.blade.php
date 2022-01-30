@extends('backend.layouts.admin')
@section('page_title','View Order')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@if($page_name == "order_pending") Pending
                            @elseif($page_name == "order_confirmed") Confirmed
                            @elseif($page_name == "order_completed") Completed
                            @elseif($page_name == "order_rejected") Rejected
                            @elseif($page_name == "delivery_pending") Delivery
                            @elseif($page_name == "order_canceled") Canceled @endif Order Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                            <li class="breadcrumb-item active">@if($page_name == "order_pending") Pending
                                @elseif($page_name == "order_confirmed") Confirmed
                                @elseif($page_name == "order_completed") Completed
                                @elseif($page_name == "order_rejected") Rejected
                                @elseif($page_name == "delivery_pending") Delivery
                                @elseif($page_name == "order_canceled") Canceled @endif  Orders Details</li>
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
                    <h3 class="card-title">SSA/PO/{{ $data->track_id }} ORDER DETAILS</h3>
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
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Total Amount</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getCurrencyFormat($data->total) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Delivery Charges</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ getCurrencyFormat($data->shipping_amount) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Payment Status</span>
                                    <span class="info-box-number text-center text-muted mb-0">{!! ($data->payment_status == "Success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <h5 class="pb-3 text-secondary text-uppercase"><i class="fas fa-shopping-basket"></i> Order item details</h5>
                            @if(count($data->items)>0)
                            <div class="row d-flex align-items-stretch">
                                @foreach($data->items as $item)
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Item #{{ ($loop->index) }}
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="lead"><b>{{ $item->product->name }}</b></h2>
                                                    <p class="text-muted text-sm"><b>Price: </b> {{ getCurrencyFormat($item->product->price) }}
                                                    </p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="fas fa-sm fa-sort-numeric-asc"></i></span> Qty: {{ $item->qty }}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-sm fa-money"></i></span> Sub Total: {{ getCurrencyFormat($item->sub_total) }}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-5 text-center">
                                                    <img src="{{ asset(($item->product->thumbnail_image)? $item->product->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $item->product->name }}" alt="user-avatar" class="img-circle img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <!--<a href="javascript:void(0)" class="btn btn-sm  btn-danger">-->
                                                <!--    <i class="fas fa-trash-alt mr-1"></i> Remove Item-->
                                                <!--</a>-->
                                                <a href="{{ route('products.show', $item->product->id)}}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye mr-1"></i> View Item
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h6 class="text-secondary"><i class="fas fa-clipboard-list"></i> Order details</h6>
                            <hr style="margin-top: 10px;"/>
                            <div class="text-muted bg-light p-3">
                                <p class="text-sm">Order ID.
                                    <strong class="d-block">{{ $data->id }}</strong>
                                </p>
                                <p class="text-sm">Invoice No.
                                    <strong class="d-block">SSA/PO/{{ $data->track_id }}</strong>
                                </p>
                                <p class="text-sm">Payment Method
                                    <b class="d-block text-uppercase">{{ ($data->payment_method == 'online_payment')? 'Card Payment' : 'Points Payment' }}</b>
                                </p>
                                <p class="text-sm">Paid Amount / Points
                                    <strong class="d-block text-uppercase">{{ ($data->payment_method == 'online_payment')? getCurrencyFormat($data->total) : getPointsFormat($data->payment->paid_points)." Points" }}</strong>
                                </p>
                                <p class="text-sm">Order date & time
                                    <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->created_at)) }} {{ date('d, M Y, h:i:s A', strtotime($data->created_at)) }}</strong>
                                </p>
                                <p class="text-sm">Delivery Method
                                    <strong class="d-block text-uppercase">{{ $data->delivery_method }}</strong>
                                </p>
                                @if($data->delivery_method == "Delivery")
                                <p class="text-sm">Pre-entered or New address
                                    <strong class="d-block">{{ $data->pre_address  }}</strong>
                                </p>
                                @endif
                                <p class="text-sm">Order Status<br/>
                                    @if($data->status == "Pending")
                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                    @elseif($data->status == "Confirmed")
                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Confirmed</span>
                                    @elseif($data->status == "Rejected")
                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Rejected</span>
                                    @elseif($data->status == "Canceled")
                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Canceled</span>
                                    @endif
                                </p>
                                @if($data->confirmed_date)
                                    <p class="text-sm">Order confirmed date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->confirmed_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->confirmed_date)) }}</strong>
                                    </p>
                                @elseif($data->rejected_date)
                                    <p class="text-sm">Order rejected date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->rejected_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->rejected_date)) }}</strong>
                                    </p>
                                    <p class="text-sm">Reason for Rejection
                                        <span class="d-block">{{ $data->reject_reason }}</span>
                                    </p>
                                @elseif($data->canceled_date)
                                    <p class="text-sm">Order canceled date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->canceled_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->canceled_date)) }}</strong>
                                    </p>
                                    <p class="text-sm">Reason for Cancel
                                        <span class="d-block">{{ $data->cancel_reason }}</span>
                                    </p>
                                @endif
                                <p class="text-sm">Delivery Status<br/>
                                    @if($data->delivery_status == "Pending")
                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Pending</span>
                                    @elseif($data->delivery_status == "Delivered")
                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Delivered</span>
                                    @elseif($data->delivery_status == "Not-delivered")
                                        <span class="badge badge-warning pt-1 pl-3 pr-3 pb-1 radius_all_10">Not-delivered</span>
                                    @elseif($data->delivery_status == "Sending")
                                        <span class="badge badge-info pt-1 pl-3 pr-3 pb-1 radius_all_10">Sending</span>
                                    @elseif($data->delivery_status == "Hold")
                                        <span class="badge badge-danger pt-1 pl-3 pr-3 pb-1 radius_all_10">Hold</span>
                                    @elseif($data->delivery_status == "Self-Pickup")
                                        <span class="badge badge-success pt-1 pl-3 pr-3 pb-1 radius_all_10">Self-Pickup</span>
                                    @endif
                                </p>
                                @if($data->delivery_send_date)
                                    <p class="text-sm">Delivery send date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->Delivered)) }} {{ date('d, M Y, h:i:s A', strtotime($data->Delivered)) }}</strong>
                                    </p>
                                @endif
                                @if($data->delivery_date)
                                    <p class="text-sm">Delivered date & time
                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->delivery_date)) }} {{ date('d, M Y, h:i:s A', strtotime($data->delivery_date)) }}</strong>
                                    </p>
                                @endif
                                <hr>
                                <p class="text-sm"><strong>Additional Note</strong>
                                    <span class="text-muted d-block">{{ $data->customer->note? $data->customer->note: '-' }}</span>
                                </p>
                            </div>
                            <div class="mt-5 bg-light p-3 w-100" style="margin-top: 15px !important;">
                                <h5 class="pb-3 text-secondary text-uppercase"><i class="fas fa-user-cog mr-1"></i> {{ ($data->status == "Confirmed")? 'Delivery' : 'Order' }} Actions</h5>
                                <div class="row">
                                    @permission('update-orders')
                                    <div class="col-12">
                                        @if($data->status =="Pending")
                                            <button class="btn btn-success btn-block w-100" onclick="confirm_check('confirm')"><i class="fa fa-check"></i> Confirm Order</button>
                                            @if($data->status !="Rejected")
                                                <form method="post" id="reject-form" action="{{ route('orders.request.reject') }}">
                                                    @csrf<input type="hidden" name="order_id" value="{{$data->id}}"/>
                                                    <label class="d-block w-100 mt-2">Reason for Rejection</label>
                                                    <textarea class="d-block w-100 mb-1" name="reject_reason" row="3"></textarea>
                                                    <button type="button" class="btn btn-danger btn-block w-100" onclick="confirm_check('reject')"><i class="fas fa-close"></i> Reject Order</button>
                                                </form>
                                            @endif
                                        @elseif($data->status == "Confirmed")
                                            <div class="d-inline">
                                                @if($data->delivery_status != "Pending")
                                                    <button class="btn btn-warning btn-block w-100" onclick="confirm_check('pending')"><i class="fas fa-truck-loading"></i> Pending</button>
                                                @endif
                                                @if($data->delivery_status != "Delivered")
                                                    <button class="btn btn-success btn-block w-100" onclick="confirm_check('delivered')"><i class="fas fa-check-double"></i> Delivered</button>
                                                @endif
                                                @if($data->delivery_status != "Sending")
                                                    <button class="btn btn-success btn-block w-100" onclick="confirm_check('send')"><i class="fas fa-truck-moving"></i> Sending</button>
                                                @endif
                                                @if($data->delivery_status != "Hold")
                                                    <button class="btn btn-info btn-block w-100" onclick="confirm_check('hold')"><i class="fas fa-truck-pickup"></i> Hold</button>
                                                @endif
                                                @if($data->delivery_status != "Not-delivered")
                                                    <button class="btn btn-danger btn-block w-100" onclick="confirm_check('not-delivery')"><i class="fas fa-close"></i> No Delivery</button>
                                                @endif
                                                @if($data->delivery_status != "Self-Pickup")
                                                    <button class="btn btn-warning btn-block w-100" onclick="confirm_check('self-pickup')"><i class="fas fa-check"></i> Self-Pickup</button>
                                                @endif
                                            </div>
                                        @endif

                                        <form method="post" id="self-pickup-form" action="{{ route('orders.delivery.self-pickup') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        <form method="post" id="confirm-form" action="{{ route('orders.request.confirm') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        <form method="post" id="send-form" action="{{ route('orders.delivery.send') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        <form method="post" id="not-delivery-form" action="{{ route('orders.delivery.not-send') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        <form method="post" id="hold-form" action="{{ route('orders.delivery.hold') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        <form method="post" id="pending-form" action="{{ route('orders.delivery.pending') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        <form method="post" id="delivered-form" action="{{ route('orders.delivery.delivered') }}">@csrf<input type="hidden" name="order_id" value="{{$data->id}}"/></form>
                                        @push('script')
                                            <script>
                                                function confirm_check(data){
                                                    swal.fire({
                                                        title: '<span class="text-uppercase">'+data+' Order</span>',
                                                        text: "Are you sure want to "+data+" this order?",
                                                        type: 'warning',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Yes, '+data+' it!',
                                                        cancelButtonText: 'No',
                                                        reverseButtons: true
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            swal.fire(
                                                                {
                                                                    type: 'info',
                                                                    icon: 'info',
                                                                    title: 'Progressing',
                                                                    text: 'SSA/PO/{{ $data->track_id }} order '+data+' progressing it now.',
                                                                    showConfirmButton: false,
                                                                    timer: 2000
                                                                }
                                                            );
                                                            setTimeout(function () {
                                                                $("#"+data+"-form").submit();
                                                            }, 2000);
                                                        } else if (
                                                            // Read more about handling dismissals
                                                            result.dismiss === Swal.DismissReason.cancel
                                                        ) { }
                                                    });
                                                }
                                            </script>
                                        @endpush
                                    </div>
                                    @endpermission
                                    <div class="col-12 mt-2">
                                        <a href="@if($page_name == "order_index") {{ route('orders.index') }}
                                        @elseif($page_name == "order_pending") {{ route('orders.pending') }}
                                        @elseif($page_name == "order_completed") {{ route('orders.completed') }}
                                        @elseif($page_name == "order_confirmed") {{ route('orders.confirmed') }}
                                        @elseif($page_name == "delivery_pending") {{ route('orders.pending.delivery') }}
                                        @elseif($page_name == "order_rejected") {{ route('orders.rejected') }}
                                        @elseif($page_name == "order_canceled") {{ route('orders.canceled') }} {{ route('orders.index') }} @else @endif
                                            "
                                           class="btn btn-info btn-block w-100" style="margin-right: 5px;">
                                            <i class="fa fa-long-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-clipboard-list"></i> Delivery & Buyer Details</h6>
                            <hr style="margin-top: 10px;"/>
                            <ul class="list-unstyled bg-light p-3">
                                <li>
                                    <i class="fa fa-user mr-2"></i> {{ $data->customer->name? $data->customer->name : 'Unknown' }}
                                </li>
                                <li>
                                    <i class="fa fa-location-arrow mr-2"></i> {{ $data->customer->address? $data->customer->address : '-'  }}
                                </li>
                                <li>
                                    <i class="fa fa-phone-square mr-2"></i> {{ $data->customer->contact? $data->customer->contact : '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope mr-2"></i> {{ $data->customer->email? $data->customer->email: '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-globe mr-2"></i> {{ $data->customer->city? $data->customer->city.", " : '-'  }} {{ $data->customer->country? $data->customer->country : ''  }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-user"></i> Account Details</h6>
                            <hr style="margin-top: 10px;"/>
                            <ul class="list-unstyled bg-light p-3">
                                <li>
                                    <i class="fa fa-user mr-2"></i> ({{ $data->user->id }}) {{ $data->user->name? ($data->user->name." ".$data->user->last_name) : 'Unknown' }}
                                </li>
                                <li>
                                    <i class="fa fa-phone-square mr-2"></i> {{ $data->user->contact? $data->user->contact : '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope mr-2"></i> {{ $data->user->email? $data->user->email: '-' }}
                                </li>
                                <li>
                                    <i class="fa fa-globe mr-2"></i> {{ $data->user->city? $data->user->city.", " : '-'  }} {{ $data->user->country? $data->user->country : ''  }}
                                </li>
                                <li>
                                    <i class="fas fa-user-shield mr-2"></i>{!! $data->user->employee? '<span class="text-success">Our Partner</span>' : 'Customer' !!}
                                </li>
                            </ul>
                        </div>
                        @permission('read-order-notes')
                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-edit"></i> Additional Note</h6>
                            <table class="w-100">
                                @foreach($data->notes as $row)
                                    <tr class="border mb-2">
                                        <td class="p-2">
                                            @if($row->is_deleted)
                                                <del>{!! ($loop->index+1).". ".$row->additional."<br/>" !!}</del>
                                            @else
                                                {!! ($loop->index+1).". ".$row->additional."<br/>" !!}
                                            @endif
                                        </td>
                                        @permission('delete-order-notes')
                                        <td class="p-2" align="right">
                                            @if(!$row->is_deleted)
                                            <a href="{{ route('orders.delete.notes',$row->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                        @endpermission
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        @endpermission
                        @permission('create-order-notes')
                        <div class="col-6 col-md-6 col-lg-6 col-sm-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-edit"></i> Add Additional Note</h6>
                            <form action="{{ route('orders.add.notes') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $data->id }}" />
                                <textarea class="form-control" name="additional" rows="5">{!! old('additional')? old('additional'): $data->additional !!}</textarea>
                                @error('additional')
                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                @enderror
                                <button class="btn btn-info float-right ml-1 mt-2" type="submit">Save Changes</button>
                            </form>
                        </div>
                        @endpermission
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mt-4 text-secondary"><i class="fas fa-money-bill-wave"></i> Invoice Details</h6>
                            <hr style="margin-top: 10px;"/>
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3 bg-light border radius_all_5">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <img class="border-right mr-2 pr-2" src="{{ asset('assets/images/logo_dark.png') }}" width="150px" alt="logo"><small>Order Receipt</small>
                                            <small class="float-right">Date: {{ date('d M Y h:i:s A', strtotime($data->created_at) ) }}</small>
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <br/>
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        From
                                        <address>
                                            <strong>{{ \App\Details::where('key','company')->first()->name }}</strong><br>
                                            <small>{!! \App\Details::where('key','company_address')->first()->value !!}</small><br/>
                                            Phone: {{ \App\Details::where('key','company_contact')->first()->value }}<br>
                                            Email: {{ \App\Details::where('key','company_email')->first()->value }}<br/>
                                            Web: <a href="{{ \App\Details::where('key','company')->first()->link }}">{{ \App\Details::where('key','company')->first()->value }}</a>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        To
                                        <address>
                                            <strong>{{ $data->customer->name? $data->customer->name : 'Unknown' }}</strong><br>
                                            <small>{{ $data->customer->address? $data->customer->address : '' }}</small><br>
                                            Phone: {{ $data->customer->contact? $data->customer->contact : '-' }}<br>
                                            Email: {{ $data->customer->email? $data->customer->email: '-' }}<br/>
                                            Location: {{ $data->customer->city? $data->customer->city.", " : '-'  }} {{ $data->customer->country? $data->customer->country : ''  }}
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Invoice #{{ HashEncode($data->id) }}</b><br>
                                        <br>
                                        <b>Order No:</b> SSA/PO/{{ $data->track_id }}<br>
                                        <b>Payment:</b> {{ date('d/m/Y', strtotime($data->payment->created_at) ) }}<br>
                                        <b>Amount/Points:</b> {{ ($data->payment_method == 'online_payment')? getCurrencyFormat($data->total) : getPointsFormat($data->payment->paid_points)." Points" }}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                @if($data->user->employee)<th>Partner Discounted Price</th>@endif
                                                <th>Description</th>
                                                <th>Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($data->items)>0)
                                                @foreach($data->items as $item)
                                                    <tr>
                                                        <td>{{ ($loop->index+1) }}</td>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>x{{ $item->qty }}</td>
                                                        <td>{{ getCurrencyFormat($item->product->price) }}</td>
                                                        @if($data->user->employee)<td>{{ ($item->product->agent_pay_amount)? getCurrencyFormat($item->product->agent_pay_amount) : '-' }}</td>@endif
                                                        <td><small title="{{ $item->product->description }}">{{ $item->product->description? \Illuminate\Support\Str::limit($item->product->description, 50)  : '-' }}</small></td>
                                                        <td>{{ ($data->user->employee)? (($item->product->agent_pay_amount)? getCurrencyFormat($item->product->agent_pay_amount*$item->qty) : getCurrencyFormat($item->sub_total) ): getCurrencyFormat($item->sub_total) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <hr></br>
                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                        <p class="lead">Payment Details:</p>
                                        <p><strong>Payment Method: </strong><span class="text-uppercase">{{ ($data->payment->payment_method == "online_payment")? "Card payment" : 'Points Payment' }}</span></p>
                                        <p><b>Payment Status:</b> {!! ($data->payment_status == "Success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</p>
                                        @if($data->vouchers)
                                            <p><b>Used Voucher:</b></p>
                                            <div class="order_review mt-3 bg-white radius_all_5 p-3">
                                                <div class="heading_s1">
                                                    <h4 class="text-center voucher_name">{{ $data->vouchers->voucher->name }}</h4>
                                                    <p class="text-center" style="margin-top: -10px"><small>({{ $data->vouchers->voucher->voucher_type }} voucher)</small></p>
                                                </div>
                                                <P style="margin-top: -10px;" class="text-center voucher_description">{{ $data->vouchers->voucher->description }}</P>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <div class="table-responsive">
                                            <p class="lead">Paid Details:</p>
                                            <table class="table">
                                                @if($data->vouchers)
                                                    <tr class="bg-white">
                                                        <td class="cart_total_label">Voucher Discount</td>
                                                        <td>
                                                            <small>
                                                                @if($data->vouchers->voucher->discount_type == "price")
                                                                    {{ getCurrencyFormat($data->vouchers->voucher->discount) }}
                                                                @else
                                                                    @if($data->vouchers->voucher_type == "Purchase")
                                                                        {{ getCurrencyFormat(((($data->vouchers->voucher->discount / 100) * $data->items->sum('sub_total')))) }}
                                                                    @else
                                                                        {{ getCurrencyFormat(((($data->vouchers->voucher->discount / 100) * \App\Details::where('key','shipping_amount')->first()->amount))) }}
                                                                    @endif
                                                                @endif
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    @if($data->vouchers->voucher->discount_type == "price" && ($data->vouchers->voucher->discount > $data->items->sum('sub_total')))
                                                        <tr class="bg-white">
                                                            <td class="cart_total_label">Earned Points</td>
                                                            <td><small> {{ ($data->vouchers->voucher->discount - $data->items->sum('sub_total'))/(\App\Details::where('key','points_rate')->first()->amount) }} Points</small></td>
                                                        </tr>
                                                    @endif
                                                @endif
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td>
                                                        @if(($data->vouchers) && $data->vouchers->voucher->voucher_type == "Purchase")
                                                            @if($data->vouchers->voucher->discount_type == "price")
                                                                <?php $cart_sub_total=($data->items->sum('sub_total') - $data->vouchers->voucher->discount); ?>
                                                                @if($data->vouchers->voucher->discount > $data->items->sum('sub_total'))
                                                                    <?php $cart_sub_total = 0; ?>
                                                                @endif
                                                                <del>{{ getCurrencyFormat($data->items->sum('sub_total')) }}</del> &nbsp; {{getCurrencyFormat($cart_sub_total)}}
                                                            @else
                                                                <?php $discount_price = ((($data->vouchers->voucher->discount / 100) * $data->items->sum('sub_total'))); ?>
                                                                <del>{{ getCurrencyFormat($data->items->sum('sub_total')) }}</del> &nbsp; {{getCurrencyFormat($cart_sub_total - $discount_price)}} <span class="text-success">({{$data->vouchers->voucher->discount}}%off)</span>
                                                            @endif
                                                        @else
                                                            {{ getCurrencyFormat($data->items->sum('sub_total')) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Delivery Charges:</th>
                                                    <td>
                                                        @if(($data->vouchers) && $data->vouchers->voucher->voucher_type == "Shipping Amount")
                                                            @if($data->vouchers->voucher->discount_type == "price")
                                                                <?php $shipping_amount=(\App\Details::where('key','shipping_amount')->first()->amount - $data->vouchers->voucher->discount); ?>
                                                                <del>{{ getCurrencyFormat(\App\Details::where('key','shipping_amount')->first()->amount) }}</del> &nbsp; {{getCurrencyFormat($shipping_amount)}}
                                                            @else
                                                                <?php $discount_price = ((($data->vouchers->voucher->discount / 100) * \App\Details::where('key','shipping_amount')->first()->amount)); ?>
                                                                <del>{{ getCurrencyFormat(\App\Details::where('key','shipping_amount')->first()->amount) }}</del> &nbsp; {{getCurrencyFormat(\App\Details::where('key','shipping_amount')->first()->amount - $discount_price)}} <span class="text-success">({{$data->vouchers->voucher->discount}}%off)</span>
                                                            @endif
                                                        @else
                                                            {{ getCurrencyFormat($data->shipping_amount) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total:</th>
                                                    <td>{!! ($data->payment_method == 'online_payment')? getCurrencyFormat($data->total) : getCurrencyFormat($data->total).' <small>('.getPointsFormat($data->payment->paid_points).' Points)</small>' !!}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('script')
    <script src="{{ asset('administration/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
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
@endpush
