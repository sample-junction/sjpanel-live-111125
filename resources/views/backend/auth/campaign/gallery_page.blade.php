@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' .'Template Gallery')

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{session('success')}}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@else
  <strong class="text-danger">{{session('fail')}}</strong>
@endif
    <div class="card" style="margin-top:20px">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            Edit Gallery
                        </h4>
                    </label>
                </div>
            </div>
        </div>

  
        <div class="card-body">
<!-- 
        <div class="row">
            <div class="col">
                <img src="{{ asset('storage/img/img_email/1707216188_take survey-img.png') }}" alt="" width="100px">
            </div>
        </div> -->

            <div class="row">
                <form id="gallery_form" method="POST" action="{{ route('admin.auth.support.templateGallary') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div style="margin-bottom: 10px;">
                        <label for="name_img" style="display: block; margin-bottom: 5px; font-weight: bold;">Image Name:</label>
                        <input type="text" name="name_img" id="name_img" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px;" required>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="path" style="display: block; margin-bottom: 5px; font-weight: bold;">Image:</label>
                        <input type="file" name="path" id="path" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px;" required>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="status" style="display: block; margin-bottom: 5px; font-weight: bold;">Status:</label>
                        <select name="status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px;" required>
                            <option value="">Select any status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                
                    <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 3px; cursor: pointer;">Submit</button>
                </form>
            </div>

            <div class="row mt-5">

                <div class="col-12 text-center">

                    <h4 class="fw-bold">Gallery Table</h4>

                </div>

                <div class="col-12">

                    <table class="table table-striped table-hover" id="gallery_table">
                    <thead>
                        <tr>
                        <th scope="col">Sno</th>
                        <th scope="col">Name</th>
                        <th scope="col">Path</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
<!-- 
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td><img src="" alt="img"></td>
                        <td><button>Delete</button></td>
                        </tr> -->

                        @if(!empty($datas))

                            @foreach($datas as $key => $data)

                                <tr>

                                    <td><small>{{$loop->index+1}}</small></td>
                                    <td><small>{{$data['image_name']}}</small></td>
                                    <td><small style="font-size:10px">{{asset($data['path'])}}</small></td>
                                    <td><img src="{{asset($data['path'])}}" alt="img" width="50px"></td>

                                    <td>
                                        {{$data['status']}}
                                     </td>

                                    <td>
                                        <input type="hidden" class="gallery-item-id" value="{{$data->id}}">
                                        <button type="button" class="deleteImgG btn-sm btn-danger btn" value="{{$data['id']}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-trash"></i></button>
                                        <button type="button" class="changeStatus edit_gal btn-sm btn-success btn" data-galId="{{$data->id}}" value="@if($data['status'] == 'active') non-active @else active @endif"><i class="fas fa-edit"></i></button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                             <form action="{{route('admin.auth.support.templateGallarySingle',['id'=>$data->id])}}" method="POST">
                                                @csrf
                                                <h3>Are You sure to Proceed</h3>
                                             
                                            </div>
                                            <div class="modal-footer">
                                           <center> <button type="submit" class="btn btn-danger">Yes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button></center>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                       
                                     
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




    


    <div class="modal fade" id="editGalleryItemModal" tabindex="-1" role="dialog" aria-labelledby="editGalleryItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGalleryItemModalLabel">Edit Gallery Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editGalleryItemForm" method="POST" action="{{ route('admin.auth.support.updateTemplateGallery', ['id' => $data->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="gallery_item_id" id="gallery_item_id">
                        <label for="editNameImg">Image Name:</label>
                        <input type="text" name="edit_name_img" id="editNameImg" class="form-control">
                        <p>Current Status: <span id="currentStatus"></span></p>
                        <label for="editPath">Current Image:</label><br>
                        <div id="currentImage"></div>
                        <label for="editNewPath">New Image:</label>
                        <input type="file" name="path" id="editNewPath" class="form-control"><br>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
    
    @include('backend.auth.campaign.campaign_history_model')
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
