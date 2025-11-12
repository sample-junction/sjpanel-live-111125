@extends('frontend.layouts.app')
@section('link_url','blog')

@section('title','Blog - SJ Panel') 
@section('meta_description','Discover insightful articles and expert opinions on various topics related to SJ Panel on our informative blog.')

 

@php

 

use Illuminate\Support\Str;

 

@endphp

 

@push('after-styles')
<link href="{{asset('css2/blog_style.css')}}" rel="stylesheet">
<link href="{{asset('css2/blog.css')}}" rel="stylesheet">

    {{--@include('blog.partials.styles')--}}

@endpush

 

@push('after-scripts')

    <script>

        $(document).ready(function(){

            $('.grid').masonry({

                // options

                itemSelector: '.grid-item',

                columnWidth: 200

            });

        });

 

    </script>

@endpush

 

@section('content')

    <div class="blog-1 subpage-header career_section">

        <div class="container w-container">
           
            <h1 class="subpage-title" data-ix="fade-in-on-load" style="opacity: 1; transform: translateX(0px) translateY(0px) translateZ(0px); display: block; transition: opacity 500ms ease 0s, transform 500ms ease 0s;">

                {{__('frontend.nav.static.heading_6')}}

            </h1>

            <div class="page-subtitle" data-ix="fade-in-on-load-2">

                {{--Str::title(config('canvas.sub_section_name'))--}}

            </div>

        </div>

    </div>

    <div class="section">

        <div class="container w-container">

            <div class="blog-posts-list-wrapper w-dyn-list">

                <div class="blog-posts-list w-clearfix w-dyn-items w-row">

                    @if( count($data['posts']) > 0 )

                        @foreach($data['posts'] as $index => $post)

                            <div class="simple-blog-post-item w-col w-col-4 w-dyn-item" @if ($index === 6) style="margin-left: -13%;" @endif>

                                <a class="simple-blog-image-block w-inline-block" href="{{ route('frontend.blog.post', $post->slug) }}"

                                    @if($post->thumbnail_image)

                                    style="background-image: url({{asset($post->featured_image)}});"

                                    @else

                                    style="background-image: url({{asset($post->featured_image)}});"

                                    @endif>
                                        
                                    <div class="blog-post-overlay light"></div>

                                </a>

                                <div class="blog-post-date w-clearfix">  {{-- $post->read_time --}}</div>

                                <a class="blog-post-title-link" href="{{ route('frontend.blog.post', $post->slug) }}">{{ $post->title }} </a>

                                @if($post->post_status !== config('canvas.canvas_status.published'))

                                    <p class="blog-post-summary">Project Status -> {{ strtoupper($post->post_status) }}</p>

                                @endif

                                <p class="blog-post-summary">{{ $post->summary }}</p>

                            </div>

                        @endforeach

                        {{ $data['posts']->links() }}

                    @else

                        <p class="mt-4">

                            {{ __('No posts were found') }}

                            {{--<a href="{{-- route('canvas.post.create') --}}">

                                {{ __('canvas::blog.empty.action') }}

                            </a>.--}}

                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

 

    <div class="section tint">

        <div class="container w-container">

            <div class="blog-posts-list-wrapper w-dyn-list">

                <div class="archive blog-posts-list w-clearfix w-dyn-items w-row">

                   

                </div>

            </div>

        </div>

    </div>

    <section id="footer">
            <div class="container">
                <div class="row text-center text-xs-center text-sm-left text-md-left">
                    <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-sm">
                        <p style="color: white">
                            <strong>{{__('frontend.register.static.footer_title_3')}} &reg; 2015-{{ date('Y') }}</strong>
                            <br/>
                              <a href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.footer.links.privacy_policy')}}</a>
                            | <a href="{{route('frontend.cms.cookie')}}">{{__('frontend.index.footer.links.cookie_policy')}}</a>
                            | <a href="{{route('frontend.cms.rewards_policy')}}">{{__('frontend.index.footer.links.reward_policy')}}</a>
                            | <a href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}}</a>
                            | <a href="{{route('frontend.cms.safeguard')}}">{{__('frontend.index.footer.links.Safeguards')}}</a>
                            | <a href="{{route('frontend.cms.term_condition')}}">{{__('frontend.index.footer.links.term_condition')}}</a>
                            | <a href="{{route('frontend.cms.faq')}}">{{__('frontend.index.footer.links.FAQ')}}</a> 
							| <a href="{{route('frontend.blog')}}" >{{__('frontend.nav.static.heading_6')}}</a>
                            | <a href="{{route('frontend.cms.help_support')}}" target="_blank">{{__('frontend.nav.static.heading_4')}}</a>           

                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{--<a href="mailto:contact@sjpanel.com" class="btn btn-primary">{!! __('frontend.index.contact_us.send_email_button') !!}</a>--}}
                        <p id="footer_contact_detail">{!! __('frontend.index.contact_us.details_7') !!}</p>
                        <a>{!! __('frontend.index.contact_us.details_8') !!}</a>
                        <p class="" style="color: white">
                            <strong>{!! __('frontend.index.contact_us.mailing_social_connection') !!}</strong>
                        </p>
                        <ul class="list-inline social-icon">
                            <li><a href="//twitter.com/samplejunction"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li><a href="//facebook.com/samplejunction"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li><a href="//www.linkedin.com/company/sample-junction"><i class="fab fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                    </hr>
                </div>
                <div class="row">
		    <div class="col-lg-12 text-center">
                         <img src="{{asset('img/frontend/gdpr_small.png')}}" class="img" id="gdpr" alt="GDPR Compliant" title="GDPR Compliant"  width="80" height="80">
                         <img src="{{asset('img/frontend/SSL.png')}}" class="img" id="ssl" width="80" height="80" title="SSL Secure" alt="ssl">
                         <img src="{{asset('img/frontend/iso-9001.png')}}" class="img" id="iso_9001" width="80" height="80" title="ISO 9001:2015 Certified" alt="ISO9001">
                         <img src="{{asset('img/frontend/iso-27001.png')}}" class="img" id="iso_27001" width="80" height="80" title="ISO 27001-2013 Certified" alt="ISO27001">

		    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                        <p style="color: white">
                            <strong>{{__('frontend.index.footer.bottom_tex')}}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </section>

   

