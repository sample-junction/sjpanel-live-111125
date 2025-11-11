@extends('frontend.layouts.app')

{{--@section('title', app_name() . ' | '.__('labels.frontend.auth.register_box_title')) --}}
@section('title','Register to Earn Money Online | Sign Up Now for free to Take Paid Surveys')
@section('meta_description','Sign up to SJ Panel and get the chance to earn money online. Register with us and complete paid surveys to earn money. Get free points for money when you sign up. Register and start making money online today!')
@section('meta_keyword','SJ Panel sign up, sign up for paid surveys, paid surveys sign in, sign up earn money online, register earn money, earn money online sign up, survey panel sign up, sign up for online surveys, sign up and get money, sign up and get free money, sign up and earn money, sign up for free and start earning')
@push('after-styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"
  rel="stylesheet" type='text/css'>

<link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
<link href="{{asset('css2/style2.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap4.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css2/bootstrap.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap.rtl.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-grid.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-grid.rtl.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-grid.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-reboot.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-reboot.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-reboot.rtl.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-reboot.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-utilities.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-utilities.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-utilities.rtl.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-utilities.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />


<style>

  .alert.alert-danger {
    margin-top: 15px !important;
    font-size: 16px;
  }

  .toast-error {
    background-color: red !important;
    color: #fff !important;
    font-size: 12px !important;
  }

  .Languague {
    display: none;
    background: white;
    border-radius: 5px;
    box-shadow: 2px 2px 10px;
  }

  .all_language_list .Languague img {
    position: absolute;
    right: 5px;
    height: 17px;
    top: 8px;
    margin-left: 50px;
  }

  .all_language_list li {
    text-align: start;
  }

  .all_language_list li a {
    left: 10px !important;
  }

  .gradient-custom-2 {
    /* fallback for old browsers */
    background: #006BDE;
    display: grid !important;

  }

  #proc .btn {
    background-color: #DCDCDC;
    color: #757575;
    font-size: 16px;
    /*  width: 85%;*/
    margin-left: 9px;
    /*  margin-top: 45px;*/
    margin-top: 36px !important;
  }

  .parent {
    position: relative;
    height: 200px;
    overflow: hidden;
  }

  .child {
    position: absolute;
    height: 200px;
    transition: transform 2s;
    transform: translateX(-120%);
    visibility: hidden;
  }

  .child-active {
    left: 50%;
    transform: translateX(-50%);
    transition: transform 2s;
    visibility: visible;
  }

  .img-text {
    scale: 0;
    transition: scale 1.5s;
  }

  .img-text-active {
    scale: 1.2;
    transition: scale 1.5s;
  }

  .border_right {
    border-right: 2px solid black;
  }

  @media (min-width: 220px) and (max-width: 767px) {
    #proc .btn {
      position: relative;
      /* top: 10px; */
      width: 85%;
      /* margin-top: 25px !important; */
          margin-top: 46px !important;

    }

    #div_mt .regis {
      top: unset;
    }
  }

  @media (min-width: 768px) and (max-width: 1200px) {
    #proc .btn {
      width: 85% !important;
      margin-left: 9px !important;
      margin-top: 0px !important;
      position: unset !important;
      top: 0;
    }

    div#proc {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  }

  .arrowpopup {
    position: relative;
    display: inline-block;
    cursor: pointer;
    opacity: 1 !important;
  }

  .arrowpopup .pass-tip {
    display: none;
    background-color: #006BDE;
    color: white;
    /*text-align: center;*/
    border-radius: 4px;
    padding: 10px 0px 8px 15px;
    width: 276px;
    opacity: 1 !important;
    position: absolute;
    bottom: 80%;
    left: 0%;
    line-height: 17px;
    margin-left: -25px;
    margin-top: 100px;
  }

  .arrowpopup .pass-tip::after {
    /*content: "33";*/
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #1080d0 transparent transparent transparent;
  }

  .arrowpopup .show {
    visibility: visible;
  }

  .field-icon {
    float: left;
    margin-left: 303px;
    margin-top: -23px;
    position: relative;
    z-index: 2;
  }

  .rg-sgn-up {
    width: 20%;
  }

  .bottom-feat-li {
    height: 100px;
  }


  @media (min-width: 220px) and (max-width: 767px) {

    .rg-sgn-up {
      width: 40%;

    }


    .bottom-feat-li {
      @if($flags =='ES-US') height:275px;

      @else height:170px;

      @endif
    }

  }

  @media screen and (max-width:991px) {
    .mobile-pd {
      /* padding: 150px 0 0 0; */
    }

    .border_right {
      border-right: unset;
    }

    #main-left-div {
      margin-top: 8px;
    }

    .mobile_slider,
    .mobile_slider img {
      height: 130px;
    }
  }
</style>

@endpush

@section('content')

@if(session('emailExist'))
<!--<div id="error-message" class="alert alert-danger">
        {{ session('error') }}
    </div>-->
<script type="text/javascript">
  Message = "{{(__('validation.attributes.frontend.toastr_2'))}}";
  setTimeout(function() {
    toastr.error(Message, '');
  }, 400);
</script>
@endif
<div id="container"><!-- main container starts-->
  <div id="wrapp"><!-- main wrapp starts-->
    <nav class="navbar navbar-expand-lg navbar-dark  static-top">
      <div class="container Nav-div">
        <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
          <img src="images/SJ Panel New LOGO without background.png" alt="logo" class="img-fluid">
        </a>
        <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button> -->

        <span class="navbar-brand-2 " id="span-1"><span class="already">{{__('frontend.index.contact_us.already_account')}}</span> <a href="{{url('/')}}/login" style="color: #006BDE;">
            {{__('frontend.modes.email_auth.button')}}
          </a></span>
      </div>
    </nav><!-- header ends-->

  </div>
</div>

<div id="line"></div>

