@extends('inpanel.layouts.device')
@push('after-styles')
<link href="{{asset('css2/My-account_style.css')}}" rel="stylesheet">
<link href="{{asset('css2/dashboard_style.css')}}" rel="stylesheet">
@endpush
@section('content')

<div class="row p-1 p-md-4">

    <div class="shadow border rounded pe-4 ps-4 pt-3" style="background: #FFFFFF;">


        <div class="col-12 mt-4 mb-4">

            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px;">
                <div class="progress-bar bg-success" @if(auth()->user()->is_social==1 && !session()->has('is_social')) @if(session()->get('country_update')==1)style="width: 20%" @endif @else style="width: 33%" @endif></div>
            </div>

        </div>

        @if(auth()->user()->is_social==1 && !session()->has('is_social'))

        <div class="row pt-md-4 page_language" @if(session()->get('country_update')==1) style="display:none;" @endif>

            <!--						 
<div class="row" style="margin-left: 0px;">									 
	<div class="border p-3 col-md-12 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;"> <label for=""><strong>&nbsp;Which language would you prefer for taking surveys?&nbsp;/&nbsp;¿Qué idioma preferiría para realizar las encuestas?</strong></label></div>
</div>
			
<div class="row1" id="english1" style="margin-left: 0px;">
	<input type="hidden" name="language" id="language" value="{{auth()->user()->locale}}">
	<div class="border p-3 col-md-5 col-md-4 mb-4"  style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;">
	<input type="radio" name="enanswer" id="enanswer" class="chk" value="en_US" @if(auth()->user()->locale=="en_US") checked @endif; onclick="showoption(this.value)" />
	<label for="">&nbsp;English/Inglés </label></div>

	<div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">
	<input type="radio" name="enanswer" id="enanswer" class=" chk" value="es_US" @if(auth()->user()->locale=="es_US") checked @endif; onclick="showoption(this.value)"/> <label for="">&nbsp;Spanish/Español</label></div>


