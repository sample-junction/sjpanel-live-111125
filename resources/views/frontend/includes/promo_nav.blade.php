<!-- ########################### SECTION START ########################### -->
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">{{__('frontend.nav2.static.title')}}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('frontend.index') }}"><img style="width: 60%;" src="{{ asset('/images/logo.png') }}" class="logo-name"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hideonmobile getproposal ga-event-proposal-button-header menu-item menu-item-type-custom2 menu-item-object-custom2">
                        <a href="{{route('frontend.auth.login')}}" class="getStarted btn btn-primary">
                            {{__('frontend.nav2.static.link.login')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- ########################### SECTION END ########################### -->
