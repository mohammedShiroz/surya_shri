@extends('layouts.front')
@section('page_title','View Order')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('View order'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@include('backend.components.plugins.alert')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'ORDER DETAILS','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Orders','route'=>route('dashboard.orders')],
        3=>['name'=>'Details','route'=>''],
    ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>SSA/PO/{{ $data->track_id }} ORDER DETAILS</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Default box -->
                                        <div class="row">
                                            <div class="col-12">
                                                @include('components.messages')
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-7 order-2 order-md-1">
                                                <h6 class="pb-3 text-secondary"><i class="fas fa-shopping-basket"></i> Order product details</h6>
                                                <hr style="margin-top: -15px;"/>
                                                @if(count($data->items)>0)
                                                    <ul class="widget_recent_post mt-2">
                                                        @foreach($data->items as $item)
                                                            <li>
                                                                <div class="post_footer">
                                                                    <div class="post_img">
                                                                        <a target="_blank" href="{{ route('product.details',$item->product->slug) }}">
                                                                            <img class="img-responsive radius_all_5" width="80px" height="80px" src="{{ asset(($item->product->thumbnail_image)? $item->product->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg') }}" alt="{{ $item->product->name }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="post_content">
                                                                        <h6>{{ $item->product->name }} X {{ $item->qty }}</h6>
                                                                        <p style="margin-top: -5px;"><small> <i class="fa fa-tags fa-sm"></i>
                                                                            @if(isset($item->product->category->parent->parent->name))
                                                                                <a href="{{ route('products.category.level_check',HashEncode($item->product->category->parent->parent->id)) }}">{{ $item->product->category->parent->parent->name }}</a>
                                                                                <strong><i class="fa fa-angle-double-right text-sm"></i></strong>
                                                                            @endif
                                                                            @if(isset($item->product->category->parent->name))
                                                                                <a href="{{ route('products.category.level_check',HashEncode($item->product->category->parent->id)) }}">{{ $item->product->category->parent->name }}</a>
                                                                                <strong><i class="fa fa-angle-double-right text-sm"></i></strong>
                                                                            @endif
                                                                            <a href="{{ route('products.category.level_check',HashEncode($item->product->category->id)) }}">{{ $item->product->category->name }}</a>
                                                                            </small>
                                                                        </p>
                                                                        <p style="margin-top: -15px; line-height: 16px;"><small title="{{ $item->product->description }}">{{ getCurrencyFormat($item->product->price) }} - {{ \Illuminate\Support\Str::limit($item->product->description, 120) }}</small></p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-5 order-1 order-md-2">
                                                <h6 class="text-secondary"><i class="fas fa-clipboard-list"></i> Order details</h6>
                                                <hr style="margin-top: 10px;"/>
                                                <div class="text-muted bg-light p-3">
                                                    <p class="text-sm">Order No.
                                                        <strong class="d-block">SSA/PO/{{ $data->track_id }}</strong>
                                                    </p>
                                                    <p class="text-sm">Payment Method
                                                        <b class="d-block text-uppercase">{{ ($data->payment_method == 'online_payment')? 'Card Payment' : 'Points Payment' }}</b>
                                                    </p>
                                                    <p class="text-sm">Order Value
                                                        <strong class="d-block text-uppercase">{{ ($data->payment_method == 'online_payment')? getCurrencyFormat($data->total) : getPointsFormat($data->payment->paid_points)." Points" }}</strong>
                                                    </p>
                                                    <p class="text-sm">Order date & time
                                                        <strong class="d-block text-uppercase">On {{ date('l', strtotime($data->created_at)) }} {{ date('d, M Y, h:i:s A', strtotime($data->created_at)) }}</strong>
                                                    </p>
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
                                                    <p class="text-sm">Delivery Method
                                                        <strong class="d-block text-uppercase">{{ $data->delivery_method }}</strong>
                                                    </p>
                                                    @if($data->delivery_method == "Delivery")
                                                        <p class="text-sm">Pre-entered or New address
                                                            <strong class="d-block">{{ $data->pre_address  }}</strong>
                                                        </p>
                                                    @endif
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
                                                <div class="mt-5" style="margin-top: 15px !important;">
                                                    @if($data->status == "Pending")
                                                        <form id="cancel-form" action="{{ route('dashboard.orders.cancel') }}" method="post">
                                                            @csrf<input type="hidden" value="{{ $data->id }}" name="order_id"/>
                                                            <label class="d-block w-100 mt-2">Reason for Cancel</label>
                                                            <textarea class="d-block w-100 mb-1" id="reject_reason" name="cancel_reason" row="3"></textarea>
                                                            <button type="button" class="btn btn-sm btn-info btn-block w-100" id="btn-cancel-order"><small>Order Cancel</small></button>
                                                        </form>
                                                        @if($data->delivery_status == "Pending")
                                                        <button href="#" class="btn btn-sm btn-warning btn-block w-100 mt-2" id="btn-hold-order"><small>Report Hold</small></button>
                                                        @endif
                                                        <form id="hold-form" action="{{ route('dashboard.orders.hold') }}" method="post">@csrf<input type="hidden" value="{{ $data->id }}" name="order_id"/></form>
                                                    @endif
                                                </div>
                                                @push('script')
                                                    <script>
                                                        $("#btn-cancel-order").click(function(){
                                                            if($("#reject_reason").val()) {
                                                                swal.fire({
                                                                    title: '<span class="text-uppercase">Cancel order</span>',
                                                                    text: "Are you sure want to cancel the order?",
                                                                    type: 'warning',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Yes, cancel it!',
                                                                    cancelButtonText: 'No',
                                                                    reverseButtons: true
                                                                }).then((result) => {
                                                                    if (result.value) {
                                                                        setTimeout(function () {
                                                                            $("#cancel-form").submit();
                                                                        }, 2000);
                                                                        swal.fire(
                                                                            {
                                                                                type: 'info',
                                                                                icon: 'info',
                                                                                title: 'Progressing',
                                                                                text: 'Your, SSA/PO/{{ $data->track_id }} order cancel request progressing on it.',
                                                                                showConfirmButton: false,
                                                                                timer: 2000
                                                                            }
                                                                        );
                                                                    } else if (
                                                                        // Read more about handling dismissals
                                                                        result.dismiss === Swal.DismissReason.cancel
                                                                    ) {
                                                                    }
                                                                });

                                                            }else{
                                                                swal.fire(
                                                                    {
                                                                        type: 'info',
                                                                        icon: 'info',
                                                                        title: 'Required Reason for Cancel',
                                                                        text: 'Please text your cancel reason.',
                                                                        showConfirmButton: false,
                                                                        timer: 2000
                                                                    }
                                                                );
                                                            }
                                                        });
                                                        $("#btn-hold-order").click(function(){
                                                            swal.fire({
                                                                title: '<span class="text-uppercase">Hold order</span>',
                                                                text: "Are you sure want to hold the order?",
                                                                type: 'warning',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonText: 'Yes, hold it!',
                                                                cancelButtonText: 'No',
                                                                reverseButtons: true
                                                            }).then((result) => {
                                                                if (result.value) {
                                                                    swal.fire(
                                                                        {
                                                                            type: 'info',
                                                                            icon: 'info',
                                                                            title: 'Progressing',
                                                                            text: 'Your, SSA/PO/{{ $data->track_id }} order holding request progressing it now.',
                                                                            showConfirmButton: false,
                                                                            timer: 2000
                                                                        }
                                                                    );
                                                                    setTimeout(function () {
                                                                        $("#hold-form").submit();
                                                                    }, 2000);
                                                                } else if (
                                                                    // Read more about handling dismissals
                                                                    result.dismiss === Swal.DismissReason.cancel
                                                                ) { }
                                                            });
                                                        });
                                                    </script>
                                                @endpush
                                                <h6 class="mt-4 text-secondary"><i class="fas fa-clipboard-list"></i> Delivery & Buyer Details</h6>
                                                <hr style="margin-top: 10px;"/>
                                                <ul class="list-unstyled bg-light p-3">
                                                    <li>
                                                        <small><i class="ti-user mr-2"></i> {{ $data->customer->name? $data->customer->name : 'Unknown' }}</small>
                                                    </li>
                                                    <li>
                                                        <small><i class="ti-location-pin mr-2"></i> {{ $data->customer->address? $data->customer->address : '-'  }}</small>
                                                    </li>
                                                    <li>
                                                        <small><i class="ti-world mr-2"></i> {{ $data->customer->city? $data->customer->city.", " : '-'  }} {{ $data->customer->country? $data->customer->country : ''  }}</small>
                                                    </li>
                                                    <li>
                                                        <small><i class="ti-mobile mr-2"></i> {{ $data->customer->contact? $data->customer->contact : '-' }}</small>
                                                    </li>
                                                    <li>
                                                        <small><i class="ti-envelope mr-2"></i> {{ $data->customer->email? $data->customer->email: '-' }}</small>
                                                    </li>

                                                </ul>
                                                <div class="mt-5 d-inline-flex" style="margin-top: 15px !important;">
                                                    <a href="{{ route('dashboard.orders') }}"
                                                       class="btn btn-info btn-sm">Go Back
                                                    </a>
                                                    <button class="btn btn-sm btn-warning" id="view_bill">View My Invoice</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-5" style="display: none;" id="invoice_slot">
                                            <hr/>
                                            <div class="col-12">
                                                <!-- Main content -->
                                                <div class="invoice p-3 mb-3 bg-light border radius_all_5">
                                                    <!-- title row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p>
                                                                <img class="border-right mr-2 pr-2" src="{{ asset('assets/images/logo_dark.png') }}" width="150px" alt="logo"><small>Order Invoice</small>
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
                                                            Invoice Created For
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
                                                            <b>Invoice No. SSA/PO/{{ $data->track_id }}</b><br>
                                                            <br>
                                                            <b>Payment Date & Time:</b> {{ date('d/m/Y', strtotime($data->payment->created_at) ) }}<br>
                                                            <br/><b>Amount/Points:</b> {{ ($data->payment_method == 'online_payment')? getCurrencyFormat($data->total) : getPointsFormat($data->payment->paid_points)." Points" }}
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
                                                                    <th>Seasonal Discount</th>
                                                                    <th>Partner Discount</th>
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
                                                                            <td>
                                                                                @if($item->product->discount_mode != "none")
                                                                                    {{ ($item->product->discount_mode == "price")? getCurrencyFormat($item->product->discount_price) : getCurrencyFormat($item->product->discount_percentage) }}
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($data->user->employee)
                                                                                    {{ ($item->product->agent_pay_amount)? getCurrencyFormat($item->product->agent_pay_amount) : getCurrencyFormat(0) }}
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ getCurrencyFormat($item->sub_total) }}</td>
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
                                                            <p><b>Payment Status:</b> {{ $data->payment_status }}</p>
                                                            @if($data->vouchers)
                                                            <p><b>Used Voucher:</b></p>
                                                            <div class="order_review mt-3 bg-white radius_all_5">
                                                                <div class="heading_s1">
                                                                    <h4 class="text-center voucher_name">{{ $data->vouchers->voucher->name }}</h4>
                                                                    <p class="text-center"><small>({{ $data->vouchers->voucher->voucher_type }} voucher)</small></p>
                                                                </div>
                                                                <P style="margin-top: -10px;" class="text-center voucher_description">{{ $data->vouchers->voucher->description }}</P>
                                                            </div>
                                                           <p>Voucher Earned:
                                                               @if($data->vouchers->voucher->discount_type == "price")
                                                                   {{ getPointsFormat($data->vouchers->voucher->discount * \App\Details::where('key','points_rate')->first()->amount)  }}
                                                               @else
                                                                   @if($data->vouchers->voucher_type == "Purchase")
                                                                       {{ getPointsFormat(((($data->vouchers->voucher->discount / 100) * $data->items->sum('sub_total')) * \App\Details::where('key','points_rate')->first()->amount)) }}
                                                                   @else
                                                                       {{ getPointsFormat(((($data->vouchers->voucher->discount / 100) * \App\Details::where('key','shipping_amount')->first()->amount) * \App\Details::where('key','points_rate')->first()->amount)) }}
                                                                   @endif
                                                               @endif Points
                                                           </p>
                                                            @endif
                                                        </div>
                                                        <!-- /.col -->
                                                        <div class="col-6">
                                                            <div class="table-responsive">
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
                                                                                    <?php $cart_sub_total=($data->items->sum('sub_total') - $data->vouchers->voucher->discount); ?>
                                                                                    <?php $discount_price = ((($data->vouchers->voucher->discount / 100) * $data->items->sum('sub_total'))); ?>
                                                                                    <del>{{ getCurrencyFormat($data->items->sum('sub_total')) }}</del> &nbsp;
                                                                                        <br/>{{getCurrencyFormat($cart_sub_total - $discount_price)}} <span class="text-success">({{$data->vouchers->voucher->discount}}%off)</span>
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
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <a href="javascript:void(0)" id="hide_bill"><i class="ti-arrow-up"></i> Hide My Invoice</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @push('script')
                                                    <script>
                                                        $("#hide_bill").click(function(){$("#invoice_slot").slideUp();});
                                                        $("#view_bill").click(function(){$("#invoice_slot").slideDown();});
                                                    </script>
                                                @endpush
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
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
