@extends('frontend.layouts.app_2fa')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))

<style>
    .container-login100 {
        width: auto;
        /* min-height: 100vh; */
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
    }

    .white,
    .white>a {
        color: white;
    }

    img {
        /* display: block; */
        margin-left: auto;
        margin-right: auto;
    }

    .ul {
        /* for IE below version 7 use `width` instead of `max-width` */
        max-width: 800px;
        margin: auto;
    }

    li {
        display: inline-block;
        *display: inline;
        /*IE7*/
        margin-right: 10px;
    }

    .home {
        text-align: center;
    }
</style>

<style>
    html * {

        font-family: roboto;

    }
</style>

<style>
    .nav_new {
        list-style: none;
        display: flex;
        justify-content: space-between;
    }

    .nav_new li a {
        text-decoration: none;
        color: black;
    }

    .nav_new li a:hover {
        color: blue;
    }

    .nav_new_2 {
        list-style: none;
        display: flex;
        justify-content: center;
    }

    .nav_new_2 li a {
        text-decoration: none;
        color: black;
        padding: 20px;
        font-size: 14px;
    }

    .nav_new_2 li a:hover {
        color: blue;
    }

    /* Add the following style for finger mouse pointer */
    .radio label:hover,
    .radio input:hover {
        cursor: pointer;
    }

    .row-cst {
        display: grid;
        grid-template-columns: auto auto;
        border-top: 2px solid grey;
        padding-top: 20px;
    }
</style>


