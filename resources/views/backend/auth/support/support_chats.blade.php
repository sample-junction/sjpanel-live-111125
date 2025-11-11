@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('inpanel.user.support.chat_heading'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    <script>
        setTimeout(function(){
            location.reload(); 
        }, 10000); 
    </script>
@endif


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6 pull-left">
                <label>
                    <h4>
                        <!-- {{__('inpanel.user.support.chat_heading')}} -->
                        {{$supportHistory->subject}}
                    </h4>
                </label>
            </div>
        </div>
    </div>
    <div class="card-body">
    <span><b>Ticket Id : </b>{{$supportHistory->id}} @if($supportHistory->updated_at)| <b>Last Updated : </b>{{date('d M Y h:i a',strtotime($supportHistory->updated_at))}}  @endif| <b>Status :</b> @if($supportHistory->status==0)<span class="btn-sm btn-success">Open</span>@else<span class="btn-sm btn-danger">Closed</span>@endif
    </span>
    <hr>
{{html()->form('post',route('admin.auth.support.chatpost',$supportHistory->id))->acceptsFiles()->id('commentForm')->open()}}
        <div class="row">
            <div class="col-md-8">
                <section class="msger">
                    <main class="msger-chat">
                        @foreach($allChatsById as $value)  
                            @if($value->manager_id==0)  
                                @php 
                                $userData = User::where('id',$value->user_id)->first();
                                @endphp
                                <div class="msg left-msg">
                                    <div class="msg-bubble">
                                        <div class="msg-info">
                                            <div class="msg-info-name">{{ucfirst($userData['first_name'])}}</div>
                                            <div class="msg-info-time">{{$value->created_at->diffForHumans()}}</div>
                                        </div>
                                        <div class="msg-text">
                                            {{$value->content}}<br>
                                            @if($value->attach_file_name) <a href="{{ asset('support_attachment/'.$value->attach_file_name) }}" target="_blank">File</a>@endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                @php 
                                $userData = User::where('id',$value->manager_id)->first();
                                @endphp
                                <div class="msg right-msg">
                                    <div class="msg-bubble">
                                        <div class="msg-info">
                                            <div class="msg-info-name">{{ucfirst($userData['first_name'])}}</div>
                                            <div class="msg-info-time">{{$value->created_at->diffForHumans()}}</div>
                                        </div>
                                        <div class="msg-text">
                                            @php
                                              print_r($value->content);
                                            @endphp
                                            @if($value->attach_file_name) <br> <a href="{{ asset('support_attachment/'.$value->attach_file_name) }}" target="_blank">File</a>@endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </main>
                </section>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="">Comment:</label>
                    <textarea name="message" id="message" class="form-control" cols="10" rows="5" placeholder="Comment"></textarea>
                    <input type="hidden" name="message_text" id="message_text" value=""> 
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Attachment:</label>
                    <input type="file" name="attachment" id="attachment" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            @if($supportHistory->status==0)
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="submit" class="btn btn-info">Post Comment</button>
                </div> 
            </div>
            @endif
        </div>
    {{html()->form()->close()}}
</div>
</div>
@endsection

@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script> 
<link rel="stylesheet" href="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.css">
<script>
    $(document).ready(function () {
        CKEDITOR.replace('message', {
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


        // Listen for form submission
        $('form').submit(function() {
            // Extract text content without HTML tags from CKEditor content
            var editorData = CKEDITOR.instances.message.getData();
            var tempDiv = document.createElement("div");
            tempDiv.innerHTML = editorData;
            var textContent = tempDiv.textContent || tempDiv.innerText || "";
            console.log(textContent); 
            $('#message_text').val(textContent); // Set the extracted text content to the hidden input field
        });

        // Apply styles to center the content
        CKEDITOR.instances.message.on('instanceReady', function (evt) {
            var editorIframe = evt.editor.editable().$;
            $(editorIframe).css({
                'display': 'flex',
                'flex-direction': 'column',
                'text-align': 'left',
                'justify-content': 'center',
                'height': '100%',
            });
        });
    });
</script>



@endpush


@push('after-styles')
<style>
    
.msger {
  display: flex;
  flex-flow: column wrap;
  justify-content: space-between;
  width: 100%;
  max-width: 1150px;
  margin: 25px 10px;
  height: calc(100% - 50px);
  border: 2px solid #e4e0e0;
  border-radius: 5px;
  background: var(--msger-bg);
  max-height: 378px;
}


.msger-chat {
  flex: 1;
  overflow-y: auto;
  padding: 20px 50px;
}
.msger-chat::-webkit-scrollbar {
  width: 6px;
}
.msger-chat::-webkit-scrollbar-track {
  background: #ddd;
}
.msger-chat::-webkit-scrollbar-thumb {
  background: #bdbdbd;
}
.msg {
  display: flex;
  align-items: flex-end;
  margin-bottom: 10px;
}
.msg:last-of-type {
  margin: 0;
}
.msg-img {
  width: 50px;
  height: 50px;
  margin-right: 10px;
  background: #ddd;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  border-radius: 50%;
}
.msg-bubble {
  max-width: 450px;
  padding: 15px;
  border-radius: 15px;
  background: var(--left-msg-bg);
  border: 2px solid #d2c6c6;
}
.msg-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.msg-info-name {
  margin-right: 10px;
  font-weight: bold;
}
.msg-info-time {
  font-size: 0.85em;
}

.left-msg .msg-bubble {
  border-bottom-left-radius: 0;
  background: #ffffff;
  width:80%;
}

.right-msg {
  flex-direction: row-reverse;
}
.right-msg .msg-bubble {
  background: #ffffff;
  width:80%;
  border-bottom-right-radius: 0;
}
.right-msg .msg-img {
  margin: 0 0 0 10px;
}

.msger-inputarea {
  display: flex;
  padding: 10px;
  border-top: var(--border);
  background: #eee;
}
.msger-inputarea * {
  padding: 10px;
  border: none;
  border-radius: 3px;
  font-size: 1em;
}
.msger-input {
  flex: 1;
  background: #ddd;
}
.msger-send-btn {
  margin-left: 10px;
  background: rgb(0, 196, 65);
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.23s;
}
.msger-send-btn:hover {
  background: rgb(0, 180, 50);
}


</style>

@endpush
