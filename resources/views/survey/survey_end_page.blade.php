@extends('inpanel.layouts.app')

@section('content')
    <style>
        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url("/img/bg-01.jpg");
        }
        .white, .white > a{
            color:white;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .ul {
            /* for IE below version 7 use `width` instead of `max-width` */
            max-width: 800px;
            margin: auto;
        }
        li {
            display:inline-block;
            *display:inline; /*IE7*/
            margin-right:10px;
        }
        .home {
            text-align: center;
        }
    </style>
    {{--<div class="wrapper wrapper-content animated fadeInRight">--}}
    <div class="row">
        <div class="col-lg-12">
            @includeWhen( $status == 1 , 'inpanel.survey.includes.survey_complete_page')
            @includeWhen( $status == 2 , 'inpanel.survey.includes.survey_terminate_page')
            @includeWhen( $status == 3 , 'inpanel.survey.includes.survey_quotafull_page')
            @includeWhen( $status == 4 , 'inpanel.survey.includes.survey_quality_terminate_page')
        </div>
    </div>
    {{-- </div>--}}
@endsection
@push('after-styles')
@endpush
