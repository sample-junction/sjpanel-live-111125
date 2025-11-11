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

        shepherd.addStep('Preference', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+'Preference',
            text: 'Welcome To Preference Page',
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: 'Next'
                }
            ]
        });
        shepherd.addStep('Preference', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+'Basic Profile',
            text: 'By Selecting you can update your basic details.',
            attachTo: {element: '.basic_profile', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: 'Next'
                }
            ]
        });
        shepherd.addStep('Preference', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+'Password Update',
            text: 'By selecting this option you can easily update your password',
            attachTo: {element: '.password_change', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            buttons: [
                {
                    action: shepherd.next,
                    text: 'Next'
                }
            ]
        });
        shepherd.start();

    </script>
@endpush
