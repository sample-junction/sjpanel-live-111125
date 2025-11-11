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
                <div class="ibox-content col-lg-6" style="max-width:500px;">
                    {{html()->form('POST',route('inpanel.unsubscribe.post',$email))->open()}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h1 class="heading" align="middle"><strong>{{__('frontend.register.unsubscribe_confirmation.title')}}</strong></h1>
                                <h4 class="content" align="middle" style="padding-top: 10px;padding-bottom: 10px;">{{__('frontend.register.unsubscribe_confirmation.question.title')}}</h4>
                                
                                    <div  class="form-group" style="display: inline-block;margin-left: 38px;">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option1')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option1')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option2')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option2')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option3')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option3')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option4')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option4')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option5')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option5')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option6')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option6')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label><input required="required" data-precode_type="other" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option7')}}" aria-required="true">{{__('frontend.register.unsubscribe_confirmation.question.radio_option7')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">

                                            <textarea name="otherReason" id="otherstext" class="form-control" style="display:none;" placeholder="{{__('frontend.register.unsubscribe_confirmation.question.other_placeholder')}}"></textarea>
                                        </div> 
                                    </div>  
                                    
                                <p class="content" align="middle">{{__('frontend.register.unsubscribe_confirmation.details')}}</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row" style="text-align: center;">
                                <input type="submit" class="home btn btn-success btn-outline" name="submit" value="{{__('frontend.register.unsubscribe_confirmation.confirm')}}">
                            </div>
                        </div>
                    </div>
                    {{html()->form()->close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
<script>
$(document).on('change', "input[data-precode_type='other']", function(e){
    $('#otherstext').hide();
    $('#otherstext').prop('required',false);
    var current_status = this.checked;
    var question = $(this).data('question');

    $("input[data-question='"+question+"']").each(function(){
        if(this.checked) {
            $(this).prop("checked", false);
        }
    });

    if(current_status){
        $(this).prop("checked", true);
        $('#otherstext').show();
        $('#otherstext').prop('required',true);
    }

});
$(document).on('change', "input[data-precode_type='general']", function(e){
    $('#otherstext').hide();
    $('#otherstext').prop('required',false);
});
</script>
@endpush