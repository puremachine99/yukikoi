<?php

return [
    'url'             => env('IMGPROXY_URL', 'http://localhost:8090'),
    'source_url_base' => env('IMGPROXY_SOURCE_URL_BASE', 'http://minio:9000'),
    'key'             => env('IMGPROXY_KEY'),
    'salt'            => env('IMGPROXY_SALT'),
    'should_sign'     => filter_var(env('IMGPROXY_SIGN_URLS', true), FILTER_VALIDATE_BOOL),
    'allow_insecure'  => filter_var(env('IMGPROXY_ALLOW_INSECURE_URLS', false), FILTER_VALIDATE_BOOL),

    'default_options' => [
        'resize'  => ['fit', 600, 600, 1],
        'quality' => 85,
        'format'  => 'webp',
    ],
];
