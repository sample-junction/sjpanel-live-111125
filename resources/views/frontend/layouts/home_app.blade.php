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

    <meta name="description" content="@yield('meta_description', 'SJ Panel is one the best online survey platforms for paid research surveys and make extra money online. You can start earning reward points now by completing paid online survey in US. ')">
    <meta name="google-site-verification" content="X_xKrEKIs6Gq5_zJq3lGd5ZyfEMTH5wEWMa3vapgA3k" />
    <meta name="author" content="@yield('meta_author', 'SJ Panel')">
    <meta name="keyword" content="@yield('meta_keyword','paid online survey, best survey platforms, paid research surveys, best paid survey sites, online survey research, online survey platforms, paid online survey in US')">
    @yield('meta')

    <link href="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/slick.css?v2022">
    <link rel="stylesheet" type="text/css" href="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/slick-theme.css?v2022">


    <!-- Toastr style -->

    <link href="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/toastr.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('before-styles')

    <!-- Google tag (gtag.js) -->


    <script src="https://www.googletagmanager.com/gtag/js?id=G-0SQ2T8ZR4E"></script>


    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-0SQ2T8ZR4E');
    </script>


    <!-- Google tag (gtag.js) -->

    <script src="https://www.googletagmanager.com/gtag/js?id=AW-11352794455"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());


        gtag('config', 'AW-11352794455');
    </script>


    <style>
        #hamB:focus {
            box-shadow: none;
        }

        .nav-list {
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
        }

        .mob-nav-active {
            background: #E6E4F6;
            padding: 14px;
            border-radius: 30px;
            transform: translateX(-14px);
        }

        #logoId {
            width: 135px;
        }


        .banner-font {
            font-size: 40px;
            line-height: 55px;
        }

        .bg-banner {
            background-image: url('https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/Home%20Page%20Banner%202nd.png');
            height: auto;
            background-position: center;
            background-size: cover;
        }

        /* css added by Anil */
        .bg-app-banner {
         position: relative;
            background: linear-gradient(90deg,rgba(0, 85, 164, 1) 0%, rgba(0, 85, 164, 1) 51%, rgba(251, 172, 1, 1) 60%);
        background-position: center;
        background-size: cover;
        height: auto;
        overflow: hidden;
        }

        /* css added by Anil End */

        .bg-banner-2 {
            background-image: url('https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/Home%20Page%20Banner1.png');
            height: auto;
            background-position: center;
            background-size: cover;
        }

        .who-we-card-1 {
            background: #f8f9fd;
            height: 440px;
        }

        .who-we-card-2 {
            background: #f8f9fd;
            height: 440px;
        }

        .contact-round-1 {
            border-radius: 20px 0px 0px 20px;
        }

        .contact-round-2 {
            border-radius: 0px 20px 20px 0px;
        }

        .who-we-card-1 {
            border-radius: 15px;
        }

        .who-we-card-2 {
            border-radius: 15px;
        }



        /* SLIDER */

        .slider {
            width: 100%;
            margin: 50px auto;
        }

        .slick-slide {
            margin: 0px 20px;
        }

        .slick-slide img {
            display: inline-block;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }


        .slick-slide {
            transition: all ease-in-out .3s;
            opacity: 1;
        }

        .slick-active {
            opacity: 1;
        }

        .slick-current {
            opacity: 1;
        }

        .slick-prev {
            transform: translateX(0px);
        }

        .slick-next {
            transform: translateX(0px);
        }

        .regular-2 .slick-prev {
            display: none !important;
        }

        .regular-2 .slick-next {
            display: none !important;
        }

        .regular-3 .slick-prev {
            display: none !important;
        }

        .regular-3 .slick-next {
            display: none !important;
        }

        .regular-3 .row {
            width: 110% !important;
        }

        .center .slick-prev {
            display: none !important;
        }

        .center .slick-next {
            display: none !important;
        }

        .center div img {
            scale: 1.2;
        }


        /* ACCORDIAN */

        button.accordion-button {
            background: none !important;
        }

        button.accordion-button:focus {
            box-shadow: none !important;
        }


        /* TABLE */

        table tr {
            border-bottom: 1px solid #F9EFCD;
        }

        table thead tr {
            border-bottom: 2px solid #efe1b2;
        }

        table tr td {
            padding-top: 24px;
            padding-bottom: 24px;
            padding-left: 15px;
            font-weight: 600;
            font-size: 16px;
        }

        table tr th {
            padding: 15px;
            font-weight: 500;
            font-size: 16px;
        }


        /* CONTACT */

        input.contact,
        textarea.contact {
            width: 100%;
            padding: 7px;
            border: 1px solid #E6E6E6;
            border-radius: 5px;
        }

        .red_list {
            border: 0;
        }


        /* testimonials */

        .cst-card-test {
            height: 240px;
        }


        /* banner */

        .b-left {
            scale: 2;
            transform: translateX(-20px);
        }

        .b-right {
            scale: 2;
            transform: translateX(20px);
        }

        .lang_text {
            font-size: 12px !important;
            text-decoration: none;
            color: black;
        }

        .lang_text2 {
            font-size: 14px !important;
            text-decoration: none;
            color: black;
        }


        .list-move {
            animation: scroll-top 5s linear infinite;
        }

        .nav-list.active {
            font-weight: bold;
        }

        @keyframes scroll-top {
            0% {
                transform: translateY(50%);
            }

            100% {
                transform: translateY(-35%);
            }
        }

        /* pop-up */

        #popup-sj {
            position: fixed;
            top: 50%;
            left: 53%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display: none;
            background: white;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .5) !important;
        }

        .pop-up-main-img {
            height: 315px;
        }

        @media only screen and (max-width: 600px) {

            #logoId {
                width: 50px;
                scale: 2;
                transform: translateX(10px);
            }

            .banner-font {
                font-size: 27px;
                line-height: 40px;
            }

            .bg-banner {
                background-image: url('images/Home Page Banner Mobile.png');
                height: auto;
                background-position: bottom;
                background-size: cover;
            }

            .right-bn-img {
                scale: 0.8;
            }

            .bg-banner-2 {
                background-image: url('images/Home Page Banner 2nd Mobile1.png');
                height: auto;
                background-position: center;
                background-size: cover;
            }

            .who-we-card-1 {
                border-bottom: 1px solid #E6E6E6;
                border-radius: 10px 10px 0px 0px;
                height: auto;
            }

            .who-we-card-2 {
                border-radius: 0px 0px 10px 10px;
                height: auto;
            }

            .contact-round-1 {
                border-radius: 20px 20px 0px 0px;
            }

            .contact-round-2 {
                border-radius: 0px 0px 20px 20px;
            }

            .blog-btn {
                width: 90%;
            }

            .faq-text {
                font-size: 23px;
            }

            .cst-card-test {
                height: 350px;
            }

            .b-left {
                scale: 2;
                transform: translate(0px, 10px);
            }

            .b-right {
                scale: 2;
                transform: translate(0px, 10px);
            }

            #popup-sj {
                width: 80%;
            }

            .pop-up-main-img {
                height: 300px;
            }

            .get-started-text {
                font-size: 10px !important;
            }

            .menu_part_2 {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
                margin-left: -20px !important;
            }

            #hamB {
                margin-left: -20px !important;
            }

            .text-light {
                font-size: 9px !important;
            }
        }

        @media only screen and (min-width: 900px) and (max-width: 1022px) {



            .bg-banner {
                /* background-image: url('img/mob-banner-bg.png'); */
                height: auto;
                background-position: center;
                background-size: cover;
            }
        }

        @media only screen and (min-width: 1023px) and (max-width: 1024px) {

            #logoId {
                width: 50px;
                scale: 2;
            }

            .banner-font {
                font-size: 27px;
                line-height: 40px;
            }
        }


        @media only screen and (min-width: 1024px) {

            .carousel-control-prev {
                width: 10%;
            }

            .carousel-control-next {
                width: 10%;
            }

        }
