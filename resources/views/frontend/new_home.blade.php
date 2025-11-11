<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@extends('frontend.layouts.home_app')

<style type="text/css">
    .table-responsive {
        height: 55%;
        overflow-y: hidden;
        overflow-x: hidden !important;
        padding: 2px;
        position: relative;
    }

    .table-responsive::-webkit-scrollbar {
        width: 0px;
    }

    .table-responsive thead,
    th {
        position: sticky;
        top: -4;
    }

    .table-responsive {
        width: 100%;
        border-collapse: collapse;
    }

    .table-responsive tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .table-responsive thead tr {
        display: table;
        width: calc(100% - 17px);
    }

    .table-responsive td {
        font-weight: normal;
        font-size: 14px;
    }

    #features-div,
    #testimonials-div,
    #blogs-div,
    #contact-div,
    #faqs-div {
        scroll-margin-top: 80px;
    }

    /* Code Added by Vikas Dhull (Code Starting)*/
    .surveyPlateForm {
        display: flex;
        align-items: start;
        padding-bottom: 12px;
        gap: 1rem;
    }

    .text-danger {
        color: red;
        font-size: 15px;
    }

    @media (max-width: 768px) {
        .surveyPlateForm {
            display: flex;
            gap: 0rem;
            padding-bottom: 12px;
            flex-direction: column !important;
        }

    }

    @media (max-width: 991px) {
        .surveyPlateForm {
            display: flex;
            gap: 0rem;
            padding-bottom: 12px;
            flex-direction: column !important;
        }

        .who-we-card-1 {
            background: #f8f9fd;
            height: 283px !important;
        }

        .who-we-card-2 {
            background: #f8f9fd;
            height: 360px !important;
        }
    }

    /* (Code Ending) */

    @media (max-width: 600px) {
        .table-responsive th {
            font-weight: 500;
            font-size: 12px;
        }

        .table-responsive td {
            font-weight: normal;
            font-size: 11px;
        }
    }

    .blog-repeat-div {
        height: 500px;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        overflow: hidden;
    }

    .blog-repeat-div-img {
        /* height: 150px; */
        /* object-fit: cover; */
        object-fit: contain;
        height: 100% !important;
    }
.carousel-control-prev,
    .carousel-control-next {
        position: absolute;
        top: 50% !important;
        bottom: auto !important;
        width: auto !important;
        height: auto;
        transform: translateY(-50%);
        padding: 8px 12px !important;
        border-radius: 50%;
        z-index: 5;
        opacity: 1;
    }
 
    .carousel-control-prev {
        left: 50px !important;
    }
 
    .carousel-control-next {
        right: 50px !important;
    }
    @media (min-width: 1024px) and (max-width: 1439px) {
        .table-responsive {
            height: 70%;
        }
    }

    @media (min-width: 767px) and (max-width: 991px) {
        .table-responsive {
            height: 88%;
        }
    }


    @media (min-width: 1440px) {
        .table-responsive {
            height: 69%;
        }
    }

    @media (max-width: 768px) {
        .table-responsive {
            height: 95%;
        }

        .who-we-card-1 {
            background: #f8f9fd;
            height: 520px !important;
        }

        .who-we-card-2 {
            background: #f8f9fd;
            height: 625px !important;
        }
    }


    @media (min-width: 1920px) {
        .table-responsive {
            height: 71%;
        }
    }

</style>
@php
use Illuminate\Support\Arr;

$langString1 = session()->get('locale');
$location1 = explode('_', $langString1);
$countryLang = $location1[0];


@endphp

@if($countryLang == 'fr')

@push('after-styles')

<style>
    @media (min-width: 1200px) {

        .h1,
        h1 {
            font-size: 1.8rem !important;
        }
    }
</style>

@endpush

@endif

@section('link_url','')
@section('content')



@php
$geoip = geoip(request()->ip());
$ipcountryCode = $geoip->getAttribute('iso_code');
$langString = session()->get('locale');
$location = explode('_', $langString);
$country = @$location[1];
if($ipcountryCode != $country){
$countryCode = $ipcountryCode;
}else{
$countryCode = $ipcountryCode;
}

@endphp

<!-- <div class="container-fluid mt-5 pb-4 bg-banner">

        <div class="row mt-5 pt-lg-5">

            <div class="col-12 col-lg-6 mt-5 pt-5 ps-lg-5 text-center text-lg-start">

                <span class="rounded-5 ps-4 pe-4 pt-1 pb-1 ms-lg-5" style="background: #78b0f326; font-weight: 600;">{{__('frontend.index.in_slider.start_now')}}</span>

                <p class="mt-3 ms-lg-5 banner-font"><span style="color: #1080D0; font-weight:bold">{{__('frontend.index.in_slider.banner_text_1')}}</span> {{__('frontend.index.in_slider.banner_text_2')}} <br> {{__('frontend.index.in_slider.banner_text_3')}} <span style="color: #1080D0; font-weight:bold">{{__('frontend.index.in_slider.banner_text_4')}}</span> <br> {{__('frontend.index.in_slider.banner_text_5')}}</p>

                <a href="" class="btn btn-primary rounded-5 ps-5 pe-5 pt-2 pb-2 ms-lg-5" style="font-size: 14px; font-weight:500">{{__('frontend.index.in_slider.button_join_now')}}</a>

            </div>

            <div class="col-12 col-lg-6 text-center text-lg-start">

                <img src="images/bannerimg.png" alt="icon" class="img-fluid">

            </div>

        </div>

    </div> -->


