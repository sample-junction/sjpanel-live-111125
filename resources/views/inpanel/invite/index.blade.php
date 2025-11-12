1@extends('inpanel.layouts.app')
@push('after-styles')
    <style>
        .pankaj{
            background-color: #0d70b7;
        }
        .bs-wizard {margin-top: 40px;}

        /*Form Wizard*/
        .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
        .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
        .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
        .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
        .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
        .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
        .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
        .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
        .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
        .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
        .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
        .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
        .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
        .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
    </style>
@endpush
@section('content')

    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="ibox-content m-b-sm border-bottom">
                <div class="p-xs">
                    <div class="pull-left m-r-md">
                        <i class="fa fa-globe text-navy mid-icon"></i>
                    </div>
                    <h2>{{__('inpanel.invite.index.title')}}</h2>
                    <span>{{__('inpanel.invite.index.heading')}}</span>
                </div>
            </div>

            <div class="ibox-content forum-container invite_info">

                <div class="forum-title">
                    <h3>{{__('inpanel.invite.index.sub_heading')}}</h3>
                </div>
                <div>
                    <p>
                        {{__('inpanel.invite.index.sub_heading_details', ['invite_points' => $get_referal_point->value])}}
                    </p>
                </div>
            </div>

            <div class="ibox-content forum-container">

                <h4> {{__('inpanel.invite.index.brief_for_steps')}} </h4>
                <div class="row bs-wizard steps_invite_points" style="border-bottom:0;">
                    <div class="col-xs-3 bs-wizard-step complete">
                        <div class="text-center bs-wizard-stepnum"><strong>{!!__('inpanel.invite.index.step1_heading')!!}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center">{{__('inpanel.invite.index.step1_details')}}</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                        <div class="text-center bs-wizard-stepnum"><strong>{{__('inpanel.invite.index.step2_heading')}}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center">{{__('inpanel.invite.index.step2_details')}}</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                        <div class="text-center bs-wizard-stepnum"><strong>{{__('inpanel.invite.index.step3_heading')}}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center">{{__('inpanel.invite.index.step3_details')}}</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step complete"><!-- active -->
                        <div class="text-center bs-wizard-stepnum"><strong>{{__('inpanel.invite.index.step4_heading')}}</strong></div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center"> {!!__('inpanel.invite.index.step4_details', ['invite_points' => $get_referal_point->value])!!}Ramesh{{$get_referal_point->value}}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox collapsed border-bottom">
                        <div class="ibox-title">
                            <h5>{{__('inpanel.invite.index.invitaion_links')}}</h5>
                        </div>
                        <div class="ibox-content" style="display: block;">
                            <div class="invitation_link">
                                <p>
                                    {{__('inpanel.invite.index.share_details')}}
                                </p>
                                <p>
                                    {{__('inpanel.invite.index.share_details_1')}}
                                </p>
                                <strong class="color-primary">{{$invite_link->getLinkAttribute()}}</strong><button type="button" id="copyUrl" class="btn btn-info" style="margin-left:13px;"><i class="fa fa-copy"></i></button>
                                <div>
                                    <!-- AddToAny BEGIN -->
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{!! $invite_link->getLinkAttribute() !!}" data-a2a-title="SJ Panel  - Invitation">
                                        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_google_plus"></a>
                                    </div>
                                    @push('after-scripts')
                                        <script>
                                            var a2a_config = a2a_config || {};
                                            a2a_config.onclick = 1;
                                            a2a_config.num_services = 6;
                                            function addFunction()
                                            {
                                                document.getElementById("wrap").innerText;
                                            }

                                        </script>
                                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                                @endpush
                                <!-- AddToAny END -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox collapsed border-bottom">
                        <div class="ibox-title">
                            <h5>{{__('inpanel.invite.index.refer_email')}}</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content invite_form" id="wrap" style="display: block;">
                            {!! BootForm::horizontal() !!}
                            <div class="form-group"><label class="col-lg-2 control-label">{{__('inpanel.invite.index.label_1')}}</label>

                                <div class="col-lg-10"><input type="text" placeholder="{{__('inpanel.invite.index.label_1')}}" class="form-control" name="name" autocomplete="off">
                                    <span class="help-block m-b-none">{{--__('inpanel.invite.index.label_2')--}}</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">{{__('inpanel.invite.index.label_2')}}</label>

                                <div class="col-lg-10"><input type="text" placeholder="{{__('inpanel.invite.index.label_2')}}" class="form-control" name="last_name" autocomplete="off">
                                    
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">{{__('inpanel.invite.index.label_3')}}</label>

                                <div class="col-lg-10"><input type="email" placeholder="{{__('inpanel.invite.index.label_3')}}" class="form-control" name="email"  autocomplete="off">
                                    <span class="help-block m-b-none">{{__('inpanel.invite.index.friend_email')}}</span>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-sm btn-primary" type="submit">{{__('inpanel.invite.button_submit')}}</button>
                                </div>
                            </div>
                            {!! BootForm::close() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('after-scripts')
   {{-- <script>
        @if($tour_taken == 0)
        @include('inpanel.includes.partials.php-js.invite')
        @endif

    </script>--}}
    <script>
        $('#copyUrl').click(function(){
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('.color-primary').text()).select();
            document.execCommand("copy");
            $temp.remove();

        });
    </script>
@endpush
