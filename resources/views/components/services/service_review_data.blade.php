<div class="review_data">
    <ul class="mt-3">
        @if(count($service_reviews)>0)
            @foreach($service_reviews as $row)
                <div class="media mt-0 mb-4">
                    <div class="d-flex mr-3">
                        <a href="javascript:void(0)"><img class="media-object rounded-circle border" width="48px" height="48px" alt="64x64" src="{{ asset(($row->user->profile_image)? $row->user->profile_image :  'assets/images/review_users/user-avatar.png') }}"> </a>
                    </div>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1 font-weight-semibold">{{ $row->name }}
                            <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified User"><small><i class="fa fa-check-circle-o text-success"></i></small></span>
                            <span class="fs-14 ml-2">
                                <div class="rating_wrap d-inline-block bg-red">
                                    <div class="rating">
                                        <div class="product_rate"
                                             @if($row->rate == 1)
                                             style="width:20%;"
                                             @elseif($row->rate == 2)
                                             style="width:40%;"
                                             @elseif($row->rate == 3)
                                             style="width:60%;"
                                             @elseif($row->rate == 4)
                                             style="width:80%;"
                                             @elseif($row->rate == 5)
                                             style="width:100%;"
                                            @endif>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </h5>
                        {{--@auth--}}
                            {{--@if($row->user_id == \Auth::user()->id)--}}
                                {{--<form action="{{ route('services.remove.my.review') }}" method="POST">--}}
                                    {{--@csrf--}}
                                    {{--<input type="hidden" name="active_tab" value="reviews">--}}
                                    {{--<input type="hidden" name="service_id" value="{{ isset($service_id) ? $service_id : $data->id }}" />--}}
                                    {{--<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}" />--}}
                                    {{--<button type="submit"  class="btn btn-link btn-sm text-danger border" style="padding: 10px !important;"><i class="ti-trash"></i> Trash my comment</button>--}}
                                {{--</form>--}}
                            {{--@endif--}}
                        {{--@endauth--}}
                        <small class="text-muted"><i class="fa fa-calendar"></i> {{ date('M d Y', strtotime($row->created_at)) }}  <i class=" ml-3 fa fa-clock-o"></i> {{ date('H:i', strtotime($row->created_at)) }}  <i class=" ml-3 fa fa-map-marker"></i> Sri-Lanka</small>
                        <p class="font-13  mb-2 mt-2">{{ $row->comments }} </p>
                        @if($row->reply)
                            @foreach($row->reply as $reply)
                            <div class="media mt-4">
                                <div class="d-flex mr-3">
                                    <a href="javascript:void(0)"><img class="media-object rounded-circle" width="48px" height="48px" alt="64x64" src="{{ asset('assets/images/logo_loader.png') }}"> </a>
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-weight-semibold">Suryashri.lk <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Admin"><small><i class="fa fa-check-circle-o text-success"></i></small></span></h5>
                                    <small class="text-muted"><i class="fa fa-calendar"></i> {{ date('M d Y', strtotime($reply->created_at)) }}  <i class=" ml-3 fa fa-clock-o"></i> {{ date('H:i', strtotime($reply->created_at)) }}  <i class=" ml-3 fa fa-map-marker"></i> Sri-Lanka</small>
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
            <div class="mt-4">
                <div class="comment_img">
                    <img width="80px" height="80px" src="{{ asset('assets/images/review_users/user-avatar.png') }}" alt="avatar"/>
                </div>
                <div class="comment_block">
                    <div class="description pb-4">
                        <p style="margin-top: -19px;">No Reviews yet!<br/>Be first to leave your review ...</p>
                    </div>
                </div>
            </div>
        @endif
    </ul>
    <div class="alert alert-info finished_data" style="display: none;">
        <i class="ti-info"></i> No Result Found!
    </div>
    @if(count($service_reviews)>=3)
        <div id="loadMore" style="" class="pb-3">
            <button id="show_more" class="btn btn-fill-out">View More Reviews</button>
        </div>
    @endif
</div>
