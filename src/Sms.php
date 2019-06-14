<?php

namespace Kolirt\Sms;

use Kolirt\Sms\Helpers\Response;

class Sms
{

    private $driver;

    /**
     * @param $driver
     * @return Sms
     * @throws \Exception
     */
    public function driver($driver)
    {
        if (!in_array($driver, array_keys(config('sms')))) {
            throw new \Exception('Driver not found. Available drivers: ' . implode(', ', array_keys(config('sms'))));
        }

        $driver = config('sms.' . $driver . '.package');
        $this->driver = new $driver;

        return $this;
    }

    /**
     * @param $recipient
     * @param $text
     * @return Response
     */
    public function send($recipient, $text): Response
    {
        return $this->driver->send($recipient, $text);
    }

    /**
     * @param $message_id
     * @return Response
     */
    public function status($message_id): Response
    {
        return $this->driver->status($message_id);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->driver, $name)) {
            /**
             * @var Response
             */
            return $this->driver->$name(...$arguments);
        }
    }

}