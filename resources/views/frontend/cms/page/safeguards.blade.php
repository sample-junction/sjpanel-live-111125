@extends('frontend.layouts.app_blog')
@section('link_url','pages/safeguard')
@section('meta_title','Safeguards - SJ Panel')
@section('title','Safeguards - SJ Panel')
@section('meta_description','Protect your business with our comprehensive Safeguards program. Our experts will work with you to identify potential risks and implement effective solutions.')
@section('content')
<style>
    body a {
        text-decoration: none !important;
        /* color:blue!important; */
        /* font-size:18px!important; */
    }

    body li {
        font-size: 18px !important;
    }

    body p {
        font-size: 18px !important;
    }
</style>
<div class="container pb-3 mt-5 body_content">
    <div class="row mt-5">
        <div class="wrapper animated fadeInRight">{{--<div class="wrapper wrapper-content animated fadeInRight">
                <div class="blog-single-post-date" data-ix="fade-in-on-load-2" style="opacity: 1; display: block; transition: opacity 500ms ease 0s;">
                    Last Updated On : July 4, 2016
                </div>
                <h1 class="blog-post-title subpage-title" data-ix="fade-in-on-load" style="opacity: 1; transform: translateX(0px) translateY(0px) translateZ(0px); display: block; transition: opacity 500ms ease 0s, transform 500ms ease 0s;">
                    Safeguards
                </h1>
            </div>--}}
        </div>
    </div>
    <section class="container features" id="features">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1> {{__('cms.safeguard.heading1')}}</h1>
            </div><br />
            <h3>{{__('cms.safeguard.heading_3')}}</h3>
            <p><strong>{{__('cms.safeguard.heading_5')}}</strong></p>
            <p>{!!str_replace('#SJPANELURL','<a href="/" target="_blank">www.sjpanel.com</a>',__('cms.safeguard.para_1'))!!}
            </p>
            <h4>{{__('cms.safeguard.heading_4')}}</h4>
            <p><strong>{{__('cms.safeguard.heading_4_1')}}</strong></p>
            <p>{{__('cms.safeguard.para_2')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_1')}}</strong></p>
            <p>{{__('cms.safeguard.para_3')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_2')}}</strong></p>
            <p>{!!__('cms.safeguard.para_4')!!}</p>
            <p><strong>{{__('cms.safeguard.heading_5_3')}}</strong></p>
            <p>{!!__('cms.safeguard.para_5')!!}</p>
            <p><strong>{{__('cms.safeguard.heading_5_4')}}</strong></p>
            <p>{{__('cms.safeguard.para_6')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_5')}}</strong></p>
            <p>{{__('cms.safeguard.para_7')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_6')}}</strong></p>
            <p>{{__('cms.safeguard.para_8')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_7')}}</strong></p>
            <p>{{__('cms.safeguard.para_9')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_8')}}</strong></p>
            <p>{{__('cms.safeguard.para_10')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_9')}}</strong></p>
            <p>{{__('cms.safeguard.para_11')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_10')}}</strong></p>
            <p>{{__('cms.safeguard.para_12')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_11')}}</strong></p>
            <p>{{__('cms.safeguard.para_13')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_12')}}</strong></p>
            <p>{{__('cms.safeguard.para_14')}}</p>
            <p><strong>{{__('cms.safeguard.heading_5_13')}}</strong></p>
            <p>{{__('cms.safeguard.para_15')}}</p>
        </div>
        <div class="single-post-author-block w-clearfix">
            <div class="post-author-line"></div>
            {{--<img class="post-author-photo" src="https://daks2k3a4ib2z.cloudfront.net/577a18541a78df7357099c0c/577a18a61a78df7357099c1b_Testimonial-10.jpg">--}}
            <div class="post-author-name">SJ Panel</div>
            <div class="description post-author-name">{!!str_replace('#SJADDR','RS Sample Junction LLP<br />
                CANADA
                Office # 117, 9131 Keele St Suite A4,Vaughan,
                ON L4K 0G7',__('cms.safeguard.address'))!!}</div>
        </div>
</div>
{{--<div class="section-title-wrapper">
                <h2 class="dont-miss section-title">Don't miss these stories:</h2>
            </div>--}}
</div>
</section>
<div class="container botton_content">
    @include('frontend.includes.blog_footer')
</div>
</div>

@endsection
@push('after-styles')
<style>
    h3 {
        color: #292c2d
    }

    h4 {
        color: #292c2d
    }

    li {
        color: #292c2d
    }
</style>
@endpush