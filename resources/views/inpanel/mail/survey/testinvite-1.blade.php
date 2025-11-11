<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="margin: 0px;padding: 0px;background-color:white;font-family: 'Roboto', sans-serif;">
@php

$data = '<div style="margin: 20px auto;width: 600px;">
        <!-- <div style="width: 600px;border-radius: 10px;"> -->
        <table style="width: 600px;border-collapse: collapse;margin: 0px;">
            <tbody>
                <tr>
                    <td style="text-align: center;border:1px solid rgba(233, 233, 233, 1);">
                        <img src="{%LOGO%}" alt="" style="width:170px;height:34px;padding:15px;">
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                        <div style="margin: 20px auto;width:560px;background-color:rgba(244, 250, 255, 1); border-radius:13px;padding:10px 10px;">
                            <img src="{%SURVEY%}" alt="" style="height:81px;width:81px;margin-top:30px;">

                            <p style="font-size:30px;line-height:24px;font-weight:bold;margin-top:20px;"> {%DETAILS_1%} {%U_NAME%},</p>

                            <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{%DETAILS_2%}</p> 
                            {{-- <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{%device_use%}</p> --}}

                        
                                <div style="width:528px;height:153px;margin:40px auto;background-color:rgba(255, 255, 255, 1); border-radius:13px; text-align:center;border:1px solid black;">
                                    <div style="width:203px;">
                                    <p style="font-size:14px;font-weight:bold;background-color:rgba(242, 242, 242, 1);padding:5px; margin-left:20px;"> {%LABELS_1%}: {%S_CODE%}</p>
                                    </div>

                                    <div style="margin:20px auto;text-align:center;">
                                    <table style="margin-left:13px;border-collapse:collapse;">
                                        <thead style="border-bottom:2px solid rgba(236, 236, 236, 1);">
                                            <tr>
                                                <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">{%LABELS_4%}</th>
                                                <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">{%LABELS_2%}</th>
                                                <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">{%LABELS_3%}</th>
                                                <th style="padding:5px 25px;border-bottom:2px solid rgba(236, 236, 236, 1);color:rgba(0, 90, 154, 1);font-size:14px;">Value</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
                                        
                                            <tr>
                                                <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">{%S_TOPIC%}</td>
                                                <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">{%S_LOI%} Minutes</td>
                                                <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">{%S_POINTS%}</td>
                                                <td style="font-size:14px;padding:10px; color:rgba(0, 0, 0, 1);">$5</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>


                            
                                <p style="color:rgba(89, 89, 89, 1); font-size:16px;">{%DETAILS_6%} "{%start_below%}"{%btn_bellow%} </p> 
                           
                            <a href="{%S_LINK%}" target="_blank" style="width:308px; height:45px;background-color:rgba(16, 128, 208, 1);border-radius:5px;text-decoration:none;font-size:16px;line-height:40px;color:white;font-weight:bold;padding:13px 70px;">{%BUTTON_S%}</a>

                          <p style="color:rgba(89, 89, 89, 1); font-size:16px;line-height:24px; justify-content:center;width:auto;margin-top:30px!important;">{%LINE_TEXT%} "{%enter%}"</p> 
                          <tr style="padding: 0px;text-align: center;vertical-align: top;background: #006bde;"
                          align="center">

                          <td  colspan="2" style="color:#ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 300; line-height: 22px; margin: 0;padding: 7px 40px;
                          text-align: center; width: 100%; word-wrap: normal" align="left">
                            <a href="{%S_LINK%}" style="color:#ffffff;">{%S_LINK%}</a>
                          </td>
                      </tr> 
                        </div>
                    </td>
                </tr>

               

                <tr>
                    <td style="border-left:1px solid rgba(233, 233, 233, 1)!important;border-right:1px solid rgba(233, 233, 233, 1)!important;width: 600px;"><p></p>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;width: 600px;height:auto;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                            <div style="width:400px;height:77px;margin:auto;padding:15px;text-align: center;">
                                <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{%happy}</p>
                                {{-- <p style="padding:0px;margin:0px;font-size:18px; font-weight:bold;line-height:26px;">{%safe_sender%}</p> --}}
                                <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);"> {%office_address%}</p>
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
                                <p style="font-size:12px;line-height:23px;">{%MAIL_CONTENT%}<a style="text-decoration: none;" href = "mailto: donotreply@sjpanel.com">{%LINK%}</a> {%LINK_CONTENT%} </p>
                                <p style="font-size:12px;line-height:23px;padding:5px;">{%LINK_CONTENT1%}<a style="text-decoration: none;" href = "mailto: support@sjpanel.com"> {%LINK1%} </a></p>
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
                                                <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{%ROUTE_P%}" >{%POLICY%}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{%ROUTE_C%}"> {%COOKIE%}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{%ROUTE_REFERRAL_P%}"> {%REFERRAL_POLICY%}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;"href="{%ROUTE_S%}">{%SAFEGUARDS%}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{%ROUTE_TC%}">{%T_CONDITION%}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{%ROUTE_F%}" >{%FAQ%}</a>
                                                 <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="ROUTE_CONT">{%CONTACT%}</a>
                                                </div>
   
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;padding:10px 0px;" colspan="7">
                                            <a style="font-size:12px;padding:4px; color:black;" href="{%UNSUBSCRIBE%}" target="_blank">{%UNSUBSCRIBE_LABEL%}</a>  
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
                                                        <p style="font-size:12px;color:white;line-height: 10px;text-align: left;"> {%ALL_RIGHT%} <br> <br>| 2015-{%YEAR%} {%COPYRIGHT_COMPANY%}  &#174;</p>
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
                                            <a  target="_blank" href="https://facebook.com/SJPanel/"><img style="width:24px; height:24px;" src="https://test3.sjpanel.com/img/social_media/facebook.png" alt=""></a>
                                         </td>
                                            <td style="padding:4px;">
                                                <a target="_blank" href="https://x.com/sjpanelsurvey"><img style="width:24px; height:24px;" src="https://test3.sjpanel.com/img/social_media/twitter.png" alt=""></a>
                                            </td>
                                             <td style="padding:4px;"> 
                                                <a target="_blank" href="https://www.linkedin.com/company/sjpanel/"><img sstyle="width:24px; height:24px;" src="https://test3.sjpanel.com/img/social_media/linkedin.png" alt=""></a>
                                            </td>
                                         </tr>
                                     </tbody>
                             </table>              
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>';
    @endphp
@if(isset($placeholders) && !empty($placeholders))
    {!! strtr($data, $placeholders) !!}
@else
    {!! $data !!}
@endif
</body>
</html>