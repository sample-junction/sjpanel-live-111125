@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.passwords.reset_password_box_title'))

@push('after-styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
    rel="stylesheet"  type='text/css'>
    <!-- <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{asset('css2/style3.css')}}" rel="stylesheet">
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

        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url("/img/bg-01.jpg");
        }
        .white, .white > a{
            color:white;
        }

        .toast-error{
  background-color: #bd362f !important;
  color: #fff !important;
  font-size: 12px !important;
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
#proc .btn{
   background-color: #DCDCDC;;
  color:#757575;
  font-size: 16px;
/*  width: 85%;*/
  margin-left: 9px;
  margin-top: -209px;
}

#contain-div-1{
  border-radius: 10px 0px 0px 10px;
}

@media (min-width: 220px) and (max-width: 767px){
#proc .btn {
    position: relative;
    top: 25px;
    width: 85%;
     margin-top: 0px !important; 
}
}
@media(min-width: 1340px) and (max-width: 1450px){
    #proc .btn{
        width: 84% !important;
    }
}

@media (min-width: 768px) and (max-width: 981px){
    #proc .btn-style {
      margin-top: -137px !important;
    }
     #email-error1{
      bottom: 138px !important;
    }
    .footer_style{
      margin-top: 126px !important;
    }
}

.field-icon {
  float: left;
  margin-left: 303px;
  margin-top: -23px;
  position: relative;
  z-index: 2;
}
.clearfix{
  clear: both;

}
  #email-error1 {

    /*position: absolute;
     padding-top: 15px; 
     bottom: 308px !important;

/*     bottom: 12px; */
    /* right: 17px; */
    font-size: 14px;
    color: red;
  }
  @media (min-width: 353px) and (max-width: 357px){
    #email-error1 {
       position: absolute;
      top: 153px;
    }
}
  @media (min-width: 358px) and (max-width: 364px){
    #email-error1{
      position: absolute;
      top: 168px;
    }
  }

#proc .btn {
    width: 15% !important;
}

    </style>

@endpush

