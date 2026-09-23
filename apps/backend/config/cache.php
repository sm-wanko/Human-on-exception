<?php

return [
    'default' => env('CACHE_STORE', 'array'),
    'stores' => [
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
    ],
    'prefix' => env('CACHE_PREFIX', 'human_on_exception_cache'),
];
