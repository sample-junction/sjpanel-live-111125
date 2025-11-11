<div class="ibox float-e-margins">
    <div class="ibox-title">
        Delete Personal Info
    </div>
    <div class="ibox-content">
        {!! BootForm::vertical(['id'=>'pinfo_delete_form']) !!}

        <p><strong>Your Personal Information will be immediately deleted. </strong></p>

        {!! BootForm::checkbox('delete_confirmation', 'I understand that my personal information will be deleted.', '1', false); !!}

        {!! BootForm::hidden('section', request()->route()->parameter('name') ) !!}

        {!! BootForm::submit('Delete Personal Info',['class'=>'btn btn-danger delete_pinfo_submit']) !!}

        {!! BootForm::close() !!}
    </div>
</div>
@push('after-styles')
    <!-- Sweet Alert -->
    {{--<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">--}}
    <style>
        .sweet-alert button.cancel{
            background-color: #23c6c8;
        }

        .sweet-alert button.cancel:hover{
            background-color: #21b9bb;
        }
        .swal-wide{
            width:600px !important;
        }
    </style>
@endpush
@push('after-scripts')
    <!-- Sweet alert -->
    {{--<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>--}}
    <script>
        $(document).ready(function(){

            jQuery('.delete_account_submit').click(function (e) {
                e.preventDefault();
                swal({
                    title: "Delete my account!",
                    html:"<p>We're sorry to hear you'd like to delete your account</p><br/>" +
                        "<p>Why are you deleting your account ?</p>" +
                        "<div class=\"form-group\">" +
                        "    <textarea class=\"form-control\" id=\"unsubscribe_reason\" rows=\"3\"></textarea>" +
                        "  </div>",
                    // --------------^-- define html element with id
                    width: '600px',
                    customClass: 'swal-wide',
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#ed5565",
                    confirmButtonText: "Delete now!",
                    cancelButtonText: "I changed my mind",
                    cancelButtonColor: "#1080d0",
                    closeOnConfirm: false,
                })
                    .then((result) => {
                        if (result.value) {
                            jQuery('#account_delete_form').submit();
                            // For more information about handling dismissals please visit
                            // https://sweetalert2.github.io/#handling-dismissals
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Your imaginary file is safe :)',
                                'error'
                            )
                        }
                    })
            });

        });
    </script>

@endpush

@push('after-scripts')
    {{--@php

        $tour_detail = $user_add_data->user_tour_taken;
         $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='preferences.delete-account' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
    @endphp
    <script>
    @if($tour_taken == 0)
@include('inpanel.includes.partials.php-js.delete')
        @endif
    </script>--}}
@endpush

