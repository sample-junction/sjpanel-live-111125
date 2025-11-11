<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Document</title> --}}
</head>

<body style="background-color:white; font-family: 'Roboto', sans-serif;">

    <div style="margin:auto;width:100%;height:auto; border-radius:10px; background-color:white; box-sizing: border-box; border: 1px solid rgba(233, 233, 233, 1);">
  
    <!-- Header Section -->
      <div style="width:100%;margin:0px;padding:0px;text-align:center;border-bottom:1px solid rgba(233, 233, 233, 1);">
        <img   src="{{asset('img/email_temp/image.png')}}" alt="" style="width:220px;padding:15px;">
    </div>

    <!-- Body_part_1 -->
    <div style="width:90%;margin:30px auto;background-color:rgba(244, 250, 255, 1); border-radius:13px;padding-top:10px; text-align:center;">
        {{--<img  src="{{asset('img/email_temp/loudspeaker 1.png')}}" alt="" style="height:81px;width:81px;margin-top:30px;margin-bottom:10px;">--}}
        <p style="font-size:27px;line-height:20px;font-weight:bold;padding:0px; margin-bottom:5px;"> Hi, </p><br>
        <p style="color:rgba(89, 89, 89, 1); font-size:14px; margin:0px; padding-left: 20px; padding-right: 30px; ">  {{--__('strings.emails.auth.confirmation.tmp_1_details_sub1')}}{{__('strings.emails.auth.confirmation.tmp_3_details_sub2')--}}I hope you’re doing well! I wanted to share some exciting news about SJ Panel, a platform where you can earn rewards by taking surveys and sharing your opinions. </p><br>
        <p style="color:rgba(89, 89, 89, 1); font-size:14px; margin:0px; padding-left: 20px; padding-right: 30px; "> At SJ Panel, your insights are truly valued. You can earn gift cards and other rewards through our simple and engaging surveys. Here’s what you can look forward to:</p><br>

        <div style="margin-left: 220px; text-align: center;" >

            <p style="text-align: left;">• <b>Quick Sign-Up:</b> Getting started is easy and takes just a few minutes.<br><br>
            • <b>Sign-Up Bonus:</b> Enjoy additional points right away to kickstart your earning journey!<br><br>
            • <b>Flexible Opportunities:</b> Choose surveys that fit your interests and schedule.<br><br>
            • <b>Rewards:</b> We ensure timely delivery of your gift cards for your participation. </p>
           
                
               </div><br>
         @php
    $route = route('frontend.auth.register', ['token' => $token, 'is_campaign' => 1]); 
    if(isset($user) && isset($request) && $request->token){
        $route = route('frontend.auth.register', ['token' => $token, 'is_reminder' => 1]); 
    }
@endphp

@if(isset($user) && isset($request) && isset($request->token))
    @php
        InviteCampaign::where('campaign_code', $token)->update(['has_visited' => 1]);
        session()->put('campaign', '1');
    @endphp
