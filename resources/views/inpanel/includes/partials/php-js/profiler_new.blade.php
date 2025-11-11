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
        
        // $welcome = shepherd.addStep('PENDING_PROFILES', {
        //     title: "{{__('inpanel.page_guide.details_profile.pending_profile.title')}}",
        //     text: "{{__('inpanel.page_guide.details_profile.pending_profile.details')}}",
        //     attachTo: {element: '.pending_profiles', on: 'right'},
        //     classes: 'shepherd shepherd-welcome',
        //     showCancelLink:true,
        //     buttons: [
        //         {
        //             action: function(){
        //                 changeTourOption();
        //                 shepherd.cancel();
        //             },
        //             text: "{{__('inpanel.page_guide.skip')}}"
        //         },
        //         {
        //             action: shepherd.next,
        //             text: "{{__('inpanel.page_guide.begin')}}"
        //         }
        //     ]
        // });

        shepherd.addStep('FILL_MY_PROFILE', {
            //title: "{{__('inpanel.page_guide.details_profile.fill_my_profile.title')}}",
            //text: "{{__('inpanel.page_guide.details_profile.fill_my_profile.details')}}",
            text: "Please click on highlited area and update the details",
            attachTo: {element: '.profile_rows:first-child', on: 'top'},
           // classes: 'shepherd shepherd-welcome',
            showCancelLink:true,
            buttons: [
                
               /* For Next button - uncomment this section, and redirect as per need*/
               /* {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }*/
            ]
        });

        $finish = shepherd.addStep('FINISH', {
            title: "{{__('inpanel.page_guide.details_profile.finish.title')}}",
            text: "{{__('inpanel.page_guide.details_profile.finish.details')}}",
            classes: 'shepherd shepherd-welcome',
            showCancelLink:false,
            buttons: [{
                action: function(){
                    changeTourOption();
                    shepherd.complete();
                },
                text: "{{__('inpanel.page_guide.finish')}}"
            }

            ]
        });
        console.log('outside final');
        
        function changeTourOption()
        {
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','detailed-profile')}}",headers);
        }

        $(document).ready(function () {
            shepherd.start();
        });

        //automating scrolling    
        setTimeout(printSomething, 500);
        function printSomething(){ 
            window.scrollTo(0,0,document.body.scrollHeight);
        }
    </script>
@endpush
