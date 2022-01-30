@extends('layouts.front')
@section('page_title','Reservation Detail')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Reservation Detail'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.jssocials')
@include('backend.components.plugins.alert')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'RESERVATION DETAILS','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Dashboard','route'=>route('dashboard')],
            2=>['name'=>'Reservations','route'=>route('dashboard.reservations')],
            3=>['name'=>'Reservation Details','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">Reservations Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-12 mb-4 mb-md-0">
                                                <div class="product-image">
                                                    <div class="product_img_box">
                                                        <img id="product_img"  src='{{ asset(($data->service->image)? $data->service->image : 'assets/images/service_img_none/no_service_img.jpg') }}'  alt="{{ $data->service->name }}" />
                                                        <a href="#" class="product_img_zoom" title="Zoom">
                                                            <span class="linearicons-zoom-in"></span>
                                                        </a>
                                                    </div>
                                                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false" style="display: none;">
                                                        <div class="item">
                                                            <a href="#" class="product_gallery_item active"  data-zoom-image="{{ asset(($data->service->image)? $data->service->image : 'assets/images/service_img_none/no_service_img.jpg') }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-12">
                                                <div class="pr_detail">
                                                    <div class="product_description">
                                                        <h4 class="product_title"><a href="#">{{ $data->service->name }}
                                                                @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                                                    <sup class="badge badge-danger pt-1 pb-1 pl-2 pr-2" style="font-size: 8px">Expired</sup>
                                                                @endif
                                                            </a></h4>
                                                        <h5 class="product_title pb-2" style="margin-top: -10px"><small>{{ $data->service->tag_code }}</small></h5>
                                                        <div class="product_sort_info d-block mt-2">
                                                            <ul>
                                                                <li><i class="linearicons-clock"></i> {{ $data->book_time }}</li>
                                                                <li><i class="linearicons-calendar-check"></i> {{ date('d M, Y',strtotime($data->book_date)) }} On {{ date('D',strtotime($data->book_date)) }}</li>
                                                                <li><i class="ti-comment-alt"></i>
                                                                    @if($data->status == "Pending")
                                                                        <span class="badge badge-warning">Pending</span>
                                                                    @elseif($data->status == "Confirmed")
                                                                        <span class="badge badge-success">Confirmed</span>
                                                                    @elseif($data->status == "Rejected")
                                                                        <span class="badge badge-danger">Rejected</span>
                                                                    @elseif($data->status == "Canceled")
                                                                        <span class="badge badge-danger">Canceled</span>
                                                                    @elseif($data->status == "Completed")
                                                                        <span class="badge badge-success">Completed</span>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product_share" style="margin-top: -10px;">
                                                        <span>Share Now:</span>
                                                        <div id="shareIconsCount"></div>
                                                        <input type="hidden" id="social_share_url" value="{{ route('dashboard.reservations.view',HashEncode($data->id)) }}"/>
                                                        <input type="hidden" id="social_share_title" value="{{ $data->service->name }}"/>
                                                        <input type="hidden" id="social_share_description" value="{{ $data->service->description }}"/>
                                                    </div>
                                                    <hr/>
                                                    <div class="cart_extra" id="show_error_review">
                                                        <div class="cart_btn">
                                                            <a href="{{ route('dashboard.reservations') }}" class="btn btn-fill-out btn-app text-white pl-3 pr-3">Back</a>
                                                            @if(!\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                                                                @if($data->status == "Pending" || $data->status == "Confirmed" || $data->status == "Confirmed")
                                                                    <button class="btn btn-fill-out btn-outline-danger text-white pl-3 pr-3" onclick="cancel_booking({{$data->id}})" style="color: white !important;">Reservation Cancel</button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <form action="{{ route('dashboard.reservations.cancel',$data->id) }}" method="POST" id="book-cancel-form">@csrf</form>
                                                    </div>
                                                    <hr/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="small_divider clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="tab-style3">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Additional Information</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Contact info</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content shop_info_tab">
                                                        <div class="tab-pane fade active show" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <td colspan="2"><strong>Booking Details</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Booking Reference</td>
                                                                            <td>SSA/BK/{{ $data->book_reference }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Service Name</td>
                                                                            <td>{{ $data->service->name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Service Duration</td>
                                                                            <td>{{ $data->service->duration_hour? $data->service->duration_hour."hr" : '' }} {{ $data->service->duration_minutes? $data->service->duration_minutes."min" : '' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Scheduled Date & Time</td>
                                                                            <td>{{ date('d M, Y',strtotime($data->book_date)) }} On {{ date('D',strtotime($data->book_date)) }} At {{ $data->book_time }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Payment Mode</td>
                                                                            <td>{{ ($data->payment_method == "online_payment")? "Online Payment" : "Points Payment" }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Paid Amount</td>
                                                                            <td>{{ ($data->payment_method == "online_payment")? getCurrencyFormat($data->paid_amount) : "(".getPointsFormat($data->paid_points).") Points" }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Book Status</td>
                                                                            <td>
                                                                                @if($data->status == "Pending")
                                                                                    <span class="badge badge-warning">Pending</span>
                                                                                @elseif($data->status == "Confirmed")
                                                                                    <span class="badge badge-success">Confirmed</span>
                                                                                @elseif($data->status == "Rejected")
                                                                                    <span class="badge badge-danger">Rejected</span>
                                                                                @elseif($data->status == "Canceled")
                                                                                    <span class="badge badge-danger">Canceled</span>
                                                                                @elseif($data->status == "Completed")
                                                                                    <span class="badge badge-success">Completed</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <td colspan="2"><strong>Patient Details</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Name</td>
                                                                            <td>{{ $data->customer->name?$data->customer->name:'-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>E-mail</td>
                                                                            <td>{{ $data->customer->email }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Contact</td>
                                                                            <td>{{ $data->customer->contact?$data->customer->contact:'-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>NIC/Passport</td>
                                                                            <td>{{ $data->customer->nic? $data->customer->nic : '-'}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Additional Note</td>
                                                                            <td>{{ ($data->customer->note)? $data->customer->note : '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Booked By</td>
                                                                            <td>{{ ($data->user->name)? $data->user->name : '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Booked Date & Time</td>
                                                                            <td>{{ date('d M, Y',strtotime($data->created_at)) }} On {{ date('D',strtotime($data->created)) }} At {{ date('h:i:s A',strtotime($data->created)) }}</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td colspan="2"><strong>Our Contact Details</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mobile</td>
                                                                    <td><a href="tel:+94769244427">(+94) 769244427</a> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>E-mail</td>
                                                                    <td><a href="mailto:suryashri.ayurveda@gmail.com">suryashri.ayurveda@gmail.com</a> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Location</td>
                                                                    <td>112 5th Ln, Pannipitiya 10230, Sri-lanka</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <hr/>
                                            <div class="col-12">
                                                <!-- Main content -->
                                                <div class="invoice p-3 mb-3 bg-light border radius_all_5">
                                                    <!-- title row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p>
                                                                <img class="border-right mr-2 pr-2" src="{{ asset('assets/images/logo_dark.png') }}" width="150px" alt="logo"><small>Reservation Invoice</small>
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
                                                                <strong>{{ $data->customer->name? $data->customer->name." ".$data->customer->last_name:'-' }}</strong><br>
                                                                Phone: {{ $data->customer->contact?$data->customer->contact:'-' }}<br>
                                                                Email: {{ $data->customer->email }}<br/>
                                                                Booked Date & Time: {{ date('d M, Y',strtotime($data->created_at)) }} On {{ date('D',strtotime($data->created)) }} At {{ date('h:i:s A',strtotime($data->created)) }}
                                                            </address>
                                                        </div>
                                                        <!-- /.col -->
                                                        <div class="col-sm-4 invoice-col">
                                                            <b>Reservation ID. {{ $data->id }}</b><br>
                                                            <b>Invoice No:</b> SSA/BK/{{ $data->book_reference }}<br>
                                                            <b>Payment Date & Time:</b> {{ date('d/m/Y', strtotime($data->payment->created_at) ) }}<br>
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
                                                                    <th>Service Name</th>
                                                                    <th>Duration</th>
                                                                    <th>Paid Amount</th>
                                                                    <th>Booked Date & Time</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>{{ $data->service->name }}</td>
                                                                    <td>{{ $data->service->duration_hour? $data->service->duration_hour."hr" : '' }} {{ $data->service->duration_minutes? $data->service->duration_minutes."min" : '' }}</td>
                                                                    <td>{{ ($data->payment_method == "online_payment")? getCurrencyFormat($data->paid_amount) : "(".getPointsFormat($data->paid_points).") Points" }}</td>
                                                                    <td>{{ date('d M, Y',strtotime($data->created_at)) }} On {{ date('D',strtotime($data->created)) }} At {{ date('h:i:s A',strtotime($data->created)) }}</td>
                                                                </tr>
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
                                                            <p><strong>Payment Method: </strong><span class="text-uppercase">{{ ($data->payment_method == "online_payment")? "Online Payment" : "Points Payment" }}</span></p>
                                                            <p><b>Payment Status:</b> {{ ($data->payment->payment_status == "success")? 'Paid' : 'Not Paid' }}</p>
                                                        </div>
                                                        <!-- /.col -->
                                                        <div class="col-6">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <th style="width:50%">Total:</th>
                                                                        <td>{{ ($data->payment_method == "online_payment")? getCurrencyFormat($data->paid_amount) : getCurrencyFormat(((\App\Details::where('key','points_rate')->first()->amount)*$data->paid_points)) }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
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
@push('script')
    <script>
        function cancel_booking(){
            swal.fire({
                title: '<span class="text-uppercase">Cancel Reservation?</span>',
                text: "Are you sure want to cancel this reservation?",
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, Thanks!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('book-cancel-form').submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            });
        }
    </script>
@endpush
