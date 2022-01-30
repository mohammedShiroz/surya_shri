<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{ asset('/administration/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/administration/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/administration/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('/administration/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/administration/plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/administration/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/administration/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/administration/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/administration/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('/administration/js/pages/dashboard2.js') }}"></script>
<script src="{{ asset('/administration/js/pages/dashboard.js') }}"></script>
<script>
    setTimeout(function () {
        $(".messages").fadeOut("slow");
    }, 6900);
</script>
@stack('js')
@stack('script')

