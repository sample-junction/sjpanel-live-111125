<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fas fa-bars"></i> </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <!-- <li>
                <span class="m-r-sm text-muted welcome-message">{{__('inpanel.topbar.title')}}</span>
            </li> -->
            <!-- <li>
                <a href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}">
                    <i class="fas fa-cog"></i> {{__('inpanel.nav.preferences')}}
                </a>
            </li> -->
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>  <span class="label label-primary"></span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> {{__('inpanel.topbar.notification')}}
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="logout-class">
                <a href="{{ route('frontend.auth.logout') }}">
                    <i class="fas fa-sign-out-alt"></i> {{__('inpanel.topbar.logout')}}
                </a>
            </li>
        </ul>

    </nav>
</div>
@push('after-scripts')
<script>
    $(document).on('click','.logout-class',function(){
        name="Tour";
        document.cookie = name+'=; Max-Age=-99999999;'; 
       
    })
    </script>
@endpush