<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="border: 1px solid #707070;"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" style="border: 1px solid #707070;"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 2" style="border: 1px solid #707070;"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">

            <div class="row mt-5 bg-app-banner">
                <div class="col-12 col-lg-6 mt-5 pt-4 ps-lg-5 text-center text-lg-start pt-lg-5 pb-lg-5" style="position:relative">
                    <p class="mt-4 ms-lg-5 banner-font" style=" font-size: 35px!important;"><span class="bft" style="color: white; font-weight:bold">{{__('frontend.index.in_slider.banner_app_text')}}</span> <br><span style="color: white; font-weight:bold">{{__('frontend.index.in_slider.banner_app_text_2')}}</span> </p>
                    <p class="rounded-5 ms-lg-5" style="color: white;font-size:22px;">{{__('frontend.index.in_slider.banner_app_text_3')}}</p>
                    <p class="rounded-5 ms-lg-5" style="color: white;font-size:22px;">{{__('frontend.index.in_slider.banner_app_text_4')}}</p>
                    <div class="mt-4 ms-lg-5">
                        <span class="px-5 py-2" style="background-color: white;color:black; font-size:22px; font-weight:bold">{{__('frontend.index.in_slider.banner_app_btn')}}</span>
                    </div>
                    <div class="mt-4 ms-lg-5 d-flex gap-3">
                        <a href="https://apps.apple.com/us/app/sj-panel/id6743372465">
                            <img src="{{asset('landing-images/Apple.svg')}}" alt="" height="41">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.sjpanel">
                            <img src="{{asset('landing-images/Google.svg')}}" alt="" height="41">
                        </a>
                    </div>
                </div>

                <div class="col-12 col-lg-6 d-flex justify-content-end align-items-end text-lg-start">
                    <img src="{{asset('img/banner_app.webp')}}" alt="icon" class="img-fluid right-bn-img">

                </div>

            </div>

        </div>
        <div class="carousel-item">

            <div class="row mt-5 pt-lg-5 pb-lg-5 bg-banner-2">

                <div class="col-12 col-lg-6 mt-5 pt-5 ps-lg-5 text-center text-lg-start" style="position:relative">

                    <span class="rounded-5 ps-4 pe-4 pt-1 pb-1 ms-lg-5" style="background: #78b0f326; font-weight: 600;">{{__('frontend.index.in_slider.start_now')}}</span>

                    <p class="mt-3 ms-lg-5 banner-font" style=" font-size: 35px!important;">{{__('frontend.index.in_slider.2nd_banner_text_1a')}} <span style="color: #1080D0; font-weight:bold">{{__('frontend.index.in_slider.2nd_banner_text_1b')}}</span> <br> {{__('frontend.index.in_slider.2nd_banner_text_2a')}} <span style="color: #1080D0; font-weight:bold">{{__('frontend.index.in_slider.2nd_banner_text_2b')}}</span> <br> {{__('frontend.index.in_slider.2nd_banner_text_3')}}</p>

                    <div class="row d-lg-none">
                        <div class="col text-center">
                            <img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/BANNER VECTOR.png" alt="icon" class="img-fluid" style="transform: translateY(-20px);">
                        </div>
                    </div>

                    <a href="{{route('frontend.auth.register')}}" class="btn btn-primary rounded-5 ps-5 pe-5 pt-2 pb-2 ms-lg-5" style="font-size: 14px; font-weight:500">{{__('frontend.index.in_slider.button_join_now')}}</a>


                </div>

                <div class="col-12 col-lg-6 text-center text-lg-start">

                    <img src="https://imagedelivery.net/mlzTivu9NMOLJnaQaCX6Kw/5f0ac264-4090-46f0-c492-8c4840baef00/public" alt="icon" class="img-fluid right-bn-img">

                </div>

            </div>

        </div>


        <div class="carousel-item">

            <div class="row mt-5 pt-lg-5 pb-lg-5 bg-banner">

                <div class="col-12 col-lg-6 mt-5 pt-5 ps-lg-5 text-center text-lg-start" style="position:relative">

                    <span class="rounded-5 ps-4 pe-4 pt-1 pb-1 ms-lg-5" style="background: #78b0f326; font-weight: 600;">{{__('frontend.index.in_slider.start_now')}}</span>

                    <p class="mt-3 ms-lg-5 banner-font" style=" font-size: 35px!important;"><span class="bft" style="color: #1080D0; font-weight:bold">{{__('frontend.index.in_slider.banner_text_1')}}</span> {{__('frontend.index.in_slider.banner_text_2')}} <br> {{__('frontend.index.in_slider.banner_text_3')}} <span style="color: #1080D0; font-weight:bold">{{__('frontend.index.in_slider.banner_text_4')}}</span> <br> {{__('frontend.index.in_slider.banner_text_5')}}</p>

                    <div class="row d-lg-none">
                        <div class="col text-center">
                            <img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/BANNER VECTOR.png" alt="icon" class="img-fluid" style="transform: translateY(-20px);">
                        </div>
                    </div>

                    <a href="{{route('frontend.auth.register')}}" class="btn btn-primary rounded-5 ps-5 pe-5 pt-2 pb-2 ms-lg-5" style="font-size: 14px; font-weight:500">{{__('frontend.index.in_slider.button_join_now')}}</a>

                    <img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/BANNER VECTOR.png" alt="icon" class="img-fluid d-none d-lg-inline-block" style="position:absolute; right:10%;">

                </div>

                <div class="col-12 col-lg-6 text-center text-lg-start">

                    <img src="https://imagedelivery.net/mlzTivu9NMOLJnaQaCX6Kw/5f0ac264-4090-46f0-c492-8c4840baef00/public" alt="icon" class="img-fluid right-bn-img">

                </div>

            </div>

        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="text-black fw-bold" aria-hidden="true"><i class="fa-solid fa-chevron-left b-left"></i></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="text-black fw-bold" aria-hidden="true"><i class="fa-solid fa-chevron-right b-right"></i></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Code Added by Vikas Dhull (Section Starting) -->
