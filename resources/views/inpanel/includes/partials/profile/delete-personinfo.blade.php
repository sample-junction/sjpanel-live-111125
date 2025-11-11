<div class="ibox float-e-margins">
    <div class="ibox-title">
        {!!__('inpanel.nav.label.delete_personal_info')!!}
    </div>
    <div class="ibox-content">
        {!! BootForm::vertical(['id'=>'pinfo_delete_form']) !!}

        <p><strong>{!!__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.prior_info_before_delete_new')!!}</strong></p>
        <p>{!!__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.prior_info_before_delete_2_new')!!}</p>
        {!! BootForm::checkbox('delete_personalinfo', __('inpanel.user.profile.preferences.delete-personinfo.basic_profile.confirmation_text'), '1', false); !!}

        {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}
        {!! BootForm::hidden('delete_reason',null,['id'=> 'delete_reason']) !!}
        {!! BootForm::submit(__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.delete_account'),['class'=>'btn btn-danger delete_pinfo_submit']) !!}

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
    <!-- Sweet alert -->
    {{--<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>--}}
    <script>
        $(document).ready(function(){
            var flag = true;
            jQuery('.delete_pinfo_submit').click(function (e) {
                e.preventDefault();
                if($("input[name='delete_personalinfo']").is(":checked")){
                    //$(".form-group").removeClass("has-error");
                    $(".help-block").text("");

                    swal({
                        title: "{{__('inpanel.user.profile.preferences.delete-account.basic_profile.title_1')}}",
                        html:"{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.title_2')!!}" +
                            "{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.title_3')!!}" +
                            "{!!__('inpanel.user.profile.preferences.delete-account.basic_profile.title_4')!!}"+
                            '<div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I do not receive converting surveys" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_1")!!}</label></div></div><div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I do not have time to take surveys" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_2")!!}</label></div></div> <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I need higher incentive surveys" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_3")!!}</label></div></div> <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="I am moving to a different country" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_4")!!}</label></div></div> <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="The surveys are too lengthy" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_5")!!}</label></div></div>  <div class="col-sm-12 col-md-12"><div class="radio" style="margin-top: -4px; margin-bottom: 6px;text-align: left;margin-left: 62px;"><label><input required="required" data-precode_type="other" data-question="UNSUBSCRIBE" name="reason" type="radio" value="Others" aria-required="true">{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_6")!!}</label></div></div> <div class="col-sm-12 col-md-12"><input type="text" name="otherReason" id="otherstext" placeholder="Please mention" class="form-control" style="display: none;width:66%;margin:0 auto;"></div></div>',
                        // --------------^-- define html element with id
                        width: '450px',
                        customClass: 'swal-wide',
                        //input: 'text',
                        type: "error",
                        showCancelButton: true,
                        confirmButtonColor: "#ed5565",
                        confirmButtonText: "{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_7")!!}",
                        cancelButtonText: "{!!__("inpanel.user.profile.preferences.delete-account.basic_profile.label_8")!!}",
                        cancelButtonColor: "#1080d0",
                        closeOnConfirm: false,
                    })
                    .then((result) => {
                        //alert(result);
                       // console.log(result.value);
                        if (result.value) {
                            //  var delete_reason = $('#delete_info_reason').val();
                            // // alert(delete_reason);
                            // if(delete_reason!=''){

                            //    $('#delete_reason').val(delete_reason);
                            //     jQuery('#pinfo_delete_form').submit();
                            //     // For more information about handling dismissals please visit
                            //     // https://sweetalert2.github.io/#handling-dismissals
                            // }else{
                            //     swal.fire(
                            //             'Required',
                            //             'Reason is required',
                            //             'error'
                            //         ) 
                            // }

                            if($("input[name='reason']").is(":checked")){
                                var delete_reason = $("input[name='reason']:checked" ).val()
                                //alert(deactivate_reason);
                                if(delete_reason!=''){
                                    if(delete_reason=='Others'){
                                        var othertext = $('#otherstext').val();
                                        if(othertext){
                                            $('#delete_reason').val(othertext);
                                            jQuery('#pinfo_delete_form').submit();
                                        }else{
                                            swal.fire(
                                                'Required',
                                                'Other reason text is required',
                                                'error'
                                            )  
                                        }
                                        
                                    }else{
                                        $('#delete_reason').val(delete_reason);
                                        jQuery('#pinfo_delete_form').submit();
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
                        $(".form-group:first").append("<span class='help-block' style='color:red;'>{{__('inpanel.user.profile.preferences.delete-account.basic_profile.error_1')}}.</span>");
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

