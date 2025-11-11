<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'SJ Panel')">
   <meta name="author" content="@yield('meta_author', 'SJ Panel')">
   <meta property="og:title" content="xxxx A title you want to be dispayed in shared content xxxx"/>
   <meta property="og:caption" content="xxxx A title you want to be dispayed in shared content xxxx"/>


        @yield('meta')

 @stack('before-styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> 

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

        <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    @stack('after-styles')    

    <style>

        @font-face {

        font-family: roboto;

        }

        html * {

        font-family: roboto;

        }  

        .cst-active{

            font-weight: bold;
            background: #f0eeff;            
            padding:10px;
            border-radius: 20px;
            transform: translateX(-10px);
        }
		
		footer{
			margin-top: auto;
		}

        .footer-ul li{
            display: inline-block;
        }

        .footer-ul li a{
        text-decoration: none;
        font-size: 12px;
        }

        input[type="checkbox"]{
            transform: scale(1.2);
        }

        .cst-menu-user-li{
            font-size: 12px;
        }

        .side-menu-li{
            display: flex;
            color: black;
            font-size: 14px;
        }

        /* .notification::after{

            content:"";
            position: absolute;
            height: 12px;
            width: 12px;
            background: red;
            left: 55%;
            border-radius: 10px;

        } */

        .line-hr:last-of-type{
            visibility: hidden;
        }

        #searchBar:focus-visible{

            outline: none;

        }


        .cst-space{
            padding-top: 3px;
            padding-bottom: 3px;

        }


        #hamB:focus{
            box-shadow: none;        
        }

        @keyframes mymoveBell {
  from {scale: 0.9;opacity:0.5;}
  to {scale: 1;opacity:1;}
    }

    .noti_Alert{
        animation-name: mymoveBell;
        animation-duration: 1s;
        animation-iteration-count: infinite;
        animation-delay:none;
    }


        .user-text{

            font-weight: 400;
            font-size: 14px;
            color: #000000;
        }

        .user-text-main{
            font-weight: 600;
            font-size: 18px;
            color: #000000;
        }


        .col-sm-8 {
            color: white;
            font-size: 24px;
            padding-bottom: 20px;
            padding-top: 18px;
        }
        .col-sm-8:nth-child(2n+1) {
            background: green;
        }
        .col-sm-8:nth-child(2n+2) {
            background: black;
        }


/*
 *  STYLE 5
 */

#style-5::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

#style-5::-webkit-scrollbar
{
    width: 2px;
    background-color: #F5F5F5;
}

#style-5::-webkit-scrollbar-thumb
{
/*    background-color: #0ae;*/
    
    background-image: -webkit-gradient(linear, 0 0, 0 100%,
                       color-stop(.5, rgba(255, 255, 255, .2)),
                       color-stop(.5, transparent), to(transparent));
}

/**STYLE 4
 */

#style-4::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

#style-4::-webkit-scrollbar
{
    width: 3px;
    background-color: #F5F5F5;
}

#style-4::-webkit-scrollbar-thumb
{
    background-color: #000000;
    border: 2px solid #555555;
}
 #hamB{
        display: none!important;
    }
@media(min-width: 220px) and (max-width:768px){
    .border-start{
        overflow-x: hidden;
        overflow-y: hidden;
    }
     #hamB{
        display: block!important;
    }
}
@media(min-width: 768px) and (max-width:991px){
    .border-start{
        overflow-x: hidden;
        overflow-y: hidden;
    }
    
}

/* Code added by Anil
Date:30-08-2025
*/
#otherCountryModal .welcome-content,
#redeemRequestModal .welcome-content,
#tourModal .welcome-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#otherCountryModal .welcome-paragraph,
#redeemRequestModal .welcome-paragraph,
#tourModal .welcome-paragraph {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    line-height: 8px;
    text-align: center;
}
#otherCountryModal .welcome-paragraph p,
#redeemRequestModal .welcome-paragraph p,
#tourModal .welcome-paragraph p{
    font-weight: 400;
    font-size: 18px;
    line-height: 16px;
}
#otherCountryModal .welcome-content .welcome-span, 
#redeemRequestModal .welcome-content .welcome-span, 
#tourModal .welcome-content .welcome-span {
    color: #0d7bf0;
    font-weight: bold;
    font-size: 30px;
    text-transform: uppercase;
}

#otherCountryModal .modal-header,
#redeemRequestModal .modal-header,
#tourModal .modal-header {
  border-bottom: none !important;
  border-bottom: unset !important;
}

