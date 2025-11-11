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
@else
  <strong class="text-danger">{{session('success')}}</strong>
@endif
<div class="card mt-3">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            Survey Reminder Mail Page
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
             <a class="btn btn-primary" href="{{route('admin.auth.show-survey-invite')}}">Back</a>
            <hr>
            <div class="row">
                <div class="col-12 mt-2 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <center><h5>Send Survey Reminder</h5></center>
                        </div>
                        <div class="card-body">
                        <form class="cf" id="mailform1" action="{{ route('admin.auth.send-Survey-Reminder-Mail') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="panelist_id">Survey Number</label>
                        <input type="text" id="survey_code" name="survey_code" class="form-control" placeholder="Enter The Survey Code">
                    </div>
                    <div class="form-group mb-3">
                        <label for="panelist_id">{{ __('inpanel.user.support.panelist_id') }}</label>
                        <select id="panelist_id" name="panelist_id[]" class="form-select form-control" multiple aria-label="multiple select example" multiselect-search="true" multiselect-select-all="true">
                            <option value="">-Select Panelist-</option>
                        </select>
                    </div>
                    <br>

                    <center> <strong>OR</strong> </center>
                    <div class="form-group mt-2 mb-3" >
                        <a href="{{asset('img/email_temp/demo_file.csv')}}" download>Download Demo File</a><br>
                        <label for="importfile">Choose only CSV File:</label>
                        <input type="file" class="form-control" name="importfile" placeholder="csv or excel">
                    </div>

                    <br>

                    <div class="form-group" style="text-align:left;">
                    <label for="campaign_id">Survey Invitation / Reminder Name</label>
                      <select name="campaign_id" id="campaign_id" class="form-select" aria-label="Default select example">
                        <option value=""selected>Select survey reminder</option> 
                        @if(isset($datas))
                        @foreach($datas as $data)
                        <option value="{{$data->id}}">{{$data->campaign_name}}</option>   
                        @endforeach
                        @endif
                      </select>
                    </div>
                    <br>

                    <div class="form-group">
                        <div><a class="btn btn-primary" id="preview" style="display:none;" href="" data-bs-toggle="modal" data-bs-target="#previewModal">Preview</a> 
                    </div>
                        </div>
            
                    <div class="form-group">
                        <label for="subject_line">{{ __('inpanel.user.support.subject_line') }}</label>
                        <input type="text" id="subject_line" name="subject_line" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="template_name">Template Name</label>
                        <input type="text" id="template_name" name="template_name" class="form-control" readonly>
                    </div>

                    <div class="form-group mt-3 mb-3 margin-bottom"> 
                        <input type="hidden" value="" id="email_content_new" name="email_content">
                    </div>



                    <div class="form-group" >
                        <label for="c_type_name">Type</label>
                        <input type="text" id="type_name" name="type_name" class="form-control" readonly>
                    </div>
                    

                    <div class="form-group">
                        <label for="campaign_amount">status</label>
                        <select id="campaign_status" name="campaign_status" class="form-select" aria-label="Default select example">
                            <option value="">select</option>
                        </select>
                    </div>
                   
                   
                    <div>
                        <input type="hidden" name="url_campaign" value="" >
                    </div>

                    <button  type="submit" value="Email Submit" class="mt-4 btn btn-outline-primary fw-bold ps-4 pe-4 pt-2 pb-2">
                        {{ __('inpanel.user.support.email_send') }}
                    </button>
                </form>
                        </div>
                    </div>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   

    <script>
        $(document).ready(function(){
            $('#campaign_id').on('change',function(){
                var id = $(this).val();
                if(id === ""){
                    $('#preview').hide();
                    $('#subject_line').val('');
                     $('#template_name').val('');
                    $('#email_content_new').val('');
                     $('.content').html('');
                     $('#type_name').val('');
                     $('#campaign_status').empty(); 
                    $('#campaign_status').append('<option value="" selected>Select</option>');
                    
                }else{
                    $('#preview').show();
                    $.ajax({
                        type:"GET",
                        data:{id:id},
                        url:"survey-reminder-getById",
                        success:function(res){                            
                          if(res.status === 200){
                            // console.log(res.datas);
                            $('#subject_line').val(res.datas.campaign_subject);
                            $('#template_name').val(res.datas.template_name);
                            $('#email_content_new').val(res.datas.campaign_content);
                            $('.content').html(res.datas.campaign_content);
                            $('#type_name').val(res.datas.type);
                            var campaign_status = res.datas.campaign_status;
                            $('#campaign_status').empty(); 
                            if(res.datas.campaign_status === 0){
                                $('#campaign_status').append('<option value="0" selected>Deactive</option>');
                            } else {
                                $('#campaign_status').append('<option value="1" selected>Active</option>');
                            }

                          }
                        }
                    });
                }
            });

            $('#survey_code').on('input', function() {
                var code = $(this).val();
                $.ajax({
                    url: "survey-details-ByCode", 
                    type: "GET",
                    data: { code: code },
                    dataType: "json",
                    success: function(res) {
                        console.log(res.datas);
                        $('#panelist_id').empty();
                        $('#panelist_id').append('<option value="select-all">Select All</option>');
                        $.each(res.datas, function(index, value) {
                            $('#panelist_id').append('<option value="' + value.panellist_id + '">' + value.panellist_id + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });


          
            $('#panelist_id').select2();

            $('#panelist_id').on('select2:select', function(e) {
                var data = e.params.data;
                if (data.id === 'select-all') {
                    $('#panelist_id').find('option[value!="select-all"]').prop('selected', 'selected');
                    $('#panelist_id').trigger('change');
                    $('#panelist_id').find('option[value="select-all"]').prop('selected', false);
                    $('#panelist_id').trigger('change');
                }
            });

            $('#panelist_id').on('select2:unselect', function(e) {
                var data = e.params.data;
                if (data.id === 'select-all') {
                    $('#panelist_id').find('option').prop('selected', false); // Unselect all options
                    $('#panelist_id').trigger('change');
                }
            });



      });
    </script>
    
@endpush




 
