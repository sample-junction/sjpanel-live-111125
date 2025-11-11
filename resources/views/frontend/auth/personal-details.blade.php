@extends('frontend.layouts.app')

{{--@section('title', app_name() . ' | '.__('labels.frontend.auth.register_box_title')) --}}
@section('title','Register to Earn Money Online | Sign Up Now for free to Take Paid Surveys')
@section('meta_description','Sign up to SJ Panel and get the chance to earn money online. Register with us and complete paid surveys to earn money. Get free points for money when you sign up. Register and start making money online today!')
@section('meta_keyword','SJ Panel sign up, sign up for paid surveys, paid surveys sign in, sign up earn money online, register earn money, earn money online sign up, survey panel sign up, sign up for online surveys, sign up and get money, sign up and get free money, sign up and earn money, sign up for free and start earning')

@push('after-styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">


    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"
    rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> -->
    <link href="{{asset('css2/style2.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css')}}" rel="stylesheet">
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
      .Spanish_fontsize{
        padding: 2px !important;
       font-size: 12px !important;
      }
#toast-container{
  display: block;
}
.toast-error{
  background-color: red !important;
  color: #fff !important;
  font-size: 12px !important;
}
.cc-window{
  display: none;
}
.Languague{
  display: none;
  background: white;
    border-radius: 5px;
    box-shadow: 2px 2px 10px;
}

.all_language_list .Languague img{
    position: absolute;
    right: 5px;
    height: 17px;
    top: 8px;
    margin-left: 50px;
}

.all_language_list li {
  text-align:start;
}

.all_language_list li a {
    left: 10px !important;
}

   .gradient-custom-2 {
/* fallback for old browsers */
background: #006BDE;
display: grid !important;

}

#contain-div-1{
  border-radius: 10px 0px 0px 10px;
}
/*#proc .btn{
  background-color: #24a0ed;
  color:white;
  font-size: 16px;
  width: 85%;
  margin-left: 9px;
  margin-top: 45px;
}*/
#proc .btn{
  background-color: #006BDE;
  color:white;
  font-size: 16px;
/*  width: 85%;*/
  margin-left: 9px;
 margin-top: 45px;
}
/*  #datepicker{width:180px;}*/
  #datepicker > span:hover{cursor: pointer;}

 /* @media (min-width: 1340px) and (max-width: 1450px){
#proc .btn {
    width: 100% !important;
} 
} */

  @media (min-width: 220px) and (max-width: 767px) {
    .div_m .icon_heading {
        color: white;
    }
  }

  @media (min-width: 768px) and (max-width: 1200px) {
     #proc .btn {
        width: 100% !important;
        margin-left: 9px!important;
        margin-top: 0px!important;
        position: unset !important;
        top: 0;
      }

      div#proc {
        position: relative;
        display: flex!important;
        flex-direction: column!important;
        align-items: center;
      }
      #proc .icon_heading_3{
        left: unset!important;
        margin-top: unset!important;
        text-align: center;
      }
  }

  @media (max-width: 800px){
    .mobile_back_btn {
      margin-left: 28px;
    }
  }

    </style>

@endpush

