<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/user*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        <!-- @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif -->
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user/index*')) }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                <!-- @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif -->
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if ($logged_in_user->isAdmin() || $logged_in_user->isManager())

                <li class="nav-item">
                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/panelist*')) }}" href="{{ route('admin.auth.panelist') }}">
                    <i class="nav-icon icon-list"></i> @lang('labels.backend.access.reports.titles.panelist_management')
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/panelist*')) }}" href="{{ route('admin.auth.active-panelist-list') }}">
                    <i class="nav-icon icon-list"></i> Active Panellist Count 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/monthlyAward*')) }}" href="{{ route('admin.auth.monthlyAward') }}">
                    <i class="nav-icon icon-list"></i> @lang('labels.backend.access.reports.titles.monthly_award')
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/all-survey*')) }}" href="{{ route('admin.auth.reports.allsurvey') }}">
                    <i class="nav-icon icon-list"></i>Survey Status Report
                    </a>
                </li>
                
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="#">
                        <i class="nav-icon icon-list"></i> Redemption Mgmt

                        <!-- @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif -->
                    </a>

                    <ul class="nav-dropdown-items">

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="{{ route('admin.auth.redeem_points') }}">
                                @lang('Redeem Points Requests')
                                <!-- @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif -->
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem-history*')) }}" href="{{ route('admin.auth.redeem_history') }}">
                            Redemption History
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if ($logged_in_user->isAdmin() || $logged_in_user->isManager())               
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="#">
                        <i class="nav-icon icon-list"></i> Awards Mgmt 
                    </a>

                    <ul class="nav-dropdown-items">

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="{{ route('admin.auth.reward.rewards_automation') }}">
                                @lang('Award Data Automation')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="{{ route('admin.auth.reward.history') }}">
                                @lang('Award History')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="{{ route('admin.auth.reward.credit_panallist_points') }}">
                                @lang('Credit Points')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points*')) }}" href="{{ route('admin.auth.reward.point_system.list') }}">
                                @lang('Award Points System')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points')) }}" href="{{ route('admin.auth.awards.list') }}">
                                @lang('Award List')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points')) }}" href="{{ route('admin.auth.reward.country_info.list') }}">
                                @lang('Countries Info')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points')) }}" href="{{ route('admin.auth.reward.template.list') }}">
                                @lang('Award Mail Template')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points')) }}" href="{{ route('admin.auth.reward.template_history.list') }}">
                                @lang('Award Mail History')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/redeem_points')) }}" href="{{ route('admin.auth.reward.banner') }}">
                                @lang('Award banner upload')
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if ($logged_in_user->isAdmin() || $logged_in_user->isManager())

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/reports*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth/reports*')) }}" href="#">
                        <i class="nav-icon icon-list"></i> Reports
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/panelist*')) }}" href="{{ route('admin.auth.reports.survey') }}">
                                Panelist Survey Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/panelist*')) }}" href="{{ route('admin.auth.reports.response') }}">
                                Panellist Response Rate
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/panelist_survey_history*')) }}" href="{{ route('admin.auth.reports.panelist_survey_history') }}">
                                Panellist Survey History
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/active*')) }}" href="{{ route('admin.auth.reports.active') }}">
                                Active Panellist
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/active*')) }}" href="{{ route('admin.auth.reports.rejection') }}">
                                Rejection
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/incentive*')) }}" href="{{ route('admin.auth.reports.incentive') }}">
                                Incentive Distribution
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/incentive*')) }}" href="{{ route('admin.auth.reports.survey_report') }}">
                                Survey Report
                            </a>
                        </li>
						
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/panelist*')) }}" href="{{ route('admin.auth.reports.survey_participation') }}">
                                Survey Participation Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/reports/panelist*')) }}" href="{{ route('admin.auth.reports.conversionRate') }}">
                                Conversion Rate
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            <li class="divider"></li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/affiliate-list'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth/affiliate-list')) }}" href="#">
                        <i class="nav-icon icon-user"></i> @lang('Affiliate')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/affiliate-list')) }}" href="{{ route('admin.auth.affiliate.list') }}">
                                @lang('labels.backend.affiliate.list')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/affiliate')) }}" href="{{ route('admin.auth.affiliate.campaign') }}">
                                @lang('labels.backend.affiliate.campaign')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/affiliate/campaign-data')) }}" href="{{ route('admin.auth.campaign.data') }}">
                                @lang('labels.backend.affiliate.campaign_data')
                            </a>
                        </li>
                    </ul>
                </li>
            


                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                        <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>

            @endif


            @if ($logged_in_user->isManager())
            @endif

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/setting*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth/setting*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('Setting')
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/countries_points/*')) }}" href="{{ route('admin.auth.setting.countries_points') }}">
                            @lang('Country Points')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/unique_ip_check/*')) }}" href="{{ route('admin.auth.setting.unique_ip_check') }}">
                            @lang('Unique IP Check')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/blacklisted_ip/*')) }}" href="{{ route('admin.auth.setting.blacklisted_ip') }}">
                            @lang('Blacklisted Ips')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/active_fraud_setting/*')) }}" href="{{ route('admin.auth.setting.active_fraud_setting') }}">
                            @lang('Active/Fraud')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/point_system_setting/*')) }}" href="{{ route('admin.auth.setting.point_system_setting') }}">
                            @lang('Points System')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/point_system_setting/*')) }}" href="{{ route('admin.auth.setting.pull_invite_duration') }}">
                            Pull Invite Duration
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/setting/nominee_count/*')) }}" href="{{ route('admin.auth.setting.nominee_count') }}">
                            Nominee Count Generator
                        </a>
                    </li>						
                    <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/panelist_upload/*')) }}" href="{{ route('admin.auth.panelist_upload') }}">
                <i class="nav-icon icon-list"></i> @lang('Panelist Uploads')
                </a>
                </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/question')) }}" href="{{ route('admin.auth.question') }}">
                <i class="nav-icon icon-list"></i>@lang('labels.backend.access.questions_answers.management')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/support*')) }}" href="{{ route('admin.auth.support.history') }}">
                <i class="nav-icon icon-list"></i>{{__('inpanel.nav.label.support_history')}}
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/panelist*')) }}" href="{{ route('admin.auth.support.birthdaysent') }}">
                <i class="nav-icon icon-list"></i>{{__('Campaign invitation')}}
                </a>
            </li>
			
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/panelist*')) }}" href="{{ route('admin.auth.invite.sendInvitation') }}">
                <i class="nav-icon icon-list"></i>{{__('Email Invitation')}}
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.auth.gallery-page')}}">
                <i class="nav-icon icon-list"></i>Edit Gallery
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/affiliate/show-campaign')) }}" href="{{ route('admin.auth.show-campaign') }}">
                <i class="nav-icon icon-list"></i> {{__('inpanel.nav.label.campaign_history')}}
               </a>
           </li>

           <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/show-survey-invite')) }}" href="{{ route('admin.auth.show-survey-invite') }}">
                <i class="nav-icon icon-list"></i> {{__('Survey Invite Campaign')}}
               </a>
           </li>


           
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/panel-bonus')) }}" href="{{ route('admin.auth.panel-bonus') }}">
            <i class="nav-icon icon-list"></i> {{__('Panel Bonus')}}
           </a>
       </li>
           <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/expense-record')) }}" href="{{ route('admin.auth.expense-record') }}">
                <i class="nav-icon icon-list"></i> {{__('Expenses Record')}}
               </a>
           </li>
           <li class="nav-item">

                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/survey-lucky-draw')) }}" href="#">
                <i class="nav-icon icon-list"></i> {{__('Survey Lucky Draw')}}
               </a>
           </li>
           <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/reconcilation-rejection')) }}" href="{{ route('admin.auth.reconcilation-rejection') }}">
                <i class="nav-icon icon-list"></i> {{__('Reconcilation Rejection')}}
               </a>
           </li>

           <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/show-feasibility')) }}" href="{{ route('admin.auth.show-feasibility') }}">
                <i class="nav-icon icon-list"></i> {{__('Feasibility')}}
               </a>
           </li>
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/show-unsubscribe')) }}" href="{{ route('admin.auth.show-unsubscribe') }}">
            <i class="nav-icon icon-list"></i> {{__('Unsubscribe Panelists')}}
           </a>
       </li>
        </ul>
    </nav>


    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
