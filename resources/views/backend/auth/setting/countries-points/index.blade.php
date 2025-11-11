@extends('backend.layouts.app')
@section('title', app_name() . ' | Country Points' . __('labels.backend.access.questions_answers.management'))

@section('breadcrumb-links')
    @include('backend.auth.question_answer.includes.breadcrumb-links')
@endsection

@section('content')

@if(session('message'))
    {{ session('message') }}
@endif
<style>
    .the_excerpt{
        max-width: 700px;
    }
    form{
        margin: 0px !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
               <div class="col-12">
               @if (session()->has('success'))
                    <div class="alert alert-success d-flex align-items-center alert_new" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            {{ session()->get('success') }}
                        </div>
                        <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif (session()->has('fail'))
                    <div class="alert alert-danger d-flex align-items-center alert_new" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Fail:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            {{ session()->get('fail') }}
                        </div>
                        <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

               </div>
            <div class="col-sm-5">
                <h4 class = "card-title mb-0" > Country Points
                </h4 ><br>               
            </div><!--col-->
            <div class="col-sm-7">
                <a href="{{route('admin.auth.setting.countries_create')}}" class="btn btn-info" style="float: right;margin-left: 10px;">Add</a>
            </div>
        </div><!--row-->
        
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="question_management">
                        <thead>
                        <tr>
                            <th class="td-th-hide">ID</th>
                            <th class="td-th-hide">Country</th>
                            <th class="td-th-hide">Country/Language</th>
                            <th class="td-th-hide">Currency</th>
                            <th class="td-th-hide">Points</th>
                            <th>@lang('labels.backend.access.users.table.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($points as $key=>$point)
                            <tr>
                                <td class="td-th-hide">{{($key+1)}}</td>
                                <td class="td-th-hide">{{$point->country}}</td>
                                <td class="td-th-hide">{{$point->country_language}}</td>
                                <td class="the_excerpt">{{$point->currency}}</td>
                                <td>{{$point->points}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a style="padding: 12px;"  href="{{ route('admin.auth.setting.countries_show', ['id' => $point->id]) }}" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a style="padding: 12px;" href="{{ route('admin.auth.setting.countries_edit', ['id' => $point->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        @if(auth()->user()->roles[0]->name == 'super_administrator')
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger" style="cursor:pointer;">
                                            <form id="deleteForm{{ $point->id }}" action="{{ route('admin.auth.setting.countries_destroy', ['id' => $point->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="event.preventDefault(); deleteQuestion({{ $point->id }});"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </a>
                                        @endif                                
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        
    </div><!--card-body-->
</div><!--card-->
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
    $(document).ready(function() {
        $('#question_management').DataTable({
               searchHighlight: true,
                dom: 'Bfrtip', // Include B for buttons, f for filter/search, r for processing display, t for table, i for info, p for pagination
               columnDefs: [{
                   targets: '_all',
                   createdCell: function(td, cellData, rowData, row, col) {
                       $(td).attr('data-search', $(td).text().toLowerCase());
                   }
               }],
               buttons:[
                   {
                       extend: 'excel',
                       exportOptions: {
                           columns: ':not(:last-child):not(:nth-child(3))'
                       }
                   },
                   {
                       extend: 'csv',
                       exportOptions: {
                           columns: ':not(:last-child):not(:nth-child(3))'
                       }
                   }
            ],
        });
    });

        function deleteQuestion(questionId) {
                if (confirm('Are you sure you want to delete this?')) {
                    document.getElementById('deleteForm' + questionId).submit();
                }
            }
</script>
@endpush
