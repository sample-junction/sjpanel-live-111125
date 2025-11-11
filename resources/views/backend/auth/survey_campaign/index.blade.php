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
@endif
<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-10">
                <label>
                    <h4>
                        Survey Reminder
                    </h4>
                </label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <a class="btn btn-primary" href="{{route('admin.auth.show-suvery-temp-detail')}}">Create New Template</a>
        <a class="btn btn-primary" href="{{route('admin.auth.show-send-survey-reminder')}}">Send Survey Invitation / Reminder Mail</a>
        <hr>
        <div class="row">
            <div class="col-12 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <center><h5>Create Survey Invitation / Reminder</h5></center>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.auth.survey-reminder-create')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Survey Invitation / Reminder Name</label>
                                <input type="text" class="form-control" name="campaign_name" placeholder="Enter Survey Reminder Name">
                            </div>
                            <div class="form-group">
                                <label for="">Survey template Name</label>
                                <select name="template_id" id="template_id" class="form-select" aria-label="Default select example">
                                    <option value="" selected>Select Template</option>   
                                    @foreach($datas as $data)
                                    <option value="{{$data->id}}">{{$data->template_name}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div><a class="btn btn-primary" id="preview" style="display:none;" href="" data-bs-toggle="modal" data-bs-target="#previewModal">Preview</a> </div>
                            </div>
                            <div class="form-group">
                                <label for="">Survey Subject</label>
                                <input type="text" class="form-control" name="campaign_subject" id="campaign_subject">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="template_content" id="template_content">
                                <input type="hidden" name="template_name" id="template_name">
                                <input type="hidden" name="template_type" id="template_type">
                            </div>
                            <div class="form-group">
                                <label for="">Type</label>
                                <select name="type" id=""  class="form-select" aria-label="Default select example">
                                    <option value="">Select Type</option>
                                    <option value="Survey">Survey</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-striped table-hover" id="survey_table" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Survey Invitation / Reminder Name</th>
                            <th>Template Name</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas2 as $data2)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$data2->campaign_name}}</td>
                            <td>{{$data2->template_name}}</td>
                            <td>{{$data2->campaign_subject}}</td>
                            <td><a href="{{route('admin.auth.active-deactive-survey',['id'=>$data2])}}" class="btn btn-sm btn-{{($data2->campaign_status == 1)? 'primary':'danger'}}">{{($data2->campaign_status == 1)? 'Active':'Deactive'}}</a></td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{route('admin.auth.show-edit-survey-reminder',['id'=>$data2->id])}}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-secondary btn-sm" href="{{route('admin.auth.show-clone-survey-reminder',['id'=>$data2->id])}}"><i class="fas fa-clone"></i></a>
                                <a class="btn btn-danger btn-sm" href="{{route('admin.auth.del-survey-reminder',['id'=>$data2->id])}}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--card-->

<!-- Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin-left:15%;">
                <div class="content">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
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
    var table = $('#survey_table').DataTable({
        "processing": true,
        "ordering": false,
        "searching": true,
        "columnDefs": [{
            "targets": [4],
            "searchable": true
        }]
    });

    $('#survey_table_filter').append('<select id="status_filter"><option value="">All</option><option value="Active">Active</option><option value="Deactive">Deactive</option></select>');

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
        $.fn.dataTable.ext.search.pop(); // Remove the custom search function after redrawing
    });

    $('#template_id').on('change', function() {
        var id = $(this).val();
        if (id === '') {
            $('#preview').hide();
            $('#edit').hide();
        } else {
            $('#preview').show();
            $('#edit').show();
            $.ajax({
                type: "GET",
                url: "get-survey-temp-byid", 
                data: { id: id }, 
                dataType: 'json',
                success: function(res) {
                    console.log(res.datas);
                    if(res.status === 200){
                        $('#campaign_subject').val(res.datas[0].email_subject);
                        $('#template_name').val(res.datas[0].template_name);
                        $('#template_content').val(res.datas[0].template_content);
                        $('.content').html(res.datas[0].template_content);
                        $('#template_type').val(res.datas[0].template_type);
                    }
                },
                error: function(xhr, status, error) {
                    
                }
            });
        }
    });
});

    </script>
@endpush