<div class="container" style="margin-bottom: 0px;">
  <section class="h-100 gradient-form">
    <div class="container {{--py-5--}} h-100" id="card">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-12">
          <div class="card rounded-3 text-black">
            <div class="row g-0" width="25px">

              <div class="col-lg-6  align-items-center gradient-custom-2 contain-div-color" id="contain-div-1">
                <div class="text-white px-3 py-4 pt-md-0 pb-md-5 ps-md-5 pe-md-5 mx-md-4">

                  <div class="container mb-5 mb-md-0 d-flex justify-content-center">

                    <div class="row pb-5 rounded-5" style="width:100%;">

                      <div class="col-12 parent mobile_slider">

                        <img src="img/Signup Image.png" alt="icon" class="img-fluid child" loading="lazy">
                        <img src="img/image for Profile updation.png" alt="icon" class="img-fluid child" loading="lazy">
                        <img src="img/Image for survey.png" alt="icon" class="img-fluid child" loading="lazy">
                        <img src="img/Earn rewards image.png" alt="icon" class="img-fluid child" loading="lazy">
                        <img src="img/refer Image.png" alt="icon" class="img-fluid child" loading="lazy">

                      </div>
                      <!-- 
                                <div class="col-12 text-center mt-4" >

                                    <p class="lead img-text m-0 fw-bold text-light">Take Surveys</p>
                                    <p class="lead img-text m-0  fw-bold text-light">Refer Friends</p>
                                    <p class="lead img-text m-0  fw-bold text-light">Earn Rewards</p>

                                </div> -->

                    </div>

                  </div>

                  <h4 class="mb-4 text_margin_style" id="heading-img-text" style="font-size:23px">{{__('frontend.index.contact_us.opinion')}}</h4>
                  <p class="small mb-0 p_open" id="heading-img-subtext">{{__('frontend.index.contact_us.join')}}<br />
                    {{__('frontend.index.contact_us.join_1')}}
                  </p>
                  <!-- 
                    <div class="row div_m" width="30px"><br>
                    
                        <div class="col-2 img-1" width="50px">
                          <div class="icon_style">
                            <img src="img/Vector.png" alt="Vector" class="icon_padding_style " style="padding-top: 10px;"/>
                          </div>        
                          <h2 class="icon_heading sign">{{__('frontend.index.contact_us.signup_for')}}</h2>          
                        </div>

                        <div class="col-4  border-center img-2">
                          <div class="icon_style"><img src="img/Group.png" alt="group" class="icon_padding_style" style="padding-left: 14px;" /></div>
                          <h2 class="icon_heading">{{__('frontend.index.how_it_works.title_subhead_4')}}</h2>
                        </div>
                        
                          <div class="col-3 border-center2 img-3">
                            <div class="icon_style"><img src="img/Group 70.png" alt="group 70" class="icon_padding_style"/></div>
                            <h2 class="icon_heading">{{__('frontend.index.contact_us.take_survey')}}</h2>
                          </div>


                          <div class="col-3 border-center3 re-image">
                          <div class="icon_style" ><img src="img/Vector-1.png" alt="Vector" class="icon_padding_style" style="padding-left: 12px;"/></div>
                          <h2 class="icon_heading">{{__('frontend.index.contact_us.redeem_rewards')}} </h2>
                          </div>
                    </div> -->

                  <div class="row mt-5" style="transform:translateX(5%)">

                    <div class="col text-center">

                      <div class="row">

                        <div class="col-6">
                          <div class="icon_style">
                            <img src="img/Vector.png" alt="Vector" class="icon_padding_style " style="padding-top: 10px;" />
                          </div>
                        </div>

                        <div class="col-6">
                          <span><img src="images/register_arrow.png" class="img-fluid mt-4 mt-md-3 ms-3 ms-md-0" style="" alt="icon"></span>
                        </div>

                      </div>

                    </div>


                    <div class="col text-center">

                      <div class="row">

                        <div class="col-6">
                          <div class="icon_style">
                            <img src="img/Group.png" alt="group" class="icon_padding_style " style="padding-top: 10px;" />
                          </div>
                        </div>

                        <div class="col-6">
                          <span><img src="images/register_arrow.png" class="img-fluid  mt-4 mt-md-3 ms-3 ms-md-0" style="" alt="icon"></span>
                        </div>

                      </div>

                    </div>

                    <div class="col text-center">

                      <div class="row">

                        <div class="col-6">
                          <div class="icon_style">
                            <img src="img/Group 70.png" alt="group70" class="icon_padding_style " style="padding-top: 10px;" />
                          </div>
                        </div>

                        <div class="col-6">
                          <span><img src="images/register_arrow.png" class="img-fluid mt-4 mt-md-3 ms-3 ms-md-0" style="" alt="icon"></span>
                        </div>

                      </div>

                    </div>


                    <div class="col text-center">

                      <div class="row">

                        <div class="col-6">
                          <div class="icon_style">
                            <img src="img/Vector-1.png" alt="Vector1" class="icon_padding_style " style="padding-top: 10px;" />
                          </div>
                        </div>

                        <div class="col">
                        </div>

                      </div>

                    </div>

                  </div>

                </div>
              </div>

              <div class="col-lg-6 {{--div_m_t--}}" id="main-left-div">
                <div class="card-body p-md-5 mx-md-4">
                  <div class="row mt-1 mb-2" id="div_mt">
                    <div class=" col-9">
                      <h4 class="mt-1 Register_text_style regi" id="register">{{__('frontend.index.contact_us.register')}}</h4>
                      <!-- <h2 class="font-bold white">{{__('frontend.register.static.title')}}</h2> -->
                      <!-- <p class="white">{{__('frontend.register.static.subtitle')}}</p> -->
                    </div>
                    <div class="col-3">
                      <h4 class="mt-1 Register_text_style regis">

                        <!-- <li class="dropdown language_dropdown"> -->
                        <!-- <div class="blink_me_other">{{__('frontend.nav.static.binker')}} <span class="glyphicon glyphicon-arrow-right"></span></div> -->
                        <!-- <a class="dropdown-toggle" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-globe"></i>
                            @if(!empty($currentLanguage)) {{$currentLanguage->language_code}} @endif
                            <i class="fas fa-caret-down"></i>
                        </a> -->
                        <ul class="dropdown-menu dropdown-menu-right all_language_list" aria-labelledby="language-button" style="width:auto; background:transparent; box-shadow:none; border:none; margin-top: -9px;margin-left: 14px;">
                          <li class="dropdown-header" style="display:none !important">
                            @if(!empty($country_code)) {{--$country_code->display_name--}}{{$country_code}} - EN (Selected) @endif
                          </li>
                          <div class="" style=" text-transform: uppercase;">
                            {{--US--}}
                            {{-- <li role="separator" class="divider"></li> --}}
                            {{--
                                <li class="dropdown-header">{{__('frontend.nav.static.language_1')}}</li>
                            <li><a class="#" href="/lang/en_US">{{__('frontend.nav.static.language_2')}}</a></li>
                            <li><a href="/lang/es_fUS">{{__('frontend.nav.static.language_3')}}</a></li>
                            --}}
                            <div id="US" class="Languague">
                              <img src="img/USA.png" alt="usa" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">
                              <li class="dropdown-header">US</li>
                              <li><a class="#" href="/lang/en_US" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/es_US" onclick="changeImage(this, 'US-ES' ,'img/USA.png' )">{{__('frontend.nav.static.language_spanish')}} </a></li>
                            </div>

                            {{--CA--}}
                            <div id="CA" class="Languague">
                              <img src="img/CANADA.png" alt="canada" onclick="changeImage(this, 'CA-EN' ,'img/CANADA.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CA</li>
                              <li><a class="#" href="/lang/en_CA" onclick="changeImage(this, 'CA-EN' ,'img/CANADA.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fr_CA" onclick="changeImage(this, 'CA-FR' ,'img/CANADA.png' )">{{__('frontend.nav.static.language_french')}} </a></li>
                            </div>

                            {{--ES--}}
                            <div id="ES" class="Languague">
                              <img src="img/SPAIN.png" alt="spain" style="transform: translateY(10px); onclick=" changeImage(this, 'ES-EN' ,'img/SPAIN.png' )">
                              <li role="separator" class="divider"></li>
                              <li class="dropdown-header">ES</li>
                              <li><a class="#" href="/lang/es_ES" onclick="changeImage(this, 'ES-ES' ,'img/SPAIN.png' )">{{__('frontend.nav.static.language_spanish')}} </a></li>
                            </div>

                            {{--DE--}}
                            <div id="DE" class="Languague">
                              <img src="img/GERMANY.png" alt="germany" onclick="changeImage(this, 'DE-EN' ,'img/GERMANY.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">DE</li>
                              <li><a class="#" href="/lang/en_DE" onclick="changeImage(this, 'DE-EN' ,'img/GERMANY.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/de_DE" onclick="changeImage(this, 'DE-DE' ,'img/GERMANY.png' )">{{__('frontend.nav.static.language_german')}} </a></li>
                            </div>

                            {{--AU--}}
                            <div id="AU" class="Languague">
                              <img src="img/AUSTRALIA.png" alt="australia" onclick="changeImage(this, 'AU-EN' ,'img/AUSTRALIA.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">AU</li>
                              <li><a class="#" href="/lang/en_AU" onclick="changeImage(this, 'AU-EN' ,'img/AUSTRALIA.png' )">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--UK--}}
                            <div id="GB" class="Languague">
                              <img src="img/UNITED KINGDOM.png" alt="GB" onclick="changeImage(this, 'GB-EN' ,'img/UNITED KINGDOM.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">GB</li>
                              <li><a class="#" href="/lang/en_GB" onclick="changeImage(this, 'GB-EN' ,'img/UNITED KINGDOM.png' )">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--FR--}}
                            <div id="FR" class="Languague">
                              <img src="img/FRANCE.png" alt="france" onclick="changeImage(this, 'FR-EN' ,'img/FRANCE.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">FR</li>
                              <li><a class="#" href="/lang/en_FR" onclick="changeImage(this, 'FR-EN' ,'img/FRANCE.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fr_FR" onclick="changeImage(this, 'FR-FR' ,'img/FRANCE.png' )">{{__('frontend.nav.static.language_french')}} </a></li>
                            </div>

                            {{--IT--}}
                            <div id="IT" class="Languague">
                              <img src="img/ITALY.png" alt="italy" onclick="changeImage(this, 'IT-EN' ,'img/ITALY.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">IT</li>
                              <li><a class="#" href="/lang/it_IT" onclick="changeImage(this, 'IT-IT' ,'img/ITALY.png' )">{{__('frontend.nav.static.language_italian')}} </a></li>
                            </div>

                            {{--IN--}}
                            <div id="IN" class="Languague">
                              <img src="img/INDIA.png" alt="india" onclick="changeImage(this, 'IN-EN' ,'img/INDIA.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">IN</li>
                              <li><a class="#" href="/lang/en_IN" onclick="changeImage(this, 'IN-EN' ,'img/INDIA.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/hi_IN" onclick="changeImage(this, 'IN-HI' ,'img/INDIA.png' )">{{__('frontend.nav.static.language_hindi')}} </a></li>
                            </div>

                            {{--CN--}}
                            <div id="CN" class="Languague">
                              <img src="img/CHINA.png" alt="china" onclick="changeImage(this, 'CN-EN' ,'img/CHINA.png' )">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CN</li>
                              <li><a class="#" href="/lang/en_CN" onclick="changeImage(this, 'CN-EN' ,'img/CHINA.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/zh_CN" onclick="changeImage(this, 'CN-CN' ,'img/CHINA.png' )">{{__('frontend.nav.static.language_chinese')}} </a></li>
                            </div>


                            <!-- new -->

                            {{--AR--}}
                            <div id="AR" class="Languague">
                              <img src="img/ARGENTINA.png" alt="argentina">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">AR</li>
                              <li><a class="#" href="/lang/en_AR">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/es_AR">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>

                            {{--BE--}}
                            <div id="BE" class="Languague">
                              <img src="img/BELGIUM.png" alt="belgium">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">BE</li>
                              <li><a class="#" href="/lang/fr_BE">{{__('frontend.nav.static.language_french')}}</a></li>
                              <li><a class="#" href="/lang/nl_BE">{{__('frontend.nav.static.language_dutch')}}</a></li>
                              <li><a class="#" href="/lang/de_BE">{{__('frontend.nav.static.language_german')}}</a></li>
                            </div>

                            {{--BR--}}
                            <div id="BR" class="Languague">
                              <img src="img/BRAZIL.png" alt="brazil">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">BR</li>
                              <li><a class="#" href="/lang/pt_BR">{{__('frontend.nav.static.language_portuguese')}}</a></li>
                            </div>

                            {{--CL--}}
                            <div id="CL" class="Languague">
                              <img src="img/CHILE.png" alt="chile">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CL</li>
                              <li><a class="#" href="/lang/es_CL">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>

                            {{--CO--}}
                            <div id="CO" class="Languague">
                              <img src="img/COLOMBIA.png" alt="colombia">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CO</li>
                              <li><a class="#" href="/lang/es_CO">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>


                            {{--DK--}}
                            <div id="DK" class="Languague">
                              <img src="img/DENMARK.png" alt="denmark">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">DK</li>
                              <li><a class="#" href="/lang/en_DK">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/de_DK">{{__('frontend.nav.static.language_german')}}</a></li>
                              <li><a class="#" href="/lang/da_DK">{{__('frontend.nav.static.language_danish')}}</a></li>
                            </div>

                            {{--EG--}}
                            <div id="EG" class="Languague">
                              <img src="img/EGYPT.png" alt="egypt">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">EG</li>
                              <li><a class="#" href="/lang/en_EG">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/ar_EG">{{__('frontend.nav.static.language_arabic')}}</a></li>
                            </div>

                            {{--HK--}}
                            <div id="HK" class="Languague">
                              <img src="img/HONG KONG.png" alt="hongkong">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">HK</li>
                              <li><a class="#" href="/lang/en_HK">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/zh_HK">{{__('frontend.nav.static.language_chinese')}}</a></li>
                            </div>

                            {{--ID--}}
                            <div id="ID" class="Languague">
                              <img src="img/INDONESIA.png" alt="indonesia">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">ID</li>
                              <li><a class="#" href="/lang/en_ID">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/id_ID">{{__('frontend.nav.static.language_indonesian')}}</a></li>
                            </div>

                            {{--JP--}}
                            <div id="JP" class="Languague">
                              <img src="img/JAPAN.png" alt="japan">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">JP</li>
                              <li><a class="#" href="/lang/jp_JP">{{__('frontend.nav.static.language_japanese')}}</a></li>
                            </div>

                            {{--KW--}}
                            <div id="KW" class="Languague">
                              <img src="img/KWAIT.png" alt="kuwait">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">KW</li>
                              <li><a class="#" href="/lang/ar_KW">{{__('frontend.nav.static.language_arabic')}}</a></li>
                            </div>


                            {{--MY--}}
                            <div id="MY" class="Languague">
                              <img src="img/MALAYSIA.png" alt="malaysia">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">MY</li>
                              <li><a class="#" href="/lang/zh_MY">{{__('frontend.nav.static.language_chinese')}}</a></li>
                              <li><a class="#" href="/lang/ms_MY">{{__('frontend.nav.static.language_malay')}}</a></li>
                              <li><a class="#" href="/lang/en_MY">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--MX--}}
                            <div id="MX" class="Languague">
                              <img src="img/MEXICO.png" alt="mexico">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">MX</li>
                              <li><a class="#" href="/lang/es_MX">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>


                            {{--NL--}}
                            <div id="NL" class="Languague">
                              <img src="img/NETHERLANDS.png" alt="netherlands">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">NL</li>
                              <li><a class="#" href="/lang/en_NL">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/nl_NL">{{__('frontend.nav.static.language_dutch')}}</a></li>
                            </div>

                            {{--NO--}}
                            <div id="NO" class="Languague">
                              <img src="img/NORWAY.png" alt="norway">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">NO</li>
                              <li><a class="#" href="/lang/en_NO">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/no_NO">NORWEGIAN</a></li>
                              <li><a class="#" href="/lang/de_NO">{{__('frontend.nav.static.language_german')}}</a></li>
                            </div>

                            {{--PE--}}
                            <div id="PE" class="Languague">
                              <img src="img/PERU.png" alt="peru">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">PE</li>
                              <li><a class="#" href="/lang/es_PE">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>

                            {{--PH--}}
                            <div id="PH" class="Languague">
                              <img src="img/PHILIPPINES.png" alt="philippines">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">PH</li>
                              <li><a class="#" href="/lang/en_PH">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fp_PH">FILIPINO/TAGALOG</a></li>
                            </div>

                            {{--PL--}}
                            <div id="PL" class="Languague">
                              <img src="img/POLAND.png" alt="poland">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">PL</li>
                              <li><a class="#" href="/lang/pl_PL">{{__('frontend.nav.static.language_polish')}}</a></li>
                            </div>


                            {{--RU--}}
                            <div id="RU" class="Languague">
                              <img src="img/RUSSIA.png" alt="russia">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">RU</li>
                              <li><a class="#" href="/lang/en_RU">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/ru_RU">{{__('frontend.nav.static.language_russian')}}</a></li>
                            </div>

                            {{--SG--}}
                            <div id="SG" class="Languague">
                              <img src="img/SINGAPORE.png" alt="singapore">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">SG</li>
                              <li><a class="#" href="/lang/zh_SG">{{__('frontend.nav.static.language_chinese')}}</a></li>
                              <li><a class="#" href="/lang/en_SG">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--SE--}}
                            <div id="SE" class="Languague">
                              <img src="img/SWEDEN.png" alt="sweden">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">SE</li>
                              <li><a class="#" href="/lang/sv_SE">{{__('frontend.nav.static.language_swedish')}}</a></li>
                            </div>

                            {{--CH--}}
                            <div id="CH" class="Languague">
                              <img src="img/SWITSERLAND.png" alt="switserland">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CH</li>
                              <li><a class="#" href="/lang/en_CH">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fr_CH">{{__('frontend.nav.static.language_french')}}</a></li>
                              <li><a class="#" href="/lang/de_CH">{{__('frontend.nav.static.language_german')}}</a></li>
                            </div>

                            {{--TW--}}
                            <div id="TW" class="Languague">
                              <img src="img/TAIWAN.png" alt="taiwan">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">TW</li>
                              <li><a class="#" href="/lang/zh_TW">{{__('frontend.nav.static.language_chinese')}}</a></li>
                            </div>

                            {{--AE--}}
                            <div id="AE" class="Languague">
                              <img src="img/UAE.png" alt="uae">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">AE</li>
                              <li><a class="#" href="/lang/en_AE">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/ar_AE">{{__('frontend.nav.static.language_arabic')}}</a></li>
                            </div>


                          </div>
                        </ul>
                        <!-- </li> -->

                        <!-- <img id="img_01" alt="group57" src="img/Group 57.png" />  -->
                        <!--                     <div>
                      <img id="img_01" class="dropdown-toggle" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" src="img/Group 57.png" alt="group57" />
                      <span id="country-code"></span>
                    </div> -->
                        <!-- <img id="img_01" class="dropdown-toggle" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" src="img/Group 57.png" alt="group57" /> -->
                        <img id="img_01" class="dropdown-toggle" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" src="img/{{$flags}}.png" alt="{{$flags}}" style="border: 1px solid #DCDCDC; " />
                        {{--<div class="dropdown-toggle" id="img_01" data-toggle="dropdown">
                      <img id="selected_country" src="img/{{$flags}}.png" alt="{{$flags}}" style="
                        border: 1px solid #DCDCDC;"/>
                        <span id="selected_country_code"></span>
                        <span id="selected_language"></span>
                    </div>--}}
                    </h4>
                  </div>

                </div>

                <!-- <form action="{{url('/')}}/register" method="POST" id="form"> -->

                @csrf
                {{ html()->form('POST', route('frontend.auth.register.post'))->class('registration_form')->open() }}
                <div class="form-outline input-control mb-4">
                  <!-- {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }} -->
                  <label class="form-label form_label_style" for="email">{{(__('validation.attributes.frontend.email'))}}</label>
                  <!-- <label class="form-label form_label_style" for="email" >Email</label> -->
                  <input type="email" id="email" class="form-control" value="{{old('email')}}" maxlength="191" placeholder="" name="email" onkeyup="validateEmail()" />
                  <div id="email-error" class="error"></div>
                </div>
                @if($errors->has('email'))
                <div class="text-danger">{{ $errors->first('email')}}</div>
                @endif

                <div class="form-outline input-control mb-4">

                  <label id="password" class="form_label_style" for="password">{{__('frontend.index.contact_us.create_password')}}</label>

                  <div class="arrowpopup"><i class="fa fa-info-circle" style="color:black; font-size: 13px;opacity: 0.4;"></i><span id="tooltipdemo" class="pass-tip" style="text-align:left">
                      <p style="padding-left: 3px; color:#fff !important;">{{__('frontend.index.contact_us.password_require')}}</p>
                      <ul style="margin-top:-10px; padding-left: 13px;font-size:12px;">
                        <li>{{__('frontend.index.contact_us.password_require1')}}</li>
                        <li>{{__('frontend.index.contact_us.password_require2')}}</li>
                        <li>{{__('frontend.index.contact_us.password_require3')}}</li>
                        <li>{{__('frontend.index.contact_us.password_require4')}}</li>
                        <li>{{__('frontend.index.contact_us.password_require5')}}</li>
                      </ul>
                    </span></div>
                  <!-- </label> -->
                  <div class="input-group input-control" id="show_hide_password">

                    <input class="form-control" type="password" name="create_password" id="create_pass"
                      value="{{old('create_password')}}" onkeyup="validatePassword()">
                    <div class="error"></div>
                    <span class="password-error" id="password-error"></span>
                    <!-- <span id="create_password" class="text-danger font-weight-bold"></span> -->
                    <div class="input-group-addon" id="input-group-addon">
                      <a href="" class="info_view pass_icons" tabindex="-1"><i class="fa fa-eye-slash" id="eye" aria-hidden="true"></i></a>
                    </div>

                  </div>
                  @if($errors->has('create_password'))
                  <div class="text-danger">{{ $errors->first('create_password')}}</div>
                  @endif

                </div>
                <!-- <div class="toast toast-error" style=""><div class="toast-title">Error</div><div class="toast-message">Invalid email address. Please check the email and try again.</div></div> -->

                <label class="confirm_pass form_label_style" id="confirm_pass1" for="password_confirmation">{{(__('validation.attributes.frontend.password_confirmation'))}}

                </label>

                <div class="input-group confirm_pass" id="show_hide_password1">
                  <input class="form-control" type="password" name="confirm_password" id="confirm_pass"
                    value="{{old('confirm_password')}}" onkeyup="validatePass()">

                  <div class="error"></div>
                  <span class="pass-error" id="pass-error"></span>
                  <div class="input-group-addon" id="input-group-addon">
                    <a href="" class="pass_icons" tabindex="-1"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>

                </div>
                @if($errors->has('confirm_password'))
                <div class="text-danger">{{ $errors->first('confirm_password')}}</div>
                @endif

              </div>



              <div class="form-outline mb-4" id="click" style="margin-top:25px;">

                <!--<a class="text-muted div_m" href="#!" style="float:right;">Forgot password?</a> -->
                <!--<label class="label_text"><input type="checkbox" id="scales" onclick="validateTerm()" name="scales" required title="{{__('frontend.register.static.messages.agree')}}" > <span class="cbox_style" style="padding-left: 10px;"> -->
                <div class="d-flex align-items-start label_text">
                  <label class="">
                  <input type="checkbox" id="scales" name="scales" required title="{{__('frontend.register.static.messages.agree')}}"> 
                </label>   
                  <span class="cbox_style" style="padding-left: 10px; width:95%">
                    {{__('frontend.index.contact_us.consent_1')}}
                    <a href="{{ route('frontend.cms.term_condition') }}" target="_blank"> {{__('frontend.index.contact_us.consent_2')}}</a> &
                    <a href="{{ route('frontend.cms.privacy') }}" target="_blank">{{__('frontend.index.contact_us.consent_3')}}</a>
                  </span>

                </div>
               

                    <span class="" id="term-error"></span>
              </div>



              <div id="commit">
                <!-- <p>SJ Panel is committed to protecting and respecting your privacy, and we’ll only use your personal information to administer your account and to provide the products and services or query you requested from us.</p> -->
                <p>{{__('frontend.index.contact_us.commit_statement')}}</p>
              </div>

              <div class="pt-1 mb-5 pb-1" style="" id="proc">
                <button class="btn-style btn mb-3" id="submit" disabled onclick="return submit()" type="submit" style="">
                  {{__('frontend.index.contact_us.proceed')}}
                </button>

              </div>
              <div style="margin-top: 70px" ;></div>


              <div class="row" id="reg_with" style="margin-top:-61px !important">
                <div class="col-4">
                  <hr id="hr-1" />
                </div>
                <div class="col-4">
                  @if( session()->get('locale') == 'fr_CA')
                  <h2 class="icon_heading_2" style="padding: 5% 0; left:37px !important">{{__('frontend.index.contact_us.register_with')}}</h2>
                  @else
                  <h2 class="icon_heading_2" style="padding: 5% 0; text-align: center;">{{__('frontend.index.contact_us.register_with')}}</h2>
                  @endif
                </div>
                <div class="col-4">
                  <hr id="hr-2" />
                </div>
              </div>


              <div class="row" id="register_with" style=" margin-top: -13px!important; padding:15px">

                <!--           <div class="col-3" id="div_bg">
            <div class="div_bg">
              <a href="{{url('login/google')}}" class="so_sty"> <img src="img/Group 8.png" alt="group8" class="so_style" /></a>
            </div>
          </div>
          <div class="col-3" id="div_bg1">
            <div class="div_bg">
              <a href="{{url('login/facebook')}}" class="so_sty"><img src="img/Group 5.png" alt="group5" class="so_style" /></a>
            </div>
          </div>
          <div class="col-3">
            <div class="div_bg">
              <a href="{{url('login/linkedin')}}" class="so_sty"><img src="img/Group 6.png" alt="group6" class="so_style" /></a>
            </div>
          </div> -->
                <div class="col-lg-3 col-md-3 face-icon">
                  <div class="div_bg">
                    <a href="{{url('login/google')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                      <i class="fab fa-google" aria-hidden="true" style="font-size:14px;margin-left: -17px;"></i> <span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                        Google</span>
                    </a>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 div_icons">
                  <div class="div_bg">
                    <a href="{{url('login/facebook')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                      <i class="fab fa-facebook" aria-hidden="true" style="font-size:14px;margin-left: -17px;"></i> <span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                        Facebook</span>
                    </a>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 div_icons">
                  <div class="div_bg">
                    <a href="{{url('login/linkedin')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                      <i class="fab fa-linkedin" aria-hidden="true" style="font-size:14px;margin-left: -17px;"></i> <span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                        Linkedin</span>
                    </a>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 div_icons">
                  <div class="div_bg">
                    <a href="{{url('login/twitter')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                      <img src="images/Twitter-X-icon.webp" alt="real paying survey sites" class="img-fluid" style="width: 15px; height: 12px; transform: translateX(-7px); filter: brightness(0);"><span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                        Twitter</span>
                    </a>
                  </div>
                </div>
              </div>
              {{ html()->form()->close() }}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
