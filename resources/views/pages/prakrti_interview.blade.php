@extends('layouts.front')
@section('page_title','Prakrti Parīksha Interview')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Recommended Prakrti Parīksha Products'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.alert')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/questions/question.css')}}">
    <style>.sticky-bar{ position:-webkit-sticky; position:sticky; top:125px; }</style>
@endpush
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Prakrti Parīksha','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Prakrti Parīksha','route'=>''],
        ]])
    <div class="main_content">
        <!-- START SECTION BLOG -->
        <div class="section small_pt pb_70">
            <div class="container">
                @if (\Session::get('data_submitted'))
                    <div class="row mt-n5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row justify-content-center text-center">
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="covid-test-wrap test-step test-report active">
                                        <div class="test-progress">
                                            <img src="{{ asset('assets/images/big-green-check.png') }}" class="img-fluid" alt="">
                                        </div>
                                        <h3 class="text-uppercase text-success">CONGRATULATION!<br/>YOUR PRAKRTI IS ANALYZED.</h3>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                                <div class="sidebar">
                                                    <div class="widget">
                                                        <div class="row">
                                                            {{--<div class="col-lg-3 col-md-3 col-sm-6">--}}
                                                            {{--<div class="contact_wrap contact_style3">--}}
                                                            {{--<div class="contact_icon">--}}
                                                            {{--<span class="question-progress-count">{{ $answers->question_count }}/{{ (\App\Questions::where('visibility',1)->orderby('order','asc')->get()->count()) }}</span>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="contact_text">--}}
                                                            {{--<p class="text-uppercase"><strong>Answered Questions</strong></p>--}}
                                                            {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--</div>--}}
                                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                                <div class="contact_wrap contact_style3">
                                                                    <div class="contact_icon">
                                                                        <span class="vata-progress-count">{{ ($answers->vata)? round($answers->vata,0) : '0' }}%</span>
                                                                    </div>
                                                                    <div class="contact_text">
                                                                        <p class="text-uppercase"><strong>Vāta</strong></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                                <div class="contact_wrap contact_style3">
                                                                    <div class="contact_icon">
                                                                        <span class="pitta-progress-count">{{ ($answers->pitta)? round($answers->pitta,0) : '0' }}%</span>
                                                                    </div>
                                                                    <div class="contact_text">
                                                                        <p class="text-uppercase"><strong>Pitta</strong></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                                <div class="contact_wrap contact_style3">
                                                                    <div class="contact_icon">
                                                                        <span class="kapha-progress-count">{{ ($answers->kapha)? round($answers->kapha,0) : '0' }}%</span>
                                                                    </div>
                                                                    <div class="contact_text">
                                                                        <p class="text-uppercase"><strong>Kapha</strong></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>Based on the answers you provided, we have brought together a recommendation of our amazing products and services that we believe will enhance your wellness best. Check them out through the links below!</p>
                                        <h4 class="mt-4">Balancing <span class="line">&#73;</span> Revitalizing</h4>
                                        <div class="row justify-content-center text-center w-100">
                                            <a href="{{ route('prakrti.products') }}" class="button--submit mt-3 text-white mr-2 pl-3 pr-3">Check Products</a>
                                            <a href="{{ route('prakrti.services') }}" class="button--submit mt-3 text-white pl-3 pr-3">Check Clinique</a>
                                            <a href="javascript:void(0)" id="send-answer-copy" class="button--submit mt-3 text-white ml-2 pl-3 pr-3">Email Me a Copy</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!$answers)
                    <div class="row">
                        <div class="col-lg-9">
                            <h3 class="text-center">Prakrti Parīksha</h3>
                            <p class="mb-3 question_slot_scroll text-center">Let's evaluate your 'Prakrti' (body constitution) to see what wellness and beauty Products and Services best suit you! Make sure you select the most suitable answer option that fits your natural state.</p>
                            <div class="covid-wrap">
                                <form action="{{ route('prakrti.store.answer') }}" method="POST" id="question-form">
                                    @csrf
                                    <?php $question_ids=null; $loop_ids=null; $all_question_ids = null; foreach (\App\Questions::where('visibility',1)->orderby('order','asc')->get() as $row){  $all_question_ids .= $row->id.",";}?>
                                    <input type="hidden" name="answer_ids" id="selected_answers" value=""/>
                                    <input type="hidden" name="user_id" value="{{ \auth::user()->id }}"/>
                                    <input type="hidden" value="{{ $all_question_ids }}" id="all_que_ids"/>
                                    <input type="hidden" id="answered_count_all" name="question_count" value="0"/>
                                    <input type="hidden" id="vata-counts" name="vata" value="0"/>
                                    <input type="hidden" id="pitta-counts" name="pitta" value="0"/>
                                    <input type="hidden" id="kapha-counts" name="kapha" value="0"/>
                                    @for($i=0; $i<(\App\Questions::where('visibility',1)->orderby('order','asc')->get()->count()/5); $i++)
                                        <div class="covid-test-wrap test-step {{ ($i == 0)? 'active' : '' }}">
                                            @if($i != 0)
                                                <div class="test-progress">
                                                    <a href="#" class="prev-btn"><img src="{{ asset('assets/images/arrow-left-grey.png') }}" alt="">Previous</a>
                                                    <div class="small_divider"></div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                @if($i == 0)
                                                    @foreach(\App\Questions::where('visibility',1)->orderby('order','asc')->get()  as $row)
                                                        @if(($loop->index+1) <= 5)
                                                            <div class="col-xl-6 col-md-6 col-sm-12 {{ (($loop->index+1) == 5)? 'offset-lg-3 offset-md-3' : '' }} grid_item">
                                                                <div class="blog_post blog_style2 box_shadow1">
                                                                    <div class="blog_content bg-white">
                                                                        <h6 class="question-name mt-3">{{ ($loop->index+1) }}. {{ $row->question }}</h6>
                                                                        <div class="step-block">
                                                                            @foreach($row->answers as $answer)
                                                                                <div class="form-group">
                                                                                    <input type="radio" name="question-{{$row->id}}" class="form-control que-answers-{{$row->id}} common_answers" value="{{ $answer->id }}" data-type="{{ ($answer->order == 1)? 'Vata' : (($answer->order == 2)? 'Pitta' : (($answer->order == 3)? 'Kapha' : 'Vata')) }}" id="answer_{{ $answer->id }}">
                                                                                    <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php  $question_ids .= $row->id.","; $loop_ids .= ($loop->index+1).",";?>
                                                        @endif
                                                    @endforeach
                                                    <input type="hidden" id="question-ids-{{ $i }}" value="{{$question_ids}}"/><input type="hidden" id="answer-loop-ids-{{ $i }}" value="{{$loop_ids}}"/>
                                                @elseif($i == 1)<?php  $question_ids = null; $loop_ids= null; ?>
                                                @foreach(\App\Questions::where('visibility',1)->orderby('order','asc')->get()  as $row)
                                                    @if(($loop->index+1) >= 6 && ($loop->index+1) <= 10)
                                                        <div class="col-xl-6 col-md-6 col-sm-12 {{ (($loop->index+1) == 10)? 'offset-lg-3 offset-md-3' : '' }} grid_item">
                                                            <div class="blog_post blog_style2 box_shadow1">
                                                                <div class="blog_content bg-white">
                                                                    <h6 class="question-name mt-3">{{ ($loop->index+1) }}. {{ $row->question }}</h6>
                                                                    <div class="step-block">
                                                                        @foreach($row->answers as $answer)
                                                                            <div class="form-group">
                                                                                <input type="radio" name="question-{{$row->id}}" class="form-control que-answers-{{$row->id}} common_answers" value="{{ $answer->id }}" data-type="{{ ($answer->order == 1)? 'Vata' : (($answer->order == 2)? 'Pitta' : (($answer->order == 3)? 'Kapha' : 'Vata')) }}" id="answer_{{ $answer->id }}">
                                                                                <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <?php  $question_ids .= $row->id.","; $loop_ids .= ($loop->index+1).",";?>
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="question-ids-{{ $i }}" value="{{$question_ids}}"/> <input type="hidden" id="answer-loop-ids-{{ $i }}" value="{{$loop_ids}}"/>
                                                @elseif($i == 2) <?php  $question_ids = null; $loop_ids= null;?>
                                                @foreach(\App\Questions::where('visibility',1)->orderby('order','asc')->get()  as $row)
                                                    @if(($loop->index+1) >= 11 && ($loop->index+1) <= 15)
                                                        <div class="col-xl-6 col-md-6 col-sm-12 {{ (($loop->index+1) == 15)? 'offset-lg-3 offset-md-3' : '' }} grid_item">
                                                            <div class="blog_post blog_style2 box_shadow1">
                                                                <div class="blog_content bg-white mt-3">
                                                                    <h6 class="question-name">{{ ($loop->index+1) }}. {{ $row->question }}</h6>
                                                                    <div class="step-block">
                                                                        @foreach($row->answers as $answer)
                                                                            <div class="form-group">
                                                                                <input type="radio" name="question-{{$row->id}}" class="form-control que-answers-{{$row->id}} common_answers" value="{{ $answer->id }}" data-type="{{ ($answer->order == 1)? 'Vata' : (($answer->order == 2)? 'Pitta' : (($answer->order == 3)? 'Kapha' : 'Vata')) }}" id="answer_{{ $answer->id }}">
                                                                                <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <?php  $question_ids .= $row->id.","; $loop_ids .= ($loop->index+1).",";?>
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="question-ids-{{ $i }}" value="{{$question_ids}}"/> <input type="hidden" id="answer-loop-ids-{{ $i }}" value="{{$loop_ids}}"/>
                                                @elseif($i == 3) <?php  $question_ids = null; $loop_ids= null; ?>
                                                @foreach(\App\Questions::where('visibility',1)->orderby('order','asc')->get()  as $row)
                                                    @if(($loop->index+1) >= 16 && ($loop->index+1) <= 20)
                                                        <div class="col-xl-6 col-md-6 col-sm-12 {{ (($loop->index+1) == 20)? 'offset-lg-3 offset-md-3' : '' }} grid_item">
                                                            <div class="blog_post blog_style2 box_shadow1">
                                                                <div class="blog_content bg-white mt-3">
                                                                    <h6 class="question-name">{{ ($loop->index+1) }}. {{ $row->question }}</h6>
                                                                    <div class="step-block">
                                                                        @foreach($row->answers as $answer)
                                                                            <div class="form-group">
                                                                                <input type="radio" name="question-{{$row->id}}" class="form-control que-answers-{{$row->id}} common_answers" value="{{ $answer->id }}" data-type="{{ ($answer->order == 1)? 'Vata' : (($answer->order == 2)? 'Pitta' : (($answer->order == 3)? 'Kapha' : 'Vata')) }}" id="answer_{{ $answer->id }}">
                                                                                <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <?php  $question_ids .= $row->id.","; $loop_ids .= ($loop->index+1).",";?>
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="question-ids-{{ $i }}" value="{{$question_ids}}"/><input type="hidden" id="answer-loop-ids-{{ $i }}" value="{{$loop_ids}}"/>
                                                @elseif($i == 4) <?php  $question_ids = null; $loop_ids= null; ?>
                                                @foreach(\App\Questions::where('visibility',1)->orderby('order','asc')->get()  as $row)
                                                    @if(($loop->index+1) >= 21 && ($loop->index+1) <= 25)
                                                        <div class="col-xl-6 col-md-6 col-sm-12 {{ (($loop->index+1) == 25)? 'offset-lg-3 offset-md-3' : '' }} grid_item">
                                                            <div class="blog_post blog_style2 box_shadow1">
                                                                <div class="blog_content bg-white">
                                                                    <h6 class="question-name mt-3">{{ ($loop->index+1) }}. {{ $row->question }}</h6>
                                                                    <div class="step-block">
                                                                        @foreach($row->answers as $answer)
                                                                            <div class="form-group">
                                                                                <input type="radio" name="question-{{$row->id}}" class="form-control que-answers-{{$row->id}} common_answers" value="{{ $answer->id }}" data-type="{{ ($answer->order == 1)? 'Vata' : (($answer->order == 2)? 'Pitta' : (($answer->order == 3)? 'Kapha' : 'Vata')) }}" id="answer_{{ $answer->id }}">
                                                                                <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><?php  $question_ids .= $row->id.","; $loop_ids .= ($loop->index+1).",";?>
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="question-ids-{{ $i }}" value="{{$question_ids}}"/><input type="hidden" id="answer-loop-ids-{{ $i }}" value="{{$loop_ids}}"/>
                                                @elseif($i == 5) <?php  $question_ids = null; $loop_ids= null; ?>
                                                @foreach(\App\Questions::where('visibility',1)->orderby('order','asc')->get()  as $row)
                                                    @if(($loop->index+1) >= 26 && ($loop->index+1) <= 30)
                                                        <div class="col-xl-6 col-md-6 col-sm-12 {{ (($loop->index+1) == 30)? 'offset-lg-3 offset-md-3' : '' }} grid_item">
                                                            <div class="blog_post blog_style2 box_shadow1">
                                                                <div class="blog_content bg-white">
                                                                    <h6 class="question-name mt-3">{{ ($loop->index+1) }}. {{ $row->question }}</h6>
                                                                    <div class="step-block">
                                                                        @foreach($row->answers as $answer)
                                                                            <div class="form-group">
                                                                                <input type="radio" name="question-{{$row->id}}" class="form-control que-answers-{{$row->id}} common_answers" value="{{ $answer->id }}" data-type="{{ ($answer->order == 1)? 'Vata' : (($answer->order == 2)? 'Pitta' : (($answer->order == 3)? 'Kapha' : 'Vata')) }}" id="answer_{{ $answer->id }}">
                                                                                <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><?php  $question_ids .= $row->id.","; $loop_ids .= ($loop->index+1).",";?>
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="question-ids-{{ $i }}" value="{{$question_ids}}"/><input type="hidden" id="answer-loop-ids-{{ $i }}" value="{{$loop_ids}}"/>
                                                @endif
                                            </div>
                                            <div class="step-block step-block-min">
                                                <a href="#" class="d-block button--next" data-row-id="{{$i}}">Next</a>
                                            </div>
                                        </div>
                                    @endfor
                                    <div class="covid-test-wrap test-step asign-info" data-last-step="true">
                                        <div class="row">
                                            <div class="col-xl-9 col-md-9 col-sm-12 offset-lg-1 offset-md-1 grid_item">
                                                <div class="test-progress">
                                                    <div style="margin-top: 95px;">
                                                        <div id="loader-img">
                                                            <div id="loader"></div>
                                                        </div>
                                                    </div>
                                                    <small>Analyzing Your Result….</small>
                                                </div>
                                                <p>We will provide recommended wellness and beauty Products and Clinique services best suit you immediately. Please select your gender and submit your answers.</p>
                                                <button class="button--submit submit-answer w-50" type="button" style="display: none;">Check Result</button>
                                                <div class="step-block step-block-gender">
                                                    {{--<div class="row">--}}
                                                    {{--<div class="col-sm-6">--}}
                                                    {{--<div class="form-group">--}}
                                                    {{--<input type="radio" name="user_gender" class="form-control" id="gmale" value="Male" required>--}}
                                                    {{--<label for="gmale">Male</label>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-sm-6">--}}
                                                    {{--<div class="form-group">--}}
                                                    {{--<input type="radio" name="user_gender" class="form-control radio-btn-up" value="Female" id="gfemale" required>--}}
                                                    {{--<label for="gfemale">Female</label>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<button class="button--submit submit-answer" type="button">Check Result</button>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4 pt-2 mt-lg-0 pt-lg-0">
                            <div class="sidebar sticky-bar first">
                                <div class="widget ">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <div class="contact_wrap contact_style3">
                                                <div class="contact_icon">
                                                    <input type="hidden" id="que_count_all" value="{{ (\App\Questions::where('visibility',1)->orderby('order','asc')->get()->count()) }}"/>
                                                    <span class="question-progress-count">0/{{ (\App\Questions::where('visibility',1)->orderby('order','asc')->get()->count()) }}</span>
                                                </div>
                                                <div class="contact_text">
                                                    <p class="text-uppercase"><strong>Questions</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="col-xl-12 col-md-12">--}}
                                        {{--<div class="contact_wrap contact_style3">--}}
                                        {{--<div class="contact_icon">--}}
                                        {{--<span class="vata-progress-count">0%</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="contact_text">--}}
                                        {{--<p class="text-uppercase"><strong>Vāta</strong></p>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-xl-12 col-md-12">--}}
                                        {{--<div class="contact_wrap contact_style3">--}}
                                        {{--<div class="contact_icon">--}}
                                        {{--<span class="pitta-progress-count">0%</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="contact_text">--}}
                                        {{--<p class="text-uppercase"><strong>Pitta</strong></p>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-xl-12 col-md-12">--}}
                                        {{--<div class="contact_wrap contact_style3">--}}
                                        {{--<div class="contact_icon">--}}
                                        {{--<span class="kapha-progress-count">0%</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="contact_text">--}}
                                        {{--<p class="text-uppercase"><strong>Kapha</strong></p>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- END SECTION BLOG -->
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/page/prakrti_interview_curd.js') }}"></script>
@endpush
