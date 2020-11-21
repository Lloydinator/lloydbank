<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\TxnStoreRequest;
use App\Traits\NotificationTrait;
use App\Traits\StripeHelpersTrait;
use App\Transaction;
use App\TxnParticipant;
use App\User;

class TransactionController extends Controller
{
	use NotificationTrait;
	use StripeHelpersTrait;

	public function index(){
		$txn = Transaction::where('publictxn', 1)->get();
		return $txn;
	}
	
    public function store(Request $request)
    {
		//$request->validated();

		// Get User ID from Email Address
		$toCustomer = User::with('accounts')
							->where('email', $request->email)
							->get();

		// Get Customer ID from User ID
		$fromCustomer = User::with(['accounts', 'stripecustomer'])
								->where('id', $request->from)
								->get();
		
		// Set variables
		$transaction = new Transaction;
		$txnparticipants = new TxnParticipant;
		$randomString = strtoupper(generateRandomString(2));
		$randomNum = mt_rand(10,99);

		// Final check
		if (!finalCheck($request->from, $toCustomer[0]->id)){
			abort(422, [
				'message' => "Something was wrong with your request. Make sure 
								you're not sending money to yourself."
				]
			);	
		}	

		// Checking to see if card was swiped and assign value to $amount based on that
		$amount = $this->swipeThatCard($fromCustomer[0]->accounts->balance, 
								$request->amount, 
								$fromCustomer[0]->stripecustomer->customer_id) ? 
								$fromCustomer[0]->accounts->balance : 
								$request->amount;
		
		// Binding
		$txnparticipants->from_user_id = $fromCustomer[0]->accounts->id;
		$txnparticipants->to_user_id = $toCustomer[0]->id;
		$txnparticipants->transaction_id = Transaction::count() + 1;
		$transaction->details = "transaction ID: F".$randomNum.$randomString;
		$transaction->amount = $request->amount;
		$transaction->message = $request->message;
		$transaction->publictxn = $request->publictxn;
		
		// Update Records and Send Notifications
		if ($transaction->save()){
			$txnparticipants->save();
			$fromUser = User::find($request->from);
			$toUser = User::find($toCustomer[0]->id);

			$fromUser->accounts->balance = $fromCustomer[0]->accounts->balance - $amount;
			$toUser->accounts->balance = $toCustomer[0]->accounts->balance + $request->amount;
			
			$fromUser->push();
			$toUser->push();

			$text = "Hey ".$toCustomer[0]->name.", ".$fromCustomer[0]->name;
			$text .= " just sent you $".$request->amount.". Check "; 
			$text .= "the LloydBank website for more info.";
			
			$this->textMessage(
				env('TWILIO_PHONE'),
				$toCustomer[0]->accounts->phone,
				$text
			);

			return response()->json([
				'sent' => '$'.$request->amount,
				'balance' => '$'.$fromUser->accounts->balance
			], 201);
		}
		else {
			abort(400, "Something went wrong. You should try again.");
		}
	}

    public function show($id)
    {
		$txn = User::with('accounts')->where('id', $id)->get();
		dd($txn);
		if (isset($txn)){
			return $txn->accounts->transactions;
		}
	}
}