</div> 	[25-04-2024] prev. dev code Backup	-->

            <!-- Parshant Sharma [25-04-2024] START -->

            @if(auth()->user()->country=="US")

            <div class="row" style="margin-left: 0px;">
                <div class="border p-3 col-md-12 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;"> <label for=""><strong>&nbsp;Which language would you prefer for taking surveys?&nbsp;/&nbsp;¿Qué idioma preferiría para realizar las encuestas?</strong></label></div>
            </div>

            <div class="row1" id="english1" style="margin-left: 0px;">
                <input type="hidden" name="language" id="language" value="{{auth()->user()->locale ?auth()->user()->locale:'en_US'}}">
                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;">
                    <input type="radio" name="enanswer" id="enanswer" class="chk" value="en_US" @if(auth()->user()->locale=="en_US") checked @endif; onclick="showoption(this.value)" />
                    <label for="">&nbsp;English/Inglés </label>
                </div>

                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">
                    <input type="radio" name="enanswer" id="enanswer" class=" chk" value="es_US" @if(auth()->user()->locale=="es_US") checked @endif; onclick="showoption(this.value)"/> <label for="">&nbsp;Spanish/Español</label>
                </div>

            </div>

            @elseif(auth()->user()->country=="CA")

            <div class="row" style="margin-left: 0px;">
                <div class="border p-3 col-md-12 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;"> <label for=""><strong>&nbsp;Which language would you prefer for taking surveys?&nbsp;/&nbsp;Quelle langue préférez-vous pour répondre aux enquêtes</strong></label></div>
            </div>

            <div class="row1" id="english1" style="margin-left: 0px;">
                <input type="hidden" name="language" id="language" value="{{auth()->user()->locale?auth()->user()->locale:'en_CA'}}">
                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;">

                    <input type="radio" name="enanswer" id="enanswer" class="chk" value="en_CA" @if(auth()->user()->locale=="en_CA" || auth()->user()->country=="CA") checked @endif; onclick="showoption(this.value)" />

                    <label for="">&nbsp;English/Anglais </label>
                </div>

                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">
                    <input type="radio" name="enanswer" id="enanswer" class=" chk" value="fr_CA" @if(auth()->user()->locale=="fr_CA") checked @endif; onclick="showoption(this.value)"/> <label for="">&nbsp;French/Français</label>
                </div>


            </div>
            @elseif(auth()->user()->country=="IN")


            <div class="row" style="margin-left: 0px;">
                <div class="border p-3 col-md-12 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;"> <label for=""><strong>&nbsp;Which language would you prefer for taking surveys?&nbsp;/&nbsp;सर्वेक्षण लेने के लिए आप कौन सी भाषा पसंद करेंगे?</strong></label></div>
            </div>

            <div class="row1" id="english1" style="margin-left: 0px;">
                <input type="hidden" name="language" id="language" value="{{auth()->user()->locale?auth()->user()->locale:'en_IN'}}">
                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;">

                    <input type="radio" name="enanswer" id="enanswer" class="chk" value="en_IN" @if(auth()->user()->locale=="en_IN" || auth()->user()->country=="IN") checked @endif; onclick="showoption(this.value)" />

                    <label for="">&nbsp;English </label>
                </div>

                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">
                    <input type="radio" name="enanswer" id="enanswer" class=" chk" value="hi_IN" @if(auth()->user()->locale=="hi_IN") checked @endif; onclick="showoption(this.value)"/> <label for="">&nbsp;Hindi</label>
                </div>

            </div>

            @elseif(auth()->user()->country=="UK")

            <div class="row" style="margin-left: 0px;">
                <div class="border p-3 col-md-12 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;"> <label for=""><strong>&nbsp;Which language would you prefer for taking surveys?&nbsp;</strong></label></div>
            </div>

            <div class="row1" id="english1" style="margin-left: 0px;">
                <input type="hidden" name="language" id="language" value="{{auth()->user()->locale?auth()->user()->locale:'en_UK'}}">
                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;">

                    <input type="radio" name="enanswer" id="enanswer" class="chk" value="en_UK" @if(auth()->user()->locale=="en_UK" || auth()->user()->country=="UK") checked @endif; onclick="showoption(this.value)" />

                    <label for="">&nbsp;English </label>
                </div>




            </div>

            @else

            <div class="row" style="margin-left: 0px;">
                <div class="border p-3 col-md-12 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;"> <label for=""><strong>&nbsp;Which language would you prefer for taking surveys?&nbsp;/&nbsp;¿Qué idioma preferiría para realizar las encuestas?</strong></label></div>
            </div>

            <div class="row1" id="english1" style="margin-left: 0px;">
                <input type="hidden" name="language" id="language" value="{{auth()->user()->locale}}">
                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;margin-bottom:10px;">
                    <input type="radio" name="enanswer" id="enanswer" class="chk" value="en_US" @if(auth()->user()->locale=="en_US") checked @endif; onclick="showoption(this.value)" />
                    <label for="">&nbsp;English/Inglés </label>
                </div>

                <div class="border p-3 col-md-5 col-md-4 mb-4" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">
                    <input type="radio" name="enanswer" id="enanswer" class=" chk" value="es_US" @if(auth()->user()->locale=="es_US") checked @endif; onclick="showoption(this.value)"/> <label for="">&nbsp;Spanish/Español</label>
                </div>

            </div>
            @endif

            <div class="row mt-4 mt-md-0 mb-4 mb-md-4 bg-danger position-relative">

                <div class="col text-center text-md-end position-absolute" style="margin-top: -29px;">
                    <span id="loader" style="display: none;margin-right: 12px;color: red;"><img src="images/loader.gif" width="32px"></span>
                    <img src="images/arrow_next.png" class="next_image" style="width:40px;height:40px;cursor:pointer;" title="Next" onclick="showoption_v1(this)">



                </div>

            </div>

        </div>


        <div class="row page2" @if(session()->get('country_update')!=1)style="display:none;" @endif>

            <p class="h4">{{__('inpanel.user.profile.preferences.preferences_menu.update_basic_profile')}}</p>
            <span style="color:red">*&nbsp;{!!__('inpanel.user.profile.preferences.preferences_menu.mandatory_feilds')!!}<i class="fa fa-arrow-right" style="margin-bottom:-2px;" aria-hidden="true"></i></span>

            <div class="row pt-md-4">
                <div class="col-md-4 col-12">
                    @php

                    if(auth()->user()->social_email){
                    $email = auth()->user()->social_email;
                    }else{
                    $email = auth()->user()->email;
                    }
                    $user_data = explode('@',$email);
                    $data = in_array("facebook.com",$user_data) ? ' ' : $email;
                    @endphp

                    <label for="">{{__('inpanel.basic_detail.email_1')}}<span class="required">*</span></label><br>
                    <input type="text" name="email" id="email" class="form-control @if(auth()->user()->email=='') emsg @endif;" value="{{$data}}" onkeyup="validateEmail()">

                    <span id="email-error" class="error text-danger"></span>
                    @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email')}}</span>
                    @endif
                </div>
                <div class="col-md-4 col-12">
                    <label for="">{{__('inpanel.basic_detail.gender')}}<span class="required">*</span></label><br>
                    <select name="gender" class="form-control" id="gender" style="font-weight: 600;">

                        <option value="Male" selected>{!!__('inpanel.activity_log.gender_male')!!}</option>
                        <option value="Female">{!!__('inpanel.activity_log.gender_female')!!}</option>
                    </select>

                </div>
                <div class="col-md-4 col-12" style="position: relative;">
                    <label for="">{{__('inpanel.basic_detail.date_birth')}}<span class="required">*</span></label><br>
                    <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                        <input class="form-control date_div @if(auth()->user()->dob=='') emsg @endif"
                            type="text" placeholder="MM/DD/YYYY" name="dob_v1" id="dob_v1" style="background: white; cursor: pointer; width: 100%; border-radius: 6px; font-weight: 600;" required value="@if(auth()->user()->dob!=''){{auth()->user()->dob->format('m/d/Y')}} @endif" />
                        <span id="error_birth"></span>
                        <span class="input-group-addon date_group" style="background:white; position: absolute; bottom: 7px; right: 10px;">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>

            </div>
            <div class="row pt-md-4">


                <div class="col-md-4 col-12">
                    <label for="zipcode" class="control-label col-sm-2 col-md-4">
                        {{__('inpanel.basic_detail.zip_code')}}<span class="required">*</span>
                    </label>

                    <input type="hidden" name="dfiq_zipcode" id="dfiq_zipcode" value="0">
                    <input id="zipcode" onkeyup="validateZip1()" name="zipcode" value="{{auth()->user()->zipcode}}" type="text" class="form-control @if(auth()->user()->zipcode=='') emsg @endif;">
                    <span id="zip-error1" class="error text-danger"></span>


                    <input type="hidden" id="requestid" name="rid" value="{{$uuid}}" />
                    <input type="hidden" id="eventid" name="eid" value="{{$ip}}" />
                    <input type="hidden" id="cc" value="{{$country_code}}" />
                    <input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}">
                    <input type="hidden" id="user_email" name="user_email" value="{{auth()->user()->email}}">

                </div>
            </div>
            <div class="row mt-4  mb-4 mb-md-4 bg-danger position-relative">

                <div class="col text-center text-md-end position-absolute" style="margin-top: -30px;">
                    <img src="images/arrow_back.png" title="Back" class="back_language" style="width:40px;height:40px;cursor:pointer;">&nbsp;
                    <!-- Class name input_email_new added by obhi -->
                    <img src="images/arrow_next.png" title="Next" class="btn-profile input_email_new" style="width:40px;height:40px;cursor:pointer;">
                    <!-- Class name input_email_new added by obhi -->

                    {{--<button type="submit" class="btn btn-primary ps-5 pe-5" style="transform:translateY(-1px)">{{__('inpanel.basic_detail.update_button')}}</button>--}}


                    <form id="partial-update" method="post" action="{{url('basic-detail-update')}}">
                        @csrf
                        <input id="zipcode1" name="zipcode1" value="{{auth()->user()->zipcode}}" type="hidden" class="form-control">
                        <input type="hidden" id="requestid" name="rid" value="{{$uuid}}" />
                        <input type="hidden" id="eventid" name="eid" value="{{$ip}}" />
                        <input type="hidden" id="cc" value="{{$country_code}}" />
                        <input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}">
                        <input type="hidden" id="user_email1" name="user_email1" value="{{auth()->user()->social_email ? auth()->user()->social_email : auth()->user()->email}}">

                        <input type="hidden" id="user_email2" name="user_email2" value="{{auth()->user()->email}} ">

                        <input type="hidden" id="dob" name="dob" value="{{auth()->user()->dob}}">
                        <input type="hidden" id="gender1" name="gender1" value="{{auth()->user()->gender}}">
                        <input type="hidden" name="is_partial" id="is_partial" value="1">
                    </form>

                </div>

            </div>


        </div>

        @endif

        {!! BootForm::horizontal(); !!}
        <input id="zipcode1" name="zipcode1" value="{{auth()->user()->zipcode}}" type="hidden" class="form-control">
        <input type="hidden" id="requestid" name="rid" value="{{$uuid}}" />
        <input type="hidden" id="eventid" name="eid" value="{{$ip}}" />
        <input type="hidden" id="cc" value="{{$country_code}}" />
        <input type="hidden" id="dfiq_check" name="dfiq_check" value="{{$dfiq}}">
        <input type="hidden" id="user_email1" name="user_email1" value="{{auth()->user()->email}}">
        <input type="hidden" id="user_email2" name="user_email2" value="{{auth()->user()->social_email}}">
        <input type="hidden" id="dob" name="dob" value="{{auth()->user()->dob}}">
        <input type="hidden" id="gender1" name="gender1" value="{{auth()->user()->gender}}">
        <div class="row mt-4 mb-4 device" @if(auth()->user()->is_social==1 && !session()->has('is_social'))style="display:none;" @endif >

            <p class="h4">{{__('inpanel.user.profile.preferences.preferences_menu.device')}}?</p>
            <div class="col-sm-12 col-md-4 mb-4 mb-md-0">

                <div class="border p-3" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">

                    {{--<input type="checkbox" name="device" value="Desktop/Laptop" id="deviceOne" class="chk"><label for="deviceOne" class="ms-2">Desktop/Laptop</label>--}}
                    {!! BootForm::checkbox('device_preference[]', __('inpanel.user.profile.preferences.preferences_menu.desktop_laptop'), '2', ((in_array('2',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'all_preference chk chkbox','onclick'=>'checkDevice(this,"1")','onchange'=>'updateSubmitBtn()')); !!}

                </div>

            </div>


            <div class="col-sm-12 col-md-4 mb-4 mb-md-0">

                <div class="border p-3" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">

                    {{--<input type="checkbox" name="device" value="Mobile/Phone" id="deviceTwo" class="chk"><label for="deviceTwo" class="ms-2">Mobile/Phone</label>--}}
                    {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.mobile_phone'), '3', ((in_array('3',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'all_preference chk chkbox','onclick'=>'checkDevice(this,"1")','onchange'=>'updateSubmitBtn()')); !!}

                </div>

            </div>


            <div class="col-sm-12 col-md-4">

                <div class="border p-3" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">

                    {{--<input type="checkbox" name="device" value="Tablet" id="deviceThree" class="chk"><label for="deviceThree" class="ms-2">Tablet</label>--}}

                    {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.tablet'), '4', ((in_array('4',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'all_preference chk chkbox','onclick'=>'checkDevice(this,"1")','onchange'=>'updateSubmitBtn()')); !!}

                </div>

            </div>



        </div>



        <div class="row mb-4 device1" @if(auth()->user()->is_social==1 && !session()->has('is_social'))style="display:none;" @endif >

            <div class="col-sm-12 col-md-4 device1">

                <div class="border p-3" style="background: #F3F3F3; border: 1px solid #ECECEC; border-radius: 5px;">

                    {{--<input type="checkbox" name="device" value="All" id="deviceFour" class="chk"><label for="deviceFour" class="ms-2">All</label>--}}
                    {!! BootForm::checkbox('device_preference[]',__('inpanel.user.profile.preferences.preferences_menu.all'), '1', ((in_array('1',(explode(',', auth()->user()->device_preference)))))? true : false ,array('class'=>'alldevice chk chkbox','onclick'=>'checkDevice(this,"1")','onchange'=>'updateSubmitBtn()')); !!}

                </div>

            </div>




            <div class="row mt-4 mt-md-0 mb-4 mb-md-4 bg-danger position-relative">

                <div class="col text-center text-md-end position-absolute">
                    @if(auth()->user()->is_social==1 && !session()->has('is_social'))
                    <img src="images/arrow_back.png" title="Back" class="back_page2" style="width:40px;height:40px;cursor:pointer;">&nbsp;
                    @endif
                    <button type="submit" class="btn btn-primary ps-5 pe-5" id="sbmtBtn" style="transform:translateY(-1px)" disabled>{{__('inpanel.profiler.button.next')}}</button>

                </div>

            </div>




            {!! BootForm::close() !!}




        </div>

    </div>


    <!-- Spacer -->

    <div class="container mt-5 pt-5">


    </div>
    @endsection
    @push('after-styles')
    <link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{asset('vendor/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <style>
        /* .date_birth{
            position:fixed;
            top: 50%;
            left: 50%;
            width:30em;
            height:18em;
            margin-top: -9em; !*set to a negative number 1/2 of your height*!
            margin-left: -15em; !*set to a negative number 1/2 of your width*!
            border: 1px solid #ccc;
            background-color: #f3f3f3;
        }*/
        .swal2-popup #swal2-content {
            text-align: justify !important;
        }

        .swal-wide {
            width: 450px !important;

        }

        h5 {
            text-align: center;
            margin: 20px;
        }

        .emsg {
            border: 1px solid red !important;
        }

        .required {
            color: red;
        }


        .toast-error {
            background-color: red !important;
            color: #fff !important;
            font-size: 12px !important;
        }
    </style>

    @endpush

    @push('after-scripts')
    <!-- Date range use moment.js same as full calendar plugin -->
 <script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v6.0.5.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
    <script src="{{asset('vendor/js/plugins/fullcalendar/moment.min.js')}}"></script>
    <script src="{{asset('vendor/js/plugins/toastr/toastr.min.js')}}"></script>
    <!-- Data picker -->
    <script src="{{asset('vendor/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script>
        $(document).ready(function() {
            var chkBoxes = document.querySelectorAll('.chkbox');
            var sbmtBtn = document.getElementById('sbmtBtn');
            if (chkBoxes) {
                var isChecked = Array.from(chkBoxes).some(function(chkbox) {
                    return chkbox.checked;
                });
                sbmtBtn.disabled = !isChecked;
            }

        });
    </script>
    <script>
        function updateSubmitBtn() {
            var chkBoxes = document.querySelectorAll('.chkbox');
            var sbmtBtn = document.getElementById('sbmtBtn');

            var isChecked = Array.from(chkBoxes).some(function(chkbox) {
                return chkbox.checked;
            });
            sbmtBtn.disabled = !isChecked;
        }
    </script>
    <script>



    </script>

    <script>
        $(function() {
            $("#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'mm/dd/yyyy',
            });
        });
        $('.input-group-date').datepicker({
            format: {
                /*
                 * Say our UI should display a week ahead,
                 * but textbox should store the actual date.
                 * This is useful if we need UI to select local dates,
                 * but store in UTC
                 */
                toDisplay: function(date, format, language) {
                    var d = new Date(date);
                    // d.setMinutes( d.getMinutes() + d.getTimezoneOffset() );
                    d = moment(d).format("MM/DD/YYYY");
                    return d;
                },
                toValue: function(date, format, language) {
                    var d = new Date(date);
                    //d.setMinutes( d.getMinutes() + d.getTimezoneOffset() );
                    d = moment(d).format("MM/DD/YYYY");
                    return d;
                }
            },
            startView: 2,
            todayBtn: false,
            keyboardNavigation: true,
            forceParse: false,
            autoclose: true,
            orientation: 'bottom',
        });
        $(document).ready(function() {

            $('.english').on('click', function() {
                val = $(this).val();
                if (val == 'en') {
                    $('#english1').show();
                    $('#spanish').hide();
                } else {
                    $('#english1').hide();
                    $('#spanish').show();
                }
            });

            checkZipCounter();
            var country_code = $('select#country').val();
            fetchLanguage(country_code);

            $('select#country').on('change', function(e) {
                var country_code = $('select#country').val();
                fetchLanguage(country_code)
            });

            function fetchLanguage(country_code) {
                var header = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                };
                if (!country_code || country_code == 0) {
                    return false;
                }
                axios.get("{{route('inpanel.language')}}", {
                    params: {
                        country_code: country_code,
                    }
                }).then(function(response) {
                    console.log(response);
                    if (response.status === 200) {
                        $select = $('#language');
                        $select.find('option').remove();
                        var lang = response.data;
                        $.each(lang, function(value, name) {

                            $select.append($('<option />', {
                                value: value,
                                text: name
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


        });


        $(document).on('click', '.back_language', function() {
            $('.page_language').show();
            $('.page2').hide();

        });
        $(document).on('click', '.back_page2', function() {
            $('.page_language').hide();
            $('.device').hide();
            $('.device1').hide();
            $('.page2').show();
        });

        function showoption(country_code) {

            $('#language').val(country_code);

        }

        function showoption_v1(obj) {
            var country_code = $('#language').val();
            var header = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            };
            if (!country_code || country_code == 0) {

                $('.col-md-5').addClass('emsg');
                return false;
            }
            $('#loader').show();
            $('.next_image').hide();
            axios.get("{{ route('inpanel.basic.countryupdate.post') }}", {
                params: {
                    country_code: country_code,
                }
            }).then(function(response) {
                $('#loader').show();
                $('.next_image').hide();
                console.log(response);
                if (response.status === 200) {
                    location.reload();
                }
            }).catch(function(error) {
                $('#loader').hide();
                $('.next_image').show();
                // handle error
            }).then(function() {
                // always executed
                console.log('always executed');
            });
        }


        function checkDevice(deviceType, count) {

            if (deviceType.value == 2 || deviceType.value == 3 || deviceType.value == 4) {
                $('.alldevice').prop('checked', false);
            } else if (deviceType.value == 1) {
                if ($(deviceType).is(':checked')) {
                    //$('.all_preference').prop('disabled',true);
                    $('.all_preference').prop('checked', true);
                } else {
                    // $('.all_preference').prop('disabled',false);
                    $('.all_preference').prop('checked', false);
                }

            }

            var all_preference_status = true;

            $('.all_preference').each(function() {
                if (!$(this).is(':checked')) {
                    all_preference_status = false;
                }
            });
            if (all_preference_status) {
                $('.alldevice').prop('checked', true);
            }

        }

        function checkZipCounter() {
            const zipcode = $('#zipcounter').val();
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };

            if (zipcode > 3) {
                swal({
                    title: '' + "{{__('inpanel.dashboard.pop_up.title')}}",
                    html: "<h5>You have consumed maximum attempts. <br/>Please start registration again when you have valid details with you.</h5>",
                    type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
                    customClass: 'swal-wide',
                    showCancelButton: false,
                    confirmButtonColor: "#1080d0",
                    confirmButtonText: "Ok",
                    //cancelButtonText: "Cancel",
                    closeOnConfirm: true
                }).then((result) => {

                    if (result.value === true) {
                        window.location.href = "/dashboard/zipfailedattempts";
                    } else if (result.value == undefined) {
                        window.location.href = "/dashboard/zipfailedattempts";
                    }
                });
            }
        }

        const getAge = birthDate => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e+10);

        /*$('#email').blur(function() {

            if($('#email').val()==''){
                $('#email').addClass('emsg');
                return false;
            }else{
                var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
                var email_info = $('#email').val();
                console.log(email_info);
                var msg = '';
                console.log('Checking :'+re.test(email_info));
                if(re.test(email_info)){
                    var header = {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                    axios.get("{{route('inpanel.basic.email')}}",{
                        params:{
                            email : email_info,
                        }
                    }).then(function (response) {
                        console.log(response.data);
                            //console.log('response=='+JSON.stringify(response));
                        if(response.status == 200){
                            if(response.data > 0){
                                console.log('case-2');
                                if(response.data=='2'){

                                    setTimeout(function() {
                                        toastr.error("{{__('frontend.index.contact_us.toastr_1')}}", "{{__('frontend.index.contact_us.error')}}" );
                                    }, 400);
                                    $('.btn-profile').hide();

                                    return true;
                                }else if(response.data==1){
                                    setTimeout(function() {
                                        toastr.error("{{__('frontend.index.contact_us.toastr_2')}}", "{{__('frontend.index.contact_us.error')}}" );
                                    }, 400);
                                    $('.btn-profile').hide();

                                    return true;
                                }
                                msg += "{{__('frontend.index.contact_us.toastr_2')}}\n";
                                $('#email').addClass('emsg');
                                flag = 1;
                            }else{
                                flag = 0;
                                $('#email').removeClass('emsg');
                                $('#user_email2').val($('#email').val());
                            }
                                
                        }
                    }).catch(function (error) {
                        console.log('error occured');
                    });
                }else{
                    $('#email').addClass('emsg');
                    flag = 1;
                    msg += "{{__('frontend.index.contact_us.toastr_3')}}\n";
                    setTimeout(function() {

                        toastr.error(msg, "{{__('frontend.index.contact_us.error')}}" );


                    }, 400);
                    $('.btn-profile').hide();
                    return false;
                }
                $('.btn-profile').show();
            }
        });*/

        $('.btn-profile').on('click', function() {
            $('.bg-success').css('width', '67%');
            var dfiq_check = $("#dfiq_check").val();
            var flag = 0;
            //    alert (dfiq_check); 
            if ($('#email').val() == "") {
                $('#email').addClass('emsg');
                return false;
            } else {
                $('#email').removeClass('emsg');
            }
            if ($('#dob_v1').val() == "") {
                $('#dob_v1').addClass('emsg');
                return false;
            } else {
                $('#dob_v1').removeClass('emsg');
    }

            const dateInput = $('#dob_v1').val();
            const formattedDateInput = new Date(dateInput);
            let formattedDate = '';
            if (!isNaN(formattedDateInput.getTime())) {
                formattedDate = `${formattedDateInput.getFullYear()}-${String(formattedDateInput.getMonth() + 1).padStart(2, '0')}-${String(formattedDateInput.getDate()).padStart(2, '0')}`;
            }
            //alert(formattedDate);
            console.log(formattedDate);
            var agearr = dateInput.split('-');
            var birthDate = agearr[2] + '-' + agearr[0] + '-' + agearr[1];
            var ua = getAge(birthDate);
            const submitButtonf = document.getElementById('submit');
            // var alldates = document.querySelectorAll('');
            if (ua < 13) {

                var Message = "Minimum age to join our panel is 13 years. Kindly come back when you meet the minimum age requirement";
                Message = "{{(__('validation.attributes.frontend.is_age'))}}";
                //$('#error_birth').html(Message);
                setTimeout(function() {
                    toastr.error(Message, '');
                }, 400);

                return false;
            } else {
                // $('#dob').val($('#dob_v1').val());
                $('#dob').val(formattedDate);
            }

            if ($('#zipcode').val() == '') {

                $('#zipcode').addClass('emsg');
                return false;
            } else {

                //var dfiq_check=$("#dfiq_check").val();
                info = $('#zipcode').val();

                dfiqval = $('#dfiq_zipcode').val();
                console.log(dfiqval);
                console.log(info);
                console.log(dfiq_check);
                $('#zipcode').removeClass('emsg');
                if (dfiq_check == 1 && dfiqval == 0) {
                    console.log(info);
                    if (info != '') {
                        invokeAPI(info);
                    }
                } else {
                    // $('.bg-success').css('width','33%');
                    // $('.page2').hide();
                    // // $('.device').show();
                    // // $('.device1').show();
                    // $('#zipcode1').val($('#zipcode').val());
                    // $('#gender1').val($('#gender').val());
                    // $('#user_email2').val($('#email').val());
                    // $('#partial-update').submit();
                    var email = $('#email').val();
                    if (email != '') {
                        emailExist();
                    }
                }
            }


            if (flag === 0) {

                $('.btn').removeAttr('disabled', 'false');

                return true;

            }
        });


        function invokeAPI(info) {

            var req = document.getElementById("requestid").value;
            var event = document.getElementById("eventid").value;
            var country = document.getElementById("cc").value;
            console.log(country);
            console.log(info);
            var utm_source = "SjPanelLogin";
            //$('#form-dispaly').hide();
            // $('.loader').show();
            var uniquenessParam = Forensic.createUniquenessParam(event, null, false);
            var geoParam = Forensic.createGeoParam(country, info.trim());

            Forensic.forensic(req, successCallback, errorCallback, uniquenessParam, geoParam, null, null, utm_source);
        }

        function successCallback(jsonData) {
            var FlagStatus = false;
            var Message = '';
            console.log(jsonData);
            // $('#form-dispaly').hide();
            // $('.loader').show();
            /*$.ajaxSetup({
            headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });*/
            var info = $('#zipcode').val();
            var email = $('#user_email').val();
            // console.log(email+"_"+info);
            var email = email + info;

            var ip_address = $('#eventid').val();
            var panelistId = $('#requestid').val();
            $.ajax({
                url: "{{ route('inpanel.basic.dfiqData.post') }}",
                type: 'GET',
                data: {
                    datajsondata: jsonData,
                    email: email,
                    ip_address: ip_address,
                    panelistId: panelistId,
                    user_id: ''
                },
                success: function(response) {
                    // window.location=addressBar+"&DFIQ=true";

                },
                async: true
            });
            console.log(jsonData.forensic.marker.isGeoPosta);
            if (jsonData.forensic.marker.isGeoPostal == false && FlagStatus == false) {
                Message = "{{__('inpanel.basic_detail.zip_error')}}";
                FlagStatus = true;
            }
            if (jsonData.forensic.marker.isBot == true && FlagStatus == false) {
                Message = "{{(__('validation.attributes.frontend.is_bot'))}}";
                FlagStatus = true;
            }

            if (jsonData.forensic.marker.isAnonymous == true && FlagStatus == false) {
                Message = "{{(__('validation.attributes.frontend.is_anonymous'))}}";
                FlagStatus = true;
            }
            if (jsonData.forensic.marker.isGeoTz == false && FlagStatus == false) {
                Message = "{{(__('validation.attributes.frontend.is_geotz'))}}";
                FlagStatus = true;
            }
            if (jsonData.forensic.marker.isTampered == true && FlagStatus == false) {
                Message = "{{(__('validation.attributes.frontend.is_tampered'))}}";
                FlagStatus = true;
            }
            if (jsonData.forensic.unique.isEventUnique == false && FlagStatus == false) {
                Message = "{{(__('validation.attributes.frontend.is_event'))}}";
                FlagStatus = true;
            }
            /**Need to uncomment before push 02/10/23 */

            console.log("HEllo" + FlagStatus);
            if (FlagStatus == true) {
                const zipcode = parseInt($('#zipcounter').val());
                var NewCounter = (zipcode + 1);
                $('#zipcounter').val(NewCounter);
                checkZipCounter();
                setTimeout(function() {
                    toastr.error(Message, '');
                }, 400);
                // $('.btn').attr('disabled','true');

            } else {
                //     $('#dfiq_zipcode').val(1);
                //    $('.page2').hide();
                //    $('.btn-profile').show();
                //     // $('.device').show();
                //     // $('.device1').show();
                //      $('#zipcode1').val($('#zipcode').val());
                //   $('#gender1').val($('#gender').val());
                //   $('#user_email2').val($('#email').val());
                //   $('#partial-update').submit();
                var email = $('#email').val();
                if (email != '') {
                    emailExist();
                }
            }
        };



        function errorCallback(jsonData) {
            console.log(jsonData.error.message); // Add your logic to handle errors
        }

        // -----------modified by obhi-------------

        //Zip required check
        function validateZip1() {
            var zipError = document.getElementById('zip-error1');

            //  alert("hello");
            var zipCode = document.getElementById('zipcode').value;
            if (zipCode.length == 0) {
                $('#zipcode').addClass('emsg');
                zipError.innerHTML = 'Zip code is required';
                return false;
            }
            zipError.innerHTML = '';
            $('#zipcode').removeClass('emsg');
            return true;
        }

        //Email validateEmail onkeyUp
        function validateEmail() {
            var email = $('#email').val();
            var emailError = document.getElementById('email-error');
            emailError.innerHTML = '';

            if (email == '') {
                $('#email').addClass('emsg');
                emailError.innerHTML = "{{(__('validation.attributes.frontend.email_require '))}}";
                return false;
            } else {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
                console.log('Checking :' + re.test(email));

                if (re.test(email)) {
                    $('#email').removeClass('emsg');
                } else {
                    $('#email').addClass('emsg');
                    emailError.innerHTML = "{{(__('validation.attributes.frontend.email_valid'))}}";
                    return false;
                }

            }
        }


        // Checking existing of provided email
        function emailExist() {
            var email = $('#email').val();
            var emailError = $('#email-error');

            if (email !== '') {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;

                if (re.test(email)) {
                    $('#email').removeClass('emsg');

                    var exist_email_alert = "{{(__('frontend.index.contact_us.toastr_2'))}}";
                    var error_alert = "{{(__('frontend.index.contact_us.error'))}}";

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('get-emailExist') }}",
                        data: {
                            email: email
                        },
                        success: function(response) {
                            var status = response.status;

                            if (status === 0) {
                                // Email doesn't exist
                                $('#email').removeClass('emsg');
                                proceedPartialUpdate();
                            } else if (status === 200) {
                                // Email already exists
                                $('#email').addClass('emsg');
                                toastr.error(exist_email_alert, error_alert);
                            } else if (status === 2) {
                                $('#email').addClass('emsg');
                                var alert_error = "{{(__('validation.attributes.frontend.email_valid'))}}";
                                toastr.error(alert_error, error_alert);
                                // return false;
                            } else {
                                // Handle other status codes if needed
                                console.log('Unexpected status code:', status);
                            }
                        },
                        error: function(error) {
                            console.log('error occurred');
                        }
                    });
                } else {
                    $('#email').addClass('emsg');
                    emailError.html("{{(__('validation.attributes.frontend.email_valid'))}}");
                    return false;
                }
            } else {
                $('#email').addClass('emsg');
                emailError.html("{{(__('validation.attributes.frontend.email_require'))}}");
                return false;
            }
        }


        function proceedPartialUpdate() {
            $('#dfiq_zipcode').val(1);
            $('.page2').hide();
            $('.btn-profile').show();
            // $('.device').show();
            // $('.device1').show();
            $('#zipcode1').val($('#zipcode').val());
            $('#gender1').val($('#gender').val());
            $('#user_email2').val($('#email').val());
            $('#partial-update').submit();
        }
    </script>


    @endpush