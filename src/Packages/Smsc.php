<?php

namespace Kolirt\Sms\Packages;

use Kolirt\Sms\Helpers\Response;
use Kolirt\Sms\Interfaces\Sms;
use SoapClient;

class Smsc
{

    private $client;
    private $endpoint = 'https://smsc.ru/sys/soap.php?wsdl';

    private $login;
    private $password;
    private $sender;
    private $time;

    public function __construct()
    {
        $this->client = new SoapClient($this->endpoint);
        $this->login = config('sms.smsc.login');
        $this->password = config('sms.smsc.password');
        $this->sender = config('sms.smsc.sender');
        $this->time = config('sms.smsc.time');
    }

    public function send($recipient, $text): Response
    {
        if (is_array($recipient)) {
            $recipient = implode(',', $recipient);
        }

        if (is_array($text)) {
            $text = implode('. ', $text);
        }

        $response = $this->client->send_sms([
            'login'  => $this->login,
            'psw'    => $this->password,
            'phones' => $recipient,
            'mes'    => $text,
            'sender' => $this->sender,
            'time'   => $this->time
        ])->sendresult;

        if (!isset($response->error)) {
            $result = [];
            $status = true;
            foreach (explode(',', $recipient) as $key => $item) {
                $result[$item] = $response->id;
            }
        } else {
            switch ($response->error) {
                case 1:
                    $message = 'Ошибка в параметрах.';
                    break;
                case 2:
                    $message = 'Неверный логин или пароль.';
                    break;
                case 3:
                    $message = 'Недостаточно средств на счету Клиента.';
                    break;
                case 4:
                    $message = 'IP-адрес временно заблокирован из-за частых ошибок в запросах.';
                    break;
                case 5:
                    $message = 'Неверный формат даты.';
                    break;
                case 6:
                    $message = 'Сообщение запрещено (по тексту или по имени отправителя).';
                    break;
                case 7:
                    $message = 'Неверный формат номера телефона.';
                    break;
                case 8:
                    $message = 'Сообщение на указанный номер не может быть доставлено.';
                    break;
                case 9:
                    $message = 'Отправка более одного одинакового запроса на передачу SMS-сообщения в течение минуты.';
                    break;
            }
            $status = false;
        }

        return (new Response())->setStatus($status)->setMessage($message ?? null)->setResult($result ?? null);
    }

    public function status($recipient, $message_id): Response
    {
        $response = $this->client->get_status([
            'login' => $this->login,
            'psw'   => $this->password,
            'phone' => $recipient,
            'id'    => $message_id,
            'all'   => '0'
        ])->statusresult;

        if ($response->error == 0) {
            if (in_array($response->status, [1, 2])) {
                switch ($response->status) {
                    case 1:
                        $message = 'Доставлено';
                        break;
                    case 2:
                        $message = 'Прочитано';
                        break;
                }

                return (new Response())->setStatus(true)->setMessage($message ?? null);
            } else {
                switch ($response->status) {
                    case -3:
                        $message = 'Сообщение не найдено';
                        break;
                    case -2:
                        $message = 'Остановлено';
                        break;
                    case -1:
                        $message = 'Ожидает отправки';
                        break;
                    case 0:
                        $message = 'Передано оператору';
                        break;
                    case 1:
                        $message = 'Доставлено';
                        break;
                    case 2:
                        $message = 'Прочитано';
                        break;
                    case 3:
                        $message = 'Просрочено';
                        break;
                    case 4:
                        $message = 'Нажата ссылка';
                        break;
                    case 20:
                        $message = 'Невозможно доставить';
                        break;
                    case 22:
                        $message = 'Неверный номер';
                        break;
                    case 23:
                        $message = 'Запрещено';
                        break;
                    case 24:
                        $message = 'Недостаточно средств';
                        break;
                    case 25:
                        $message = 'Недоступный номер';
                        break;
                }

                return (new Response())->setStatus(false)->setMessage($message ?? null);
            }
        } else {
            switch ($result->error) {
                case 1:
                    $message = 'Ошибка в параметрах.';
                    break;
                case 2:
                    $message = 'Неверный логин или пароль.';
                    break;
                case 3:
                    $message = 'Сообщение не найдено.';
                    break;
                case 4:
                    $message = 'IP-адрес временно заблокирован.';
                    break;
                case 9:
                    $message = 'Попытка отправки более пяти запросов на получение статуса одного и того же сообщения в течение минуты.';
                    break;
            }

            return (new Response())->setStatus(false)->setMessage($message ?? null);
        }

        /*if (in_array($response, [
            'Отправлено'
        ])) {
            return (new Response())->setStatus(true)->setMessage($response);
        } else {
            return (new Response())->setStatus(false)->setMessage($response);
        }*/
    }

    public function balance(): Response
    {
        $result = $this->client->get_balance([
            'login' => $this->login,
            'psw'   => $this->password
        ])->balanceresult;

        if ($result->error == 0) {
            return (new Response())->setStatus(true)->setResult((float)$result->balance);
        } else {
            switch ($result->error) {
                case 1:
                    $message = 'Ошибка в параметрах.';
                    break;
                case 2:
                    $message = 'Неверный логин или пароль.';
                    break;
                case 4:
                    $message = 'IP-адрес временно заблокирован.';
                    break;
                case 9:
                    $message = 'Попытка отправки более десяти запросов на получение баланса в течение минуты.';
                    break;
            }

            return (new Response())->setStatus(false)->setMessage($message ?? null);
        }

    }

}
