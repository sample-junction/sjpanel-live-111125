@push('after-styles')
<style>
    /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  float:right;
}
    /* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input.default:checked + .slider {
  background-color: #444;
}
input.primary:checked + .slider {
  background-color: #2196F3;
}
input.success:checked + .slider {
  background-color: #8bc34a;
}
input.info:checked + .slider {
  background-color: #3de0f5;
}
input.warning:checked + .slider {
  background-color: #FFC107;
}
input.danger:checked + .slider {
  background-color: #f44336;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
    </style>
@endpush
<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.two_fact.modal.heading')}}
    </div>
    <div class="ibox-content password_change">


        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <h2><strong>{{__('inpanel.user.profile.preferences.two_fact.heading')}}</strong></h2>
                    <label for="two_fact_auth" class="control-label">{{__('inpanel.user.profile.preferences.two_fact.subheading')}}</label>
                    <p>{{--__('inpanel.user.profile.preferences.two_fact.details')--}}
                        <Strong>{{__('inpanel.user.profile.preferences.two_fact.Enable_Email_Authentication')}}: </strong>{{__('inpanel.user.profile.preferences.two_fact.Enable_Email_Content')}}</p>
                </div>
                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-9" style="margin-left: -16px;">

                    @if(auth()->user()->two_fact_auth==1)
                        <a href="{{route('inpanel.user.profile.two_fact_auth.disable')}}" type="button" id="disable" class="btn btn-primary"> {{__('inpanel.user.profile.preferences.two_fact.button_1')}} </a>
                    @else
                       {{-- <a href="javascript:void(0);"  type="button" id="get_started" class="btn btn-primary"> {{__('inpanel.user.profile.preferences.two_fact.button_2')}} </a>--}}
                       <table>
                    <tbody><tr>
                        
                        <td><a href="{{ route('inpanel.user.profile.two_fact_auth.setting') }}"  type="button"  class="btn btn-primary1" id="get_started"><label class="switch " ><input type="checkbox" class="primary"> <span class="slider round"></span> </label></a></td>
                        <td><strong>&nbsp;{{__('inpanel.user.profile.preferences.two_fact.Email_Authentication')}}&nbsp;</strong></td>
                    </tr>
                </tbody></table>
                    @endif

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



@push('after-scripts')
    <script src="https://cdn.rawgit.com/lrsjng/jquery-qrcode/v0.17.0/dist/jquery-qrcode.min.js" integrity="sha384-J7DIscqSIBfb9e7vk6Z6HUs+iizZghD0pZKKjwu6eoh1GR9dLMlMXNJLfGUNpN/z" crossorigin="anonymous"></script>
    <script>
        /*$(document).on('click','a#get_started',function (e) {

            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
            jQuery('.question_loader').show();
            $('.two_fact_setting').html('');
            axios.get("{{ route('inpanel.user.profile.two_fact_auth.setting') }}").then(function (response) {
                if (response.status === 200) {
                    var $html = response.data;
                    $('.two_fact_setting').html($html);
                    $("#qr").empty().qrcode({
                        render: "image",
                        text: "stefansundin"
                    });
                    $("link[rel=icon]").prop("href", $("#qr img").prop("src"));
                    var uri = generate_uri(jQuery(this));
                    update_qr(jQuery(this))
                    console.log(uri);
                }
            }).catch(function (error) {
                alert('error occured');
                console.log(error);
            }).then(function () {
                jQuery('.question_loader').hide();
            });
            $('#twoFactAuth').modal('toggle');
        })*/
        $(document).on('click','a#get_started',function (e) {
            console.log("Click");
            e.preventDefault();

            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
            jQuery('.question_loader').show();
            $('.two_fact_setting').html('');
            axios.get("{{ route('inpanel.user.profile.two_fact_auth.setting') }}").then(function (response) {
                if (response.status === 200) {
                    console.log("Success");
                    //window.location.reload();
                    swal({
                title: ''+"{{__('inpanel.dashboard.pop_up.title')}}",
                html: "<h5>{{__('inpanel.dashboard.pop_up.content')}}</h5>",
                type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
                customClass: 'swal-wide',
                showCancelButton: false,
                confirmButtonColor: "#1080d0",
                confirmButtonText: "Ok",
                //cancelButtonText: "Cancel",
                closeOnConfirm: true
            }).then((result) => {
                
                 if (result.value===true) {
                    window.location.href = "/logout";
                 } 
                 else if(result.value == undefined) {
                     window.location.href = "/logout";
                 }
            });
                }
            }).catch(function (error) {
                alert('error occured');
                console.log(error);
            }).then(function () {
                jQuery('.question_loader').hide();
            });
            //$('#twoFactAuth').modal('toggle');
        })


        $( "#verify_otp" ).submit(function( event ) {
            event.preventDefault();
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
            var questionForm = jQuery('form#verify_otp');
            var questionFormData = questionForm.serialize();
            var postData = questionFormData;
            console.log(postData);
            /* jQuery('.question_loader').show();
             $('.two_fact_setting').html('');*/
            axios.post("{{ route('inpanel.user.profile.two_fact_auth.verify-otp') }}",postData,headers).then(function (response) {
                if (response.status === 200) {
                    if (response.data.status === false) {
                        console.log("tada");
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                            };
                            toastr.error("{!! __('inpanel.user.profile.preferences.two_fact.error') !!}");
                        }, 400);
                        $('button#verify_opt_button').removeAttr('disabled');
                    }else if(response.data.status === true){
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                            };
                            window.location.href = "{{route('inpanel.user.profile.preference.show',['two_fact_auth'])}}"
                            toastr.success( "{!! __('inpanel.user.profile.preferences.two_fact.success_messages') !!}");
                        }, 400);
                    }
                }
            }).catch(function (error) {
                alert('error occured');
                console.log(error);
            }).then(function () {
                jQuery('.question_loader').hide();
            });
        });





        /*$('#twoFactAuth').on('shown.bs.modal', function (e) {
            var uri = generate_uri(jQuery(this));
            console.log(uri);
        })*/
        function generate_uri(modal) {
            var modalDiv = modal;
            const type = "totp";
            var modalBody = $('div#twoFactAuth').find('div.two_fact_setting');
            console.log(modalBody);
            console.log(modalBody.find('div.google2fa'));
            var uri = modalBody.find('div.google2fa').find("#url").val();
            return uri;
        }
        function update_qr(modal) {
            var modalDiv = modal;
            const type = "totp";
            var modalBody = $('div#twoFactAuth').find('div.two_fact_setting');
            console.log(modalBody);
            console.log(modalBody.find('div.google2fa'));
            var uri = modalBody.find('div.google2fa').find("#url").val();
            const size = 200;
            $("#qr").empty().qrcode({
                text: uri,
                size: size,
            });
            if (label == "" && issuer == "") {
                $("#app_label").text("Issuer (label)");
            }
            else {
                $("#app_label").text(issuer == "" ? label : `${issuer} (${label})`);
            }
            // remove error on uri field
            $("#uri").removeClass("is-invalid");
            // mark empty required input fields
            $("#secret").toggleClass("is-invalid", secret == "");
            $("#label").toggleClass("is-invalid", label == "");
        }
        function decode(s) {
            return s ? decodeURIComponent(s) : undefined;
        }
    </script>


@endpush

