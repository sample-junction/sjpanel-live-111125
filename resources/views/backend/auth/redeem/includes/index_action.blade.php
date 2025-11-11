<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       Actions
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @if(empty($redeem->approve))
         <a class="dropdown-item" href="{{route('admin.auth.approve.redeem_points',[$redeem->user_uuid,$redeem->id])}}" >Approve</a>
         @elseif(empty($redeem->ribbon_notified))
         <!-- <a class="dropdown-item" href="{{route('admin.auth.ribbon_notified.redeem_points',[$redeem->user_uuid,$redeem->id])}}">Rybbon Notified</a> -->
         <a class="dropdown-item" href="javascript:void(0);" onclick="clickdata('    {{route('admin.auth.ribbon_notified.redeem_points',[$redeem->user_uuid,$redeem->id])}}')">Rybbon Notified</a>
         @elseif(empty($redeem->coupon_sent))
         <a class="dropdown-item" href="{{route('admin.auth.coupon_sent.redeem_points',[$redeem->user_uuid,$redeem->id])}}">Coupon Send</a>
         @elseif(empty($redeem->coupon_redeemed))
         <a class="dropdown-item" href="{{route('admin.auth.coupon_redeem.redeem_points',[$redeem->user_uuid,$redeem->id])}}">Coupon Redeem</a>

         <a class="dropdown-item" href="{{route('admin.auth.coupon_lapsed',[$redeem->user_uuid,$redeem->id])}}">Coupon Lapsed</a>

         @endif
    </div>
</div>
