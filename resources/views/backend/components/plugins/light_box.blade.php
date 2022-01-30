@push('css')
    <link rel="stylesheet" href="{{ asset('administration/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endpush
@push('js')
    <script src="{{ asset('administration/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $(function () {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({gutterPixels: 3});
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
@endpush
