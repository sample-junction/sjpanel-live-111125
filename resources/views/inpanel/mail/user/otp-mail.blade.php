<head>
    <meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
    <meta name="viewport" content="width=device-width">

</head>
<style>
    html * {

 font-family: roboto;

       }  
</style>
<body style="background-color:white; font-family: 'Roboto', sans-serif;">

    <div style="margin:auto;width:600px;height:auto; border-radius:10px; background-color:white; box-sizing: border-box; border: 1px solid rgba(233, 233, 233, 1);">
  
    <!-- Header Section -->
      <div style="width:600px;margin:0px;padding:0px;text-align:center;border-bottom:1px solid rgba(233, 233, 233, 1);">
        <img src="{{asset('img/frontend/logo.png')}}" alt="" style="width:170px;height:34px;padding:15px;">
    </div>

    <!-- Body_part_1 -->
    <div style="max-width: 560px; margin: 30px auto; background-color: #f4faff; border-radius: 13px; text-align: center; overflow: hidden;">
        <img  src="{{asset('img/frontend/2fa_verification.png')}}" alt="" style="height: 81px; width: 81px; margin-top: 30px; margin-bottom: 10px;">
        <p style="font-size: 24px; line-height: 32px; font-weight: bold; margin: 0; padding: 0 20px;">Dear Isha,</p>
        <p style="color: #595959; font-size: 16px; margin: 10px 0; padding: 0 20px;">{{__('frontend.otp_mail.header')}}&nbsp;<strong>{{$otp}}</strong></p>
        <p style="color: #595959; font-size: 16px; margin: 0; padding: 0 20px;">{{__('frontend.otp_mail.header1')}} "{{__('frontend.otp_mail.header2')}}". {{__('frontend.otp_mail.header3')}}</p><br>
    </div>


     <!-- Body_part_2 -->
   <div style="width:560px;height:auto;margin:40px auto; border:1px solid white;background-color:rgba(255, 251, 243, 1); border-radius:13px; text-align:center; box-sizing:border-box; padding:10px;">
    <p style="font-size:16px;line-height:20px;">{{__('frontend.otp_mail.sjpanel')}}</p>
    </div>
 
   <!-- Body_part_3 -->
   <div style="width:560px;height:77px; margin:40px auto;background-color:white;  text-align:center; padding:0px;">
      <div style="width:400px;height:77px;margin:auto;padding:0px;">
            <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}}</p>
           <a href= "{{$logoUrl}}" ><img src="{{url('img/jpblog/img/logo.png')}}" alt="logo" width="150px" id="logoId" class="img-fluid ms-lg-4 ms-1 me-1">  </a>          
           <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.address')}}</p>
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

       
        <!-- footer_section_part_3 -->
        <div style="margin:auto;width:600px;height:56px;background-color:rgba(16, 128, 208, 1); margin-bottom:0px; margin-top:0px;">
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
    
    </tbody>
</table>

</body>
<style>
    span .im{
    color: #6f7881 !important;
    }
</style>
