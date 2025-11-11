<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.email-scheduled.title')}}
    </div>
    <div class="ibox-content">
        <p>{!!__('inpanel.user.profile.preferences.email-scheduled.content')!!}</p>

        <p>{!!__('inpanel.user.profile.preferences.email-scheduled.content_2')!!}</p>
        <a href="{{route('inpanel.user.profile.preference.completeUnsubscribe')}}" class="email_unsubscribe">{{__('inpanel.user.profile.preferences.email-scheduled.unsubscribe')}}</a>

        <div class="ibox float-e-margins">
            <div class="">
                <!-- <h5> <a class="collapse-link schedule_email">{{__('inpanel.user.profile.preferences.email-scheduled.advanced')}}  <i class="fa fa-chevron-down"></i></a></h5> -->
            </div>
            {{html()->form('post',route('inpanel.user.profile.preference.update',request()->route()->parameter('name')))->acceptsFiles()->open()}}
            <div class="ibox-content" style="">
                <div id="external-events">
                    <p>{{__('inpanel.user.profile.preferences.email-scheduled.weekly')}}</p>
                    <div class="row">
                        <div class="col-sm-6">
                            
                            <div class="radio radio-primary">
                                <input type="radio" name="email_ratio" id="radio1" value="1" @if(auth()->user()->email_ratio==1) checked @endif>
                                <label for="radio1">
                                    {{__('inpanel.user.profile.preferences.email-scheduled.email_ratios_1')}}
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <input type="radio" name="email_ratio" id="radio2" value="2" @if(auth()->user()->email_ratio==2) checked @endif>
                                <label for="radio2">
                                    {{__('inpanel.user.profile.preferences.email-scheduled.email_ratios_2')}}
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <input type="radio" name="email_ratio" id="radio2" value="3" @if(auth()->user()->email_ratio==3) checked @endif>
                                <label for="radio2">
                                    {{__('inpanel.user.profile.preferences.email-scheduled.email_ratios_3')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}
            </div>
            {!! BootForm::submit(__('inpanel.user.profile.preferences.preferences_menu.basic_profile_update_button')); !!}
            {{html()->form()->close()}}
        </div>

    </div>
</div>
@push('after-styles')

    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <style>
        .sweet-alert button.cancel{
            background-color: #23c6c8;
        }

        .sweet-alert button.cancel:hover{
            background-color: #21b9bb;
        }
        .swal-wide{
            width:600px !important;
        }
    </style>
@endpush
@push('after-scripts')

    <!-- Sweet alert -->
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <script>
        {{--@php

            $tour_detail = $user_add_data->user_tour_taken;
             $tour_taken=0;
            if($tour_detail){
                foreach ($tour_detail as $key => $value){
                    if($value['section']=='preferences.email-schedule' && $value['taken']==true){
                        $tour_taken=1;
                    }
                }
            }
        @endphp--}}
        {{--@if($tour_taken == 0)
        @include('inpanel.includes.partials.php-js.email_schedule')
        @endif--}}

        $(document).ready(function(){

            jQuery('a.email_unsubscribe').click(function (e) {
                var currentVar = $(this);
                e.preventDefault();
                swal({
                    title: "Unsubscribe from all emails",
                    text:"<p>We're sorry to hear you'd like to unsubscribe from our emails</p><br/>" +
                        "<p>Why are you unsubscribing ?</p>" +
                        "<div class=\"form-group\">" +
                        "    <textarea class=\"form-control\" id=\"unsubscribe_reason\" rows=\"3\"></textarea>" +
                        "  </div>",
                    // --------------^-- define html element with id
                    html: true,
                    width: '600px',
                    customClass: 'swal-wide',
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#ed5565",
                    confirmButtonText: "Unsubscribe now!",
                    cancelButtonText: "I changed my mind",
                    cancelButtonColor: "#1080d0",
                    closeOnConfirm: false,
                }, function (isConfirm) {
                    if (isConfirm) {
                        console.log(currentVar.attr('href'));
                        window.location.href = currentVar.attr('href');
                    } else {

                    }

                });
            });



        });
    </script>

@endpush
