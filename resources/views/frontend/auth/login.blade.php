@extends('frontend.layouts.app')


@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))
@push('after-styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"
  rel="stylesheet" type='text/css'>

<link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
<link href="{{asset('css2/style.css')}}" rel="stylesheet">
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

  .toast-success {
    background-color: #51A351 !important; /* default green */
    color: #fff !important;
}
  .gradient-custom-2 {
    /* fallback for old browsers */
    background: #006BDE;
    display: grid !important;
    border-radius: 0px 0px 0px 0px;

  }

  .Languague {
    display: none;
    background: white;
    border-radius: 5px;
    box-shadow: 2px 2px 10px;
  }

  .all_language_list .Languague img {
    position: absolute;
    left: 17px;
    height: 17px;
    top: 6px;
  }

  .all_language_list .Languague .dropdown-header {
    position: relative;
    right: 8px;
    top: 4px;
  }

  .toast-error {
    background-color: red !important;
    font-size: 12px;
  }

  #contain-div-1 {
    border-radius: 10px 0px 0px 10px;
  }

  .log-submit:hover {
    color: white;
  }

  .modal-paragraph {
    font-size: large;
  }

  .swal2-container.swal2-center.swal2-backdrop-show {
    z-index: 9999 !important;
  }

  #twitter_but {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* --- commented by Himanshu 20-06-2025 */
  /* @media (min-width: 220px) and (max-width: 767px) {
    .div_m .icon_heading {
        color: black;
    }
  } */

  /* Hiamnshu code start 20-06-2025 */
  @media (max-width: 981px) {
    .gradient-custom-2 {
      border-radius: 10px;
    }
  }

  /* Hiamnshu code end 20-06-2025 */

  @media (min-width: 768px) and (max-width: 981px) {
    .footer_style {
      margin-top: 0px;
    }

    .input-group-addon {
      padding-right: 26px !important;
    }
  }

  @media(min-width: 370px) and (max-width:376px) {
    .footer_style p {
      padding-right: 0px !important;
    }

    .footer_style .vcenter .copyright {
      padding-left: 11% !important;
    }

    .input-group-addon {
      padding-right: 26px !important;
    }
  }
</style>
@endpush

@section('content')
<div id="container"><!-- main container starts-->
  <div id="wrapp"><!-- main wrapp starts-->
    <nav class="navbar navbar-expand-lg navbar-dark  static-top">
      <div class="container Nav-div">
        <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
          <img src="images/SJ Panel New LOGO without background.png" alt="best survey platforms" class="img-fluid">
        </a>
        <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button> -->

        <span class="navbar-brand-2 " id="span-1"><span class="already">{{__('frontend.index.contact_us.not_register')}}</span> <a href="{{url('/')}}/register" style="color: #006BDE;">
            {{__('frontend.index.how_it_works.title_action')}}
          </a></span>
      </div>
    </nav><!-- header ends-->

  </div>
</div>

<div id="line"></div>


