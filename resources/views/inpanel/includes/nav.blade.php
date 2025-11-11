@php
    $currentPage = request()->route()->getName();
@endphp
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element" style="margin-top: -18px;text-align: center;">
                    <span>
                        <a @if(Auth::user()->image_url!='') title="Edit Photo" @else title="Add Photo" @endif href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}">
                            
                           {{-- <img alt="image" class="img-circle" style="width: 80px; height: 80px;" @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif /> --}}
                           <img alt="image" class="img-circle" style="width: 80px; height: 80px;" @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif />
                            
                        </a>
                      
                     </span>
                    <a data-toggle="dropdown1" class="dropdown-toggle" href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::user()->name }}</strong>
                            </span>
                            @include('inpanel.includes.partials.sidebar_user_points')
                            @if(!empty($global_user_points->user_points) && ($global_user_points->user_points['completed']!==$threshold_point && $global_user_points->user_points['completed']<$threshold_point))
                                @php
                                       $userCompletedPoints = $global_user_points->user_points['completed'];
                                       $remainPoint = $threshold_point - $userCompletedPoints;
                                       $pointPercent = ($userCompletedPoints/$threshold_point) * 100;
                                @endphp

                                <div class="row">
                                     <div class="col-sm-1">
                                          <i class="fas fa-running"></i>
                                     </div>
                                    <div class="col-sm-7">
                                        <div class="progress progress-mini">
                                            <div style="width: {{$pointPercent}}%;" class="progress-bar"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <a class="nav-text" data-remaining_points="{{$remainPoint}}"><i class="fas fa-flag-checkered" {{--data-toggle="tooltip" data-placement="top" title="{{__('inpanel.profile.index.remaining_points_message',['points' => ($remainPoint)])}}"--}}></i></a>
                                     </div>
                                </div>
                            @endif
                        </span>
                    </a>
                    <!-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="{{ route('frontend.auth.logout') }}" {{--onclick="event.preventDefault();document.getElementById('logout-form').submit();"--}}>
                                <i class="fas fa-sign-out-alt"></i> {{__('inpanel.nav.button_logout')}}
                            </a>
                            {{--<form id="logout-form" action="{{ route('frontend.auth.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>--}}
                        </li>
                    </ul> -->
                </div>
                <div class="logo-element">
                    <img src="{{asset('images/logo.png')}}" style="width:100%;">
                </div>
            </li>
            <li class="{{ active_class(Active::checkRoute('inpanel.dashboard')) }}">
                <a href="{{ route('inpanel.dashboard') }}">
                    <i class="fa fa-th-large"></i>
                    <span class="nav-label">{{__('inpanel.nav.dashboard')}}</span>
                </a>
            </li>

            {{--My Account Start--}}
            <li class="{{ active_class(Active::checkRoutePattern(['inpanel.user.profile.preference*'])) }}">
                <a href="#" class="invite_friends"><i class="fas fa-user-friends"></i> <span class="nav-label">{{__('inpanel.nav.my_account')}}</span> </a>
                <ul class="nav nav-second-level">
                @if(Auth::user()->is_blacklist==0)
                    <li class="{{ active_class(Active::checkRouteParam('name','basic-profile')) }}">
                        <a href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}">
                            {{__('inpanel.nav.label.basic_profile')}}
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkRouteParam('name','security')) }}">
                        <a href="{{ route('inpanel.user.profile.preference.show', 'security') }}">
                            {{__('inpanel.nav.label.security')}}
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkRouteParam('name','email-schedule')) }}">
                        <a href="{{ route('inpanel.user.profile.preference.show', 'email-schedule') }}">
                            {{__('inpanel.nav.label.email_frequnecy')}}
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkRouteParam('name','my-data')) }}">
                        <a href="{{ route('inpanel.user.profile.preference.show', 'my-data') }}">
                            {{__('inpanel.nav.label.my_data')}}
                        </a>
                    </li>
                    @endif
                    <li class="{{ active_class(Active::checkRouteParam('name','delete-account')) }}">
                        <a href="{{ route('inpanel.user.profile.preference.show', 'delete-account') }}">
                            {{__('inpanel.nav.label.deactive_account')}}
                        </a>
                    </li>
                    @if(Auth::user()->is_blacklist==0)
                    <li class="{{ active_class(Active::checkRouteParam('name','delete-personinfo')) }}">
                        <a href="{{ route('inpanel.user.profile.preference.show', 'delete-personinfo') }}">
                            {{__('inpanel.nav.label.delete_personal_info')}}
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </li>
            {{--My Account end--}}

            @if(Auth::user()->is_blacklist==0)
            <li>
                <hr/>
            </li>

            {{--Detailed Profile Start--}}
            <li class="{{ active_class(Active::checkRoute('inpanel.profiler.show')) }}">
                <a href="@if(Route::has('inpanel.profiler.show')){{ route('inpanel.profiler.show') }}@endif" class="detail_profile__menu">
                    <i class="fa fa-briefcase"></i>
                    <span class="nav-label">{{__('inpanel.nav.label.profile_details')}}</span>
                </a>
            </li>
            {{--Detailed profile end--}}

            {{--Surveys Start--}}

            <li class="{{ active_class(Active::checkRoutePattern(['inpanel.survey*'])) }}">
                <a href="#" class="survey_details"><i class="fas fa-newspaper"></i> <span class="nav-label">{{__('inpanel.nav.surveys')}}</span> </a>
                <ul class="nav nav-second-level">
                    <li class="{{ active_class(Active::checkRoute('inpanel.survey.index')) }}">
                        <a href="@if(Route::has('inpanel.survey.index')){{ route('inpanel.survey.index') }}@endif" >
                        {{__('inpanel.nav.new_surveys')}}
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkRoute('inpanel.survey.index')) }}">
                        <a href="@if(Route::has('inpanel.survey.index')){{ route('inpanel.survey.index') }}@endif">{{__('inpanel.nav.surveys_history')}}</a>
                    </li>
                </ul>
            </li>
            {{--Surveys End--}}

            {{--Invite friends Start--}}
            <li class="{{ active_class(Active::checkRoutePattern(['inpanel.invite*'])) }}">
                <a href="#" class="invite_friends"><i class="fas fa-user-friends"></i> <span class="nav-label">{{__('inpanel.nav.label.invite')}}</span> </a>
                <ul class="nav nav-second-level">
                    <li class="{{ active_class(Active::checkRoute('inpanel.invite.show')) }}">
                        <a href="@if(Route::has('inpanel.invite.show')){{ route('inpanel.invite.show') }}@endif">
                            {{__('inpanel.nav.label.refer')}}
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkRoute('inpanel.invite.show')) }}">
                    <a href="@if(Route::has('inpanel.invite.show')){{ route('inpanel.invite.show') }}@endif">
                        {{--<a href="@if(Route::has('inpanel.invite.show')){{ route('inpanel.invite.myreferrals.show') }}@endif"> --}}
                            {{__('inpanel.nav.my_referral')}}
                        </a>
                    </li>
                </ul>
            </li>
            {{--Invite friends end--}}
            @endif

            <li>
                <hr/>
            </li>

            {{--Rewards Start--}}
            <li class="{{ active_class(Active::checkRoute('inpanel.reward.show')) }}">
                <a href="@if(Route::has('inpanel.reward.show')){{ route('inpanel.reward.show') }}@endif"><i class="fa fa-trophy"></i> <span class="nav-label reward_points">{{__('inpanel.nav.label.reward_points')}}</span></a>
            </li>
            {{--Rewards End--}}

            <li class="{{ active_class(Active::checkRoutePattern(['inpanel.redeem*'])) }}">
                <a href="#" class="invite_friends nav-dropdown-toggle"><i class="far fa-money-bill-alt"></i> <span class="nav-label">{{__('inpanel.nav.points_redemption')}}</span> </a>

                <ul class="nav nav-second-level">
                    {{--Redeem Start--}}
                    <li class="{{ active_class(Active::checkRoute('inpanel.redeem.show')) }}">
                        <a href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif">
                             <span class="nav-label">
                                {{__('inpanel.nav.label.redeem_points')}}
                            </span>
                        </a>
                    </li>
                    {{--Redeem End--}}

                    {{--Redeem History--}}
                    <li class="{{ active_class(Active::checkRoute('inpanel.redeem.redeem.history')) }}">
                        <a href="@if(Route::has('inpanel.redeem.redeem.history')){{ route('inpanel.redeem.redeem.history') }}@endif">
                             <span class="nav-label">
                              {{__('inpanel.nav.label.redemption_status')}}
                            </span>
                        </a>
                    </li>
                    {{--Redeem History End--}}

                    {{--Redeem Options Start--}}
                    <li class="{{ active_class(Active::checkRoute('frontend.cms.show')) }}">
                        <a href="{{route('frontend.cms.rewards')}}" target="_blank">
                             <span class="nav-label">
                            {{__('inpanel.footer.title_4')}}
                            </span>
                        </a>
                    </li>
                    {{--Redeem Options End--}}

                </ul>
            </li>
            {{--Panellist Support Start--}}
            @if(Auth::user()->is_blacklist==0)
            <li class="{{ active_class(Active::checkRoutePattern(['inpanel.user.support*'])) }}">
                <a href="#" class="survey_details"><i class="fa fa-regular fa-headset"></i> <span class="nav-label">{{__('inpanel.nav.panelist_support')}}</span> </a>
                <ul class="nav nav-second-level">
                    <!-- Code commented for Contact Us(Under Panelist support to hide it,as same thing coming at two places.) By Ramesh on 08March 2023-->
                   {{-- <li class="{{ active_class(Active::checkRoute('frontend.cms.help_support')) }}">
                        <a href="{{route('frontend.cms.help_support')}}" target="_blank">
                        {{__('inpanel.nav.label.contact_us')}}
                        </a>
                    </li>--}}
                    <li class="{{ active_class(Active::checkRoute('inpanel.user.support')) }}">
                        <a href="{{route('inpanel.user.support')}}" >
                        {{__('inpanel.nav.label.support')}}
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkRoute('inpanel.user.support_history')) }}">
                        <a href="{{route('inpanel.user.support_history')}}" >
                        {{__('inpanel.nav.label.support_history')}}
                        </a>
                    </li>
                </ul>
            </li>
            {{--Panellist Support End--}}
            @endif
            
            {{--FAQ Start--}}
            <li class="{{ active_class(Active::checkRoute('frontend.cms.faq')) }}">
                <a href="{{route('frontend.cms.faq')}}" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i> <span class="nav-label reward_points">{{__('inpanel.nav.label.faq')}}</span></a>
            </li>
            {{--FAQ End--}}
        </ul>

    </div>
</nav>

@push('after-scripts')
    <script>
        $(document).ready(function(){
            @if(!empty($global_user_points->user_points) && ($global_user_points->user_points['completed']!=$threshold_point && $global_user_points->user_points['completed']<$threshold_point))
            $('.nav-text').tooltip({
                'placement': 'right',
                'title': '{!! __('inpanel.redeem.index.details', ['points_remain' => $remainPoint]) !!}'
            });
            @endif
        });
    </script>
@endpush
