@extends('frontend.layouts.home_app')
@php 
    use Illuminate\Support\Arr;

        
@endphp
@section('link_url','')
@section('content')
    <div class="row">

        <!-- ########################### SECTION START ########################### -->
        <div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#inSlider" data-slide-to="0" class="active"></li>
                <li data-target="#inSlider" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>{!! __('frontend.index.in_slider.start_1') !!}</h1>
                            <p>{{__('frontend.index.in_slider.start_now')}}</p>
                            <p>
                                <a class="btn btn-lg btn-primary" href="{{route('frontend.auth.register')}}" role="button">{{__('frontend.index.in_slider.button_join_now')}}</a>
                                {{--<a class="caption-link" href="#" role="button">{{__('frontend.index.in_slider.button_read_more')}}</a>--}}
                            </p>
                        </div>
                        <div class="carousel-image wow zoomIn">
                            <img src="{{asset('vendor/img/landing/laptop1.png')}}" alt="laptop"/>
                        </div>
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back one"></div>

                </div>
                <div class="item">
                    <div class="container">
                        <div class="carousel-caption blank">
		<h2 class="style_head2">{!! __('frontend.index.in_slider.start_2') !!}</h2>			    
		<p>{{__('frontend.index.in_slider.start_2_1')}}</p>
                            <p><a class="btn btn-lg btn-primary" href="{{route('frontend.auth.register')}}" role="button">{{__('frontend.register.join_now')}}</a></p>
                        </div>
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back two"></div>
                </div>
            </div>
            <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!-- ########################### SECTION END ########################### -->
 <!-- ########################### SECTION START ########################### -->
        <section  class="features" id="features">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h2 class="style_Head2">{!! __('frontend.index.how_it_works.title_1') !!} </h2>
                        <p>{!! __('frontend.index.how_it_works.title_2') !!}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12 text-center wow fadeInLeft">
                        <div>
                            <i class="fa fa-mobile features-icon"></i>
                            <h3>{{__('frontend.index.how_it_works.title_action')}}</h3>
                            <p>{{__('frontend.index.how_it_works.title_subhead')}}</p>
                        </div>
                        <div class="m-t-lg">
                            <i class="fas fa-money-bill-alt features-icon"></i>
                            <h3>{{__('frontend.index.how_it_works.title_subhead_2')}}</h3>
                            <p>{{__('frontend.index.how_it_works.title_subhead_3')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 text-center  wow zoomIn">
                        <img src="{{asset('vendor/img/landing/4steps.png')}}" alt="dashboard" class="img-responsive" style="margin-left: 10%;">
                    </div>
                    <div class="col-md-4 text-center wow fadeInRight">
                        <div class="m-t-lg">
                            <i class="fa fa-tasks features-icon"></i>
                            <h3>{{__('frontend.index.how_it_works.title_subhead_4')}}</h3>
                            <p>{{__('frontend.index.how_it_works.title_subhead_5')}}</p>
                        </div>
                        <div>
                            <i class="fa fa-envelope features-icon"></i>
                            <h3>{{__('frontend.index.how_it_works.title_subhead_6')}}</h3>
                            <p>{{__('frontend.index.how_it_works.title_subhead_7')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ########################### SECTION END ########################### -->


        {{--***************************SECTION START*****************************--}}

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h2 class="great_reward_head2">{{__('frontend.index.get_great_rewards.title_1')}}</h2>
                        <p>{{__('frontend.index.get_great_rewards.subtitle_1')}} </p>
                    </div>
                </div>
                <div class="row features-block">
                    <div class="col-lg-6 features-text wow fadeInLeft">
                        <small>{{__('frontend.index.get_great_rewards.under.title_1')}}</small>
                        <h2>{{__('frontend.index.get_great_rewards.under.title_2')}} </h2>
                        <p>{{__('frontend.index.get_great_rewards.under.title_2_details')}}</p>
                        <a href="{{route('frontend.cms.rewards')}}" class="btn btn-primary">{{__('frontend.index.get_great_rewards.under.button_learn_more')}}</a>
                    </div>
                    <div class="col-lg-6 text-right wow fadeInRight">
                        <img src="{{asset('vendor/img/rewards/rewards.png')}}" alt="dashboard" class="img-responsive pull-right">
                    </div>
                </div>
            </div>
        </section>
        {{--***************************SECTION END*******************************************--}}

        <!-- ########################### SECTION START ########################### -->
        <section class="features landing_grey_background">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h2 class="style_Head_2">{{__('frontend.index.why_you_earn.title_1')}}</h2>
                        <p>{{__('frontend.index.why_you_earn.title_2')}} </p>
                    </div>
                </div>
                <div class="row features-block">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 features-text wow fadeInLeft">
                        <h2>{{__('frontend.index.why_you_earn.under.subtitle_1')}}</h2>
                        <p>{{__('frontend.index.why_you_earn.under.subtitle_1_details')}}</p>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-xs-12 text-right m-t-n-lg wow zoomIn">
                        <img src="{{asset('vendor/img/rewards/happy.jpg')}}" class="img-responsive" alt="dashboard">
                    </div>
                    <div class="col-lg-3 col-sm-12 col-xs-12 features-text text-right wow fadeInRight">
                        <h2>{{__('frontend.index.why_you_earn.under.subtitle_2')}}</h2>
                        <p>{{__('frontend.index.why_you_earn.under.subtitle_2_details')}}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- ########################### SECTION END ########################### -->
        <!-- ########################### TESTIMONIAL SECTION ##################### -->
        <section id="testimonials" class="navy-section testimonials" style="margin-top: 0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center wow zoomIn">
                        <i class="fa fa-comment big-icon"></i>
                        <h2 class="what_users_head">
                            {{__('frontend.index.what_our_users_say.title_1')}}
                        </h2>
                        <div class="testimonials-text">
                            <i>{!! __('frontend.index.what_our_users_say.details') !!}</i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ########################### TESTIMONIAL SECTION END ##################### -->

        <!-- ########################### FOOTER SECTION ##################### -->
        <section id="contact" class="grey-contact-section contact_section">
            <div class="container">
                <div class="row m-b-lg">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h2 style="font-size:30px">{{__('frontend.index.contact_us.title_1')}}</h2>
                        <p>{{__('frontend.index.contact_us.title_2')}}</p>
                    </div>
                </div>
                <div class="row m-b-lg">
                    <div class="col-lg-3 col-lg-offset-3">
                        <address>
                            <strong>
                            <span class="navy">
                                {!! __('frontend.index.contact_us.subtitle') !!}
                            </span>
                                <br/>
                                {{--<span class="navy">
                                    {!! __('frontend.index.contact_us.subtitle2') !!}.
                                </span>--}}
                            </strong><br/>
                            {!! __('frontend.index.contact_us.details_1') !!}
                            {!! __('frontend.index.contact_us.details_2') !!}
                        </address>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-color">
                            {!! __('frontend.index.contact_us.details_3') !!}
                        </p>
                    </div>
                </div>
                @include('frontend.includes.contact_us')
            </div>
        </section>
        <section id="footer">
            <div class="container">
                <div class="row text-center text-xs-center text-sm-left text-md-left">
                    <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-sm">
                        <p style="color: white">
                            <strong>{{__('frontend.register.static.footer_title_3')}} &reg; 2015-{{ date('Y') }}</strong>
                            <br/>
                              <a href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                            | <a href="{{route('frontend.cms.cookie')}}">{{__('frontend.index.footer.links.cookie_policy')}}</a>
                            | <a href="{{route('frontend.cms.rewards_policy')}}">{{__('frontend.index.footer.links.reward_policy')}}</a>
                            | <a href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                            | <a href="{{route('frontend.cms.safeguard')}}">{{__('frontend.index.footer.links.Safeguards')}}</a>
                            | <a href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>
			    | <a href="{{route('frontend.cms.faq')}}">{{__('frontend.index.footer.links.FAQ')}}</a>
			    | <a href="{{route('frontend.blog')}}" >{{__('frontend.nav.static.heading_6')}}</a> 
			    | <a href="{{route('frontend.cms.help_support')}}" target="_blank">{{__('frontend.nav.static.heading_4')}}</a>

                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{--<a href="mailto:contact@sjpanel.com" class="btn btn-primary">{!! __('frontend.index.contact_us.send_email_button') !!}</a>--}}
			<p id="footer_contact_detail">{!! __('frontend.index.contact_us.details_7') !!}</p>
			<a>{!! __('frontend.index.contact_us.details_8') !!}</a>
                            <p class="" style="color: white">
			<strong>{!! __('frontend.index.contact_us.mailing_social_connection') !!}</strong>
			</p>
                        
                        <ul class="list-inline social-icon">
                            <li><a href="//twitter.com/samplejunction"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li><a href="//facebook.com/samplejunction"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li><a href="//www.linkedin.com/company/sample-junction"><i class="fab fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                    </hr>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('img/frontend/gdpr_small.png')}}" class="img" id="gdpr" alt="Example of alt text" title="GDPR Compliant"  width="80" height="80">
                        <img src="{{asset('img/frontend/SSL.png')}}" class="img" id="ssl" width="80" height="80" title="SSL Secure" alt="ssl">
                        <img src="{{asset('img/frontend/iso-9001.png')}}" class="img" id="iso_9001" width="80" height="80" title="ISO 9001:2015 Certified" alt="ISO9001"> 
                        <img src="{{asset('img/frontend/iso-27001.png')}}" class="img" id="iso_27001" width="80" height="80" title="ISO 27001-2013 Certified" alt="ISO27001">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                        <p style="color: white">
                            <strong>{{__('frontend.index.footer.bottom_tex')}}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ########################### REDEMPTION HISTORY SECTION ##################### -->
     @php 
    $file_path = storage_path('records_date.json');
    $data = json_decode(file_get_contents($file_path), true);
    $rec_id = $data['rec_id'];
    $rec_date = \Carbon\Carbon::parse($data['rec_date']);
    $today = \Carbon\Carbon::now();
    $date15DaysAhead = $rec_date->copy()->addDays(15);
    if($today->greaterThanOrEqualTo($date15DaysAhead)){
        $data['rec_date'] = $today->toDateString();
        if($rec_id != '3'){
            $data['rec_id'] = $rec_id + 1;
        }else{
            $data['rec_id'] = 1;
        }
        $rec_id = $data['rec_id'];
        file_put_contents($file_path, json_encode($data));
    }
    $names = config('settings.dummyNames_'.$rec_id);
    $panelistIds = config('settings.dummyID_'.$rec_id);
    $amounts = config('settings.dummyAmount_'.$rec_id);
    @endphp

        <div class="row" id="redemptionTable">

            <div class="col-12 text-center p-0">

                <p class="fw-bold text-light pt-3 pb-3" id="checktext" style="margin:0; background: #0082F0; border-radius: 15px; padding-top:8px; padding-bottom:8px; font-weight:bold;">{!! __('frontend.register.redemption_seo') !!}</p>

            </div>

            <div class="col-12" style="border: 2px solid #0082F0; border-radius: 15px; padding:10px; background:white;">


                <div class="row-1" style="background: #eaf2fb; border-radius: 15px; padding-top:10px;">

                    <div class="col text-center">

                        <p class="fw-bold m-0" style="color: #004AAD;">{!! __('frontend.register.panelist_name_seo') !!}</p>

                    </div>

                    <div class="col text-center">

                        <p class="fw-bold m-0" style="color: #004AAD">{!! __('frontend.register.panelist_id_seo') !!}</p>

                    </div>

                    <div class="col text-center">

                        <p class="fw-bold m-0" style="color:#004AAD;">{!! __('frontend.register.redeemed_amt_seo') !!}</p>

                    </div>

                </div>


                <div class="row-2" style="background: #eaf2fb; border-radius: 10px; overflow:hidden; padding:10px; margin-top:8px;">

                    <div class="col mt-2 mb-2">

                        <ul class="pt-2 pb-2 rounded m-0 ul-ele column" style="background: #BCDCF9; list-style-type: none;">

                            <div class="list-move">
                                @foreach($names as $name)
                                <li class="">{{$name}}</li>
                                @endforeach
                            </div>

                        </ul>

                    </div>

                    <div class="col mt-2 mb-2">

                        <ul class="pt-2 pb-2 rounded m-0 ul-ele column" style="background: #BCDCF9; list-style-type: none;">

                            <div class="list-move">
                                @foreach($panelistIds as $panelist)
                                <li class="">{{$panelist}}</li>
                                @endforeach
                            </div>

                        </ul>

                    </div>

                    <div class="col mt-2 mb-2">

                        <ul class="pt-2 pb-2 rounded m-0 ul-ele column" style="background: #BCDCF9; list-style-type: none;">

                            <div class="list-move">
                                @foreach($amounts as $amount)
                                <li class="">{{$amount}}</li>
                                @endforeach
                            </div>

                        </ul>

                    </div>

                </div>


            </div>


        </div>
        



    <!-- popup new -->

    <div id="popup-sj" class="row hidden">

        
        <div id="img-holder" class="col-12 text-center">
            <img src="{{asset('images/Group.png')}}" alt="Popup Image" width="120px">
        </div>

        <div class="col-12 text-center">
            <p>{{__('inpanel.dashboard.pop_up.title_new_1')}} <b>“{{__('inpanel.dashboard.pop_up.title_new_2')}}”</b> {{__('inpanel.dashboard.pop_up.title_new_3')}} </p>
        </div>

        <div id="btn-container" class="col-12 text-center">
            <button id="okBtn"><b>{!! __('frontend.register.join_now') !!}</b></button>
        </div>

        <div class="col-12" style="margin-top:15px;">

            <div class="row-3">

                <div class="col">

                    <button id="closeBtn"><b>{!! __('inpanel.dashboard.pop_up.skip_for_now') !!}</b></button>

                </div>

                <div class="col" style="text-align:end;">

                    <button id="closeBtn-cls"><b>{{ __('inpanel.dashboard.pop_up.donot_show_button_1') }}</b></button>

                </div>

            </div>

        </div>

    </div>

    
@endsection

@push('after-styles')

    <style>

        #popup-sj {
            position: fixed;
            background: white;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display:flex;
            flex-direction: column;
            width: 35%;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 20px;
            border-radius: 17px;
            border:5px solid #0082F0;       
         }

        #okBtn{
            background: #0082F0;
            font-size: 22px;
            border-radius: 40px;
            padding-left: 35px;
            padding-right: 35px;
            padding-bottom: 10px;
            padding-top: 10px;
            border: none;
            color: white;
        }   

        #closeBtn{
            background: #DDDDDD; 
            font-size: 13px; 
            border-radius: 30px;
            padding-left: 35px;
            padding-right: 35px;
            padding-bottom: 5px;
            padding-top: 5px;
            border:none;
        }
        
        #closeBtn-cls{
            background: #DDDDDD; 
            font-size: 13px; 
            border-radius: 30px;
            padding-left: 10px;
            padding-right: 10px;
            padding-bottom: 5px;
            padding-top: 5px;
            border:none;
        }

        .row-3{
            display:grid;
            grid-template-columns: auto auto;
        }
        

        .ul-ele li{
            color:#004AAD;
            font-size: 10px;
        }

        .row-1{
            display:grid;
            grid-template-columns: auto auto auto;
            column-gap: 5px;
        }

        .row-2{
            display:grid;
            grid-template-columns: 105px 105px 130px;
            column-gap: 5px;
        }
        
        .fw-bold{
            font-weight:bold;
        }

        .rounded{
            border-radius:5px;
        }

        .top-div {
            background-color: #1180D0;
            /* padding: 20px; */
            text-align: center;
            position: sticky;
            top:0;
            font-weight: 600;
            z-index: 100000;
        }
       
        .column-heading {
            font-size: 12px;
            font-weight: 600;
        }

        #redemptionTable{
            position: fixed;
            top: 50%;
            right: 30px;
            width: 395px;
            height: 150px;
            transform: translate(0, -50%);
            /* background-color: #1180D0; */
            color: #fff;
            /* padding-left: 5px;
            padding-right: 5px; */
            /* border: 1px solid #1180D0; */
            /* box-shadow: 0 0 10px rgba(0,0,0,0.2); */
            /* overflow: hidden; */
            z-index: 9999;
        }
        .w-40 {
            width: 40%;
        }
        .w-30 {
            width: 28%;
        }
        .list-move{
            animation: scroll-top 7s linear infinite;
        }
        .column {
            text-align:center;
            padding-top:10px;
            display: inline-block;
            vertical-align: top;
            /* width: 31.5%;
            margin-right: 0.5%; */
            padding-left: 5px;
            padding-right: 5px;
            list-style: none;
            height: 100%;
            overflow: hidden;
            width:100%;
        }
        @keyframes scroll-top {
            0% {
                transform: translateY(100%);
            }
            100% {
                transform: translateY(-100%);
            }
        }
        .scroll-box {
            width: 100%;
            height: 40px;
            overflow: hidden;
            position: relative;
            background-color: black;
        }

        .scroll-content {
            white-space: nowrap;
            position: absolute;
            right: 0;
            animation: scroll-left 25s linear infinite;
        }
        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        .feed-item {
            margin-bottom: 10px;
            margin-top: 10px;
            font-size: 15px;
            font-weight: 600;
            color: white;
        }
        .feed-element {
            /* background-color: yellow; */
            padding-right: 5px;
        }
        #footer {
            background: #1180D0 !important;
        }
        #footer h5{
            padding-left: 10px;
            border-left: 3px solid #eeeeee;
            padding-bottom: 6px;
            margin-bottom: 20px;
            color:#ffffff;
        }
        #footer a {
            color: #ffffff;
            text-decoration: none !important;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }
        #footer ul.social li{
            padding: 3px 0;
        }
        #footer ul.social li a i {
            margin-right: 5px;
            font-size:25px;
            -webkit-transition: .5s all ease;
            -moz-transition: .5s all ease;
            transition: .5s all ease;
        }
        #footer ul.social li:hover a i {
            font-size:30px;
            margin-top:-10px;
        }
        #footer ul.social li a,
        #footer ul.quick-links li a{
            color:#ffffff;
        }
        #footer ul.social li a:hover{
            color:#eeeeee;
        }
        #footer ul.quick-links li{
            padding: 3px 0;
            -webkit-transition: .5s all ease;
            -moz-transition: .5s all ease;
            transition: .5s all ease;
        }
        #footer ul.quick-links li:hover{
            padding: 3px 0;
            margin-left:5px;
            font-weight:700;
        }
        #footer ul.quick-links li a i{
            margin-right: 5px;
        }
        #footer ul.quick-links li:hover a i {
            font-weight: 700;
        }

        .swal2-popup {
            height: 200px;
        }
        .swal2-footer {
            display: block;
            position: absolute;
            bottom: 10px;
            width: 90%;
        }
        .swal2-confirm {
            width: 150px;
            height: 70px;
            font-size: 1.5em !important;
            font-weight: 600;
            border: none !important;
            outline: none !important;
        }
        @if(app()->getLocale() == "en_US")
        .lang-padding-col3 {
             
             padding-left: 60px;
         
        }
        @elseif(app()->getLocale() == "es_US")
        .lang-padding-col3 {
             
             padding-left: 70px;
         
        }
        .lang-padding-col2 {
            padding-left: 40px;
        }
        @endif
        
        @media (max-width:767px) {
            #footer h5 {
                padding-left: 0;
                border-left: transparent;
                padding-bottom: 0px;
                margin-bottom: 10px;
            }

            #popup-sj {
            width: 80%;
         }

         #okBtn{
            font-size: 17px; 
        }   

        #closeBtn{
            font-size: 10px; 
            padding-left: 20px;
            padding-right: 20px;
        }
        
        #closeBtn-cls{
            font-size: 10px; 
            padding-left: 10px;
            padding-right: 10px;
        }

        #redemptionTable{
            scale:0.9;
            right:-3px;
        }

        }


        @media only screen and (min-width: 768px) and (max-width:992px){

            #popup-sj {
            width: 60%;
         }

        }

    </style>
