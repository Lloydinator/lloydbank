<?php

namespace App\Services;

use Twilio\Rest\Client;

class Twilio {
    protected $sid;
    protected $token;
    protected $twilio_number;
    protected $client;

    public function __construct(){
        $this->sid = getenv('TWILIO_SID');
        $this->token = getenv('TWILIO_AUTH');
        $this->twilio_number = getenv('TWILIO_PHONE');

        $this->client = $this->setUp();
    }

    private function setUp(){
        $client = new Client($this->sid, $this->token);
        return $client;
    }

    public function send($number, $message){
        $sms = $this->client->messages->create($number, [
            'from' => $this->twilio_number,
            'body' => $message
        ]);

        return $sms;
    }
}