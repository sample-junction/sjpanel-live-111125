@php
    $translatedQuestion = $question->doTranslate();
    if( empty($translatedQuestion) ){
     dd('error in translation - Translation not found', $question);
    }
    $question->userAnswers = collect();
    $hasQuestions = true;
@endphp

@if(isset($progress) && !empty($progress) )
    <div class="row">
        @php
            $total = $progress['total'];
            /*$pending = $progress['answered'];*/
            $completed = $progress['answered'];
            $completedPer = 0;
            if(!empty($completed)){
                $completedPer = floor(($completed/$total) * 100) ;
            }
        @endphp
        <div class="progress progress-striped active">
            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{$completedPer}}" role="progressbar" class="progress-bar progress-bar-primary" style="width: {{$completedPer}}%;">
                <span>{{$completedPer}}%  {{__('inpanel.profiler.progress_bar.completes')}}</span>
            </div>
        </div>
    </div>
@endif
<div class="well">
    <h3 id="question_{{$question->_id}}" class="question_title">
        {{ $question->doTranslate('text') }}@if($question->spl_quest==true) ** @endif
    </h3>
       
        @php
          $quesdata = $question->doTranslate('answers'); 
          if($question->general_name=='STANDARD_SEXUAL_ORIENTATION_EN'){     
                foreach($quesdata as $k => $val) {
                    if($gender == 'male'){
                        if(($val['display_name'] == "Lesbian") || ($val['display_name'] == "Transgender")) {
                            unset($quesdata[$k]);
                        }
                    }
                    if($gender == 'female'){
                        if(($val['display_name'] == "Gay") || ($val['display_name'] == "Transgender")) {
                            unset($quesdata[$k]);
                        }
                    }    
                 }
             }    
        @endphp
    
    {!!  CustomBootForm::generateFields( $question->type, $question->general_name, $quesdata, $question->userAnswers ) !!}
</div>
{{--Ended Here--}}

@if($question->spl_quest==true)
    <div class="row">
        <div class="col-md-12">
            <p><strong>{{__('inpanel.questions.disclaimer')}}:</strong> {{__('inpanel.questions.disclaimer_details')}}</p>
        </div>
    </div>
@endif
<div class="row">
    @if( isset($previous_id) && !empty($previous_id) )
    <div class="col-md-6 col-sm-6 col-xs-6">
        <button data-currentId="{{$question->id}}" class="ladda-button ladda-button-demo btn btn-lg btn-primary pull-right load_previous_question"  data-style="zoom-in" type="button">
            {{__('inpanel.profiler.button.back')}}
        </button>
    </div>
    @endif
    <div class="col-md-6 col-sm-6 col-xs-6">
        <button class="ladda-button ladda-button-demo btn btn-lg btn-primary pull-left load_next_question"  data-style="zoom-in" type="button">
            {{__('inpanel.profiler.button.next')}}
        </button>
    </div>

</div>
