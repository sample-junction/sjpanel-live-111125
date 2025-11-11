<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.preferences_menu.deactivate_account')}}
    </div>
    <div class="ibox-content">
        {!! BootForm::vertical(['id'=>'account_delete_form']) !!}

        <p><strong>{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.prior_info_before_delete_new')!!}</strong></p>

        <p>{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.prior_info_before_delete_2_new')!!}</p>

        <p>{{--__('inpanel.user.profile.preferences.delete-account.basic_profile.prior_info_before_delete_3_new')--}}</p>

        {!! BootForm::checkbox('delete_confirmation', __('inpanel.user.profile.preferences.delete-account.basic_profile.confirmation_text'), '1', false); !!}

        {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}
        {!! BootForm::hidden('deactive_reason',null,['id'=> 'deactive_reason']) !!}
        {!! BootForm::submit(__('inpanel.user.profile.preferences.preferences_menu.deactivate_account'),['class'=>'btn btn-danger delete_account_submit']) !!}

        {!! BootForm::close() !!}
    </div>
</div>
@push('after-styles')
    <!-- Sweet Alert -->
    {{--<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">--}}
    <style>
        .sweet-alert button.cancel{
            background-color: #23c6c8;
        }

        .sweet-alert button.cancel:hover{
            background-color: #21b9bb;
        }
        .swal-wide{
            width:450px !important;
        }
    </style>
@endpush
@push('after-scripts')

<!-- <textarea name="otherReason" id="otherstext" placeholder="Please mention" class="form-control" style="display: none;width:66%;margin:0 auto;"></textarea> -->

    <!-- Sweet alert -->
    {{--<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>--}}
    <script>
        $(document).ready(function(){

            var flag = true;
            jQuery('.delete_account_submit').click(function (e) {
                e.preventDefault();
                if($("input[name='delete_confirmation']").is(":checked")){
                    //$(".form-group").removeClass("has-error");
                    $(".help-block").text("");
                    
                    swal({
                        title: "{{__('inpanel.user.profile.preferences.delete-account.basic_profile.deativate_title_1')}}",
                        html:"{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.deativate_title_2')!!}" +
                            "{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.title_3')!!}" +
                            "{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.title_4')!!}"+
                            '<div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I do not receive converting surveys" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_1")!!}</label></div></div><div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I do not have time to take surveys" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_2")!!}</label></div></div> <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I need higher incentive surveys" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_3")!!}</label></div></div> <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I am moving to a different country" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_4")!!}</label></div></div> <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="The surveys are too lengthy" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_5")!!}</label></div></div>  <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="other" data-question="UNSUBSCRIBE" name="reason" type="radio" value="Others" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_6")!!}</label></div></div> <div class="col-sm-12 col-md-12"><input type="text" name="otherReason" id="otherstext" placeholder="Please mention" class="form-control" style="display: none;width:66%;margin:0 auto;"></div></div>',
                        // --------------^-- define html element with id
                        width: '450px',
                        customClass: 'swal-wide',
                        type: "error",
                        showCancelButton: true,
                        confirmButtonColor: "#ed5565",
                        confirmButtonText: "{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_9")!!}",
                        cancelButtonText: "{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_8")!!}",
                        cancelButtonColor: "#1080d0",
                        closeOnConfirm: false,
                    })
                    .then((result) => {
                        if (result.value) {
                           if($("input[name='reason']").is(":checked")){
                                var deactivate_reason = $("input[name='reason']:checked" ).val()
                                //alert(deactivate_reason);
                                if(deactivate_reason!=''){
                                    if(deactivate_reason=='Others'){
                                        var othertext = $('#otherstext').val();
                                        if(othertext){
                                            $('#deactive_reason').val(othertext);
                                            jQuery('#account_delete_form').submit();
                                        }else{
                                            swal.fire(
                                                'Required',
                                                'Other reason text is required',
                                                'error'
                                            )  
                                        }
                                        
                                    }else{
                                        $('#deactive_reason').val(deactivate_reason);
                                        jQuery('#account_delete_form').submit();
                                    }
                                        // For more information about handling dismissals please visit
                                        // https://sweetalert2.github.io/#handling-dismissals
                                }
                           
                           }else{
                                swal.fire(
                                        'Required',
                                        'Reason is required',
                                        'error'
                                    ) 
                            }
                            // For more information about handling dismissals please visit
                            // https://sweetalert2.github.io/#handling-dismissals
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            // swal.fire(
                            //     'Cancelled',
                            //     'Your imaginary file is safe :)',
                            //     'error'
                            // )
                        }
                    })
                }else{
                    //$(".form-group").addClass("has-error");
                    if(flag)
                    {
                        $(".form-group:first").append("<span class='help-block' style='color:red;'>{{__('inpanel.user.profile.preferences.delete-account.basic_profile.error_2')}}</span>");
                    flag = false;
                    }
                     
                }
            });

        });
    </script>
    <script>
$(document).on('change', "input[data-precode_type='other']", function(e){
    //alert();
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

@push('after-scripts')
    {{--@php

        $tour_detail = $user_add_data->user_tour_taken;
         $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='preferences.delete-account' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
    @endphp
    <script>
    @if($tour_taken == 0)
@include('inpanel.includes.partials.php-js.delete')
        @endif
    </script>--}}
@endpush

