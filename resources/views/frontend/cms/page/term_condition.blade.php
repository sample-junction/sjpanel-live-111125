@extends('frontend.layouts.app_blog')
@section('link_url','pages/terms&condition')
@section('meta_title','Terms and Conditions - SJ Panel')
@section('title','Terms and Conditions - SJ Panel')
@section('meta_description','Our terms and conditions help you protect your business and establish clear guidelines for your customers.')
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
                            <h1>{{__('cms.reward_policy.details_terms_condition_title')}}</h1><span style="float: right;margin-top: 10px;">{{__('cms.reward_policy.details_terms_condition_title_update')}} 11-07-2025</span>
                            {{--<h1>{{__('cms.term&condition.heading')}}</h1> --}}
                        </div>
                    </div>
                    <p>
                        {{__('cms.term&condition.details')}}
                    </p>
                    <p>
                        {{__('cms.term&condition.details_1')}}
                    </p>

                    <p>{{__('cms.term&condition.details_2')}}
                    </p>
                    <p>
                        {{__('cms.term&condition.details_3')}}
                    </p>

                    <h3><strong>{{__('cms.term&condition.contract.heading')}}
                        </strong>
                    </h3>

                    <p> {{__('cms.term&condition.contract.details_1')}}
                    </p>

                    <p> {{__('cms.term&condition.contract.details_2')}}
                    </p>
                    <p> {{__('cms.term&condition.contract.details_3')}}
                    </p>

                    <p> {{__('cms.term&condition.contract.details_4')}}
                    </p>

                    <p> {{__('cms.term&condition.contract.details_5')}}
                    </p>

                    <h3>
                        <strong>{{__('cms.term&condition.data_info.heading')}}</strong>
                    </h3>
                    <p>{{__('cms.term&condition.data_info.details')}}
                    </p>

                    <p>{{__('cms.term&condition.data_info.auth_heading')}}
                    </p>

                    <p>{{__('cms.term&condition.data_info.auth_heading_point_1')}}
                    </p>
                    <p>{{__('cms.term&condition.data_info.auth_heading_point_2')}}
                    </p>

                    <p>{{__('cms.term&condition.data_info.auth_heading_point_3')}}
                    </p>
                    <p>{{__('cms.term&condition.data_info.auth_heading_point_4')}}
                    </p>

                    <p>{{__('cms.term&condition.data_info.auth_heading_point_5')}}
                    </p>

                    <h3>
                        <strong>{{__('cms.term&condition.user_eligibility.heading')}}</strong>
                    </h3>

                    <p>{{__('cms.term&condition.user_eligibility.details')}}
                    </p>

                    <h3>
                        <strong>{{__('cms.term&condition.obligation.heading')}}</strong>
                    </h3>
                    <p>{{__('cms.term&condition.obligation.detail')}}
                    </p>

                    <p>{{__('cms.term&condition.obligation.detail_point_1')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_2')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_3')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_4')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_5')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_6')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_7')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_8')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_9')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_10')}}
                    </p>
                    <p>
                        {{__('cms.term&condition.obligation.detail_point_11')}}

                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_12')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_13')}}
                    </p>
                    <p>{{__('cms.term&condition.obligation.detail_point_14')}}
                    </p>

                    <h3> <strong>5.{{__('cms.term&condition.termination.heading')}}</strong>
                    </h3>
                    <p>{{__('cms.term&condition.termination.details')}}
                    </p>
                    <h3><strong>{{__('cms.term&condition.limitation.heading')}}</strong>
                    </h3>

                    <p>{{__('cms.term&condition.limitation.details')}}
                    </p>

                    <h3><strong>{{__('cms.term&condition.intellectual.heading')}}</strong>
                    </h3>

                    <p>{{__('cms.term&condition.intellectual.details')}}
                    </p>

                    <h3><strong>{{__('cms.term&condition.disclaimer.heading')}}</strong>
                    </h3>

                    <p>{{__('cms.term&condition.disclaimer.details')}}
                    </p>

                    <h3>{{__('cms.term&condition.data_protection.heading')}}
                    </h3>

                    <p>{{__('cms.term&condition.data_protection.details')}}
                    </p>

                    <h3><strong>{{__('cms.term&condition.changes_to_term.heading')}}</strong>
                    </h3>

                    <p>{{__('cms.term&condition.changes_to_term.details')}}
                    </p>

                    <h3><strong>{{__('cms.term&condition.jurisdiction_law.heading')}}</strong>
                    </h3>
                    <p>{{__('cms.term&condition.jurisdiction_law.details')}}
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
