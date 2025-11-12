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
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'SJ Panel')">
        <meta name="author" content="@yield('meta_author', 'SJ Panel')">
        @yield('meta')

        @stack('before-styles')

        {{ style(mix('css/frontend.css')) }}

        <style>
            li.language_dropdown > ul.all_language_list > li > a, li.language_dropdown > ul.all_language_list > div > li > a {
                color: #5e6d77 !important;
                font-size: 12px !important;
            }
        </style>

        <!-- Gritter -->
        <link href="{{ asset('vendor/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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

            @include('frontend.includes.promo_nav')

            <div class="row">
                @if(( !Active::checkRoute('frontend.auth.register')) && (!Active::checkRoute('frontend.auth.login')) )
                    @include('includes.partials.messages')
                @endif
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
                    "theme": "classic",
                    "position": "bottom-left",
                    "content": {
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
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123538092-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());



            gtag('config', 'UA-123538092-1');
        </script>
        {{--@include('includes.partials.ga')--}}
    </body>
</html>