<div class="container-fluid ps-3 pe-3 ps-lg-5 pe-lg-5 pt-2">
    <div class="col text-center mt-2 mt-lg-5">
        <h1>{{__('frontend.index.survey_platform.title_one')}}</h1>
        <p class="lead mt-4" style="color:#343D48; font-weight: 400; font-size: 16px;">
            {{__('frontend.index.survey_platform.first_paragraph')}}
        </p>
    </div>
    <div class="col mt-4">
        <h3 class="text-center ps-3">{{__('frontend.index.survey_platform.why_choose')}} </h3>
        <div class="mt-3 ps-3">
            <div class="surveyPlateForm">
                <span class="fw-bold flex-shrink-0">{{__('frontend.index.survey_platform.easy_free')}} –</span>
                <span>{{__('frontend.index.survey_platform.easy_free_para')}}</span>
            </div>
            <div class="surveyPlateForm">
                <span class="fw-bold flex-shrink-0">{{__('frontend.index.survey_platform.earn_reward')}} –</span>
                <span>{{__('frontend.index.survey_platform.earn_reward_para')}}</span>
            </div>
            <div class="surveyPlateForm">
                <span class="fw-bold flex-shrink-0">{{__('frontend.index.survey_platform.flex_hassle')}} –</span>
                <span>{{__('frontend.index.survey_platform.flex_hassle_para')}}</span>
            </div>
            <div class="surveyPlateForm">
                <span class="fw-bold flex-shrink-0">{{__('frontend.index.survey_platform.trustworthy_reliable')}} –</span>
                <span>{{__('frontend.index.survey_platform.trustworthy_reliable_para')}}</span>
            </div>
            <div class="surveyPlateForm">
                <span class="fw-bold flex-shrink-0">{{__('frontend.index.survey_platform.boost_earning_referral')}} –</span>
                <span>{{__('frontend.index.survey_platform.boost_earning_referral_para')}}</span>
            </div>
        </div>
    </div>

    <div class="col text-center">
        <p class="lead mt-4" style="color:#343D48; font-weight: 400; font-size: 16px;">
            {{__('frontend.index.survey_platform.survey_engaging_para')}}
        </p>
    </div>
</div>
<!-- Section Ending -->

