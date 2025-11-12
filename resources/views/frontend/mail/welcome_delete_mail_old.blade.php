<head>
    <meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
    <meta name="viewport" content="width=device-width">

</head>
<body style="background-color:white; font-family: 'Roboto', sans-serif;">

    <div style="margin:auto;width:600px;height:1178px; border-radius:10px; background-color:white; box-sizing: border-box; border: 1px solid rgba(233, 233, 233, 1);">
  
    <!-- Header Section -->
      <div style="width:600px;margin:0px;padding:0px;text-align:center;border-bottom:1px solid rgba(233, 233, 233, 1);">
        <img   src="{{asset('img/frontend/logo.png')}}" alt="" style="width:170px;height:34px;padding:15px;">
    </div>

    <!-- Body_part_1 -->
    <div style="width:560px;height:383px;margin:30px auto;background-color:rgba(244, 250, 255, 1); border-radius:13px; text-align:center;">
        <img src="assets/pic/bell.png" alt="" style="height:81px;width:81px;margin-top:30px;margin-bottom:10px;">
        <p style="font-size:30px;line-height:20px;font-weight:bold;padding:0px;"> {{__('strings.emails.auth.confirmation.greetings')}} {{$user->first_name}},</p>
        <p style="color:rgba(89, 89, 89, 1); font-size:16px;"> {{__('frontend.welcome_mail.details_delete3')}}</p>        

     <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{{__('frontend.welcome_mail.details_delete4')}}</p><br>
     <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{{__('frontend.welcome_mail.details_delete5')}}</p>




   </div>

   <!-- Body_part_2 -->
    <div style="width:560px;height:114px;margin:40px auto; border:1px solid white;background-color:rgba(255, 251, 243, 1); border-radius:13px; text-align:center; padding:30px auto; box-sizing:border-box;">
     <p style="font-size:16px;margin-top:30px;line-height:15px;padding:-5px;">{{__('frontend.welcome_mail.com_details_5')}}</p>
      {{-- <a style="text-decoration:none;font-size:16px;padding:0px;margin:0px;color:rgba(16, 128, 208, 1)" href="mailto: support@sjpanel.com">support@sjpanel.com</a> --}}
   </div> 

   <!-- Body_part_3 -->
   <div style="width:560px;height:77px; margin:40px auto;background-color:white;  text-align:center; padding:0px;">
      <div style="width:400px;height:77px;margin:auto;padding:0px;">
            <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}},</p>
            <p style="padding:0px;margin:0px;font-size:18px; font-weight:bold;line-height:26px;">{{__('frontend.otp_mail.sj_panel')}}</p>
            <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">75-76, Pocket-13, Sector 21, Rohini, Delhi - 110086</p>
      </div>
   </div>

   <!-- Body_part_4 -->
      <div style="width:600px; border-top: 1px solid gainsboro;border-bottom: 1px solid gainsboro; margin-top:40px;">
        <div style="width:560px; margin:auto;background-color:white;  text-align:center; padding:10px;" >  
            <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}} <a style="text-decoration: none;" href = "mailto: donoreply@sjpanel.com">{{__('frontend.otp_mail.link')}}</a> {{__('frontend.otp_mail.link_content')}}</p>
            <!-- <p style="font-size:12px;margin-top:-8px; "> sender list</p> -->
                    
            <p style="font-size:12px;line-height:23px;padding:5px;"><a style="text-decoration: none;" href = "mailto: support@sjpanel.com">{{__('frontend.otp_mail.link1')}}</a></p>
                    
        </div>
      </div>

      <!-- footer_section -->
      <div style="margin:auto;width:600px;height:56px; margin-bottom:0px;margin-top:25px; border-radius-bottom:20px;">
           <!-- Footer_section_part_2 -->
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
        <div style="margin:auto;width:600px;height:56px;background-color:rgba(16, 128, 208, 1); margin-bottom:0px; margin-top:15px;">
            <div style="float:left;padding-top:10px;padding-left:20px;">
                <p style="font-size:12px;margin:0px;color:white;"> {{__("strings.emails.auth.confirmation.all_right")}}</p>
                <p style="font-size:12px;margin:0px;color:white;">2015-{{date('Y')}} {{__('strings.emails.auth.confirmation.copyrightcompany')}} &#174; </p>
            </div>
            <div style="float:right;">
                <div style="display:flex;padding:10px 40px;text-align:center;">
                    <a href="https://twitter.com/SampleJunction" style="padding:10px 8px; margin-bottom:10px;"><img src="{{asset('img/frontend/t.png')}}" alt="" style="width:21px; height:21px;"></a>
                    <a href="https://www.facebook.com/samplejunction/" style="padding:11px 8px; margin-bottom:10px;"><img src="{{asset('img/frontend/fb.png')}}" alt="" style="width:17px; height:17px;"></a>
                    <a href="https://www.linkedin.com/company/sample-junction/" style="padding:8px 8px; margin-bottom:10px;"><img src="{{asset('img/frontend/ind.png')}}" alt="" style="width:23px; height:23px;"></a>
                </div>
                <table class="header-spacer-bottom spacer  float-center" align="center" style="border-collapse: collapse; border-spacing: 0; float: none; line-height: 30px; margin: 0 auto; padding: 0; text-align: center; vertical-align: top; width: 100%">
                    <tbody>
                    <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                        <td height="16px" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 16px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                            align="left" valign="top">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>

                <table class="milkyway-email-card container float-center" align="center" style="background: #FFFFFF; border-collapse: collapse; border-radius: 6px; border-spacing: 0; box-shadow: 0 1px 8px 0 rgba(28,35,43,0.15); float: none; margin: 0 auto; overflow: hidden; padding: 0; text-align: center; vertical-align: top; width: 580px"
                       bgcolor="#FFFFFF">
                    <tbody>
                    <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                        <td style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 1.3; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                            align="left" valign="top">

                            <table class="milkyway-content confirmation-instructions container" align="center" style="background: #FFFFFF; border-collapse: collapse; border-spacing: 0; hyphens: none; margin: auto; max-width: 100%; padding: 0; text-align: inherit; vertical-align: top; width: 300px !important"
                                   bgcolor="#FFFFFF">
                                <tbody>
                                <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                    <td style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 1.3; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                        align="left" valign="top">
                                        <table class=" spacer " style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <td height="30px" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 30px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                                    align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class=" row" style="border-collapse: collapse; border-spacing: 0; display: table; padding: 0; position: relative; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th class=" small-12 large-12 columns first last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0; text-align: left; width: 564px" align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <center style="min-width: 0; width: 100%">
                                                                    <img width="250" src="{{asset('img/frontend/welcome.png')}}"
                                                                         align="center" class=" float-center float-center" style="-ms-interpolation-mode: bicubic; clear: both; display: block; float: none; margin: 0 auto; max-width: 100%; outline: none; text-align: center; text-decoration: none; width: auto">
                                                                </center>
                                                            </th>
                                                            <th class="expander" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; visibility: hidden; width: 0" align="left"></th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class=" spacer " style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <td height="30px" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 30px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                                    align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class=" row" style="border-collapse: collapse; border-spacing: 0; display: table; padding: 0; position: relative; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th class="header-padding small-12 large-12 columns first last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0; text-align: left; width: 564px" align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <h1 class="welcome-header" style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 600; hyphens: none; line-height: 30px; margin: 0 0 24px; padding: 0; text-align: left; width: 100%; word-wrap: normal" align="left">
                                                                    {{__('frontend.welcome_mail.salutation')}} {{$first_name}} {{$last_name}}
                                                                </h1>
                                                            </th>
                                                            <th class="expander" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; visibility: hidden; width: 0" align="left"></th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class=" row" style="border-collapse: collapse; border-spacing: 0; display: table; padding: 0; position: relative; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th class="body-content small-12 large-12 columns first last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0; text-align: left; width: 564px" align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <h2 class="welcome-subcontent" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0; padding: 0; text-align: left; width: 100%; word-wrap: normal" align="left">
                                                                    {{__('frontend.welcome_mail.details_delete1')}}
                                                                </h2>
                                                            </th>
                                                            <th class="expander" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; visibility: hidden; width: 0" align="left"></th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <br />
                                        <table class=" row" style="border-collapse: collapse; border-spacing: 0; display: table; padding: 0; position: relative; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th class="body-content-end small-12 large-12 columns first last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0; text-align: left; width: 564px" align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <h2 class="welcome-subcontent" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0; padding: 0; text-align: left; width: 100%; word-wrap: normal" align="left">


                                                                </h2>
                                                                <p><a style="text-decoration:none;color:#0288d1" href="{{route('inpanel.dashboard')}}">{{__('frontend.welcome_mail.anchor')}}</a>
                                                                </p>
                                                                <br />
                                                                <h2 class="welcome-subcontent" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0; padding: 0; text-align: left; width: 100%; word-wrap: normal" align="left">

                                                                    <p>
                                                                        {{__('frontend.welcome_mail.sub_header')}}
                                                                    </p>
                                                                    <h2>
                                                                        <h2 style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0; padding: 0; text-align: left; width: 100%; word-wrap: normal" align="left">

                                                                            <p>
                                                                                {{__('frontend.welcome_mail.team')}}
                                                                            </p>
                                                                            <h2>
                                                            </th>
                                                            <th class="expander" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; visibility: hidden; width: 0" align="left"></th>
                                                        </tr>
                                                        <br />
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class=" spacer " style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <td height="30px" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 30px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                                    align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="milkyway-content row" style="border-collapse: collapse; border-spacing: 0; display: table; hyphens: none; margin: auto; max-width: 100%; padding: 0; position: relative; text-align: left; vertical-align: top; width: 280px !important">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th class="milkyway-padding small-12 large-12 columns first last" valign="middle" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0; text-align: left; width: 564px"
                                                    align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <table class="cta-text primary radius expanded button" style="border-collapse: collapse; border-spacing: 0; font-size: 14px; font-weight: 400; line-height: 0; margin: 0 0 16px; padding: 0; text-align: left; vertical-align: top; width: 100% !important">
                                                                    <tbody>
                                                                    <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                                        <td style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 1.3; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                                                            align="left" valign="top">
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </th>
                                                            <th class="expander" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; visibility: hidden; width: 0" align="left"></th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <table class=" spacer " style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <td height="10px" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 10px; font-weight: normal; hyphens: auto; line-height: 10px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                                    align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class=" spacer  float-center" align="center" style="border-collapse: collapse; border-spacing: 0; float: none; margin: 0 auto; padding: 0; text-align: center; vertical-align: top; width: 100%">
                    <tbody>
                    <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                        <td height="20px" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 20px; font-weight: normal; hyphens: auto; line-height: 20px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                            align="left" valign="top">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
                <table class="emailer-footer container float-center" align="center" style="background-color: transparent !important; border-collapse: collapse; border-spacing: 0; float: none; margin: 0 auto; padding: 0; text-align: center; vertical-align: top; width: 580px"
                       bgcolor="transparent">
                    <tbody>
                    <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                        <td style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 1.3; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                            align="left" valign="top">
                            <table class=" row" style="border-collapse: collapse; border-spacing: 0; display: table; padding: 0; position: relative; text-align: left; vertical-align: top; width: 100%">
                                <tbody>
                                <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                    <th class=" small-12 large-4 columns first" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 8px 16px 16px; text-align: left; width: 177.3333333333px"
                                        align="left">
                                        <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                </th>
                                                <th class="emailer-border-bottom small-12 large-11 columns first" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 0 16px; text-align: left; width: 91.666666%"
                                                    align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <p class="text-left small-text-center" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.5; margin: 0; padding: 0; text-align: left" align="left">
                                                                    <a href="{{route('frontend.cms.rewards')}}" style="color: #4E78F1; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none">{{__('strings.emails.auth.confirmation.rewards')}}</a>
                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                                <th class="show-for-large small-12 large-1 columns last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 0 16px; text-align: left; width: 8.333333%" align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <p class="first-bullet" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; left: 6px; line-height: 1.5; margin: 0; padding: 0; position: relative; text-align: left" align="left">

                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                    <th class=" small-12 large-4 columns" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 8px 16px; text-align: left; width: 177.3333333333px" align="left">
                                        <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                </th>
                                                <th class="emailer-border-bottom small-12 large-11 columns first" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 0 16px; text-align: left; width: 91.666666%"
                                                    align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <p class="text-center small-text-center" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.5; margin: 0; padding: 0; text-align: center" align="center">
                                                                    <a target="_blank" href="{{route('frontend.cms.privacy')}}" style="color: #4E78F1; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                                <th class="show-for-large small-12 large-1 columns last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 0 16px; text-align: left; width: 8.333333%" align="left">
                                                    <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                                        <tbody>
                                                        <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                            <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                                <p class="last-bullet" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; left: 22px; line-height: 1.5; margin: 0; padding: 0; position: relative; text-align: left" align="left">

                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                    <th class="emailer-border-bottom small-12 large-4 columns last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 16px 16px 8px; text-align: left; width: 177.3333333333px"
                                        align="left">
                                        <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                    <p class="text-center small-text-center" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.5; margin: 0; padding: 0; text-align: center" align="center">
                                                        <a target="_blank" href="{{route('frontend.cms.faq')}}" style="color: #4E78F1; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none">{{__('strings.emails.auth.confirmation.faq')}}</a>
                                                    </p>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <table class="make-you-smile row" style="border-collapse: collapse; border-spacing: 0; display: table; padding: 0; position: relative; text-align: left; vertical-align: top; width: 100%">
                                <tbody>
                                <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                    <th class=" small-12 large-12 columns first last" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0 auto; padding: 0 16px 16px; text-align: left; width: 564px" align="left">
                                        <table style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%">
                                            <tbody>
                                            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                                <th style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left" align="left">
                                                    <p class="help-email-address text-center" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 1.5; margin: 0; padding: 0; text-align: center" align="center">
                                     <span class="text-divider" style="margin-left: 10px; margin-right: 10px">
                                    {{__('strings.frontend.disclaimer')}}
                                         <a href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $email])}}" style="color: #4E78F1; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none" target="_blank">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a>
</span>
                                                    </p>
                                                    <br />
                                                    <p class="text-center email-tag-line" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.5; margin: 0; padding: 0; text-align: center" align="center">
                                                        {{__('frontend.index.footer_Section_1')}}
                                                    </p>
                                                    <br />
                                                    <p class="text-center email-tag-line" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.5; margin: 0; padding: 0; text-align: center" align="center"> {{__('strings.emails.auth.confirmation.copyright')}} © 2015 - {{date('Y')}}</p>

                                                </th>
                                                <th class="expander" style="color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; visibility: hidden; width: 0" align="left"></th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </center>
        </td>
    </tr>
    </tbody>
</table>

</body>

