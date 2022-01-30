@extends('backend.layouts.admin')
@section('page_title','View Service Details')
@include('backend.components.plugins.jssocials')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.dropfy')
@include('backend.components.plugins.alert')
@push('css')
    <style>
        .rating_wrap {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
        }
        .rating_wrap {
            -ms-flex-pack: center;
            justify-content: center;
        }
        .rating_num {
            font-size: 14px;
            margin-left: 5px;
            vertical-align: middle;
            display: inline-block;
        }
        .rating_wrap .rating {
            overflow: hidden;
            position: relative;
            height: 20px;
            font-size: 12px;
            width: 70px;
            font-family: "Font Awesome 5 Free";
            display: inline-block;
            vertical-align: middle;
        }
        .rating::before {
            font-size: 12px;
            content: "\f005\f005\f005\f005\f005";
            top: 0;
            position: absolute;
            left: 0;
            float: left;
            color: #F6BC3E;
        }
        .product_rate {
            overflow: hidden;
            float: left;
            top: 0;
            left: 0;
            position: absolute;
            padding-top: 1.5em;
            color: #F6BC3E;
        }
        .product_rate::before {
            font-size: 12px;
            content: "\f005\f005\f005\f005\f005";
            top: 0;
            position: absolute;
            left: 0;
            font-weight: 900;
        }
        .rating_wrap {
            float: right;
            margin-top: 7px;
        }
    </style>
