@extends('inpanel.layouts.device')
@section('dashboard_select')
@push('after-styles')

<link href="{{asset('css2/dashboard_style.css')}}" rel="stylesheet">
<link href="{{asset('vendor/css/plugins/c3/c3.min.css')}}" rel="stylesheet">
<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />


<style type="text/css">
    .z-low{
        z-index: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .z-high{
        z-index: 1052;
    }
    .t-high{
        z-index: 1054;
    }
    .shepherd-bottom-right {
        position: fixed !important;
        bottom: 20px;
        right: 20px;
        max-width: 320px;
        /* optional */
        z-index: 9999;
    }

    .cst-overlay {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050;
        @if(count($filled_pro_survey)==8) display:none;

        @endif
        /*     */
        background: #0000007a;
        width: 100%;
        height: 100%;
    }

    .cst-overlay-survey {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: #0000007a;
        width: 100%;
        height: 100%;
    }

    .cst-overlay-refer {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: #0000007a;
        width: 100%;
        height: 100%;
    }

    #popup-sj-detail {
        position: fixed;
        top: 50%;
        left: 53%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        @if(count($filled_pro_survey)==8) display:none;

        @endif
        /*     */
        background:white;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
        width: 700px;
    }

    #popup-sj-detail-survey {
        position: fixed;
        top: 50%;
        left: 53%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: white;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
        width: 700px;
    }

    #popup-sj-detail-refer {
        position: fixed;
        top: 50%;
        left: 53%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: white;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
        width: 700px;
    }

    #popup-reward-detail {
        position: fixed;
        top: 50%;
        left: 53%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: white;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
        width: 90%;
        max-width: 700px;
        padding: 29px;
        text-align: center;
    }

    .remove-pop-up {
        transform: translateX(20%);
    }

    .remove-pop-up-survey {
        transform: translateX(20%);
    }

    .remove-reward-popup {
        transform: translateX(20%);
    }

    .remove-pop-up-refer {
        transform: translateX(20%);
    }

    .pop-img-main {
        height: 270px;
    }

    #line_spc {
        border-left: 1px solid #ECECEC;
        display: inline-block;
        height: 270px !important;
        /* padding-left: 28px !important; */
        margin-left: 18px !important;
        position: absolute;
    }

    #H_r {
        display: none;
    }

    #tippy-1 {
        transform: translate3d(75%, 351px, 0px) !important;
    }

    #tippy-2 {
        transform: translate3d(75%, 229px, 0px) !important;
    }

    #tippy-3 {
        transform: translate3d(75%, 229px, 0px) !important;
    }

    #tippy-5 {
        transform: translate3d(75%, 163px, 0px) !important;
    }

    @media(min-width: 1300px) and (max-width:1400px) {
        #tippy-1 {
            transform: translate3d(59%, 351px, 0px) !important;
        }

        #tippy-2 {
            transform: translate3d(59%, 229px, 0px) !important;
        }

        #tippy-3 {
            transform: translate3d(59%, 229px, 0px) !important;
        }

        #tippy-5 {
            transform: translate3d(59%, 163px, 0px) !important;
        }
    }

    @media(min-width: 220px) and (max-width:768px) {
        #tippy-1 {
            transform: translate3d(3%, 240px, 0px) !important;
        }

        #tippy-2 {
            transform: translate3d(3%, 121px, 0px) !important;
        }

        #tippy-3 {
            transform: translate3d(3%, 121px, 0px) !important;
        }

        #tippy-5 {
            transform: translate3d(3%, 250px, 0px) !important;
        }

        #popup-reward-detail {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
            width: 300px;
            padding: 29px;
            text-align: center;
        }

        #popup-reward-detail .weekday_mobile {
            margin-bottom: 10px;
        }

        .weekday-select-form {
            margin-bottom: 1rem;
        }

        .weekdaysubmitbtn {
            width: 100%;
        }
    }

    @media(min-width: 768px) and (max-width:990px) {
        #tippy-1 {
            transform: translate3d(116%, 240px, 0px) !important;
            ;
        }

        #tippy-2 {
            transform: translate3d(116%, 111px, 0px) !important;
        }

        #tippy-3 {
            transform: translate3d(116%, 139px, 0px) !important;
        }

        #tippy-5 {
            transform: translate3d(116%, 264px, 0px) !important;
        }
    }

    @media(min-width: 220px) and (max-width:990px) {
        #H_r {
            display: block !important;
            margin-top: 0px !important;
        }

        .remove-pop-up {
            transform: translateX(25%);
        }

        .remove-pop-up-survey {
            transform: translateX(25%);
        }

        .remove-pop-up-refer {
            transform: translateX(25%);
        }

        .pop-img-main {
            height: 210px;
        }

        #popup-sj-detail {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            @if(count($filled_pro_survey)==8) display:none;

            @endif
            /*     */
            background:white;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
            width: 67%;
        }

        #popup-sj-detail-survey {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
            width: 67%;
        }

        #popup-sj-detail-refer {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
            width: 67%;
        }

    }

    .cst-full-sr {
        border: 1px solid #ECECEC;
    }

    .cst-full-sr:hover {
        border: 1px solid #794dc8 !important;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    #hot_survey_options {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
        font-size: 16px;
        height: 42px;
        margin-right: 2%;
    }

    #hot_survey_options option {
        background-color: #fff;
        color: #333;
        padding: 5px 10px;
    }



    #hot_survey_options option:checked {
        background-color: #007bff;
        color: #fff;
    }

    select {
        margin-right: 5px;
    }

    select:focus {
        outline: none;
    }

    .custom-tooltip {
        --bs-tooltip-bg: #0d6efd;
        --bs-tooltip-color: white;
        --bs-tooltip-opacity: 1;
    }

    .pop-up-main-img {
        height: 315px;
    }

    .pop-link-btn {
        width: 100%;
        display: block;
        padding-top: 10px;
        padding-bottom: 10px;
        text-decoration: none;
    }

    #searchBar:focus,
    #searchBar:focus-visible {
        outline: none;
        border-color: #006bde;
        box-shadow: 0 0 0 4px rgba(0, 107, 222, 0.18);
    }
</style>

@endpush

@section('dashboard_select','cst-active')
@section('content')




<!-- New -->


<div class="row text-center d-sm-none ">

    <div class="col-12 mt-4">


        <div class="position-relative" style="width: 100%">
            <img src="img/search-icon.png" alt="img" width="10px" id="searchIconM" class="img-fluid position-absolute" style="left: 20px; top: calc(50% - 10px/2 - 1px); opacity: 0.7">
            <input type="text" name="search" value="" placeholder="       {{__('inpanel.invite.myreferrals.index.search')}}" id="searchBarM" class="p-2 rounded" style="width:100%; border: 1px solid #F4F4F4;">
        </div>


    </div>

</div>

<input type="hidden" id="user_id" name="user_id" value="{{$user->id}}" />
<input type="hidden" id="requestid" name="rid" value="{{$user->uuid}}" />
<input type="hidden" id="email" name="email" value="{{$user->email}}" />
<input type="hidden" id="eventid" name="eid" value="{{str_replace('.','-',$user->ip_registered_with)}}" />
<input type="hidden" id="cc" value="{{$user->country_code}}" />
<input type="hidden" id="home_country" value="{{$user->home_country}}" />
<input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}">


<!-- <div class="alert alert-warning logged-in-as mb-0">
        You are currently logged in as {{ Auth::user()->name }}. <a href="https://test17.sjpanel.com/admin/auth/user/{{$user->id}}/login-as">Re-Login as {{ Auth::user()->name }}</a>.
</div> -->
<div class="p-3 rounded d-none">

    <div class="row rounded mt-1 mt-lg-1 p-3 bg-white" style="border-radius: 10px;" id="top_user_info">

        <div class="col-12 col-md-4 text-center text-md-start">

            {{--<img @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif class="img-fluid me-3 mb-1" alt="img" style="height:45px;width:45px;object-fit:cover;scale:1.3; border-radius:32px!important;"> --}}
            <!--<img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user" class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />-->

             <img @if(Auth::user()->thumbnail_image_path) src="{{config('settings.centralize_server_image').(Auth::user()->thumbnail_image_path)}}" @else src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user" class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />


            <span class="lead d-none d-md-inline-block">{{__('inpanel.dashboard.user.name')}}</span> <span class="lead fw-bold d-none d-md-inline-block" style="text-transform: capitalize;" id="user_first_name_tab">{{ Auth::user()->first_name }} !</span>

            <p class="lead d-sm-none mt-2 mb-1">{{__('inpanel.dashboard.user.name')}} <span class="fw-bold">{{ Auth::user()->first_name }}!</span> </p>

        </div>


        <div class="col-12 col-md-8 text-center text-md-end mt-1">

            <span class="d-none d-md-inline-block"><small>{{__('inpanel.dashboard.user.panId')}} </small><span class="fw-bold">{{ Auth::user()->panellist_id }}</span> <span class="ms-2 me-2">|</span> <span class="fw-bold">{{ Auth::user()->country}}</span> <span class="ms-2 me-2">|</span></span>

            <p class="d-sm-none m-1">{{__('inpanel.dashboard.user.panId')}}. <span class="fw-bold">{{ Auth::user()->panellist_id }} | {{ Auth::user()->country}}</span></p>


            <span class="text-primary"> <a href="@if(Route::has('inpanel.profiler.show')){{ route('inpanel.profiler.show') }}@endif">{{__('inpanel.dashboard.user.pro_completed')}} @if(isset($profilePercent)){{$profilePercent}}@else{{0}}@endif%</a> </span>

        </div>

    </div>

</div>








<div class="row mt-3 mb-2">


    <div class="col">

        <p class="h4 ms-2" style="font-weight: 600;">{{__('inpanel.dashboard.heading')}}</p>

    </div>


</div>

