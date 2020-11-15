<?php

if (!function_exists('generateRandomString')){
    function generateRandomString($length = 0){
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        $charLength = strlen($chars);
        $randStr = '';
        $i = 0;

        while ($i < $length) {
            $randStr .= $chars[mt_rand(0, $charLength - 1)];
            $i++;
        }

        return $randStr;
    }
}

if (!function_exists('finalCheck')){
    function finalCheck($from, $to){
        if ($from == $to){
            return false;
        }
        return true;
    }
}

if (!function_exists('swipeThatCard')){
    function swipeThatCard($balance, $amount, $customer_id){
        if ($balance < $amount){
            $newAmount = $amount - $balance;

            \Stripe\Stripe::setApiKey('sk_test_WOvPHpplMVyTJV2UJsIrPl27');

            $card = \Stripe\PaymentMethod::all([
                            'customer' => $customer_id,
                            'type' => 'card',
                            ]);
            try {
                \Stripe\PaymentIntent::create([
                    'amount' => $newAmount * 100,
                    'currency' => 'usd',
                    'customer' => $customer_id,
                    'payment_method' => $card->data[0]->id,
                    'off_session' => true,
                    'confirm' => true,
                ]);
            } 
            catch (\Stripe\Exception\CardException $e){
                $payment_intent_id = $e->getError()->code;
                $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                return response()->json([
                    'message' => 'Error code is'.$e->getError()->code,
                    'payment_intent' => $payment_intent
                ]);
            }

            return true;
        }
        return false;
    }
}
