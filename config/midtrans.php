<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

    'pricing' => [
        'silver' => 49000,
        'gold' => 99000,
        'platinum' => 299000,
    ],

    'duration_days' => [
        'silver' => 90,
        'gold' => 90,
        'platinum' => 90,
    ],
];