@section('content')



  <div id="container"><!-- main container starts-->
    <div id="wrapp"><!-- main wrapp starts-->
        <nav class="navbar navbar-expand-lg navbar-dark  static-top">
          <div class="container Nav-div" >
          <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
              <img src="images/SJ Panel New LOGO without background.png" alt="earn from surveys" class="img-fluid">
            </a>
            <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button> -->
          
            <span class="navbar-brand-2 " id="span-1"><span class="already"> {{__('frontend.index.contact_us.already_account')}}</span> <a href="{{url('/')}}/login" style="color: #006BDE;">
              {{__('frontend.modes.email_auth.button')}}
            </a></span>
          </div>
        </nav><!-- header ends-->
        
    </div>
  </div>

  <div id="line"></div>


  <div class="container" style="margin-bottom: 10px;">
    <section class="h-100 gradient-form">
      <div class="container py-5 h-100" id="card">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-12">
            <div class="card rounded-3 text-black">
              <div class="row g-0" width="25px">
                <!--  remove id="country_name" by himanshu 20-06-2025 -->
                <!-- <div class="col-lg-6  align-items-center gradient-custom-2" id="contain-div-1"> -->
                <div class="col-lg-6  align-items-center gradient-custom-2" id="">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <img src="img/login_user.png" alt="get paid for surveys" class="image_center"/>
                    <h4 class="mb-4 text_margin_style">{{__('frontend.index.contact_us.opinion')}}</h4>
                    <p class="small mb-0 p_open">{{__('frontend.index.contact_us.join')}}<br />
                      {{__('frontend.index.contact_us.join_1')}}</p>                
                    <div class="row div_m">
                      <div class="col-3 img-1">
                        <div class="icon_style">
                          <img src="img/Vector.png" alt="get paid for online surveys" class="icon_padding_style " style="padding-top: 10px;" />
                        </div>        
                         <h2 class="icon_heading sign">{{__('frontend.index.contact_us.signup_for')}}</h2>        
                      </div>
      
                            <div class="col-3 border-center img-2">
								<div class="icon_style"><img src="img/Group.png" alt="survey and earn" class="icon_padding_style" style="padding-left: 14px;"/></div>
                            <h2 class="icon_heading">{{__('frontend.index.how_it_works.title_subhead_4')}}</h2>
                            </div>
                            <div class="col-3 border-center2 img-3">
                            <div class="icon_style"><img src="img/Group 70.png" alt="paid to do surveys online" class="icon_padding_style"/></div>
                            <h2 class="icon_heading">{{__('frontend.index.contact_us.take_survey')}}</h2>
                            </div>
                            <div class="col-3 border-center3 re-image">
                            <div class="icon_style"><img src="img/Vector-1.png" alt="survey sites to make money" class="icon_padding_style" style="padding-left: 12px;"/></div>
                            <h2 class="icon_heading">{{__('frontend.index.contact_us.redeem_rewards')}} </h2>
                            </div>
                          </div>
                        </div>
                      </div>
                  
            
                      <div class="col-lg-6 div_m_t centerr-div" id="center-div">
                        <div class="card-body p-md-5 mx-md-4">
                          <div class="row" id="div_mt">
                            <div class=" col-lg-9">                 
                              <h4 class="mt-1 Register_text_style regi" id="register">{{__('frontend.index.contact_us.personal_details')}}</h4>
                            </div>
                            <div class="col-lg-3">                  
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
                                <li><a href="/lang/es_US">{{__('frontend.nav.static.language_3')}}</a></li>
                                --}}
                                <div id="US" class="Languague">
                                <img src="img/USA.png" alt="earn through surveys">
                                <li class="dropdown-header">US</li>
                                <li><a class="#" href="/lang/en_US">{{__('ENGLISH ')}}</a></li>
                                <li><a href="/lang/es_US">{{__('frontend.nav.static.language_spanish')}} </a></li>
                               </div>
                                
                                {{--CA--}}
                                 <div id="CA" class="Languague">
                                <img src="img/CANADA.png" alt="paid online surveys for money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CA</li>
                                <li><a class="#" href="/lang/en_CA">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fr_CA">{{__('frontend.nav.static.language_french')}} </a></li></div>

                                {{--ES--}}
                                 <div id="ES" class="Languague">
                                <img src="img/SPAIN.png" alt="survey sites to earn money" style="transform: translateY(10px);">
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">ES</li>
                                <li><a class="#" href="/lang/es_ES">{{__('frontend.nav.static.language_spanish')}} </a></li>
                              </div>

                                {{--DE--}}
                                <div id="DE" class="Languague">
                                <img src="img/GERMANY.png" alt="online marketing survey">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">DE</li>
                                <li><a class="#" href="/lang/en_DE">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/de_DE">{{__('frontend.nav.static.language_german')}} </a></li>
                              </div>

                                {{--AU--}}
                                <div id="AU" class="Languague">
                                <img src="img/AUSTRALIA.png" alt="survey sites free">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">AU</li>
                                <li><a class="#" href="/lang/en_AU">{{__('ENGLISH ')}}</a></li>
                              </div>
                            
                                {{--UK--}}
                                <div id="UK" class="Languague">
                                <img src="img/UNITED KINGDOM.png" alt="free online survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">UK</li>
                                <li><a class="#" href="/lang/en_UK">{{__('ENGLISH ')}}</a></li>
                                </div>

                                {{--FR--}}
                                <div id="FR" class="Languague">
                                <img src="img/FRANCE.png" alt="market research online surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">FR</li>
                                <li><a class="#" href="/lang/en_FR">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fr_FR">{{__('frontend.nav.static.language_french')}} </a></li>
                              </div>

                                {{--IT--}}
                                <div id="IT" class="Languague">
                                <img src="img/ITALY.png" alt="market survey online">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">IT</li>
                                <li><a class="#" href="/lang/it_IT">{{__('frontend.nav.static.language_italian')}} </a></li>
                              </div>

                                {{--IN--}}
                                <div id="IN" class="Languague">
                                <img src="img/INDIA.png" alt="best survey platforms">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">IN</li>
                                <li><a class="#" href="/lang/en_IN">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/hi_IN">{{__('frontend.nav.static.language_hindi')}} </a></li></div>

                                {{--CN--}}
                                <div id="CN" class="Languague">
                                <img src="img/CHINA.png" alt="online survey companies that pay well">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CN</li>
                                <li><a class="#" href="/lang/en_CN">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/zh_CN">{{__('frontend.nav.static.language_chinese')}} </a></li></div>

                                <!-- new -->

                                {{--AR--}}
                                <div id="AR" class="Languague">
                                <img src="img/ARGENTINA.png" alt="best survey sites for earning">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">AR</li>
                                <li><a class="#" href="/lang/en_AR">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/es_AR">{{__('frontend.nav.static.language_spanish')}}</a></li></div>

                                {{--BE--}}
                                <div id="BE" class="Languague">
                                <img src="img/BELGIUM.png" alt="legit surveys to earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">BE</li>
                                <li><a class="#" href="/lang/fr_BE">{{__('frontend.nav.static.language_french')}}</a></li>
                                <li><a class="#" href="/lang/nl_BE">{{__('frontend.nav.static.language_dutch')}}</a></li>
                                <li><a class="#" href="/lang/de_BE">{{__('frontend.nav.static.language_german')}}</a></li></div>

                                {{--BR--}}
                                <div id="BR" class="Languague">
                                <img src="img/BRAZIL.png" alt="legit survey to earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">BR</li>
                                <li><a class="#" href="/lang/pt_BR">{{__('frontend.nav.static.language_portuguese')}}</a></li></div>

                                {{--CL--}}
                                <div id="CL" class="Languague">
                                <img src="img/CHILE.png" alt="surveys that give you money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CL</li>
                                <li><a class="#" href="/lang/es_CL">{{__('frontend.nav.static.language_spanish')}}</a></li></div>

                                {{--CO--}}
                                <div id="CO" class="Languague">
                                <img src="img/COLOMBIA.png" alt="free money earning survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CO</li>
                                <li><a class="#" href="/lang/es_CO">{{__('frontend.nav.static.language_spanish')}}</a></li></div>


                                {{--DK--}}
                                <div id="DK" class="Languague">
                                <img src="img/DENMARK.png" alt="online survey companies that pay well">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">DK</li>
                                <li><a class="#" href="/lang/en_DK">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/de_DK">{{__('frontend.nav.static.language_german')}}</a></li>
                                <li><a class="#" href="/lang/da_DK">{{__('frontend.nav.static.language_danish')}}</a></li></div>

                                {{--EG--}}
                                <div id="EG" class="Languague">
                                <img src="img/EGYPT.png" alt="best survey sites for earning">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">EG</li>
                                <li><a class="#" href="/lang/en_EG">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/ar_EG">{{__('frontend.nav.static.language_arabic')}}</a></li></div>

                                {{--HK--}}
                                <div id="HK" class="Languague">
                                <img src="img/HONG KONG.png" alt="fill out surveys to make money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">HK</li>
                                <li><a class="#" href="/lang/en_HK">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/zh_HK">{{__('frontend.nav.static.language_chinese')}}</a></li></div>

                                {{--ID--}}
                                <div id="ID" class="Languague">
                                <img src="img/INDONESIA.png" alt="making money filling out surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">ID</li>
                                <li><a class="#" href="/lang/en_ID">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/id_ID">{{__('frontend.nav.static.language_indonesian')}}</a></li></div>

                                {{--JP--}}
                                <div id="JP" class="Languague">
                                <img src="img/JAPAN.png" alt="answer survey and earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">JP</li>
                                <li><a class="#" href="/lang/jp_JP">{{__('frontend.nav.static.language_japanese')}}</a></li></div>

                                {{--KW--}}
                                <div id="KW" class="Languague">
                                <img src="img/KWAIT.png" alt="making money doing surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">KW</li>
                                <li><a class="#" href="/lang/ar_KW">{{__('frontend.nav.static.language_arabic')}}</a></li></div>


                                {{--MY--}}
                                <div id="MY" class="Languague">
                                <img src="img/MALAYSIA.png" alt="take surveys and earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">MY</li>
                                <li><a class="#" href="/lang/zh_MY">{{__('frontend.nav.static.language_chinese')}}</a></li>
                                <li><a class="#" href="/lang/ms_MY">{{__('frontend.nav.static.language_malay')}}</a></li>
                                <li><a class="#" href="/lang/en_MY">{{__('ENGLISH ')}}</a></li></div>

                                {{--MX--}}
                                <div id="MX" class="Languague">
                                <img src="img/MEXICO.png" alt="earn money completing surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">MX</li>
                                <li><a class="#" href="/lang/es_MX">{{__('frontend.nav.static.language_spanish')}}</a></li></div>


                                {{--NL--}}
                                <div id="NL" class="Languague">
                                <img src="img/NETHERLANDS.png" alt="complete survey and earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">NL</li>
                                <li><a class="#" href="/lang/en_NL">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/nl_NL">{{__('frontend.nav.static.language_dutch')}}</a></li></div>

                                {{--NO--}}
                                <div id="NO" class="Languague">
                                <img src="img/NORWAY.png" alt="get money for completing surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">NO</li>
                                <li><a class="#" href="/lang/en_NO">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/no_NO">NORWEGIAN</a></li>
                                <li><a class="#" href="/lang/de_NO">{{__('frontend.nav.static.language_german')}}</a></li></div>

                                {{--PE--}}
                                <div id="PE" class="Languague">
                                <img src="img/PERU.png" alt="surveys to get money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">PE</li>
                                <li><a class="#" href="/lang/es_PE">{{__('frontend.nav.static.language_spanish')}}</a></li></div>

                                {{--PH--}}
                                <div id="PH" class="Languague">
                                <img src="img/PHILIPPINES.png" alt="survey and get money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">PH</li>
                                <li><a class="#" href="/lang/en_PH">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fp_PH">FILIPINO/TAGALOG</a></li></div>

                                {{--PL--}}
                                <div id="PL" class="Languague">
                                <img src="img/POLAND.png" alt="earn money doing surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">PL</li>
                                <li><a class="#" href="/lang/pl_PL">{{__('frontend.nav.static.language_polish')}}</a></li></div>


                                {{--RU--}}
                                <div id="RU" class="Languague">
                                <img src="img/RUSSIA.png" alt="making money completing surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">RU</li>
                                <li><a class="#" href="/lang/en_RU">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/ru_RU">{{__('frontend.nav.static.language_russian')}}</a></li></div>

                                {{--SG--}}
                                <div id="SG" class="Languague">
                                <img src="img/SINGAPORE.png" alt="earn money from completing surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">SG</li>
                                <li><a class="#" href="/lang/zh_SG">{{__('frontend.nav.static.language_chinese')}}</a></li>
                                <li><a class="#" href="/lang/en_SG">{{__('ENGLISH ')}}</a></li></div>

                                {{--SE--}}
                                <div id="SE" class="Languague">
                                <img src="img/SWEDEN.png" alt="completing surveys to earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">SE</li>
                                <li><a class="#" href="/lang/sv_SE">{{__('frontend.nav.static.language_swedish')}}</a></li></div>

                                {{--CH--}}
                                <div id="CH" class="Languague">
                                <img src="img/SWITSERLAND.png" alt="earn from surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CH</li>
                                <li><a class="#" href="/lang/en_CH">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fr_CH">{{__('frontend.nav.static.language_french')}}</a></li>
                                <li><a class="#" href="/lang/de_CH">{{__('frontend.nav.static.language_german')}}</a></li></div>

                                {{--TW--}}
                                <div id="TW" class="Languague">
                                <img src="img/TAIWAN.png" alt="get paid for surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">TW</li>
                                <li><a class="#" href="/lang/zh_TW">{{__('frontend.nav.static.language_chinese')}}</a></li></div>

                                {{--AE--}}
                                <div id="AE" class="Languague">
                                <img src="img/UAE.png" alt="get paid for online surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">AE</li>
                                <li><a class="#" href="/lang/en_AE">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/ar_AE">{{__('frontend.nav.static.language_arabic')}}</a></li>
                                </div>

                              </div>
                        </ul>
                    <!-- </li> -->

                    <!-- <img id="img_01" src="img/Group 57.png" />  -->
                   

                    {{--<div class="dropdown-toggle" id="img_01" data-toggle="dropdown">
                      <img id="selected_country" alt="earn from surveys" src="img/{{$flags}}.png" style="border: 1px solid #DCDCDC; "/>
                      <span id="selected_country_code"></span>
                      <span id="selected_language"></span>
                    </div>--}}
                    <img id="img_01" alt="get paid for surveys" class="dropdown-toggle" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" src="img/{{$flags}}.png" style="border: 1px solid #DCDCDC; " />
                            </h4>
                          </div>
                          
                        </div>

                <!-- <form action="{{url('/')}}/personal-details" method="POST"> -->
                  
                 @csrf
                 {{ html()->form('POST', route('frontend.auth.personal-details.post'))->class('registration_form')->open() }} 
                  <input type="hidden" name="zip_check" id="zip_check" value="0">
                 <input type="hidden" name="email" id="email" value="{{$email}}">
                 <input type="hidden" name="create_password" value="{{$password}}">
                 <input type="hidden" id="requestid" name="rid"  value="{{$uuid}}" />
                                <input type="hidden" id="eventid" name="eid" value="{{$ip}}" />
                                <input type="hidden" id="cc" value="{{$country_code}}" />
                                <input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}">
                 <input type="hidden" name="gender" id="gender" value="" required>
				
                 <input type="hidden" name="language" id="langg" value="">
            <div class="form-outline mb-4">                
              <div class="row" >
                <div class="col-6 col-12 col-md-6 col-xs-12 f_name"> <label class="form-label form_label_style firstname" for="form2Example11" style="opacity: 0.7;">{{(__('validation.attributes.frontend.first_name'))}}*</label>
                  <input type="text" id="first_name" maxlength="20" class="form-control fname"
                     name="firstname" value="{{old('firstname')}}" onkeyup="{{--validateFname()--}}" required />
                     <span id="first_name_err" class="error"></span>
                          @if($errors->has('firstname'))
                          <div class="text-danger">{{ $errors->first('firstname')}}</div>
                          @endif
                </div>
                <!-- <span id="fname-error" class="error"></span> -->
                      
                <div class="col-6 col-12 col-md-6 col-xs-12 l_name"> <label class="form-label form_label_style lastname" for="form2Example11" style="opacity: 0.7;">{{(__('validation.attributes.frontend.last_name'))}}*</label>
                  <input type="text" id="last_name" maxlength="20" class="form-control lname"
                     name="lastname" value="{{old('lastname')}}" onkeydown="{{--validateLname()--}}" required />
                     <span id="last_name_err" class="error"></span>
                          @if($errors->has('lastname'))
                          <div class="text-danger">{{ $errors->first('lastname')}}</div>
                          @endif
                </div>  
                                 
              </div>                    
            </div>

            <!-- <div class="form-outline mb-4">                
              <div class="" >        
                <div class="l-name"> <label class="form-label form_label_style lastname" for="form2Example11">Last Name*</label>
                  <input type="text" id="form2Example11" class="form-control lname"
                    placeholder="danny" />
                </div>  
                                 
              </div>                    
            </div> -->
               
            

                  <div class="form-outline mb-4" id="gen_da">
                 <div class="row">
                 <div class="col-lg-6 col-md-6"> 
                 <label class="form-label form_label_style gender" for="form2Example11" style="opacity: 0.7;">{{__('frontend.register.static.gender')}}*</label>
                  <div class="row gend">
                  <!-- onclick="testFunction('male')" -->
                    <div class="col-6 col-md-6">
                    
                      <input type="button" value="{{__('frontend.register.static.gender_male')}}"  id="form2Example11" class="form-control icon_img_style btn-male btn-gender @if(__('frontend.register.static.gender_male')=='Masculino') Spanish_fontsize @endif" placeholder="Male" data-value="Male"/>
                        </div>
                        <!--
                        Author : Anil 
                        content removed from the div 
                        -->
                        <!-- onclick="testFunction('female')" -->
                        <div class="col-6 col-md-6">

                        <input type="button" value="{{__('frontend.register.static.gender_female')}}" id="form2Example11" class="form-control icon_img_style2  btn-gender btn-female @if(__('frontend.register.static.gender_male')=='Masculino') Spanish_fontsize @endif"
                        placeholder="Female" data-value="Female"/>
                        
                        </div>
                        <span id="gender-error" class="error"></span>
                          @if($errors->has('gender'))
                          <div class="text-danger">{{ $errors->first('gender')}}</div>
                          @endif
 
                        </div>                       
                        
                        </div>
                          
                      
                      <div class="col-lg-6 col-md-6" id="date_div"> 
                        <label class="form-label form_label_style" for="form2Example11" style="opacity: 0.7;">{{__('frontend.index.contact_us.date')}}*</label>
