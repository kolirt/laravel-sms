<?php

return [

    'turbosms' => [
        'login'    => env('SMS_TURBOSMS_LOGIN'),
        'password' => env('SMS_TURBOSMS_PASSWORD'),
        'sender'   => env('SMS_TURBOSMS_SENDER'),
        'package'  => \Kolirt\Sms\Packages\TurboSms::class
    ],

    'sigmasms' => [
        'login'      => env('SMS_TURBOSMS_LOGIN'),
        'password'   => env('SMS_TURBOSMS_PASSWORD'),
        'time_cache' => env('SMS_TURBOSMS_TIME_CACHE', 21600),
        'sender'     => [
            'sms'       => env('SMS_TURBOSMS_SENDER_SMS'),
            'viber'     => env('SMS_TURBOSMS_SENDER_VIBER'),
            'vk'        => env('SMS_TURBOSMS_SENDER_VK'),
            'whats_app' => env('SMS_TURBOSMS_SENDER_WHATS_APP')
        ],
        'package'    => \Kolirt\Sms\Packages\SigmaSms::class
    ],

    'smsc' => [
        'login'    => env('SMS_SMSC_LOGIN'),
        'password' => env('SMS_SMSC_PASSWORD'),
        'sender'   => env('SMS_SMSC_SENDER'),
        'time'     => env('SMS_SMSC_TIME', 0),
        'package'  => \Kolirt\Sms\Packages\Smsc::class
    ],

];
