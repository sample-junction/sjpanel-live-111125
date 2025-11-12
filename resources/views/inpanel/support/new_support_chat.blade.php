@php
use App\Models\Auth\User;
@endphp
@extends('inpanel.layouts.device')

@section('panelistSupport_select','cst-active')
@section('content')

@push('after-styles')
<style>
#browse_button{
		float: right;
	    /* transform: translate(2px, -39px); */
	    border-top-left-radius: 0;
	    border-bottom-left-radius: 0;
		/* margin-top: 60px;  */
		margin-left: 15px;
	    font-size: 13px;
    	padding: 9px 45px;
	}
    .norm-disp {
        display: flex;
    }
    .status-disp {
        margin-top: 7px;
        margin-left: 10px;
    }
    @media(min-width: 220px) and (max-width:767px){
		#browse_button {
		    padding: 9px 15px !important;
		}
        .norm-disp {
            display: block;
        }
        .status-disp {
            margin-top: 20px;
            margin-left: 5px;
        }
    }
</style>
@endpush


                    <div class="row mt-5">

                         <div class="col-12">

                            <p class="h4 ms-2" style="font-weight: 600;">{{__('inpanel.Panelist_Support.title')}}</p>

                        </div>

                        
                    </div>

                    <div class="row p-lg-3 mt-4">


                        <div class="col border pt-3 pb-3 ps-4 pe-4 bg-white" style="border-radius:10px;">


                            <div class="row border-bottom pb-3 pb-lg-0">

                                <div class="col-12 pt-3 ps-1 pe-0 pb-4 norm-disp">

                                    <span class="fw-bold p-2" style="background: #F4F4F4;">{{__('inpanel.user.support.ticket_no')}} {{$supportHistory->id}}</span>

                                    @if($supportHistory->updated_at)   
                                       <span class="fw-bold p-2 ms-3 d-none d-lg-inline-block" style="background: #F4F4F4; scale:0.9;">{{__('inpanel.user.support.last_update')}} {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $supportHistory->updated_at)->setTimezone($userTimezone)->format('d M Y h:i a')}}</span>
                                    @endif

                                    <span class="fw-bold p-2 ms-3" style="background: #F4F4F4;">{{__('inpanel.user.support.status')}}</span>
                                    <div class="status-disp">
                                        <span class="fw-bold p-2 text-light" style="background: {{ $supportHistory->status==0 ?  '#5cb85c' : '#F01D44' }} ; margin-left:-5px;">
                                                @if($supportHistory->status==0)
                                                {{__('inpanel.user.support.button1')}}
                                                @else
                                                {{__('inpanel.user.support.button2')}}    
                                            @endif    
                                        </span>
                                    </div>
                                </div>

                                @if($supportHistory->updated_at) 
                                        <div class="col-12 ps-1">
                                            <span class="fw-bold p-2 d-lg-none" style="background: #F4F4F4;">{{__('inpanel.user.support.last_update')}} {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $supportHistory->updated_at)->setTimezone($userTimezone)->format('d M Y h:i a')}}</span>
                                        </div>  
                                @endif

                            </div>

                    {{html()->form('post',route('inpanel.user.support.chatpost',$supportHistory->id))->acceptsFiles()->open()}}


                            <div class="row mt-5">

                                <div class="col-12 p-0">

                                    <span style="font-weight: 600;">{{__('inpanel.user.support.support_message')}}</span>

                                </div>
                                <div class="col-12 border mt-3 rounded p-5" style="height:300px; overflow-y:auto;">
                                @foreach($allChatsById as $key => $value)
                                @php
                                //dd($value);
                                $attachment_link=null;
                                if($value->attach_file_name){
                                    
                                    if(strpos($value->attach_file_name,'support_attachment')){
                                        $api_server = config('settings.centralize_server_image');
                                        $attachment_link = $api_server.$value->attach_file_name;
                                    }else{
                                        $attachment_link = asset('support_attachment/'.$value->attach_file_name);
                                    }
                                }

                                @endphp
                                    @if($value->manager_id != 0)
                                        @php 
                                            $userData = User::where('id', $value->manager_id)->first();
                                        @endphp
                                        <div class="row p-3 mt-2 sender-msg">
                                            <div class="col-12 col-lg-4"><span style="font-weight:600;">{{ ucfirst($userData['first_name']) }} </span></div>
                                            <div class="col-12 col-lg-8 text-end mt-2 mt-lg-0 d-none d-lg-inline-block"><span class="text-msg-sent">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone($userTimezone)->diffForHumans() }}</span></div>
                                            <div class="col-12">
                                                <span style="word-wrap: break-word;">
                                                    {!! $value->content !!}
                                                   {{-- {!! nl2br(e(strip_tags(str_replace("&nbsp;", "", str_replace("&#39;", "'", $value->content))))) !!}--}}
                                                    
                                               </span> @if($attachment_link)
                                               <a href="{{ $attachment_link }}" target="_blank">{{ __('inpanel.user.support.file_msg') }}</a>
                                               @endif
                                            </div>
                                            <div class="col-12 col-lg-8 text-end mt-2 mt-lg-0 d-lg-none"><span class="text-msg-sent">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone($userTimezone)->diffForHumans() }}</span></div>
                                        </div>
                                    @else
                                        <div class="row p-3 receiver-msg @php if($key > 0) { echo 'mt-2';  } @endphp">
                                            <div class="col-12 col-lg-4"><span class="text-light" style="font-weight:600;">{{ __('inpanel.user.support.you') }}</span></div>
                                            <div class="col-12 col-lg-8 text-end mt-2 mt-lg-0 d-none d-lg-inline-block"><span class="text-light text-msg-sent">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone($userTimezone)->diffForHumans() }}</span></div>
                                            <div class="col-12">
                                                <span class="text-light" style="word-wrap: break-word;"> {!! nl2br(e(strip_tags(str_replace("&nbsp;", "", str_replace("&#39;", "'", $value->content))))) !!}
                                               </span> 

                                                @if($attachment_link)
                                               <a href="{{ $attachment_link }}" class="text-light" target="_blank">{{ __('inpanel.user.support.file_msg') }}</a>
                                               @endif
                                            </div>
                                            <div class="col-12 col-lg-8 text-end mt-2 mt-lg-0 d-lg-none"><span class="text-light text-msg-sent">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone($userTimezone)->diffForHumans() }}</span></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>




                            </div>


                            <div class="row mt-5">

                                <div class="col-12 p-0">

                                    <span style="font-weight: 600;">{{__('inpanel.user.support.attachment')}}</span>

                                </div>

                                <div class="col-12 mt-3 p-0">

                                  {{--  <div class="form-group border rounded" style="height:42px; position:relative;">
                                        <label for="attachment" class="text-light pt-2 pb-2 ps-5 pe-5 brws-btn" style="background:#006BDE;">{{__('inpanel.user.support.brws_btn')}}</label>
                                        <input type="file" name="attachment" id="attachment" style="visibility:hidden;" class="form-control">                                        
                                    </div> --}}
                                    <input type="file" id="file_input" name="attachment" accept="image/*" style="display:none;">
                                    <div style="display:flex;max-height:40px;">
                                        <button type="button" id='btn-upload' class="form-control photo_upload" style="width:90%;"></button>
                                        
                                        <button class="btn btn-primary rounded" type="button" id="browse_button">{{__('inpanel.Panelist_Support.browse')}}</button><br><br><br>
                                        
                                    </div>
                                    <br><span id="images_err" style="color:red;"></span>
                                </div>

                            </div>



                            <div class="row mt-5">

                                <div class="col-12 p-0">

                                    <span style="font-weight: 600;">{{__('inpanel.user.support.comment')}}</span>

                                </div>

                                <div class="col-12 mt-3 p-0">

                                    <div class="form-floating">
                                        <textarea class="form-control" name="comment" id="message" style="height: 100px"></textarea>
                                    </div>

                                </div>

                                <div class="col-12 mt-4 p-0">

                                @if($supportHistory->status==0)

                                    <button type="button" class="btn ps-3 pe-3 text-light me-3" style="background: #1080D0;" onclick="changeStatus('{{$supportHistory->id}}',1)">{{__('inpanel.user.support.resolve_ticket')}}</button>

                                    <button type="submit" class="btn ps-3 pe-3 text-light" style="background: #25A76E;">{{__('inpanel.user.support.post_comment')}}</button>
                                
                                @endif

                                </div>

                            </div>

                    {{html()->form()->close()}}

                        </div>


                    </div>




