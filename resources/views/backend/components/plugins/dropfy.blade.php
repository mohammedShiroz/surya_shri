@push('css')
    <link rel="stylesheet" href="{{ asset('administration/plugins/dropify/css/dropify.min.css')}}">
@endpush
@push('js')
    <script src="{{ asset('administration/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $(function () {
            // Basic
            $('.dropify').dropify();
            // Translated
            $('.dropify').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove:  'Supprimer',
                    error:   'Désolé, le fichier trop volumineux'
                }
            });

            // Used events
            var drEvent = $('.dropify').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element){
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function(event, element){
                console.log('Has Errors');
            });

            var drDestroy = $('.dropify').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e){
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })        });
    </script>
@endpush
