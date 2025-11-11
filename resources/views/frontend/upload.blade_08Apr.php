@extends('frontend.layouts.app')
   
@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
    rel="stylesheet"  type='text/css'>

    <link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{asset('css2/style.css')}}" rel="stylesheet">
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

        label.btn-up {
        padding: 12px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        background-color: white;
        color: black;
        border: 2px solid #008CBA;
        color: #008CBA;
        border-radius: 15px;
        }

        .drop-zone {
            height: 330px;
        padding: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-family: "Quicksand", sans-serif;
        font-weight: 500;
        font-size: 20px;
        cursor: pointer;
        color: #cccccc;
        border: 2px dashed #cbd4d2;
        border-radius: 10px;
        flex-direction: column;
        }

        .drop-zone--over {
        border-style: solid;
        }

        .drop-zone__input {
        display: none !important;
        }

        .drop-zone__thumb {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        background-color: #cccccc;
        background-size: cover;
        position: relative;
        }

        .drop-zone__thumb::after {
        content: attr(data-label);
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 5px 0;
        color: #ffffff;
        background: rgba(0, 0, 0, 0.75);
        font-size: 14px;
        text-align: center;
        }
		

.footer_style{
  bottom: -56px;
}

@media(min-width: 220px) and (max-width:767px){
/*  #contain-div-1{
    display: none !important;
  }*/
  footer.footer_style{
/*    display: none !important;*/
/*  position: absolute !important;*/
  }
  .div_m_t .image_center {
    margin-top: 0px !important;
}
}
@media (min-width: 768px) and (max-width: 981px){
  .footer_style{
      margin-top: 135px !important;
  }
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
</style>

@section('content')
  <div id="container"><!-- main container starts-->
    <div id="wrapp"><!-- main wrapp starts-->
        <nav class="navbar navbar-expand-lg navbar-dark  static-top">
          <div class="container Nav-div" >
            <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
              <img src="{{asset('images/SJ Panel New LOGO without background.png')}}" alt="..." class="img-fluid">
            </a>

          </div>
        </nav><!-- header ends-->
        
    </div>
  </div>

<div id="line"></div>


    <div class="container mt-5 pt-5">

        <div class="row shadow" style="border-radius: 20px;">

            <div class="col-6" style="background-image: url('{{asset('img/video-recording-app-coursifyme.jpg')}}'); background-size: cover; border-radius: 20px 0px 0px 20px;">


            </div>

            <div class="col-6 text-center pt-5 pb-5 ps-5 pe-5">
			
				@if(session('success'))
					<div id="myDiv"></div>				
					<img src="{{ asset('img/thank.jpg')}}" class="image_center" />
					<h4 class="mb-4 text_margin_style Thank_text_h1">{{__('frontend.index.contact_us.upload_thanks_1')}}</h4>
					<h4 class="mb-4 text_margin_style Thank_text_h1">{{__('frontend.index.contact_us.upload_thanks_2')}}</h4>
					<h4 class="mb-4 text_margin_style Thank_text_h1">{{__('frontend.index.contact_us.upload_thanks_3')}}</h4>
					<br /> 
					<p class="small mb-0 p_open">{{__('frontend.index.contact_us.upload_thanks_4')}}</p>
					
				@else

                <p class="h5 text-primary mb-4">***Your Information Will Be Kept Under Full Privacy***</p>

					@php
						$url = $currentUrl;
						// Assuming $url contains the URL generated by Laravel's route
						$slug = last(explode('/', parse_url($url, PHP_URL_PATH)));
						
					@endphp
																 
					<form action="{{ route('frontend.video.upload') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    
                    <div class="drop-zone">
                        
                        <img src="{{ asset('img/feather_upload-cloud.png')}}" alt="icon" class="img-fluid drop-zone__prompt">

                        <p class="mt-2 mb-0 text-dark drop-zone__prompt2 mt-4" style="font-size: 17px;">Select a file or drag and drop here</p>

                        <p class="mt-1 text-secondary drop-zone__prompt3" style="opacity:0.7; font-size: 17px;">JPG, PNG or Video file size no more than 10 MB</p>

                        <button class="btn btn-outline-primary mt-2 drop-zone__prompt4" type="button" style="font-size: 14px; border: 1px solid #0d6efd;">SELECT FILE</button>

                        <input type="file" name="image" id="inputGroupFile01" class="drop-zone__input">
						
                    </div>
					<input type="hidden" name="uid" value="{{ $slug }}">
                    <div class="p-2 pt-4 pb-4 mt-4 rounded-4" style="background: #FBFDFE; box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.1);">
                        <button class="btn btn-primary" type="submit" id="uploadButton" style="width: 100px; height: 40px;">Upload</button>
                    </div>


                </form>
						
				@endif
            </div>
        </div>
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
                  <a href="{{ route('frontend.cms.term_condition') }}"  style="color: black;" class="terms policy"> 
                    {{__('frontend.index.footer.links.term_condition')}}</a> <span cl
                    class="policy"> | </span> 
                    <a href="{{ route('frontend.cms.faq') }}" style="color: black;" class="policy">{{__('frontend.index.footer.links.FAQ')}}</a></p>
              </div>
            </div>
             <div class="pull-left col-lg-6 col-xs-12 d-sm-none mt-3">
                <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj')}}</a></p>
            </div>
        </div>
    </div>
</footer>


@endsection

@push('after-styles')
    <style>

/*        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control-placeholder {
            position: absolute;
            top: 0;
            padding: 7px 0 0 13px;
            transition: all 200ms;
            opacity: 0.5;
        }

        .form-control:focus + .form-control-placeholder,
        .form-control:valid + .form-control-placeholder, .form-control + .form-control-placeholder {
            font-size: 75%;
            transform: translate3d(0, -100%, 0);
            opacity: 1;
        }
*/
    </style>
@push('after-scripts')

<script>

        document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
        updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
        dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
        inputElement.files = e.dataTransfer.files;
        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
    });

    /**
     * Updates the thumbnail on a drop zone element.
     *
     * @param {HTMLElement} dropZoneElement
     * @param {File} file
     */
    function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    if (dropZoneElement.querySelector(".drop-zone__prompt2")) {
        dropZoneElement.querySelector(".drop-zone__prompt2").remove();
    }

    if (dropZoneElement.querySelector(".drop-zone__prompt3")) {
        dropZoneElement.querySelector(".drop-zone__prompt3").remove();
    }

    if (dropZoneElement.querySelector(".drop-zone__prompt4")) {
        dropZoneElement.querySelector(".drop-zone__prompt4").remove();
    }


    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
        thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
    }



    // Get the reference to the div element
    var div = document.getElementById('myDiv');

    // Hide the div after 3 seconds
    setTimeout(function() {
        div.style.display = 'none';
		window.location.href = '/login';
    }, 5000); // 5000 milliseconds = 5 seconds
</script>


<script>
    const dropZone = document.getElementById('drop-zone');
    const input = document.getElementById('inputGroupFile01');
    const uploadButton = document.getElementById('uploadButton');
    const uploadForm = document.getElementById('uploadForm');
    const uid = document.getElementById('uidd');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        
        const file = e.dataTransfer.files[0];
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change')); 
        input.style.display = 'none'; 
        uploadButton.style.display = 'block'; 
    });

    uploadButton.addEventListener('click', () => {
        uploadForm.submit();
    });

    // Trigger file input click when select file button is clicked
    document.querySelector('.drop-zone__prompt4').addEventListener('click', () => {
        input.click();
    });
</script>

@endpush

