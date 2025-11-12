@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' .'Pull Invite Duration')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

           <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Setting <small class="text-muted">Pull Invite Duration</small>
                </h4>
            </div><!--col-->
            <!-- <div class="col-sm-7">
                <a href="{{route('admin.auth.reports.incentive')}}" class="btn btn-info" style="float: right;margin-left: 10px;">Reset</a>&nbsp;&nbsp;
                <button type="button" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#bulkSearch">Bulk Search</button>
            </div> -->
        </div><hr>
        <!--<form action="{{route('admin.auth.reports.incentive')}}" method="get" id="filterdata">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>From Date</span>
                        <input type="date" name="fromDate" id="" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>To Date</span>
                        <input type="date" name="toDate" id="" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                    </div>
                </div>
            </div>
        </form>-->
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th class="text-center">Survey ID</th>
                            <th  class="text-center">Country</th>
                            <th  class="text-center">Status</th>
                            <th  class="text-center">Launch Date</th>
                            <th  class="text-center">Invite Duration</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                           
                        @foreach($livesurveys as $key => $result)

                        @if(count($livesurveys) > 0)
                            <tr>
                                 <td  class="text-center" id="survey_{{ $key }}">{{ $result->apace_project_code }}</td>
                                 <td  class="text-center">{{ $result->country_code }}</td>
                                 <td  class="text-center">{{ $result->survey_status_code }}</td>
                                 <td  class="text-center">{{ $result->created_at }}</td>


                                    
                                <td  class="text-center">
                                    <input type="checkbox" class="btn-check survey_{{ $key }}" value="0" onclick="setPullInvites(this,this.value, survey_{{ $key }})" id="btncheck" autocomplete="off" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Set invite hours to 0" 
                                    @foreach($zero_pull_invite_surveys as $zero_pulled)

                                        @if($zero_pulled->apace_survey_code == $result->apace_project_code) 

                                            @php echo'checked'; @endphp

                                        @endif 

                                    @endforeach   
                                    >
                                </td>            
               
                            </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->


<div class="modal fade in bulkSearch" tabindex="-1" role="dialog" id="bulkSearch" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog modal-lg invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 class="modal-title"></h3>
            </div>
            <form action="{{route('admin.auth.reports.incentive')}}" method="post">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Search Type</span>
                                <select name="searchType" id="searchType" class="form-control" required>
                                    <option value="">Select Search Type</option>
                                    <option value="uuid" selected>UUID</option>
                                    <!-- <option value="panelists_id">Panelists Id</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Insert Data For Search</span>
                                <textarea name="userids" class="form-control" placeholder="Enter Data (ex-1,2,3,4)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" class="btn btn-primary" style="margin-right: 20px;">Apply</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->
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

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        $(document).ready(function() {
            $('#user_management').DataTable({
                serverSide: false,
                stateSave: true,
                destroy: true,
                'processing': true,
                dom: 'Bfrtip',
                order: [[0, 'desc']],
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],
                buttons: [
                    'excel', 'csv'
                ],
            });
            $(".dataTables_wrapper").css("width","100%");
        } );





        function setPullInvites(element, value, surveyId){

          var survey = surveyId.innerText;

          checkBox = element;

          if(checkBox.checked){

            $.ajax({
                        url: "{{ route('admin.auth.setting.pull_invite_duration_save') }}",
                        type: 'POST',
                        data: { query:survey, _token: '{{csrf_token()}}' },
                        dataType: 'JSON',

                        success: function (response) { 

                            console.log(response.data);

                        },
                        error: function (data, textStatus, errorThrown) {

                            console.log(data);

                        }
                }); 

          }else{

            $.ajax({
                        url: "{{ route('admin.auth.setting.pull_invite_duration_delete') }}",
                        type: 'POST',
                        data: { query:survey, _token: '{{csrf_token()}}' },
                        dataType: 'JSON',

                        success: function (response) { 

                            console.log(response.data);

                        },
                        error: function (data, textStatus, errorThrown) {

                            console.log(data);

                        }
                }); 

          }



        }


    </script>
@endpush
