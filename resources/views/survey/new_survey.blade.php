@extends('inpanel.layouts.device')

@push('after-styles')

<link href="{{asset('css2/dashboard_style.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/css/plugins/c3/c3.min.css')}}" rel="stylesheet">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

 <!-- data table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <style type="text/css">
        /* css added by Vikas Starting*/
        body.modal-open {
            overflow: hidden;
        }

        #surveyCountryMismatchModal {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }

        .modal-content-country {
            position: relative;
            z-index: 10000; /* higher than backdrop if needed */
            background: #fff;
            margin: 10% auto;
            width: 90%;
            max-width: 400px;
            border-radius: 12px;
            text-align: center;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-content-country h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-content-country p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .modal-content-country button {
            padding: 10px 24px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-content-country button:hover {
            background-color: #0056b3;
        }
        /* Ending */

        #line_spc{
                border-left: 1px solid #ECECEC;
    display: inline-block;
    height: 357px !important;
    /* padding-left: 28px !important; */
    margin-left: 18px !important;
    position: absolute;
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
        select:focus {
            outline: none;
        }
    </style>

@endpush

@section('content')

@php
    $check_scroll = "false";
    if (isset($_GET['survey'])){
        $check_scroll = "true";
        $searched_survey = $_GET['survey'];
    }

	/* Parshant Sharma [22-08-2024] STARTS */

	//$metricConversion = round(1/$countryPoints, 4);
	$metricConversion = 1/$countryPoints;
	//dd($metricConversion);
					
@endphp






<!-- <div class="col-sm-12 col-xl-10 border-start pe-4 ps-4" style="background: #F5F5F5; overflow:hidden"> -->


    <!-- New -->




    <div class="row mt-5 mb-2">


        <div class="col">

            <p class="h4 ms-2" style="font-weight: 600;">{{__('inpanel.survey.index.heading_1')}}</p>

        </div>
        <div class="col text-end" id="clearFilter1">
            <span style="font-weight:600; margin-block-start: 20px;" >{{__('inpanel.dashboard.user.filter_by')}}</span>
            <span>
        <select id="hot_survey_options">
            <option hidden disabled selected>{{__('inpanel.dashboard.user.select')}}</option>
            <option value="1">{{__('inpanel.dashboard.user.survey_opt_1')}}</option>
            <option value="2">{{__('inpanel.dashboard.user.survey_opt_2')}}</option>
            <option value="3">{{__('inpanel.dashboard.user.survey_opt_3')}}</option>
        </select>
            </span>
        <span>
        <a id="clearFilter" style="display:none;" href="{{ route('inpanel.survey.index') }}">{{__('inpanel.dashboard.user.clear_filter')}}</a> 
        </span>
    </div>
 </div>


    <!-- ms-2 ms-lg-0 me-2 me-lg-0  -->

    <div class="row mt-1 p-lg-3">


        <div class="col cst-bg-hot-survey bg-white" style="border-radius: 10px;">

        @php

        if (isset($_GET['tab'])){
            $searched_tab = $_GET['tab'];
        }

        @endphp

            <div class="row p-3 border-bottom li-tab-row cst-menu-tab-mob">

                    <span class="lead filter-survey-li @php if(isset($searched_tab)){ if($searched_tab == 'live'){echo 'cst-survey-filter-active';} else{echo'';} } else{echo'cst-survey-filter-active';} @endphp" onclick="loadSurveyEss('live')">{{__('inpanel.survey.index.live_survey')}}</span>

                    <span class="lead filter-survey-li li-list-item-two @php if(isset($searched_tab)){ if($searched_tab == 'history'){echo 'cst-survey-filter-active';} else{echo'';} } else{echo'';} @endphp" onclick="loadSurveyEss('history')">{{__('inpanel.survey.index.survey_history')}}</span>

                    <span class="lead filter-survey-li li-list-item-three me-2 @php if(isset($searched_tab)){ if($searched_tab == 'expired'){echo 'cst-survey-filter-active';} else{echo'';} } else{echo'';} @endphp" onclick="loadSurveyEss('expired')">{{__('inpanel.survey.index.survey_expired')}}</span>

            </div>


            <div id="filter-content-survey" class="@php if(isset($searched_tab)){ if($searched_tab == 'live'){echo '';}else{echo'hid';} } @endphp" data-sr="live">

                @if(count($surveys) > 0)


                <div class="row text-end mt-3 pe-lg-3 ps-lg-3">

                    <div class="col">

                        <form action="{{route('inpanel.survey.index')}}" method="get" id="filterdata">

                        <span style="font-weight:600">{{__('inpanel.survey.index.sort_1')}} : </span>

                        <select name="sort" id="sort" class="cst-sort-btn">
                            <option value="dsc">{{__('inpanel.survey.index.dsc')}}</option>
                            <option value="asc" @if( isset($_GET['sort']) && $_GET['sort'] == 'asc') selected @endif>{{__('inpanel.survey.index.asc')}}</option>
                        </select>

                        <span><img src="images/sort-by.png" alt="img" style="transform:translateX(-30px)"></span>

                        </form>
                        

                    </div>

                </div>

            @endif    


                <div class="row pt-lg-3 pb-3 pe-lg-3 ps-lg-3" id="hot_survey_section">

                       

                        @if(count($surveys) == 0)

                        <div class="row text-center ms-2">

                            <div class="col mt-3 text-center">

                            <small>{{__('inpanel.survey.index.sub_heading')}}</small>

                            </div>

                        </div>
                        @endif


                            @if(!empty($surveys))

                                @foreach($surveys as $key=>$availableSurvey)

                                        @php

 
                                        if($key % 3 == 0 && $key != 0){

                                            echo "<div class='row mt-2 mb-2 d-none d-lg-block'>";

                                            echo    "<div class='col' style='margin-left:12px'>";

                                            echo      "<hr style='scale:1.02; opacity:0.1'>";

                                            echo    "</div>";

                                            echo "</div>"; 

                                        }

                                        @endphp


                                        <div class="col-12 col-lg-4 mt-3 mt-lg-0">

                                            <div id="sr{{$key}}" class="p-3 rounded bg-white cst-full-sr @php if(isset($searched_survey)){ if($searched_survey == $availableSurvey->apace_project_code) { echo 'scroll-to-this'; } } @endphp" @php if (isset($searched_survey)){ if($searched_survey == $availableSurvey->apace_project_code){ echo "style='border:2px solid #0d6efd'"; } }@endphp>


                                                <div class="row">

                                                    <div class="col">

                                                        <p class="h4 mb-0" style="font-weight: 600; color:#005A9A">{{$availableSurvey->points}}
                                                        {{__('inpanel.survey.index.column_2')}}</p>

                                                    </div>


                                                    <div class="col text-end">

                                                        <p class="fw-bold lead">
                                                            @if($availableSurvey->points*$metricConversion < 1)
																@php
                                                                    $centsValue = round($availableSurvey->points * $metricConversion * 100);
                                                                    $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                                                @endphp
                                                                {{ $centsValue }} {{ __($currency) }}
                                                            @else
                                                               @php echo $currencies['currency_logo']; @endphp {{number_format($availableSurvey->points*$metricConversion,2)}} 
                                                            @endif    
    
                                                        </p>

                                                    </div>

                                                </div>



                                                <div class="row" style="transform: translateY(-5px);">

                                                    <div class="col">

                                                        <p class="lead" style="font-weight:400">{{$availableSurvey->apace_project_code}}</p>

                                                    </div>

                                                </div>




                                                <div class="row">

                                                    <div class="col">

                                                        <span class="m-0 pb-2" style="font-size: 12px;">{{__('inpanel.survey.index.column_5')}}</span>

                                                        <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-weight: 500; font-size: 12px;"> {{$availableSurvey->loi}} min</span>

                                                    </div>


                                                    <div class="col text-end">
                                                            <a class="btn btn-primary btn-lg survey-btn" style="font-size: 17px;"
                                                                href="{{ route('inpanel.survey.execute.show', ['user_project_id' => $availableSurvey->id]) }}"
                                                                target="_blank">
                                                                @if($availableSurvey->status === 0)
                                                                    {{ __('inpanel.survey.index.link_take_survey_2') }}
                                                                @elseif($availableSurvey->status === null)
                                                                    {{ __('inpanel.survey.index.link_take_survey') }}
                                                                @endif
                                                            </a>
                                                  
                                                    </div>

                                                </div>


                                        <div class="row text-center">


                                            <div class="col-12 m-0 text-start p-0">

                                                        @php  
                                                        $temp_topic =  $availableSurvey->survey_name;
                                                        $use_topic = explode('-', $temp_topic);
                                                        @endphp
                                                        <p class="mt-3 mb-3 ms-2 type-element" style="font-size: 11px;" data-bs-toggle="tooltip"  data-bs-custom-class="custom-tooltip" data-bs-placement="bottom" data-bs-title="@php echo $use_topic[0]; @endphp">{{__('inpanel.survey.index.column_10')}} : @php echo $use_topic[0]; @endphp</p>

                                            </div>

                                            @php $count_total_taken_surveys = 0; @endphp

                                            @foreach($getAllUserTakenSurveys as $allsurveystaken) 

                                                @php

                                                if($allsurveystaken->apace_project_code == $availableSurvey->apace_project_code){
                                                    $count_total_taken_surveys++;
                                                }

                                                @endphp

                                            @endforeach

                                            <div class="col-12 m-0" style="@php if($count_total_taken_surveys < 1){ echo'visibility:hidden;'; }else{ echo''; } @endphp">

                                                        <p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;">@php echo $count_total_taken_surveys; @endphp {{__('inpanel.survey.index.column_11')}}</p>

                                                    </div>

                                                </div>


                                            </div>

                                        </div>





                                @endforeach

                                    {{-- @if(isset($_GET['sort'])) 
                                        {{$surveys->appends(['sort' => $_GET['sort']])->render()}}
                                    @else  
                                        {{$surveys->render()}}
                                    @endif --}}


                                    <!-- </div> -->
                                

                                
                                @else
                                <div class="row text-center">
                                    <div class="col">

                                    <small class="mt-3 mb-3">{{__('inpanel.survey.index.sub_heading')}}</small>

                                    </div>
                                </div>
                                @endif

                </div>

            </div>





            <!--sepration-->




            <div id="filter-content-survey" class="@php if(isset($searched_tab)){ if($searched_tab == 'history'){echo '';}else{echo'hid';} }else{echo'hid';} @endphp" data-sr="history">


                <div class="row text-end mt-3 mb-3 pe-lg-3 ps-lg-3">


                    <div class="col text-start">

                        <p class="mt-3" style="font-size: 14px;font-weight: 600;">{{__('inpanel.survey.history.showing')}} @php echo count($hsurveys); @endphp {{__('inpanel.survey.history.results')}}</p>

                    </div>


                </div>



                <div class="row text-center">


                    <div class="col table-responsive">
                        <table class="table border" id="table_id_sh" style="width:100%">

                            <thead>

                            @if(count($hsurveys)>0)

                                <tr class="table-height-cst-row">
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.history.column_2')}}<span
                                                class="d-none d-md-inline-block ms-2"><img
                                                    src="images/table-heading-icon.png" alt="img"></span></p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.history.column_3')}}</p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.index.column_6')}}</p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.history.column_5')}}</p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.index.column_7')}}</p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.history.column_4')}}</p>
                                    </th>
                                </tr>
                            
                                @endif
                            </thead>


                            <tbody>

                        
                            @if(count($hsurveys)>0)

                            @php

                            $statusColor = array(1 => '#E3FCCC', 0 => '#F2F2F2', 50 => '#CAFED9', 5 => '#f8bbc1', 4 => '#fff6e7', 3 => '#FDE9DF', 2 => '#fdeef0');
							//dd($hsurveys);
                            @endphp
                                    @foreach($hsurveys as $survey)
                                    @php
                                    $user=\Auth::user(); 
                                    $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $survey->updated_at)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                    @endphp                                    

                                <tr class="table-height-cst-row @php if(isset($searched_survey)){ if($searched_survey == $survey->apace_project_code) { echo 'scroll-to-this'; } } @endphp" @php if (isset($searched_survey)){ if($searched_survey == $survey->apace_project_code){ echo "style='background:#cee3f2'"; } }@endphp>
                                    <td scope="row" class="fw-bold">{{$survey->project->apace_project_code}}</td>
                                    <td class="fw-bold">{{$survey->points}}</td>
                                    <td class="fw-bold">
                                        @if($survey->points*$metricConversion < 1)
                                            <!-- Code Updated by Vikas -->
											@php
                                                $centsValue = round($survey->points * $metricConversion * 100);
                                                $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                            @endphp
                                            {{ $centsValue }} {{ __($currency) }}
                                            <!-- End -->
                                        @else
                                            {{number_format($survey->points*$metricConversion,2)}}
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ $survey->project->loi }}</td>
                                    <td class="fw-bold">{{--date('m/d/Y H:i:s',strtotime($survey->updated_at))--}}
                                              
                                              {{--date('Y-m-d H:i:s',strtotime("$survey->updated_at UTC"))--}}
                                              {{$updatedDate}}</td>


                                              
                                    <td> <button class="rounded ps-2 pe-2 pt-1 pb-1 cst-status-final" style="font-weight:600; scale:0.9; border:none; background: @php echo $statusColor[$survey->status];@endphp">@if($survey->status==1) {{__('inpanel.survey.history.status_1')}}  @elseif($survey->status==0){{__('inpanel.survey.history.status_2')}}  @elseif($survey->status==50) {{__('inpanel.survey.history.status_3')}} @elseif($survey->status==5) {{__('inpanel.survey.history.status_4')}} @else {{$status[$survey->status]}} @endif</button> 
                                </td>

                                </tr>
                                @endforeach
                                    
                                @else
                                <div class="row text-center">
                                    <div class="col">
                                        <p>{{__('inpanel.survey.history.no_history')}}</p>
                                    </div>
                                </div>
                                @endif



                            </tbody>
                        </table>

                        {{--$surveys->render()--}}


                    </div>


                </div>


            </div>


            <!--sepration 2-->

            <div id="filter-content-survey" class="@php if(isset($searched_tab)){ if($searched_tab == 'expired'){echo '';}else{echo'hid';} }else{echo'hid';} @endphp" data-sr="expired">


                <div class="row text-end mt-3 mb-3 pe-lg-3 ps-lg-3">


                    <div class="col text-start">

                        <p class="mt-3" style="font-size: 14px;font-weight: 600;">{{__('inpanel.survey.history.showing')}} @php echo count($user_expire_surveys); @endphp {{__('inpanel.survey.history.results')}}</p>

                    </div>

                </div>

                <div class="row text-center">

 

 

                    <div class="col">

 

 

                        <table class="table border" id="table_id_shh" style="overflow:hidden">

 

                            <thead>

                            @if(count($user_expire_surveys)>0)

                                <tr class="table-height-cst-row">
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.history.column_2')}}<span
                                                class="d-none d-md-inline-block ms-2"><img
                                                    src="images/table-heading-icon.png" alt="img"></span></p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.history.column_3')}}</p>
                                    </th>
                                    <th scope="col">
                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.index.column_6')}}</p>
                                    </th>

                                    <th scope="col">

                                        <p style="transform: translateY(6px);">{{__('inpanel.survey.index.column_9')}}</p>

                                    </th>

                                </tr>
                            
                                @endif
                            </thead>


                            <tbody>

                        
                            @if(count($user_expire_surveys)>0)

                                    @foreach($user_expire_surveys as $survey)
                                    @php
                                    $user=\Auth::user(); 
                                    $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $survey->updated_at)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                    @endphp

                                <tr class="table-height-cst-row @php if(isset($searched_survey)){ if($searched_survey == $survey->apace_project_code) { echo 'scroll-to-this'; } } @endphp" @php if (isset($searched_survey)){ if($searched_survey == $survey->apace_project_code){ echo "style='background:#cee3f2'"; } }@endphp>
                                    <td scope="row" class="fw-bold">{{$survey->apace_project_code}}</td>
                                    <td class="fw-bold">{{$survey->points}}</td>
                                    <td class="fw-bold">
                                        @if($survey->points*$metricConversion < 1)
                                            <!-- Code Updated by Vikas -->
											@php
                                                $centsValue = round($survey->points * $metricConversion * 100);
                                                $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                            @endphp
                                            {{ $centsValue }} {{ __($currency) }}
                                            <!-- End -->
                                        @else
                                            {{number_format($survey->points*$metricConversion,2)}}
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{--date('m/d/Y H:i:s',strtotime($survey->updated_at))--}}

                                    @php $ex_date = explode(' ',$updatedDate); @endphp
                                            {{--date('Y-m-d H:i:s',strtotime("$survey->updated_at UTC"))--}}
                                            {{$ex_date[0]}} </td>


 

                                </tr>
                                @endforeach
                                    
                                @else
                                <div class="row text-center">
                                    <div class="col">
                                        <p>{{__('inpanel.survey.history.no_history')}}</p>
                                    </div>
                                </div>
                                @endif



                            </tbody>
                        </table>


 

                        {{--$surveys->render()--}}


 


                    </div>


                </div>


                </div>


            </div>


    </div>


    <!-- Modal Added by Vikas (Starting)-->
    <div id="surveyCountryMismatchModal">
        <div class="modal-content-country">
            <h3>{{ __('inpanel.dashboard.pop_up.title') }}</h3>
            <p>{{ __('inpanel.dashboard.pop_up.other_country_title_1') }}<br>
                {{ __('inpanel.dashboard.pop_up.other_country_title_2') }}</p>
            <button id="countryMismatchOkBtn">Ok</button>
        </div>
    </div>
    <!-- Ending -->


    <!-- New -->


