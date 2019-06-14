<?php

return [

    'turbosms' => [
        'login' => env('SMS_TURBOSMS_LOGIN'),
        'password' => env('SMS_TURBOSMS_PASSWORD'),
        'sender' => env('SMS_TURBOSMS_SENDER'),
        'package' => \Kolirt\Sms\Packages\TurboSms::class
    ],

];
