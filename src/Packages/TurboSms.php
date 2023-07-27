<?php

namespace Kolirt\Sms\Packages;

use Kolirt\Sms\Helpers\Response;
use Kolirt\Sms\Interfaces\Sms;
use SoapClient;

class TurboSms implements Sms
{

    private $client;
    private $endpoint = 'http://turbosms.in.ua/api/wsdl.html';

    private $login;
    private $password;
    private $sender;

    public function __construct()
    {
        $this->client = new SoapClient($this->endpoint);
        $this->login = config('sms.turbosms.login');
        $this->password = config('sms.turbosms.password');
        $this->sender = config('sms.turbosms.sender');
        $this->login();
    }

    /**
     * Sign in to the service.
     */
    private function login()
    {
        $this->client->Auth([
            'login'    => $this->login,
            'password' => $this->password
        ])->AuthResult;
    }

    public function send($recipient, $text): Response
    {
        if (is_array($recipient)) {
            $recipient = implode(',', $recipient);
        }

        $response = $this->client->SendSMS([
            'sender'      => $this->sender,
            'destination' => $recipient,
            'text'        => $text
        ])->SendSMSResult->ResultArray;

        if (is_string($response)) {
            return (new Response())->setStatus(false)->setMessage($response);
        }

        $message = array_shift($response);

        if (count($response) ?? 0) {
            $result = [];
            $status = true;
            foreach (explode(',', $recipient) as $key => $item) {
                if (preg_match('#^[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}$#', $response[$key])) {
                    $result[$item] = $response[$key];
                } else {
                    $result[$item] = null;
                }
            }
        } else {
            $status = false;
        }

        return (new Response())->setStatus($status)->setMessage($message)->setResult($result ?? null);
    }

    public function status($message_id): Response
    {
        $response = $this->client->GetMessageStatus([
            'MessageId' => $message_id
        ])->GetMessageStatusResult;

        if (in_array($response, [
            'Отправлено'
        ])) {
            return (new Response())->setStatus(true)->setMessage($response);
        } else {
            return (new Response())->setStatus(false)->setMessage($response);
        }
    }

    /**
     * Get a credit balance.
     *
     * @return Response
     */
    public function balance(): Response
    {
        $result = $this->client->GetCreditBalance();
        $response = $result->GetCreditBalanceResult;

        if ($response === 'Вы не авторизированы') {
            return (new Response())->setStatus(false)->setMessage($response);
        }

        return (new Response())->setStatus(true)->setResult((float)$result->GetCreditBalanceResult);
    }

}
