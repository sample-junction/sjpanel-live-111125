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
                                                <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <th style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;     padding: 0 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                @if(count($data) > 2)
                                                   {{$data[0]}}
                                                @elseif(count($data) > 0 && count($data) <= 2)
                                                    @if ($data[0] >= 1000)
                                                    A redemption request of {{$redeem_points}} points({{$totalEarnedAmount}}) has been raised by <br><br><br>Name:{{$user->first_name}} <br> Panelist ID: {{$user->panellist_id}} <br> Country: {{ $user->country }} <br>State: {{$user_state}}
                                                    @else
                                                    A redemption request of {{$redeem_points}} points({{$totalEarnedAmount}}) has been raised by <br><br><br>Name:{{$user->first_name}} <br> Panelist ID: {{$user->panellist_id}} <br> Country: {{ $user->country }} <br>State: {{$user_state}}
                                                    @endif
                                                @else
                                                    New User registered with following details,
                                                @endif

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
                                                    @if(count($data) > 2 )
                                                    {{$data[1]}}

                                                    @elseif (count($data) > 0 && count($data) <= 2 )

                                                  @else
                                                        Name : {{$user->first_name}}  {{$user->last_name}}
                                                    @endif
                                                    </td>
                                                </tr>
												<tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <td colspan="2" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 10px 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                    @if(count($data) > 2 )
                                                    {{$data[2]}}

                                                    @elseif (count($data) > 0 && count($data) <= 2 )

                                                    @else
                                                        Panelist ID : {{$user->panellist_id}} 
                                                    @endif
                                                    </td>
                                                </tr>
												<tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                    <td colspan="2" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 10px 40px;
                                                    text-align: left; width: 100%; word-wrap: normal" align="left">
                                                    @if(count($data) > 2 )
                                                    {{$data[3]}}

                                                   @elseif (count($data) > 0 && count($data) <= 2 )
                                                    @else    

                                                        Country : {{$user->country}} 

                                                    @endif
                                                    </td>
                                                </tr>
                                                @if(count($data) > 2 )
                                                   @php $init = 4; @endphp
                                                    @for($x = 0; $x < 4; $x++)
                                                    @php $index = $init + $x; @endphp
                                                    <tr style="padding: 0; text-align: left; vertical-align: top"
                                                    align="left">
                                                        <td colspan="2" style="color: #6F7881; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 10px 40px;
                                                        text-align: left; width: 100%; word-wrap: normal" align="left">
                                                        {{$data[$index]}}
                                                        
                                                        </td>
                                                    </tr>
                                                    @endfor
                                                @endif
                                                <tr>
                                                    <td colspan="2" height="20px" align="left" valign="top" style="padding: 0;">
                                                    </td>
                                                </tr>
                                                
                                                
                                                <!------------Footer Section Start--------------->
                                                @php 
                                                $originalLocale = app()->getLocale();
                                                            app()->setLocale('en_US');
                                                @endphp
                                                {{--@include('includes.partials.common_mail_footer')--}}

                                                @php
                                                            app()->setlocale($originalLocale);
                                                @endphp  
                                            <!------------Footer Section End--------------->
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



