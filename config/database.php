<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    'mongodb_primary' => env('MONGO_DB_CONNECTION', 'mongodb'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'sqlite_testing' => [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('SJP_DB_HOST', '127.0.0.1'),
            'port' => env('SJP_DB_PORT', '3306'),
            'database' => env('SJP_DB_DATABASE', 'forge'),
            'username' => env('SJP_DB_USERNAME', 'forge'),
            'password' => env('SJP_DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],
        'mysql_additional' => [
            'driver' => 'mysql',
            //'url' => env('DATABASE_URL'),
            'host' => env('SJP_ADDITIONAL_DB_HOST', '127.0.0.1'),
            'port' => env('SJP_ADDITIONAL_DB_PORT', '3306'),
            'database' => env('SJP_ADDITIONAL_DB_DATABASE', 'forge'),
            'username' => env('SJP_ADDITIONAL_DB_USERNAME', 'forge'),
            'password' => env('SJP_ADDITIONAL_DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
        'mysql_global' => [
            'driver' => 'mysql',
            'host' => env('GLOBAL_SJP_DB_HOST', '45.40.143.179'),
            'port' => env('GLOBAL_SJP_DB_PORT', '3306'),
            'database' => env('GLOBAL_SJP_DB_DATABASE', 'sjpanel_live_global'),
            'username' => env('GLOBAL_SJP_DB_USERNAME', 'sjpanel_live_v2'),
            'password' => env('GLOBAL_SJP_DB_PASSWORD', '-eOG!MuZEGP&'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_DB_HOST', 'localhost:81'),
            'port' => env('MONGO_DB_PORT', 27017),
            'database' => env('MONGO_DB_DATABASE','apace_temp'),
            'username' => env('MONGO_DB_USERNAME','root'),
            'password' => env('MONGO_DB_PASSWORD','root'),
            'options' => [
                'database' => 'admin' // sets the authentication database required by mongo 3
            ]
        ],
      'mysql_apace1' => [
            'driver' => 'mysql',
            //'url' => env('DATABASE_URL'),
            'host' => env('APACE_DB_HOST', '127.0.0.1'),
            'port' => env('APACE_DB_PORT', '3306'),
            'database' => env('APACE_DB_DATABASE', 'sjhostne_apace_live'),
            'username' => env('APACE_DB_USERNAME', 'apace_user'),
            'password' => env('APACE_DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
        'mongodbapace' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_DB_HOST1', 'localhost:81'),
            'port' => env('MONGO_DB_PORT1', 27017),
            'database' => env('MONGO_DB_DATABASE1','apace_temp'),
            'username' => env('MONGO_DB_USERNAME1','root'),
            'password' => env('MONGO_DB_PASSWORD1','root'),
            'options' => [
                'database' => 'admin' // sets the authentication database required by mongo 3
            ]
         ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

       'mysql_apace' => [

            'driver' => 'mysql',
            'host' =>'10.136.194.32',
            'port' => 3306,
            'database' => 'sjhostne_apace_live',
            'username' => 'sjhostne',
            'password' => 'Sjun(TioN@!23$4H',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
