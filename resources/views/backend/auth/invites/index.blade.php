@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <label>
            <h4>
                {{__('Email Validation')}}
            </h4>
        </label>
    </div>

    <form id="csvForm" method="post" action="{{route('admin.auth.invite.upload')}}" enctype="multipart/form-data">
               @csrf
               <input type='file' id='csv_file' style="display: none;" name='csv_file' />
    </form>
    <form id="exportFaultyDataForm" method="post" action="{{route('admin.auth.invite.export-faulty')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name='faulty_data' id='faulty_data' @if((session()->has('duplicateEmails')))value="{{json_encode(session('duplicateEmails'))}}" @endif/>
    </form>
    <form id="exportValidatedDataForm" method="post" action="{{route('admin.auth.invite.export-validated')}}" enctype="multipart/form-data">
        @csrf
        {{--<input type="hidden" name='faulty_data' id='faulty_data' @if((session()->has('duplicateEmails')))value="{{json_encode(session('duplicateEmails'))}}" @endif/>--}}
    </form>
    <form id="sendBulkMail" method="post" action="{{route('admin.auth.invite.send-bulk-mails')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name='mail_limit_min' id='mail_limit_min' value="1" />
        <input type="hidden" name='mail_limit_max' id='mail_limit_max' value="500" />
        <input type="hidden" name="is_reminder" id="is_reminder" value="" />
    </form>
    <form id="exportBulkSuccessDataForm" method="post" action="{{route('admin.auth.invite.export-bulk-success')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name='success_email_data' id='success_email_data' @if((session()->has('successEmails')))value="{{json_encode(session('successEmails'))}}" @endif/>
    </form>
    <form id="exportBulkFailDataForm" method="post" action="{{route('admin.auth.invite.export-bulk-fail')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name='fail_email_data' id='fail_email_data' @if((session()->has('failedEmails')))value="{{json_encode(session('failedEmails'))}}" @endif/>
    </form>
    <div class="card-body">
        <div class="row">
        <div class="col-lg-6 col-md-7 col-sm-8">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <button type="button" id='btn-upload' class="form-control photo_upload btn btn-info">Upload CSV{{--__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')--}}</button>
                <button type="button" id='btn-upload_save' class="form-control photo_upload btn btn-info" style="display:none;">Submit{{--__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')--}}</button>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ route('admin.auth.invite.downloadsampleCSV') }}">
                    <button type="button" id='btn-download' class="form-control photo_upload btn btn-info">Download Sample File{{--__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')--}}</button>
                </a>   
            </div>
        </div>
            <!-- <div class="row mt-3">
                <div class="col-md-6">
                </div>
            </div> -->
            
        </div>
        <div class="col-lg-6 col-md-5 col-sm-4">
		<!-- Parshant [25-06-2024] start-->
            <button type="button" class="btn btn-info" style="float: right;margin-right: 10px;" id="btn_exportData">Export Data</button>
            <!-- <button type="button" class="btn btn-info" style="float: right;margin-right: 11px" id="btn_sendBulkMail">Send Bulk Mail</button>
            <button type="button" id='btn-export-faulty' class="btn btn-info" style="float: right;margin-right: 12px; @if(!(session()->has('duplicateEmails'))) display:none; @endif" >Export Faulty Mails</button> --> 
		<!-- Parshant [25-06-2024] end-->
        </div>
        </div>
        <div style="float:right; margin-right: 220px ">
		<!-- Parshant [25-06-2024] start-->
          <!--  <label for="reminder_chk">  
                <input type="checkbox" id="reminder_chk" style="margin-top:15px;">
                Send Reminders
            </label> -->
		<!-- Parshant [25-06-2024] end-->	
        </div>
        <div class="row mt-5" @if(!(session()->has('duplicateEmails'))) style="display:none;" @endif>
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="faulty_emails">
                        <thead>
                        <tr>
                            <th colspan="3">Rejected Data</th>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email ID</th>
                            <th>Mobile No.</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @if((session()->has('duplicateEmails')))
                            @foreach(session('duplicateEmails') as $duplicate)
                            <tr>
                            <td>{{$duplicate['first_name']}}</td>
                            <td>{{$duplicate['last_name']}}</td>
                            <td>{{$duplicate['email']}}</td>
                            <td>{{$duplicate['mob']}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-5" @if(!(session()->has('successEmails')) || (count(session('successEmails')) == 0)) style="display:none;" @endif>
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="success_emails">
                        <thead>
                        <tr>
                            <th colspan="3">Mail sent Data</th>
                        </tr>
                        <tr>
                            <th>Serial</th>
                            <th>Email ID</th>
                            <th>Mail Sent At</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @if((session()->has('successEmails')))
                            @foreach(session('successEmails') as $success)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$success['Mail']}}</td>
                            <td>{{$success['Sent_At']}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-9">
                    <button type="button" class="btn btn-info" style="float: right;margin-right: 10px;" id="btn_exportBulkSuccessData">Export Success Report</button>
                </div>
            </div>
        </div>
        <div class="row mt-5" @if(!(session()->has('failedEmails')) || (count(session('failedEmails')) == 0)) style="display:none;" @endif>
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="failed_emails">
                        <thead>
                        <tr>
                            <th colspan="3">Error Report</th>
                        </tr>
                        <tr>
                            <th>Serial</th>
                            <th>Email ID</th>
                            <th>Error</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @if((session()->has('failedEmails')))
                            @foreach(session('failedEmails') as $failed)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$failed['Mail']}}</td>
                            <td>{{$failed['Error']}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-9">
                    <button type="button" class="btn btn-info" style="float: right;margin-right: 10px;" id="btn_exportBulkFailData">Export Failure Report</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
    </div><!--card-footer-->
</div>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
@endpush

@push('after-scripts')
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<!-- For upload csv -->
<script>
    $(document).ready(function(){
        $('#btn-upload').click(function(e){
            $('#csv_file').click();
        });
        $('#csv_file').on('change', function(){
            $('#btn-upload').hide();
            $('#btn-upload_save').show();


            $('#btn-upload_save').on('click', function(){
            
            if(($('#csv_file').val().slice((($('#csv_file').val().lastIndexOf(".") -1) >>> 0) + 2)).toLowerCase() === 'csv'){
                $('#csvForm').submit();
                // alert('hi');
            }else{
                swal('Only .csv files allowed ');
                $('#btn-upload_save').hide();
                $('#btn-upload').show();
                
            }
        });

        });

    });
</script>
<!-- For displaying faulty_emails -->
<script>
    $(document).ready(function() {
        var table = $('#faulty_emails').DataTable({
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
            buttons: [
                'excel', 'csv'
            ],
            "ordering": false,
        });
        $(".dataTables_wrapper").css("width","100%");
        $('.dataTables_filter').before($('#faulty_emails thead tr:first'));
        table.draw();
    });
</script>
<!-- For displaying bulk_emails_success -->
<script>
    $(document).ready(function() {
        if($('#failed_emails').is(':visible')){
            var table = $('#success_emails').DataTable({
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
                buttons: [
                    'excel', 'csv'
                ],
                "ordering": false,
            });
            $(".dataTables_wrapper").css("width","100%");
            $('.dataTables_filter').before($('#success_emails thead tr:first'));
            table.draw();
        }
        
    });
</script>
<!-- For displaying bulk_emails_failed -->
<script>
    $(document).ready(function() {
        if($('#failed_emails').is(':visible')){
            var table = $('#failed_emails').DataTable({
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
                buttons: [
                    'excel', 'csv'
                ],
                "ordering": false,
            });
            $(".dataTables_wrapper").css("width","100%");
            $('.dataTables_filter').before($('#failed_emails thead tr:first'));
            table.draw();
        }
    });
</script>
<!-- For exporting faulty emails -->
<script>
    $(document).ready(function(){
        $('#btn-export-faulty').on('click',function() {
            $('#exportFaultyDataForm').submit();
            // setTimeout(() => {
            //     location.reload();
            // }, 3000);
            
        });
    });
</script>
<!-- For exporting validated emails -->
<script>
    $(document).ready(function(){
        $('#btn_exportData').on('click',function() {
            $('#exportValidatedDataForm').submit();
            
        });
    });
</script>
<!-- For sending emails with limit 500 -->
<script>
    $(document).ready(function(){
        $('#btn_sendBulkMail').on('click',function() {
            if($('#reminder_chk').is(':checked')){
                $('#is_reminder').val('1');
            }else{
                $('#is_reminder').val('0');
            }
            // alert($('#is_reminder').val());
            $('#sendBulkMail').submit();
            
        });
    });
</script>
<!-- For exporting bulk success emails -->
<script>
    $(document).ready(function(){
        $('#btn_exportBulkSuccessData').on('click',function() {
            $('#exportBulkSuccessDataForm').submit();
            
        });
    });
</script>
<!-- For exporting bulk fail emails -->
<script>
    $(document).ready(function(){
        $('#btn_exportBulkFailData').on('click',function() {
            $('#exportBulkFailDataForm').submit();
            
        });
    });
</script>
@endpush