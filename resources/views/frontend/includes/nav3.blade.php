
<style>

@media only screen and (max-width: 600px) {
    #language-button{

        border: none;
        background: white!important;
        padding: 12px 10px;
        margin-top: -5px; 

    }
    .custom-dropdown-item {
        font-size: 16px;
        font-weight: bold;
    }

    .gradient-custom-2 {
    /* fallback for old browsers */
    background: #006BDE;
    display: grid !important;
    border-radius: 10px 0px 0px 10px;
    
    }
    
    .Languague{
      display: none;
    }
    
    .all_language_list .Languague img{
        position: absolute;
        left: 17px;
        height: 17px;
        top: 6px;
    }
        
    .all_language_list .Languague .dropdown-header{
      position: relative;
        right: -38px;
        top: 4px;
    }
    
    .toast-error{
        background-color: red !important;
        font-size: 12px;
    }
    #contain-div-1{
      border-radius: 10px 0px 0px 10px;
    }
    
    .log-submit:hover{
      color: white;
    }
    
    
    @media (min-width: 768px) and (max-width: 981px){
    .footer_style {
        margin-top: 135px;
    }
    }
    
    @media(min-width: 370px) and (max-width:376px){
        .footer_style p {
            padding-right: 0px !important;
        }
        .footer_style .vcenter .copyright{
          padding-left: 11% !important;
        }
    }
}
</style>

<!-- ########################### SECTION START ########################### -->

