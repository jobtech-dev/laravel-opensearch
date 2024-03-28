<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Client config
    |--------------------------------------------------------------------------
    |
    | This is where client configurations are set up
    |
    */
    'client' => [
        'hosts' => [
            'host' => env('OPENSEARCH_HOST'),
        ],
        'basicAuthentication' => [env('OPENSEARCH_USER'), env('OPENSEARCH_SECRET')],
    ],

    /*
    |--------------------------------------------------------------------------
    | Indices config
    |--------------------------------------------------------------------------
    |
    | Put OpenSearch indices here
    |
    */
    'indices' => [],

    /*
    |--------------------------------------------------------------------------
    | Indices prefix
    |--------------------------------------------------------------------------
    |
    | Enter the OpenSearch prefix if you want indexes to have a specific prefix
    |
    */
    'prefix' => env('OPENSEARCH_PREFIX'),
];
