@extends('frontend.layouts.app_blog')
@section('link_url','pages/referral-policy')
@section('meta_title','Referral Policy - SJ Panel')
@section('title','Referral Policy - SJ Panel')
@section('meta_description','Learn about SJ Panel\'s referral policy and how you can earn rewards by referring friends and family to our services. Join now!')
@push('after-styles')
    <style>
        h3{
            color:#292c2d
        }
        h4{
            color:#292c2d
        }
        li{
            color:#292c2d
        }

        .bs-wizard {
            margin-top: 40px;
        }

        /*Form Wizard*/
        .bs-wizard {
            border-bottom: solid 1px #e0e0e0; 
            padding: 0 0 10px 0;
        }
        .bs-wizard > .bs-wizard-step {
            padding: 0;
            position: relative;
            width: 25%;
        }
        .bs-wizard > .bs-wizard-step + .bs-wizard-step {

        }
        .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {
            color: #595959; 
            font-size: 16px; 
            margin-bottom: 5px;
            
        }
        .bs-wizard > .bs-wizard-step .bs-wizard-info {
             color: #999;
             font-size: 14px;
            }
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot {
            position: absolute; 
            width: 30px; 
            height: 30px; 
            display: block;
             background: #fbe8aa; 
             top: 45px; 
             left: 50%;
            margin-top: -15px;
            margin-left: -15px;
            border-radius: 50%;
            }
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {
            content: ' '; 
            width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
        .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
        .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
        .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
        .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
        .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
        .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
        .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
        .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
        .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
    </style>
@endpush


@section('content')
<div class="container pb-3 mt-5 body_content">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <!-- ########################### SECTION START ########################### -->
                <section  class="container features" id="features">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="navy-line"></div>
                            <h1>{{__('cms.reward_policy.details_referral_policy_title')}}</h1>
                        </div>
                    </div>
                    <p>{!!str_replace('#SJPANELURL','<a href="/" target="_blank">www.sjpanel.com</a>',__('cms.referral.para_1'))!!}</p>

                    <ol>
                        <li>{{__('cms.referral.para_2')}}</li> 
                        <li>{{str_replace("#POINTS#",$get_referal_point,__('cms.referral.para_3'))}}</li> 
                        <li>{{__('cms.referral.para_4')}}</li> 
                        <li>{{__('cms.referral.para_5')}}</li> 
                        <li>{{__('cms.referral.para_6')}}</li> 
                        <li>{{__('cms.referral.para_7')}}</li>  
                        
                    </ol>

                <div class="ibox-content forum-container">

                <h4> {{__('cms.reward_policy.details_referral_policy_title_various')}} </h4>
                <div class="row bs-wizard steps_invite_points" style="border-bottom:0;">
                    <div class="col-xs-3 bs-wizard-step complete">
                        <div class="text-center bs-wizard-stepnum"><strong>{!!__('inpanel.invite.index.step1_heading')!!}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center p-1">{{__('inpanel.invite.index.step1_details')}}</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                        <div class="text-center bs-wizard-stepnum"><strong>{{__('inpanel.invite.index.step2_heading')}}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center p-1">{{__('inpanel.invite.index.step2_details')}}</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                        <div class="text-center bs-wizard-stepnum"><strong>{{__('inpanel.invite.index.step3_heading')}}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center p-1">{{__('inpanel.invite.index.step3_details')}}</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step complete"><!-- active -->
                        <div class="text-center bs-wizard-stepnum"><strong>{{__('inpanel.invite.index.step4_heading')}}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center p-1"> {!!__('inpanel.invite.index.step4_details', ['invite_points' => $get_referal_point])!!}</div>
                        <!-- $get_referal_point->value -->
                    </div>
                </div>
                </div>
                </section>
            </div>
        </div>
    </div>
    <div class="container">
    @include('frontend.includes.blog_footer')
    </div>
</div>

@endsection

