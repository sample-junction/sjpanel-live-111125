@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{__('Campaign Data Information')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="row">
                <table class="table table-striped table-hover" id="affiliate_campaign_data" style="width:100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>User Name</th>
                        <th>Campaign</th>
                        <th>Affiliate</th>
                        <th>Medium</th>
                        <th>Affiliate Vars</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($affiliate_campaign_datas as $campaign_data)
                            <tr>
                                <td></td>
                                <td>@unless(!$campaign_data->user){{$campaign_data->user->first_name}}@endunless</td>
                                <td>@unless(!$campaign_data->user){{$campaign_data->campaign->name}}@endunless</td>
                                <td>{{$campaign_data->affiliate->name}} </td>
                                <td>{{$campaign_data->medium}}</td>
                                <td>{{$campaign_data->aff_vars}}</td>
                                <td>{{$campaign_data->status}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>-->
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
        $(document).ready(function() {
            new ClipboardJS('.btn-copy');
            $('#affiliate_campaign_data').DataTable({
                serverSide: true,
                destroy: true,
                'processing': true,
                ajax: "{{ route('admin.auth.affiliate.campaign.data.datatable') }}",
                columns: [
                    { name: 'id' },
                    { name: 'user.first_name' , orderable:false},
                    { name: 'campaign.name' , orderable:false},
                    { name: 'affiliate.name' , orderable:false},
                    { name: 'medium'},
                    { name: 'aff_vars'},
                    { name: 'status'}
                ],
            });
            $(".dataTables_wrapper").css("width","100%");
        } );
    </script>
@endpush
