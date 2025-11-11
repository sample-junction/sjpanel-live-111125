<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color:gray;font-family: 'Roboto', sans-serif0">

  <div style="margin:auto;width:600px;height:1378px; border-radius:10px;background-color:white;box-sizing: border-box;">

  <!-- Header Section -->
    <div style="width:600px;margin:0px;padding:0px;text-align:center;border-bottom:1px solid rgba(233, 233, 233, 1);">
        <img src="assets/pic/logo.png" alt="" style="width:170px;height:34px;padding:15px;">
    </div>

    <!-- Body_part_1 -->
    <div style="width:560px;height:727px;margin:40px auto;background-color:rgba(244, 250, 255, 1); border-radius:13px; text-align:center;border:1px solid black;">
        <img src="assets/pic/bell.png" alt="" style="height:81px;width:81px;margin-top:30px;margin-bottom:10px;">
        <p style="font-size:30px;line-height:20px;font-weight:bold;padding:0px;">{%DETAILS_1%} {%U_NAME%},</p>
        <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{%DETAILS_2%}</p> 
        <p style="color:rgba(89, 89, 89, 1); font-size:16px;"> {%LABELS_1%}: {%S_CODE%}</p>

        <!-- Body_part_inner_box -->
        <div style="width:528px;height:153px;margin:40px auto;background-color:rgba(255, 255, 255, 1); border-radius:13px; text-align:center;border:1px solid black;">
            <div style="width:203px;">
            <p style="font-size:14px;font-weight:bold;background-color:rgba(242, 242, 242, 1);padding:5px; margin-left:20px;">Survey No. 12345678901234</p>
            </div>

            <div style="margin:20px auto;text-align:center;">
  @php

   $data  =  <table style="margin-left:13px;border-collapse:collapse;">
                <thead style="border-bottom:2px solid rgba(236, 236, 236, 1);">
                    <tr>
                        <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">'{%S_TOPIC%}'</th>
                        <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">'{%LABELS_2%}'</th>
                        <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">'{%POINTS%}'</th>
                        <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">'{%VALUE%}'</th>
                    </tr>
                </thead>
             
                <tbody>
                   
                    <tr>
                        <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">Others</td>
                        <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">{%S_TOPIC%}</td>
                        <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">{%S_LOI%}</td>
                        <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">{%S_POINTS%}</td>
                    </tr>
                </tbody>
            </table>

@endphp

@if(isset($placeholders) && !empty($placeholders))
    {!! strtr($data, $placeholders) !!}
@else
    {!! $data !!}
@endif

            </div>
        </div>

        <p style="font-size:12px">We expect you read all questions carefully and  give your valuable and honest opinion in this survey.</p>
        <p style="font-size:12px"> Your precious viewpoint will help our clients make better products and services for the mankind</p>
       
      <button style="width:308px; height:45px;background-color:rgba(16, 128, 208, 1);border-radius:10px; margin-top:20px;border:1px solid black;">
          <a style="text-decoration:none;font-size:16px;color:white;" href="{%S_LINK%}">{%BUTTON_S%}</a>
      </button>
      <p style="font-size:14px;">or you can click the below link</p>
      <p style="font-size:14px;color:rgba(34, 149, 244, 1);"><a href="{%S_LINK%}">https://www.sjpanel.com/invite/my-refer/aa502984-cd8d-4d67-a7a6.....</a>{%LINE_TEXT%}</p>

   </div>

 
   <!-- Body_part_2 -->
   <div style="width:560px;height:77px; margin:40px auto;background-color:white;  text-align:center; padding:0px;">
      <div style="width:400px;height:77px;margin:auto;padding:0px;">
            <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}},</p>
            <p style="padding:0px;margin:0px;font-size:18px; font-weight:bold;line-height:26px;">{{__('frontend.otp_mail.sj_panel')}}</p>
            <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">75-76, Pocket-13, Sector 21, Rohini, Delhi - 110086</p>
      </div>
   </div>

   <!-- Body_part_3 -->
   <div style="width:600px; border-top: 1px solid gainsboro;border-bottom: 1px solid gainsboro; margin-top:40px;">
        <div style="width:560px; margin:auto;background-color:white;  text-align:center; padding:10px;" >  
            <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}} <a style="text-decoration: none;" href = "mailto: donoreply@sjpanel.com">{{__('frontend.otp_mail.link')}}</a> {{__('frontend.otp_mail.link_content')}}</p>
            <!-- <p style="font-size:12px;margin-top:-8px; "> sender list</p> -->
                    
            <p style="font-size:12px;line-height:23px;padding:5px;"><a style="text-decoration: none;" href = "mailto: support@sjpanel.com">{{__('frontend.otp_mail.link1')}}</a></p>
                    
        </div>
  </div>

      <!-- footer_section -->
      <div style="margin:auto;width:600px;height:56px; margin-bottom:0px;margin-top:25px; border-radius-bottom:20px;background-color:white; ">
           <!-- Footer_section_part_1 -->
           <div style="width:560px; margin:10px auto;background-color:white; text-align:center; padding:0px; display:flex; flex-direction:space-between;" > 
            <div style="margin:10px auto;">
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;"  href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.cookie')}}"> {{__('strings.emails.auth.confirmation.cookie')}}</a>
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.safeguard')}}">{{__('strings.emails.auth.confirmation.safeguards')}}</a>
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="{{route('frontend.cms.faq')}}">{{__('strings.emails.auth.confirmation.faq')}}</a>
                <a style="font-size:12px;padding:7px; text-decoration:none;color:black;" href="https://sjpanel.com/pages/contact">{{__('strings.emails.auth.confirmation.contact')}}</a>
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
        <div style="margin:auto;width:600px;height:56px;background-color:rgba(16, 128, 208, 1); margin-bottom:0px; margin-top:15px;positon:fixed;">
            <div style="float:left;padding-top:10px;padding-left:20px;">
            <p style="font-size:12px;margin:0px;color:white;"> {{__("strings.emails.auth.confirmation.all_right")}}</p>
                <p style="font-size:12px;margin:0px;color:white;">2015-{{date('Y')}} {{__('strings.emails.auth.confirmation.copyrightcompany')}} &#174; </p>
            </div>
            <div style="float:right;">
                <div style="display:flex;padding:10px 40px;text-align:center;">
                    <a href="https://x.com/sjpanelsurvey" style="padding:10px 8px; margin-bottom:10px;"><img src="{{asset('img/frontend/t.png')}}" alt="" style="width:21px; height:21px;"></a>
                    <a href="https://facebook.com/SJPanel/" style="padding:11px 8px; margin-bottom:10px;"><img src="{{asset('img/frontend/fb.png')}}" alt="" style="width:17px; height:17px;"></a>
                    <a href="https://www.linkedin.com/company/sjpanel/" style="padding:8px 8px; margin-bottom:10px;"><img src="{{asset('img/frontend/ind.png')}}" alt="" style="width:23px; height:23px;"></a>
                </div>
            </div>
        </div>
    </div>
  </div>
    
</body>
</html>