@extends('backend.layouts.app')
@push('after-styles')
<style type="text/css">
    .btn-group .btn-info{
        display: none !important;
    }
    .btn-group .btn-primary{
        display: none !important;
    }
    /*.btn-group .show .dropdown-item{
        display: none !important;
    }*/
    .btn-group .dropdown-menu a.dropdown-item:nth-child(2),
    .btn-group .dropdown-menu a.dropdown-item:nth-child(3),
    .btn-group .dropdown-menu a.dropdown-item:nth-child(4) {
        display: none !important;
    }
    .frau_use_email{
        display: none !important;
    }
    .td-th-hide{
        display:none;
    }
    
/*    .dataTables_filter{
        display: block !important;
    }*/
</style>
@endpush

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.panelist_management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

@if(session('message'))
    {{ session('message') }}
@endif
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
                <h4 class="card-title mb-0">
                @lang('labels.backend.access.reports.titles.panelist_management') 
                <!-- <small class="text-muted">Active Users</small> -->
                </h4><br>
                <h5 class="text-muted">@lang('labels.backend.access.users.total_panelists') : <b>@if(isset($users)) {{count($users)}}  @endif </b></h5>
            </div><!--col-->
            <div class="col-sm-7">
                <a href="{{route('admin.auth.doi-all')}}" class="btn btn-info" id="bulkreminderdoi" style="float: right;margin-left: 10px;">Bulk Reminder DOI</a>&nbsp;&nbsp;
                <a href="{{route('admin.auth.panelist')}}" class="btn btn-info" style="float: right;margin-left: 10px;">@lang('labels.backend.access.users.table.reset')</a>&nbsp;&nbsp;
                <button type="button" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#bulkSearch">@lang('labels.backend.access.users.table.bulk_search')</button>&nbsp;&nbsp;
                <!-- <a href="{{--route('admin.auth.user.exportUserProfile')--}}" class="btn btn-info" style="float: right;margin-right: 10px;">Export Profiles</a> -->
                <button type="button" class="btn btn-info" style="float: right;margin-right: 10px;" data-toggle="modal" data-target="#exportProfileData">@lang('labels.backend.access.users.table.export_profiles')</button>
                <button type="button" class="btn btn-info" style="float: right;margin-right: 11px" data-toggle="modal" data-target="#bulkimport">@lang('labels.backend.access.users.table.bulk_mark')</button>
            </div>
            
        </div><!--row-->
        
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th class="td-th-hide">@lang('labels.backend.access.users.table.first_name')</th>
                            <th class="td-th-hide">@lang('labels.backend.access.users.table.last_name')</th>
                            <th class="td-th-hide">@lang('labels.backend.access.users.table.email')</th>
                            <th>@lang('labels.backend.access.users.table.uuid')</th>
                            <th>@lang('labels.backend.access.users.table.panelistid')</th>
                            <th>@lang('labels.backend.access.users.table.country')</th>
                           <th>@lang('labels.backend.access.users.table.locale')</th>
                            <th>@lang('labels.backend.access.users.table.doi')</th>
                            <th>Unsubscribed</th> 
                            <th>Deactivated</th>
                            <th>Active</th>  {{-- Add Active column by Himanshu 25-09-2025 --}}
                            <th>Age</th> 
                            <th>Gender</th> 
                            <th>State</th>
                            <th>DMA Name</th>
                            <th>Region</th>



 
                             <!-- <th>@lang('labels.backend.access.users.table.age')</th>
                             <th>@lang('labels.backend.access.users.table.gender')</th>  -->
 
                            <th>@lang('labels.backend.access.users.table.fraud_count')</th>
                            <th>@lang('labels.backend.access.users.table.project_code')</th>
                            <th>@lang('labels.backend.access.users.table.roles')</th>
                            <th>@lang('labels.backend.access.users.table.social')</th>
                            <th>@lang('labels.backend.access.users.table.Last_login')</th>
                            <th>@lang('labels.backend.access.users.table.recent_activity')</th>
                            <th>@lang('labels.backend.access.users.table.recent_activity_date')</th>
                            <th>@lang('labels.backend.access.users.table.no_of_profile_filled')</th>
                            <th>@lang('labels.backend.access.users.table.channel')</th>
                            <th>@lang('labels.backend.access.users.table.last_survey_taken')</th>
                            <th>@lang('labels.backend.access.users.table.last_survey_status')</th>
                            <th>@lang('labels.backend.access.users.table.total_no_of_survey_attempted')</th>  
                            <th>@lang('labels.backend.access.users.table.total_no_of_survey_complete')</th>
                            <th>@lang('labels.backend.access.users.table.last_survey_complete_on')</th>

                            <th>{{--@lang('labels.backend.access.users.table.joining_date')--}} SOI</th>

                            <th>DOI</th>
                            <th>Source</th>
                            <th>Platform</th>
                            <th>Downloaded App</th>
                            <th>@lang('labels.backend.access.users.table.action')</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                         
                        @foreach($users as $key=>$user)

                                @php
                               
                                        $Activities='';
                                        $role_name="Panelist";
                                        /*foreach($user->roles as $role){
                                            if($role->name == "panelist"){
                                                $role_name="Panelist";
                                            }elseif($role->name == "test panelist"){
                                                $role_name="SJ Internal User";
                                            }else{
                                                $role_name='N/A';
                                            }      
                                        }*/
 
                                        $propertyJson = $user->property;
                                        $property = json_decode($propertyJson);
                                        if (is_object($property) && property_exists($property, 'survey_code'))
                                           {
                                            $code = $property->survey_code;
                                            $points = $property->points;
                                            }
 
                                        $maxDate = max($user->Activities_date, $user->redeem_request, $user->survey_taken, $user->user_refer_date,$user->support_date,$user->password_changed_at);
                                        
                                        if ($maxDate) {
                                            if ($maxDate == $user->redeem_request) {
                                                $Activities = "inpanel.activity_log.redeem_request";
                                            } elseif ($maxDate == $user->survey_taken) {
                                                $Activities = "inpanel.activity_log.survey_taken";
                                            } elseif ($maxDate == $user->user_refer_date) {
                                                $Activities = "inpanel.activity_log.refer_done";
                                            } elseif ($maxDate == $user->support_date) {
                                                $Activities = "inpanel.activity_log.support_request_activities";
                                            } elseif ($maxDate == $user->password_changed_at){
                                                $Activities = "inpanel.activity_log.Password_change";
                                            }else {
                                                if (!empty($user->Activities)) {
                                                        if ($user->Activities == "inpanel.activity_log.survey_points") {
                                                            $Activities = __("inpanel.activity_log.survey_points", ['points' => $points, 'code' => $code]);
                                                        } else {
                                                            $Activities = $user->Activities;
                                                        }
                                                    }
                                            }
                                        } 

                                      
                                     
 
                                        if(isset($user->survey_status)){
                                            if($user->survey_status == 0){
                                                $survey_status = "inpanel.activity_log.abandon";
                                            } elseif($user->survey_status == 1){
                                                $survey_status = "inpanel.activity_log.completed";
                                            }elseif($user->survey_status == 2){
                                                $survey_status = "inpanel.activity_log.terminate";
                                            }elseif($user->survey_status == 3){
                                                $survey_status = "inpanel.activity_log.Quota_full";
                                            }elseif($user->survey_status == 4){
                                                $survey_status = "inpanel.activity_log.Quality_terminate";
                                            }elseif($user->survey_status == 5){
                                                $survey_status = "inpanel.activity_log.rejected";
                                            }elseif($user->survey_status == 50){
                                                $survey_status = "inpanel.activity_log.approved";
                                            }else{
                                                $survey_status = "";
                                            }
                                        }else{
                                           $survey_status = $user->survey_status;
                                        }
 
                                        if(isset($user->channel_id)){
                                            if($user->channel_id == '1'){
                                                $channel_name = "Dashboard";
                                            }elseif($user->channel_id == '2'){
                                                $channel_name = "Email";
                                            }else{
                                                $channel_name = "";
                                            }
                                        }else{
                                            $channel_name = "";
                                           }
                                       
                                        $lang = $user->locale;    
                                        $langParts = preg_split('/[_-]/', $lang);    
                                        $final_lang = '';    
                                        if(count($langParts) >= 1) {        
                                            $final_lang = ucfirst($langParts[0]);    
                                             }   
                                             
                                    if(in_array(strtolower($user->email),$invite_emails)){
                                        $source = 'Email Invite';
                                    }else{
										 
                                        /* if(in_array($user->id, $affiliate)){
                                            $source ='PANT';
											}else{
											$source ="";
										   }  */   
									   
									   /* Parshant Sharma [10-09-2024] Start */
									   
									   // Extract the userId column									   
									    $searchUserId = $user->id;
										
										$userIds = array_column($affiliate, 'userId');

										// Find the index of the userId
										$index = array_search($searchUserId, $userIds);

										// Check if the userId was found
										if ($index !== false) {											
											$source = $affiliate[$index]['medium'];											
										} else {
											 $source ="";
										}
											
									   /* Parshant Sharma [10-09-2024] End */
                                    }
                                    //$userData = $usersData[$key] ?? null; 
                                  @endphp
           
                            <tr>
                                <td class="td-th-hide">{{$user->first_name}}</td>
                                <td class="td-th-hide">{{$user->last_name}}</td>
                                <td class="td-th-hide">{{$user->email}}</td>
                                <td>{{ $user->uuid }}</td>
                                <td>{{ $user->panellist_id }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{$final_lang }}</td>
                                <td>{!! $user->confirmed_label !!}</td>
                                <td>
                                    @if($user->unsubscribed == 1)
                                        <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                    @else
                                        <span class="badge badge-danger" style="padding: 5px;">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->active == 1)
                                        
                                        <span class="badge badge-danger" style="padding: 5px;">No</span>
                                    @else
                                        <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->has_active)
                                    <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                    @else
                                    <span class="badge badge-danger" style="padding: 5px;">No</span>
                                    @endif
 
                                </td> {{-- Add Active column by Himanshu 25-09-2025 --}}
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
                                <td>
                                    @if($user->state)
                                        {{ $user->state }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($user->city)
                                        {{ $user->city }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($user->region)
                                        {{ $user->region }}
                                    @else
                                        -
                                    @endif
                                </td>


                                <td>{!! $user->froud_count !!}</td>
                                <td>{{ implode(", ",explode(",",$user->project_ids)) }}</td>
                                @if($user->fraud_count >= $getFraudLimit->value && $user->is_blacklist == 1)
                                <td><span class="btn-sm btn-danger">Blacklisted</span></td>
                                @else
                                <!-- <td><button type="button" class="btn btn-warning" onclick="insertFraud('{{ $user->panellist_id }}')">Fraud</button></td>
                               <td><button type="button" class="btn-sm btn-warning" onclick="openPopup('{{ $user->panellist_id }}')">Fraud</button></td> -->
                                @endif
                                <td>{!!$role_name!!}</td>                              
                                <td>{!! $user->social_buttons_2 !!}</td>
                                <td>{!! optional($user->last_login ? \Carbon\Carbon::parse($user->last_login) : null)->diffForHumans() !!}</td>
                                <td>{{__($Activities)}}</td>
                                <td>{{$maxDate}}</td>
                                <td>@if(isset($profile_filled_count[$user->uuid])){!!$profile_filled_count[$user->uuid] !!}@endif</td>
                                <td>{{__($channel_name)}}</td>
                                <td>{!!$user->survey_taken !!}</td>
                                <td>{{__($survey_status)}}</td>
                                <td>{!!$user->Total_survey_taken!!}</td>    
                                <td>{!!$user->Total_survey_completed!!}</td>
                                <!--<td>{{ \Carbon\Carbon::parse($user->last_survey_completed_on)->format('d-m-Y') }}</td>-->
                                <td>@if(!is_null($user->last_survey_completed_on)){{ \Carbon\Carbon::parse($user->last_survey_completed_on)->format('d-m-Y') }}@endif</td>

                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                                <td>@if(!is_null($user->confirm_at)){{ \Carbon\Carbon::parse($user->confirm_at)->format('d-m-Y') }}@endif</td>
                                <td>@if(in_array($user->id,$affiliate)) PANT @else {{$source}}  @endif</td>
                                <td>    
                                    @php
                                        $device = strtolower($user->platform); // just in case it's capitalized
                                    @endphp

                                    @if($device === 'android' || $device === 'ios')
                                        App ({{ $device }})
                                    @elseif($device === 'web')
                                        Web
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $user->downloaded_app }}</td>
                                <td>{!! $user->action_buttons_2 !!}</td>
                               
                               
                        @endforeach
                       
                       
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        
    </div><!--card-body-->
