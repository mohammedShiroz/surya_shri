<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section page-title-mini">
    {{--style="background: url({{ asset('assets/images/banners/breadcrump.jpg') }}); background-size: contain"--}}
    <div class="{{ isset($custom_container)? 'custom-container' : 'container' }}"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1 class="text-uppercase" style="color: #837000;">{!! isset($page_title_text)? $page_title_text : '' !!}</h1>
                </div>
            </div>
            <div class="col-md-6">
                @if(isset($paths))
                    <ol class="breadcrumb justify-content-md-end">
                        @foreach($paths as $path)
                            @if($loop->last)
                                <li class="breadcrumb-item active">{!! $path['name'] !!}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{$path['route']}}">{!! $path['name'] !!}</a></li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

