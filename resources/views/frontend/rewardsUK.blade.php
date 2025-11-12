@extends('frontend.layouts.rewards_app')


@push('after-styles')

<style>

.surveyy{
    display: none !important;
}
</style>   

@endpush

@section('content')


<div class="container-fluid p-0 m-0">

<div class="row" style="background: #ececec;">

   <!-- <div class="col text-center">

        <img src="img/SJ Panel New LOGO without background.png" alt="logo" width="170px" class="img-fluid">

    </div> -->

    <div class="col-12 p-0">

        <img src="{{asset('img/May_25_Banner_reward Page.png')}}" alt="banner" class="img-fluid">

    </div>

</div>

<div class="row pt-3 pb-3 border-bottom" style="background: #ececec;">

    <div class="col-6 col-lg-3 text-center">
        <button class="tap-btn fil_active" onclick="contentLoader('about')">About Us</button>

    </div>
    <div class="col-6 col-lg-3 text-center">
 <button class="tap-btn" onclick="contentLoader('f-award')">Profile Prodigy</button>

    </div>
    <div class="col-6 col-lg-3 mt-3 mt-lg-0 text-center surveyy" style="display:block">


        <button class="tap-btn" onclick="contentLoader('s-award')">Survey Superstar</button>

    </div>

    <div class="col-6 col-lg-3 mt-3 mt-lg-0 text-center">

        <button class="tap-btn" onclick="contentLoader('t-award')">Most Active Panelist</button>

    </div>

</div>





<div id="filter-content-data" class="container-fluid ps-5 pe-5" data-sr="about">
<div class="row">
        <div class="col-11"></div>
        <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
            <img src="{{asset('img/UK_Flag.png')}}" alt="image">
        </div>
    </div>
    <div class="row">

        <div class="col text-center mt-2 mt-lg-5">

            <p class="h3 fw-bold">How <span class="pe-5 pb-2" style="background: #e9f6f1;">It Works</span></p>

            <p class="lead mt-4" style="color:#343d488c; font-weight: 500; font-size: 16px;">Everything is simple</p>

        </div>

    </div>


    <div class="row mt-4 ps-4 pe-4">

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                <span class="me-4" style="font-size: 52px; color:#CCE8FF">1</span><span><img src="{{asset('images/arrow1.png')}}" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">Signup</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Register with us. Get confirmation mail on your registered email id.</p>

            </div>

        </div>

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                <span class="me-4" style="font-size: 52px; color:#FCD7D7">2</span><span><img src="{{asset('images/arrow2.png')}}" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">Update Your Profile</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">We will send you profiler surveys to understand your interests and background.</p>

            </div>

        </div>

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                <span class="me-4" style="font-size: 52px; color:#E2E0FF">3</span><span><img src="{{asset('images/arrow3.png')}}" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">Take Survey And Earn Points</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Personalised surveys, quick rewards: Earn <span class="fw-bold">100-10,000</span> points instantly.</p>

            </div>

        </div>

        <div class="col-3 d-none d-lg-block">

            <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                <span class="me-4" style="font-size: 52px; color:#DAF4DA">4</span>

                <p class="fw-bold">Get Rewards</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Complete surveys, accumulate points, and when you reach <span class="fw-bold">6500 points</span>, redeem them for rewards.</p>

            </div>

        </div>



    <!-- CARDS FOR MOBILE -->


    <div class="col-12 d-lg-none">

        <section class="regular-2 slider" style="margin:0 !important;">

            <div class="border rounded-3 p-4 mob-card">

                <span class="me-4" style="font-size: 52px; color:#CCE8FF">1</span><span><img src="{{asset('images/arrow1.png')}}" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">Signup</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Register with us. Get login credentials on your registered email id.</p>

            </div>

            <div class="border rounded-3 p-4 mob-card">

                <span class="me-4" style="font-size: 52px; color:#FCD7D7">2</span><span><img src="{{asset('images/arrow2.png')}}" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">Update Your Profile</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">We will send you profiler surveys to understand your interests and background.</p>

            </div>

            <div class="border rounded-3 p-4 mob-card">

                <span class="me-4" style="font-size: 52px; color:#E2E0FF">3</span><span><img src="{{asset('images/arrow3.png')}}" alt="icon" class="img-fluid" style="transform: translateY(-14px);"></span>

                <p class="fw-bold">Take Survey And Earn Points</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Personalised surveys, quick rewards: Earn <span class="fw-bold">100-10,000</span> points instantly.</p>

            </div>

            <div class="border rounded-3 p-4 mob-card">

                <span class="me-4" style="font-size: 52px; color:#DAF4DA">4</span>

                <p class="fw-bold">Get Rewards</p>

                <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Complete surveys, accumulate points, and when you reach <span class="fw-bold">6500 points</span>, redeem them for rewards.</p>

            </div>


        </section>

    </div>


    </div>