<!--                          <input type="date" id="form2Example11" class="form-control date_div"
                           name="date" value="{{old('date')}}"/>  -->
                              <div id="datepicker"
                                class="input-group date"
                                data-date-format="mm-dd-yyyy" onclick="zipRemove()">
                                <input class="form-control date_div cst-form-date @if(__('frontend.register.static.gender_male')=='Masculino') Spanish_fontsize @endif"
                                  type="text"  id="form2Example11" style="background: white;cursor: pointer;" name="date" required />
                                <span class="input-group-addon date_group" style="background:white;width:17%;padding-left: 18px;">
                                  <!-- <i class="glyphicon glyphicon-calendar"></i> -->
                                  <i class="fa fa-calendar"></i>
                                </span>
                                <!-- <span id="date-error" class="error"></span> -->
                              </div>
                          @if($errors->has('date'))
                          <div class="text-danger">{{ $errors->first('date')}}</div>
                          @endif
                      </div>

                      <div class="form-outline mb-4">                
                        <!-- <div class="" >        
                          <div class="date"> <label class="form-label form_label_style dat" for="form2Example11">Date of Birth*</label>
                            <input type="date" id="form2Example11" class="form-control lname"
                              placeholder="danny" name="date"/>
                          </div>  
                                           
                        </div>                     -->
                      </div>
                      
                      </div>
                  </div>
                  
                   <div class="form-outline mb-4 zipp">
                  <label class="form-label form_label_style zi @if(__('frontend.register.static.gender_male')=='Masculino') Spanish_fontsize @endif" for="form2Example11" style="opacity: 0.7;">{{__('frontend.index.contact_us.zip')}}*</label>
                    <input type="text" id="zip" class="form-control zip"
                      placeholder="" name="zip" value="{{old('zip')}}" maxlength="15" onkeyup="validateZip()" required />
                      <span id="zip-error" class="error"></span>
                          @if($errors->has('zip'))
                          <div class="text-danger">{{ $errors->first('zip')}}</div>
                          @endif
                  </div>
                  