@endpush
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user shadow">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-white">
                                    <h3 class="widget-user-username"><strong>{{ $data->name }}</strong></h3>
                                    <h6 class="widget-user-desc"><small>{{ \Illuminate\Support\Str::limit($data->description, 100) }}</small></h6>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ (!empty($data->image)) ? asset($data->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" style="width:128px; height: 128px; " width="128px" height="128px" alt="{{ $data->name }}">
                                </div>
                                <div class="card-footer" style="padding-top: 100px">
                                    <div class="row">
                                        <div class="col-sm-3 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ getCurrencyFormat($data->price) }}</h5>
                                                <span class="description-text">Price</span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-3 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $data->status }} </h5>
                                                <span class="description-text">Status</span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-3 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{!! ($data->visibility == 1)? '<i class="fa fa-eye"></i> VISIBLE' : '<i class="fa fa-eye-slash"></i> Hidden' !!}</h5>
                                                <span class="description-text">Visibility</span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-3 border-right">
                                            <div class="description-block">
                                                <span class="description-text d-block">Rating Level</span>
                                                <div class="rating_wrap d-block float-left" style="margin-left: 34%">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:{{ (($data->reviews->count()>0)? (100/5)* $data->reviews->sum('rate')/$data->reviews->count() : 0) }}%"></div>
                                                    </div>
                                                    <span class="rating_num">({{ $data->reviews->count() }}) </span>
                                                </div>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <div class="col-md-5 col-sm-12 mt-3">
                            <h3 class="d-inline-block d-sm-none">{{ $data->name }}</h3>
                            <div class="col-12">
                                <img src="{{ asset($data->image) }}" style="object-fit: cover !important;" class="product-image" alt="{{ $data->name }}">
                            </div>
                            <div class="col-12 product-image-thumbs">
                                @if($data->image)
                                    <div class="product-image-thumb active"><img src="{{ asset($data->thumbnail_image) }}" alt="Product Image 1"></div>
                                @endif
                                @foreach($data->images as $row)
                                    <div class="product-image-thumb"><img style="object-fit: cover !important;" src="{{ asset($row->image_thumbnail) }}" alt="Product Image {{ ($loop->index+1) }}"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <h3 class="my-3">{{ $data->name }}</h3>
                            <p>{{ $data->description }}</p>
                            <hr>
                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">
                                    Service's Doctor Details
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-8">
                                            <h2 class="lead"><b>{{ $data->doctor->user->name }}</b></h2>
                                            <p class="text-muted text-sm" style="margin-top: -10px;">({{ ($data->doctor->is_seller && $data->doctor->is_doctor)? ' Doctor & Seller ' : (($data->doctor->is_doctor)? 'Doctor' : 'Seller') }})</p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></span> Email: {{ $data->doctor->user->email }}</li>
                                                <li class="small mt-1"><span class="fa-li"><i class="fas fa-phone"></i></span> Phone: {{ $data->doctor->user->contact }}</li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="{{ asset($data->doctor->user->profile_image) }}" alt="user-avatar" width="100px" height="100px" class="img-circle img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-inline-block ">
                                        <div id="shareIconsCount"></div>
                                        <input type="hidden" id="social_share_url" value="{{ route('services.details',[$data->category->slug,$data->slug]) }}"/>
                                        <input type="hidden" id="social_share_title" value="{{ $data->name }}"/>
                                        <input type="hidden" id="social_share_description" value="{{ $data->description }}"/>
                                    </div>
                                    <div class="d-inline-block float-right pt-2">
                                        <a href="{{ route('sellers.show', $data->doctor->user->id) }}" class="btn btn-info">
                                            <i class="fas fa-user"></i> View Doctor Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0">
                                    {{ getCurrencyFormat($data->price) }}
                                </h2>
                                <h4 class="mt-0 text-md">
                                    <del><small>{!! ($data->discount_price)? getCurrencyFormat($data->actual_price) : '' !!}</small></del>  <small>{!! ($data->discount_price)? $data->discount_percentage."% Off<br/>" : '' !!}</small>
                                    <small>{!! ($data->seller_paid)? 'Doctor Paid: '.$data->seller_paid."%<br/>Doctor Paid Amount: ".getCurrencyFormat($data->seller_paid_amount) : '' !!}</small>
                                </h4>
                            </div>
                            <a href="{{ route('services.index') }}" class="btn btn-outline-dark mt-2">Back to Services</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 col-sm-12">
                            <nav class="w-100">
                                <div class="nav nav-tabs" id="product-tab" role="tablist">
                                    <a class="nav-item nav-link {{ (session('active_tab') && session()->get("active_tab")=='reviews')? '' : 'active' }}" id="product-info-tab" data-toggle="tab" href="#product-info" role="tab" aria-controls="product-info" aria-selected="true">Service Details</a>
                                    <a class="nav-item nav-link" id="price-info-tab" data-toggle="tab" href="#price-info" role="tab" aria-controls="price-info" aria-selected="true">Price Margin Detail</a>
                                    <a class="nav-item nav-link" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                                    <a class="nav-item nav-link {{ (session('active_tab') && session()->get("active_tab")=='reviews')? 'active' : '' }}" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments & Rating</a>
                                </div>
                            </nav>
                            <div class="tab-content p-3" id="nav-tabContent" style="width: 100%; padding: 0 !important;">
                                <div class="tab-pane fade {{ (session('active_tab') && session()->get("active_tab")=='reviews')? '' : 'show active' }}"  id="product-info" role="tabpanel" aria-labelledby="product-info-tab">
                                    <table class="table border mt-2">
                                        <tbody>
                                        <tr>
                                            <td width="15%">Category:</td>
                                            <td>{{ $data->category->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td>{{ $data->price? getCurrencyFormat($data->price) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount amount</td>
                                            <td>{!! ($data->discount_price)? getCurrencyFormat($data->actual_price - $data->price) : '' !!} {!!   $data->discount_price? "<small>(".$data->discount_percentage."%)</small>" : '-' !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Duration</td>
                                            <td>{{ $data->duration_hour? $data->duration_hour."hr" : '' }} {{ $data->duration_minutes? $data->duration_minutes."min" : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Buffer Time</td>
                                            <td>{{ $data->buffer_time? $data->buffer_time."Min" : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Available Days</td>
                                            <td>{{ ($data->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$data->week_days)) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Added Date & Time</td>
                                            <td>
                                                {{ date('Y-m-d h:i:s A', strtotime($data->created_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Updated Date & Time</td>
                                            <td>
                                                {{ date('Y-m-d h:i:s A', strtotime($data->updated_at)) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="price-info" role="tabpanel" aria-labelledby="price-info-tab">
                                    <div class="row mt-2">
                                        <div class="col-md-6 col-sm-12">
                                            <table class="table border mt-2">
                                                <tbody>
                                                <tr>
                                                    <td width="35%">Price</td>
                                                    <td>{{ getCurrencyFormat($data->price) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Actual Price:</td>
                                                    <td>{{ getCurrencyFormat($data->actual_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Discount</td>
                                                    <td>{!!  ($data->discount_price || $data->discount_percentage)? "Price: ".getCurrencyFormat($data->actual_price - $data->price)."<br/>Percentage: ".$data->discount_percentage."%" : '-' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td>Direct Commission</td>
                                                    <td>{{ ($data->direct_commission)? $data->direct_commission."%" : '-' }} &nbsp; <small>({{ ($data->direct_commission_price)? getCurrencyFormat($data->direct_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Network Bonus/Giveaways/Gifts</td>
                                                    <td>{{ ($data->bonus_commission)? $data->bonus_commission."%" : '-' }} &nbsp; <small>({{ ($data->bonus_commission_price)? getCurrencyFormat($data->bonus_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Site Account (expenses& profit)</td>
                                                    <td>{{ ($data->expenses_commission)? $data->expenses_commission."%" : '-' }} &nbsp; <small>({{ ($data->expenses_commission_price)? getCurrencyFormat($data->expenses_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <table class="table border mt-2">
                                                <tbody>
                                                <tr>
                                                    <td width="45%">1st Level Affiliate Commission</td>
                                                    <td>{{ ($data->first_level_commission)? $data->first_level_commission."%" : '-'  }}  &nbsp; <small>({{ ($data->first_level_commission_price)? getCurrencyFormat($data->first_level_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>2nd Level Affiliate Commission</td>
                                                    <td>{{ ($data->second_level_commission)? $data->second_level_commission."%" : '-'  }} &nbsp; <small>({{ ($data->second_level_commission_price)? getCurrencyFormat($data->second_level_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td width="45%">3rd Level Affiliate Commission</td>
                                                    <td>{{ ($data->third_level_commission)? $data->third_level_commission."%" : '-'  }} &nbsp; <small>({{ ($data->third_level_commission_price)? getCurrencyFormat($data->third_level_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>4th Level Affiliate Commission</td>
                                                    <td>{{ ($data->fourth_level_commission)? $data->fourth_level_commission."%" : '-'  }} &nbsp; <small>({{ ($data->fourth_level_commission_price)? getCurrencyFormat($data->fourth_level_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Global Commission</td>
                                                    <td>{{ ($data->fifth_level_commission)? $data->fifth_level_commission."%" : '-'  }} &nbsp; <small>({{ ($data->fifth_level_commission_price)? getCurrencyFormat($data->fifth_level_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Network Bonus/Gifts Commission</td>
                                                    <td>{{ ($data->bonus_commission)? $data->bonus_commission."%" : '-'  }} &nbsp; <small>({{ ($data->bonus_commission_price)? getCurrencyFormat($data->bonus_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Site Account Commission</td>
                                                    <td>{{ ($data->expenses_commission)? $data->expenses_commission."%" : '-'  }} &nbsp; <small>({{ ($data->expenses_commission_price)? getCurrencyFormat($data->expenses_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Donations Commission</td>
                                                    <td>{{ ($data->donations_commission)? $data->donations_commission."%" : '-'  }} &nbsp; <small>({{ ($data->donations_commission_price)? getCurrencyFormat($data->donations_commission_price) : '-'  }})</small></td>
                                                </tr>
                                                <tr>
                                                    <td>Doctor Paid</td>
                                                    <td>{{ ($data->seller_paid)? $data->seller_paid."%" : '-' }} &nbsp; <small>({{ ($data->seller_paid_amount)? getCurrencyFormat($data->seller_paid_amount) : '-'  }})</small></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-6 col-sm-12">
                                            <h5>Description</h5>
                                            {{ $data->description }}
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <h5>Long Description</h5>
                                            {!! $data->long_description !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ (session('active_tab') && session()->get("active_tab")=='reviews')? 'active show' : '' }}" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            @if($data->reviews->count() > 0)
                                            <table class="table border mt-2">
                                                <tr>
                                                    <td width="30%">Rating</td>
                                                    <td>
                                                        <div class="rating_wrap">
                                                            <div class="rating">
                                                                <div class="product_rate"
                                                                     @if(round($data->reviews->avg('rate'),2) < round(100.00,2))
                                                                        @if(round($data->reviews->avg('rate'),2) < 5 && round($data->reviews->avg('rate'),2) > 1)
                                                                        style="width:{{ ($data->reviews->avg('rate')+6) }}%"
                                                                     @else
                                                                        style="width:{{ $data->reviews->avg('rate') }}%"
                                                                        @endif
                                                                     @elseif($data->reviews->avg('rate') > 100)
                                                                        style="width:100%"
                                                                     @endif
                                                                ></div>
                                                            </div>
                                                            <span class="rating_num">
                                                                <i class="ti-comment"></i> ({{ ($data->reviews->avg('rate'))? $data->reviews->avg('rate') : '0' }})
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">Reviews/ Comments</td>
                                                    <td>
                                                        <div class="rating_wrap">
                                                            <span class="rating_num">
                                                                <i class="ti-comment"></i> ({{ ($data->reviews->count())? $data->reviews->count() : '0' }})
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if($data->reviews->count() > 0)
                                                @foreach($data->reviews as $row)
                                                        <div class="media border mt-0 p-3 mb-3">
                                                            <div class="d-flex mr-3">
                                                                <a {{ route('users.show', $row->user_id)}}><img class="media-object rounded-circle border" width="48px" height="48px" alt="{{ $row->user->profile_image }}" src="{{ asset(($row->user->profile_image)? $row->user->profile_image :  'assets/images/review_users/user-avatar.png') }}"> </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h5 class="mt-0 mb-1 font-weight-semibold"><a href="{{ route('users.show', $row->user_id)}}">{{ $row->name }}</a>
                                                                    <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"><small><i class="fa fa-check-circle-o text-success"></i></small></span>
                                                                    <span class="fs-14 ml-2 d-inline-flex">
                                                                        @for($rate=0; $rate <= 4; $rate++)
                                                                            <i class="fa {{ ($row->rate > $rate)? 'fa-star' : 'fa-star-o' }} text-warning fa-sm"></i>
                                                                        @endfor
                                                                    </span>
                                                                </h5>
                                                                <small class="text-muted"><i class="fa fa-calendar"></i> {{ date('M d Y', strtotime($row->created_at)) }}  <i class=" ml-3 fa fa-clock-o"></i> {{ date('H:i', strtotime($row->created_at)) }}  <i class=" ml-3 fa fa-map-marker"></i> Sri-Lanka</small>
                                                                <p class="font-13  mb-2 mt-2">
                                                                    {{ $row->comments }}
                                                                </p>
                                                                <form action="{{ route('services.remove.user.review') }}" method="POST" class="d-inline-block">
                                                                    @csrf
                                                                    <input type="hidden" name="active_tab" value="reviews">
                                                                    <input type="hidden" name="service_id" value="{{ $data->id }}" />
                                                                    <input type="hidden" name="review_id" value="{{ $row->id }}" />
                                                                    <button type="submit"  class="badge badge-danger mr-2"><i class="fa fa-trash"></i> Trash comment</button>
                                                                </form>
                                                                @permission('create-review-reply')
                                                                <a href="" class="mr-2" data-toggle="modal" data-target="#Comment-{{$row->id}}"><span class="">Reply</span></a>
                                                                @endpermission
                                                                <!-- Message Modal -->
                                                                <div class="modal fade" id="Comment-{{$row->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <form action="{{ route('services.add.reply') }}" method="post">
                                                                            @csrf
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Reply to {{ $row->name }}</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" value="{{$row->id}}" name="review_id" />
                                                                                    <input type="hidden" name="active_tab" value="reviews">
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" class="form-control" name="user_id" value="{{ \auth::user()->id }}">
                                                                                        <input type="text" readonly class="form-control" value="{{ \auth::user()->name }}" placeholder="Your Name">
                                                                                    </div>
                                                                                    <div class="form-group mb-0">
                                                                                        <textarea class="form-control" required name="comments" rows="6" placeholder="Message"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                @if($row->reply)
                                                                    @foreach($row->reply as $reply)
                                                                        <div class="media mt-4">
                                                                            <div class="d-flex mr-3">
                                                                                <a href="#"><img class="media-object rounded-circle" width="48px" height="48px" alt="64x64" src="{{ asset('assets/images/logo_loader.png') }}"> </a>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <h5 class="mt-0 mb-1 font-weight-semibold">Suryashri.lk <span class="fs-14 ml-0">
                                                                                        <form action="{{ route('services.remove.admin.reply') }}" method="POST" class="d-inline-block">
                                                                                            @csrf
                                                                                                    <input type="hidden" name="active_tab" value="reviews">
                                                                                            <input type="hidden" name="reply_id" value="{{ $reply->id }}" />
                                                                                            <button data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Reply" type="submit" class="bg-transparent border-0"><small><i class="fa fa-trash text-danger"></i></small></button>
                                                                                        </form>
                                                                                    </span>
                                                                                </h5>
                                                                                <small class="text-muted"><i class="fa fa-calendar"></i> {{ date('M d Y', strtotime($reply->created_at)) }}  <i class=" ml-3 fa fa-clock-o"></i> {{ date('H:i', strtotime($reply->created_at)) }}  <i class=" ml-3 fa fa-map-marker"></i> Sri-Lanka <i class=" ml-3 fa fa-user"></i> By {{ $reply->user->name }}</small>
                                                                                <p class="font-13  mb-2 mt-2">
                                                                                    {{ $reply->comments }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                @endforeach
                                            @else
                                                <p><i class="fa fa-info-circle"></i> No review result found</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
