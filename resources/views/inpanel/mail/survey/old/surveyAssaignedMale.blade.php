<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color:white; font-family: 'Roboto', sans-serif;">

    <div style="margin:auto;width:600px;height:auto; border-radius:10px; background-color:white; box-sizing: border-box; border: 1px solid rgba(233, 233, 233, 1);">
  
    <!-- Header Section -->
      <div style="width:600px;margin:0px;padding:0px;text-align:center;border-bottom:1px solid rgba(233, 233, 233, 1);">
        <img   src="{{asset('img/email_temp/logo.png')}}" alt="" style="width:170px;height:34px;padding:15px;">
    </div>

    <!-- Body_part_1 -->
    <div style="width:560px;height:383px;margin:30px auto;background-color:rgba(244, 250, 255, 1); border-radius:13px; text-align:center;">
        <img src="{{asset('img/email_temp/survey.png')}}" alt="" style="height:81px;width:81px;margin-top:30px;margin-bottom:10px;">
        <p style="font-size:30px;line-height:20px;font-weight:bold;padding:0px;"> {{__('strings.emails.auth.confirmation.greetings')}} {{$user->first_name}},</p>
        <p style="color:rgba(89, 89, 89, 1); font-size:16px;">  
        @if($user_project_count > 1)
            {{__('inpanel.SurveyMail.content_1',['survey_count' => $user_project_count])}}
            {{__('inpanel.SurveyMail.content_2')}} 
        @else
            {{__('inpanel.SurveyMail.content_4',['survey_count' => $user_project_count])}}
            {{__('inpanel.SurveyMail.content_5')}} 
        @endif
        </p>        
           
      <!-- <button style="width:308px; height:45px;background-color:rgba(16, 128, 208, 1);border-radius:10px; margin-top:20px;">
          {{-- <a href="{{$route}}" style="text-decoration:none;font-size:16px;color:white;" href="">{{__('strings.emails.auth.confirmation.confirm_button')}}</a> --}}
      </button> -->

     <p style="color:rgba(89, 89, 89, 1); font-size:16px;">https://sjpanel.com/survey</p><br>




   </div>

   <!-- Body_part_2 -->
   <!-- <div style="width:560px;height:114px;margin:40px auto; border:1px solid white;background-color:rgba(255, 251, 243, 1); border-radius:13px; text-align:center; padding:30px auto; box-sizing:border-box;">
      {{-- <p style="font-size:16px;margin-top:30px;line-height:15px;padding:-5px;">{{__('strings.emails.auth.confirmation.contact_detail')}}</p> --}}
      <a style="text-decoration:none;font-size:16px;padding:0px;margin:0px;color:rgba(16, 128, 208, 1)" href="mailto: support@sjpanel.com">support@sjpanel.com</a>
   </div> -->

   <!-- Body_part_3 -->
   <div style="width:560px;height:77px; margin:40px auto;background-color:white;  text-align:center; padding:0px;">
      <div style="width:400px;height:77px;margin:auto;padding:0px;">
            <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}}</p>
            <p style="padding:0px;margin:0px;font-size:18px; font-weight:bold;line-height:26px;">{{__('frontend.otp_mail.sj_panel')}}</p>
            <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">75-76, Pocket-13, Sector 21, Rohini, Delhi - 110086</p>
      </div>
   </div>

   <!-- Body_part_4 -->
   <div style="width:600px; border-top: 1px solid gainsboro;border-bottom: 1px solid gainsboro; margin-top:40px;">
    <div style="width:560px; margin:auto;background-color:white;  text-align:center; padding:10px;" >  
        <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}} <a style="text-decoration: none;" href = "mailto: donoreply@sjpanel.com">{{__('frontend.otp_mail.link')}}</a> {{__('frontend.otp_mail.link_content')}}</p>
        <p style="font-size:12px;margin-top:-8px; "></p>        
        <p style="font-size:12px;line-height:23px;padding:5px;">{{__('frontend.otp_mail.link_content1')}} <a style="text-decoration: none;" href = "mailto: support@sjpanel.com">{{__('frontend.otp_mail.link1')}}</a></p>        
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


        <!-- footer_section_part_2 -->
        <div style="width:560px;margin:7px auto;background-color:white; text-align:center; padding:0px; text-align:center;">
        @if(isset($user->email))
        <a style="font-size:12px;padding:4px; color:black;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $user->email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a>
        @else
        <a style="font-size:12px;padding:4px; color:black;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email'   => $email])}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a> 
         @endif 
        </div>

        <!-- footer_section_part_3 -->
        <div style="margin:auto;width:600px;height:56px;background-color:rgba(16, 128, 208, 1); margin-bottom:0px; margin-top:0px;">
            <div style="float:left;padding-top:10px;padding-left:20px;">
                <p style="font-size:12px;margin:0px;color:white;"> {{__("strings.emails.auth.confirmation.all_right")}}</p>
                <p style="font-size:12px;margin:0px;color:white;">2015-{{date('Y')}} {{__('strings.emails.auth.confirmation.copyrightcompany')}} &#174; </p>
            </div>
            <div style="float:right;">
                <div style="display:flex;padding:10px 40px;text-align:center;">
                    <a href="https://twitter.com/SampleJunction" style="padding:10px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/twitter.png')}}" alt="" style="width:21px; height:21px;"></a>
                    <a href="https://www.facebook.com/samplejunction/" style="padding:11px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/fb.png')}}" alt="" style="width:17px; height:17px;"></a>
                    <a href="https://www.linkedin.com/company/sample-junction/" style="padding:8px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/ind.png')}}" alt="" style="width:23px; height:23px;"></a>
                </div>
            </div>
        </div>
    </div>
  </div>
    
</body>
</html>