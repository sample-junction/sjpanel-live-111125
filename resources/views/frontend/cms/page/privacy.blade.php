@extends('frontend.layouts.app_blog')
@section('link_url','pages/privacy')
@section('meta_title','Privacy Policy - SJ Panel')
@section('title','Privacy Policy - SJ Panel')
@section('meta_description','Our privacy policy outlines our commitment to protecting your personal information. Learn how we use and safeguard your data at SJ Panel.')
@section('content')
<style>
   body a {
     text-decoration:none!important;
     /* color:blue!important; */
     /* font-size:18px!important; */
    }
    body li {
        font-size:18px!important;
    }
    body p{
        font-size:18px!important;
    }
</style>
<div class="container pb-3 mt-5 body_content">
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <!-- ########################### SECTION START ########################### -->
                <section  class="container features" id="features">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="navy-line"></div>
                            <h1>{{__('cms.privacy.heading_1')}}</h1>
                        </div>
                    </div>
                    <p>
                        <a href="//sjpanel.com" style="text-decoration:none!important;color:blue!important;">www.sjpanel.com</a> {{__('cms.privacy_policy_2.details_1')}}
                    </p>
                    <p>{{__('cms.privacy_policy_2.details_2')}}
                    </p>

                    <p>{{__('cms.privacy_policy_2.details_3')}}</p>
                    <p>{{__('cms.privacy_policy_2.details_4')}}</p>

                    <p>{{__('cms.privacy_policy_2.details_5_1')}}<a href="{{route('frontend.cms.ccpa-privacy')}}" style="text-decoration:none!important;color:blue!important;"> {{__('cms.privacy_policy_2.details_5_2')}} </a>{{__('cms.privacy_policy_2.details_5_3')}}</p>

                    <h3><strong>{{__('cms.privacy_policy_2.question_1.heading')}}</strong></h3>
                    <p><h4><strong>1. {{__('cms.privacy_policy_2.question_1.point_1')}}</strong></h4></p>
                    <p>{{__('cms.privacy_policy_2.question_1.point_1_details')}}
                    </p>

                    <p><h4><strong>2. {{__('cms.privacy_policy_2.question_1.point_2')}}</strong></h4></p>
                    <p>{{__('cms.privacy_policy_2.question_1.point_2_details')}}
                    </p>
                    <p>{{__('cms.privacy_policy_2.question_1.point_2_details_1')}}
                    </p>

                    <p><strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_email')}}</strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_email_details')}}
                    </p>
                    <p><strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_age')}}</strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_age_details')}}
                    </p>
                    <p><strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_social')}}</strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_social_details')}}
                    </p>
                    <p><strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_physical')}} </strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_physical_details')}}
                    </p>
                    <p><strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_special')}}</strong>{{__('cms.privacy_policy_2.question_1.point_2_details_1_special_details')}}
                    </p>

                    <h4><strong>3. {{__('cms.privacy_policy_2.question_1.point_3')}}</strong></h4>
                    <!-- <p>{{__('cms.privacy_policy_2.question_1.point_3_details')}}</p> -->
                    <p>{{__('cms.privacy_policy_2.question_1.point_3_details_1')}}
                    </p>

                    <p>{{__('cms.privacy_policy_2.question_1.point_3_details_2')}}
                    </p>

                    <h4><strong>4.  {{__('cms.privacy_policy_2.question_1.point_4')}}</strong></h4>
                    <p>{{__('cms.privacy_policy_2.question_1.point_4_details')}}
                    </p>

                    <p><h4><strong>5. {{__('cms.privacy_policy_2.question_1.point_5')}}</strong></h4></p>
                    <p>{{__('cms.privacy_policy_2.question_1.point_5_details')}}
                    </p>

                    <h4><strong>6. {{__('cms.privacy_policy_2.question_1.point_6')}}</strong></h4>
                    <p>{{__('cms.privacy_policy_2.question_1.point_6_details')}}</p>
                    <p>{{__('cms.privacy_policy_2.question_1.point_6_details_1')}}
                    </p>
                    <p>{{__('cms.privacy_policy_2.question_1.point_6_details_2')}}</p>

                    <h3><strong>{{__('cms.privacy_policy_2.question_2.heading')}}</strong></h3>
                    <p>{{__('cms.privacy_policy_2.question_2.details')}}</p>

                    <h3><strong>{{__('cms.privacy_policy_2.question_3.heading')}}</strong></h3>
                    <p>{{__('cms.privacy_policy_2.question_3.details')}}</p>

                    <ul>
                        <li>{{__('cms.privacy_policy_2.question_3.list_1')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_3.list_2')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_3.list_3')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_3.list_4')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_3.list_5')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_3.list_6')}}</li>
                    </ul>

                    <p>{{__('cms.privacy_policy_2.question_3.details_1')}}</p>
                    <p>{{__('cms.privacy_policy_2.question_3.details_2')}}</p>

                    <h3><strong>{{__('cms.privacy_policy_2.question_4.heading')}}</strong></h3>
                    <p>{{__('cms.privacy_policy_2.question_4.details_1')}}</p>

                    <p>{{__('cms.privacy_policy_2.question_4.details_2')}}</p>
                    <p>{!!__('cms.privacy_policy_2.question_4.details_3')!!}</p>

                    <p>{{__('cms.privacy_policy_2.question_4.details_4')}}</p>

                    <h3><strong>{{__('cms.privacy_policy_2.question_5.heading')}}</strong></h3>


                    <p>{{__('cms.privacy_policy_2.question_5.details_1')}}</p>

                    <p><strong>{{__('cms.privacy_policy_2.question_5.point_1')}}</strong></p>

                    <p>{{__('cms.privacy_policy_2.question_5.point_1_details')}}</p>

                    <ul>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_1')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_2')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_3')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_4')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_5')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_6')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_7')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_8')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_9')}}</li>
                        <li>{{__('cms.privacy_policy_2.question_5.point_1_list_10')}}</li>
                    </ul>
                    <p>{!!__('cms.privacy_policy_2.question_5.point_1_details_1')!!}</p>

                    <p><strong>{{__('cms.privacy_policy_2.question_5.point_2')}}</strong></p>
                    <p>{{__('cms.privacy_policy_2.question_5.point_2_details_1')}} <a href="https://ico.org.uk" style="text-decoration:none!important;color:blue!important;">www.ico.org.uk</a>
                    </p>

                    <p><strong>{{__('cms.privacy_policy_2.question_5.point_3')}}</strong></p>
                    <p>{{__('cms.privacy_policy_2.question_5.point_3_details_1')}}</p>
                    <p>{{__('cms.privacy_policy_2.question_5.point_3_details_2')}}
                    </p>

                    {{--<p>{{__('cms.privacy.sjpanel.modification.policy_heading')}}</p>
                    <p>{{__('cms.privacy.sjpanel.modification.policy_details')}}
                    </p>

                    <p>{{__('cms.privacy.sjpanel.security.heading')}}</p>
                    <p>{{__('cms.privacy.sjpanel.security.details')}}
                    </p>

                    <p>{{__('cms.privacy.sjpanel.link.heading')}}</p>
                    <p>{{__('cms.privacy.sjpanel.link.details')}}
                    </p>

                    <p>{{__('cms.privacy.sjpanel.sign.heading')}}</p>
                    <p>{{__('cms.privacy.sjpanel.sign.details')}}
                    </p>

                    <p>{{__('cms.privacy.sjpanel.aggrement.heading')}}</p>
                    <p>{{__('cms.privacy.sjpanel.aggrement.details')}}
                    </p>--}}
                    <p>
                        {{__('cms.privacy.sjpanel.contact.heading')}}</p>
                    <p>
                        {!!__('cms.privacy.sjpanel.contact.details')!!}
                    </p>
                    <p>{!!__('cms.privacy.sjpanel.contact.details_1')!!}
                       
                    </p>
                </section>
            </div>
        </div>
    </div>
    <div class="container">
    @include('frontend.includes.blog_footer')
    </div>
</div>

@endsection

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
    </style>
@endpush
