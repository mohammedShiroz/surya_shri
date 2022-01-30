@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('administration/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
@endpush
@push('script')
    <script>
        $(function () {
           $("#data_table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "paging": true,
                "searching": true,
                "info": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
            $(".data_tables").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "paging": true,
                "searching": true,
                "info": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
