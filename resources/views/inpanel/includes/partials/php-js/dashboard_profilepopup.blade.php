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
                    title: "Profile Update",
                    html:"<p>Would you like to update the profile</p><br/>",
                    width: '600px',
                    customClass: 'swal-wide',
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#ed5565",
                    confirmButtonText: "Yes, Update",
                    cancelButtonText: "No",
                    cancelButtonColor: "#1080d0",
                    closeOnConfirm: false,
                })
                    .then((result) => {
                        if (result.value) {
                            window.location.href="dashboard"
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


