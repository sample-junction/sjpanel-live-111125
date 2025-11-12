<div class="container">
    <div class="row text-center">
        <div class="col-sm-6 col-sm-offset-3">
            <br><br> <h2 style="color:#0fad00">{{__('inpanel.survey_complete_page.header')}}</h2>
            <img src="{{asset('img/inpanel/survey_success.png')}}" width="100px">
            <h3>{{__('inpanel.survey_complete_page.salutation')}}, {{$user_project->user->first_name}} {{$user_project->user->last_name}}</h3>
            <p style="font-size:20px;color:#5C5C5C;">{{__('inpanel.survey_complete_page.details_1')}}
                {{$user_project->points}} {{__('inpanel.survey_complete_page.details_2')}}</p>
            {{__('inpanel.survey_complete_page.details_3')}} <br />
            <a href="{{route('inpanel.survey.history')}}"> {{__('inpanel.survey_complete_page.button_text')}} </a>
            <br><br>
            <a href="{{route('inpanel.survey.index')}}" class="btn btn-success"> {{__('inpanel.survey_complete_page.more_survey_button')}} </a>
        </div>
    </div>
</div>
