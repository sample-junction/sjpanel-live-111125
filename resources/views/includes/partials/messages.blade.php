@if ($errors->any())
    @push('after-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof toastr === 'undefined') return console.error('toastr not loaded');

                const opts = {
                    closeButton: true,
                    debug: false,
                    newestOnTop: true,
                    progressBar: false,
                    positionClass: "toast-top-right",
                    preventDuplicates: false,
                    showDuration: "10",
                    hideDuration: "1000",
                    timeOut: 0,
                    extendedTimeOut: 0,
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                };

                toastr.options = opts;

                @if ($errors->any())
                    let title = {!! json_encode(
                        (__('inpanel.user.profile.preferences.preferences_menu.toastr_error') === 'inpanel.user.profile.preferences.preferences_menu.toastr_error')
                        ? 'Error'
                        : __('inpanel.user.profile.preferences.preferences_menu.toastr_error')
                    ) !!};

                    @foreach ($errors->all() as $error)
                        toastr.error({!! json_encode($error) !!}, title);
                    @endforeach
                @endif
            });
        </script>
    @endpush

@elseif (session()->get('flash_success'))
    @push('after-scripts')
        <script>
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                @if(is_array(session()->get('flash_success')))
                    toastr.success(
                        "{!! implode('<br/>', session()->get('flash_success')) !!}", 
                        "{!! __('inpanel.user.profile.preferences.preferences_menu.toastr_success') !!}");
                @else
                    toastr.success(
                        "{!! session()->get('flash_success') !!}", 
                        "{!! __('inpanel.user.profile.preferences.preferences_menu.toastr_success') !!}"
                    );
                @endif
            }, 400);
        </script>
    @endpush

@elseif (session()->get('flash_warning'))
    @push('after-scripts')
        <script>
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                @if(is_array(json_decode(session()->get('flash_warning'), true)))
                toastr.warning("{!! implode('', session()->get('flash_warning')->all(':message<br/>')) !!}", "{!!__('inpanel.user.profile.preferences.preferences_menu.toastr_warning')!!}");
                @else
                toastr.warning("{!! session()->get('flash_warning') !!}", "{!!__('inpanel.user.profile.preferences.preferences_menu.toastr_warning')!!}");
                @endif
            }, 400);
        </script>
    @endpush
@elseif (session()->get('flash_info'))
    @push('after-scripts')
        <script>
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };

                @if(is_array(json_decode(session()->get('flash_info'), true)))
                toastr.info("{!! implode('', session()->get('flash_info')->all(':message<br/>')) !!}", "{!!__('inpanel.user.profile.preferences.preferences_menu.toastr_information')!!}");
                @else
                toastr.info( "{!! session()->get('flash_info') !!}", "{!!__('inpanel.user.profile.preferences.preferences_menu.toastr_information')!!}");
                @endif
            }, 400);
        </script>
    @endpush
@elseif (session()->get('flash_danger'))
@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session()->has('flash_danger'))
            (function(){
                var msg   = {!! json_encode(session()->get('flash_danger')) !!};
                var title = {!! json_encode(
                    (__('inpanel.user.profile.preferences.preferences_menu.toastr_error') === 'inpanel.user.profile.preferences.preferences_menu.toastr_error')
                    ? 'Error'
                    : __('inpanel.user.profile.preferences.preferences_menu.toastr_error')
                ) !!};

                try {
                    var parsed = JSON.parse(msg);
                    if (Array.isArray(parsed)) {
                        msg = parsed.join('<br/>');
                    } else if (typeof parsed === 'object' && parsed !== null) {
                        msg = Object.values(parsed).join('<br/>');
                    }
                } catch(e) {
                    // not JSON, ignore
                }

                if (typeof toastr === 'undefined') {
                    console.error('toastr is not defined — make sure toastr.js is loaded before this script');
                    return;
                }

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 0,
                    extendedTimeOut: 0
                };

                toastr.error(msg, title);
            })();
        @endif

        @if(session()->has('flash_info'))
            (function(){
                var msg   = {!! json_encode(session()->get('flash_info')) !!};
                var title = {!! json_encode(
                    (__('inpanel.user.profile.preferences.preferences_menu.toastr_information') === 'inpanel.user.profile.preferences.preferences_menu.toastr_information')
                    ? 'Info'
                    : __('inpanel.user.profile.preferences.preferences_menu.toastr_information')
                ) !!};

                if (typeof toastr === 'undefined') {
                    console.error('toastr is not defined — make sure toastr.js is loaded before this script');
                    return;
                }

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 5000,
                    extendedTimeOut: 1000
                };

                toastr.info(msg, title);
            })();
        @endif
    });
</script>
@endpush

@elseif (session()->get('flash_message'))
    @push('after-scripts')
        <script>
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };

                @if(is_array(json_decode(session()->get('flash_message'), true)))
                toastr.info("{!! implode('', session()->get('flash_message')->all(':message<br/>')) !!}", "{!!__('inpanel.user.profile.preferences.preferences_menu.toastr_message')!!}");
                @else
                toastr.info("{!! session()->get('flash_message') !!}", "{!!__('inpanel.user.profile.preferences.preferences_menu.toastr_message')!!}");
                @endif
            }, 500);
        </script>
    @endpush
@endif