</div>





<div id="filter-content-data" class="container-fluid ps-5 pe-5 hid" data-sr="f-award">
<div class="row">
        <div class="col-11"></div>
        <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
            <img src="{{asset('img/UK_Flag.png')}}" alt="image">
        </div>
    </div>
    <div class="row">
    
        <div class="col-6 shadow p-2 ps-5 pe-5 rounded-5 mt-4 text-center" style="height:400px; background:#752f9266">

        <p class="h4 text-custom fw-bold m-0 mb-3">April Month Winners</p>

        <div class="row">

            <div class="col-12">

                <div class="rounded-5 p-2 bg-white shadow">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Profile Prodigy</p>

                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">Abraham Azi</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">250417550011</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£10</span></span>
                    <br>
                    <span class="small" style="font-weight:600">City & State : <span style="font-weight:400">Littlehampton, West Sussex</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Yet to be redeemed</span></span>


                </div>

                {{--<div class="mt-3 rounded-5 p-2 shadow bg-light">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Survey Superstar</p>



                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">Geoff Wheatley</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">241019370008</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£15</span></span>
                    <br>
                    <span class="small ms-2" style="font-weight:600">City & State : <span style="font-weight:400">Chelmsford, Essex</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Redeemed on 4/16/2025</span></span>
                </div>--}}
                <div class="mt-3 rounded-5 p-2 bg-white shadow">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Most Active Panelist</p>

                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">kern Amofa</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">250301110078</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£20</span></span>
                    <br>
                    <span class="small ms-2" style="font-weight:600">City & State : <span style="font-weight:400">Nottingham, Nottinghamshire</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Yet to be redeemed</span></span>

                </div>

            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="row">
    

        <div class="col text-center mt-4">

            <img src="{{asset('img/bronzebadge.png')}}" alt="icon" class="img-fluid mb-3" width="170px">
            
            <p class="text-primary lead fw-bold mb-2">Profile Prodigy</p>
            <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>13,000 Points ( £10)</span></p>
            <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span> <span>Those who have completed all 8 profiles in May, 2025</span></p>
            <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span> <span>1167</span></p>
            <!-- <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" onclick="gen_Result(this,'profile')">Click Here</button> -->
            <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" id="pp-click" onclick="move()">Click Here</button>

            
            <div class="progress">
                <div class="progress-done prog1" data-done="0">
                    
                </div>
            </div>

            <!--<div class="row rounded-5 p-2 mt-3 element-info mb-3"  style="box-shadow: 0px 5px 0px #191A23;">
                <div class="col-10 col-lg-11 text-start" style="font-weight: 600;">Profile Prodigy</div>
                <div class="col-2 col-lg-1">                    
                    <img src="{{asset('img/drop-icon.png')}}" alt="icon" class="img-fluid">
                </div>
            </div>-->


            <div class="p-4 rounded-4 text-start mt-1 res-box hid" id="profileAward" style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">

                <p class="text-dark mb-1"><span class="fw-bold">Name :</span> <span>Gillian Barry</span></p>
                <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span> <span>250507160005</span></p>
                <p class="text-dark mb-1"><span class="fw-bold">City & State :</span> <span>Felixstowe, Suffolk</span></p>
                <!-- <p class="text-dark mb-1"><span class="fw-bold">Price Amount :</span> <span>$10</span></p> -->

            </div>


        </div>

    </div>
    </div>
    </div>

