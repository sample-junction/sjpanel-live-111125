<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
@php
	/* Parshant Sharma [27-08-2024] STARTS */

	//$metricConversion = round(1/$currencies['countryPoint'], 4);
	$metricConversion = 1/$currencies['countryPoint'];
	//dd($metricConversion);
	
@endphp
<body style="margin: 0px;padding: 0px;background-color:white;font-family: 'Roboto', sans-serif;">
    <div style="margin: 20px auto;width: 600px;">
        <!-- <div style="width: 600px;border-radius: 10px;"> -->
        <table style="width: 600px;border-collapse: collapse;margin: 0px;">
            <tbody>
                <tr>
                    <td style="text-align: center;border:1px solid rgba(233, 233, 233, 1);">
                    <a href="{{ env('APP_URL') }}"><img src="{{asset('img/img_email/logo.png')}}" alt="" style="width:170px;height:34px;padding:15px;"></a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                    @php 
						/* if($currencies['lang']!='UK'){
                            if($get_referal_point*config('app.points.metric.conversion') < 1){
                                $points = $get_referal_point*config('app.points.metric.conversion')*100 . __('inpanel.dashboard.cents'); 
                            }else{
                                $points = '$'. $get_referal_point*config('app.points.metric.conversion');
                            }
						}else{
							$get_referal_points=number_format($get_referal_point/$currencies['countryPoint'],2);							
							if($get_referal_points < 1){
								$currency = ($get_referal_point*@$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                $points = $get_referal_point*$metricConversion*100 .' '. __($currency); 
                            }else{
                                $points = '$'. $get_referal_point*config('app.points.metric.conversion');
                            }
							
						} */
													
						if($get_referal_point*$metricConversion < 1){
							$currency = ($get_referal_point*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
							$points = number_format(($get_referal_point*$metricConversion*100),2) .' '. __($currency); 
						}else{
							$points = $currencies['currency_logo']. number_format($get_referal_point*$metricConversion,2);
						}
                    @endphp
                        <div style="margin: 20px auto;width:560px;background-color:rgba(244, 250, 255, 1); border-radius:13px;padding:10px 10px;">
                            <img src="{{asset('img/img_email/refer.png')}}" alt="" style="height:81px;width:81px;margin-top:30px;margin-bottom:0px;">
                            <p style="font-size:30px;line-height:24px;font-weight:bold;padding:0px;margin-top:20px;">{{__('inpanel.mail.invitation.invite_freind_content_1')}} {{$referralName}},</p>

                            <p style="color:rgba(89, 89, 89, 1); font-size:16px;line-height:24px; justify-content:center;width:auto;margin-top:15px!important;margin-bottom:10px!important;"> {{__('inpanel.mail.invitation.survey_complete_content_1')}} {{$referredName}}, {{__('inpanel.mail.invitation.survey_complete_content_2')}}</p>

                            <p style="color:rgba(89, 89, 89, 1); font-size:16px;line-height:24px; justify-content:center;width:auto;margin-bottom:20px!important;"> {{__('inpanel.mail.invitation.survey_complete_content_3')}} {{$points}} ({{$get_referal_point}} {{__('inpanel.dashboard.points')}}) {{__('inpanel.mail.invitation.survey_complete_content_4')}} {{__('inpanel.mail.invitation.survey_complete_content_5')}} <strong>{{__('inpanel.mail.invitation.survey_complete_content_10')}}</strong> {{__('inpanel.mail.invitation.survey_complete_content_11')}} {{$referred_first_name}}{{__('inpanel.mail.invitation.survey_complete_content_6')}} </p> 

                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;width: 600px;padding: -20px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                            <div style="margin:auto;width:560px;height:89px;background-color:rgba(255, 251, 243, 1); border-radius:13px; text-align: center;padding:0px 10px;">
                             <p style="color:rgba(89, 89, 89, 1); font-size:15px;line-height:24px;padding:30px 10px;">{{__('inpanel.mail.invitation.survey_complete_content_7')}} <a style="color:rgba(0, 107, 222, 1);" href="{{route('frontend.cms.referral_policy')}}">{{__('inpanel.mail.invitation.survey_complete_content_8')}}</a> {{__('inpanel.mail.invitation.survey_complete_content_9')}}</p> 
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="border-left:1px solid rgba(233, 233, 233, 1)!important;border-right:1px solid rgba(233, 233, 233, 1)!important;width: 600px;"><p></p>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;width: 600px;height:auto;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                            <div style="width:400px;height:auto;margin:auto;padding:15px;text-align: center;">
                                <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}}</p>
                                <a href="{{ env('APP_URL') }}"><img src="{{asset('img/img_email/logo.png')}}" alt="" style="width:170px;height:34px;padding:3px;"></a>
                                <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">{{__('frontend.index.footer.links.office_address')}}</p>
                            </div>
                            
                    </td>
                </tr>

                <tr>
                    <td style="border-left:1px solid rgba(233, 233, 233, 1)!important;border-right:1px solid rgba(233, 233, 233, 1)!important;width: 600px;"><p></p>
                 </td>
                </tr>
                

                <tr>
                    <td style="text-align:center;width: 600px; border: 1px solid rgba(233, 233, 233, 1);">
                        <div style="margin: 20px auto;width:560px;padding:0px 10px; text-align: center;">
                            <div style="margin:auto;">
                                <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}}<a style="text-decoration: none;" href = "mailto: donotreply@sjpanel.com"> {{__('frontend.otp_mail.link')}}</a> {{__('frontend.otp_mail.link_content')}} </p>
                                    
                                <p style="font-size:12px;line-height:23px;padding:5px;">{{__('frontend.otp_mail.link_content1')}}<a style="text-decoration: none;" href = "mailto: support@sjpanel.com">{{__('frontend.otp_mail.link1')}}</a></p>
                          </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                          
                                <table style="width:580px;background-color:white; text-align:center; padding:auto;margin-top:20px!important;">
                                    <tbody>
                                        <tr>
                                            <td>
                                            <div style="float:right;text-align:center;">
                                                <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.cookie')}}">{{__('strings.emails.auth.confirmation.cookie')}}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.safeguard')}}">{{__('strings.emails.auth.confirmation.safeguards')}}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.faq')}}">{{__('strings.emails.auth.confirmation.faq')}}</a>

                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.help_support')}}">{{__('strings.emails.auth.confirmation.contact')}}</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;padding:10px 0px;" colspan="7">
                                            @if(isset($user->email))
                                            <a style="font-size:12px;padding:4px; color:black;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $user->email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a> 
                                            @else
                                            <a style="font-size:12px;padding:4px; color:black;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email'   => $email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a>
                                            @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;width: 600px;height: 56px; background-color:rgba(16, 128, 208, 1);padding: 0px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);border-bottom:1px solid rgba(233, 233, 233, 1);">  
                         <table>
                              <tbody>
                                    <tr>
                                      <td style="padding-left:10px;padding-right:180px;padding-top:0px;padding-bottom:0px;">
                                          <table>
                                              <tbody>
                                                   <tr>
                                                      <td>
                                                        <div style="width:273px;">
                                                        <p style="font-size:12px;color:white;line-height: 10px;text-align: left;">{{__('inpanel.mail.invitation.company_copyright_1')}} <br> <br>2015-{{date('Y')}} {{__('inpanel.mail.invitation.company_copyright_2')}} &#174;</p>
                                                        </div>
                                                         <!-- <p style="font-size:12px;color:white;line-height: 3px;text-align: left;">
                                                         </p> -->
                                                      </td>   
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                             </table>
                                         </td>
                                         <td style="padding-right:4px;padding-left:30px;">
                                             <a href="https://x.com/sjpanelsurvey" style="padding:6px 6px;"><img src="{{asset('img/img_email/twitter.png')}}" alt="" style="width:24px; height:24px;"></a>
                                         </td>
                                            <td style="padding:4px;">
                                              <a href="https://facebook.com/SJPanel/" style="padding:8px 8px;"><img src="{{asset('img/img_email/fb.png')}}" alt="" style="width:19px; height:19px;"></a>
                                            </td>
                                             <td style="padding:4px;"> 
                                               <a href="https://www.linkedin.com/company/sjpanel/" style="padding:9px 8px;"><img src="{{asset('img/img_email/linkdin.png')}}" alt="" style="width:19px; height:19px;"></a>
                                            </td>
                                         </tr>
                                     </tbody>
                             </table>              
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>