@if(count($surveys) < 4 || count($hsurveys) < 4)

<div class="row mt-5 pt-5 pb-5">

    <div class="col mt-4 pt-5">

        <div class="cst-margin-space"></div>

    </div>

</div>
@endif


<!-- </div> -->








@endsection
@push('after-styles')

      <style>
        .cst-sort-btn{
            background: white;
            border: 1px solid #ECECEC;
            padding: 10px 10px 10px 10px;
            width: 172px;
            border-radius: 7px;
            font-size: 14px;
            appearance: none;
            -webkit-appearance: none;
            width: 50mm; /* Adjust the width as needed */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* .cst-sort-btn option{
            font-size: 12px;
        } */


        .cst-sort-btn:focus-visible{
            outline: none;
        }

        .cst-added-expired{
            transform:translateX(-50%)
        }

        .li-tab-row{
            position:relative; height:60px; overflow-x: auto; overflow-y: hidden;
            white-space: nowrap;
        }

        .li-tab-row {
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;  /* Firefox */
        }
        .li-tab-row::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }

        .filter-survey-li{
            color: #999999;
            font-size: 17px;
            cursor: pointer;
            position: absolute;
            width:auto;
            bottom: 0;
            padding-bottom:16px;
        }

        .li-list-item-two{
            left:20%;
        }

        .li-list-item-three{
            left:40%;
        }

        .cst-survey-filter-active{
            border-bottom: 3px solid #0d6efd;
            color: #0d6efd;
            padding-bottom: 16px;
            font-weight: 600;
        }
      

        .table-height-cst-row{
            height: 51px;
        }

        .table-height-cst-row td{
            text-align: center;
            padding-top: 14px;
            vertical-align: middle;
        }   

        .table-height-cst-row th{
            text-align: center;
            padding-top: 14px;
            color: #005A9A;
            background: #FAFAFA;
        }

        .tab-sta-btn{
            height: 30px;
            width: 80px;
            border-radius: 5px;
            border: none;
            font-weight: 600;
            font-size: 14px;
        }

        .cst-full-sr{
            border: 1px solid #ECECEC;
        }

        .cst-full-sr:hover{
            border: 1px solid #794dc8;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        .dataTables_filter{
            margin-bottom: 20px;
            font-weight: bold;
        }

        .dataTables_filter label input:focus-visible{
            outline: none;
        }

        .dataTables_info{
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14px;
            transform: translateX(5px);
        }

        .dataTables_paginate{
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .dataTables_paginate span .current{
            background: #e9f6f1 !important;      
            border-radius: 10px !important;
            border: none !important;
        }

        .dataTables_length{
            font-weight: bold;
        }

        .cst-margin-space{
            margin-top: 100px;
        }

        .pagination{
            display: none;  
        }

        .hid{
            display: none;
        }

        @media only screen and (max-width: 990px) {

            .filter-survey-li{
            color: #999999;
            font-size: 14px;
            cursor: pointer;
            position: absolute;
            width:auto;
            bottom: 0;
            padding-bottom:16px;
        }

        .cst-survey-filter-active{
        border-bottom: 3px solid #0d6efd;
        color: #0d6efd;
        padding-bottom: 16px;
        font-weight: 600;
        }

        .li-list-item-two{
            left:45%;
        }

        .li-list-item-three{
            left:90%;
        }

        .cst-added-expired{
            transform:translateX(-35%);
        }

            .cst-border-first-sec{

                border-right: 0px solid #ECECEC;
                border-bottom: 1px solid #ECECEC;
    
            }

            .cst-bg-hot-survey{
                background-color: transparent;
                border: none;
                box-shadow: none;
            }

            .table-height-cst-row th{

                font-size: 5px;
            }

            .table-height-cst-row th p{
                scale: 1.3;
            }
            
            .table-height-cst-row td{

                font-size: 10px;
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

            .dataTables_info{
             display:none;
            }

            .dataTables_length{
                display:none;
            }

            .cst-margin-space{
            margin-top: 250px;
            }

          }



          .type-element{
            text-overflow: ellipsis;
            width: 255px;
            overflow: hidden;
            white-space: nowrap;
        }

        .custom-tooltip {
        --bs-tooltip-bg: #f3f2f2;
        --bs-tooltip-color: var(--bs-black);
        --bs-tooltip-font-size: 11px;
        }

    </style>
@endpush
@php
    $registeredCountry = auth()->user()->country;

    // Assign 'GB' if country is 'UK'
    if ($registeredCountry === 'UK') {
        $registeredCountry = 'GB';
    }
@endphp
@if($registeredCountry !== $currentCountry)
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('surveyCountryMismatchModal');
        const okBtn = document.getElementById('countryMismatchOkBtn');

        if (modal && okBtn) {
            modal.style.display = 'block';
            document.body.classList.add('modal-open');

            okBtn.addEventListener('click', function () {
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');

                // Redirect to previous page
                history.back();
            });
        }
    });