<div class="container" style="margin-bottom: 10px;">
  <section class="gradient-form">
    <div class="container py-5" id="card">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xl-12">
          <div class="card rounded-3 text-black">
            <div class="row g-0" width="25px">

              <div class="col-lg-6  align-items-center gradient-custom-2">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <img src="img/login_user.png" alt="online survey companies that pay well" class="image_center" />
                  <h4 class="mb-4 text_margin_style">{{__('frontend.index.contact_us.opinion')}}</h4>
                  <p class="small mb-0 p_open">{{__('frontend.index.contact_us.join')}}<br />
                    {{__('frontend.index.contact_us.join_1')}}
                  </p>
                  <div class="row div_m">
                    <div class="col-3 img-1">
                      <div class="icon_style">
                        <img src="img/Vector.png" class="icon_padding_style " alt="best survey sites for earning" style="padding-top: 10px;" />
                      </div>
                      <h2 class="icon_heading sign">{{__('frontend.index.contact_us.signup_for')}}</h2>
                    </div>

                    <div class="col-3 border-center img-2">
                      <div class="icon_style"><img src="img/Group.png" class="icon_padding_style" alt="legit surveys to earn money" style="padding-left: 14px;" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.how_it_works.title_subhead_4')}}</h2>
                    </div>
                    <div class="col-3 border-center2 img-3">
                      <div class="icon_style"><img src="img/Group 70.png" class="icon_padding_style" alt="get paid for surveys" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.take_survey')}}</h2>
                    </div>
                    <div class="col-3 border-center3 re-image">
                      <div class="icon_style"><img src="img/Vector-1.png" class="icon_padding_style" style="padding-left: 12px;" alt="surveys that give you money" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.redeem_rewards')}} </h2>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 div_m_t" style="">
                <div class="card-body p-md-5 mx-md-4">
                  <div class="row" id="div_mt">
                    <div class=" col-lg-9">
                      <h1 class="mt-1 Register_text_style regi" id="register" style="font-weight: 700;">{{__('frontend.modes.email_auth.button')}}</h1>
                    </div>
                    <div class="col-lg-3">
                      <h4 class="mt-1 Register_text_style regis">


                        <ul class="dropdown-menu dropdown-menu-right all_language_list" aria-labelledby="language-button" style="min-width:50px;width: 95px;margin-top: -9px;/*height: 91px;*/margin-left: 14px; @if ($country_code == 'GB') display: none; @endif">
                          <li class="dropdown-header" style="display:none !important">
                            @if(!empty($country_code)) {{--$country_code->display_name--}}{{$country_code}} - EN (Selected) @endif
                          </li>
                          <div class="" style=" text-transform: uppercase;">
                            {{--US--}}
                            {{-- <li role="separator" class="divider"></li> --}}
                            {{--
                                <li class="dropdown-header">{{__('frontend.nav.static.language_1')}}</li>
                            <li><a class="#" href="/lang/en_US">{{__('frontend.nav.static.language_2')}}</a></li>
                            <li><a href="/lang/es_US">{{__('frontend.nav.static.language_3')}}</a></li>
                            --}}
                            <div id="US" class="Languague">
                              <img src="img/USA.png" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )" alt="free money earning survey sites">
                              <li class="dropdown-header">US</li>
                              <li><a class="#" href="/lang/en_US" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">{{__('ENGLISH ')}}</a></li>
                              <li><a href="/lang/es_US" onclick="changeImage(this, 'US-ES' ,'img/USA.png' )">{{__('frontend.nav.static.language_spanish')}} </a></li>
                            </div>

                            {{--CA--}}
                            <div id="CA" class="Languague">
                              <img src="img/CANADA.png" alt="real survey sites that pay money">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CA</li>
                              <li><a class="#" href="/lang/en_CA">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fr_CA">{{__('frontend.nav.static.language_french')}} </a></li>
                            </div>

                            {{--ES--}}
                            <div id="ES" class="Languague">
                              <img src="img/SPAIN.png" alt="earn money filling out surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">ES</li>
                              <li><a class="#" href="/lang/es_ES">{{__('frontend.nav.static.language_spanish')}} </a></li>
                            </div>

                            {{--DE--}}
                            <div id="DE" class="Languague">
                              <img src="img/GERMANY.png" alt="making money filling out surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">DE</li>
                              <li><a class="#" href="/lang/en_DE">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/de_DE">{{__('frontend.nav.static.language_german')}} </a></li>
                            </div>

                            {{--AU--}}
                            <div id="AU" class="Languague">
                              <img src="img/AUSTRALIA.png" alt="online surveys that pay you">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">AU</li>
                              <li><a class="#" href="/lang/en_AU">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--UK--}}
                            <div id="UK" class="Languague">
                              <img src="img/UNITED_KINGDOM.png" alt="fill out surveys to make money">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">UK</li>
                              <li><a class="#" href="/lang/en_UK">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--FR--}}
                            <div id="FR" class="Languague">
                              <img src="img/FRANCE.png" alt="get survey and earn money">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">FR</li>
                              <li><a class="#" href="/lang/en_FR">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fr_FR">{{__('frontend.nav.static.language_french')}} </a></li>
                            </div>

                            {{--IT--}}
                            <div id="IT" class="Languague">
                              <img src="img/ITALY.png" alt="earn by survey online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">IT</li>
                              <li><a class="#" href="/lang/it_IT">{{__('frontend.nav.static.language_italian')}} </a></li>
                            </div>

                            {{--IN--}}
                            <div id="IN" class="Languague">
                              <img src="img/INDIA.png" alt="websites that pay you for surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">IN</li>
                              <li><a class="#" href="/lang/en_IN">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/hi_IN">{{__('frontend.nav.static.language_hindi')}} </a></li>
                            </div>


                            {{--CN--}}
                            <div id="CN" class="Languague">
                              <img src="img/CHINA.png" alt="sites that pay you for surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CN</li>
                              <li><a class="#" href="/lang/en_CN">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/zh_CN">{{__('frontend.nav.static.language_chinese')}} </a></li>
                            </div>

                            <!-- new -->

                            {{--AR--}}
                            <div id="AR" class="Languague">
                              <img src="img/ARGENTINA.png" alt="take survey and earn">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">AR</li>
                              <li><a class="#" href="/lang/en_AR">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/es_AR">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>

                            {{--BE--}}
                            <div id="BE" class="Languague">
                              <img src="img/BELGIUM.png" alt="earn by filling surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">BE</li>
                              <li><a class="#" href="/lang/fr_BE">{{__('frontend.nav.static.language_french')}}</a></li>
                              <li><a class="#" href="/lang/nl_BE">{{__('frontend.nav.static.language_dutch')}}</a></li>
                              <li><a class="#" href="/lang/de_BE">{{__('frontend.nav.static.language_german')}}</a></li>
                            </div>

                            {{--BR--}}
                            <div id="BR" class="Languague">
                              <img src="img/BRAZIL.png" alt="easy surveys for money">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">BR</li>
                              <li><a class="#" href="/lang/pt_BR">{{__('frontend.nav.static.language_portuguese')}}</a></li>
                            </div>

                            {{--CL--}}
                            <div id="CL" class="Languague">
                              <img src="img/CHILE.png" alt="easy cash surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CL</li>
                              <li><a class="#" href="/lang/es_CL">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>

                            {{--CO--}}
                            <div id="CO" class="Languague">
                              <img src="img/COLOMBIA.png" alt="earn money doing surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CO</li>
                              <li><a class="#" href="/lang/es_CO">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>


                            {{--DK--}}
                            <div id="DK" class="Languague">
                              <img src="img/DENMARK.png" alt="making money doing surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">DK</li>
                              <li><a class="#" href="/lang/en_DK">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/de_DK">{{__('frontend.nav.static.language_german')}}</a></li>
                              <li><a class="#" href="/lang/da_DK">{{__('frontend.nav.static.language_danish')}}</a></li>
                            </div>

                            {{--EG--}}
                            <div id="EG" class="Languague">
                              <img src="img/EGYPT.png" alt="get money doing surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">EG</li>
                              <li><a class="#" href="/lang/en_EG">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/ar_EG">{{__('frontend.nav.static.language_arabic')}}</a></li>
                            </div>

                            {{--HK--}}
                            <div id="HK" class="Languague">
                              <img src="img/HONG KONG.png" alt="making money taking online surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">HK</li>
                              <li><a class="#" href="/lang/en_HK">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/zh_HK">{{__('frontend.nav.static.language_chinese')}}</a></li>
                            </div>

                            {{--ID--}}
                            <div id="ID" class="Languague">
                              <img src="img/INDONESIA.png" alt="get paid to fill in surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">ID</li>
                              <li><a class="#" href="/lang/en_ID">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/id_ID">{{__('frontend.nav.static.language_indonesian')}}</a></li>
                            </div>

                            {{--JP--}}
                            <div id="JP" class="Languague">
                              <img src="img/JAPAN.png" alt="earn cash doing surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">JP</li>
                              <li><a class="#" href="/lang/jp_JP">{{__('frontend.nav.static.language_japanese')}}</a></li>
                            </div>

                            {{--KW--}}
                            <div id="KW" class="Languague">
                              <img src="img/KWAIT.png" alt="earn money completing surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">KW</li>
                              <li><a class="#" href="/lang/ar_KW">{{__('frontend.nav.static.language_arabic')}}</a></li>
                            </div>


                            {{--MY--}}
                            <div id="MY" class="Languague">
                              <img src="img/MALAYSIA.png" alt="paid surveys online legit">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">MY</li>
                              <li><a class="#" href="/lang/zh_MY">{{__('frontend.nav.static.language_chinese')}}</a></li>
                              <li><a class="#" href="/lang/ms_MY">{{__('frontend.nav.static.language_malay')}}</a></li>
                              <li><a class="#" href="/lang/en_MY">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--MX--}}
                            <div id="MX" class="Languague">
                              <img src="img/MEXICO.png" alt="legitimate paid online surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">MX</li>
                              <li><a class="#" href="/lang/es_MX">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>


                            {{--NL--}}
                            <div id="NL" class="Languague">
                              <img src="img/NETHERLANDS.png" alt="get paid to do surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">NL</li>
                              <li><a class="#" href="/lang/en_NL">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/nl_NL">{{__('frontend.nav.static.language_dutch')}}</a></li>
                            </div>

                            {{--NO--}}
                            <div id="NO" class="Languague">
                              <img src="img/NORWAY.png" alt="get paid to take surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">NO</li>
                              <li><a class="#" href="/lang/en_NO">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/no_NO">NORWEGIAN</a></li>
                              <li><a class="#" href="/lang/de_NO">{{__('frontend.nav.static.language_german')}}</a></li>
                            </div>

                            {{--PE--}}
                            <div id="PE" class="Languague">
                              <img src="img/PERU.png" alt="online surveys that pay instantly">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">PE</li>
                              <li><a class="#" href="/lang/es_PE">{{__('frontend.nav.static.language_spanish')}}</a></li>
                            </div>

                            {{--PH--}}
                            <div id="PH" class="Languague" style="width:140%">
                              <img src="img/PHILIPPINES.png" alt="online surveys and get paid">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">PH</li>
                              <li><a class="#" href="/lang/en_PH">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fp_PH">FILIPINO/TAGALOG</a></li>
                            </div>

                            {{--PL--}}
                            <div id="PL" class="Languague">
                              <img src="img/POLAND.png" alt="real online surveys for money">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">PL</li>
                              <li><a class="#" href="/lang/pl_PL">{{__('frontend.nav.static.language_polish')}}</a></li>
                            </div>


                            {{--RU--}}
                            <div id="RU" class="Languague">
                              <img src="img/RUSSIA.png" alt="real cash surveys online">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">RU</li>
                              <li><a class="#" href="/lang/en_RU">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/ru_RU">{{__('frontend.nav.static.language_russian')}}</a></li>
                            </div>

                            {{--SG--}}
                            <div id="SG" class="Languague">
                              <img src="img/SINGAPORE.png" alt="money through surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">SG</li>
                              <li><a class="#" href="/lang/zh_SG">{{__('frontend.nav.static.language_chinese')}}</a></li>
                              <li><a class="#" href="/lang/en_SG">{{__('ENGLISH ')}}</a></li>
                            </div>

                            {{--SE--}}
                            <div id="SE" class="Languague">
                              <img src="img/SWEDEN.png" alt="answer surveys and earn">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">SE</li>
                              <li><a class="#" href="/lang/sv_SE">{{__('frontend.nav.static.language_swedish')}}</a></li>
                            </div>

                            {{--CH--}}
                            <div id="CH" class="Languague">
                              <img src="img/SWITSERLAND.png" alt="get paid for answering surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">CH</li>
                              <li><a class="#" href="/lang/en_CH">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/fr_CH">{{__('frontend.nav.static.language_french')}}</a></li>
                              <li><a class="#" href="/lang/de_CH">{{__('frontend.nav.static.language_german')}}</a></li>
                            </div>

                            {{--TW--}}
                            <div id="TW" class="Languague">
                              <img src="img/TAIWAN.png" alt="answer surveys and get paid">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">TW</li>
                              <li><a class="#" href="/lang/zh_TW">{{__('frontend.nav.static.language_chinese')}}</a></li>
                            </div>

                            {{--AE--}}
                            <div id="AE" class="Languague">
                              <img src="img/UAE.png" alt="earn by taking surveys">
                              <!-- <li role="separator" class="divider"></li> -->
                              <li class="dropdown-header">AE</li>
                              <li><a class="#" href="/lang/en_AE">{{__('ENGLISH ')}}</a></li>
                              <li><a class="#" href="/lang/ar_AE">{{__('frontend.nav.static.language_arabic')}}</a></li>
                            </div>

                          </div>
                        </ul>

                        <!-- <img id="img_01" src="img/Group 57.png" /> -->
                        <img id="img_01" class="dropdown-toggle" alt="trusted survey sites" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" src="img/{{$flags}}.png" style="border: 1px solid #DCDCDC;cursor: pointer; " />


                        {{--<div class="dropdown-toggle" id="img_01" data-toggle="dropdown" style="cursor:pointer;">
                      <img id="selected_country" src="img/{{$flags}}.png" alt="trustworthy survey sites" style="border: 1px solid #DCDCDC;cursor: pointer; "/>
                        <span id="selected_country_code"></span>
                        <span id="selected_language"></span>
                    </div>--}}
                    </h4>
                  </div>
                </div>

                @if($prompt)
                <form action="{{route('frontend.auth.login.post',['prompt_id'=>true])}}" method="POST">
                  @else
                  <form action="{{url('/')}}/login" method="POST">
                    @endif

                    @csrf
                    <input type="hidden" id="requestid" name="rid" value="{{$uuid}}" />
                    <input type="hidden" id="eventid" name="eid" value="{{$ip}}" />
                    <input type="hidden" id="cc" value="{{$country_code}}" />
                    <input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}">
                    <div class="form-outline mb-4">
                      <label class="form-label form_label_style" for="form2Example11" id="email">{{(__('validation.attributes.frontend.email'))}}</label>
                      <input type="email" id="form2Example11" class="form-control"
                        placeholder="" name="email" @if(Cookie::has('email')) value="{{Cookie::get('email')}}" @endif onkeyup="validateEmail()" required />
                      <span id="email-error" class="error"></span>
                    </div>
                    <div class="form-outline mb-4">
                      <label id="password" class="form_label_style">{{(__('validation.attributes.frontend.password'))}}</label>
                      <div class="input-group" id="show_hide_password">
                        <input class="form-control" type="password" name="password" @if(Cookie::has('password')) value="{{Cookie::get('password')}}" @endif onkeyup="validatePassword()" id="create_pass" required>
                        <div class="input-group-addon" style="padding-right:12px;">
                          <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                      </div>
                      <!--                       @if($errors->has('email'))
                      <div class="text-danger">{{ $errors->first('email')}}</div>
                      @endif   -->
                      <!--                       @if($errors->has('email'))
                      <div id="toast-container" class="toast-top-right" aria-live="polite" role="alert" >
                      <div class="toast toast-error" style="background-color: red !important;">
                      <button type="button" class="toast-close-button" onclick="myFun()" id="toast_div">×</button>
                      <div class="toast-title" style="font-size:13px">Error</div>
                      <div class="toast-message" style="font-size:12px">{{ $errors->first('email')}}</div>
                      </div>
                      </div>
                      @endif   -->
                      <span class="password-error" id="password-error"></span>
                    </div>
                    <div class="form-outline mb-4">
                      <!--<a class="text-muted div_m" href="#!" style="float:right;">Forgot password?</a> -->
                      <div class="row">
                        <div class="col-6 remember" style="cursor: pointer;">
                          <label class="label_text"><input type="checkbox" class="rem-label" name="remember" style="cursor:pointer;"> <span class="cbox_style" style="float:none;cursor: pointer;">{{__('frontend.index.contact_us.remember')}}</span></label>
                        </div>
                        <div class="col-6" id="forgot">
                          <a href="{{ route('frontend.auth.password.reset') }}" style="float:right; font-size:13px; text-decoration:none">{{__('frontend.index.contact_us.forgot_pass')}}</a>
                          <!--<label class="label_text" style="float:right"> <span class="cbox_style" style="float:none">Remember Me</span></label> -->
                        </div>
                      </div>
                    </div>

                    <div class="pt-1 mb-5 pb-1 log-submit" style="margin-bottom:0px!important;" id="">
                      <button class="btn btn-block fa-lg gradient-custom-lo mb-3" type="submit" style="width:100%;background-color: #DCDCDC;height: 50px;color: #757575;" id="submit" onclick="return submit()">
                        <center style="font-size: 16px; " class="log-sub"><span class="login-sub">{{__('frontend.modes.email_auth.button')}}</span> </center>
                      </button>
                    </div>

                    <div class="row register-with" id="reg_with">
                      <div class="col-4">
                        <hr class="hr-1" id="hr-1" />
                      </div>
                      <div class="col-4" id="registr_with">
                        <h2 class="icon_heading_2" style="padding: 10% 0;">{{__('frontend.index.contact_us.register_with')}}</h2>
                      </div>
                      <div class="col-4">
                        <hr class="hr-2" id="hr-2" />
                      </div>
                    </div>

                    <div class="row" id="register_with">
                      <!--           <div class="col-3" id="div_bg">
            <div class="div_bg">
              <a href="{{url('login/google')}}" class="so_sty"> <img src="img/Group 8.png" class="so_style" /></a>
            </div>
          </div>
          <div class="col-3" id="div_bg1">
            <div class="div_bg">
              <a href="{{url('login/facebook')}}" class="so_sty"><img src="img/Group 5.png" class="so_style" /></a>
            </div>
          </div>
          <div class="col-3">
            <div class="div_bg">
              <a href="{{url('login/linkedin')}}" class="so_sty"><img src="img/Group 6.png" class="so_style" /></a>
            </div>
          </div> -->
                      <div class="col-lg-3 col-md-3" id="face-icon">
                        <div class="div_bg">
                          <a href="{{url('login/google')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                            <i class="fab fa-google" aria-hidden="true" style="font-size:14px;margin-left: -17px;"></i> <span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                              Google</span>
                          </a>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                        <div class="div_bg">
                          <a href="{{url('login/facebook')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                            <i class="fab fa-facebook" aria-hidden="true" style="font-size:14px;margin-left: -17px;"></i> <span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                              Facebook</span>
                          </a>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                        <div class="div_bg">
                          <a href="{{url('login/linkedin')}}" class="so_sty linkedin btn col-sm-12 " id="linkedin_but">
                            <i class="fab fa-linkedin" aria-hidden="true" style="font-size:14px;margin-left: -17px;"></i> <span class="span-twit" style="font-size: 15px;font-weight: 500;margin-top: 18px;margin-left: 4px;">
                              Linkedin</span>
                          </a>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                        <div class="div_bg">
                          <a href="{{url('login/twitter')}}" class="so_sty linkedin btn col-sm-12 " id="twitter_but">
                            <img src="images/Twitter-X-icon.webp" alt="real paying survey sites" class="img-fluid" style="width: 15px; height: 12px; transform: translateX(-4px); filter: brightness(0);"><span class="span-twit" style="font-size: 15px;font-weight: 500;">Twitter</span>
                          </a>
                        </div>
                      </div>
                    </div>

                  </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@if(session('confirmation_pending'))
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-end">
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="img-div mb-3">
          <img src="images/resend-mail.png" alt="Email Icon" style="height: 60px;">
        </div>
        <div class="content m-auto w-100">
          <p class="modal-paragraph">
            {{__('frontend.index.contact_us.resend_mail_text')}}
          </p>
        </div>
        <div class="button-div mt-3">
          <input type="hidden" id="user_id" value="{{session('user_id')}}">
          <button id="resendBtn" type="button" class="btn btn-primary w-50">{{__('frontend.index.contact_us.resend_email')}}</button>
          <p id="countdownText" style="display: none;">{{__('frontend.index.contact_us.resend_in')}} <span id="countdown">20</span> {{__('frontend.index.contact_us.resend_sec')}}</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#exampleModalCenter').modal('show');
  });
