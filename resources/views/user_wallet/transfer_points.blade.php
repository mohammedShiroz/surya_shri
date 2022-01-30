@extends('layouts.front')
@section('page_title','Transfer Points')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Transfer Points'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.select2')
@include('backend.components.plugins.alert')
@include('backend.components.plugins.data_table_front')
@push('css')
    <style>
        .select2-container .select2-selection--single { height: 50px} .select2-container--default .select2-selection--single { padding-top: 10px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow { top: 13px;}
    </style>
@endpush
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'Transfer Points','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'My Wallet','route'=>route('wallet')],
        3=>['name'=>'Transfer Points','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('user_wallet.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="text-uppercase">Transfer Points</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        @include('components.messages')
                                    </div>
                                    <div class="col-md-7 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" id="available_points" value="{{ getFinalPoints()["available_points"] }}" />
                                                        <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                        <p>Available Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" id="transferable_points" value="{{ getTransferablePoints(\auth::user()->id) }}" />
                                                        <h5>{{ getPointsFormat(getTransferablePoints(\auth::user()->id)) }}</h5>
                                                        <p>Transferable Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getCalPoints()["total_transferred_points"]) }}</h5>
                                                        <p>Total Transferred Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <form action="{{ route('wallet.points.transfer') }}" method="POST" id="transferForm">
                                            <input type="hidden" name="transfer_type" value="users">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-12" id="agent_ref_field">
                                                    <label>Partner Email / Code<span class="text-danger">*</span></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" id="partner_name" name="partner_name" class="form-control"  value="{{ old('partner_name') }}" placeholder="User Code">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-fill-out btn-block check-partner-code">Check now</button>
                                                        </div>
                                                        <small id="ref-error" class="w-100" role="alert" ></small>
                                                    </div>
                                                    @if ($errors->has('receiver_name'))
                                                        <span class="invalid-feedback" id="ref-error" role="alert">
                                                            <strong>{{ $errors->first('receiver_name') }}</strong>
                                                        </span>
                                                    @endif
                                                    <input type="hidden" value="{{ old('receiver_name') }}" name="receiver_name" id="receiver_id" />
                                                    <label>Partner Name<span class="text-danger">*</span></label>
                                                    <input id="referral_name" type="text" readonly class="form-control" value="{{ old('receiver_name') }}">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Points<span class="required">*</span></label>
                                                    <input type="text" name="points" id="transfer_points" value="{{ old('points')? old('points') : '0'  }}" class="form-control" />
                                                    @error('points')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" id="submit_btn" class="btn btn-fill-out btn-sm">Transfer Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="text-uppercase">Donate Points</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p>Be a part of life changing worthy causes and meritorious deeds
                                            that make the society we live in a little better by supporting to SURYA SHRI’s
                                            charity operations.</p>
                                    </div>
                                    <div class="col-md-7 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" value="{{ getFinalPoints()["available_points"] }}" />
                                                        <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                        <p>Available Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <input type="hidden" id="available_donation_transfer_points" value="{{ getFinalPoints()["available_points"] }}" />
                                                        <h5>{{ getPointsFormat(getFinalPoints()["available_points"]) }}</h5>
                                                        <p>Transferable Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="icon_box icon_box_style4">
                                                    <div class="icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="icon_box_content">
                                                        <h5>{{ getPointsFormat(getCalPoints()["total_transferred_points"]) }}</h5>
                                                        <p>Total Transferred Points</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <form action="{{ route('wallet.points.transfer') }}" method="POST" id="transferFormCompany">
                                            <input type="hidden" name="transfer_type" value="donation">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-12" id="agent_ref_field">
                                                    <input type="hidden" value="{{ \App\User::Where('prefix','Donations')->first()->id }}" name="receiver_name" />
                                                    <label>Receiver Name<span class="text-danger">*</span></label>
                                                    <input id="referral_name_company" type="text" readonly class="form-control" value="SURYA SHRI Donation Wallet">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Points<span class="required">*</span></label>
                                                    <input type="text" name="donation_points" id="transfer_points_company" value="{{ old('donation_points')? old('donation_points') : '0'  }}" class="form-control" />
                                                    @error('points')
                                                    <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" id="company_submit_btn" class="btn btn-fill-out btn-sm">Donate Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $transfer_points_ids = \App\Points::where('user_id', \Auth::user()->id)->WhereNotNull('forward_points')->pluck('id')->toArray();
                            $credited_points_ids = \App\Points::where('forward_user_id',\auth::user()->id)->pluck('id')->toArray();
                            $points_ids = array_merge($transfer_points_ids,$credited_points_ids);
                        ?>
                        @if(count($points_ids) > 0)
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="data_table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Partner Name</th>
                                            <th>Transferred Points</th>
                                            <th>Transfer Type</th>
                                            <th>Transferred Date & Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Points::whereIn('id',$points_ids)->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>
                                                    @if($row->forward_user_info->id == \auth::user()->id)
                                                        {{ $row->user_info->name." ".$row->user_info->last_name }}
                                                    @elseif($row->user_info)
                                                        {{ $row->forward_user_info->name." ".$row->forward_user_info->last_name }}
                                                    @endif
                                                </td>
                                                <td>{{ getPointsFormat($row->forward_points) }}</td>
                                                <td>
                                                    @if($row->forward_user_info->id == \auth::user()->id)
                                                        Received
                                                    @elseif($row->user_info)
                                                        Send
                                                    @endif
                                                </td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @else
                            <p class="border p-3"><i class="fa fa-info-circle"></i> No Transfer Point Yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
