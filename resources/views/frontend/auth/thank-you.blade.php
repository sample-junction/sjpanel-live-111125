@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.register_box_title'))
@push('head-script')
<!-- Event snippet for Website lead conversion page -->

<script>
  gtag('event', 'conversion', {
    'send_to': 'AW-11352794455/bdbQCJquuOYYENfKt6Uq'
  });
</script>
@endpush
@push('after-styles')

<!-- Bootstrap Core CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"
  rel="stylesheet" type='text/css'>

<link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
<link href="{{asset('css2/style2.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap4.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css2/bootstrap.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap.rtl.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-grid.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-grid.rtl.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-grid.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-reboot.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-reboot.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-reboot.rtl.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-reboot.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-utilities.css')}}" rel="stylesheet">
<link href="{{asset('css2/bootstrap-utilities.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-utilities.rtl.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css2/bootstrap-utilities.rtl.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<style>
  .Thank_text_h1 {
    padding: 10px !important;
  }

  .gradient-custom-2 {
    /* fallback for old browsers */
    background: #006BDE;
    display: grid !important;

  }

  #contain-div-1 {
    border-radius: 10px 0px 0px 10px;
  }

  .div_m_t p {
    color: #757575 !important;
    font-size: 16px !important;
  }

  .footer_style {
    bottom: -56px;
  }

  .custom-swal-popup {
    font-size: 18px !important;
    /* For general text */
  }

  .custom-swal-title {
    font-size: 24px !important;
  }

  .custom-swal-text {
    font-size: 20px !important;
  }

  .main-confirm-div .not_receive {
    color: black !important;
  }

  @media(min-width: 220px) and (max-width:767px) {

    /*  #contain-div-1{
    display: none !important;
  }*/
    footer.footer_style {
      /*    display: none !important;*/
      /*  position: absolute !important;*/
    }

    .div_m_t .image_center {
      margin-top: 0px !important;
    }
  }

  @media (min-width: 768px) and (max-width: 981px) {
    .footer_style {
      margin-top: 135px !important;
    }
  }
</style>

@endpush

@section('content')


<div id="container"><!-- main container starts-->
  <div id="wrapp"><!-- main wrapp starts-->
    <nav class="navbar navbar-expand-lg navbar-dark  static-top">
      <div class="container Nav-div">
        <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
          <img src="images/SJ Panel New LOGO without background.png" alt="..." class="img-fluid">
        </a>
        <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button> -->

        <span class="navbar-brand-2 " id="span-1"><span class="already">{{__('frontend.index.contact_us.already_account')}} </span> <a href="{{url('/')}}/login" style="color: #006BDE;">
            {{__('frontend.modes.email_auth.button')}}
          </a></span>
      </div>
    </nav><!-- header ends-->

  </div>
</div>

<div id="line"></div>

<div class="container" style="margin-bottom: 10px;">
  <section class="h-100 gradient-form">
    <div class="container py-5 h-100" id="card">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-12">
          <div class="card rounded-3 text-black">
            <div class="row g-0" width="25px">

              <div class="col-lg-6  align-items-center gradient-custom-2" id="contain-div-1">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <img src="{{ asset('img/login_user.png')}}" class="image_center" />
                  <h4 class="mb-4 text_margin_style">{{__('frontend.index.contact_us.opinion')}}</h4>
                  <p class="small mb-0 p_open">{{__('frontend.index.contact_us.join')}}<br />
                    {{__('frontend.index.contact_us.join_1')}}
                  </p>
                  <div class="row div_m">
                    <div class="col-3 img-1">
                      <div class="icon_style">
                        <img src="{{ asset('img/Vector.png')}}" class="icon_padding_style " style="padding-top: 10px;" />
                      </div>
                      <h2 class="icon_heading sign">{{__('frontend.index.contact_us.signup_for')}}</h2>
                    </div>

                    <div class="col-3 border-center img-2">
                      <div class="icon_style"><img src="{{ asset('img/Group.png')}}" class="icon_padding_style" style="padding-left: 14px;" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.how_it_works.title_subhead_4')}}</h2>
                    </div>
                    <div class="col-3 border-center2 img-3">
                      <div class="icon_style"><img src="{{ asset('img/Group 70.png')}}" class="icon_padding_style" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.take_survey')}}</h2>
                    </div>
                    <div class="col-3 border-center3 re-image">
                      <div class="icon_style"><img src="{{ asset('img/Vector-1.png')}}" class="icon_padding_style" style="padding-left: 12px;" /></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.redeem_rewards')}}</h2>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 div_m_t">
                <img src="{{ asset('img/thank.jpg')}}" class="image_center" />
                <h4 class="mb-4 text_margin_style Thank_text_h1">{{__('frontend.index.contact_us.thanks_1')}}</h4>
                <p class="small mb-0 p_open" style="color: black !important;">{{__('frontend.index.contact_us.thanks_2')}}<br />
                  {{__('frontend.index.contact_us.thanks_3')}}<strong>{{__('frontend.index.contact_us.thnk_3')}}</strong><br />{{__('frontend.index.contact_us.thanks_4')}}
                </p>
                <div class="confirmation-btn w-100 mt-4 text-center main-confirm-div">
                  <p class="not_receive small mb-0 p_open">{{__('frontend.index.contact_us.not_receive_mail_msg')}}</p>
                  <p class="not_receive">{{__('frontend.index.contact_us.not_receive_mail_msg2')}}</p>
                  <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : $user_id }}" id="user_id">
                  <button id="resendBtn" type="button" class="btn btn-primary w-25">{{__('frontend.index.contact_us.resend_email')}}</button>
                  <p id="countdownText" style="display: none;">{{__('frontend.index.contact_us.resend_in')}} <span id="countdown">20</span> {{__('frontend.index.contact_us.resend_sec')}}</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</div>