@endpush

@push('after-scripts')
    <script>


       // var checkSpanish = document.getElementById('checktext').innerText;

        //var rowElement = document.querySelector(".row-2");
        
       // if(checkSpanish == "Redención en los últimos 15 días"){
        //    rowElement.style.gridTemplateColumns = "122px 107px 113px";
      //  }



        function changeLanguage(elem) {
            var element = jQuery(elem);
            console.log(element);
        }
        $(document).ready(function(){
            const dontShowAgain = localStorage.getItem('dontShowAgain');
            let is_user_set = @json(session()->has('current_user'));
            console.log("heRE " +is_user_set);
            if(!dontShowAgain){
                /* if(document.cookie.indexOf('skipSwal=true') === -1){ */
                    setTimeout(() => {
                    const popup = document.getElementById("popup-sj");
                    popup.classList.remove("hidden");
                    }, 1000);
                /* } */
               
            }
            console.log(dontShowAgain); 
        });


        document.addEventListener("DOMContentLoaded", function(){

            const popup = document.getElementById("popup-sj");
            const okBtn = document.getElementById("okBtn");
            const closeBtn = document.getElementById("closeBtn");
            
            /* setTimeout(() => {
                popup.classList.remove("hidden");
                
            }, 1000); */

            okBtn.addEventListener("click", function(){
                   const newTab = window.open("{{route('frontend.auth.register')}}","_blank");
                   newTab.focus();
                   popup.classList.add("hidden");
                });

            closeBtn.addEventListener("click", function(){
                /* document.cookie = 'skipSwal=true'; */
                   popup.classList.add("hidden");
                });


            document.getElementById("closeBtn-cls").addEventListener('click', function(){
                /* alert("hello"); */
                localStorage.setItem('dontShowAgain', 'true');
                popup.classList.add("hidden");

                
            });    

        });
        

        /* function  displayRegisterPopUp()
        {
            swal({
                // title: ''+"{{__('inpanel.dashboard.pop_up.title')}}",
                // html: "{{__('inpanel.dashboard.pop_up.title_1')}}" +
                //     "<br/>{{__('inpanel.dashboard.pop_up.title_2')}}&nbsp;<i class='far fa-smile-wink'></i><br/>",
                // type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
                // showCancelButton: true,
                confirmButtonColor: "#1080d0",
                confirmButtonText: "{!! __('frontend.register.join_now') !!}",
                // cancelButtonText: "{!! __('inpanel.dashboard.pop_up.donot_show_button') !!}",
                // closeOnConfirm: false,
                showCloseButton: true,
                footer: `
                    <div style="display: flex; justify-content: space-between; width: 100%;">
                        <a href='javascript:void(0)' id='skip-action'>{!! __('inpanel.dashboard.pop_up.skip_for_now') !!}</a>
                        <a href='javascript:void(0)' id='noshow-action'>{!! __('inpanel.dashboard.pop_up.donot_show_button') !!}</a>
                    </div>
                `,
                backdrop: false
            }).then((result)=>{
                if(result.value===true){
                    window.location.href = "{{route('frontend.auth.register')}}";
                }
            });

            document.querySelector('.swal2-close').addEventListener('click', function(){
                swal.close();

                setTimeout(() => {
                    displayRegisterPopUp();
                }, 60000);
            });

            document.getElementById('skip-action').addEventListener('click', function(){
                document.cookie = 'skipSwal=true';
                swal.close();
            });
            document.getElementById('noshow-action').addEventListener('click', function(){
                localStorage.setItem('dontShowAgain', 'true');
                swal.close();
                
            });
        } */


        function resetScroll(){
            const columns = document.querySelectorAll('.list-move');
            columns.foreach(column => {
                column.style.animation = 'none';
                column.offsetHeight;
                column.style.animation = null;
            });

        }

        const columns = document.querySelectorAll('.column');
        columns.foreach(column => {
            column.addEventListener('animationiteration', resetScroll);
        });


    </script>
@endpush
