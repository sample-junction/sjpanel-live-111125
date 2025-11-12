<tr>
    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
    </td>
</tr>

<tr>
    <td colspan="2"style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.5; margin: 0;padding: 0 40px;
        text-align: left">
        <!-- {{__('strings.emails.auth.confirmation.footer')}}<br> -->
        {{__('strings.emails.auth.confirmation.footer_1')}} <br>
        {{__('frontend.welcome_mail.team')}}
    </td>
</tr>
<tr>

    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
    </td>
</tr>
</tbody>



<tr style=" background: #f2f2f2; padding: 0px;">
<td colspan="2" style="color: #666; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 16px; margin: 0; padding: 10px 40px;
    text-align: left; border-bottom: 1px solid #ccc;" align="left">
@if(isset($user->email))
    {!!__('strings.frontend.disclaimer')!!} <a href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $user->email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a> {{__('strings.frontend.disclaimer_1')}}
@else
    {!!__('strings.frontend.disclaimer')!!} <a href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a> {{__('strings.frontend.disclaimer_1')}}
@endif
</td>
</tr>

<tfoot style="background: #f2f2f2;">
<tr> 
    <td colspan="2"style="text-align:center;padding: 10px 32px 10px;border-bottom: 1px solid #ccc;font-size: 14px; font-weight: 600;" align="center"> {{__('frontend.index.footer.links.connect_with_us')}}
        <br>
        <a  target="_blank" href="https://facebook.com/SJPanel/"><img style="width: 32px!important;" src="https://test3.sjpanel.com/img/social_media/facebook.png" alt=""></a>
        <a target="_blank" href="https://www.linkedin.com/company/sjpanel/"><img style="width:32px!important;" src="https://test3.sjpanel.com/img/social_media/linkedin.png" alt=""></a>
        <a target="_blank" href="https://x.com/sjpanelsurvey"><img style="width:32px!important;" src="https://test3.sjpanel.com/img/social_media/twitter.png" alt=""></a>
        <a target="_blank" href="https://join.skype.com/invite/yrkeOdZCszrI"><img style="width:32px!important;" src="https://test3.sjpanel.com/img/social_media/skype.png" alt=""></a>

                                                          
    </td>
    
    
</tr>
<tr>
    <td colspan="2"style="text-align:center;padding: 10px 32px 10px;border-bottom: 1px solid #ccc;font-size: 14px; font-weight: 600;" align="center">{{__('frontend.index.footer.links.safe_sender')}}</td>
</tr>
<tr>
    <td colspan="2"style="text-align:center;padding: 10px 32px 10px;border-bottom: 1px solid #ccc;font-size: 14px; font-weight: 600;" align="center"> {{__('frontend.index.footer.links.office_address')}}
        <br>
    </td>
</tr>


<tr style="margin-top: 0px;">
    <td colspan="2" style=" text-align: center;padding: 10px 6px 0px;
    " align="center">
        <a href="{{route('frontend.cms.privacy')}}" style="display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0; padding: 0; text-decoration:none;padding: 0px 4px 0px 4px;border-right: 1px solid #8f8f8f;">{{__('frontend.index.footer.links.privacy_policy')}} </a>
        <a href="{{route('frontend.cms.cookie')}}" style=" display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0;text-decoration:none;padding: 0px 4px 0px 4px;border-right: 1px solid #8f8f8f!important;">
        {{__('strings.emails.auth.confirmation.cookie')}}</a>
        <a href="{{route('frontend.cms.rewards_policy')}}" style=" display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0;text-decoration:none;padding: 0px 4px 0px 4px;border-right: 1px solid #8f8f8f!important;">
        {{__('frontend.index.footer.links.reward_policy')}}</a>
        <a href="{{route('frontend.cms.referral_policy')}}" style=" display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0;text-decoration:none;padding: 0px 4px 0px 4px;border-right: 1px solid #8f8f8f!important;">
        {{__('frontend.index.footer.links.referral_policy')}}</a>
        <a href="{{route('frontend.cms.safeguard')}}" style=" display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0;text-decoration:none;padding: 0px 4px 0px 4px;border-right: 1px solid #8f8f8f!important;">{{__('strings.emails.auth.confirmation.safeguards')}}
        </a>
        <a href="{{route('frontend.cms.term_condition')}}" style="display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0;text-decoration:none;padding: 0px 4px 0px 4px;border-right: 1px solid #8f8f8f!important;">{{__('frontend.index.footer.links.term_condition')}}</a>

        <a href="{{route('frontend.cms.faq')}}" style="display:inline-block;color: #006bdd; font-family: Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 300; line-height: 22px; margin: 0; text-decoration:none;padding: 0px 4px 0px 4px;">{{__('strings.emails.auth.confirmation.faq')}} </a>

    </td>
    <tr>
        <td  colspan="2" style="color: rgb(88, 88, 88); font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 20px; margin: 0;padding: 10px 40px
        20px; text-align: center; " align="center">
            &#169; 2015-{{date('Y')}} {{__('strings.emails.auth.confirmation.copyrightcompany')}} &#174; | {{__("strings.emails.auth.confirmation.all_right")}} 
        </td>
    </tr>
</tr>
</tfoot>