</div><!--card-->

<!--Bulk Search  -->
<div class="modal fade in bulkSearch" tabindex="-1" role="dialog" id="bulkSearch" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog modal-lg invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('labels.backend.access.users.table.search')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 class="modal-title"></h3>
            </div>
            <form action="{{route('admin.auth.user.fraud')}}" method="post">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.search_type')</span>
                                <select name="searchType" id="searchType" class="form-control" required>
                                    <option value="">@lang('labels.backend.access.users.table.select_type')</option>
                                    <option value="uuid">@lang('labels.backend.access.users.table.uuid')</option>
                                    <option value="panelists_id">@lang('labels.backend.access.users.table.panelistid')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.user_ids')</span>
                                <textarea name="userids" class="form-control" placeholder="Enter Data (ex-1,2,3,4)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" class="btn btn-primary" style="margin-right: 20px;" >@lang('labels.backend.access.users.table.apply')</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->

<!------Popup Comment----------->
<div class="modal fade in popupComment" tabindex="-1" role="dialog" id="popupComment" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('labels.backend.access.users.table.add_fraud')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closePopup()">x</button> <h3 class="modal-title"></h3>
            </div>
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.project_code')</span>
                                <!-- <select name="searchType" id="searchType" class="form-control" required>
                                    <option value="">Select Search Type</option>
                                    <option value="uuid">UUID</option>
                                    <option value="panelists_id">Panelists Id</option>
                                </select> -->
                                <input type="text" id="projectid" class="form-control" required>
                                <input type="hidden" id="panelistsId" class="form-control">
                                <input type="hidden" id="managerId" class="form-control" value="{{ $userid }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.reason')</span>
                                <textarea id="reason" class="form-control" placeholder="@lang('labels.backend.access.users.table.enter_reason')"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" class="btn btn-primary" style="margin-right: 20px;" onclick="insertFraud()">@lang('labels.backend.access.users.table.apply')</button>
                    </div>
                </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->