@endsection
@push('after-styles')
<style>

.sender-msg{
  background: #006bde36; 
  border-radius:30px; 
  width: 487px;
}

.receiver-msg{
  background: #006BDE; 
  border-radius:30px; 
  width: 487px;
  transform: translateX(99%);
}

.text-msg-sent{
      font-weight:600;
      font-size:13px;
  }

  input[type=file]::file-selector-button {
    background: #006BDE;
    color:white;
  }

 .brws-btn{
    position:absolute;
    right:0;
    border-radius: 0px 5px 5px 0px;
    cursor:pointer;
 }


  @media only screen and (max-width: 600px) {

       .sender-msg{
          background: #006bde36; 
          border-radius:30px; 
          width: auto;
          transform: translateX(-10%);
      }

      .receiver-msg{
          background: #006BDE; 
          border-radius:30px; 
          width: auto;
          transform: translateX(10%);
      }

      .text-msg-sent{
          font-size:12px;
      }

  }     


  @media only screen and (min-width: 601px) and (max-width: 1280px){

      .sender-msg{
          background: #006bde36; 
          border-radius:30px; 
          width: 50%;
      }

      .receiver-msg{
          background: #006BDE; 
          border-radius:30px; 
          width: 50%;
          transform: translateX(99%);
      }
  }
</style>


@endpush
@push('after-scripts')
<script>
    $(document).ready(function () {
		    $("#browse_button").click(function () {
		        $("#file_input").click();
		    });
		});
    $(document).ready(function(){
			$('#btn-upload').click(function(e){
				e.preventDefault();
				
			});

			$('#file_input').on('change', function() {
			var file = this.files[0];
			var fileType = file.type.split('/')[0];

			if (fileType !== 'image') {
				$('#file_input').val('');
				$('#images_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.image_error')}}");
			} else {
				$('#images_err').html('');
				$('#btn-upload').text(file.name);
			}
			var maxSize = 10 * 1024 * 1024;
			if (file.size > maxSize) {
				$('#file_input').val('');
				$('#btn-upload').text('');
				$('#images_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.file_size_error')}}");
			}
		});
			$('#browse_button').on('blur',function(){
				$('#images_err').html('');
			});
		});
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
                    // location.reload();
                sessionStorage.setItem('successMessage', "{{ __('inpanel.user.profile.preferences.preferences_menu.resolved_ticket_msg') }}");
                window.location.href = "/support?tab=support_history";
                }
            }catch(error){
                swal({text: "Some error occure!", type: "error"});
            } 
        }
    });
}
</script>

@endpush