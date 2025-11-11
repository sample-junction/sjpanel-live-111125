<?php return array (
  'albertcht/invisible-recaptcha' => 
  array (
    'providers' => 
    array (
      0 => 'AlbertCht\\InvisibleReCaptcha\\InvisibleReCaptchaServiceProvider',
    ),
  ),
  'anlutro/l4-settings' => 
  array (
    'aliases' => 
    array (
      'Setting' => 'anlutro\\LaravelSettings\\Facade',
    ),
    'providers' => 
    array (
      0 => 'anlutro\\LaravelSettings\\ServiceProvider',
    ),
  ),
  'appstract/laravel-blade-directives' => 
  array (
    'providers' => 
    array (
      0 => 'Appstract\\BladeDirectives\\BladeDirectivesServiceProvider',
    ),
  ),
  'arcanedev/log-viewer' => 
  array (
    'providers' => 
    array (
      0 => 'Arcanedev\\LogViewer\\LogViewerServiceProvider',
    ),
  ),
  'arcanedev/no-captcha' => 
  array (
    'providers' => 
    array (
      0 => 'Arcanedev\\NoCaptcha\\NoCaptchaServiceProvider',
    ),
    'aliases' => 
    array (
      'Captcha' => 'Arcanedev\\NoCaptcha\\Facades\\NoCaptcha',
    ),
  ),
  'barryvdh/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Cors\\ServiceProvider',
    ),
  ),
  'barryvdh/laravel-debugbar' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Debugbar\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Debugbar' => 'Barryvdh\\Debugbar\\Facade',
    ),
  ),
  'barryvdh/laravel-ide-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'beyondcode/laravel-dump-server' => 
  array (
    'providers' => 
    array (
      0 => 'BeyondCode\\DumpServer\\DumpServerServiceProvider',
    ),
  ),
  'beyondcode/laravel-self-diagnosis' => 
  array (
    'providers' => 
    array (
      0 => 'BeyondCode\\SelfDiagnosis\\SelfDiagnosisServiceProvider',
    ),
  ),
  'creativeorange/gravatar' => 
  array (
    'providers' => 
    array (
      0 => 'Creativeorange\\Gravatar\\GravatarServiceProvider',
    ),
    'aliases' => 
    array (
      'Gravatar' => 'Creativeorange\\Gravatar\\Facades\\Gravatar',
    ),
  ),
  'davejamesmiller/laravel-breadcrumbs' => 
  array (
    'providers' => 
    array (
      0 => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsServiceProvider',
    ),
    'aliases' => 
    array (
      'Breadcrumbs' => 'DaveJamesMiller\\Breadcrumbs\\Facades\\Breadcrumbs',
    ),
  ),
  'dimsav/laravel-translatable' => 
  array (
    'providers' => 
    array (
      0 => 'Dimsav\\Translatable\\TranslatableServiceProvider',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'freshbitsweb/laratables' => 
  array (
    'providers' => 
    array (
      0 => 'Freshbitsweb\\Laratables\\LaratablesServiceProvider',
    ),
  ),
  'hieu-le/active' => 
  array (
    'providers' => 
    array (
      0 => 'HieuLe\\Active\\ActiveServiceProvider',
    ),
    'aliases' => 
    array (
      'Active' => 'HieuLe\\Active\\Facades\\Active',
    ),
  ),
  'jenssegers/mongodb' => 
  array (
    'providers' => 
    array (
      0 => 'Jenssegers\\Mongodb\\MongodbServiceProvider',
      1 => 'Jenssegers\\Mongodb\\MongodbQueueServiceProvider',
    ),
  ),
  'laravel/nexmo-notification-channel' => 
  array (
    'providers' => 
    array (
      0 => 'Illuminate\\Notifications\\NexmoChannelServiceProvider',
    ),
  ),
  'laravel/slack-notification-channel' => 
  array (
    'providers' => 
    array (
      0 => 'Illuminate\\Notifications\\SlackChannelServiceProvider',
    ),
  ),
  'laravel/socialite' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
    ),
    'aliases' => 
    array (
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravelcollective/html' => 
  array (
    'providers' => 
    array (
      0 => 'Collective\\Html\\HtmlServiceProvider',
    ),
    'aliases' => 
    array (
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nikaia/translation-sheet' => 
  array (
    'providers' => 
    array (
      0 => 'Nikaia\\TranslationSheet\\TranslationSheetServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'samplejunction/custombootstrapform' => 
  array (
    'providers' => 
    array (
      0 => 'Samplejunction\\CustomBootstrapForm\\CustomBootstrapFormProvider',
    ),
    'aliases' => 
    array (
      'CustomBootForm' => 'Samplejunction\\CustomBootstrapForm\\Facades\\CustomBootstrapForm',
    ),
  ),
  'spatie/laravel-activitylog' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
    ),
  ),
  'spatie/laravel-html' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Html\\HtmlServiceProvider',
    ),
    'aliases' => 
    array (
      'Html' => 'Spatie\\Html\\Facades\\Html',
    ),
  ),
  'spatie/laravel-permission' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Permission\\PermissionServiceProvider',
    ),
  ),
  'torann/geoip' => 
  array (
    'providers' => 
    array (
      0 => 'Torann\\GeoIP\\GeoIPServiceProvider',
    ),
    'aliases' => 
    array (
      'GeoIP' => 'Torann\\GeoIP\\Facades\\GeoIP',
    ),
  ),
  'watson/bootstrap-form' => 
  array (
    'providers' => 
    array (
      0 => 'Watson\\BootstrapForm\\BootstrapFormServiceProvider',
    ),
    'aliases' => 
    array (
      'BootForm' => 'Watson\\BootstrapForm\\Facades\\BootstrapForm',
    ),
  ),
  'webpatser/laravel-uuid' => 
  array (
    'providers' => 
    array (
      0 => 'Webpatser\\Uuid\\UuidServiceProvider',
    ),
    'aliases' => 
    array (
      'Uuid' => 'Webpatser\\Uuid\\Uuid',
    ),
  ),
);