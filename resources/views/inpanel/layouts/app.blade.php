<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl

    <head>
        <link rel=”dns-prefetch” href=”//sjpanel.com”>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:500,400">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'SJ Panel')">
        <meta name="author" content="@yield('meta_author', 'SJ Panel')">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/inpanel.css')) }}
        {{--<link href="{{ asset('vendor/css/plugins/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">--}}
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        {{--<link href="{{ asset('vendor/css/plugins/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">--}}
        {{--Toaster--}}
        <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
        <!-- Gritter -->
        <link href="{{ asset('vendor/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

        <link href="{{ asset('vendor/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">

        <!-- Toastr style -->

        @stack('after-styles')
            <style>
                .tippy-tooltip{
                    font-size: inherit !important;
                }
                .toast-success{
                    background-color: #51a351;
                }
                .toast-error{
                    background-color: #bd362f;
                }
            </style>
        <style>
            .nav-total_points{
                font-size: 16px;
            }
        </style>
        <style>
            .fas.fa-running {
                color: white;
            }

        </style>
        <style>
            .nav-total_points{
                font-size: 16px;
            }
            /*.tooltip-inner {
                background-color: #00cc00;
            }*/
            /*.tooltip.bs-tooltip-right .arrow:before {
                border-right-color: #00cc00 !important;
            }
            .tooltip.bs-tooltip-left .arrow:before {
                border-right-color: #00cc00 !important;
            }
            .tooltip.bs-tooltip-bottom .arrow:before {
                border-right-color: #00cc00 !important;
            }
            .tooltip.bs-tooltip-top .arrow:before {
                border-right-color: #00cc00 !important;
            }*/
            .tooltip {
                position: fixed;
            }
			@media (max-width: 768px) {span.survey_list{width:100%; !important}

span.label.label-info {
    position: absolute!important;
    top: 50% !important;
    left: 0 !important;
    transform: translate(0%, -50%) !important;
}}
        </style>
    </head>
    <body class="fixed-sidebar no-skin-config full-height-layout">
        <div id="app">
            <div id="wrapper">
                @include('includes.partials.logged-in-as')
                @include('inpanel.includes.nav')
                <div id="page-wrapper" class="gray-bg dashbard-1">
                    @include('inpanel.includes.topbar')
                        @include('includes.partials.messages')
                        @yield('content')
                    @include('inpanel.includes.footer')
                </div>
            </div>
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/inpanel.js')) !!}
        <script>
            $(document).ready(function(){
                var remain_point = $('.nav-text').attr('data-remaining_points');
            });
        </script>
        <script src="{{asset('vendor/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
        <script src="{{asset('vendor/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- Custom and plugin javascript -->
        <script src="{{asset('vendor/js/inspinia.js')}}"></script>
        <script src="{{asset('vendor/js/plugins/pace/pace.min.js')}}"></script>
        <!-- jQuery UI
        <script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script> -->
        <!-- GITTER -->
        <script src="{{asset('vendor/js/plugins/gritter/jquery.gritter.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{asset('vendor/js/plugins/toastr/toastr.min.js')}}"></script>
        @stack('after-scripts')
        {{--@include('includes.partials.ga')--}}
    </body>
</html>
