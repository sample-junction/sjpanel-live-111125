<div class="row">
    @if( count($profile_sections) >0 )
    <div class="col-md-6 border-right pending_profiles">
        <div class="table-responsive">
            <div class="table_head text-center">
                <span class="label label-danger profile_status_label pending_profile_title">{{__('inpanel.profile.index.label.pending')}}</span>
            </div>
            <table class="table profiles pending">
                <thead>
                <tr>
                    <th> {{__('inpanel.profile.index.general_profile.details')}}</th>
                    <th>{{__('inpanel.profile.index.general_profile.expected_points')}}</th>
                    <th> {{__('inpanel.profile.index.general_profile.expected_time')}}</th>
                </tr>
                </thead>
                <tbody>
                @if( !empty($profile_sections) )
                    @foreach($profile_sections as $sections)
                    @php
                        $translated = $sections->doTranslate();
                    @endphp
                    <tr class="profile_rows">
                        <td>
                            <a href="@if( Route::has('inpanel.profiler.single.show') ){{route('inpanel.profiler.single.show', $sections->_id)}}@endif" class="profiles-item-title">{{ $sections->doTranslate('text') }}</a>
                            <div class="forum-sub-title">{{ $sections->doTranslate('description') }}</div>
                        </td>
                        <td>
                            <span class="views-number">
                                {{$sections->points}} <span style='font-size:15px'>({{$sections->points*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})</span>
                            </span>
                            <div>
                                <small>{{__('inpanel.profile.index.points')}} </small>
                            </div>
                        </td>
                        <td>
                            <span class="views-number">
                                {{$sections->completion_time}}
                             </span>
                            <div>
                                <small>{{__('inpanel.profile.index.minute')}}</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6 border-left">
    @else
    <div class="col-md-12 border-left">
    @endif
        <div class="table-responsive">
            <div class="table_head text-center">
                <span class="label label-success profile_status_label">{{__('inpanel.profile.index.label.complete')}}</span>
            </div>
            <table class="table profiles success">
                <thead>
                <tr>
                    <th> {{__('inpanel.profile.index.general_profile.details')}}</th>
                    <th>{{__('inpanel.profile.index.points_received')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if( !empty($completedProfiles) )

                    @foreach($completedProfiles as $sections)
                        @php
                            $translated = $sections->doTranslate();
                        @endphp
                    <tr class="profile_rows">
                        <td>
                            <a href="@if( Route::has('inpanel.profiler.update.show') ){{route('inpanel.profiler.update.show', $sections->id)}}@endif" class="forum-item-title">{{ $translated['text'] }}</a>
                            <div class="forum-sub-title">{{ $translated['description'] }}</div>
                        </td>
                        <td>
                             <span class="views-number">
                                <!-- {{$sections->points}}<br> -->
                                
                                @if (array_key_exists($sections->general_name,$filledProfilesPoints))
                               
                                    {{$filledProfilesPoints[$sections->general_name]}} <span style='font-size:15px'>({{$filledProfilesPoints[$sections->general_name]*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})</span>
 
                                @endif
                               
                             </span>
                            <small>{{__('inpanel.profile.index.points')}}</small>
                        </td>
                        <td>
                            <div class="forum-icon">
                                <i class="far fa-check-square" style="font-size:40px;"></i>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('after-styles')
    <style>
        table.profiles > tbody > tr:hover {
            background-color: whitesmoke;
        }
        table.profiles.pending a {
            color: #337ab7;
            display: block;
            font-size: 18px;
            font-weight: 600;
        }

        table.profiles.success a {
            color: #337ab7;
            display: block;
            font-size: 18px;
            font-weight: 600;
        }
        .profile_status_label{
            font-size: 14px;
        }
    </style>
@endpush

@push('after-scripts')
    <script>
    
    @if(isset($_GET['update']))
        @include('inpanel.includes.partials.php-js.profiler_new')
        
    @endif
    </script>
@endpush
