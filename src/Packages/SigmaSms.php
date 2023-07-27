<?php

namespace Kolirt\Sms\Packages;

use Kolirt\Sms\Helpers\Response;
use Kolirt\Sms\Interfaces\Sms;


class SigmaSms implements Sms
{

    private $client;
    private $token;
    private $api = 'https://online.sigmasms.ru/api/';

    private $username;
    private $password;
    private $cache_time;

    public function __construct()
    {
        $this->username = config('sms.sigmasms.login');
        $this->password = config('sms.sigmasms.password');
        $this->cache_time = config('sms.sigmasms.time_cache');

        $this->client = new Client([
            'base_uri' => $this->api,
            'timeout'  => 10
        ]);

        if (!cache()->get('sigmasms')) {
            $this->token = $this->login();
            cache()->set('sigmasms_token', $this->token, $this->cache_time);
        } else {
            $this->token = cache()->get('sigmasms_token');
        }
    }

    /**
     * Send SMS message.
     *
     * @param $recipient
     * @param $text
     * @return Response
     */
    public function send($recipient, $text): Response
    {
        try {
            $response = $this->client->post('sendings', [
                'headers' => [
                    'Authorization' => $this->token
                ],
                'json'    => [
                    'recipient' => $recipient,
                    'type'      => 'sms',
                    'payload'   => [
                        'sender' => config('sms.sigmasms.sender.sms'),
                        'text'   => $text
                    ]
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                return (new Response)->setStatus(true)->setResult($response->getBody()->getContents());
            } else {
                return (new Response)->setStatus(false);
            }
        } catch (\Exception $e) {
            return (new Response)->setStatus(false);
        }
    }

    /**
     * Send Viber message.
     *
     * @param $recipient
     * @param $text
     * @param $image
     * @param $button_text
     * @param $button_url
     * @return Response
     */
    public function sendViber($recipient, $text, $image = null, $button_text = null, $button_url = null): Response
    {
        try {
            $response = $this->client->post('sendings', [
                'headers' => [
                    'Authorization' => $this->token
                ],
                'json'    => [
                    'recipient' => $recipient,
                    'type'      => 'vk',
                    'payload'   => [
                        'sender' => config('sms.sigmasms.sender.viber'),
                        'text'   => $text,
                        'image'  => $image,
                        'button' => [
                            'text' => $button_text,
                            'url'  => $button_url
                        ]
                    ]
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return (new Response())->setStatus(true)->setResult($response->getBody()->getContents());
            } else {
                return (new Response)->setStatus(false);
            }
        } catch (\Exception $e) {
            return (new Response)->setStatus(false);
        }
    }

    /**
     * Send WhatsApp message.
     *
     * @param $recipient
     * @param $text
     * @param null $image
     * @return mixed|null
     */
    public function sendWhatsApp($recipient, $text, $image = null): Response
    {
        try {
            $response = $this->client->post('sendings', [
                'headers' => [
                    'Authorization' => $this->token
                ],
                'json'    => [
                    'recipient' => $recipient,
                    'type'      => 'whatsapp',
                    'payload'   => [
                        'sender' => config('sms.sigmasms.sender.whats_app'),
                        'text'   => $text,
                        'image'  => $image
                    ]
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return (new Response())->setStatus(true)->setResult(json_decode($response->getBody()->getContents()));
            } else {
                return (new Response)->setStatus(false);
            }
        } catch (\Exception $e) {
            return (new Response)->setStatus(false);
        }
    }

    /**
     * Send VK message.
     *
     * @param $recipient
     * @param $text
     * @return Response
     */
    public function sendVk($recipient, $text): Response
    {
        try {
            $response = $this->client->post('sendings', [
                'headers' => [
                    'Authorization' => $this->token
                ],
                'json'    => [
                    'recipient' => $recipient,
                    'type'      => 'vk',
                    'payload'   => [
                        'sender' => config('sms.sigmasms.sender.vk'),
                        'text'   => $text
                    ]
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return (new Response())->setStatus(true)->setResult(json_decode($response->getBody()->getContents()));
            } else {
                return (new Response)->setStatus(false);
            }
        } catch (\Exception $e) {
            return (new Response)->setStatus(false);
        }
    }

    public function status($message_id): Response
    {
        try {
            $response = $this->client->get('sendings/' . $message_id, [
                'headers' => [
                    'Authorization' => $this->token
                ],
                'json'    => [],
            ]);

            if ($response->getStatusCode() === 200) {
                return (new Response())->setStatus(true)->setResult(json_decode($response->getBody()->getContents()));
            } else {
                return (new Response)->setStatus(false);
            }
        } catch (\Exception $e) {
            return (new Response)->setStatus(false);
        }
    }

    private function login()
    {
        try {
            $response = $this->client->post('login', [
                'json' => [
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents());
                return $data->token;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

}
