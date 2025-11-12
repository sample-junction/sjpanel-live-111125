<!-- Himanshu (in popup file) 31-07-2025 -->
@php
$data = getWinningDataForLoggedInUser();
//dd($data);
$redeem_url = url('/redeem');

$locale = Auth::user()->locale;
$lang = null;

if ($locale && strpos($locale, '_') !== false) {
    list($lang, $c_code) = explode('_', $locale);
}

$popuCookieName = 'congrats_popup_cookie';
$today = now()->format('Y-m-d');

// need to show the popup once per day
$hasCookieSet = (isset($_COOKIE[$popuCookieName]) && $_COOKIE[$popuCookieName]==$today );
//$hasCookieSet =false;
@endphp

@if($data && !$hasCookieSet)
@push('after-styles')
<style>
    .reward-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .reward-popup-box {
        background: #fff;
        border-radius: 16px;
        width: 90%;
        max-width: 570px;
        padding: 30px 20px;
        text-align: center;
        position: relative;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .reward-popup-box .confetti {
        width: 90px;
        margin-bottom: 20px;
    }

    .reward-popup-box .close-reward-popup {
        position: absolute;
        top: 24px;
        right: 26px;
        width: 22px;
        cursor: pointer;
    }

    .reward-popup-box p {
        margin: 4px 0;
        font-size: 15px;
        color: #222;
    }

    .reward-popup-box p strong {
        font-weight: 700;
    }

    .reward-popup-box .redeem-button {
        background: linear-gradient(90deg, #3a7bfd, #4e5fff);
        color: white;
        font-weight: bold;
        border: none;
        padding: 12px 32px;
        font-size: 16px;
        border-radius: 12px;
        margin-top: 25px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        transition: 0.3s;
    }

    .reward-popup-box .redeem-button:hover {
        opacity: 0.95;
    }
</style>
@endpush

<!-- <div class="reward-overlay" id="rewardPopup">
    <div class="reward-popup-box">
        <img src="{{ asset('img/inpanel/firework.png') }}" class="confetti" alt="🎉">
        <img src="{{ asset('img/inpanel/close__1.svg') }}" class="close-reward-popup" alt="X">


        <p><strong>Congratulations</strong> on winning {{ now()->subMonth()->format('F') }} month’s</p>
        <p><strong>{{ $data->award_name }} Award!</strong></p>
        <p><strong>{{ $data->points }} points ({{ $data->amount }})</strong> credited to your SJ Panel account. Email sent on <strong>{{\Carbon\Carbon::parse($data->amount_credited_date)->format('j M Y')}}</strong> </p>
        <p><strong>Claim your reward points now:</strong></p>

        <button class="redeem-button" onclick="window.location.href='{{ $redeem_url }}'">Redeem</button>
    </div>
</div> -->

<div class="reward-overlay" id="rewardPopup">
    <div class="reward-popup-box">
        <img src="{{ asset('img/inpanel/firework.png') }}" class="confetti" alt="🎉">
        <img src="{{ asset('img/inpanel/close__1.svg') }}" class="close-reward-popup" alt="X">
        @php 
            $pointsArr =[
                'points' => $data->points,
                'amount' => $data->amount,
                'date'   => \Carbon\Carbon::parse($data->amount_credited_date)->format('j M Y')
            ]; 

            $hindi_award = [
                '1'=>'प्रोफ़ाइल विलक्षण पुरस्कार',
                '2'=>'सर्वेक्षण सुपरस्टार पुरस्कार',
                '3'=>'सबसे सक्रिय पैनलिस्ट पुरस्कार'
            ];
            $award_name = 'inpanel.award_name.'.$data->award_type;
        @endphp

        @if($lang == 'hi')

            <p><strong>बधाई हो !</strong> {{ now()->subMonth()->format('F') }} महीने का </p>
            <p><strong>{{ __($award_name) }}</strong> जीतने पर l </p>
            <p><strong>{{ $pointsArr['points'] }} पॉइंट ({{ $pointsArr['amount'] }})</strong> आपके एसजे पैनल खाते में जमा हो गए हैं। ईमेल <strong>{{ $pointsArr['date'] }}</strong> को भेजा गया हैं। </p>
            <p><strong>अपने रिवॉर्ड पॉइंट अभी प्राप्त करें:<strong> </p>

        @else

            <p>
                <strong>{{ __('inpanel.congrats_award_popup.congratulations') }}</strong>
                {{ __('inpanel.congrats_award_popup.on_winning', ['month' => now()->subMonth()->format('F')]) }}
            </p>
            <p><strong>{{ __('inpanel.congrats_award_popup.award_name', ['award' => __($award_name)]) }}</strong></p>
            <p>
                {!! __('inpanel.congrats_award_popup.credited', $pointsArr) !!}
            </p>
            <p><strong>{{ __('inpanel.congrats_award_popup.claim') }}</strong></p>
        @endif

        <button class="redeem-button" onclick="window.location.href='{{ $redeem_url }}'"> {{ __('inpanel.congrats_award_popup.redeem') }} </button>
    </div>
</div>


@push('after-scripts')
<script>
    document.querySelectorAll('.close-reward-popup').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('rewardPopup').style.display = 'none';
        });
    });

    const expires = new Date();
    expires.setHours(24, 0, 0, 0); // Set to midnight tonight
    document.cookie = "{{ $popuCookieName }}={{ $today }}; expires=" + expires.toUTCString() + "; path=/";

</script>
@endpush

@endif