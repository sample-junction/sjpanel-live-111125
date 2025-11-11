@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')


<style>
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background-color: #f0f0f0;
        border-radius: 5px;
        font-weight: bold;
        color: #333;
    }

    .custom-file-upload:hover {
        background-color: #e0e0e0;
    }
</style>

@section('content')

<div class="container mt-5">
	@if (session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	
	@if (session('error'))
		<div class="alert alert-error alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	<!-- Your form or other content here -->
</div>

	<form action="{{ route('admin.auth.invite.fresh') }}" method="POST" enctype="multipart/form-data">
	@csrf

	<div class="card">
		<div class="card-header">
			<label>
				<h4>
					{{__('Fresh Invite Send Mail')}}
				</h4>
			</label>   
		</div>
		<div class="card-body">
		
			<div class="row">
				<!--<div class="col-md-4">
					<label for="batchNumber">Batch Name:</label>
					<input type="text" id="batchNumber" name="batch_number">			
				</div>-->
				<div class="col-md-10">
					<input type="file" name="csv_file" id="fileInput" style="display: none;"/>
					<input type="hidden" name="button_name" id="buttonName" value="Submit">

					<label for="fileInput" id="uploadButton" class="custom-file-upload btn btn-primary">Upload Fresh Invite</label>
					<button type="submit" id="submitButton" class="btn btn-primary" style="display: none;">Fresh Invite Send Mail</button>
				</div>
				<div class="col-md-2">
					<a href="{{asset('sample_fresh_invite.csv')}}" download="sample_fresh_invite.csv">
					    <button type="button" class="btn btn-primary">Dowonload Sample File</button>
				    </a>
				</div>
			</div>
			
			
			<div class="row mt-5 listingDiv">
				<div class="col">			
					<div class="table-responsive">
						<table class="table" id="emailsSentTable">
							<thead>
							<tr>
								<th>Batch Number</th>
								<th>Fresh Invites Sent</th>
								<th>Time</th>      
								<th>Action</th>							
							</tr>
							</thead>
							<tbody>
								@foreach($recentEmailsSent as $recentEmailsSentData)
									@php
										$date = $recentEmailsSentData->email_sent_at;
										$formattedDate = date('d-m-Y', strtotime($date));
									@endphp
								<tr>
								<td>{{ucwords($recentEmailsSentData->batch_number)}}</td>
								<td>{{$recentEmailsSentData->count.' '.'Fresh Invites Sent '}}</td>
								<td>{{$date}}</td>
								<td>
									<a id="reminderButton" onclick="sendReminder('{{$recentEmailsSentData->batch_number}}')" href="javascript::void()" class="btn btn-primary"><i class="fas fa-paper-plane" title="Send Reminder"></i></a> | <a id="reminderButton" href="{{ route('admin.auth.invite.viewFresh', ['batch' => encrypt($recentEmailsSentData->batch_number)]) }}" target="_blank" class="btn btn-primary"><i class="fas fa-eye icon-red" title="View Fresh Invites" style="color: green;"></i></a> | <a id="reminderButton" href="{{ route('admin.auth.invite.viewReminder', ['batch' => encrypt($recentEmailsSentData->batch_number)]) }}" target="_blank" class="btn btn-primary"><i class="fas fa-eye icon-red" title="View Send Reminders" style="color: blue;"></i></a>
								</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div> 
			</div> <!-- .listingDiv -->	
		</div>   
		
	</div>

	</form>

@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
@endpush

@push('after-scripts')
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>

<script>
    var fileInput = document.getElementById('fileInput');
    var uploadButton = document.getElementById('uploadButton');
    var submitButton = document.getElementById('submitButton');

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            uploadButton.innerText = "Upload Fresh Invite";
            submitButton.style.display = "inline-block";
            uploadButton.style.display = "none";
        }
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#emailsSentTable').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            search: {
                regex: true,
            },
            'processing': true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
            "ordering": true,
        });
        $(".dataTables_wrapper").css("width","100%");
        //$('.dataTables_filter').before($('#emailsSentTable thead tr:first'));
        table.draw();
    });
	
	function sendReminder(batch_number){
        let formData = new FormData();
        formData.append('batch_number', batch_number);
        $.ajax({
            url : '{{ route("admin.auth.invite.reminder") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:  formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType:'json',
            success : function (result) {
                if(result.status == true){
                    alert(result.message);
                    window.location.reload();
                }else{
                	alert(result.message);
                }
            }
        });
    }
</script>


@endpush