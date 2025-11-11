@extends('backend.layouts.app')

@section('title', __('labels.backend.access.questions_answers.management') . ' | ' . __('labels.backend.access.questions_answers.edit'))

@section('breadcrumb-links')
    @include('backend.auth.question_answer.includes.breadcrumb-links')
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('content')
{{ html()->modelForm($countryPoint, 'PUT', route('admin.auth.setting.countries_update', $countryPoint->id))->class('form-horizontal')->id('myForm')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        <!--Country Points -->						
                        <small class="text-muted">Update Country Point</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class = "col-md-3" >                       
                    <div class = "form-group" >
                        <label for="">Country:</label>
                        <!--<input  name="locale" id="locale" class="form-control required">-->
                        <select name="country" id="country_code" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                @php
                                 $selected = ($country->name == $countryPoint->country) ? 'selected' : '';
                                @endphp
                                @if(!empty($country->currency_code))
                                    <option data-currency="{{$country->currency_code}}" data-country_code="{{$country->country_code}}" value='{{$country->name}}' {{ $country->name == $countryPoint->country ? 'selected' : '' }}>{{$country->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div >
                </div>
                <div class = "col-md-3" >
                    <div class = "form-group" >
                        <label for="">Language:</label>
                        <!--<input  name="locale" id="locale" class="form-control required">-->
                        <select name="country_language" id="lang_code" class="form-control">
                            <option value="">Select Language</option>
                        </select>
                    </div >
                </div>
                <div class = "col-md-3" >
                    <div class = "form-group" >
                        <label for="">Currency:</label>
                        <input  name="currency" id="currency" readOnly class="form-control required" value="{{$countryPoint->currency}}">
                    </div >
                </div>
                <div class = "col-md-3" >
                    <div class = "form-group" >
                        <label for="">Point:</label>
                        <input  name="points" id="points" class="form-control numbersOnly required" value="{{$countryPoint->points}}">
                    </div >
                </div>          
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.setting.countries_points'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {!! Form::button(__('buttons.general.crud.update'), ['type' => 'submit', 'class' => 'btn btn-success btn-sm pull-right', 'id' => 'update_button']) !!}

                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
@push('after-scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

$(document).ready(function() {
	$('.select2').select2();
	setTimeout(function() {
        $('#country_code').trigger('change');
    }, 100); // Adjust the timeout as needed
});

$(document).ready(function(){
	$('#country_code').select2();
	var selectedCountry = $('#country_code').find('option:selected').data('country_code');
	console.log('selectedCountry--'+selectedCountry);
   
    /* $('#country_code').val(selectedCountry).trigger('change'); */
    $('.numbersOnly').on('keydown', function(e) {
		var key = e.which || e.keyCode;

		// Allow specific keys
		if (key === 8 || key === 46 || key === 9 || key === 27 || key === 13 || 
		  (key >= 37 && key <= 40)) {
		  return; // Allow these keys
		}

		// Block non-numeric keys
		if (key < 48 || key > 57) {
		  e.preventDefault(); // Block the keypress
		}
	}).on('keypress', function(e) {
		var char = String.fromCharCode(e.which || e.keyCode);

		// Allow only numeric characters
		if (!/^\d$/.test(char)) {
		  e.preventDefault(); // Block the character
		}
	}).on('input', function() {
		var inputVal = $(this).val();
		var isValid = /^\d*$/.test(inputVal); // Check if input is digits only

		if (isValid) {
		  $(this).addClass('valid').removeClass('invalid');
		} else {
		  $(this).addClass('invalid').removeClass('valid');
		}
	});
		  
    //$('#country_code').change(function(){
	$('#country_code').on('change', function() {
        //var selectedCountry = $(this).find('option:selected').data('country_code');
        var selectedCountry = $('#country_code').find('option:selected').data('country_code');
        var currency_code = $(this).find('option:selected').data('currency');
        console.log('currency_code => ',currency_code);
        $.ajax({
            url: '{{route("admin.auth.Language")}}',
            method: 'GET',
            data: {country_code: selectedCountry},
            success: function(response){
                $('#currency').val(currency_code);
                console.log(response);
				// Pass the PHP variable to JavaScript
				var selectedLang = "{{ $countryPoint->country_language }}"; 
                $('#lang_code').empty();
                $('#lang_code').append('<option value="">Select Language</option>');
                $.each(response, function(index, item) {
					
					// Split the string into two parts
					var parts = item.split("-");

					// Convert the first part to lowercase and the second part to uppercase
					var result = parts[1].toLowerCase() + "_" + parts[0].toUpperCase();
					
					var isSelected = result === selectedLang; // Compare with the PHP value
                    $('#lang_code').append($('<option>', { 
                        value: result,
                        text : item,
						selected: isSelected
                    }));
                });

            },
            error: function(xhr, status, error){
                // Handle errors
                console.error(error);
            }
        });
    });

});
</script>
@endpush