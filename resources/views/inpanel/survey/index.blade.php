@extends('inpanel.layouts.app')

@section('content')
    {{--<div class="wrapper wrapper-content animated fadeInRight">--}}
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('inpanel.survey.index.heading_1')}}</h5>
                        <form action="{{route('inpanel.survey.index')}}" method="get" id="filterdata">
                            <span style="float: right;"><b>{{__('inpanel.survey.index.sort_1')}} </b>
                            <select name="sort" id="sort">
                                <option value="dsc" selected>Decreasing Incentive</option>
                                <option value="asc" @if( isset($_GET['sort']) && $_GET['sort'] == 'asc'){ selected } @endif>Increasing Incentive</option>                           
                            </select>
                            </span>
                        </form>
                    </div>
                    <div class="row pb-2 d-none d-md-flex survey_heading">
                        <div class="col-sm-5 d-none d-md-flex align-items-center justify-content-start">
                            <div class="text-bold header-points" style="font-weight: bold">
                                {{__('inpanel.survey.index.column_2')}}
                            </div>
                            <div class="text-bold header-points" style="font-weight: bold">
                                {{__('inpanel.survey.index.column_6')}}
                            </div>
                            <div class="text-bold header-type" style="font-weight: bold">
                                {{__('inpanel.survey.history.column_2')}}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="text-bold header-loi" style="font-weight: bold">
                                {{__('inpanel.survey.index.column_5')}}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-bold header-status" style="font-weight: bold">
                                {{__('inpanel.survey.index.column_3')}}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-bold header-closing" style="font-weight: bold">
                               {{__('inpanel.survey.index.column_8')}}
                            </div>
                        </div>
                    </div>
                    @if($detailed_profile_survey)
                    <!-- <section class="module">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-7 d-none d-md-flex align-items-center justify-content-start">
                                    <div class="ellipse">
                                        <p class="survey-points">
                                            {{$detailed_profile_survey->points}}
                                        </p>
                                    </div>
                                    <div class="survey-heading">
                                        {{__('inpanel.survey.index.detailed_profile')}}
                                    </div>
                                </div>
                                <div class="col-sm-1 d-none d-md-flex align-items-center text-bold length">
                                    <div class="survey-loi">
                                        <i class="fas fa-clock"></i>
                                        {{$detailed_profile_survey->completion_time}} min.
                                    </div>
                                </div>
                                <div class="col-sm-2 d-none d-md-flex align-items-center text-bold status">
                                    <p class="status">{{__('inpanel.survey.index.pending')}}</p>
                                </div>
                                <div class="col-sm-2 d-none d-md-flex align-items-center justify-content-end">
                                    <a class="btn btn-primary" href="{{route('inpanel.survey.execute.show', ['user_project_id' => $detailed_profile_survey->id])}}">
                                        {{__('inpanel.survey.index.link_take_survey')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section> -->
                    @endif
                    @if(!empty($surveys))
                        @foreach($surveys as $availableSurvey)
                            <section class="module">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-5 d-none d-md-flex align-items-center justify-content-start">
                                            <div class="ellipse">
                                                <p class="survey-points">
                                                    {{$availableSurvey->points}}
                                                </p>
                                            </div>
                                            <div class="survey-value">
                                                {{$availableSurvey->points*config('app.points.metric.conversion')}}
                                            </div>
                                            <div class="survey-heading">
                                                <p class="apace_code">{{$availableSurvey->apace_project_code}}</p>
                                               {{-- <p class="sjpl_code">{{$availableSurvey->code}}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-1 d-none d-md-flex align-items-center text-bold length">
                                            <div class="survey-loi1">
                                                <i class="fas fa-clock"></i>
                                                {{$availableSurvey->loi}} min.
                                            </div>
                                        </div>
                                        <div class="col-sm-2 d-none d-md-flex align-items-center text-bold status">
                                            <p class="status"> @if($availableSurvey->status===0) {{__('inpanel.survey.index.pending')}} @elseif($availableSurvey->status===null) {{$status[$availableSurvey->status]}} @endif</p>
                                        </div>
                                        <div class="col-sm-2 d-none d-md-flex align-items-center text-bold length">
                                            <div class="survey-loi align-items-center">
                                                @if($availableSurvey->end_date)
                                                {{ date('d M Y',strtotime($availableSurvey->end_date))}}
                                                @else
                                                ---
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2 d-none d-md-flex align-items-center justify-content-end">
                                             @if(auth()->user()->home_country!='OUT')
                                            <a class="btn btn-primary" href="{{route('inpanel.survey.execute.show', ['user_project_id' => $availableSurvey->id])}}" target="_blank">
                                                @if($availableSurvey->status===0) {{__('inpanel.survey.index.link_take_survey_2')}} @elseif($availableSurvey->status===null) {{__('inpanel.survey.index.link_take_survey')}} @endif
                                            </a>
                                            @else
                                            <a class="btn btn-primary" href="#" disabled>
                                                @if($availableSurvey->status===0) {{__('inpanel.survey.index.link_take_survey_2')}} @elseif($availableSurvey->status===null) {{__('inpanel.survey.index.link_take_survey')}} @endif
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endforeach
                        @if(isset($_GET['sort'])) 
                            {{$surveys->appends(['sort' => $_GET['sort']])->render()}}
                        @else  
                            {{$surveys->render()}}
                        @endif
                        
                    @else
                        <div class="content">
                            <small>{{__('inpanel.survey.index.sub_heading')}}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- </div>--}}
@endsection
@push('after-styles')
    <style>
        .justify-content-start {
            justify-content: flex-start !important;
        }
        .ellipse {
            height: 55px;
            width: 55px;
            border-radius: 50%;
            background: #d5f6f2;
            display: flex;
            flex-grow: 0;
            flex-shrink: 0;
            align-items: center;
            padding-left: 0px;
        }
        .survey-points {
            font-family: 'Lato Black', sans-serif;
            font-size: 1.5rem;
            text-transform: uppercase;
            text-align: center !important;
            word-wrap: break-word;
            letter-spacing: 1pt;
            margin: 0 auto;
            color: #076256;
        }
        .survey-heading {
            margin-left: 45px;
            vertical-align: middle;
            margin: auto;
            text-align:center;
        }
        .survey-value {
            margin-left: 45px;
            vertical-align: middle;
            margin: auto;
        }

        section.module {
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            margin-bottom: 20px;
            display: block;
        }
        @media (min-width: 768px){
            .d-md-flex {
                display: flex !important;
            }
        }
        @media (min-width: 576px){
            .col-sm-7 {
                flex: 0 0 58.3333333333%;
                max-width: 58.3333333333%;
            }
        }
        .header-points {
            margin-left: 50px;
        }
        .header-type {
            margin-left: 110px;
        }
        @media (min-width: 768px){
            .d-md-flex {
                display: flex !important;
            }
        }
        @media (max-width: 767.98px){
            .row.survey_heading{
                display: none;
            }
        }

        .header-points{
            font-size: 17px;
        }
        .header-type{
            font-size: 17px;
        }
        .header-loi{
            font-size: 17px;
        }
        .header-status{
            font-size: 17px;
            margin-left: 55px;
        }
        .header-closing{
            font-size: 17px;
            margin-left: 19px;
        }
        div.survey-loi{
            margin: auto;
        }
        p.status{
            margin: auto;
        }
        p.apace_code {
            margin-bottom: 5px;
        }
        p.sjpl_code {
            font-size: 10px;
        }
    </style>
@endpush
@push('after-scripts')

<script>
    $(document).ready(function() {

    $('#sort').change(function() {
        $('#filterdata').submit();

    }); 
    $('.btn').on('click',function(){
        url=$(this).attr('href');
       win= window.open(url, '_blank');
if (win) {
        location.reload();
    }
    });

});
</script>
@endpush