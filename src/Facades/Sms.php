<?php

namespace Kolirt\Sms\Facades;

use \Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method static Kolirt\Sms\Sms driver($driver)
 */
class Sms extends BaseFacade
{

    protected static function getFacadeAccessor()
    {
        return 'sms';
    }

}