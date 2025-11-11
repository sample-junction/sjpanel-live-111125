
@extends('inpanel.layouts.device')

@push('after-styles')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<style>
    .filter-survey-li {
        color: #999999;
        font-size: 15px;
        cursor: pointer;
        position: absolute;
        width: auto;
        bottom: 0;
        padding-bottom: 16px;
    }

    .cst-survey-filter-active {

        border-bottom: 3px solid #0d6efd;
        color: #0d6efd;
        padding-bottom: 15px;
        font-weight: 600;
    }


    .table-height-cst-row {

        height: 51px;

    }

    .table-height-cst-row td {

        vertical-align: middle;
        text-align: center;

    }

    .table-height-cst-row th {
        padding-top: 14px;
        color: #005A9A;
        background: #FAFAFA;
        text-align: center;
    }

    .tab-sta-btn {
        height: 30px;
        width: 80px;
        border-radius: 5px;
        border: none;
        font-weight: 600;
        font-size: 14px;
    }


    .link-social {
        width: auto;
    }

    .points-cst-bottom {
        font-size: 14px;
        transform: translate(-40px, 5px);
    }

    .ref-text {
        text-decoration: none;
        font-size: 16px;
    }

    .cst-status-final {
        font-size: 14px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .input-my-ref::placeholder {
        /* Chrome, Firefox, Opera, Safari 10.1+ */
        opacity: 0.5;
        /* Firefox */
    }

    .points-enter-sec {
        transform: translateX(-30px);
    }

    .cst-li-scroll::-webkit-scrollbar {
        display: none;
    }

    .reed-options {
        font-size: 16px;
    }

    .cst-mid-li {
        transform: translateX(-5%)
    }

    .cst-ul::before {
        content: "";
        height: 97%;
        width: 1px;
        background: #ECECEC;
        position: absolute;
        transform: translate(18px, 7px);
    }

    .li-tab-row {
        position: relative;
        height: 60px;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }

    .li-tab-row {
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
        scrollbar-width: none;
        /* Firefox */
    }

    .li-tab-row::-webkit-scrollbar {
        display: none;
        /* Safari and Chrome */
    }

    .li-list-item-two {
        left: 22%;
    }

    .li-list-item-three {
        left: 45%;

    }

    .li-list-item-four {
        left: 62%;
    }

    .table-height-cst-row {
        height: 51px;
    }

    .table-height-cst-row td {
        text-align: center;
        padding-top: 14px;
        vertical-align: middle;
    }

    .table-height-cst-row th {
        text-align: center;
        padding-top: 14px;
        color: #005A9A;
        background: #FAFAFA;
    }

    .tab-sta-btn {
        height: 30px;
        width: 80px;
        border-radius: 5px;
        border: none;
        font-weight: 600;
        font-size: 14px;
    }

    .cst-full-sr {
        border: 1px solid #ECECEC;
    }

    .cst-full-sr:hover {
        border: 1px solid #794dc8;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .dataTables_filter {
        margin-bottom: 20px;
        font-weight: bold;
    }

    .dataTables_filter label input:focus-visible {
        outline: none;
    }

    .dataTables_info {
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        transform: translateX(5px);
    }

    .dataTables_paginate {
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .dataTables_paginate span .current {
        background: #e9f6f1 !important;
        border-radius: 10px !important;
        border: none !important;
    }

    .dataTables_length {
        font-weight: bold;
    }

    .cst-margin-space {
        margin-top: 100px;
    }

    .pagination {
        display: none;
    }

    .update-point-btn {
        font-size: 14px;
    }

    .hid {
        display: none;
    }

    .text-to-be {
        font-size: 14px;
    }

    /* css added by Anil */
    .modal-header {
        border-bottom: unset !important;
        align-items: start !important;
    }

    .modal-body-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    .modal-body p {
        font-size: 27px;
        text-align: center;
    }

    .main-heading {
        font-size: 34px;
        font-weight: bold;
    }

    .custom-btn {
        width: 80%;
        font-size: 20px;
        padding: 8px 40px;
    }

    .custom-btn1 {
        width: 80%;
        font-size: 20px;
        padding: 8px 16px;
    }

    .form-check {
        display: flex;
        justify-content: start;
        align-items: start;
        gap: 1rem;
    }

    .form-check-input {
        transform: scale(1.5);
        /* Increase size (1.5 = 150%) */
        margin-right: 8px;
        /* Add spacing */
    }

    .form-check label {
        font-size: 18px;
    }

    .modal-body .bankModal-paragraph {
        font-size: 15px;
        text-align: left;
    }

    .modal-body .bankModal-paragraph2 {
        font-size: 15px;
        font-weight: bold;
        color: grey;
        text-align: left;
    }

    .modal .modal-bank-detail-content {
        border-radius: 50px !important;
        padding: 30px 60px !important;
    }

    .modal .modal-bank-detail-content {
        border-radius: 50px !important;
        padding: 30px 60px !important;
    }

    .modal-header .modal-title {
        font-size: 29px;
    }

    .error {
        color: red;
    }

    .input-icon {
        position: absolute;
        right: 48px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        pointer-events: none;
    }

    #bankModal input {
        background-color: rgb(0, 0, 0, 0.13);
    }

    #ifscResult {
        max-height: 200px;
        /* adjust based on your modal height */
        overflow-y: auto;
        /* adds scroll if content is too long */
        word-wrap: break-word;
        /* ensures long text doesn’t overflow */
        white-space: normal;
        /* allows wrapping */
    }

    /* css added by Anil */

    @media only screen and (max-width: 990px) {

        .rpoints-edit {
            font-size: 8px;
        }

        .select-width {
            width: 100%;
        }

        .added-answer {
            text-align: start;
        }

        .earned-text {
            font-size: 13px;
        }

        .remaining-text {
            font-size: 13px;
        }

        .earned-points {
            border-right: 0px solid white;
        }

        .remaining-points {
            border-top: 1px solid white;
        }

        .update-point-btn {
            font-size: 5px;
        }

        .li-list-item-two {
            left: 55%;
        }

        .li-list-item-three {
            left: 110%;
        }

        .li-list-item-four {
            left: 156%;
        }

        .dataTables_info {
            display: none;
        }

        .dataTables_length {
            display: none;
        }

        .table-height-cst-row th {

            font-size: 5px;
        }

        .table-height-cst-row th p {
            scale: 1.3;
        }

        .table-height-cst-row td {

            font-size: 5px;
            vertical-align: middle;
            scale: 1.2;
        }

        .tab-sta-btn {

            height: 30px;
            width: 58px;
            border-radius: 5px;
            border: none;
            font-weight: 600;
            font-size: 10px;
        }


        .link-social {
            width: 90%;
        }

        .reed-options {
            font-size: 15px;
        }

        .points-cst-bottom {
            font-size: 14px;
            transform: translateX(-10px);
        }

        .ref-text {
            text-decoration: none;
            font-size: 13px;
        }

        .cst-status-final {
            font-size: 10px;
        }


        .cst-mid-li {
            transform: translateX(-5%)
        }

        .points-enter-sec {
            transform: translateX(0px);
        }

    }

    @media only screen and (min-width: 1000px) and (max-width: 1025px) {

        .text-to-be {
            font-size: 10px;
        }

    }
</style>
@endpush
@php

/* Parshant Sharma [22-08-2024] STARTS */

//$metricConversion = round(1/$countryPoints, 4);
$metricConversion = 1/$countryPoints;
//dd($metricConversion);

@endphp

@section('points_select','cst-active')
@section('content')

<!-- New -->

@php
if(isset($redeem_requests)){
$user_available_points = $userPoints['completed'] - $redeem_requests->redeem_points;
}else{
$user_available_points = $userPoints['completed'];
}
@endphp


