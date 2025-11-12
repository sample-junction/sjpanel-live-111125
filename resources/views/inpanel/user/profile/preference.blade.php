@extends('inpanel.layouts.device')
@push('after-styles')
<style>
    #swal2-title {
        padding-bottom: 5px;
        padding-top: 20px;
    }

    .swal2-input {
        scale: 0.9;
    }

    #my_profile_details a {
        font-size: 13px !important;
    }

    .swal2-popup .swal2-title {
        padding: 20px 5px !important;
        font-size: 1.675em !important;
    }

    .swal-content {
        padding: 8px 20px 20px;
    }

    #fb,
    #twitter,
    #linkdin {
        width: 93% !important;
    }
</style>
<link href="{{asset('css2/My-account_style.css')}}" rel="stylesheet">
<link href="{{asset('css2/dashboard_style.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.2/dist/sweetalert2.min.css" rel="stylesheet">
@endpush
@section('myAccount_select','cst-active')
@section('content')

<div class="row mt-4">
    <div class="col">
        <p class="h4 ms-2 mt-3" style="font-weight: 600;">{{__('inpanel.nav.my_account')}}</p>
    </div>
</div>
<div id="flash_msg_disabled" class="alert alert-success" style="display:none;"></div>
{{--@if (session()->has('flash_success'))
    <div id="flash_msg" class="alert alert-success">
        {{ session('flash_success') }}
</div>
@elseif($errors->any())
<div id="flash_msg" class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif--}}
<!-- for deactive account -->
<form id="deactive_form" method="post" action="{{route('inpanel.user.profile.preference.update','delete-account')}}" enctype="multipart/form-data">
    @csrf

    <div class="w-100 h-100 d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="offcanvas offcanvas-center m-auto" tabindex="-1" id="DEACTIVE"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a class="" href="#"><img src="{{asset('images/Featured icon.png')}}" alt="logo" width="53px" style="position: absolute;top: 15px;" class="img-fluid"></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="position: relative;top: 13px;" id="close-but" onclick="close()"></button>
            </div>
            <div class="offcanvas-body" style="padding-right: 5px;padding-left: 5px;">
                <ul class="navbar-nav p-3 justify-content-end flex-grow-1 pe-3">
                    <h2 class="deactive_head">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_9')}}</h2>
                    <p class="deactive_p">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_14')}} <br> {{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_16')}}</p>
                    <p class="deactive_p">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.title_3')}}</p>
                    <div>
                        <input type="radio" name="deactive_reason" id="deactive_reason" value="I do not receive converting surveys" required>
                        <label for="" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_1')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="deactive_reason" id="deactive_reason" value="I do not have time to take surveys" required>
                        <label for="" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_2')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="deactive_reason" id="deactive_reason" value="I need higher incentive surveys" required>
                        <label for="" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_3')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="deactive_reason" id="deactive_reason" value="I am moving to a different country" required>
                        <label for="" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_4')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="deactive_reason" id="deactive_reason" value="The surveys are too lengthy" required>
                        <label for="" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_5')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="deactive_reason" id="deactive_reason" value="Others" required>
                        <label for="" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_6')}}</label>
                    </div>
                    <input type="textarea" id="reason_txt" class="mt-3 text_area" placeholder="{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_18')}}" name="additional_reason">
                </ul>
                <input type="hidden" id="section" name="section" value="delete-account">
                <div class="d-flex justify-content-center gap-2">
                    <button type="submit" id="deactivateButton" class="btn btn-primary btn-lg  px-lg-5">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_10')}}</button>
                    <button type="button" id="cancelButton" class="btn btn-primary btn-lg  px-lg-5" data-bs-dismiss="offcanvas">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_12')}}</button>
                </div>
            </div>
        </div>
    </div>