</section>
</div>
<section class="mobile-pd">
  <div class="container">

    <hr>
    <div class="row mt-5">

      <div class="col-12 text-center mb-3">

        <h3 class="fw-bold">{{__('frontend.index.register_bottom_sec.h_1')}}</h5>

          <p>{{__('frontend.index.register_bottom_sec.p_1')}}</p>

      </div>

      <div class="col-12 col-lg-6 text-center p-0 border_right">

        <ul style="list-style-type: none;" class="p-0 m-0">

          <li class="bottom-feat-li p-4" style="border-bottom:2px solid black;">
            <p class="lead mb-2 fw-bold">{{__('frontend.index.register_bottom_sec.h_2')}}</p>
            <p>{{__('frontend.index.register_bottom_sec.p_2')}}</p>
          </li>

          <li class="bottom-feat-li p-4">
            <p class="lead mb-2 fw-bold">{{__('frontend.index.register_bottom_sec.h_3')}}</p>
            <p>{{__('frontend.index.register_bottom_sec.p_3')}}</p>
          </li>

        </ul>

      </div>



      <div class="col-12 col-lg-6 text-center p-0">

        <ul style="list-style-type: none;" class="p-0 m-0">


          <li class="bottom-feat-li p-4" style="border-bottom:2px solid black;">
            <p class="lead mb-2 fw-bold">{{__('frontend.index.register_bottom_sec.h_4')}}</p>
            <p>{{__('frontend.index.register_bottom_sec.p_4')}}</p>
          </li>
          <li class="bottom-feat-li p-4">
            <p class="lead mb-2 fw-bold">{{__('frontend.index.register_bottom_sec.h_5')}}</p>
            <p>{{__('frontend.index.register_bottom_sec.p_5')}}</p>
          </li>

        </ul>

      </div>




      <div class="col-12 mt-3 text-center">

        <ul style="list-style-type: none;">

          <li>
            <p class="lead text-black mt-2">{{__('frontend.index.register_bottom_sec.h_6')}}
            </p>
          </li>

        </ul>

      </div>

      <div class="col-12 text-center">

        <button type="button" class="btn btn-primary rg-sgn-up" style="border-radius:10px; background-color:#0d6efd;">{{__('frontend.index.how_it_works.title_action')}}</button>

      </div>


    </div>

  </div>