</script>
@endif
@push('after-scripts')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>





<script>



var cl_locale = @php echo json_encode($country_lang); @endphp;
console.log('cl_locale--'+cl_locale);

if(cl_locale == "en_US"){
    var url_lang = '';
}else if(cl_locale == "es_US"){
    var url_lang = '//cdn.datatables.net/plug-ins/2.1.0/i18n/es-ES.json';;
}else if(cl_locale == "fr_CA"){
    var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json';;
}else{
    var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/en-CA.json';
}


$('.survey-btn').on('click',function(){
        url=$(this).attr('href');
       //win= window.open(url, '_blank');
       setTimeout(() => {
        if (win) {
            // location.reload();

           // window.location.href = window.location.href;

        }
       }, 3000);

    });



// data table

$(document)
  .ready(function () {
    $('#table_id_sh')

      .DataTable({        "language": {
            "url": `${url_lang}`
        }});

  });


  $(document)
  .ready(function () {
    $('#table_id_shh')
      .DataTable({        "language": {
            "url": `${url_lang}`
        }});
  });

//
$(document).ready(function(){
    let d_data = document.querySelectorAll('#filter-content-survey');
    let fil = document.querySelectorAll('.filter-survey-li ');
    @if(isset($history))
        let redirect_arr = @json($history);
        console.log("Arr: "+redirect_arr.length);
        if(redirect_arr.length > 0){
            d_data[2].style.display = 'block';
            fil[2].classList.add('cst-survey-filter-active');
            d_data[0].style.display = 'none';
            fil[0].classList.remove('cst-survey-filter-active');
            d_data[1].style.display = 'none';
            fil[1].classList.remove('cst-survey-filter-active');
        }
    @endif
});


    $(document).ready(function() {

    $('#sort').change(function() {
        $('#filterdata').submit();

    });  
});





