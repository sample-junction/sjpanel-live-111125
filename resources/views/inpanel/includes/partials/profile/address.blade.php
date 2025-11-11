<div class="ibox float-e-margins">
    <div class="ibox-title">
        {{__('inpanel.user.profile.preferences.address.basic_profile')}}
    </div>
    <div class="ibox-content">
        @if (isset($status))
            <div class="alert alert-success">
                {{ $status }}
            </div>
        @endif

        {!! BootForm::horizontal(); !!}

        {!! BootForm::text('first_name', null, auth()->user()->first_name) !!}

        {!! BootForm::text('last_name', null, auth()->user()->last_name) !!}

        {!! BootForm::radios('gender', 'Gender', ['male'=>'Male', 'female'=> 'Female'], auth()->user()->gender); !!}

        {!! BootForm::text('dob', 'Date of birth', (!empty(auth()->user()->dob))?auth()->user()->dob->format('Y-m-d'):'', ['id'=>'dob','placeholder'=>'Y-m-d']) !!}

        {!! BootForm::password('password') !!}
        {!! BootForm::password('password_confirmation', 'Confirm Password') !!}

        {!! BootForm::submit('Update'); !!}

        {!! BootForm::close() !!}
    </div>
</div>
