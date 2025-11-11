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
        <strong>{{session('fail')}}</strong>   
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                <div><a class="btn btn-primary" href="{{route('admin.auth.template-detail')}}">Back</a></div><br>
                    <center><label>
                        <h4>
                            Edit And Update Template
                        </h4>
                    </label>
                </center>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div style="font-size:30px;">
                   @foreach($datas as $data)
                      @php 
                        $content =$data->template_content;
                        $button_text = $data->button_text;
                      @endphp
                    <form action="{{route('admin.auth.update-template')}}" method="POST">
                        @csrf


                        <div class="form-group mt-2">
                        <label for=""><h5>Template Type :</h5></label>
                        <select name="template_type" id="" class="form-select" aria-label="Default select example">
                            <option value="{{$data->template_type}}">Campaign</option>
                        </select>
                       </div>

                    <div class="form-group mt-2">
                        <input type="hidden" name="temp_id" value="{{$data->id}}">
                        <label for=""><h4>Template Name :</h4></label>
                        <input type="text" name="template_name" class="form-control" placeholder="Enter Template Name" value="{{$data->template_name}}">
                    </div>

                    <div class="form-group mt-2">
                        <label for=""><h5>Email Subject :</h5></label>
                        <input type="text" name="email_subject" class="form-control" placeholder="Enter Email Subject" value="{{$data->email_subject}}">
                        <input type="hidden" name="user_id"  value="{{$data->user_id}}">
                    </div>

                    <div class="form-group mt-2">
                        <label for=""><h4>Template Body Content :</h4></label>
                        <!-- <input  type="text" id="content_insert" class="form-control" placeholder="Enter Template Body Content"> -->
                        <textarea name="template_content" class="content" id="email_content" cols="60" rows="60">{!!$data->template_content!!}</textarea>
                    </div>

                    <div class="form-group mt-2">
                        <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#preview_template_Modal">Preview</span>
                    </div>

                    <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Gallery</span>



                    <div class="form-group mt-2">
                        <label for=""><h4>URL Link :</h4></label>
                        <input  type="text" name="url" class="form-control" placeholder="Enter URL Link" value="{{$data->url}}">
                    </div>

                    <center><button type="submit" class="btn btn-primary">Update</button></center>
                    </form>
                    @endforeach
                    </div>
                </div>
              

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
                        {!!$data->template_content!!}
                        </div>
                        </div>
                    </div>
                    </div>
                <!-- Template Section -->
                
                
            </div>
        </div>
    </div>


               <!-- Modal -->
               <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="min-width:900px;">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Photo Gallery</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                            <div style="height: 200px; overflow-y: scroll;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Path</th>
                                            <th>Photo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($gallery as $gall)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$gall->image_name}}</td>
                                            <td>{{asset($gall->path)}}</td>
                                            <td><img src="{{asset($gall->path)}}" alt="" style="height:81px;width:81px;"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
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
        .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 400px;
            }
            .ck-content .image {
                /* Block images */
                max-width: 80%;
                margin: 20px auto;
            }
    </style>

@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
    <link rel="stylesheet" href="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.css">
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
<script>
  
  $(document).ready(function () {
    CKEDITOR.replace('email_content', {
                filebrowserBrowseUrl: '/ckfinder/ckfinder.html?resourceType=Files',
                filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                toolbar: [
                    { name: 'clipboard', items: ['Undo', 'Redo'] },
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'insert', items: ['Image'] },
                    { name: 'source', items: ['Source'] },
                    { name: 'styles', items: ['Format', 'Font', 'FontSize'] }
                ],
                extraPlugins: 'autogrow',
                autoGrow_bottomSpace: 10,
                allowedContent: true, // Allow all HTML tags
                fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;30/30px;32/32px;36/36px;40/40px;44/44px;48/48px;52/52px;56/56px;60/60px;64/64px;68/68px;72/72px;76/76px;80/80px;84/84px;88/88px;92/92px;96/96px;100/100px;',
            });

            CKEDITOR.instances.email_content.on('change', function (evt) {
                console.log(evt.editor.getData());
                $('.content').html(evt.editor.getData());
            });


            // $('#t_button_text').on('input',function(){
            //     var val = $('#t_button_text').val();
            //     $('#button_text').html(val);
            // });

            CKEDITOR.instances.email_content.on('instanceReady', function (evt) {
            // Get the CKEditor iframe
            var editorIframe = evt.editor.editable().$;

            // Apply styles to center the content
            $(editorIframe).css({
                'display': 'flex',
                'flex-direction': 'column',
                'align-items': 'center',
                'justify-content': 'center',
                'height': '100%', // Ensure iframe takes full height
            });
        });


               
        });

</script>
    
    
@endpush