@push('script')
    <script>
        $('#transfer_points').on('keypress', function (event) {
            var regex = new RegExp("^[0-9\.]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });

        $('.check-partner-code').on('click', function () {
            valid_partner_code($("#partner_name").val());
        });
        function valid_partner_code(code) {
            $("#ref-error").html('');
            if ($("#partner_name").val()) {
                $.ajax({
                    url: "{{ route('transfer-users.valid.check') }}",
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {code: code},
                    success: function (data) {
                        console.log(data);
                        if (data.status == "valid") {
                            $("#receiver_id").val(data['user_id']);
                            $("#ref-error").fadeIn();
                            $("#ref-error").html('The email/code you entered match.');
                            $("#ref-error").removeClass('text-danger');
                            $("#ref-error").addClass('text-success');
                            $("#partner_name").removeClass('is-invalid');
                            $("#partner_name").addClass('is-valid');
                            $("#referral_name").val(data.partner_name);
                        } else {
                            $("#ref-error").fadeIn();
                            $("#ref-error").html('The email/code you entered does not match.');
                            $("#ref-error").removeClass('text-success');
                            $("#ref-error").addClass('text-danger');
                            $("#partner_name").removeClass('is-valid');
                            $("#partner_name").removeClass('is-invalid');
                            $("#partner_name").addClass('is-invalid');
                            $("#referral_name").val(null);
                            $("#receiver_id").val(null);
                        }
                    }
                });
            } else {
                $("#referral").val(null);
                $("#ref-error").html('Please enter valid user code or email.');
                $("#ref-error").removeClass('text-success');
                $("#ref-error").addClass('text-danger');
                $("#partner_name").removeClass('is-valid');
                $("#partner_name").removeClass('is-invalid');
                $("#partner_name").addClass('is-invalid');
                $("#ref-error").fadeIn();
            }
        }

        $("#submit_btn").click(function(){
           if(parseFloat($("#transferable_points").val()) < parseFloat($("#transfer_points").val())){
               swal.fire({
                   title: 'Notice!',
                   text:'You do not have sufficient points for this transfer.',
                   icon: "info",
               });
           }else{
               swal.fire({
                   title: '<span class="text-uppercase">CONFIRMATION REQUIRED!</span>',
                   text: "You are requesting to transfer "+$("#transfer_points").val() +" points to "+$("#referral_name").val()+". Are you sure you want to proceed with this transfer?”",
                   type: 'warning',
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonText: 'Confirm',
                   cancelButtonText: 'Cancel',
                   reverseButtons: true
               }).then((result) => {
                   if (result.value) {
                       $("#transferForm").submit();
                   } else if (
                       // Read more about handling dismissals
                       result.dismiss === Swal.DismissReason.cancel
                   ) {
                   }
               });

           }

        });

        $("#company_submit_btn").click(function(){
            if(parseFloat($("#available_donation_transfer_points").val()) < parseFloat($("#transfer_points_company").val())){
                swal.fire({
                    title: 'Notice!',
                    text:'You do not have sufficient points for this transfer.',
                    icon: "info",
                });
            }else{
                swal.fire({
                    title: '<span class="text-uppercase">CONFIRMATION REQUIRED!</span>',
                    text: "You are requesting to transfer, "+$("#transfer_points_company").val() +" points to "+$("#referral_name_company").val()+". Are you sure you want to proceed with this transfer?”",
                    type: 'warning',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $("#transferFormCompany").submit();
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });

            }

        });
    </script>
@endpush
