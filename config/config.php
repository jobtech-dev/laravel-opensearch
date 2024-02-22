<?php

return [
    'client' => [
        'hosts' => [
            'host' => env('OPENSEARCH_HOST', 'opensearch:9200'),
        ],
        'basicAuthentication' => [env('OPENSEARCH_USER', 'opensearch'), env('OPENSEARCH_SECRET')],
    ],

    'indices' => [
        // put list of index of opensearch microservices
    ],

    'queue' => [
        'connection' => env('OPENSEARCH_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync')),
        'queue' => env('OPENSEARCH_QUEUE', env('QUEUE_DEFAULT')),
    ],

    'prefix' => env('OPENSEARCH_PREFIX'),
];
