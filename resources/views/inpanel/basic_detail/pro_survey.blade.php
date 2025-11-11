@extends('inpanel.layouts.device')

@push('after-styles')
<link href="{{asset('css2/My-account_style.css')}}" rel="stylesheet">
<link href="{{asset('css2/dashboard_style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{asset('css2/detail_profile_inpage.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="row p-1 p-md-4">

    <div class="shadow border rounded pe-4 ps-4 pt-3" style="background: #FFFFFF;">
        <div class="col-12 mt-4 mb-4">

            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px;">
                <div class="progress-bar bg-success" @if($display_index==0) style="width: 66%" @else style="width: 95%" @endif></div>
            </div>

        </div>
        <div class="row p-lg-3">
            <div class="col cst-bg-hot-survey bg-white shadow" style="border-radius: 10px;">
                @if(isset($profile_sections))
                @foreach($profile_sections as $index => $sections)
                @php
                $class_item_sr = '';
                if($index != $display_index){
                $class_item_sr = 'hid';
                }
                $data_sr = 'data-sr-'.$index;
                $load_data = 'loadData-'.$index;
                if($display_index == 0){
                $i = 0;
                }else{
                $i = 1;
                }
                @endphp
                @if($index == $display_index)
                <div id="filter-content-survey" class="{{$class_item_sr}}" data-sr="{{$data_sr}}">
                    <div class="row pt-4 profile_ques_data">
                        <div class="col-12 mt-3 load_{{$sections->_id}}" id="{{$load_data}}">

                        </div>
                        <form id="pro_form_{{$sections->_id}}" method="post" action="{{route('inpanel.profiler.profile.save_fetch.show', ['id' => $sections->_id,'basic_detail_sur' => true,'index'=> $i])}}">
                            @csrf
                            @php $sel_count = 0; @endphp
                            @if(isset($profile_surveys))
                            @foreach($profile_surveys[$i]->questions as $ques)
                            @if($ques->translated)
                            @php
                            $multiSelectMsg="";
                            $multiple = '';
                            if($ques->type == 'Multi Punch'){
                            $multiple = 'multiple';
                            $multiSelectMsg = '(' . __('inpanel.profiler.Select_Multiple_Message') . ')';
                            }
                            if($sel_count == 0){
                            $disabled = '';
                            }else{
                            $disabled = 'disabled';
                            }
                            @endphp
                            <div id="ques_{{$ques->_id}}" class="profile_questions_{{$sections->_id}}">
                                <div class="col-12 mt-3 text-center">
                                    <p class="fw-bold" id="ques_txt_{{$ques->_id}}" @if($sel_count> 0)style="color:#999999;" @endif>
                                        {{$ques->translated[0]['text']}} {{$multiSelectMsg}}
                                    </p>
                                </div>
                                <div class="col-12 text-center d-flex justify-content-center">
                                    <select class="form-select form-select-lg select-width select_{{$sections->_id}} myselect" aria-label="Large select example" id="sel_{{$ques->id}}" name="{{$ques->id}}[]" {{$multiple}} required {{$disabled}}>
                                        @if($multiple == '')
                                        <option value=""></option>
                                        @endif
                                        @if(!empty($ques->translated))

                                        @foreach($ques->translated as $trans)
                                        @php

                                        $x = 1; @endphp
                                        @if(isset($trans['answers']))
                                        @foreach($trans['answers'] as $ans)
                                        <option value="{{$x}}">{{$ans['text']}}</option>
                                        @php $x++; @endphp
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>

                                </div>
                                @php
                                if($sel_count > 0){
                                $style = "button_disabled";
                                }else{
                                $style = "button_enabled";
                                }
                                @endphp
                                <div class="col-12 text-center">
                                    <small class="text-danger err-handle hid">
                                        {{__('inpanel.profiler.empty_error')}}
                                    </small>
                                </div>
                                <div class="col-12 mt-4 mb-4 text-center d-flex justify-content-center">
                                    <button type="button" class="btn btn-outline-secondary btn-lg {{$style}} nextDepButton" onclick="addAnswer('sel_{{$ques->id}}','ques_{{$ques->_id}}','ques_txt_{{$ques->_id}}','{{$load_data}}')" {{$disabled}}>{{__('inpanel.profiler.done')}}</button>
                                </div>
                                <hr class="q_hr">
                            </div>
                            <!-- end question  -->
                            @php $sel_count++; @endphp
                            @endif
                            @endforeach
                            @endif

                            <div class="btn-holder">
                                <button type="submit" id="update-button" class="btn btn-primary btn-lg mt-4 w-sm-100 update-button">@if($display_index == 0){{__('inpanel.profiler.button.next')}} @else {{__('inpanel.basic_detail.update_button')}} @endif</button>
                            </div>
                        </form>

                    </div>
                </div>
                @endif
                @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('after-styles')