<div class="container-fluid ps-3 pe-3 ps-lg-5 pe-lg-5 pb-3 pt-5" style="overflow: hidden;">


    <!-- HOW IT WORKS -->

    <div class="row mt-lg-4" id="features-div">

        <div class="col text-center mt-2 mt-lg-5">

            <h1 class="h1 fw-bold">{!! __('frontend.index.how_it_works.title_1a') !!} <span class="pe-4 pb-2" style="background: #e9f6f1;">{!! __('frontend.index.how_it_works.title_1b') !!}</span></h1>

            <p class="lead mt-4" style="color:#343d488c; font-weight: 500; font-size: 16px;">{!! __('frontend.index.how_it_works.title_2') !!}</p>

        </div>

    </div>


    <div class="row mt-4 ps-4 pe-4">

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 p-4" style="height:300px">

                <span class="me-4" style="font-size: 52px; color:#CCE8FF">1</span><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/arrow1.png" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">{{__('frontend.index.how_it_works.title_action')}}</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead')}}</p>

            </div>

        </div>

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 p-4" style="height:300px">

                <span class="me-4" style="font-size: 52px; color:#FCD7D7">2</span><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/arrow2.png" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">{{__('frontend.index.how_it_works.title_subhead_4')}}</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead_5')}}</p>

            </div>

        </div>

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 p-4" style="height:300px">

                <span class="me-4" style="font-size: 52px; color:#E2E0FF">3</span><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/arrow3.png" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">{{__('frontend.index.how_it_works.title_subhead_6')}}</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead_7')}}</p>

            </div>

        </div>

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 p-4" style="height:300px">

                <span class="me-4" style="font-size: 52px; color:#DAF4DA">4</span>

                <p class="fw-bold">{{__('frontend.index.how_it_works.title_subhead_2')}}</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead_3a')}} {{ $redeemptionThresholdPoints->value }} {{__('frontend.index.how_it_works.title_subhead_3b')}}</p>

            </div>

        </div>


        <!-- CARDS FOR MOBILE -->


        <div class="col-12 d-lg-none">

            <section class="regular-2 slider" style="margin:0 !important;">

                <div class="border rounded-3 p-4" style="height:280px">

                    <span class="me-4" style="font-size: 52px; color:#CCE8FF">1</span><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/arrow1.png" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                    <p class="fw-bold">{{__('frontend.index.how_it_works.title_action')}}</p>

                    <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead')}}</p>

                </div>

                <div class="border rounded-3 p-4" style="height:280px">

                    <span class="me-4" style="font-size: 52px; color:#FCD7D7">2</span><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/arrow2.png" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                    <p class="fw-bold">{{__('frontend.index.how_it_works.title_subhead_4')}}</p>

                    <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead_5')}}</p>

                </div>

                <div class="border rounded-3 p-4" style="height:280px">

                    <span class="me-4" style="font-size: 52px; color:#E2E0FF">3</span><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/arrow3.png" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                    <p class="fw-bold">{{__('frontend.index.how_it_works.title_subhead_6')}}</p>

                    <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead_7')}}</p>

                </div>

                <div class="border rounded-3 p-4" style="height:280px">

                    <span class="me-4" style="font-size: 52px; color:#DAF4DA">4</span>

                    <p class="fw-bold">{{__('frontend.index.how_it_works.title_subhead_2')}}</p>

                    <p style="color: #343d488c; font-weight: 500; font-size: 15px;">{{__('frontend.index.how_it_works.title_subhead_3a')}} {{ $redeemptionThresholdPoints->value }} {{__('frontend.index.how_it_works.title_subhead_3b')}}</p>

                </div>


            </section>

        </div>


    </div>


    <!-- WHO ARE WE -->

    <div class="row ps-lg-4 pe-lg-4 mt-5 pt-5">

        <div class="col-12 col-lg-6">

            <div class="rounded-lg-4 p-4 who-we-card-1">

                <div class="row mb-2 mb-lg-0">
                    <div class="col-10">
                        <h2 class="h2 fw-bold">{{__('frontend.index.why_you_earn.under.subtitle_2')}}</h2>
                    </div>
                    <div class="col-2 text-end"><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/design.png" alt="icon" class="img-fluid"></span></div>
                </div>

                <p class="" style="line-height: 28px; font-size: 15px; font-weight: 400; color: #343D48;">{{__('frontend.index.why_you_earn.under.subtitle_2_details')}}</p>

            </div>

        </div>


        <div class="col-12 col-lg-6">

            <div class="rounded-lg-4 p-4 who-we-card-2">

                <div class="row mb-2 mb-lg-0">
                    <div class="col-10">
                        <h2 class="h2 fw-bold">{{__('frontend.index.why_you_earn.under.subtitle_1')}}</h2>
                    </div>
                    <div class="col-2 text-end"><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/design.png" alt="icon" class="img-fluid"></span></div>
                </div>

                <p class="" style="line-height: 28px; font-size: 15px; font-weight: 400; color: #343D48;">{{__('frontend.index.why_you_earn.under.subtitle_1_details')}} <a href="https://www.rybbon.net/rewards-gifts/" target="_blank" style="text-decoration:none">Rybbon</a>{{__('frontend.index.why_you_earn.under.subtitle_1_detailsb')}}</p>

            </div>

        </div>

    </div>


    <!-- TESTIMONIALS -->


    <div class="row mt-5" id="testimonials-div">

        <div class="col text-center mt-5">

            <h1 class="h1 fw-bold">{{__('frontend.index.testimonials.title_a')}}<span class="pb-2 pe-3" style="background: #e9f6f1;">{{__('frontend.index.testimonials.title_b')}}</span></h1>

            <p class="lead mt-4 mb-0" style="color:#343d488c; font-weight: 500; font-size: 16px;">{{__('frontend.index.testimonials.title_sub')}}</p>

        </div>

    </div>


    <div class="row" style="scale:0.9">

        <section class="regular slider d-none d-lg-block">

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_1')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Jessica T.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_2')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Michael R.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_3')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Emily S.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_4')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">David M.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_5')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Sophie L.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_6')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Justin K.</span></div>
            </div>

        </section>

        <!-- Mobile Testimonials -->

        <section class="regular-4 slider d-lg-none">

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px; text-align:justify;">{{__('frontend.index.testimonials.review_1')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Jessica T.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB; text-align:justify;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px;">{{__('frontend.index.testimonials.review_2')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Michael R.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB; text-align:justify;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px;">{{__('frontend.index.testimonials.review_3')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Emily S.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB; text-align:justify;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px;">{{__('frontend.index.testimonials.review_4')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">David M.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB; text-align:justify;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px;">{{__('frontend.index.testimonials.review_5')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Sophie L.</span></div>
            </div>

            <div class="p-5 rounded-4 cst-card-test" style="background: #FBFBFB; text-align:justify;">
                <p style="font-weight:400; line-height: 28px; font-size: 15px;">{{__('frontend.index.testimonials.review_6')}}</p>
                <div><span><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/testimonial-img.png" alt="icon" width="50px" class="img-fluid me-3"></span> <span style="font-weight:500">Justin K.</span></div>
            </div>

        </section>

    </div>


    <!-- blogs -->

    <div class="row mt-5 pt-5" id="blogs-div">

        <div class="col text-center">

            <p class="h1 fw-bold">{{__('frontend.index.testimonials.latest')}} <span class="pe-4 pb-2" style="background: #e9f6f1;">{{__('frontend.index.testimonials.blogs')}}</span></p>

            <!--<p class="lead mt-4" style="color:#343d488c; font-weight: 500; font-size: 16px;">{{__('frontend.index.testimonials.title_sub')}}</p>-->

        </div>

    </div>


    <div class="row mt-4 gx-5 ms-2 me-2 ms-lg-0 me-lg-0">


        @if( count($data['posts']) > 0 )
        @foreach($data['posts'] as $index => $post)

        @if($index < 3)

            <div class="col-12 col-lg-4 col-md-6 col-sm-6 mb-4 mb-lg-4 d-none d-md-block">


            <div class="row pt-2 pb-3 border blog-repeat-div" style="border-radius: 12px;height: 410px;">

                <div class="col-12 mt-2 text-center">

                    <a href="{{ route('frontend.blog.post', $post->slug) }}">


                        <img src="{{ !$post->thumbnail_image ? asset($post->featured_image) : asset($post->thumbnail_image)}}" style="min-height: 225px;" alt="" class="blog-repeat-div-img img-fluid" href="{{ route('frontend.blog.post', $post->slug) }}">

                    </a>

                </div>


                <div class="col-12 text-start mt-3 ms-1">

                    <span class="fw-bold" style="font-size: 15px;">{{ $post->title }}</span>

                </div>


                <div class="col-12 text-start mt-3 ms-1">

                    <!-- <img src="img/Image.png" alt="" class="img-fluid me-2"> <span style="color:#858B91" class="border-end pe-3">Staff Writer</span> -->

                    <span style="color:#858B91" class=""><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/Vector.png" alt="" class="mb-1"> {{$read_time[$index]}}</span>

                </div>


                <div class="col-12 text-start mt-3 ms-1">

                    <a href="{{ route('frontend.blog.post', $post->slug) }}" class="text-black" style="font-weight: 600;">{{__('frontend.index.footer.links.Continue_Reading')}}</a>

                </div>


            </div>


    </div>

    @endif

    @endforeach
    @endif


    <!-- MOBILE SECTION BLOGS -->

    <section class="regular-3 slider d-md-none" style="margin:0 !important;">


        @if( count($data['posts']) > 0 )
        @foreach($data['posts'] as $index => $post)

        @if($index < 3)


            <div class="row pt-2 pb-3 border" style="border-radius: 12px;">

            <div class="col mt-2 text-center">

                <a href="{{ route('frontend.blog.post', $post->slug) }}">
                    <img src="{{ !$post->thumbnail_image ? asset($post->featured_image) : asset($post->thumbnail_image)}}" alt="{{$post->featured_image}}" class="img-fluid">
                </a>

            </div>


            <div class="col-12 text-start mt-3 ms-1">

                <span class="fw-bold" style="font-size: 15px;">{{ $post->title }}</span>

            </div>


            <div class="col-12 text-start mt-3 ms-1">

                <!-- <img src="img/Image.png" alt="" class="img-fluid me-2"> <span style="color:#858B91" class="border-end pe-3">Staff Writer</span> -->

                <span style="color:#858B91" class=""><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/Vector.png" alt="" class="mb-1"> {{$read_time[$index]}}</span>

            </div>


            <div class="col-12 text-start mt-3 ms-1">

                <a href="{{ route('frontend.blog.post', $post->slug) }}" class="text-black" style="font-weight: 600;">{{__('frontend.index.footer.links.Continue_Reading')}}</a>

            </div>


</div>

@endif
@endforeach
@endif

</section>

<!-- END -->

<div class="col-12 mt-4 mt-lg-0 text-center">

    <a href="/blog" class="btn btn-primary rounded-5 ps-5 pe-5 pt-2 pb-2 blog-btn" style="font-size: 15px; font-weight: 500;">{{__('frontend.index.testimonials.all_blogs')}}</a>

</div>


</div>


<!-- FAQ -->

<div class="row d-flex flex-wrap mt-5 pt-5" id="faqs-div">

    <div class="text-center">
        <p class="fw-bold mb-5 h1 faq-text">{{__('frontend.index.testimonials.faq_a')}}<span class="pe-4 pb-2" style="background: #e9f6f1;">{{__('frontend.index.testimonials.faq_b')}}</span></p>
    </div>
    <div class="col-12 col-lg-6 mt-4 flex-fill">

        <div class="accordion" id="accordionExample">

            <div class="accordion-item mb-3 border rounded-3 p-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="font-weight:600">
                        {{__('cms.FAQ.Que_1.question')}}
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{__('cms.FAQ.Que_1.answer')}}
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-3 border rounded-3 p-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="font-weight:600">
                        {{__('cms.FAQ.Que_2.question')}}
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{__('cms.FAQ.Que_2.answer')}}
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-3 border rounded-3 p-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="font-weight:600">
                        {{__('cms.FAQ.Que_3.question')}}
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{__('cms.FAQ.Que_3.answer')}}.
                        <ul class="mt-2">
                            <li>{{ __('cms.FAQ.Que_3.opt_34') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_1') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_2') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_3') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_4') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_5') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_6') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_7') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_8') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_9') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_10') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_11') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_12') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_13') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_14') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_15') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_16') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_17') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_18') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_19') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_20') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_21') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_22') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_23') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_24') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_25') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_26') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_27') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_28') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_29') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_30') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_31') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_32') }}</li>
                            <li>{{ __('cms.FAQ.Que_3.opt_33') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-3 border rounded-3 p-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="font-weight:600">
                        {{__('cms.FAQ.Que_4.question')}}
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{__('cms.FAQ.Que_4.answer')}}
                        <ul class="mt-2">
                            <li>{{__('cms.FAQ.Que_4.opt_1')}}</li>
                            <li>{{__('cms.FAQ.Que_4.opt_2')}}</li>
                            <li>{{__('cms.FAQ.Que_4.opt_3')}}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-3 border rounded-3 p-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" style="font-weight:600">
                        {{__('cms.FAQ.Que_5.question')}}
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{__('cms.FAQ.Que_5.answer')}}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 mt-4 mt-lg-4 mb-4 mb-lg-0 text-center text-lg-start">

            <a href="{{route('frontend.cms.faq')}}" class="btn btn-primary rounded-5 ps-5 pe-5 pt-2 pb-2 blog-btn" style="font-size: 15px; font-weight: 500;">{{__('frontend.index.testimonials.all_faq')}}</a>

        </div>

    </div>

    @php
    /* $file_path = storage_path('records_date.json');
    $data = json_decode(file_get_contents($file_path), true);
    $rec_id = $data['rec_id'];
    $rec_date = \Carbon\Carbon::parse($data['rec_date']);
    $today = \Carbon\Carbon::now();
    $date15DaysAhead = $rec_date->copy()->addDays(15);
    if($today->greaterThanOrEqualTo($date15DaysAhead)){
    $data['rec_date'] = $today->toDateString();
    if($rec_id != '3'){
    $data['rec_id'] = 2;
    }else{
    $data['rec_id'] = 2;
    }
    $rec_id = $data['rec_id'];
    file_put_contents($file_path, json_encode($data));
    }
    $names = config('settings.dummyNames_'.$rec_id);
    $panelistIds = config('settings.dummyID_'.$rec_id);
    $amounts = config('settings.dummyAmount_'.$rec_id);
    $state=config('settings.dummyState_'.$rec_id);*/
    @endphp

    <div class="col-12 col-lg-6 mt-2 overflow-auto" style="height: 575px;">

        <div style="background: #FDF7E4;" class="rounded-4 px-2 pb-3">

            <p style="font-size: 20px; color: #1080D0; font-weight: 500;" class="pt-3 mt-2 ms-2">{!! __('frontend.register.redemption_seo') !!}</p>
            <div class="table-responsive">
                <table style="width: 100%;" class=" table table-md table-hover">
                    <thead>
                        <tr>
                            <th scope="col fw-bold" style="background: #FDF7E4;">{!! __('frontend.register.panelist_name_seo') !!}</th>
                            <th scope="col fw-bold" style="background: #FDF7E4;">{!! __('frontend.register.panelist_city_state_seo') !!}</th>
                            <th scope="col fw-bold" style="background: #FDF7E4;padding-left: 55px;">{!! __('frontend.register.panelist_id_seo') !!}</th>
                            <th scope="col fw-bold" style="background: #FDF7E4;">{!! __('frontend.register.redeemed_amt_seo') !!}</th>

                        </tr>
                    </thead>

                    <tbody style="line-height: 40px">
                        @foreach($get_redeem_data as $key => $redeem)
                        @php

                        $panellist_id = $redeem->panellist_id;
                        if (!empty($panellist_id)) {
                        if($redeem->points) {
                        $symbol = ($redeem->currency_symbols == 'CAD') ? $redeem->currency_symbols.' ' : $redeem->currency_symbols;
                        $points = $redeem->points;
                        $value = round($redeem->redeem_points / $points, 2);
                        } else {
                        $symbol = '$';
                        $points = config('app.points.metric.conversion');
                        $value = round($redeem->redeem_points * $points, 2);
                        }
                        }else{
                        $symbol = '$';
                        $points = config('app.points.metric.conversion');
                        $value = round($redeem->redeem_points * $points, 2);
                        }

                        if ($panellist_id === null) {
                        Log::error('Panelist ID is null for user_uuid: ' . $redeem->user_uuid);
                        }
                        @endphp
                        @if($key < 10)
                            <tr class="">
                            <td style="background: #FDF7E4;">{{ucfirst($redeem->first_name)}} *****</td>
                            <td style="background: #FDF7E4;">{{$redeem->country}}</td>
                            <td style="background: #FDF7E4;">{{$redeem->panellist_id}}</td>
                            <td style="background: #FDF7E4; text-align: center;">{{ $symbol }}{{ $value}}</td>
                            </tr>

                            @endif

                            @endforeach

                    </tbody>
                </table>
            </div>
        </div>


    </div>

