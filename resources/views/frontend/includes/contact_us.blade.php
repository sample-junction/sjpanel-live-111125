<div class="row">
    <!--Grid column-->
    <div class="text-center col-md-6 col-md-offset-3">

        {{html()->form('POST',route('frontend.auth.send.email'))->id('contact-us')->open()}}
        <!--Form with header-->
            <div class="card-body p-3">
                <!--Body-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-light"><i class="fa fa-user text-primary"></i></div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" name="name" placeholder="{{__('frontend.index.contact_us.name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mb-sm-0">
                                <div class="input-group-addon bg-light"><i class="fa fa-envelope text-primary"></i></div>
                                <input type="email" class="form-control" id="inlineFormInputGroupUsername" name="email" placeholder="{{__('frontend.index.contact_us.email')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea class="form-control" placeholder="{{__('frontend.index.contact_us.message')}}" name="messages" rows="6"></textarea>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" value="1" class="form-check-input"  name="consent">&nbsp; {{__('frontend.index.contact_us.consent_1')}}
                                <a href="{{route('frontend.cms.term_condition')}}"> {{__('frontend.index.contact_us.consent_2')}}</a> & <a href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.contact_us.consent_3')}}</a>
                            </label>
                        </div>
                    </div>
                </div><!--row-->
            </div>

            <div class="card-footer col-md-5 col-md-offset-4 text-center">
                <button type="submit" class="g-recaptcha btn btn-primary btn-block rounded-0 py-2"
                        onclick="onSubmitData()"
                        data-sitekey="{{config('settings.RECAPTCHA_SITE_KEY')}}"
                        data-callback="onSubmit"
                >
                    <i class="fa fa-spinner fa-spin" id="load" style="display: none"></i>
                    {{__('frontend.index.contact_us.button')}}
                    <i class="fas fa-caret-right"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        {{__('frontend.index.contact_us.commit_statement')}}
                    </div>
                </div>
            </div><!--row-->
            {{html()->form()->close()}}
        <!--Form with header-->
    </div>
</div>


@push('after-styles')
<style>
    .contact_us {
        display: table-cell;
        vertical-align: middle;
    }

    </style>
@endpush
@push('after-scripts')
    <script>
        function onSubmit(token) {
            $('#loading').show();
            $('form#contact-us').submit();
        }
        function onSubmitData()
        {
            $('#load').show();
        }
    </script>
@endpush
