<!DOCTYPE html>
<html dir="@yield('direction', 'ltr')">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{$title}}</title>
        <meta name="description" content="('meta_description', 'Samppoint Page')">
        <meta name="author" content="('meta_author', 'SJ')">
        <link href="{{asset('end/end.css')}}" rel='stylesheet' type='text/css' media="all" />
       
        
    </head>
    <body class="" onload="@yield('body-load', '')">
        @yield('content')


       
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>

    var timeleft = '{{$redirectTime}}';//set in second
    var downloadTimer = setInterval(function(){
    if(timeleft <= 0){
        clearInterval(downloadTimer);
        //document.getElementById("countdown").innerHTML = "Finished";
        location.href = "{{url('dashboard')}}";
    } else {
        document.getElementById("countdown").innerHTML = "<b>"+timeleft + " {{__('cms.surveys.countdown_text')}}</b>";
    }
    timeleft -= 1;
    }, 1000);
</script>
