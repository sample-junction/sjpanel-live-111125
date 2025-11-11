<style>
.btn-success {
    background-color: #1c84c6;
    border-color: #1c84c6;
    color: #FFFFFF;
	margin-left:200px;
	padding: 10px 20px;
    font-weight: 600;

}
.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
}
.btn-primary:hover {
    color: #fff;
    background-color: #1b8eb7;
    border-color: #1985ac;
}
.btn-primary {
    color: #fff;
    background-color: #20a8d8;
    border-color: #20a8d8;
}
.btn:hover, .btn:focus {
    text-decoration: none;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    -webkit-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
}
</style>
<div class="titlebox">
    {{__('cms.surveys.heading')}}
</div>
<div class="contentarea">
    <h3 style="font-size: 14px;text-align: center;">{{__('cms.surveys.blacklisted_text')}}</h3>
	<p style="padding-bottom:15px; text-align:center">	
	    {{__('cms.surveys.reward_procedure')}} <a href="{{url('pages/rewards-policy')}}">{{__('cms.surveys.reward_text')}}</a>
	</p>
	<p style="padding-bottom:15px; text-align:center">
	{{__('cms.surveys.report_text')}} <a href="mailto:support@sjpanel.com">{{__('cms.surveys.support_mail')}}</a>{{__('cms.surveys.extra_space')}}
	</p>
    <div id="countdown" style="text-align:center;"></div>
</div>