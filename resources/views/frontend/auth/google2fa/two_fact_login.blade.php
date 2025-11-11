@extends('frontend.layouts.app_2fa')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))
<style>
    .container-login100 {
        width: auto;
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
    }
    .white, .white > a{
        color:white;
    }
</style>
<style>
    .nav_new {
        list-style: none;
        display: flex;
        justify-content: space-between;
    }
    .nav_new li a{
        text-decoration: none;
        color: black;
    }
    .nav_new li a:hover{
        color:blue;
    }

    .nav_new_2{
        list-style: none;
        display: flex;
        justify-content: center;
    }
    .nav_new_2 li a{
        text-decoration: none;
        color: black;
        padding: 20px;
        font-size: 14px;
    }
    .nav_new_2 li a:hover{
        color:blue;
    }
    .row-cst {
        display: grid;
        grid-template-columns: auto auto ;
        border-top: 2px solid grey;
        padding-top : 20px; 

    }
    @media only screen and (max-width: 600px) {
                .hamBImg{
                    margin-left:-10px!important;
                }

                .text-light2{
                    font-size:10px!important;
                    /* font-weight: 100!important; */
                }
                .text_login{
                    font-size:9px!important;
                    padding-left:6px!important;
                    padding-right:6px!important;
                    /* padding-bottom:-5px!important; */
                    padding-top:5px!important;
                }
    }
    

    @media only screen and (max-width: 767px) {
        /* For mobile devices */
        .row-1 {
            margin-left: -45px;
        }

       .panel panel-default {
        width:115%;      
       }

    }
</style>
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight container-login100  bg-white" style="height: 80px!important;padding-bottom: 0px;">
        <div class="container" >
            <div class="row-1" style= "justify-content: center;display: flex; margin-left: 0px;">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style= "margin-top:170px;border-radius: 19px;background: #F8F9FD;box-shadow: 5px 5px 10px rgb(213, 215, 232); width:110%; height:250px;">
                        <div class="endpage_question_loader" style="display:none; ">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <div class="select_modes" >
                            <div class="panel-heading">
                                <h3><strong>{{__('frontend.modes.index.heading')}}</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{__('frontend.modes.index.label')}}</label>
                                    <div class="col-md-9 col-form-label">
                                       {{-- <div class="form-check">
                                            <input class="form-check-input" id="mode" type="radio" value="1" name="mode">
                                            <label class="form-check-label" for="radio1">{{__('frontend.modes.index.radio_1')}}</label>
                                        </div>--}}
                                        <div class="form-check">
                                            <input class="form-check-input" id="mode" type="radio" value="2" name="mode">
                                            <label class="form-check-label" for="mode">{{--__('frontend.modes.index.radio_2')--}}EMAIL AUTHENTICATION</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button id="select" class="btn btn-primary">
                                            {{__('frontend.modes.index.button')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
 
    <div class="row mt-5 pt-5">
 
        <div class="col-12 text-center" >

            <img  src="{{url('img/jpblog/img/logo.png')}}" alt="logo" class="img-fluid" style="width: 100px;height: 30px; margin-bottom:20px;">

        </div>

        <div class="col-12 mt-3 text-center" >
            <!--<p style="font-weight: 600;">{{__('frontend.modes.email_auth.footer_9')}}</p> -->
        </div>

        <div class="col-12 mt-2 text-center pb-4 border-bottom">

            <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.privacy')}}" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.index.footer.links.privacy_policy')}}</a> </span>
            <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.cookie')}}" class="text-black" style="text-decoration: none; color:black;">{{__('strings.emails.auth.confirmation.cookie')}}</a> </span>
            <span class="me-3 me-lg-4"><a href="/pages/rewards" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.modes.email_auth.footer_3')}}</a></span>
            <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.referral_policy')}}" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.index.footer.links.referral_policy')}}</a> </span>
            <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.safeguard')}}" class="text-black" style="text-decoration: none; color:black;">{{__('strings.emails.auth.confirmation.safeguards')}}</a> </span>
            <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.term_condition')}}" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.index.footer.links.term_condition')}}</a> </span>
            <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.faq')}}"  class="text-black" style="text-decoration: none; color:black;">{{__('strings.emails.auth.confirmation.faq')}}</a> </span>
            <span class=""> <a href="/blog" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.modes.email_auth.footer_8')}}</a> </span>

        </div>
       
        <div class="col-12 col-lg-6 text-center text-lg-start mt-3 mt-lg-4">
            <p class="mt-1">{{__('frontend.modes.email_auth.footer_10')}}</p>
        </div>

        <div class="col-12 col-lg-6 text-center text-lg-end mt-lg-4">
            <p class="mt-lg-1">{{__('frontend.modes.email_auth.footer_11')}}</p>
        </div>

    </div>
