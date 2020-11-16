<?php

namespace App\Traits;
use Twilio\Rest\Client;

trait NotificationTrait {
    public function textMessage($phoneFrom, $phoneTo, $message){
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH');
        $client = new Client($sid, $token);
        
        $client->messages->create(
            $phoneTo, [
                'from' => $phoneFrom,
                'body' => $message
            ]
        );
    }
}