<!--                    <div class="form-outline mb-4 countryy">
                  <label class="form-label form_label_style countr" for="form2Example11">Country & Language*</label>
                    <select class="form-control form-select country" id="country-op" name="country_name" value="{{old('country_name')}}">
                    
                    <option >Australia&nbsp;</option>
                    <option >Canada&nbsp;</option>
                    <option >China&nbsp;</option>
                    <option >France&nbsp;</option>
                    <option >Germany&nbsp;</option>
                    <option >India&nbsp;</option>
                    <option >Italy&nbsp;</option>
                    <option >Spain&nbsp;</option>
                    <option selected>United States&nbsp;</option>
                    <option >United Kingdom&nbsp;</option>
                </select>
                          @if($errors->has('country_name'))
                          <div class="text-danger">{{ $errors->first('country_name')}}</div>
                          @endif
                  </div> -->

                  @if( !empty($countries) )
                  <div class="form-outline mb-4" id="count_lan">
                    <div class="row">
                      <div class="col-6 col-12 col-md-6 col-xs-12 countryy">
                        <label class="form-label form_label_style countr" for="form2Example11" style="opacity: 0.7;">
                        {{(__('frontend.register.static.country'))}}*</label>
                       
                        @foreach($countries as $country)
                          @if($country->country_code==@$country_code || $country->country_code==@$country_code)
                          <input type="text" id="country" class="form-control"
                        placeholder="" name="country_name" value="{{$country->country_name}}" readonly />
                        <input type="hidden" name="country_name" value="{{$country->country_code}}">
                        @endif
                        @endforeach
                         {{-- <select class="form-control form-select country" id="country" name="country_name" value="{{old('country_name')}}" required> --}}
                            <!-- <option selected>Country&nbsp;</option> -->
                            <!-- <option >United States&nbsp;</option>
                            <option >Canada&nbsp;</option>
                            <option >China&nbsp;</option>
                            <option >France&nbsp;</option>
                            <option >Germany&nbsp;</option>
                            <option >India&nbsp;</option>
                            <option >Italy&nbsp;</option>
                            <option >Spain&nbsp;</option>
                            <option selected>United Kingdom&nbsp;</option>
                            <option >Australia &nbsp;</option> -->

                                                   {{-- @foreach($countries as $country) --}}
                                                        {{--<option @if($country->country_code==@$country_code) selected @endif value="{{$country->country_code}}" >{{$country->country_name}}</option>--}}
                                                        {{--<option value="{{$country->id}}" {{ ($country->country_code == $country_code)?'selected="true"':'' }}>{{$translatedCountry->name}}</option>--}}
                                                 {{--   @endforeach   --}}
                          <!-- </select>  -->
                          <span id="country-error" class="error"></span>
                          @if($errors->has('country_name'))
                          <div class="text-danger">{{ $errors->first('country_name')}}</div>
                          @endif
                      </div>
                      <div class="col-6 col-12 col-md-6 col-xs-12 language-opt">
                        <label class="form-label form_label_style countr" for="form2Example11" style="opacity: 0.7;">{{(__('frontend.register.static.language'))}}*</label>
                          <select class="form-control form-select country" id="language" name="language" required>
                           <option>English</option>
                          </select>
                          <span id="language-error" class="error"></span>

                      </div>
                    </div>
                  </div>
                  @endif

                
