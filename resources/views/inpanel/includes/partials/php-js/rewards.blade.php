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

        $welcome = shepherd.addStep('Reward_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.reward_points.welcome.title')}}",
            text: "{{__('inpanel.page_guide.reward_points.welcome.details')}}",
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: function(){
                        changeTourOption();
                        shepherd.cancel();
                    },
                    text:"{{__('inpanel.page_guide.skip')}}"
                },
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.begin')}}"
                }
            ]
        });
        shepherd.addStep('Reward_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.reward_points.total_points.title')}}",
            text: "{{__('inpanel.page_guide.reward_points.total_points.details')}}",
            attachTo: {element: '.reward_total_points', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        shepherd.addStep('Reward_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.reward_points.detailed_summary.title')}}",
            text: "{{__('inpanel.page_guide.reward_points.detailed_summary.details')}}",
            attachTo: {element: '.detailed_point_summary', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        shepherd.addStep('Reward_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.reward_points.pending_points.title')}}",
            text: "{{__('inpanel.page_guide.reward_points.pending_points.details')}}",
            attachTo: {element: '.reward_pending_points', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        /*shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+'Rejected Points',
            text: 'Here you can see all your rejected points you have till now.',
            attachTo: {element: '.invite_form', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: 'Next'
                }
            ]
        });*/
        $finish = shepherd.addStep('Reward_Points', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.reward_points.recent_details.title')}}",
            text: "{{__('inpanel.page_guide.reward_points.recent_details.details')}}",
            attachTo: {element: '.recent_details', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
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
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','rewards')}}",headers);
        }
    </script>
@endpush
