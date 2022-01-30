<div class="filter_data">
    <div class="row shop_container loadmore" data-item="20" data-item-show="4"
         data-finish-message="No More products to Show" data-btn="Load More">
        @if($services->count() > 0)
            @foreach($services  as $service_row)
                <div class="col-md-4 col-sm-12">
                    <div class="item">
                        <div class="product" style="border: 2px solid #f4f4f4; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="product_img" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                <a href="{{ route('services.details',[$service_row->category->slug, $service_row->slug]) }}">
                                    <img src="{{ asset(($service_row->thumbnail_image)? $service_row->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{ $service_row->name }}">
                                </a>
                                <div class="product_action_box" onclick='window.location.href = "{{ route('services.details',[$service_row->category->slug, $service_row->slug]) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                <div class="product_action_box">
                                    <ul class="list_none ">
                                        <li><a href="{{ route('services.booking',$service_row->slug) }}" class="btn btn-fill-out btn-radius"><i class="icon-check"></i>BOOK NOW</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="{{ route('services.details',[$service_row->category->slug, $service_row->slug]) }}">{{ $service_row->name }}</a>
                                    <br/><small title="{{ $service_row->tag_code }}">{{ $service_row->tag_code }}</small></h6>
                                <div class="product_price" style="height: 80px">
                                    <small><i class="ti-alarm-clock mr-1"></i> {{ ($service_row->duration_hour == null && $service_row->duration_minutes == null)? '-' : (($service_row->duration_hour? $service_row->duration_hour."hr " : '').($service_row->duration_minutes? $service_row->duration_minutes."min" : '')) }}</small><br/>
                                    <small><i class="ti-calendar mr-1"></i> {{ ($service_row->week_days)? str_replace(","," | ",str_replace(array( '\'', '"',';', '[', ']' ),"",$service_row->week_days)) : '-' }}</small><br/>
                                    <span class="price mt-3">{{ getCurrencyFormat($service_row->price) }}</span>
                                </div>
                                <div class="rating_wrap">
                                    <span class="rating_num">
                                        <div class="d-inline-flex">
                                            <span class="mr-1 mt-1"><i class="{{ ($service_row->reviews->count()>0)? 'ti-comment-alt' :' ti-comment' }}"></i></span>
                                            <span>({{ $service_row->reviews->count() }})</span>
                                        </div>
                                    </span>
                                    <div class="rating ml-2">
                                        <div class="product_rate" style="width:{{ (($service_row->reviews->count()>0)? (100/5)* $service_row->reviews->sum('rate')/$service_row->reviews->count() : 0) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12 col-12 grid_item pb-lg-0">
                <div class="msg-alert warning bg-transparent text-black-50 border-bottom border-left border-top border-right">
                    <span class="msg-closebtn text-black-50">&times;</span>
                    <strong><i class="fa fa-info fa-lg "></i></strong>&nbsp; No Result found!
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            {{ $services->links('pagination.default') }}
        </div>
    </div>
</div>
