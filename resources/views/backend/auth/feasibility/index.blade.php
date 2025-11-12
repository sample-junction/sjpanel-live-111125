@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('Feasibility Criteria'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
<style>
    .toast-error{
        background-color: #bd362f;
    }
    .toast-success{
        background-color: #5cb85c;
    }
</style>
    <div class="card mt-4">
        <div class="card-header">
            Feasibility
        </div>
       <div class="card-body">
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-header bg-primary">
                    Get Feasibility Info
                    </div>
                    <form action="{{route('admin.auth.check-feasibility')}}" method="POST">
                      @csrf
                    <div class="card-body">
                        <div class="row mt-3">
                            <!--<div class="col-2">
                                <label for="">Quota ID</label>
                                <div class="form-group">
                                    <input type="text" class="form-control">
                                </div>
                            </div>-->
                            <div class="col-3">
                            <label for="">Country</label>
                                <div class="form-group">
                                    <select name="country_code" id="country_code" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                          <option value="{{$country->country_code}}">{{$country->country_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                            <label for="">Language</label>
                            <div class="form-group">
                                    <select name="lang_code" id="lang_code" class="form-control">
                                        <option value="">Select Lang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-5">
                                <label for="device">Device</label>
                                <div class="form-group">
                                    <select multiple name="device[]" id="device" class="form-control"  data-placeholder="Select Device">
                                        <!--<option value="" disabled>Select Device</option>-->
                                        <option value="2">DESKTOP/LAPTOP</option>
                                        <option value="3">PHONE/MOBILE</option>
                                        <option value="4">TABLET</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group" style="margin-top:33px;">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" id="set_criteria"> Criteria</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit" id="check_feasibility">Check Feasibility</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
       </div>
    </div><!--card-->

    

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content modal-xl">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Criteria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <input type="hidden" name="selected_criteria" id="selected_criteria">
        <div class="content"></div>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" id="select_criteria">Save</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .th-td-hide{
            display:none;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Add custom styles if needed */
    .toggleBtn {
      cursor: pointer;
    }
  </style>

@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    /*var $j = jQuery.noConflict();
    $j(document).ready(function() {
        $j('#device').select2();
    });*/
$(document).ready(function(){
    $('#device').select2();
    $('#set_criteria').prop('disabled', true);
    $('#check_feasibility').prop('disabled', true);
    $('#lang_code').change(function(){
       // Check if there is an open toastr notification
       if (toastr && toastr.currentlyVisible && toastr.currentlyVisible.length > 0) {
           // Close the currently visible toastr notification
           toastr.clear(toastr.currentlyVisible, { force: true });
       }
        var selectedCountry = $(this).val();
        if(selectedCountry){
              $.ajax({
                url: '{{route("admin.auth.display-criteria")}}',
                method: 'GET',
                data: {lang: selectedCountry},
                success: function(response){
                    // console.log(response);
                    var datas=response;
                    $('.content').html(datas);
                    toastr.success('Criteria is found.', '', {
                        closeButton: true
                    });
                    // $('#question_content').html(datas);
                    $('#set_criteria').prop('disabled', false);
                    $('#check_feasibility').prop('disabled', false);
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                    toastr.error('Criteria is not found.', '', {
                        closeButton: true
                    });
                    $('#set_criteria').prop('disabled', true);
                    $('#check_feasibility').prop('disabled', true);
                }
            });
          }else{
            $('#set_criteria').prop('disabled', true);
            $('#check_feasibility').prop('disabled', true);
          }
    });
    $('#check_feasibility').click(function(){
        var device = $('#device').val();
        var criteria = $('#selected_criteria').val();
        var lang_code = $('#lang_code').val();
        console.log('criteria => ',criteria);
        if(device == '')
        {
            Message="Please select the devices.";
            toastr.error(Message, '', {
                closeButton: true
            });
            return false;
        }
        if(criteria == '')
        {
            Message="Please select the criteria.";
            toastr.error(Message, '', {
                closeButton: true
            }); 
            return false;
        }
        if(lang_code == '')
        {
            Message="Please select the language.";
            toastr.error(Message, '', {
                closeButton: true
            }); 
            return false;
        }
    });
});
</script>

<script>
$(document).ready(function(){
    $('#country_code').change(function(){
        var selectedCountry = $(this).val();
        $('#selected_criteria').val('');
        $('#set_criteria').prop('disabled', true);
        $('#check_feasibility').prop('disabled', true);
        if(selectedCountry){
            $.ajax({
                url: '{{route("admin.auth.Language")}}',
                method: 'GET',
                data: {country_code: selectedCountry},
                success: function(response){
                    console.log(response);
                    $('#lang_code').empty();
                    $('#lang_code').append('<option value="">Select Lang</option>');
                    $.each(response, function(index, item) {
                        $('#lang_code').append($('<option>', { 
                            value: item,
                            text : item 
                        }));
                        //$('#check_feasibility').prop('disabled', false);
                    });

                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                    $('#lang_code').empty();
                    $('#lang_code').append('<option value="">Select Lang</option>');
                    $('#set_criteria').prop('disabled', true);
                    $('#check_feasibility').prop('disabled', true);
                }
            });
        }else{
            $('#lang_code').empty();
            $('#lang_code').append('<option value="">Select Lang</option>');
            $('#set_criteria').prop('disabled', true);
            $('#check_feasibility').prop('disabled', true);
        }
    });

});
</script>


    
@endpush
