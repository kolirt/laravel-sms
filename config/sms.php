<?php

return [

    'turbosms' => [
        'login' => env('SMS_TURBOSMS_LOGIN'),
        'password' => env('SMS_TURBOSMS_PASSWORD'),
        'sender' => env('SMS_TURBOSMS_SENDER'),
        'package' => \Kolirt\Sms\Packages\TurboSms::class
    ],

    'sigmasms' => [
        'login' => env('SMS_TURBOSMS_LOGIN'),
        'password' => env('SMS_TURBOSMS_PASSWORD'),
        'time_cache' => 21600,
        'sender' => [
            'sms' => env('SMS_TURBOSMS_SENDER_SMS'),
            'viber' => env('SMS_TURBOSMS_SENDER_VIBER'),
            'vk' => env('SMS_TURBOSMS_SENDER_VK'),
            'whats_app' => env('SMS_TURBOSMS_SENDER_WHATS_APP')
        ],
        'package' => \Kolirt\Sms\Packages\SigmaSms::class
    ],

];
