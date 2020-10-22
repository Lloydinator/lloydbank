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

if (!function_exists('balanceCheck')){
    function balanceCheck($customerBalance, $amount, $from, $to){
        if ($customerBalance < $amount){
            return false;
        }
        if ($from == $to){
            return false;
        }
        return true;
    }
}

if (!function_exists('swipeThatCard')){
    function swipeThatCard($balance, $amount, $customer, $payment_id){
        if ($balance < $amount){
            $newAmount = $amount - $balance;
            
            try {
                \Stripe\PaymentIntent::create([
                    'amount' => $newAmount,
                    'currency' => 'usd',
                    'customer' => $customer,
                    'payment_method' => $payment_id,
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

            return $newAmount;
        }
    }
    return $amount;
}
