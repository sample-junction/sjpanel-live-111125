<span class="text-muted text-xs block nav-total_points" style="font-size: 16px">
    @php
		$user = Auth::user();
        if(session()->has('redeem_requests_points')){
            $redeem_points =  session()->get('redeem_requests_points');
        }else{
            $redeem_points = 0;
        } 
        $points = (!empty($global_user_points->user_points))?$global_user_points->user_points['completed'] - $redeem_points:0;
    @endphp
     @if(request()->route()->uri!='basic-detail' )
    <i class="fas fa-trophy"></i> {{__('inpanel.nav.sidebar_points', ['user_points' => $points])}} 
    @else
    <span class="small fw-bold text-primary p-2 rounded" style="background: #f6fbff;">{{$points}}</span>
    @endif
</span>

