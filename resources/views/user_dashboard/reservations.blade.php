@extends('layouts.front')
@section('page_title','Reservations')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Reservations'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Reservations','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Reservations','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">MY Reservations</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row shop_container grid">
                                            @if(\auth::user()->booking()->count() > 0)
                                                @foreach(\Auth::user()->booking as $row)
                                                    <div class="col-md-4 col-sm-12">
                                                        @if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($row->book_date)))
                                                            <span class="ml-3 pr_flash bg-danger" style="border-radius: 15px;">Expired</span>
                                                        @endif
                                                        <div class="product_box">
                                                            <div class="product_action_box" onclick='window.location.href = "{{ route('dashboard.reservations.view',HashEncode($row->id)) }}";' style="position: absolute; background: transparent; height: 500px;"></div>
                                                            <div class="product_img">
                                                                <a href="{{ route('dashboard.reservations.view',HashEncode($row->id)) }}">
                                                                    <img src="{{ asset(($row->service->thumbnail_image)? $row->service->thumbnail_image : 'assets/images/service_img_none/no_service_img.jpg') }}" alt="{{$row->service->name}}">
                                                                </a>
                                                            </div>
                                                            <div class="product_info">
                                                                <h5 class="product_title">
                                                                    <a href="{{ route('dashboard.reservations.view',HashEncode($row->id)) }}">
                                                                        {{$row->service->name}}</a>
                                                                    <small class="d-block text-sm" style="font-size: 13px;">{{ $row->service->tag_code }}</small>
                                                                </h5>
                                                                <div class="product_sort_info">
                                                                    <ul>
                                                                        <li><i class="linearicons-clock"></i> {{ $row->book_time }}</li>
                                                                        <li><i class="linearicons-calendar-check"></i> {{ date('d M, Y',strtotime($row->book_date)) }} On {{ date('D',strtotime($row->book_date)) }}</li>
                                                                        <li><i class="ti-comment-alt"></i>
                                                                            @if($row->status == "Pending")
                                                                                <span class="badge badge-warning">Pending</span>
                                                                            @elseif($row->status == "Confirmed")
                                                                                <span class="badge badge-success">Confirmed</span>
                                                                            @elseif($row->status == "Rejected")
                                                                                <span class="badge badge-danger">Rejected</span>
                                                                            @elseif($row->status == "Canceled")
                                                                                <span class="badge badge-danger">Canceled</span>
                                                                            @elseif($row->status == "Completed")
                                                                                <span class="badge badge-success">Completed</span>
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="add-to-cart">
                                                                    <a href="{{ route('dashboard.reservations.view',HashEncode($row->id)) }}" class="btn btn-fill-out btn-radius w-100">Details <i class="icon-arrow-right ml-1"></i> </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="card mb-3 mb-lg-0">
                                                        <div class="card-body">
                                                            <p>No reservations done yet!</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
