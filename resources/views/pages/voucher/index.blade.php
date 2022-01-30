@extends('layouts.front')
@section('page_title','Voucher Code')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Voucher Code'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Voucher Code','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Voucher Code','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center order_complete">
                            <i class="fas fa-ticket-alt"></i>
                            <div class="heading_s1">
                                <input type="hidden" value="{{ $data->code }}" id="copy_url"/>
                                <h3 style="text-transform: none !important;">{{ $data->code }}</h3>
                            </div>
                            <p>You can use this voucher code to get an amazing discount<br/>for your {{ env('APP_NAME') }} products purchases.</p>
                            <button class="btn btn-line-fill btn-radius" onclick="copy_link()">Copy Code Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
@push('js')
    <script>
        function copy_link() {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($("#copy_url").val()).select();
            document.execCommand("copy");
            $temp.remove();
            swal("Link Copied", "Your partner invitation link has been copied", "success");
        }
    </script>
@endpush