<div class="row p-lg-3">
<div class="shadow p-3 rounded bg-white" style="border-radius: 10px;padding-top: 25px !important;">

    <div class="row">
        @php
        $spanishArr=['5da78cda894794269f063c23'=>'Mi perfil','5da78cda894794269f063c25'=>'Automotor','5da78cda894794269f063c26'=>'Empleo','5da78cda894794269f063c27'=>'Viajes / Ocio','5da78cda894794269f063c29'=>'Comida saludable','5da78cda894794269f063c2a'=>'Tecnología','5da78cda894794269f063c24'=>'Familia','5da78cda894794269f063c28'=>'Entretenimiento'];
        if($detailed_profile_survey){
        $detailed_profile_count = 1;
        $detailedProfileComplete = 0;
        }else{
        $detailed_profile_count = 0;
        $detailedProfileComplete = 1;
        }
        $total_surveys = $allUserSurveys->count()+1;
        $active_surveys = $active_user_count;
        $completed_surveys = $completedSurveys->count()+$detailedProfileComplete;
        $attemptedSurvey = $user_count;
        $expiredSurvey = $userExpireSurveys->count();
        @endphp

        <div class="col-12 col-lg-4 pt-3 cst-border-first-sec" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__('inpanel.dashboard.tooltip_1')}}">

            <div class="row">


                <div class="col">

                    <span class="h3 ps-3 pe-3 pt-2 pb-2" style="background: linear-gradient(60deg,#ab47bc,#8e24aa); color: #FFF; font-weight: 700; border-radius: 15px;padding-left: 22px !important;padding-right: 22px !important;margin-left: 5px;">
                        @if( isset($profile_sections_all))
                        {{count($profile_sections_all)+count($surveys)+count($hsurveys)+$expiredSurvey}}{{--$unsuccessful_count--}}

                        @else{{'0'}}@endif
                    </span>



                </div>
                @php
                $live_survey_points = 0;
                $approved_survey_points = 0;
                $assigned_points = 0;
                $approved_incentive = 0;
                $approved_count = 0;
                $hsurvey_points = 0;
                if(!empty($surveys)){
                foreach($surveys as $live_survey){
                $live_survey_points += $live_survey->points;
                }
                }
                if(!empty($profile_sections_all)){
                foreach($profile_sections_all as $profile_survey){
                $assigned_points += $profile_survey->points;
                }
                }
                if(count($hsurveys)){
                foreach($hsurveys as $survey_with_approved_incentive){
                $hsurvey_points += $survey_with_approved_incentive->points;
                if($survey_with_approved_incentive->status === 50){
                $approved_incentive += $survey_with_approved_incentive->points;
                $approved_count++;
                }
                }
                }
                @endphp
                @php
                $points = (!empty($global_user_points->user_points))?$global_user_points->user_points['completed']:0;
                $completed_points = 0;
                $avail_survey_profile_points = 0;
                $expired_points = 0;
                if(count($completedProfiles)){
                foreach($completedProfiles as $pro_sur_taken){
                $completed_points += $pro_sur_taken->points;
                }
                }
                if(count($profile_sections)){
                foreach($profile_sections as $pro_sur_avail){
                $avail_survey_profile_points += $pro_sur_avail->points;
                }
                }
                if(count($userExpireSurveys)){
                foreach($userExpireSurveys as $expired){
                $expired_points += $expired->points;
                }
                }

                @endphp
                <div class="col text-end">

                    <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">
                        @php
                        /* Parshant Sharma [20-08-2024] STARTS */

                        //$metricConversion = round(1/$countryPoints, 4);
                        $metricConversion = 1/$countryPoints;
                        //dd($metricConversion);
                        @endphp

                        @if( isset($user_awaited_points))
                        @php
                        $total_awaited_points = $assigned_points + $live_survey_points + $hsurvey_points + $expired_points;
                        @endphp
                        @if($total_awaited_points * $metricConversion < 1)
                            @php
                            $convertedAmount=round($total_awaited_points * $metricConversion * 100); // Round to nearest integer
                            $currency=($convertedAmount> 1)
                            ? $currencies['currency_denom_plural']
                            : $currencies['currency_denom_singular'];
                            @endphp
                            {{ $convertedAmount }} {{ __($currency) }}
                            @else
                            {{ @$currencies['currency_logo'] }}{{ number_format($total_awaited_points * $metricConversion, 2) }}
                            @endif
                            @else
                            {{ '0' }}
                            @endif

                            {{ __('inpanel.dashboard.user.assiagn') }}

                            @php
                            /* Parshant Sharma [20-08-2024] ENDS */
                            @endphp


                    </p>
                    <!--@if( isset($user_awaited_points)) 
                        {{--$user_awaited_points/1000 + $detailed_profile_survey->total_points/1000 + $live_survey_points*config('app.points.metric.conversion')--}}
                        @php
                        $total_awaited_points = $assigned_points + $live_survey_points + $hsurvey_points + $expired_points;	
                        @endphp
                        @if($total_awaited_points*config('app.points.metric.conversion') < 1)
                        {{$total_awaited_points*config('app.points.metric.conversion')*100}} {{__('inpanel.dashboard.cents')}} 
                        @else
                        ${{$total_awaited_points*config('app.points.metric.conversion')}} 
                        @endif						
                    @else
                        {{'0'}}
                    @endif {{__('inpanel.dashboard.user.assiagn')}}</p>-->

                    <!-- <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">$@if( isset($availableProfilesCount)) {{$availableProfilesCount / 10}}@else{{'0'}}@endif {{__('inpanel.dashboard.user.await')}}</p> -->

                </div>
                <span>
                    <p class="pt-4 ms-1" style="font-size: 20px; font-weight: 300;">{{__('inpanel.dashboard.assigned')}}</p>
                </span>

            </div>
            <hr id="H_r">
        </div>


        <div class="col-12 col-lg-4 pt-4 pt-lg-3 cst-border-first-sec" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__('inpanel.dashboard.tooltip_3')}}">

            <div class="row">


                <div class="col">

                    <span class="h3 ps-3 pe-3 pt-2 pb-2" style="background: linear-gradient(195deg, rgb(73, 163, 241), rgb(26, 115, 232)); color: rgb(255, 255, 255); font-weight: 700; border-radius: 15px;padding-left: 22px !important;padding-right: 22px !important;margin-left: 5px;">
                        @if( isset($pendingProfilecount_v1)){{$pendingProfilecount_v1 + count($surveys)}}{{-- -$unsuccessful_count-$pending_count--}}
                        @else{{0}}@endif</span>

                </div>

                <div class="col text-end">

                    <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">

                        @php
                        /* Parshant Sharma [20-08-2024] STARTS */
                        $total_pending_points = $avail_survey_profile_points + $live_survey_points;
                        //dd($total_pending_points);
                        @endphp

                        @if($total_pending_points * $metricConversion < 1)
                            @php
                            $convertedAmount=round($total_pending_points * $metricConversion * 100); // Round to nearest integer
                            $currency=($convertedAmount> 1)
                            ? $currencies['currency_denom_plural']
                            : $currencies['currency_denom_singular'];
                            @endphp
                            {{ $convertedAmount }} {{ __($currency) }}
                            @else
                            {{ @$currencies['currency_logo'] }}{{ number_format($total_pending_points * $metricConversion, 2) }}
                            @endif

                            {{ __('inpanel.dashboard.user.await') }}

                            @php
                            /* Parshant Sharma [20-08-2024] ENDS */
                            @endphp

                    </p>
                    <!--{{--$@if( isset($user_awaited_points)) {{$user_awaited_points + $detailed_profile_survey->total_points/1000 + --}}
                    
                    @php 
                        $total_pending_points = $avail_survey_profile_points + $live_survey_points;
                    @endphp
                        @if($total_pending_points*config('app.points.metric.conversion') < 1)
                        {{$total_pending_points*config('app.points.metric.conversion')*100}} {{__('inpanel.dashboard.cents')}} 
                        @else
                        ${{$total_pending_points*config('app.points.metric.conversion')}} 
                        @endif
                        {{--@else{{'0'}}
                        @endif --}}{{__('inpanel.dashboard.user.await')}}</p>-->

                </div>

                <span>
                    <p class="pt-4 ms-1" style="font-size: 20px; font-weight: 300;">{{__('inpanel.dashboard.available')}}</p>
                </span>

            </div>
            <hr id="H_r">

        </div>







        <div class="col-12 col-lg-4 pt-4 pt-lg-3" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__('inpanel.dashboard.tooltip_5')}}">

            <div class="row">


                <div class="col">

                    <span class="h3 ps-3 pe-3 pt-2 pb-2" style="background: linear-gradient(60deg,#26c6da,#00acc1); color: #fff; font-weight: 700; border-radius: 15px;padding-left: 22px !important;padding-right: 22px !important;margin-left: 5px;">
                        {{$unsuccessful_count - $pending_count - $approved_count}}
                    </span>



                </div>

                <div class="col text-end">

                    <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">
                        <!--@php
                         
                    $un_count_amt = 0;
                    $pending_count_amt = 0;


                    if(isset($hsurveys)){

                        foreach($hsurveys as $survey){

                            if($survey['status'] != 1 || $survey['status'] != 50){
                                $un_count_amt += $survey['points'];
                            }

                            if($survey['status'] == 1){
                                $pending_count_amt += $survey['points'];
                            }

                        }
                        $tot_unsuccessful_points = $un_count_amt - $approved_incentive - $pending_count_amt;
                        if($tot_unsuccessful_points*config('app.points.metric.conversion') < 1){
                            echo ($tot_unsuccessful_points*config('app.points.metric.conversion')*100)." ".__('inpanel.dashboard.cents');
                        }else{
                            echo '$'.$tot_unsuccessful_points*config('app.points.metric.conversion');
                        }

                    }else{

                        echo $un_count_amt;

                    }

                    @endphp
                     {{__('inpanel.dashboard.user.miss_pt')}}</p>-->

                        <!-- Parshant Sharma [20-08-2024] Starts -->

                        @php
                        $un_count_amt = 0;
                        $pending_count_amt = 0;

                        if (isset($hsurveys)) {

                        foreach ($hsurveys as $survey) {
                        if ($survey['status'] != 1 && $survey['status'] != 50) {
                        $un_count_amt += $survey['points'];
                        }

                        if ($survey['status'] == 1) {
                        $pending_count_amt += $survey['points'];
                        }
                        }

                        $tot_unsuccessful_points = $un_count_amt - $approved_incentive - $pending_count_amt;

                        if ($tot_unsuccessful_points * $metricConversion < 1) {
                            $convertedAmount=round($tot_unsuccessful_points * $metricConversion * 100);
                            $currency=($convertedAmount> 1)
                            ? $currencies['currency_denom_plural']
                            : $currencies['currency_denom_singular'];

                            echo $convertedAmount . ' ' . __($currency);
                            } else {
                            echo @$currencies['currency_logo'] . number_format($tot_unsuccessful_points * $metricConversion, 2);
                            }

                            } else {
                            echo $un_count_amt;
                            }
                            @endphp
                            {{__('inpanel.dashboard.user.miss_pt')}}
                    </p>
                    <!-- Parshant Sharma [20-08-2024] ENDS -->

                </div>

                <span>
                    <p class="pt-4 ms-1" style="font-size: 20px; font-weight: 300;">{{__('inpanel.dashboard.unsuccessful')}}</p>
                </span>

            </div>
            <hr id="H_r">




        </div>



    </div>



    <div class="row d-none d-lg-block">

        <div class="col">

            <hr>

        </div>

    </div>



    <div class="row pb-lg-2">


        <div class="col-12 col-lg-4 pt-4 pt-lg-3 cst-border-first-sec cst-border-upper" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__('inpanel.dashboard.tooltip_4')}}">

            <div class="row">


                <div class="col">

                    <span class="h3 ps-3 pe-3 pt-2 pb-2" style="background: linear-gradient(60deg,#ffa726,#fb8c00); color: #FFF; font-weight: 700; border-radius: 15px;padding-left: 22px !important;padding-right: 22px !important;margin-left: 5px;">
                        @php
                        echo $pending_count;
                        @endphp
                    </span>



                </div>

                <div class="col text-end">

                    <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">
                        <!--@php

                    if(isset($hsurveys)){

                       
                        if($pending_count_amt*config('app.points.metric.conversion') < 1){
                            echo ($pending_count_amt*config('app.points.metric.conversion')*100)." ".__('inpanel.dashboard.cents');
                        }else{
                            echo '$'.$pending_count_amt*config('app.points.metric.conversion');
                        }

                    }else{

                        echo $pending_count_amt;

                    }
                    @endphp
                     {{__('inpanel.dashboard.user.pending')}}</p>-->

                        <!-- Parshant Sharma [20-08-2024] Starts -->
                        @php
                        if(isset($hsurveys)){
                        if ($pending_count_amt * $metricConversion < 1) {
                            $convertedAmount=round($pending_count_amt * $metricConversion * 100); // Round to nearest integer
                            $currency=($convertedAmount> 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                            echo $convertedAmount . ' ' . __($currency);
                            } else {
                            echo @$currencies['currency_logo'] . number_format($pending_count_amt * $metricConversion, 2);
                            }
                            } else {
                            echo $pending_count_amt;
                            }
                            @endphp
                            {{__('inpanel.dashboard.user.pending')}}
                    </p>

                    <!-- Parshant Sharma [20-08-2024] Ends -->

                </div>

                <span>
                    <p class="pt-4 ms-1" style="font-size: 20px; font-weight: 300;">{{__('inpanel.dashboard.pending')}}</p>
                </span>

            </div>
            <hr id="H_r">


        </div>






        <div class="col-12 col-lg-4 pt-4 pt-lg-3 cst-border-first-sec" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__('inpanel.dashboard.tooltip_2')}}">


            <div class="row">


                <div class="col">

                    <span class="h3 ps-3 pe-3 pt-2 pb-2" style="background: linear-gradient(60deg,#66bb6a,#43a047); color: #fff; font-weight: 700; border-radius: 15px;padding-left: 22px !important;padding-right: 22px !important;margin-left: 5px;">
                        @if( isset($completedProfiles)){{count($completedProfiles) + $approved_count}}@else{{0}}@endif
                    </span>



                </div>

                <div class="col text-end">


                    <!--    {{-- <i class="fas fa-trophy"></i> --}}{{--__('inpanel.nav.sidebar_points', ['user_points' => $points])--}} 
                        <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">
                        {{-- $@if( isset($user_point)) {{$user_point/1000}}@else{{'0'}}@endif  --}}
                        @php 
                        $total_completed_points = $completed_points + $approved_incentive;
                        @endphp
                        @if($total_completed_points*config('app.points.metric.conversion') < 1)
                        {{$total_completed_points*config('app.points.metric.conversion')*100}} {{__('inpanel.dashboard.cents')}} 
                        @else
                        ${{$total_completed_points*config('app.points.metric.conversion')}} 
                        @endif
                        {{__('inpanel.dashboard.user.earn')}}</p>-->

                    <!-- Parshant Sharma [20-08-2024] Starts -->
                    <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">
                        @php
                        $total_completed_points = $completed_points + $approved_incentive;

                        if ($total_completed_points * $metricConversion < 1) {
                            $convertedAmount=round($total_completed_points * $metricConversion * 100); // Round to nearest integer
                            $currency=($convertedAmount> 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                            echo $convertedAmount . ' ' . __($currency);
                            } else {
                            echo @$currencies['currency_logo'] . number_format($total_completed_points * $metricConversion, 2);
                            }
                            @endphp
                            {{__('inpanel.dashboard.user.earn')}}</p>

                    <!-- Parshant Sharma [20-08-2024] Ends -->

                </div>

                <span>
                    <p class="pt-4 ms-1" style="font-size: 20px; font-weight: 300;">{{__('inpanel.dashboard.completed')}}</p>
                </span>
            </div>
            <hr id="H_r">


        </div>







        <div class="col-12 col-lg-4 pt-4 pt-lg-3" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__('inpanel.dashboard.tooltip_6')}}">


            <div class="row">


                <div class="col">

                    <span class="h3 ps-3 pe-3 pt-2 pb-2" style="background: linear-gradient(60deg,#ef5350,#e53935); color: #fff; font-weight: 700; border-radius: 15px;padding-left: 22px !important;padding-right: 22px !important;margin-left: 5px;">
                        @if( isset($allUserSurveys)){{$expiredSurvey}}@else{{0}}@endif</span>

                </div>

                <div class="col text-end">

                    <!-- <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">
                        
                            @if($expired_points*config('app.points.metric.conversion') < 1)
                            {{$expired_points*config('app.points.metric.conversion')*100}} {{__('inpanel.dashboard.cents')}} 
                            @else
                            ${{$expired_points*config('app.points.metric.conversion')}} 
                            @endif  
                        {{__('inpanel.dashboard.user.miss_pt')}}</p>
                        {{--@if( isset($user_missed_points)) {{$user_missed_points/1000}}@else{{'0'}}@endif--}} -->

                    <!-- Parshant Sharma [20-08-2024] Starts -->
                    <p style="transform: translate(-5px,-10px); font-weight: 600; font-size: 14px;margin-top: 5px;">

                        @if($expired_points * $metricConversion < 1)
                            @php
                            $convertedAmount=round($expired_points * $metricConversion * 100); // Round off to nearest integer
                            $currency=($convertedAmount> 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                            @endphp
                            {{ $convertedAmount }} {{ __($currency) }}
                            @else
                            {{ @$currencies['currency_logo'] }}{{ number_format($expired_points * $metricConversion, 2) }}
                            @endif
                            {{__('inpanel.dashboard.user.miss_pt')}}</p>
                    <!-- Parshant Sharma [20-08-2024] Ends -->

                </div>

                <span>
                    <p class="pt-4 ms-1" style="font-size: 20px; font-weight: 300;">{{__('inpanel.dashboard.expired_surveys')}}</p>
                </span>
            </div>


        </div>



    </div>



</div>
</div>












<div class="row mt-5 p-lg-3">
    <div class="col mt-1">

        <p class="h4 ms-2 mb-0" style="font-weight:600">{{__('inpanel.dashboard.user.hot_surveys')}}</p>

    </div>

    <div class="col text-end">
        <span style="font-weight:600;">{{__('inpanel.dashboard.user.filter_by')}}</span>
        <span>
            <select id="hot_survey_options">
                <option hidden disabled selected>{{__('inpanel.dashboard.user.select')}}</option>
                <option value="1">{{__('inpanel.dashboard.user.survey_opt_1')}}</option>
                <option value="2">{{__('inpanel.dashboard.user.survey_opt_2')}}</option>
                <option value="3">{{__('inpanel.dashboard.user.survey_opt_3')}}</option>
            </select>
        </span>
        <span style="margin-right: 10px;">&nbsp;<a id="clearFilter" style="display:none;" href="{{ route('inpanel.dashboard') }}">{{__('inpanel.dashboard.user.clear_filter')}}</a>&nbsp;</span>
        <a href="@if(Route::has('inpanel.survey.index')){{ route('inpanel.survey.index') }}@endif"> {{__('inpanel.dashboard.user.view_all')}}</a>

    </div>
</div>

<div class="row mt-1 p-lg-3">
    <div class="col cst-bg-hot-survey" style="border-radius: 10px;">
        <!-- @if(isset($allUserSurveys) || isset($detailed_profile_survey))
                            @php
                                if($detailed_profile_survey){
                                $detailed_profile_count = 1;
                                }else{
                                $detailed_profile_count = 0;
                                }
                                $total_surveys  = $userActiveSurveys->count()+$detailed_profile_count;
                            @endphp
                            {{__('inpanel.dashboard.user.available_surveys_notifications',
                                ['active_survey' => $total_surveys, 'notification' => '0'])
                            }}
                        @else
                            {{__('inpanel.dashboard.user.available_surveys_notifications',
                                ['active_survey' => "0", 'notification' => '0'])
                            }}
                        @endif -->

        <div class="row pt-lg-4 pb-lg-3 pe-lg-3 ps-lg-3" style="background: #EFEDFF !important;padding-top: 15px !important;padding-bottom: 30px !important;border-radius: 12px;" id="hot_Surveys_Section">
            @if(count($profile_sections) === 0 && count($user_assign_projects_info)===0)
            <div class="row text-center ms-2">
                <div class="col mt-3 text-center">
                    <small>{{__('inpanel.survey.index.sub_heading')}}</small>
                </div>
            </div>

            @else

            @php
            $all_hot_surveys = [];
            $i = 0;
            if(count($profile_sections) > 0){
            foreach($profile_sections as $pro){
            $all_hot_surveys[$i] = $pro;
            $i++;
            }
            }
            if(count($user_assign_projects_info) > 0){
            foreach($user_assign_projects_info as $us_assgn){
            $all_hot_surveys[$i] = $us_assgn;
            $i++;
            }
            }
            @endphp
            @if(count($all_hot_surveys)>0)
            @foreach($all_hot_surveys as $key=> $detailed_profile_survey)
            @php
            if($key < 12){
                if($key < count($profile_sections)){
                if($key % 3==0 && $key !=0){
                echo "<div class='row mt-2 mb-2 d-none d-lg-block' style='margin-bottom: -10px !important;'>" ;
                echo "<div class='col' style='margin-left:12px'>" ;
                echo "<hr style='scale:1.02; opacity:0.1'>" ;
                echo "</div>" ;

                echo "</div>" ;


                }
                @endphp
                <div class="col-12 col-lg-4 mt-3 ">

                <div class="border p-3 rounded bg-white cst-full-sr">


                    <div class="row mt-2">

                        <div class="col">

                            <p class="h4 mb-0" style="font-weight: 600; color:#005A9A">{{$detailed_profile_survey->points}} {{__('inpanel.survey.index.column_2')}}</p>

                        </div>


                        <div class="col text-end">

                            <!--<p class="fw-bold lead">
                                {{--${{$detailed_profile_survey->points*config('app.points.metric.conversion')}} --}}
                                @if($detailed_profile_survey->points*config('app.points.metric.conversion') < 1)
                                    {{$detailed_profile_survey->points*config('app.points.metric.conversion')*100}} {{__('inpanel.dashboard.cents')}} 
                                @else
                                    ${{$detailed_profile_survey->points*config('app.points.metric.conversion')}} 
                                @endif    
                            </p>-->

                            <!-- Parshant Sharma [21-08-2024] Starts -->
                            <p class="fw-bold lead">
                                {{--${{$detailed_profile_survey->points*config('app.points.metric.conversion')}} --}}

                                @if($detailed_profile_survey->points*$metricConversion < 1)
                                    <!-- code updated by Vikas(Start) -->
                                    @php
                                    $centsValue = round($detailed_profile_survey->points * $metricConversion * 100);
                                    $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                    @endphp
                                    {{ $centsValue }} {{ __($currency) }}
                                    <!-- end -->
                                    @else
                                    {{@$currencies['currency_logo']}}{{number_format($detailed_profile_survey->points*$metricConversion,2)}}
                                    @endif
                            </p>
                            <!-- Parshant Sharma [21-08-2024] Ends -->

                        </div>

                    </div>



                    <div class="row" style="transform: translateY(-5px);">

                        <div class="col">

                            <p class="lead mt-3 mb-3">
                                @if(auth()->user()->locale=='es_US')
                                {{$spanishArr[$detailed_profile_survey->_id]}}

                                @elseif(auth()->user()->locale == 'fr_CA' || auth()->user()->locale=='hi_IN'|| auth()->user()->locale=='en_IN')

                                @if( $detailed_profile_survey->display_name == 'Family' )
                                {{__('inpanel.profile.index.pro_survey_8')}}
                                @elseif( $detailed_profile_survey->display_name == 'Automotive' )
                                {{__('inpanel.profile.index.pro_survey_2')}}
                                @elseif( $detailed_profile_survey->display_name == 'Travel / Leisure' )
                                {{__('inpanel.profile.index.pro_survey_4')}}
                                @elseif( $detailed_profile_survey->display_name == 'Internet / Games / Sports' )
                                {{__('inpanel.profile.index.pro_survey_5')}}
                                @elseif( $detailed_profile_survey->display_name == 'Health / Food' )
                                {{__('inpanel.profile.index.pro_survey_6')}}
                                @elseif( $detailed_profile_survey->display_name == 'Technology' )
                                {{__('inpanel.profile.index.pro_survey_7')}}
                                @else

                                @endif

                                @else
    @if($detailed_profile_survey->display_name == 'Internet / Games / Sports')
        {{ __('inpanel.profile.index.pro_survey_5') }}
    @else
        {{ $detailed_profile_survey->display_name }}
    @endif
                                @endif
                            </p>


                        </div>

                    </div>




                    <div class="row mt-3">

                        <div class="col">

                            <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-size: 12px;">{{$detailed_profile_survey->completion_time}} {{__('inpanel.dashboard.user.min')}}</span>

                            <br>

                            <p class="pt-1" style="font-size: 12px; transform: translateY(10px);">{{__('inpanel.dashboard.survey.column_2')}}</p>

                        </div>


                        <div class="col text-end">

                            {{-- <button class="btn btn-primary btn-lg" style="font-size: 18px;" ><a  class="btn btn-primary" href="@if(Route::has('inpanel.survey.execute.show')){{route('inpanel.profiler.single.show', $detailed_profile_survey->_id)}}@endif" >Take Survey </a></button> --}}

                            <span class="pull-right survey_list">
                                <a class="btn btn-primary btn-lg survey-btn" style="font-size:18px" href="@if(Route::has('inpanel.survey.execute.show')){{route('inpanel.profiler.show', ['id' => $detailed_profile_survey->_id])}}@endif" id="tke_sry_but">{{__('inpanel.survey.index.link_take_survey')}}</a>

                            </span>

                        </div>

                    </div>


                </div>


        </div>
        @php
        }else{
        if($key % 3 == 0 && $key != 0){
        echo "<div class='row mt-2 mb-2 d-none d-lg-block' style='margin-bottom: -10px !important;'>";
            echo "<div class='col' style='margin-left:12px'>";
                echo "
                <hr style='scale:1.02; opacity:0.1'>";
                echo "
            </div>";

            echo "</div>";
        }
        @endphp
        <div class="col-12 col-lg-4 mt-3 ">

            <div class="border p-3 rounded bg-white cst-full-sr">


                <div class="row">

                    <div class="col">

                        <p class="h4 mb-0" style="font-weight: 600; color:#005A9A">{{$detailed_profile_survey->points}} {{__('inpanel.survey.index.column_2')}}</p>

                    </div>


                    <div class="col text-end">

                        <!--<p class="fw-bold lead">
                                {{--${{$detailed_profile_survey->points*config('app.points.metric.conversion')}}--}}
                                @if($detailed_profile_survey->points*config('app.points.metric.conversion') < 1)
                                    {{$detailed_profile_survey->points*config('app.points.metric.conversion')*100}} {{__('inpanel.dashboard.cents')}} 
                                @else
                                    ${{$detailed_profile_survey->points*config('app.points.metric.conversion')}} 
                                @endif
                            
                            </p>-->
                        <!-- Parshant Sharma [21-08-2024] Starts -->
                        <p class="fw-bold lead">
                            @if($detailed_profile_survey->points*$metricConversion < 1)
                                <!-- code updated by Vikas(Start) -->
                                @php
                                $centsValue = round($detailed_profile_survey->points * $metricConversion * 100);
                                $currency = ($centsValue > 1) ? @$currencies['currency_denom_plural'] : @$currencies['currency_denom_singular'];
                                @endphp
                                {{ $centsValue }} {{ __($currency) }}
                                <!-- End -->
                                @else
                                {{@$currencies['currency_logo']}}{{number_format($detailed_profile_survey->points*$metricConversion,2)}}
                                @endif

                        </p>
                        <!-- Parshant Sharma [21-08-2024] Ends -->
                    </div>

                </div>



                <div class="row" style="transform: translateY(-5px);">

                    <div class="col">

                        <p class="lead">{{$detailed_profile_survey->apace_project_code}}</p>

                    </div>

                </div>




                <div class="row">

                    <div class="col">

                        <span class="pt-1" style="font-size: 12px; transform: translateY(10px);">{{__('inpanel.survey.index.column_5')}} : </span>

                        <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-size: 11px;">{{@$detailed_profile_survey->loi}} {{__('inpanel.dashboard.user.min')}}</span>

                    </div>


                    <div class="col text-end">



                        <span class="pull-right survey_list">
                            @php
                            $registeredCountry = auth()->user()->country;

                            // Assign 'GB' if country is 'UK'
                            if ($registeredCountry === 'UK') {
                            $registeredCountry = 'GB';
                            }
                            @endphp

                            @if($registeredCountry === $currentCountry)
                            <a class="btn btn-primary btn-lg survey-btn" style="font-size:18px" href="@if(Route::has('inpanel.survey.execute.show')){{route('inpanel.survey.execute.show', ['user_project_id' => $detailed_profile_survey->id])}}@endif" id="tke_sry_but" target="_blank">{{__('inpanel.survey.index.link_take_survey')}}</a>
                            @else
                            <a class="btn btn-primary btn-lg survey-btn" style="font-size:18px" href="javascript:void(0)" onclick="showCustomCountryModal()" id="tke_sry_but">
                                {{__('inpanel.survey.index.link_take_survey')}}
                            </a>
                            @endif
                        </span>

                    </div>

                </div>

                @php $count_total_taken_surveys = 0; @endphp

                @foreach($getAllUserTakenSurveys as $allsurveystaken)

                @php

                if($allsurveystaken->apace_project_code == $detailed_profile_survey->apace_project_code){
                $count_total_taken_surveys++;
                }

                @endphp

                @endforeach

                <div class="row m-0 text-center">

                    <div class="col-12 m-0 text-start p-0">
                        @php
                        $temp_topic = $detailed_profile_survey->survey_name;
                        $use_topic = explode('-', $temp_topic);
                        @endphp
                        <p class="ms-0 me-0 mt-3 mb-3 type-element" style="font-size: 11px;" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="bottom" data-bs-title="@php echo $use_topic[0]; @endphp">{{__('inpanel.survey.index.column_10')}} : @php echo $use_topic[0]; @endphp</p>
                    </div>


                    <div class="col-12 m-0" style="@php if($count_total_taken_surveys < 1){ echo'visibility:hidden;'; }else{ echo''; } @endphp">

                        <p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;">@php echo $count_total_taken_surveys; @endphp {{__('inpanel.survey.index.column_11')}}</p>

                    </div>

                </div>


            </div>


        </div>
        @php }} @endphp
        @endforeach
        @endif
        @endif
        <!--<div class="row mt-2 mb-2 d-none d-lg-block"><div class="col ms-2 me-2"><hr></div></div> -->
    </div>
    <div class="row d-none d-lg-block">

        <div class="col ms-3 me-3">

            <!-- <hr> -->

        </div>

    </div>

</div>


</div>
<!--last section-->


<div class="row mt-5 mb-md-3 p-lg-1" style="margin-bottom: -27px !important;">

    <!--for mobile-->

    <div class="col-12 d-lg-none mb-5" id="detailed_progress_graph">

        <div class="shadow pt-4  pe-1 ps-1 pb-0 bg-white border" style="border-radius: 10px;">

            <p class="lead pe-3 ps-3" style="font-weight:600">{{__('inpanel.dashboard.detailed_progress')}}</p>

            <hr class="mb-5 me-3 ms-3">

            <div class="row">

                <div class="col d-flex justify-content-center">

                    <div class="semi-donut margin cst-per" style="--percentage : @if(isset($profilePercent)){{$profilePercent}}@else{{0}}@endif; --fill: #8387FF ;color: #FFA40B;">
                        <span class="text text-warning fw-bold" id="percentText1" style="color: #FFA40B !important;margin-top: 15px;"></span>
                    </div>


                    </col>


                </div>


                <div class="row mt-2 mb-4">

                    <div class="col lead text-center text-warning fw-bold" style="position: absolute;left: -124px;">0</div>

                    <div class="col lead text-center text-success fw-bold " style="position: relative;right: -136px;">100</div>

                </div>

                <div class="row mt-3 mb-4 text-center ms-1">

                    <p class="pb-1">{{__('inpanel.dashboard.profile.filling')}}</p>

                </div>


            </div>

        </div>

    </div>
    <!---->






    <div class="col-12 col-lg-7">

        <div class="shadow p-4 bg-white border" style="border-radius: 10px;">

            <div class="row">

                <div class="col-7">
                    <p class="lead" style="font-weight:600">{{__('inpanel.dashboard.recent_activites')}}</p>
                </div>

                <div class="col-5 text-end">
                    <a href="{{ route('inpanel.redeem.show') }}?tab=p-history" class="">{{__('inpanel.dashboard.show_more_recent_activities')}}</a>
                </div>


            </div>

            <hr class="mt-0 mb-4">
            @if(!empty($userActivities))
            <div>
                <ul style="list-style-type: none;">
                    <!-- <div id="line_spc"></div> -->
                    @php $i = 0; $totalactivity =count($userActivities); @endphp
                    @forelse($userActivities as $activity)
                    @if(!$activity->properties->isEmpty())
                    @php
                    $jsonData = json_decode($activity->properties);
                    if(isset($jsonData->survey_code)){
                    $surveycode = $jsonData->survey_code;
                    $descriptionData = trans($activity->description,['code'=>$surveycode]);
                    }else{
                    $descriptionData = trans($activity->description);
                    }

                    if(isset($jsonData->date)){
                    $date = \Carbon\Carbon::parse($jsonData->date);

                    $formatted = $date->formatLocalized('%B, %Y');;
                    $descriptionData = str_replace(':month_year', $formatted, $descriptionData);
                    }

                    if (isset($jsonData->points)) {
                    if (strpos($descriptionData, 'Points') !== false) {
                    $descriptionData = str_replace('Points', ' ' . $jsonData->points . ' Points', $descriptionData);
                    } elseif (strpos($descriptionData, 'Puntos') !== false) {
                    $descriptionData = str_replace('Puntos', ' ' . $jsonData->points . ' Puntos', $descriptionData);

                    }
                    }
                    @endphp
                    @else
                    @php
                    $descriptionData = trans(@$activity->description);
                    @endphp
                    @endif
                    <li class="mb-4 ">
                        <div class="d-flex gap-4">
                            <div class="col-1">
                                <img src="img/clock img.png" style="display: inherit;" class="me-1 position-relative" alt="img">
                                @if($i < $totalactivity-1)
                                    <span id="img_li"></span>
                                    @endif
                            </div>
                            <div class="col-10">
                                <span class="fw-bold">{{$descriptionData}}</span>
                                <p class="mr-md-5" style="transform: translateY(7px); opacity:0.5" id="user_activity_para">{{$activity->created_at->diffForHumans()}}</p>
                            </div>
                        </div>

                    </li>

                    </li>

                    @php $i++; @endphp
                    @empty

                    @endforelse
                </ul>
            </div>
            @endif

        </div>



    </div>


    <div class="col-5 d-none d-lg-block mt-3 mt-md-0" id="detailed_progress_Graph_2">

        <div class="shadow pt-4  pe-4 ps-4 pb-0 bg-white border" style="border-radius: 10px;padding-bottom: 18px !important;">

            <p class="lead" style="font-weight:600">{{__('inpanel.dashboard.detailed_progress')}}</p>

            <hr class="mb-5">

            <div class="row">

                <div class="wrapper d-flex justify-content-center">
                    <div class="circle-out">

                        <div id="bar" class="circle" data-progress="@if(isset($profilePercent)){{$profilePercent}}@else{{0}}@endif" class="detailed_progress"></div>
                        <span class="text text-warning fw-bold" id="percentText" style="color: #FFA40B !important;"></span>
                    </div>
                </div>


            </div>


            <div class="row mt-2 mb-4">

                <div class="col lead text-center text-warning fw-bold">0</div>

                <div class="col lead text-center text-success fw-bold">100</div>

            </div>

            <div class="row mt-3 mb-4 text-center">

                <p class="pb-1">{{__('inpanel.dashboard.profile.filling')}}</p>

            </div>


        </div>

    </div>

    <!-- popup new -->

    @if(auth()->user()->detailed_profile_filled == 0)

    <div class="cst-overlay">

        <div id="popup-sj-detail" class="row p-0 pt-2 pb-2 m-0 rounded-3">

            <div class="col-12 text-end d-lg-none">
                <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-pop-up" width="30px" style="cursor:pointer;">
            </div>

            <div class="col-12 col-lg-6 m-0 p-0 text-center">
                <img src="images/Profile updation popup image.png" alt="img" class="img-fluid pop-img-main">
            </div>

            <div class="col-12 col-lg-6">

                <div class="row">

                    <div class="col-12 text-end mt-1 d-none d-lg-block">
                        <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-pop-up" width="30px;" style="cursor:pointer;">
                    </div>

                    <div class="col-12 text-center">
                        <p class="h3 fw-bold text-primary mt-2">{{__('inpanel.dashboard.new_popups.profile_update_1')}}</p>
                        <p class="mt-4" style="font-weight: 400;">{{__('inpanel.dashboard.new_popups.profile_update_2')}}</p>
                        <a href="{{ route('inpanel.profiler.show') }}" class="mt-4 fw-bold h3 text-light bg-primary rounded-3 pop-link-btn">{{__('inpanel.dashboard.new_popups.profile_update_3')}}</a>
                    </div>

                </div>

            </div>

        </div>

    </div>


    @endif

    <!-- Himanshu created popup 31-07-2025 start -->
    @include('inpanel.includes.congrats_popup')
    <!-- Himanshu created popup 31-07-2025 end -->



    @if(session()->has('pop-up-survey'))

    @php

    $register_date = \Carbon\Carbon::parse(auth()->user()->created_at);
    $currentDate = \Carbon\Carbon::now();
    $days = $currentDate->diffInDays($register_date);
    @endphp

    @if ($days == 10 || ($days > 10 && ($days - 10) % 10 == 0))

    <div class="cst-overlay-survey">

        <div id="popup-sj-detail-survey" class="row p-0 pt-2 pb-2 m-0 rounded-3">

            <div class="col-12 text-end d-lg-none">
                <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-pop-up-survey" width="30px" style="cursor:pointer;">
            </div>

            <div class="col-12 col-lg-6 m-0 p-0 text-center">
                <img src="images/Survey popup Image.png" alt="img" class="img-fluid pop-img-main">
            </div>

            <div class="col-12 col-lg-6">

                <div class="row">

                    <div class="col-12 text-end mt-1 d-none d-lg-block">
                        <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-pop-up-survey" width="30px;" style="cursor:pointer;">
                    </div>

                    <div class="col-12 text-center">
                        <p class="h3 fw-bold text-primary mt-2">{{__('inpanel.dashboard.new_popups.take_survey_1')}}</p>
                        <p class="mt-4" style="font-weight: 400;">{{__('inpanel.dashboard.new_popups.take_survey_2')}}</p>
                        <a href="{{ route('inpanel.survey.index') }}" class="mt-4 fw-bold h3 text-light bg-primary rounded-3 pop-link-btn">{{__('inpanel.dashboard.new_popups.take_survey_3')}}</a>
                    </div>

                </div>

            </div>

        </div>

    </div>


    @endif

    @endif



    <!-- obhi sir poopup -->

    @if(session()->has('pop-up-refer'))

    @if($reffer_count == 0)

    @if ($days == 30 || ($days > 30 && ($days - 30) % 30 == 0))

    <div class="cst-overlay-refer">


        <div id="popup-sj-detail-refer" class="row p-0 pt-2 pb-2 m-0 rounded-3">

            <div class="col-12 text-end d-lg-none">
                <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-pop-up-refer" width="30px" style="cursor:pointer;">
            </div>

            <div class="col-12 col-lg-6 m-0 p-0 text-center">
                <img src="images/refer popup image.png" alt="img" class="img-fluid pop-img-main @if(auth()->user()->locale=='es_US') mt-4 @endif">
            </div>

            <div class="col-12 col-lg-6">

                <div class="row">

                    <div class="col-12 text-end mt-1 d-none d-lg-block">
                        <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-pop-up-refer" width="30px;" style="cursor:pointer;">
                    </div>

                    <div class="col-12 text-center">
                        <p class="h3 fw-bold text-primary mt-2">{{__('inpanel.dashboard.new_popups.refer_1')}}</p>
                        <p class="mt-4" style="font-weight: 400;">{{__('inpanel.dashboard.new_popups.refer_2')}}</p>
                        <a href="{{ route('inpanel.invite.show') }}" class="mt-4 fw-bold h3 text-light bg-primary rounded-3 pop-link-btn">{{__('inpanel.dashboard.new_popups.refer_3')}}</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

    @endif

    @endif

    @endif
    @if($showRewardPopUp->isEmpty())
    <div class="cst-overlay-reward">
        <div class="modal-content" id="popup-reward-detail">
            <div class="modal-body">
                <div class="col-12 text-end">
                    <img src="images/image-removebg-POP.png" alt="img" class="img-fluid remove-reward-popup" width="30px" style="cursor:pointer; margin-bottom:15px;">
                </div>
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle" style="font-size: 23px;color:goldenrod;"></i> {{ __('inpanel.reward_pole.points_part_1') }}<strong>{{ __('inpanel.reward_pole.points_part_2') }}</strong> {{ __('inpanel.reward_pole.points_part_3') }}
                </div>
                <div class="content">
                    <p class="m-0" style="font-size: large;">
                        <strong>{{ __('inpanel.reward_pole.monthly_award_message') }}</strong>
                    </p>
                    <p>
                        {{ __('inpanel.reward_pole.preferred_day_time_question') }}
                    </p>
                </div>
                <div class="mainform">
                    <form action="" id="rewardPoleForm">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 weekday_mobile">
                                @php
                                function localizedTime($time) {
                                $format = 'g:i A'; // This gives you something like 1:30 PM
                                $formatted = $time->format($format);

                                // Translate AM/PM manually
                                $formatted = str_replace('AM', __('inpanel.weekdaytime.am'), $formatted);
                                $formatted = str_replace('PM', __('inpanel.weekdaytime.pm'), $formatted);
                                return $formatted;
                                }
                                @endphp
                                <div class="form-group weekday-select-form">
                                    <select
                                        class="form-control py-3 form-select"
                                        id="weekday"
                                        style="height: auto;">
                                        <option value="" disabled selected>{{ __('inpanel.weekdays.select_weekdays') }}</option>
                                        <option value="monday">{{ __('inpanel.weekdays.monday') }}</option>
                                        <option value="tuesday">{{ __('inpanel.weekdays.tuesday') }}</option>
                                        <option value="wednesday">{{ __('inpanel.weekdays.wednesday') }}</option>
                                        <option value="thursday">{{ __('inpanel.weekdays.thursday') }}</option>
                                        <option value="friday">{{ __('inpanel.weekdays.friday') }}</option>
                                        <option value="saturday">{{ __('inpanel.weekdays.saturday') }}</option>
                                        <option value="sunday">{{ __('inpanel.weekdays.sunday') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control py-3 form-select" id="weekdaytime" style="height: auto;">
                                        <option value="" disabled selected>{{ __('inpanel.weekdaytime.select_time') }}</option>
                                        @for ($i = 0; $i < 24 * 2; $i++)
                                            @php
                                            $time=\Carbon\Carbon::createFromTime(0, 0)->addMinutes($i * 30);
                                            @endphp
                                            <option value="{{ $time->format('H:i') }}">{{ localizedTime($time) }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="text-center col-12 mt-4">
                                <div class="rewardMessage"></div>
                                <button type="submit" class="btn btn-primary py-2 px-3 weekdaysubmitbtn">
                                    {{ __('inpanel.reward_pole.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="modal fade" id="otherCountryModal" aria-hidden="true" aria-labelledby="otherCountryModalToggle"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="otherCountryModalToggle"></h1>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-popup-other-country">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <img src="{{asset('images/country_image1.webp')}}" alt="" class="img-fluid img-cover">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 welcome-div">
                                <div class="welcome-content">
                                     <span class="welcome-span">{{ __('inpanel.welcome_to_message.welcome_to') }}</span>
                                    <span class="welcome-span">{{ __('inpanel.welcome_to_message.sj_panel') }}</span>
                                </div>

                                <div class="welcome-paragraph">
                                    <div class="welcome-paragraph">
                                        <p>{{ __('inpanel.login_country_warning.country_restrict_1') }}</p>
                                        <p>{{ __('inpanel.login_country_warning.country_restrict_2') }}</p>
                                        <p>{{ __('inpanel.login_country_warning.country_restrict_3') }}</p>
                                        <p>{{ __('inpanel.login_country_warning.country_restrict_4') }}</p>
                                    </div>
                                </div>
                                <div class="">
                                    <button class="custom-button m-auto" id="modalConfirmBtn">{{ __('inpanel.login_country_warning.ok') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade @if($showRewardPopUp->isEmpty()) z-low @else t-high @endif" id="tourModal" aria-hidden="true" aria-labelledby="tourModalLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tourModalLabel"></h1>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <img src="./images/welcome_image1.webp" alt="" class="img-fluid img-cover">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 welcome-div">
                                <div class="welcome-content">
                                    <span class="welcome-span">{{ __('inpanel.welcome_to_message.welcome_to') }}</span>
                                    <span class="welcome-span">{{ __('inpanel.welcome_to_message.sj_panel') }}</span>

                                </div>
                                <div class="welcome-paragraph">
                                    <p>{{ __('inpanel.welcome_popup.welcome_1') }}</p>
                                    <p>{{ __('inpanel.welcome_popup.welcome_2') }}</p>
                                    <p>{{ __('inpanel.welcome_popup.welcome_3') }}</p>
                                    <p>{{ __('inpanel.welcome_popup.welcome_4') }}</p>
                                </div>
                                <div class="">
                                    <button class="custom-button m-auto" id="startTourBtn">{{ __('inpanel.welcome_popup.lets_do_it') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade @if($showRewardPopUp->isEmpty()) z-low @else z-high @endif" id="redeemRequestModal" aria-hidden="true" aria-labelledby="redeemRequestModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="redeemRequestModalLabel"></h1>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row redeem-div">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <img src="{{asset('images/redeem_image.webp')}}" alt="" class="img-fluid img-cover">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 welcome-div">
                                <div class="welcome-paragraph">
                                    <p>{!! __('inpanel.threshold_reached.congratulations_1') !!}</p>
                                    <p>{{ __('inpanel.threshold_reached.congratulations_2') }}</p>
                                    <p>{{ __('inpanel.threshold_reached.congratulations_3') }}</p>
                                    <p>{{ __('inpanel.threshold_reached.congratulations_4') }}</p>
                                    <p>{{ __('inpanel.threshold_reached.congratulations_5') }}</p>
                                    <p>{{ __('inpanel.threshold_reached.congratulations_6') }}</p>
                                </div>
                                <div class="">
                                    <a href="{{ route('inpanel.redeem.show') }}" class="btn custom-button m-auto">{{ __('inpanel.threshold_reached.redeem') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection


    @push('after-scripts')
    <script src="{{asset('vendor/js/plugins/d3/d3.min.js')}}"></script>
    <script src="{{asset('vendor/js/plugins/c3/c3.min.js')}}"></script>
    <script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v6.0.5.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
    <script type="text/javascript" src="{{asset('js2/dashboard.js')}}"></script>
    <script type="text/javascript">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        /*$(document).ready(function(){
            displayOtherCountryPopUp(); 
        })*/
        var dfiq_check = $("#dfiq_check").val();
        var home_country = $('#home_country').val();
        if (dfiq_check == 1 && home_country == '') {
            invokeAPI();
            //displayOtherCountryPopUp();               
        } else {
            if (home_country == 'OUT') {

                //displayOtherCountryPopUp();

            }

        }
        @if($user->is_blacklist == 1)
        // displayBlacklistPopUp();
        @endif

        function displayBlacklistPopUp() {
            swal({
                title: '' + "{{__('inpanel.dashboard.pop_up.title')}}",
                html: "{{__('inpanel.dashboard.pop_up.title_6')}}",
                type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
                showCancelButton: false,
                confirmButtonColor: "#1080d0",
                confirmButtonText: "Ok",
                //cancelButtonText: "Cancel",
                closeOnConfirm: true
            }).then((result) => {
                // if (result.value===true) {
                //     window.location.href = "detailed-profile?update=profile";
                // } 
                // else if(result.dismiss == 'cancel') {

                // }
            });
        }

        // function displayOtherCountryPopUp() {

        //     // $('.navbar-default').hide();
        //     swal({
        //         title: '' + "{{__('inpanel.dashboard.pop_up.title')}}",
        //         html: "{!!__('inpanel.dashboard.pop_up.title_7')!!}",
        //         type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
        //         customClass: 'swal-wide',
        //         showCancelButton: false,
        //         confirmButtonColor: "#1080d0",
        //         confirmButtonText: "{{__('inpanel.dashboard.pop_up.title_9')}}",
        //         //cancelButtonText: "Cancel",
        //         closeOnConfirm: true
        //     }).then((result) => {

        //         if (result.value === true) {
        //             // window.location.href = "/dashboard";
        //         } else if (result.value == undefined) {
        //             // window.location.href = "/dashboard";
        //         }
        //     });
        // }
        function displayOtherCountryPopUp() {
            $('#otherCountryModal').modal('show');
            $('#modalConfirmBtn').off('click').on('click', function() {
                $('#otherCountryModal').modal('hide');
            });
        }
        $(document).ready(function() {
            var detailedMeter = $('#gauge').length;
            if (detailedMeter > 0) {
                c3.generate({
                    bindto: '#gauge',
                    data: {
                        columns: [
                            [

                                'Progress', @if(isset($profilePercent)) {
                                    $profilePercent
                                }
                                @else {

                                    0

                                }
                                @endif

                            ]
                        ],

                        type: 'gauge'
                    },
                    color: {
                        pattern: ['#1ab394', '#BABABA']

                    }
                });
            }

        });

        //graph
        const bar = document.getElementById("bar");

        var progress = bar.dataset.progress;

        var metertext = document.getElementById("percentText").innerHTML = progress + '%';
        var metertext1 = document.getElementById("percentText1").innerHTML = progress + '%';

        const p = 180 - (progress / 100) * 180;

        bar.style.transform = `rotate(-${p}deg)`;


        // const bar1 = document.getElementById("bar1");

        // var progress1 = bar1.dataset.progress;



        // const q = 180 - (progress1 / 100) * 180;

        // bar1.style.transform = `rotate(-${q}deg)`;
        //


        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); // Set expiration time
            document.cookie = name + "=" + value + ";expires=" + expires.toUTCString() + ";path=/";
        }


        function isSidebarReady() {
            return new Promise((resolve) => {
                document.getElementById("offcanvasNavbar").classList.add("show");
                setTimeout(() => {
                    resolve();
                }, 400);
                // if(document.readyState === 'complete'){
                //     resolve();
                // }else{
                //     document.addEventListener('DOMContentLoaded',resolve);
                // }
            });
        }

        function getCookie(cname) {

            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }

            }
            return "";
        }


        // function displayTourOption() {
        //     if (getCookie("Tour") != 1) {
        //         swal({
        //             title: '' + "{{__('inpanel.dashboard.pop_up.title')}}",
        //             html: "{{__('inpanel.dashboard.pop_up.title_1')}}" +
        //                 "<br/>{{__('inpanel.dashboard.pop_up.title_2')}}&nbsp;<i class='far fa-smile-wink'></i><br/>",
        //             type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
        //             showCancelButton: true,
        //             confirmButtonColor: "#1080d0",
        //             confirmButtonText: "{!! __('inpanel.dashboard.pop_up.title_3') !!}",
        //             cancelButtonText: "{!! __('inpanel.dashboard.pop_up.donot_show_button') !!}",
        //             closeOnConfirm: false,
        //             footer: "<a href='javascript:void(0)' onclick='closeTour()' id='some-action'>{!! __('inpanel.dashboard.pop_up.skip_for_now') !!}</a>"
        //         }).then((result) => {
        //             if (result.value === true) {
        //                 if (window.innerWidth >= 220 && window.innerWidth <= 990) {
        //                     // beforeShowPromise:
        //                     // document.getElementById("offcanvasNavbar").classList.add("show");
        //                     isSidebarReady().then(() => {
        //                         shepherd.start();
        //                     });

        //                 } else {

        //                     shepherd.start();
        //                 }


        //                 //window.location.href = "@if(Route::has('inpanel.profiler.show')){{route('inpanel.profiler.show')}}@endif";
        //                 // For more information about handling dismissals please visit
        //                 // https://sweetalert2.github.io/#handling-dismissals
        //             } else if (result.dismiss == 'cancel') {
        //                 changeTourOption();
        //                 closeTour();
        //             }
        //         });
        //     }
        // }
        function displayTourOption() {
            if (getCookie("Tour") != 1) {
                $('#tourModal').modal('show');
                document.getElementById("startTourBtn").addEventListener("click", function() {
                    $('#tourModal').modal('hide');
                    if (window.innerWidth >= 220 && window.innerWidth <= 990) {
                        isSidebarReady().then(() => {
                            shepherd.start();
                        });
                    } else {
                        shepherd.start();
                    }
                });
            }
        }
        /*
        added code on 1 july 2022 via dushyant
            starts
            code is for show profile update popup every six month 
        */
       $(document).ready(function(){
           @if($tour_taken == 0)
           displayTourOption();
           @include('inpanel.includes.partials.php-js.dashboard')
           @endif
       })

        @if($minute == 0 && $user->is_blacklist == 0)
        displayProfilePopUp();
        @endif

        function displayProfilePopUp() {
            swal({
                title: '' + "{{__('inpanel.dashboard.pop_up.title')}}",
                html: "{{__('inpanel.dashboard.pop_up.title_8')}}",
                type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
                showCancelButton: true,
                confirmButtonColor: "#1080d0",
                confirmButtonText: "Yes, Update",
                cancelButtonText: "No",
                closeOnConfirm: true
            }).then((result) => {
                if (result.value === true) {
                    window.location.href = "detailed-profile?update=profile";
                } else if (result.dismiss == 'cancel') {
                    @if($tour_taken == 0)
                    displayTourOption();
                    @include('inpanel.includes.partials.php-js.dashboard')
                    @endif
                }
            });
        }


        /*
            added code on 1 july 2022 via dushyant
            end
        */



        function closeTour() {
            expires = 0;
            cvalue = 1;
            cname = "Tour";
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            swal.close();
        }

        function changeTourOption() {
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','dashboard')}}", headers);
        }

        // Code added by anil
        // Date: 01-09-2025
        function openRedeemModal() {
            // alert('ddd');
            $('#redeemRequestModal').modal('show');
        }
        @if(!$hasRedeemRequest && $hasThresholdReached)
        $(document).ready(function() {
            openRedeemModal();
        })
        @endif
        // Code added by anil end

        $(document).on('click', 'a#survey', function(e) {
            var active_survey_id = $(this).attr('data-active_survey_id');
            swal({
                title: '' + "<i class='fas fa-flag-checkered'></i>",
                html: "<strong>{{__('inpanel.dashboard.survey_pop_up.title_1')}}</strong>" +
                    "<br/>{{__('inpanel.dashboard.survey_pop_up.title_2')}}<br/>",
                type: "{{__('inpanel.dashboard.survey_pop_up.title_5')}}",
                showCancelButton: true,
                confirmButtonColor: "#1080d0",
                confirmButtonText: "{!! __('inpanel.dashboard.survey_pop_up.title_3') !!}",
                cancelButtonText: "{!! __('inpanel.dashboard.survey_pop_up.cancel') !!}",
                closeOnConfirm: false,
            }).then((result) => {
                if (result.value === true) {
                    var url = "{{route('inpanel.survey.execute.show',": id ")}}";
                    url = url.replace(':id', active_survey_id);
                    window.location.replace(url);
                }
            });
        })

        function invokeAPI() {
            var req = document.getElementById("requestid").value;
            var event = document.getElementById("eventid").value;
            var country = document.getElementById("cc").value;
            if (country == 'UK') {
                country = 'GB';
            } else {
                country = country;
            }
            var utm_source = "SjPanel";
            //$('#form-dispaly').hide();
            // $('.loader').show();
            var uniquenessParam = Forensic.createUniquenessParam(event, null, false);
            var geoParam = Forensic.createGeoParam(country);
            Forensic.forensic(req, successCallback, errorCallback, uniquenessParam, geoParam, null, null, utm_source);
        }

        function successCallback(jsonData) {
            var FlagStatus = false;
            var Message = '';
            console.log(jsonData);
            var email = $('#email').val();
            var ip_address = $('#eventid').val();
            var panelistId = $('#eventid').val();
            var userid = $('#user_id').val();
            $.ajax({
                url: "{{ route('inpanel.dashboard.dfiqData.post') }}",
                type: 'GET',
                data: {
                    datajsondata: jsonData,
                    email: email,
                    ip_address: ip_address,
                    panelistId: panelistId,
                    user_id: userid
                },
                success: function(response) {
                    window.location = addressBar + "&DFIQ=true";
                },
                async: true
            });

            if (jsonData.forensic.marker.score > 26) {

                console.log("fraud score >= 25 or not unique"); // Add your logic to handle non-fraud/unique
                if (jsonData.forensic.marker.isGeoPostal == false && FlagStatus == false) {
                    //displayOtherCountryPopUp();
                }

            }

        };

        function errorCallback(jsonData) {
            console.log(jsonData.error.message); // Add your logic to handle errors
        }



        // var spanish_fields = document.getElementById('tke_sry_but');

        // if(spanish_fields.innerText != 'take surveys'){



        //     spanish_fields.style.fontSize = '12px !important';
        //   }


        // survey btn






        var sa = document.getElementById("searchBarM");
        var sj = document.getElementById("searchIconM");
        sa.addEventListener("keyup", () => {
            if (sa.value !== '') {
                sj.style.visibility = 'hidden';
            } else {
                sj.style.visibility = 'visible';

            }

        });



        //


        // $(function() {
        //   $(".shepherd-button").click(function() {
        //     alert('hello');
        //     $("#detailed_progress_Graph").focus();
        //   });
        // });

        // document.querySelector('#detailed_progress_Graph').addEventListener('click' , () => {
        //     alert("hello");
        //     window.scrollTo(0, 500);
        // })
        $(document).ready(function() {
            $('.survey-btn').on('click', function() {
                url = $(this).attr('href');
                //win= window.open(url, '_blank');
                if (win) {
                    location.reload('/');
                    // window.location.href = window.location.href;
                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#hot_survey_options').change(function() {
                let survey_dd = document.getElementById('clearFilter');
                survey_dd.style.display = "inline-block";
                let profiling_surveys = <?php echo json_encode($profile_sections); ?>;
                let profiling_surveys_count = <?php echo count($profile_sections); ?>;
                //let config_setting = {!! json_encode(config('app.points.metric.conversion')) !!};
                //console.log('config_setting-'+config_setting);
                let config_setting = <?php echo json_encode($metricConversion); ?>;
                let config_singular = "{{__($currencies['currency_denom_singular'])}}";
                let config_plural = "{{__($currencies['currency_denom_plural'])}}";
                let config_logo = <?php echo json_encode($currencies['currency_logo']); ?>;

                console.log('config_setting-' + config_setting);
                console.log('config_singular-' + config_singular);
                console.log('config_plural-' + config_plural);
                console.log('config_logo-' + config_logo);

                val = $('#hot_survey_options').val();
                $.ajax({
                    url: "{{route('inpanel.get.filtered.survey')}}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        data: val,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        //  console.log(response.data);
                        const mergeResult = [...response.data, ...profiling_surveys];
                        let responseCount = response.data.length;
                        console.log(mergeResult);
                        // console.log("hello "+responseCount);
                        let new_html_sr = '';
                        let end_count = 0;
                        if (mergeResult.length > 12) {
                            end_count = 12;
                        } else {
                            end_count = mergeResult.length;
                        }
                        if (response.data.length > 0) {
                            document.querySelector('#hot_Surveys_Section').innerHTML = "";
                            for (let i = 0; i < end_count; i++) {
                                if (i % 3 == 0 && i != 0) {
                                    new_html_sr += "<div class='row mt-2 mb-2 d-none d-lg-block' style='margin-bottom: -10px !important;'>" +
                                        "<div class='col' style='margin-left:12px'>" +
                                        "<hr style='scale:1.02; opacity:0.1'>" +
                                        "</div>" +

                                        "</div>";
                                }
                                if (responseCount >= 12) {
                                    if (i < responseCount) {
                                        var use_arr_for_type = mergeResult[i].survey_name.split('-');
                                        var total_taken_surveys = @php echo json_encode($getAllUserTakenSurveys) @endphp;
                                        var total_taken_survey_count = 0;
                                        // console.log(total_taken_surveys.data);

                                        for (let j = 0; j < total_taken_surveys.data.length; j++) {

                                            if (total_taken_surveys.data[j].apace_project_code == mergeResult[i].apace_project_code) {

                                                total_taken_survey_count++;

                                            }
                                        }

                                        new_html_sr += `<div class="col-12 col-lg-4 mt-3 " id="userAssigned">
         
                                                        <div class="border p-3 rounded bg-white cst-full-sr">
                                        
                                        
                                                            <div class="row">
                                        
                                                                <div class="col">
                                        
                                                                    <p class="h4 mb-0" style="font-weight: 600; color:#005A9A">${mergeResult[i].points} {{__('inpanel.survey.index.column_2')}}</p>
                                        
                                                                </div>
                                        
                                                                
                                                                <div class="col text-end">
                                        
                                                                    <p class="fw-bold lead"> `;
                                        if (mergeResult[i].points * config_setting < 1) {

                                            var currencyy = ((mergeResult[i].points * config_setting * 100) > 1) ? config_plural : config_singular;

                                            new_html_sr += `${parseFloat((mergeResult[i].points * config_setting * 100).toFixed(2))} ${currencyy} `;
                                        } else {
                                            new_html_sr += `${config_logo}${parseFloat((mergeResult[i].points*config_setting).toFixed(2))}`;
                                        }

                                        new_html_sr += `</p>
                                        
                                                                </div>
                                        
                                                            </div>
                                        
                                        
                                        
                                                            <div class="row" style="transform: translateY(-5px);">
                                        
                                                                <div class="col">
                                        
                                                                    <p class="lead">${mergeResult[i].apace_project_code}</p>
                                        
                                                                </div>
                                        
                                                            </div>
                                        
                                        
                                        
                                        
                                                            <div class="row">
                                        
                                                                <div class="col">
    
                                                                    <span class="pt-1" style="font-size: 12px; transform: translateY(10px);">{{__('inpanel.survey.index.column_5')}}</span>
                                        
                                                                    <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-size: 11px;">${mergeResult[i].loi} {{__('inpanel.dashboard.user.min')}}</span>
                                        
                                                                </div>
                                        
                                                                
                                                                <div class="col text-end">
                                        
                                                                    <span class="pull-right survey_list">
                                                                            
                                                                            <a  class="btn btn-primary btn-lg survey-btn" style="font-size:18px" id="tke_sry_but" target="_blank">{{__('inpanel.survey.index.link_take_survey')}}</a>
                                                                        
                                                                    </span>
    
                                                                </div>
                                        
                                                            </div>
    
    
                                                            <div class="row m-0 text-center">
    
                                                                <div class="col-12 m-0 text-start p-0">
    
                                                                        <p class="ms-0 me-0 mt-3 mb-3" style="font-size: 11px;">{{__('inpanel.survey.index.column_10')}} ${use_arr_for_type[0]}</p>
                                                                </div>    
    
    
                                                                <div class="col-12 m-0">`;
                                        if (total_taken_survey_count) {
                                            new_html_sr += `<p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;">${total_taken_survey_count} {{__('inpanel.survey.index.column_11')}}</p>`;

                                        } else {
                                            new_html_sr += `<p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;visibility:hidden;">${total_taken_survey_count} {{__('inpanel.survey.index.column_11')}}</p>`;

                                        }

                                        new_html_sr += `   </div>
    
                                                            </div>
                                        
                                        
                                                        </div>
                                                        
                                        
                                                    </div>`;

                                    }

                                } else {
                                    if (i < responseCount) {
                                        var use_arr_for_type = mergeResult[i].survey_name.split('-');
                                        var total_taken_surveys = @php echo json_encode($getAllUserTakenSurveys) @endphp;
                                        var total_taken_survey_count = 0;
                                        // console.log(total_taken_surveys.data);

                                        for (let j = 0; j < total_taken_surveys.data.length; j++) {

                                            if (total_taken_surveys.data[j].apace_project_code == mergeResult[i].apace_project_code) {

                                                total_taken_survey_count++;

                                            }
                                        }

                                        new_html_sr += `<div class="col-12 col-lg-4 mt-3 " id="userAssigned">
         
                                                        <div class="border p-3 rounded bg-white cst-full-sr">
                                        
                                        
                                                            <div class="row">
                                        
                                                                <div class="col">
                                        
                                                                    <p class="h4 mb-0" style="font-weight: 600; color:#005A9A">${mergeResult[i].points} {{__('inpanel.survey.index.column_2')}}</p>
                                        
                                                                </div>
                                        
                                                                
                                                                <div class="col text-end">
                                        
                                                                    <p class="fw-bold lead"> `;
                                        if (mergeResult[i].points * config_setting < 1) {
                                            var currencyy = ((mergeResult[i].points * config_setting * 100) > 1) ? config_plural : config_singular;
                                            new_html_sr += `${parseFloat((mergeResult[i].points * config_setting * 100).toFixed(2))} ${currencyy} `;
                                        } else {
                                            new_html_sr += `${config_logo}${parseFloat((mergeResult[i].points*config_setting).toFixed(2))}`;
                                        }

                                        new_html_sr += `</p>
                                        
                                                                </div>
                                        
                                                            </div>
                                        
                                        
                                        
                                                            <div class="row" style="transform: translateY(-5px);">
                                        
                                                                <div class="col">
                                        
                                                                    <p class="lead">${mergeResult[i].apace_project_code}</p>
                                        
                                                                </div>
                                        
                                                            </div>
                                        
                                        
                                        
                                        
                                                            <div class="row">
                                        
                                                                <div class="col">
    
                                                                    <span class="pt-1" style="font-size: 12px; transform: translateY(10px);">{{__('inpanel.survey.index.column_5')}}</span>
                                        
                                                                    <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-size: 11px;">${mergeResult[i].loi}{{__('inpanel.dashboard.user.min')}}</span>
                                        
                                                                </div>
                                        
                                                                
                                                                <div class="col text-end">
                                        
                                                                    <span class="pull-right survey_list">
                                                                            
                                                                            <a  class="btn btn-primary btn-lg survey-btn" style="font-size:18px" id="tke_sry_but" target="_blank">{{__('inpanel.survey.index.link_take_survey')}}</a>
                                                                        
                                                                    </span>
    
                                                                </div>
                                        
                                                            </div>
    
    
                                                            <div class="row m-0 text-center">
    
                                                                <div class="col-12 m-0 text-start p-0">
    
                                                                        <p class="ms-0 me-0 mt-3 mb-3" style="font-size: 11px;">{{__('inpanel.survey.index.column_10')}} ${use_arr_for_type[0]}</p>
                                                                </div>    
    
    
                                                                <div class="col-12 m-0">`;

                                        if (total_taken_survey_count) {
                                            new_html_sr += `<p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;">${total_taken_survey_count} {{__('inpanel.survey.index.column_11')}}</p>`;

                                        } else {
                                            new_html_sr += `<p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;visibility:hidden;">${total_taken_survey_count} {{__('inpanel.survey.index.column_11')}}</p>`;

                                        }

                                        new_html_sr += `   </div>
    
                                                            </div>
                                        
                                        
                                                        </div>
                                                        
                                        
                                                    </div>`;




                                    } else {

                                        new_html_sr += `<div class="col-12 col-lg-4 mt-3 " id="userAssigned">
                                                        <div class="border p-3 rounded bg-white cst-full-sr">
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <p class="h4 mb-0" style="font-weight: 600; color:#005A9A">${mergeResult[i].points} {{__('inpanel.survey.index.column_2')}}</p>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <p class="fw-bold lead">`;
                                        if (mergeResult[i].points * config_setting < 1) {

                                            var currencyy = ((mergeResult[i].points * config_setting * 100) > 1) ? config_plural : config_singular;
                                            new_html_sr += `${parseFloat((mergeResult[i].points * config_setting * 100).toFixed(2))} ${currencyy} `;
                                        } else {
                                            new_html_sr += `${config_logo}${parseFloat((mergeResult[i].points*config_setting).toFixed(2))}`;
                                        }

                                        new_html_sr += `</p>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="transform: translateY(-5px);">
                                                                <div class="col">
                                                                    <p class="lead mt-3 mb-4">${mergeResult[i].display_name}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-size: 12px;">${mergeResult[i].completion_time} {{__('inpanel.dashboard.user.min')}}</span>
                                                                    <br>
                                                                    <p class="pt-1" style="font-size: 12px; transform: translateY(10px);">{{__('inpanel.dashboard.survey.column_2')}}</p>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <span class="pull-right survey_list"> 
    
                                                                <a  class="btn btn-primary btn-lg survey-btn" style="font-size:18px"  id="tke_sry_but" target="_blank">{{__('inpanel.survey.index.link_take_survey')}}</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`;
                                    }
                                }

                            }
                            jQuery("#hot_Surveys_Section").append(new_html_sr);
                            var te = document.querySelectorAll('#tke_sry_but');

                            for (let i = 0; i < te.length; i++) {
                                if (te[i].innerText == 'Tomar encuestas') {

                                    te[i].style.fontSize = '13px';

                                    te[i].style.scale = '1.1';

                                }

                                if (i < responseCount) {
                                    var url = "{{route('inpanel.survey.execute.show', ['id' => ':id'])}}";
                                    url = url.replace(':id', mergeResult[i].id);
                                } else {
                                    var url = "{{route('inpanel.profiler.show', ['id' => 'pro_id'])}}";
                                    url = url.replace('pro_id', mergeResult[i]._id);

                                }
                                te[i].href = url;
                            }
                        }
                    }


                });

            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#rewardPoleForm').on('submit', function(e) {
                e.preventDefault();

                $('#weekday, #weekdaytime').removeClass('is-invalid');

                let weekday = $('#weekday').val();
                let time = $('#weekdaytime').val();
                let hasError = false;

                if (!weekday) {
                    $('#weekday').addClass('is-invalid');
                    hasError = true;
                }

                if (!time) {
                    $('#weekdaytime').addClass('is-invalid');
                    hasError = true;
                }

                if (hasError) return;

                let formData = {
                    weekday: weekday,
                    weekdaytime: time,
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: "{{ route('inpanel.dashboard.insertRewardPole') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        toastr.success("{{ __('inpanel.reward_pole.response_success') }}");
                        document.querySelector('#popup-reward-detail').style.display = 'none';
                        $('#rewardPoleForm')[0].reset();
                    },
                    error: function(xhr) {
                        $('.rewardMessage').text(xhr.responseText);
                    }
                });
            });
        });
        $('#weekday, #weekdaytime').on('change', function(e) {
            $('.weekdaysubmitbtn').removeAttr('disabled');
            $(e.target).removeClass('is-invalid');
        });
    </script>
    <script>
        document.querySelectorAll('.remove-pop-up').forEach((item) => {
            item.addEventListener('click', () => {
                document.querySelector('#popup-sj-detail').style.display = 'none';
                document.querySelector('.cst-overlay').style.display = 'none';
                {{session()->pull('pop-up')}}
            });

        });

        document.querySelectorAll('.remove-pop-up-survey').forEach((item) => {
            item.addEventListener('click', () => {
                document.querySelector('#popup-sj-detail-survey').style.display = 'none';
                document.querySelector('.cst-overlay-survey').style.display = 'none';
                {{session()->pull('pop-up-survey')}}
            });
        });
        
           document.querySelectorAll('.remove-reward-popup').forEach((item) => {
            item.addEventListener('click', () => {
                document.querySelector('#popup-reward-detail').style.display = 'none';
                document.querySelector('.cst-overlay-reward').style.display = 'none';
                const tourModal = document.querySelector('#tourModal');
                const redeemModal = document.querySelector('#redeemRequestModal');

                if (tourModal) {
                    tourModal.classList.remove('z-low'); // restore z-index & visibility
                    tourModal.style.visibility = 'visible';
                    tourModal.style.pointerEvents = 'auto';
                }
            
                if (redeemModal) {
                    redeemModal.classList.remove('z-low'); // restore z-index & visibility
                    redeemModal.style.visibility = 'visible';
                    redeemModal.style.pointerEvents = 'auto';
                }
                tourModal.style.zIndex = 1054;
               redeemModal.style.zIndex = 1052;
            });
        });

        document.querySelectorAll('.remove-pop-up-refer').forEach((item) => {
            item.addEventListener('click', () => {
                document.querySelector('#popup-sj-detail-refer').style.display = 'none';
                document.querySelector('.cst-overlay-refer').style.display = 'none';
                {{session()->pull('pop-up-refer')}}
            });
        });
    </script>


    @endpush

    <script>

    </script>