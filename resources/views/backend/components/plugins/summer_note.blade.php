@push('css')
    <!-- summernote -->
    {{--<link rel="stylesheet" href="{{ asset('administration/plugins/summernote/summernote-bs4.min.css')}}">--}}
@endpush
@push('js')
    <!-- Summernote -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    {{--<script src="{{ asset('administration/plugins/summernote/summernote-bs4.min.js') }}"></script>--}}
@endpush
@push('script')
    <script>
        CKEDITOR.replace( 'summernote' );
    </script>
@endpush
