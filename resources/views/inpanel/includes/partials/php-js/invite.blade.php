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

        $welcome = shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.invite_refer.refer_friends.title')}}",
            text: "{{__('inpanel.page_guide.invite_refer.refer_friends.details')}}",
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
        shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.invite_refer.invite_friends.title')}}",
            text: "{{__('inpanel.page_guide.invite_refer.invite_friends.details')}}",
            attachTo: {element: '.invite_info', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.invite_refer.steps.title')}}",
            text: "{{__('inpanel.page_guide.invite_refer.refer_friends.details')}}",
            attachTo: {element: '.steps_invite_points', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
        shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.invite_refer.invitation_link.title')}}",
            text: "{{__('inpanel.page_guide.invite_refer.invitation_link.details')}}",
            attachTo: {element: '.invitation_link', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });
       $finish =  shepherd.addStep('Refer_Friend', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+"{{__('inpanel.page_guide.invite_refer.invitation_form.title')}}",
            text: "{{__('inpanel.page_guide.invite_refer.invitation_form.details')}}",
            attachTo: {element: '.invite_form', on: 'bottom'},
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
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','invite.refer')}}",headers);
        }
    </script>
@endpush
