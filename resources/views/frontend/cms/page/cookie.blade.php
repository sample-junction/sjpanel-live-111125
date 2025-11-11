@extends('frontend.layouts.app_blog')
@section('link_url','pages/cookies')
@section('meta_title','Cookie Policy - SJ Panel')
@section('title','Cookie Policy - SJ Panel')
@section('meta_description','Our Cookie Policy outlines how we use cookies on our website to enhance your browsing experience. Read on to learn more about our policies and practices.')
@section('content')
<div class="container pb-3 mt-5 body_content">
    <div class="row mt-5">
        <div class="col-lg-12">
           <div class="container">
           <div class="wrapper wrapper-content animated fadeInRight">

            <!-- ########################### SECTION START ########################### -->
            <section  class="container features" id="features">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h1>{{__('cms.cookie.heading')}}</h1>
                    </div>
                </div>
                <p>{{__('cms.cookies_2.last_updated')}} 11-07-2025</p>
                <p>
                    {{__('cms.cookies_2.at')}} <a href="{{route('frontend.index')}}" style="text-decoration:none!important;color:blue!important;">www.sjpanel.com</a> (<b>{{__('cms.cookies_2.we_us_our')}}</b>){{__('cms.cookies_2.details_1')}}
                </p>
                <p>
                    {!! __('cms.cookies_2.details_2') !!}
                </p>
                <p>
                    {{__('cms.cookies_2.details_6')}}<a href="{{route('frontend.cms.privacy')}}" target="_blank" style="text-decoration:none!important;color:blue!important;"> {{__('cms.cookies_2.points_5.table_row_6')}}</a>.
                    {{__('cms.cookies_2.details_4')}}
                </p>
                <p>
                    {{__('cms.cookies_2.details_5')}}
                </p>
                <h3><strong>1.	{{__('cms.cookies_2.points_1.heading')}}</strong></h3>
                <p>
                    {{__('cms.cookies_2.points_1.details')}}
                </p>

                <p>
                    {!! __('cms.cookies_2.points_1.point') !!}
                </p>
                <ol>
                    <li>
                        {{__('cms.cookies_2.points_1.points_list_1')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_1.points_list_2')}}
                    </li>
                </ol>

                <p>
                    {!! __('cms.cookies_2.points_1.point_2') !!}
                </p>

                <p>
                    {!! __('cms.cookies_2.points_1.point_3') !!}
                </p>

                <h3><strong>2.	{{__('cms.cookies_2.points_2.heading')}}</strong></h3>

                <p>
                    {{__('cms.cookies_2.points_2.details')}}
                </p>
                <ol>
                    <li>
                        {{__('cms.cookies_2.points_2.list_1')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.list_2')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.list_3')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.list_4')}}
                    </li>
                </ol>
                <p>
                    {{__('cms.cookies_2.points_2.details_2')}}
                </p>
                <p>
                    {!! __('cms.cookies_2.points_2.point') !!}
                </p>
                <p>
                    {{__('cms.cookies_2.points_2.points_details')}}
                </p>
                <ul>
                    <li>
                        {{__('cms.cookies_2.points_2.point_list_1')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.point_list_2')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.point_list_3')}}
                    </li>
                    <!-- <li>
                        {{__('cms.cookies_2.points_2.point_list_4')}}
                    </li> -->
                </ul>

                <p>
                    {{__('cms.cookies_2.points_2.points_detail_2')}}
                </p>

                <p>
                    {!! __('cms.cookies_2.points_2.points_2') !!}
                </p>
                <p>
                    {{__('cms.cookies_2.points_2.points_2_details')}}
                </p>

                <ul>
                    <li>
                        {{__('cms.cookies_2.points_2.points_2_list_1')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_2_list_2')}}
                    </li>
                    <!-- <li>
                        {{__('cms.cookies_2.points_2.points_2_list_2')}}
                    </li> -->
                    <li>
                        {{__('cms.cookies_2.points_2.points_2_list_3')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_2_list_4')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_2_list_5')}}
                    </li>
                </ul>

                <p>
                    {{__('cms.cookies_2.points_2.points_2_details_2')}}
                </p>

                <p>
                    {!! __('cms.cookies_2.points_2.points_3') !!}
                </p>

                <p>
                    {{__('cms.cookies_2.points_2.points_3_details')}}
                </p>

                <ul>
                    <li>
                        {{__('cms.cookies_2.points_2.points_3_list_1')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_3_list_2')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_3_list_3')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_3_list_4')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_3_list_5')}}
                    </li>
                </ul>

                <p>
                    {{__('cms.cookies_2.points_2.points_3_details_2')}}
                </p>

                <p>
                    {!! __('cms.cookies_2.points_2.points_4') !!}
                </p>

                <p>
                    {{__('cms.cookies_2.points_2.points_4_details')}}
                </p>

                <ul>
                    <li>
                        {{__('cms.cookies_2.points_2.points_4_list_1')}}
                    </li>
                    <li>
                        {{__('cms.cookies_2.points_2.points_4_list_2')}}
                    </li>
                </ul>

                <h3><strong>3.	{{__('cms.cookies_2.points_3.heading')}}</strong></h3>

                <p>
                    {{__('cms.cookies_2.points_3.details_1')}}
                </p>

                <p>
                    {{__('cms.cookies_2.points_3.details_2')}}
                </p>

                <h3><strong>4.	{{__('cms.cookies_2.points_4.heading')}}</strong></h3>

                <p>
                    {{__('cms.cookies_2.points_4.details_1')}}
                </p>

                <p>
                    <b>{{__('cms.cookies_2.points_4.point')}}</b>
                    {{__('cms.cookies_2.points_4.point_details')}}
                </p>

                <ul>
                    <li>
                        <a href="https://support.microsoft.com/en-us/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" style="text-decoration:none!important;color:blue!important;">
                            {{__('cms.cookies_2.points_4.point_list_1')}}
                        </a>
                    </li>
                    <li>
                        <a href="https://support.mozilla.org/en-US/kb/enable-and-disable-cookies-website-preferences" target="_blank" style="text-decoration:none!important;color:blue!important;">{{__('cms.cookies_2.points_4.point_list_2')}}</a>
                    </li>
                    <li>
                        <a href="https://support.google.com/chrome/answer/95647?hl=en" target="_blank" style="text-decoration:none!important;color:blue!important;">{{__('cms.cookies_2.points_4.point_list_3')}}</a>
                    </li>
                    <!-- <li>
                        {{--<a href="https://support.apple.com/kb/ph21411?locale=en_US" target="_blank" style="text-decoration:none!important;color:blue!important;">{{__('cms.cookies_2.points_4.point_list_4')}}</a>--}}
                    </li> -->
                </ul>

                <p>
                    <b>{{__('cms.cookies_2.points_4.point_2')}}</b>
                    {{__('cms.cookies_2.points_4.point_2_details_1')}}<a href="https://www.aboutcookies.com" target="_blank" style="text-decoration:none!important;color:blue!important;"> www.aboutcookies.com</a>.
                </p>

                <h3><strong>5.	{{__('cms.cookies_2.points_5.heading')}}</strong></h3>
                <div class="container table-content">
                <div class="table-item-wrapper">
                    <div class="table-wrapper">
                        <table class="table" style="table-layout: fixed;">
                            <thead>
                            <tr>
                                <th>{{__('cms.cookies_2.points_5.table_heading_1')}}</th>
                                <th></th>
                                <th>{{__('cms.cookies_2.points_5.table_heading_2')}}</th>
                                <th>{{__('cms.cookies_2.points_5.table_heading_3')}}</th>
                                <th></th>
                                <th class="td_type" style="margin-left:20px!important;">{{__('cms.cookies_2.points_5.table_heading_4')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    _ga
                                </td>
                                <td>
                                    {{__('cms.cookies_2.points_5.table_row_1')}}
                                </td>
                                <td>
                                    {{__('cms.cookies_2.points_5.table_row_7')}} <a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage" style="text-decoration:none!important;color:blue!important;"> {{__('cms.cookies_2.points_5.table_row_5')}}</a>
                                </td>
                                <td>
                                    {{__('cms.cookies_2.points_5.table_row_3')}}
                                </td>
                                <td></td>
                                <td>
                                    {{__('cms.cookies_2.points_5.table_row_4')}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                <h3><strong>6.	{{__('cms.cookies_2.points_6.heading')}}</strong></h3>
                <p>
                    {{__('cms.cookies_2.points_6.contact_email')}} support@sjpanel.com.
                </p>
                <p>
                    {{__('cms.cookies_2.points_6.privacy_email')}} privacy@sjpanel.com
                </p>
            </section>
            </div>
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

        @media only screen and (max-width: 600px) {
        .mobile_p_2{
            margin-left: -20px!important;           
        }
        .mobile_p_1{
            margin-right: 0px!important;
            margin-left: -10px!important;
        }
        table {
            font-size:9px!important;
            /* border:1px solid black; */
            /* min-width:100%; */
        }
        .hamBImg{
            margin-left:10px!important;
        }
        
        
     }
        
    </style>
@endpush
