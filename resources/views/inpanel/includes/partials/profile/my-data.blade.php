<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.my-data.title')}}
    </div>
    <div class="ibox-content export_data">
        {!! BootForm::vertical() !!}
        <p><strong>{!!__('inpanel.user.profile.preferences.my-data.accessing_details')!!}</strong></p>
        <p>{!!__('inpanel.user.profile.preferences.my-data.accessing_details_2')!!}</p>

        {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}

        {!! BootForm::submit(__('inpanel.user.profile.preferences.my-data.export_data')) !!}

        {!! BootForm::close() !!}
    </div>
</div>

@push('after-scripts')
    {{--@php

        $tour_detail = $user_add_data->user_tour_taken;
         $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='preferences.my-data' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
    @endphp
    <script>
    @if($tour_taken == 0)
@include('inpanel.includes.partials.php-js.my_data')
        @endif
    </script>--}}
@endpush
