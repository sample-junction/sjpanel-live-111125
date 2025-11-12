@extends('inpanel.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('inpanel.survey.history.heading')}}</h5>
                    </div>
                    <div class="ibox-content col-md-12">

                        <div class="project-list">
                            <table class="table table-hover">
                                <thead>
                                @if(count($surveys)>0)
                                    <tr>
                                        <!-- <th>{{__('inpanel.survey.history.column_1')}}</th> -->
                                        <th >{{__('inpanel.survey.history.column_2')}}</th>
                                        <th>{{__('inpanel.survey.history.column_3')}}</th>
                                        <th>{{__('inpanel.survey.index.column_6')}}</th>
                                        <th>{{__('inpanel.survey.index.column_7')}}</th>
                                        <th>{{__('inpanel.survey.history.column_4')}}</th>
                                    </tr>
                                @endif
                                </thead>
                                <tbody>
                                @if(count($surveys)>0)
                                    @foreach($surveys as $survey)
                                    @php
                                    $user=\Auth::user(); 
                                    $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $survey->updated_at)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                    @endphp
                                        <tr >
                                            <!-- <td>{{@$survey->project->survey_name}}</td> -->
                                            <td>
                                                <p class="apace_code">{{@$survey->project->apace_project_code}}</p>
                                               {{-- <p class="sjpl_code">{{$survey->project->code}}</p> --}}
                                            </td>
                                            <td><span class="margin-td">{{$survey->points}}</span></td>
                                            <td><span class="margin-td">{{$survey->points*config('app.points.metric.conversion')}}</span></td>
                                            <td>{{--date('m/d/Y H:i:s',strtotime($survey->updated_at))--}}
                                              
                                               {{--date('Y-m-d H:i:s',strtotime("$survey->updated_at UTC"))--}}
                                               {{$updatedDate}}
                                            </td>
                                            <td>@if($survey->status==1) {{__('inpanel.survey.history.status_1')}}  @elseif($survey->status==0){{__('inpanel.survey.history.status_2')}}  @elseif($survey->status==50) {{__('inpanel.survey.history.status_3')}} @elseif($survey->status==5) {{__('inpanel.survey.history.status_4')}} @else {{$status[$survey->status]}} @endif</td>
                                        </tr>
                                    @endforeach
                                    
                                @else
                                    {{__('inpanel.survey.history.no_history')}}
                                @endif
                                </tbody>
                            </table>
                            {{$surveys->render()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
@endsection
@push('after-styles')
    <style>
        .margin-td
        {
            margin-left: 15px !important;
        }
        p.apace_code {
            margin-bottom: 5px;
        }
        p.sjpl_code {
            font-size: 10px;
        }
    </style>