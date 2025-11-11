
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SJ Panel</title>
  <link rel="stylesheet" href="{{asset('landing-css/style.css')}}" />
  <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="" />
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'>
  <link rel="stylesheet" href="{{asset('landing-css/slider.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/toastr.min.css" rel="stylesheet">

</head>

<body>
  <div class="container-fluid">
    @include('includes.partials.messages')
  </div>

  <div class="container-fluid p-0">
    <section class="hero-section d-flex">
      <div class="triangle-shape"></div>
      <div class="blue-bg-shape"></div>
      <div class="container">
        <div class="d-flex header-mobile-wrapper">
          <img src="{{asset('landing-images/logo.svg')}}" class="logo" alt="SJ Panel Logo" />
          <a href="#contact-section" class="text">Contact Us</a>
        </div>
        <div class="row align-items-center mt-5">
          <div class="col-md-6 hero-content">
            <h1 class="hero-heading"><strong>YOUR OPINION </strong><span class="hero-subheading d-block">MATTERS</span>
            </h1>
            <p class="hero-text">
              SJ Panel is a free online survey platform that lets you share your opinion through online
              surveys and earn exciting rewards.
              Simply register, fill your profile, take surveys and collect points for each completed
              survey.
              Redeem your points for exciting gifts, coupons, and other rewards.
            </p>

            <div class="app-buttons mt-4 d-flex">
              <a href="https://apps.apple.com/us/app/sj-panel/id6743372465"><img src="{{asset('landing-images/Apple.webp')}}" alt="App Store" /></a>
              <a href="https://play.google.com/store/apps/details?id=com.sjpanel"><img src="{{asset('landing-images/Google.webp')}}" alt="Google Play" /></a>
            </div>
            <div class="dot-frame"><img src="{{asset('landing-images/Dot Frame.svg')}}" alt="dot frame" /></div>
          </div>

          <div class="col-md-6 d-flex justify-content-center mobile-rlt">
            <img src="{{asset('landing-images/iPhone 13.webp')}}" class="phone-mockup" alt="Phone UI" />
          </div>
        </div>
      </div>
    </section>
    <section class="slider-1 mt-3">
      <div class="container text-center">
        <h2 class="features-title">Features</h2>
        <div class="dot-divider"></div>


        <div class="container">
          <div class="slider-container">
            <div class="left-arrow"><i class="fa fa-angle-left" style="font-size:24px;color: white;"></i></div>
            <div class="slider-content" id='slider-content'>
              <div class='slide'>
                <div class="media">
                  <img src="{{asset('landing-images/Phone_Screen_5.webp')}}"
                    alt="">
                  <video src=""></video>
                </div>
              </div>
              <div class='slide'>
                <div class="media">
                  <img src="{{asset('landing-images/Phone_Screen_2.webp')}}"
                    alt="">
                  <video src=""></video>
                </div>
              </div>
              <div class='slide'>
                <div class="media">
                  <img
                    src="{{asset('landing-images/Phone_Screen_1.webp')}}"
                    alt="">
                  <video src=""></video>
                </div>
              </div>
              <div class='slide'>
                <div class="media">
                  <img src="{{asset('landing-images/Phone_Screen_4.webp')}}"
                    alt="">
                  <video src=""></video>
                </div>
              </div>
              <div class='slide'>
                <div class="media">
                  <img
                    src="{{asset('landing-images/Phone_Screen_3.webp')}}"
                    alt="">
                  <video src=""></video>
                </div>

              </div>
              <!-- <div class='slide'>
                <div class="media">
                  <img
                    src="landing-images/Phone_Screen_5.png"
                    alt="">
                  <video src=""></video>
                </div>
                <div class="card-sections">
                </div>
              </div>
              <div class='slide'>
                <div class="media">
                  <img src="landing-images/Phone_Screen_2.png"
                    alt="">
                  <video src=""></video>
                </div>
              </div>
              <div class='slide'>
                <div class="media">
                  <img src="landing-images/Phone_Screen_3.png"
                    alt="">
                  <video src=""></video>
                </div>
              </div> -->
              <div class="slider-content-background"></div>
            </div>
            <div class="right-arrow"><i class="fa fa-angle-right" style="font-size:24px;color:white;"></i></div>
          </div>
        </div>
      </div>
    </section>

    <div class="content-bg container-fluid">
      <section class="app-section text-center d-flex">
        <div class="container">
          <div class="row align-items-center">
            <div class=" col-lg-8 col-md-6 text-md-start text-center">
              <h5 class="fw-bold get-app-h5"><span class="text-primary dot-span">•</span> Get the App</h5>
              <p>Join SJ Panel and start earning rewards for your opinions. Available now on both iOS and
                Android – download the app and take surveys anytime, anywhere!</p>
              <div class="d-flex justify-content-md-start justify-content-center align-items-center gap-2 mt-5">
                <a href="https://apps.apple.com/us/app/sj-panel/id6743372465"><img src="{{asset('landing-images/Apple.webp')}}" alt="App Store" height="55"></a>
                <a href="https://play.google.com/store/apps/details?id=com.sjpanel"><img src="{{asset('landing-images/Google.webp')}}" alt="Google Play" height="55"></a>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center mt-md-0 mobile-img">
              <img src="{{asset('landing-images/Group 40.webp')}}" class="app-image" alt="Phone Mockup" />
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Form -->
      <section class="contact-section" id="contact-section">
        <div class="container">
          <div class="contact-card mx-auto">
            <h3 class="text-center">Say Hello to Us</h3>
            <p class="text-center">Have questions or need help? Contact us – we’re here to assist you!</p>
            {{ html()->form('POST', route('frontend.auth.landingcontact'))->id('landingform')->open() }}
            <form action="{{route('frontend.auth.send.email')}}" method="POST">
              <div class="row g-3">
                <div class="col-md-6 contact-input">
                  <input type="text" class="form-control" placeholder="What is your name? *" name="name">
                </div>
                <div class="col-md-6 contact-input">
                  <input type="email" class="form-control" placeholder="What is your email? *" name="email">
                </div>
                <div class="col-12 contact-input">
                  <textarea class="form-control" rows="3" placeholder="Write your message here" name="messages"></textarea>
                </div>
                <div
                  class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center policy-div">
                  <div class="form-check d-flex align-items-start mt-4 gap-2">
                    <div class="col-lg-6 col-md-12">
                      <input class="form-check-input custom-checkbox me-2" type="checkbox" value="" id="agreeCheck">
                      <span>
                        I have read and accept the
                        <a href="#" class="text-primary-1 text-decoration-none">Terms & Condition & Privacy Policy *</a>
                        <div class="agreeCheck_error_div col-12"></div>

                      </span>
                    </div>
                    <div class="col-md-6 send-message-div"><button type="submit" class="btn btn-primary mt-3 mt-md-0 send-message-btn" data-sitekey="{{config('settings.RECAPTCHA_SITE_KEY')}}">SEND
                        MESSAGE</button>
                    </div>
                  </div>
                </div>
              </div>
              {{html()->form()->close()}}
          </div>
        </div>
      </section>
    </div>
    <!-- Footer Download -->
    <footer class="download-footer text-center">
      <h5 class="mb-3">What are you waiting for? Download Now!</h5>
      <div class="store-buttons d-flex justify-content-center">
        <a href="https://apps.apple.com/us/app/sj-panel/id6743372465"><img src="{{asset('landing-images/Apple.svg')}}" alt="App Store" /></a>
        <a href="https://play.google.com/store/apps/details?id=com.sjpanel"><img src="{{asset('landing-images/Google.svg')}}" alt="Google Play" /></a>
      </div>
    </footer>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <!--<script type="text/javascript">
  const swiper = new Swiper(".mySwiper", {
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  loop: true,
  slidesPerView: 5,
  coverflowEffect: {
    rotate: 0,
    stretch: 80,
    depth: 200,
    modifier: 1.5,
    scale: 0.85,
    slideShadows: false
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  breakpoints: {
    320: { slidesPerView: 1 },
    576: { slidesPerView: 2 },
    768: { slidesPerView: 3 },
    992: { slidesPerView: 5 }
  }
});
</script>-->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js'></script>
  <script src="https://pub-7203ff99929c4d2ba6e23b092569532c.r2.dev/toastr.min.js"></script>
  <script src="{{asset('landing-css/script.js')}}"></script>
</body>
<script>
  $(document).ready(function() {
    // Handle form submit
    $('#landingform').on('submit', function(e) {
      let isValid = true;

      // Clear previous errors
      $('.form-control').removeClass('is-invalid');
      $('.error-message').remove();

      // Name field
      if ($('input[name="name"]').val().trim() === '') {
        $('input[name="name"]').addClass('is-invalid')
          .after('<div class="text-danger error-message">Name is required.</div>');
        isValid = false;
      }

      // Email field
      const email = $('input[name="email"]').val().trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (email === '') {
        $('input[name="email"]').addClass('is-invalid')
          .after('<div class="text-danger error-message">Email is required.</div>');
        isValid = false;
      } else if (!emailRegex.test(email)) {
        $('input[name="email"]').addClass('is-invalid')
          .after('<div class="text-danger error-message">Enter a valid email.</div>');
        isValid = false;
      }

      // Message field
      if ($('textarea[name="messages"]').val().trim() === '') {
        $('textarea[name="messages"]').addClass('is-invalid')
          .after('<div class="text-danger error-message">Message is required.</div>');
        isValid = false;
      }

      // Checkbox
      if (!$('#agreeCheck').is(':checked')) {
        $('#agreeCheck').addClass('is-invalid');
        if (!$('#agreeCheck').next('.error-message').length) {
          $('.agreeCheck_error_div').append('<div class="text-danger error-message">You must agree to terms.</div>');
        }
        isValid = false;
      }
      if (!isValid) {
        e.preventDefault();
      }
    });
    $('.form-control, #agreeCheck').on('keyup change', function() {
      $(this).removeClass('is-invalid');
      $(this).siblings('.error-message').remove();
      $(this).closest('.form-check').find('.error-message').remove();
    });

  });
</script>
@if(session('flash_success'))
    <script>
        toastr.success("{{ session('flash_success') }}");
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if(session('warning'))
    <script>
        toastr.warning("{{ session('warning') }}");
    </script>
@endif

@if(session('info'))
    <script>
        toastr.info("{{ session('info') }}");
    </script>
@endif

</html>