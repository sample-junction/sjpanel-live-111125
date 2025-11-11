backend/@extends('backend.layouts.app')

@section('content')

    <div class="card" style="margin-top:20px">
  
        <div class="card-body">

            <div class="row mt-5">

                <div class="col-12 text-center">

                    <h4 class="fw-bold">Panelist Upload Table</h4>

                </div>

                <div class="col-12">

                    <table class="table table-striped table-hover" id="gallery_table">
                    <thead>
                        <tr>
                        <th scope="col">Sno</th>
                        <th scope="col">Panelist Id</th>
                        <th scope="col">Firstname</th>
                        <th scope="col">File</th>
                        <th scope="col">Upload Time</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(!empty($datas))

                            @foreach($datas as $key => $data)
							
								@php
									$explodedValues = explode('/', $data['path']);
									$extension = pathinfo($explodedValues[1], PATHINFO_EXTENSION);
									$allowedExtensions = ["mp4", "avi", "mov", "mkv", "wmv"];
								@endphp

                                <tr>
                                    <td><small>{{$loop->index+1}}</small></td>
                                    <td><small>{{$data['panelist_id']}}</small></td>
                                    <td><small>{{$data['firstname']}}</small></td>
                                    <!--<td><small style="font-size:10px">{{asset($data['path'])}}</small></td>-->
                                    <td>
									
										@if (in_array(strtolower($extension), $allowedExtensions))
											<a href="{{asset($data['path'])}}" target="_blank">{{asset($data['path'])}}</a><br>
										
										@else
											<a href="{{asset($data['path'])}}" target="_blank" > <img src="{{asset($data['path'])}}" alt="img" width="50px"> </a>
										@endif
										
									</td>
									<td>
										@php										
											echo date('d F Y',strtotime($data['created_at']));
										@endphp
									</td>
                                </tr>

                            @endforeach

                        @endif
 
                    </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div><!--card-->

    
@endsection
@push('after-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .toast-error {
                background-color: red!important;
            }
    </style>
@endpush

@push('after-scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


 <!-- Add this script after the jQuery and Bootstrap scripts -->
<!-- Add this script after the jQuery and Bootstrap scripts -->
<script>
    $(document).ready(function() {
        // Event listener for edit button click
        $(document).on('click', '.changeStatus', function() {
            // Extract gallery item details
            var itemId = $(this).data('id');
            var currentStatus = $(this).data('status');

            // Populate modal with item details
            $('#editGalleryItemId').val(itemId);
            $('#currentStatus').text(currentStatus);

            // Show the modal
            $('#editGalleryItemModal').modal('show');
        });
    });
</script>

<script>
$(document).ready(function() {
    var table = $('#gallery_table').DataTable({
        "processing": true,
        "ordering": false
    });

    // Append select dropdown for filtering by status
    $('#gallery_table_filter').append('<select id="status_filter"><option value="">All</option><option value="active">Active</option><option value="inactive">Inactive</option></select>');

    // Event listener for status filter change
    $('#status_filter').on('change', function() {
        var status = $(this).val();

        // Apply filter based on selected status
        table.column(4)
            .search(status === '' ? '' : '^' + status + '$', true, false)
            .draw();
    });
});

</script> 
@endpush