</div>



<!-- CONTACT US -->

<div class="row pt-2" id="contact-div">

    <div class="col text-center">

        <p class="h1 fw-bold">{{__('frontend.index.contact_us_new.title_a')}}<span class="pe-4 pb-2" style="background: #e9f6f1;">{{__('frontend.index.contact_us_new.title_b')}}</span></p>

        <p class="lead mt-4 mb-0" style="color:#343d488c; font-weight: 500; font-size: 16px;">{{__('frontend.index.contact_us.title_2')}}</p>

    </div>

</div>


@include('frontend.includes.new_contact_us')


<!-- BADGES -->

<div class="row mt-5 pb-3 ms-lg-4 me-lg-4">

    <div class="col p-0 d-none d-md-block">

        <img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/Group 1000001784.png" alt="" style="width:103%">

    </div>

    <div class="col-12 d-md-none border rounder-4">

        <section class="center slider autoplay">

            <div>
                <img src="images/gdpr.png" alt="icon" class="img-fluid">
            </div>

            <div>
                <img src="images/secure.png" alt="icon" class="img-fluid">
            </div>

            <div>
                <img src="images/iso1.png" alt="icon" class="img-fluid">
            </div>

            <div>
                <img src="images/iso13.png" alt="icon" class="img-fluid">
            </div>

        </section>

    </div>