@endsection

@push('after-styles')
    <style>
        .container-fluid{
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
        #footer {
            background: #1180D0 !important;
        }
        #footer h5{
            padding-left: 10px;
            border-left: 3px solid #eeeeee;
            padding-bottom: 6px;
            margin-bottom: 20px;
            color:#ffffff;
        }
        #footer a {
            color: #ffffff;
            text-decoration: none !important;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }
        #footer ul.social li{
            padding: 3px 0;
        }
        #footer ul.social li a i {
            margin-right: 5px;
            font-size:25px;
            -webkit-transition: .5s all ease;
            -moz-transition: .5s all ease;
            transition: .5s all ease;
        }
        #footer ul.social li:hover a i {
            font-size:30px;
            margin-top:-10px;
        }
        #footer ul.social li a,
        #footer ul.quick-links li a{
            color:#ffffff;
        }
        #footer ul.social li a:hover{
            color:#eeeeee;
        }
        #footer ul.quick-links li{
            padding: 3px 0;
            -webkit-transition: .5s all ease;
            -moz-transition: .5s all ease;
            transition: .5s all ease;
        }
        #footer ul.quick-links li:hover{
            padding: 3px 0;
            margin-left:5px;
            font-weight:700;
        }
        #footer ul.quick-links li a i{
            margin-right: 5px;
        }
        #footer ul.quick-links li:hover a i {
            font-weight: 700;
        }

        @media (max-width:767px) {
            #footer h5 {
                padding-left: 0;
                border-left: transparent;
                padding-bottom: 0px;
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
