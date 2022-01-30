@extends('backend.layouts.admin')
@section('page_title','Edit Reservation')
@include('backend.components.plugins.full_calendar')
@include('backend.components.plugins.alert')
@push('css')
    <style>
        .fc-day:hover{ background: rgba(156,118,30,0.1); cursor: pointer; }.fc-highlight { background: rgba(156,118,30,0.3) !important; color: white !important; }
        .sticky{ position:-webkit-sticky; position:sticky; top:100px; } .cellBg { background: rgba(156,118,30,0.4) !important; color: #ffffff; border: 2px solid #97751d !important; }
        .text-black{ color:black !important; }
    </style>
@endpush
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $data->user->name }}'s Reservation Detail</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservations</a></li>
                            <li class="breadcrumb-item active">{{ $data->customer->name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user shadow">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-secondary">
                                <h3 class="widget-user-username text-uppercase"><strong>{{ $data->service->name }}</strong></h3>
                                <h5 class="widget-user-desc"><small>{{ $data->service->category->name }}</small></h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="{{ (!empty($data->service->thumbnail_image)) ? asset($data->service->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" style="width:128px; height: 128px; " width="128px" height="128px" alt="{{ $data->service->thumbnail_image }}">
                            </div>
                            <div class="card-footer" style="padding-top: 100px">
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">{{ $data->status }}</h5>
                                            <span class="description-text">Status</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">{{ getCurrencyFormat($data->price) }}</h5>
                                            <span class="description-text">Paid Amount</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">{!! ($data->payment->payment_status == "success")? '<span class="badge badge-success">Paid</span>': '<span class="badge badge-danger">Not Paid</span>' !!}</h5>
                                            <span class="description-text">Payment Status</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    <div class="col-12">
                        @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($data->book_date)))
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-info-circle"></i> Expired!</h5>
                                Reservation has been expired On {{ date('D',strtotime($data->book_date)) }} {{ date('d M, Y',strtotime($data->book_date)) }}.
                            </div>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Reservation Date & Time</h3>
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
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="panel-body" style="border: none !important; padding: 0 !important;">
                                            <table class="table border w-100">
                                                <tr>
                                                    <td width="15%"><strong>Reservation Date & Time</strong></td>
                                                    <td>On {{ date('l',strtotime($data->book_date)) }} {{ date('d M, Y',strtotime($data->book_date)) }} at {{ $data->book_time }}</td>
                                                </tr>
                                            </table>
                                            <div id="calendar"></div>
                                            <div id="time_slot_scroll"></div>
                                            <div class="border mt-3" id="time_slot" style="display: none;">
                                                <div class="row pr-4">
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h6 class="text-center mt-3">Morning</h6>
                                                        <div class="pl-3 pr-3 pb-4 w-100">
                                                            <button class="btn btn-outline-dark d-none"></button>
                                                            @php $morning_times=array("8:00 am", "8:30 am", "9:00 am", "9:30 am", "10:00 am", "10:30 am", "11:00 am", "11:30 am"); @endphp
                                                            @foreach($morning_times as $k=>$time)
                                                                <button type="button" class="btn btn-outline-dark set_time w-100 mt-3" data-time="{{ $time }}">{{$time}}</button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h6 class="text-center mt-3">Afternoon</h6>
                                                        <div class="pl-3 pr-3 pb-4 w-100">
                                                            <button class="btn btn-outline-dark d-none"></button>
                                                            @php $noon_times=array("12:00 pm", "12:30 pm", "1:00 pm", "1:30 pm", "2:00 pm", "2:30 pm", "3:00 pm", "3:30 pm", "4:00 pm", "4:30 pm"); @endphp
                                                            @foreach($noon_times as $k=>$time)
                                                                <button type="button" class="btn btn-outline-dark set_time w-100 mt-3" data-time="{{ $time }}">{{$time}}</button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h6 class="text-center mt-3">Evening</h6>
                                                        <div class="pl-3 pr-3 pb-4 w-100">
                                                            <button class="btn btn-outline-dark d-none"></button>
                                                            @php $evening_times=array("5:00 pm", "5:30 pm", "6:00 pm", "6:30 pm", "7:00 pm", "7:30 pm"); @endphp
                                                            @foreach($evening_times as $k=>$time)
                                                                <button type="button" class="btn btn-outline-dark set_time w-100 mt-3" data-time="{{ $time }}">{{$time}}</button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('reservations.update',$data->id) }}" method="post" class="form-horizontal" role="form">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="old_book_date" value="{{ $data->book_date }}"/>
                                                <input type="hidden" name="old_book_time" value="{{ $data->book_time }}"/>
                                            <div id="show_update"></div>
                                            <div class="form-group row mt-5">
                                                <div class="col-md-6 col-sm-12">
                                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Booked Date</label>
                                                    <input type="text" required readonly class="form-control booked_date @error('book_date') is-invalid @enderror" name="book_date" value="{{ old('book_date')? old('book_date') : $data->book_date }}" placeholder="Booked Date ...">
                                                    @error('book_date')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Booked Time</label>
                                                    <input type="text" readonly required class="form-control booked_time @error('book_time') is-invalid @enderror" name="book_time" value="{{ old('book_time')? old('book_time') : $data->book_time }}" placeholder="Booked Time ...">
                                                    @error('book_time')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12 pull-right">
                                                    <a href="" type="reset" class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i> Reset</a>
                                                    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check-circle"></i> Save & changes</button>
                                                    <a href="{{ route('reservations.index') }}" class="btn btn-danger btn-flat"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
