@extends('layouts.front')
@section('page_title','Address')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Address'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.alert')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Address','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Address','route'=>''],
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
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>MY ADDRESS</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                @include('components.messages')
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h6><i class="fa fa-plus-circle"></i> Add Address</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>Please add your shipping or delivery address here.</p>
                                                        <form action="{{ route('user-address.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ \auth::user()->id }}" />
                                                            <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }} mb-3" value="{{ old('address') }}" placeholder="Your Address" />
                                                            <input type="text" name="postal_code" class="form-control mb-3" placeholder="Your postal code" />
                                                            <button type="reset" class="btn btn-info btn-sm">Reset</button>
                                                            <button type="submit" class="btn btn-fill-out btn-sm">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(Auth::user()->address_info()->count() > 0)
                                                @foreach(Auth::user()->address_info as $k=>$row)
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="card mb-3 mb-lg-0">
                                                            <div class="card-header">
                                                                <h6>Address #{{ ($k+1) }}</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <address>{{ $row->address }}</address>
                                                                <p>Postal Code: {{ ($row->postal_code)? $row->postal_code : '' }}</p>
                                                                @if($loop->index > 0)
                                                                <button class="btn btn-danger btn-sm" onclick="delete_address({{$row->id}})">Remove</button>
                                                                @endif
                                                                <form action="{{ route('user-address.destroy', $row->id) }}" id="delete-form-{{$row->id}}" method="post">@csrf @method('delete')</form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-lg-12">
                                                    <div class="card mb-3 mb-lg-0">
                                                        <div class="card-body">
                                                            <p><i class="fa fa-info-circle mr-1"></i> No Address Found!</p>
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
@push('script')
    <script>
        function delete_address(id){
            swal.fire({
                title: '<span class="text-uppercase">Delete Address?</span>',
                text: "Are you sure want to delete this address?",
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, Thanks!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
            });
        }
    </script>
@endpush
