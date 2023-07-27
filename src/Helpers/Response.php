<?php

namespace Kolirt\Sms\Helpers;

class Response
{

    public $status = false;
    public $message;
    public $result;

    /**
     * @param mixed $result
     * @return Response
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @param mixed $message
     * @return Response
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param mixed $status
     * @return Response
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

}