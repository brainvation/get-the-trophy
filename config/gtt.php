<?php

return [
    'auth' => [
        'secrets' => [
            'Telegram' => env('AUTH_TELEGRAM_SECRET', ''),
            'Web' => env('AUTH_WEB_SECRET', ''),
        ],
    ],
];
