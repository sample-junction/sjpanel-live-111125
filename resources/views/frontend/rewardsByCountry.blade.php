@extends('frontend.layouts.rewards_app')
@section('content')

    @php
        $hasThisMonthProfileProdigy =
            isset($thisMonthWinners['profile_prodigy']) && !empty($thisMonthWinners['profile_prodigy']);
        $hasThisMonthSurveySuperstar =
            isset($thisMonthWinners['survey_superstar']) && !empty($thisMonthWinners['survey_superstar']);
        $hasThisMonthMostActivePanelist =
            isset($thisMonthWinners['most_active_panelist']) && !empty($thisMonthWinners['most_active_panelist']);

    @endphp

    {{-- previous month winners section start --}}
    @php
        $hasPreviousMonthData = !empty($previousMonthWinners);
        ob_start();
    @endphp

    <div class="col-6 col-lg shadow p-2 ps-5 pe-5 rounded-5 mt-4 text-center" style="height:400px; background:#752f9266">
        <p class="h4 text-custom fw-bold m-0 mb-3">{{ $previousMonthName }} Month Winners</p>
        <div class="row">
            <div class="col-12">

                @if (!empty($previousMonthWinners))
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($previousMonthWinners as $prev_month_winner)
                        @php
                            $i++;
                            $class = $i > 1 ? ' mt-3' : '';
                            $class .= $i % 2 == 0 ? ' bg-white' : ' bg-light';

                        @endphp
                        <div class="rounded-5 p-2 shadow {{ $class }}">
                            <p class="lead text-danger" style="font-weight:500; margin:0">
                                {{ $prev_month_winner['award_name'] }}</p>
                            <span class="small" style="font-weight:600">Name : <span
                                    style="font-weight:400">{{ $prev_month_winner['full_name'] }}</span></span>
                            <span class="small" style="font-weight:600">Panelist Id : <span
                                    style="font-weight:400">{{ $prev_month_winner['panellist_id'] }}</span></span>
                            <span class="small ms-2" style="font-weight:600">Amount : <span
                                    style="font-weight:400">{{ $prev_month_winner['amount'] }}</span></span>
                            <br>
                            <span class="small" style="font-weight:600">City & State : <span
                                    style="font-weight:400">{{ $prev_month_winner['location'] }}</span></span>
                            <span class="small ms-2" style="font-weight:600">Redemption status : <span
                                    style="font-weight:400">{{ $prev_month_winner['redemption_txt'] }}</span></span>
                        </div>
                    @endforeach
                @endif





                <?php /* 
                @if (isset($previousMonthWinners['profile_prodigy']) && !empty($previousMonthWinners['profile_prodigy']))
                    @php
                        $preProfileProdigy = $previousMonthWinners['profile_prodigy'];
                        $hasPreviousMonthData =true;
                    @endphp
                    <div class="rounded-5 p-2 bg-white shadow">
                        <p class="lead text-danger" style="font-weight:500; margin:0">Profile Prodigy</p>
                        <span class="small" style="font-weight:600">Name : <span style="font-weight:400">{{ $preProfileProdigy['full_name'] }}</span></span>
                        <span class="small" style="font-weight:600">Panelist Id : <span style="font-weight:400">{{ $preProfileProdigy['panellist_id'] }}</span></span>
                        <span class="small ms-2" style="font-weight:600">Amount : <span style="font-weight:400">{{ $preProfileProdigy['amount'] }}</span></span>
                        <br>
                        <span class="small" style="font-weight:600">City & State : <span style="font-weight:400">{{ $preProfileProdigy['location'] }}</span></span>
                        <span class="small ms-2" style="font-weight:600">Redemption status : <span style="font-weight:400">{{ $preProfileProdigy['redemption_txt'] }}</span></span>
                    </div>
                @endif

                @if (isset($previousMonthWinners['survey_superstar']) && !empty($previousMonthWinners['survey_superstar']))
                    @php
                        $preSurveySuperstar = $previousMonthWinners['survey_superstar'];
                        $hasPreviousMonthData =true;
                    @endphp

                    <div class="mt-3 rounded-5 p-2 shadow bg-light">
                        <p class="lead text-danger" style="font-weight:500; margin:0">Survey Superstar</p>
                        <span class="small" style="font-weight:600">Name : <span 
                                style="font-weight:400">{{ $preSurveySuperstar['full_name'] }}</span></span>
                        <span class="small" style="font-weight:600">Panelist Id : <span
                                style="font-weight:400">{{ $preSurveySuperstar['panellist_id'] }}</span></span>
                        <span class="small ms-2" style="font-weight:600">Amount : <span
                                style="font-weight:400">{{ $preSurveySuperstar['amount'] }}</span></span>
                        <br>
                        <span class="small" style="font-weight:600">City & State : <span
                                style="font-weight:400">{{ $preSurveySuperstar['location'] }}</span></span>
                        <span class="small ms-2" style="font-weight:600">Redemption status : <span
                                style="font-weight:400">{{ $preSurveySuperstar['redemption_txt'] }}</span></span>
                    </div>
                @endif

                @if (isset($previousMonthWinners['most_active_panelist']) && !empty($previousMonthWinners['most_active_panelist']))
                    @php
                        $preMostActivePanelist = $previousMonthWinners['most_active_panelist'];
                        $hasPreviousMonthData =true;
                    @endphp

                    <div class="mt-3 rounded-5 p-2 bg-white shadow">
                        <p class="lead text-danger" style="font-weight:500; margin:0">Most Active Panelist</p>
                        <span class="small" style="font-weight:600">Name : <span
                                style="font-weight:400">{{ $preMostActivePanelist['full_name'] }}</span></span>
                        <span class="small" style="font-weight:600">Panelist Id : <span
                                style="font-weight:400">{{ $preMostActivePanelist['panellist_id'] }}</span></span>
                        <span class="small ms-2" style="font-weight:600">Amount : <span
                                style="font-weight:400">{{ $preMostActivePanelist['amount'] }}</span></span>
                        <br>
                        <span class="small" style="font-weight:600">City & State : <span
                                style="font-weight:400">{{ $preMostActivePanelist['location'] }}</span></span>
                        <span class="small ms-2" style="font-weight:600">Redemption status : <span
                                style="font-weight:400">{{ $preMostActivePanelist['redemption_txt'] }}</span></span>

                    </div>
                @endif

                */
                ?>


            </div>
        </div>
    </div>

    @php
        $previousMonthWinnersSection = ob_get_clean();
        if (!$hasPreviousMonthData) {
            $previousMonthWinnersSection = '';
        }
    @endphp

    {{-- previous month winners section end --}}


    <div class="container-fluid p-0 m-0" style="overflow: hidden;">

        <div class="row" style="background: #ececec;">

            <!-- <div class="col text-center">

                        <img src="img/SJ Panel New LOGO without background.png" alt="logo" width="170px" class="img-fluid">

                    </div> -->

            {{-- <div class="col-12 p-0">
                <img src="{{ $bannerImage }}" alt="banner" class="img-fluid">
            </div> --}}
            
            <div class="col-12 p-0">
                <div class="image-section">
                    <img src="{{ $bannerImage }}" alt="Sample Image" class="banner_image">
                    <div class="image-text h3 fw-bold">
                         {{ strtoupper($thisMonthName)}}, {{$thisYear}} AWARD ANNOUCEMENT 
                    </div>
                </div>
            </div>

        </div>

        <div class="row pt-3 pb-3 border-bottom" style="background: #ececec;">

            <div class="col-6 col-lg text-center">

                <button class="tap-btn fil_active tab-about" onclick="contentLoader('about')">About Us</button>

            </div>

            @if (!empty($thisMonthWinners))
                @foreach ($thisMonthWinners as $item)
                    <div class="col-6 col-lg text-center">
                        <button class="tap-btn tab-{{ $item['award_type'] }}-award"
                            onclick="contentLoader('{{ $item['award_type'] }}-award')">{{ $item['award_name'] }}</button>
                    </div>
                @endforeach
            @endif

            <?php /*
            @if($hasThisMonthProfileProdigy)
            <div class="col-6 col-lg text-center">
                <button class="tap-btn tab-f-award" onclick="contentLoader('f-award')">Profile Prodigy</button>
            </div>
            @endif

            @if($hasThisMonthSurveySuperstar)
            <div class="col-6 col-lg mt-3 mt-lg-0 text-center">
                <button class="tap-btn tab-s-award" onclick="contentLoader('s-award')">Survey Superstar</button>
            </div>
            @endif

            @if($hasThisMonthMostActivePanelist)
            <div class="col-6 col-lg mt-3 mt-lg-0 text-center">
                <button class="tap-btn tab-t-award" onclick="contentLoader('t-award')">Most Active Panelist</button>
            </div>
            @endif
            */
            ?>

        </div>


        <div id="filter-content-data" class="container-fluid ps-5 pe-5 filter-content-data container-about" data-sr="about">
            <div class="row">
                <div class="col-11"></div>
                <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
                    <img src="{{ $countriesFlag }}" alt="image">
                </div>
            </div>
            <div class="row">

                <div class="col text-center mt-2 mt-lg-5">

                    <p class="h3 fw-bold">How <span class="pe-5 pb-2" style="background: #e9f6f1;">It Works</span></p>

                    <p class="lead mt-4" style="color:#343d488c; font-weight: 500; font-size: 16px;">Everything is simple
                    </p>

                </div>

            </div>


            <div class="row mt-4 ps-4 pe-4">

                <div class="col-3 d-none d-lg-block">

                    <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                        <span class="me-4" style="font-size: 52px; color:#CCE8FF">1</span><span><img
                                src="{{ asset('images/arrow1.png') }}" alt="icon" class="img-fluid"
                                style="transform: translateY(-14px);"></span>

                        <p class="fw-bold">Signup</p>

                        <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Register with us. Get confirmation
                            mail on your registered email id.</p>

                    </div>

                </div>

                <div class="col-3 d-none d-lg-block">

                    <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                        <span class="me-4" style="font-size: 52px; color:#FCD7D7">2</span><span><img
                                src="{{ asset('images/arrow2.png') }}" alt="icon" class="img-fluid"
                                style="transform: translateY(-14px);"></span>

                        <p class="fw-bold">Update Your Profile</p>

                        <p style="color: #343d488c; font-weight: 500; font-size: 15px;">We will send you profiler surveys
                            to
                            understand your interests and background.</p>

                    </div>

                </div>

                <div class="col-3 d-none d-lg-block">

                    <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                        <span class="me-4" style="font-size: 52px; color:#E2E0FF">3</span><span><img
                                src="{{ asset('images/arrow3.png') }}" alt="icon" class="img-fluid"
                                style="transform: translateY(-14px);"></span>

                        <p class="fw-bold">Take Survey And Earn Points</p>

                        <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Personalised surveys, quick
                            rewards:
                            Earn <span class="fw-bold">100-10,000</span> points instantly.</p>

                    </div>

                </div>

                <div class="col-3 d-none d-lg-block">

                    <div class="shadow rounded-3 ps-4 pe-4 pt-3 pb-3 info-box">

                        <span class="me-4" style="font-size: 52px; color:#DAF4DA">4</span>

                        <p class="fw-bold">Get Rewards</p>

                        <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Complete surveys, accumulate
                            points,
                            and when you reach <span class="fw-bold">{{ $thresholdPoints }} points</span>, redeem them for
                            rewards.</p>

                    </div>

                </div>



                <!-- CARDS FOR MOBILE -->


                <div class="col-12 d-lg-none">

                    <section class="regular-2 slider" style="margin:0 !important;">

                        <div class="border rounded-3 p-4 mob-card">

                            <span class="me-4" style="font-size: 52px; color:#CCE8FF">1</span><span><img
                                    src="{{ asset('images/arrow1.png') }}" alt="icon" class="img-fluid"
                                    style="transform: translateY(-14px);"></span>

                            <p class="fw-bold">Signup</p>

                            <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Register with us. Get login
                                credentials on your registered email id.</p>

                        </div>

                        <div class="border rounded-3 p-4 mob-card">

                            <span class="me-4" style="font-size: 52px; color:#FCD7D7">2</span><span><img
                                    src="{{ asset('images/arrow2.png') }}" alt="icon" class="img-fluid"
                                    style="transform: translateY(-14px);"></span>

                            <p class="fw-bold">Update Your Profile</p>

                            <p style="color: #343d488c; font-weight: 500; font-size: 15px;">We will send you profiler
                                surveys to understand your interests and background.</p>

                        </div>

                        <div class="border rounded-3 p-4 mob-card">

                            <span class="me-4" style="font-size: 52px; color:#E2E0FF">3</span><span><img
                                    src="{{ asset('images/arrow3.png') }}" alt="icon" class="img-fluid"
                                    style="transform: translateY(-14px);"></span>

                            <p class="fw-bold">Take Survey And Earn Points</p>

                            <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Personalised surveys, quick
                                rewards: Earn <span class="fw-bold">100-10,000</span> points instantly.</p>

                        </div>

                        <div class="border rounded-3 p-4 mob-card">

                            <span class="me-4" style="font-size: 52px; color:#DAF4DA">4</span>

                            <p class="fw-bold">Get Rewards</p>

                            <p style="color: #343d488c; font-weight: 500; font-size: 15px;">Complete surveys, accumulate
                                points, and when you reach <span class="fw-bold">{{ $thresholdPoints }} points</span>,
                                redeem them for
                                rewards.</p>

                        </div>


                    </section>

                </div>


            </div>

        </div>


        @if (!empty($thisMonthWinners))
            @foreach ($thisMonthWinners as $thisMonthWinner)
                @php
                    $prog = 'prog' . $thisMonthWinner['award_type'];
                    // $moveFunction = ($thisMonthWinner['award_type']>1)?'move'.$thisMonthWinner['award_type'].'()':'move()';
                @endphp

                <div id="filter-content-data"
                    class="container-fluid ps-5 pe-5 hid filter-content-data container-{{ $thisMonthWinner['award_type'] }}-award"
                    data-sr="{{ $thisMonthWinner['award_type'] }}-award">
                    <div class="row">
                        <div class="col-11"></div>
                        <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
                            <img src="{{ $countriesFlag }}" alt="image">
                        </div>
                    </div>
                    <div class="row">

                        {!! $previousMonthWinnersSection !!}

                        <div class="col-6 col-lg">
                            <div class="row">
                                <div class="col text-center mt-4">

                                    @php
                                        $badge = '';
                                        if (isset($awardTypeBadge[$thisMonthWinner['award_type']])) {
                                            $badge = $awardTypeBadge[$thisMonthWinner['award_type']];
                                        }

                                    @endphp

                                    <img src="{{ $badge }}" alt="Award Badge" class="img-fluid mb-3"
                                        width="170px">

                                    <p class="text-primary lead fw-bold mb-2">{{ $thisMonthWinner['award_name'] }}</p>

                                    <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span>
                                        <span>{{ $thisMonthWinner['points'] }} Points ({{ $thisMonthWinner['amount'] }})
                                        </span>
                                    </p>



                                    @if ($thisMonthWinner['award_type'] == 1)
                                        <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span>
                                            <span>Those who have completed all 8 profiles in {{ $thisMonthName }},
                                                {{ $thisYear }}</span></p>
                                    @endif
                                    @if ($thisMonthWinner['award_type'] == 2)
                                        <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span>
                                            <span>Those who have completed the surveys in {{ $thisMonthName }},
                                                {{ $thisYear }}</span></p>
                                    @endif
                                    @if ($thisMonthWinner['award_type'] == 3)
                                        <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span>
                                            <span>Attempted at least one surveys in {{ $thisMonthName }},
                                                {{ $thisYear }}</span></p>
                                    @endif



                                    <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span>
                                        <span>{{ $thisMonthWinner['nominations'] }}</span>
                                    </p>

                                    <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;"
                                        id="{{ $prog }}_click" onclick="new_move('{{ $prog }}')">Click
                                        Here</button>


                                    <div class="progress">
                                        <div class="progress-done {{ $prog }}" data-done="0">

                                        </div>
                                    </div>


                                    <div class="p-4 rounded-4 text-start mt-1 res-box hid"
                                        id="{{ $prog }}_section"
                                        style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">

                                        <p class="text-dark mb-1"><span class="fw-bold">Name :</span>
                                            <span>{{ $thisMonthWinner['full_name'] }}</span>
                                        </p>
                                        <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span>
                                            <span>{{ $thisMonthWinner['panellist_id'] }}</span>
                                        </p>
                                        <p class="text-dark mb-1"><span class="fw-bold">City & State :</span>
                                            <span>{{ $thisMonthWinner['location'] }}</span>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif





        <?php /*

        @if($hasThisMonthProfileProdigy)
        <div id="filter-content-data" class="container-fluid ps-5 pe-5 hid filter-content-data container-f-award" data-sr="f-award">
            <div class="row">
                <div class="col-11"></div>
                <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
                    <img src="{{ $countriesFlag }}" alt="image">
                </div>
            </div>
            <div class="row">

                {!! $previousMonthWinnersSection !!}
                
                <div class="col-6 col-lg">
                    <div class="row">
                        <div class="col text-center mt-4">

                            <img src="{{ asset('img/bronzebadge.png') }}" alt="icon" class="img-fluid mb-3"
                                width="170px">

                            <p class="text-primary lead fw-bold mb-2">Profile Prodigy</p>
                            @php
                                $profileProdigy = $thisMonthWinners['profile_prodigy'];
                            @endphp

                            <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>{{ $profileProdigy['points'] }}  Points ({{ $profileProdigy['amount'] }})  </span>
                            </p>
                            <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span> <span>Those who have
                                    completed all 8 profiles in {{ $thisMonthName }}, {{ $thisYear }}</span></p>
                            <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span> 
                                <span>{{ $profileProdigy['nominations'] }}</span></p>

                            <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" id="pp-click"
                                onclick="move()">Click Here</button>


                            <div class="progress">
                                <div class="progress-done prog1" data-done="0">

                                </div>
                            </div>


                            <div class="p-4 rounded-4 text-start mt-1 res-box hid" id="profileAward"
                                style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">

                                    <p class="text-dark mb-1"><span class="fw-bold">Name :</span>
                                        <span>{{ $profileProdigy['full_name'] }}</span>
                                    </p>
                                    <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span>
                                        <span>{{ $profileProdigy['panellist_id'] }}</span>
                                    </p>
                                    <p class="text-dark mb-1"><span class="fw-bold">City & State :</span>
                                        <span>{{ $profileProdigy['location'] }}</span>
                                    </p>                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($hasThisMonthSurveySuperstar)
        <div id="filter-content-data" class="container-fluid ps-5 pe-5 hid filter-content-data container-s-award" data-sr="s-award">
            <div class="row">
                <div class="col-11"></div>
                <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
                    <img src="{{ $countriesFlag }}" alt="image">
                </div>
            </div>
            <div class="row">

                {!! $previousMonthWinnersSection !!}

                <div class="col-6 col-lg">

                    <div class="row">

                        <div class="col text-center mt-4">

                            <img src="{{ asset('img/silverbadge.png') }}" alt="icon" class="img-fluid mb-3"
                                width="170px">

                            <p class="text-primary lead fw-bold mb-2">Survey Superstar</p>

                            @php
                                $surveySuperstar = $thisMonthWinners['survey_superstar'];
                            @endphp

                            {{-- <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>{{ $surveySuperstar['amount'] }} Gift Coupon</span></p> --}}
                            <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>{{ $surveySuperstar['points'] }}  Points ({{ $surveySuperstar['amount'] }})  </span></p>
                            <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span> <span>Those who have completed the surveys in {{ $thisMonthName }}, {{ $thisYear }}</span></p>
                            <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span>
                                <span>{{ $surveySuperstar['nominations'] }}</span>
                            </p>

                            <!-- <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" onclick="gen_Result(this,'profile')">Click Here</button> -->
                            <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" id="ps-click"
                                onclick="move2()">Click Here</button>


                            <div class="progress">
                                <div class="progress-done prog2" data-done="0">

                                </div>
                            </div>

                            <!--<div class="row rounded-5 p-2 mt-3 element-info mb-3"  style="box-shadow: 0px 5px 0px #191A23;">
                        <div class="col-10 col-lg-11 text-start" style="font-weight: 600;">Survey Superstar</div>
                        <div class="col-2 col-lg-1">
                            <img src="{{ asset('img/drop-icon.png') }}" alt="icon" class="img-fluid">
                        </div>
                    </div>-->


                            <div class="p-4 rounded-3 text-start mt-1 res-box hid" id="surveyAward"
                                style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">
                                
                                
                                <p class="text-dark mb-1"><span class="fw-bold">Name :</span>
                                    <span>{{ $surveySuperstar['full_name'] }}</span>
                                </p>
                                <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span>
                                    <span>{{ $surveySuperstar['panellist_id'] }}</span>
                                </p>
                                <p class="text-dark mb-1"><span class="fw-bold">City & State :</span>
                                    <span>{{ $surveySuperstar['location'] }}</span>
                                </p>
                                <!-- <p class="text-dark mb-1"><span class="fw-bold">Price Amount :</span> <span>$10</span></p> -->
                                
                            </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>
        @endif
    
        @if($hasThisMonthMostActivePanelist)
        <div id="filter-content-data" class="container-fluid ps-5 pe-5 hid filter-content-data container-t-award" data-sr="t-award">
            <div class="row">
                <div class="col-11"></div>
                <div class="col-1 gx-0 gy-0 shadow-sm p-2 mt-2 bg-white rounded text-center">
                    <img src="{{ $countriesFlag }}" alt="image">
                </div>
            </div>
            <div class="row">

                {!! $previousMonthWinnersSection !!}

                <div class="col-6 col-lg">

                    <div class="row">

                        <div class="col text-center mt-4">

                            <img src="{{ asset('img/goldbadge.png') }}" alt="icon" class="img-fluid mb-3"
                                width="170px">

                            <p class="text-primary lead fw-bold mb-2">Most Active Panelist</p>
                            @php
                                $mostActivePanelist = $thisMonthWinners['most_active_panelist'];
                            @endphp

                            {{-- <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>{{ $mostActivePanelist['amount'] }} Gift Coupon</span></p> --}}
                            <p class="text-primary mb-1"><span class="fw-bold">Prize Amount :</span> <span>{{ $mostActivePanelist['points'] }}  Points ({{ $mostActivePanelist['amount'] }})  </span></p>
                            <p class="text-primary mb-1"><span class="fw-bold">Requirement :</span> <span>Attempted most number of surveys in {{ $thisMonthName }}, {{ $thisYear }}</span></p>

                            <p class="text-primary mb-3"><span class="fw-bold">Total Nominations :</span>
                                <span>{{ $mostActivePanelist['nominations'] }}</span>
                            </p>

                            <!-- <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" onclick="gen_Result(this,'profile')">Click Here</button> -->
                            <button class="btn btn-primary ps-4 pe-4" style="font-size: 22px;" id="pa-click"
                                onclick="move3()">Click Here</button>


                            <div class="progress">
                                <div class="progress-done prog3" data-done="0">

                                </div>
                            </div>

                            <div class="p-4 rounded-4 text-start mt-1 res-box hid" id="activeAward"
                                style="width: 300px; margin-left: 50%; transform: translateX(-50%); border: 2px solid black;">
                                
                               
                                <p class="text-dark mb-1"><span class="fw-bold">Name :</span>
                                    <span>{{ $mostActivePanelist['full_name'] }}</span>
                                </p>
                                <p class="text-dark mb-1"><span class="fw-bold">Panelist ID :</span>
                                    <span>{{ $mostActivePanelist['panellist_id'] }}</span>
                                </p>
                                <p class="text-dark mb-1"><span class="fw-bold">City & State :</span>
                                    <span>{{ $mostActivePanelist['location'] }}</span>
                                </p>
                                <!-- <p class="text-dark mb-1"><span class="fw-bold">Price Amount :</span> <span>$10</span></p> -->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        */
        ?>



    @endsection

    @push('after-styles')
        <style>
            .hid {
                display: none;
            }

            .image-section {
                position: relative;
                /* width: 100%;
                height: 154px;
                overflow: hidden; */
            }

            .image-section .banner_image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 2rem;
                /* font-weight: bold; */
                /* text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); */
                height: 70%;
                display: flex;
                align-items: end;
            }
        </style>
    @endpush

    @push('after-scripts')
        <script>
            function executeDraw(str) {

                if (str == 'mpa') {
                    document.querySelector('#mapTotal').classList.remove('hid');
                    document.querySelector('#mapCon').classList.remove('hid');

                } else if (str == 'sp') {
                    document.querySelector('#spTotal').classList.remove('hid');
                    document.querySelector('#spCon').classList.remove('hid');

                } else if (str == 'pp') {
                    document.querySelector('#ppTotal').classList.remove('hid');
                    document.querySelector('#ppCon').classList.remove('hid');
                } else {
                    console.log('end');
                }

            }
        </script>
    @endpush
