<div class="footer">
    <div class="pull-right">
            <p>
				<a href="{{route('frontend.cms.privacy')}}" target="_blank">{{__('inpanel.footer.title_1')}}</a>
                | <a href="{{route('frontend.cms.cookie')}}" target="_blank">{{__('strings.emails.auth.confirmation.cookie')}}</a>  
                | <a href="{{route('frontend.cms.rewards_policy')}}" target="_blank">{{__('frontend.index.footer.links.reward_policy')}}</a>
                | <a href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                | <a href="{{route('frontend.cms.safeguard')}}" target="_blank">{{__(('inpanel.footer.title_2'))}}</a> 
                | <a href="{{route('frontend.cms.term_condition')}}" target="_blank">{{__('frontend.index.footer.links.term_condition')}}</a>
                | <a href="{{route('frontend.cms.faq')}}" target="_blank">{{__('inpanel.footer.title_3')}}</a> 
                | <a href="{{route('frontend.cms.help_support')}}" target="_blank">{{__('frontend.nav.static.heading_4')}}</a>  
                
			</p>
    </div>
    <div>
        {{__('frontend.register.static.footer_title_3')}} &reg; 2015-{{ date('Y') }}
    </div>
</div>
