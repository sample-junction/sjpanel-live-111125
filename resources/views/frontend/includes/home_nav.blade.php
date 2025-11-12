<div class="container-fluid">

    <div class="row">

        <header>

            <nav class="navbar fixed-top p-sm-2 p-md-2 border-bottom" style="background-color: white;">
                <div class="container-fluid">


                    <div class="cst-sec {{ in_array(session()->get('locale'), ['fr_CA', 'es_US']) ? 'ms-lg-3' : 'ms-lg-5' }}">

                        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="border:none" id="hamB">

                            <span style="width:30px; height:30px; display:inline-block; background-image: url('/img/Side bar hamburger Icon.webp'); background-repeat: no-repeat; background-size: contain;"></span>

                        </button>

                        <a class="navbar-brand d-none d-lg-inline-block" href="/"><img src="images/SJ Panel New LOGO without background.png" alt="trustworthy survey sites" width="140" height="50" id="logoId" class="img-fluid ms-lg-4"></a>

                    </div>




                    @php
                        if(session()->get('locale') == 'fr_CA'){
                            $marginClass = 'me-3';
                        }elseif(session()->get('locale') == 'es_US'){
                            $marginClass = 'me-2';
                        }else{
                            $marginClass = 'me-4';
                        }
                    @endphp

                    <div class="cst-sec menu_part_2">

                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a id="home" class="text-dark page-scroll nav-list active">{{__('frontend.nav.static.heading_1')}}</a>
                        </span>

                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a id="features" class="text-dark page-scroll nav-list">{{__('frontend.nav.static.heading_2')}}</a>
                        </span>

                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a id="testimonials" class="text-dark page-scroll nav-list">{{__('frontend.nav.static.heading_3')}}</a>
                        </span>

                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a id="contact" class="text-dark page-scroll nav-list">{{__('frontend.nav.static.heading_4')}}</a>
                        </span>

                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a id="faq-section" class="text-dark nav-list">{{__('frontend.index.footer.links.FAQ')}}</a>
                        </span>

                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a id="blog-section" class="text-dark nav-list">{{__('frontend.nav.static.heading_6')}}</a>
                        </span>


                        <!--@if( session()->get('locale') == 'fr_CA')


                    <span class="me-4 d-none d-lg-inline-block">
                        <a href="/pages/rewards" class="text-dark nav-list">{{__('frontend.nav.static.heading_7')}}</a>
                    </span>
					
					@else
						
					<span class="me-4 d-none d-lg-inline-block">
                        <a href="/pages/rewards" class="text-dark nav-list">Rewards</a>
                    </span>
						
					@endif -->

                        <!-- [30-05-2024] -->
                        <span class="{{ $marginClass }} d-none d-lg-inline-block">
                            <a href="/pages/rewards" class="text-dark nav-list">{{__('frontend.nav.static.heading_7')}}</a>
                        </span>

                        @auth

                        <span class="me-1 me-lg-4">
                            <a href="{{route('inpanel.dashboard')}}" class="text-light ps-2 pt-2 pb-2 pe-2 ps-lg-4 pe-lg-4 pt-lg-2 pb-lg-2" style="background: #1080D0; border-radius: 35px; font-size: 13px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.link.home')}}</a>
                        </span>

                        @else
                        <span class="me-1 d-inline-block">
                            <a href="{{ route('frontend.auth.login') }}" class="text-dark nav-list">{{__('frontend.nav.static.link.login')}}</a>
                        </span>

                        @if( session()->get('locale') == 'fr_CA')

                        <span class="me-2 me-lg-4">
                            <a href="{{route('frontend.auth.register')}}" class="text-light ps-2 pt-2 pb-2 pe-2 ps-lg-4 pe-lg-4 pt-lg-2 pb-lg-2" style="background: #0d6efd; border-radius: 35px; font-size: 13px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.heading_8')}}</a>
                        </span>

                        @else
                        <span class="me-2 me-lg-4">
                            <a href="{{route('frontend.auth.register')}}" class="text-light ps-2 pt-2 pb-2 pe-2 ps-lg-4 pe-lg-4 pt-lg-2 pb-lg-2" style="background: #0d6efd; border-radius: 35px; font-size: 13px; text-decoration: none; font-weight: 600;">{{__('frontend.index.footer.links.join_now_home')}}</a>
                        </span>

                        @endif



                        @endauth



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


                        <!-- Language Section -->
                        <span class="me-lg-4 d-inline-block nav-item dropdown ">
                            <a class="nav-link dropdown-toggle rounded count_name fw-bold" style="background: transparent;border:1px solid rgb(235, 228, 228);padding:4px 8px;font-size:14px;" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @php
                                $flagPath = file_exists(public_path('img/'.$flags.'.png'))
                                ? asset('img/'.$flags.'.png')
                                : asset('img/'.$flags.'.webp');
                                @endphp
                                <i style="padding: 0px;"><span class="flag-icon" style="background-image: url('{{ $flagPath }}');width: 76px; height: 32px; display: inline-block;"></span></i>
                                {{-- @if(!empty($currentLanguage)) {{$currentLanguage->language_code}} @endif --}}

                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="box-shadow: 0 0 3px rgba(86, 96, 117, 0.7); transform: translateX(-25%); min-width:82px;">

                                <div class=" dropdown-item" style="background-color:white!important;padding:0px auto;">
                                    {{--US--}}
                                    @if($countryCode=='US')
                                    <div id="US" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;">
                                            <img class="lang_img" src="{{url('img/USA.webp')}}" alt="easy cash surveys" onclick="changeImage(this, 'US-EN' ,'img/USA.webp' )">
                                            <span class="lang_let ms-2"> US</span>
                                        </div>

                                        <li>
                                            <a href="/lang/en_US" class="lang_text" onclick="changeImage(this, 'US-EN' ,'img/USA.webp' )">{{__('ENGLISH US')}} </a>
                                        </li>
                                        <li>
                                            <a href="/lang/es_US" class="lang_text2" onclick="changeImage(this, 'US-ES' ,'img/USA.webp' )">{{__('frontend.nav.static.language_spanish')}} US</a>
                                        </li>
                                    </div>

                                    @endif

                                    {{--CA--}}
                                    @if($countryCode=='CA')
                                    <div id="CA" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><span style="background-image: url('/img/CANADA.webp');"></span><span class="lang_let">CA</span></div>


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
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/UNITED_KINGDOM.png')}}" alt="give survey and earn money"> <span class="lang_let">UK</span></div>

                                        <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH UK')}}</a></li>
                                    </div>

                                    @endif

                                    {{--ES--}}
                                    @if($countryCode=='ES')
                                    <div id="ES" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/SPAIN.png')}}" alt="legit survey paying sites"> <span class="lang_let">ES</span></div>

                                        <li><a class="lang_text" href="/lang/en_ES" class="#">{{__('ENGLISH ES')}} </a></li>
                                        <li><a class="lang_text2" href="/lang/fr_ES" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_spanish')}} ES </a></li>
                                    </div>

                                    @endif
                                    {{--DE--}}
                                    @if($countryCode=='DE')
                                    <div id="DE" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/GERMANY.png')}}" alt="paid instantly surveys"> <span class="lang_let">DE</span></div>

                                        <li><a class="lang_text" href="/lang/en_DE" class="#">{{__('ENGLISH DE')}} </a></li>
                                        <li><a class="lang_text2" href="/lang/fr_DE" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_german')}} DE </a></li>
                                    </div>

                                    @endif
                                    {{--AU--}}
                                    @if($countryCode=='AU')
                                    <div id="AU" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/AUSTRALIA.png')}}" alt="legitimate paid survey sites"> <span class="lang_let">AU</span></div>

                                        <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH AU')}} </a></li>
                                    </div>

                                    @endif
                                </div>
                                <div class=" dropdown-item" style="background-color:white!important;">
                                    {{--UK--}}
                                    @if($countryCode=='UK')
                                    <div id="UK" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;"><img class="lang_img" src="{{url('img/UNITED KINGDOM.png')}}" alt="legit survey websites that pay"> <span class="lang_let">UK</span></div>

                                        <li><a class="lang_text" href="/lang/en_UK" class="#">{{__('ENGLISH UK')}} </a></li>
                                    </div>


                                    @endif
                                    {{--FR--}}
                                    @if($countryCode=='FR')
                                    <div id="FR" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/FRANCE.png')}}" alt="surveys that pay immediately"> <span class="lang_let">FR</span></div>

                                        <li><a class="lang_text" href="/lang/en_FR" class="#">{{__('ENGLISH FR')}} </a></li>
                                        <li><a class="lang_text2" href="/lang/fr_FR" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_french')}} FR </a></li>
                                    </div>

                                    @endif
                                    {{--IT--}}
                                    @if($countryCode=='IT')
                                    <div id="IT" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/ITALY.png')}}" alt="paid survey sites that are legit"> <span class="lang_let">IT</span></div>

                                        <li><a class="lang_text" href="/lang/en_IT" class="#">{{__('ENGLISH IT')}} </a></li>
                                        <li><a class="lang_text2" href="/lang/it_IT" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_italian')}} IT </a></li>
                                    </div>

                                    @endif
                                    {{--IN--}}
                                    @if($countryCode=='IN')
                                    <div id="IN" class="Languague" style="display: block;font-weight:600;">
                                        <div style="display:flex;margin-bottom:10px;height:20px;text-align:center;"><img class="lang_img" src="{{url('img/INDIA.png')}}" alt="genuine survey sites"> <span class="lang_let">IN</span></div>

                                        <li><a class="lang_text" href="/lang/en_IN" class="#">{{__('ENGLISH IN')}} </a></li>
                                        <li><a class="lang_text2" href="/lang/hi_IN" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_hindi')}} IN </a></li>
                                    </div>
                                    @endif
                                </div>

                            </ul>

                        </span>
                        <!-- Language Section -->


                    </div>





                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header border-bottom">

                            <a class="" href="/"><img src="images/SJ Panel New LOGO without background.png" alt="get survey and earn money" width="150" height="60" class="img-fluid"></a>

                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav p-3 justify-content-end flex-grow-1 pe-3">

                                <li class="nav-item mt-2 mob-nav-active">
                                    <a href="" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: bold;">{{__('frontend.nav.static.heading_1')}}</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>

                                <li class="nav-item">
                                    <a id="features-mob" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.heading_2')}}</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>


                                <li class="nav-item">
                                    <a id="testimonials-mob" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.heading_3')}}</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>

                                <li class="nav-item">
                                    <a id="contact-mob" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.heading_4')}}</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>


                                <li class="nav-item">
                                    <a href="{{route('frontend.cms.faq')}}" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.index.footer.links.FAQ')}}</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>

                                <li class="nav-item">
                                    <a href="/blog" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.heading_6')}}</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>

                                <li class="nav-item">
                                    <a href="/pages/rewards" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">Rewards</a>
                                </li>

                                <li>
                                    <hr class="cst-space">
                                </li>

                                @auth

                                <li class="nav-item">
                                    <a href="{{route('inpanel.dashboard')}}" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.link.home')}}</a>
                                </li>

                                @else

                                <li class="nav-item">
                                    <a href="{{route('frontend.auth.login')}}" class="text-dark" style="font-size: 14px; text-decoration: none; font-weight: 600;">{{__('frontend.nav.static.link.login')}}</a>
                                </li>

                                @endauth

                            </ul>

                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </div>
</div>