<style>
      .toggleBtn {
          cursor: pointer;
          display: inline-block;
          width: 20px;
          height: 20px;
          text-align: center;
          line-height: 20px;
      }
      .childContainer {
          margin-left: 20px;
      }
      .grandchildContainer {
          margin-left: 40px;
          display: flex;
          align-items: center;
          flex-wrap: wrap;
      }
      .grandchildContainer .form-check {
          margin-bottom: 5px;
      }
      .chkboxToggle{
        margin-right: 20px;
      }
      label.form-check-label {
          max-width: 94%;
          /* display: inline-block; */
          word-wrap: break-word;
      }
</style>
<div class="form-check">
<input class="form-check-input" type="checkbox" name="checkAllBtn" value="checkAllBtn" id="checkAllBtn" style="margin-left:100px;">
 <label class="form-check-label" for="SelectAll">
Select All</label>
</div>

@foreach($profile_sections as $index => $sections)
        @php $i=1; @endphp
       
        <div class="form-check">
            <span class="toggleBtn" id="parentToggle">+</span>
            <label class="form-check-label" for="parentCheckbox_{{$sections->general_name}}">
                {{$sections->general_name}}
               
            </label>
                <input class="form-check-input parentCheckbox" type="checkbox" name="profile_id[]" value="{{$sections->general_name}}" id="parentCheckbox" style="margin-left:50px;">
                @foreach($questions[$index]->questions as $ind=>$ques)
                  @if(($ques->profile_section_id == $sections->id) && !empty($ques->translated[0]['text']))
                <div class="ml-4 childContainer" style="display: none;">
                    <div class="form-check">
                        <span class="toggleBtn chkboxToggle" id="childToggle1">+</span>
                        <input class="form-check-input childCheckbox" type="checkbox" name="questions[]" value="{{$ques->id}}" id="childCheckbox1">
                        <label class="form-check-label" for="childCheckbox1_{{$ques->id}}">
                        {{$ques->translated[0]['text']}}
                        </label>
                        @if(isset($ques->translated) && is_array($ques->translated))
                        @foreach($ques->translated as $trans)
                             @php $x = 1; @endphp
                            @if(isset($trans['answers']) && is_array($trans['answers']))
                             @foreach($trans['answers'] as $ans)
                                <div class="ml-4 grandchildContainer" style="display: block;">
                                    <div class="form-check">
                                        <span class="toggleBtn chkboxToggle" id="grandchildToggle1" style="margin-right:20px;"></span>
                                        <input class="form-check-input grandchildCheckbox" type="checkbox" data-profile_id="{{$sections->general_name}}" data-questions="{{$ques->id}}" name="answers[]" value="@if(!empty($ans['precode'])){{ $ans['precode'] }}@endif" id="grandchildCheckbox1">
                                        <label class="form-check-label" for="grandchildCheckbox1_{{$ques->id}}">
                                        {{$ans['text']}}
                                        </label>
                                    </div>
                                </div>
                            @php $x++; @endphp
                             @endforeach
                               @endif
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif
                @php $i++; @endphp
                @endforeach 
            </div> 
      
        
      @endforeach


      <script>
  $(document).ready(function() {
    // Toggle child checkboxes on click 
    $(".parentCheckbox").change(function() {
      $(this).siblings('.childContainer').find('.form-check-input').prop('checked', $(this).prop("checked"));
    });

    // Toggle grandchild checkboxes on click
    $(".childCheckbox").change(function() {
      $(this).siblings('.grandchildContainer').find('.form-check-input').prop('checked', $(this).prop("checked"));
    });

    // Toggle great-grandchild checkboxes on click
    $(".grandchildCheckbox").change(function() {
      $(this).siblings('.greatGrandchildContainer').find('.form-check-input').prop('checked', $(this).prop("checked"));
    });

    // Toggle expansion/collapse of child checkboxes on click
    $(".toggleBtn11").click(function() {
      var container = $(this).closest('.form-check').find('.childContainer, .grandchildContainer, .greatGrandchildContainer');
      var icon = $(this);
      container.slideToggle(function() {
        icon.text(function(i, text) {
          console.log('text => ',text);
         /* var checkoxCls = text === "+" ? "addChkbox" : "minusaddChkbox";
          $('.checkoxCls').addClass(checkoxCls);*/
          return text === "+" ? "-" : "+";
         // return '-';
        });
      });
    });

    // Form submission handling
    $("#checkboxForm").submit(function(event) {
      event.preventDefault(); // Prevent default form submission
      
      // Collect form data
      var formData = {};
      $(this).find(':input').each(function() {
        if (this.type !== 'submit') {
          formData[this.id] = this.checked;
        }
      });

      // Log form data
      console.log(formData);
    });
  });

  //$('#select_criteria').click(function() {
  var clickCount = 0;
  //$(document).on('click', '#select_criteria', function() {
  $(document).off('click', '#select_criteria').on('click', '#select_criteria', function() {
      $('#selected_criteria').val('');
      var dataObjects = [];
      // Select checked checkboxes and group by profile_id and profile_question_code
      $('.grandchildCheckbox:checked').each(function() {
          var profile_section_code = $(this).data('profile_id');
          var profile_question_code = $(this).data('questions');
          var checkboxValue = $(this).val();

          // Check if an object with the same profile_id and profile_question_code exists in dataObjects
          var existingObjectIndex = dataObjects.findIndex(function(obj) {
              return obj.profile_section_code === profile_section_code && obj.profile_question_code === profile_question_code;
          });

          if (existingObjectIndex !== -1) {
              // Object already exists, add selected answer to existing object
              dataObjects[existingObjectIndex].selected_answer.push(checkboxValue);
          } else {
              // Create a new object
              var newObject = {
                  'profile_section_code': profile_section_code,
                  'profile_question_code': profile_question_code,
                  'selected_answer': [checkboxValue]
              };
              dataObjects.push(newObject);
          }
      });

      // Example: Log the array of objects
      var jsonData = JSON.stringify(dataObjects);
      if ($.isArray(dataObjects) && dataObjects.length === 0) {
          $('#selected_criteria').val('');
          toastr.error('Criteria is not selected. Please select some criteria.', '', {
              closeButton: true
          });
         // $('#set_criteria').prop('disabled', false);
          $('#check_feasibility').prop('disabled', true);
      } else {
          $('#selected_criteria').val(jsonData);
          //$('#selected_criteria').val(jsonData);
           toastr.success('Criteria is selected.', '', {
               closeButton: true
           });
          //$('#set_criteria').prop('disabled', true);
          $('#check_feasibility').prop('disabled', false);
      }
    
      // You can now use the dataObjects array as needed
      // For example, send it to a server, process further, etc.
  });

  $("#checkAllBtn").change(function() {
        // Check or uncheck all checkboxes based on the state of #checkAllBtn
        var isChecked = $(this).prop("checked");
        $('.parentCheckbox, .childCheckbox, .grandchildCheckbox').prop('checked', isChecked);
  });
  var toastrShown = false;
  $('.btn-close').click(function(){
        $('.parentCheckbox, .childCheckbox, .grandchildCheckbox, #checkAllBtn').prop('checked', false);
       // if (!toastrShown) {
            toastrShown = true;
            toastr.error('Please select the some criteria.', '', {
               closeButton: true
            });
        // }
        // $('#set_criteria').prop('disabled', false);
         $('#check_feasibility').prop('disabled', true);
  });

  $(document).on('click', function(event) {
      if (!$(event.target).closest('.modal').length && !$(event.target).is('.modal') && !$(event.target).is('#check_feasibility')) {
        // $('.btn-close').trigger('click'); // Trigger the close button click event
        $('.parentCheckbox, .childCheckbox, .grandchildCheckbox, #checkAllBtn').prop('checked', false);
        $('#selected_criteria').val('');
        $('#check_feasibility').prop('disabled', true);
      }
  });

  $(".toggleBtn").click(function() {
      var iconText = $(this).text();
      //alert(iconText);
      var container = $(this).closest('.form-check').find('.childContainer, .grandchildContainer, .greatGrandchildContainer');
      var icon = $(this);
      var toggleText = '+';
      container.slideToggle(function() {
        icon.text(function(i, text) {
            if(iconText == '+'){
              toggleText = '-';
            }else{
              toggleText = '+';
            }
            return toggleText;
          });
      });

  });
</script>