</div>



<!-- footer -->

<div class="row mt-5">

    <div class="col-12 text-center">
        <a href="#" class="navbar-brand d-none d-lg-inline-block scroll-to-top">
            <img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/SJ%20Panel%20New%20LOGO%20without%20background.png" 
                class="img-fluid" width="150px">
        </a>
    </div>

    <!-- <div class="col-12 mt-3 text-center" >

                <p style="font-weight: 600;">{{__('frontend.index.footer.links.footer_content')}}</p>

            </div> -->

    <div class="col-12 mt-3 text-center">

        <!-- <p style="font-weight: 600;">Suite 117, 9131 Keele St Suite A4, Vaughan, ON L4K 0G7</p> -->

    </div>

    <div class="col-12 mt-2 text-center pb-4 border-bottom">

        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.privacy')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.privacy_policy')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.cookie')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.cookie_policy')}}</a> </span>
        <span class="me-3 me-lg-4"><a href="{{route('frontend.cms.rewards_policy')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.reward_policy')}}</a></span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.referral_policy')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.referral_policy')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.safeguard')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.Safeguards')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.term_condition')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.term_condition')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.faq')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.FAQ')}}</a> </span>
        <span class=""> <a href="{{route('frontend.blog')}}" class="text-black " style="text-decoration: none;">{{__('frontend.nav.static.heading_6')}}</a> </span>

    </div>

    <div class="col-12 col-lg-4 text-center text-lg-start mt-3 mt-lg-4">
        <p class="mt-1">{{__('frontend.index.footer.links.copy_right_company')}}</p>
    </div>
    <div class="col-12 col-lg-4 text-center text-lg-end mt-lg-4">
        <div class="store-buttons d-flex justify-content-center">
            <a href="https://apps.apple.com/us/app/sj-panel/id6743372465" style="
    padding: 0px 5px 0px 0px;
