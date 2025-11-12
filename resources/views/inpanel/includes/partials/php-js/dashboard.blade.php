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
        const minWidth = 220;
        const maxWidth = 990;
        const screenWidth = window.innerWidth;
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

        /*shepherd.addStep('TOTAL_POINTS', {
            title: "<i class=\"em em-gift\"></i>&nbsp;"+ "{{__('inpanel.page_guide.dashboard.total_points.title')}}",
            text: "{{__('inpanel.page_guide.dashboard.total_points.details')}}",
            attachTo: {element: '.total_points', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            showCancelLink:false,
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });*/
        shepherd.addStep('TOTAL_POINTS_NAV', {
    //text: "{{__('inpanel.page_guide.dashboard.total_points_nav.details')}}",
    title: "<i class=\"em em-gift\"></i>&nbsp;" + "{{__('inpanel.page_guide.dashboard.total_points.title')}}",
    text: "{{__('inpanel.page_guide.dashboard.total_points.details')}}",
    attachTo: getAttachToPosition(),
    tether: {attachment: 'left', targetAttachment: 'right'},
    classes: 'shepherd shepherd-welcome',
    showCancelLink: true,
    buttons: [
        {
            action: shepherd.next,
            text: "{{__('inpanel.page_guide.next')}}"
        }
    ]
});

function getAttachToPosition() {
    
    if (screenWidth >= minWidth && screenWidth <= maxWidth) {
        
        return { element: '#Reedem_Points', on: 'top'  };
    } else {
        return { element: '#Reedem_Points', on: 'left' };
    }
}


        shepherd.addStep('AVAILABLE_SURVEYS', {
            title: "&nbsp;"+ "{{__('inpanel.page_guide.dashboard.available_survey.title')}}",
            text: "{{__('inpanel.page_guide.dashboard.available_survey.details')}}",
            attachTo: getSurveyPosition(),
			tether: {attachment: 'left', targetAttachment: 'right'},
            classes: 'shepherd shepherd-welcome',
            showCancelLink:true,
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });

        function getSurveyPosition() {
            if (screenWidth >= minWidth && screenWidth <= maxWidth) {
                return { element: '#survey_sec', on: 'top'  };
            } else {
                return { element: '#survey_sec', on: 'left' };
            }
        }

        shepherd.addStep('COMPLETED_SURVEYS', {
            text: "{{__('inpanel.page_guide.dashboard.completed_surveys.details')}}",
            attachTo: getSurveyPosition1(),
			tether: {attachment: 'left', targetAttachment: 'right'},
            classes: 'shepherd shepherd-welcome',
            showCancelLink:true,
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ],
            
            
        });

                function getSurveyPosition1() {
                    if (screenWidth >= minWidth && screenWidth <= maxWidth) {
                        return { element: '#survey_sec', on: 'top'  };
                    } else {
                        return { element: '#survey_sec', on: 'left' };
                    }
                }

        shepherd.addStep('PROFILE_METRE', {
            title: "{{__('inpanel.page_guide.dashboard.profile_meter.title')}}",
            text: "{{__('inpanel.page_guide.dashboard.profile_meter.details')}}",
            attachTo: getDetailprofile(),
            classes: 'shepherd shepherd-welcome',
            beforeShowPromise: function(){
                if (window.innerWidth >= 220 && window.innerWidth <= 990){
                    document.getElementById("offcanvasNavbar").classList.remove("show");
                }
                return Promise.resolve();
            },
            showCancelLink:true,
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ],
            
        });

function getDetailprofile() {
    if (screenWidth >= minWidth && screenWidth <= maxWidth) {
        return { element: '#detailed_progress_graph', on: 'top' };
    } else {
        return { element: '#detailed_progress_Graph_2', on: 'right' };
    }
    
}



       /* shepherd.addStep('RECENT_ACTIVITIES', {
            title: "{{__('inpanel.page_guide.dashboard.recent_activity.title')}}",
            text: "{{__('inpanel.page_guide.dashboard.recent_activity.details')}}",
            attachTo: {element: '.recent_activity_box', on: 'bottom'},
            classes: 'shepherd shepherd-welcome',
            showCancelLink:false,
            buttons: [
                {
                    action: shepherd.next,
                    text: "{{__('inpanel.page_guide.next')}}"
                }
            ]
        });*/
		shepherd.addStep('DETAILED_PROFILE_NAV', {
            id: "final_step",
            title: "{{__('inpanel.page_guide.dashboard.detail_profile_nav.title')}}",
            text: "{{__('inpanel.page_guide.dashboard.detail_profile_nav.details') }}"+
                "<br/><b>{{__('inpanel.page_guide.dashboard.detail_profile_nav.details_1')}}</b>",
            attachTo: getDetailprofileNav(),
			tether: {attachment: 'left', targetAttachment: 'right'},
            classes: 'shepherd shepherd-welcome',
            beforeShowPromise: ()=>{
                if (window.innerWidth >= 220 && window.innerWidth <= 990){
                    const sidebar = document.getElementById("offcanvasNavbar");
                    sidebar.classList.add('show');
                    return new Promise((resolve)=>{
                        setTimeout(() => {
                            resolve();
                        }, 500);
                    });
                }else{
                    return Promise.resolve();
                }
                
            },
            showCancelLink:true,
            buttons: [
                {
                    action: function(){
						changeTourOption();
                        shepherd.complete();
                    },
                    text: "{{__('inpanel.page_guide.dashboard.detail_profile_nav.go')}}"
                }
            ]
        });
        function getDetailprofileNav() {
            if (screenWidth >= minWidth && screenWidth <= maxWidth) {
                return { element: '#detailed_Profile', on: 'top' };
            } else {
                return { element: '#detailed_Profile', on: 'left' };
            }
            
        }
        function changeTourOption()
        {
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            var ajaxObj = axios.get("{{route('inpanel.change.tour.selection','dashboard')}}",headers);
        }

    </script>
@endpush
