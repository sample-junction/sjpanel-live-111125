@extends('inpanel.layouts.app')

@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div id="profile-success" style="display:none;">
            </div>
            <div class="ibox-content forum-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="forum-title header">
                            <div class="pull-left forum-desc">
                                @if( !empty($filledProfilesCount) && !empty($allPointsCount) && $allPointsCount!==$filledProfilesCount)
                                    <p>{!! __('inpanel.profile.index.remaining_points_message',["points" => ($allPointsCount-$filledProfilesCount.' ('.($allPointsCount-$filledProfilesCount)*100*config('app.points.metric.conversion')."cents)")]) !!}</p><br />
                                @endif
                            </div>
                            <div class="pull-right forum-desc">
                                @if( !empty($filledProfilesCount) && !empty($allPointsCount) )
                                    <small><b>{{__('inpanel.profile.index.credit_points')}}: {{ $filledProfilesCount}} ({{$filledProfilesCount*100*config('app.points.metric.conversion') }} {{__('inpanel.dashboard.cents')}})</b></small><br />
                                    <small><b>{{__('inpanel.profile.index.remaining_points')}}: {{ $allPointsCount-$filledProfilesCount }} ({{ ($allPointsCount-$filledProfilesCount)*100*config('app.points.metric.conversion') }} {{__('inpanel.dashboard.cents')}})</b></small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @includeWhen(!$twinview, 'inpanel.profiler.includes.index.single_view')
                @includeWhen($twinview, 'inpanel.profiler.includes.index.twin_view')
            </div>
        </div>
    </div>
    
@endsection


@push('after-scripts')
<script>
    @if(Session::has('message'))
    $(document).ready(function () {
        var message_div = $('#profile-success');
        console.log('message_div=='+message_div);
        toastr.success("{!! Session::get('message')!!}", 'Success');
    })
    @endif
    @php Session::forget('message'); @endphp

</script>
    @endpush