<style>
    .row-1 {
        margin-top: 170px;
        border-radius: 19px;
        background: #F8F9FD;
        box-shadow: 5px 5px 10px rgb(213, 215, 232);
        width: 70%;
    }

    @media only screen and (max-width: 767px) {

        /* For mobile devices */
        .row-1 {
            width: 95%;
        }
    }

    .radio-container {
        text-align: center;
    }

    .radio-container label {
        font-weight: bold;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        text-align: left;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.2/dist/sweetalert2.min.css" rel="stylesheet">



@section('content')
<div class="panel panel-default" style="justify-content:center; border:none!important; display:flex;">
    <div class="row-1">
        <h1 class="heading" align="middle" style="margin-top: 70px; color:black; font-weight:600;">{{__('frontend.register.unsubscribe_confirmation.title')}}</h1>
        <h5 class="content" align="middle" style="padding-top: 10px;padding-bottom: 10px; font-size: 20px;">{{__('frontend.register.unsubscribe_confirmation.question.title')}}</h4>

            <!-- Modal -->
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

            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight container-login100">

                    <div class="ibox-content col-lg-6" style="max-width:500px;">
                        <div class="radio-container">
                            <!-- <label><input type="radio" name="myRadio" value="option1"> {{__('frontend.register.unsubscribe_confirmation.option1')}}</label><br> -->
                            <!-- <label><input type="radio" name="myRadio" value="option2"> {{__('frontend.register.unsubscribe_confirmation.option2')}}</label> -->
                            <input type="hidden" value="@php echo $email; @endphp" id="emailId">
                        </div>
                        <!-- {{html()->form('POST',route('inpanel.unsubscribe.post',$email))->open()}} -->
                        {{-- <div class="card"> --}}
                        <div id="cardContainer" style="display: block;">
                            <div class="card-body" style="min-height: 300px;">
                                <div class="row" style="margin-bottom: 50px;">
                                    {{-- <h1 class="heading" align="middle"><strong>{{__('frontend.register.unsubscribe_confirmation.title')}}</strong></h1> --}}
                                    {{-- <h4 class="content" align="middle" style="padding-top: 10px;padding-bottom: 10px;">{{__('frontend.register.unsubscribe_confirmation.question.title')}}</h4> --}}

                                    <div class="form-group" style="display: inline-block;">
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: 20px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64); margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option1')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option1')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option2')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option2')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option3')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option3')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option4')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option4')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option5')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option5')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550; color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="general" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option6')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option6')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">
                                            <div class="radio" style="margin-top: -4px;margin-bottom: 6px;">
                                                <label style="font-weight: 550;  color:rgb(70, 64, 64);  margin-left:10px;"><input required="required" data-precode_type="other" data-question="UNSUBSCRIBE" name="reason" type="radio" value="{{__('frontend.register.unsubscribe_confirmation.question.radio_option7')}}" aria-required="true" style=" margin:10px;">{{__('frontend.register.unsubscribe_confirmation.question.radio_option7')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 ">

                                            <textarea name="otherReason" id="otherstext" class="form-control" style="display:none; font-weight: 550;  color:rgb(70, 64, 64); margin-bottom:10px;" placeholder="{{__('frontend.register.unsubscribe_confirmation.question.other_placeholder')}}"></textarea>
                                        </div>
                                    </div>

                                    <p class="content" align="middle" style="font-weight: 550; text-decoration: underline; color:rgb(70, 64, 64);">{{__('frontend.register.unsubscribe_confirmation.details')}}</p>

                                    <div class="col-md-6 col-md-offset-4" style="width: 100%; display:flex; justify-content:center; margin:0;">
                                        <button type="submit" class="btn btn-primary" id="confirmReason" name="submit" style="width: 80%; max-width: 300px;border-radius: 10px; background-color: rgb(16, 128, 208)!important; ">
                                            {{__('frontend.register.unsubscribe_confirmation.confirm')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-footer"> --}}

                        {{-- <div class="col-md-6 col-md-offset-4" style="width: 100%; display:flex; justify-content:center; margin:0;">
                                <button type="submit" class="btn btn-primary" style="width: 80%; max-width: 300px;border-radius: 10px; background-color: rgb(16, 128, 208)!important; ">
                                    {{__('frontend.register.unsubscribe_confirmation.confirm')}}
                        </button>
                    </div> --}}
                    {{-- <div class="row" style="text-align: center;">
                                <input type="submit" class="home btn btn-success btn-outline" name="submit" value="{{__('frontend.register.unsubscribe_confirmation.confirm')}}">
                </div> --}}

                {{--
                        </div>  --}}
                {{-- </div> --}}
                <!-- {{html()->form()->close()}} -->
            </div>
    </div>
</div>

</div>
</div>
<!-- footer -->

<div class="row mt-5 pt-5">

    <div class="col-12 text-center">

        <img src="{{url('img/jpblog/img/logo.png')}}" alt="logo" class="img-fluid" style="width: 200px;height: 60px; margin-bottom:20px;">

    </div>

    <!--<div class="col-12 mt-3 text-center" >
     
                    <p style="font-weight: 600;">{{__('frontend.modes.email_auth.footer_9')}}</p>
     
                </div>-->

    <div class="col-12 mt-2 text-center pb-4 border-bottom">

        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.privacy')}}" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.index.footer.links.privacy_policy')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.cookie')}}" class="text-black" style="text-decoration: none; color:black;">{{__('strings.emails.auth.confirmation.cookie')}}</a> </span>
        <span class="me-3 me-lg-4"><a href="/pages/rewards" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.modes.email_auth.footer_3')}}</a></span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.referral_policy')}}" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.index.footer.links.referral_policy')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.safeguard')}}" class="text-black" style="text-decoration: none; color:black;">{{__('strings.emails.auth.confirmation.safeguards')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.term_condition')}}" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.index.footer.links.term_condition')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.faq')}}" class="text-black" style="text-decoration: none; color:black;">{{__('strings.emails.auth.confirmation.faq')}}</a> </span>
        <span class=""> <a href="/blog" class="text-black" style="text-decoration: none; color:black;">{{__('frontend.modes.email_auth.footer_8')}}</a> </span>

    </div>

    <div class="col-12 col-lg-6 text-center text-lg-start mt-3 mt-lg-4">
        <p class="mt-1">{{__('frontend.modes.email_auth.footer_10')}}</p>
    </div>

    <div class="col-12 col-lg-6 text-center text-lg-end mt-lg-4">
        <p class="mt-lg-1">{{__('frontend.modes.email_auth.footer_11')}}</p>
    </div>

</div>

@endsection

@push('after-scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.2/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).on('change', "input[data-precode_type='other']", function(e) {
        $('#otherstext').hide();
        $('#otherstext').prop('required', false);
        var current_status = this.checked;
        var question = $(this).data('question');

        $("input[data-question='" + question + "']").each(function() {
            if (this.checked) {
                $(this).prop("checked", false);
            }
        });

        if (current_status) {
            $(this).prop("checked", true);
            $('#otherstext').show();
            $('#otherstext').prop('required', true);
        }

    });
    $(document).on('change', "input[data-precode_type='general']", function(e) {
        $('#otherstext').hide();
        $('#otherstext').prop('required', false);
    });

    $(document).on('change', "input[data-precode_type='general']", function(e) {
        $('#otherstext').hide();
        $('#otherstext').prop('required', false);
    });

    $(document).on('change', "input[name='myRadio']", function(e) {
        if ($(this).val() === "option1") {
            $('#cardContainer').show();
            $('#otherstext').hide().prop('required', false);
        } else {
            $('#cardContainer').hide();
            $('#otherstext').hide().prop('required', false);
        }
    });


    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $('#confirmReason').click(function() {
            $('#confirmationModal').modal('show');
        })
        $('#sureButton').click(function() {
            var email = $('#emailId').val();
            var reason = $('input[name="reason"]:checked').val();
            if (reason == 'Others') {
                reason = $('#otherstext').val();
            }
            $.ajax({
                url: "{{ route('frontend.auth.account.userDeactivateReason') }}",
                type: 'POST',
                data: {
                    email: email,
                    reason: reason
                },
                success: function(response) {
                    $('#confirmationModal').modal('hide');
                    Swal.fire({
                        title: "{{__('inpanel.user.profile.preferences.unsubscribe_email.swal_title2')}}",
                        icon: 'success',
                        text: response.message,
                        confirmButtonText: "{{__('inpanel.user.profile.preferences.unsubscribe_email.ok_button')}}",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((res) => {
                        window.location.href = "{{ route('frontend.auth.logout') }}";
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });





    $(document).ready(function() {
        $("input[name='myRadio'][value='option2']").on('click', function() {
            $('#confirmationModal').modal('show');
        });

        // $('#sureButton').on('click', function() {
        //      = "{{ route('frontend.auth.account.deactivate') }}";
        // });


    });
</script>
@endpush