<link href="{{asset('vendor/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endpush

@push('after-scripts')
<!-- Date range use moment.js same as full calendar plugin -->
<script type="text/javascript" id="forensic_script_id" src="https://api-cdn.dfiq.net/scripts/forensic-v5.5.0.min.js" data-key="29109E607D0B6E11DE0B966F50EA617A-5004-1" data-nc></script>
<script src="{{asset('vendor/js/plugins/toastr/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $("select").select2({
        tags: false,
        tokenSeparators: [',', ' '],
        width: '873px',
        height: '50px',
        closeOnSelect: true,
        language: {
            noResults: function() {
                return "{{__('inpanel.profile.index.no_result')}}";
            }
        }
    });

    function addAnswer(select, question, questionText, loader) {
        var sel_id = select;
        var q_id = question;
        var q_text_id = questionText;
        var sel_value = $('#' + sel_id).val();
        var sel_element = document.getElementById(sel_id);
        var sel_options = $('#' + sel_id).select2('data');
        var sel_option_txt = '';
        var classesList = Array.from($('#' + sel_id)[0].classList);
        if (sel_element.multiple) {
            sel_option_txt = sel_options.map(function(option) {
                return option.text;
            }).join(' ; ');
        } else {
            sel_option_txt = sel_options.map(function(option) {
                return option.text;
            });
        }

        var q_element = document.getElementById(q_id);
        var q_text_id_value = document.getElementById(q_text_id).innerText;

        if (sel_value == "" && sel_element.disabled == false) {
            document.getElementById(sel_id).style.border = "1px solid red";
            sel_element.parentElement.nextElementSibling.children[0].classList.remove('hid');
        } else if (sel_value != "" && sel_element.disabled == false) {
            document.getElementById(sel_id).style.border = "1px solid #f8f9fa";
            q_element.classList.add('d-none');
            // add .pt-3 class below element for all added menu options except first one
            var new_load_html = `<div class="row ms-1 me-1"> 
                                        <div class="col-12 col-lg-6">
                                            <p class="fw-bold">${q_text_id_value}</p>
                                        </div>
                                        <div class="col-12 col-lg-6 added-answer">
                                            <p class="fw-bold" style="color:#1080D0; font-size:13px;">${sel_option_txt}</p>
                                        </div>
                                    </div>
                                    <hr class="mt-0">`;

            jQuery("#" + loader).append(new_load_html);

            var select_available = document.querySelectorAll('.' + classesList[3]);
            for (let i = 0; i < select_available.length; i++) {
                if ($(select_available[i]).is(':hidden')) {
                    console.log("hidden");
                    continue;
                } else {
                    console.log("not hidden");
                    if (select_available[i].disabled) {
                        select_available[i].disabled = false;
                        select_available[i].parentElement.previousElementSibling.children[0].style.color = "black";
                        select_available[i].parentElement.nextElementSibling.nextElementSibling.children[0].disabled = false;
                        select_available[i].parentElement.nextElementSibling.nextElementSibling.children[0].style.background = "none";
                        select_available[i].parentElement.nextElementSibling.nextElementSibling.children[0].style.border = "1px solid #1080D0";
                        select_available[i].parentElement.nextElementSibling.nextElementSibling.children[0].classList.remove('button_disabled');
                        select_available[i].parentElement.nextElementSibling.nextElementSibling.children[0].classList.add('button_enabled');
                        break;
                    }
                }
                // Get section ID and update button visibility
                var sectionId = classesList.find(cls => cls.startsWith('select_')).split('_')[1];
                updateEditModeButtonVisibility(sectionId);
            }
        }
    }

        // Add this new function
    function updateEditModeButtonVisibility(sectionId) {
        // Get all visible questions (both answered and unanswered)
        var $allVisibleQuestions = $('.profile_questions_' + sectionId)
            .not('.d-none')
            .not(':hidden');
        
        // Hide all next buttons first
        $('.profile_questions_' + sectionId).find('.nextDepButton').hide();

        // Case 1: Only one question total - hide its button
        if ($allVisibleQuestions.length === 1) {
            $allVisibleQuestions.find('.nextDepButton').hide();
        }
        // Case 2: Multiple questions - show buttons for all except last question
        else if ($allVisibleQuestions.length > 1) {
            $allVisibleQuestions.not(':last').find('.nextDepButton').show();
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('.myselect').each(eachSelect);

        function eachSelect(e) {
            var selectId = $(this).attr('id');

            var ques_code_arr = selectId.split('_');
            var ques_code = ques_code_arr.slice(1).join('_');
            console.log(ques_code);
            var selectedOptions = '';
            $(this).on('change', function(e) {

                if (selectId.multiple) {
                    selectedOptions = $(this).val().join(' ; ');
                } else {
                    selectedOptions = $(this).val();
                }

                var add_indexes = [];
                var remove_indexes = [];
                var dep_ques = <?php echo json_encode($dependent_survey_ques); ?>;
                for (let i = 0; i < dep_ques.length; i++) {
                    var dep_jsonObj = JSON.parse(dep_ques[i].dependency);

                    for (let j = 0; j < dep_jsonObj.length; j++) {
                        if (dep_jsonObj[j].question_code === ques_code) {
                            if (selectedOptions && dep_jsonObj[j].precode.indexOf(parseInt(selectedOptions, 10)) === -1) {
                                add_indexes.push(i);
                            } else {
                                remove_indexes.push(i);
                            }

                        }
                    }
                }
                if (add_indexes.length > 0) {
                    addQues(add_indexes, dep_ques);
                }
                if (remove_indexes.length > 0) {
                    removeQues(remove_indexes, dep_ques);
                }
            });
            // Initialize button visibility for all sections
            @if(isset($profile_sections))
                @foreach($profile_sections as $sections)
                    updateEditModeButtonVisibility('{{$sections->_id}}');
                @endforeach
            @endif
        }

        function removeQues(remove_indexes, dep_ques) {
            for (let i = 0; i < remove_indexes.length; i++) {
                var dep_ques_id = dep_ques[remove_indexes[i]]._id;
                var dep_profile_section_id = dep_ques[remove_indexes[i]].profile_section_id;
                $('#dependency-' + dep_profile_section_id).find('#ques_' + dep_ques_id).remove();
                $('#ques_' + dep_ques_id).hide();
            }
        }

        function addQues(add_indexes, dep_ques) {
            var dependencyQues = $('.profile_ques_dependency').map(function() {
                return $(this).attr('id').split('_')[1];
            }).get();
            // console.log(dependencyQues);
            for (let i = 0; i < add_indexes.length; i++) {
                var dep_profile_section_id = dep_ques[add_indexes[i]].profile_section_id;
                var dep_ques_id = dep_ques[add_indexes[i]]._id;
                var type = '';
                if (dep_ques[add_indexes[i]].type == 'Multi Punch') {
                    type = 'multiple';
                }
                var dep_ques_code = dep_ques[add_indexes[i]].id;
                var dep_ques_text = dep_ques[add_indexes[i]].translated[0]['text'];
                var dep_ques_ans = dep_ques[add_indexes[i]].translated[0]['answers'];
                var dep_profile_section = dep_ques[add_indexes[i]].profile_section;
                var loader_id = $('.load_' + dep_profile_section_id).attr('id');
                if ($('#ques_' + dep_ques_id).is(':hidden')) {
                    $('#ques_' + dep_ques_id).show();
                }

            }
        }
    });
</script>
@endpush