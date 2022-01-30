@push('css_top')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('administration/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('administration/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@push('js')
    <!-- Select2 -->
    <script src="{{ asset('administration/plugins/select2/js/select2.full.min.js')}}"></script>
@endpush
@push('script')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endpush
