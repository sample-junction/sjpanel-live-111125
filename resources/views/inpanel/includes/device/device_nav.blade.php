    <div class="col-2 mt-4 text-start ps-0  position-fixed d-none d-lg-block vertical-scrollable" id="style-5" style="background: #ffffff;overflow-y: scroll;height: 100%;">

    <ul style="list-style-type: none;">

        <li class="mt-4 mb-2  @yield('dashboard_select')"><a href="{{ route('inpanel.dashboard') }}" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif"><span>
                    <img src="{{asset('images/DashboardBoldIcon.png')}} " width="15px" class="img-fluid me-3" alt=""></span> {{__('inpanel.nav.dashboard')}} </a></li>

        <li class="mt-4 mb-2 @yield('myAccount_select')"><a href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif"><span>

                    @if(trim($__env->yieldContent('myAccount_select')))
                    <img src="{{asset('images/My Account Bolc Icon.png')}}" width="15px" style="margin-right: 16px !important" class="img-fluid me-3" alt="">
                    @else
                    <img src="{{asset('images/My Account Icon.png')}}" width="15px" style="margin-right: 16px !important" class="img-fluid me-3" alt="">
                    @endif
                </span>{{__('inpanel.nav.my_account')}} </a></li>

        <li>
            <hr class="cst-space">
        </li>

        <li class="mt-4 mb-2 @yield('detailProfile_select')" id="detailed_Profile"><a href="@if(Route::has('inpanel.profiler.show')){{ route('inpanel.profiler.show') }}@endif" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif">
                <span>
                    @if(trim($__env->yieldContent('detailProfile_select')))
                    <img src="{{asset('images/Detailed Profile Bold icon.png')}}" width="15px" class="img-fluid me-3" alt="">
                    @else
                    <img src="{{asset('images/Detailed Profile Icon.png')}}" width="15px" class="img-fluid me-3" alt="">
                    @endif
                </span> {{__('inpanel.nav.detailed_profile')}} </a></li>

        <!-- Code Added by Vikas for getting count of panelist and test panelist differently (Starting)-->
        @php
        $user = auth()->user();
        $userRole = $user->roles->pluck('name')->toArray();
        $surveys = session()->get('surveys');
        $testsurveys = session()->get('testsurveys');

        if (in_array('test panelist', $userRole)) {
        // Test Panelist → study_type_id = 12
        $num_live_sr = $testsurveys;

        } elseif (in_array('panelist', $userRole)) {
        // Panelist → study_type_id ≠ 12
        $num_live_sr = $surveys;
        } else {
        $num_live_sr = 0;
        }

        $count_sr = $num_live_sr > 0 ? 1 : 0;

        @endphp
        @php
        $registeredCountry = auth()->user()->country;
        if ($registeredCountry === 'UK') {
        $registeredCountry = 'GB';
        }
        @endphp

        @if($registeredCountry === $currentCountry)
        <li class="mt-4 mb-2 d-flex" id="survey_sec"><a href="@if(Route::has('inpanel.survey.index')){{ route('inpanel.survey.index') }}@endif" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif"><span><img src="{{asset('images/Surveys Icon.png')}}" width="15px" class="img-fluid me-3" alt=""></span> {{__('inpanel.nav.surveys')}}</a>
            @else
        <li class="mt-4 mb-2 d-flex" id="survey_sec"><a href="javascript:void(0)" onclick="showCustomCountryModal()" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif"><span><img src="{{asset('images/Surveys Icon.png')}}" width="15px" class="img-fluid me-3" alt=""></span> {{__('inpanel.nav.surveys')}}</a>
            @endif


            @if($count_sr!=0)
            <span class="text-primary small">({{$num_live_sr}})</span>
            <span><img src="{{asset('images/Ellipse 3.png')}}" alt="" style="transform:translateX(17px)"></span>
            @endif
        </li>

        <li>
            <hr class="cst-space">
        </li>

        <li class="mt-4 mb-2 @yield('points_select')" id="Reedem_Points"><a href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif">
                <span>
                    @if(trim($__env->yieldContent('points_select')))
                    <img src="{{asset('images/My Points Bold Icon.png')}}" width="15px" class="img-fluid me-3" alt="">
                    @else
                    <img src="{{asset('images/My Points Icon.png')}}" width="15px" class="img-fluid me-3" alt="">
                    @endif
                </span>{{__('inpanel.nav.label.reward_points')}} </a></li>

        <!-- <li class="mt-4 mb-2" id="Reedem_Points"><a href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif" ><span><img src="{{asset('images/Points redemption Icon.png')}}" width="15px" class="img-fluid me-3" alt=""></span> {{__('inpanel.nav.label.redeem_points')}} </a></li> -->

        <li class="mt-4 mb-2 @yield('invite_select')"><a href="@if(Route::has('inpanel.invite.show')){{ route('inpanel.invite.show') }}@endif" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif">
                <span>
                    @if(trim($__env->yieldContent('invite_select')))
                    <img src="{{asset('images/refer bold icon.png')}}" width="15px" style="margin-right: 16px !important" class="img-fluid me-3" alt="">
                    @else
                    <img src="{{asset('images/Refer a friend Icon.png')}}" width="15px" style="margin-right: 16px !important" class="img-fluid me-3" alt="">
                    @endif
                </span>
                {{__('inpanel.nav.label.refer')}} </a></li>

        <li>
            <hr class="cst-space">
        </li>

        <li class="mt-4 mb-2  @yield('panelistSupport_select')"><a href="@if(Route::has('inpanel.user.support')){{ route('inpanel.user.support') }}@endif" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif">
                <span>
                    @if(trim($__env->yieldContent('panelistSupport_select')))
                    <img src="{{asset('images\Panel Support Bold.png')}}" width="15px" class="img-fluid me-3" alt="icon">
                    @else
                    <img src="{{asset('images\Panelist Support Icon.png')}}" width="15px" class="img-fluid me-3" alt="icon">
                    @endif
                </span> {{__('inpanel.nav.panelist_support')}} </a></li>


        <li class="mt-4 mb-4"><a href="{{route('frontend.cms.faq')}}" class="side-menu-li mx-2" style="text-decoration: none;@if(auth()->user()->locale!='en_US') @endif"><span><img src="{{asset('images/FAQ Icone.png')}}" width="15px" class="img-fluid me-3" alt=""></span> {{__('inpanel.nav.label.faq')}} </a></li>
        <li>&nbsp;</li>
        <li>&nbsp;</li>
    </ul>
    <!-- Modal Added by Vikas (Starting)-->
    <!-- Country Mismatch Modal -->
    <!-- <div class="modal fade" id="other-country-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0 rounded-3">
                            <div class="modal-body text-center p-4">
                                <h3>{{ __('inpanel.dashboard.pop_up.title') }}</h3>
                                <p class="mt-3 mb-4">
                                    {{ __('inpanel.dashboard.pop_up.other_country_title_1') }}<br>
                                    {{ __('inpanel.dashboard.pop_up.other_country_title_2') }}
                                </p>
                                <button type="button" class="btn btn-primary px-4" onclick="closeCustomCountryModal()">
                                    {{ __('inpanel.dashboard.pop_up.other_country_ok_msg') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->
    <div class="modal fade" id="otherCountryModal" aria-hidden="true" aria-labelledby="otherCountryModalToggle"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="otherCountryModalToggle"></h1>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-popup-other-country">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <img src="{{asset('images/country_image1.webp')}}" alt="" class="img-fluid img-cover">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 welcome-div">
                                <div class="welcome-content">
                                     <span class="welcome-span">{{ __('inpanel.welcome_to_message.welcome_to') }}</span>
                                    <span class="welcome-span">{{ __('inpanel.welcome_to_message.sj_panel') }}</span>
                                </div>

                                <div class="welcome-paragraph">
                                    <p>{{ __('inpanel.login_country_warning.country_restrict_1') }}</p>
                                    <p>{{ __('inpanel.login_country_warning.country_restrict_2') }}</p>
                                    <p>{{ __('inpanel.login_country_warning.country_restrict_3') }}</p>                                
                                    <p>{{ __('inpanel.login_country_warning.country_restrict_4') }}</p>                                
                                </div>
                                <div class="">
                                    <button class="custom-button m-auto" id="modalConfirmBtn" onclick="closeCustomCountryModal()">{{ __('inpanel.login_country_warning.ok') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ending -->
</div>

<script>
    // Code Added by Vikas (Starting)
    function showCustomCountryModal() {
        $('#otherCountryModal').modal('show');
    }

    function closeCustomCountryModal() {
        $('#otherCountryModal').modal('hide');
    }
    // Ending
</script>