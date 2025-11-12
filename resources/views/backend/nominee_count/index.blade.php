@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('Nominee Count'))

@section('content')

@push('after-styles')
<style>
	.container {
		padding-top: 50px;
	}
	.box {
		border: 1px solid #ccc;
		padding: 20px;
		margin-bottom: 20px;
		cursor: pointer;
		text-align: center;
		font-weight: bold;
		background-color: #20a8d8;
	}
    .textbox-container {
        margin-top: 10px;
    }
</style>
@endpush
		<div class="card-header">
			<strong>@lang('Nominee Count Generator')</strong>
		</div><!--card-header-->
<div class="container">
    <div class="row">

        <div class="col-md-4">
            <div class="box" onclick="showValue(1)">Profile Prodegy</div>
            <div class="textbox-container">
                <input type="text" id="textbox1" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="box" onclick="showValue(2)">Survey Superstar</div>
            <div class="textbox-container">
                <input type="text" id="textbox2" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="box" onclick="showValue(3)">Most Active Panelists</div>
            <div class="textbox-container">
                <input type="text" id="textbox3" class="form-control">
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
    function showValue(divNumber) {
		
		var textBoxId = "#textbox" + divNumber;
		
		var condition = $("#condition").val(); // Get the value of the condition input field
        var randomNumber;

        // Check the condition
        if (divNumber === 1) {
            // Generate random number between 1000 and 2000
            randomNumber = Math.floor(Math.random() * (2000 - 1000 + 1)) + 1000;
			/* assign value to the textbox */			
			$(textBoxId).val(randomNumber);
        } else if (divNumber === 2){
            // Generate random number between 10000 and 11000
            randomNumber = Math.floor(Math.random() * (11000 - 10000 + 1)) + 10000;
			/* assign value to the textbox */			
			$(textBoxId).val(randomNumber);
        }else {
            // Generate random number between 80000 and 90000
            randomNumber = Math.floor(Math.random() * (90000 - 80000 + 1)) + 80000;
			/* assign value to the textbox */			
			$(textBoxId).val(randomNumber);
        }
        //alert("Random Number: " + randomNumber);
    }
</script>
@endpush
