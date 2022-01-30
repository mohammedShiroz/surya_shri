<div id="fetch_times">
    <div class="row pr-4">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h6 class="text-center mt-3">Morning</h6>
            <div class="pl-3 pr-3 pb-4 w-100">
                <button class="btn btn-outline-dark d-none"></button>
                @php
                    $morning_times=array("9:00 AM", "9:30 AM", "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM");
                    $choose_time = isset($selected_time)? date('d-m-y', strtotime($selected_time)) : null;
                    $old_book = isset($booked_time)? date('h:i A', strtotime($booked_time)) : null;
                    $old_book_addition = isset($booked_time_addition)? $booked_time_addition : null;
                @endphp
                @foreach($morning_times as $k=>$time)
                    <button type="button"
                            @if($old_book)
                                @if(($old_book <= date('h:i A',strtotime($time))) && (date('h:i A', strtotime($time)) <= $old_book_addition))

                                @endif
                            @endif
                            @if((date('d-m-y H:i', strtotime(\Carbon\Carbon::now(). ' + 3 day')) >= date('y-m-d H:i',strtotime($choose_time." ".$time))) && (date('m',strtotime(\Carbon\Carbon::now())) == date('m',strtotime($choose_time." ".$time))))
                                disabled
                            @endif
                            class="btn btn-outline-dark set_time w-100 mt-3" data-time="{{ $time }}">{{$time}}</button>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h6 class="text-center mt-3">Afternoon</h6>
            <div class="pl-3 pr-3 pb-4 w-100">
                <button class="btn btn-outline-dark d-none"></button>
                @php $noon_times=array("2:00 PM", "2:30 PM", "3:00 PM", "3:30 PM", "4:00 PM", "4:30 PM"); @endphp
                @foreach($noon_times as $k=>$time)
                    <button type="button"
                            @if($old_book)
                                @if(($old_book <= date('h:i A',strtotime($time))) && (date('h:i A', strtotime($time)) <= $old_book_addition))

                                @endif
                            @endif
                            @if(date('d-m-y H:i', strtotime(\Carbon\Carbon::now(). ' + 3 day')) >= date('y-m-d H:i',strtotime($choose_time." ".$time)) && (date('m',strtotime(\Carbon\Carbon::now())) == date('m',strtotime($choose_time." ".$time))))
                                disabled
                            @endif
                            class="btn btn-outline-dark set_time w-100 mt-3" data-time="{{ $time }}">{{$time}}</button>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h6 class="text-center mt-3">Evening</h6>
            <div class="pl-3 pr-3 pb-4 w-100">
                <button class="btn btn-outline-dark d-none"></button>
                @php $evening_times=array("5:00 PM", "5:30 PM", "6:00 PM", "6:30 PM", "7:00 PM", "7:30 PM"); @endphp
                @foreach($evening_times as $k=>$time)
                    <button type="button"
                            @if($old_book)
                                @if(($old_book <= date('h:i A',strtotime($time))) && (date('h:i A', strtotime($time)) <= $old_book_addition))

                                @endif
                            @endif
                            @if(date('d-m-y H:i', strtotime(\Carbon\Carbon::now(). ' + 3 day')) >= date('y-m-d H:i',strtotime($choose_time." ".$time)) && (date('m',strtotime(\Carbon\Carbon::now())) == date('m',strtotime($choose_time." ".$time))))
                                disabled
                            @endif
                            class="btn btn-outline-dark set_time w-100 mt-3" data-time="{{ $time }}">{{$time}}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>
