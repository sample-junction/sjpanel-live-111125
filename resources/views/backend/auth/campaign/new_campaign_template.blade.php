@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('campaign_history'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @else
        {{session('fail')}}
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <div>
                        <a class="btn btn-primary" href="{{route('admin.auth.template-detail')}}">Back</a>
                    <center><label>
                        <h4>
                            New Template
                        </h4>
                    </label></center>
                </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div style="font-size:30px;">
                    <form action="{{route('admin.auth.new-campaign-template')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mt-2">
                        <label for=""><h5>Template Type :</h5></label>
                        <select name="template_type" id="" class="form-select" aria-label="Default select example">
                            <option value="">Select Template Type</option>
                            <option value="1">Campaign</option>
                        </select>
                       </div>

                    <div class="form-group mt-2">
                        <label for=""><h5>Template Name :</h5></label>
                        <input type="text" name="template_name" class="form-control" placeholder="Enter Template Name">
                    </div>

                    <div class="form-group mt-2">
                        <label for=""><h5>Email Subject :</h5></label>
                        <input type="text" name="email_subject" class="form-control" placeholder="Enter Email Subject">
                        <input type="hidden" name="user_id"  value="{{$logged_in_user->id}}">
                    </div>
                   
                    <div class="form-group mt-2">
                        <label for=""><h5>Template Body Content :</h5></label>
                        <textarea name="template_content" class="content" id="email_content" cols="60" rows="1000" style="">
                        <div style="margin: 20px auto;width: auto;">
                            <table style="width: 600px;border-collapse: collapse;margin: 0px;">
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;border:1px solid rgba(233, 233, 233, 1);min-height:auto;">
                                        <div style="min-height:auto;"><a href=":logo_url"><img alt="" id="header_logo_section" src="https://test112.sjpanel.com/img/img_email/logo.png" style="width:200px;min-height:40px;padding:15px;" /></a></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                        <div style="margin: 20px auto;width:560px;background-color:rgba(244, 250, 255, 1); border-radius:13px;padding:10px 10px;min-height:400px;"><img alt="" id="body_logo_section" src="https://test112.sjpanel.com/img/img_email/Points.png" style="height:81px;width:81px;margin-top:30px;" />
                                        <p style="font-size:20px;line-height:24px;font-weight:bold;margin-top:20px;">Dear :userFristName,</p>

                                        <div id="body_content" style="min-height:100px;">
                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">Thanks for joining SJ Panel. Our data shows that you have completed all your profiling surveys but still not have completed a single survey so far.</p>

                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">As a valued panellists, we are offering Welcome Back reward up to $5. Simply log in with your SJ Panel account details and fulfil the following tasks before 31st Jan, 2024.</p>

                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">1. Complete at least 2 live surveys and earn $3</p>

                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">2. Refer to at least 5 People and earn $2</p>

                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">If you complete both the tasks, you will be eligible for additional $5 apart from your regular survey points.</p>
                                        </div>

                                        <div style="padding-bottom:20px; marign-top:10px;margin-bottom:10px;"><a href=":link" id="button_text" style="color:white;text-decoration:none;background-color:blue;padding:10px 20px;border-radius:20px;font-weight:bold;">join Now</a></div>

                                        <p>Note: Please visit &ldquo;Surveys&rdquo; page for more exciting surveys and chance to earn maximum rewards. For additional and maximum reward, kindly make sure your referrals join our panel and complete a survey.</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;width: 600px;height:auto;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                        <div style="margin:auto;width:560px;height:auto;background-color:rgba(255, 251, 243, 1); border-radius:13px;padding: 20px 10px; justify-content:center;">
                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">If you have any questions or concerns, feel free to contact our support team at <a href="mailto:support@sjpanel.com" style="text-decoration:none;">support@sjpanel.com</a>. We&#39;re here to assist you.</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-left:1px solid rgba(233, 233, 233, 1)!important;border-right:1px solid rgba(233, 233, 233, 1)!important;width: 600px;">
                                        <p>&nbsp;</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;width: 600px;height:auto;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                        <div style="width:400px;auto;margin:auto;padding:15px;text-align: center;">
                                        <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">Best Regards,</p>
                                        <a href=":logo_url"><img alt="" id="footer_logo_section" src="https://test112.sjpanel.com/img/img_email/logo.png" style="width:200px;height:40px;padding:5px;" /></a>

                                        <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">Suite 117, 9131 Keele St Suite A4, Vaughan, ON L4K 0G7</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-left:1px solid rgba(233, 233, 233, 1)!important;border-right:1px solid rgba(233, 233, 233, 1)!important;width: 600px;">
                                        <p>&nbsp;</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;width: 600px; border: 1px solid rgba(233, 233, 233, 1);">
                                        <div style="margin: 20px auto;width:560px;padding:0px 10px; text-align: center;">
                                        <div style="margin:auto;">
                                        <p style="font-size:12px;line-height:23px;">To recieve our emails in your inbox &amp; avoid spam, please add<a href="mailto: donotreply@sjpanel.com" style="text-decoration: none;"> donotreply@sjpanel.com</a> to your safe sender list.</p>

                                        <p style="font-size:12px;line-height:23px;padding:5px;">You are receiving this email because you are a registered member of SJ Panel where we reward you through incentives for taking part in online surveys. If you do not wish to receive any future email from SJ Panel, please Unsubscribe to de-activate your account. As soon as you unsubscribe from SJ Panel, your account will be deleted within 72 hours and you will stop receiving emails from SJ Panel. In case you need any technical support, please write to our team at <a href="mailto: support@sjpanel.com" style="text-decoration: none;">support@sjpanel.com</a></p>
                                        </div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                        <table style="width:580px;background-color:white; text-align:center;padding:auto;margin-top:20px!important;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                    <div style="float:right;text-align:center;"><a href="https://test112.sjpanel.com/pages/privacy" style="font-size:12px;padding:3px; text-decoration:none;color:black;">Privacy Policy</a> <a href="https://test112.sjpanel.com/pages/cookies" style="font-size:12px;padding:3px; text-decoration:none;color:black;">Cookie Policy</a> <a href="https://test112.sjpanel.com/pages/referral-policy" style="font-size:12px;padding:3px; text-decoration:none;color:black;">Referral Policy</a> <a href="https://test112.sjpanel.com/pages/safeguard" style="font-size:12px;padding:3px; text-decoration:none;color:black;">Safeguards</a> <a href="https://test112.sjpanel.com/pages/terms&amp;condition" style="font-size:12px;padding:3px; text-decoration:none;color:black;">Terms &amp; Condition</a> <a href="https://test112.sjpanel.com/pages/faq" style="font-size:12px;padding:3px; text-decoration:none;color:black;">FAQ&#39;s</a> <a href="https://test112.sjpanel.com/pages/contact" style="font-size:12px;padding:3px; text-decoration:none;color:black;">Contact</a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" style="text-align:center;padding:10px 0px;"><a href="https://test112.sjpanel.com/user/unsubscribe?signature=8622cff386c0d79f367f5d79211714ea9fbdd68227058d16fd84ffb0d436f063" style="font-size:12px;padding:4px; color:black;text-decoration:none;">Unsubscribe</a></td>
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
                                                                <p style="font-size:12px;color:white;line-height: 10px;text-align: left;margin-top:10px;">All rights reserved.<br />
                                                                <br />
                                                                2015-{{ date('Y') }} RS Sample Junction LLP &reg;</p>
                                                                </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    </td>
                                                    <td style="padding-right:4px;padding-left:30px;"><a href="https://x.com/sjpanelsurvey" style="padding:6px 6px;"><img alt="" src="https://test112.sjpanel.com/img/img_email/twitter.png" style="width:24px; height:24px;" /></a></td>
                                                    <td style="padding:4px;"><a href="https://facebook.com/SJPanel" style="padding:8px 8px;"><img alt="" src="https://test112.sjpanel.com/img/img_email/fb.png" style="width:19px; height:19px;" /></a></td>
                                                    <td style="padding:4px;"><a href="https://www.linkedin.com/company/sjpanel/" style="padding:9px 8px;"><img alt="" src="https://test112.sjpanel.com/img/img_email/linkdin.png" style="width:19px; height:19px;" /></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>

                           
                        </textarea>
                    </div>

                    <div class="form-group mt-2">
                        <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#preview_template_Modal">Preview</span>
                    </div>


                    <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Gallery</span>



                    <div class="form-group mt-2">
                        <input type="hidden" name="user_id"  value="{{$logged_in_user->id}}">
                        <label for=""><h5>URL Link for Redirecting Panellist :</h5></label>
                        <input  type="text" name="url" class="form-control" placeholder="Enter URL Link">
                    </div>

                    <center><button type="submit" class="btn btn-primary">Save</button></center>
                    </form>
                    </div>
                </div>

                <!-- Template Section -->

                    <!-- Modal -->
                    <div class="modal fade" id="preview_template_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" style="min-width:900px;">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="margin-left:15%;">
                        <div class="content">

                        <div style="margin: 20px auto;width: auto;">
                                    <table style="width: 600px;border-collapse: collapse;margin: 0px;">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;border:1px solid rgba(233, 233, 233, 1);min-height:auto;">
                                                   <div style="min-height:auto;">
                                                   <img src="{{asset('img/img_email/logo.png')}}" alt="" style="width:200px;min-height:40px;padding:15px;">
                                                   </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                                    <div style="margin: 20px auto;width:560px;background-color:rgba(244, 250, 255, 1); border-radius:13px;padding:10px 10px;min-height:400px;">
                                                        <img src="{{asset('img/img_email/Points.png')}}" alt="" style="height:81px;width:81px;margin-top:30px;">

                                                        <p style="font-size:20px;line-height:24px;font-weight:bold;margin-top:20px;">{{__('inpanel.mail.invitation.invite_freind_content_1')}} :userFristName,</p>

                                                        <div id="body_content" style="min-height:100px;"> 
                                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">
                                                        Thanks for joining SJ Panel. Our data shows that you have completed all your profiling surveys but still not have completed a single survey so far.
                                                        </p>
                                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">As a valued panellists, we are offering Welcome Back reward up to $5. Simply log in with your SJ Panel account details and fulfil the following tasks before 31st Jan, 2024.</p>

                                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">1. Complete at least 2 live surveys and earn $3</p>
                                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">2. Refer to at least 5 People and earn $2</p>
                                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">If you complete both the tasks, you will be eligible for additional $5 apart from your regular survey points.</p>
                                                        </div>

                                                        <br>
                                                    <div style="padding-bottom:20px;">
                                                    <a style="color:white;text-decoration:none;background-color:blue;padding:10px 20px;border-radius:20px;font-weight:bold;" id="button_text" href=":link">join Now</a> 
                                                    </div>
                                                    <br>
                                                    <p>Note: Please visit “Surveys” page for more exciting surveys and chance to earn maximum rewards. For additional and maximum reward, kindly make sure your referrals join our panel and complete a survey.</p>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align:center;width: 600px;height:auto;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                                    <div style="margin:auto;width:560px;height:auto;background-color:rgba(255, 251, 243, 1); border-radius:13px;padding: 20px 10px; justify-content:center;">
                                                        <p style="font-size:16px;line-height:24px;color:rgba(51, 51, 51, 1);justify-content:center;">
                                                        {{__('inpanel.mail.invitation.fraud_info_mail_content_6')}} <a href="mailto:support@sjpanel.com" style="text-decoration:none;">support@sjpanel.com</a>. {{__('inpanel.mail.invitation.fraud_info_mail_content_7')}}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="border-left:1px solid rgba(233, 233, 233, 1)!important;border-right:1px solid rgba(233, 233, 233, 1)!important;width: 600px;"><p></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align:center;width: 600px;height:auto;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                                        <div style="width:400px;auto;margin:auto;padding:15px;text-align: center;">
                                                            <p style="padding:0px;margin:0px;font-size:18px;line-height:24px;color:rgba(51, 51, 51, 1);">{{__('frontend.otp_mail.best_regards')}}</p>
                                                            <a href=""><img src="{{asset('img/img_email/logo.png')}}" alt="" style="width:200px;height:70px;padding:5px;"></a>
                                                            <p style="padding:0px;margin:0px;font-size:14px;line-height:24px; color:rgba(51, 51, 51, 1);">{{__('frontend.index.footer.links.office_address')}}</p>
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
                                                            <p style="font-size:12px;line-height:23px;">{{__('frontend.otp_mail.mail_content')}}<a style="text-decoration: none;" href = "mailto: donotreply@sjpanel.com"> {{__('frontend.otp_mail.link')}}</a> {{__('frontend.otp_mail.link_content')}} </p>
                                                                
                                                            <p style="font-size:12px;line-height:23px;padding:5px;">{{__('frontend.otp_mail.link_content1')}}<a style="text-decoration: none;" href = "mailto: support@sjpanel.com">{{__('frontend.otp_mail.link1')}}</a></p>
                                                    </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align:center;width: 600px;border-left:1px solid rgba(233, 233, 233, 1);border-right:1px solid rgba(233, 233, 233, 1);">
                                                    
                                                            <table style="width:580px;background-color:white; text-align:center;padding:auto;margin-top:20px!important;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <div style="float:right;text-align:center;">
                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.cookie')}}">{{__('strings.emails.auth.confirmation.cookie')}}</a>
                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.safeguard')}}">{{__('strings.emails.auth.confirmation.safeguards')}}</a>
                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>
                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.faq')}}">{{__('strings.emails.auth.confirmation.faq')}}</a>

                                                                            <a style="font-size:12px;padding:3px; text-decoration:none;color:black;" href="{{route('frontend.cms.help_support')}}">{{__('strings.emails.auth.confirmation.contact')}}</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:center;padding:10px 0px;" colspan="7">
                                                                        <a style="font-size:12px;padding:4px; color:black;text-decoration:none;" href="{{\Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe')}}">{{__('strings.emails.auth.confirmation.unsubscribe')}}</a>
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
                                                                                    <p style="font-size:12px;color:white;line-height: 10px;text-align: left;margin-top:10px;">{{__('inpanel.mail.invitation.company_copyright_1')}} <br> <br>2015-{{date('Y')}} {{__('inpanel.mail.invitation.company_copyright_2')}} &#174;</p>
                                                                                    </div>
                                                                                </td>   
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding-right:4px;padding-left:30px;">
                                                                        <a href="https://twitter.com/SampleJunction" style="padding:6px 6px;"><img src="{{asset('img/img_email/twitter.png')}}" alt="" style="width:24px; height:24px;"></a>
                                                                    </td>
                                                                        <td style="padding:4px;">
                                                                        <a href="https://www.facebook.com/samplejunction/" style="padding:8px 8px;"><img src="{{asset('img/img_email/fb.png')}}" alt="" style="width:19px; height:19px;"></a>
                                                                        </td>
                                                                        <td style="padding:4px;"> 
                                                                        <a href="https://www.linkedin.com/company/sample-junction/" style="padding:9px 8px;"><img src="{{asset('img/img_email/linkdin.png')}}" alt="" style="width:19px; height:19px;"></a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                        </table>              
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                        </div>

                        </div>
                        </div>
                    </div>
                    </div>


    

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="min-width:900px;">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Photo Gallery</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                            <div style="height: 200px; overflow-y: scroll;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Path</th>
                                            <th>Photo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datas as $gall)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$gall->image_name}}</td>
                                            <td>{{asset($gall->path)}}</td>
                                            <td><img src="{{asset($gall->path)}}" alt="" style="height:81px;width:81px;"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>

            
             
                <p><strong>Note:</strong> </p>
                <p>Use the following Variables:-</p>
                <p>1.<strong>(:userFisrtName)</strong> for polulating UserFisrtName <br>2.<strong>(:link)</strong> in href of Join Now Button for Panelist Link Click Check <br>3.<strong>(:logo_url)</strong> in href of company's 'Logo <br>4.<strong>(:pid)</strong> in URL Link for Redirecting Panellist to replace with actual panelist id dynamically </p>
                
            </div>
        </div>
    </div><!--card-->
    @include('backend.auth.campaign.campaign_history_model')
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .th-td-hide{
            display:none;
        }
        .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 1000px;
            }
            .ck-content .image {
                /* Block images */
                max-width: 80%;
                margin: 20px auto;
            }

            /* Center the CKEditor content */
            .cke_wysiwyg_frame {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            /* Optionally, set a max-width for the CKEditor container */
            .cke_wysiwyg_div {
                max-width: 600px; /* Adjust the value as needed */
                margin: 0 auto; /* Center the container horizontally */
            }

    </style>

@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.css">
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
<script>
  
  $(document).ready(function () {
                CKEDITOR.replace('email_content', {
                filebrowserBrowseUrl: '/ckfinder/ckfinder.html?resourceType=Files',
                filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                toolbar: [
                    { name: 'clipboard', items: ['Undo', 'Redo'] },
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'insert', items: ['Image'] },
                    { name: 'source', items: ['Source'] },
                    { name: 'styles', items: ['Format', 'Font', 'FontSize'] }
                ],
                extraPlugins: 'autogrow',
                autoGrow_bottomSpace: 10,
                allowedContent: true, // Allow all HTML tags
                fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;30/30px;32/32px;36/36px;40/40px;44/44px;48/48px;52/52px;56/56px;60/60px;64/64px;68/68px;72/72px;76/76px;80/80px;84/84px;88/88px;92/92px;96/96px;100/100px;',
            });

            CKEDITOR.instances.email_content.on('change', function (evt) {
                console.log(evt.editor.getData());
                $('.content').html(evt.editor.getData());
            });


            // $('#t_button_text').on('input',function(){
            //     var val = $('#t_button_text').val();
            //     $('#button_text').html(val);
            // });

            CKEDITOR.instances.email_content.on('instanceReady', function (evt) {
                    // Get the CKEditor iframe
                    var editorIframe = evt.editor.editable().$;

                    // Apply styles to center the content
                    $(editorIframe).css({
                        'display': 'flex',
                        'flex-direction': 'column',
                        'align-items': 'center',
                        'justify-content': 'center',
                        'height': '100%', // Ensure iframe takes full height
                    });
                });

               
        });


</script>
    
    
@endpush






