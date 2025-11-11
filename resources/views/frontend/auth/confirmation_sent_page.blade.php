@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))
<style>
    .container-login100 {
        width: 100%;
        min-height: 100vh;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-image: url("/img/bg-01.jpg");
    }
    .white, .white > a{
        color:white;
    }
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .ul {
        /* for IE below version 7 use `width` instead of `max-width` */
        max-width: 800px;
        margin: auto;
    }
    li {
        display:inline-block;
        *display:inline; /*IE7*/
        margin-right:10px;
    }
    .home {
        text-align: center;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight container-login100">
                    <div class="ibox-content col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <img src="{{asset('img/frontend/envelope.png')}}" /><br>
                                    <h1 class="heading" align="middle"><strong>{{__('frontend.register.email_sent.title')}}</strong></h1>
                                    <p class="content" align="middle">{{__('frontend.register.email_sent.details')}}<br>
                                        If you do not find our email in Inbox, please follow the steps by <a href="#" data-toggle="modal" data-target="#exampleModalCenter">clicking here.</a> 
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="social-media-icons" style="text-align: center; margin-left: -25px;">
                                        {{--<span>{{__('frontend.register.email_sent.follow_us')}}</span><br>--}}
                                        <ul>
                                            <li><a href="https://facebook.com/SJPanel" target="_blank"><i class='fab fa-facebook fa-2x'></i></a></li>
                                            <li><a href="https://x.com/sjpanelsurvey" target="_blank"><i class='fab fa-twitter fa-2x'></i></a></li>
                                            <li><a href="https://www.linkedin.com/company/sjpanel/" target="_blank"><i class='fab fa-linkedin fa-2x'></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row" style="text-align: center;">
                                <a href="{{route('frontend.index')}}" class="home btn btn-success btn-outline">{{__('frontend.register.email_sent.home')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="margin-top:20px;">{!!__('frontend.register.email_sent.index_help')!!}:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>{!!__('frontend.register.email_sent.popup_title')!!}:</h5>
        <ul>
            <li style="width:300px;"><strong>{!!__('frontend.register.email_sent.step1')!!}:</strong> {!!__('frontend.register.email_sent.step1_title')!!}<br></li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li><strong>{!!__('frontend.register.email_sent.step2')!!}:</strong> {!!__('frontend.register.email_sent.step2_title')!!} </li>
            <li><strong>{!!__('frontend.register.email_sent.step3')!!}:</strong> {!!__('frontend.register.email_sent.step3_title')!!} </li>
            <li><strong>{!!__('frontend.register.email_sent.step4')!!}:</strong> {!!__('frontend.register.email_sent.step4_title')!!} </li>
            <li><strong>{!!__('frontend.register.email_sent.step5')!!}:</strong> {!!__('frontend.register.email_sent.step5_title')!!} </li>
            {{--<li><strong>Step 3:</strong> Click on "Move to Tab" and select "Primary"</li>
            <li><strong>Step 4:</strong> You will receive this pop-up on the left bottom "Conversation moved to Primary. Do this for future messages from donotreply@sjpanel.com?"</li>
            <li><strong>Step 5:</strong> Please select "Yes" on this pop-up</li>--}}

        </ul>
        <h5>{!!__('frontend.register.email_sent.yahoo')!!}</h5>
      </div>
      <div class="modal-footer">
        
        
      </div>
    </div>
  </div>
</div>
@endsection
