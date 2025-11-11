@extends('inpanel.layouts.device')
@section('invite_select','cst-active')
@push('after-styles')

 <!-- data table -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <style>
        .pankaj{
            background-color: #0d70b7;
        }
        .bs-wizard {margin-top: 40px;}

        /*Form Wizard*/
        .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
        .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
        .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
        .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
        .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
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
    
    .cst-sort-btn{
        background: white;
        border: 1px solid #ECECEC;
        padding: 8px 10px 8px 10px;
        width: 140px;
        border-radius: 7px;
        font-size: 15px;
    }

    .cst-sort-btn:focus-visible{
        outline: none;
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

        vertical-align: middle;
        text-align: center;

    }   

    .table-height-cst-row th{
        padding-top: 14px;
        color: #005A9A;
        background: #FAFAFA;
        text-align: center;
    }

    .tab-sta-btn{
        height: 30px;
        width: 80px;
        border-radius: 5px;
        border: none;
        font-weight: 600;
        font-size: 14px;
    }


    .link-social{
        width: auto;
    }

    .points-cst-bottom{
        font-size: 14px;
        transform: translate(-40px, 5px);
    }

    .ref-text{
        text-decoration: none;
        font-size: 16px;
    }

    .cst-status-final{
    font-size: 14px;
    }    

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    .input-my-ref::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        opacity: 0.5; /* Firefox */
      }

      .points-enter-sec{
        transform: translateX(-30px);
      }

      .cst-li-scroll::-webkit-scrollbar{
        display: none;
      }

      .reed-options{
        font-size: 16px; 
      }

      .cst-mid-li{
        transform:translateX(-5%)
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

        .plus-icon-div{
            transform: translateY(8px);
        }

        table.dataTable tbody td {
            padding: 8px 0px;
        }

        .li-list-item-two{
            left:30%;
        }

    .hid{
        display: none;
    }



    @media only screen and (max-width: 990px) {

        .filter-survey-li{
            font-size: 14px;
            cursor: pointer;
            position: absolute;
            width:auto;
            bottom: 0;
            padding-bottom:16px;
        }

        
        .li-list-item-two{
            left:60%;
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

            font-size: 10px;
        }

        
        .table-height-cst-row td{

            font-size:9px;
        }

        .tab-sta-btn {

        height: 30px;
        width: 58px;
        border-radius: 5px;
        border: none;
        font-weight: 600;
        font-size: 10px; 
        }



        .link-social{
            width: 90%;
        }

        .reed-options{
            font-size: 15px; 
          }

        .points-cst-bottom{
            font-size: 14px;
            transform: translateX(-10px);
        }

        .ref-text{
            text-decoration: none;
            font-size: 13px;
        }

        .cst-status-final{
            font-size: 10px;
        }

        
        .dataTables_info{
            
            display:none;
        }

        .dataTables_length{
            
            display:none;
        }

      .cst-mid-li{
        transform:translateX(-5%)
      }

        .points-enter-sec{
            transform: translateX(0px);
          }


          .plus-icon-div{
            transform: translateY(0px);
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
@section('content')







                    <!-- New -->




                    <div class="row mt-5">


                        <div class="col-12">

                            <p class="h4 ms-2" style="font-weight: 600;">{{__('inpanel.invite.index.title')}}</p>

                        </div>

                        <div class="col-12 mt-4">

                            <p class="p-3" style="background: #fbf2e3; font-size: 14px;">{{__('inpanel.invite.index.sub_heading_details_1')}} <span class="fw-bold">{{__('inpanel.invite.index.sub_heading_details_2', ['invite_points' => $get_referal_point->value])}} 
                            
                            @if($get_referal_point->value < 1)
								@php
									$currency = ($get_referal_point->value*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
								@endphp
                            ({{number_format($get_referal_point->value*$metricConversion*100,2)}} {{__($currency)}})
                            @else
                            ({{$currencies['currency_logo']}}{{number_format($get_referal_point->value*$metricConversion,2)}})
                            @endif

                            </span> {{__('inpanel.invite.index.sub_heading_details_3')}}</p>

                        </div>


                    </div>




                    <div class="row p-lg-3">


                        <div class="col cst-bg-hot-survey bg-white shadow" style="border-radius: 10px;">

                            <div class="row p-3 border-bottom li-tab-row cst-menu-tab-mob">

                                    <span class="lead filter-survey-li cst-survey-filter-active" onclick="loadSurveyEss('Refer a Friend')">{{__('inpanel.invite.index.title')}}</span>

                                    <span class="lead filter-survey-li li-list-item-two" onclick="loadSurveyEss('My References')">{{__('inpanel.invite.myreferrals.index.heading')}}</span>

                            </div>


                            <div id="filter-content-survey" class="" data-sr="Refer a Friend">



                                <div class="row mt-2 mb-1">

                                    <div class="col">

                                        <p class="ps-3 pt-3 text-secondary">{{__('inpanel.invite.index.brief_for_steps')}}</p>

                                    </div>
                                    
                                </div>



                                <div class="row">

                                    <div class="col">

                                        <p class="ps-3" style="font-weight: 600;">{{__('inpanel.invite.index.invitaion_links')}}</p>

                                    </div>
                                    
                                </div>


                                <div class="row mb-4 border ms-3 me-3 p-2 rounded">
                                    <div class="col-10">
                                        <a class="ref-text">{{$invite_link->getLinkAttribute('1',$ref_code_rand)}}</a>
                                        <input type="text" value="{{$invite_link->getLinkAttribute('1',$ref_code_rand)}}" id="link_refer" class="d-none">
                                    </div>
                                    <div class="col-2 text-end">
                                        <i class="fas fa-copy" onclick="cstCopyText()" style="cursor:pointer"></i>
                                    </div>
                                </div>
                                




                                <div class="row">

                                    <div class="col">

                                        <p class="ps-3" style="font-weight: 600;">{{__('inpanel.invite.index.refer_email')}}</p>

                                    </div>
                                    
                                </div>


                                <div class="row mb-4 ps-3 pe-3 invite_form">

                                {{ html()->form('POST')->class('form-horizontal')->open() }} 


                                <div class="row invite_form_email">

                                    <input type="hidden" name="refer_code" value="{{$ref_code_rand}}">

                                    <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                    <input type="text" class="form-control input-my-ref input-my-ref-f-name" placeholder="{{__('inpanel.invite.index.label_1')}}" pattern="[A-Za-z]+" title="Only letters are allowed" name="name[]" style="outline:none; box-shadow: none; border: 1px solid #ECECEC;">
                                    <p class="text-danger f-name-err-msg mb-0 mt-1 ms-2 p-0 hid">{{__('inpanel.invite.index.form_err_1')}}</p>
                                    </div>

                                    <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                    <input type="text" class="form-control input-my-ref input-my-ref-l-name" placeholder="{{__('inpanel.invite.index.label_2')}}" name="lastname[]" pattern="[A-Za-z]+" title="Only letters are allowed" style="outline:none; box-shadow: none; border: 1px solid #ECECEC;">
                                    <p class="text-danger l-name-err-msg mb-0 mt-1 ms-2 p-0 hid">{{__('inpanel.invite.index.form_err_2')}}</p>
                                    </div>

                                    <div class="col-12 col-lg-4 mb-3 mt-lg-0 mb-lg-0  mb-2 mb-lg-0">
                                    <input type="text" class="form-control input-my-ref input-my-ref-email" placeholder="{{__('inpanel.invite.index.label_3')}}" name="email[]" style="outline:none; box-shadow: none; border: 1px solid #ECECEC;">
                                    <p class="text-danger email-err-msg mb-0 mt-1 ms-2 p-0 hid">{{__('inpanel.invite.index.form_err_3')}}</p>
                                    </div>

                                    <div class="col-12 col-lg-2 text-center plus-icon-div">
                                        <i class="me-3 border ps-5 pe-5 pb-2 pt-2 rounded pl-ic" style="cursor:pointer" onclick="addMoreMails(this)">
                                            <!-- SVG plus icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transform: translateY(-3px);">
                                                <path d="M12 5v14M5 12h14"></path>
                                            </svg>
                                        </i>
                                    </div>
                                    

                                </div>

                                
                                <div id="newAppend">

                                </div>

                                
                                <div class="row text-center mt-4">

                                <div class="col">
                                <button class="btn emailSbtn" style="background: #0d6efd; width:auto; color:white">{{__('inpanel.invite.button_submit')}}</button>
                                </div>

                                </div>


                                 {{ html()->form()->close() }}   

                                </div>



                                <div class="row pt-3 mb-3 text-center">

                                    <div class="col">

                                        <p class="text-secondary">{{__('inpanel.invite.index.or_share_with')}}</p>

                                    </div>

                                </div>


                                <div class="row text-center mt-1 mb-5">

                                    <div class="col-12 col-md-4 text-md-end">

                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$invite_link->getLinkAttribute('f',$ref_code_rand)}}&p[title]={{$title_social_media}}"  class="btn border rounded-0 ps-5 pe-5 pt-2 pb-2 text-secondary link-social" target="_blank">{{__('inpanel.invite.index.social_link_1')}}</a>
                                    
                                    </div>

                                    <div class="col-12 col-md-4 mt-3 mb-3 mt-md-0 mb-md-0">

                                        <a href="https://twitter.com/intent/tweet?url={{$invite_link->getLinkAttribute('t',$ref_code_rand)}}" class="btn border rounded-0  ps-5 pe-5 pt-2 pb-2 text-secondary link-social">{{__('inpanel.invite.index.social_link_2')}}</a>

                                    </div>

                                    <div class="col-12 col-md-4 text-md-start">

                                        <a href="https://www.linkedin.com/shareArticle?url={{$invite_link->getLinkAttribute('l',$ref_code_rand)}}" class="btn border rounded-0  ps-5 pe-5 pt-2 pb-2 text-secondary link-social">{{__('inpanel.invite.index.social_link_3')}}</a>

                                    </div> 

                                </div>



                                <div class="row pb-3  ps-3 pt-5" style="background: #FAFAFA; border-radius: 10px;">
                                
                                    <div class="col-12">

                                        <p class="fw-bold mb-4">{{__('inpanel.invite.index.how_to_refer')}}</p>

                                    </div>

                                    
                                    <div class="col-2 col-md-1 text-md-start">
                                        <img src="images/icon for refer page.png" alt="img">
                                    </div>
                                    <div class="col-10 col-md-11">
                                        <p class="text-secondary points-cst-bottom">{{__('inpanel.invite.index.step1_details')}}</p>
                                    </div>


                                    <div class="col-2 col-md-1 text-md-start mt-md-3">
                                        <img src="images/icon for refer page.png" alt="img">
                                    </div>
                                    <div class="col-10 col-md-11 mt-md-3">
                                        <p class="text-secondary points-cst-bottom">{{__('inpanel.invite.index.step2_details')}}</p>
                                    </div>


                                    <div class="col-2 col-md-1 text-md-start mt-md-3">
                                        <img src="images/icon for refer page.png" alt="img">
                                    </div>
                                    <div class="col-10 col-md-11 mt-md-3">
                                        <p class="text-secondary points-cst-bottom">{{__('inpanel.invite.index.step3_details')}}</p>
                                    </div>

                                    
                                    <div class="col-2 col-md-1 text-md-start mt-md-3">
                                        <img src="images/icon for refer page.png" alt="img">
                                    </div>
                                    <div class="col-10 col-md-11 mt-md-3">
                                        <p class="text-secondary points-cst-bottom">{{__('inpanel.invite.index.step4_details_1')}} <span>{{__('inpanel.invite.index.step4_details_2', ['invite_points' => $get_referal_point->value])}}
                                        @if($get_referal_point->value < 1)
											@php
												$currency = ($get_referal_point->value*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
											@endphp
                                            ({{number_format($get_referal_point->value*$metricConversion*100,2)}} {{__($currency)}})
                                            @else
                                            ({{$currencies['currency_logo']}}{{number_format($get_referal_point->value*$metricConversion,2)}})
                                            @endif  

                                            </span> {{__('inpanel.invite.index.step4_details_3')}}</p>
                                    </div>


                                </div>

                                


                            </div>



                            <!--sepration-->




                            <div id="filter-content-survey" class="hid" data-sr="My References">



                                <div class="row mt-4 mb-3">

                                    <div class="col ms-3 me-3">

                                        <small class="text-secondary"> {{__('inpanel.invite.myreferrals.index.content_title_1')}} </small>
                                        <small class="text-secondary">  {{__('inpanel.invite.myreferrals.index.content_title_2')}} </small>
                                       
                                    </div>
                                    
                                </div>



                                <div class="row text-end mb-3 pe-lg-3 ps-lg-3">


                                    <div class="col text-start">

                                        <p class="mt-3" style="font-size: 14px;font-weight: 600;">{{__('inpanel.survey.history.showing')}} @php echo count($myreferrals) + count($email_sent_results); @endphp {{__('inpanel.survey.history.results')}}</p>

                                    </div>

                                    <div class="col">


                                    </div>

                                </div>


                                <div class="row" style="position: relative; overflow-x: auto;">


                                    <div class="col">

                                        <table class="table border" id="table_id_sh">

                                            <thead>
                                                <tr class="table-height-cst-row">

                                                    <th scope="col">
                                                        <p style="transform: translateY(6px);">{{__('inpanel.invite.myreferrals.index.heading_name')}}</p>
                                                    </th>
                                                    <th scope="col">
                                                        <p style="transform: translateY(6px);">{{__('inpanel.invite.myreferrals.index.heading_email')}}</p>
                                                    </th>
                                                    <th scope="col">
                                                        <p style="transform: translateY(6px);">{{__('inpanel.invite.myreferrals.index.heading_method')}}</p>
                                                    </th>
                                                    <th scope="col" style="width: 30%;">
                                                        <p style="transform: translateY(6px);">{{__('inpanel.invite.myreferrals.index.heading_status')}}</p>
                                                    </th>

                                                </tr>
                                            </thead>


                                            <tbody>
              
                                @if(count($myreferrals) > 0)

                                @forelse($myreferrals as $key => $referral)
                                @php
                                $user=Auth::user();
                                // $user->timezone;
                                //date_default_timezone_set("America/New_York", 'UTC');
                                 $here = \Carbon\Carbon::parse($referral['created_at']);

                                $there = \Carbon\Carbon::now($user->timezone);
                                 $newDate= date('m/d/Y H:i:s',strtotime("$here UTC"));
                                $result = \Carbon\Carbon::createFromFormat('m/d/Y H:i:s', $newDate)->diffForHumans();
                               //echo $newDate->diffForHumans();
                               //echo $here . PHP_EOL;
                               // echo $there . PHP_EOL;

                                $here->subSeconds($here->offset - $there->offset);
                                //echo $here->diffForHumans() . PHP_EOL;
                                @endphp


                                            
                                                <tr class="table-height-cst-row">

                                                    <td class="fw-bold">{{$referral['name']}}</td>

                                                    <td class="fw-bold">{{$referral['email']}}</td>

                                                    @if(count($ref_methods) > 0)
 
                                                        @if($ref_methods[$key])

                                                            @if($ref_methods[$key]->ref_method == 1)
                                                            <td class="fw-bold">{{__('inpanel.invite.myreferrals.index.method_type_1')}}</td>
                                                            @elseif($ref_methods[$key]->ref_method == 2)
                                                            <td class="fw-bold">{{__('inpanel.invite.myreferrals.index.method_type_2')}}</td>
                                                            @elseif($ref_methods[$key]->ref_method == 'f')
                                                            <td class="fw-bold">{{__('inpanel.invite.myreferrals.index.method_type_3')}}</td>
                                                            @elseif($ref_methods[$key]->ref_method == 't')
                                                            <td class="fw-bold">{{__('inpanel.invite.myreferrals.index.method_type_4')}}</td>
                                                            @elseif($ref_methods[$key]->ref_method == 'l')
                                                            <td class="fw-bold">{{__('inpanel.invite.myreferrals.index.method_type_5')}}</td>
                                                            @else
                                                            <td class="fw-bold">-</td>
                                                            @endif

                                                        @else
                                                        <td class="fw-bold">-</td>

                                                        @endif    

                                                    @else
                                                    <td class="fw-bold">-</td>

                                                    @endif


 
                                                  @if($referral['status']=='pending')
                                                    <td class="fw-bold"><p class="btn cst-status-final fw-bold" style="transform: translateY(10px); background:#D5EBFF; border:none; scale:0.9;">{{__('inpanel.invite.myreferrals.index.referral_status_2')}}</p></td>
                                                    @elseif($referral['status']=='completed')
                                                    <td class="fw-bold"><p class="btn cst-status-final fw-bold" style="transform: translateY(10px); background:#BDFFF4; border:none; scale:0.9;">{{__('inpanel.invite.myreferrals.index.referral_status_3')}}</p></td>
                                                    @elseif($referral['status']=='Response Rejected')
                                                    <td class="fw-bold"><p class="btn cst-status-final fw-bold" style="transform: translateY(10px); background:#BDFFF4; border:none; scale:0.9;">{{__('inpanel.invite.myreferrals.index.referral_status_5')}}</p></td>
                                                    @else
                                                    <td class="fw-bold"><p class="btn cst-status-final fw-bold" style="transform: translateY(10px); background:#C7FFC1; border:none; scale:0.9;">{{__('inpanel.invite.myreferrals.index.referral_status_4')}}</p></td>
                                                    @endif


                                                </tr>

                                @empty
                                {{--__('inpanel.invite.myreferrals.index.no_referrals')--}}
                                @endforelse

                            @endif

                            
                            @if(count($email_sent_results) > 0)
                                @foreach($email_sent_results as $sent_email)

                                    <tr class="table-height-cst-row">

                                    <td class="fw-bold">{{$sent_email->first_name}} {{$sent_email->last_name}}</td>

                                    <td class="fw-bold">{{$sent_email->email}}</td>

                                    <td class="fw-bold">-</td>
                                    
                                    @if($sent_email->status =='Yes')
                                    <td class="fw-bold"><p class="btn cst-status-final fw-bold" style="transform: translateY(10px); background:#F8F7E0; border:none; scale:0.9;">{{__('inpanel.invite.myreferrals.index.referral_status_1')}}</p></td>
                                    @else
                                    <td class="fw-bold"><p class="btn cst-status-final fw-bold" style="transform: translateY(10px); background:#F8F7E0; border:none; scale:0.9;">{{$sent_email->status}}</p></td>
                                    @endif

                                    </tr>

                                @endforeach    
                            @endif
                                            </tbody>
                                        </table>

                                    </div>


                                </div>





                            </div>


                        </div>

                    </div>





                    <!-- New -->







@endsection

@push('after-scripts')

{{-- <script>
        @if($tour_taken == 0)
        @include('inpanel.includes.partials.php-js.invite')
        @endif

    </script>--}}


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>


<script>

var cl_locale = @php echo json_encode($country_lang); @endphp;

if(cl_locale == "en_US"){
    var url_lang = '';
}else if(cl_locale == "es_US"){
	var url_lang = '//cdn.datatables.net/plug-ins/2.1.0/i18n/es-ES.json';;
}else if(cl_locale == "fr_CA"){
    var url_lang = '//cdn.datatables.net/plug-ins/2.0.7/i18n/fr-FR.json';
}else{
    var url_lang = '//cdn.datatables.net/plug-ins/2.0.7/i18n/en-CA.json';
}


$(document).ready(function(){
    console.log("RAS");
    let d_data = document.querySelectorAll('#filter-content-survey');
    let fil = document.querySelectorAll('.filter-survey-li ');
    let redirect_arr = @json($history);
    console.log("Arr: "+redirect_arr.length);
    if(redirect_arr.length > 0){
        d_data[1].style.display = 'block';
        fil[1].classList.add('cst-survey-filter-active');
        d_data[0].style.display = 'none';
        fil[0].classList.remove('cst-survey-filter-active');
    }
});
// data table



$(document)
  .ready(function () {
    
    $('#table_id_sh')
      .DataTable({
        "language": {
            "url": `${url_lang}`,
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

        },
        autoWidth : false,
        "columnDefs": [
            { "width": "20%", "targets": "_all" }
        ],
        initComplete: function () {
            $('.dataTables_filter input').addClass('m-2');
        }
    });
    $('#table_id_sh').on('page.dt', function() {
        $('html, body').animate({
            scrollTop: $("#table_id_sh").offset().top - 150
        }, 400);
    });
  });

//



 //
function loadSurveyEss(str) {

let s = str;

let div_data = document.querySelectorAll('#filter-content-survey');

let fil_m = document.querySelectorAll('.filter-survey-li ');


if (str == 'Refer a Friend') {

    for (let i = 0; i < div_data.length; i++) {

        if (div_data[i].dataset.sr == 'Refer a Friend') {

            div_data[i].style.display = 'block';
            fil_m[0].classList.add('cst-survey-filter-active');

        } else {

            div_data[i].style.display = 'none';
            fil_m[1].classList.remove('cst-survey-filter-active');

        }

    }

}

else if (str == 'My References') {
    
    for (let i = 0; i < div_data.length; i++) {
        
        if (div_data[i].dataset.sr == 'My References') {

            div_data[i].style.display = 'block';
            fil_m[1].classList.add('cst-survey-filter-active');

        } else {

            div_data[i].style.display = 'none';
            fil_m[0].classList.remove('cst-survey-filter-active');

        }

    }


}



}
//




// email submit

var subBtn = document.querySelector('.emailSbtn');

subBtn.addEventListener('click', (e) => {

    var inputsReferName = document.querySelectorAll('.input-my-ref-f-name');
    var inputsRefLName = document.querySelectorAll('.input-my-ref-l-name');
    var inputsReferEmail = document.querySelectorAll('.input-my-ref-email');

    var f_name_err_all = document.querySelectorAll('.f-name-err-msg');
    var l_name_err_all = document.querySelectorAll('.l-name-err-msg');
    var email_err_all = document.querySelectorAll('.email-err-msg');


    let temp = false;

    for(let i = 0; i < inputsReferName.length; i++){

        if(inputsReferName[i].value == ""){
            e.preventDefault();
            temp = true;
            f_name_err_all[i].classList.remove('hid');
        }else{
            temp = false;
            f_name_err_all[i].classList.add('hid');
        }

    }


    for(let i = 0; i < inputsRefLName.length; i++){

    if(inputsRefLName[i].value == ""){
        e.preventDefault();
        temp = true;
        l_name_err_all[i].classList.remove('hid');
    }else{
        temp = false;
        l_name_err_all[i].classList.add('hid');
    }

    }



    var mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;


    for(let i = 0; i < inputsReferEmail.length; i++){

        if(inputsReferEmail[i].value == ""){
            e.preventDefault();
            temp = true;
            email_err_all[i].classList.remove('hid');

        }
        else{

            if (inputsReferEmail[i].value.match(mailformat) == null){
            e.preventDefault();
            temp = true;
            email_err_all[i].innerHTML = '{{__('inpanel.invite.index.form_err_4')}}';
            email_err_all[i].classList.remove('hid'); 
            }else{
                temp = false;
                email_err_all[i].classList.add('hid');
            }

        }


    }


    if(temp == true){
        e.preventDefault();
    }


});

//





// copy btn text

function cstCopyText() {
// Get the text field
var copyText = document.getElementById("link_refer");

// Select the text field
copyText.select();
copyText.setSelectionRange(0, 99999); // For mobile devices

// Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value).then(() => {
        let feedback = document.createElement("span");
        feedback.innerText = "{{__('inpanel.invite.index.link_copied')}}";
        feedback.style.color = "green";
        feedback.style.fontSize = "12px";
        feedback.style.marginLeft = "8px";
        
        let parent = document.querySelector(".col-2.text-end");
        parent.appendChild(feedback);

        setTimeout(() => {
            feedback.remove();
        }, 1500); // removes after 1.5s
    });

}


//





function allowOnlyLetters(input) {
    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-z]/g, ''); // sirf letters
    });
}

