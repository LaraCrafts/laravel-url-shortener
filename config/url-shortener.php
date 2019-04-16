<?php

return [

    'default' => env('URL_SHORTENER_DRIVER', 'tiny_url'),

    'drivers' => [

        'bit_ly' => [
            'domain' => env('BIT_LY_DOMAIN', 'bit.ly'),
            'token' => env('BIT_LY_API_TOKEN'),
        ],

        'shorte_st' => [
            'token' => env('SHORTE_ST_API_TOKEN'),
        ],

        'tiny_url' => [
            //
        ],
    ],
];
