<?php

namespace App\Listeners;

use App\Events\TransactionMade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Twilio;

class ReceivedMoneyNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TransactionMade  $event
     * @return void
     */
    public function handle(TransactionMade $event)
    {
        $user_from = name_explode($event->transaction->user_from->name);
        $user_to = name_explode($event->user->name);
        $phone = $event->transaction->user_from->account->phone;
        $amount = $event->transaction->amount; 
        $message = "Hey {$user_to[0]}, {$user_from[0]} just sent you ${$amount}. "; 
        $message .= "Check the LloydBank website for more info.";

        $twilio = new Twilio;
        $twilio->send($phone, $message);
    }
}