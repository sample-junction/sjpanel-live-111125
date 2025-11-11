@extends('inpanel.layouts.app')
@push('after-styles')
    <!-- Ladda style -->
    <link href="{{asset('vendor/css/plugins/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
    <style>
        .swal-wide{
            width:850px !important;
        }
        </style>
@endpush
@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">


            <div class="ibox-content forum-container">
                @php
                    $hasQuestions = false;
                   
                @endphp
                <ul class="nav nav-tabs">
                    <li class="test active"><a href="#tab_{{@$profile->_id}}">{{$profile->doTranslate('text')}}</a></li>
                    <input type="hidden" value="{{ __('inpanel.questions.popup.congrats') }}">
                </ul>

                <div class="tab-content">
                    <div id="tab_{{$profile->_id}}" class="tab-pane fade in active ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                        {{--Started Here--}}
                                        <div class="question_loader" style="display:none;">
                                            <div class="sk-spinner sk-spinner-rotating-plane"></div>
                                        </div>
                                        {!! CustomBootForm::horizontal(['class'=>'form-horizontal detailedProfileForm','route' => array('inpanel.profiler.question.save_fetch.show', $profile->_id)]) !!}
                                            <div class="question_section">

                                            </div>
                                        {!! CustomBootForm::close() !!}
                                        {{--Ended Here--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


     


@push('after-styles')
<style>
    .swal2-popup{
        width:500px !important;
        height:50% !important;
        font-size: inherit !important;
    }
</style>
@endpush
@push('after-scripts')
<!-- Jquery Validate -->
<script src="{{asset('vendor/js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Ladda -->
<script src="{{asset('vendor/js/plugins/ladda/spin.min.js')}}"></script>
<script src="{{asset('vendor/js/plugins/ladda/ladda.min.js')}}"></script>
<script src="{{asset('vendor/js/plugins/ladda/ladda.jquery.min.js')}}"></script>

<script>

$(document).ready(function(){

    loadFirstProfileQuestion();

    var l = $( '.ladda-button-demo' ).ladda();

    $('.detailedProfileForm').validate();


    jQuery(document).on('click','.load_next_question',function(e){
        if($('.detailedProfileForm').validate().form()) {
            saveAndFetchNextQuestion();
        }
    });

    jQuery(document).on('click','.load_previous_question',function(e){
            var questId = jQuery(this).attr('data-currentId');
            fetchPreviousQuestion(questId);
    });


    jQuery(document).on('change', "input[data-precode_type='general']", function(e){
        var question = $(this).data('question');
		var clickedElement = $(this);
		
        console.log('question=='+question);
        var dataType = $(this).attr('type'); 
        if(dataType=='radio'){
             clickedElement.closest(".well").find( ".appended" ).remove();
       clickedElement.closest(".well").find( ".appendedWithSelected" ).remove();
        }
       
        $("input[data-question='"+question+"']").each(function(){
            var type = $(this).data('precode_type');
            console.log('type=='+type);
            if(type == 'exclusive' || type == 'other') {
                $(this).prop("checked", false);

            }
        });
       // clickedElement.closest(".well").find( ".appended" ).remove();

    });

    jQuery(document).on('change', "input[data-precode_type='exclusive']", function(e){

        var current_status = this.checked;
		var clickedElement = $(this);
        var question = $(this).data('question');
		
		clickedElement.closest(".well").find( ".appended" ).remove();
		clickedElement.closest(".well").find( ".appendedWithSelected" ).remove();
		
        $("input[data-question='"+question+"']").each(function(){
            if(this.checked) {
                $(this).prop("checked", false);
            }
        });

        if(current_status){
            $(this).prop("checked", true);
        }

    });
	
	jQuery(document).on('change', "input[data-precode_type='other']", function(e){


        var current_status = this.checked;
        var question = $(this).data('question');
		
        $("input[data-question='"+question+"']").each(function(){
            if(this.checked) {
                $(this).prop("checked", false);
            }
        });

        if(current_status){
            $(this).prop("checked", true);
        }

    });
	
	jQuery(document).on('change', "input[data-precode_type='select_other']", function(e){
        
        var current_status = this.checked;
		var question = $(this).data('question');
		
		$("input[data-question='"+question+"']").each(function(){
            var type = $(this).data('precode_type');
            console.log('type=='+type);
            if(type == 'exclusive' || type == 'other') {
                $(this).prop("checked", false);

            }
        });

        if(current_status){
            $(this).prop("checked", true);
        }

    });
	
});


jQuery(document).on('change', "input[data-precode_type='other']", function(e){
   
   var fieldName = $(this).attr('name');  
 //  var type = $(this).data('precode_type');
   var clickedElement = $(this);
   var current_status = this.checked;
   var dataType = $(this).attr('type');  
   if(dataType == 'checkbox'){
     fieldArray = fieldName.split("[");
	 fieldName =  fieldArray[0];
   }

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var params =  {
        generalName : fieldName +'_OTHER'
    }
     clickedElement.closest(".well").find( ".appendedWithSelected" ).remove();
	 clickedElement.closest(".well").find( ".appended" ).remove();
     if(current_status){
	 axios.get("{{ route('inpanel.profiler.other_field.show',['id' => $profile->_id ]) }}",{params,headers})
	      .then(function (response){                
				clickedElement.closest(".well > .form-group > div").append(response.data)
			  }); 
	}else{
		  clickedElement.closest(".well").find( ".appended" ).remove();
	} 
});   

jQuery(document).on('change', "input[data-precode_type='select_other']", function(e){
   
   var fieldName = $(this).attr('name'); 
   var clickedElement = $(this);
   var current_status = this.checked;
   var dataType = $(this).attr('type');  
   if(dataType == 'checkbox'){
     fieldArray = fieldName.split("[");
	 fieldName =  fieldArray[0];
   }
 
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var params =  {
        generalName : fieldName +'_SELECT_OTHER'
    }
	
	clickedElement.closest(".well").find( ".appended" ).remove();
 
     if(current_status){
	 axios.get("{{ route('inpanel.profiler.withother_field.show',['id' => $profile->_id ]) }}",{params,headers})
	      .then(function (response){  
          console.log(response.data);              
				//clickedElement.closest(".well > .form-group > div").append(response.data)
                clickedElement.closest('.radio,.checkbox').append(response.data);
			  }); 
	}else{
		  clickedElement.closest(".well").find( ".appendedWithSelected" ).remove();
	} 
}); 

function fetchPreviousQuestion(currentQuestionId) {
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var params =  {
        active_question_id : currentQuestionId
    }

    jQuery('.question_section > .well').hide('slow');
    jQuery('.question_loader').show();
    var ajaxObj = axios.get("{{ route('inpanel.profiler.previous_question.show',['id' => $profile->_id ]) }}",{params,headers});

    processSingleQuestionAjaxs(ajaxObj);
}

function saveAndFetchNextQuestion() {

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var questionForm = jQuery('.detailedProfileForm');
    var questionFormData = questionForm.serialize();

    var postData = questionFormData;

    jQuery('.question_section > .well').hide('slow');
    jQuery('.question_loader').show();

    var ajaxObj = axios.post("{{ route('inpanel.profiler.question.save_fetch.show', ['id' => $profile->_id]) }}",postData,headers);
    processSingleQuestionAjaxs(ajaxObj);
}

function loadFirstProfileQuestion()
{
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var params =  {
    };
    jQuery('.question_section > .well').hide('slow');
    jQuery('.question_loader').show();
    var ajaxObj = axios.get("{{ route('inpanel.profiler.active_question.show', ['id' => $profile->_id]) }}",params,headers);
    processSingleQuestionAjaxs(ajaxObj);
}

function processSingleQuestionAjaxs(ajaxObj){
    ajaxObj
    .then(function (response) {
        var questionHtml = response.data;
        console.log(response.data.user_project_id);
        if(questionHtml instanceof Object === false){
            var questionHtmlResponse = $.parseHTML( questionHtml );
            jQuery("div.question_section").hide().html(questionHtmlResponse).slideDown('slow');
        }else{
            console.log(response.data);
            if(response.data.id!==""){
                $(".progress-bar-primary").css('width','100%');
                $(".progress-bar-primary span").text('100%');
                var points = '<strong>'+response.data.points+'</strong>'
               
                swal({
                    title: "{{ __('inpanel.questions.popup.congrats') }}", 
                    type: "success",                  
                    html: '{!! __("inpanel.questions.popup.message_1") !!} <strong>'+response.data.current_display_name+'</strong> {!! __("inpanel.questions.popup.message_2") !!}<strong>'+points+'</strong> {!! __("inpanel.questions.popup.message_3") !!}',
                    showCancelButton: true,
                    confirmButtonColor: "#1080d0",
                    confirmButtonText: "{!! __('inpanel.questions.popup.continue_button') !!}",
                    cancelButtonText: "{!! __('inpanel.questions.popup.close') !!}",
                    closeOnConfirm: false,
                }).then((result) => {
                    if (result.value===true) {
                        var id = response.data.id;
                        var url = "{{route('inpanel.profiler.single.show',":id")}}";
                        url = url.replace(':id', response.data.id);
                        window.location.replace(url);
                    } else {
                        window.location.replace("{{route('inpanel.profiler.show')}}");
                    }
                });
            } else if( response.data.user_project_id==="" ) {
                swal("{!! __('inpanel.profiler.success') !!}", "", "success")
                .then((value) => {
                    window.location.replace("{{route('inpanel.profiler.show')}}");
                });
            }else{
                var points = response.data.user_project_points;
                var id = response.data.user_project_id;
                swal({
                    title: '{!! __("inpanel.survey_popup.congrats") !!}',
                    type: "success",
                    //text: '<button type="' + points + '">Button</button>',
                    html: '{!! __("inpanel.survey_popup.message_1") !!} <br /> {!! __("inpanel.survey_popup.message_2") !!} {!! __("inpanel.survey_popup.message_4") !!} <strong>'+points+'</strong>  {!! __("inpanel.survey_popup.message_5") !!}' ,
                    showCancelButton: false,
                    confirmButtonColor: "#1080d0",
                    confirmButtonText: "{!! __('inpanel.questions.popup.continue_button') !!}",
                    /*cancelButtonText: "{!! __('inpanel.questions.popup.close') !!}",*/
                    closeOnConfirm: false,
                }).then((result) => {
                    if (result.value===true) {
                        // var url = "{{route('inpanel.survey.execute.show',":id")}}";
                        // url = url.replace(':id', id);
                        // window.location.replace(url);
                        window.location.replace("{{route('inpanel.survey.index')}}");
                        
                    } else {
                        window.location.replace("{{route('inpanel.profiler.show')}}");
                    }
                });
            }
        }
    }).catch(function (error) {
        alert('some Error occured');
        console.log(error);

    }).then(function () {
        // always executed
        console.log('always executed');
        jQuery('.question_loader').hide();
    });
}
  

</script>

@endpush