</section>




</div>


<footer class="footer_style" style="background:#E6E6E6;">
  <div class="container">
    <div class="row text-center">
      <div class="pull-left col-lg-6 col-xs-12 d-none d-md-block " style="text-align:start !important">
        <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj')}}</a></p>
      </div>
      <div class="col-lg-6 col-lg-offset-4 col-xs-12">
        <div class="pull_right_style">
          <p style="padding-right: 2px;">
            <a href="{{ route('frontend.cms.privacy') }}" class="policies" style="color: black;">{{__('frontend.index.contact_us.consent_3')}}</a> <span class=""> | </span>
            <a href="{{ route('frontend.cms.cookie') }}" class="" style="color: black;">{{__('frontend.index.footer.links.cookie_policy')}}</a> <span class=""> | </span>
            <a href="{{ route('frontend.cms.rewards_policy') }}" class=" pol" style="color: black;">{{__('frontend.index.footer.links.reward_policy')}}</a> <span cl
              class=" pol"> | </span>
            <a href="{{ route('frontend.cms.referral_policy') }}" class=" pol" style="color: black;">{{__('frontend.index.footer.links.referral_policy')}}</a> <span cl
              class=" pol"> | </span>
            <a href="{{ route('frontend.cms.safeguard') }}" class="Policy" style="color: black;">{{__('frontend.index.footer.links.Safeguards')}}</a> <span cl
              class="policy"> | </span>
            <a href="{{ route('frontend.cms.term_condition') }}" style="color: black;" class="terms policy">
              {{__('frontend.index.footer.links.term_condition')}}</a> <span cl
              class="policy"> | </span>
            <a href="{{ route('frontend.cms.faq') }}" style="color: black;" class="policy">{{__('frontend.index.footer.links.FAQ')}}</a>
          </p>
        </div>
      </div>
      <div class="pull-left col-lg-6 col-xs-12 d-sm-none mt-3">
        <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj')}}</a></p>
      </div>
    </div>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  gtag('event', 'conversion', {
    'send_to': 'AW-11352794455/cMO6CMKGp5AaENfKt6Uq',
    'value': 1.0,
    'currency': 'INR'
  });
  $(document).ready(function() {
    function startResendCountdown() {
      let countdown = 20;
      document.getElementById('resendBtn').disabled = true;
      document.getElementById('countdownText').style.display = 'block';
      const interval = setInterval(() => {
        countdown--;
        document.getElementById('countdown').innerText = countdown;

        if (countdown <= 0) {
          clearInterval(interval);
          document.getElementById('resendBtn').disabled = false;
          document.getElementById('countdownText').style.display = 'none';
        }
      }, 1000);
    }

    $('#resendBtn').click(function() {
      let user_id = $('#user_id').val();
      startResendCountdown();
      $.ajax({
        url: '{{ route("frontend.auth.resend_confirmation_email") }}',
        method: 'GET',
        data: {
          user_id: user_id
        },
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: "{{ __('frontend.index.contact_us.resend_success') }}",
            text: response.message,
            confirmButtonText:"{{__('frontend.index.contact_us.swalconfirm')}}",
            customClass: {
              popup: 'custom-swal-popup',
              title: 'custom-swal-title',
              htmlContainer: 'custom-swal-text'
            }
          });

          $('message').html(`<span style='color:green;'>${response.message}</span>`);
        },
        error: function(response) {
          Swal.fire({
            icon: 'error',
            title: "{{ __('frontend.index.contact_us.error') }}",
            confirmButtonText:"{{__('frontend.index.contact_us.swalconfirm')}}",
            text: response.message || 'Something went wrong!'
          });
        }
      });
    });
  });
</script>
@endsection