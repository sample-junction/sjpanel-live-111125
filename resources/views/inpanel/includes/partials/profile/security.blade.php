<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h4><strong>{{__('inpanel.user.profile.preferences.password_title')}}</strong></h4>
    </div>
    <div class="ibox-content password_change">
        <div class="col-md-1">
            <i class="fa fa-key" aria-hidden="true" style="font-size:20px"></i>
        </div>
        <div class="col-md-7">
            {{__('inpanel.user.profile.preferences.password_details')}}
        </div>
        <div class="col-md-1 pull-left">
            <a href="{{ route('inpanel.user.profile.preference.show', 'password') }}">
                <i class="fa fa-angle-right" style="font-size:55px"></i>
            </a>
        </div>
    </div>
</div>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h4><strong>{{__('inpanel.user.profile.preferences.two_fact_heading')}}</strong></h4>
    </div>
    <div class="ibox-content password_change">
        <div class="col-md-1">
            <i class="fas fa-shield-alt" aria-hidden="true" style="font-size:20px"></i>
        </div>
        <div class="col-md-7">
            {{__('inpanel.user.profile.preferences.two_fact_details')}}
        </div>
        <div class="col-md-1 pull-left">
            <a href="{{ route('inpanel.user.profile.preference.show', 'two_fact_auth') }}" >
                <i class="fa fa-angle-right" style="font-size:55px"></i>
            </a>
        </div>
    </div>
</div>


