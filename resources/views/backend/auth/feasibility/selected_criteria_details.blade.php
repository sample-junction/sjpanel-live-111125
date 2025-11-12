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
@foreach($profile_sections as $index => $sections)
    @php
        $checkedParent = "";
        $checkedChild = "";
        $checkedGrandChild = "";
        $disabled = "";
        if (!empty($selected_criteria)) {
            $disabled = "disabled";
            foreach ($selected_criteria as $key => $criteria) {
                if ($criteria['profile_section_code'] == $sections->general_name) {
                    $checkedParent = "checked";
                }
            }
        }
    @endphp

    <div class="form-check">
        <span class="toggleBtn" id="parentToggle{{ $index }}">+</span>
        <label class="form-check-label" for="parentCheckbox{{ $index }}">
            {{ $sections->general_name }}
        </label>
        <input class="form-check-input parentCheckbox" type="checkbox" name="profile_id[]" value="{{ $sections->general_name }}" id="parentCheckbox{{ $index }}" style="margin-left:50px;" {{ $checkedParent }} {{ $disabled }}>

        @php $i=1; @endphp

        @foreach($questions[$index]->questions as $ind=>$ques)
            @php
                $checkedChild = "";
                if (!empty($selected_criteria)) {
                    foreach ($selected_criteria as $key => $criteria) {
                        if ($criteria['profile_question_code'] == $ques->id) {
                            $checkedChild = "checked";
                        }
                    }
                }
            @endphp

            @if(($ques->profile_section_id == $sections->id) && !empty($ques->translated[0]['text']))
                <div class="ml-4 childContainer" style="display: none;">
                    <div class="form-check">
                        <span class="toggleBtn chkboxToggle" id="childToggle{{ $index }}-{{ $ind }}">+</span>
                        <input class="form-check-input childCheckbox" type="checkbox" name="questions[]" value="{{ $ques->id }}" id="childCheckbox{{ $index }}-{{ $ind }}" {{ $checkedChild }} {{ $disabled }}>
                        <label class="form-check-label" for="childCheckbox{{ $index }}-{{ $ind }}">
                            {{ $ques->translated[0]['text'] }}
                        </label>
                        @if(isset($ques->translated) && is_array($ques->translated))
                        @foreach($ques->translated as $trans)
                            @if(isset($trans['answers']) && is_array($trans['answers']))
                            @foreach($trans['answers'] as $ans)
                                @php
                                    $checkedGrandChild = "";
                                    if (!empty($selected_criteria)) {
                                        foreach ($selected_criteria as $key => $criteria) {
                                            if(!empty($ans['precode'])){
                                                if ($criteria['profile_question_code'] == $ques->id && in_array($ans['precode'], $criteria['selected_answer'])) {
                                                    $checkedGrandChild = "checked";
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <div class="ml-4 grandchildContainer" style="display: block;">
                                    <div class="form-check">
                                        <span class="toggleBtn" id="grandchildToggle{{ $index }}-{{ $ind }}-{{ $loop->index }}"></span>
                                        <input class="form-check-input grandchildCheckbox" type="checkbox" data-profile_id="{{ $sections->general_name }}" data-question_id="{{ $ques->id }}" name="answers[]" value="@if(!empty($ans['precode'])){{ $ans['precode'] }}@endif" id="grandchildCheckbox{{ $index }}-{{ $ind }}-{{ $loop->index }}" {{ $checkedGrandChild }} {{ $disabled }}>
                                        <label class="form-check-label" for="grandchildCheckbox{{ $index }}-{{ $ind }}-{{ $loop->index }}">
                                            {{ $ans['text'] }}
                                        </label>
                                    </div>
                                </div>
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
            $(this).siblings('.childContainer').find('.grandchildContainer').find('.form-check-input').prop('checked', $(this).prop("checked"));
        });

        // Toggle expansion/collapse of child checkboxes on click
        $(".toggleBtn123").click(function() {
            var container = $(this).closest('.form-check').find('.childContainer, .grandchildContainer');
            var icon = $(this);
            container.slideToggle(function() {
                icon.text(function(i, text) {
                    return text === "+" ? "-" : "+";
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

        // Handle selection of criteria
        $('#select_criteria').click(function() {
            var dataObjects = [];

            $('.grandchildCheckbox:checked').each(function() {
                var profile_section_code = $(this).data('profile_id');
                var question_id = $(this).data('question_id');
                var checkboxValue = $(this).val();

                var existingObjectIndex = dataObjects.findIndex(function(obj) {
                    return obj.profile_section_code === profile_section_code && obj.profile_question_code === question_id;
                });

                if (existingObjectIndex !== -1) {
                    dataObjects[existingObjectIndex].selected_answer.push(checkboxValue);
                } else {
                    var newObject = {
                        'profile_section_code': profile_section_code,
                        'profile_question_code': question_id,
                        'selected_answer': [checkboxValue]
                    };
                    dataObjects.push(newObject);
                }
            });

            // Example: Log the array of objects
            console.log(dataObjects);
            var jsonData = JSON.stringify(dataObjects);
            console.log(jsonData);
            $('#selected_criteria').val(jsonData);
        });
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
