@push('css')
    <link rel="stylesheet" href="{{ asset('administration/plugins/fullcalendar/main.css')}}">
@endpush
@push('js')
    <!-- fullCalendar 2.2.5 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.min.js"></script>
    <script src="{{ asset('administration/plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('administration/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ asset('administration/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ asset('administration/plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ asset('administration/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>

@endpush
