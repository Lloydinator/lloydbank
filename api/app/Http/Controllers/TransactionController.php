<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\TxnStoreRequest;
use App\Transaction;
use App\Account;
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
		$to = User::firstWhere('email', $request->email);

		// Set variables
		$transaction = new Transaction;
		$randomString = strtoupper(generateRandomString(2));
		$randomNum = mt_rand(10,99);
		$newBalance = Account::firstWhere('userid', $request->from);
		$newBalanceTo = Account::firstWhere('userid', $to->id);

		// Checking to see if card was swiped and assign value to $amount based on that
		$amount = swipeThatCard($newBalance->balance, $request->amount, $request->customer) ? 
					$newBalance->balance : $request->amount;
		/*
		// Final checks
		if (!balanceCheck($newBalance->balance, $amount, $request->from, $to->id)){
			abort(422, [
				'message' => "Something was wrong with your request. Make sure you're
								not sending money to yourself or sending more 
								than you have"
				]
			);	
		}	
		*/
		
		// Binding
		$transaction->from = $request->from;
		$transaction->to = $to->id;
		$transaction->details = "transaction ID: F".$randomNum.$randomString;
		$transaction->amount = $amount;
		$transaction->message = $request->message;
		$transaction->publictxn = $request->publictxn;
		
		// Database
		if ($transaction->save()){
			$newBalance->balance = $newBalance['balance'] - $amount;
			$newBalanceTo->balance = $newBalanceTo['balance'] + $amount;
			$newBalance->save();
			$newBalanceTo->save();
			
			return response()->json([
				'message' => 'You just sent $'.$request->amount.'. Balance: $'.$newBalance->balance
			], 201);
		}
		else {
			abort(400, "Something went wrong. You should try again.");
		}
	}

    public function show($id)
    {
		$txn = Account::find($id);
		if (isset($txn)){
			return $txn->transactions()->where('from', $id)->get()->toJson(JSON_PRETTY_PRINT);
		}
	}
}