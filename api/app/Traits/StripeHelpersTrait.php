<?php

namespace App\Traits;

trait StripeHelpersTrait {
    function swipeThatCard($balance, $amount, $customer_id){
        if ($balance < $amount){
            $newAmount = $amount - $balance;

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

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
                return response()->json([
                    'message' => 'Error. '.$e->getMessage()
                ], $e->getCode() ? $e->getCode() : 500);
            }

            return true;
        }
        return false;
    }
}