</section>
<footer class="footer_style" style="background:#E6E6E6;">
  <div class="container">
    <div class="row text-center">
      <div class="pull-left col-lg-6 col-xs-12 d-none d-md-block " style="text-align:start !important">
        <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj',['year' => date('Y')])}}</a></p>
      </div>
      <div class="col-lg-6 col-lg-offset-4 col-xs-12">
        <div class="pull_right_style">
          <p style="padding-right: 2px;">
            <a href="{{ route('frontend.cms.privacy') }}" class="policies" style="color: black;">{{__('frontend.index.contact_us.consent_3')}}</a> <span class=""> | </span>
            <a href="{{ route('frontend.cms.cookie') }}" class="" style="color: black;">{{__('frontend.index.footer.links.cookie_policy')}}</a> <span class=""> | </span>
            <a href="{{ route('frontend.cms.rewards_policy') }}" class=" pol" style="color: black;">{{__('frontend.index.footer.links.reward_policy')}}</a> <span cl
              class=" pol"> | </span>
            <a href="{{ route('frontend.cms.referral_policy') }}" class=" pol" style="color: black;">{{__('frontend.index.footer.links.referral_policy')}}</a> <span cl
              class=" pol"> | </span>
            <a href="{{ route('frontend.cms.safeguard') }}" class="Policy" style="color: black;">{{__('frontend.index.footer.links.Safeguards')}}</a> <span cl
              class="policy"> | </span>
            <a href="{{ route('frontend.cms.term_condition') }}" style="color: black;" class="terms policy">
              {{__('frontend.index.footer.links.term_condition')}}</a> <span cl
              class="policy"> | </span>
            <a href="{{ route('frontend.cms.faq') }}" style="color: black;" class="policy">{{__('frontend.index.footer.links.FAQ')}}</a>
          </p>
        </div>
      </div>
      <div class="pull-left col-lg-6 col-xs-12 d-sm-none mt-3">
        <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj',['year' => date('Y')])}}</a></p>
      </div>
    </div>
  </div>
