@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 pull-left">
                    <label>
                        <h4>
                            {{__('List Of Blacklisted IPs')}}
                        </h4>
                    </label>
                </div>
                <div class="col-sm-6 pull-right">
                    <a href="{{route('admin.auth.setting.add.unique_ip_check')}}" class="btn btn-primary">Add Ips</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-striped table-hover" id="redeem-request" style="width:50%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Blacklisted IP</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blacklisted_ips as $ip)
                        <tr>
                            <td>{{$ip}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{html()->form()->close()}}
        <div class="card-footer">
        </div><!--card-footer-->
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