<div class="card bg-white">
    <div class="card-header bg-white" style="height: 80px!important; padding-bottom: 0px; display: flex; align-items: center; border: 1px solid rgb(240, 238, 238);">
        <img src="{{ asset('/images/logo.png') }}" alt="best survey site" style="width: 150px; height: 30px; margin-left: 20px; border: 20px; margin-left: 200px;">
        <ul class="nav_new" style="margin-left: auto; display: flex; align-items: center; margin-right: 20px;">
            <li><a href="{{route('frontend.auth.register')}}" id="get" class="btn text-white" style="border-radius: 90px; margin-top: 20px; background-color: rgba(16, 128, 208, 1); padding: 5px 15px; color:white!important;">{{__('frontend.nav.static.link.home')}}</a>
            </li>
            <li class="dropdown language_dropdown" style="color: rgb(46, 36, 36); padding: 0px; border: 1px solid rgb(235, 228, 228); height:auto; margin-top: 20px;margin-left: 20px;margin-left: 20px; border-radius: 5px; margin-right:200px;">

            
                {{-- <div class="blink_me_other">
                    {{__('frontend.nav.static.binker')}} <span class="glyphicon glyphicon-arrow-right"></span>
                </div> --}}
                <a class="dropdown-toggle" style="color: black; padding: 8px; " id="language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            
                             <i style="padding: 0px;"><img id="img_01" style="height: 32px; width:76px; margin-top: 0px;" src="{{asset('/img/'.$flags.'.png')}}" alt="online survey site"></i>
                            {{-- @if(!empty($currentLanguage)) {{$currentLanguage->language_code}} @endif --}}
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right all_language_list" aria-labelledby="language-button" style="min-width:120px;">
                            
                            <div class="col-md-61" style="width: 120px;margin-left: 10px;">
                                {{--US--}}
                                <!-- <li role="separator" class="divider"></li> -->
                                {{--
                                <li class="dropdown-header">{{__('frontend.nav.static.language_1')}}</li>
                                <li><a class="#" href="/lang/en_US">{{__('frontend.nav.static.language_2')}}</a></li>
                                <li><a href="/lang/es_US">{{__('frontend.nav.static.language_3')}}</a></li>
                                --}}
                                @if($countryCode=='US')
                                <div id="US" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/USA.png" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )" alt="paid online survey"> <li class="dropdown-header">US</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_US" class="#" onclick="changeImage(this, 'US-EN' ,'img/USA.png' )">{{__('ENGLISH US')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/es_US" class="#" style="left: 18px !important;" onclick="changeImage(this, 'US-ES' ,'img/USA.png' )">{{__('frontend.nav.static.language_spanish')}} US </a></li>
                                </div>
                                
                                @endif
                                
                                {{--CA--}}
                                 @if($countryCode=='CA')
                                 <div id="CA" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/CANADA.png" alt="legit survey site"> <li class="dropdown-header">CA</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_CA" class="#">{{__('ENGLISH CA')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/fr_CA" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_french')}} CA </a></li>
                                </div>
                                
                                @endif

                                {{--ES--}}
                                @if($countryCode=='ES')
                                <div id="ES" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/SPAIN.png" alt="online surveys to earn money"> <li class="dropdown-header">ES</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_ES" class="#">{{__('ENGLISH ES')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/fr_ES" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_spanish')}} ES </a></li>
                                </div>
                                
                                 @endif
                                {{--DE--}}
                                @if($countryCode=='DE')
                                <div id="DE" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/GERMANY.png" alt="fill surveys to earn money"> <li class="dropdown-header">DE</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_DE" class="#">{{__('ENGLISH DE')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/fr_DE" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_german')}} DE </a></li>
                                </div>
                                
                                 @endif
                                {{--AU--}}
                                @if($countryCode=='AU')
                                <div id="AU" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/AUSTRALIA.png" alt="fill survey and earn money"> <li class="dropdown-header">AU</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_UK" class="#">{{__('ENGLISH AU')}} </a></li> 
                                </div>
                                
                                 @endif
                            </div>
                            <div class="col-md-61" style="margin-left: 10px;width: 90% !important;">
                                {{--UK--}}
                                <!-- <li role="separator" class="divider"></li> -->
                                @if($countryCode=='UK')
                                <div id="UK" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/UNITED KINGDOM.png" alt="earn money answering surveys"> <li class="dropdown-header">UK</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_UK" class="#">{{__('ENGLISH UK')}} </a></li> 
                                </div>
                                
                                
                                @endif
                                {{--FR--}}
                                @if($countryCode=='FR')
                                <div id="FR" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/FRANCE.png" alt="making money answering surveys"> <li class="dropdown-header">FR</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_FR" class="#">{{__('ENGLISH FR')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/fr_FR" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_french')}} FR </a></li>
                                </div>
                                
                                @endif
                                {{--IT--}}
                                 @if($countryCode=='IT')
                                 <div id="IT" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/ITALY.png" alt="answer survey and earn money"> <li class="dropdown-header">IT</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_IT" class="#">{{__('ENGLISH IT')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/it_IT" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_italian')}} IT </a></li>
                                </div>
                                
                                @endif
                                {{--IN--}}
                                @if($countryCode=='IN')
                                <div id="IN" class="Languague" style="display: block;font-weight:600;">
                                    <div style="display:flex;margin-top:5px;margin-bottom:10px;"><img src="img/INDIA.png" alt="making money doing surveys"> <li class="dropdown-header">IN</li></div>
                                        
                                    <li style="margin-bottom:15px;"><a href="/lang/en_IN" class="#">{{__('ENGLISH IN')}} </a></li> 
                                    <li style="margin-bottom:15px;"><a href="/lang/hi_IN" class="#" style="left: 18px !important;">{{__('frontend.nav.static.language_hindi')}} IN </a></li>
                                </div>
                                @endif
                            </div>
                            
                        </ul>

                    </li> 
                    @auth
                    <a href="{{ route('frontend.auth.logout') }}" class="btn btn-transparent" style=" margin-top: 20px; margin-right: 300px;"> <i class="fas fa-sign-out-alt"></i> {{__('inpanel.nav.button_logout')}}</a>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')


<script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v5.2.0.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
<script>
 $(document).ready(function() {

  var country_code = $('#cc').val();
$("#"+country_code).show();
 
$("#show_hide_password1 a").on('click', function(event) {
    event.preventDefault();
    if($('#show_hide_password1 input').attr("type") == "text"){
        $('#show_hide_password1 input').attr('type', 'password');
        $('#show_hide_password1 svg').addClass( "fa-eye-slash" );
        $('#show_hide_password1 svg').removeClass( "fa-eye" );
    }
    else if($('#show_hide_password1 input').attr("type") == "password"){
        $('#show_hide_password1 input').attr('type', 'text');
        $('#show_hide_password1 svg').removeClass( "fa-eye-slash" );
        $('#show_hide_password1 svg').addClass( "fa-eye" );
    }
});
$("#show_hide_password a").on('click', function(event) {
    event.preventDefault();
    if($('#show_hide_password input').attr("type") == "text"){
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password svg').addClass( "fa-eye-slash" );
        $('#show_hide_password svg').removeClass( "fa-eye" );
    }
    else if($('#show_hide_password input').attr("type") == "password"){
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password svg').removeClass( "fa-eye-slash" );
        $('#show_hide_password svg').addClass( "fa-eye" );
    }
});
});

function myFun() {
document.getElementById("toast-container").style.display = "none";
}


 var emailError = document.getElementById('email-error');
var passwordError = document.getElementById('password-error');
var confirmError = document.getElementById('pass-error');

function validateEmail(){
// alert("hello");

var email = document.getElementById('form2Example11').value;

if(email.length == 0){
    emailError.innerHTML = '{{(__('validation.attributes.frontend.email_require'))}}';
    return false;
}
console.log(email);
if(!email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
    emailError.innerHTML = '{{(__('validation.attributes.frontend.email_valid'))}}';
    return false;
}
emailError.innerHTML = '';
return true;
}

function validatePassword(){
// alert("hello");
var password = document.getElementById('create_pass').value;

if(password.length == 0){
    passwordError.innerHTML = '{{(__('validation.attributes.frontend.password_req'))}}';
    return false;
}
/*if(!password.match(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/)){
  passwordError.innerHTML = "{{(__('validation.attributes.frontend.password_valid'))}}";
  return false;
}*/
if(password.length < 8){
    passwordError.innerHTML = '{{(__('validation.attributes.frontend.password_valid1'))}}';
    return false;
}
if(password.length > 16){
  passwordError.innerHTML = '{{(__('validation.attributes.frontend.password_valid2'))}}';
  return false;
}
passwordError.innerHTML = '';
// validateForm();
return true;
}


const emailInput = document.getElementById('form2Example11');
const passwordInput = document.getElementById('create_pass');
const submitButton = document.getElementById('submit');

emailInput.addEventListener('input', validateForm);
passwordInput.addEventListener('input', validateForm);

function validateForm() {
if(!validateEmail() || !validatePassword()){

submitButton.disabled = true;
submitButton.style.background = "#DCDCDC";
submitButton.style.color = "#757575";
return false;
}
else{
submitButton.style.background = "#006BDE";
submitButton.style.color = "white";
submitButton.disabled = false;
}
}

if($('#form2Example11').val()!=''){
validateForm();
}



// emailIn.addEventListener('input', checkForm);
// passwordIn.addEventListener('input', checkForm);

// function checkForm(){
//     if(){
  
//     }

// } 


$('select#country').on('change',function(e){
    var country_code = $('select#country').val();
    fetchLanguage(country_code)
});

function fetchLanguage(country_code)
{
   var countryName={};
   countryName['US']='USA.png';
   countryName['CA']='CANADA.png';
   countryName['AU']='AUSTRALIA.png';
   countryName['ES']='SPAIN.png';
   countryName['DE']='GERMANY.png';
   countryName['UK']='UNITED KINGDOM.png';
   countryName['IN']='INDIA.png';
   countryName['FR']='FRANCE.png';
   countryName['IT']='ITALY.png';

   
   country_flag=countryName[country_code];
   //$('#img_01').attr('src','img/'+country_flag);

    var header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
    if(!country_code || country_code == 0){
        return false;
    }
    axios.get("{{route('frontend.auth.language')}}",{
        params:{
            country_code: country_code,
        }
    }).then(function (response) {
        if(response.status === 200){
            $select = $('#language');
            $select.find('option').remove();
            var lang = response.data;
            $.each(lang, function (value, name) {
                $select.append($('<option />', {value: value, text: name}));
            });
        }
    }).catch(function (error) {
        // handle error
    }).then(function () {
        // always executed
        console.log('always executed');
    });
}


function changeImage(clickedImage , data){
    var targetImage = document.getElementById("img_01");
    targetImage.src = clickedImage.src;
    targetImage.textContent = data;
    // count1.src = clickedImage.src;
    // count2.textContent = clickedImage.country_code;
    // count3.textContent = clickedImage.language;
  console.log("image");
  console.log(clickedImage);
}


    $(document).on('click',".toggle-password",function() {

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
$('.login_form .form-control').blur(function() {

    var info = $(this).val();
    var id = $(this).attr('id');
    var dfiq_check=$("#dfiq_check").val();
                                    
    if(id == 'email'){
        if(flag==0 && dfiq_check==1){
         invokeAPI(info); 
        }
    }
})

});
function invokeAPI(info) {
            var req = document.getElementById("requestid").value;
            var event = document.getElementById("eventid").value;
            var country = document.getElementById("cc").value;
            var utm_source="SjPanelLogin";
            var disableOptions=[3];
            //$('#form-dispaly').hide();
           // $('.loader').show();
            var uniquenessParam = Forensic.createUniquenessParam(event,null, false);
            var geoParam = Forensic.createGeoParam(country);
            Forensic.forensic(req, successCallback, errorCallback, uniquenessParam, geoParam, null, disableOptions, utm_source);
        }
         
        function errorCallback(jsonData) {
            console.log(jsonData.error.message); // Add your logic to handle errors
        }
</script>

@endpush

<!-- ########################### SECTION END ########################### -->