@push('script')
    <script>
        $(function () {
            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');
            // initialize the external events
            // -----------------------------------------------------------------
            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'title',
                    center: '',
                    right: 'prev,next today'
                },
                themeSystem: 'bootstrap',
                defaultView: 'dayGridMonth',
                validRange: {
                    //start: new Date()
                },
                navLinks: true,
                nowIndicator: true,
                dayMaxEvents: true, // allow "more" link when too many events
                selectable: true,
                select: function(info) {
                    var now = new Date();
                    var selected_date = new Date(info.dateStr);
                    now.setHours(0,0,0,0);
                    if ( selected_date < now) {
                        return false;
                    } else {
                        return true;
                    }
                },
                dateClick: function(info) {
                    var now = new Date();
                    var selected_date = new Date(info.dateStr);
                    now.setHours(0,0,0,0);
                    if ( selected_date < now) {
                        swal.fire(
                            {
                                type: 'warning',
                                icon: "warning",
                                title: 'Invalid Date',
                                text: 'Sorry, unable to choose this date.',
                                showConfirmButton: false,
                                timer: 1000
                            }
                        );
                    } else {
                        $(".booked_date").val(info.dateStr);
                        $('.fc-day').removeClass('cellBg');
                        $('.fc-day[data-date="'+ info.dateStr +'"]').addClass('cellBg');
                        $(".set_time").removeClass('btn-dark text-white');
                        $(".booked_time").val(null);
                        $(".show_selected_time").html('');
                        $("#view_time_tag").hide();
                        $("#time_slot").slideDown();
                        $('html, body').animate({
                            scrollTop: ($("#time_slot_scroll").offset().top-120)
                        }, 1000);
                    }
                    // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    // alert('Current view: ' + info.view.type);
                    // change the day's background color just for fun
                },
                editable: false,
                events: '{{ route('reservations.all.events') }}',
                eventDidMount: function(info) {
                    info.el.style.borderRadius = '5px';
                    info.el.style.borderWidth = '2px';
                    info.el.style.borderDash = true;
                    info.el.style.textAlign = 'center';
                },
            });
            calendar.render();
            // $('#calendar').fullCalendar()
        });
    </script>
    <script>
        $(".set_time").click(function(){
            $(".set_time").removeClass('btn-dark text-white');
            $(this).addClass('btn-dark text-white');
            $(".booked_time").val($(this).attr('data-time'));
            $('html, body').animate({
                scrollTop: $("#show_update").offset().top
            }, 1000);
        });
    </script>
@endpush