</script>
@endif
<div id="message" class="mt-2 text-center"></div>
</section>




</div>

<footer class="footer_style" style="background:#E6E6E6;">
  <div class="container">
    <div class="row text-center">
      <div class="pull-left col-lg-6 col-xs-12 d-none d-md-block " style="text-align:start !important">
        <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj',['year' => date('Y')])}}</a></p>
      </div>
      <div class="col-lg-6 col-lg-offset-4 col-xs-12 col-md-4">
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
  /*        .form-group {
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
        .form-control:valid + .form-control-placeholder, .form-control + .form-control-placeholder {
            font-size: 75%;
            transform: translate3d(0, -100%, 0);
            opacity: 1;
        }
*/
</style>
@endpush
@push('after-scripts')
@if(session('password_updated'))
    <script>
        toastr.success("{{ session('password_updated') }}", "Success", {
            "closeButton": true,
            "progressBar": true
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v6.0.4.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
@if(session('session_expired'))
    <script>
        toastr.error("{{(__('validation.attributes.session_expired'))}}");
    </script>
@endif

<script>
  $(document).ready(function() {

    let countryCode = $('#cc').val();
    $("#" + countryCode).show();

    // $("#show_hide_password1 a").on('click', function(event) {
    //     event.preventDefault();
    //     if($('#show_hide_password1 input').attr("type") == "text"){
    //         $('#show_hide_password1 input').attr('type', 'password');
    //         $('#show_hide_password1 svg').addClass( "fa-eye-slash" );
    //         $('#show_hide_password1 svg').removeClass( "fa-eye" );
    //     }
    //     else if($('#show_hide_password1 input').attr("type") == "password"){
    //         $('#show_hide_password1 input').attr('type', 'text');
    //         $('#show_hide_password1 svg').removeClass( "fa-eye-slash" );
    //         $('#show_hide_password1 svg').addClass( "fa-eye" );
    //     }
    // });
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

  // function myFun() {
  //   document.getElementById("toast-container").style.display = "none";
  // }


  var emailError = document.getElementById('email-error');
  var passwordError = document.getElementById('password-error');
  // var confirmError = document.getElementById('pass-error');
  $("#form2Example11, #create_pass").on("input", validateForm);

  function validateEmail() {
    let email = $("#form2Example11").val().trim();
    let emailError = $("#email-error");

    if (!email) {
      emailError.text("{{(__('validation.attributes.frontend.email_require'))}}");
      return false;
    }
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.match(emailPattern)) {
      emailError.text("{{(__('validation.attributes.frontend.email_valid'))}}");
      return false;
    }
    emailError.text('');
    return true;
  }

  function validatePassword() {
    let password = $("#create_pass").val().trim();
    let passwordError = $("#password-error");

    if (!password) {
      passwordError.text("{{(__('validation.attributes.frontend.password_req'))}}");
      return false;
    }
    if (password.length < 8) {
      passwordError.text("{{(__('validation.attributes.frontend.password_valid1'))}}");
      return false;
    }

    if (password.length > 16) {
      passwordError.text("{{(__('validation.attributes.frontend.password_valid2'))}}");
      return false;
    }
    passwordError.text('');
    return true;
  }


  const emailInput = document.getElementById('form2Example11');
  const passwordInput = document.getElementById('create_pass');
  const submitButton = document.getElementById('submit');

  emailInput.addEventListener('input', validateForm);
  passwordInput.addEventListener('input', validateForm);

  function validateForm() {
    let isValid = validateEmail() && validatePassword();
    let submitButton = $("#submit");

    if (isValid) {
      submitButton.prop("disabled", false).css({
        background: "#006BDE",
        color: "white"
      });
    } else {
      submitButton.prop("disabled", true).css({
        background: "#DCDCDC",
        color: "#757575"
      });
    }
  }

  if ($("#form2Example11").val() !== "") {
    validateForm();
  }



  // emailIn.addEventListener('input', checkForm);
  // passwordIn.addEventListener('input', checkForm);

  // function checkForm(){
  //     if(){

  //     }

  // } 


  // $('select#country').on('change',function(e){
  //     var country_code = $('select#country').val();
  //     fetchLanguage(country_code)
  // });

  // function fetchLanguage(country_code)
  // {
  //    var countryName={};
  //    countryName['US']='USA.png';
  //    countryName['CA']='CANADA.png';
  //    countryName['AU']='AUSTRALIA.png';
  //    countryName['ES']='SPAIN.png';
  //    countryName['DE']='GERMANY.png';
  //    countryName['UK']='UNITED KINGDOM.png';
  //    countryName['IN']='INDIA.png';
  //    countryName['FR']='FRANCE.png';
  //    countryName['IT']='ITALY.png';
  //    countryName['NL']='NETHERLAND.png';


  //    country_flag=countryName[country_code];
  //    //$('#img_01').attr('src','img/'+country_flag);

  //     var header = {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  //     }
  //     if(!country_code || country_code == 0){
  //         return false;
  //     }
  //     axios.get("{{route('frontend.auth.language')}}",{
  //         params:{
  //             country_code: country_code,
  //         }
  //     }).then(function (response) {
  //         if(response.status === 200){
  //             $select = $('#language');
  //             $select.find('option').remove();
  //             var lang = response.data;
  //             $.each(lang, function (value, name) {
  //                 $select.append($('<option />', {value: value, text: name}));
  //             });
  //         }
  //     }).catch(function (error) {
  //         // handle error
  //     }).then(function () {
  //         // always executed
  //         console.log('always executed');
  //     });
  // }


  function changeImage(clickedImage, data) {
    var targetImage = document.getElementById("img_01");
    targetImage.src = clickedImage.src;
    targetImage.textContent = data;
    // count1.src = clickedImage.src;
    // count2.textContent = clickedImage.country_code;
    // count3.textContent = clickedImage.language;
    console.log("image");
    console.log(clickedImage);
  }


  // $(".toggle-password").on("click", function () {
  //     $(this).toggleClass("fa-eye fa-eye-slash");
  //     let input = $($(this).attr("toggle"));
  //     input.attr("type", input.attr("type") === "password" ? "text" : "password");
  // });

  $(document).ready(function() {


    var flag = 0;
    var msg = '';
    $(".login_form .form-control").on("blur", function() {
      let email = $(this).val();
      let id = $(this).attr("id");
      let dfiqCheck = $("#dfiq_check").val();

      if (id === "email" && dfiqCheck == 1) {
        invokeAPI(email);
      }
    });
    /*const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function (e) {
        console.log("click");

    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
})*/
  });

  function invokeAPI(email) {
    let req = $("#requestid").val();
    let event = $("#eventid").val();
    let country = $("#cc").val();
    let utm_source = "SJWLogin";
    let disableOptions = [3];

    let uniquenessParam = Forensic.createUniquenessParam(event, null, false);
    let geoParam = Forensic.createGeoParam(country);

    Forensic.forensic(req, successCallback, errorCallback, uniquenessParam, geoParam, null, disableOptions, utm_source);
  }

  function successCallback(jsonData) {
    console.log(jsonData);

    let email = $("#email").val();
    let ipAddress = $("#eventid").val();
    let panelistId = $("#eventid").val();

    $.ajax({
      url: "{{ route('frontend.auth.register.dfiqData.post') }}",
      type: "GET",
      data: {
        datajsondata: jsonData,
        email: email,
        ip_address: ipAddress,
        panelistId: panelistId,
        user_id: ""
      },
      async: true,
    });

    let isFraud = jsonData.forensic.marker.score > 26 || !jsonData.forensic.unique.isEventUnique;
    let isAnonymous = jsonData.forensic.marker.isAnonymous;

    if (isFraud || isAnonymous) {
      setTimeout(() => {
        toastr.error("{{__('frontend.index.contact_us.toastr_5')}}", "Alert");
      }, 400);
      $(".btn").prop("disabled", true);
    } else {
      $(".btn").prop("disabled", false);
    }
  }

  function errorCallback(jsonData) {
    console.error(jsonData.error.message);
  }
</script>
<script>
  $(document).ready(function() {
    function startResendCountdown() {
      let countdown = 20;
      document.getElementById('resendBtn').disabled = true;
      document.getElementById('countdownText').style.display = 'block';
      const interval = setInterval(() => {
        countdown--;
        document.getElementById('countdown').innerText = countdown;

        if (countdown <= 0) {
          clearInterval(interval);
          document.getElementById('resendBtn').disabled = false;
          document.getElementById('countdownText').style.display = 'none';
        }
      }, 1000);
    }

    $('#resendBtn').click(function() {
      let user_id = $('#user_id').val();
      startResendCountdown();
      $.ajax({
        url: '{{ route("frontend.auth.resend_confirmation_email") }}',
        method: 'GET',
        data: {
          user_id: user_id
        },
        success: function(response) {

          $('#exampleModalCenter').modal('hide');
          Swal.fire({
            icon: 'success',
            title: "{{ __('frontend.index.contact_us.resend_success') }}",
            text: "{{__('frontend.index.contact_us.resend_email_sent')}}",
            confirmButtonText: "{{__('frontend.index.contact_us.swalconfirm')}}",
            customClass: {
              popup: 'custom-swal-popup',
              title: 'custom-swal-title',
              htmlContainer: 'custom-swal-text'
            }
          });

          // $('#message').html(`<span style='color:green;'>${response.message}</span>`);
        },
        error: function(response) {
          Swal.fire({
            icon: 'error',
            title: "{{ __('frontend.index.contact_us.error') }}",
            confirmButtonText: "{{__('frontend.index.contact_us.swalconfirm')}}",
            text: "{{__('frontend.index.contact_us.error_message')}}"
          });
        }
      });
    });
  });
</script>
@endpush