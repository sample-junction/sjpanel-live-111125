@extends('frontend.layouts.app_2fa')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))

<style>
    .container-login100 {
        width: auto;
        /* min-height: 100vh; */
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        /* background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-image: url("/img/bg-01.jpg"); */
    }
    .white, .white > a{
        color:white;
    }
    img {
        /* display: block; */
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
</style>
<style>
    html * {

 font-family: roboto;

       }  
</style>

<style>
    .row-1 {
        margin-top: 170px;
        border-radius: 19px;
        background: #F8F9FD;
        box-shadow: 5px 5px 10px rgb(213, 215, 232); 
        width:auto;
    }
    /* .card {

         scale:0.5;
         height: auto;
         width: 550px;
         margin-left: -100px;

    } */

    @media only screen and (max-width: 767px) {
        /* For mobile devices */
        .row-1 {
            width: auto%;
        }

        /* .card {
            margin-left: 3px;
        } */

    }
</style>

@section('content')
<div class="panel panel-default" style="justify-content:center; border:none!important; display:flex;">
    <div class="row-1">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight container-login100">
                <div class="ibox-content col-lg-10" style="max-width:600px;">
                    {{-- <div class="card"> --}}
                        <div class="card-body">
                            <div class="row">
                                <img src="{{asset('img/frontend/sad.png')}}" style="width:180px;" /><br>
                                <h1 class="heading" align="middle"><strong>{{__('frontend.register.unsubscribe.title')}}</strong></h1>
                                <p class="content" align="middle">{{__('frontend.register.unsubscribe.details',['email' => "  support@sjpanel.com"])}}</p>
                            </div>
                            <div class="row">
                                <div class="social-media-icons" style="text-align: center;">
                                    <span>{{__('frontend.register.email_sent.follow_us')}}</span><br>
                                    <ul style="padding: 0px;">
                                        <li><a href="https://facebook.com/SJPanel " target="_blank"><i class='fab fa-facebook fa-2x'></i></a></li>
                                        <li><a href="https://x.com/sjpanelsurvey" target="_blank"><i class='fab fa-twitter fa-2x'></i></a></li>
                                        <li><a href="https://www.linkedin.com/company/sjpanel/" target="_blank"><i class='fab fa-linkedin fa-2x'></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-footer"> --}}
                            <div class="row" style="text-align: center;">
                                <a href="{{route('frontend.index')}}" class="home btn btn-success btn-outline" style="background-color: rgb(16, 128, 208)!important; color: white!important; ">{{__('frontend.register.email_sent.home')}}</a>
                            </div>
                        {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
       <!-- footer -->
 
            <div class="row mt-5 pt-5">
 
                <div class="col-12 text-center" >
     
                    <img  src="{{url('img/jpblog/img/logo.png')}}" alt="logo" class="img-fluid" style="width: 200px;height: 60px; margin-bottom:20px;">
     
                </div>
     
                <!--<div class="col-12 mt-3 text-center" >
     
                    <p style="font-weight: 600;">{{__('frontend.modes.email_auth.footer_9')}}</p>
     
                </div>-->
     
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
