


<div class="container-fluid">

<div class="row">


    <header>

        <nav class="navbar fixed-top p-sm-1 p-md-3 border-bottom" style="background-color: white;">
            <div class="container-fluid mobile-menu_1">


                <div class="cst-sec ms-lg-5 mt-1 ms-md-5 mobile_p_1">

                   <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="border:none" id="hamB">
                    <img src="{{url('img/jpblog/img/Side bar hamburger Icon.png')}}" alt="best survey site" class="ms-lg-3 ms-1 hamBImg" width="30px">
                    </button>

                    <a class ="navbar-brand" href="/"><img src="{{asset('images/SJ Panel New LOGO without background.png')}}" alt="online survey site" width="140" height="50" id="" class="img-fluid ms-lg-4 ms-1 me-1"></a>

                  
                </div>




                

                <div class="cst-sec p-0 me-0 me-lg-5 me-lx-5 mobile_p_2">
             
                       <span class="me-1 me-lg-4">
                            <a class="text-light2 text-dark "  href="{{url('/')}}"  style="font-size: 16px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.heading_1')}}</a>
                        </span>
                       
                        @guest
                        <span class="me-1 me-lg-4">
                            <a class="text-light2 text-dark "  href="{{ route('frontend.auth.login') }}"  style="font-size: 16px; text-decoration: none; font-weight: 600;">{{__('frontend.nav2.static.link.login')}}</a>
                        </span>
                        @endguest
                        
                        
                    

                    <span class="me-lg-4 me-1">
                         @guest
                        <a href="{{route('frontend.auth.register')}}" class="text-light text_login ps-2 pt-1 pb-2 pe-2 ps-lg-4 pe-lg-4 pt-lg-2 pb-lg-2" style="background: #1080D0; border-radius: 35px; font-size: 14px; text-decoration: none; font-weight: 600;padding-bottom:15px">{{__('frontend.index.footer.links.join_now_home')}}</a>
                        @endguest
                        @auth
                        <a href="{{route('frontend.auth.register')}}" id="get" class="text-light text_login text_myhome ps-2 pt-1 pb-2 pe-2 ps-lg-4 pe-lg-4 pt-lg-2 pb-lg-2" style="background: #1080D0; border-radius: 35px; font-size: 14px; text-decoration: none; font-weight: 600;padding-bottom:15px">{{__('frontend.nav.static.link.home')}}</a>
                        @endauth
                    </span>

                    <!-- Language Section -->
                    <span class="me-1 d-inline-block d-lg-inline-block nav-item dropdown ">
                    <a class="nav-link dropdown-toggle rounded count_name fw-bold" style="background: transparent;border:1px solid rgb(235, 228, 228);padding:4px 8px;font-size:14px;" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            
                            <i style="padding: 0px;"><img id="img_01" style="height: 25px; min-width:60px; margin-top: 0px;padding:0px;" src="{{asset('/img/'.$flags.'.png')}}" alt="paid online survey"></i>
                           {{-- @if(!empty($currentLanguage)) {{$currentLanguage->language_code}} @endif --}}
                          
                       </a>
                       <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="box-shadow: 0 0 3px rgba(86, 96, 117, 0.7);">
                           
                           <div class=" dropdown-item" style="background-color:white!important;padding:0px auto;">
                               {{--US--}}
                               @if($countryCode=='US')
                               <div id="US"  class="flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;">
                                        <img class="lang_img" src="{{url('img/USA.png')}}" alt="legit survey site" onclickp="changeImage(this, 'US-EN' ,'img/USA.png' )">
                                       <span class="lang_let"> US</span>
                                    </div>
                                       
                                   <li >
                                        <a href="/lang/en_US" class="lang_text" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">{{__('ENGLISH US')}} </a>
                                    </li> 
                                   <li >
                                        <a href="/lang/es_US" class="lang_text2" onclick="changeImage(this, 'US-ES' ,'img/USA.png' )">{{__('frontend.nav.static.language_spanish')}} US </a>
                                    </li>
                               </div>
                               
                               @endif
                               
                               {{--CA--}}
                                @if($countryCode=='CA')
                                <div id="CA" class="flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/CANADA.png')}}" alt="online surveys to earn money"> <span class="lang_let">CA</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_CA" class="#">{{__('ENGLISH CA')}} </a></li> 
                                   <li><a class="lang_text2" href="/lang/fr_CA" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_french')}} CA </a></li>
                               </div>
                               
                               @endif
							   
								{{--UK--}}
                               @if($flags=='EN-UK')
                               <!--<div id="UK" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;"><img class="lang_img" src="{{url('img/EN-UK.png')}}"> <span class="lang_let">UK</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH UK')}} </a></li> 
                               </div>-->
							   
							   <div id="UK" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/UNITED_KINGDOM.png')}}" alt="fill surveys to earn money"> <span class="lang_let">UK</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH UK')}}</a></li> 
                               </div>
                               
                               
                               @endif							   

                               {{--ES--}}
                               @if($countryCode=='ES')
                               <div id="ES" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/SPAIN.png')}}" alt="fill survey and earn money"> <span class="lang_let">ES</span></div>
                                       
                                   <li ><a class="lang_text" href="/lang/en_ES" class="#">{{__('ENGLISH ES')}} </a></li> 
                                   <li ><a class="lang_text2" href="/lang/fr_ES" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_spanish')}} ES </a></li>
                               </div>
                               
                                @endif
                               {{--DE--}}
                               @if($countryCode=='DE')
                               <div id="DE" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/GERMANY.png')}}" alt="earn money answering surveys"> <span class="lang_let">DE</span></div>
                                       
                                   <li ><a class="lang_text" href="/lang/en_DE" class="#">{{__('ENGLISH DE')}} </a></li> 
                                   <li ><a class="lang_text2" href="/lang/fr_DE" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_german')}} DE </a></li>
                               </div>
                               
                                @endif
                               {{--AU--}}
                               @if($countryCode=='AU')
                               <div id="AU" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/AUSTRALIA.png')}}" alt="making money answering surveys"> <span class="lang_let">AU</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH AU')}} </a></li> 
                               </div>
                               
                                @endif
                           </div>
                           <div class=" dropdown-item" style="background-color:white!important;">
                               {{--UK--}}
                               @if($countryCode=='UK')
                               <div id="UK" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;"><img class="lang_img" src="{{url('img/UNITED KINGDOM.png')}}" alt="answer survey and earn money"> <span class="lang_let">UK</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH UK')}} </a></li> 
                               </div>
                               
                               
                               @endif
                               {{--FR--}}
                               @if($countryCode=='FR')
                               <div id="FR" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/FRANCE.png')}}" alt="making money doing surveys"> <span class="lang_let">FR</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_FR" class="#">{{__('ENGLISH FR')}} </a></li> 
                                   <li><a class="lang_text2" href="/lang/fr_FR" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_french')}} FR </a></li>
                               </div>
                               
                               @endif
                               {{--IT--}}
                                @if($countryCode=='IT')
                                <div id="IT" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/ITALY.png')}}" alt="take surveys and earn money"> <span class="lang_let">IT</span></div>
                                       
                                   <li ><a class="lang_text" href="/lang/en_IT" class="#">{{__('ENGLISH IT')}} </a></li> 
                                   <li ><a class="lang_text2" href="/lang/it_IT" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_italian')}} IT </a></li>
                               </div>
                               
                               @endif
                               {{--IN--}}
                               @if($countryCode=='IN')
                               <div id="IN" class="Languague flag_div" style="display: block;font-weight:600;">
                                   <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/INDIA.png')}}" alt="earn money completing surveys"> <span class="lang_let">IN</span></div>
                                       
                                   <li><a class="lang_text" href="/lang/en_IN" class="#">{{__('ENGLISH IN')}} </a></li> 
                                   <li><a class="lang_text2" href="/lang/hi_IN" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_hindi')}} IN </a></li>
                               </div>
                               @endif
                           </div>
                           
                       </ul>

                       
                       

                    </span>
                <!-- Language Section -->
                     @auth
                    <span class="me-lg-4 ms-lg-4 ms-1 p-sm-0">
                            <a class="text-light2" href="{{ route('frontend.auth.logout') }}" style="font-size: 14px; text-decoration: none; font-weight: 600;color:#337ab7;"> <i class="fas fa-sign-out-alt" style="color: #337ab7;"></i> {{__('inpanel.nav.button_logout')}}</a>
                    </span>
                    @endauth
              

                </div>





                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header border-bottom">

                        <a class="" href="/"><img src="{{url('img/jpblog/img/logo.png')}}" alt="complete survey and earn money" width="150px" class="img-fluid"></a>

                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav p-3 justify-content-end flex-grow-1 pe-3">

                            <li class="nav-item mt-2 mob-nav-active">
                                @guest
                                <a href="{{route('frontend.auth.register')}}" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: bold;">{{__('frontend.index.footer.links.join_now_home')}}</a>
                                @endguest
                                @auth
                                <a href="{{route('frontend.auth.register')}}" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: bold;">{{__('frontend.nav.static.link.home')}}</a>
                                @endauth
                            </li>

                            <li> <hr class="cst-space"> </li>

                            @auth
                            <li class="nav-item">
                                <a href="{{ route('frontend.auth.logout') }}" style="font-size: 14px; text-decoration: none; font-weight: 600;color:#337ab7;"> <i class="fas fa-sign-out-alt" style="color: #337ab7;"></i> {{__('inpanel.nav.button_logout')}}</a>
                            </li>
                            @endauth

                            @guest
                            <li class="nav-item">
                                <a href="{{route('frontend.auth.login')}}" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav2.static.link.login')}}</a>
                            </li>
                            @endguest
        
 
                        </ul>

                    </div>
                </div>
            </div>
        </nav>


    </header>

</div>

</div>






