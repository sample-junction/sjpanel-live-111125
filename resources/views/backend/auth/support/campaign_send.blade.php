@extends('backend.layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.css">
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            
        @endif
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <p class="h2 fw-bold">{{ __('Send Campaign Mail') }}</p>
            </div>
        </div>  
        
       

        <div class="row mt-5">
            <div class="col">

                <form class="cf" id="mailform1" action="{{ route('admin.auth.support.campaign-mail') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <a href="{{asset('img/email_temp/demo_file.csv')}}" download>Download Demo File</a><br>
                        <label for="importfile">Choose only CSV File:</label>
                        <input type="file" class="form-control" name="importfile" placeholder="csv or excel">
                    </div>

                    <div>OR</div>
                    <div class="form-group mb-3">
                       <label>{{ __('inpanel.user.support.panelist_id') }}</label>
                        <input type="text" id="panelist_id" name="panelist_id" class="form-control">
                        
                    </div>
                    <br>
                    <div class="form-group" style="text-align:left;">
                    <label for="campaign_id">Campaign</label>
                      <select name="campaign_id" id="campaign_id" class="form-select" aria-label="Default select example">
                        <option value=""selected>Select Campaign</option>
                        @foreach($datas as $data) 
                            <option value="{{$data->id}}" >{{$data->campaign_name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <br>

                    <div class="form-group">
                        <div><a class="btn btn-primary" id="preview" style="display:none;" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Preview</a> 
                    </div>
                        </div>

                        <br>
            
                    <div class="form-group">
                    <label for="subject_line">{{ __('inpanel.user.support.subject_line') }}</label>
                        <input type="text" id="subject_line" name="subject_line" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                    <label for="template_name">Template Name</label>
                        <input type="text" id="template_name" name="template_name" class="form-control" readonly>
                    </div>

                    <div class="form-group mt-3 mb-3 margin-bottom"> 
                        <textarea placeholder="Email Content" id="email_content_new" name="email_content" rows="5" cols="10" class="form-control" style="display:none;"></textarea>
                    </div>



                    <div class="form-group" >
                       <label for="c_type_id">campaign_type</label>
                        <input type="hidden" id="button_text" name="button_text" class="form-control">
                        <input type="text" id="c_type_name" name="c_type_name" class="form-control" readonly>
                    </div>
                    

                    <div class="form-group">
                        <label for="campaign_amount">campaign_amount</label>
                        <input type="number" id="campaign_amount" name="campaign_amount" class="form-control" readonly>
                        
                    </div>
                    <div class="form-group">
                        <label for="campaign_amount">campaign_status</label>
                        <input type="number" id="campaign_status" name="campaign_status" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="campaign_id">Campaign Link</label>
                        <input type="text" id="status_link" name="status_link" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="campaign_start_date">campaign_start_date</label>
                        <input type="text" id="campaign_start_date" name="campaign_start_date" class="form-control" readonly>
                    </div>
                    <div>
                        <input type="hidden" name="url_campaign" value="{{ route('frontend.auth.login') }}">
                    </div>

                    <button  type="submit" value="Email Submit" class="mt-4 mb-4 btn btn-outline-primary fw-bold ps-4 pe-4 pt-2 pb-2">
                        {{ __('inpanel.user.support.email_send') }}
                    </button>
                </form>

            </div>
        </div>

     </div>  
    </div>
    @include('backend.auth.campaign.campaign_model')
    <!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="min-width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div style="margin-left:15%;">
        <div class="content"></div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

    <!-- Modal -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    $(document).ready(function () {

        $('#campaign_id').on('change',function(){
            var id=$(this).val();
            if(id === ""){
                $('#preview').hide();
                $('#edit').hide();
                $('#subject_line').val(' ');
                $('#email_content_new').html('');
                $('#c_type_id').val('');
                $('#c_type_name').val('');
                $('#campaign_amount').val('');
                $('#campaign_status').val('');
                $('#status_link').val('');
                $('#campaign_start_date').val('');
            }else{
                $('#preview').show();
                $('#edit').show();
                $.ajax({
                        url: "{{ route('admin.auth.campaignGetById') }}",
                        method: 'GET',
                        data: { campaign_id: id },
                        success: function (data) {
                            if (data.status === 1 && data.datas) {
                                //alert(data.datas[0].campaign_content);
                                // console.log(data.datas[0].campaign_status);
                                $('#subject_line').val(data.datas[0].campaign_subject);
                                $('#email_content_new').html(data.datas[0].campaign_content);
                                $('#c_type_id').val(data.datas[0].type_id);
                                $('#c_type_name').val(data.datas[0].type);
                                $('#campaign_amount').val(data.datas[0].campaign_amount);
                                $('#campaign_status').val(data.datas[0].campaign_status);
                                $('#status_link').val(data.datas[0].campaign_link);
                                $('#campaign_start_date').val(data.datas[0].campaign_start_date);
                                $('.content').html(data.datas[0].campaign_content);
                                $('#button_text_p').html(data.datas[0].button_text);
                                $('#template_name').val(data.datas[0].template_name);
                                $('#button_text').val(data.datas[0].button_text);
                            } else {
                                console.log('Invalid data format or no data returned.');
                            }
                        },
                        error: function (error) {
                            console.log('Error:', error);
                        }
                    });
            }
        });

    });
</script>
<script>
    $(document).ready(function () {
        $('#mailform1').show();
        $('#mailform2').hide();
    });
       function tempFunc(temp_id){
            // var selectedOption = $(this).val();
            if (temp_id == '1') {
                $('#mailform1').show();
                $('#mailform2').hide();
            } else if (temp_id == '2') {
                $('#mailform1').hide();
                $('#mailform2').show();
            }
        }
    
</script>
    
</body>
@endsection
