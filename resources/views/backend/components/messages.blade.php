@push('script')
    <!-- SweetAlert2 -->
    <script src="{{ asset('/administration/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/administration/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function() {
            @if(count($errors)>0)
                @foreach($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach
            @endif
            @if(session('success'))
                toastr.success('{{session('success')}}');
            @endif
            @if(session('error'))
                toastr.error('{{session('error')}}');
            @endif
            @if(session('info'))
                toastr.info('{{session('info')}}');
            @endif
            @if(session('warning'))
                toastr.info('{{session('warning')}}');
            @endif
        });
    </script>
@endpush
