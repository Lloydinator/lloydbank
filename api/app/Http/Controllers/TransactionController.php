<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\TxnStoreRequest;
use App\Transaction;
use App\User;

class TransactionController extends Controller
{
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
		$amount = swipeThatCard($fromCustomer[0]->accounts->balance, 
								$request->amount, 
								$fromCustomer[0]->stripecustomer->customer_id) ? 
								$fromCustomer[0]->accounts->balance : 
								$request->amount;

		// Binding
		$transaction->from = $fromCustomer[0]->accounts->id;
		$transaction->to = $toCustomer[0]->id;
		$transaction->details = "transaction ID: F".$randomNum.$randomString;
		$transaction->amount = $request->amount;
		$transaction->message = $request->message;
		$transaction->publictxn = $request->publictxn;
		
		// Database
		if ($transaction->save()){
			$fromUser = User::find($request->from);
			$toUser = User::find($toCustomer[0]->id);

			$fromUser->accounts->balance = $fromCustomer[0]->accounts->balance - $amount;
			$toUser->accounts->balance = $toCustomer[0]->accounts->balance + $request->amount;
			
			$fromUser->push();
			$toUser->push();
			
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
		$txn = User::find($id);
		if (isset($txn)){
			return $txn->accounts->transactions;
		}
	}
}