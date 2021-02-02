<?php

namespace App\Traits;

trait StripeHelpersTrait {
    public function swipeThatCard($balance, $amount, $customer_id){
        if ($balance < $amount){
            $this->getApiKey();

            $newAmount = $amount - $balance;

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
                ], 400);
            }

            return true;
        }
        return false;
    }

    public function createSetupIntent($customer_id){
        $this->getApiKey();

        $intent = \Stripe\SetupIntent::create([
            'customer' => $customer_id,
        ]);
        return response()->json([
            'message' => 'Setting up your card.', 
            'intent' => $intent->client_secret,
        ]);
    }

    public function getPaymentMethod($customer_id){
        $this->getApiKey();

        $payment_method = \Stripe\PaymentMethod::all([
                            'customer' => $customer_id,
                            'type' => 'card',
                        ]);
        return $payment_method;
    }

    public function createCustomer($email){
        $this->getApiKey();

        $customer = \Stripe\Customer::create([
            'email' => $email
        ]);
        return $customer;
    }

    private function getApiKey(){
        $sk = getenv('STRIPE_SECRET');
        \Stripe\Stripe::setApiKey($sk);
    }
}