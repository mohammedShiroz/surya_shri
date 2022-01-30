@push('css')
    <!-- Sweet Alert -->
    <link href="{{asset('administration/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('administration/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css">
@endpush
@push('js')
    <!-- Sweet-Alert  -->
    <script src="{{asset('administration/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
@endpush
@push('script')
    <script>
        {{--@if (session('success'))--}}
        {{--Swal.fire({--}}
            {{--type: 'success',--}}
            {{--title: '{{ session()->get("success") }}',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 1500--}}
        {{--});--}}
        {{--@endif--}}
        {{--@if (session('error'))--}}
        {{--Swal.fire({--}}
            {{--type: 'error',--}}
            {{--title: '{{ session()->get("error") }}',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 1500--}}
        {{--});--}}
        {{--@endif--}}
        {{--@if (session('info'))--}}
        {{--Swal.fire({--}}
            {{--type: 'info',--}}
            {{--title: '{{ session()->get("info") }}',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 1500--}}
        {{--});--}}
        {{--@endif--}}
        // function deleteConfirmation(form) {
        //     swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Yes, delete it!',
        //         cancelButtonText: 'No, cancel!',
        //         reverseButtons: true
        //     }).then((result) => {
        //         if (result.value) {
        //             document.getElementById(form).submit();
        //         } else if (
        //             // Read more about handling dismissals
        //             result.dismiss === Swal.DismissReason.cancel
        //         ) {
        //             swal.fire(
        //                 {
        //                     type: 'info',
        //                     title: 'Delete Cancelled',
        //                     showConfirmButton: false,
        //                     timer: 1000
        //                 }
        //             )
        //         }
        //     })
        // }
    </script>
@endpush