/* code added by anil */
.welcome-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.welcome-paragraph {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    line-height: 8px;
}
.welcome-paragraph p{
    font-size: 18px;
}
.welcome-content .welcome-span {
    color: #0d7bf0;
    font-size: 30px;
    font-weight: 700;
}

.modal .modal-content .modal-header {
    border-bottom: unset !important;
}

.custom-close {
    background-color: red !important;
    color: white !important;
    opacity: 1;
    border-radius: 50%;
    background-size: 1.25rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M2.146 2.854a.5.5 0 0 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854z'/%3E%3C/svg%3E") !important;
}

.custom-close::before,
.custom-close::after {
    background-color: white !important;
}

.custom-button {
    background-color: #0d7bf0;
    color: white;
    border: none;
    padding: 12px 18px;
    border-radius: 10px;
    width: 100%;
    font-weight: 500;
    font-size: 18px;
}

.welcome-div {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.modal-body{
    height: 330px!important;
}
.modal-popup-other-country{
    height: 400px!important;
}
@media only screen and (max-width: 991px) {
  .modal-body {
    height: auto!important;
  }
  .modal-popup-other-country{
    height: auto!important;
}
}
    </style>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="canonical" href="https://www.sjpanel.com/@yield('link_url')">

    <!-- Cookie Consent style -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
</head>

<body id="page-top" class="landing-page">
    <div id="app">
        @include('includes.partials.logged-in-as')


        @include('frontend.includes.home_nav')

        <div class="container-fluid">
            @include('includes.partials.messages')

        </div>

        @yield('content')


    </div><!-- #app -->

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/frontend.js')) !!}

    <!-- Toastr -->
    <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/toastr.min.js"></script>

    <!-- Cookie Consent Script -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>


    <script>
        window.addEventListener("load", function() {
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
                "type": "opt-out",
                "dismissOnWindowClick": true,
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
        document.querySelectorAll('.nav-list').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-list').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/bootstrap.bundle.js"></script>
    <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/jquery-migrate-3.4.0.min.js"></script>
    <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/slick.js?v2022" type="text/javascript" charset="utf-8"></script>
    <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/54485227b7.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).on('ready', function() {

            $(".regular").slick({
                dots: true,
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 2
            });

            $(".regular-2").slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });

            $(".regular-3").slick({
                dots: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });

            $(".regular-4").slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });

            $(".center").slick({
                dots: false,
                infinite: true,
                centerMode: false,
                slidesToShow: 1,
                slidesToScroll: 1
            });

        });

        // const menuToggle = document.getElementById('offcanvasNavbar');

        document.getElementById('features').addEventListener('click', () => {

            document.querySelector('#features-div').scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });

        document.getElementById('testimonials').addEventListener('click', () => {

            document.querySelector('#testimonials-div').scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra  

        });

        document.getElementById('blog-section').addEventListener('click', () => {

            document.querySelector('#blogs-div').scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });

        document.getElementById('faq-section').addEventListener('click', () => {

            document.querySelector('#faqs-div').scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });

        document.getElementById('contact').addEventListener('click', () => {

            document.querySelector('#contact-div').scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });


        document.getElementById('home').addEventListener('click', () => {

            window.scrollTo(0, 0);

        });



        // mobiles nav scrolls


        document.getElementById('features-mob').addEventListener('click', () => {

            document.querySelector('.btn-close').click();
            document.querySelector('#features-div').scrollIntoView();

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });

        document.getElementById('testimonials-mob').addEventListener('click', () => {

            document.querySelector('.btn-close').click();
            document.querySelector('#testimonials-div').scrollIntoView();
            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });


        document.getElementById('contact-mob').addEventListener('click', () => {

            document.querySelector('.btn-close').click();
            document.querySelector('#contact-div').scrollIntoView();

            // this function add by pushpendra
            tableScrollStopAndStart()
            // this function add by pushpendra

        });



        var hometext = document.querySelector('#home').innerText;

        var allspanish_headertext = document.querySelectorAll('.nav-list');

        if (hometext == 'Hogar') {

            allspanish_headertext.forEach(item => {

                item.style.fontSize = '12px';

            });

        }


        var bannerFt = document.querySelector('.bft').innerText;

        // alert(bannerFt);

        var allBanner_text = document.querySelectorAll('.banner-font');

        if (bannerFt == 'Miles') {

            allBanner_text.forEach(item => {

                item.style.fontSize = '30px';

            });

        }



        function resetScroll() {

            const columns = document.querySelector('.list-move');
            columns.style.animation = 'none';
            columns.offsetHeight;
            columns.style.animation = null;

        }

        // const columns = document.querySelector('.column');
        // columns.addEventListener('animationiteration', resetScroll);




        // pop-up

        $(document).ready(function() {
            const dontShowAgain = localStorage.getItem('dontShowAgain');
            let is_user_set = @json(session()->has('current_user'));
            console.log("heRE " + is_user_set);
            console.log("d " + dontShowAgain);

            if (!dontShowAgain) {
                /* if(document.cookie.indexOf('skipSwal=true') === -1){ */
                setTimeout(() => {
                    const popup = document.getElementById("popup-sj");
                    popup.style.display = "flex";
                }, 1000);
                /* } */

            }
            console.log(dontShowAgain);
        });


        document.addEventListener("DOMContentLoaded", function() {


            const popup = document.getElementById("popup-sj");
            const okBtn = document.getElementById("okBtn");
            const closeBtnp = document.getElementById("closeBtnPopup");
            const closeBtnpmob = document.getElementById("closeBtnPopup-mob");

            okBtn.addEventListener("click", function() {
                const newTab = window.open("{{route('frontend.auth.register')}}", "_blank");
                newTab.focus();
                popup.style.display = "none";
            });

            closeBtnp.addEventListener("click", function() {
                /* document.cookie = 'skipSwal=true'; */
                popup.style.display = "none";
            });

            closeBtnpmob.addEventListener("click", function() {
                /* document.cookie = 'skipSwal=true'; */
                popup.style.display = "none";
            });


            document.getElementById("dontShow").addEventListener('click', function() {
                /* alert("hello"); */
                localStorage.setItem('dontShowAgain', 'true');
                popup.style.display = "none";

            });

        });

        // this code added by pushpendra
        function tableScrollStopAndStart() {
            const tableResponsive = document.querySelector('.table-responsive');
            if (tableResponsive) {
                $(tableResponsive).stop();
                setTimeout(() => {
                    $(tableResponsive).animate({
                        scrollTop: 0
                    }, 0);
                    $(tableResponsive).trigger('scroll');
                }, 1000);
            }
        }
    </script>
    @stack('after-scripts')
    <!-- Global site tag (gtag.js) - Google Analytics -->


    <script src="https://www.googletagmanager.com/gtag/js?id=UA-123538092-1"></script>


    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());



        gtag('config', 'UA-123538092-1');
    </script>

</body>

</html>