<!-- 
                  <div class="pt-1 mb-5 pb-1" style="margin-bottom:0px!important;" >
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"  type="submit" style="">

                        <a class="Submit_text" >Submit</a>
                      </button> -->
                                        <div class="pt-1 mb-5 pb-1" style="" id="proc">
                    <button class="btn-style btn mb-3" type="submit" id="submit" style="" onclick="return testInputValidate(event)">
                     {{__('frontend.index.contact_us.submit')}}
                    </button>

                    <!-- <button class="btn-style btn mb-3" type="submit"  style="">
                     Back
                    </button> -->
                    <div class="text-center w-50 m-auto">
                      <h2 class="icon_heading_3 mobile_back_btn" style="color: #006BDE"><a href="{{ route('frontend.auth.register') }}">{{__('frontend.modes.email_auth.back')}}</a></h2>
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
  
</section>

 </div>   
   

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
                  <a href="{{ route('frontend.cms.term_condition') }}"  style="color: black;" class="terms policy"> 
                    {{__('frontend.index.footer.links.term_condition')}}</a> <span cl
                    class="policy"> | </span> 
                    <a href="{{ route('frontend.cms.faq') }}" style="color: black;" class="policy">{{__('frontend.index.footer.links.FAQ')}}</a></p>
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
       $countryCode="UK";
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
    .form-control:focus + .form-control-placeholder, .form-control + .form-control-placeholder {
        font-size: 75%;
        transform: translate3d(0, -100%, 0);
        opacity: 1;
    }


    .emsg{
        border: 1px solid red;
    }
