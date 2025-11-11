@push('after-styles')
    <link href="{{asset('vendor/css/plugins/shepherd/shepherd-theme-default.css')}}" rel="stylesheet">
    <style>
        .shepherd-element .shepherd-content header .shepherd-title{
            color: rgb(255, 255, 255);
        }

        .shepherd-element.shepherd-has-title .shepherd-content header{
            background: #3288e6;
        }
        .shepherd-element .shepherd-content{
            border-radius: 7px;
        }
    </style>
@endpush
@push('after-scripts')
    <script src="{{asset('vendor/js/plugins/shepherd/shepherd.js')}}"></script>
    <script>
        const shepherd = new Shepherd.Tour({
            defaultStepOptions: {
                scrollTo: true,
                showCancelLink: true
            },
            useModalOverlay: true
        });

        /*
        * POINTS INTRO
        * */

       $welcome =  shepherd.addStep('Redeem_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.redeem_points.welcome.title')}}",
            text: "{{__('inpanel.page_guide.redeem_points.welcome.details')}}",
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: function(){
                        changeTourOption();
                        shepherd.cancel();
                    },
                    text: "{{__('inpanel.page_guide.skip')}}"
                },
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        $finish = shepherd.addStep('Redeem_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.redeem_points.redeem_points_progress.title')}}",
            text: "{{__('inpanel.page_guide.redeem_points.redeem_points_progress.title')}}",
            attachTo: {element: '.progress_bar', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            showCancelLink:false,
            buttons: [
                {
                    action: function(){
                        changeTourOption();
                        shepherd.complete();
                    },
                    text: "{{__('inpanel.page_guide.finish')}}"
                }
            ]
        });
        shepherd.start();

        function changeTourOption()
        {
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','redeem-points')}}",headers);
        }
    </script>
@endpush