#otherCountryModal .custom-close,
#redeemRequestModal .custom-close,
#tourModal .custom-close {
    background-color: red !important;
    color: white !important;
    opacity: 1;
    border-radius: 50%;
    background-size: 1.25rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M2.146 2.854a.5.5 0 0 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854z'/%3E%3C/svg%3E") !important;
}

#otherCountryModal .custom-close::before,
#otherCountryModal .custom-close::after,
#redeemRequestModal .custom-close::before,
#redeemRequestModal .custom-close::after,
#tourModal .custom-close::before,
#tourModal .custom-close::after {
    background-color: white !important;
}


#otherCountryModal .modal-content .custom-button,
#redeemRequestModal .modal-content .custom-button,
#tourModal .modal-content .custom-button {
    background-color: #0d7bf0;
    color: white;
    border: none;
    padding: 12px 18px;
    border-radius: 10px;
    width: 80%;
    font-weight: 500;
    font-size: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
}

#otherCountryModal .welcome-div,
#tourModal .welcome-div {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
#tourModal .modal-body{
    max-height: 340px!important;
}
#redeemRequestModal .modal-body{
    height: 280px!important;
}
#otherCountryModal .modal-popup-other-country{
    max-height: 330px!important;
}

@media only screen and (max-width: 991px) {
  #otherCountryModal .modal-body,
  #tourModal .modal-body, 
  #redeemRequestModal .modal-body {
    height: auto!important;
  }
  #otherCountryModal .modal-popup-other-country{
    height: auto!important;
}
#redeemRequestModal .redeem-div{
    display: flex;
    flex-direction: column;
    gap: 2rem;
}
#otherCountryModal .welcome-paragraph {
    display: flex;
    font-size: 20px;
    line-height: 8px;
}
#otherCountryModal .welcome-paragraph p {
    font-weight: 400;
    font-size: 18px;
    line-height: 20px;
}
}
    </style>

<!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0SQ2T8ZR4E"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-0SQ2T8ZR4E');
</script>

</head>

<body style="background: white;">
    
<section>
<div class="container-fluid mt-5">

        <div class="row">
    
    @include('inpanel.includes.device.device_header')
    @include('inpanel.includes.device.device_nav')
    
    
           <div class="col-2 d-none d-lg-block"></div>
           <div class="col-sm-12 col-lg-10 border-start" style="background: #F3F3F3;display: flex;flex-direction: column;min-height: 100vh;">
            @include('includes.partials.logged-in-as')
           
            @if (Route::currentRouteName() !== 'inpanel.basic.show' && Route::currentRouteName() !== 'inpanel.basic.pro')
                @include('includes.partials.reedem-points-meter')
            @endif

                 @include('inpanel.includes.device.device_topbar')
                 @include('includes.partials.messages')
                        @yield('content')

                        @include('inpanel.includes.device.device_footer')
               

                

           


            </div>





        </div>

    </div>


</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>


<script>


// for all options selection

var allchk = document.querySelectorAll('.chk');

var op = document.querySelector('#deviceFour');

var status = 'unchecked';

op.addEventListener('click', () => {


    setTimeout(checkBoxStim, 100);


});

function checkBoxStim(){

    if(status == 'unchecked'){

        allchk.forEach((element) => {

        element.checked = true;

        });

        status = 'checked';

    }else{

        status = 'unchecked';

        allchk.forEach((element) => {

        element.checked = false;

        });

    }




}

//




// for search icon

var sb = document.getElementById("searchBar");

var si = document.getElementById("searchIcon");

sb.addEventListener("keyup", () => {

    if(sb.value !== ''){

        si.style.visibility = 'hidden';

    }else{

        si.style.visibility = 'visible';

    }

});


//



</script>
<!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
       
        {!! script(mix('js/inpanel.js')) !!}
          <script src="{{ asset('js/vendor.js') }}"></script>
        <script>
            $(document).ready(function(){
                var remain_point = $('.nav-text').attr('data-remaining_points');
            });
        </script>
        <script src="{{asset('vendor/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
        <script src="{{asset('vendor/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- Custom and plugin javascript -->
        <script src="{{asset('vendor/js/inspinia.js')}}"></script>
        <script src="{{asset('vendor/js/plugins/pace/pace.min.js')}}"></script>
        <!-- jQuery UI
        <script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script> -->
        <!-- GITTER -->
        <script src="{{asset('vendor/js/plugins/gritter/jquery.gritter.min.js')}}"></script>
        <!-- Toastr -->
		{{--@unless(str_contains(Request::url(), 'profile'))--}}
			<script src="{{asset('vendor/js/plugins/toastr/toastr.min.js')}}"></script>
		{{--@endunless--}}
        @stack('after-scripts')
        {{--@include('includes.partials.ga')--}}
    

</body>

</html>