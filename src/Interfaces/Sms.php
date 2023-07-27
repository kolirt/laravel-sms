<?php

namespace Kolirt\Sms\Interfaces;

use Kolirt\Sms\Helpers\Response;

interface Sms
{

    public function send($recipient, $text): Response;

    public function status($message_id): Response;

}