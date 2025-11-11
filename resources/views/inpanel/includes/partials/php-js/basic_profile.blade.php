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

        $welcome = shepherd.addStep('Basic_Profile', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.basic_details_guide.welcome.title')}}",
            text: "{{__('inpanel.page_guide.basic_details_guide.welcome.details')}}",
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: function(){
                        changeTourOption();
                        shepherd.cancel();
                    },
                    text: "{{__('inpanel.page_guide.skip')}}",
                    on:'left',
                },
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.begin')}}"
                }
            ]
        });
        $finish =  shepherd.addStep('Basic_Profile_Form', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+ "{{__('inpanel.page_guide.basic_details_guide.form.title')}}",
            text: "{{__('inpanel.page_guide.basic_details_guide.form.details')}}",
            attachTo: {element: '.basic_profile_form', on: 'bottom'},
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
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection', 'preferences.basic-profile')}}",headers);
        }
    </script>
@endpush

