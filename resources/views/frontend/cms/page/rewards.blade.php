@extends('frontend.layouts.app_blog')
@section('link_url','pages/rewards')
@section('title','Rewarding Surveys | Quick Rewards Surveys - SJ Panel')
@section('meta_title','Rewarding Surveys | Quick Rewards Surveys - SJ Panel')
@section('meta_keyword','rewarding surveys, rewards for opinions, quick rewards surveys')
@section('meta_description','Get rewarded for your opinions with Quick Rewards Surveys! Join SJ Panel and start earning rewards for sharing your thoughts on various topics. Sign up now!')


@section('content')
    <!-- body -->
    <div class="container pb-3 mt-5 body_content">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <!-- ########################### SECTION START ########################### -->
                <section  class="container features" id="features">
                    
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="navy-line"></div>
                             <h1>{{__('cms.rewards.heading_1')}}</h1>
                             <h2>{{__('cms.rewards.heading_2')}}</h2>
                            
                        </div>
                    </div>


                    <div class="row text-center" style="min-height:450px;">
                        <div class="col-md-12">
                            <div class="row m-t-lg">
                                <div class="form-group">
                                    <!-- <div class="col-sm-12">
                                        <label class="control-label">You would be able to redeem incentives through our Incentive Management Partner Rybbon.</label>
                                    </div> -->
                                    <div class="col-sm-12 div_text_rewards" >
                                        {!!__('cms.rewards.heading_3')!!}
                                        
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <div class="container">
    @include('frontend.includes.blog_footer')
    </div>
</div>

@endsection