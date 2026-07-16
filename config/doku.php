<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DOKU SNAP API Configuration
    |--------------------------------------------------------------------------
    |
    | Credentials for DOKU payment gateway integration.
    | These values are used as fallback when no PaymentMethodConfig record
    | is found in the database.
    |
    */

    'client_id' => env('DOKU_CLIENT_ID', ''),

    'secret_key' => env('DOKU_SECRET_KEY', ''),

    'private_key' => env('DOKU_PRIVATE_KEY', ''),

    'is_production' => env('DOKU_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Virtual Account Channels
    |--------------------------------------------------------------------------
    |
    | Available VA channels that can be offered to the customer.
    | channel_code is the DOKU channel identifier.
    | label is displayed in the checkout UI.
    |
    */

    'va_channels' => [
        [
            'code' => 'VIRTUAL_ACCOUNT_BANK_CIMB',
            'label' => 'CIMB Niaga Virtual Account',
            'short' => 'CIMB',
        ],
        [
            'code' => 'VIRTUAL_ACCOUNT_BANK_MANDIRI',
            'label' => 'Mandiri Virtual Account',
            'short' => 'Mandiri',
        ],
        [
            'code' => 'VIRTUAL_ACCOUNT_BANK_BRI',
            'label' => 'BRI Virtual Account',
            'short' => 'BRI',
        ],
        [
            'code' => 'VIRTUAL_ACCOUNT_BANK_DANAMON',
            'label' => 'Danamon Virtual Account',
            'short' => 'Danamon',
        ],
        [
            'code' => 'VIRTUAL_ACCOUNT_BANK_BNC',
            'label' => 'Neo Commerce Virtual Account',
            'short' => 'Neo Commerce',
        ],
        [
            'code' => 'VIRTUAL_ACCOUNT_BANK_BJB',
            'label' => 'BJB Virtual Account',
            'short' => 'BJB',
        ],
    ],
];