</form>
<!--  -->
<!-- for delete  -->
<form id="delete_form" method="post" action="{{route('inpanel.user.profile.preference.update','delete-personinfo')}}" enctype="multipart/form-data">
    @csrf

    <div class="w-100 h-100 d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="offcanvas offcanvas-center" tabindex="-1" id="DELETE"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a class="" href="#"><img src="{{asset('images/Featured icon.png')}}" alt="logo" width="53px" style="position: absolute;top: 15px;" class="img-fluid"></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="position: relative;top: 13px;"></button>
            </div>
            <div class="offcanvas-body" style="padding-right: 5px;padding-left: 5px;">
                <ul class="navbar-nav p-3 justify-content-end flex-grow-1 pe-3">
                    <h2 class="deactive_head">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_13')}}</h2>
                    <p class="deactive_p">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_15')}} <br>{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_17')}}</p>
                    <p class="deactive_p">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.title_3')}}</p>
                    <div>
                        <input type="radio" name="delete_reason" id="deactive_reason" value="I do not receive converting surveys" required>
                        <label for="deactive_reason" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_1')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="delete_reason" id="deactive_reason" value="I do not have time to take surveys" required>
                        <label for="deactive_reason" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_2')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="delete_reason" id="deactive_reason" value="I need higher incentive surveys" required>
                        <label for="deactive_reason" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_3')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="delete_reason" id="deactive_reason" value="I am moving to a different country" required>
                        <label for="deactive_reason" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_4')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="delete_reason" id="deactive_reason" value="The surveys are too lengthy" required>
                        <label for="deactive_reason" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_5')}}</label>
                    </div>
                    <div>
                        <input type="radio" name="delete_reason" id="deactive_reason" value="Others" required>
                        <label for="deactive_reason" class="px-lg-2" id="deactive_label">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_6')}}</label>
                    </div>
                    <input type="textarea" id="others_txt" class="mt-3 text_area" name="additional_reason" placeholder="{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_18')}}" disabled>
                </ul>
                <input type="hidden" id="section" name="section" value="delete-personinfo">
                <div class="d-flex justify-content-center gap-2">
                    <button type="submit" id="deactivateButton" class="btn btn-danger btn-lg  px-lg-5">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_7')}}</button>
                    <button type="button" id="deleteButton" class="btn btn-primary btn-lg  px-lg-5" data-bs-dismiss="offcanvas">{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_12')}}</button>
                </div>
            </div>
        </div>
    </div>

</form>
<!--  -->

@php

if (isset($_GET['tab'])){
$searched_tab = $_GET['tab'];
}

@endphp

<div class="row p-1 p-lg-3" id="main_content">
    <div class="shadow border rounded pe-4 ps-4 pt-3" style="background: #FFFFFF;" id="main_content_sec">
        <div class="col-12 mt-4 mb-4">
            <div class="row d-block my_details" id="my_profile_details" style="margin-top: -20px;">
                <a class="basic_profile basicProfile @php if(isset($searched_tab)){ if($searched_tab == 'basic'){echo 'active_color';} else{echo'';} } else{echo'active_color';} @endphp" style="text-decoration: none;" id="Basic_Profile" onclick="myFun()">{{__('inpanel.nav.label.basic_profile')}}</a>
                <a class="basic_profile basicProfile @php if(isset($searched_tab)){ if($searched_tab == 'security'){echo 'active_color';} else{echo'';} } else{echo'';} @endphp" style="text-decoration: none;" id="Security" onclick="myFun1()">{{__('inpanel.nav.label.security')}}</a>
                <a class="basic_profile basicProfile @php if(isset($searched_tab)){ if($searched_tab == 'email'){echo 'active_color';} else{echo'';} } else{echo'';} @endphp" style="text-decoration: none;" id="Email_Frequency" onclick="myFun2()">{{__('inpanel.nav.label.email_frequnecy')}}</a>
                <a class="basic_profile @php if(isset($searched_tab)){ if($searched_tab == 'mydata'){echo 'active_color';} else{echo'';} } else{echo'';} @endphp" style="text-decoration: none;" id="MyData" onclick="myFun3()">{{__('inpanel.nav.label.my_data')}}</a>
                <a class="basic_profile basicProfile @php if(isset($searched_tab)){ if($searched_tab == 'deactivate'){echo 'active_color';} else{echo'';} } else{echo'';} @endphp" style="text-decoration: none;" id="Deactivate_Account" onclick="myFun4()">{{__('inpanel.nav.label.deactive_account')}}</a>
                <a class="basic_profile basicProfile @php if(isset($searched_tab)){ if($searched_tab == 'delete'){echo 'active_color';} else{echo'';} } else{echo'';} @endphp" style="text-decoration: none;" id="Delete" onclick="myFun5()">{{__('inpanel.nav.label.delete_personal_info')}}</a>
            </div>
            <hr class="hr_line">
            <div>
                <div class="" @php if(isset($searched_tab)){ if($searched_tab=='basic' ){echo '' ;}else{echo'style="display:none"';} } @endphp id="basic_prof">
                <form  method="post" action="{{route('inpanel.user.profile.preference.update','basic-profile')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <label for="first_name">{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_1')}}</label><br>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{auth()->user()->first_name}}" maxlength="20">
                            <br><span id="first_name_err" style="color:red;"></span>
                            <input type="hidden" id="section" name="section" value="basic-profile">
                            
                        </div>
                        <!-- <div class="col-md-4 col-12">
                            <label for="">Middle Name</label><br>
                            <input type="text" class="form-control" >
                            </div> -->
                        <div class="col-md-4 col-12">
                            <label for="last_name">{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_2')}}</label><br>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{auth()->user()->last_name}}" maxlength="20">
                            <br><span id="last_name_err" style="color:red;"></span>
                        </div>
                        <div class="col-md-4 col-12">
                            <label for="gender">{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_details_filling_3')}}</label><br>                                             
                            <input type="text" id="gender" name="gender" class="form-control" style="font-weight: 600;background: #f9f9f9;" value="{{auth()->user()->gender}}" readonly>
                        </div>
                    </div>
                    <div class="row pt-md-4">
                        <div class="col-md-4 col-12" style="position: relative;">
                            <label for="dob">{{__('inpanel.user.profile.preferences.preferences_menu.basic_profile_date_of_birth')}}</label><br>                                        
                            <input type="text" id="dob" name="dob" class="form-control" style="font-weight: 600;background: #f9f9f9;" value="{{ auth()->user()->dob ? \Carbon\Carbon::parse(auth()->user()->dob)->format('m-d-Y') : '' }}" readonly>
                            <span class="input-group-addon date_group" style="top: -30px;right: 8%;left: 90%;position: relative;">
                            <i class="fa fa-calendar"></i>
                            </span>
                            <!-- <div id="datepicker"
                                class="input-group date"
                                data-date-format="mm-dd-yyyy">
                                <input class="form-control date_div"
                                type="text"  id="form2Example11" style="background: white;cursor: pointer;width: 100%;border-radius: 6px;font-weight: 600;"
                                name="date" required/>
                                <span class="input-group-addon date_group" style="background:white;position: absolute;bottom: 7px;right: 10px;">
                                
                                <i class="fa fa-calendar"></i>
                                </span>
                                
                                </div> -->
                        </div>
                        
                        <div class="col-md-4 col-12">
                            <label for="">{{__('inpanel.user.profile.preferences.preferences_menu.profile_pic')}}</label><br>
                            <!-- <input type="file" class="form-control" id="myFile" style="" name="filename" placeholder="Click to Upload"> -->
                            <!-- <button type="button" style="" class="form-control photo_upload ">
                                <span class=""> Click to Upload</span>
                                </button>  -->
                            
                            <button type="button" id='btn-upload' class="form-control photo_upload">{{__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')}}</button>
                    <input type='file' id='images' style="display: none;" name='images' />
                    <br><span id="images_err" style="color:red;"></span>
                </div>
                <!-- Parshant Sharma [10-09-2024] Starts -->

                <div class="col-md-4 col-12">

                    <label for="">{{__('inpanel.user.profile.preferences.preferences_menu.preferred_language')}}</label>
                    <select class="form-control form-select country" id="language" name="language" required>
                        <option>English</option>
                    </select>
                    <span id="language-error" class="error"></span>

                </div> <!-- Language Div -->

                <!-- Parshant Sharma [10-09-2024] Ends -->


            </div>
            <div class="row pt-md-4">
                <div class="col-md-4 col-12 position-relative" id="{{--social_icon--}}">
                    <div>
                        <label for="fb">{{__('inpanel.user.profile.preferences.preferences_menu.facebook')}}</label><br>
                        <input type="text" id="fb" name="fb" class="form-control" value="{{auth()->user()->fb}}" placeholder="{{__('inpanel.invite.index.label_facebook')}}">
                        <img src="{{asset('images/Vector.png')}}" alt="" class="{{--position-absolute--}}"
                            style="top: -30px;right: 8%;left: 95%;position: relative;">
                        <br><span id="fb_err" style="color:red;"></span>
                    </div>
                    <div>

                    </div>
                </div>
                <div class="col-md-4 col-12 position-relative" id="">
                    <label for="twitter">{{__('inpanel.user.profile.preferences.preferences_menu.twitter')}}</label><br>
                    <input type="text" id="twitter" name="twitter" class="form-control" value="{{auth()->user()->twitter}}" placeholder="{{__('inpanel.invite.index.label_x_twitter')}}">
                    <img src="{{asset('images/Vector.png')}}" alt="" class=""
                        style="top: -30px;right: 8%;left: 95%;position: relative;">
                    <br><span id="twitter_err" style="color:red;"></span>
                </div>
                <div class="col-md-4 col-12 position-relative" id="">
                    <label for="linkdin">{{__('inpanel.user.profile.preferences.preferences_menu.linkedin')}}</label><br>
                    <input type="text" id="linkdin" name="linkdin" class="form-control" value="{{auth()->user()->linkdin}}" placeholder="{{__('inpanel.invite.index.label_linkedin')}}">
                    <img src="{{asset('images/Vector.png')}}" alt="" class=""
                        style="top: -30px;right: 8%;left: 95%;position: relative;">
                    <br><span id="linkdin_err" style="color:red;"></span>
                </div>
            </div>
            <button type="submit" id="update-button" class="btn btn-primary btn-lg mt-4 px-lg-5 w-sm-100">{{__('inpanel.user.profile.preferences.preferences_menu.password_update_button')}}</button>
            </form>
        </div>

        <div id="security" class="@php if(isset($searched_tab)){ if($searched_tab == 'security'){echo 'Show';}else{echo'';} } @endphp">
            <h5>{{__('inpanel.user.profile.preferences.password_title')}}</h5>
            <p>{{__('inpanel.user.profile.preferences.password_details')}}</p>
            <hr>
            <form method="post" action="{{route('inpanel.user.profile.preference.update','password')}}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row pt-4">
                    <div class="col-md-4" id="security_1">
                        <label for="">{{__('inpanel.user.profile.preferences.preferences_menu.password_new_password')}}</label><br>
                        <div id="security1">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <span class="first_eye">
                                <i class="fa-solid fa-eye-slash pass_icon" style="width:fit-content; left:88%;"></i>
                            </span>
                        </div>
                        <span id="pwd_err" style="color:red;"></span>
                    </div>
                    <div class="col-md-4" id="security_2">
                        <label for="">{{__('inpanel.user.profile.preferences.preferences_menu.password_confirm_new_password')}}</label><br>
                        <div id="security2">
                            <input type="password" id="confirm_pass" class="form-control" required>
                            <span class="second_eye">
                                <i class="fa-solid fa-eye-slash pass_icon" style="width:fit-content; left:88%;"></i>
                            </span>
                        </div>
                        <span id="cnf_err" style="color:red;"></span>
                    </div>
                </div>
                <input type="hidden" id="section" name="section" value="password">

                <button type="submit" id="pwd_chng_btn" class="btn btn-primary btn-lg mt-4 px-lg-5" disabled>{{__('inpanel.user.profile.preferences.preferences_menu.password_update_button')}}</button>
                <div class="two_step" id="two_st">
                    <div class="">
                        <h6 class="mt-4 two_step_h4">{{__('inpanel.user.profile.preferences.two_fact.heading')}}</h6>
                        <p class="two_step_p">{{__('inpanel.user.profile.preferences.two_fact_details')}}<br>
                            {{__('inpanel.user.profile.preferences.two_fact_heading2')}}
                        </p>
                    </div>
                    <div class="mt-4">
                        <h5 class="email_2fa">{{__('inpanel.user.profile.preferences.two_fact_email')}}
                            @if(auth()->user()->two_fact_auth==1)
                            <span class="scrollImg" id="scroll-img2" onclick="removeSwitch()">
                                <img src="{{asset('images/Rectangle 89.png')}}" class="scrollImg2" id="image2" style="transition: all 1s !important;" alt="">
                            </span>
                            {{--<a href="{{route('inpanel.user.profile.two_fact_auth.disable')}}" type="button" id="disable" class="btn btn-primary"> {{__('inpanel.user.profile.preferences.two_fact.button_1')}} </a>--}}
                            @else
                            <span class="" id="scroll-img" onclick="scrollSwitch()">
                                <img src="{{asset('images/Rectangle 89.png')}}" id="image1" style="transition: all 1s !important;" alt="">
                            </span>
                            @endif
                            {{--<a href="{{ route('inpanel.user.profile.two_fact_auth.setting') }}" type="button" class="btn btn-primary1" id="get_started">
                            <label class="switch ">
                                <input type="checkbox" class="primary">
                                <span class="slider round"></span>
                            </label>
                            </a>--}}
                        </h5>
                    </div>
                </div>
            </form>
        </div>

        <div id="email_frequency" class="@php if(isset($searched_tab)){ if($searched_tab == 'email'){echo 'Show';}else{echo'';} } @endphp">
            <form method="post" action="{{route('inpanel.user.profile.preference.update','email-schedule')}}" enctype="multipart/form-data">
                @csrf
                <div>
                    <h5>{{__('inpanel.user.profile.preferences.preferences_menu.email_scheduled')}}</h5>
                    <hr>
                    <p class="email_p">{{__('inpanel.user.profile.preferences.email-scheduled.content')}}<br>
                        <span class="nnote">{{__('inpanel.user.profile.preferences.email-scheduled.note')}}</span>{{__('inpanel.user.profile.preferences.email-scheduled.content_2')}}
                    </p>
                    @php
                    $checked = auth()->user()->email_ratio;

                    @endphp
                    <span class="email_input input_opt">
                        <input type="radio" name="email_ratio" id="first_opt" value="1" @if ( $checked===1) checked @endif />
                        <label for="first_opt" class="px-lg-2">{{__('inpanel.user.profile.preferences.email-scheduled.email_ratios_1')}}</label>
                    </span>
                    <span class="email_input input_opt">
                        <input type="radio" name="email_ratio" id="second_opt" value="2" @if ( $checked===2) checked @endif />
                        <label for="second_opt" class="px-lg-2">{{__('inpanel.user.profile.preferences.email-scheduled.email_ratios_2')}}</label>
                    </span>
                    <span class="input_opt">
                        <input type="radio" name="email_ratio" id="third_opt" value="3" @if ( $checked===3) checked @endif />
                        <label for="third_opt" class="px-lg-2">{{__('inpanel.user.profile.preferences.email-scheduled.email_ratios_3')}}</label>
                    </span>
                </div>
                <input type="hidden" id="section" name="section" value="email-schedule">
                <div class="unsubscribe">
                    <button type="submit" id="update-button" class="btn btn-primary btn-lg mt-4 px-lg-5">{{__('inpanel.user.profile.preferences.preferences_menu.password_update_button')}}</button>
                    <!-- <a href="{{route('inpanel.user.profile.preference.completeUnsubscribe')}}" id="unsubscribe_link" class="pt-5"></a> -->
                    @if(auth()->user()->unsubscribed == 0)
                    <a href="javascript:void(0)" id="unsubscribe_link" class="pt-5">
                        {{__('inpanel.user.profile.preferences.email-scheduled.unsubscribe')}}</a>
                    @else

                    <span style="color: rgb(16, 128, 208); font-weight: bold;" class="pt-5">{{__('inpanel.user.profile.preferences.email-scheduled.unsubscribetext')}}</span>
                    @endif
                </div>
                <div id="confirmationModal" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="font-size: 20px;">{{__('frontend.register.unsubscribe_confirmation.confirmation')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{__('frontend.register.unsubscribe_confirmation.confirm_title')}}<a class="page-scroll" href="/pages/rewards">{{__('frontend.register.unsubscribe_confirmation.reward')}}</a>{{__('frontend.register.unsubscribe_confirmation.confirm_title1')}}</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('frontend.register.unsubscribe_confirmation.cancel')}}</button>
                                <button type="submit" id="sureButton" class="btn btn-primary">{{__('frontend.register.unsubscribe_confirmation.confirm')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="my_data" class="@php if(isset($searched_tab)){ if($searched_tab == 'mydata'){echo 'Show';}else{echo'';} } @endphp">
            <form method="post" action="{{route('inpanel.user.profile.preference.update','my-data')}}" enctype="multipart/form-data">
                @csrf
                <h5>{{__('inpanel.user.profile.preferences.my-data.accessing_details')}}</h5>
                <hr>
                <p>
                    {{__('inpanel.user.profile.preferences.my-data.accessing_details_2')}}
                </p>
                <input type="hidden" id="section" name="section" value="my-data">

                <button type="submit" id="update-button" class="btn btn-primary btn-lg  px-lg-5">{{__('inpanel.user.profile.preferences.my-data.export_data')}}</button>
            </form>
        </div>

        <div id="deactive_account" class="@php if(isset($searched_tab)){ if($searched_tab == 'deactivate'){echo 'Show';}else{echo'';} } @endphp">
            <h5>{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_10')}}</h5>
            <hr>
            <p>
                <span class="match_surveys">
                    {{__('inpanel.user.profile.preferences.delete-account.basic_profile.prior_info_before_delete_new')}}<br>
                </span>
            </p>
            <p>
                <span class="match-survey" style="line-height: 28px;">
                    {!!__('inpanel.user.profile.preferences.delete-account.basic_profile.prior_info_before_delete_2_new')!!}<br>
            </p>
            <p style="margin-bottom:25px">
                <span style="font-weight:600; color:black;">{{__('inpanel.user.profile.preferences.email-scheduled.note')}}</span>{{__('inpanel.user.profile.preferences.delete-account.basic_profile.prior_info_before_delete_3_new')}}<br>
                </span>
            </p>
            <p>
                <label style="display: flex;">
                    <input type="checkbox" class="deactive_process" id="deactive_chk">
                    <span class="px-lg-2">
                        {{__('inpanel.user.profile.preferences.delete-account.basic_profile.confirmation_text')}}
                    </span>
                </label>
            </p>

            <!-- <button type="button" id="update-button" class="btn btn-danger btn-lg  px-lg-4">Deactivate Account</button> -->
            <!-- <button class="navbar-toggler btn btn-danger btn-lg  px-lg-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" 
                  aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="border:none" id="hamB"> -->
            <button type="button" id="deactive-button" class="btn btn-danger btn-lg  px-lg-4" data-bs-toggle="offcanvas" data-bs-target="#DEACTIVE"
                aria-controls="offcanvasNavbar" onclick="deactive()" aria-label="Toggle navigation" disabled>{{__('inpanel.user.profile.preferences.delete-account.basic_profile.label_11')}}</button>
            <!-- </button> -->
        </div>

        <div id="delete" class="@php if(isset($searched_tab)){ if($searched_tab == 'delete'){echo 'Show';}else{echo'';} } @endphp">

            <h5>{{__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.delete_account')}}</h5>
            <hr>

            <p>
                <span class="match_surveys">
                    {{__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.prior_info_before_delete_new')}}<br>
                </span>
            </p>
            <p>
                <span class="match-survey" style="line-height: 28px;">
                    {{__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.prior_info_before_delete_2_new')}}<br>
            </p>
            <p style="margin-bottom:25px">
                <span style="font-weight:600; color:black;">{{__('inpanel.user.profile.preferences.email-scheduled.note')}}</span>{{__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.prior_info_before_delete_3_new')}} <br>
                </span>
            </p>
            <p>
                <label style="display: flex;">
                    <input type="checkbox" class="deactive_process" id="delete_chk">
                    <span class="px-lg-2">
                        {{__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.confirmation_text')}}
                    </span>
                </label>
            </p>

            <button type="button" id="delete-button" class="btn btn-danger btn-lg  px-lg-5" data-bs-toggle="offcanvas" data-bs-target="#DELETE"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation" disabled>{{__('inpanel.user.profile.preferences.delete-personinfo.basic_profile.delete_label')}}</button>

        </div>

    </div>
</div>
</div>
</div>
<div class="modal" id="twoFactAuth" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content col-lg-11">
            <div class="modal-header">
                <h4 class="modal-title">{{__('inpanel.user.profile.preferences.two_fact.modal.heading')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="question_loader" style="display:none;">
                <div class="sk-spinner sk-spinner-wave">
                    <div class="sk-rect1"></div>
                    <div class="sk-rect2"></div>
                    <div class="sk-rect3"></div>
                    <div class="sk-rect4"></div>
                    <div class="sk-rect5"></div>
                </div>
            </div>
            {{html()->form('POST',route('inpanel.user.profile.two_fact_auth.verify-otp'))->id('verify_otp')->open()}}
            <div class="modal-body two_fact_setting">
                <div class="alert alert-warning" id="error_show" style="display: none">
                    <strong>Error!</strong> OTP is wrong
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('inpanel.user.profile.preferences.two_fact.modal.button_1')}}</button>
                <button type="submit" id="verify_opt_button" class="btn btn-primary">{{__('inpanel.user.profile.preferences.two_fact.modal.button_2')}}</button>
            </div>
            {{html()->form()->close()}}
        </div>
    </div>
</div>

@endsection
@push('after-scripts')
<script src="https://kit.fontawesome.com/1653f4e8b4.js" crossorigin="anonymous"></script>
<script src="https://cdn.rawgit.com/lrsjng/jquery-qrcode/v0.17.0/dist/jquery-qrcode.min.js" integrity="sha384-J7DIscqSIBfb9e7vk6Z6HUs+iizZghD0pZKKjwu6eoh1GR9dLMlMXNJLfGUNpN/z" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bcryptjs/2.4.3/bcrypt.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.2/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {

        $('#btn-upload').click(function(e) {
 
            e.preventDefault();
            e.stopImmediatePropagation();
             $('#images').click();
            // setTimeout(() => {
            //     //$('#images').focus();
            // }, 0);
        });
    });
    $(document).ready(function() {
        $('#images').on('change', function() {
            var file = this.files[0];
            var fileType = file.type.split('/')[0];

            if (fileType !== 'image') {
                $('#images').val('');
                $('#images_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.image_error')}}");
                $('.photo_upload').html("{{__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')}}");
            } else {
                $('.photo_upload').text(file.name);
                $('#images_err').html('');
            }
        });
        $('#btn-upload').on('blur', function() {
            $('#images_err').html('');
        });
    });
</script>
<script>
    $(document).ready(function() {
        var flashMsg = $('#flash_msg');
        if (flashMsg.length) {
            var timeout = 2000;
            setTimeout(() => {
                flashMsg.fadeOut('slow', function() {
                    $(this).remove();
                })

            }, timeout);
        }
    });
    // $(document).ready(function(){
    //     var flashMsg = $('#flash_msg_disabled');
    //     if(flashMsg.length){
    //         var timeout = 2000;
    //         setTimeout(() => {
    //             flashMsg.fadeOut('slow',function(){
    //                 $(this).remove();
    //             })

    //         }, timeout);
    //     }
    // });
</script>

<script>
    $(document).ready(function() {
        $('#delete_chk').on('change', function() {
            if ($(this).is(":checked")) {
                $('#delete-button').prop('disabled', false);
            } else {
                $('#delete-button').prop('disabled', true);
            }
        });
    });
    $(document).ready(function() {
        $('#deactive_chk').on('change', function() {
            if ($(this).is(":checked")) {
                $('#deactive-button').prop('disabled', false);
            } else {
                $('#deactive-button').prop('disabled', true);
            }
        });
    });
</script>
<script>
    /* For Delete segment */
    $(document).ready(function() {

        $('input[name="delete_reason"]').on('change', function() {
            if ($(this).val() === 'Others') {
                $('#others_txt').prop('disabled', false).focus();
                $('#others_txt').prop('required', true);
            } else {
                $('#others_txt').prop('disabled', true).val('');
                $('#others_txt').prop('required', false);
            }
        });

    });
    /* For Deactive segment */
    $(document).ready(function() {

        $('input[name="deactive_reason"]').on('change', function() {
            if ($(this).val() === 'Others') {
                $('#reason_txt').prop('disabled', false).focus();
                $('#reason_txt').prop('required', true);
            } else {
                $('#reason_txt').prop('disabled', true).val('');
                $('#reason_txt').prop('required', false);
            }
        });

    });
</script>
<script>
    $(document).ready(function() {
        var error_flag = false;
        $(':text').on('keypress paste', function(e) {
            if ($(this).attr('id') == 'first_name' || $(this).attr('id') == 'last_name') {
                if (e.type === 'keypress') {
                    error_flag = false;
                    var keyCode = e.which;
                    var input = String.fromCharCode(e.which);
                    var regex = /[a-zA-Z]/;
                    if (!regex.test(input)) {
                        e.preventDefault();
                        if (keyCode >= 48 && keyCode <= 57) {
                            $('#' + $(this).attr('id') + '_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.special_char_num')}}");
                        } else {
                            $('#' + $(this).attr('id') + '_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.special_character')}}");
                        }

                    } else {
                        $('#' + $(this).attr('id') + '_err').html('');
                        var input_txt = $('#' + $(this).attr('id')).val();
                        if (input_txt.length > 1) {
                            var currentInput = input.toUpperCase();
                            var lastInput = input_txt.substr(-1, 1).toUpperCase();
                            var lastBeforeInput = input_txt.substr(-2, 1).toUpperCase();
                            if (currentInput === lastInput && currentInput === lastBeforeInput) {
                                e.preventDefault();
                                $('#' + $(this).attr('id') + '_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.repeat_character')}}");
                            } else {
                                $('#' + $(this).attr('id') + '_err').html('');
                            }
                        }
                    }
                } else if (e.type === 'paste') {
                    var input = e.originalEvent.clipboardData.getData('text');
                    var input_up = input.toUpperCase();
                    // alert(input_up);
                    if (/[^a-zA-Z]/.test(input) || /(.)\1\1/.test(input_up)) {
                        $('#' + $(this).attr('id') + '_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.paste_input_error')}}");
                        error_flag = true;
                        $(this).focus();
                    } else {
                        error_flag = false;
                    }
                }
            }
        });
        $(':text').on('blur', function(e) {
            if ($(this).attr('id') == 'first_name' || $(this).attr('id') == 'last_name') {
                if (error_flag) {
                    $('#' + $(this).attr('id')).val('');
                }
                $('#' + $(this).attr('id') + '_err').html('');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var err_flag = false;

        $(':text').on('paste input', function(e) {
            if ($(this).attr('id') == 'fb' || $(this).attr('id') == 'linkdin' || $(this).attr('id') == 'twitter') {
                var input = $(this);
                var url = e.type === 'input' ? input.val() : e.originalEvent.clipboardData.getData('text');
                var err_msg = isValidUrl(url, $(this).attr('id'));
                if (err_msg !== '') {
                    err_flag = true;
                    //e.preventDefault();
                    //$('#'+$(this).attr('id')).val('');
                    $('#' + $(this).attr('id') + '_err').html(err_msg);
                } else {
                    err_flag = false;
                    $('#' + $(this).attr('id') + '_err').html('');
                }
            }
        });
        $(':text').on('blur', function(e) {
            if ($(this).attr('id') == 'fb' || $(this).attr('id') == 'linkdin' || $(this).attr('id') == 'twitter') {
                if (err_flag) {
                    $('#' + $(this).attr('id')).val('');
                    $('#' + $(this).attr('id') + '_err').html('');
                    //clicked = false;
                } else {
                    clicked = true;
                }


            }
        });
    });

    function isValidUrl(url, domain) {
        var main_domain = '';
        var msg = '';
        if (domain == 'fb') {
            main_domain = 'facebook';
            msg = "{{__('inpanel.user.profile.preferences.preferences_menu.facebook_error')}}";
        } else if (domain == 'twitter' || domain == 'x') {
            main_domain = '(twitter|x)';
            msg = "{{__('inpanel.user.profile.preferences.preferences_menu.twitter_error')}}";
        } else if (domain == 'linkdin') {
            main_domain = 'linkedin';
            msg = "{{__('inpanel.user.profile.preferences.preferences_menu.linkedin_error')}}";
        }
        var pattern = RegExp("^(https?:\/\/)?(www\.)?" + main_domain + ".com\/[a-zA-Z0-9(\.\?)?]");
        if (pattern.test(url)) {
            msg = '';
        }
        return msg;

    }
</script>
<script>
    $(document).ready(function() {
        $('#password').on('input', function(e) {
            var pwd = $('#password').val();
            var old_pwd = "{{$user->password}}";
            // alert(old_pwd);
            var regex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$/;
            if (pwd.length < 8 && pwd.length > 0) {
                $('#pwd_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.password_min_len')}}");
                $('#pwd_chng_btn').prop('disabled', true);

            } else if (pwd.length > 20) {
                $('#pwd_err').html("{{__('validation.attributes.frontend.password_valid2')}}");
                $('#pwd_chng_btn').prop('disabled', true);
            } else if (/\s/.test(pwd)) {
                $('#pwd_err').html("{{__('validation.attributes.frontend.password_no_space')}}");
                $('#pwd_chng_btn').prop('disabled', true);
            } else {
                if (!regex.test(pwd)) {
                    $('#pwd_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.password_validation')}}");
                    $('#pwd_chng_btn').prop('disabled', true);
                } else {
                    // bcrypt.compare(pwd,old_pwd).then(function(result){
                    //     if(result){

                    //         alert('Same Password');
                    //     }else{
                    //         $('#pwd_err').html('');
                    //         if($('#cnf_err').text() === '' && $('#pwd_err').text() === '' && $('#confirm_pass').val().length > 0 && $('#confirm_pass').val() === $('#password').val()){
                    //             $('#pwd_chng_btn').prop('disabled',false);
                    //         }
                    //     }
                    // }).catch((err)=>{
                    //     console.error(err);
                    // });

                    $('#pwd_err').html('');
                    if ($('#cnf_err').text() === '' && $('#pwd_err').text() === '' && $('#confirm_pass').val().length > 0 && $('#confirm_pass').val() === $('#password').val()) {
                        $('#pwd_chng_btn').prop('disabled', false);
                    }
                    // });

                }
            }

        });
        $('#confirm_pass').on('input', function() {
            var pwd = $('#password').val();
            var cnf_pwd = $('#confirm_pass').val();
            if (pwd !== cnf_pwd) {
                $('#cnf_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.password_mismatch')}}");
                $('#pwd_chng_btn').prop('disabled', true);

            } else if (/\s/.test(pwd)) {
                $('#cnf_err').html("{{__('validation.attributes.frontend.password_no_space')}}");
                $('#pwd_chng_btn').prop('disabled', true);
            } else {
                $('#cnf_err').html('');
                if ($('#cnf_err').text() === '' && $('#pwd_err').text() === '' && $('#confirm_pass').val().length > 0 && $('#confirm_pass').val() === $('#password').val()) {
                    $('#pwd_chng_btn').prop('disabled', false);
                }

            }
        });

    });

    function scrollSwitch() {
        var icon = document.getElementById('scroll-img');
        var icon2 = document.getElementById('image1');
        // alert('shop')
        // icon.classList.add('scrollImg');
        icon.classList.toggle('scrollImg');
        icon2.classList.toggle('scrollImg2')
    }

    function removeSwitch() {
        var icon = document.getElementById('scroll-img2');
        var icon2 = document.getElementById('image2');
        icon.classList.toggle('scrollImg');
        icon2.classList.toggle('scrollImg2');
    }




    $(document).on('click', '#scroll-img', function(e) {
        console.log("Click");
        e.preventDefault();

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
        jQuery('.question_loader').show();
        $('.two_fact_setting').html('');
        axios.get("{{ route('inpanel.user.profile.two_fact_auth.setting') }}").then(function(response) {
            if (response.status === 200) {
                console.log("Success");
                //window.location.reload();
                Swal.fire({
                    title: '' + "{{__('inpanel.dashboard.pop_up.title')}}",
                    html: "<div class='swal-content'><h5>{{__('inpanel.dashboard.pop_up.content')}}</h5></div>",
                    type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
                    customClass: 'swal-wide',
                    showCancelButton: false,
                    confirmButtonColor: "#1080d0",
                    confirmButtonText: "{{__('inpanel.dashboard.pop_up.title_9')}}",
                    //cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    didOpen: () => {
                        document.querySelector('.swal2-html-container').style.margin = "0";
                        document.querySelector('.swal2-title').style.margin = "0";
                        document.querySelector('.swal2-actions').style.margin = "0";
                    }
                }).then((result) => {

                    //  if (result.value===true) {
                    //     window.location.href = "/logout";
                    //  } 
                    //  else if(result.value == undefined) {
                    //      window.location.href = "/logout";
                    //  }
                });
            }
        }).catch(function(error) {
            alert('error occured');
            console.log(error);
        }).then(function() {
            jQuery('.question_loader').hide();
        });
        //$('#twoFactAuth').modal('toggle');
    })
</script>
<script>
    $(document).ready(function() {
        var attempts = 0;
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        };

        function showSuccessMessage(message, message2) {
            Swal.fire({
                title: '' + "{{__('inpanel.user.profile.preferences.two_fact.modal.showSuccessMessage1')}}",
                text: message,
                icon: 'success',
                button: message2,
                confirmButtonText: message2
            }).then(() => {
                location.reload();
            });
        }

        function showMaxAttemptsMessage(msg) {
            Swal.fire({
                title: '' + "{{__('inpanel.user.profile.preferences.two_fact.modal.showMaxAttemptsMessage1')}}",
                text: msg,
                icon: 'error',
                button: '' + "{{__('inpanel.dashboard.pop_up.title_9')}}"
            }).then(() => {
                location.reload();
            });
        }
        $(document).on('click', '#scroll-img2', function(e) {
            $.ajax({
                url: "{{ route('inpanel.user.profile.two_fact_auth.sendOtp') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        let swalInstance = Swal.fire({
                            title: '' + "{{__('inpanel.user.profile.preferences.two_fact.modal.otpsend')}}",
                            input: 'text',
                            inputAttributes: {
                                autocapitalize: 'off',
                            },
                            showCancelButton: true,
                            cancelButtonText: '' + "{{__('inpanel.user.profile.preferences.two_fact.modal.button_cancel')}}",
                            confirmButtonText: '' + "{{__('inpanel.user.profile.preferences.two_fact.modal.button_submit')}}",
                            showLoaderOnConfirm: true,
                            preConfirm: (otp) => {
                                if (!otp) {
                                    Swal.showValidationMessage("{{__('inpanel.user.profile.preferences.two_fact.modal.showValidationMessage')}}");
                                } else {
                                    console.log(otp);
                                    return $.ajax({
                                        url: "{{ route('inpanel.user.profile.two_fact_auth.disable') }}",
                                        type: 'GET',
                                        dataType: 'json',
                                        data: {
                                            otp: otp,
                                            _token: headers['X-CSRF-TOKEN']
                                        },

                                    }).then((verifyResponse) => {
                                        if (verifyResponse.success == true) {
                                            showSuccessMessage("{{__('inpanel.user.profile.preferences.two_fact.modal.showSuccessMessage2')}}", "{{__('inpanel.dashboard.pop_up.title_9')}}");
                                        } else {
                                            attempts++;
                                            if (attempts < 3) {

                                                Swal.getInput().value = '';
                                                Swal.showValidationMessage("{{__('inpanel.user.profile.preferences.two_fact.modal.showErrorMessage')}}");
                                                console.log(attempts);

                                            } else {
                                                showMaxAttemptsMessage("{{__('inpanel.user.profile.preferences.two_fact.modal.showMaxAttemptsMessage2')}}");
                                            }
                                            return false;
                                        }
                                    }).catch(() => {
                                        Swal.showValidationMessage("{{__('inpanel.user.profile.preferences.two_fact.modal.showValidationMessage')}}");
                                        return false;
                                    });
                                }
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        });
                        // swalInstance.then((result) => {
                        // //    if(result.isConfirmed && result.value){
                        // //         const verifyResponse = result.value;
                        // //         if(verifyResponse.success == true){

                        // //         }
                        // //    }
                        // });
                    }
                }
            });

        });
    });
    // var attempts = 0;
    // $(document).on('click', '#scroll-img2', function(e) {
    //     e.preventDefault();
    //     var headers = {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     };
    //     function showErrorMessage(message) {
    //         swal({
    //             title:'Invalid OTP .',
    //             text: message,
    //             icon: 'error',
    //             button: 'OK'
    //         }).then(() => {
    //             removeSwitch();
    //         });    }
    //     
    //     $.ajax({
    //         url: "{{ route('inpanel.user.profile.two_fact_auth.sendOtp') }}",
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success == true) {
    //                 swal({
    //                     title: 'Please enter the OTP sent on your registered email as confirmation.',
    //                     input: 'text',
    //                     inputAttributes: {
    //                         autocapitalize: 'off'
    //                     },
    //                     showCancelButton: true,
    //                     confirmButtonText: 'Submit',
    //                     showLoaderOnConfirm: true,
    //                     // preConfirm: async(otp) => {
    //                     //     try{
    //                     //         const response = await fetch("{{ route('inpanel.user.profile.two_fact_auth.disable') }}"), {
    //                     //             method: 'GET',
    //                     //             body: JSON.stringify({otp: result.value })
    //                     //         }
    //                     //     }
    //                     //     // if (!otp) {
    //                     //     //     swal.showValidationMessage('Please enter OTP.');
    //                     //     // } else {
    //                     //     //     // return otp;
    //                     //     // }
    //                     // },
    //                     allowOutsideClick: () => !swal.isLoading()
    //                 }).then((result) => {
    //                     if (result.value) {
    //                         $.ajax({
    //                             url: "{{ route('inpanel.user.profile.two_fact_auth.disable') }}",
    //                             type: 'GET',
    //                             dataType: 'json',
    //                             data: {
    //                                 otp: result.value,
    //                                 _token: headers['X-CSRF-TOKEN']
    //                             },
    //                             success: function(verifyResponse) {
    //                                 if (verifyResponse.success == true) {
    //                                     showSuccessMessage('Your OTP has been disabled.');
    //                                 } 
    //                             },
    //                             error: function() {
    //                                 attempts++;
    //                                 console.log(attempts);
    //                                 if (attempts < 3) {
    //                                     // showErrorMessage('pleasee enter the correct OTP.');
    //                                     swal({
    //                                         title: 'Error',
    //                                         html: 'wrong otp',
    //                                         showConfirmButton: false,
    //                                     });
    //                                     return false;
    //                                 } else {
    //                                     showMaxAttemptsMessage();
    //                                 }
    //                             }
    //                         });
    //                     }
    //                 });
    //             }
    //         },
    //     });
    // });
</script>
<script>
    $(document).ready(function() {

        jQuery('a.email_unsubscribe').click(function(e) {
            var currentVar = $(this);
            e.preventDefault();
            swal({
                title: "Unsubscribe from all emails",
                text: "<p>We're sorry to hear you'd like to unsubscribe from our emails</p><br/>" +
                    "<p>Why are you unsubscribing ?</p>" +
                    "<div class=\"form-group\">" +
                    "    <textarea class=\"form-control\" id=\"unsubscribe_reason\" rows=\"3\"></textarea>" +
                    "  </div>",
                // --------------^-- define html element with id
                html: true,
                width: '600px',
                customClass: 'swal-wide',
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Unsubscribe now!",
                cancelButtonText: "I changed my mind",
                cancelButtonColor: "#1080d0",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                    console.log(currentVar.attr('href'));
                    window.location.href = currentVar.attr('href');
                } else {

                }

            });
        });

        $('#unsubscribe_link').click(function(e) {
            e.preventDefault();
            $('#confirmationModal').modal('show');
            // Swal.fire({
            //     title: "{{__('inpanel.user.profile.preferences.unsubscribe_email.swal_title1')}}",
            //     text: "",
            //     icon: "question",
            //     showCancelButton: true,
            //     confirmButtonColor: "#3085d6",
            //     cancelButtonColor: "#d33",
            //     cancelButtonText: "{{__('inpanel.user.profile.preferences.unsubscribe_email.no_button')}}",
            //     confirmButtonText: "{{__('inpanel.user.profile.preferences.unsubscribe_email.yes_button')}}"
            // }).then((confirmed) => {
            //     if (confirmed.isConfirmed) {
            //         var formData = new FormData();
            //         $.ajax({
            //             url: "{{ route('inpanel.user.profile.preference.completeUnsubscribe') }}",
            //             type: 'POST',
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             data: formData,
            //             contentType: false,
            //             cache: false,
            //             processData: false,
            //             dataType: 'json',
            //             success: function(result) {
            //                 if (result.status == true) {
            //                     new swal({
            //                         title: "{{__('inpanel.user.profile.preferences.unsubscribe_email.swal_title2')}}",
            //                         icon: 'success',
            //                         text: "{{__('inpanel.user.profile.preferences.unsubscribe_email.success_text')}}",
            //                         buttons: {
            //                             confirm: {
            //                                 text: "{{__('inpanel.user.profile.preferences.unsubscribe_email.ok_button')}}",
            //                                 value: true,
            //                                 visible: true
            //                             }
            //                         }
            //                     }).then((res) => {
            //                         location.reload();
            //                     });
            //                 }
            //             },
            //         });
            //     } else {

            //     }
            // })
        });

        $('#sureButton').click(function(e) {
            var formData = new FormData();
            $.ajax({
                url: "{{ route('inpanel.user.profile.preference.completeUnsubscribe') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(result) {
                    new swal({
                        title: "{{__('inpanel.user.profile.preferences.unsubscribe_email.swal_title2')}}",
                        icon: 'success',
                        text: result.message,
                        confirmButtonText: "{{__('inpanel.user.profile.preferences.unsubscribe_email.ok_button')}}",
                        // buttons: {
                        //     confirm: {
                        //         text: "{{__('inpanel.user.profile.preferences.unsubscribe_email.ok_button')}}",
                        //         value: true,
                        //         visible: true
                        //     }
                        // }
                    }).then((res) => {
                        window.location.href = window.location.reload();
                    });
                },
            });
        })
    });

    /* Parshant Sharma [10-09-2024] Starts */

    let userLang = '{{auth()->user()->locale}}';
    const selectedLang = userLang.split("_");
    const myLang = selectedLang[0].toUpperCase();

    fetchLanguage('{{$country_code}}', userLang);

    function fetchLanguage(country_code, userLang) {
        console.log('country_code==' + country_code);
        console.log('country_Lang==' + myLang);


        var header = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
        if (!country_code || country_code == 0) {
            return false;
        }

        const url = '/language';

        axios.get(url, {
            params: {
                country_code: country_code,
            }
        }).then(function(response) {
            if (response.status === 200) {
                $select = $('#language');
                $select.find('option').remove();
                $('#language option:selected').removeAttr('selected');
                var lang = response.data;
                $.each(lang, function(value, name) {
                    var isSelected = (value == myLang);
                    $select.append($('<option />', {
                        value: value,
                        text: name,
                        selected: isSelected,
                        class: 'lang_' + value,
                        langg: name
                    }));
                });
            }
        }).catch(function(error) {
            // handle error
        }).then(function() {
            // always executed
            console.log('always executed');
        });
    }
    /* Parshant Sharma [10-09-2024] Ends */

    /* Parshant Sharma [26-09-2024] Starts */

    $(document).ready(function() {

        let previousValue = myLang;

        const getLang = $('#language option.lang_' + myLang).attr('langg');

        console.log('.lang_' + myLang);

        let prevLangText = $('#language option[value="+ previousValue + "]').text();


        $('#language').change(function() {

            const newValue = $(this).val();

            var optionText = $('.lang_' + myLang).text();
            console.log('optionText==' + optionText); // Outputs the text of the selected option

            Swal.fire({
                title: "{{__('inpanel.dashboard.pop_up.lang_text3')}}",
                text: "{{__('inpanel.dashboard.pop_up.lang_text1')}} " + optionText + " {{__('inpanel.dashboard.pop_up.lang_text2')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{__('inpanel.dashboard.pop_up.okay')}}",
                cancelButtonText: "{{__('inpanel.dashboard.pop_up.cancel')}}"
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed the change, do nothing, it will stay as is
                    previousValue = newValue; // Update the previous value
                } else {
                    // User canceled the change, revert to previous value
                    $(this).val(previousValue);
                }
            });
        });
    });


    /* Parshant Sharma [26-09-2024] Ends */


    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
        bootstrap.Tooltip.getOrCreateInstance(el).dispose();
    });
</script>
<script type="text/javascript" src="{{asset('js2/my-account.js')}}"></script>
@endpush