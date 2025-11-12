@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Edit Award History' )


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{__('Edit Award History')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.reward.history.edit.post', ['id' => $awardData->id]))->open()}}
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Redemption Status:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <select name="redemption_status" id="redemption_status" class="form-control">
                            <option value="" selected>Not Redeemed </option> 
                            <option value="Redeemed" {{ ( old('redemption_status', $awardData->redemption_status) == 'Redeemed' ? 'selected' : '') }}>Redeemed</option>
                                
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Redeemed at:</h6>
                            <span> <strong>Note:</strong> Please enter the time in UTC </span>
                        </label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <input type="date" class="form-control me-2" name="redemption_date" placeholder="Enter Zoom Link Date" value="{{ old('redemption_date',$redemption_date) }}" >
                            <input type="time" class="form-control" name="redemption_time" placeholder="Enter Zoom Link Time" value="{{ old('redemption_time',$redemption_time) }}" >
                        </div>
                    </div>
                </div>
            </div>
            
    
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{route('admin.auth.reward.history')}}" class="btn btn-primary">Back</a>
                        <input type="submit" class="btn btn-primary" id="create" value="Update" name="submit"><br>
                    </div>
                </div>
            </div>
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

@endpush
