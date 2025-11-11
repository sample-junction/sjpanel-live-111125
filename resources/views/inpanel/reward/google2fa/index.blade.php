
@push('after-styles')
<style>
    body {
        padding: 0 15px;
        margin-bottom: 100px;
    }
    @media (min-width: 768px) {
        .container {
            max-width: 770px;
        }
    }
    header {
        margin-top: 25px;
        text-align: center;
    }
    h1 {
        font-size: 4em;
        font-weight: 700;
        margin-bottom: 0.5em;
    }
    h2 {
        margin-top: 1em;
        font-size: 1.5em;
        font-weight: 400;
    }
    #uri {
        color: gray;
    }
    #uri:focus {
        color: inherit;
    }
    #qr {
        padding: 25px;
        text-align: center;
    }
    #app {
        padding: 10px 20px;
        background-color: white;
        border-top: 15px solid #f2f2f2;
        border-bottom: 15px solid #f2f2f2;
        font-family: 'Roboto', sans-serif;
    }
    #app_code {
        color: #4285f4;
        font-weight: 500;
        font-size: xx-large;
    }
    #app_label {
        color: #757575;
    }
</style>
@endpush
<div class="row google2fa">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{__('inpanel.user.profile.preferences.two_fact.modal.subheading')}}</div>
            <div class="panel-body" style="text-align: center;">
                <p>{{__('inpanel.user.profile.preferences.two_fact.modal.details_1')}}{{ $secret }}</p>
                {{--<div>
                    <img src="{{ $QR_Image }}">
                </div>--}}
                <div id="qr"></div>
                <p>{{__('inpanel.user.profile.preferences.two_fact.modal.details_2')}}</p>
                {{--<div>
                    <a href="{{route('frontend.auth.2fa.register',$user)}}"><button class="btn-primary">Complete Registration</button></a>
                </div>--}}

                <p><input class="form-control" type="hidden" id="secret" value="{{$secret}}" placeholder="Secret &mdash; Required" spellcheck="false"></p>
                <p><input class="form-control" type="hidden" id="label" value="{{$label}}" placeholder="Label &mdash; Required" spellcheck="false"></p>
                <p><input class="form-control" type="hidden" id="issuer" value="{{$issuer}}" placeholder="Issuer &mdash; Optional" list="issuers" spellcheck="false"></p>
                <p><input class="form-control" type="hidden" id="url" value="{{$url}}"  list="issuers" spellcheck="false"></p>
            </div>
            <div class = "panel-footer">
                <div class="row">
                <p class="col-md-12">{{__('inpanel.user.profile.preferences.two_fact.modal.details_app')}}</p>
                </div>
                <div class="row">
                <p class="col-md-4">
                    <img
                        src="{{asset('img/inpanel/google_auth.png')}}"
                        alt="" /> <br />
                    {{__('inpanel.user.profile.preferences.two_fact.app.google')}}
                </p>
                <p class="col-md-4">
                    <img
                        src="{{asset('img/inpanel/ms_authenticator.png')}}"
                        alt="" /> <br />
                    {{__('inpanel.user.profile.preferences.two_fact.app.microsoft')}}
                </p>
                <p class="col-md-4">
                    <img
                        src="{{asset('img/inpanel/authy_2.png')}}"
                        alt="" /> <br />
                    {{__('inpanel.user.profile.preferences.two_fact.app.authy')}}
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="opt_verify" class="control-label">{{__('inpanel.user.profile.preferences.two_fact.modal.label')}}</label>
            <div>
                <input id="one_time_password" type="text" class="form-control" name="one_time_password" required autofocus>
            </div>
        </div>
    </div>
</div>


@push('after-scripts')

@endpush
