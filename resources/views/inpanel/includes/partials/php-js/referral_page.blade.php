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

        $welcome = shepherd.addStep('Referral', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.referral_page.welcome.title')}}",
            text: "{{__('inpanel.page_guide.referral_page.welcome.details')}}",
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
                    text: "{{__('inpanel.page_guide.begin')}}"
                }
            ]
        });

        shepherd.addStep('Referral', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.referral_page.search.title')}}",
            text: "{{__('inpanel.page_guide.referral_page.search.details')}}",
            attachTo: {element: '.search_referral', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        $finish =  shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.referral_page.referral_details.title')}}",
            text: "{{__('inpanel.page_guide.referral_page.referral_details.details')}}",
            attachTo: {element: '.referral_details', on: 'bottom'},
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
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','invite.my-referral')}}",headers);
        }


    </script>
@endpush