// survey btn

var te = document.querySelectorAll('.survey-btn');

for(let i = 0; i < te.length; i++){

    if(te[i].innerText == 'Tomar encuestas'){
    te[i].style.fontSize = '13px';
    te[i].style.scale = '1.1';
}

}

//


// live survey - survey history

var seei = document.querySelectorAll('.filter-survey-li');

if(seei[0].innerText == 'Encuesta en vivo'){

    for(let i = 0; i < seei.length; i++){

    seei[i].style.fontSize = '14px';
}

}

//

// main function
function loadSurveyEss(str) {

let s = str;

let div_data = document.querySelectorAll('#filter-content-survey');

let fil_m = document.querySelectorAll('.filter-survey-li ');
let survey_dd = document.getElementById('hot_survey_options');

if (str == 'live') {
$('#clearFilter1').show();
    for (let i = 0; i < div_data.length; i++) {

        if (div_data[i].dataset.sr == 'live') {
            //$('#clearFilter1').show();
            div_data[i].style.display = 'block';
            fil_m[0].classList.add('cst-survey-filter-active');
            survey_dd.style.visibility = "visible";
        } else {
            //$('#clearFilter1').hide();
            div_data[i].style.display = 'none';
            fil_m[1].classList.remove('cst-survey-filter-active');
            fil_m[2].classList.remove('cst-survey-filter-active');

        }

    }

}

else if (str == 'history') {
    $('#clearFilter1').hide();
    for (let i = 0; i < div_data.length; i++) {

        if (div_data[i].dataset.sr == 'history') {

            div_data[i].style.display = 'block';
            fil_m[1].classList.add('cst-survey-filter-active');
            survey_dd.style.visibility = "hidden";

        } else {

            div_data[i].style.display = 'none';
            fil_m[0].classList.remove('cst-survey-filter-active');
            fil_m[2].classList.remove('cst-survey-filter-active');

        }

    }


}


else if (str == 'expired') {
$('#clearFilter1').hide();
for (let i = 0; i < div_data.length; i++) {

    if (div_data[i].dataset.sr == 'expired') {

        div_data[i].style.display = 'block';
        fil_m[2].classList.add('cst-survey-filter-active');
        survey_dd.style.visibility = "hidden";

    } else {

        div_data[i].style.display = 'none';
        fil_m[0].classList.remove('cst-survey-filter-active');
        fil_m[1].classList.remove('cst-survey-filter-active');

    }

}


}



}
//

 