</style>
@endpush
@push('after-scripts')
@if (config('access.captcha.registration'))
  {!! NoCaptcha::renderJs() !!}
@endif
<script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v6.0.4.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{asset('vendor/js/plugins/fullcalendar/moment.min.js')}}"></script>

<!-- Data picker -->
<script src="{{asset('vendor/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/b9bdbd120a.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
  var myarray=["sayani.deb.test@gmail.com", 
"amar.das.test@gmail.com", 
"riya.roy.test6@gmail.com", 
"majumderamarjit16@gmail.com", 
"bochkarirohan@gmail.com", 
"majumderamarjit950@gmail.com", 
"pranavtest001@gmail.com", 
"pranavtest0002@gmail.com", 
"pranavtest003@gmail.com", 
"pranavtest005@gmail.com", 
"pranavtest006@gmail.com", 
"pranavtest0007@gmail.com", 
"pranavtest0008@gmail.com", 
"pranavtest009@gmail.com", 
"pranavs.sj007@gmail.com", 
"Pranavtest005@gmail.com", 
"vbas03467@gmail.com"];
  $(document).ready(function(e){ 
    // $('.btn').prop('disabled','true');
    //$('[data-toggle="tooltip"]').tooltip();
  $('.arrowpopup').mouseover(function(){
   var tt = document.getElementById("tooltipdemo");
   console.log(tt);
  tt.classList.toggle("show");
  })
  });
  
</script>


<script>
fetchLanguage('{{$country_code}}')
var fnameError = document.getElementById('first_name_err');
var lnameError = document.getElementById('lname-error');
var zipError = document.getElementById('zip-error');

function validateFname(){
  // alert("hello");
    var fName = document.getElementById('first_name').value;
    if(fName.length == 0){
        fnameError.innerHTML = '{{(__('validation.attributes.frontend.first_name1'))}}';
        return false;
    }
    if(!fName.match(/^[A-Za-z]+$/)){
      fnameError.innerHTML = '{{(__('validation.attributes.frontend.first_name1'))}}';
      return false;
    }
    let occ_count = 0;
    if(fName.length > 2){
      for(let i = 0; i < fName.length; i++){
        if(countString(fName, fName[i]).length != 0){
          fnameError.innerHTML = '{{(__('validation.attributes.frontend.first_name4'))}}';      
            return false;
        }
      }
    
    }
    fnameError.innerHTML = '';
    return true;
}
function countString(str, letter) {
    let count = 0;
  let arr_counts = [];
    // looping through the items
    for (let i = 0; i < str.length; i++) {

        // check if the character is at that position
        if (str.charAt(i) == letter && str.charAt(i+1) == letter && str.charAt(i+2) == letter && str.charAt(i+3) != null) {
            count += 1;
            arr_counts.push(count);

        }

      }
      return arr_counts;
  }
function validateLname(){
  // alert("hello");
    var lName = document.getElementById('l-name').value;
    if(lName.length == 0){
        lnameError.innerHTML = '{{(__('validation.attributes.frontend.last_name1'))}}';
        return false;
    }
    if(!lName.match(/^[A-Za-z]+$/)){
      lnameError.innerHTML = '{{(__('validation.attributes.frontend.last_name1'))}}';
      return false;
    }
    lnameError.innerHTML = '';
    return true;
}
$(document).ready(function(){
   	$(':text').on('keypress',function(e){
              if($(this).attr('id') == 'first_name' || $(this).attr('id') == 'last_name' ){
                  var input = String.fromCharCode(e.which);
                  var regex = /[a-zA-Z]/;
                  if(!regex.test(input)){
                      e.preventDefault();
                      if(e.which >= 48 && e.which <= 57){
                        $('#'+$(this).attr('id')+'_err').html('{{(__('validation.attributes.frontend.name_req_3'))}}');
                      }else{
                        $('#'+$(this).attr('id')+'_err').html('{{(__('validation.attributes.frontend.name_req_1'))}}');
                      }
                      
                  }else{
                      $('#'+$(this).attr('id')+'_err').html('');
                      var input_txt = $('#'+$(this).attr('id')).val();
                      if(input_txt.length > 1){
                          var currentInput = input.toUpperCase();
                          var lastInput = input_txt.substr(-1,1).toUpperCase();
                          var lastBeforeInput = input_txt.substr(-2,1).toUpperCase();
                          if(currentInput === lastInput && currentInput === lastBeforeInput){
                              e.preventDefault();
                              $('#'+$(this).attr('id')+'_err').html('{{(__('validation.attributes.frontend.name_req_2'))}}');
                          }else{
                              $('#'+$(this).attr('id')+'_err').html('');
                          }
                      }
                  }
              }	
          });
   	$(':text').on('blur',function(e){
   		if($(this).attr('id') == 'first_name'  || $(this).attr('id') == 'last_name' ){
   			$('#'+$(this).attr('id')+'_err').html('');
   		}
   	});
});

 
function validateZip(){
 
  console.log($('#email').val().indexOf("samplejunction")==-1 && jQuery.inArray(email, myarray) ==-1);
    var zipCode = document.getElementById('zip').value;
    if(zipCode.length == 0){
        zipError.innerHTML = '{{(__('validation.attributes.frontend.zip_code1'))}}';
        return false;
    }
    // if(!zipCode.match(/^[0-9]{5}(?:-[0-9]{4})?$/)){
    //   zipError.innerHTML = 'Enter valid zip code';
    //   return false;
    // }
    zipError.innerHTML = '';
     return true;
}

