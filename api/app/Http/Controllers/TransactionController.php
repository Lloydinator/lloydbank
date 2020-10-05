<?php

namespace App\Http\Controllers;

use App\Http\Requests\TxnStoreRequest;
use App\Transaction;
use App\Account;

class TransactionController extends Controller
{
	public function index(){
		$txn = Transaction::where('publictxn', 1)->get();
		return $txn;
	}
	
    public function store(TxnStoreRequest $request)
    {
		$request->validated();

		$transaction = new Transaction;
		$randomString = strtoupper(genRandStr(2));
		$randomNum = mt_rand(10,99);
		$amount = $request->amount;
		$newBalance = Account::find($request->from);
		$newBalanceTo = Account::find($request->to);

		if ($request->from == $request->to)
			return abort(400, "You can't send money to yourself.");
		if ($amount > $newBalance['balance'] || $newBalance['balance'] <= 0) 
			return abort(400, "Your balance isn't high enough.");
		
		$transaction->from = $request->from;
		$transaction->to = $request->to;
		$transaction->details = "transaction ID: F".$randomNum.$randomString;
		$transaction->amount = $amount;
		$transaction->message = $request->message;
		$transaction->publictxn = $request->publictxn;
		
		if ($transaction->save()){
			$newBalance->balance = $newBalance['balance'] - $amount;
			$newBalanceTo->balance = $newBalanceTo['balance'] + $amount;
			$newBalance->save();
			$newBalanceTo->save();
			
			return response()->json([
				'message' => 'You just sent $'.$amount.'. Balance: $'.$newBalance->balance
			], 201);
		}
		else {
			return abort(400, "Something went wrong, You should try again.");
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