// side bar survey active

  var all_li_nav = document.querySelectorAll('.side-menu-li');

  if(all_li_nav != []){

    all_li_nav[0].parentElement.classList.remove('cst-active');
    all_li_nav[0].firstElementChild.firstElementChild.src="images/Dashboard Icon.png";

    all_li_nav[3].parentElement.classList.add('cst-active');
    all_li_nav[3].firstElementChild.firstElementChild.src="images/Surveys bold icon.png";

  }

//


// side bar survey active mobile

var all_li_nav_mob = document.querySelectorAll('.side-menu-li-mob');

if(all_li_nav_mob != []){

    all_li_nav_mob[0].classList.remove('cst-active');
    all_li_nav_mob[0].firstElementChild.firstElementChild.src="images/Dashboard Icon.png";

    all_li_nav_mob[3].classList.add('cst-active');
    all_li_nav_mob[3].firstElementChild.firstElementChild.src="images/Surveys bold icon.png";

}

//


// side bar active mobile

var all_li_nav_mob = document.querySelectorAll('.side-menu-li-mob');

if(all_li_nav_mob != []){
    all_li_nav_mob[0].classList.remove('cst-active');
    all_li_nav_mob[3].classList.add('cst-active');
}

//



$(document).ready(function(){

$('.cst-menu-tab-mob span').on('click', function(){

    var bar = $('.cst-menu-tab-mob');

    var barWidth = bar.width();

    var barScrollLeft = bar.scrollLeft();

    var barOffset = bar.offset().left;

    var tab = $(this).closest('span');

    var tabOffset = tab.offset().left;

    var tabWidth = tab.outerWidth();

    // alert (tabOffset + "<>" + tabWidth);

   

    var scrollOffset = (barWidth / 2) - (tabWidth /2);

    var scrollTo;

    if(tabOffset < barOffset ){

        scrollTo = barScrollLeft - (barOffset - tabOffset) - scrollOffset;

    }

    else if(tabOffset + tabWidth > barOffset + barWidth){

        scrollTo = barScrollLeft + tabOffset + tabWidth - (barOffset + barWidth) + scrollOffset;

    }

    bar.animate({

        scrollLeft: scrollTo

    }, 500);

   

});

});


