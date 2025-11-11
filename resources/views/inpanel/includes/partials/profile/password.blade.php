<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.password_title')}}
    </div>
    <div class="ibox-content password_change">

        {!! BootForm::horizontal(); !!}

        {!! BootForm::password('password', __('inpanel.user.profile.preferences.preferences_menu.password_new_password')) !!}
        <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
        <span style="color: red;margin-left: 222px;" id="password-msg"></span>
        {!! BootForm::password('password_confirmation', __('inpanel.user.profile.preferences.preferences_menu.password_confirm_new_password')) !!}
        <span toggle="#password_confirmation" class="fa fa-fw fa-eye-slash field-icon toggle-password-confirm"></span>

        {!! BootForm::submit(__('inpanel.user.profile.preferences.preferences_menu.password_update_button')); !!}

        {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}

        {!! BootForm::close() !!}
    </div>
</div>
@push('after-styles')
<style>
    .help-block{
        display: none;
    }
    .field-icon {
    float: left;
    margin-left: 516px;
    margin-top: -38px;
    position: relative;
    z-index: 2;
}
.form-control, .single-line{
    width: 50% !important;
}
.emsg{
        border: 1px solid red;
    }

    </style>

@endpush

@push('after-scripts')
    {{--@php
        $tour_detail = $user_add_data->user_tour_taken;
         $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='preferences.password' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
    @endphp
    <script>
    @if($tour_taken == 0)
@include('inpanel.includes.partials.php-js.password')
        @endif
    </script>--}}
    <script>
        $(document).on('click',".toggle-password",function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
        $(document).on('click',".toggle-password-confirm",function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

        $(document).ready(function() {
            var flag = 0;
    var msg = '';
    $('.form-horizontal .form-control').blur(function() {

        var info = $(this).val();
        var id = $(this).attr('id');

        if(id == 'password_confirmation' || id=='password'){
            var pass = $("#password").val();
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if(pass.length<8)
            {
                $(this).addClass('emsg');
                $('#password-msg').html('Password should be atleast 8 characters.')
                //$(this).show();
                flag = 1;
                msg += 'Weak (should be atleast 8 characters.).\n';
                return false;
            }else{ 
                flag = 0;
                $('#password-msg').html('');
                $(this).removeClass('emsg');
            } 

            if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters) && flag==0) {
               flag = 0;
                $(this).removeClass('emsg');
                $('#password-msg').html('')
        } else {
            $(this).addClass('emsg');
                //$(this).show();
                  $('#password-msg').html('Password should include alphabets, numbers and special characters.')
                flag = 1;
                msg += 'Medium (should include alphabets, numbers and special characters or some combination.).\n';
           
        }
            if(pass != info){
                // there is a mismatch, hence show the error message
                $(this).addClass('emsg');
                //$(this).show();
                flag = 1;
                msg += 'Passwords do not match.\n';
            }
            else{
                flag = 0;
                $(this).removeClass('emsg');
            } 
        }
    })

    $('.form-horizontal').on('submit', function(){
        if(flag || $('.emsg').length > 0){
            $(':input[type="submit"]').prop('disabled', false);
            alert('Please provide valid input for the marked fields');
            return false;
        }
        return true;
    })
        });
    </script>
@endpush