// function testFunction(gender) {
//   var la = gender;
//   // alert(la);
//   // return la;
// }

// var temp = testFunction();
// if(temp == ''){
//   alert('Submit gender');
// }

function testInputValidate(e){
 
  const dateInput = document.querySelector('.cst-form-date').value;
  var country = document.getElementById("cc").value;
  if(country=='IN' || country=='AU'){
    var AgeLimit=18;
  }else{
    var AgeLimit=13;
  }
  // console.log(dateInput);

  var agearr = dateInput.split('-');

  var birthDate = agearr[2] +'-'+ agearr[0] +'-'+ agearr[1];

  var ua = getAge(birthDate); 
  const submitButton = document.getElementById('submit');
  // var alldates = document.querySelectorAll('');

  // Code added by Vikas for restrict age max 100 years
  if(ua > 100){
    Message="{{(__('validation.attributes.frontend.max_age_limit'))}}";
    //submitButton.disabled = true;
    setTimeout(function() {
      toastr.error(Message, '' );
        }, 400);
    return false;                            
  }
  // End
  if(ua < AgeLimit){
    Message="{{(__('validation.attributes.frontend.is_age'))}}";
    //submitButton.disabled = true;
    setTimeout(function() {
      toastr.error(Message, '' );
        }, 400);

    return false;                            


  }
  // validateFname();
  // else{

  //   //dateerr.innerHTML = " ";

  //   return true;

  // }
 return true;
}


const getAge = birthDate => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e+10);



function zipRemove(){

//document.querySelector('.zip').value = " ";


}

const firstnameInput = document.getElementById('f-name');
const lastnameInput = document.getElementById('l-name');
const zipInput = document.getElementById('zip');
const submitButton = document.getElementById('submit');

//firstnameInput.addEventListener('input', validateForm);
//lastnameInput.addEventListener('input', validateForm);
//zipInput.addEventListener('input', validateForm);

function validateForm() {
  // if(!passwordInput.value.includes(confirmPasswordInput.value){
  //   alert("passowrd and confirm pssword are not same");
  // }
    // alert("disable");
    if(!validateZip() || !validateLname() || !validateFname()){
    submitButton.disabled = true;
    return false;
  }
  else{
    submitButton.disabled = false;
    return true;
  }
}



 
$(document).on('click','.btn-gender',function(){
  $('.btn-gender').removeClass('genderChange');
  $('#gender').val($(this).data('value'));
  if($(this).data('value') == "{{__('frontend.register.static.gender_male')}}"){
    classname="icon_img_style1";
    //$('.btn-gender').removeClass('icon_img_style3');
    $(this).removeClass('icon_img_style');
    $('.btn-female').removeClass('icon_img_style3');
    $('.btn-female').addClass('icon_img_style2');
  }    
        
  if($(this).data('value') == "{{__('frontend.register.static.gender_female')}}"){
    classname="icon_img_style3";
    $(this).removeClass('icon_img_style2');
    $('.btn-male').removeClass('icon_img_style1');
    $('.btn-male').addClass('icon_img_style');
  }
  if($(this).hasClass('genderChange')){
    $(this).removeClass('genderChange');
  }else{
    $(this).addClass('genderChange');
    $(this).addClass(classname);
  }
  
});

    


    $('select#country').on('change',function(e){
        var country_code = $('select#country').val();
        fetchLanguage(country_code)
    });

    function fetchLanguage(country_code)
    {
       var countryName={};
       countryName['US']='USA.png';
       countryName['CA']='CANADA.png';
       countryName['AU']='AUSTRALIA.png';
       countryName['ES']='SPAIN.png';
       countryName['DE']='GERMANY.png';
       countryName['UK']='UNITED KINGDOM.png';
       countryName['IN']='INDIA.png';
       countryName['FR']='FRANCE.png';
       countryName['IT']='ITALY.png';

       $("#"+country_code).show();
       country_flag=countryName[country_code];
       //$('#img_01').attr('src','img/'+country_flag);

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
            }
        }).catch(function (error) {
            // handle error
        }).then(function () {
            // always executed
            console.log('always executed');
        });
    }
    $('.registration_form .form-control').blur(function() {
         var info = $("#zip").val();
         var id=$(this).attr('id');
         var email=$('#email').val();
         
         if(id=='zip'){
          var dfiq_check=$("#dfiq_check").val();
          // alert(email.indexOf("samplejunction"));
          if(dfiq_check==1 && info!='')
          {
             if(email.indexOf("samplejunction")==-1 && jQuery.inArray(email, myarray) ==-1){
               invokeAPI(info);  
             }else{
              $('#zip_check').val('1');
             }
            
          } 
        }        
       
    });
    $(document).on('click','#submit',function(){
      // return true;
      // alert($('#zip_check').val());
      if($('#zip_check').val()==0){
         var dfiq_check=$("#dfiq_check").val();
         if(dfiq_check==1){
          return false;
         }
         else{
          return true;
        }
        
      }
      return true;
    });

    function invokeAPI(info) {
                var zipCode = document.getElementById('zip').value;
                console.log(zipCode);
                //return false;
                var req = document.getElementById("requestid").value;
                var event = document.getElementById("eventid").value;
                var country = document.getElementById("cc").value;
                if(country=='UK'){
                  country1='GB';
                }else{
                  country1=country;
                }

                if(country1=="GB"){
               var zip_code_V1= zipCode.substring(0, zipCode.indexOf(' '));
               if(zip_code_V1==''){
                zip_code_V1=zipCode;
               }
            }
            if(country1=="CA"){
                zipCode=zipCode.replace(/\s+/g, "");
                var zip_code_V1 = zipCode.replace(/.{3}/g, '$& ');
                //var zip_code_V1= zipCode.replace(/.{3}/g, '$&');
            }
            if(country1=="AR"){
                var zip_code_V1= $.trim(zipCode).substring(0, 5);
            }
             if(country1!="CA" && country1!="GB" && country1!="AR"){
                var zip_code_V1= $.trim(zipCode);
            }

                var utm_source="SJWRegister";
                //$('#form-dispaly').hide();
               // $('.loader').show();
                var uniquenessParam = Forensic.createUniquenessParam("SJPL",null, false);
                var geoParam = Forensic.createGeoParam(country1,zip_code_V1);
                Forensic.forensic(req, successCallback, errorCallback, uniquenessParam, geoParam, null, null, utm_source);
            }
             function successCallback(jsonData) {
                var FlagStatus=false;
                var Message='';
                console.log(jsonData);
                
               // $('#form-dispaly').hide();
               // $('.loader').show();
                /*$.ajaxSetup({
                headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });*/
                var email=$('#email').val();
                var ip_address=$('#eventid').val();
                var panelistId=$('#requestid').val();
                $.ajax({
                    url: "{{ route('frontend.auth.register.dfiqData.post') }}",
                    type: 'GET',
                    data: {datajsondata:jsonData,email:email,ip_address:ip_address,panelistId:panelistId,user_id:''},
                    success: function(response){
                       // window.location=addressBar+"&DFIQ=true";
                    }, 
                    async: true
                    });

                if (jsonData.forensic.marker.score > 26 ||  jsonData.forensic.unique.isEventUnique == false){
                    console.log("fraud score >= 25 or not unique"); // Add your logic to handle non-fraud/unique
                   /* if(jsonData.forensic.unique.isEventUnique == false  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_event'))}}";
                        FlagStatus=true;
                    }*/
                    if(jsonData.forensic.marker.isGeoPostal == false  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_geopostal'))}}";
                        FlagStatus=true;
                    }
                    if(jsonData.forensic.marker.isBot == true  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_bot'))}}";
                        FlagStatus=true;
                    }
                    
                    if(jsonData.forensic.marker.isAnonymous == true  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_anonymous'))}}";
                        FlagStatus=true;
                    }
                    if(jsonData.forensic.marker.isGeoTz == false  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_geotz'))}}";
                        FlagStatus=true;
                    }
                    if(jsonData.forensic.marker.isTampered == true  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_tampered'))}}";
                        FlagStatus=true;
                    }
                    /*if(jsonData.forensic.unique.isEventUnique == false  && FlagStatus==false){
                        Message="{{(__('validation.attributes.frontend.is_event'))}}";
                        FlagStatus=true;
                    }*/
                }
                console.log(FlagStatus);
                console.log(Message);
                
                if(FlagStatus==true){
                    setTimeout(function() {
                                toastr.error(Message, '' );
                                }, 400);
                    // $('.btn').prop('disabled','true');
                    $('#zip_check').val(0);
                 }else{
                    $('#zip_check').val(1);
                    $('.btn').removeAttr('disabled','false');
                    //$('#submit').click();

                 }
            };
            function errorCallback(jsonData) {
                console.log(jsonData.error.message); // Add your logic to handle errors
            }
