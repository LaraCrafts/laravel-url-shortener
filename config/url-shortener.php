<?php

return [

    'default' => env('URL_SHORTENER_DRIVER', 'tiny_url'),

    'shorteners' => [

        'bit_ly' => [
            'driver' => 'bit_ly',
            'domain' => env('URL_SHORTENER_PREFIX', 'bit.ly'),
            'token' => env('URL_SHORTENER_API_TOKEN'),
        ],

        'firebase' => [
            'driver' => 'firebase',
            'prefix' => env('URL_SHORTENER_PREFIX'),
            'token' => env('URL_SHORTENER_API_TOKEN'),
            'suffix' => env('URL_SHORTENER_STRATEGY', 'UNGUESSABLE'),
        ],

        'is_gd' => [
            'driver' => 'is_gd',
            'base_uri' => 'https://is.gd',
            'statistics' => env('URL_SHORTENER_ANALYTICS', false),
        ],

        'ouo_io' => [
            'driver' => 'ouo_io',
            'token' => env('URL_SHORTENER_API_TOKEN'),
        ],

        'polr' => [
            'driver' => 'polr',
            'prefix' => env('URL_SHORTENER_PREFIX'),
            'token' => env('URL_SHORTENER_API_TOKEN'),
        ],

        'shorte_st' => [
            'driver' => 'shorte_st',
            'token' => env('URL_SHORTENER_API_TOKEN'),
        ],

        'tiny_url' => [
            'driver' => 'tiny_url',
        ],

        'v_gd' => [
            'driver' => 'is_gd',
            'base_uri' => 'https://v.gd',
            'statistics' => env('URL_SHORTENER_ANALYTICS', false),
        ],
    ],
];