<div class="row mt-5">

    <div class="col-12">

        <p class="h4 ms-2" style="font-weight: 600;">{{__('inpanel.redeem.index.title')}}</p>

    </div>

    @if($user->is_blacklist==0)

    <div class="col-12">

        <div class="row mt-4 ms-lg-2 me-lg-2 mb-lg-4 rounded shadow" style="background: #EFEDFF">



            <div class="col-12 col-lg-7 ps-lg-5 text-center text-lg-start">

                <p class="mb-0 mt-4 mt-lg-5 pt-2" style="font-size: 20px;">{{__('inpanel.redeem.index.total_points')}}</p>

                <p class="mb-0" style="font-weight: 700; font-size: 40px; color:#005A9A;">
                    {{__('inpanel.redeem.index.form_main_heading',['max_points' => $user_available_points])}}
                    @if($user_available_points*$metricConversion < 1)
                        <!-- Code Updated by Vikas -->
                        @php
                        $centsValue = round($user_available_points * $metricConversion * 100);
                        $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                        @endphp
                        ({{ $centsValue }} {{ __($currency) }})
                        <!-- End -->
                        @else
                        ({{$currencies['currency_logo']}}{{number_format($user_available_points*$metricConversion,2)}})
                        @endif
                </p>

                <small class="text-to-be">{{__('inpanel.redeem.index.thresh_points')}}</small>

                <span class="fw-bold pb-lg-5 d-lg-none text-to-be" style="font-size: 14px;">{{$threshold_point}} {{__('inpanel.redeem.index.points')}}</span>


                <p class="fw-bold d-none d-lg-block text-to-be">{{$threshold_point}} {{__('inpanel.redeem.index.points_var')}}</p>

                <p class="mt-3 mt-lg-0" style="font-weight:600; font-size:14px; color: #E18F06; cursor:pointer;" onclick="addHyperLink()">{{__('inpanel.redeem.index.points_alert')}}</p>
            </div>

            <div class="col-12 col-lg-5 bg-white rounded mt-4 mb-lg-4 shadow-sm points-enter-sec">

                @if( $userPoints['completed'] == $threshold_point || $userPoints['completed']>$threshold_point )

                @include('inpanel.includes.partials.redeem.redeem_form_unlocked')

                @else

                @include('inpanel.includes.partials.redeem.redeem_form_locked')

                @endif

            </div>


        </div>

    </div>

    @else

    <div class="row redeem-form">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                {{--<div class="ibox-title">
                                                <h5>{{__('inpanel.redeem.index.title')}}</h5>
            </div>--}}
            <div class="ibox-content">
                <p style="text-align:center;font-weight:800">{{__('inpanel.redeem.blacklist_err')}}</p>
            </div>
        </div>
    </div>
</div>

@endif

</div>

{{-- </div> --}}


@php

if (isset($_GET['tab'])){
$searched_tab = $_GET['tab'];
}

@endphp

