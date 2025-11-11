@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('Feasibility Criteria'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            Feasibility
        </div>
       <div class="card-body">
        <table class="table">
                    <thead class="bg-primary">
                        <tr>
                            <th class="bg-primary" colspan="5" style ="text-align: center;">SJPanel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Country</th>
                            <th>Language</th>
                            <th>Device</th>
                            <th>Criteria</th>
                            <th>
                                Available Panelist
                                <!--<table>
                                <tr>
                                    <th class="bg-primary">Feasibility</th>
                                    <th class="bg-primary">Assumption</th>
                                </tr>
                                </table>-->
                            </th>
                        </tr>
                        <tr>
                            <td>{{ $search['country_code'] }}</td>
                            <td>{{ $search['lang_code'] }}</td>
                            <td>
                               @if(!empty($search['device']))
                                    @if(in_array('2',$search['device']))
                                        DESKTOP/LAPTOP
                                    @endif
                                    @if(in_array('3',$search['device']))
                                        PHONE/MOBILE
                                    @endif
                                    @if(in_array('4',$search['device']))
                                        TABLET
                                    @endif
                                @else 
                                    Not Set     
                               @endif
                            </td>
                            <td>
                                @if(!empty($search['selected_criteria']))
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" id="set_criteria"> Criteria</button></td>
                                 @else
                                    No Criteria
                                 @endif
                            <td>
                                {{ count($panelist) }}
                                    <!--<div class="row">
                                        <div class="col-6">
                                            {{ count($panelist) }}
                                        </div>
                                        <div class="col-6">
                                            {{ count($panelist) }}
                                        </div>
                                    </div>-->
                            </td>
                        </tr>
                    </tbody>
                </table>
            @if(!empty($search))
             <div class="row  mb-4">
                <div class="col-sm-10">
                    <!-- Content for col-sm-10 -->
                </div>
                <div class="col-sm-2 text-right">
                    <a style="margin-top: 24px;" href="{{ route('admin.auth.show-feasibility') }}" class="btn btn-sm btn-secondary" id="resetFilter">Reset Filter</a>
                </div>
            </div>
            @endif    
            <table class="table" id="user_management">
                <thead>
                    <tr>
                        <th>@lang('labels.backend.access.users.table.panelistid')</th>
                        <th>@lang('labels.backend.access.users.table.uuid')</th>
                        <th>@lang('labels.backend.access.users.table.first_name')</th>
                        <th>@lang('labels.backend.access.users.table.last_name')</th>
                        <th>@lang('labels.backend.access.users.table.age')</th>
                        <th>@lang('labels.backend.access.users.table.gender')</th>
                        <th>@lang('labels.backend.access.users.table.Last_login')</th>
                        <th>@lang('labels.backend.access.users.table.unsubscribed')</th>
                        <th>@lang('labels.backend.access.users.table.SOI')</th>
                        <th>@lang('labels.backend.access.users.table.DOI')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($panelist as $key=>$user)
                        <tr>
                            <td>{{ $user->panellist_id }}</td>
                            <td>{{ $user->uuid }}</td>
                            <td class="td-th-hide">{{$user->first_name}}</td>
                            <td class="td-th-hide">{{$user->last_name}}</td>
                            <td>{{$user->age }}</td>
                            <td>
                                <!--{{$user->gender }} -->                                
                                @if( strtolower($user->gender) == 'homme' || strtolower($user->gender) == 'masculino' || strtolower($user->gender) == 'male')
                                {{ 'Male' }}
                                @elseif( strtolower($user->gender) == 'femme' || strtolower($user->gender) == 'femenina' || strtolower($user->gender) == 'female' || strtolower($user->gender) == 'hembra')
                                {{ 'Female' }} 
                                @else   
                                {{ $user->gender }} 
                                @endif                                
                            </td>
                            <td>{!! optional($user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at) : null)->diffForHumans() !!}</td>
                            <td>
                                @if($user->unsubscribed == 1)
                                    <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                @else
                                <span class="badge badge-danger" style="padding: 5px;">No</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                            <td>
                                @if($user->confirmed == 1)
                                    <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                @else
                                <span class="badge badge-danger" style="padding: 5px;">No</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div><!--card-->
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
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@push('after-scripts')
{{-- For DataTables --}}
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        /*$('#set_criteria').prop('disabled', true);
        var selectedCountry = "{{ $search['lang_code'] }}";
        var selected_criteria = "{{ $search['selected_criteria'] }}";
        if(selected_criteria != ''){
              $.ajax({
                url: '{{route("admin.auth.display-criteria")}}',
                method: 'GET',
                data: {lang: selectedCountry,selected_criteria:selected_criteria},
                success: function(response){
                    // console.log(response);
                    var datas=response;
                    $('.content').html(datas);
                    $('#set_criteria').prop('disabled', false);
                    // $('#question_content').html(datas);

                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                }
            });
        }*/
        $('#set_criteria').prop('disabled', true);
        var selectedCountry = "{{ $search['lang_code'] }}";
        var selected_criteria = "{{ $search['selected_criteria'] }}";

        if (selected_criteria != '') {
            $.ajax({
                url: '{{ route("admin.auth.display-selected-criteria") }}',
                method: 'POST',
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    lang: selectedCountry,
                    selected_criteria: selected_criteria
                },
                success: function(response) {
                    $('.content').html(response); // Assuming the response is HTML
                    $('#set_criteria').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log detailed error message
                    alert('An error occurred while fetching criteria.'); // Show user-friendly message
                    $('#set_criteria').prop('disabled', false);
                }
            });
        }
        $('#user_management').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            'processing': true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100,'All'],
            ],
            buttons: [
                'excel', 'csv'
            ],
        });
        $(".dataTables_wrapper").css("width","100%");
    });
</script>
@endpush