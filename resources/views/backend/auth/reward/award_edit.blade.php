@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Edit Award' )


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-10">
                <label>
                    <h4>
                        {{__('Edit Award')}}
                    </h4>
                </label>
            </div>
        </div>
    </div>
    {{html()->form('POST',route('admin.auth.awards.edit.post',['award_id'=>$award->id]))->open()}}
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Award Name:</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {{-- <input type="text" class="form-control" placeholder="Enter Award's Name" value="{{$award->name}}" name="name"><br> --}}
                    <input type="text" class="form-control" placeholder="Enter Award's Name" value="{{ $award->name ?? '' }}" name="name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Nominations Start No. :</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nominations Start no." value="{{ $award->nomination_start ?? '' }}" name="nomination_start">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Nominations End No. :</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nominations End no." value="{{ $award->nomination_end ?? '' }}" name="nomination_end">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Mail Template:</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select class="form-control" name="mail_template_id">
                        <option value="">Select mail template </option>
                        @foreach($mail_templates as $id => $name)
                        <option value="{{ $id }}" {{($award->mail_template_id==$id)?'selected':''}} >{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Status:</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="1" {{($award->status=='1')?'selected':''}}>Active</option>
                        <option value="0" {{($award->status!='1')?'selected':''}}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>


    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <a href="{{route('admin.auth.awards.list')}}" class="btn btn-primary">Back</a>
                    <input type="submit" class="btn btn-primary" id="create" value="Update" name="submit"><br>
                </div>
            </div>
        </div>
    </div><!--card-footer-->
    {{html()->form()->close()}}
</div><!--card-->
@endsection
@push('after-styles')
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">

@endpush

@push('after-scripts')
{{-- For DataTables --}}
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
{{--<script>
        $(document).ready(function () {
            $('#create').on('click',function (e) {
                var vars = $('#aff_vars').val();
                var variables = vars.split(',');
                console.log(variables);
                console.log(Array.isArray(variables));
                return false;
            })
        })
    </script>--}}
@endpush