<div class="row p-lg-3 mt-5 m-auto">


    <div class="col cst-bg-hot-survey bg-white shadow ms-1 me-1" style="border-radius: 8px;">

        <div class="row p-3 border-bottom li-tab-row cst-menu-tab-mob">


            <span class="lead filter-survey-li ps-2 pe-2 @php if(isset($searched_tab)){ if($searched_tab == 'status'){echo 'cst-survey-filter-active';} else{echo'';} } else{echo'cst-survey-filter-active';} @endphp" onclick="loadSurveyEss('My Points')">{{__('inpanel.redeem.index.nav_link_1')}}</span>

            <span class="lead filter-survey-li ps-2 pe-2 li-list-item-two" onclick="loadSurveyEss('Redemption History')">{{__('inpanel.redeem.index.nav_link_2')}}</span>

            <span class="lead filter-survey-li li-list-item-three ps-2 pe-2 @php if(isset($searched_tab)){ if($searched_tab == 'p-history'){echo 'cst-survey-filter-active';} else{echo'';} } else{echo'';} @endphp" onclick="loadSurveyEss('Points History')">{{__('inpanel.redeem.index.nav_link_3')}}</span>

            <span class="lead filter-survey-li li-list-item-four ps-2 pe-2"><a href="{{route('frontend.cms.rewards')}}" target="_blank" style="text-decoration: none;  color: #999999; ">{{__('inpanel.redeem.index.nav_link_4')}}</a></span>

        </div>




        <div id="filter-content-survey" class="@php if(isset($searched_tab)){ if($searched_tab == 'status'){echo '';}else{echo'hid';} } @endphp" data-sr="My Points">

            <div class="row mt-3 text-center">


                <div class="col">
                    @if($redeem_requests)

                    <table class="table border" id="table_id_sh" style="overflow:hidden">

                        <thead>


                            <tr class="table-height-cst-row">
                                <th scope="col">
                                    <p style="transform: translateY(6px);">ID</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c1')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c2')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c3')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c4')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c5')}}</p>
                                </th>
                            </tr>

                        </thead>


                        <tbody>



                            <tr class="table-height-cst-row">
                                <td scope="row" class="fw-bold">{{$redeem_requests->id}}</td>

                                <td class="fw-bold"><span id="r_points">{{$redeem_requests->redeem_points}}</span>
                                    <!-- <input type="text" id="r_points_edit" max="{{$userPoints['completed']}}" value="{{$userPoints['completed']}}" style="width: 100%;" name="r_points_edit" class="form-control rpoints-edit hid" > -->
                                </td>
                                @php
                                $user=\Auth::user();

                                $reminder_count = '';
                                $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->created_at)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                if($redeem_requests->approve!=''){
                                $approve = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->approve)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                }
                                if($redeem_requests->ribbon_notified!=''){
                                $ribbon_notified = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->ribbon_notified)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                }
                                if($redeem_requests->coupon_sent!=''){
                                $coupon_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->coupon_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                }
                                if($redeem_requests->coupon_redeemed!=''){
                                $coupon_redeemed = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->coupon_redeemed)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                }
                                if($redeem_requests->reminder_sent!=''){
                                $reminder_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem_requests->reminder_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                }
                                if($redeem_requests->reminder_count == 1){
                                $reminder_count = __('inpanel.redeem.reminder_count.first');
                                }else if($redeem_requests->reminder_count == 2){
                                $reminder_count = __('inpanel.redeem.reminder_count.second');
                                }else if($redeem_requests->reminder_count == 3){
                                $reminder_count = __('inpanel.redeem.reminder_count.third');
                                }
                                @endphp
                                <td class="fw-bold"><span id="modifiedAmount">
                                        @if($redeemValue < 1)
                                            {{$redeemValue*100}} {{__('inpanel.dashboard.cents')}}
                                            @else
                                            {{$redeemValue}}
                                            @endif
                                            </span>

                                            <input type="text" id="r_points_edit" max="{{number_format($userPoints['completed']/$countryPoints,2)}}" value="{{ number_format((float) preg_replace('/[^0-9.]/', '', $redeemValue), 0, '.', '') }}" style="width: 100%;" name="r_points_edit" class="form-control rpoints-edit hid" onkeypress="return isNumber(event)">
                                </td>

                                <td class="fw-bold">@if($redeem_requests->created_at) {{--$redeem_requests->created_at--}}{{$updatedDate}} {{-- $redeem_requests->created_at--}} @else -- @endif</td>

                                @if($redeem_requests->show_status === 'Redemption Requested')
                                <td class="fw-bold">
                                    <p style="background:#fdeef0; font-weight: 600;" class="p-2 m-0 rounded">{{__('inpanel.redeem.index.status_1')}} @if($redeem_requests->reminder_count!='' && $redeem_requests->status=='pending') {{$reminder_count}} {{__('inpanel.redeem.index.reminder_sent')}}@endif</p>
                                </td>
                                @endif

                                @if($redeem_requests->show_status === '<b style="color:green;">Redemption Approved</b>')
                                <td class="fw-bold">
                                    <p style="background:#e9f6f1; font-weight: 600;" class="p-2 m-0 rounded">{{__('inpanel.redeem.index.status_2')}} @if($redeem_requests->reminder_count!='' && $redeem_requests->status=='pending') {{$reminder_count}} {{__('inpanel.redeem.index.reminder_sent')}}@endif</p>
                                </td>
                                @endif

                                @if($redeem_requests->show_status === 'Redemption Process Started')
                                <td class="fw-bold">
                                    <p style="background:#fff6e7; font-weight: 600;" class="p-2 m-0 rounded">{{__('inpanel.redeem.index.status_3')}} @if($redeem_requests->reminder_count!='' && $redeem_requests->status=='pending') {{$reminder_count}} {{__('inpanel.redeem.index.reminder_sent')}}@endif</p>
                                </td>
                                @endif

                                @if($redeem_requests->show_status === 'Voucher sent by Rybbon on your email')
                                <td class="fw-bold">
                                    <p style="background:#f8bbc1; font-weight: 600;" class="p-2 m-0 rounded">{{__('inpanel.redeem.index.status_4')}} @if($redeem_requests->reminder_count!='' && $redeem_requests->status=='pending') {{$reminder_count}} {{__('inpanel.redeem.index.reminder_sent')}}@endif</p>
                                </td>
                                @endif
                                @if($redeem_requests->show_status === 'Redemption Requested')
                                <td class="lastDiv">
                                    <input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-block ps-lg-4 pe-lg-4 pt-1 pb-1 pt-lg-2 pb-lg-2 update-point-btn" value="{{__('inpanel.redeem.index.cancel')}}" id="cancel" name="cancel" style="border: 1px solid #DDDDDD; font-weight:600;">
                                    <input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-block ps-lg-4 pe-lg-4 text-light pt-1 pb-1 pt-lg-2 pb-lg-2 mt-lg-0 update-point-btn" value="{{__('inpanel.redeem.index.modify')}}" id="modifyId" name="modifyId" style="font-weight:600; background: #0d6efd;">
                                    <input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-block ps-lg-4 pe-lg-4 text-light pt-1 pb-1 pt-lg-2 pb-lg-2 update-point-btn review-btn" id="review" value="{{__('inpanel.redeem.index.review')}}" name="save" style="font-weight:600; background: #0d6efd; display:none;">
                                </td>

                                @else

                                <td> - </td>

                                @endif

                            </tr>

                            @else

                            <div class="row text-center">
                                <div class="col mb-3">

                                    <small class="mt-3 mb-3">{{__('inpanel.survey.index.no_request_point')}}</small>

                                </div>
                            </div>

                            @endif

                        </tbody>
                    </table>


                </div>


            </div>


        </div>


        <!--sepration-->




        <div id="filter-content-survey" class="hid" data-sr="Redemption History">

            <div class="row  mt-3 text-center">


                <div class="col">


                    <table class="table border" id="table_id_sh_2" style="overflow:hidden">

                        <thead>

                            <tr class="table-height-cst-row">
                                <th scope="col">
                                    <p style="transform: translateY(6px);">ID</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c1')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c2')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_c3')}}</p>
                                </th>
                                <th scope="col">
                                    <p style="transform: translateY(6px);">{{__('inpanel.redeem.index.index_table_rs')}}</p>
                                </th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($redeem_history as $redeem)
                            @php
                            $user=\Auth::user();

                            if($redeem->approve!=''){
                            $approve = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->approve)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                            }
                            if($redeem->coupon_sent!=''){
                            $coupon_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->coupon_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                            }
                            if($redeem->ribbon_notified!=''){
                            $ribbon_notified = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->ribbon_notified)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                            }
                            if($redeem->coupon_redeemed!=''){
                            $coupon_redeemed = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->coupon_redeemed)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                            }
                            if($redeem->reminder_sent!=''){
                            $reminder_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->reminder_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                            }

                            @endphp

                            @if($redeem->status == 'completed' || $redeem->status == 'lapsed')

                            <tr class="table-height-cst-row">
                                <td scope="row" class="fw-bold">{{$redeem->id}}</td>
                                <td class="fw-bold">{{$redeem->redeem_points}}</td>
                                <!--<td class="fw-bold">
                                                            @if(($redeem->redeem_points/1000) < 1)
                                                            {{($redeem->redeem_points/1000)*100}} {{__('inpanel.dashboard.cents')}}
                                                            @else
                                                            {{$redeem->redeem_points/1000}}
                                                            @endif
                                                        </td>-->

                                <td class="fw-bold">

                                    @if(($redeem->redeem_points*$metricConversion) < 1)
                                        @php
                                        $currency=($redeem->redeem_points*100*$metricConversion > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                        @endphp
                                        ({{number_format($redeem->redeem_points*100*$metricConversion,2)}} {{__($currency)}})
                                        @else
                                        {{number_format($redeem->redeem_points*$metricConversion,2)}}
                                        @endif

                                </td>

                                <td class="fw-bold">@if($redeem->created_at) {{--$redeem->created_at--}}{{$redeem->created_at->setTimezone(auth()->user()->timezone)->format('m/d/Y H:i:s') }} @else '--' @endif</td>
                                <td class="fw-bold">
                                    <span style="background:#e9f6f1; font-weight: 600;" class="p-2 rounded capitalize">

                                        @if($redeem->status == 'completed'){{__('inpanel.redeem.index.status_5')}} @else {{__('inpanel.redeem.index.status_6')}} @endif @if($redeem->reminder_count!='' && $redeem->status=='pending'){{$redeem->reminder_count}}{{__('inpanel.redeem.index.reminder_sent')}}@endif

                                    </span>
                                </td>
                            </tr>

                            @endif

                            @endforeach

                        </tbody>
                    </table>


                </div>


            </div>


        </div>



        <!--sepration-->




        <div id="filter-content-survey" class="@php if(isset($searched_tab)){ if($searched_tab == 'p-history'){echo '';}else{echo'hid';} }else{echo'hid';} @endphp" data-sr="Points History">


            <div class="row mt-lg-4">

                <div class="col-12 col-lg-5 order-lg-last">

                    <div class="row mt-lg-4 ps-4 pe-4 rounded me-lg-3" style="background:#FBFBFB">

                        <div class="col-12 rounded mt-4 ps-5 pt-4 pb-4" style="background: #EFEDFF;">

                            <p class="lead mb-0 mt-3"> {{__('inpanel.rewards.index.total_points')}} </p>
                            <p style="font-size: 30px; font-weight: 700; color:#005A9A">
                                {{__('inpanel.redeem.index.form_main_heading',['max_points' => $user_available_points])}}
                                @if($user_available_points*$metricConversion < 1)
                                    <!-- Code Updated by Vikas -->
                                    @php
                                    $centsValue = round($user_available_points * $metricConversion * 100);
                                    $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                    @endphp
                                    ({{ $centsValue }} {{ __($currency) }})
                                    <!-- End -->
                                    @else

                                    ({{$currencies['currency_logo']}}{{number_format($user_available_points*$metricConversion,2)}})
                                    @endif
                            </p>

                            {{--<p style="font-size: 30px; font-weight: 700; color:#005A9A">

            @if($redeem_requests)
            {{$redeem_requests->redeem_points + ($count_completed_assignments*1000)}}
                            @if($redeemValue < 1)
                                @php
                                $currency=($redeemValue*100> 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                @endphp
                                ({{number_format($redeemValue*100,2)}} {{__($currency)}})
                                @else
                                ({{$currencies['currency_logo']}}{{$redeemValue}})
                                @endif
                                @else
                                @if($count_completed_assignments > 0)
                                @if($count_completed_assignments < 1)
                                    @else
                                    @endif
                                    @else
                                    @php
                                    $currency=$currencies['currency_denom_singular'];
                                    @endphp
                                    (0 {{__($currency)}})
                                    @endif
                                    @endif

                                    </p>--}}
                        </div>
                        <div class="col-12 rounded mt-4 mb-4 ps-5 pt-4 pb-4" style="background: #FFF6E7;">

                            <p class="lead mb-0 mt-3"> {{__('inpanel.rewards.index.pending_points')}}</p>
                            <p style="font-size: 30px; font-weight: 700; color:#005A9A">
                                @if($redeem_requests)
                                @php
                                $totalPoints = $redeem_requests->redeem_points + ($count_completed_assignments*1000) + $pendingReferralPoints;
                                $totalAmount = $totalPoints / $countryPoints;
                                @endphp

                                {{$totalPoints}}
                                @if($totalAmount < 1)
                                    @php
                                    $currency=($totalAmount*100> 1) ? $currencies['currency_logo'] : $currencies['currency_denom_singular'];
                                    @endphp
                                    ({{number_format($totalAmount*100,2)}} {{__($currency)}})
                                @else
                                    ({{$currencies['currency_logo']}}{{number_format($totalAmount,2)}})
                                @endif
                                    @else
                                        @if($count_completed_assignments > 0)
                                            @if($count_completed_assignments < 1)
                                    
                                                @php
                                                $calculate = $count_completed_assignments*1000;
                                                $formattedCal =number_format($calculate/$countryPoints,2);
                                                $currency=($formattedCal>1) ? $currencies['currency_logo'] : $currencies['currency_denom_plural'];
                                                @endphp
                                                @if($user->country=='IN')
                                                {{$count_completed_assignments*1000 + $pendingReferralPoints}} ({{__($currency)}}{{number_format(($count_completed_assignments*1000 + $pendingReferralPoints)/$countryPoints,2)}})
                                                @else
                                                {{$count_completed_assignments*1000 + $pendingReferralPoints}} ({{round(($count_completed_assignments*1000  + $pendingReferralPoints)*$metricConversion * 100)}} {{__($currency)}}) 
                                                @endif
                                            @else 
                                                {{$count_completed_assignments*1000 + $pendingReferralPoints}} ({{$currencies['currency_logo']}}{{number_format(($count_completed_assignments*1000 + $pendingReferralPoints)/$countryPoints,2)}})
                                            @endif
                                        @else
                                            @php
                                            $currency = $currencies['currency_denom_singular'];
                                            @endphp
                                            @if($pendingReferralPoints > 0)
                                                {{$pendingReferralPoints}} ({{$currencies['currency_logo']}}{{number_format($pendingReferralPoints/$countryPoints, 2)}})
                                                @else
                                                (0 {{__($currency)}})
                                            @endif

                                        @endif
                                        @endif
                            </p>
                        </div>

                    </div>

                </div>


                <div class="col-12 col-lg-7 mt-3 mt-lg-4 order-lg-first">

                    <div class="pe-4 pe-lg-5 ps-4 pb-4 bg-white" style="border-radius: 10px;">

                        <div class="row">

                            <div class="col">
                                <p class="lead" style="font-weight:600">{{__('inpanel.rewards.index.heading')}}</p>
                            </div>


                        </div>

                        <hr class="mt-0 mb-4">

                        @php
                        $count = 0;
                        $counter = 0;
                        @endphp

                        @if(!empty($userActivities))
                        <ul style="list-style-type: none; position: relative;" class="ms-0 ps-0 cst-ul">
                            @foreach($userActivities as $key => $activity)
                            <li class="mb-4 cst-clock d-flex gap-2" style="font-size: 13px">
                                <img src="img/clock img.png" alt="" class="me-1 position-relative" style="height:35px;width:35px;">
                                @php
                                $jsonData = json_decode($activity->properties);
                                $descriptionData = $activity->description;

                                if(isset($jsonData->survey_code)) {
                                $surveycode = $jsonData->survey_code;
                                $descriptionData = trans($activity->description, ['code' => $surveycode]);
                                } else {
                                $descriptionData = trans($activity->description);
                                }

                                if(isset($jsonData->date)){
                                $date = \Carbon\Carbon::parse($jsonData->date);

                                $formatted = $date->formatLocalized('%B, %Y');;
                                $descriptionData = str_replace(':month_year', $formatted, $descriptionData);
                                }


                                @endphp

                                <div class="d-flex flex-column gap-1">
                                    <span class="fw-bold">
                                        @if (str_contains($descriptionData, 'Invite') || str_contains($descriptionData, 'parrainage') || str_contains($descriptionData, 'attente') ||str_contains($descriptionData, 'invitación') ||str_contains($descriptionData, 'Invitar'))
                                        @if(!empty(@$userrefer[$user_id][$count]) || !empty(@$userrefer[$user_id][$counter]))
                                        @if (str_contains($descriptionData, 'Approved')|| str_contains($descriptionData, 'crédit') || str_contains($descriptionData, 'aprobados'))

                                        {{$descriptionData}} {{@$userrefer[$user_id][$count]}}

                                        @php $count++; @endphp
                                        @else
                                        {{$descriptionData}} {{@$userrefer[$user_id][$counter]}}
                                        @php $counter++; @endphp
                                        @endif

                                        @endif
                                        @else
                                        @php

                                        if(str_contains($descriptionData,'campaign_incentive_points')){
                                        $descriptionData = __('inpanel.rewards.index.incentive_points');
                                        }
                                        @endphp
                                        {{$descriptionData}}
                                        @endif

                                        @if(!$activity->properties->isEmpty())
                                        @php
                                        $points = json_decode($activity->properties);
                                        @endphp
                                        @if($points->points * $metricConversion < 1)
                                            <!-- Code updated by Vikas -->
                                            @php
                                            $centsValue = round($points->points * $metricConversion * 100);
                                            $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                            @endphp
                                            <p class=""><strong>{{ $points->points }} ({{ $centsValue }} {{ __($currency) }})</strong></p>
                                            <!-- End -->
                                            @else
                                            <p class=""><strong>{{$points->points}} ({{ $currencies['currency_logo']}}{{number_format($points->points/$countryPoints,2)}})</strong></p>
                                            @endif
                                            @endif


                                    </span>
                                    <p class="" style="transform: translateY(-7px); opacity:0.5; font-size: 14px;">{{$activity->created_at->diffForHumans()}}</p>
                                </div>
                            </li>
                            @endforeach
                            @if(!empty($extraBonus))
                            @foreach($extraBonus as $extraBonu)
                            <li>
                                <img src="img/clock img.png" alt="" class="me-1 position-relative">
                                <span class="fw-bold" style="font-size: smaller;">
                                    {{__('Extra Bonus')}}({{$extraBonu->source}})
                                    <span class="fw-bold">
                                        @php
                                        $currency = ($extraBonu->point*100*$metricConversion > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                        @endphp
                                        <p class="ms-5"><strong>{{$extraBonu->point}} ({{number_format($extraBonu->point*100*$metricConversion,2)}} {{__($currency)}})</strong></p>

                                    </span>

                                </span>
                                <p class="ms-5" style="transform: translateY(-7px); opacity:0.5; font-size: 14px;">
                                    {{ \Carbon\Carbon::parse($extraBonu->created_at)->diffForHumans() }}
                                </p>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                        @else
                        {{__('inpanel.rewards.index.points')}}
                        @endif

                    </div>




                </div>

            </div>

        </div>



    </div>
    <!-- Anil modal added -->
    <div class="modal fade" id="selectTransferMethod" aria-hidden="true" aria-labelledby="selectTransferMethodLabel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 px-4 d-flex justify-content-between align-items-center">
                    <span class="main-heading flex-grow-1 text-center m-0">{{__('inpanel.bank_messages.select_transfer_method')}}</span>
                    <button type="button" class="btn-close ms-auto closeBankModalBtn" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body-content">
                        <p class="select-method">{{__('inpanel.bank_messages.select_prefered_method')}}</p>
                        <button class="custom-btn btn btn-primary direct-bank-transfer">{{__('inpanel.bank_messages.direct_bank_transfer')}}</button>
                        <button class="custom-btn1 btn btn-outline-primary redeem-gift-btn">{{__('inpanel.bank_messages.gift_card_transfer')}}</button>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="defaultMethod">
                            <label class="form-check-label" for="defaultMethod">
                                {{__('inpanel.bank_messages.default_payment')}}
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bankDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-bank-detail-content">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">{{__('inpanel.bank_messages.enter_bank_detail')}}</h5>
                    <button type="button" class="btn-close mt-2" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="post" action="#" id="bankForm">
                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.account_holder')}}</label>
                            <input type="text" class="form-control" name="account_holder" placeholder="Enter account holder name">
                            <span id="error-account-holder" class="error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.account_number')}}</label>
                            <input type="text" class="form-control" id="accountNumber" placeholder="************">
                            <input type="hidden" name="account_number" id="hiddenAccountNumber">
                            <span id="error-account-number" class="error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.re_confirm_account')}}</label>
                            <input type="text" class="form-control" name="account_number_confirmation" placeholder="Re-enter account number" oncopy="return false" onpaste="return false" oncut="return false">
                            <span id="error-account-confirm" class="error"></span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label">
                                {{ __('inpanel.bank_messages.ifsc_code') }}
                                <small class="text-muted">({{ __('inpanel.bank_messages.verify_ifsc') }})</small>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ifsc_code" id="ifsc" placeholder="Enter IFSC Code">
                                <button class="btn btn-outline-secondary" id="searchIfsc" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                                <span id="ifscStatus" class="input-icon d-none"></span>
                            </div>
                            <span id="error-ifsc" class="error"></span>
                            <div id="ifscResult" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.account_type')}}</label>
                            <select class="form-select" name="account_type">
                                <option value="">{{__('inpanel.bank_messages.select_account_type')}}</option>
                                <option value="savings">{{__('inpanel.bank_messages.savings')}}</option>
                                <option value="current">{{__('inpanel.bank_messages.current')}}</option>
                            </select>
                            <span id="error-account-type" class="error"></span>
                        </div>
                        <p class="bankModal-paragraph">{{__('inpanel.bank_messages.confidential_message')}}</p>
                        <p class="bankModal-paragraph2">{{__('inpanel.bank_messages.confidential_message2')}}</p>

                        <button type="submit" class="btn btn-primary w-100 btn-submit py-3">{{__('inpanel.bank_messages.submit')}}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-bank-detail-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="bankModalLabel">{{__('inpanel.bank_messages.re_confirm_account')}}</h5>
                    <button type="button" class="btn-close mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('inpanel.redeem.redeem.bankDetails')}}" method="POST" id="bankdetails">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.account_holder')}}</label>
                            <input type="text" class="form-control" name="account_holder" value="" id="ver_account_holder" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.account_number')}}</label>
                            <input type="text" class="form-control" value="" name="account_number" id="ver_account_number" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.ifsc_code')}}</label>
                            <input type="text" class="form-control" value="" name="ifsc_code" id="ver_ifsc" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('inpanel.bank_messages.account_type')}}</label>
                            <input type="text" class="form-control" value="" name="account_type" id="ver_account_type" readonly>
                        </div>

                        <p class="bankModal-paragraph">{{__('inpanel.bank_messages.confidential_message')}}</p>
                        <p class="bankModal-paragraph2">{{__('inpanel.bank_messages.confidential_message2')}}</p>
                        <input type="hidden" name="bank_name" id="bank_name">
                        <input type="hidden" name="branch_name" id="branch_name">
                        <input type="hidden" name="branch_address" id="branch_address">
                        <input type="hidden" name="ifsc_verified" id="ifsc_verified" value="0">
                        <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                        <input type="hidden" name="action_id" id="action_id" value="0">
                        <input type="hidden" name="payment_default_status" class="payment_default_status" value="0">
                        <input type="hidden" name="is_default" class="is_default" value="0">
                        <input type="hidden" name="bank_detail_only" class="bank_detail_only" value="0">
                        <input type="hidden" name="request_points" id="requested_points" value="">

                    </form>
                </div>

                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-primary px-4 edit_bank_details">{{__('inpanel.bank_messages.edit')}}</button>
                    <button type="button" class="btn btn-primary px-4 verifed_bank_detail_submit">{{__('inpanel.bank_messages.verify')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bankMethodUpdate" aria-hidden="true" aria-labelledby="bankMethodUpdateLabel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 px-4 d-flex justify-content-between align-items-center">
                    <span class="main-heading flex-grow-1 text-center m-0">{{__('inpanel.bank_messages.select_transfer_method')}}</span>
                    <button type="button" class="btn-close ms-auto closeBankModalBtn" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body-content">
                        <p class="select-method">{{__('inpanel.bank_messages.select_prefered_method')}}</p>
                        <button class="custom-btn btn {{ $payment_method_default == 2 ? 'btn-primary' : 'btn-outline-primary' }} bank_transfer_method">{{__('inpanel.bank_messages.direct_bank_transfer')}}</button>
                        <button class="custom-btn1 btn {{ $payment_method_default == 1 ? 'btn-primary' : 'btn-outline-primary' }} redeem_gift_method">{{__('inpanel.bank_messages.gift_card_transfer')}}</button>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="defaultMethod_transfer" {{ $is_default == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="defaultMethod_transfer">
                                {{__('inpanel.bank_messages.default_payment')}}
                            </label>
                        </div>
                        <form action="{{route('inpanel.redeem.redeem.bankMethodUpdate')}}" method="POST" id="updateBankDetailsMethod">
                            @csrf
                            <input type="hidden" name="payment_method" class="payment_method" value="{{$payment_method_default}}">
                            <input type="hidden" name="transfer_default_status" class="transfer_default_status" value="{{$is_default}}">
                            <input type="hidden" name="is_default" class="is_default" value="{{$is_default}}">
                            <input type="hidden" name="user_id" class="user_id" value="{{$user->id}}">
                        </form>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="custom-btn btn btn-primary px-4 update_transfer_method">{{__('inpanel.bank_messages.update')}}</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Anil modal added End -->

</div>


<!-- New -->

@endsection

@push('after-scripts')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<script>
    // data table

    // $(document)
    // .ready(function () {
    //     $('#table_id_sh').DataTable();

    // });

    var cl_locale = @php echo json_encode($country_lang);
    @endphp;

    if (cl_locale == "en_US") {
        var url_lang = '';
    } else if (cl_locale == "es_US") {
        var url_lang = '//cdn.datatables.net/plug-ins/2.1.0/i18n/es-ES.json';;
    } else if (cl_locale == "fr_CA") {
        var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json';;
    } else {
        var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/en-US.json';
    }

    $(document)
        .ready(function() {
            $('#table_id_sh_2').DataTable({
                language: {
                    url: url_lang,
                    lengthMenu: "{{ __('inpanel.dataTable.lengthMenu') }}",
                    zeroRecords: "{{ __('inpanel.dataTable.zeroRecords') }}",
                    info: "{{ __('inpanel.dataTable.info') }}",
                    infoEmpty: "{{ __('inpanel.dataTable.infoEmpty') }}",
                    infoFiltered: "{{ __('inpanel.dataTable.infoFiltered') }}",
                    search: "{{ __('inpanel.dataTable.search') }}",
                    paginate: {
                        first: "{{ __('inpanel.dataTable.paginate.first') }}",
                        last: "{{ __('inpanel.dataTable.paginate.last') }}",
                        next: "{{ __('inpanel.dataTable.paginate.next') }}",
                        previous: "{{ __('inpanel.dataTable.paginate.previous') }}"
                    }
                }
            });
            $('#table_id_sh_2').on('page.dt', function() {
                $('html, body').animate({
                    scrollTop: $("#table_id_sh_2").offset().top - 150
                }, 400);
            });
        });

    $(document).ready(function() {
        let d_data = document.querySelectorAll('#filter-content-survey');
        let fil = document.querySelectorAll('.filter-survey-li ');
        @if(isset($history))
        let redirect_arr = @json($history);
        console.log("Arr: " + redirect_arr.length);
        if (redirect_arr.length > 0) {
            d_data[1].style.display = 'block';
            fil[1].classList.add('cst-survey-filter-active');
            d_data[0].style.display = 'none';
            fil[0].classList.remove('cst-survey-filter-active');
            d_data[2].style.display = 'none';
            fil[2].classList.remove('cst-survey-filter-active');
        }
        @endif
    });

    //
    function loadSurveyEss(str) {

        let s = str;

        let div_data = document.querySelectorAll('#filter-content-survey');

        let fil_m = document.querySelectorAll('.filter-survey-li ');


        if (str == 'My Points') {

            for (let i = 0; i < div_data.length; i++) {

                if (div_data[i].dataset.sr == 'My Points') {
                    div_data[i].style.display = 'block';
                    fil_m[0].classList.add('cst-survey-filter-active');

                } else {
                    div_data[i].style.display = 'none';
                    fil_m[1].classList.remove('cst-survey-filter-active');
                    fil_m[2].classList.remove('cst-survey-filter-active');

                }

            }

        } else if (str == 'Redemption History') {

            for (let i = 0; i < div_data.length; i++) {

                if (div_data[i].dataset.sr == 'Redemption History') {
                    div_data[i].style.display = 'block';
                    fil_m[1].classList.add('cst-survey-filter-active');

                } else {
                    div_data[i].style.display = 'none';
                    fil_m[0].classList.remove('cst-survey-filter-active');
                    fil_m[2].classList.remove('cst-survey-filter-active');
                }

            }


        } else if (str == 'Points History') {

            for (let i = 0; i < div_data.length; i++) {

                if (div_data[i].dataset.sr == 'Points History') {
                    div_data[i].style.display = 'block';
                    fil_m[2].classList.add('cst-survey-filter-active');

                } else {
                    div_data[i].style.display = 'none';
                    fil_m[0].classList.remove('cst-survey-filter-active');
                    fil_m[1].classList.remove('cst-survey-filter-active');
                }
            }
        }

    }
    //




    // points cal

    function calPoints(metricConv) {
        var entered_points = document.getElementById('custom').value;
        //var convertedValue = entered_points / 1000;
        var convertedValue = entered_points / metricConv;
        //document.getElementById('getPoints').value = Math.floor(convertedValue);
        document.getElementById('getPoints').value = floorToDecimals(convertedValue, 2);
    }


    function floorToDecimals(number, decimals) {
        const factor = Math.pow(10, decimals); // 10^decimals
        return Math.floor(number * factor) / factor;
    }

    //

    // add hyperlink

    function addHyperLink() {

        loadSurveyEss('Redemption History');

    }

    //



    //


    $(document).ready(function() {

        $('.cst-menu-tab-mob span').on('click', function() {
            var bar = $('.cst-menu-tab-mob');
            var barWidth = bar.width();
            var barScrollLeft = bar.scrollLeft();
            var barOffset = bar.offset().left;
            var tab = $(this).closest('span');
            var tabOffset = tab.offset().left;
            var tabWidth = tab.outerWidth();

            // alert (tabOffset + "<>" + tabWidth);



            var scrollOffset = (barWidth / 2) - (tabWidth / 2);
            var scrollTo;
            if (tabOffset < barOffset) {
                scrollTo = barScrollLeft - (barOffset - tabOffset) - scrollOffset;
            } else if (tabOffset + tabWidth > barOffset + barWidth) {
                scrollTo = barScrollLeft + tabOffset + tabWidth - (barOffset + barWidth) + scrollOffset;
            }

            bar.animate({
                scrollLeft: scrollTo
            }, 500);
        });

    });
</script>

<script>
    var cancelClicked = false;

    var mod = document.getElementById('modifyId');
    var cnclBtn = document.getElementById('cancel');
    var sbtBtn = document.getElementById('review');
    var action = document.getElementById('action_id');
    var r_points = document.getElementById('r_points');
    var modifiedAmount = document.getElementById('modifiedAmount');
    var r_points_edit = document.getElementById('r_points_edit');
    if (mod) {
        mod.addEventListener('click', () => {

            var cstBox = document.getElementById('custom');

            mod.style.display = 'none';
            cnclBtn.style.display = 'none';
            action.value = "1";
            sbtBtn.style.display = 'block';
            sbtBtn.style.marginLeft = '70px';
            // r_points.style.display = 'none';
            modifiedAmount.style.display = 'none';
            r_points_edit.style.display = 'block';
            //cstBox.removeAttribute('readonly');
        });
        cnclBtn.addEventListener('click', () => {
            cancelClicked = true;
            action.value = "2";
            //var request_points = document.getElementById('custom'); [20-09-2024]
            var request_points = document.getElementById('getPoints');

            request_points.value = r_points_edit.value;
            sbtBtn.click();
        });
    }
</script>


<script>
    $(document).ready(function() {
        $(":reset");
    });
    jQuery('.redemptionRequest_btn').on('click', function(e) {
        if (jQuery(this).attr('disabled')) {
            return false;
        }
        swal('Your redemption request submitted');
    });

    $('input:radio').on('change', function(e) {
        var val = $(this).val();
        console.log(val);
        if (val === 'custom') {
            //console.log('hiii');
            $('.custom_input').show();
            $('.custom_input').removeAttr("disabled");
        } else {
            console.log('hello');
            $('.custom_input').hide().attr("disabled", "disabled");
        }
    });
    /* $('#review').click(function(){
        if($('#r_points_edit').length){
            if($('#r_points_edit').is(':visible')){
                var request_points = parseInt($('#r_points_edit').val(), 10);
            }else{
                var request_points = parseInt($('#custom').val(), 10);
            }
        }else{
            var request_points = parseInt($('#custom').val(), 10);
        }
        
        var minRedeemedPoint = '{{ $threshold_point }}';
       
        var multiplepoint ='{{ $multiplypoint }}';
    //     alert(request_points);
    //    alert(minRedeemedPoint);
        if(request_points >= minRedeemedPoint){
        
            if(request_points%multiplepoint==0){
                
                $('input[name="request_points"]').val(request_points);
                $('#redeem_form').submit();
                
            }else{
                swal('{{__('inpanel.redeem.index.multiple_points')}} '+multiplepoint);
            }

        }else{
            $('#custom').val(request_points);
            swal('{{__('inpanel.redeem.index.less_points')}} '+ minRedeemedPoint);
        }
    }); [20-09-2024]*/


    /* Parshant Sharma [20-09-2024] Starts */

    $('.review-btn').click(function(e) {
        e.preventDefault();
        var request_points = parseInt($('#getPoints').val(), 10);
        var request_amount = parseInt($('#custom_curr').val(), 10);
        var countryPoints = '{{$countryPoints}}';
        var minRedeemedPoint = '{{ $threshold_point }}';
        var multiplepoint = '{{ $countryPoints }}';
        var countryLang = '{{ $country_lang }}';
        var countryParts = countryLang.split('_');
        if (isNaN(request_amount) || request_amount === '') {
            request_points = $('#r_points_edit').val() * countryPoints;
        }

        var requestPointCancel = request_points * countryPoints;
        var getMinCurr = minRedeemedPoint / countryPoints;
        var minCurr = Math.floor(getMinCurr);
        if (cancelClicked) {
            if (requestPointCancel >= minRedeemedPoint) {
                var $submitButton = $(this);
                $submitButton.prop('disabled', true);
                if (request_points % multiplepoint == 0) {
                    $('input[name="request_points"]').val(request_points);
                    $('#redeem_form').submit();
                } else {
                    swal("{{__('inpanel.redeem.index.multiple_points')}} " + multiplepoint);
                }

            }
        } else {

            if (isNaN(request_points) || request_points === '') {
                $('#validation-custom').remove();
                $('#custom_curr').after("<div id='validation-custom' style='color: red; font-size: 12px;'>{{__('inpanel.redeem.index.enter_amount_require')}}</div>");
            } else if (request_points === 0) {
                showPopup("{{__('inpanel.redeem.index.enter_valid_amount')}}");
            } else if (request_points >= minRedeemedPoint) {

                //var $submitButton = $(this);
                //$submitButton.prop('disabled', true);
                if (request_points % multiplepoint == 0) {
                    // if country is india user can select
                    $('input[name="request_points"]').val(request_points);
                    $('#redeem_form').submit();

                    // $('input[name="request_points"]').val(request_points);
                    // $('#redeem_form').submit();

                } else {
                    swal("{{__('inpanel.redeem.index.multiple_points')}} " + multiplepoint);
                }

            } else {
                $('#custom').val(request_points);
                //swal('{{__('inpanel.redeem.index.less_points')}} '+ minRedeemedPoint);
                //swal('You cannot Redeem less than '+ '{{$currencies['currency_logo']}}'+ minCurr);
                swal({
                    title: "",
                    text: "{{__('inpanel.redeem.index.redeem_less_amt')}} {{$currencies['currency_logo']}}" + minCurr,
                    confirmButtonText: "{{__('inpanel.redeem.index.ok_swal_btn')}}",
                }).then(function() {});
            }
        }
    });
    // code added by Anil
    $('.direct-bank-transfer').click(function() {
        if ($('#defaultMethod').is(':checked')) {
            $('.is_default').val('1');
        }
        $('.payment_default_status').val('2');
        $('#bankDetailModal').modal('show');
        $('#selectTransferMethod').modal('hide');
    })
    $('.redeem-gift-btn').click(function() {
        var request_points = parseInt($('#getPoints').val(), 10);
        var request_amount = parseInt($('#custom_curr').val(), 10);
        var countryPoints = '{{$countryPoints}}';
        if (isNaN(request_amount) || request_amount === '') {
            request_points = $('#r_points_edit').val() * countryPoints;
        }
        $('input[name="request_points"]').val(request_points);
        if ($('#defaultMethod').is(':checked')) {
            $('input[name="is_default"]').val('1');
        }
        $('input[name="payment_default_status"]').val('1');
        $('#redeem_form').submit();

    })
    $("#bankForm").on("submit", function(e) {
        e.preventDefault();
        let isValid = true;
        let accountHolder = $("[name='account_holder']").val().trim();
        let accountNumber = $("[name='account_number']").val().trim();
        let accountConfirm = $("[name='account_number_confirmation']").val().trim();
        let ifsc = $("[name='ifsc_code']").val().trim();
        let accountType = $("[name='account_type']").val();
        let ifsc_verified = $("#ifsc_verified").val();
        let expectedName = "{{ $user->full_name }}";
        $("small.text-danger").addClass("d-none").text("");

        if (accountHolder === "") {
            $("#error-account-holder").removeClass("d-none").text("{{ __('inpanel.bank_messages.account_holder_required') }}");
            isValid = false;
        } else if (accountHolder.toLowerCase() !== expectedName.toLowerCase()) {
            $("#error-account-holder").removeClass("d-none").text("{{ __('inpanel.bank_messages.account_name_valid') }}");
            isValid = false;
        }
        if (accountNumber === "") {
            $("#error-account-number").removeClass("d-none").text("{{ __('inpanel.bank_messages.account_number_required') }}");
            isValid = false;
        } else if (accountNumber.length < 6 || accountNumber.length > 18) {
            $("#error-account-number").removeClass("d-none").text("{{ __('inpanel.bank_messages.account_number_valid') }}");
            isValid = false;
        }
        if (accountConfirm === "") {
            $("#error-account-confirm").removeClass("d-none").text("{{ __('inpanel.bank_messages.account_number_confirm') }}");
            isValid = false;
        } else if (accountNumber !== accountConfirm) {
            $("#error-account-confirm").removeClass("d-none").text("{{ __('inpanel.bank_messages.account_number_notmatched') }}");
            isValid = false;
        }
        if (ifsc === "") {
            $("#error-ifsc").removeClass("d-none").text("{{ __('inpanel.bank_messages.ifsc_required') }}");
            isValid = false;
        } else if (ifsc.length !== 11) {
            $("#error-ifsc").removeClass("d-none").text("{{ __('inpanel.bank_messages.ifsc_valid') }}");
            isValid = false;
        } else if (ifsc_verified !== '1') {
            $("#error-ifsc").removeClass("d-none").text("{{ __('inpanel.bank_messages.ifsc_verify') }}");
            isValid = false;
        }
        if (accountType === "") {
            $("#error-account-type").removeClass("d-none").text("{{ __('inpanel.bank_messages.select_account_required') }}");
            isValid = false;
        }
        if (isValid) {
            $('#ver_account_holder').val(accountHolder);
            $('#ver_account_number').val(accountNumber);
            $('#ver_ifsc').val(ifsc);
            $('#ver_account_type').val(accountType);
            $('#bankDetailModal').modal('hide');
            $('#bankModal').modal('show');
        }
    });
    let actualValue = '';

    $('#accountNumber').on('focus', function() {
        $(this).val(actualValue);
    });

    $('#accountNumber').on('input', function() {
        actualValue = $(this).val();
        $('#hiddenAccountNumber').val(actualValue);
    });

    $('#accountNumber').on('blur', function() {
        if (actualValue) {
            $(this).val('*'.repeat(actualValue.length));
            $('#hiddenAccountNumber').val(actualValue);
        }
    });


    $('.edit_bank_details').click(function() {
        $('#bankDetailModal').modal('show');
        $('#bankModal').modal('hide');
        $("#bankForm button[type='submit']").prop("disabled", false);
    })
    $('.verifed_bank_detail_submit').click(function(e) {
        e.preventDefault();
        let request_points = parseInt($('#getPoints').val(), 10);
        let request_amount = parseInt($('#custom_curr').val(), 10);
        var countryPoints = '{{$countryPoints}}';
        if (isNaN(request_amount) || $('#custom_curr').val().trim() === '') {
            let rPoints = parseInt($('#r_points_edit').val(), 10) || 0;
            request_points = rPoints * countryPoints;
        }
        $('#requested_points').val(request_points);
        $('#bankdetails').submit();
    });


    $("#bankForm input, #bankForm select").on("keyup change", function() {
        let targetError = $(this).attr("name");
        if (targetError === "account_holder") {
            $("#error-account-holder").addClass("d-none").text("");
        } else if (targetError === "account_number") {
            $("#error-account-number").addClass("d-none").text("");
        } else if (targetError === "account_number_confirmation") {
            $("#error-account-confirm").addClass("d-none").text("");
        } else if (targetError === "ifsc_code") {
            $("#error-ifsc").addClass("d-none").text("");
        } else if (targetError === "account_type") {
            $("#error-account-type").addClass("d-none").text("");
        }
        $("#bankForm button[type='submit']").prop("disabled", false);
    });

    $("#searchIfsc").on("click", function() {
        var ifsc = $("#ifsc").val().trim().toUpperCase();

        // Reset status
        $("#ifscStatus").addClass("d-none").html("");

        if (!ifsc) {
            $("#ifscResult").html("<span style='color:red;'>{{__('inpanel.bank_messages.select_IFSC')}}</span>");
            return;
        }
        $("#bankForm button[type='submit']").prop("disabled", false);
        $.get("https://ifsc.razorpay.com/" + ifsc, function(res) {
            $("#ifscResult").html(
                "<b>Bank:</b>" + res.BANK + "<br>" +
                "<b>Branch:</b>" + res.BRANCH + "<br>" +
                "<b>Address:</b>" + res.ADDRESS
            );

            $("#ifscStatus")
                .removeClass("d-none")
                .html('<i class="fas fa-check-circle"></i> ')
                .css("color", "green");
            $('#bank_name').val(res.BANK);
            $('#branch_name').val(res.BRANCH);
            $('#branch_address').val(res.ADDRESS);
            $('#ifsc_verified').val(1);
            $("#error-ifsc").addClass("d-none").text("");
        }).fail(function() {
            $("#ifscResult").html("<span style='color:red;'>Invalid IFSC Code</span>");

            $("#ifscStatus")
                .removeClass("d-none")
                .html('<i class="fas fa-times-circle"></i>')
                .css("color", "red");
        });
    });
    $('.payment_method_change').click(function() {
        $('#bankMethodUpdate').modal('show');
    });

    $('.bank_transfer_method').click(function() {
        $('.bank_transfer_method')
            .removeClass('btn-outline-primary')
            .addClass('btn-primary');

        $('.redeem_gift_method')
            .removeClass('btn-primary')
            .addClass('btn-outline-primary');
        $('.payment_method').val('2');
        $('.payment_default_status').val('2');
        if ($('#defaultMethod_transfer').is(':checked')) {
            $('.is_default').val('1');
        }
        $('.bank_detail_only').val('1');
        $('#bankMethodUpdate').modal('hide');
        $('#bankDetailModal').modal('show');
    });

    // handle redeem gift card click
    $('.redeem_gift_method').click(function() {
        $('.redeem_gift_method')
            .removeClass('btn-outline-primary')
            .addClass('btn-primary');

        $('.bank_transfer_method')
            .removeClass('btn-primary')
            .addClass('btn-outline-primary');
        $('.payment_method').val('1');
        if ($('#defaultMethod_transfer').is(':checked')) {
            $('.is_default').val('1');
        }
        $('.transfer_default_status').val('1');

    });
    $('.payment_method_change').click(function() {
        $('#bankMethodUpdate').modal('show');
    });
    $('.update_transfer_method').click(function() {
        $('#updateBankDetailsMethod').submit();
    })

    $('#defaultMethod_transfer').on('change', function() {
        if ($(this).is(':checked')) {
            $('.is_default').val('1');
        } else {
            $('.is_default').val('0');
        }
    });

    $('#defaultMethod').on('change', function() {
        if ($(this).is(':checked')) {
            $('.is_default').val('1');
            $('input[name="is_default"]').val('1');

        } else {
            $('.is_default').val('0');
        }
    });
    $('.closeBankModalBtn').on('click', function() {
        setTimeout(function() {
            location.reload();
        }, 200);
    });
    // code added by Anil

    /* Parshant Sharma [20-09-2024] Ends */


    /* Parshant Sharma [17-09-2024] Starts */

    // function isNumber(evt) {
    //  evt = (evt) ? evt : window.event;
    //  var charCode = (evt.which) ? evt.which : evt.keyCode;

    //  // Access the input element
    //  //var inputElement = evt.target;
    //  //var inputValue = inputElement.value;

    //  // Check current input value and log it
    //  //console.log('Current value before key press:', inputValue);

    //  /* we will check  User available points */          

    //  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    //      return false;
    //  }
    //  return true;
    // }

    // $('#custom_curr').on('blur',function(e){

    //  var countryPoints = '{{$countryPoints}}';

    //  var currAmt = e.target.value;           
    //  console.log('CurrencyAmount :'+currAmt);

    //  /* minimum Currency to Redeem */
    //  var threshHold = '{{$threshold_point}}';
    //  console.log('threshHold:', threshHold);

    //  var getMinCurr = threshHold / countryPoints;
    //  var minCurr = Math.floor(getMinCurr);
    //  console.log('minCurr:', minCurr);


    //  /* Maximum Currency that can be Redeemed */
    //  var availablePoints = '{{$user_available_points}}';
    //  console.log('availablePoints:', availablePoints);

    //  var getMaxCurr = availablePoints / countryPoints;
    //  var maxCurr = Math.floor(getMaxCurr);
    //  console.log('maxCurr:', maxCurr);

    //  const currInput = document.getElementById('custom_curr');
    //  const pointsInput = document.getElementById('getPoints');

    //  if( currAmt < minCurr){

    //      swal({
    //          title: "",
    //          text: 'You cannot Redeem less than '+ '{{$currencies['currency_logo']}}'+ minCurr,
    //          type: "OK"
    //      }).then(function() {
    //          currInput.value = '';
    //          pointsInput.value = '';
    //      });

    //  }else if( currAmt > maxCurr){

    //      swal({
    //          title: "",
    //          text: 'You cannot Redeem more amount than '+ '{{$currencies['currency_logo']}}'+ maxCurr,
    //          type: "OK"
    //      }).then(function() {
    //          currInput.value = '';
    //          pointsInput.value = '';
    //      });

    //  }else{

    //      const convertedPoints = currAmt*countryPoints;

    //      $('#getPoints').val(convertedPoints);
    //  }


    // });

    /* Parshant Sharma [17-09-2024] Ends */

    /* Vikas Dhull [21-03-2025] Starts */
    function isNumber(evt) {

        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        // Allow only digits and control keys (like backspace)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function calculateLimits(countryPoints, threshHold, availablePoints) {
        const minCurr = Math.floor(threshHold / countryPoints);
        const maxCurr = Math.floor(availablePoints / countryPoints);
        return {
            minCurr,
            maxCurr
        };
    }

    function showPopup(message) {
        swal({
            title: "",
            text: message,
            confirmButtonText: "{{__('inpanel.redeem.index.ok_swal_btn')}}",
        }).then(function() {
            $('#custom_curr').val('');
            $('#getPoints').val('');
        });
    }

    function showValidationMessage(message) {
        // Add the validation message under the input field
        $('#validation-custom').remove();
        $('#custom_curr').after('<div id="validation-custom" style="color: red; font-size: 12px;">' + message + '</div>');
    }

    $('#custom_curr').on('blur', function(e) {
        let $redeemBtn = $('#review');
        $redeemBtn.prop('disabled', true);

        if (cancelClicked) {
            cancelClicked = false; // Reset flag after cancel
            return; // Do nothing if cancel was clicked
        }

        const countryPoints = parseFloat('{{$countryPoints}}');
        const threshHold = parseFloat('{{$threshold_point}}');
        const availablePoints = parseFloat('{{$user_available_points}}');
        const {
            minCurr,
            maxCurr
        } = calculateLimits(countryPoints, threshHold, availablePoints);

        const currAmt = parseFloat(e.target.value);

        var countryLang = '{{ $country_lang }}';
        var countryParts = countryLang.split('_');

        // Check if the amount is valid and within the allowed limits
        if (isNaN(currAmt) || currAmt === '') {
            showValidationMessage("{{__('inpanel.redeem.index.enter_amount_require')}}");
            return; // Stop further checks if empty or invalid
        }

        // Check if the entered amount is less than the minimum allowed
        if (currAmt < minCurr) {
            showPopup("{{__('inpanel.redeem.index.redeem_less_amt')}} {{$currencies['currency_logo']}}" + minCurr);
            return; // Stop further checks if less than minimum
        }

        // Check if the entered amount exceeds the maximum allowed
        if (currAmt > maxCurr) {
            let displayMaxCurr = (countryParts[countryParts.length - 1] === 'IN') ?
                Math.floor(maxCurr / 10) * 10 // Round down to the nearest multiple of 10 if country is IN
                :
                maxCurr;
            showPopup("{{__('inpanel.redeem.index.redeem_more_amt')}} {{$currencies['currency_logo']}}" + displayMaxCurr);
            return; // Stop further checks if more than maximum
        }

        // Check if the country is IN and the value is a multiple of 10
        if (countryParts[countryParts.length - 1] === 'IN' && currAmt % 10 !== 0) {
            swal({
                title: "{{__('inpanel.redeem.index.invalid_input')}}",
                text: "{{__('inpanel.redeem.index.redeem_multiple_valid')}}",
                icon: "error",
                confirmButtonText: "{{__('inpanel.redeem.index.ok_swal_btn')}}",
            }).then(function() {
                e.target.value = '';
                $('#getPoints').val('');
            });
            return;
        }
        $redeemBtn.prop('disabled', false);

        // If all checks pass, update the input field with the valid amount
        e.target.value = currAmt;
    });

    $('#r_points_edit').on('blur', function(e) {

        if (cancelClicked) {
            cancelClicked = false;
            return;
        }

        const countryPoints = parseFloat('{{$countryPoints}}');
        const threshHold = parseFloat('{{$threshold_point}}');
        const availablePoints = parseFloat('{{$user_available_points}}');

        const {
            minCurr,
            maxCurr
        } = calculateLimits(countryPoints, threshHold, availablePoints);
        var countryLang = '{{ $country_lang }}';
        var countryParts = countryLang.split('_');

        let currAmt = parseFloat(e.target.value);

        if (isNaN(currAmt) || currAmt === '') {
            currAmt = 0;
        }

        currAmt = Math.floor(currAmt);

        if (currAmt === 0) {
            showPopup("{{__('inpanel.redeem.index.enter_valid_amount')}}");
            return;
        }

        if (countryParts[countryParts.length - 1] === 'IN' && currAmt % 10 !== 0) {
            swal({
                title: "{{__('inpanel.redeem.index.invalid_input')}}",
                text: "{{__('inpanel.redeem.index.redeem_multiple_valid')}}",
                icon: "error",
                confirmButtonText: "{{__('inpanel.redeem.index.ok_swal_btn')}}",
            }).then(function() {
                e.target.value = '';
            });
            return;
        }

        e.target.value = currAmt;
    });



    // On keyup event, update points
    $('#custom_curr').on('keyup', function(e) {
        if (cancelClicked) {
            cancelClicked = false; // Reset flag after cancel
            return; // Do nothing if cancel was clicked
        }
        const countryPoints = parseFloat('{{$countryPoints}}');
        const threshHold = parseFloat('{{$threshold_point}}');
        const availablePoints = parseFloat('{{$user_available_points}}');
        const {
            minCurr,
            maxCurr
        } = calculateLimits(countryPoints, threshHold, availablePoints);
        const currAmt = parseFloat(e.target.value);

        const convertedPoints = currAmt * countryPoints;
        if (isNaN(currAmt) || currAmt === '') {
            $('#getPoints').val('');
            $('#validation-custom').remove();
            showValidationMessage("{{__('inpanel.redeem.index.enter_amount_require')}}");
        } else if (!isNaN(currAmt) || currAmt !== '') {
            $('#getPoints').val(convertedPoints);
            $('#validation-custom').remove();
        } else {
            $('#getPoints').val('');
        }
    });

    /* Vikas Dhull [21-03-2025] Ends */
</script>
@endpush