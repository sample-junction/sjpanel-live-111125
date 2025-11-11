@extends('frontend.layouts.app')
@section('link_url','pages/faq')
@section('meta_title','FAQ - SJ Panel')
@section('title','FAQ - SJ Panel')
@section('meta_description','Get answers to frequently asked questions about SJ Panel, a reliable and efficient platform for online surveys. Learn more today.')
@section('content')
@push('after-styles')
<style>
    .demo {
        display: none !important;
    }
    .demo1 {
        display: block !important;
        height: auto !important;
    }
    </style>
    @endpush
    
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="row">

                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content text-center">
                            <h1 class="m-b-xxs">{{__('cms.faq.heading')}}</h1>
                        </div>
                    </div>
                </div>

            </div>

            <section class="section1">
                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq1" class="faq-question">{{__('cms.faq.what_is_sjpanel')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.general')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq1" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq2" class="faq-question">{{__('cms.faq.why_member_sj_panel_question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.general_2')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq2" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.details_2')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section2">
                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq3" class="faq-question">{{__('cms.faq.eligible.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.eligible.general')}}</span>
                                <span class="tag-item">{{__('cms.faq.eligible.membership')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq3" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                    {{__('cms.faq.eligible.age')}}
                                    <ul>
                                        <li>United states</li>
                                        <li>United Kingdom</li>
                                        <li>France</li>
                                        <li>Germany</li>
                                        <li>Italy</li>
                                        <li>Spain</li>
                                        <li>India</li>
                                        <li>Australia</li>
                                        <li>Canada</li>
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq4" class="faq-question">{{__('cms.faq.how_do_join.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_do_join.general')}}</span>
                                <span class="tag-item">{{__('cms.faq.how_do_join.membership')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq4" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_do_join.its_free')}}<br/>{{__('cms.faq.how_do_join.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq5" class="faq-question">{{__('cms.faq.how_do_earn.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_do_earn.general')}}</span>
                                <span class="tag-item">{{__('cms.faq.how_do_earn.membership')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq5" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_do_earn.details',['points' => config('app.points.metric.threshold_points')])}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq6" class="faq-question">{{__('cms.faq.why_do_need_personal_info.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.why_do_need_personal_info.general')}}</span>
                                <span class="tag-item">{{__('cms.faq.why_do_need_personal_info.membership')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq6" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.why_do_need_personal_info.details')}} <a href="{{route('frontend.cms.privacy')}}">{{__('cms.faq.why_do_need_personal_info.privacy_policy')}}</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq7" class="faq-question">{{__('cms.faq.how_many_times_invitaion.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_many_times_invitaion.general')}}</span>
                                <span class="tag-item">{{__('cms.faq.how_many_times_invitaion.membership')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq7" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_many_times_invitaion.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq8" class="faq-question">{{__('cms.faq.how_to_cancel_membership.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_to_cancel_membership.general')}}</span>
                                <span class="tag-item">{{__('cms.faq.how_to_cancel_membership.membership')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq8" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_to_cancel_membership.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq9" class="faq-question">{{__('cms.faq.how_to_login.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_to_login.my_account')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq9" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_to_login.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq10" class="faq-question">{{__('cms.faq.how_to_update.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_to_update.my_account')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq10" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_to_update.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq11" class="faq-question">{{__('cms.faq.how_to_change_password.question')}}</a>
                        </div>
                        <div class="col-md-3">
                            <div class="tag-list">
                                <span class="tag-item">{{__('cms.faq.how_to_change_password.my_account')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq11" class="panel-collapse collapse ">
                                <div class="faq-answer">
                                    <p>
                                        {{__('cms.faq.how_to_change_password.details')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
       
    </div>
    @include('frontend.cms.page.cms_footer')

@endsection
@push('after-scripts')
<script>

    $(document).on('click','.faq-question',function(){
        let ids=$(this).attr('href');
        console.log(ids);
        for(i=1;i<=11;i++){
             let DivId='#faq'+i;
            if(DivId==ids){
               
               $('#faq'+i).removeClass('demo');
                $('#faq'+i).addClass('demo1');
               // $('#faq'+i).toggle();
                //$('.demo1').toggle('slow');

            }else{
                
                console.log("No"+DivId+"--"+i);

               $('#faq'+i).addClass('demo'); 
               $('#faq'+i).removeClass('demo1');
                 
            }

        }
    
     
    });
    </script>
@endpush
