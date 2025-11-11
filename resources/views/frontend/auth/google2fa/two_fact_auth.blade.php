<div class="panel-heading">
    <h3><strong>{{__('frontend.modes.two_fact.heading')}}</strong></h3>
</div>
<div class="panel-body">
    <form class="form-horizontal" method="POST" action="{{ route('frontend.auth.2fa') }}">
        @csrf
        <div class="form-group">
            <label for="one_time_password" class="col-md-5 control-label">{{__('frontend.modes.two_fact.label')}}</label>
            <div class="col-md-6">
                <input id="one_time_password" type="text" class="form-control" name="one_time_password" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    {{__('frontend.modes.two_fact.button')}}
                </button>
                <button id="back" class="btn btn-primary">
                    {{__('frontend.modes.email_auth.back')}}
                </button>
            </div>
            <div class="col-md-6 col-md-offset-4">

            </div>
        </div>
    </form>
</div>

<script>
    $(document).on('click','#back',function (e) {
        location.reload();
    })
</script>