// });


// $(document).ready(function() {

//   $("#submit").click(function(event) {
//     event.preventDefault();

//     if (!$(".btn-gender").is("")) {
//       alert("Please select a gender.");
//       return;
//     }
//     $(".registration_form").submit();
//   });
// });

$(document).ready(function() {
    $("#submit").on("click", function(event) {
        let isValid = true; 

        if (!$(".btn-gender").hasClass("selected")) {
            event.preventDefault();
            var genderError = document.getElementById('gender-error');
            genderError.innerHTML = "{{(__('validation.attributes.frontend.gender_req'))}}";
            isValid = false;
        }
        const namePattern = /^[a-zA-Z]+$/; 
        const firstName = document.getElementById('first_name').value;
        if (firstName === "") {
            document.getElementById("first_name_err").innerHTML= ("{{(__('validation.attributes.frontend.first_name1'))}}");
            isValid = false;
        } else if (!namePattern.test(firstName)) {
          document.getElementById("first_name_err").innerHTML=("{{(__('validation.attributes.frontend.first_name2'))}}");
            isValid = false;
        } else {
          document.getElementById("first_name_err").innerHTML ="";
        }
        const lastName = document.getElementById('last_name').value;
        if (lastName === "") {
          document.getElementById("last_name_err").innerHTML=("{{(__('validation.attributes.frontend.last_name1'))}}");
          isValid = false;
        } else if (!namePattern.test(lastName)) {
          document.getElementById("last_name_err").innerHTML=("{{(__('validation.attributes.frontend.first_name2'))}}"); 
          isValid = false;
        } else {
          document.getElementById("last_name_err").innerHTML ="";
        }
        const zip = document.getElementById('zip').value;
        if (zip === "") {
          document.getElementById("zip-error").innerHTML=("{{(__('validation.attributes.frontend.zip_code1'))}}");
            isValid = false;
        } else {
          document.getElementById("zip-error").innerHTML="";
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    $(".btn-gender").on("click", function() {
        $(".btn-gender").removeClass("selected");
        $(this).addClass("selected");
        var genderError = document.getElementById('gender-error');
        genderError.innerHTML = "";
    });
});



</script>

  <script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity=
  "sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous">
  </script>
  <script>
    $(function () {
      $("#datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
      }).datepicker('update', new Date());
    });
  </script>
    
  <script src=
"https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous">
  </script>
  <script src=
"https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous">
  </script>
  <script src=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
  </script>

@endpush
