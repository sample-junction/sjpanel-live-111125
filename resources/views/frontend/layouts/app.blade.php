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

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}
 <!-- Google tag (gtag.js) -->

		<script  src="https://www.googletagmanager.com/gtag/js?id=G-0SQ2T8ZR4E"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());



            gtag('config', 'G-0SQ2T8ZR4E');
        </script>
        
       <!-- Google tag (gtag.js) -->
		<script  src="https://www.googletagmanager.com/gtag/js?id=AW-11352794455"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'AW-11352794455');
		</script>

        <style>
            li.language_dropdown > ul.all_language_list > li > a, li.language_dropdown > ul.all_language_list > div > li > a {
                color: #5e6d77 !important;
                font-size: 12px !important;
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

        </style>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="canonical" href="https://www.sjpanel.com/@yield('link_url')">
        <!-- Gritter -->
        <link href="{{ asset('vendor/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
        <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css">
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

        @if(Active::checkRoute('frontend.index'))
            @include('frontend.includes.nav')
        @elseif(Request::path() == '2fa')
            @include('frontend.includes.nav3')
        @else
            @include('frontend.includes.nav2')
        @endif

        
            {{--<div class="container">

            </div>--}}

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
        </script>

        <script>

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
        <script  src="https://www.googletagmanager.com/gtag/js?id=UA-123538092-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());



            gtag('config', 'UA-123538092-1');
        </script>
        {{--@include('includes.partials.ga')--}}


        
    </body>
   
</html>
