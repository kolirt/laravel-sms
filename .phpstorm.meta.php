<?php
// @formatter:off

namespace PHPSTORM_META {

    override(\Kolirt\Sms\Facades\Sms::driver(0), map([
        'turbosms' => \Kolirt\Sms\Packages\TurboSms::class,
        'sigmasms' => \Kolirt\Sms\Packages\SigmaSms::class,
        'smsc'     => \Kolirt\Sms\Packages\Smsc::class
    ]));

}