</footer>



@php
if($country_code=='UK'){
$countryCode="GB";
}else{
$countryCode=$country_code;
}
@endphp

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

  /*.form-control:required:valid + .form-control-placeholder, .form-control:optional:not([value=""]):not(:focus) + .form-control-placeholder, */
  .form-control:focus+.form-control-placeholder,
  .form-control+.form-control-placeholder {
    font-size: 75%;
    transform: translate3d(0, -100%, 0);
    opacity: 1;
  }


  .emsg {
    border: 1px solid red;
  }

  .toast toast-error {
    background-color: Red !important;
    color: #000;
  }
</style>
@endpush
@push('after-scripts')
@if (config('access.captcha.registration'))
{!! Captcha::script() !!}
@endif
<script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v6.0.5.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{asset('vendor/js/plugins/fullcalendar/moment.min.js')}}"></script>
<!-- Data picker -->
<script src="{{asset('vendor/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/b9bdbd120a.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->

<script src="https://unpkg.com/metismenu"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
  document.querySelector('.rg-sgn-up').addEventListener('click', () => {
    window.scrollTo(0, 0);
  });
  $(document).on('mouseover', '.arrowpopup', function() {
    var tt = document.getElementById("tooltipdemo");

  });
  $(".arrowpopup").hover(
    function() {


      $("#tooltipdemo").show();
    },
    function() {

      $("#tooltipdemo").hide();

    }
  );



  fetchLanguage('{{$country_code}}')
  var emailError = document.getElementById('email-error');
  var passwordError = document.getElementById('password-error');
  var confirmError = document.getElementById('pass-error');
  var termError = document.getElementById('term-error');

  function validateEmail() {
    // alert("hello");
    var email = document.getElementById('email').value;
    if (email.length == 0) {
      emailError.innerHTML = "{{ __('validation.attributes.frontend.email_require') }}";
      return false;
    }
    if (!email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
      emailError.innerHTML = "{{__('validation.attributes.frontend.email_valid')}}";
      return false;
    }
    emailError.innerHTML = '';
    return true;
  }

  function validatePassword() {
    // alert("hello");
    var password = document.getElementById('create_pass').value;
    // alert(password.length);
    if (password.length == 0) {
      passwordError.innerHTML = "{{ __('validation.attributes.frontend.password_req') }}";
      return false;
    }
    if (!password.match(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/)) {
      passwordError.innerHTML = "{{ __('validation.attributes.frontend.password_valid') }}";
      return false;
    }
    if (password.length < 8) {
      passwordError.innerHTML = "{{ __('validation.attributes.frontend.password_valid1') }}";
      return false;
    }
    if (password.length > 20) {
      passwordError.innerHTML = "{{__('validation.attributes.frontend.password_valid2')}}";
      return false;
    }
      if (/\s/.test(password)) {
    passwordError.innerHTML = "{{ __('validation.attributes.frontend.password_no_space') }}";
    return false;
  }
    passwordError.innerHTML = '';
    return true;
  }

  function validatePass() {
    //alert("retype-password");
    var password = document.getElementById('create_pass').value;
    var cpassword = document.getElementById('confirm_pass').value;
    if (cpassword.length == 0) {
      confirmError.innerHTML = "{{ __('validation.attributes.frontend.confirm_pass1') }}";
      return false;
    }
    if (/\s/.test(cpassword)) {
    confirmError.innerHTML = "{{ __('validation.attributes.frontend.password_no_space') }}";
    return false;
    }
    if (cpassword !== password) {
      confirmError.innerHTML = "{{ __('validation.attributes.frontend.confirm_pass2') }}";
      return false;
    }
    confirmError.innerHTML = '';
    return true;
  }


  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('create_pass');
  const confirmPasswordInput = document.getElementById('confirm_pass');
  const termsInput = document.getElementById('scales');
  // termsInput.setCustomValidity("{!!__('frontend.register.static.messages.agree')!!}");
  const submitButton = document.getElementById('submit');
  //emailInput.addEventListener('input', validateForm);
  //passwordInput.addEventListener('input', validateForm);
  confirmPasswordInput.addEventListener('input', validateForm);
  termsInput.addEventListener('change', validateForm);


  function validateForm() {
    // if(!passwordInput.value.includes(confirmPasswordInput.value){
    //   alert("passowrd and confirm pssword are not same");
    // }
    // alert("disable");
    if (!validateEmail() || !validatePassword() || !validatePass() || !termsInput.checked) {
      submitButton.disabled = true;
      submitButton.style.background = "#DCDCDC";
      submitButton.style.color = "#757575";
      return false;
    } else {
      submitButton.style.background = "#006BDE";
      submitButton.style.color = "white";
      submitButton.disabled = false;
    }
  }



  $('select#country').on('change', function(e) {
    var country_code = $('select#country').val();
    fetchLanguage(country_code)
  });

  function fetchLanguage(country_code) {
    var countryName = {};
    countryName['US'] = 'USA.png';
    countryName['CA'] = 'CANADA.png';
    countryName['AU'] = 'AUSTRALIA.png';
    countryName['ES'] = 'SPAIN.png';
    countryName['DE'] = 'GERMANY.png';
    countryName['GB'] = 'UNITED KINGDOM.png';
    countryName['IN'] = 'INDIA.png';
    countryName['FR'] = 'FRANCE.png';
    countryName['IT'] = 'ITALY.png';

    $("#" + country_code).show();
    country_flag = countryName[country_code];
    //$('#img_01').attr('src','img/'+country_flag);

    var header = {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
    if (!country_code || country_code == 0) {
      return false;
    }
    axios.get("{{route('frontend.auth.language')}}", {
      params: {
        country_code: country_code,
      }
    }).then(function(response) {
      if (response.status === 200) {
        $select = $('#language');
        $select.find('option').remove();
        var lang = response.data;
        $.each(lang, function(value, name) {
          $select.append($('<option />', {
            value: value,
            text: name
          }));
        });
      }
    }).catch(function(error) {
      // handle error
    }).then(function() {
      // always executed
      console.log('always executed');
    });
  }



  function changeImage(clickedImage, data, img) {
    return false;
    var targetImage = document.getElementById("img_01");
    var selectImage = document.getElementById("selected_country");
    // selectImage.src = img;
    targetImage.src = img;
    targetImage.textContent = data;
    selectImage.src = img;
    targetImage.src = img;
    // document.getElementById("country-code").value = data;
    // document.getElementById("country-code").textContent = data;



    console.log(clickedImage);
    console.log(data);
    console.log(img);
  }



  $(document).ready(function() {
    $("#show_hide_password1 a").on('click', function(event) {
      event.preventDefault();
      if ($('#show_hide_password1 input').attr("type") == "text") {
        $('#show_hide_password1 input').attr('type', 'password');
        $('#show_hide_password1 svg').addClass("fa-eye-slash");
        $('#show_hide_password1 svg').removeClass("fa-eye");
      } else if ($('#show_hide_password1 input').attr("type") == "password") {
        $('#show_hide_password1 input').attr('type', 'text');
        $('#show_hide_password1 svg').removeClass("fa-eye-slash");
        $('#show_hide_password1 svg').addClass("fa-eye");
      }
    });
    $("#show_hide_password a").on('click', function(event) {
      event.preventDefault();
      if ($('#show_hide_password input').attr("type") == "text") {
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password svg').addClass("fa-eye-slash");
        $('#show_hide_password svg').removeClass("fa-eye");
      } else if ($('#show_hide_password input').attr("type") == "password") {
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password svg').removeClass("fa-eye-slash");
        $('#show_hide_password svg').addClass("fa-eye");
      }
    });
  });
</script>

<script>
  $(document).on('click', ".toggle-password", function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  $(document).on('click', ".toggle-password-confirm", function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  $(document).ready(function() {


    var country_code = $('select#country').val();

    var flag = 0;
    var msg = '';
    $('.registration_form .form-control').blur(function() {


      var info = $(this).val();
      var id = $(this).attr('id');
      console.log(id);

      if (id == 'email') {
        console.log(id);

        var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;

        if (re.test(info)) {
          var header = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }
          axios.get("{{route('frontend.auth.validateEmail')}}", {
            params: {
              email: info,
            }
          }).then(function(response) {
            console.log(response.data);
            //console.log('response=='+JSON.stringify(response));
            if (response.status == 200) {
              if (response.data > 0) {
                console.log('case-2');
                if (response.data == '2') {
                  setTimeout(function() {
                    toastr.error("{{__('frontend.index.contact_us.toastr_1')}}", "{{__('frontend.index.contact_us.error')}}");
                  }, 400);
                } else if (response.data == 1) {
                  setTimeout(function() {
                    toastr.error("{{__('frontend.index.contact_us.toastr_2')}}", "{{__('frontend.index.contact_us.error')}}");
                  }, 400);
                }
                msg += "{{__('frontend.index.contact_us.toastr_2')}}\n";
                $('#email').addClass('emsg');
                flag = 1;
              } else {
                flag = 0;
                $('#email').removeClass('emsg');
              }
              var dfiq_check = $("#dfiq_check").val();
              if (flag == 0 && dfiq_check == 1) {
                invokeAPI(info);
              }
            }
          }).catch(function(error) {
            console.log('error occured');
          });
        } else {
          $(this).addClass('emsg');
          flag = 1;
          msg += "{{__('frontend.index.contact_us.toastr_3')}}\n";
        }
      } else if (id == 'password_confirmation') {

        var pass = $("#password").val();
        if (pass != info) {
          // there is a mismatch, hence show the error message
          $(this).addClass('emsg');
          //$(this).show();
          flag = 1;
          msg += "{{__('frontend.index.contact_us.toastr_4')}}\n";
        } else {
          flag = 0;
          $(this).removeClass('emsg');
        }
      }


    });
    // var scaleFlag = false;
    // $(document).on('click', '#scales', function() {
    //     var termError = document.getElementById('term-error');
    //   if ($(this).is(':checked')) {
    //     //termsInput.removeAttribute('required');
    //     $(this).prop("required", false);
    //     termsInput.setCustomValidity("");
    //     termError.innerHTML = "";
    //     scaleFlag = true;
    //   } else {
    //     //termsInput.setAttribute('required');
    //     $(this).prop("required", true);
    //     scaleFlag = false;
    //     termError.innerHTML = "{{__('frontend.register.static.messages.agree')}}";
    //   }
    // })

    $('.registration_form').on('submit', function(e) {
      var termsInput = document.getElementById('scales');
      var termError = document.getElementById('term-error');
      termError.innerHTML = '';

      if (!termsInput.checked) {
        e.preventDefault();
        termError.innerHTML = "{{ __('frontend.register.static.messages.agree') }}";
        return false;
      }
      if (flag || $('.emsg').length > 0) {
        e.preventDefault();
        return false;
      }

      return true;
    });


    fetchLanguage(country_code);
    /*$("#password").password('toggle');*/

    $('a.socialite').click(function(e) {
      e.preventDefault();
      $('#myModal').modal('toggle');
      window.location.hash = $(this).attr('data-action');
    });


    $('.register_button').click(function(e) {

      var type = window.location.hash.substr(1);
      console.log('type');

      if (!type || type === 'register_form') {
        var form = jQuery(document).find('.registration_form');
        //jQuery('.registration_form').submit();
        console.log(form);
        form.submit();
        return false;
      }

      var socialAnchor = $('div.social_container').find("a[data-action='" + type + "']");
      if (socialAnchor) {
        window.location.href = socialAnchor.attr('href');
      } else {
        console.log('popup error occured');
      }


    })
  });



  // animater images


  var all_icon_childs = document.querySelectorAll('.child');
  // var all_texts_img = document.querySelectorAll('.img-text');

  var count_childs = all_icon_childs.length;

  var temp = 0;

  var img_texts = [
    '{{ __("frontend.index.register_new.img_text_1") }}',
    '{{ __("frontend.index.register_new.img_text_2") }}',
    '{{ __("frontend.index.register_new.img_text_3") }}',
    '{{ __("frontend.index.register_new.img_text_4") }}',
    '{{ __("frontend.index.register_new.img_text_5") }}'
  ];

  // var img_subtexts = ['Your Opinion Matters. Join us for free to share your opinion and influence future products & services.','Update your profile to get relevant surveys as per your area of interest.','Participate in live surveys and share your opinions to earn points.','Redeem your points on a click of a button with our hassle-free redemption policy. ','Introduce your friends to SJ Panel and reap the benefits of earning rewards through our referral program.'];


  setTimeout(animatorImage, 1000);

  function animatorImage() {
    // child_active.classList.add('child-active');

    if (temp != 0 || temp == count_childs) {
      all_icon_childs[temp - 1].classList.remove('child-active');
      // all_texts_img[temp-1].classList.remove('img-text-active');
    }

    if (temp != count_childs) {

      all_icon_childs[temp].classList.add('child-active');
      // all_texts_img[temp].classList.add('img-text-active');
      document.querySelector('#heading-img-text').innerText = img_texts[temp];
      // document.querySelector('#heading-img-subtext').innerText = img_subtexts[temp];

    }

    temp++;

    if (temp < count_childs) {

      setTimeout(animatorImage, 3000);

    } else if (temp == count_childs) {

      setTimeout(animatorImage, 3000);

    } else {

      temp = 0;
      // all_icon_childs[count_childs-1].classList.remove('child-active');
      setTimeout(animatorImage, 100);

    }

  }

  $(document).ready(function() {
    $('#error-message').delay(3000).fadeOut(); // Fades out after 5 seconds (adjust as needed)
  });

  function submit() {
    $('.registration_form').submit();
  }
</script>

@endpush