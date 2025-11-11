<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color:white; font-family: 'Roboto', sans-serif;">

@php
  $originalLocale = app()->getLocale();
   app()->setLocale($user->locale);
@endphp

    <div style="margin:auto;width:600px;height:auto; border-radius:10px; background-color:white; box-sizing: border-box; border: 1px solid rgba(233, 233, 233, 1);">
  
    <!-- Header Section -->
      <div style="width:600px;margin:0px;padding:0px;text-align:center;border-bottom:1px solid rgba(233, 233, 233, 1);">
        <img   src="{{asset('img/email_temp/logo.png')}}" alt="" style="width:170px;height:34px;padding:15px;">
    </div>
    
    <!-- Body_part_1 -->
    <div style="width:560px;margin:30px auto;background-color:rgba(244, 250, 255, 1); border-radius:13px; text-align:center;">
        <img src="{{asset('img/img_email/survey1.png')}}" alt="" style="height:81px;width:81px;margin-top:30px;margin-bottom:10px;padding-bottom: 10px;">
        <p style="font-size:30px;line-height:20px;font-weight:bold;padding:0px;padding-bottom: 10px;"> {{__('inpanel.mail.invitation.invite_freind_content_1')}} {{$user->first_name}},</p>
        <p style="color: rgba(89, 89, 89, 1); font-size: 16px; padding-left: 10px; padding-right: 10px;">
            {{ __('inpanel.mail.invitation.reminder_survey_new_content') }}<br>
            {{ __('inpanel.mail.invitation.reminder_button_survey') }}<br>

            <a href="{{ route('inpanel.survey.index') }}"
            style="display: inline-block; padding: 10px 20px; margin: 15px 0; font-size: 16px; font-weight: bold; text-align: center; text-decoration: none; color: #ffffff; background-color: #006bde; border-radius: 6px;"
            target="_blank">
            {{ __('buttons.emails.auth.survey_dashboard') }}
            </a><br>

            {{ __('inpanel.SurveyMail.content_2') }}
        </p>
        <br>        

        <p style="color:rgba(89, 89, 89, 1); font-size:16px; padding-bottom:10px;">{{route('inpanel.survey.index')}}</p><br>
   </div>


    <!-- Body_part_3 -->
    <div style="width:560px;height:77px; margin:40px auto;background-color:white;  text-align:center; padding:0px;">
        <div style="width:400px;height:77px;margin:auto;padding:0px;">
              <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.thanks')}}</p>
             <a href="{{env('APP_URL')}}"> <img src="{{url('img/jpblog/img/logo.png')}}" alt="logo" width="150px" id="logoId" class="img-fluid ms-lg-4 ms-1 me-1"> </a>
              <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.address')}}</p>
        </div>
     </div>
  
     <!-- Body_part_4 -->
     <div style="width:600px; border-top: 1px solid gainsboro;border-bottom: 1px solid gainsboro; margin-top:40px;">
      <div style="width:560px; margin:auto;background-color:white;  text-align:center; padding:10px;" >  
          <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}} <a style="text-decoration: none;" href = "mailto: donoreply@sjpanel.com">{{__('frontend.otp_mail.link')}}</a> {{__('frontend.otp_mail.link_content')}}</p>
          <p style="font-size:12px;margin-top:-8px; "></p>
                  
          <p style="font-size:12px;line-height:23px;padding:5px;">{{__('frontend.otp_mail.link_content1')}} <a style="text-decoration: none;" href = "mailto: support@sjpanel.com">support@sjpanel.com</a>.</p>
                  
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