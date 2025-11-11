
@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('campaign_history'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
   
   @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>{{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('fail'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong>{{session('fail')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container">
        <div class="row mt-1">
            <div class="col">
               
            </div>
        </div>       

        <div class="row mt-1">
            <div class="col">
               
                <br>
               
                <a class="btn btn-primary" href="{{route('admin.auth.template-detail')}}">Create New Template</a>
                <a class="btn btn-primary" href="{{route('admin.auth.campaign-send')}}">Campaign Mail Send</a>
                <!-- <a class="btn btn-primary" href="{{route('admin.auth.gallery-page')}}">Edit Gallery</a> -->

                <br>

                <div>
                    <div class="card mt-5">
                        <div class="card-header">
                            <center><h2>New Campaign</h2></center>
                        </div>
                        <div class="card-body">
                        <form action="{{route('admin.auth.create-campaign')}}" method="POST">
                            @csrf
                        <div class="form-group">
                            <label for="">Campaign Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="campaign_name">
                        </div>


                        <div class="form-group">
                            <label for="">Campaign template Name</label>
                            <select name="template_id" id="template_id" class="form-select" aria-label="Default select example">
                                    <option value="">Select Template</option>
                                @foreach($datas as $data)
                                    <option value="{{$data->id}}">{{$data->template_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <div><a class="btn btn-primary" id="preview" style="display:none;" href="" data-bs-toggle="modal" data-bs-target="#PreviewModal">Preview</a> <a class="btn btn-primary" id="edit" style="display:none;"  href="">Edit</a></div>
                        </div>

                        
                        <div class="form-group">
                            <label for="">Campaign Subject</label>
                            <input type="text" class="form-control" name="campaign_subject" id="campaign_subject">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="campaign_content" id="template_content">
                            <input type="hidden" name="template_name" id="template_name">
                            <input type="hidden" name="template_type" id="template_type">
                            <label for="">Campaign Amount ($) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="campaign_amount">
                        </div>
                        

                        <div class="form-group">
                            <label for="">Campaign Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="type">
                        </div>

                        <div class="form-group">
                            <label for="">Campaign Link</label>
                            <input type="text" class="form-control" name="campaign_link" id="campaign_link" >
                        </div>

                        <div class="form-group">
                            <label for="">Campaign Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="campaign_start_date" >
                        </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                    
                </form>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    @include('backend.auth.campaign.campaign_model')
    <!-- Modal -->
<div class="modal fade" id="PreviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="min-width:900px!important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div style="margin-left:13%;">
         <div class="body_content_p">
            
         </div>
       </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<div class="card mt-5">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            Campaign Master
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
           
            <div class="row">
                <table class="table table-striped table-hover" id="campaign_table" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Campaign Name</th>
                        <th>Type</th>
                        <th>Campaign Start Date</th>
                        <th>Campaign Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                               @foreach($datas_campaign as $data)
                                @php 
                                    if($data->campaign_status == 1){
                                        $campaign_status = "Active";
                                     }else{
                                        $campaign_status = "Deactive";
                                     }
                                @endphp
                               <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->campaign_name}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>{{$data->campaign_start_date}}</td>
                                    <td><a href="{{route('admin.auth.activate-or-deactive-camp',['id'=>$data->id])}}" class="btn btn-sm btn-{{($data->campaign_status == 1)? 'primary':'danger'}}">{{($data->campaign_status == 1)? 'Active':'Deactive'}}</a></td>
                                    <td>
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.auth.edit-campaign',['id'=>$data->id]) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.auth.show-clone',['id'=>$data->id]) }}"><i class="fa fa-clone"></i></a>
                                    <a class="btn btn-danger btn-sm" href="{{ route('admin.auth.del-campaign',['id'=>$data->id]) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                    
                                </tr>
                               @endforeach
                    </tbody>
                </table>
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
    <script>
        $(document).ready(function() {
            var table = $('#campaign_table').DataTable({
                "processing": true,
                "ordering": false,
                "searching": true,
                "columnDefs": [{
                    "targets": [4],
                    "searchable": true
                }]
            });
            $('#campaign_table_filter').append('<select id="status_filter"><option value="">All</option><option value="Active">Active</option><option value="Deactive">Deactive</option></select>');

            $('#status_filter').on('change', function() {
                var status = $(this).val();
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var rowStatus = data[4];
                        if (status === "") {
                            return true;
                        }
                        if (rowStatus === status) {
                            return true;
                        }
                        return false;
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            });
        });



        $(document).ready(function () {

        $('#template_id').on('change',function(){
        var id=$(this).val();
        if(id === ""){
            $('#preview').hide();
            $('#edit').hide();
        }else{
            $('#preview').show();
            $('#edit').show();
            $.ajax({
                url: "{{ route('admin.auth.get-template') }}",
                type: "GET",
                data: { id: id },
                datatype :"json",
                success: function(data) {
                    console.log(data.data);
                    $('.body_content_p').html(data.data[0].template_content);
                    $('#campaign_link').val(data.data[0].url);
                    var editUrl = "{{ route('admin.auth.edit-template', ['id' => '']) }}" + data.data[0].id;
                    $('#edit').attr('href', editUrl);
                    $('#template_content').val(data.data[0].template_content);
                    $('#template_name').val(data.data[0].template_name);
                    $('#campaign_subject').val(data.data[0].email_subject);
                    $('#template_type').val(data.data[0].template_type);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }       
        });
     });

    </script>
@endpush



 

   

