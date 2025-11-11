@extends('frontend.layouts.promo_app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@push('after-styles')
    <link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <style>
        .landing-form_container{
            padding: 3rem 1rem;
            z-index: 1;
            position: absolute;
            top: 10%;
            right: 5%;
        }
        #free-flag {
            position: absolute;
            top: 29px;
            
            right: 254px;
            height: 52px;
            width: 100px;
            z-index: 1;
            background: url(https://www.newradio.it/wpnr/wp-content/uploads/2017/01/free-tag.png) top left no-repeat;
            background-size: 100%;
        }
        .promo_registration_form{
            max-width: 35rem;
            min-width: 35rem;
        }
        .landing-page .header-back.promo-one {
            height: 250px;
            width: 100%;
        }
        .landing-page .header-back.promo-one {
            background: url(/img/promo/hrisbanner3.jpg);
        }
        .consent-form{
            margin-bottom: 0px;
            position: relative;
            height: 470px;
            margin-top: -72px;
            margin-bottom: 110px;
            padding: 40px;
            -webkit-justify-content: space-around;
            -ms-flex-pack: distribute;
            justify-content: space-around;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 5px;
            background-color: #1f6fff;
            color: #fff;
        }
        .promo-section-title{
            text-align: center;
            margin-bottom: 13px;
            margin-top: 0px;
            font-size: 46px;
            line-height: 39px;
            font-weight: 300;
        }
        .promo-section-description{
            font-size: 18px;
            line-height: 31px;
        }
    </style>
@endpush

@section('content')
    <!-- ########################### SECTION START ########################### -->
    <div class="row">
        <div class="header-back promo-one">

        </div>

        <div class="section" style="padding-bottom: 0px;  position: relative;">
            <div class="container w-container" style="position: relative;">
                <div class="consent-form w-form" style="">
                    <div class="newsletter-row w-row">
                        <div class="newsletter-column-left w-col w-col-5">
                            <h2 class="promo-section-title">
                                Welcome to SJ Panel
                            </h2>
                            <div class="faded promo-section-description">
                                <p><strong>{{__('frontend.promo_popup.sj_panel')}} </strong> {{__('frontend.promo_popup.details_1')}}
                                </p>
                                <p>{{__('frontend.promo_popup.details_2')}}
                                </p>
                                <p>
                                    {{__('frontend.promo_popup.details_3')}}
                                </p>
                                <p>
                                    {!! __('frontend.promo_popup.details_4') !!}
                                </p>
                            </div>
                            <div style="text-align: center;">
                                <a href="{{route('frontend.auth.promo.register', request()->all())}}" class="btn btn-secondary btn-lg" style="color: #f8f9fa;border-color: #f8f9fa;">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ########################### SECTION END ########################### -->
    <!-- ########################### SECTION START ########################### -->

    <!-- ########################### SECTION START ########################### -->
    <section  class="features" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>{!! __('frontend.index.how_it_works.title_1') !!} </h1>
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






    <!-- ########################### SECTION END ########################### -->

    <section class="features landing_grey_background">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>{{__('frontend.index.why_you_earn.title_1')}}</h1>
                    <p>{{__('frontend.index.why_you_earn.title_2')}}. </p>
                </div>
            </div>
            <div class="row features-block">
                <div class="col-lg-3 features-text wow fadeInLeft">
                    <h2>{{__('frontend.index.why_you_earn.under.subtitle_1')}}</h2>
                    <p>{{__('frontend.index.why_you_earn.under.subtitle_1_details')}}.</p>
                </div>

                <div class="col-lg-6 text-right m-t-n-lg wow zoomIn">
                    <img src="{{asset('vendor/img/rewards/happy.jpg')}}" class="img-responsive" alt="dashboard">
                </div>
                <div class="col-lg-3 features-text text-right wow fadeInRight">
                    <h2>{{__('frontend.index.why_you_earn.under.subtitle_2')}}</h2>
                    <p>{{__('frontend.index.why_you_earn.under.subtitle_2_details')}}.</p>
                </div>
            </div>
        </div>

    </section>


    <!-- ########################### TESTIMONIAL SECTION ##################### -->
    <section id="testimonials" class="navy-section testimonials" style="margin-top: 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center wow zoomIn">
                    <i class="fa fa-comment big-icon"></i>
                    <h1>
                        {{__('frontend.index.what_our_users_say.title_1')}}
                    </h1>
                    <div class="testimonials-text">
                        <i>{!! __('frontend.index.what_our_users_say.details') !!}</i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ########################### TESTIMONIAL SECTION END ##################### -->
    <div class="container" style="padding-top: 97px;">
    </div>
    <section id="footer">
        <div class="container">
            <div class="row text-center text-xs-center text-sm-left text-md-left">
                <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-sm">
                    <p style="color: white">
                        <strong>&reg; {{__('frontend.index.footer_Section_1')}}</strong>
                        <br/>
                        <a href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                        | <a href="https://samplejunction.com/safeguard/">{{__('frontend.index.footer.links.Safeguards')}}</a>
                        | <a href="{{route('frontend.cms.faq')}}">{{__('frontend.index.footer.links.FAQ')}}</a>
                        | <a href="{{route('frontend.cms.cookie')}}">{{__('frontend.index.footer.links.cookie_policy')}}</a>
                        | <a href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>

                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    {{--<a href="mailto:contact@sjpanel.com" class="btn btn-primary">{!! __('frontend.index.contact_us.send_email_button') !!}</a>--}}
                    <p class="m-t-sm" style="color: white">
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
                    <img src="{{asset('img/frontend/SSL.png')}}" class="img" id="ssl" width="80" height="80" title="SSL Secure">
                    <img src="{{asset('img/frontend/iso-9001.png')}}" class="img" id="iso_9001" width="80" height="80" title="ISO 9001:2015 Certified">
                    <img src="{{asset('img/frontend/iso-27001.png')}}" class="img" id="iso_27001" width="80" height="80" title="ISO 27001-2013 Certified">
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

    <div class="modal fade inmodal" id="promo_welcome_popup" tabindex="-1" role="dialog" style="padding-right: 17px;" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <img style="width: 24%" src="{{ asset('/images/logo.png') }}" class="logo-name"><br />
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body">
                    <p><strong>{{__('frontend.promo_popup.sj_panel')}} </strong> {{__('frontend.promo_popup.details_1')}}
                    </p>
                    <p>{{__('frontend.promo_popup.details_2')}}
                    </p>
                    <p>
                        {{__('frontend.promo_popup.details_3')}}
                    </p>
                    <p>
                        {!! __('frontend.promo_popup.details_4') !!}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="popup_next" class="btn btn-primary">{{__('frontend.promo_popup.button')}}</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('after-styles')
    <style>

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control-placeholder {
            position: absolute;
            top: 0;
            padding: 7px 0 0 13px;
            transition: all 200ms;
            opacity: 0.5;
        }

        .form-control:focus + .form-control-placeholder,
        .form-control:valid + .form-control-placeholder {
            font-size: 75%;
            transform: translate3d(0, -100%, 0);
            opacity: 1;
        }

    </style>
    <style>
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

        @media (max-width:767px) {
            #footer h5 {
                padding-left: 0;
                border-left: transparent;
                padding-bottom: 0px;
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
@push('after-scripts')
    @if (config('access.captcha.registration'))
        @captchaScripts('en')
    @endif

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{asset('vendor/js/plugins/fullcalendar/moment.min.js')}}"></script>

    <!-- Data picker -->
    <script src="{{asset('vendor/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <script>

        $(document).ready(function () {

            /*$('#promo_welcome_popup').modal('toggle');*/


        })

        $('button#popup_next').on('click',function (e) {
            $('#promo_welcome_popup').modal("hide");
            $('input#first_name').focus();
        })


    </script>
@endpush
