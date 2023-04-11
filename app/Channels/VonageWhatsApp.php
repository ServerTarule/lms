<?php

namespace App\Channels;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Exception\Request;

class VonageWhatsApp
{
    private $basic;
    private $client;

    public function __construct()
    {
        $this->basic = new Basic(env('NEXMO_API_KEY'), env('NEXMO_API_SECRET'));
        $this->client = new Client($this->basic);
    }

    public function sendMessage($to, $text)
    {
        try {
            $response = $this->client->messages()->send([
                'to' => $to,
                'from' => 'whatsapp:' . env('VONAGE_WHATSAPP_FROM'),
                'text' => $text,
            ]);
            return $response->getResponseData();
        } catch (Request $e) {
            throw new \Exception($e->getMessage());
        }
    }}
