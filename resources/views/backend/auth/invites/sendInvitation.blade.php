@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('content')
<div class="card">
	<div class="card-header"></div>
    <div class="card-body">
        <div class="row">
			<div class="col-md-6"><a href="{{ url('/admin/auth/invite') }}" class="btn btn-primary" target="_blank">Verify Email</a></div>
			<div class="col-md-6"><a href="{{ route('admin.auth.invite.invitation') }}" class="btn btn-primary" target="_blank">Fresh Invite Send Mail</a></div>
        </div>
    </div>    
</div>
@endsection
