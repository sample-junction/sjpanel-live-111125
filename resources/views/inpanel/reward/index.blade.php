@extends('inpanel.layouts.app')
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInRight">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{__('inpanel.rewards.index.heading')}}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content inspinia-timeline detailed_point_summary">
                        @php
                        $count=0;
                        $counter=0;
                        @endphp
                        @if(!empty($userActivities))
                        
                            @foreach($userActivities as $key=>$activity)
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-xs-3 date">
                                            <i class="fa fa-briefcase"></i>
                                            {{--{{$activity->created_at->format('g:i a')}}--}}
                                            <br>
                                            <small class="text-navy">{{$activity->created_at->diffForHumans()}}</small>
                                        </div>
                                        @if(!$activity->properties->isEmpty())
                                                @php
                                                    $jsonData = json_decode($activity->properties);
                                                    if(isset($jsonData->survey_code)){
                                                        $surveycode = $jsonData->survey_code;
                                                        $descriptionData = trans($activity->description,['code'=>$surveycode]);
                                                    }else{
                                                        $descriptionData = trans($activity->description);
                                                    }
                                                @endphp
                                        @else
                                            @php
                                                $descriptionData = trans($activity->description);
                                            @endphp    
                                        @endif
                                        <div class="col-xs-7 content no-top-border">
                                            <p class="m-b-xs"><strong>
                                            @if (str_contains($descriptionData, 'Invite'))
                                             @if(!empty(@$userrefer[$user_id][$count]) ||!empty(@$userrefer[$user_id][$counter]) )
                                            @if (str_contains($descriptionData, 'Approved'))
                                            Points credited for referral of  {{@$userrefer[$user_id][$count]}} 
                                            @php
                                             $count++;
                                             
                                             @endphp
                                            @else
                                            Pending points for referral of  {{@$userrefer[$user_id][$counter]}}
                                            @php
                                            $counter++;
                                            @endphp
                                            @endif
                                            
                                             @endif
                                            @else
                                            {{$descriptionData}}
                                            @endif
                                           </strong></p>

                                            @if(!$activity->properties->isEmpty())
                                                @php
                                                    $points = json_decode($activity->properties);
                                                @endphp
                                                @if($points->points*config('app.points.metric.conversion') < 1)
                                                <p class="m-b-xs"><strong>{{$points->points}} ({{$points->points*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})</strong></p>
                                                @else
                                                <p class="m-b-xs"><strong>{{$points->points}} (${{$points->points*config('app.points.metric.conversion')}})</strong></p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            
                                 
                            @endforeach
                            @else
                            {{__('inpanel.rewards.index.points')}}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox ">

                    <div class="ibox-content">
                        <div class="tab-content">
                            <div id="contact-1" class="tab-pane active">
                                <div class="row m-b-lg">
                                    <div class="col-lg-12 text-center reward_total_points">
                                        <div class="widget style1 lazur-bg">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-trophy fa-5x"></i>
                                                </div>
                                                <div class="col-xs-8 text-right">
                                                    <span> {{__('inpanel.rewards.index.total_points')}} </span>
                                                    <h2 class="font-bold">{{ (!empty($userPoints))?$userPoints->user_points['completed']:0 }}</h2>
                                                    @if($userPoints->user_points['completed']*config('app.points.metric.conversion') < 1)
                                                    <span class="text-light font-bold">({{$userPoints->user_points['completed']*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})</span>
                                                    @else
                                                    <span class="text-light font-bold">(${{$userPoints->user_points['completed']*config('app.points.metric.conversion')}})</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center reward_pending_points">
                                        <div class="widget style1 yellow-bg">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fas fa-shield-alt fa-5x"></i>
                                                </div>
                                                <div class="col-xs-8 text-right">
                                                    <span> {{__('inpanel.rewards.index.pending_points')}} </span>
                                                    <h2 class="font-bold">{{ (!empty($userPoints))?$userPoints->user_points['pending']:0 }}</h2>
                                                    @if($userPoints->user_points['pending']*config('app.points.metric.conversion') < 1)
                                                    <span class="text-light font-bold">({{$userPoints->user_points['pending']*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})</span>
                                                    @else
                                                    <span class="text-light font-bold">(${{$userPoints->user_points['pending']*config('app.points.metric.conversion')}})</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if( !empty($userPoints) && !empty($userPoints['rejected']) )
                                    <div class="col-lg-12 text-center reward_rejected_points">
                                        <div class="widget style1 red-bg">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fas fa-ban fa-5x"></i>
                                                </div>
                                                <div class="col-xs-8 text-right">
                                                    <span> {{__('inpanel.rewards.index.rejected_points')}} </span>
                                                    <h2 class="font-bold">{{ (!empty($userPoints))?$userPoints->user_points['rejected']:0 }}</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="client-detail1 recent_details">
                                    <strong>{{__('inpanel.rewards.index.recent_points')}}</strong>

                                    <ul class="list-group clear-list">
                                        @if(!empty($userActivities))
                                            @php
                                                $sortedActivities = $userActivities->sortByDesc("created_at")->take(5);
                                            @endphp
                                            @php
                                            $count1=0;
                                            $count2=0;
                                            @endphp
                                            @foreach($sortedActivities as $activity)
                                                <li class="list-group-item fist-item">

                                                    <span class="pull-right"> {{$activity->created_at->diffForHumans()}} </span>
                                            @if(!$activity->properties->isEmpty())
                                                @php
                                                    $jsonData = json_decode($activity->properties);
                                                    if(isset($jsonData->survey_code)){
                                                        $surveycode = $jsonData->survey_code;
                                                        $descriptionData = trans($activity->description,['code'=>$surveycode]);
                                                    }else{
                                                        $descriptionData = trans($activity->description);
                                                    }
                                                @endphp
                                            @else
                                                @php
                                                    $descriptionData = trans($activity->description);
                                                @endphp    
                                            @endif

                                                    @if (str_contains($descriptionData, 'Invite'))
                                             @if(!empty(@$userrefer[$user_id][$count1]) || !empty(@$userrefer[$user_id][$count2]))
                                            @if (str_contains($descriptionData, 'Approved'))
                                            Points credited for referral of {{@$userrefer[$user_id][$count1]}} 
                                            @php
                                             $count1++;
                                             @endphp
                                            @else
                                           Pending points for referral of {{@$userrefer[$user_id][$count2]}}
                                           @php
                                           $count2++;
                                           @endphp
                                            @endif
                                            
                                             @endif
                                            @else
                                            {{$descriptionData}}
                                            @endif


                                                    @if(!$activity->properties->isEmpty())
                                                        @php
                                                            $points = json_decode($activity->properties);
                                                        @endphp
                                                        @if($points->points*config('app.points.metric.conversion') < 1)
                                                        <p class="m-b-xs"><strong>{{$points->points}} ({{$points->points*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})</strong></p>
                                                        @else
                                                        <p class="m-b-xs"><strong>{{$points->points}} (${{$points->points*config('app.points.metric.conversion')}})</strong></p>
                                                        @endif                                                        
                                                    @endif
                                                </li>
                                           
                                                
                                            @endforeach
                                            
                                            @else
                                            {{__('inpanel.rewards.index.no_recent_activities')}}
                                        @endif
                                    </ul>
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
    {{--<script>
        @if($tour_taken == 0)
            @include('inpanel.includes.partials.php-js.rewards')
        @endif
    </script>--}}
@endpush
