@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 pull-left">
                    <label>
                        <h4>
                            {{__('Add IPs')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.setting.post.unique_ip_check'))->open()}}
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-10">
                    <div class="col-lg-10">
                        <label class="control-label"><strong>{{__('Insert Ips Line Seperated')}}:</strong></label>&nbsp;
                        <textarea class="form-control" name="ips" rows="10" style="min-width: 100%"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="Add" name="submit">
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
    <script>
        $(".dataTables_wrapper").css("width","100%");
    </script>
@endpush