</div>



<div id="filter-content-data" class="container-fluid ps-5 pe-5 hid" data-sr="s-award">
<div class="row">
        <div class="col-11"></div>
        <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
            <img src="{{asset('img/UK_Flag.png')}}" alt="image">
        </div>
    </div>
    <div class="row">
    
        <div class="col-6 shadow p-2 ps-5 pe-5 rounded-5 mt-4 text-center" style="height:400px; background:#752f9266">

        <p class="h4 text-custom fw-bold m-0 mb-3">April Month Winners</p>

       <div class="row">

            <div class="col-12">

                <div class="rounded-5 p-2 bg-white shadow">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Profile Prodigy</p>

                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">Abraham Azi</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">250417550011</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£10</span></span>
                    <br>
                    <span class="small" style="font-weight:600">City & State : <span style="font-weight:400">Littlehampton, West Sussex</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Yet to be redeemed</span></span>


                </div>

                {{--<div class="mt-3 rounded-5 p-2 shadow bg-light">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Survey Superstar</p>



                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">Geoff Wheatley</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">241019370008</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£15</span></span>
                    <br>
                    <span class="small ms-2" style="font-weight:600">City & State : <span style="font-weight:400">Chelmsford, Essex</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Redeemed on 4/16/2025</span></span>
                </div>--}}


                <div class="mt-3 rounded-5 p-2 bg-white shadow">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Most Active Panelist</p>

                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">kern Amofa</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">250301110078</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£20</span></span>
                    <br>
                    <span class="small ms-2" style="font-weight:600">City & State : <span style="font-weight:400">Nottingham, Nottinghamshire</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Yet to be redeemed</span></span>

                </div>

            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="row">

        <div class="col text-center mt-4">

            <img src="{{asset('img/silverbadge.png')}}" alt="icon" class="img-fluid mb-3" width="170px">
            
            <p class="text-primary lead fw-bold mb-2">Survey Superstar</p>

            <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>19,500 points (£15)</span></p>
            <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span> <span>Those who have completed the surveys in May, 2025</span></p>
            <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span> <span>10298</span></p>


            <!-- <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" onclick="gen_Result(this,'profile')">Click Here</button> -->
            <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" id="ps-click" onclick="move2()">Click Here</button>

            
            <div class="progress">
                <div class="progress-done prog2" data-done="0">
                    
                </div>
            </div>

            <!--<div class="row rounded-5 p-2 mt-3 element-info mb-3"  style="box-shadow: 0px 5px 0px #191A23;">
                <div class="col-10 col-lg-11 text-start" style="font-weight: 600;">Survey Superstar</div>
                <div class="col-2 col-lg-1">                    
                    <img src="{{asset('img/drop-icon.png')}}" alt="icon" class="img-fluid">
                </div>
            </div>-->


            <div class="p-4 rounded-3 text-start mt-1 res-box hid" id="surveyAward" style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">


                <p class="text-dark mb-1"><span class="fw-bold">Name :</span> <span>George Edward</span></p>
                <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span> <span>241017380008</span></p>
                <p class="text-dark mb-1"><span class="fw-bold">City & State :</span> <span>Birmingham, West Midlands</span></p>

                <!-- <p class="text-dark mb-1"><span class="fw-bold">Price Amount :</span> <span>$10</span></p> -->

            </div>


        </div>
        </div>
        </div>

    </div>

</div>



