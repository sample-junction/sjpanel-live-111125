@extends('frontend.layouts.app_blog')
@section('link_url','pages/contact')
@section('meta_title','Contact - SJ Panel')
@section('title','Contact - SJ Panel')
@section('meta_description','Get in touch with SJ Panel for high-quality panel products. Contact us today to discuss your requirements and receive a quote.')
@section('content')

<div class="container pb-3 mt-5 body_content">
    <div class="loginColumns animated fadeInDown">
        <div class="row col-lg-12">
            <div id="wrapper">
                <div class="row border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h1> {{__('cms.help_support.heading')}}</h1>
                    </div>
                    <div class="wrapper wrapper-content">
                        <div class="row animated fadeInRight">
                            <div class="col-lg-8">
                                <div class="ibox">
                                    <div class="ibox-content text-left " style="padding-left:20px;padding-right:20px;">
                                        <h3 class="m-b-xxs">
                                           {{-- {{__('cms.help_support.title')}}
                                            <i class="fa fa-envelope" aria-hidden="true"></i>--}}
                                        </h3>
                                        <h5> {{__('cms.help_support.details_1')}}</h5><br>
                                        <h5>1. {{__('cms.help_support.details_2')}}<a href="/support">{{__('cms.help_support.details_3_support')}} </a></h5><br>
                                       {{-- <h5> {{__('cms.help_support.details_4')}}</h5>
                                        {{--<p>
                                            "Sample Junction"
                                            <br>
                                            75-76, Pocket-13, Sector - 21,
                                            <br>
                                            Rohini, Delhi - 110085, India
                                            <br>
                                            Landline : +91-11-45670889 
                                        </p>--}}
                                        <h5>2.
                                            {{__('cms.help_support.details_start_chat')}} &nbsp;<i class="fa fa-arrow-right"></i>
                                        </h5><br>
                                        <h5>3.
                                            {{__('cms.help_support.email_drop')}}&nbsp;<a href="mailto:support@sjpanel.com">support@sjpanel.com</a>
                                        </h5><br>
                                        
                                        
                                        <br>
                                        <hr>
                                        <h5>
                                            {!! __('frontend.index.contact_us.mailing_social_connection') !!}
                                        </h5>
                                        <ul class="list-inline social-icon" style="display:flex;">
                                            <li><a class="ms-3" href="//twitter.com/samplejunction"><i class="fab fa-twitter"></i></a>
                                            </li>
                                            <li><a class="ms-3" href="//facebook.com/samplejunction"><i class="fab fa-facebook"></i></a>
                                            </li>
                                            <li><a class="ms-3" href="//www.linkedin.com/company/sample-junction"><i class="fab fa-linkedin"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ibox">
                                    <div class="ibox-content text-center">
                                        <h3 class="m-b-xxs">
                                            {{__('cms.help_support.chat_title')}}
                                            <img style="width: 20%;" src="{{ asset('/img/chat_support.png') }}" class="logo-name" alt="chat">
                                        </h3>
                                        <hr>
                                        <!--<a href="javascript:void(0);" id="chat_us" class="btn btn-primary drift-open-chat"> {{__('cms.help_support.chat_button')}} <i class="fas fa-comments"></i> </a>-->

                                        <a  href="javascript:void(Tawk_API.toggle())" id="chat_us" class="btn btn-primary">{{__('cms.help_support.chat_button')}} <i class="fas fa-comments"></i> </a>
                                        <div class="question_loader" style="display:none;">
                                            <div class="sk-spinner sk-spinner-wave">
                                                <div class="sk-rect1"></div>
                                                <div class="sk-rect2"></div>
                                                <div class="sk-rect3"></div>
                                                <div class="sk-rect4"></div>
                                                <div class="sk-rect5"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="container">
    @include('frontend.includes.blog_footer')
    </div>
</div>

@endsection



<style>
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
    .landing-page .social-icon a {
    background: #1080d0;
    color: #fff;
    padding: 8px 7px 7px 8px !important;
    height: 30px;
    width: 30px;
    display: block;
    border-radius: 50px;
}
.ibox{
    border: 1px solid #e7eaec  !important;
}
.tawk-branding{
    display: none !important;
}
</style>

<!-- @push('after-scripts') -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/640852554247f20fefe4a6c3/1gr083899';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

<!-- @endpush -->
