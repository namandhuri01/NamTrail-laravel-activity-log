<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Activity Log Table Name
    |--------------------------------------------------------------------------
    |
    | You can customize the table name used for storing activity logs.
    | This is useful when you want to use a different table name than the default.
    |
    */
    'table_name' => env('ACTIVITY_LOG_TABLE_NAME', 'activity_logs'),

    /*
    |--------------------------------------------------------------------------
    | Default Log Name
    |--------------------------------------------------------------------------
    |
    | This is the default log name that will be used when none is specified.
    |
    */
    'default_log_name' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Default Causer Type
    |--------------------------------------------------------------------------
    |
    | This is the default causer type that will be used when none is provided.
    |
    */
    'default_causer_type' => '\App\Models\User',
];