@section('content')

  <div id="container"><!-- main container starts-->
    <div id="wrapp"><!-- main wrapp starts-->
        <nav class="navbar navbar-expand-lg navbar-dark  static-top">
          <div class="container Nav-div" >
          <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
              <img src="/img/SJ Panel New LOGO without background.png" alt="get survey and earn money" class="img-fluid">
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
    <section class="h-100 gradient-form">
      <div class="container py-5 h-100" id="card">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-12">
            <div class="card rounded-3 text-black">
              <div class="row g-0" width="25px">
                
                <div class="col-lg-6  align-items-center gradient-custom-2" id="contain-div-1">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <img src="/img/login_user.png" alt="earn by survey online" class="image_center"/>
                    <h4 class="mb-4 text_margin_style">{{__('frontend.index.contact_us.opinion')}}</h4>
                    <p class="small mb-0 p_open">{{__('frontend.index.contact_us.join')}}<br />
                    {{__('frontend.index.contact_us.join_1')}}</p>                
                    <div class="row div_m">
                      <div class="col-3 img-1">
                        <div class="icon_style">
                          <img src="/img/Vector.png" alt="websites that pay you for surveys" class="icon_padding_style " style="padding-top: 10px;"/>
                        </div>        
                        <h2 class="icon_heading sign">{{__('frontend.index.contact_us.signup_for')}}</h2>             
                      </div>

                      <div class="col-3  border-center img-2">
                      <div class="icon_style"><img src="/img/Group.png" alt="sites that pay you for surveys" class="icon_padding_style" style="padding-left: 14px;" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.how_it_works.title_subhead_4')}}</h2>
                      </div>
                      <div class="col-3 border-center2 img-3">
                      <div class="icon_style"><img src="/img/Group 70.png" alt="take survey and earn" class="icon_padding_style"/></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.take_survey')}}</h2>
                      </div>
                      <div class="col-3 border-center3 re-image">
                      <div class="icon_style" ><img src="/img/Vector-1.png" alt="earn by filling surveys" class="icon_padding_style" style="padding-left: 12px;"/></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.redeem_rewards')}} </h2>
                      </div>
                    </div>
                  </div>
                </div>
            
            <div class="col-lg-6 div_m_t" id="main-left-div">
              <div class="card-body p-md-5 mx-md-4">
                <div class="row" id="div_mt">
                  <div class=" col-lg-9">                 
                    <h4 class="mt-1 Register_text_style regi" id="register">{{__('frontend.index.contact_us.reset_password')}}</h4>
                    <!-- <h2 class="font-bold white">{{__('frontend.register.static.title')}}</h2> -->
                    <!-- <p class="white">{{__('frontend.register.static.subtitle')}}</p> -->
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
                                <img src="/img/USA.png" alt="easy surveys for money" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">
                                <li class="dropdown-header">US</li>
                                <li><a class="#" href="/lang/en_US" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/es_US" onclick="changeImage(this, 'US-ES' ,'img/USA.png' )">{{__('frontend.nav.static.language_spanish')}} </a></li>
                               </div>
                                
                                {{--CA--}}
                                 <div id="CA" class="Languague">
                                <img src="/img/CANADA.png" alt="easy cash surveys" onclick="changeImage(this, 'CA-EN' ,'img/CANADA.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CA</li>
                                <li><a class="#" href="/lang/en_CA" onclick="changeImage(this, 'CA-EN' ,'img/CANADA.png' )">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fr_CA" onclick="changeImage(this, 'CA-FR' ,'img/CANADA.png' )">{{__('frontend.nav.static.language_french')}} </a></li></div>

                                {{--ES--}}
                                 <div id="ES" class="Languague">
                                <img src="/img/SPAIN.png" alt="earn money doing surveys online" style="transform: translateY(10px); onclick="changeImage(this, 'ES-EN' ,'img/SPAIN.png' )">
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">ES</li>
                                <li><a class="#" href="/lang/es_ES" onclick="changeImage(this, 'ES-ES' ,'img/SPAIN.png' )">{{__('frontend.nav.static.language_spanish')}} </a></li>
                              </div>

                                {{--DE--}}
                                <div id="DE" class="Languague">
                                <img src="/img/GERMANY.png" alt="making money doing surveys online" onclick="changeImage(this, 'DE-EN' ,'img/GERMANY.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">DE</li>
                                <li><a class="#" href="/lang/en_DE" onclick="changeImage(this, 'DE-EN' ,'img/GERMANY.png' )">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/de_DE" onclick="changeImage(this, 'DE-DE' ,'img/GERMANY.png' )">{{__('frontend.nav.static.language_german')}} </a></li>
                              </div>

                                {{--AU--}}
                                <div id="AU" class="Languague">
                                <img src="/img/AUSTRALIA.png" alt="get money doing surveys online" onclick="changeImage(this, 'AU-EN' ,'img/AUSTRALIA.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">AU</li>
                                <li><a class="#" href="/lang/en_AU" onclick="changeImage(this, 'AU-EN' ,'img/AUSTRALIA.png' )">{{__('ENGLISH ')}}</a></li>
                              </div>
                            
                                {{--UK--}}
                                <div id="UK" class="Languague">
                                <img src="/img/UNITED KINGDOM.png" alt="making money taking online surveys" onclick="changeImage(this, 'UK-EN' ,'img/UNITED KINGDOM.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">UK</li>
                                <li><a class="#" href="/lang/en_UK" alt="get paid to fill in surveys" onclick="changeImage(this, 'UK-EN' ,'img/UNITED KINGDOM.png' )">{{__('ENGLISH ')}}</a></li>
                                </div>

                                {{--FR--}}
                                <div id="FR" class="Languague">
                                <img src="/img/FRANCE.png" alt="earn cash doing surveys online" onclick="changeImage(this, 'FR-EN' ,'img/FRANCE.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">FR</li>
                                <li><a class="#" href="/lang/en_FR" onclick="changeImage(this, 'FR-EN' ,'img/FRANCE.png' )">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fr_FR" onclick="changeImage(this, 'FR-FR' ,'img/FRANCE.png' )">{{__('frontend.nav.static.language_french')}} </a></li>
                              </div>

                                {{--IT--}}
                                <div id="IT" class="Languague">
                                <img src="/img/ITALY.png" alt="earn cash doing surveys online" onclick="changeImage(this, 'IT-EN' ,'img/ITALY.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">IT</li>
                                <li><a class="#" href="/lang/it_IT" onclick="changeImage(this, 'IT-IT' ,'img/ITALY.png' )">{{__('frontend.nav.static.language_italian')}} </a></li>
                              </div>

                                {{--IN--}}
                                <div id="IN" class="Languague">
                                <img src="/img/INDIA.png" alt="earn money completing surveys online" onclick="changeImage(this, 'IN-EN' ,'img/INDIA.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">IN</li>
                                <li><a class="#" href="/lang/en_IN" onclick="changeImage(this, 'IN-EN' ,'img/INDIA.png' )">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/hi_IN" onclick="changeImage(this, 'IN-HI' ,'img/INDIA.png' )">{{__('frontend.nav.static.language_hindi')}} </a></li></div>

                                {{--CN--}}
                                <div id="CN" class="Languague">
                                <img src="/img/CHINA.png" alt="paid surveys online legit" onclick="changeImage(this, 'CN-EN' ,'img/CHINA.png' )">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CN</li>
                                <li><a class="#" href="/lang/en_CN" onclick="changeImage(this, 'CN-EN' ,'img/CHINA.png' )">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/zh_CN" onclick="changeImage(this, 'CN-CN' ,'img/CHINA.png' )">{{__('frontend.nav.static.language_chinese')}} </a></li></div>

                                 <!-- new -->
                                
                                 {{--AR--}}
                                <div id="AR" class="Languague">
                                <img src="/img/ARGENTINA.png" alt="legitimate paid online surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">AR</li>
                                <li><a class="#" href="/lang/en_AR">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/es_AR">{{__('frontend.nav.static.language_spanish')}}</a></li></div>

                                {{--BE--}}
                                <div id="BE" class="Languague">
                                <img src="/img/BELGIUM.png" alt="get paid to do surveys online">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">BE</li>
                                <li><a class="#" href="/lang/fr_BE">{{__('frontend.nav.static.language_french')}}</a></li>
                                <li><a class="#" href="/lang/nl_BE">{{__('frontend.nav.static.language_dutch')}}</a></li>
                                <li><a class="#" href="/lang/de_BE">{{__('frontend.nav.static.language_german')}}</a></li></div>

                                {{--BR--}}
                                <div id="BR" class="Languague">
                                <img src="/img/BRAZIL.png" alt="get paid to take surveys online">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">BR</li>
                                <li><a class="#" href="/lang/pt_BR">{{__('frontend.nav.static.language_portuguese')}}</a></li></div>

                                {{--CL--}}
                                <div id="CL" class="Languague">
                                <img src="/img/CHILE.png" alt="online surveys that pay instantly">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CL</li>
                                <li><a class="#" href="/lang/es_CL">{{__('frontend.nav.static.language_spanish')}}</a></li></div>

                                {{--CO--}}
                                <div id="CO" class="Languague">
                                <img src="/img/COLOMBIA.png" alt="online surveys and get paid">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CO</li>
                                <li><a class="#" href="/lang/es_CO">{{__('frontend.nav.static.language_spanish')}}</a></li></div>


                                {{--DK--}}
                                <div id="DK" class="Languague">
                                <img src="/img/DENMARK.png" alt="real online surveys for money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">DK</li>
                                <li><a class="#" href="/lang/en_DK">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/de_DK">{{__('frontend.nav.static.language_german')}}</a></li>
                                <li><a class="#" href="/lang/da_DK">{{__('frontend.nav.static.language_danish')}}</a></li></div>

                                {{--EG--}}
                                <div id="EG" class="Languague">
                                <img src="/img/EGYPT.png" alt="real cash surveys online">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">EG</li>
                                <li><a class="#" href="/lang/en_EG">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/ar_EG">{{__('frontend.nav.static.language_arabic')}}</a></li></div>

                                {{--HK--}}
                                <div id="HK" class="Languague">
                                <img src="/img/HONG KONG.png" alt="money through surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">HK</li>
                                <li><a class="#" href="/lang/en_HK">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/zh_HK">{{__('frontend.nav.static.language_chinese')}}</a></li></div>

                                {{--ID--}}
                                <div id="ID" class="Languague">
                                <img src="/img/INDONESIA.png" alt="answer surveys and earn">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">ID</li>
                                <li><a class="#" href="/lang/en_ID">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/id_ID">{{__('frontend.nav.static.language_indonesian')}}</a></li></div>

                                {{--JP--}}
                                <div id="JP" class="Languague">
                                <img src="/img/JAPAN.png" alt="get paid for answering surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">JP</li>
                                <li><a class="#" href="/lang/jp_JP">{{__('frontend.nav.static.language_japanese')}}</a></li></div>

                                {{--KW--}}
                                <div id="KW" class="Languague">
                                <img src="/img/KWAIT.png" alt="answer surveys and get paid">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">KW</li>
                                <li><a class="#" href="/lang/ar_KW">{{__('frontend.nav.static.language_arabic')}}</a></li></div>


                                {{--MY--}}
                                <div id="MY" class="Languague">
                                <img src="/img/MALAYSIA.png" alt="earn by taking surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">MY</li>
                                <li><a class="#" href="/lang/zh_MY">{{__('frontend.nav.static.language_chinese')}}</a></li>
                                <li><a class="#" href="/lang/ms_MY">{{__('frontend.nav.static.language_malay')}}</a></li>
                                <li><a class="#" href="/lang/en_MY">{{__('ENGLISH ')}}</a></li></div>

                                {{--MX--}}
                                <div id="MX" class="Languague">
                                <img src="/img/MEXICO.png" alt="trusted survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">MX</li>
                                <li><a class="#" href="/lang/es_MX">{{__('frontend.nav.static.language_spanish')}}</a></li></div>


                                {{--NL--}}
                                <div id="NL" class="Languague">
                                <img src="/img/NETHERLANDS.png" alt="trustworthy survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">NL</li>
                                <li><a class="#" href="/lang/en_NL">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/nl_NL">{{__('frontend.nav.static.language_dutch')}}</a></li></div>

                                {{--NO--}}
                                <div id="NO" class="Languague">
                                <img src="/img/NORWAY.png" alt="real paying survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">NO</li>
                                <li><a class="#" href="/lang/en_NO">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/no_NO">NORWEGIAN</a></li>
                                <li><a class="#" href="/lang/de_NO">{{__('frontend.nav.static.language_german')}}</a></li></div>

                                {{--PE--}}
                                <div id="PE" class="Languague">
                                <img src="/img/PERU.png" alt="real survey websites that pay">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">PE</li>
                                <li><a class="#" href="/lang/es_PE">{{__('frontend.nav.static.language_spanish')}}</a></li></div>

                                {{--PH--}}
                                <div id="PH" class="Languague">
                                <img src="/img/PHILIPPINES.png" alt="real money survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">PH</li>
                                <li><a class="#" href="/lang/en_PH">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fp_PH">FILIPINO/TAGALOG</a></li></div>

                                {{--PL--}}
                                <div id="PL" class="Languague">
                                <img src="/img/POLAND.png" alt="website for surveys that pay">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">PL</li>
                                <li><a class="#" href="/lang/pl_PL">{{__('frontend.nav.static.language_polish')}}</a></li></div>


                                {{--RU--}}
                                <div id="RU" class="Languague">
                                <img src="/img/RUSSIA.png" alt="daily survey and earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">RU</li>
                                <li><a class="#" href="/lang/en_RU">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/ru_RU">{{__('frontend.nav.static.language_russian')}}</a></li></div>

                                {{--SG--}}
                                <div id="SG" class="Languague">
                                <img src="/img/SINGAPORE.png" alt="online earning survey sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">SG</li>
                                <li><a class="#" href="/lang/zh_SG">{{__('frontend.nav.static.language_chinese')}}</a></li>
                                <li><a class="#" href="/lang/en_SG">{{__('ENGLISH ')}}</a></li></div>

                                {{--SE--}}
                                <div id="SE" class="Languague">
                                <img src="/img/SWEDEN.png" alt="answer paid surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">SE</li>
                                <li><a class="#" href="/lang/sv_SE">{{__('frontend.nav.static.language_swedish')}}</a></li></div>

                                {{--CH--}}
                                <div id="CH" class="Languague">
                                <img src="/img/SWITSERLAND.png" alt="give survey and earn money">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">CH</li>
                                <li><a class="#" href="/lang/en_CH">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/fr_CH">{{__('frontend.nav.static.language_french')}}</a></li>
                                <li><a class="#" href="/lang/de_CH">{{__('frontend.nav.static.language_german')}}</a></li></div>

                                {{--TW--}}
                                <div id="TW" class="Languague">
                                <img src="/img/TAIWAN.png" alt="legit survey paying sites">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">TW</li>
                                <li><a class="#" href="/lang/zh_TW">{{__('frontend.nav.static.language_chinese')}}</a></li></div>

                                {{--AE--}}
                                <div id="AE" class="Languague">
                                <img src="/img/UAE.png" alt="paid instantly surveys">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li class="dropdown-header">AE</li>
                                <li><a class="#" href="/lang/en_AE">{{__('ENGLISH ')}}</a></li>
                                <li><a class="#" href="/lang/ar_AE">{{__('frontend.nav.static.language_arabic')}}</a></li>
                                </div>

                              </div>
                        </ul>
                    <!-- </li> -->
                    <input type="hidden" id="cc" value="{{$country_code}}" />
                    <img id="img_01" class="dropdown-toggle" alt="legitimate paid survey sites" id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" src="/img/{{$flags}}.png" style="border: 1px solid #DCDCDC; " />
                     <!-- <div class="dropdown-toggle" id="img_01" data-toggle="dropdown">
                      <img id="selected_country" src="img/Group 57.png" />
                      <span id="selected_country_code"></span>
                      <span id="selected_language"></span>
                    </div> -->
                  </h4>
                </div>
                
              </div>

                <!-- <form action="{{url('/')}}/register" method="POST" id="form"> -->
               
                  @csrf
                   {{ html()->form('POST', route('frontend.auth.password.email.post'))->open() }} 
                  <div class="form-outline input-control mb-4">
                    <!-- {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }} -->
                    <label class="form-label form_label_style" for="email" >{{(__('validation.attributes.frontend.email'))}}</label>
                  <!-- <label class="form-label form_label_style" for="email" >Email</label> -->
                    <input type="email" id="email" class="form-control" value="{{old('email')}}" maxlength="191" placeholder="" name="email" onkeyup="validateEmail()" required />
                    <div class="clearfix"></div>

                    <div class="message-div">
                    <p id="email-error1" class="error"></p>
                  </div>
                      <!-- @if($errors->any())
                      @foreach ($errors->all() as $error)
                          <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif  -->