@endsection


@push('after-styles')
    <style>
        #projects-show{
            min-height: 500px;
        }
        .sk-spinner-wave.sk-spinner {
            margin: 0 auto;
            width: 50px;
            height: 30px;
            text-align: center;
            font-size: 10px;
        }
        .sk-spinner-wave div {
            background-color: #1ab394;
            height: 100%;
            width: 6px;
            display: inline-block;
            -webkit-animation: sk-waveStretchDelay 1.2s infinite ease-in-out;
            animation: sk-waveStretchDelay 1.2s infinite ease-in-out;
        }
        .sk-spinner-wave .sk-rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }
        .sk-spinner-wave .sk-rect3 {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }
        .sk-spinner-wave .sk-rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }
        .sk-spinner-wave .sk-rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }
        @-webkit-keyframes sk-waveStretchDelay {
            0%,
            40%,
            100% {
                -webkit-transform: scaleY(0.4);
                transform: scaleY(0.4);
            }
            20% {
                -webkit-transform: scaleY(1);
                transform: scaleY(1);
            }
        }
        @keyframes  sk-waveStretchDelay {
            0%,
            40%,
            100% {
                -webkit-transform: scaleY(0.4);
                transform: scaleY(0.4);
            }
            20% {
                -webkit-transform: scaleY(1);
                transform: scaleY(1);
            }
        }

        .error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding:1px 20px 1px 20px;
        }
    </style>
@endpush
@push('after-scripts')
    <script>
           /* $(document).on('click','button#select',function (e) {
                var mode = $('input[type="radio"]:checked').val();
                var headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
                if (!mode || mode === 0) {
                    return false;
                }
                $('div.endpage_question_loader').show();
                $('.select_modes').html('');
                axios.get("{{ route('frontend.auth.2fa.otp.mode') }}", {
                    params: {
                        mode: mode
                    }
                }).then(function (response) {
                    if (response.status === 200) {
                        var $html = response.data;
                        $('.select_modes').html($html);
                    }
                }).catch(function (error) {
                    alert('error occured');
                    console.log(error);
                }).then(function () {
                    jQuery('.endpage_question_loader').hide();
                });
            })*/
            
        $(document).ready(function(){
            EmailCall();
        })
            $(document).on('click','button#select',function (e) {
                var mode = $('input[type="radio"]:checked').val();
                var headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
                if (!mode || mode === 0) {
                    return false;
                }
                $('div.endpage_question_loader').show();
                $('.select_modes').html('');
                axios.get("{{ route('frontend.auth.2fa.otp.mode') }}", {
                    params: {
                        mode: mode
                    }
                }).then(function (response) {
                    if (response.status === 200) {
                        var $html = response.data;
                        $('.select_modes').html($html);
                    }
                }).catch(function (error) {
                    alert('error occured');
                    console.log(error);
                }).then(function () {
                    jQuery('.endpage_question_loader').hide();
                });
            })
            function EmailCall(){
                 var mode = 2;
                var headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
                if (!mode || mode === 0) {
                    return false;
                }
                $('div.endpage_question_loader').show();
                $('.select_modes').html('');
                axios.get("{{ route('frontend.auth.2fa.otp.mode') }}", {
                    params: {
                        mode: mode
                    }
                }).then(function (response) {
                    if (response.status === 200) {
                        var $html = response.data;
                        $('.select_modes').html($html);
                    }
                }).catch(function (error) {
                    alert('error occured');
                    console.log(error);
                }).then(function () {
                    jQuery('.endpage_question_loader').hide();
                });
            }
    </script>


    
@endpush