</script>

<script>
    // console.log(profiling_surveys);

        $(document).ready(function(){
           // config_setting = {!! json_encode(config('app.points.metric.conversion')) !!};
			//console.log('config_setting-'+config_setting);
			let config_setting = <?php echo json_encode ($metricConversion); ?>;
			let config_singular = "{{__($currencies['currency_denom_singular'])}}";
			let config_plural = "{{__($currencies['currency_denom_plural'])}}";
			let config_logo = <?php echo json_encode ($currencies['currency_logo']); ?>;

			console.log('config_setting-'+config_setting);
			console.log('config_singular-'+config_singular);
			console.log('config_plural-'+config_plural);
			console.log('config_logo-'+config_logo);
			
            
            $('#hot_survey_options').change(function(){
                let survey_dd = document.getElementById('clearFilter');
                survey_dd.style.display = "inline-block";
                
                val = $('#hot_survey_options').val();
                $.ajax({
                    url: "{{route('inpanel.get.filtered.survey')}}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {data: val, _token: '{{csrf_token()}}'},
                    success: function(response){
                        console.log(config_setting);
                        const mergeResult = response.data;
                        console.log(mergeResult.length + "hello");
                        let new_html_sr = '';
                        if(mergeResult.length > 0){
                            document.querySelector('#hot_survey_section').innerHTML = "";
                                for(let i = 0; i < mergeResult.length; i++){
                                    if(i % 3 == 0 && i != 0){
                                        new_html_sr += "<div class='row mt-2 mb-2 d-none d-lg-block' style='margin-bottom: -10px !important;'>"+
                                                    "<div class='col' style='margin-left:12px'>"+
                                                      "<hr style='scale:1.02; opacity:0.1'>"+
                                                    "</div>"+

                                                 "</div>";
                                    }

                                        var use_arr_for_type = mergeResult[i].survey_name.split('-');
                                        var total_taken_surveys = @php echo json_encode($getAllUserTakenSurveys) @endphp;
                                        var total_taken_survey_count = 0;
                                        console.log(total_taken_surveys.data);

                                        for(let j = 0; j < total_taken_surveys.data.length; j++){

                                            if(total_taken_surveys.data[j].apace_project_code == mergeResult[i].apace_project_code){

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
                                                
                                                                            <p class="fw-bold lead">`;
                                                                            
                                                                            if(mergeResult[i].points*config_setting < 1){
																				var currencyy = ((mergeResult[i].points * config_setting * 100)>1) ? config_plural : config_singular;
																				
                                                                new_html_sr +=    `${parseFloat((mergeResult[i].points*config_setting*100).toFixed(2))} ${currencyy} `;
                                                                            }else{
                                                                new_html_sr +=     `${config_logo}${parseFloat((mergeResult[i].points*config_setting).toFixed(2))}`;
                                                                            } 
                                                                            
                                                                new_html_sr +=                 `</p>
                                                
                                                                        </div>
                                                
                                                                    </div>
                                                
                                                
                                                
                                                                    <div class="row" style="transform: translateY(-5px);">
                                                
                                                                        <div class="col">
                                                
                                                                            <p class="" style="font-weight:400">${mergeResult[i].apace_project_code}</p>
                                                
                                                                        </div>
                                                
                                                                    </div>
                                                
                                                
                                                
                                                
                                                                    <div class="row">
                                                
                                                                        <div class="col">
                                                
                                                                            <span class="m-0 pb-2" style="font-size: 12px;">{{__('inpanel.survey.index.column_5')}}</span>

                                                                            <span class="p-2 rounded-pill" style="color:#7465F1; background: #f3f2f2; font-weight: 500; font-size: 12px;">${mergeResult[i].loi} {{__('min.')}}</span>
                                                                                                                                                
                                                                        </div>
                                                
                                                                        
                                                                        <div class="col text-end">
                                                
                                                                            <span class="pull-right survey_list">
                                                                                    
                                                                                    <a  class="btn btn-primary btn-lg" style="font-size:17px"  id="tke_sry_but">{{__('inpanel.survey.index.link_take_survey')}}</a>
                                                                                
                                                                            </span>

                                                                        </div>
                                                
                                                                    </div>

                                                                    
                                                                    <div class="row m-0 text-center">

                                                                        <div class="col-12 m-0 text-start p-0">

                                                                                <p class="ms-0 me-0 mt-3 mb-3" style="font-size: 11px;">{{__('inpanel.survey.index.column_10')}} ${use_arr_for_type[0]}</p>
                                                                        </div>    


                                                                        <div class="col-12 m-0">`;
    
                                                                    if(total_taken_survey_count)  {
                                                                        new_html_sr += `<p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;">${total_taken_survey_count} {{__('inpanel.survey.index.column_11')}}</p>`;

                                                                    } else{
                                                                        new_html_sr += `<p class="m-0" style="font-size: 10px; scale:1.1; color:#7465F1;visibility:hidden;">${total_taken_survey_count} {{__('inpanel.survey.index.column_11')}}</p>`;

                                                                    } 
                                                                        
                                                                    new_html_sr += `   </div>

                                                                    </div>
                                                
                                                
                                                                </div>
                                                                
                                                
                                                            </div>`;

                                    
                                    // console.log(mergeResult);

                                    }
                                    jQuery("#hot_survey_section").append(new_html_sr);
                                    var te = document.querySelectorAll('#tke_sry_but');
                                    
                                    for(let i = 0; i < te.length; i++){
                                        if(te[i].innerText == 'Tomar encuestas'){

                                            te[i].style.fontSize = '13px';

                                            te[i].style.scale = '1.1';

                                        }
                                        var url = "{{route('inpanel.survey.execute.show', ['id' => ':id'])}}";
                                    
                                        url = url.replace(':id',mergeResult[i].id);
                                        
                                        te[i].href = url;
                                    }
                                }
                    }

                });

            });

        });
		
    </script>

@endpush