<!--                           @if($errors->has('email'))
                          <div class="text-danger">{{ $errors->first('email')}}</div>
                          @endif -->
                  </div>
                 

                  <div class="form-outline input-control mb-4">
                  
    
  

                 


                  <div class="pt-1 mb-5 pb-1" style="" id="proc">
                  <button class="btn-style btn mb-3" id="submit" onclick="return submit()" type="submit">
    {{ __('frontend.index.contact_us.reset_password_button') }}
</button>


                  </div>
                  <div style="margin-top: 60px";></div>




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
@endsection
@php
       if($country_code=='UK'){
       $countryCode="GB";
       }else{
         $countryCode=$country_code;
       }
@endphp

@push('after-scripts')
    <script>
        @if (session('status'))
        $(document).ready(function () {
            toastr.success("{!! Session::get('message')!!}", {!! __('password.sent') !!});
        })
        @endif
        @php Session::forget('message'); @endphp

        


  $(document).on('mouseover','.arrowpopup',function(){
  var tt = document.getElementById("tooltipdemo");

    });
    $(".arrowpopup").hover(
  function () {
   
    
    $("#tooltipdemo").show();
  }, 
  function () {
   
    $("#tooltipdemo").hide();
    
  }
);


         $(document).ready(function() {
          var country_code = $('#cc').val();
    $("#"+country_code).show();
    $("#show_hide_password1 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password1 input').attr("type") == "text"){
            $('#show_hide_password1 input').attr('type', 'password');
            $('#show_hide_password1 svg').addClass( "fa-eye-slash" );
            $('#show_hide_password1 svg').removeClass( "fa-eye" );
        }
        else if($('#show_hide_password1 input').attr("type") == "password"){
            $('#show_hide_password1 input').attr('type', 'text');
            $('#show_hide_password1 svg').removeClass( "fa-eye-slash" );
            $('#show_hide_password1 svg').addClass( "fa-eye" );
        }
    });
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password svg').addClass( "fa-eye-slash" );
            $('#show_hide_password svg').removeClass( "fa-eye" );
        }
        else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password svg').removeClass( "fa-eye-slash" );
            $('#show_hide_password svg').addClass( "fa-eye" );
        }
    });
});


var emailError = document.getElementById('email-error1');


function validateEmail(){
  // alert("hello");
    var email = document.getElementById('email').value;
    if(email.length == 0){
        emailError.innerHTML = '{{(__('validation.attributes.frontend.email_require'))}}';
        return false;
    }
    if(!email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
        emailError.innerHTML = '{{(__('validation.attributes.frontend.email_valid'))}}';
        return false;
    }
    emailError.innerHTML = '';
    return true;
}




const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('create_pass');
const confirmPasswordInput = document.getElementById('confirm_pass');
const submitButton = document.getElementById('submit');

emailInput.addEventListener('input', validateForm);
passwordInput.addEventListener('input', validateForm);
confirmPasswordInput.addEventListener('input', validateForm);


function validateForm() {

    if(!validateEmail()){

    submitButton.disabled = true;
    return false;
  }
  else{
    submitButton.style.background = "#006BDE";
    submitButton.style.color = "white";
    submitButton.disabled = false;
  }
}



    </script>
@endpush

