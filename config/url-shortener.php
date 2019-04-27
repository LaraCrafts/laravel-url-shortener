<?php

return [

    'default' => env('URL_SHORTENER_DRIVER', 'tiny_url'),

    'drivers' => [

        'bit_ly' => [
            'domain' => env('BIT_LY_DOMAIN', 'bit.ly'),
            'token' => env('BIT_LY_API_TOKEN'),
        ],

        'firebase' => [
            'prefix' => env('FIREBASE_URI_PREFIX'),
            'token' => env('FIREBASE_API_TOKEN'),
            'suffix' => env('FIREBASE_SUFFIX', 'UNGUESSABLE'),
        ],

        'is_gd' => [
            'link_previews' => env('IS_GD_LINK_PREVIEWS', false),
            'statistics' => env('IS_GD_STATISTICS', false),
        ],

        'ouo_io' => [
            'token' => env('OUO_IO_API_TOKEN'),
        ],

        'shorte_st' => [
            'token' => env('SHORTE_ST_API_TOKEN'),
        ],

        'tiny_url' => [
            //
        ],
    ],
];
