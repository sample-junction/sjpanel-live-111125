@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))
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
</style>

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight container-login100">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Set up Google Authenticator</div>
                        <div class="panel-body" style="text-align: center;">
                            <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                            <div>
                                <img src="{{ $QR_Image }}">
                            </div>
                            <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                            <div>
                                <a href="{{route('frontend.auth.2fa.register',$user)}}"><button class="btn-primary">Complete Registration</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
