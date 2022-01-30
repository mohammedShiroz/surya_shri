<!-- Home Popup Section -->
@push('css')
    <style>
        .select2-container .select2-selection--single { height: 50px; }
        .select2-container--default .select2-selection--single { padding-top: 10px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow { top: 13px;}
        .select2-dropdown { z-index: 100000; }
    </style>
@endpush
<div class="modal fade" id="employee-Request-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row no-gutters">
                    <div class="col-sm-5">
                        <div class="background_bg h-50" style="margin-top: 25%" data-img-src="{{ asset('assets/images/become_employee.jpg') }}"></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s1">
                                    <h4 class="text-uppercase mt-3">Become a Partner</h4>
                                </div>
                                <p class="mt-1" style="margin-top: -20px;">Thank you for your interest to join with us. Please before send request, Choose your wishes referral person below.</p>
                            </div>
                            <div class="text-left">
                                <form action="{{ route('send.partner.request') }}" method="POST">
                                    @csrf
                                    <div class="form-group mt-4" id="agent_ref_field">
                                        <label>Partner Email / Code<span class="text-danger">*</span></label>
                                        <input id="referral" type="hidden" name="referral" value="{{ old('referral') }}">
                                        <div class="input-group mb-3">
                                            <input type="text" id="partner_name" class="form-control" name="partner_name" value="{{ old('partner_name') }}" placeholder="Partner Code">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-fill-out btn-block check-partner-code">Check now</button>
                                            </div>
                                            <small id="ref-error" class="w-100" role="alert" ></small>
                                        </div>
                                        @if ($errors->has('partner_name'))
                                            <span class="invalid-feedback" id="ref-error" role="alert">
                                                    <strong>{{ $errors->first('partner_name') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Send Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Screen Load Popup Section -->
@push('script')
    <script>
        $('.check-partner-code').on('click', function () {
            valid_partner_code($("#partner_name").val());
        });
        function valid_partner_code(code) {
            $("#ref-error").html('');
            if ($("#partner_name").val()) {
                $.ajax({
                    url: "{{ route('partner.valid.check') }}",
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {code: code},
                    success: function (data) {
                        if (data.status == "valid") {
                            $("#referral").val(data['partner_id']);
                            $("#ref-error").fadeIn();
                            $("#ref-error").html('The email/code you entered match. Your referral partner is ' + data.partner_name);
                            $("#ref-error").removeClass('text-danger');
                            $("#ref-error").addClass('text-success');
                            $("#partner_name").removeClass('is-invalid');
                            $("#partner_name").addClass('is-valid');
                        } else {
                            $("#ref-error").fadeIn();
                            $("#ref-error").html('The email/code you entered does not match.');
                            $("#ref-error").removeClass('text-success');
                            $("#ref-error").addClass('text-danger');
                            $("#partner_name").removeClass('is-valid');
                            $("#partner_name").removeClass('is-invalid');
                            $("#partner_name").addClass('is-invalid');
                            $("#referral").val(null);
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
    </script>
@endpush
