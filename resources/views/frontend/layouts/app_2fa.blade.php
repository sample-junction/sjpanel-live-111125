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
       {{--<meta name="title" content="@yield('meta_title','Best Online Survey Platform | Paid Online Survey in US - SJ Panel')">--}}
       <meta name="description" content="@yield('meta_description', 'SJ Panel is one the best online survey platforms for paid research surveys and make extra money online. You can start earning reward points now by completing paid online survey in US. ')">
	<meta name="google-site-verification" content="X_xKrEKIs6Gq5_zJq3lGd5ZyfEMTH5wEWMa3vapgA3k" />
	<meta name="author" content="@yield('meta_author', 'SJ Panel')">
    <meta name="keyword" content="@yield('meta_keyword','paid online survey, best survey platforms, paid research surveys, best paid survey sites, online survey research, online survey platforms, paid online survey in US')">
    @yield('meta')
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">


    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="canonical" href="https://www.sjpanel.com/@yield('link_url')">
        <!-- Gritter -->
        <link href="{{ asset('vendor/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
        <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="{{ asset('vendor/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">

        <!-- Toastr style -->
        <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
        /* 
            body, html {
                font-family: Roboto, sans-serif; 
            } */

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
                /* min-height: 21px; */
                /* min-height:0px; */
            }

            .lang_img{
                height:20px!important;
                min-width:40px!important;
                margin-right:5px!important;
                margin-left: 0px!important;
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

            .flag_div {

                display: block!important;
                margin: 10px -11px;

            }
            .flag_div li{
                display: block!important;
            }
            /* .flag_div li img{

                margin-left: -60px!important;
                margin-right: 10px!important;
                

            } */


         
         

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

                /* .hamBImg{
                    margin-left:-10px!important;
                }

                .text-light2{
                    font-size:9px!important;
                    /* font-weight: 100!important; */
                /* }
                .text_login{
                    font-size:9px!important;
                    padding-left:8px!important;
                    padding-right:8px!important;
                    padding-bottom:-5px!important;
                    padding-top:5px!important;
                } */ 

                
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

                .mobile_p_2{
                    margin-top:0px!important;
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
                .mobile_p_2 {
                    margin-right: 0px!important;
                    margin-left: -20px!important;
                }
                #hamB{
                    margin-right: 0px!important;
                    margin-left: -10px!important;

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


        </style>
       
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="canonical" href="https://www.sjpanel.com/@yield('link_url')">
        <!-- Gritter -->
        <link href="{{ asset('vendor/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
        <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="{{ asset('vendor/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">

        <!-- Toastr style -->
        <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

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

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="{{asset('css/bootstrap.bundle.js')}}"></script> 


        @stack('after-scripts')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123538092-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());



            gtag('config', 'UA-123538092-1');
        </script>
    </body>
</html>
