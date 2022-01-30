@extends('layouts.front')
@section('page_title','Contact us')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Contact us'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.alert')
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Contact us','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Contact Us','route'=>''],
        ]])
    @push('css') <style> p{ color: black; } </style> @endpush
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <div class="section small_pt pb_70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 align-content-center">
                        <div class="heading_s1 text-center">
                            <h2>Your Health Starts Here</h2>
                        </div>
                        <p class="leads text-center mt-n2">Send in your thoughts so we can help guide you on a mesmerizing journey through wellness, or maybe you can guide us to be better....</p>
                        @include('components.messages')
                        <div class="field_form">
                            <form method="POST" action="{{ route('send.contact.msg') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Name*</label>
                                        <input required placeholder="Name"  id="first-name" class="form-control" name="name" type="text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email*</label>
                                        <input required placeholder="Email" id="email" class="form-control" name="email" type="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Contact Number*</label>
                                        <input required placeholder="Contact Number" id="phone_number" class="form-control" name="contact">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Subject*</label>
                                        <input placeholder="Subject" id="subject" class="form-control" required name="subject">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Your message*</label>
                                        <textarea required placeholder="Place your inquiries, requests, suggestions and comments here ..." id="description" class="form-control" name="message" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <button type="submit" title="Submit Your Message!" class="btn btn-line-fill btn-md pl-5 pr-5 pt-md-2 pb-md-2 pt-sm-1 pb-sm-1" id="submitButton" name="submit" value="Submit">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{--<div class="col-lg-6 pt-2 pt-lg-0 mt-4 mt-lg-0">--}}
                    {{--<iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d126762.1799238329!2d79.87136800636914!3d6.8524183287001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3ae251c27bdd44ab%3A0x5442158000ca1aea!2sSurya%20Shri%20Ayurveda%20Clinic%2C%20No.%20112%2C%205th%20Lane%2C%20Kendahenawatta%20Road%2C%20Pannipitiya%2010230!3m2!1d6.852423399999999!2d79.9414086!5e0!3m2!1sen!2slk!4v1627301616178!5m2!1sen!2slk" width="100%" height="450" style="" id="google_map" allowfullscreen="" loading="lazy"></iframe>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>

        <!-- START SECTION CONTACT -->
        <div class="section small_pt pb_20">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="contact_wrap contact_style3 icon_box_style_contact">
                            <div class="contact_icon">
                                <i class="linearicons-envelope-open"></i>
                            </div>
                            <div class="contact_text">
                                <span>Email Address</span>
                                <a href="mailto:suryashri.ayurveda@gmail.com">suryashri.ayurveda@gmail.com</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 show-map">
                        <div class="contact_wrap contact_style3 icon_box_style_contact">
                            <div class="contact_icon">
                                <i class="linearicons-map2"></i>
                            </div>
                            <div class="contact_text">
                                <span>Location</span>
                                <p>112, 5th lane, Kendahenawatta road, Depanama, Sri Lanka</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="contact_wrap contact_style3 icon_box_style_contact">
                            <div class="contact_icon">
                                <i class="linearicons-tablet2"></i>
                            </div>
                            <div class="contact_text">
                                <span>Phone</span>
                                <p>+94769244427</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION CONTACT -->
        <div class="section pb-0 small_pt" id="google-map" style="display: none;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d126762.1799238329!2d79.87136800636914!3d6.8524183287001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3ae251c27bdd44ab%3A0x5442158000ca1aea!2sSurya%20Shri%20Ayurveda%20Clinic%2C%20No.%20112%2C%205th%20Lane%2C%20Kendahenawatta%20Road%2C%20Pannipitiya%2010230!3m2!1d6.852423399999999!2d79.9414086!5e0!3m2!1sen!2slk!4v1627301616178!5m2!1sen!2slk" width="100%" height="450" style="" id="" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <!-- END SECTION SINGLE BANNER -->
    </div>
@endsection
@push('script')
    <script>
        $(".show-map").click(function(){
            $("#google-map").slideDown();
        });

        $('#first-name').on('keypress', function (event) {
            var regex = new RegExp("^[A-Z-a-z]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('#phone_number').on('keypress', function (event) {
            var regex = new RegExp("^[0-9+]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
    </script>
@endpush
