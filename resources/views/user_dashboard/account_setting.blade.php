@extends('layouts.front')
@section('page_title','Account Settings')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Account settings'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')
@push('css')
    <style>
        .select2-container .select2-selection--single { height: 50px} .select2-container--default .select2-selection--single { padding-top: 10px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow { top: 13px;} .user_photo {
                                                                                                           display: block;
                                                                                                           width: 140px;
                                                                                                           height: 140px;
                                                                                                           border-radius: 100%;
                                                                                                           border:2px solid #FFFFFF;
                                                                                                           box-shadow: 0 0 8px 3px #B8B8B8;
                                                                                                           position:relative;
                                                                                                       }
        .user_photo img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
        }
        .user_photo span.icon {
            position: absolute;
            top: 10px;
            right: 0;
            background:#e2e2e2;
            border-radius:100%;
            width:30px;
            height:30px;
            line-height:25px;
            vertical-align:middle;
            text-align:center;
            color: #99731f;
            font-size:20px;
            cursor:pointer;
        }
        .user_photo span.icon:hover {
            background: #cecece;
            color: #dba32b;
        }
        .user_info{
            position: absolute;
            top: 35px;
            left: 180px;
        }
        .user_photo span.icon input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            filter: alpha(opacity=0);
            opacity: 0;
            cursor: inherit;
            display: block;
        }
    </style>
@endpush
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Account Settings','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Account Settings','route'=>''],
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
                        @include('components.messages')
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show" role="tabpanel"
                                 aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>ACCOUNT SETTING</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('dashboard.account.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-3 col-sm-12">
                                                    <div class="mt-3">
                                                        <div class="user_photo">
                                                            <img id="preview" src="{{ (!empty(\Auth::user()->profile_image))? asset(\Auth::user()->profile_image) : asset('assets/images/avatar.png') }}" class="main-profile-img" />
                                                            {{--<span class="icon"><i class="fa fa-pencil-alt fa-sm"></i><input type="file" class="hidden-input" onchange="loadFile(event)" name="profile_image"/></span>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @push('script')
                                                    <script>
                                                        var loadFile = function(event) {
                                                            var output = document.getElementById('preview');
                                                            output.src = URL.createObjectURL(event.target.files[0]);
                                                            output.onload = function() {
                                                                URL.revokeObjectURL(output.src)
                                                            }
                                                        };
                                                    </script>
                                                @endpush
                                                <div class="form-group col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <label>First Name <span class="required">*</span></label>
                                                            <input required="" class="form-control @error('name') is-invalid @enderror" name="name" type="text"
                                                                   value="{{ \Auth::user()->name }}">
                                                            @error('name')
                                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <label>Last Name <span class="required">*</span></label>
                                                            <input required="" class="form-control @error('last_name') is-invalid @enderror" name="last_name" type="text"
                                                                   value="{{ \Auth::user()->last_name }}">
                                                            @error('last_name')
                                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <label class="mt-3">Email<span class="required">*</span></label>
                                                    <input disabled class="form-control @error('email') is-invalid @enderror" name="email" type="email"
                                                           value="{{ \Auth::user()->email }}">
                                                    @error('email')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Phone <span class="required">*</span></label>
                                                    <input required="" class="form-control @error('contact') is-invalid @enderror" name="contact"
                                                           value="{{ \Auth::user()->contact }}">
                                                    @error('contact')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Gender <span class="required">*</span></label>
                                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                                        <option selected value="" disabled>Choose the gender</option>
                                                        <option {{ (\Auth::user()->gender == "Male")? 'selected': '' }} value="Male">Male</option>
                                                        <option {{ (\Auth::user()->gender == "Female")? 'selected': '' }} value="Female">Female</option>
                                                        <option {{ (\Auth::user()->gender == "Other")? 'selected': '' }} value="Other">Other</option>
                                                    </select>
                                                    @error('gender')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Location<span class="required">*</span></label>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <select class="form-control select2 @error('country') is-invalid @enderror" name="country" id="user_country">
                                                                <option selected="selected" disabled value="">Choose the Country</option>
                                                                @if(\App\Location::where('parent_id',0)->get()->count() > 0)
                                                                    @foreach(\App\Location::where('parent_id',0)->get() as $row)
                                                                        <option value="{{ $row->name }}" {{ (\Auth::user()->country == $row->name)? 'selected' : '' }} data-id="{{ $row->id }}">{{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error('country')
                                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6" id="p_price">
                                                            <select class="form-control select2 @error('city') is-invalid @enderror" name="city" id="user_city">
                                                                <option selected="selected" disabled value="">Choose the city</option>
                                                                @if (!empty(\Auth::user()->city))
                                                                    @foreach(\App\Location::where('parent_id', \App\Location::where('name' , \Auth::user()->country)->firstOrFail()->id)->get() as $row)
                                                                        <option value="{{ $row->name }}" {{ (\Auth::user()->city == $row->name)? 'selected' : '' }}>{{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error('city')
                                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-12 col-sm-12 mt-n3">
                                                            <label></label>
                                                            <div class="custome-checkbox border p-3 radius_all_5">
                                                                <input class="form-check-input" type="checkbox" name="e_subscribe" id="news_chk" {{ (\Auth::user()->e_subscribe == 1)? 'checked': '' }} value="1">
                                                                <label class="form-check-label" for="news_chk"><span></span></label>
                                                                <span>Subscribe to the SURYA SHRI Newsletter?</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-fill-out btn-sm" name="submit"
                                                            value="Submit">Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5>CHANGE PASSWORD</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('dashboard.account.update.pwd') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label>Old Password <span class="required">*</span></label>
                                                    <input type="password" class="form-control {{ Session::has('old_password_error') ? ' is-invalid' : '' }}" name="old_password" placeholder="Old Password" required>
                                                    @if(Session::has('old_password_error'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{Session::get('old_password_error')}}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label>New password <span class="required">*</span></label>
                                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Your new password" required>
                                                    @if ($errors->has('new_password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('new_password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label>Confirm Password <span class="required">*</span></label>
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"required>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-fill-out btn-sm" name="submit"
                                                            value="Submit">Change Password
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5>MY ADDRESS</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
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
        $('#user_country').on('change', function () {
            Get_city_name($(this).find(':selected').attr('data-id'), '{{route('user.fetch.city')}}', '#user_city');
        });
        function Get_city_name(selected_value, url, data_fetch_id) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: selected_value,
                    _token: '{{ csrf_token()}}',
                },
                cache: true,
                success: function (data) {
                    $(data_fetch_id).html('');
                    $(data_fetch_id).append(data);
                }
            });
        }
    </script>
@endpush
@push('script')
    <script>
        $('.select_product_country').on('change', function () {
            var country_id =$('select.select_product_country').find(':selected').data('id');
            $.ajax({
                url: "/fetch-city",
                type: "GET",
                data: {
                    country_id: country_id
                },
                cache: false,
                success: function (result) {
                    $(".select_product_city").html(result);
                }
            });
        });
    </script>
@endpush
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

