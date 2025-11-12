@php
use App\Models\Auth\User;
@endphp
@extends('inpanel.layouts.app')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>
                       {{-- {{__('inpanel.user.support.chat_heading')}} --}}
                        {{$supportHistory->subject}}
                    </h5>
                </div>
                <div class="ibox-title">
                    <span><b>{{__('inpanel.user.support.ticket_no')}} </b>{{$supportHistory->id}} @if($supportHistory->updated_at)| <b>{{__('inpanel.user.support.last_update')}} </b> {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $supportHistory->updated_at)->setTimezone($userTimezone)->format('d M Y h:i a')}}  @endif | <b>{{__('inpanel.user.support.status')}}</b>@if($supportHistory->status==0)<span class="btn-sm btn-success">{{__('inpanel.user.support.button1')}}</span>@else<span class="btn-sm btn-danger">{{__('inpanel.user.support.button3')}}</span>@endif</span>
                </div>
                <div class="ibox-content">
               
                    {{html()->form('post',route('inpanel.user.support.chatpost',$supportHistory->id))->acceptsFiles()->open()}}
                        <div class="row">
                            <div class="col-md-8">
                               
                            <section class="msger">
                                
                                <main class="msger-chat">
                                @foreach($allChatsById as $value)  

                                    @if($value->manager_id!=0)  
                                    @php 
                                    $userData = User::where('id',$value->manager_id)->first();
                                    @endphp
                                    <div class="msg left-msg">
                                        <!-- <div class="msg-img" style="background-image: url({{ asset('img/p1.jpg')}})"></div> -->

                                        <div class="msg-bubble">
                                            <div class="msg-info">
                                            <div class="msg-info-name">{{ucfirst($userData['first_name'])}}</div>
                                            <div class="msg-info-time">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone($userTimezone)->diffForHumans()}}</div>
                                            </div>

                                            <div class="msg-text">
                                                {{$value->content}}<br>
                                                @if($value->attach_file_name) <a href="{{ asset('support_attachment/'.$value->attach_file_name) }}" target="_blank">File</a>@endif
                                            </div>
                                        </div>
                                    </div>
                                    @else

                                    <div class="msg right-msg">
                                        <!-- <div class="msg-img" style="background-image: url({{ asset('img/profile_small.jpg')}})"></div> -->
                                        
                                        <div class="msg-bubble">
                                            <div class="msg-info">
                                            <div class="msg-info-name">{{__('inpanel.user.support.you')}}</div>
                                            <div class="msg-info-time">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone($userTimezone)->diffForHumans()}}</div>
                                            </div>

                                            <div class="msg-text">
                                                {{$value->content}}<br>
                                                @if($value->attach_file_name) <a href="{{ asset('support_attachment/'.$value->attach_file_name) }}" target="_blank">File</a>@endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @endforeach
                                    
                                </main>

                                </section>
                                <!-- <table>
                                    <tbody>
                                        @foreach($allChatsById as $value)
                                        <tr>                                           
                                            <td style="float:right;">{{$value->content}}</td>
                                            <td style="float:left;">{{$value->created_at}}</td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table> -->
                               
                            </div>
                        </div><hr>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">{{__('inpanel.user.support.comment')}}</label>
                                    <textarea name="message" id="message" class="form-control" cols="10" rows="5" placeholder=""></textarea>
                                    
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{__('inpanel.user.support.attachment')}}</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                    
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                        @if($supportHistory->status==0)
                            <div class="col-md-12">
                                <div class="form-group">
                                  <button type="button" class="btn" onclick="changeStatus('{{$supportHistory->id}}',1)">{{__('inpanel.user.support.resolve_ticket')}}</button>
                                  <button type="submit" class="btn btn-info">{{__('inpanel.user.support.post_comment')}}</button>
                                </div> 
                            </div>
                        @endif
                        </div>
                    {{html()->form()->close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
  border-bottom-right-radius: 0;
  width:80%;
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
@push('after-scripts')
<script>
function changeStatus(supportId,statusData){
    //alert(supportId);
    $.ajax({
        /* the route pointing to the post function */
        url: "{{route('inpanel.user.support.changeStatus')}}",
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: {_token: "{{ csrf_token() }}", supportId : supportId ,statusData:statusData},
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (response) { 
            console.log(response.status);
            try{
                if (response.status === 200) {
                    // swal('Fraud action successfully');

                    // swal({title: "Good job", text: "Fraud action successfully", type: "success"}).then(function(){ location.reload();});
                    location.reload();
                }
            }catch(error){
                swal({text: "Some error occure!", type: "error"});
            } 
        }
    });
}
</script>
@endpush