"><img src="https://www.sjpanel.com/landing-images/Apple.svg" alt="App Store" style="
    max-width: 100px;
"></a>
            <a href="https://play.google.com/store/apps/details?id=com.sjpanel"><img src="https://www.sjpanel.com/landing-images/Google.svg" alt="Google Play" style="
    max-width: 100px;
    /* padding: 10px; */
"></a>
        </div>
    </div>
    <div class="col-12 col-lg-4 text-center text-lg-end mt-lg-4">
        <p class="mt-lg-1">{{ __('frontend.index.footer.links.copyright_sj', ['year' => date('Y')]) }}</p>
    </div>

</div>




<!-- popup new -->

<div id="popup-sj" class="row">

    <div class="col-12 text-end d-lg-none position-absolute">

        <img src="images/image-removebg-POP.png" alt="icon" id="closeBtnPopup-mob" class="img-fluid" width="20px" style="transform: translateY(30%); scale:1.2; cursor:pointer;">

    </div>

    <div class="col-12 col-lg-6 p-0 pop-up-main-img" style="background-image:url('https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/SJ%20Panel-%20Popup%20Icon.png'); background-size:cover;">

        <!-- <img src="images/SJ Panel- Popup Icon.png" alt="icon" class="img-fluid "> -->

    </div>

    <div class="col-12 col-lg-6 bg-white">

        <div class="row">

            <div class="col-12 text-end d-none d-lg-block mt-2">

                <img src="images/image-removebg-POP.png" alt="icon" id="closeBtnPopup" class="img-fluid" width="20px" style="cursor:pointer;">

            </div>

            <div class="col-12 text-center mt-3">

                <p class=" @php if($langString == 'es_US'){echo'h5';}else{echo'h4';} @endphp">{{__('inpanel.dashboard.pop_up.title_new_1')}}</p>

            </div>

            <div class="col-12 text-center">
                @if($langString == 'hi_IN')
                <p class="mt-2" style="font-size:15px"><span style="font-weight:600">{{__('inpanel.dashboard.pop_up.title_new_2')}}</span> <span>{{__('inpanel.dashboard.pop_up.title_new_3a')}}</span> {{__('inpanel.dashboard.pop_up.title_new_3b')}}</p>
                @else
                <p class="mt-2" style="font-size:15px">{{__('inpanel.dashboard.pop_up.title_new_2')}} <span style="font-weight:600">{{__('inpanel.dashboard.pop_up.title_new_3a')}}</span> {{__('inpanel.dashboard.pop_up.title_new_3b')}}</p>
                @endif

            </div>

            <div class="col-12 text-center mt-1 mt-lg-2">

                <a id="okBtn" class="btn btn-primary rounded-3 pt-3 pb-3 fw-bold" style="width:100%">{{__('inpanel.dashboard.pop_up.J_now')}}</a>

            </div>

            <div class="col-12 text-center mt-2 mb-3 mb-lg-0">

                <a id="dontShow" class="btn rounded-3 pt-3 pb-3 fw-bold lead" style="width:100%; background:#E0EDF8; color:#0082F0;   margin-bottom: 10px;">{{__('inpanel.dashboard.pop_up.D_show')}}</a>

            </div>

        </div>

    </div>

</div>




</div>

@endsection
@push('after-scripts')
<script>
    var $el = $(".table-responsive");

    function anim() {
        var st = $el.scrollTop();
        var sb = $el.prop("scrollHeight") - $el.innerHeight();
        $el.animate({
            scrollTop: st < sb / 2 ? sb : 0
        }, 4000, anim);
    }

    function stop() {
        $el.stop();
    }
    anim();
    $el.hover(stop, anim);

    $('.autoplay').slick({
        autoplay: true,
        dots: false,
        infinite: true,
        speed: 1000,

    })
    screenWidth = window.screen.width,
        screenHeight = window.screen.height;
    console.log(screenWidth);
    console.log(screenHeight);

    // Code added by Vikas click on logo and scroll on top of home page
    $('.scroll-to-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 500);
    });
</script>
<script>
    screenWidth = window.screen.width,

        screenHeight = window.screen.height;
</script>
@endpush