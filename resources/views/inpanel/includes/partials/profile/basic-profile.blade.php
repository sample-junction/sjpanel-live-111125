@push('after-styles')
<style>
    .emsg{
        border: 1px solid red !important;
    }
    .help-block{
        display: none !important;
    }
    .has-error .control-label{
        color: #6b6868 !important;
        font-weight: 700 !important;
    }
</style>
@endpush
<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.basic_profile.basic_profile')}}

        {{--<div class="pull-right">
            <p>Connect with</p>
            <a href="{{route('inpanel.user.profile.preference.social','facebook')}}" class="btn  btn-outline-info m-1">
                <i class="fab fa-facebook"></i></a>
            <i class="fab fa-twitter"></i>
        </div>--}}
    </div>
    <div class="ibox-title">
        <b>{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_email')}} : </b>  {{auth()->user()->email}}
    </div>

    <div class="ibox-content basic_profile_form">
        @if (isset($status))
            <div class="alert alert-success">
                {{ $status }}
            </div>
        @endif
        {{--{!! BootForm::horizontal(); !!}--}}
        {{html()->form('post',route('inpanel.user.profile.preference.update',request()->route()->parameter('name')))->acceptsFiles()->open()}}
        {!! BootForm::text('first_name', __('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_1'), auth()->user()->first_name,['maxlength' => '20']) !!}
        <div id="first_name_err" style="color:red; margin-top: -10px;"></div>
        {{--{!! BootForm::text('middle_name', __('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_4'), auth()->user()->middle_name,['maxlength' => '20']) !!}
        <div id="middle_name_err" style="color:red; margin-top: -10px;"></div>--}}
        {!! BootForm::text('last_name', __('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_2'), auth()->user()->last_name,['maxlength' => '20']) !!}
        <div id="last_name_err" style="color:red; margin-top: -10px;"></div>
        @if(auth()->user()->is_social==1)
        {!! BootForm::text('email', __('Email'), auth()->user()->email) !!}
        @endif
        <div class="form-group ">
            <label for="last_name" class="control-label">{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_3')}} : </label>&nbsp;&nbsp;{{auth()->user()->gender}}
        </div>
        
        {{--{!! BootForm::radios('gender', __('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_3'), ['male'=>__('inpanel.user.profile.preferences.preferences_menu.basic_profile_gender_male'), 'female'=> __('inpanel.user.profile.preferences.preferences_menu.basic_profile_gender_female')], auth()->user()->gender); !!}--}}
        <div class="form-group ">
            <label for="last_name" class="control-label">{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_date_of_birth')}} : </label>&nbsp;&nbsp;{{(!empty(auth()->user()->dob))?auth()->user()->dob->format('m-d-Y'):''}}
        </div>
        {{--{!! BootForm::text('dob', __('inpanel.user.profile.preferences.preferences_menu.basic_profile_date_of_birth'), (!empty(auth()->user()->dob))?auth()->user()->dob->format('m-d-Y'):'', ['id'=>'dob','placeholder'=>'MM-DD-YYYY', 'suffix' => BootForm::addonText(__('inpanel.user.profile.preferences.preferences_menu.basic_profile_date_format')), 'readonly' => 'true']) !!}--}}
        

        {!! BootForm::file('images',__('inpanel.user.profile.preferences.preferences_menu.upload_photo'),['accept'=> "image/*"]) !!}
        <div id="images_err" style="color:red; margin-top: -10px;"></div>
        {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}

        {!! BootForm::text('fb', __('inpanel.user.profile.preferences.preferences_menu.facebook'), auth()->user()->fb) !!}
        <div id="fb_err" style="color:red;margin-top: -10px;"></div>
        {!! BootForm::text('twitter',__('inpanel.user.profile.preferences.preferences_menu.twitter'), auth()->user()->twitter) !!}
        <div id="twitter_err" style="color:red;margin-top: -10px;"></div>
        {!! BootForm::text('linkdin', __('inpanel.user.profile.preferences.preferences_menu.linkedin'), auth()->user()->linkdin) !!}
        <div id="linkdin_err" style="color:red;margin-top: -10px;"></div>
        {!! BootForm::label('device_preference',__('inpanel.user.profile.preferences.preferences_menu.device')); !!}
        
        {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.desktop_laptop'), '2', ((in_array('2',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'all_preference','onclick'=>'checkDevice(this,"1")')); !!}
        {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.mobile_phone'), '3', ((in_array('3',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'all_preference','onclick'=>'checkDevice(this,"1")')); !!}
        {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.tablet'), '4', ((in_array('4',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'all_preference','onclick'=>'checkDevice(this,"1")')); !!}
        {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.all'), '1', ((in_array('1',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'alldevice','onclick'=>'checkDevice(this,"1")')); !!}

            {{--<div class="form-group">
                
                <label for="dob" class="control-label">Select Two Factor Authentication</label>
                <div>
                    <div class="input-group">
                        <select class="form-control" name="two_fact_auth">
                            <option @if(auth()->user()->two_fact_auth==0) selected @endif value="0">No</option>
                            <option @if(auth()->user()->two_fact_auth==1) selected @endif value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>--}}
        {!! BootForm::submit(__('inpanel.user.profile.preferences.preferences_menu.basic_profile_update_button')); !!}
        {{html()->form()->close()}}
    </div>
</div>
@push('after-scripts')
   {{-- @php
        $tour_detail = $user_add_data->user_tour_taken;
        $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='preferences.basic-profile' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
        @endphp--}}
    {{--<script>
    @if($tour_taken == 0)
@include('inpanel.includes.partials.php-js.basic_profile')
        @endif
    </script>--}}

<script>
    $(document).ready(function(){
        $(':text').on('keypress',function(e){
            if($(this).attr('id') == 'first_name' || $(this).attr('id') == 'middle_name' || $(this).attr('id') == 'last_name' ){
                var input = String.fromCharCode(e.which);
                var regex = /[a-zA-Z]/;
                if(!regex.test(input)){
                    e.preventDefault();
                    $('#'+$(this).attr('id')+'_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.special_character')}}");
                }else{
                    $('#'+$(this).attr('id')+'_err').html('');
                    var input_txt = $('#'+$(this).attr('id')).val();
                    if(input_txt.length > 1){
                        var currentInput = input;
                        var lastInput = input_txt.substr(-1,1);
                        var lastBeforeInput = input_txt.substr(-2,1);
                        if(currentInput === lastInput && currentInput === lastBeforeInput){
                            e.preventDefault();
                            $('#'+$(this).attr('id')+'_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.repeat_character')}}");
                        }else{
                            $('#'+$(this).attr('id')+'_err').html('');
                        }
                    }
                }
            }   
        });
        $(':text').on('blur',function(e){
            if($(this).attr('id') == 'first_name' || $(this).attr('id') == 'middle_name' || $(this).attr('id') == 'last_name' ){
                $('#'+$(this).attr('id')+'_err').html('');
            }
        });
    });
    let status=0;
 $(document).on('click','.btn',function(){
        facebook=$('#fb').val();
        twitter=$('#twitter').val();
        linkdin=$('#linkdin').val();
        if(facebook!=''){
        if (/^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(facebook))
        {
         $('#fb').removeClass('emsg');
          $('#fb_err').html("");
         $('.btn').prop('disabled',false);
        
        }else{
            $('#fb').addClass('emsg');
            $('#fb_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.facebook_error')}}");
           // $('.btn').prop('disabled',true);
            status=1;
           
        }
    }
      if(twitter!=''){
        if (/^(https?:\/\/)?((w{3}\.)?)twitter\.com\/(#!\/)?[a-z0-9_]+$/i.test(twitter))
        {
         $('#twitter').removeClass('emsg');
         $('#twitter_err').html('');
        
        }else{
            $('#twitter').addClass('emsg');
             $('#twitter_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.twitter_error')}}");
            // $('.btn').prop('disabled',true);
           status=1;
        }
    }
     if(linkdin!=''){
        if (/(ftp|http|https):\/\/?(?:www\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(linkdin) )
        {
         $('#linkdin').removeClass('emsg');
        $('#linkdin_err').html('');
        }else{
            $('#linkdin').addClass('emsg');
            $('#linkdin_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.linkedin_error')}}");
            // $('.btn').prop('disabled',true);
            status=1;
        }
    }
    if(status==1){
        return false;
    }

    })
    function checkDevice(deviceType,count){
       
        if(deviceType.value == 2 || deviceType.value == 3 || deviceType.value == 4){
            $('.alldevice').prop('checked',false);
        }else if(deviceType.value == 1){
            if($(deviceType).is(':checked')){
                //$('.all_preference').prop('disabled',true);
                $('.all_preference').prop('checked',true);
            }else{
               // $('.all_preference').prop('disabled',false);
                $('.all_preference').prop('checked',false); 
            }
           
        }

        var all_preference_status = true;

        $('.all_preference').each(function(){        
            if(!$(this).is(':checked')){
                all_preference_status = false;
            }
        });
        if(all_preference_status){
            $('.alldevice').prop('checked',true);
        }
        
    }

    $("#images").on("change",function(){
            
            /* current this object refer to input element */
            var $input = $(this);

            /* collect list of files choosen */
            var files = $input[0].files;

            var filename = files[0].name;
     
            /* getting file extenstion eg- .jpg,.png, etc */
            var extension = filename.substr(filename.lastIndexOf("."));

            /* define allowed file types */
            var allowedExtensionsRegx = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

            /* testing extension with regular expression */
            var isAllowed = allowedExtensionsRegx.test(extension);

            if(isAllowed){
                //alert("File type is valid for the upload");
                $('#images').removeClass('emsg');
                $('.btn').prop('disabled',false);
                $('#images_err').html('');
                /* file upload logic goes here... */
            }else{
                 $('#images_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.image_error')}}");
                $('#images').addClass('emsg');

                $('.btn').prop('disabled',true);
                return false;
            }
        }); 
</script>
@endpush