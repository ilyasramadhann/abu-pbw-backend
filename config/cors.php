<?php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173','https://frontend-web-bps-zidan.vercel.app'
    ],

    'allowed_origins_patterns' => ['https://frontend-web-bps-zidan.vercel.app'],
    'allowed_headers' => ['*'],

    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];