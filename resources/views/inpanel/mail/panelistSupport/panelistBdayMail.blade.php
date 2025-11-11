<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color:white; font-family: 'Roboto', sans-serif;">

<body style="-webkit-text-size-adjust: 100%;
box-sizing: border-box;
color: #1C232B;
font-family: Helvetica, Arial, sans-serif;
font-size: 16px;
font-weight: normal;
line-height: 22px;
margin: 0;
min-width: 100%;
padding: 0;
text-align: left;
width: 100% !important;">

        @php
             $originalLocale = app()->getLocale();

              app()->setLocale($user->locale);
        @endphp

    <table class="body" data-made-with-foundation=""
        style="background: #FAFAFA; border-collapse: collapse; border-spacing: 0; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; height: 100%; line-height: 1.3; margin: 0; padding: 0; text-align: left; vertical-align: top; width: 100%"
        bgcolor="#FAFAFA">
        <tbody>
            <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                <td  class="center" align="center" valign="top"
                    style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 1.3; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word">
                    <center style="min-width: 580px; width: 100%">
                        <table class=" spacer  float-center" align="center"
                            style="border-collapse: collapse; border-spacing: 0; float: none; margin: 0px auto; padding: 0; text-align: center; vertical-align: top; width: 100%">
                            <tbody>
                                <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                    <td height="20px"
                                        style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 20px; font-weight: normal; hyphens: auto; line-height: 20px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                        align="left" valign="top">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>


                        <table align="center"
                            style="background: #FFFFFF; border-collapse: collapse; border-radius: 6px; border-spacing: 0; box-shadow: 0 1px 8px 0 rgb(28 35 43 / 15%); float: none; margin: 0 auto; overflow: hidden; padding: 0; text-align: center; vertical-align: top; width: 580px"
                            >
                            <tbody>
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <td colspan="2" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 1.3; margin: 0; padding: 0px; text-align: left; vertical-align: top; word-wrap: break-word"
                                        align="left" valign="top">

                                        <table class="milkyway-content confirmation-instructions container"
                                            align="center"
                                            style="background: #FFFFFF; border-collapse: collapse; border-spacing: 0; hyphens: none; margin: auto; max-width: 580px; width: 100% !important; text-align: inherit; vertical-align: top; "bgcolor="#FFFFFF">
                                            <tbody>
                                                <tr  style="background: #f2f2f2;">
                                                    <td  colspan="2" style=" height:60px;background: #f2f2f2;  text-align: left;padding: 10px 0px;" align="center">

                                                        <img width="100px"
                                                            src="{{asset('img/frontend/logo.png')}}"
                                                            align=" center" class="float-center float-center"
                                                            style="  display: block; margin: 0 auto; max-width: 100%; text-align: center;  width: auto">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                                <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <th style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;     padding: 0 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                       {{__('strings.emails.auth.confirmation.greetings')}}   {{$user->first_name}},
                                                    </th>

                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                                <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <td colspan="2" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 10px 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                      <p style="color:#6f7881 !important">
                                                        {!! (($emailContent)) !!}
                                                        <br />
                                                    </p>

                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                               

                                                <!----------Footer Start--------->

                                            @php
                                                $originalLocale = app()->getLocale();
                                                
                                                app()->setLocale($user->locale);
                                            @endphp
                                            
                                            @include('includes.partials.common_mail_footer')
                                            
                                            @php
                                                app()->setLocale($originalLocale);
                                            @endphp
                                            <!--------footer end------->
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <table class="header-spacer-bottom spacer  float-center" align="center"
                            style="border-collapse: collapse; border-spacing: 0; float: none; line-height: 30px; margin: 11px auto; padding: 0; text-align: center; vertical-align: top; width: 100%">
                            <tbody>
                                <tr style="padding: 0; text-align: left; vertical-align: top" align="left">
                                    <td height="16px"
                                        style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse !important; color: #1C232B; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: normal; hyphens: auto; line-height: 16px; margin: 0; mso-line-height-rule: exactly; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word"
                                        align="left" valign="top">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>


                    </center>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>


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
                    <a href="https://x.com/sjpanelsurvey" style="padding:10px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/twitter.png')}}" alt="" style="width:21px; height:21px;"></a>
                    <a href="https://facebook.com/SJPanel/" style="padding:11px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/fb.png')}}" alt="" style="width:17px; height:17px;"></a>
                    <a href="https://www.linkedin.com/company/sjpanel/" style="padding:8px 8px; margin-bottom:10px;"><img src="{{asset('img/email_temp/ind.png')}}" alt="" style="width:23px; height:23px;"></a>
                </div>
            </div>
        </div>
    </div>
  </div>
    
</body>
</html>