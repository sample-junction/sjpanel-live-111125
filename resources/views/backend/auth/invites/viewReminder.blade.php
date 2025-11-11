@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('content')

<div class="card mt-2">
	<div class="card-header">
        <label>
            <h4>
                {{__('View Reminder Invitation')}}
            </h4>
        </label>   
    </div>
   
    <div class="card-body">
		<table id="reminderTable" class="display table" style="width:100%">
			<thead>
				<tr>
					<th>Email</th>
					<th>Batch Number</th>
					<th>Reminder Interval</th>
					<th>Reminder Send At</th>
				</tr>
			</thead>
			<tbody>
				@foreach($reminder_records as $reminder_record)
				<tr>
					<td>{{ $reminder_record->email }}</td>
					<td>{{ ucwords($reminder_record->batch_number) }}</td>
					<td>{{ $reminder_record->reminder_count }}</td>
					<td>{{ $reminder_record->reminder_sent_at }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>	
    </div>
</div>



@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
@endpush
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


<script>
    $(document).ready(function() {
        $('#reminderTable').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            search: {
                regex: true,
                caseInsensitive: false
            },
            'processing': true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
            buttons:[
                {
                    extend: 'excel',
                    // exportOptions: {
                    //     columns: ':not(:last-child):not(:nth-child(3))'
                    // }
                },
                {
                    extend: 'csv',
                    // exportOptions: {
                    //     columns: ':not(:last-child):not(:nth-child(3))'
                    // }
                }
            ],
           
        });
        //$(".dataTables_wrapper").css("width","100%");
    });
</script>
@endpush