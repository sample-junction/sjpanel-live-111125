<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <i class="fa fa-fw fa-flag"></i> {{__('inpanel.user.profile.preferences.preferences_menu.heading')}}
        </h5>
    </div>
    <div class="ibox-content">
        <ul class="list-group">
        @if(Auth::user()->is_blacklist==0)
            <li class="list-group-item {{ active_class(Active::checkRouteParam('name','basic-profile')) }}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.basic_profile')}}
                </a>
            </li>
            <li class="list-group-item {{ active_class(in_array(request()->route()->parameter('name'),['security','password','two_fact_auth']))}}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'security') }}" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.security')}}
                </a>
            </li>
           {{-- <li class="list-group-item {{ active_class(Active::checkRouteParam('name','password')) }}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'password') }}" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.password')}}
                </a>
            </li>--}}
            <li class="list-group-item {{ active_class(Active::checkRouteParam('name','email-schedule')) }}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'email-schedule') }}" class="forum-item-title">
                    <!-- {{__('inpanel.user.profile.preferences.preferences_menu.email_scheduled')}} -->
                    {{__('inpanel.nav.label.email_frequnecy')}}
                </a>
            </li>
            {{--<li class="list-group-item">
                <a href="" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.phone')}}
                </a>
            </li>
            <li class="list-group-item">
                <a href="" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.address')}}
                </a>
            </li>--}}
            <li class="list-group-item {{ active_class(Active::checkRouteParam('name','my-data')) }}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'my-data') }}" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.my_data')}}
                </a>
            </li>
            @endif
            <li class="list-group-item {{ active_class(Active::checkRouteParam('name','delete-account')) }}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'delete-account') }}" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.deactivate_account')}}
                </a>
            </li>
            @if(Auth::user()->is_blacklist==0)
             <li class="list-group-item {{ active_class(Active::checkRouteParam('name','delete-personinfo')) }}">
                <a href="{{ route('inpanel.user.profile.preference.show', 'delete-personinfo') }}" class="forum-item-title">
                    {{__('inpanel.user.profile.preferences.preferences_menu.delete_personinfo')}}
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
