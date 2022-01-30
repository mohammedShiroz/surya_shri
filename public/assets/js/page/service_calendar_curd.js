var event_dates=[];
$(function () {
    $.ajax({
        url: '/users/bookings/events/all',
        method: "GET",
        success: function (data) {
            event_dates.push(data.date);
            event_dates.pop()
            for(var i=0; i < data.length; i++){
                if(data[i]['date']){
                event_dates.push(data[i]['date']); }
            }
        }
    });
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
        themeSystem: '',
        defaultView: 'dayGridMonth',
        validRange: {
            //start: new Date()
        },
        selectable: true,
        select: function(info) {
            var now = new Date();
            var selected_date = new Date(info.dateStr);
            now.setHours(0,0,0,0);
            if ( selected_date < now ) {
                return false;
            }
        },
        dateClick: function(info) {
            var errors=false;
            var now = new Date();
            var selected_date = new Date(info.dateStr);
            now.setHours(0,0,0,0);
            if ( selected_date < now) {
                swal("Notice!", "This "+moment(info.dateStr).format('D/M/YYYY')+" is unavailable! Please choose another.", "error");
            } else {
                var date1= new Date();
                var date2= new Date(info.dateStr);
                // var d1 = new Date(moment(new Date()).format('M/D/YYYY'));
                // var d2 = new Date(info.dateStr);
                // var day_diff = (d2.getTime() - d1.getTime()) / (1000 * 60 * 60 * 24);
                var diff = Math.abs(date1.getTime() - date2.getTime()) / 3600000;
                if (diff < 59) {
                    swal("Notice!", "This "+moment(info.dateStr).format('D/M/YYYY')+"  date is unavailable! Please choose another.\n"+" Call us to check if there are additional openings\n", "info");
                    errors=true;
                }
                //
                // if(day_diff < 3){
                //     swal("Notice!", "This "+moment(info.dateStr).format('D/M/YYYY')+"  date is unavailable! Please choose another.\n"+" Call us to check if there are additional openings\n", "info");
                //     errors=true;
                // }
            }
            // for(var i=0; i < event_dates.length; i++){
            //     if(moment(event_dates[i]).format('D/M/YYYY') == moment(selected_date).format('D/M/YYYY')){
            //         errors =true;
            //         swal("Notice!", "This "+moment(info.dateStr).format('D/M/YYYY')+"  date is already booked! Please choose another."+" Call us to check if there are additional openings\n", "info");
            //     }
            // }
            if(errors ==false){
                $(".booked_date").val(info.dateStr);
                $("#selected_date_cl").fadeIn();
                $(".show_selected_date").html(moment(info.dateStr).format('MMM DD, YYYY'));
                $(".get_selected_date").val(info.dateStr);
                $('.fc-day').removeClass('cellBg');
                $('.fc-day[data-date="' + info.dateStr + '"]').addClass('cellBg');
                $(".set_time").removeClass('btn-dark text-white');
                $(".booked_time").val(null);
                $(".show_selected_time").html('');
                $("#view_time_tag").hide();
                $("#time_slot").slideDown();
                $('html, body').animate({
                    scrollTop: ($("#time_slot_scroll").offset().top - 120)
                }, 1000);

                $.ajax({
                    url: "/clinique/reservations/time-slot",
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { selected_time: info.dateStr, },
                    success: function (data) {
                        $("#fetch_times").html(data.time_view);
                    }
                });
            }

            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // change the day's background color just for fun
        },
        editable: false,
        eventSources: [{
                        url: '/users/bookings/events/all',
                        type: 'POST',
                        allDayDefault:false,
                        color: '#121212',
                        textColor: '#121212',
                        //display:'background',
                        }
        ],
        events: [
            {
                start: '1000-05-06',
                end: new Date(),
                display:'background',
                backgroundColor:'#cccccc',
                borderColor: '#949494',
                allDay: true

            },
            {
                start: new Date(),
                title: '',
                end: new Date().setDate((new Date().getDate() + 3)),
                display:'background',
                backgroundColor: '#f2f0d3',
                borderColor: 'transparent',
                textColor: '#868686',
                allDay: true
            },
            {
                start: new Date(),
                end: new Date(),
                title: '\t\tToday',
                display:'block',
                backgroundColor: 'transparent',
                borderColor: 'transparent',
                textColor: '#868686',
                allDay: true
            },

        ],
        eventDidMount: function(info) {
            info.el.style.borderRadius = '5px';
            info.el.style.borderWidth = '5px';
            info.el.style.textAlign = 'center';
        },
    });
    calendar.render();
    $("button.fc-prev-button").prop("disabled",true);
    // $('#calendar').fullCalendar()
    $('body').on('click', 'button.fc-prev-button', function() {
        if(((moment(calendar.getDate()).format('M')-1) < moment(new Date()).format('M')) && ((moment(calendar.getDate()).format('YYYY')) == moment(new Date()).format('YYYY'))){
            $("button.fc-prev-button").prop("disabled",true);
        }else{
            $("button.fc-prev-button").prop("disabled",false);
        }
        if((moment(calendar.getDate()).format('YYYY')) > 2023){
            $("button.fc-next-button").prop("disabled",true);
        }else{
            $("button.fc-next-button").prop("disabled",false);
        }
    });
    $('body').on('click', 'button.fc-next-button', function() {
        if(((moment(calendar.getDate()).format('M')-1) < moment(new Date()).format('M')) && ((moment(calendar.getDate()).format('YYYY')) == moment(new Date()).format('YYYY'))){
            $("button.fc-prev-button").prop("disabled",true);
        }else{
            $("button.fc-prev-button").prop("disabled",false);
        }

        if((moment(calendar.getDate()).format('YYYY')) > 2023){
            $("button.fc-next-button").prop("disabled",true);
        }else{
            $("button.fc-next-button").prop("disabled",false);
        }
    });
});


