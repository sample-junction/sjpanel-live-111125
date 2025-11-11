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
<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            Template Details
                        </h4>
                    </label>
                </div>
            </div>
        </div>

        {{-- @if(session('success'))

       <div class="alert alert-success">{{ session('success') }}</div>

       @endif --}}

        <div class="card-body">
            <a class="btn btn-primary" href="{{route('admin.auth.support.birthdaysent')}}">Back</a>
             <a class="btn btn-primary" href="{{route('admin.auth.campaign-Template')}}">Create New Template</a>
            <hr>
            <div class="row">
                <table class="table table-striped table-hover" id="campaign_detail" style="width:100%">
                    <thead>
                    <th>ID</th>
                       <th>Template Type</th>
                       <th>Template Name</th>
                       <th>Email Subject</th>
                       <th>Status</th>
                       <th>Created By</th>
                       <th>Created At</th>
                       <th>Get Approval</th>
                       <th>Approved By</th>
                       <th style="text-align:center;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                          @php
                            if(isset($data->template_type)){
                                if($data->template_type != 2 ){
                                $template_type = "Campaign";
                               }
                            }
                            if($data->template_status == "1"){
                                $template_status = "Approved";
                            }elseif($data->template_status == "0"){
                                $template_status = "Rejected";
                            }
                            else{
                                $template_status = "Approval Pending";
                            }
                            $user_name = decrypt($data->firstname).' '.decrypt($data->lastname);
                          @endphp
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$template_type}}</td>
                            <td>{{$data->template_name}}</td>
                            <td>{{$data->email_subject}}</td>
                            <td>{{$template_status}}</td>
                            <td>{!!$user_name!!}</td>
                            <td>{{$data->created_at}}</td>
                            <td>
                               @if($data->template_status == 0)
                                <a class="btn btn-secondary btn-sm" href="{{route('frontend.auth.send-email', ['id' => $data->id])}}"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                @endif
                            </td>
                            <td>{{$data->approval_email}}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{route('admin.auth.edit-template', ['id' => $data->id])}}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-secondary btn-sm ml-1 temp_preview" data-content="{{$data->template_content}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i style="color:white;" class="fas fa-eye"></i></a>
                                <a class="btn btn-danger btn-sm" href="{{route('admin.auth.del-template', ['id' => $data->id])}}"><i class="fas fa-trash"></i></a>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>   
                </table>
            </div>
            
        </div>
    </div><!--card-->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            $('#campaign_detail').DataTable({
                "processing": true,
                "ordering": false,
            });

            $('.temp_preview').on('click',function(){
                var content = $(this).data('content');
                $('.content').html(content);
            });

        });
    </script>
@endpush
