<!-- ########################### SECTION START ########################### -->
@php
$geoip = geoip(request()->ip());
        $ipcountryCode = $geoip->getAttribute('iso_code');
        $langString = session()->get('locale');
        $location = explode('_', $langString);
        $country = $location[1];
        if($ipcountryCode != $country){
            $countryCode = $ipcountryCode;
        }else{
            $countryCode = $ipcountryCode;
        }
        
@endphp

<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">{{__('frontend.nav2.static.title')}}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              <a class="navbar-brand" href="{{ route('frontend.index') }}"><img style="width: 60%;" src="{{ asset('/images/logo.png') }}" alt="websites that pay you for surveys" class="logo-name"></a>
            </div>
           <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right" >
                    <li>
                        <div class="blink_me">{{__('frontend.nav.static.binker')}} <span class="glyphicon glyphicon-arrow-right"></span></div>
                    </li>                     

                    <li class="dropdown language_dropdown" id="country_language_nav">                        
                        <a class="dropdown-toggle" id="language-button" style="color:#005ce6;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-globe"></i>
                            @if(!empty($currentLanguage)) {{$currentLanguage->language_code}} @endif
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right all_language_list" aria-labelledby="language-button" style="min-width:120px;">
                            <li class="dropdown-header">
                                @if(!empty($currentLanguage)) {{$currentLanguage->display_name}} - {{$currentLanguage->country->country_code}} (Selected) @endif
                            </li>
                            <div class="col-md-61" style="width: 120px;margin-left: 10px;">
                                {{--US--}}
                                <!-- <li role="separator" class="divider"></li> -->
                                {{--
                                <li class="dropdown-header">{{__('frontend.nav.static.language_1')}}</li>
                                <li><a class="#" href="/lang/en_US">{{__('frontend.nav.static.language_2')}}</a></li>
                                <li><a href="/lang/es_US">{{__('frontend.nav.static.language_3')}}</a></li>
                                --}}
                                @if($countryCode=='US')
                                <li class="dropdown-header">US</li>
                                <li><a class="#" href="/lang/en_US">{{__('ENGLISH US')}}</a></li>
                                <li><a href="/lang/es_US">{{__('frontend.nav.static.language_spanish')}} US</a></li>
                                @endif
                                
                                {{--CA--}}
                                 @if($countryCode=='CA')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">CA</li>
                                <li><a class="#" href="/lang/en_CA">{{__('ENGLISH CA')}}</a></li>
                                <li><a class="#" href="/lang/fr_CA">{{__('frontend.nav.static.language_french')}} CA</a></li>
                                @endif

                                {{--ES--}}
                                @if($countryCode=='ES')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">ES</li>
                                <li><a class="#" href="/lang/en_ES">{{__('ENGLISH ES')}}</a></li>
                                <li><a class="#" href="/lang/es_ES">{{__('frontend.nav.static.language_spanish')}} ES</a></li>
                                 @endif
                                {{--DE--}}
                                @if($countryCode=='DE')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">DE</li>
                                <li><a class="#" href="/lang/en_DE">{{__('ENGLISH DE')}}</a></li>
                                <li><a class="#" href="/lang/de_DE">{{__('frontend.nav.static.language_german')}} DE</a></li>
                                 @endif
                                {{--AU--}}
                                @if($countryCode=='AU')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">AU</li>
                                <li><a class="#" href="/lang/en_AU">{{__('ENGLISH AU')}}</a></li>
                                 @endif
                                 {{--AR--}}
                                @if($countryCode=='AR')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">AR</li>
                                <li><a class="#" href="/lang/en_AR">{{__('ENGLISH AR')}}</a></li>
                                <li><a class="#" href="/lang/es_AR">{{__('frontend.nav.static.language_spanish')}} AR</a></li>
                                 @endif
                                 {{--BE--}}
                                @if($countryCode=='BE')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">BE</li>
                                <li><a class="#" href="/lang/fr_BE">{{__('frontend.nav.static.language_french')}} BE</a></li>
                                <li><a class="#" href="/lang/nl_BE">{{__('frontend.nav.static.language_dutch')}} BE</a></li>
                                <li><a class="#" href="/lang/de_BE">{{__('frontend.nav.static.language_german')}} BE</a></li>
                                 @endif
                                 {{--BR--}}
                                @if($countryCode=='BR')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">BR</li>
                                <li><a class="#" href="/lang/pt_BR">{{__('frontend.nav.static.language_portuguese')}} BR</a></li>
                                 @endif
                                 {{--CL--}}
                                @if($countryCode=='CL')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">CL</li>
                                <li><a class="#" href="/lang/es_CL">{{__('frontend.nav.static.language_spanish')}} CL</a></li>
                                 @endif
                                 {{--CN--}}
                                @if($countryCode=='CN')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">CN</li>
                                <li><a class="#" href="/lang/zh_CN">{{__('frontend.nav.static.language_chinese')}} CN</a></li>
                                <li><a class="#" href="/lang/en_CN">{{__('ENGLISH CN')}}</a></li>
                                 @endif
                                 {{--CO--}}
                                @if($countryCode=='CO')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">CO</li>
                                <li><a class="#" href="/lang/es_CO">{{__('frontend.nav.static.language_spanish')}} CO</a></li>
                                 @endif
                                 {{--DK--}}
                                @if($countryCode=='DK')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">DK</li>
                                <li><a class="#" href="/lang/en_DK">{{__('ENGLISH DK')}}</a></li>
                                <li><a class="#" href="/lang/de_DK">{{__('frontend.nav.static.language_german')}} DK</a></li>
                                <li><a class="#" href="/lang/da_DK">{{__('frontend.nav.static.language_danish')}} DK</a></li> 
                                 @endif
                                 {{--EG--}}
                                @if($countryCode=='EG')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">EG</li>
                                <li><a class="#" href="/lang/en_EG">{{__('ENGLISH EG')}}</a></li>
                                <li><a class="#" href="/lang/ar_EG">{{__('frontend.nav.static.language_arabic')}} EG</a></li>
                                 @endif
                                 {{--HK--}}
                                @if($countryCode=='HK')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">HK</li>
                                <li><a class="#" href="/lang/en_HK">{{__('ENGLISH HK')}}</a></li>
                                <li><a class="#" href="/lang/zh_HK">{{__('frontend.nav.static.language_chinese')}} HK</a></li>
                                 @endif
                                 {{--ID--}}
                                @if($countryCode=='ID')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">ID</li>
                                <li><a class="#" href="/lang/en_ID">{{__('ENGLISH ID')}}</a></li>
                                <li><a class="#" href="/lang/id_ID">{{__('frontend.nav.static.language_indonesian')}} ID</a></li>
                                 @endif
                                 {{--JP--}}
                                @if($countryCode=='JP')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">JP</li>
                                <li><a class="#" href="/lang/jp_JP">{{__('frontend.nav.static.language_japanese')}} JP</a></li>
                                 @endif
                                 {{--KW--}}
                                @if($countryCode=='KW')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">KW</li>
                                <li><a class="#" href="/lang/ar_KW">{{__('frontend.nav.static.language_arabic')}} KW</a></li>
                                 @endif
                            </div>
                            <div class="col-md-61" style="margin-left: 10px;width: 90% !important;">
                                {{--UK--}}
                                <!-- <li role="separator" class="divider"></li> -->
                                @if($countryCode=='UK')
                                <li class="dropdown-header">UK</li>
                                <li><a class="#" href="/lang/en_UK">{{__('ENGLISH UK')}}</a></li>
                                <li>&nbsp;</li>
                                @endif
                                {{--FR--}}
                                @if($countryCode=='FR')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">FR</li>
                                <li><a class="#" href="/lang/en_FR">{{__('ENGLISH FR')}}</a></li>
                                <li><a class="#" href="/lang/fr_FR">{{__('frontend.nav.static.language_french')}} FR</a></li>
                                @endif
                                {{--IT--}}
                                 @if($countryCode=='IT')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">IT</li>
                                <li><a class="#" href="/lang/en_IT">{{__('ENGLISH IT')}}</a></li>
                                <li><a class="#" href="/lang/it_IT">{{__('frontend.nav.static.language_italian')}} IT</a></li>
                                @endif
                                {{--IN--}}
                                @if($countryCode=='IN')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">IN</li>
                                <li><a class="#" href="/lang/en_IN">{{__('ENGLISH IN')}}</a></li>
                                <li><a class="#" href="/lang/hi_IN">{{__('frontend.nav.static.language_hindi')}} IN</a></li>
                                @endif
                                {{--MY--}}
                                @if($countryCode=='MY')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">MY</li>
                                <li><a class="#" href="/lang/zh_MY">{{__('frontend.nav.static.language_chinese')}} MY</a></li>
                                <li><a class="#" href="/lang/ms_MY">{{__('frontend.nav.static.language_malay')}} MY</a></li>
                                <li><a class="#" href="/lang/en_MY">{{__('ENGLISH MY')}}</a></li>
                                @endif
                                {{--MX--}}
                                @if($countryCode=='MX')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">MX</li>
                                <li><a class="#" href="/lang/es_MX">{{__('frontend.nav.static.language_spanish')}} MX</a></li>
                                @endif
                                {{--NL--}}
                                @if($countryCode=='NL')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">NL</li>
                                <li><a class="#" href="/lang/en_NL">{{__('ENGLISH NL')}}</a></li>
                                <li><a class="#" href="/lang/nl_NL">{{__('frontend.nav.static.language_dutch')}} NL</a></li>
                                @endif
                                {{--NO--}}
                                @if($countryCode=='NO')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">NO</li>
                                <li><a class="#" href="/lang/en_NO">{{__('ENGLISH NO')}}</a></li>
                                <li><a class="#" href="/lang/no_NO">{{__('frontend.nav.static.language_norway')}} NO</a></li>
                                <li><a class="#" href="/lang/de_NO">{{__('frontend.nav.static.language_german')}} NO</a></li>
                                @endif
                                {{--PE--}}
                                @if($countryCode=='PE')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">PE</li>
                                <li><a class="#" href="/lang/es_PE">{{__('frontend.nav.static.language_spanish')}} PE</a></li>
                                @endif
                                {{--PH--}}
                                @if($countryCode=='PH')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">PH</li>
                                <li><a class="#" href="/lang/en_PH">{{__('ENGLISH PH')}}</a></li>
                                <li><a class="#" href="/lang/fp_PH">FILIPINO/TAGALOG PH</a></li>
                                @endif
                                {{--PL--}}
                                @if($countryCode=='PL')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">PL</li>
                                <li><a class="#" href="/lang/pl_PL">{{__('frontend.nav.static.language_polish')}} PL</a></li>
                                @endif
                                {{--RU--}}
                                @if($countryCode=='RU')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">RU</li>
                                <li><a class="#" href="/lang/en_RU">{{__('ENGLISH RU')}}</a></li>
                                <li><a class="#" href="/lang/ru_RU">{{__('frontend.nav.static.language_russian')}} RU</a></li>
                                @endif
                                {{--SG--}}
                                @if($countryCode=='SG')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">SG</li>
                                <li><a class="#" href="/lang/zh_SG">{{__('frontend.nav.static.language_chinese')}} SG</a></li>
                                <li><a class="#" href="/lang/en_SG">{{__('ENGLISH SG')}}</a></li>
                                @endif
                                {{--SE--}}
                                @if($countryCode=='SE')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">SE</li>
                                <li><a class="#" href="/lang/sv_SE">{{__('frontend.nav.static.language_swedish')}} SE</a></li>
                                @endif
                                {{--CH--}}
                                @if($countryCode=='CH')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">CH</li>
                                <li><a class="#" href="/lang/en_CH">{{__('ENGLISH CH')}}</a></li>
                                <li><a class="#" href="/lang/fr_CH">{{__('frontend.nav.static.language_french')}} CH</a></li>
                                <li><a class="#" href="/lang/de_CH">{{__('frontend.nav.static.language_german')}} CH</a></li>
                                @endif
                                {{--TW--}}
                                @if($countryCode=='TW')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">TW</li>
                                <li><a class="#" href="/lang/zh_TW">{{__('frontend.nav.static.language_chinese')}} TW</a></li>
                                @endif
                                {{--AE--}}
                                @if($countryCode=='AE')
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">AE</li>
                                <li><a class="#" href="/lang/en_AE">{{__('ENGLISH AE')}}</a></li>
                                <li><a class="#" href="/lang/ar_AE">{{__('frontend.nav.static.language_arabic')}} AE</a></li>
                                @endif
                            </div>
                        </ul>
                    </li>
                    @auth
                    <li class="hideonmobile getproposal ga-event-proposal-button-header menu-item menu-item-type-custom menu-item-object-custom">
                        <a href="{{route('inpanel.dashboard')}}" class="getStarted btn btn-primary">{{__('frontend.nav.static.link.home')}}</a>
                    </li>
                    @else
                        <li class="hideonmobile getproposal ga-event-proposal-button-header menu-item menu-item-type-custom2 menu-item-object-custom2">
                            <a href="{{route('frontend.auth.login')}}" class="getStarted btn btn-primary">
                                {{__('frontend.nav2.static.link.login')}}
                            </a>
                        </li>
                        @if (config('access.registration'))
                            <li class="hideonmobile getproposal ga-event-proposal-button-header menu-item menu-item-type-custom2 menu-item-object-custom2">
                                <a href="{{route('frontend.auth.register')}}" class="getStarted btn btn-primary">{{__('frontend.nav2.static.link.join_now')}}</a>
                            </li>
                        @endif
                    @endauth
                     @auth
                        <a href="{{ route('frontend.auth.logout') }}" class="btn btn-transparent"> <i class="fas fa-sign-out-alt"></i> {{__('inpanel.nav.button_logout')}}</a>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- ########################### SECTION END ########################### -->