<div id="filter-content-data" class="container-fluid ps-5 pe-5 hid" data-sr="t-award">
<div class="row">
        <div class="col-11"></div>
        <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
            <img src="{{asset('img/UK_Flag.png')}}" alt="image">
        </div>
    </div>
    <div class="row">
    
       <div class="col-6 shadow p-2 ps-5 pe-5 rounded-5 mt-4 text-center" style="height:400px; background:#752f9266">

       <p class="h4 text-custom fw-bold m-0 mb-3">April Month Winners</p>
        <div class="row">


            <div class="col-12">

                <div class="rounded-5 p-2 bg-white shadow">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Profile Prodigy</p>

                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">Abraham Azi</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">250417550011</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£10</span></span>
                    <br>
                    <span class="small" style="font-weight:600">City & State : <span style="font-weight:400">Littlehampton, West Sussex</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Yet to be redeemed</span></span>


                </div>

                {{--<div class="mt-3 rounded-5 p-2 shadow bg-light">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Survey Superstar</p>



                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">Geoff Wheatley</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">241019370008</span></span>
                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£15</span></span>
                    <br>
                    <span class="small ms-2" style="font-weight:600">City & State : <span style="font-weight:400">Chelmsford, Essex</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Redeemed on 4/16/2025</span></span>


                </div>--}}


                <div class="mt-3 rounded-5 p-2 bg-white shadow">

                    <p class="lead text-danger" style="font-weight:500; margin:0">Most Active Panelist</p>


                    <span class="small" style="font-weight:600">Name : <span style="font-weight:400">kern Amofa</span></span>
                    <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">250301110078</span></span>

                    <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">£20</span></span>
                    <br>
                    <span class="small ms-2" style="font-weight:600">City & State : <span style="font-weight:400">Nottingham, Nottinghamshire</span></span>
                    <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">Yet to be redeemed</span></span>

                </div>

            </div>

        </div>


    </div>

    <div class="col-6">

        <div class="row">

        <div class="col text-center mt-4">

            <img src="{{asset('img/goldbadge.png')}}" alt="icon" class="img-fluid mb-3" width="170px">
            
            <p class="text-primary lead fw-bold mb-2">Most Active Panelist</p>


            <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>26,000 Points ( £20)</span></p>
            <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span> <span>Attempted most number of surveys in May, 2025</span></p>
            <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span> <span>88701</span></p>

            <!-- <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" onclick="gen_Result(this,'profile')">Click Here</button> -->
            <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" id="pa-click" onclick="move3()">Click Here</button>

            
            <div class="progress">
                <div class="progress-done prog3" data-done="0">
                    
                </div>
            </div>

            <!--<div class="row rounded-5 p-2 mt-3 element-info mb-3"  style="box-shadow: 0px 5px 0px #191A23;">
                <div class="col-10 col-lg-11 text-start" style="font-weight: 600;">Most Active Panelist</div>
                <div class="col-2 col-lg-1">                    
                    <img src="{{asset('img/drop-icon.png')}}" alt="icon" class="img-fluid">
                </div>
            </div>-->


            <div class="p-4 rounded-4 text-start mt-1 res-box hid" id="activeAward" style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">
                <p class="text-dark mb-1"><span class="fw-bold">Name :</span> <span>Donna Flavell</span></p>
                <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span> <span>250301290073</span></p>
                <p class="text-dark mb-1"><span class="fw-bold">City & State :</span> <span>Lowestoft, Suffolk</span></p>

                <!-- <p class="text-dark mb-1"><span class="fw-bold">Price Amount :</span> <span>$10</span></p> -->

            </div>


        </div>
        </div>
        </div>

    </div>

</div>



@endsection

@push('after-styles')

<style>

.hid{
    display: none;
}

.surveyy{
    display: none;
}

</style>   

@endpush

@push('after-scripts')

<script>

function executeDraw(str){

    if(str == 'mpa'){
        document.querySelector('#mapTotal').classList.remove('hid');
        document.querySelector('#mapCon').classList.remove('hid');

    }else if(str == 'sp'){
        document.querySelector('#spTotal').classList.remove('hid');
        document.querySelector('#spCon').classList.remove('hid');

    }else if(str == 'pp'){
        document.querySelector('#ppTotal').classList.remove('hid');
        document.querySelector('#ppCon').classList.remove('hid');
    }else{
        console.log('end');
    }

}

</script>
    


@endpush
