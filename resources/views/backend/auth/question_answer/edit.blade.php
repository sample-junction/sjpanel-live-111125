@extends('backend.layouts.app')

@section('title', __('labels.backend.access.questions_answers.management') . ' | ' . __('labels.backend.access.questions_answers.edit'))

@section('breadcrumb-links')
    @include('backend.auth.question_answer.includes.breadcrumb-links')
@endsection
<style>
    /* Hide the upgrade message */
    .cke_notification_warning {
        display: none !important;
    }
</style>
@section('content')
{{ html()->modelForm($question, 'PUT', route('admin.auth.question.update', $question->id))->class('form-horizontal')->id('myForm')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.questions_answers.management')
                        <small class="text-muted">Update Question & Answer</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class = "col-md-12" >                      
                    <div class = "form-group" >
                        <label for="">Question:</label>
                        <input  name="question" id="question" class="form-control question-input" value="{{ $question->question}}">
                    </div >
                    <!--form - group-->
                    <div class = "form-group" >
                        <label for="">Answer:</label>
                        <input  type="hidden" name="answer_id" class="form-control" value="{{ $question->answers[0]->id}}">
                        <textarea name="answer" id="answer" class="form-control ckeditor" placeholder="Answer">{!! $question->answers[0]->answer !!}</textarea>
                    </div >
                    <!--form - group-->
                </div>          
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.question'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ html()->button(__('buttons.general.crud.update'))
    ->type('submit')
    ->class('btn btn-success btn-sm pull-right')
    ->id('update_button') }}


                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script> 
<link rel="stylesheet" href="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.css">
<script>
          /*  setTimeout(function() {
           // location.reload();
            $('#update_button').prop('disabled', false);
        }, 5000);*/
/*    window.addEventListener('popstate', function(event) {
      if (event.state && event.state.page) {
        // Here you can handle what happens when the user navigates backward
        alert('User navigated backward to page: ' + event.state.page);
      }
    });*/
    $(window).on('pageshow', function(event) {
      var historyTraversal = event.originalEvent.persisted;
      if (historyTraversal) {
        // Enable form button on page show
        $('#update_button').prop('disabled', false);
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
                   /* if(length == 0){
                        isValid = false;
                    }*/
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
                //return isValid;
                return { isValid: isValid, message: message };
            }
            $('#myForm').submit(function() {
                /*var contentLength = ckEditorContent();
                if (!contentLength) {
                    console.log('a');
                    var Message = "Answer field is required and not accepting empty spaces";
                    toastr.error(Message, '', {
                        closeButton: true
                    });
                    $('#update_button').prop('disabled', false);
                    return false;
                }else{}*/
                event.preventDefault();
                if(!validQuestion()){
                    Message="The question must contain alphabets.";
                    toastr.error(Message, '', {
                        closeButton: true
                    });
                    $('#update_button').prop('disabled', false);
                    return false;
                }
                var result = ckEditorContent();
                if (!result.isValid) {
                    toastr.error(result.message, '', { closeButton: true });
                    $('#update_button').prop('disabled', false); // Assuming this is to re-enable a button
                } else {
                    // Form submission logic here
                    this.submit(); // Submit the form if validation passes
                }
            });
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
    });
</script>
@endpush
