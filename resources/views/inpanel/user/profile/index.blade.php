@extends('inpanel.layouts.app')
@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="ibox-content m-b-sm border-bottom">
                <div class="p-xs">
                    <div class="pull-left m-r-md">
                        <i class="fa fa-globe text-navy mid-icon"></i>
                    </div>
                    <h2>Update Profile</h2>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
            </div>
        </div>
    </div>
@endsection
