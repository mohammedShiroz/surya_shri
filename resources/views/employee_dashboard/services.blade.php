@extends('layouts.front')
@section('page_title','My Services')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('My Services'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'My Services','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Partner','route'=>route('partners.profile')],
        3=>['name'=>'My Services','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('employee_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">My Services</h5>
                            </div>
                            <div class="card-body">
                                @include('components.messages')
                                @if(\auth::user()->employee->is_doctor)
                                    <table id="data_table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service Image</th>
                                            <th>Service Name and Code</th>
                                            <th>Listed Price</th>
                                            <th>Doctor’s Fee</th>
                                            <th>No. of Reservations</th>
                                            <th>Listing Status</th>
                                            <th>Listing Visibility</th>
                                            <th>Listed Date & Time</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Service::where('doctor_id', \Auth::user()->employee->id)->where('status','Available')->whereNull('is_deleted')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td width="80px"><img class="rounded-circle" width="80px" height="80px" src="{{ (!empty($row->image)) ? asset($row->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" alt="product Image" /></td>
                                                <td>
                                                    {{ $row->name }}<br/>
                                                    ({{ $row->service_code }})
                                                </td>
                                                <td>{{ getCurrencyFormat($row->price) }}</td>
                                                <td>{{ getCurrencyFormat($row->seller_paid_amount) }}</td>
                                                <td>{{ \App\Service_booking::where('service_id',$row->id)->where('status','Completed')->whereNull('is_deleted')->get()->count() }}</td>
                                                <td>{{ ($row->status == "Available")? 'Published' : 'Unpublished'  }}</td>
                                                <td>{{ $row->visibility == 0 ? "Hidden" : 'Visible' }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>
                                                    <div class="mb-2" role="group" aria-label="Basic example">
                                                        <a href="{{ route('services.details',[$row->category->slug, $row->slug]) }}" class="btn btn-line-fill btn-radius btn-sm"><small>View Details</small></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p><i class="fa fa-info-circle mr-2"></i>
                                        If you are a registered doctor at the Sri Lanka Ayurveda Medical Council with
                                        a practice that arises to our quality standards with a record of proven results
                                        in either enhancing wellness or curing illnesses, <a href="{{ route('contact-us') }}">Contact SURYA SHRI</a> to enlist
                                        your services along with our fruitful collection of services in our <a href="{{ route('services') }}">“CLINIQUE”.</a>
                                        </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
