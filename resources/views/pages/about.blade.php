@extends('layouts.front')
@section('page_title','About us')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('About us'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'About Us','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'About Us','route'=>''],
        ]])
    @push('css') <style> p{ color: black; } </style> @endpush
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- STAT SECTION ABOUT -->
        <div class="section small_pt">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="heading_s1">
                            <h4 class="text-uppercase">THE TALE OF SURYA SHRI</h4>
                        </div>
                        <div class="row mt-n3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="tab-style3">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Our Origin</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">OUR Aspirations</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content shop_info_tab">
                                        <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                           <div class="row">
                                               <div class="col-md-6 offset-3">
                                                   <p class="text-justify" style="text-align: justify-all !important;">
                                                       SURYA SHRI is a vision, of a young Ayurveda medical student which sprouted
                                                       <br/>its first buds in 2011, steadily actualizing with the determination
                                                       <br/>to one day bring the real fruits of Ayurveda to our global community.</p>
                                               </div>
                                           </div>
                                            <p>With her now being a qualified Ayurveda physician, enriched with the knowledge of
                                                modern cosmetology, she has succeeded in bringing the ancient goodness and treasures
                                                of Ayurveda to the comfort of your palms.</p>
                                            <p>Ayurveda itself is a universal philosophy that is time tested for millennia and proven
                                                time and again to enhance and uplift the quality of life through the pure immersion of
                                                nature and her skilled understanding of this ancient knowledge has brought the
                                                possibility to give you the opportunity to experience a truly authentic lifestyle of
                                                wellness.</p>
                                            <div class="row mb-6">
                                                <!--<div class="col-md-6 col-sm-12">-->
                                                <blockquote class="blockquote_style4">
                                                    <p>“As someone who evades the use of chemical infused goods in general, it
                                                        was extremely hard to come by personal care products that truly delivered
                                                        to my simple wellness standards: natural, sustainable, ethical, safe &
                                                        effective.<br/>
                                                        Which is what prompted me to study and explore the possibility of
                                                        infusing the universal knowledge of Ayurveda—which I already
                                                        understood the potency of—with modern cosmetology to develop
                                                        personal care products that agreed with my <em>‘Prakrti’</em> and <em>my standards</em>.<br/>
                                                        When I finally had my breakthrough, I fell in love with the goodness and
                                                        results our products yielded; and I thought “We <em>must</em> share this <em>amazing</em>
                                                        experience because <em>everyone</em> deserves the gift of wellness.” And <em>that</em>, is
                                                        why SURYA SHRI is here; to make lives better."</p>
                                                    <div class="align-content-center mt-2">
                                                        <div class="">
                                                            <div class="author_img">
                                                                <img src="{{ asset('assets/images/avatar.png') }}" class="rounded-circle" alt="Avatar" />
                                                            </div>
                                                            <div class="author_name mt-3">
                                                                <h6>Dr. Mahe<br/>(Dr. Maheshika Dasanayake)</h6>
                                                                <span class="d-block mt-n1"><small>Chief Medical Officer & Lead Research Officer</small>
                                                                        <small class="d-block mt-n2">SURYA SHRI</small>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </blockquote>
                                                <p>The necessity to introduce SURYA SHRI, a brand that genuinely represents Ayurveda, to
                                                    the community was born out of love and empathy: A love for Nature and an empathy
                                                    for humanity.</p>
                                                <p>Nature has an immeasurable volume of energy and potency which has been condensed
                                                    into the elixir of Ayurveda and we believe that each & every one of you deserves to
                                                    experience this divine goodness in person, which is why SURYA SHRI has spent years of
                                                    study, research and development before presenting these jewls to you.</p>

                                                <blockquote class="blockquote_style4">
                                                    <p style="font-size:36px"><b>“We don’t just love what we give; we <em>give</em> what we love”</b></p>
                                                </blockquote>
                                                <p>Each and every gift presented by SURYA SHRI is prepared with such zeal; undivided
                                                    attention goes to procuring ingredients of the best quality and maintaining a process
                                                    that creates superior, effective products that are not only pure from within but cool yet
                                                    sustainable in its packaging, which is why artificial colorants, fragrances, preservatives,
                                                    petro and other harmful chemicals will not be found in our creations.</p>

                                                <p>We are one who strongly believe in ecological, ethical and cruelty free practices and
                                                    incorporate the very same to every possible step of our journey. We believe <em>you and
                                                        Nature</em> deserve the best and we take great pride delivering it.</p>

                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <blockquote class="blockquote_style3">
                                                    <p><strong>OUR VISION</strong> – To offer authentic ancient Ayurvedic remedies to ensure health and
                                                        wellbeing of our local and global communities
                                                    </p>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <blockquote class="blockquote_style3">
                                                    <p><strong>OUR VISION</strong> – To offer authentic ancient Ayurvedic remedies to ensure health and
                                                        wellbeing of our local and global communities
                                                    </p>
                                                </blockquote>
                                            </div>
                                            <h5>AYURVEDA – A JOURNEY TO WELLNESS</h5>
                                            <p>“The Knowledge of Life”</p>
                                            <p class="mt-n3">Originated in South Asia more than 10,000 years ago, <em>Ayurveda</em>, is an ancient universal
                                                lifestyle which utilizes elements of Nature to obtain optimal health and wellness.
                                                ‘To preserve and to cure’ are Ayurveda’s two main objectives out of which the prior is
                                                considered <em>most important</em>, hence the efforts here at SURYA SHRI.</p>
                                            <p class="mt-n1">Ayurveda has stood the test of time and continued to spread its brilliance even today
                                                due to its practicality and fundamentals that agree with the holistic laws of the
                                                Universe. The puranic manuscripts of Ayurveda explain that, the very same energies
                                                that rule the universe, rules nature and therefore, rules a being.</p>
                                            <p>These energies are called <em>‘Pancha Bhuta’</em>: <em>‘PaTavi’</em> (earth), <em>‘Äp’ </em>(water), <em>‘Theja’</em> (fire),
                                                <em>‘Väyu’</em> (air) and <em>‘Äkäsha’</em> (ether). Combined in three unique proportions they create
                                                body humour called <em>‘Tri-dosha’</em> which are <em>‘Väta’, ’Pitta’</em> and <em>‘KaPa’</em> that yet again blend
                                                to form the entire body of any material in Nature.</p>
                                            <p>Every material, human or not, have a unique balance of these energies and humours
                                                and what Ayurveda does is balance certain deficits of these energies and matters of our
                                                being through Natures sources by utilizing its divine knowledge through its physicians.</p>

                                            <h5>SURYA SHRI – YOUR WELLNESS GURU</h5>
                                            <p>SURYA SHRI is founded upon the fundamental principles of Ayurveda and infuse these
                                                essences every time we craft our works of science which are with no doubt pieces of art,
                                                to produce the most balancing with superior efficacy.</p>
                                            <p>And what better way to seek wellness than with a professional Wellness Guru?</p>
                                            <p>At SURYA SHRI you are guaranteed professional authentic Ayurvedic products at our
                                                ‘boutique’ and services at our ‘clinique’ that will provide solutions to your concerns with
                                                exclusive preparations and treatment methods that are unique to your body and mind.</p>
                                            <p>With this timeless knowledge we have been fortunate to access the sacred secrets of
                                                Ayurveda to enhance your lifestyle to one that is self-loved.</p>
                                            <p><a href="{{ route('prakrti.products') }}">Check your <em>Tri-dosha</em> constitution here</a> to get the best out of SURYA SHRI’s amazing
                                                products and services.</p>
                                            <h6>WELLNESS – AT A WHOLE NEW LEVEL</h6>
                                            <p>Our wellness missions do not stop with you because to us, <em>wellness</em> is not just about
                                                physical and mental wellbeing or limiting it to an individual or our organization; it is
                                                about spreading wellness to the entire world starting from <em>our Sri Lanka</em>.</p>
                                            <p>Which is why we donate a share off of each and every product and service of ours
                                                towards worthy causes which will help improve wellness and uplift the overall quality of
                                                life of underprivileged communities.</p>
                                            <p>We also try to <em>locally</em> source ingredients for our products and services which are both
                                                high in quality and nutrient enriched by the lush soils of Lanka as it <em>tremendously</em> helps
                                                improve the efficacy of <em>our products</em> and most importantly empower the economy of
                                                <em>our people</em>.</p>
                                            <p>One untold reason behind Surya Shri’s genesis and one of our current missions is to
                                                create economic relief to our local community directly through creating new
                                                employment opportunities and indirectly by any means possible.</p>
                                            <h6>NATURE FRIENDLY – A BRAND TO BE WITH</h6>
                                            <p>From the air we breathe to the pillow we sleep on and everything in between comes to
                                                us from some form of Nature. It is our unwavering duty to protect this ultimate source
                                                and show our gratitude to her and to remember always that we are hers</p>
                                            <p>SURYA SHRI is a very <em>nature</em> concerned brand which is why our products are not only a
                                                100% natural but also come in nature-friendly sustainable yet attractive packaging; we
                                                believe it is our responsibility to promote the wellness of our planet, to leave it a little
                                                bit better than we found it.</p>
                                            <p>Be with us to join hands in future ventures towards conserving and improving the health
                                                of our home—Planet Earth—in the little ways we keeping in mind that drops of water
                                                come together to create an ocean.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION ABOUT -->
    {{--<!-- START SECTION TESTIMONIAL -->--}}
    {{--<div class="section small_pt mt-n5 large_pb mb-n5 pb_100">--}}
    {{--<div class="container">--}}
    {{--<div style="background: #f5f5f5;" class="p-5 radius_all_5">--}}
    {{--<div class="row justify-content-center">--}}
    {{--<div class="col-md-6">--}}
    {{--<div class="heading_s1 text-center">--}}
    {{--<h2>Client Appreciation</h2>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row justify-content-center">--}}
    {{--<div class="col-lg-9">--}}
    {{--<div class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2" data-nav="true" data-dots="false" data-center="true" data-loop="true" data-autoplay="true" data-items='1'>--}}
    {{--<div class="testimonial_box">--}}
    {{--<div class="testimonial_desc">--}}
    {{--<p>This is your Testimonial quote. It’s a great place to share reviews about you, your personal qualities and your services. Add client details for extra credibility and get your future clients excited from day one!</p>--}}
    {{--</div>--}}
    {{--<div class="author_wrap">--}}
    {{--<div class="author_img">--}}
    {{--<img src="{{ asset('assets/images/avatar.png') }}" class="rounded-circle" alt="Avatar" />--}}
    {{--</div>--}}
    {{--<div class="author_name">--}}
    {{--<h6>Avery Smith</h6>--}}
    {{--<span class="d-block mt-n1"><small>Customer</small></span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- END SECTION TESTIMONIAL -->
        <!-- START SECTION SHOP INFO -->
    {{--<div class="section pb_70">--}}
    {{--<div class="container">--}}
    {{--<div class="row no-gutters">--}}
    {{--<div class="col-lg-4">--}}
    {{--<div class="icon_box icon_box_style1">--}}
    {{--<div class="icon">--}}
    {{--<i class="flaticon-shipped"></i>--}}
    {{--</div>--}}
    {{--<div class="icon_box_content">--}}
    {{--<h5>Fast Delivery</h5>--}}
    {{--<p>We delivery fast and safe in colombo and selected suburbs.</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-4">--}}
    {{--<div class="icon_box icon_box_style1">--}}
    {{--<div class="icon">--}}
    {{--<i class="flaticon-money-back"></i>--}}
    {{--</div>--}}
    {{--<div class="icon_box_content">--}}
    {{--<h5>30 Day Return</h5>--}}
    {{--<p>If you are going to return a product, you need to be sure there anything</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-4">--}}
    {{--<div class="icon_box icon_box_style1">--}}
    {{--<div class="icon">--}}
    {{--<i class="ti-credit-card"></i>--}}
    {{--</div>--}}
    {{--<div class="icon_box_content">--}}
    {{--<h5>Secure Payments</h5>--}}
    {{--<p>We are dealing online secure payment mode on delivery online.</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- END SECTION SHOP INFO -->
    </div>
@endsection
