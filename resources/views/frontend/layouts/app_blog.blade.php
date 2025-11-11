<!DOCTYPE html>
    @langrtl
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @endlangrtl
  
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Best Online Survey Platform | Paid Online Survey in US - SJ Panel')</title>
        <meta name="title" content="@yield('meta_title','Best Online Survey Platform | Paid Online Survey in US - SJ Panel')">
        <meta name="description" content="@yield('meta_description', 'SJ Panel is one the best online survey platforms for paid research surveys and make extra money online. You can start earning reward points now by completing paid online survey in US. ')">
        <meta name="google-site-verification" content="X_xKrEKIs6Gq5_zJq3lGd5ZyfEMTH5wEWMa3vapgA3k" />
        <meta name="author" content="@yield('meta_author', 'SJ Panel')">
        <meta name="keyword" content="@yield('meta_keyword','paid online survey, best survey platforms, paid research surveys, best paid survey sites, online survey research, online survey platforms, paid online survey in US')">
        @yield('meta')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

        @stack('before-styles')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-0SQ2T8ZR4E"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-0SQ2T8ZR4E');
        </script>
		
        <style>

            body, html {
                font-family: Roboto, sans-serif; 
            }
            
            body .landing-page{
                    padding:1px!important;
                }

            body{
                font-size:40px;
            }
            #hamB:focus{
                box-shadow: none;        
            }

            .mob-nav-active{
                background: #E6E4F6;
                padding: 14px;
                border-radius: 30px;
                transform: translateX(-14px);
            }

                #logoId{
                    width: 200px;
                }

            .dropdown-menu{
                min-width: 82px!important;
                min-height:5px;
                padding:0px auto;
                /* border:1px solid red; */
            }
            .dropdown-item{
                padding:0px auto;
                /* min-height:0px; */
            }

            .lang_img{
                height:20px!important;
                min-width:40px!important;
                margin-right:5px!important;
            }
            .lang_text{
                font-size:12px!important;
                text-decoration:none;
                color:black;
            }
            .lang_text2{
                font-size:14px!important;
                text-decoration:none!important;
                color:black!important;
            }
            .lang_text:hover{
                color:blue;
            }
            .footer_logo{
                height:80px;
                width:204px;
            }
            .body_content{
                /* margin-top:150px!important; */
            }

            .blink_me {
              animation: blinker 1s linear infinite;
              color: rgb(0, 92, 230);
              padding-top: 12%;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
            }

            @keyframes blinker {
              50% {
                opacity: 0;
              }
            }
         
            @media only screen and (max-width: 600px) {
                #logoId{
                    width: 45px;
                    scale: 2;
                    transform: translateX(10px);
                    margin-left:-20px!important;
                    display:none;
                }
                .footer_logo{
                    height:50px;
                    width:160px;
                }
                .hamBImg{
                    margin-left:-5px!important;
                    height:40px;
                    width:40px;
                    padding-left:-30px;
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
                .text_myhome{
                    font-size:9px!important;
                    padding-left:15px!important;
                    padding-right:15px!important;
                    /* padding-bottom:-5px!important; */
                    padding-top:5px!important;
                }
                
                .count_name{
                    font-size:5px!important;
                    margin-top:-30px!important;
                    padding-top:6px!important;
                    padding-bottom:0px!important;
                    
                }
                .dropdown{
                    min-width:40px!important;
                    padding-top:10px!important;
                }
                #img_01{
                    margin-top:-5px!important;
                }

                .lang_text{
                    font-size:10px!important;
                    margin-top:1px!important;
                    margin-bottom:1px!important;
                }
                .lang_text2{
                    font-size:12px!important;
                    margin-top:1px!important;
                    margin-bottom:1px!important;
                }
                .lang_img{
                    height:20px!important;
                    min-width:20px!important;
                    padding-bottom:2px!important;
                }
                .lang_let{
                    font-size:10px!important;
                    padding-top:-20px!important;
                }
                .body_content{
                    margin-top:80px!important;
                    margin-bottom:150px!important;
                }
            
                .botton_content{
                    margin-bottom:50px!important;
                    margin-top:-150px!important;
                }
                .bs-wizard-info{
                    font-size:10px!important;
                }

                .mobile-menu_1{
                    /* border:1px solid green; */
                    padding:0px;
                }
                .mobile_p_1{
                    width:40px!important;
                    padding:auto;
                    height:auto;
                    /* border:1px solid black; */
                }

                .mobile_p_2{
                    /* margin-top:0px!important;
                    margin-right:10px!important;
                    margin-left:0px!important; */
                    /* border:1px solid black; */
                    margin:auto;
                    padding-right:20px!important;
                    padding-top:5px!important;
                    padding-bottom:5px!important;
                    height:30px!important;
                }

                .dropdown-item {
                    margin-left: -2px!important;
                }

                .dropdown-menu.show {
                    display: block;
                    margin-left: -20px!important;
                    padding: 1px;
                }

            }

            @media only screen and (min-width: 900px) and (max-width: 1024px){
                #logoId{
                    width: 50px;
                    scale: 2;
                }

                .footer_logo{
                    height:50px;
                    width:160px;
                }
            }

            /* Faq*/
        
            section{
                font-family: Roboto !important;
            }

            .faq_selected_div{
                display: none;
            }
            #top_user_info h6{
                cursor: pointer;
                font-size: 21px;
                font-family: Roboto;
                font-size: 16px;
                font-weight: 600;
                line-height: 19px;
                letter-spacing: 0em;
                text-align: left;
                color: black;
            }
            #faq_heading{
                font-family: Roboto;
                font-size: 24px;
                font-weight: 500;
                line-height: 24px;
                letter-spacing: -0.02em;
                text-align: left;
            }
            .faq_selected_div p,
            .faq_selected_div ul li{
                color: #787878 !important;
                font-weight: 400;
                font-size: 15px !important;
                line-height: 22px;
            }
            .landing-page .navbar.navbar-scroll .navbar-brand {
                margin-top: 0;
                padding: 15px 20px 15px 20px;
            }
            .navbar-fixed-top, .navbar-static-top {
                background: #ffffff !important;
            }
            .landing-page .navbar-wrapper .navbar.navbar-scroll{
                border-bottom: none !important;   
            }
            @media(min-width: 220px) and (max-width:396px){
                .landing-page .navbar .navbar-brand{
                    margin-top: -14%;
                }
                .landing-page .navbar.navbar-scroll .navbar-brand {
                    margin-top: -14%;
                    padding: 10px;
                }
                .landing-page .navbar-wrapper .navbar.navbar-scroll {
                    padding-top: 3px;
                }
                .landing-page .navbar-wrapper .navbar {
                    padding-top: 3px;
                }
                #faq_heading {
                    margin-top: 16%;
                }
            }
            @media(min-width: 397px) and (max-width:767px){
                .landing-page .navbar .navbar-brand{
                    margin-top: 0px !important;
                }
                .landing-page .navbar.navbar-scroll .navbar-brand {
                    margin-top: 0px !important;
                }
                #faq_heading {
                    margin-top: 12%;
                }
            }
            @media(min-width: 510px) and (max-width:767px){
                #faq_heading {
                    margin-top: 5% !important;
                }
            }
            @media(min-width: 768px) and (max-width:991px){
                .navbar-right {
                    margin-top: -10%;
                }
                #faq_heading {
                    margin-top: 7%;
                }
            }
            /* FAQ */

            /* Web Story CSS added by Vikas */
            /* Light background container */
            .status-container {
                background: #ffffff; /* White background */
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15); /* Strong shadow effect */
                max-width: 1200px; /* Limit width for a clean look */
                margin: 100px auto; /* Center the container */
            }

            /* Grid layout */
            .status-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            /* Story box with white background */
            .status-box {
                text-align: center;
                cursor: pointer;
                padding: 15px;
                background: white; /* Ensures the box is visible */
                border-radius: 15px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease-in-out;
            }

            /* Hover effect */
            .status-box:hover {
                transform: scale(1.05);
            }

            /* Image styling */
            .status-img {
                width: 100%;
                aspect-ratio: 6 / 10; /* Ensures correct ratio */
                border-radius: 10px;
                object-fit: cover;
                background: white; /* Background behind images */
                padding: 5px; /* Adds spacing */
            }

            /* Story title */
            .status-title {
                font-size: 14px;
                margin-top: 10px;
                color: black;
            }

            /* Responsive Design */
            @media (max-width: 992px) {
                .status-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 768px) {
                .status-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 480px) {
                .status-grid {
                    grid-template-columns: repeat(1, 1fr);
                }
            }
        }
     /* FAQ */
	 
		/* Web Story CSS added by Vikas */
            /* Light background container */
            .status-container {
                background: #ffffff; /* White background */
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15); /* Strong shadow effect */
                max-width: 1200px; /* Limit width for a clean look */
                margin: 100px auto; /* Center the container */
            }

            /* Grid layout */
            .status-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            /* Story box with white background */
            .status-box {
                text-align: center;
                cursor: pointer;
                padding: 15px;
                background: white; /* Ensures the box is visible */
                border-radius: 15px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease-in-out;
            }

            /* Hover effect */
            .status-box:hover {
                transform: scale(1.05);
            }

            /* Image styling */
            .status-img {
                width: 100%;
                aspect-ratio: 6 / 10; /* Ensures correct ratio */
                border-radius: 10px;
                object-fit: cover;
                background: white; /* Background behind images */
                padding: 5px; /* Adds spacing */
            }

            /* Story title */
            .status-title {
                font-size: 14px;
                margin-top: 10px;
                color: black;
            }

            /* Responsive Design */
            @media (max-width: 992px) {
                .status-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 768px) {
                .status-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 480px) {
                .status-grid {
                    grid-template-columns: repeat(1, 1fr);
                }

            }	 

 </style>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="canonical" href="https://www.sjpanel.com/@yield('link_url')">
        <!-- Gritter -->
        <link href="{{ asset('vendor/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="{{ asset('vendor/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">

        <!-- Toastr style -->
        <!-- <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet"> -->

        <!-- Cookie Consent style -->
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
        @stack('after-styles')
    </head>
    <body id="page-top" class="landing-page">
        <div id="app">
            @include('includes.partials.logged-in-as')

            @include('frontend.includes.navb')

            <div class="container-fluid">
                @include('includes.partials.messages')

                @yield('content')
            </div>
        
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}

        <!-- Theme JS -->
        <script src="{{asset('vendor/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
        <script src="{{asset('vendor/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

        <!-- Custom and plugin javascript -->
        <script src="{{asset('vendor/js/inspinia.js')}}"></script>

        <script src="{{asset('vendor/js/plugins/wow/wow.min.js')}}"></script>

        <!-- Toastr -->
        <script src="{{asset('vendor/js/plugins/toastr/toastr.min.js')}}"></script>

        <!-- Cookie Consent Script -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
	        window.addEventListener("load", function(){
                window.cookieconsent.initialise({
                    "palette": {
                        "popup": {
                            "background": "#237afc"
                        },
                        "button": {
                            "background": "#fff",
                            "text": "#237afc"
                        }
                    },
                    "position": "bottom-left",
                    "type":"opt-out",
                    "dismissOnWindowClick":true,
                    "onStatusChange": function(status, chosenBefore) {
                        var type = this.options.type;
                        var didConsent = this.hasConsented();
                        if (type == 'opt-in' && didConsent) {
                            $('.cc-window').css('display', 'none');
                        }
                        if (type == 'opt-out' && !didConsent) {
                            $('.cc-window').css('display', 'none');
                        }
                    },
                    "content": {
                        "message": 'This website uses cookies to improve your experience.',
                        "allow": 'Allow cookies',
                        "link": 'Learn more',
                        "policy": 'Cookie Policy',
                        "target": '_blank',
                        "deny": 'Decline',
                        "href": "{{route('frontend.cms.cookie')}}"
                    }
                })
            });
            

            $(document).ready(function () {

                $('body').scrollspy({
                    target: '.navbar-fixed-top',
                    offset: 80
                });

                // Page scrolling feature
                $('a.page-scroll').bind('click', function(event) {
                    var link = $(this);
                    $('html, body').stop().animate({
                        scrollTop: $(link.attr('href')).offset().top - 50
                    }, 500);
                    event.preventDefault();
                    $("#navbar").collapse('hide');
                });
            });

            var cbpAnimatedHeader = (function() {
                var docElem = document.documentElement,
                    header = document.querySelector( '.navbar-default' ),
                    didScroll = false,
                    changeHeaderOn = 200;
                function init() {
                    window.addEventListener( 'scroll', function( event ) {
                        if( !didScroll ) {
                            didScroll = true;
                            setTimeout( scrollPage, 250 );
                        }
                    }, false );
                }
                function scrollPage() {
                    var sy = scrollY();
                    if ( sy >= changeHeaderOn ) {
                        $(header).addClass('navbar-scroll')
                    }
                    else {
                        $(header).removeClass('navbar-scroll')
                    }
                    didScroll = false;
                }
                function scrollY() {
                    return window.pageYOffset || docElem.scrollTop;
                }
                init();

            })();

            // Activate WOW.js plugin for animation on scrol
            new WOW().init();

        </script>
        @stack('after-scripts')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123538092-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-123538092-1');
        </script>
        {{--@include('includes.partials.ga')--}}

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="{{asset('css/bootstrap.bundle.js')}}"></script>
    </body>
</html>