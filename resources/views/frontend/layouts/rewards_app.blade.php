<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" oncontextmenu="return true;">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" oncontextmenu="return true;">
@endlangrtl

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Best Online Survey Platform | Paid Online Survey in US - SJ Panel')</title>

    <meta name="description" content="@yield('meta_description', 'SJ Panel is one the best online survey platforms for paid research surveys and make extra money online. You can start earning reward points now by completing paid online survey in US. ')">
	<meta name="google-site-verification" content="X_xKrEKIs6Gq5_zJq3lGd5ZyfEMTH5wEWMa3vapgA3k" />
	<meta name="author" content="@yield('meta_author', 'SJ Panel')">
    <meta name="keyword" content="@yield('meta_keyword','paid online survey, best survey platforms, paid research surveys, best paid survey sites, online survey research, online survey platforms, paid online survey in US')">
    @yield('meta')

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./slick/slick.css?v2022">
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css?v2022">

    <!-- Toastr style -->
    <link href="{{ asset('vendor/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    @stack('before-styles')

    <style>
		body{
			height:100vh;
		}
        .tap-btn{
            padding: 5px;
            border-radius: 10px;
            width: 172px;
        }

		.res-box{
			background: #CBDFFA;
			box-shadow: 0px 5px 0px #191A23;
		}

        .mob-card{
            height: 300px;
        }

        .info-box{
            height: 240px;
        }

        #filter-content-data{
            background-image: url({{asset('img/bg-new-award.png')}});
            background-size: cover;
            height:auto;
           	overflow:hidden;
			padding-bottom:15px;
        }

        .text-custom{
            text-shadow: 0 1px 0 #ccc, 
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);
               0 30px 20px rgba(0,0,0,.1); 
        }

        .element-info{
            width: 40%;
            margin-left: 50%;
            transform: translateX(-50%);
            border: 2px solid black;
            background-color: #ececec;
        }

        .progress {
        background-color: #d8d8d8;
        border-radius: 20px;
        position: relative;
        margin: 15px 0;
        height: 30px;
        width: 300px;
        margin-left: 50%;
        transform: translateX(-50%);
        }

        .progress-done {
            background: linear-gradient(to left, #F2709C, #FF9472);
            box-shadow: 0 3px 3px -5px #F2709C, 0 2px 5px #F2709C;
            border-radius: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 0;
            opacity: 0;
            transition: 1s ease 0.3s;
        }

        .fil_active{
            color:#0d6efd;
            border: 2px solid #0d6efd;
            font-weight: 600;
        }

        .hid{
            display: none;
        }
.img-fluid {
    padding-top: 30px !important;
}

        @media only screen and (max-width: 600px) {

            .element-info{
            width: 100%;
            margin-left: 50%;
            transform: translateX(-50%);
            border: 2px solid black;
        }

		.tap-btn{
            padding: 10px;
            border-radius: 10px;
            width: 165px;
        }


        }

    </style>

    @stack('after-styles')
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="canonical" href="https://www.sjpanel.com/@yield('link_url')">

                <!-- Cookie Consent style -->
                <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
</head>
<body id="page-top" class="landing-page">
        <div id="app">
            

            @yield('content')


        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
		
   <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
<!--  remove conflicts : Priyanka (07-june-2024) -->
<script>
	// Display the loader overlay
	function showLoader() {
		document.getElementById('loader-overlay').style.display = 'block';
	}

	// Hide the loader overlay 
	function hideLoader() {
		document.getElementById('loader-overlay').style.display = 'none';
	}
 
	// Simulate loading for demonstration purposes (remove this in real implementation)
	function simulateLoading() {
		showLoader();
		setTimeout(function() {
			hideLoader();
		}, 3000); // Simulate loading for 3 seconds
	}

		
	function executeDraw(str,ele){

		if(str == 'mpa'){
			
			console.log(ele);
			
			showLoader();
			setTimeout(function() {
				hideLoader();
				document.querySelector('#mapTotal').classList.remove('hid');
				document.querySelector('#mapCon').classList.remove('hid');
				ele.disabled = true;
				// Scroll down by 100px
				//window.scrollBy(0, 500);
				smoothScrollBy(1000, 200);
			}, 3000);	
			

		}else if(str == 'sp'){
			
			showLoader();
			setTimeout(function() {
				hideLoader();
				document.querySelector('#spTotal').classList.remove('hid');
				document.querySelector('#spCon').classList.remove('hid');
				ele.disabled = true;

				smoothScrollBy(1000, 200);
			}, 3000);			
			
		}else if(str == 'pp'){
			
			showLoader();
			setTimeout(function() {
				hideLoader();
				document.querySelector('#ppTotal').classList.remove('hid');
				document.querySelector('#ppCon').classList.remove('hid');
				ele.disabled = true;

				smoothScrollBy(1000, 200);
			}, 3000);
		}else{
			console.log('end');
		}

	}		
function smoothScrollBy(distance, speed) {
    const step = distance / speed;
    let currentPosition = window.pageYOffset;
    const targetPosition = currentPosition + distance;

    function scrollStep() {
        if (currentPosition < targetPosition) {
            window.scrollBy(0, step);
            currentPosition += step;
            requestAnimationFrame(scrollStep);
        }
    }

    scrollStep();
}

</script>
<!-- code after conflicts : Priyanka (07-june-2024) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.4.0.min.js"></script>
        <script src="./slick/slick.js?v2022" type="text/javascript" charset="utf-8"></script>
    <script>

//
// Himanshu 22-04-2025 start ->
function contentLoader(str) {

    $('.tap-btn').removeClass('fil_active');
    $('.filter-content-data').hide();

    $(`.tab-${str}`).addClass('fil_active');
    $(`.container-${str}`).show();
}
// Himanshu 22-04-2025 end <-


function contentLoader_old(str) {

let div_data = document.querySelectorAll('#filter-content-data');

let fil_m = document.querySelectorAll('.tap-btn ');


if (str == 'about') {

    for (let i = 0; i < div_data.length; i++) {

        if (div_data[i].dataset.sr == 'about') {

            div_data[i].style.display = 'block';
            fil_m[0].classList.add('fil_active');

        } else {

            div_data[i].style.display = 'none';
            fil_m[1].classList.remove('fil_active');
            fil_m[2].classList.remove('fil_active');
            fil_m[3].classList.remove('fil_active');

        }

    }

}

else if (str == 'f-award') {

    for (let i = 0; i < div_data.length; i++) {

        if (div_data[i].dataset.sr == 'f-award') {

            div_data[i].style.display = 'block';
            fil_m[1].classList.add('fil_active');

        } else {

            div_data[i].style.display = 'none';
            fil_m[0].classList.remove('fil_active');
            fil_m[2].classList.remove('fil_active');
            fil_m[3].classList.remove('fil_active');

        }

    }


}



else if (str == 's-award') {

    for (let i = 0; i < div_data.length; i++) {

        if (div_data[i].dataset.sr == 's-award') {

            div_data[i].style.display = 'block';
            fil_m[2].classList.add('fil_active');

        } else {

            div_data[i].style.display = 'none';
            fil_m[0].classList.remove('fil_active');
            fil_m[1].classList.remove('fil_active');
            fil_m[3].classList.remove('fil_active');

        }

    }


}



else if (str == 't-award') {

for (let i = 0; i < div_data.length; i++) {

    if (div_data[i].dataset.sr == 't-award') {

        div_data[i].style.display = 'block';
        fil_m[3].classList.add('fil_active');

    } else {

        div_data[i].style.display = 'none';
            fil_m[0].classList.remove('fil_active');
            fil_m[1].classList.remove('fil_active');
            fil_m[2].classList.remove('fil_active');

    }

}


}


}

var count = 0;

function new_move(prog){
    count++;
    const progress = document.querySelector('.'+prog);
    console.log(progress);
    progress.dataset.done = count;

    progress.style.width = progress.getAttribute('data-done') + '%';
    progress.style.opacity = 1;

    if(count == 100){

        setTimeout(function(){
            document.body.style.overflow = "scroll";
            document.querySelector(`#${prog}_click`).disabled = true;
            document.querySelector(`#${prog}_section`).classList.remove('hid');
            document.querySelector(`#${prog}_section`).scrollIntoView();

        }, 1200);
        count = 0;
        return;
    }

    setTimeout(function(){new_move(prog)}, 1);


}





const progress = document.querySelector('.prog1');
const progress2 = document.querySelector('.prog2');
const progress3 = document.querySelector('.prog3');


function move(){

    count++;

    progress.dataset.done = count;

    progress.style.width = progress.getAttribute('data-done') + '%';
    progress.style.opacity = 1;

    if(count == 100){

        setTimeout(gen_Result1, 1200);
        count = 0;
        return;
    }

    setTimeout(move, 1);
}


function move2(){

count++;

progress2.dataset.done = count;

progress2.style.width = progress2.getAttribute('data-done') + '%';
progress2.style.opacity = 1;

if(count == 100){

    setTimeout(gen_Result2, 1200);
    count = 0;
    return;
}

setTimeout(move2, 1);
}


function move3(){

count++;

progress3.dataset.done = count;

progress3.style.width = progress3.getAttribute('data-done') + '%';
progress3.style.opacity = 1;

if(count == 100){

    setTimeout(gen_Result3, 1200);
    count = 0;
    return;
}

setTimeout(move3, 1);
}



function gen_Result1(){
document.body.style.overflow = "scroll";
document.querySelector('#pp-click').disabled = true;

document.querySelector('#profileAward').classList.remove('hid');

document.querySelector('#profileAward').scrollIntoView();

}


function gen_Result2(){
document.body.style.overflow = "scroll";
document.querySelector('#ps-click').disabled = true;

document.querySelector('#surveyAward').classList.remove('hid');

document.querySelector('#surveyAward').scrollIntoView();

}


function gen_Result3(){
document.body.style.overflow = "scroll";
document.querySelector('#pa-click').disabled = true;

document.querySelector('#activeAward').classList.remove('hid');

document.querySelector('#activeAward').scrollIntoView();

}




$(document).on('ready', function() {
      
    $(".regular-2").slick({
        dots: true,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1
      });

    });      


    </script>
<!-- code after conflicts : Priyanka (07-june-2024) -->

</body>
</html>