@extends('inpanel.layouts.app')
@push('after-styles')
    <!-- Ladda style -->
    <link href="{{asset('css/plugins/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
@endpush
@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="ibox-content forum-container">
                @php
                    $hasQuestions = false;
                    
                @endphp
                <ul class="nav nav-tabs">
                    <li class="test active"><a href="#tab_{{$profile->_id}}">{{ $profile->doTranslate('text') }}</a></li>
                    
                </ul>
                {!! CustomBootForm::horizontal(['class'=>'form-horizontal detailedProfileForm','route' => array('inpanel.profiler.update', $profile->_id)]) !!}
                <div class="tab-content">


                @php $tabTranslated = $profile->translated; @endphp

                <div id="tab_{{$profile->_id}}" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                <input type="hidden" value="{{ $profile->general_name }}" name="profileName"  />
                                    @php $i=0; @endphp
                                    @forelse( $profile->questions as $index => $question )
                                        
                                        @php
                                            $translatedQuestion = $question->doTranslate();
                                            if( empty($translatedQuestion) ){
                                                if(empty($translatedQuestion)){
                                                    continue;
                                                }
                                            }
                                            $hasQuestions = true;
                                       if($question->spl_quest==true){
                                            $i++;
                                        }

                                        @endphp
                                        
                                        
                                        
                                    @if($question->userAnswers)
                                        <div class="well">
                                            <h3 id="question_{{$question->_id}}" class="question_title">
												@php
													if( empty( $question->doTranslate('text') ) ){
														dd($question);
													}
												@endphp
                                                {{ $question->doTranslate('text') }} @if($question->spl_quest==true) ** @endif
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

                                            {!!  CustomBootForm::generateFields( $question->type, $question->general_name, $quesdata, $question->userAnswers->only(['user_answer']) ) !!}
                                        
                                         
                                            
                                        @if($question->userAnswers->get('other'))                                          
                                           @php  
                                             $generalName = $question->general_name . '_OTHER';                                            
                                           @endphp 
                                <div class="form-group">             
                                  <div class="col-sm-12 col-md-12 appended">          
                                             
                          {!!  CustomBootForm::generateFields( "Text Open Ended", $generalName, '', $question->userAnswers->only(['other']), [ "placeholder" => "Other" ] ) !!}
                                  </div>
                                </div>  
                                        @endif
                                        
                                        @if($question->userAnswers->get('selectother'))                                          
                                           @php  
                                             $generalName = $question->general_name . '_SELECT_OTHER';
                                           @endphp 
                                <div class="form-group">             
                                  <div class="col-sm-12 col-md-12 appendedWithSelected">          
                                             
                          {!!  CustomBootForm::generateFields( "Text Open Ended", $generalName, '', $question->userAnswers->only(['selectother']), [ "placeholder" => "Select With Other" ] ) !!}
                                  </div>
                                </div>  
                                        @endif
                                        
                                        

                                        </div>
                                        
                                        @if($question->spl_quest==true)
                                        @endif
                                    @endif
                                    @empty
                                        <p>{{__('inpanel.questions.no_qusetions')}}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                @if($i>0)
                    <p><strong>{{__('inpanel.questions.disclaimer')}}:</strong> {{__('inpanel.questions.disclaimer_details')}}</p>
                @endif
                @if($hasQuestions)
                    <div class="row">
                        <input type="hidden" name="update_date" value="{{$update_date}}">
                        <input type="hidden" name="hours_gap" value="{{$hours_gap}}">
                        <button class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in" id="detailedProfileSaveBtn" type="submit">{{__('inpanel.questions.buttons_submit')}}</button>
                    </div>
                @endif
                {!! CustomBootForm::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <!-- Jquery Validate -->
    <script src="{{asset('vendor/js/plugins/validate/jquery.validate.min.js')}}"></script>

    <!-- Ladda -->
    <script src="{{asset('js/plugins/ladda/spin.min.js')}}"></script>
    <script src="{{asset('js/plugins/ladda/ladda.min.js')}}"></script>
    <script src="{{asset('js/plugins/ladda/ladda.jquery.min.js')}}"></script>

    <script>

        $(document).ready(function(){
            var submitFormClass=".detailedProfileForm";
            $(".detailedProfileForm").validate(/*{
                errorPlacement: function(error, element) {
                    if (element.type == 'checkbox') {
                        error.appendTo(element.closest('.well').find('.question_title'));
                    }else {
                        error.insertAfter(element);
                    }
                }
            }*/);
            $.validator.setDefaults({
                submitHandler: function() {
                    $(submitFormClass).submit();
                }
            });



            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });

            //var l = $( '.ladda-button-demo' ).ladda();

            jQuery("input[data-precode_type='general']").on('change', function(e){	
				    var question = $(this).data('question');
					var clickedElement = $(this);
					
					console.log('question=='+question);
			
					$("input[data-question='"+question+"']").each(function(){
						var type = $(this).data('precode_type');
						if(type == 'exclusive' || type == 'other') {
							$(this).prop("checked", false);
			
						}
					});
					clickedElement.closest(".well").find( ".appended" ).remove();

            });
			

            jQuery("input[data-precode_type='exclusive']").on('change', function(e){
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
			
			jQuery("input[data-precode_type='other']").on('change', function(e){
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
			
			jQuery("input[data-precode_type='select_other']").on('change', function(e){
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
			

            jQuery('#detailedProfileSaveBtn').on('click',function(e){
                // Start loading
                //l.ladda( 'start' );

                $(submitFormClass).submit();
                return true;

            });




        });

        function executeSaveAjax(formObj){
            // send ajax
            var saveAjax = $.ajax({
                url: formObj.attr('action'), // url where to submit the request
                type : formObj.attr('method'), // type of action POST || GET
                dataType : 'json', // data type
                data : formObj.serialize()
            });
            return saveAjax;
        }
  

$(document).ready(function(){
		jQuery("input[data-precode_type='other']").on('change', function(e){
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
			 
			 if(current_status){
			 axios.get("{{ route('inpanel.profiler.other_field.show',['id' => $profile->_id ]) }}",{params,headers})
				  .then(function (response){                
						clickedElement.closest(".well > .form-group > div").append(response.data)
					  }); 
			}else{
				  clickedElement.closest(".well").find( ".appended" ).remove();
			} 
		});
		
		jQuery("input[data-precode_type='select_other']").on('change', function(e){
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
						clickedElement.closest(".well > .form-group > div").append(response.data)
					  }); 
			}else{
				  clickedElement.closest(".well").find( ".appendedWithSelected" ).remove();
			} 
		});
});

    </script>

@endpush
