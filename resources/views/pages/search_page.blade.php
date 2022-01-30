@extends('layouts.front',['old_search_word' => $old_search_word])
@section('page_title','Search Result')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Boutique'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/customs_popup.css')}}">
@endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Search Result','paths'=>[
           0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
           1=>['name'=>'Search Results','route'=>''],
       ]])
    <!-- START SECTION SHOP -->
    <div class="section small_pt" style="margin-top: -80px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    @if(isset($_COOKIE['load_popup']))
                        @if($_COOKIE['load_popup'] == "true")
                        @endif
                    @endif
                    <button class="button button--warning d-none" id="show_question_popup" data-for="js_question-popup"></button>
                    <div class="popup popup--icon -question js_question-popup">
                        <div class="popup__background"></div>
                        <div class="popup__content">
                            <button type="button" class="close" data-for="js_question-popup">
                                <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                            </button>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="background_bg h-100 radius_all_5" data-img-src="{{ asset('assets/images/prakrti-pop-up-image.png') }}"></div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="popup_content p-2">
                                        <div class="popup-text">
                                            <div class="heading_s1 pt-md-2 pt-sm-1">
                                                <h3>Prakrti Parīksha</h3>
                                            </div>
                                            <p style="font-weight: 400; line-height: 20px;" class="mt-n4">Understand yourself better<br/>by assessing your Prakrti!</p>
                                            <p style="line-height: 20px;" class="p-1">Let's evaluate your 'Prakrti' (body constitution) to see what wellness and beauty Products and Services best suit you! Make sure you select the most suitable answer option that fits your natural state.</p>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <a class="button button--check--now btn-block text-uppercase rounded-0" href="{{ route('prakrti.products') }}" title="Check Now">Check Now</a>
                                        </div>
                                        <div class="chek-form">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="popup-show" id="popup-show" value="">
                                                <label class="form-check-label" for="popup-show"><span>Don't show this popup again!</span></label>
                                            </div>
                                        </div>
                                        <p class="mt-1 pb-0" style="margin-bottom: -10px;"><a href="javascript:void(0)" data-for="js_question-popup" class="small">Skip it</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @push('script')
                        <script>
                            $( document ).ready(function() {
                                setTimeout(function () {
                                    @auth @if(!\App\Customers_answers::where('user_id',\auth::user()->id)->first()) $('#show_question_popup').trigger('click'); @endif
                                    @else $('#show_question_popup').trigger('click'); @endauth
                                }, 2000);
                            });
                            const addButtonTrigger = el => {
                                el.addEventListener('click', () => {
                                    const popupEl = document.querySelector(`.${el.dataset.for}`);
                                    popupEl.classList.toggle('popup--visible');
                                });
                            };
                            Array.from(document.querySelectorAll('button[data-for]')).
                            forEach(addButtonTrigger);
                            Array.from(document.querySelectorAll('a[data-for]')).
                            forEach(addButtonTrigger);
                            $("#popup-show").click(function(){
                                if($("input:checkbox[name='popup-show']").is(":checked")) {
                                    set_cookie('false'); }else{ set_cookie('true');
                                }
                            });
                            function set_cookie(status){
                                $.ajax({
                                    url:"prakrti-parīksha/popup-curd",
                                    method: "POST",
                                    data:{status:status},
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function (data) {}
                                });
                            }
                        </script>
                    @endpush
                </div>
            </div>
            <div class="row">
                @if(isset($old_search_word))
                    @if(($data_products->count() + $data_services->count()) > 0)
                        <div class="col-md-12 col-sm-12 grid_item pb-lg-0 mb-4 mt-4">
                            <div class="msg-alert warning bg-transparent text-black-50 border-bottom border-left border-top border-right">
                                <span class="msg-closebtn text-black-50">&times;</span>
                                <strong><i class="fa fa-search"></i></strong>&nbsp; <strong>{{ ($data_products->count() + $data_services->count()) }}</strong> found{{ isset($old_search_word)? " for ".$old_search_word."!" : '!' }}
                            </div>
                        </div>
                    @else
                        <div class="col-md-12 col-12 grid_item pb-lg-0 mb-4 mt-4">
                            <div class="msg-alert warning bg-transparent text-black-50 border-bottom border-left border-top border-right">
                                <span class="msg-closebtn text-black-50">&times;</span>
                                <strong><i class="fa fa-info fa-lg "></i></strong>&nbsp; No search results found{{ isset($old_search_word)? " for ".$old_search_word."!" : '!' }}
                            </div>
                        </div>
                    @endif
                @endif
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @include('components.search.data_fetch')
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection
@push('js')
@endpush
@push('script')
    <script>
        $(document).ready(function () {
        });
    </script>
@endpush
