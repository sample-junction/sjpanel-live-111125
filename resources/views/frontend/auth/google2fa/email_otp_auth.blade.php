
<style>
    #projects-show{
        min-height: 500px;
    }
    .sk-spinner-wave.sk-spinner {
        margin: 0 auto;
        width: 50px;
        height: 30px;
        text-align: center;
        font-size: 2px;
    }
    .sk-spinner-wave div {
        background-color: #1ab394;
        height: 100%;
        width: 6px;
        display: inline-block;
        -webkit-animation: sk-waveStretchDelay 1.2s infinite ease-in-out;
        animation: sk-waveStretchDelay 1.2s infinite ease-in-out;
    }
    .sk-spinner-wave .sk-rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }
    .sk-spinner-wave .sk-rect3 {
        -webkit-animation-delay: -1s;
        animation-delay: -1s;
    }
    .sk-spinner-wave .sk-rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }
    .sk-spinner-wave .sk-rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }
    @-webkit-keyframes sk-waveStretchDelay {
        0%,
        40%,
        100% {
            -webkit-transform: scaleY(0.4);
            transform: scaleY(0.4);
        }
        20% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }
    @keyframes  sk-waveStretchDelay {
        0%,
        40%,
        100% {
            -webkit-transform: scaleY(0.4);
            transform: scaleY(0.4);
        }
        20% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }
    #back {
        text-decoration: underline;
        color: black;
    }
    #resend{
        text-decoration: underline;
        color: black;
    }


    #one_time_password {
        text-align: center;
    }

    .error {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
        padding:1px 20px 1px 20px;
    }
</style>


<div class="panel-heading" style="padding-bottom:0px;">
    <div style="margin-top: -125px; margin-left: 15px; font-weight: bold;">
        <a id="back" class="text-dark" >
            {{__('frontend.modes.two_fact.back')}}
        </a>
</div>
<h3 style="display: block; text-align: center; bottom: 20px;"><strong>{{__('frontend.modes.email_auth.heading')}}</strong></h3>
</div>
<div class="panel-body email_otp">
    <form class="form-horizontal" method="POST" action="{{ route('frontend.auth.2fa.email.auth') }}">
        @csrf
        {{-- <input type="hidden" id="requestid" name="rid" value="{{$uuid}}" />
        <input type="hidden" id="eventid" name="eid" value="{{$ip}}" />
        <input type="hidden" id="cc" value="{{$country_code}}" />
        <input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}"> --}}
        <div class="form-group">
            <label id="label" for="one_time_password" class="col-md-12 control-label" style="display: block; text-align: center; bottom: 20px; font-weight:600!important; margin-bottom:15px;">{{__('frontend.modes.email_auth.label')}}</label>
             <div class="col-md-6 text-center" style="width: 100%; display: flex; justify-content:center;">
                <input id="one_time_password" type="text" class="form-control" name="one_time_password" required autofocus style="width: 80%; max-width: 300px; margin-bottom: 15px; border-radius: 5px; margin-bottom:15px;">
                <div class="resend_otp_loader" style="display:none;">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                @php
                   $em   = explode("@",$email);
                   $name = implode('@', array_slice($em, 0, count($em) - 1));
                   $len  = strlen($name)-2;
                  $masked_email = str_repeat('*', $len) .substr($name,$len). "@" . end($em);
                @endphp
             
            </div>

              
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4" style="width: 100%; display:flex; justify-content:center; margin:0;">
                <button type="submit" class="btn btn-primary" style="width: 80%; max-width: 300px;border-radius: 10px; background-color: rgb(16, 128, 208)!important; margin-bottom:130px; ">
                    {{__('frontend.modes.email_auth.button')}}
                </button>
            </div>
        </div>

            <div style="text-align: center; font-weight: bold; margin-top: -117px;">
                <span id="resend">{{__('frontend.modes.email_auth.span_1')}} <a href="javascript:void(0);" id="resend_otp">{{__('frontend.modes.email_auth.span_3')}}</a></span>
            </div>
        </div>
       
    </form>
</div>

<script>
    $(document).on('click','#back',function (e) {
        location.reload();
    })
    $(document).on('click','a#resend_otp',function (e) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
        $('div.resend_otp_loader').show();
        $('span#resend').hide();
        axios.get("{{ route('frontend.auth.2fa.otp.resend') }}").then(function (response) {
            if (response.status === 200) {
                var $html = response.data;
                $('span#resend').show();
                $('span#resend').html('{!! __('frontend.modes.email_auth.span_2') !!}')
            }
        }).catch(function (error) {
            alert('error occured');
            console.log(error);
        }).then(function () {
            jQuery('div.resend_otp_loader').hide();
        });
    })
</script>