// Page load par existing inputs pe lagao
document.querySelectorAll('.input-my-ref-f-name, .input-my-ref-l-name').forEach(allowOnlyLetters);


// add more mails
function addMoreMails(element){

    // var main_form_div = document.getElementById('newAppend');

    var allcurrentForms = document.querySelectorAll('.invite_form_email');

    if(allcurrentForms.length > 1)
    element.nextElementSibling.classList.add('hid');

    element.classList.add('hid');

    if(allcurrentForms.length < 10){


        var new_html = "<div class='row mt-3 invite_form_email'>" +

                                    "<div class='col-12 col-lg-3  mb-2 mb-lg-0'>" +
                                    "<input type='text' class='form-control input-my-ref input-my-ref-f-name' placeholder='{{__('inpanel.invite.index.label_1')}}' name='name[]' pattern='[A-Za-z]+' title='Only letters are allowed' style='outline:none; box-shadow: none; border: 1px solid #ECECEC;'>" +
                                    "<p class='text-danger f-name-err-msg mb-0 mt-1 ms-2 p-0 hid'>{{__('inpanel.invite.index.form_err_1')}}</p>" +
                                    "</div>" +

                                    "<div class='col-12 col-lg-3  mb-2 mb-lg-0'>" +
                                    "<input type='text' class='form-control input-my-ref input-my-ref-l-name' placeholder='{{__('inpanel.invite.index.label_2')}}' name='lastname[]' pattern='[A-Za-z]+' title='Only letters are allowed' style='outline:none; box-shadow: none; border: 1px solid #ECECEC;'>" +
                                    "<p class='text-danger l-name-err-msg mb-0 mt-1 ms-2 p-0 hid'>{{__('inpanel.invite.index.form_err_2')}}</p>" +
                                    "</div>" +

                                    "<div class='col-12 col-lg-4 mb-3 mt-lg-0 mb-lg-0  mb-2 mb-lg-0'>" +
                                    "<input type='text' class='form-control input-my-ref input-my-ref-email' placeholder='{{__('inpanel.invite.index.label_3')}}' name='email[]' style='outline:none; box-shadow: none; border: 1px solid #ECECEC;'>" +
                                    "<p class='text-danger email-err-msg mb-0 mt-1 ms-2 p-0 hid'>{{__('inpanel.invite.index.form_err_3')}}</p>" +
                                    "</div>" +

                                    "<div class='col-12 col-lg-2 text-center plus-icon-div'>" +
                                    "<i class='ms-3 border ps-3 pe-3 pb-2 pt-2 rounded pl-ic' style='cursor:pointer' onclick='addMoreMails(this)'><img src='images/plus-icon-plus-svg-png-icon-download-1.png' alt='icon' width='10px' style='transform: translateY(-1px);'></i>" +
                                    "<i class='ms-3 border ps-3 pe-3 pb-2 pt-2 rounded cr-ic' style='cursor:pointer' onclick='removeMail(this)'><img src='images/642337_close_512x512.png' alt='icon' width='10px' style='transform: translateY(-1px);'></i>" +  
                                    "</div>" +

                                "</div>";

            jQuery("#newAppend").append(new_html);
            let newInputs = document.querySelectorAll('.invite_form_email:last-child .input-my-ref-f-name, .invite_form_email:last-child .input-my-ref-l-name');
        newInputs.forEach(allowOnlyLetters);

     }                


     var newallcurrentForms = document.querySelectorAll('.invite_form_email');

     if(newallcurrentForms.length > 9){
        newallcurrentForms[newallcurrentForms.length - 1].lastElementChild.firstElementChild.classList.add('hid');
     }
     

 }

//



// remove mail

function removeMail(element){

    var allcurrentForms = document.querySelectorAll('.invite_form_email');


    if(allcurrentForms.length > 2){

        element.parentElement.parentElement.previousElementSibling.lastElementChild.firstElementChild.classList.remove('hid');
        element.parentElement.parentElement.previousElementSibling.lastElementChild.lastElementChild.classList.remove('hid');

    }else{

        element.parentElement.parentElement.parentElement.previousElementSibling.lastElementChild.firstElementChild.classList.remove('hid');

    }


    element.parentElement.parentElement.remove();    

}


//


//
var listitemtwo = document.querySelector(".li-list-item-two");
if(listitemtwo.innerText == "My References"){
    listitemtwo.style.transform = "translateX(-75px)";
}

//


    </script>
@endpush