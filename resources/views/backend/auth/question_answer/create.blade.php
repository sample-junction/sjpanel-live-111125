@extends('backend.layouts.app')
@section('title', __('labels.backend.access.questions_answers.management').' | '.__('labels.backend.access.questions_answers.create'))
@section('breadcrumb-links')
	@include('backend.auth.question_answer.includes.breadcrumb-links')@endsection
@section('content') 
{{  html()->form('POST', route('admin.auth.question.store'))->class('form-horizontal')->id('myForm')->open()}}
<style>
	/* Hide the upgrade message */
	.cke_notification_warning {
	    display: none !important;
	}
</style>
<div class = "card">
	<div class = "card-body">
		<div class = "row" >
				<div class="col-12">
				@if (session()->has('success'))
				     <div class="alert alert-success d-flex align-items-center alert_new" role="alert">
				         <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
				         <div>
				             {{ session()->get('success') }}
				         </div>
				         <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
				             <span aria-hidden="true">&times;</span>
				         </button>
				     </div>
				 @elseif (session()->has('fail'))
				     <div class="alert alert-danger d-flex align-items-center alert_new" role="alert">
				         <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Fail:"><use xlink:href="#exclamation-triangle-fill"/></svg>
				         <div>
				             {{ session()->get('fail') }}
				         </div>
				         <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
				             <span aria-hidden="true">&times;</span>
				         </button>
				     </div>
				 @endif

				</div>
				<div class = "col-sm-5" >
					<h4 class = "card-title mb-0" > @lang('labels.backend.access.questions_answers.management') <small class = "text-muted" > @lang('labels.backend.access.questions_answers.create') </small>
					</h4 >
				</div>
				<!--col-->
			</div >
			<!--row-->
			<hr >
		<div class = "clone-container">
			<button id="clone-btn" type="button" class="btn btn-success ml-1 float right"><i class="fas fa-plus-circle"></i></button>	
			<div class="clone">
				<div class = "col-md-12" >						
					<div class = "form-group" >
						<label for="">Question:</label>
						<input  name="question[]" id="question" class="form-control required question-input">
					</div >
					<!--form - group-->
					<div class = "form-group" >
						<label for="">Answer:</label>
						<textarea name="answer[]" id="answer" class="form-control ckeditor" placeholder="Answer" required></textarea>
					</div >
					<!--form - group-->
				</div>				
			</div>			
		</div>
	</div>
	<div class="card-footer clearfix">
		<div class="row">
			<div class="col">
				{{ form_cancel(route('admin.auth.question'), __('buttons.general.cancel')) }}
			</div >
			<!--col-->
			<div class = "col text-right" >
				{{ html()->button(__('buttons.general.crud.create'))->type('submit')->class('btn btn-success btn-sm pull-right')->id('create_button') }}
			</div><!--col-->
		</div >
			<!--row-->
		</div>
		<!--card-footer-->
	</div >
	<!--card-->
	{{ html()->form()->close() }}
