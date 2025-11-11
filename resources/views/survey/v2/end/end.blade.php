@extends('survey.v2.layout.app')

@section('title', 'Survey End' )

@section('meta')
    @if( !empty($finalRedirectUrl) )
        <meta http-equiv="refresh" content="2;url={{$finalRedirectUrl}}" />
    @endif
@endsection

{{--@if( !empty($rowSurvey) && $rowSurvey->sylanguageid == 7 )
@section('direction', 'rtl' )
@endif--}}

@push('after-styles')
    <link href="{{asset('end/end.css')}}" rel='stylesheet' type='text/css' media="all" />
@endpush

@section('content')
<div id="wrapper">
    <div class="content">
        <div id="logo">
            <img src="{{ asset('images/logo.png')}}" border="0"/>
        </div>
        @includeWhen( $status == 1 , 'survey.complete')
        @includeWhen( $status == 2 , 'survey.terminate')
        @includeWhen( $status == 3 , 'survey.quotafull')
        @includeWhen( $status == 4 , 'survey.quality_terminate')
        @includeWhen( $status == 10 , 'survey.unassign')
        @includeWhen( $status == 11 , 'survey.cpiupdate')
        @includeWhen( $status == 12 , 'survey.email')
        @includeWhen( $status == 13 , 'survey.dashboard')
        @includeWhen( $status == 14 , 'survey.surveypause')
        @includeWhen( $status == 15 , 'survey.blacklisteduser')
        @includeWhen( $status == 16 , 'survey.hold_and_closed')
        @includeWhen( !in_array($status, [1,2,3,4,10,11,12,13,14,15,16]) , 'survey.legacy.includes.other')

    </div>
</div>
@endsection
