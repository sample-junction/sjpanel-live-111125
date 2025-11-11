<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'teams'],
            //'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
	    'days' => 14,
	    'permission' => 0777,
        ],

        'teams' => [
            'driver'    => 'custom',
            'via'       => \SampleJunction\LaravelLoggerForTeams\LoggerChannel::class,
            'level'     => 'debug',
            'url'       => env('LOG_TEAMS_WEBHOOK_URL', 'https://outlook.office.com/webhook/8cc08659-8d48-4b7a-aa56-e3721a2e079a@e24e70de-a391-4c09-9140-90bcdfc15f42/IncomingWebhook/bf2597e63b3846fab89aefcc26624a25/f8f01fb5-2bbb-41a2-b526-982c3a299a02'),
            'style'     => 'card',    // Available style is 'simple' and 'card', default is 'simple'
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'SJ Panel - Logger',
            'emoji' => ':robot_face:',
            'level' => 'debug',
        ],

        'slack-monitor' => [
            'driver' => 'slack',
            'url' => env('MONITOR_SLACK_WEBHOOK_URL'),
            'username' => 'SJ Panel Monitor BOT',
            'emoji' => ':robot_face:',
            'level' => 'debug',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
