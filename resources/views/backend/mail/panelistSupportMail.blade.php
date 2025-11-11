<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
    <meta name="viewport" content="width=device-width">

</head>

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
    $orig_locale = app()->getLocale();
    app()->setLocale('en_US');
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
                                                   {{--<td  colspan="2" style=" height:60px;background: #f2f2f2;  text-align: left;padding: 10px 0px;" align="center">

                                                        <img width="100px"
                                                            src="{{asset('img/frontend/logo.png')}}"
                                                            align=" center" class="float-center float-center"
                                                            style="  display: block; margin: 0 auto; max-width: 100%; text-align: center;  width: auto">
                                                    </td>--}}
                                                </tr>
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                                {{-- <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <th style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;     padding: 0 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                        Hii,
                                                    </th>

                                                </tr> --}}
                                                
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                                <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <td colspan="2" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 10px 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                        {{__('inpanel.Panelist_Support_Mail.content_2')}}

                                                    </td>
                                                </tr>
                                               {{-- <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <td colspan="2" align="center" valign="top">
                                                        <a href="{{route('frontend.auth.account.confirm', $confirmation_code)}}"
                                                            style="border: 1px solid #006bde;border-radius: 6px;color: #FFFFFF;display: inline-block;font-family: Helvetica, Arial, sans-serif;font-size: 16px;font-weight:500;line-height: 1.3;margin: 0px;padding: 10px 10px;
                                                        text-align: center;text-decoration: none;width: 22%; background:#006bde;"
                                                            target="_blank"> {{__('strings.emails.auth.confirmation.confirm_button')}}</a>
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                                {{--<tr style="padding: 0px;text-align: center;vertical-align: top;background: #006bde;"
                                                    align="center">
                                                    <td  colspan="2" style="color:#fff; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 7px 40px;
                                                    text-align: center; width: 100%; word-wrap: normal" align="left">
                                                        
                                                    </td>
                                                </tr>--}}

                                                <!----------Footer Start--------->

                                                {{-- @include('includes.partials.common_mail_footer')--}}

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
@php 
     
    app()->setLocale($orig_locale);
@endphp
</body>

</html>