<!-- Bulk Upload mark fraud -->
<div class="modal fade in bulkimport" tabindex="-1" role="dialog" id="bulkimport" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog modal-lg invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('labels.backend.access.users.table.bulk_upload')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 class="modal-title"></h3>
            </div>
            <form action="{{route('admin.auth.user.importFraudUser')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <a href="{{asset('demofraud/Sample_fraud_users.csv')}}">@lang('labels.backend.access.users.table.sample_excel')</a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.upload_excel')</span><br>
                                <input type="file" name="importfile" id="importfile" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" class="btn btn-primary" style="margin-right: 20px;" >@lang('labels.backend.access.users.table.upload')</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->

<!--Export Profile Data -->
<div class="modal fade in exportProfileData" tabindex="-1" role="dialog" id="exportProfileData" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog modal-lg invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('labels.backend.access.users.table.export_profile')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 class="modal-title"></h3>
            </div>
            <form action="{{route('admin.auth.user.exportUserProfile')}}" id="profileForm" method="post">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <span>Search Type</span>
                                <select name="searchType" id="searchType" class="form-control" required>
                                    <option value="">Select Search Type</option>
                                    <option value="uuid">UUID</option>
                                    <option value="panelists_id">Panellists Id</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.panelistid')</span>
                                <textarea name="panellist_ids" class="form-control" placeholder="Panellist Ids (ex-1,2,3,4)" required></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>@lang('labels.backend.access.users.table.country_code')</span>
                                <select name="country_code" id="country_code" class="form-control" required>
                                    <option value="US">US</option>
                                    <option value="IN">IN</option>
                                    <option value="CA">CA</option>
                                    <option value="UK">UK</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label fw-bold">Profile Section</label>
                                </div>
                                
                                <div class="col-sm-6">
                                    <!-- All Profiles -->
                                    <div class="form-check">
                                        {{ html()->checkbox('all_profile', 'all_profiles')->id('allprofile')->class('form-check-input') }}
                                        {{ html()->label('All Profiles')->for('allprofile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Basic -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'BASIC')->id('basic_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Basic')->for('basic_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- My Profile -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'MY_PROFILE')->id('my_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('My Profile')->for('my_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Family -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'FAMILY')->id('family_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Family')->for('family_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Automotive -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'AUTOMOTIVE')->id('automotive_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Automotive')->for('automotive_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Employment -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'EMPLOYMENT')->id('employment_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Employment')->for('employment_profile')->class('form-check-label') }}
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <!-- Travel / Leisure -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'TRAVEL_LEISURE')->id('travel_leisure_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Travel / Leisure')->for('travel_leisure_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Internet / Games / Sports -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'INTERNET_GAMES_SPORTS')->id('internet_games_sports_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Internet / Games / Sports')->for('internet_games_sports_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Health / Food -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'HEALTH_FOOD')->id('health_food_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Health / Food')->for('health_food_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Technology -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'TECHNOLOGY')->id('technology_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Technology')->for('technology_profile')->class('form-check-label') }}
                                    </div>
                                    
                                    <!-- Hidden -->
                                    <div class="form-check">
                                        {{ html()->checkbox('profile_section[]', 'HIDDEN')->id('hidden_profile')->class('allselect form-check-input') }}
                                        {{ html()->label('Hidden')->for('hidden_profile')->class('form-check-label') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" class="btn btn-primary" style="margin-right: 20px;" id="exportData" >@lang('labels.backend.access.users.table.export')</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->

<!-- <div class="alert alert-warning logged-in-as mb-0">
        You are currently logged in as {{ Auth::user()->name }}. <a href="https://test17.sjpanel.com/admin/auth/user/{{$user->id}}/login-as">Re-Login as {{ Auth::user()->name }}</a>.
</div> -->




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
        $('#user_management').DataTable({
            deferRender: true,
            serverSide: false,
            stateSave: true,
            destroy: true,
            search: {
                regex: true,
                caseInsensitive: false
            },
            'processing': true,
            deferRender: true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
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
            "ordering": false,
        });
        $(".dataTables_wrapper").css("width","100%");
    });
</script>

  
   

    <script>
        function openPopup(panelistsId){
            $('#popupComment').modal('show');
            $('#panelistsId').val(panelistsId);
            
        }

        function insertFraud(){
            var panelistsId = $('#panelistsId').val();
            var managerId   = $('#managerId').val();
            var projectid   = $('#projectid').val();
            var reason      = $('#reason').val();
            
        //    alert(panelistsId);
        //    alert(managerId);
        //    alert(projectid);
        //    alert(reason);
            $.ajax({
                /* the route pointing to the post function */
                url: "{{route('admin.auth.user.insertfraud')}}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: "{{ csrf_token() }}", panelistsId : panelistsId , managerId : managerId , projectid : projectid , reason : reason},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (response) { 
                    try{
                        if (response.status === 200) {
                           // swal('Fraud action successfully');
                            $('#panelistsId').val('');
                            $('#managerId').val('');
                            $('#projectid').val('');
                            $('#reason').val('');

                            swal({text: "Fraud action successfully"}).then(function(){ location.reload();});
                           
                        }
                    }catch(error){
                        swal({text: "Some error occure!", type: "error"});
                    } 
                }
            }); 
        }

        function closePopup(){
            $('#popupComment').modal('hide');
        }

        $('#exportData').click(function(){
            setTimeout(function () {
                location.reload(true);
            }, 2000);
            
        });
    
       $('#allprofile').click(function(){
            if($(this).is(':checked')){
                $(".allselect").prop('checked',true)
            }else{
                $(".allselect").prop('checked',false)
            }

       }); 

    
        $('#profileForm').on('submit', function(e) {
            // Count how many checkboxes are checked
            if ($('.allselect:checked').length === 0) {
                e.preventDefault(); // Stop form submission
                alert('Please select at least one Profile Section.');
                // return false;
            }
        });


        
    </script>
@endpush
