@extends('frontend.layouts.app_blog')

@section('content')

<div class="container pb-3 mt-5 body_content">
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <!-- ########################### SECTION START ########################### -->
                <section  class="container features" id="features">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="navy-line"></div>
                            <h1>{{__('cms.ccpa_privacy.heading_1')}}</h1>
                        </div>
                    </div>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_1_intro')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_2')}}
                    </p>

                    <h3>{{__('cms.ccpa_privacy.heading_2')}}</h3>

                    <p>
                        {{__('cms.ccpa_privacy.paragraph_3')}}
                    </p>
                    <p>
                        <b>{{__('cms.ccpa_privacy.paragraph_4_1')}}</b> {{__('cms.ccpa_privacy.paragraph_4_2')}}
                    </p>

                    <p>
                        <b>{{__('cms.ccpa_privacy.paragraph_5_1')}}</b> {{__('cms.ccpa_privacy.paragraph_5_2')}}
                    </p>
                    <p>
                        <b>{{__('cms.ccpa_privacy.paragraph_6_1')}}</b>{{__('cms.ccpa_privacy.paragraph_6_2')}}
                    </p>
                    <p>
                        <b>{{__('cms.ccpa_privacy.paragraph_7_1')}}</b> {{__('cms.ccpa_privacy.paragraph_7_2')}}
                    </p>
                    <p>
                        <b>{{__('cms.ccpa_privacy.paragraph_8_1')}}</b> {{__('cms.ccpa_privacy.paragraph_8_2')}}
                    </p>
                    <p>
                        <b>{{__('cms.ccpa_privacy.paragraph_9')}}</b>
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_10')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_11')}}
                    </p>

                    <h3>{{__('cms.ccpa_privacy.heading_3')}}</h3>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_12')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_13')}}
                    </p>
                    <h3>{{__('cms.ccpa_privacy.heading_4')}}</h3>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_14')}}
                    </p>
                    <ul class="bullet_ul">
                        <li>
                            {{__('cms.ccpa_privacy.list_1_1')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_1_2')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_1_3')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_1_4')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_1_5')}}
                        </li>
                    </ul>
                    <h3>{{__('cms.ccpa_privacy.heading_5')}}</h3>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_15')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_16')}}
                    </p>
                    <ul class="bullet_ul">
                        <li>
                            {{__('cms.ccpa_privacy.list_2_1')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_2')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_3')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_4')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_5')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_6')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_7')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_8')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_2_9')}}
                        </li>
                    </ul>
                    <h3>{{__('cms.ccpa_privacy.heading_6')}}</h3>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_17')}}
                    </p>
                    <p>
                        {!!__('cms.ccpa_privacy.paragraph_18')!!}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_19')}} <a href="{{route('frontend.cms.help_support')}}" style="text-decoration:none!important;color:blue!important;">{{route('frontend.cms.help_support')}}</a>
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_20')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_21')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_22')}}
                    </p>
                    <ul class="bullet_ul">
                        <li>
                            {{__('cms.ccpa_privacy.list_3_1')}}
                        </li>
                        <li>
                            {{__('cms.ccpa_privacy.list_3_2')}}
                        </li>
                    </ul>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_23')}}
                    </p>
                    <h3>{{__('cms.ccpa_privacy.heading_7')}}</h3>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_24')}}
                    </p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_25')}}
                    </p>
                    <p>{{__('cms.ccpa_privacy.paragraph_26')}}</p>
                    <p>
                        {{__('cms.ccpa_privacy.paragraph_27')}}
                    </p>

                    <p>
                        {{__('cms.privacy.sjpanel.contact.heading')}}</p>
                    <p>
                        {!!__('cms.privacy.sjpanel.contact.details')!!}
                    </p>
                    <p>
                        SJ Panel<br/>
                        {!!str_replace('#SJADDR','RS Sample Junction LLP<br />
                        CANADA
                        Office # 117, 9131 Keele St Suite A4,Vaughan,
                        ON L4K 0G7',__('cms.safeguard.address'))!!}</
                    </p>
                </section>
            </div>
        </div>
    </div>
    <div class="container">
    @include('frontend.includes.blog_footer')
    </div>
</div>

@endsection

@push('after-styles')
    <style>
        h3{
            color:#292c2d
        }
        h4{
            color:#292c2d
        }
        li{
            color:#292c2d
        }
    
        @media only screen and (max-width: 600px) {
        .mobile_p_2 {
            padding-right:10px!important;
        }
        }
    </style>
@endpush
