@extends('backend.layouts.app')

@section('title', __('labels.backend.access.setting.management') . ' | ' . __('labels.backend.access.setting.titles.point_system_title'))

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 pull-left">
                    <label>
                        <h4>
                            {{__('Point System')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.setting.post.point_system_setting'))->open()}}
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Sign-up Points')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="signup_points" value="{{$signupPoints->value}}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Account Activation')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="account_activation" value="{{ $accountActivation->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">                    
                            <label class="control-label"><strong>{{__('Technology Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="technology_profile" value="{{ $technologyPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Health/Food Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text" name="helthfood_profile" value="{{ $healthfoodPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Internet/Games/Sports Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="internet_profile" value="{{ $internetPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Travel/Leisure Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">    
                            <input type="text"  name="travel_profile" value="{{ $travelLeisurePoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Employment Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="employment_profile" value="{{ $employmentPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Automotive Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="automotive_profile" value="{{ $automativePoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Family Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text"  name="family_profile" value="{{ $familyPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('My Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <input type="text" name="my_profile" value="{{ $myProfilePoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Completing Basic Profile')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">    
                            <input type="text"  name="basic_profile" value="{{ $basicProfilePoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Social Profile Linked')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">       
                            <input type="text"  name="social_profile" value="{{ $socialProfilePoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>    
            </div>

            <div class="row">
                
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Friend Referral')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">       
                            <input type="text"  name="friend_referral" value="{{ $frienfReferralPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
				
				<!-- Parshant Sharma [02-09-2024] STARTS -->
				
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<div class="row">
						<div class="col-lg-7 col-md-6 col-sm-12">
							<label class="control-label"><strong>{{__('Redeemption Threshold US')}}:</strong></label>
						</div>
						<div class="col-lg-5 col-md-6 col-sm-12">     
							<input type="text"  name="redeemption_threshold_US" value="{{ $redeemptionThresholdPoints_US->value }}" required class="form-control">
						</div>
					</div>
				</div>			

				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<div class="row">
						<div class="col-lg-7 col-md-6 col-sm-12">
							<label class="control-label"><strong>{{__('Redeemption Threshold UK')}}:</strong></label>
						</div>
						<div class="col-lg-5 col-md-6 col-sm-12">     
							<input type="text"  name="redeemption_threshold_UK" value="{{ $redeemptionThresholdPoints_UK->value }}" required class="form-control">
						</div>
					</div>
				</div>	

				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<div class="row">
						<div class="col-lg-7 col-md-6 col-sm-12">
							<label class="control-label"><strong>{{__('Redeemption Threshold CA')}}:</strong></label>
						</div>
						<div class="col-lg-5 col-md-6 col-sm-12">     
							<input type="text"  name="redeemption_threshold_CA" value="{{ $redeemptionThresholdPoints_CA->value }}" required class="form-control">
						</div>
					</div>
				</div>	

				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<div class="row">
						<div class="col-lg-7 col-md-6 col-sm-12">
							<label class="control-label"><strong>{{__('Redeemption Threshold IN')}}:</strong></label>
						</div>
						<div class="col-lg-5 col-md-6 col-sm-12">     
							<input type="text"  name="redeemption_threshold_IN" value="{{ $redeemptionThresholdPoints_IN->value }}" required class="form-control">
						</div>
					</div>
				</div>					
				
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
					<div class="row">
						<div class="col-lg-7 col-md-6 col-sm-12">
							<label class="control-label"><strong>{{__('Redeemption Threshold AU')}}:</strong></label>
						</div>
						<div class="col-lg-5 col-md-6 col-sm-12">     
							<input type="text"  name="redeemption_threshold_AU" value="{{ $redeemptionThresholdPoints_AU->value }}" required class="form-control">
						</div>
					</div>
				</div>
				<!-- Parshant Sharma [02-09-2024] ENDS -->

                <!-- <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Redeemption Multiply')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">     
                            <input type="text"  name="redeemption_multiply" value="{{ $redeemptionMultiplyPoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div> -->
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Profile Image')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">       
                            <input type="text"  name="profile_image" value="{{ $profileImagePoints->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('inpanel.activity_log.email_invite_check')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">       
                            <input type="text"  name="email_invite" value="{{ $emailInviteCheck->value }}" required class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Reminder Invite Time')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">       
                            <input type="text"  name="reminder_invite_time" value="{{ $reminderInviteTime->value }}" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <label class="control-label"><strong>{{__('Profile Update Time')}}:</strong></label>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">       
                            <input type="text" name="profile_update_time" value="{{ isset($profileUpdateTime) ? $profileUpdateTime->value : 24 }}" required class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="Update" name="submit">
            <p class="error-message" style="color: red;"></p>

        </div><!--card-footer-->
        {{html()->form()->close()}}
    </div><!--card-->
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >

@endpush
@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".dataTables_wrapper").css("width","100%");

         $('input[type="text"]').on('input', function() {
            var errorMessage = $('.error-message');
            
            $('input[type="text"]').each(function() {
                var inputText = $(this).val();

                if (!/^\d+$/.test(inputText)) {
                    $(this).css('border', '1px solid red');
                } else {
                    $(this).css('border', ''); 
                }
            });

            var invalidFields = $('input[type="text"]').filter(function() {
                return !/^\d+$/.test($(this).val());
            });

            if (invalidFields.length === 0) {
                $('input[type="submit"]').prop('disabled', false);
                errorMessage.text('').hide();
            } else {
                $('input[type="submit"]').prop('disabled', true);
            }
        });


    </script>
@endpush
