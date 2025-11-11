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
            max-width: 39rem;
            min-width: 39rem;
        }
        .landing-page .header-back.promo-one {
            height: 250px;
            width: 100%;
        }
        .landing-page .header-back.promo-one {
            background: url(/img/promo/hrisbanner3.jpg);
        }
    </style>
@endpush

@section('content')
    <!-- ########################### SECTION START ########################### -->
    <div class="row">
        <div class="header-back promo-one"></div>
        <div class="pull-right landing-form_container">
            {{ html()->form('POST', route('frontend.auth.promo.register.post'))->class('well center-block promo_registration_form')->open() }}
            <legend class="text-center">Registration</legend>
            <legend class="text-right">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <a class="btn btn-default" href="{{route('frontend.auth.social.login', 'facebook')}}" role="button" style="text-transform:none">
                            <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAb1BMVEU6VZ////82Up4zUJ1UbKx4ibswTpyMmsQ5V6EtTJupss8nSJnN0+WVosgqSpo4U56eqcyDksDj5vBwgbb3+PxFXqNabqt9jb3S2OhidbC9xdy3v9l0hLjZ3etLY6bq7fTEyt4dQpdJYqekrs2uttK97JEgAAADFUlEQVR4nO3c2XLiMBBAUUZmM3IsFsNgSIAk/P83TsLzjCNbI3c3de9rqlw+BV7VZDIhIiIiIiIiIiIiIiIiIlJeCM4VxbzsrJDey8G50s/3h91ss3jp7LdJYii8262rbfPr545eem/753y9qWJwjypzwqJuT7E6i0JX7459fOaEvn3r5zMmLPy5r8+W0L9Gn15MCkO9GuAzJHSh9xFoS1hcrsOAVoTzdsghaEhYTAcDbQjdfjjQhDAshx6DRoShrhKAFoR+nQI0ICzaJKABYZlyEFoQ1p9pQPVCd0m4UJgQ+lsiULvQXVKB2oW+1ysZg8KwTAYqF5ZpF3sDQr99cqFLvJ3RL0y+2usXDnw1Y0YYUh58TQiL3X8Aql57Kvschs3xdF/9pftC8fphj3vSalZ6X5tbA/axJ5rtzhdBem+HVEeeaKq55s+po1DHAW/vJj+/yfdifdxX1OYX9LuwjxIejH5Fv3LTGOBJ8eXup+KEH056P4cXJby+S+9mQlHCUy29mwlFCddz6d1MKEq4sXsmjRTOEGoOIUL9IUSoP4QI9YcQof4QItQfQoT6Q4hQR27+78qYucRX37GFR7Jrb65ddBQz1Hbv2sCjpSixvEcgEitlhcN+cNenRnZxagThm+wK6ghC4TXiEYSr8tmFwstvIwhb2XX+EYR72St+fmEj6htDuBW+a8svPArPauQXnp9e+CI8jZJfKP38mF8ofDnML2wuwsOn2YVX6ena7MKt9PRpduHt6YUr6eHM7MKF9HBmduGr9OvU7MKp9BR4bmEjDcwulJ9zzy2U/+1hbqH0s1N+4afsq8QRhPKT/LmFB+kb7+xC6Tua7ELhdacRhOLPTtmFCv7ZQOY14LP4xWISlh2FqFkM17UF8VPpF7Hjb3HTJl2nSwXAzp5jnqYrhAj1hxCh/hAi1B9ChPpDiFB/CBHqDyFC/SFEqD+ECPWHEKH+ECLUH0KE+kOIUH8IEeoPIUL9IUSoP4QI9YcQof4QItQfQoT6Q4hQfwgR6g8hQv0hRKg/hAj1hxCh/hAi1B9ChD36A+1ASVvVoq0WAAAAAElFTkSuQmCC" />
                            <span>Login with Facebook</span>
                        </a>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <a class="btn btn-default" href="{{route('frontend.auth.social.login', 'google')}}" role="button" style="text-transform:none">
                            <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                            Login with Google
                        </a>
                    </div>
                </div>

            </legend>
            <div class="row">
                <div class="col-12 col-md-6 mx-auto">
                    <div class="form-group">
                        <input type="text" name="first_name" id="first_name" class="form-control" required>
                        <label class="form-control-placeholder" for="first_name">{{__('validation.attributes.frontend.first_name')}}</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 mx-auto">
                    <div class="form-group">
                        <input type="text" name="last_name" id="last_name" class="form-control" required>
                        <label class="form-control-placeholder" for="last_name">{{__('validation.attributes.frontend.last_name')}}</label>
                    </div>
                </div>
                {{--<div class="col-12 col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}
                        {{ html()->text('first_name')
                            ->class('form-control input-lg')
                            ->placeholder(__('validation.attributes.frontend.first_name'))
                            ->attribute('maxlength', 191)
                            ->attribute('autocomplete', 'off')
                        }}
                    </div><!--col-->
                </div><!--row-->--}}

                {{-- <div class="col-12 col-md-6">
                     <div class="form-group">
                         {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                         {{ html()->text('last_name')
                             ->class('form-control input-lg')
                             ->placeholder(__('validation.attributes.frontend.last_name'))
                             ->attribute('maxlength', 191)
                             ->attribute('autocomplete', 'off')
                         }}
                     </div><!--form-group-->
                 </div><!--col-->--}}
            </div><!--row-->
            <div class="row">
                <div class="col-12 col-md-12 mx-auto">
                    <div class="form-group">
                        <input type="email" name="email" id="email" value="" maxlength="191" autocomplete="off" required="required" class="form-control input-lg">
                        <label class="form-control-placeholder" for="email">{{__('validation.attributes.frontend.email')}}</label>
                    </div>
                </div>
                {{--<div class="col-12 col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}
                        {{ html()->email('email')
                            ->class('form-control input-lg')
                            ->placeholder(__('validation.attributes.frontend.email'))
                            ->attribute('maxlength', 191)
                            ->attribute('autocomplete', 'off')
                            ->required() }}
                    </div>
                </div>--}}
            </div>
            <div class="row">
                <div class="col-12 col-md-12 mx-auto">
                    <div class="form-group">
                        <input type="password" name="password" id="password"  required="required" class="form-control input-lg">
                        <label class="form-control-placeholder" for="password">{{__('validation.attributes.frontend.password')}}</label>
                    </div>
                </div>
                {{--<div class="col-12 col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                        {{ html()->password('password')
                            ->class('form-control input-lg')
                            ->placeholder(__('validation.attributes.frontend.password'))
                            ->required() }}
                    </div><!--form-group-->
                </div><!--col-->--}}
            </div><!--row-->

            <div class="row">
                <div class="col-12 col-md-12 mx-auto">
                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" required="required" class="form-control input-lg">
                        <label class="form-control-placeholder" for="password_confirmation">{{__('validation.attributes.frontend.password_confirmation')}}</label>
                    </div>
                </div>
                {{--<div class="col-12 col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                        {{ html()->password('password_confirmation')
                            ->class('form-control input-lg')
                            ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                            ->required() }}
                    </div><!--form-group-->
                </div><!--col-->--}}
            </div><!--row-->
            @if( !empty($countries) )
                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('frontend.register.static.country'))->for('country') }}
                            <select autocomplete="off" data-con_code="{{$con_code}}" data-lang_code="{{$lang_code}}" id="country" class="form-control form-control-lg" name="country" required title="country">
                                <option {{(!$countries->contains('country_code', $con_code)??'selected=true')}}>{{__('frontend.modes.index.button').' '.__('frontend.register.static.country')}}</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->country_code}}"  {{ ($country->country_code && $con_code==$country->country_code)?'selected="true"':'' }}>{{$country->country_name}}</option>
                                    {{--<option value="{{$country->id}}" {{ ($country->country_code == $currentCountry)?'selected="true"':'' }}>{{$translatedCountry->name}}</option>--}}
                                @endforeach
                            </select>
                        </div><!--form-group-->
                    </div><!--col-->
                    <div class="col-6 col-md-6">
                        <div class="form-group lang">
                            {{ html()->label(__('frontend.register.static.language'))->for('language') }}
                            <select autocomplete="off" class="form-control" id="language" name="language" required title="language">

                            </select>
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->
            @endif
            @if (config('access.captcha.registration'))
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            {!! app('captcha')->renderCaptchaHTML() !!}
                        </div>
                    </div><!--col-->
                </div><!--row-->
            @endif
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" value="1" class="form-check-input"  name="consent">&nbsp; {{__(' By clicking on this checkbox you understand and agree to our')}}
                            <a href="{{route('frontend.cms.term_condition')}}"> {{__('Terms & Conditions')}}</a> & <a href="{{route('frontend.cms.privacy')}}">{{__('Privacy Policy')}}</a>
                        </label>
                    </div>
                </div>
            </div><!--row-->

            <div class="row">
                <button class="btn btn-block btn-primary" type="submit">{{__('labels.frontend.auth.register_button')}}</button>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        {{__('frontend.index.contact_us.commit_statement')}}
                    </div>
                </div>
            </div><!--row-->
            {{ html()->form()->close() }}
            <div id="free-flag"></div>
        </div>
    </div>
    <!-- ########################### SECTION END ########################### -->
    <!-- ########################### SECTION START ########################### -->

    <section  class="container features" id="features" style = "position:relative;top:-40px;">
        <div class="row">
            <div class="col-lg-8 text-center">
                <div class="navy-line"></div>
                <h1>{!! __('frontend.index.how_it_works.title_1') !!} </h1>
                <p>{!! __('frontend.index.how_it_works.title_2') !!}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 text-center">
                <div>
                    <i class="fa fa-mobile features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_action')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead')}}.</p>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div>
                    <i class="fa fa-envelope features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_subhead_6')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead_7')}}.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 text-center">
                <div class="m-t-lg">
                    <i class="fa fa-tasks features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_subhead_4')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead_5')}}.</p>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="m-t-lg">
                    <i class="fas fa-money-bill-alt features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_subhead_2')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead_3')}}</p>
                </div>
            </div>
        </div>
        <div class="row">

        </div>


    </section>





    {{--<section  class="container features" id="features">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>{!! __('frontend.index.how_it_works.title_1') !!} </h1>
                <p>{!! __('frontend.index.how_it_works.title_2') !!}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center wow fadeInLeft">
                <div>
                    <i class="fa fa-mobile features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_action')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead')}}.</p>
                </div>
                <div class="m-t-lg">
                    <i class="fas fa-money-bill-alt features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_subhead_2')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead_3')}}</p>
                </div>
            </div>
            <div class="col-md-4 text-center  wow zoomIn">
                <img src="{{asset('vendor/img/landing/4steps.png')}}" alt="dashboard" class="img-responsive" style="margin-left: 10%;">
            </div>
            <div class="col-md-4 text-center wow fadeInRight">
                <div class="m-t-lg">
                    <i class="fa fa-tasks features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_subhead_4')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead_5')}}.</p>
                </div>
                <div>
                    <i class="fa fa-envelope features-icon"></i>
                    <h3>{{__('frontend.index.how_it_works.title_subhead_6')}}</h3>
                    <p>{{__('frontend.index.how_it_works.title_subhead_7')}}.</p>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>{{__('frontend.index.get_great_rewards.title_1')}}</h1>
                <p>{{__('frontend.index.get_great_rewards.subtitle_1')}} </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-6 features-text wow fadeInLeft">
                <small>{{__('frontend.index.get_great_rewards.under.title_1')}}</small>
                <h2>{{__('frontend.index.get_great_rewards.under.title_2')}} </h2>
                <p>{{__('frontend.index.get_great_rewards.under.title_2_details')}}.</p>
                <a href="{{route('frontend.cms.rewards')}}" class="btn btn-primary">{{__('frontend.index.get_great_rewards.under.button_learn_more')}}</a>
            </div>
            <div class="col-lg-6 text-right wow fadeInRight">
                <img src="{{asset('vendor/img/rewards/rewards.png')}}" alt="dashboard" class="img-responsive pull-right">
            </div>
        </div>
    </section>--}}
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

    {{--<div class="modal fade inmodal" id="promo_welcome_popup" tabindex="-1" role="dialog" style="padding-right: 17px;" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div>--}}

    {{--<div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-sm">
            <p>
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
        <div class="col-lg-8 col-lg-offset-2 text-center">
            <p>
                {{__('frontend.index.footer.bottom_tex')}}
            </p>
        </div>
    </div>--}}
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
            var country_code = $('select#country').val();
            console.log(country_code);
            var lang_code = $('select#country').attr('data-lang_code');
            console.log(lang_code);
            loadLanguage(country_code,lang_code);
        })

        $('button#popup_next').on('click',function (e) {
            $('#promo_welcome_popup').modal("hide");
            $('input#first_name').focus();
        })
        $('select#country').on('change', function (e) {
            var country_code = $('select#country').val();
            var lang_code = $('select#country').attr('data-lang_code');
            loadLanguage(country_code,lang_code);

        })

        function loadLanguage(country_code,lang_code)
        {
            var header = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
            if(!country_code || country_code == 0){
                return false;
            }
            axios.get("{{route('frontend.auth.language')}}",{
                params:{
                    country_code: country_code,
                }
            }).then(function (response) {
                if(response.status === 200){
                    $select = $('#language');
                    $select.find('option').remove();
                    var lang = response.data;
                    $.each(lang, function (value, name) {
                        $select.append($('<option />', {value: value, text: name}));
                    });
                    if(country_code && lang_code){
                        $select.val(lang_code);
                    }
                }
            }).catch(function (error) {
                // handle error
            }).then(function () {
                // always executed
                console.log('always executed');
            });
        }
    </script>
@endpush
