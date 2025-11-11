@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('campaign_history'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
@if(session('success'))
 <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>{{session('success')}}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@else
<strong class="text-danger">{{session('fail')}}</strong>
@endif
<div class="card">
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
            <a class="btn btn-primary" href="{{route('admin.auth.show-survey-invite')}}">Back</a>
             <a class="btn btn-primary" href="{{route('admin.auth.show-survey-temp')}}">Create New Template</a>
            <hr>
            <div class="row">
               <div class="col-12">
               <table class="table table-striped table-hover" id="survey_table" style="width:100%">
                    <thead>
                    <tr>
                       <th>ID</th>
                       <th>Template Type</th>
                       <th>Template Name</th>
                       <th>Email Subject</th>
                       <th>Status</th>
                       <th>Created By</th>
                       <th>Created At</th>
                       <th>Get Approval</th>
                       <th>Approved/Rejected By</th>
                       <th style="text-align:center;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    @if(isset($datas))
                        @foreach($datas as $data)
                          @php
                            if($data->template_type == 2){
                                $template_type = "Survey";
                            }

                            if($data->template_status == '1'){
                                $template_status = "Approved";
                            }elseif($data->template_status == '0'){
                                $template_status = "Rejected";
                            }else{
                                $template_status = "Approval Pending";
                            }

                            $user_name = decrypt($data->firstname).' '.decrypt($data->lastname);
                          @endphp
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$template_type}}</td>
                            <td>{{$data->template_name}}</td>
                            <td>{{$data->email_subject}}</td>
                            <td>{{__($template_status)}}</td>
                            <td>{!!$user_name!!}</td>
                            <td>{{$data->created_at}}</td>
                            <td>
                                @if($data->template_status == 0)
                                <a class="btn btn-secondary btn-sm" href="{{route('frontend.auth.send-email', ['id' => $data->id])}}"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                @endif 
                            </td>
                            <td>{{$data->approval_email}}</td>
                            <td style="text-align:center;">
                                <a class="btn btn-success btn-sm" href="{{route('admin.auth.edit-survey-temp',['temp_id'=>$data->id])}}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-secondary btn-sm ml-1" id="survey_preview" data-content="{{$data->template_content}}" data-bs-toggle="modal" data-bs-target="#preview_template_Modal"><i style="color:white;" class="fas fa-eye"></i></a>
                                <a class="btn btn-danger btn-sm" href="{{route('admin.auth.del-survey-temp',['temp_id'=>$data->id])}}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                              
                    </tbody>
                </table>
               </div>
            </div>
        </div>
    </div><!--card-->
    @include('backend.auth.campaign.campaign_history_model')
     <!-- Template Section -->

                    <!-- Modal -->
                    <div class="modal fade" id="preview_template_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
@endsection

@push('after-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endpush

@push('after-scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#survey_table').DataTable({
                "processing": true,
                "ordering": false,
            });

            $('#survey_preview').on('click',function(){
                var content = $(this).data('content');
                $('.content').html(content);
            });
        });
    </script>
@endpush