</div>
@endsection
@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script> 
<link rel="stylesheet" href="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.css">
<script>
	$(window).on('pageshow', function(event) {
	  var historyTraversal = event.originalEvent.persisted;
	  if (historyTraversal) {
	    // Enable form button on page show
	    $('#create_button').prop('disabled', false);
	  }
	});
    $(document).ready(function () {
    	/* CK Editor */
    	CKEDITOR.replace('answer', {
    	    filebrowserBrowseUrl: '/ckfinder/ckfinder.html?resourceType=Files',
    	    filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    	    toolbar: [
    	        { name: 'clipboard', items: ['Undo', 'Redo'] },
    	        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
    	        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
    	        { name: 'links', items: ['Link', 'Unlink'] },
    	        { name: 'insert', items: ['Image'] },
    	        { name: 'source', items: ['Source'] },
    	        { name: 'styles', items: ['Format', 'Font', 'FontSize'] }
    	    ],
    	    extraPlugins: 'autogrow',
    	    //autoGrow_bottomSpace: 10,
    	    allowedContent: true, // Allow all HTML tags
    	    fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;30/30px;32/32px;36/36px;40/40px;44/44px;48/48px;52/52px;56/56px;60/60px;64/64px;68/68px;72/72px;76/76px;80/80px;84/84px;88/88px;92/92px;96/96px;100/100px;',
    	});
    	/* CK Editor */

    	/* Jquery clone or remove div */

    	// Clone div when clone button is clicked
    		var cloneIndex = 1;
    	    $('#clone-btn').click(function() {
    	        var removeHtml = '<span class="btn btn-danger ml-1 remove"><i class="fas fa-minus-circle"></i></span>';
    	        var clonedDiv = '<div class="clone">'+removeHtml+'<div class="col-md-12"><div class="form-group"><label for="">Question:</label><input name="question[]" class="form-control required question-input"></div><div class="form-group"><label for="">Answer:</label><textarea name="answer[]" class="form-control ckeditor clonedDivTextarea" placeholder="Answer" id="answer'+cloneIndex+'"></textarea></div></div></div>';

    	        // Destroy CKEditor instances before appending new content
    	        $('.clonedDivTextarea').each(function(index, element) {
    	            var instance = CKEDITOR.instances[element.id];
    	            if (instance) {
    	               // instance.destroy();
    	            }
    	        });

    	        // Append clonedDiv to .clone-container
    	        $('.clone-container').append(clonedDiv);

    	        // Initialize CKEditor for newly appended textarea only
    	        var $newTextarea = $('.clone-container').find('.clone:last').find('.clonedDivTextarea');
    	        CKEDITOR.replace($newTextarea[0]);
    	        cloneIndex++;
    	    });


    	    // Remove div when remove link is clicked
    	    $(document).on('click', '.remove', function() {
    	        $(this).closest('.clone').remove();
    	    });

    	/* Jquery clone or remove div */
    });
    $(document).ready(function() {
           // $('#create_button').prop('disabled', true);
            function checkFormValidity() {
                var valid = true;
                        $('#myForm .required').each(function() {

                            if ($.trim($(this).val()) == '') {
                                valid = false;
                                $(this).css('border-color', 'red'); 
                                //$('#create_button').prop('disabled', true);
                            } else {
                                $(this).css('border-color', '');
                                //$('#create_button').prop('disabled', false);
                            }
                        });
                        return valid;
            }           

            /* Code for validate the empty content or not : priyanka(10-july-2024)*/

            function isCKEditorValid(editorId) {
                var editor = CKEDITOR.instances[editorId];
                var content = editor.getData().trim();
                var allowedPattern = /<p>(&nbsp;|)<\/p>/g;
                var trimmedContent = editor.getData().trim().replace(/<(?:.|\n)*?>/gm, '').replace(/&nbsp;/g, '').trim();
                var strlength = trimmedContent.length;
               // alert(strlength);return false
                //return content.match(allowedPattern) !== null;
                return strlength;
            }

            function isCKEditorValidContent(editorId) {
                var editor = CKEDITOR.instances[editorId];

                if (!editor) {
                    console.error('CKEditor instance not found with ID: ' + editorId);
                    return false; // Return false if CKEditor instance is not found
                }

                var content = editor.getData().trim();
                var trimmedContent = content.replace(/<(?:.|\n)*?>/gm, '').replace(/&nbsp;/g, '').trim();
                var isValid = /[a-zA-Z]/.test(trimmedContent);

                return isValid;
            }

            function ckEditorContent() {
                    var isValid = true;
    				var message = "";

                    $('.ckeditor').each(function() {
                        var editorId = $(this).attr('id');
                        var length =  isCKEditorValid(editorId);
                        var validContent = isCKEditorValidContent(editorId);
                        if (length === 0) {
                           isValid = false;
                           message = "Answer field is required and not accepting empty spaces.";
                           return false; // Exit each loop early if invalid
						} else if (!validContent) {
						   isValid = false;
						   message = "Answer field must contain alphabetic character.";
						   return false; // Exit each loop early if invalid
						}
                    });
                    //console.log('isValid => ',isValid);return false;
                    console.log('isValid => ',isValid);
                    console.log('message => ',message);
                    return { isValid: isValid, message: message };
                }
           /* $('#myForm .required').on('keyup change', function() {
                    if (validateForm()) {
                        $(this).css('border-color', 'red'); 
                        //$('#create_button').prop('disabled', true);
                    } else {
                        $(this).css('border-color', '');
                        $(this).css('border-color', '');
                        //$('#create_button').prop('disabled', false);
                    }
                });*/
            $('#myForm').submit(function() {
            	 event.preventDefault(); 
                if (!checkFormValidity()) {
                	//Message="Please fill all the question & answer.";
                	Message="All the fields are required.";
                	toastr.error(Message, '', {
					    closeButton: true
					});
					$('#create_button').prop('disabled', false);
                    return false;
                }else{}
                 if(!validQuestion()){
                	Message="Each question must contain alphabets.";
                	toastr.error(Message, '', {
					    closeButton: true
					});
					$('#create_button').prop('disabled', false);
					return false;
                }else{}
                if(!checkDuplicacy()){
                	Message="Each question title must be unique.";
                	toastr.error(Message, '', {
					    closeButton: true
					});
					$('#create_button').prop('disabled', false);
					return false;
                }else{}
               	var result = ckEditorContent();
				if (!result.isValid) {
				  	toastr.error(result.message, '', { closeButton: true });
				  	$('#create_button').prop('disabled', false);
				    return false;
				}else{this.submit();}
            });
        });
	function checkDuplicacy() {
		var isDuplicate = true;
		var questions = $('.question-input').map(function() {
	           return $(this).val().trim(); 
	       }).get();
		var uniqueQuestions = Array.from(new Set(questions));
        if (uniqueQuestions.length !== questions.length) {
            isDuplicate = false;
        }
        console.log('isDuplicate => ',isDuplicate);
		return isDuplicate;	        
	}
	function validQuestion() {
		var isValid = true;
		var questions = $('.question-input').map(function() {
	           return $(this).val().trim(); 
	       }).get();
		var regex = /[a-zA-Z]/;
		questions.forEach(function(question) {
		        if (!regex.test(question)) {
		            isValid = false;
		        }
		    });
        console.log('isValid => ',isValid);
		return isValid;	        
	}
    /* Code for validate the empty content or not  : priyanka(10-july-2024)*/

</script>
@endpush