@endif
       
         <p style="color:rgba(89, 89, 89, 1); font-size:14px; margin:0px; padding-left: 30px; padding-right: 30px; "> Join our panel today by visiting <a href="{{$route}}">sjpanel.com</a> and start earning rewards for your valuable opinions!    </p><br>  

        <!-- {{$token}} -->
    
        <!-- right code -->

       
  

    {{-- <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{{__('frontend.welcome_mail.com_details_5')}} </p><br>    --}}
    
    
   {{-- <p style="color:rgba(89, 89, 89, 1); font-size:16px; margin:0px; padding-left: 30px; padding-right: 30px; ">  {!!__('strings.emails.auth.confirmation.tmp_3_details_7')!!} </p><br>
        --}}
   </div>

   <!-- Body_part_2 -->
   <div style="width:90%;height:114px;margin:40px auto; border:1px solid white;background-color:rgba(255, 251, 243, 1); border-radius:13px; text-align:center; padding:30px auto; box-sizing:border-box; padding:0px;">
      <p style="font-size:16px;margin-top:30px;line-height:18px;padding:-5px; margin-left: 20px;margin-right: 20px;">{{--__('frontend.welcome_mail.com_details_7')--}}If you have any questions or need more help, please contact us at <a style="text-decoration:none;font-size:16px;padding:0px;margin:0px;color:rgba(16, 128, 208, 1)" href="mailto: support@sjpanel.com">support@sjpanel.com.</a>We’re always here to help!</p>
   </div>

 
   <!-- Body_part_3 -->
   <div style="width:90%;height:77px; margin:40px auto;background-color:white;  text-align:center; padding:0px;">
    <div style="width:400px;height:77px;margin:auto;padding:0px;">
          <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}}</p>
          <p style="padding:0px;margin:0px;font-size:18px; line-height:24px;">{{--__('frontend.otp_mail.sj_panel')--}}<b>SJ Panel</b> Team</p>
          <a href="{{ env('APP_URL') }}"><img src="{{asset('img/email_temp/image.png')}}" alt="" style="width:140px;padding:3px;"></a>
          <p style="padding:0px;margin:0px;font-size:14px;line-height:19px; color:rgba(51, 51, 51, 1);">Suite 117, 9131 Keele St Suite A4, Vaughan, ON L4K 0G7</p>
    </div>
 </div>

   <!-- Body_part_4 -->
   <div style="width:100%; border-top: 1px solid gainsboro;border-bottom: 1px solid gainsboro; margin-top:90px;">
    <div style="width:90%; margin:auto;background-color:white;  text-align:center; padding:10px;" >  
        <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}} <a style="text-decoration: none;" href = "mailto: donoreply@sjpanel.net">donoreply@sjpanel.net</a> {{__('frontend.otp_mail.link_content')}}</p>
        <p style="font-size:12px;margin-top:-8px; "></p>
                
        <p style="font-size:12px;line-height:23px;padding:5px;">{{--__('frontend.otp_mail.link_content1')--}}You are receiving this email because you are a registered member of SJ Panel where we reward you through incentives for taking part in online surveys. If you do not wish to receive any future email from SJ Panel, please Unsubscribe to de-activate your account. As soon as you unsubscribe from SJ Panel, your account will be deleted within 72 hours and you will stop receiving emails from SJ Panel. In case you need any technical support, please write to our team at <a style="text-decoration: none;" href = "mailto: support@sjpanel.com">{{__('frontend.otp_mail.link1')}}</a></p>
                
    </div>
  </div>

  
        <!-- footer_section -->
        <div style="margin:auto;width:auto;height:56px; margin-bottom:0px;margin-top:25px; border-radius-bottom:20px;">
            <!-- Footer_section_part_2 -->
         <div style="width:auto; margin:10px auto;background-color:white; text-align:center; padding:0px;" >
             <div style="margin:10px auto;">
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;"  href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.cookie')}}"> {{__('strings.emails.auth.confirmation.cookie')}}</a>
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.safeguard')}}">{{__('strings.emails.auth.confirmation.safeguards')}}</a>
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.faq')}}">{{__('strings.emails.auth.confirmation.faq')}}</a>
                 <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.help_support')}}"> {{__('strings.emails.auth.confirmation.contact')}}</a>
             </div>
  
         </div>


        <!-- footer_section_part_3 -->
       {{-- <div style="width:90%;margin:7px auto;background-color:white; text-align:center; padding:0px; text-align:center;">
            @if(isset($user->email))
            <a style="font-size:12px;padding:4px; color:black;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $user->email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a>
            @else
            <a style="font-size:12px;padding:4px; color:black;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email'   => $email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a> 
             @endif 
        </div>
        --}}
        <!-- footer_section_part_4 -->
        <div style="margin:auto;width:100%;height:56px;background-color:rgba(16, 128, 208, 1); margin-bottom:0px; margin-top:0px;">
            <div style="float:left;padding-top:10px;padding-left:20px;">
                <p style="font-size:12px;margin:0px;color:white;"> {{__("strings.emails.auth.confirmation.all_right")}}</p>
                <p style="font-size:12px;margin:0px;color:white;">2015-{{date('Y')}} {{__('strings.emails.auth.confirmation.copyrightcompany')}} &#174; </p>
            </div>
            <div style="float:right;">
                <div style="display:flex;padding:10px 40px;text-align:center;">
                    <a href="https://x.com/sjpanelsurvey" style="padding:10px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/twitter.png')}}" alt="" style="width:21px; height:21px;"></a>
                    <a href="https://facebook.com/SJPanel" style="padding:11px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/fb.png')}}" alt="" style="width:17px; height:17px;"></a>
                    <a href="https://www.linkedin.com/company/sjpanel/" style="padding:8px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/ind.png')}}" alt="" style="width:23px; height:23px;"></a>
                </div>
            </div>
        </div>
    </div>
  </div>
    
</body>
</html>
